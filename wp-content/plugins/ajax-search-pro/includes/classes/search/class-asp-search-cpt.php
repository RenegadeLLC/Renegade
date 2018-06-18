<?php
/* Prevent direct access */
defined( 'ABSPATH' ) or die( "You can't access this file directly." );

if ( ! class_exists( 'ASP_Search_CPT' ) ) {
    /**
     * Content (post,page,CPT) search class
     *
     * @class       ASP_Search_CPT
     * @version     2.0
     * @package     AjaxSearchPro/Classes/Search
     * @category    Class
     * @author      Ernest Marcinko
     */
    class ASP_Search_CPT extends ASP_Search {

        /**
         * @var array of query parts
         */
        protected $parts = array();
        /**
         * @var array of custom field query parts
         */
        protected $cf_parts = array();
        /**
         * @var string the final search query
         */
        protected $query;

        protected $ordering = array(
            "primary"   => "relevance DESC",
            "secondary" => "post_date DESC",
            "primary_field" => "relevance"
        );

        /**
         * Gets the related taxonomy term count based on input post IDs and taxonomies and terms
         *
         * @param (int|object)[] $ids Array of post IDs or Array of Objects with post IDs
         * @param ['taxonomy' => int[] terms] $taxonomies
         * @param int $max_packet_size Maximum number of IDs per query
         * @param int $max_call_count  Maximum number if queries overall
         * @return int[] associative array of term_id => object_count
         */
        public function get_relevant_tax_terms($post_ids, $taxonomy_terms, $max_packet_size = 1000, $max_call_count = 2 ) {
            $_ids = array();
            $results = array();

            if ( count($post_ids) <= 0 ) return $results;

            // Is this an object array?
            if ( isset($post_ids[0]->id) ) {
                foreach ($post_ids as $o)
                    $_ids[] = $o->id;
            } else {
                $_ids = $post_ids;
            }
            for ($i=0;$i<$max_call_count;$i++) {
                $pack = array_splice($_ids, $max_packet_size);

                // SELECT id FROM xxx WHERE post in $pack AND tax in ($taxonomies)
                // $results = array_merge($results ...)

                if ( count($_ids) <= 0 ) break;
            }

            return array_unique($results);
        }

        /**
         * Content search function
         *
         * @return array|string
         */
        protected function do_search() {
            global $wpdb;
            global $q_config;

            $args = &$this->args;

            $aspdb = wd_asp()->tables;
            if ( isset($args["_sd"]) )
                $sd = &$args["_sd"];
            else
                $sd = array();

            // General variables
            $postmeta_join   = "";

            // Prefixes and suffixes
            $pre_field = $this->pre_field;
            $suf_field = $this->suf_field;
            $pre_like  = $this->pre_like;
            $suf_like  = $this->suf_like;

            $wcl = '%'; // Wildcard Left
            $wcr = '%'; // Wildcard right
            if ( $args["_exact_matches"] == 1 ) {
                if ( $args['_exact_match_location'] == 'start' )
                    $wcl = '';
                else if ( $args['_exact_match_location'] == 'end' )
                    $wcr = '';
            }

            $kw_logic             = $args['keyword_logic'];
            $q_config['language'] = $args['_qtranslate_lang'];

            $s  = $this->s; // full keyword
            $_s = $this->_s; // array of keywords

            if ( $args['_limit'] > 0 ) {
                $this->remaining_limit = $args['_limit'];
            } else {
                if ( $args['_ajax_search'] )
                    $this->remaining_limit = $args['posts_limit'];
                else
                    $this->remaining_limit = $args['posts_limit_override'];
            }
            $query_limit = $this->remaining_limit * $this->remaining_limit_mod;

            if ($this->remaining_limit <= 0)
                return array();

            $group_priority_select = $this->build_pgp_query( $wpdb->posts.".ID" );
            $group_priority_select = $group_priority_select . " AS group_priority,";
            $group_priority_orderby = "group_priority DESC, ";

            /**
             * Determine if the priorities table should be used or not.
             */
            $priority_select = WD_ASP_Priorities::count() > 0 ? "
	        IFNULL((
            	SELECT
	            aspp.priority
	            FROM $aspdb->priorities as aspp
	            WHERE aspp.post_id = $wpdb->posts.ID AND aspp.blog_id = " . get_current_blog_id() . "
            ), 100)
	        " : 100;


            /*------------------------- Statuses ----------------------------*/
            $post_statuses = "";
            $allowed_statuses = "'publish'"; // used later!
            if ( count($args['post_status']) > 0) {
                $allowed_statuses = "'".implode( "','", $args['post_status'] )."'";
                $post_statuses = "AND (" . $pre_field . $wpdb->posts . ".post_status" . $suf_field . " IN ($allowed_statuses) )";
            }
            /*---------------------------------------------------------------*/

            /*----------------------- Gather Types --------------------------*/
            $page_q = "";
            if ( $args['_exclude_page_parent_child'] != '' )
                $page_q = " AND (
                    $wpdb->posts.post_parent NOT IN (" . str_replace( '|', ',', $args['_exclude_page_parent_child'] ) . ") AND
                    $wpdb->posts.ID NOT IN (" . str_replace( '|', ',', $args['_exclude_page_parent_child'] ) . ")
                )";

            // If no post types selected, well then return
            if ( count( $args['post_type'] ) < 1 && $page_q == "" ) {
                return '';
            } else {
                $words = implode( "','", $args['post_type'] );
                if ( in_array('product_variation', $args['post_type']) && class_exists('WooCommerce') ) {
                    $_post_types = $args['post_type'];
                    $_post_types = array_diff($_post_types, array('product_variation'));
                    if (count($_post_types) > 0)
                        $or_ptypes = "OR $wpdb->posts.post_type IN ('".implode("', '", $_post_types)."')";
                    else
                        $or_ptypes = '';
                    $post_types = "
                    ((
                        (
                            $wpdb->posts.post_type = 'product_variation' AND 
                            EXISTS(SELECT 1 FROM $wpdb->posts par WHERE par.ID = $wpdb->posts.post_parent AND par.post_status IN($allowed_statuses) ) 
                        )  $or_ptypes
                    ) $page_q)";
                } else {
                    $post_types = "($wpdb->posts.post_type IN ('$words') $page_q)";
                }
            }
            /*---------------------------------------------------------------*/

            // ------------------------ Categories/tags/taxonomies ----------------------
            $term_query = $this->build_term_query( $wpdb->posts.".ID", $wpdb->posts.'.post_type' );
            // ---------------------------------------------------------------------

            /*------------- Custom Fields with Custom selectors -------------*/
            $cf_select = $this->build_cff_query( $wpdb->posts.".ID" );
            /*---------------------------------------------------------------*/

            /*----------------------- Exclude USER id -----------------------*/
            $user_query = "";
            if ( isset($args['post_user_filter']['include']) ) {
                if ( !in_array(-1, $args['post_user_filter']['include']) ) {
                    $user_query = "AND $wpdb->posts.post_author IN (" . implode(", ", $args['post_user_filter']['include']) . ")
                    ";
                }
            }
            if ( isset($args['post_user_filter']['exclude']) ) {
                if ( !in_array(-1, $args['post_user_filter']['exclude']) )
                    $user_query = "AND $wpdb->posts.post_author NOT IN (".implode(", ", $args['post_user_filter']['exclude']).") ";
                else
                    return array();
            }
            /*---------------------------------------------------------------*/

            /*------------------------ Exclude ids --------------------------*/
            if ( !empty($args['post_not_in']) )
                $exclude_posts = "AND ($wpdb->posts.ID NOT IN (".(is_array($args['post_not_in']) ? implode(",", $args['post_not_in']) : $args['post_not_in'])."))";
            else
                $exclude_posts = "";
            if ( !empty($args['post_not_in2']) )
                $exclude_posts .= "AND ($wpdb->posts.ID NOT IN (".implode(",", $args['post_not_in2'])."))";
            /*---------------------------------------------------------------*/

            /*------------------------ Include ids --------------------------*/
            if ( !empty($args['post_in']) )
                $include_posts = "AND ($wpdb->posts.ID IN (".(is_array($args['post_in']) ? implode(",", $args['post_in']) : $args['post_in'])."))";
            else
                $include_posts = "";
            /*---------------------------------------------------------------*/

            /*------------------------ Term JOIN -------------------------*/
            // If the search in terms is not active, we don't need this unnecessary big join
            $term_join = "";
            if ( in_array('terms', $args['post_fields']) ) {
                $term_join = "
                LEFT JOIN $wpdb->term_relationships ON $wpdb->posts.ID = $wpdb->term_relationships.object_id
                LEFT JOIN $wpdb->term_taxonomy ON $wpdb->term_taxonomy.term_taxonomy_id = $wpdb->term_relationships.term_taxonomy_id
                LEFT JOIN $wpdb->terms ON $wpdb->term_taxonomy.term_id = $wpdb->terms.term_id";
            }
            /*---------------------------------------------------------------*/


            /*------------------------- WPML filter -------------------------*/
            $wpml_query = "(1)";
            if ( $args['_wpml_lang'] != "" ) {
                global $sitepress;
                $site_lang_selected = false;
                $wpml_post_types_arr = array();

                foreach ($args['post_type'] as $tt) {
                    $wpml_post_types_arr[] = "post_" . $tt;
                }
                $wpml_post_types = implode( "','", $wpml_post_types_arr );

                // Let us get the default site language if possible
                if ( is_object($sitepress) && method_exists($sitepress, 'get_default_language') ) {
                    $site_lang_selected = $sitepress->get_default_language() == $args['_wpml_lang'] ? true : false;
                }

                $_wpml_query_id_field = "$wpdb->posts.ID";
                // Product variations are not translated, so we need to use the parent ID (product) field to compare
                if ( in_array('product_variation', $args['post_type']) ) {
                    $_wpml_query_id_field = "(IF($wpdb->posts.post_type='product_variation', $wpdb->posts.post_parent, $wpdb->posts.ID))";
                }

                $wpml_query = "
				EXISTS (
					SELECT DISTINCT(wpml.element_id)
					FROM " . $wpdb->prefix . "icl_translations as wpml
					WHERE
	                    $_wpml_query_id_field = wpml.element_id AND
	                    wpml.language_code = '" . ASP_Helpers::escape( $args['_wpml_lang'] ) . "' AND
	                    wpml.element_type IN ('$wpml_post_types')
                )";

                /**
                 * For missing translations..
                 * If the site language is used, the translation can be non-existent
                 */
                if ($site_lang_selected) {
                    $wpml_query = "
                    NOT EXISTS (
                        SELECT DISTINCT(wpml.element_id)
                        FROM " . $wpdb->prefix . "icl_translations as wpml
                        WHERE
                            $_wpml_query_id_field = wpml.element_id AND
                            wpml.element_type IN ('$wpml_post_types')
                    ) OR
                    " . $wpml_query;
                }
            }
            /*---------------------------------------------------------------*/

            /*----------------------- POLYLANG filter -----------------------*/
            $polylang_query = "";
            if ( $args['_polylang_lang'] != "" ) {
                $languages = get_terms('language', array(
                        'hide_empty' => false,
                        'fields' => 'ids',
                        'orderby' => 'term_group',
                        'slug' => $args['_polylang_lang'])
                );
                if ( !empty($languages) && !is_wp_error($languages) && isset($languages[0]) ) {
                    $polylang_query = " AND (
                    $wpdb->posts.ID IN ( SELECT DISTINCT(tr.object_id)
                        FROM $wpdb->term_relationships AS tr
                        LEFT JOIN $wpdb->term_taxonomy as tt ON (tr.term_taxonomy_id = tt.term_taxonomy_id AND tt.taxonomy = 'language')
                        WHERE tt.term_id = $languages[0]
			         ) )";
                }
            }
            /*---------------------------------------------------------------*/

            /*--------------------- Post parent IDs -------------------------*/
            $post_parents = '';
            if ( count($args['post_parent']) > 0 ) {
                $post_parents = "AND $wpdb->posts.post_parent IN (".implode(',', $args['post_parent']).") ";
            }
            /*---------------------------------------------------------------*/

            /*--------------------- Other Query stuff -----------------------*/
            // Do not select the content field, if it is not used at all
            $select_content = $args['_post_get_content'] ? $wpdb->posts. ".post_content" : "''";

            // Do not select excerpt if its not used at all
            $select_excerpt = $args['_post_get_excerpt'] ? $wpdb->posts. ".post_excerpt" : "''";
            /*---------------------------------------------------------------*/

            /*----------------------- Date filtering ------------------------*/
            $date_query = "";
            $date_query_parts = $this->get_date_query_parts();
            if ( count($date_query_parts) > 0 )
                $date_query = " AND (" . implode(" AND ", $date_query_parts) . ") ";
            /*---------------------------------------------------------------*/

            /*-------------- Additional Query parts by Filters --------------*/
            /**
             * Use these filters to add additional parts to the select, join or where
             * parts of the search query.
             * Params:
             *  array() $args - search arguments
             *  string $s - the full search keyword
             *  array() $_s - the array of unique search keywords separated
             */
            $add_select = apply_filters('asp_cpt_query_add_select', '', $args, $s, $_s);
            $add_join = apply_filters('asp_cpt_query_add_join', '', $args, $s, $_s);
            $add_where = apply_filters('asp_cpt_query_add_where', '', $args, $s, $_s);
            /*---------------------------------------------------------------*/

            /*------------------- Post type based ordering ------------------*/
            $p_type_priority = "";
            if ( isset($sd['use_post_type_order']) && $sd['use_post_type_order'] == 1 ) {
                foreach ( $sd['post_type_order'] as $pk => $p_order ) {
                    $p_type_priority .= "
                    WHEN '$p_order' THEN $pk ";
                }
                if ( $p_type_priority != "")
                    $p_type_priority = "
                        CASE $wpdb->posts.post_type
                    " . " " .$p_type_priority . "
                          ELSE 999
                        END ";
                else
                    $p_type_priority = "1";
            } else {
                $p_type_priority = "1";
            }
            /*---------------------------------------------------------------*/

            /*---------------- Primary custom field ordering ----------------*/
            $custom_field_selectp = "1 ";
            if (
                strpos($args['post_primary_order'], 'customfp') !== false &&
                $args['_post_primary_order_metakey'] !== false
            ) {
                $custom_field_selectp = "(SELECT IF(meta_value IS NULL, 0, meta_value)
                FROM $wpdb->postmeta
                WHERE
                    $wpdb->postmeta.meta_key='".esc_sql($args['_post_primary_order_metakey'])."' AND
                    $wpdb->postmeta.post_id=$wpdb->posts.ID
                LIMIT 1
                ) ";
            }
            /*---------------------------------------------------------------*/

            /*--------------- Secondary custom field ordering ---------------*/
            $custom_field_selects = "1 ";
            if (
                strpos($args['post_secondary_order'], 'customfs') !== false &&
                $args['_post_secondary_order_metakey'] !== false
            ) {
                $custom_field_selects = "(SELECT IF(meta_value IS NULL, 0, meta_value)
                FROM $wpdb->postmeta
                WHERE
                    $wpdb->postmeta.meta_key='".esc_sql($args['_post_secondary_order_metakey'])."' AND
                    $wpdb->postmeta.post_id=$wpdb->posts.ID
                LIMIT 1
                ) ";
            }
            /*---------------------------------------------------------------*/


            /**
             * This is the main query.
             *
             * The ttid field is a bit tricky as the term_taxonomy_id doesn't always equal term_id,
             * so we need the LEFT JOINS :(
             */
            $this->ordering['primary'] = $args['post_primary_order'];
            $this->ordering['secondary'] = $args['post_secondary_order'];

            $_primary_field = explode(" ", $this->ordering['primary']);
            $this->ordering['primary_field'] = $_primary_field[0];

            $orderby_primary    = str_replace( "post_", $wpdb->posts . ".post_",  $args['post_primary_order'] );
            $orderby_secondary  = str_replace( "post_", $wpdb->posts . ".post_",  $args['post_secondary_order'] );

            if (
                $args['post_primary_order_metatype'] !== false &&
                $args['post_primary_order_metatype'] == 'numeric'
            )
                $orderby_primary = str_replace('customfp', 'CAST(customfp as SIGNED)', $orderby_primary);

            if (
                $args['post_secondary_order_metatype'] !== false &&
                $args['post_secondary_order_metatype'] == 'numeric'
            )
                $orderby_secondary = str_replace('customfs', 'CAST(customfs as SIGNED)', $orderby_secondary);

            $this->query = "
    		SELECT
    		    $add_select
    		    {args_fields}
                $wpdb->posts.post_title as title,
                $wpdb->posts.post_title as post_title,
                $wpdb->posts.ID as id,
                $this->c_blogid as blogid,
                $wpdb->posts.post_date as date,
                $wpdb->posts.post_date as post_date,
                $select_content as content,
                $select_excerpt as excerpt,
                $wpdb->posts.post_type as post_type,
                'pagepost' as content_type,
                'post_page_cpt' as g_content_type,
                (SELECT
                    $wpdb->users." . w_isset_def( $sd['author_field'], 'display_name' ) . " as author
                    FROM $wpdb->users
                    WHERE $wpdb->users.ID = $wpdb->posts.post_author
                ) as author,
                $wpdb->posts.post_author as post_author,
                $wpdb->posts.post_type as post_type,
                $priority_select AS priority,
                $p_type_priority AS p_type_priority,
                $group_priority_select
                {relevance_query} as relevance,
                $custom_field_selectp as customfp,
                $custom_field_selects as customfs
            FROM $wpdb->posts
                {postmeta_join}
                $term_join
                $add_join
                {args_join}
            WHERE
                $post_types
                $term_query
                $user_query
                AND $cf_select
                $post_statuses
                AND {like_query}
                $exclude_posts
                $include_posts
                $post_parents
                AND ( $wpml_query )
                $polylang_query
                $date_query
                $add_where
                {args_where}
            GROUP BY
                $wpdb->posts.ID
            ORDER BY {args_orderby} $group_priority_orderby priority DESC, p_type_priority ASC, $orderby_primary, $orderby_secondary, id DESC
            LIMIT $query_limit";

            // Place the argument query fields
            if ( isset($args['cpt_query']) && is_array($args['cpt_query']) ) {
                $this->query = str_replace(
                    array('{args_fields}', '{args_join}', '{args_where}', '{args_orderby}'),
                    array($args['cpt_query']['fields'], $args['cpt_query']['join'], $args['cpt_query']['where'], $args['cpt_query']['orderby']),
                    $this->query
                );
            } else {
                $this->query = str_replace(
                    array('{args_fields}', '{args_join}', '{args_where}', '{args_orderby}'),
                    '',
                    $this->query
                );
            }

            $words        = $args["_exact_matches"] == 1 ? array( $s ) : $_s;

            if ( $s != "") {
                /*----------------------- Title query ---------------------------*/
                if ( in_array('title', $args['post_fields']) ) {
                    $parts           = array();
                    $relevance_parts = array();

                    if ( $kw_logic == 'or' || $kw_logic == 'and' ) {
                        $op = strtoupper( $kw_logic );
                        if ( count( $_s ) > 0 ) {
                            $_like = implode( "%'$suf_like " . $op . " " . $pre_field . $wpdb->posts . ".post_title" . $suf_field . " LIKE $pre_like'%", $words );
                        } else {
                            $_like = $s;
                        }
                        $parts[] = "( " . $pre_field . $wpdb->posts . ".post_title" . $suf_field . " LIKE $pre_like'$wcl" . $_like . "$wcr'$suf_like )";
                    } else {
                        $_like = array();
                        $op    = $kw_logic == 'andex' ? 'AND' : 'OR';
                        foreach ( $words as $word ) {
                            $_like[] = "
                               ( " . $pre_field . $wpdb->posts . ".post_title" . $suf_field . " LIKE $pre_like'% " . $word . " %'$suf_like
                            OR  " . $pre_field . $wpdb->posts . ".post_title" . $suf_field . " LIKE $pre_like'" . $word . " %'$suf_like
                            OR  " . $pre_field . $wpdb->posts . ".post_title" . $suf_field . " LIKE $pre_like'% " . $word . "'$suf_like
                            OR  " . $pre_field . $wpdb->posts . ".post_title" . $suf_field . " = '" . $word . "')";
                        }
                        $parts[] = "(" . implode( ' ' . $op . ' ', $_like ) . ")";
                    }

                    $relevance_parts[] = "(case when
                    (" . $pre_field . $wpdb->posts . ".post_title" . $suf_field . " LIKE '$s%')
                     then ".(w_isset_def($sd['etitleweight'], 10) * 2)." else 0 end)";

                    $relevance_parts[] = "(case when
                    (" . $pre_field . $wpdb->posts . ".post_title" . $suf_field . " LIKE '%$s%')
                     then ".w_isset_def($sd['etitleweight'], 10)." else 0 end)";

                    // The first word relevance is higher
                    if ( count( $_s ) > 0 ) {
                        $relevance_parts[] = "(case when
                      (" . $pre_field . $wpdb->posts . ".post_title" . $suf_field . " LIKE '%" . $_s[0] . "%')
                       then ".w_isset_def($sd['etitleweight'], 10)." else 0 end)";
                    }

                    $this->parts[] = array( $parts, $relevance_parts );
                }
                /*---------------------------------------------------------------*/

                /*---------------------- Content query --------------------------*/
                if ( in_array('content', $args['post_fields']) ) {
                    $parts           = array();
                    $relevance_parts = array();

                    if ( $kw_logic == 'or' || $kw_logic == 'and' ) {
                        $op = strtoupper( $kw_logic );
                        if ( count( $_s ) > 0 ) {
                            $_like = implode( "%'$suf_like " . $op . " " . $pre_field . $wpdb->posts . ".post_content" . $suf_field . " LIKE $pre_like'%", $words );
                        } else {
                            $_like = $s;
                        }
                        $parts[] = "( " . $pre_field . $wpdb->posts . ".post_content" . $suf_field . " LIKE $pre_like'$wcl" . $_like . "$wcr'$suf_like )";
                    } else {
                        $_like = array();
                        $op    = $kw_logic == 'andex' ? 'AND' : 'OR';
                        foreach ( $words as $word ) {
                            $_like[] = "
                               (" . $pre_field . $wpdb->posts . ".post_content" . $suf_field . " LIKE $pre_like'% " . $word . " %'$suf_like
                            OR  " . $pre_field . $wpdb->posts . ".post_content" . $suf_field . " LIKE $pre_like'" . $word . " %'$suf_like
                            OR  " . $pre_field . $wpdb->posts . ".post_content" . $suf_field . " LIKE $pre_like'% " . $word . "'$suf_like
                            OR  " . $pre_field . $wpdb->posts . ".post_content" . $suf_field . " = '" . $word . "')";
                        }
                        $parts[] = "(" . implode( ' ' . $op . ' ', $_like ) . ")";
                    }

                    if ( count( $_s ) > 0 ) {
                        $relevance_parts[] = "(case when
                        (" . $pre_field . $wpdb->posts . ".post_content" . $suf_field . " LIKE '%" . $_s[0] . "%')
                         then ".w_isset_def($sd['contentweight'], 10)." else 0 end)";
                    }
                    $relevance_parts[] = "(case when
                    (" . $pre_field . $wpdb->posts . ".post_content" . $suf_field . " LIKE '%$s%')
                     then ".w_isset_def($sd['econtentweight'], 10)." else 0 end)";

                    $this->parts[] = array( $parts, $relevance_parts );
                }
                /*---------------------------------------------------------------*/

                /*----------------- Permalink/Post name query -------------------*/
                if ( in_array('permalink', $args['post_fields']) ) {
                    $parts           = array();
                    $relevance_parts = array();

                    if ( $kw_logic == 'or' || $kw_logic == 'and' )
                        $op = strtoupper( $kw_logic );
                    else
                        $op = $kw_logic == 'andex' ? 'AND' : 'OR';
                    if (count($_s) > 0) {
                        $_like = implode("%'$suf_like " . $op . " " . $pre_field . $wpdb->posts . ".post_name" . $suf_field . " LIKE $pre_like'%", $words);
                    } else {
                        $_like = $s;
                    }
                    $parts[] = "( " . $pre_field . $wpdb->posts . ".post_name" . $suf_field . " LIKE $pre_like'$wcl" . $_like . "$wcr'$suf_like )";

                    $this->parts[] = array( $parts, $relevance_parts );
                }
                /*---------------------------------------------------------------*/

                /*---------------------- Excerpt query --------------------------*/
                if ( in_array('excerpt', $args['post_fields']) ) {
                    $parts           = array();
                    $relevance_parts = array();

                    if ( $kw_logic == 'or' || $kw_logic == 'and' ) {
                        $op = strtoupper( $kw_logic );
                        if ( count( $_s ) > 0 ) {
                            $_like = implode( "%'$suf_like " . $op . " " . $pre_field . $wpdb->posts . ".post_excerpt" . $suf_field . " LIKE $pre_like'%", $words );
                        } else {
                            $_like = $s;
                        }
                        $parts[] = "( " . $pre_field . $wpdb->posts . ".post_excerpt" . $suf_field . " LIKE $pre_like'$wcl" . $_like . "$wcr'$suf_like )";
                    } else {
                        $_like = array();
                        $op    = $kw_logic == 'andex' ? 'AND' : 'OR';
                        foreach ( $words as $word ) {
                            $_like[] = "
                               (" . $pre_field . $wpdb->posts . ".post_excerpt" . $suf_field . " LIKE $pre_like'% " . $word . " %'$suf_like
                            OR  " . $pre_field . $wpdb->posts . ".post_excerpt" . $suf_field . " LIKE $pre_like'" . $word . " %'$suf_like
                            OR  " . $pre_field . $wpdb->posts . ".post_excerpt" . $suf_field . " LIKE $pre_like'% " . $word . "'$suf_like
                            OR  " . $pre_field . $wpdb->posts . ".post_excerpt" . $suf_field . " = '" . $word . "')";
                        }
                        $parts[] = "(" . implode( ' ' . $op . ' ', $_like ) . ")";
                    }

                    if ( count( $_s ) > 0 ) {
                        $relevance_parts[] = "(case when
                        (" . $pre_field . $wpdb->posts . ".post_excerpt" . $suf_field . " LIKE '%" . $_s[0] . "%')
                         then ".w_isset_def($sd['excerptweight'], 10)." else 0 end)";
                    }
                    $relevance_parts[] = "(case when
                    (" . $pre_field . $wpdb->posts . ".post_excerpt" . $suf_field . " LIKE '%$s%')
                     then ".w_isset_def($sd['eexcerptweight'], 10)." else 0 end)";

                    $this->parts[] = array( $parts, $relevance_parts );
                }
                /*---------------------------------------------------------------*/

                /*------------------------ Term query ---------------------------*/
                if ( in_array('terms', $args['post_fields']) ) {
                    $parts           = array();
                    $relevance_parts = array();

                    if ( $kw_logic == 'or' || $kw_logic == 'and' ) {
                        $op = strtoupper( $kw_logic );
                        if ( count( $_s ) > 0 ) {
                            $_like = implode( "%'$suf_like " . $op . " " . $pre_field . $wpdb->terms . ".name" . $suf_field . " LIKE $pre_like'%", $words );
                        } else {
                            $_like = $s;
                        }
                        $parts[] = "( " . $pre_field . $wpdb->terms . ".name" . $suf_field . " LIKE $pre_like'$wcl" . $_like . "$wcr'$suf_like )";
                    } else {
                        $_like = array();
                        $op    = $kw_logic == 'andex' ? 'AND' : 'OR';
                        foreach ( $words as $word ) {
                            $_like[] = "
                               (" . $pre_field . $wpdb->terms . ".name" . $suf_field . " LIKE $pre_like'% " . $word . " %'$suf_like
                            OR  " . $pre_field . $wpdb->terms . ".name" . $suf_field . " LIKE $pre_like'" . $word . " %'$suf_like
                            OR  " . $pre_field . $wpdb->terms . ".name" . $suf_field . " LIKE $pre_like'% " . $word . "'$suf_like
                            OR  " . $pre_field . $wpdb->terms . ".name" . $suf_field . " = '" . $word . "')";
                        }
                        $parts[] = "(" . implode( ' ' . $op . ' ', $_like ) . ")";
                    }

                    $relevance_parts[] = "(case when
                    (" . $pre_field . $wpdb->terms . ".name" . $suf_field . " = '$s')
                     then ".w_isset_def($sd['etermsweight'], 10)." else 0 end)";

                    $this->parts[] = array( $parts, $relevance_parts );
                }
                /*---------------------------------------------------------------*/

                /*---------------------- Custom Fields --------------------------*/
                if ( $args['post_custom_fields_all'] == 1 )
                    $args['post_custom_fields'] = array("all");

                if ( count($args['post_custom_fields']) > 0 ) {
                    $parts           = array();
                    $relevance_parts = array();
                    $postmeta_join   = "LEFT JOIN $wpdb->postmeta ON $wpdb->postmeta.post_id = $wpdb->posts.ID";

                    foreach ( $args['post_custom_fields'] as $cfield ) {
                        $key_part = $args['post_custom_fields_all'] == 1 ? "" : "$wpdb->postmeta.meta_key='$cfield' AND ";

                        if ( $kw_logic == 'or' || $kw_logic == 'and' ) {
                            $op = strtoupper( $kw_logic );
                            if ( count( $_s ) > 0 ) {
                                $_like = implode( "%'$suf_like " . $op . " " . $pre_field . $wpdb->postmeta . ".meta_value" . $suf_field . " LIKE $pre_like'%", $words );
                            } else {
                                $_like = $s;
                            }
                            $parts[] = "( $key_part " . $pre_field . $wpdb->postmeta . ".meta_value" . $suf_field . " LIKE $pre_like'$wcl" . $_like . "$wcr'$suf_like )";
                        } else {
                            $_like = array();
                            $op    = $kw_logic == 'andex' ? 'AND' : 'OR';
                            foreach ( $words as $word ) {
                                $_like[] = "
                           (" . $pre_field . $wpdb->postmeta . ".meta_value" . $suf_field . " LIKE $pre_like'% " . $word . " %'$suf_like
                        OR  " . $pre_field . $wpdb->postmeta . ".meta_value" . $suf_field . " LIKE $pre_like'" . $word . " %'$suf_like
                        OR  " . $pre_field . $wpdb->postmeta . ".meta_value" . $suf_field . " LIKE $pre_like'% " . $word . "'$suf_like
                        OR  " . $pre_field . $wpdb->postmeta . ".meta_value" . $suf_field . " = '" . $word . "')";
                            }
                            $parts[] = "( $key_part (" . implode( ' ' . $op . ' ', $_like ) . ") )";
                        }
                        if ( $cfield == 'author_field_name ')
                            $relevance_parts[] = "(case when
                            ($wpdb->postmeta.meta_key='$cfield' AND " . $pre_field . $wpdb->postmeta . ".meta_value" . $suf_field . " LIKE '%$s%')
                             then 100 else 0 end)";
                        if ( $cfield == 'fulltext_field_name ')
                            $relevance_parts[] = "(case when
                            ($wpdb->postmeta.meta_key='$cfield' AND " . $pre_field . $wpdb->postmeta . ".meta_value" . $suf_field . " LIKE '%$s%')
                             then 10 else 0 end)";
                    }
                    $this->parts[] = array( $parts, $relevance_parts );
                }
                /*---------------------------------------------------------------*/

                /*---------------------- Post CPT IDs ---------------------------*/
                if ( in_array("ids", $args['post_fields']) )
                    $this->parts[] = array(
                        array("$wpdb->posts.ID LIKE '$s'"), array()
                    );
                /*---------------------------------------------------------------*/
            }

            // Add the meta join if needed..
            $this->query = str_replace( '{postmeta_join}', $postmeta_join, $this->query );

            $querystr = $this->build_query( $this->parts, true );
            $all_pageposts = $wpdb->get_results( $querystr, OBJECT );

            // Get the real count, up to 500
            $this->results_count = count($all_pageposts);
            // For non-ajax search, results count needs to be limited to the maximum limit,
            // ..as nothing is parsed beyond that
            if ($args['_ajax_search'] == false && $this->results_count > $this->remaining_limit) {
                $this->results_count = $this->remaining_limit;
            }

            /**
             * Order them again:
             *  - The custom field ordering always uses alphanumerical comparision, which is not ok
             */
            if (
                count($all_pageposts) > 0 &&
                (
                    strpos($args['post_primary_order'], 'customfp') !== false ||
                    strpos($args['post_secondary_order'], 'customfs') !== false
                )
            ) {
                usort( $all_pageposts, array( $this, 'compare_by_primary' ) );
                /**
                 * Let us save some time. There is going to be a user selecting the same sorting
                 * for both primary and secondary. Only do secondary if it is different from the primary.
                 */
                if ( $this->ordering['primary'] != $this->ordering['secondary'] ) {
                    $i = 0;
                    foreach ($all_pageposts as $pk => $pp) {
                        $all_pageposts[$pk]->primary_order = $i;
                        $i++;
                    }

                    usort( $all_pageposts, array( $this, 'compare_by_secondary' ) );
                }
            }

            // Slice the needed ones only
            $all_pageposts = array_slice($all_pageposts, $args['_call_num'] * $this->remaining_limit, $this->remaining_limit);

            $this->results = $all_pageposts;
            $this->return_count = count($this->results);

            return $all_pageposts;
        }

        protected function build_pgp_query($post_id_field) {
            global $wpdb;
            $query = '1';
            $s  = $this->s;
            $args = $this->args;

            $group_query_arr = array();
            foreach(wd_asp()->priority_groups->getSorted() as $group) {
                // Rule affects this instance?
                if ($group['instance'] != 0 && $group['instance'] != $args['_sid'])
                    continue;
                // Rule affects this phrase?
                if ( ASP_mb::strlen($group['phrase']) > 0 ) {
                    switch ($group['phrase_logic']) {
                        case 'any':
                            if (ASP_mb::strpos($s, $group['phrase']) === false)
                                continue 2;
                            break;
                        case 'exact':
                            if ($s !== $group['phrase'])
                                continue 2;
                            break;
                        case 'start':
                            if (ASP_mb::strpos($s, $group['phrase']) !== 0)
                                continue 2;
                            break;
                        case 'end':
                            if (!(ASP_mb::substr($s, -ASP_mb::strlen($group['phrase'])) === $group['phrase']))
                                continue 2;
                            break;
                    }
                }
                $rule_query_arr = array();
                foreach($group['rules'] as $rule) {
                    switch($rule['field']) {
                        case 'tax':
                            $tax_term_query_arr = array();
                            foreach ( $rule['values'] as $taxonomy => $terms ) {
                                if (count($terms) < 1)
                                    continue;
                                $term_ids = implode(',', $terms);
                                if ( $rule['operator'] == 'in' ) {
                                    $operator = 'EXISTS';
                                } else {
                                    $operator = 'NOT EXISTS';
                                }
                                $tax_term_query_arr[] = "(
                                $operator ( SELECT 1
                                        FROM $wpdb->term_relationships AS gptr
                                        LEFT JOIN $wpdb->term_taxonomy as gptt ON (gptr.term_taxonomy_id = gptt.term_taxonomy_id AND gptt.taxonomy = '$taxonomy')
                                        WHERE gptt.term_id IN ($term_ids) AND gptr.object_id = $post_id_field
                                 ) )";
                            }
                            if ( count($tax_term_query_arr) ) {
                                $tax_term_query = '( '.implode(' AND ', $tax_term_query_arr) . ' )';
                                $rule_query_arr[] = $tax_term_query;
                            }
                            break;
                        case 'cf':
                            // Get the field and the values
                            foreach ( $rule['values'] as $field => $values )
                                break;
                            $field = ASP_Helpers::escape($field);

                            $numeric_operators = array('=', '<>', '>', '>=', '<', '<=');
                            if ( false !== $nkey = array_search($rule['operator'], $numeric_operators) ) {
                                $operator = $numeric_operators[$nkey];
                                $values = ASP_Helpers::force_numeric($values);
                                $qry = " gp_pm.meta_value".$operator.$values[0];
                            } else if(
                                $rule['operator'] == 'between' &&
                                isset($values[0], $values[1])
                            ) {
                                $qry = " gp_pm.meta_value BETWEEN ".$values[0]. " AND ".$values[1];
                            } else if ( $rule['operator'] == 'like' ) {
                                $qry = " gp_pm.meta_value LIKE '%".$values[0]."%'";
                            } else if ( $rule['operator'] == 'not like' ) {
                                $qry = " gp_pm.meta_value NOT LIKE '%".$values[0]."%'";
                            } else if ( $rule['operator'] == 'elike' ) {
                                $qry = " gp_pm.meta_value LIKE '".$values[0]."'";
                            } else {
                                // None of the operators above?
                                continue 2;
                            }

                            $cf_query = "
                            (EXISTS(
                                SELECT 1
                                FROM $wpdb->postmeta as gp_pm
                                WHERE gp_pm.post_id = $post_id_field AND gp_pm.meta_key='$field' AND $qry
                                GROUP BY gp_pm.meta_id
                                ORDER BY gp_pm.meta_id
                                LIMIT 1
                            ))";
                            $rule_query_arr[] = $cf_query;
                            break;
                    }
                }

                // Construct the WHEN-THEN for this case
                if ( count($rule_query_arr) > 0 ) {
                    $priority = $group['priority'] + 0;
                    if ( $group['logic'] == 'and' )
                        $rule_logic = ' AND ';
                    else
                        $rule_logic = ' OR ';
                    $condition = implode($rule_logic, $rule_query_arr);
                    $group_query_arr[] = "WHEN $condition THEN $priority";
                }

            }

            if ( count($group_query_arr) > 0 ) {
                $query = implode(' ', $group_query_arr);
                $query = "(CASE
                    $query
                    ELSE 1
                END)";
            }

            return $query;
        }

        protected function build_term_query($post_id_field, $post_type_field) {
            global $wpdb;
            $args = $this->args;

            if ( isset($_GET['ignore_op']) ) return "";

            $term_query = "";
            $term_query_parts = array();

            foreach ($args['post_tax_filter'] as $k => $item) {
                $tax_term_query = '';
                $taxonomy = $item['taxonomy'];

                // Is there an argument set to allow empty items for this taxonomy filter?
                if ( isset($item['allow_empty']) ) {
                    $allow_empty_tax_term = $item['allow_empty'];
                } else {
                    $allow_empty_tax_term = $taxonomy == 'post_tag' ? $args["_post_tags_empty"] : $args['_post_allow_empty_tax_term'];
                }

                if ( $allow_empty_tax_term == 1 ) {
                    $empty_terms_query = "
                    NOT EXISTS (
                        SELECT *
                        FROM $wpdb->term_relationships as xt
                        INNER JOIN $wpdb->term_taxonomy as tt ON ( xt.term_taxonomy_id = tt.term_taxonomy_id AND tt.taxonomy = '$taxonomy')
                        WHERE
                            xt.object_id = $post_id_field
                    ) OR ";
                } else {
                    $empty_terms_query = "";
                }

                // Quick explanation for the AND
                // .. MAIN SELECT: selects all object_ids that are not in the array
                // .. SUBSELECT:   excludes all the object_ids that are part of the array
                // This is used because of multiple object_ids (posts in more than 1 tag)
                if ( !empty($item['exclude']) ) {
                    $words = implode( ',', $item['exclude'] );
                    $tax_term_query = " (
                        $empty_terms_query

						$post_id_field IN (
							SELECT DISTINCT(tr.object_id)
								FROM $wpdb->term_relationships AS tr
				                LEFT JOIN $wpdb->term_taxonomy as tt ON (tr.term_taxonomy_id = tt.term_taxonomy_id AND tt.taxonomy = '$taxonomy')
												WHERE
													tt.term_id NOT IN ($words)
													AND tr.object_id NOT IN (
														SELECT DISTINCT(trs.object_id)
														FROM $wpdb->term_relationships AS trs
				                    LEFT JOIN $wpdb->term_taxonomy as tts ON (trs.term_taxonomy_id = tts.term_taxonomy_id AND tts.taxonomy = '$taxonomy')
														WHERE tts.term_id IN ($words)
													)
										)
									)";
                }
                if ( !empty($item['include']) ) {
                    $words = implode( ',', $item['include'] );
                    if ( !empty($tax_term_query) )
                        $tax_term_query .= " AND ";
                    if ( isset($item['logic']) && $item['logic'] == 'andex' ) {
                        $tax_term_query .= "(
                            $empty_terms_query
    
                            ".count($item['include'])." = ( SELECT COUNT(tr.object_id)
                                FROM $wpdb->term_relationships AS tr
                                LEFT JOIN $wpdb->term_taxonomy as tt ON (tr.term_taxonomy_id = tt.term_taxonomy_id AND tt.taxonomy = '$taxonomy')
                                WHERE tt.term_id IN ($words) AND tr.object_id = $post_id_field
                          ) )";
                    } else {
                        $tax_term_query .= "(
                            $empty_terms_query
    
                            $post_id_field IN ( SELECT DISTINCT(tr.object_id)
                                FROM $wpdb->term_relationships AS tr
                                LEFT JOIN $wpdb->term_taxonomy as tt ON (tr.term_taxonomy_id = tt.term_taxonomy_id AND tt.taxonomy = '$taxonomy')
                                WHERE tt.term_id IN ($words)
                          ) )";
                    }
                }


                /**
                 * POST TAG SPECIFIC ONLY
                 *
                 * At this point we need to check if the user wants to hide the empty tags but the $tag_query
                 * turned out to be empty. (if not all tags are used and all of them are selected).
                 * If so, then return true on every post type other than 'post' OR check if any tags
                 * are associated with the post.
                 */
                if (
                    $taxonomy == 'post_tag' &&
                    $args['_post_tags_active'] == 1 &&
                    $tax_term_query == "" &&
                    $args["_post_tags_empty"] == 0
                ) {
                    $tax_term_query = "
                    (
                        ($post_type_field != 'post') OR

                        EXISTS (
                            SELECT *
                            FROM $wpdb->term_relationships as xt
                            INNER JOIN $wpdb->term_taxonomy as tt ON ( xt.term_taxonomy_id = tt.term_taxonomy_id AND tt.taxonomy = 'post_tag')
                            WHERE
                                xt.object_id = $post_id_field
                        )
                    )";
                }
                // ----------------------------------------------------

                if ( !empty($tax_term_query) )
                    $term_query_parts[] = "(" . $tax_term_query . ")";
            }

            if ( !empty($term_query_parts) )
                $term_query = "AND (" . implode(" ".strtoupper($args['_taxonomy_group_logic'])." ", $term_query_parts) . ") ";

            return $term_query;
        }

        protected function build_cff_query( $post_id_field ) {
            global $wpdb;
            $args = $this->args;
            $parts = array();

            aspDebug::start( '--searchContent-cf' );

            $allow_cf_null = $args['_post_meta_allow_null'];

            foreach ( $args['post_meta_filter'] as $data ) {

                $operator = $data['operator'];
                $posted = $data['value'];
                $field = $data['key'];

                // Is this a special case of date operator?
                if (strpos($operator, "datetime") === 0) {
                    switch ($operator) {
                        case 'datetime =':
                            $current_part = "($wpdb->postmeta.meta_value BETWEEN '$posted 00:00:00' AND '$posted 23:59:59')";
                            break;
                        case 'datetime <>':
                            $current_part = "($wpdb->postmeta.meta_value NOT BETWEEN '$posted 00:00:00' AND '$posted 23:59:59')";
                            break;
                        case 'datetime <':
                            $current_part = "($wpdb->postmeta.meta_value < '$posted 00:00:00')";
                            break;
                        case 'datetime >':
                            $current_part = "($wpdb->postmeta.meta_value > '$posted 23:59:59')";
                            break;
                        default:
                            $current_part = "($wpdb->postmeta.meta_value < '$posted 00:00:00')";
                            break;
                    }
                    // Is this a special case of timestamp?
                } else if (strpos($operator, "timestamp") === 0) {
                    switch ($operator) {
                        case 'timestamp =':
                            $current_part = "($wpdb->postmeta.meta_value BETWEEN $posted AND ".($posted + 86399).")";
                            break;
                        case 'timestamp <>':
                            $current_part = "($wpdb->postmeta.meta_value NOT BETWEEN $posted AND ".($posted + 86399).")";
                            break;
                        case 'timestamp <':
                            $current_part = "($wpdb->postmeta.meta_value < $posted)";
                            break;
                        case 'timestamp >':
                            $current_part = "($wpdb->postmeta.meta_value > ".($posted + 86399).")";
                            break;
                        default:
                            $current_part = "($wpdb->postmeta.meta_value < $posted)";
                            break;
                    }
                    // Check BETWEEN first -> range slider
                } else if ( $operator === "BETWEEN" ) {
                    $current_part = "($wpdb->postmeta.meta_value BETWEEN " . $posted[0] . " AND " . $posted[1] . " )";
                    // If not BETWEEN but value is array, then drop-down or checkboxes
                } else if ( is_array($posted) ) {
                    // Is there a logic sent?
                    $logic  = isset($data['logic']) ? $data['logic'] : "OR";
                    $values = '';
                    if ($operator === "IN" ) {
                        $val = implode("','", $posted);
                        if ( !empty($val) ) {
                            if ($values != '') {
                                $values .= " $logic $wpdb->postmeta.meta_value $operator ('" . $val . "')";
                            } else {
                                $values .= "$wpdb->postmeta.meta_value $operator ('" . $val . "')";
                            }
                        }
                    } else {
                        foreach ($posted as $v) {
                            if ($operator === "ELIKE") {
                                if ($values != '') {
                                    $values .= " $logic $wpdb->postmeta.meta_value $operator '" . $v . "'";
                                } else {
                                    $values .= "$wpdb->postmeta.meta_value $operator '" . $v . "'";
                                }
                            } else if ($operator === "NOT LIKE" || $operator === "LIKE") {
                                if ($values != '') {
                                    $values .= " $logic $wpdb->postmeta.meta_value $operator '%" . $v . "%'";
                                } else {
                                    $values .= "$wpdb->postmeta.meta_value $operator '%" . $v . "%'";
                                }
                            } else {
                                if ($values != '') {
                                    $values .= " $logic $wpdb->postmeta.meta_value $operator " . $v;
                                } else {
                                    $values .= "$wpdb->postmeta.meta_value $operator " . $v;
                                }
                            }
                        }
                    }

                    $values  = $values == '' ? '0' : $values;
                    $current_part = "($values)";
                    // String operations
                } else if ($operator === "NOT LIKE" || $operator === "LIKE") {
                    $current_part = "($wpdb->postmeta.meta_value $operator '%" . $posted . "%')";
                } else if ($operator === "ELIKE") {
                    $current_part = "($wpdb->postmeta.meta_value LIKE '$posted')";
                    // Numeric operations or problematic stuff left
                } else {
                    $current_part = "($wpdb->postmeta.meta_value $operator $posted  )";
                }

                // Finally add the current part to the parts array
                if ( $current_part != "") {
                    if ( isset($data['allow_missing']) )
                        $allowance = $data['allow_missing'];
                    else
                        $allowance = $allow_cf_null;

                    $parts[] = array($field, $current_part, $allowance);
                }
            }

            // The correct count is the unique fields count
            //$meta_count = count( $unique_fields );

            $cf_select = "(1)";
            $cf_select_arr = array();

            /**
             * NOTE 1:
             * With the previous NOT EXISTS(...) subquery solution the search would hang in some cases
             * when checking if empty values are allowed. No idea why though...
             * Eventually using separate subqueries for each field is the best.
             *
             * NOTE 2:
             * COUNT(post_id) is a MUST in the nested IF() statement !! Otherwise the query will return empty rows, no idea why either..
             */

            foreach ( $parts as $k => $part ) {
                $def = $part[2] ? "(
                    SELECT IF((meta_key IS NULL OR meta_value = ''), -1, COUNT(meta_id))
                    FROM $wpdb->postmeta
                    WHERE $wpdb->postmeta.post_id = $post_id_field AND $wpdb->postmeta.meta_key='$field'
                    LIMIT 1
                  ) = -1
                 OR" : '';                  // Allowance
                $field = $part[0];          // Field name
                $qry = $part[1];            // Query condition
                $cf_select_arr[] = "
                (
                  $def
                  (
                    SELECT COUNT(meta_id) as mtc
                    FROM $wpdb->postmeta
                    WHERE $wpdb->postmeta.post_id = $post_id_field AND $wpdb->postmeta.meta_key='$field' AND $qry
                    GROUP BY meta_id
                    ORDER BY mtc
                    LIMIT 1
                  ) >= 1
                )";
            }
            if ( count($cf_select_arr) ) {
                // Connect them based on the meta logic
                $cf_select = "( ". implode( $args['_post_meta_logic'], $cf_select_arr ) . " )";
            }

            aspDebug::stop( '--searchContent-cf' );

            return $cf_select;
        }

        protected function get_date_query_parts( $table_alias = "", $date_field = "post_date" ) {
            global $wpdb;
            $args = $this->args;

            if ( empty($table_alias) )
                $table_alias = $wpdb->posts;

            $date_query_parts = array();

            foreach( $args['post_date_filter'] as $date_filter ) {
                if (isset($date_filter['date']))    // Given by date argument
                    $date = $date_filter['date'];
                else                                // Given by year, month, day arguments
                    $date = $date_filter['year'] . "-" . sprintf("%02d", $date_filter['month']) . "-" . sprintf("%02d", $date_filter['day']);

                if ($date_filter['interval'] == "before") {
                    $op = $date_filter['operator'] == "exclude" ? ">" : "<=";
                    $date_query_parts[] = "$table_alias.$date_field $op '" . $date . " 23:59:59'";
                } else {
                    $op = $date_filter['operator'] == "exclude" ? "<" : ">=";
                    $date_query_parts[] = "$table_alias.$date_field $op '" . $date . " 00:00:00'";
                }
            }
            return $date_query_parts;
        }


        /**
         * usort() custom function, sort by primary
         *
         * @param $a
         * @param $b
         *
         * @return int
         */
        protected function compare_by_primary( $a, $b ) {
            // Only compare objects with the same post type priority, so the groups dont get messed up
            if ( $a->p_type_priority === $b->p_type_priority ) {

                if ($a->group_priority === $b->group_priority) {

                    if ($a->priority === $b->priority) {

                        switch ($this->ordering['primary']) {
                            case "average_rating DESC":
                                // ceil() is very important here!! as this expects 1, 0, -1 but no values inbetween
                                return ceil((float)$b->average_rating - (float)$a->average_rating);
                                break;
                            case "relevance DESC":
                                return $b->relevance - $a->relevance;
                                break;
                            case "post_date DESC":
                                $date_diff = strtotime($b->date) - strtotime($a->date);
                                if ($date_diff == 0)
                                    return $b->id - $a->id;

                                return $date_diff;
                                break;
                            case "post_date ASC":
                                $date_diff = strtotime($a->date) - strtotime($b->date);
                                if ($date_diff == 0)
                                    return $a->id - $b->id;

                                return $date_diff;
                                break;
                            case "post_title DESC":
                                return strcasecmp($b->title, $a->title);
                                break;
                            case "post_title ASC":
                                return strcasecmp($a->title, $b->title);
                                break;
                            case "customfp DESC":
                                if ($this->args['post_primary_order_metatype'] == 'numeric')
                                    return $b->customfp - $a->customfp;
                                else
                                    return strcasecmp($b->customfp, $a->customfp);
                                break;
                            case "customfp ASC":
                                if ($this->args['post_primary_order_metatype'] == 'numeric')
                                    return $a->customfp - $b->customfp;
                                else
                                    return strcasecmp($a->customfp, $b->customfp);
                                break;
                            default:
                                return $b->relevance - $a->relevance;
                                break;
                        }

                    }

                    return $b->priority - $a->priority;
                }

                return $b->group_priority - $a->group_priority;
            }

            // Post type priority is not equivalent, results should be treated as equals, no change
            return $a->p_type_priority - $b->p_type_priority;
        }

        /**
         * usort() custom function, sort by secondary
         *
         * @param $a
         * @param $b
         *
         * @return int
         */
        protected function compare_by_secondary( $a, $b ) {
            if ( $a->p_type_priority === $b->p_type_priority ) {

                if ($a->group_priority === $b->group_priority) {

                    if ($a->priority === $b->priority) {

                        $field = $this->ordering['primary_field'];

                        if ($a->$field == $b->$field) {

                            switch ($this->ordering['secondary']) {
                                case "relevance DESC":
                                    return $b->relevance - $a->relevance;
                                    break;
                                case "post_date DESC":
                                    $date_diff = strtotime($b->date) - strtotime($a->date);
                                    if ($date_diff == 0)
                                        return $b->id - $a->id;

                                    return $date_diff;
                                    break;
                                case "post_date ASC":
                                    $date_diff = strtotime($a->date) - strtotime($b->date);
                                    if ($date_diff == 0)
                                        return $a->id - $b->id;

                                    return $date_diff;
                                    break;
                                case "post_title DESC":
                                    return strcasecmp($b->title, $a->title);
                                    break;
                                case "post_title ASC":
                                    return strcasecmp($a->title, $b->title);
                                    break;
                                case "customfs DESC":
                                    if ($this->args['post_secondary_order_metatype'] == 'numeric')
                                        return $b->customfs - $a->customfs;
                                    else
                                        return strcasecmp($b->customfs, $a->customfs);
                                    break;
                                case "customfs ASC":
                                    if ($this->args['post_secondary_order_metatype'] == 'numeric')
                                        return $a->customfs - $b->customfs;
                                    else
                                        return strcasecmp($a->customfs, $b->customfs);
                                    break;
                                default:
                                    return $b->relevance - $a->relevance;
                                    break;
                            }

                        }

                        /**
                         * If the primary fields are not equal, then leave it as it is.
                         * The primary sorting already sorted the items out so return 0 - as equals
                         */
                        return $a->primary_order - $b->primary_order;

                    }

                    return $b->priority - $a->priority;
                }

                return $b->group_priority - $a->group_priority;
            }

            return $a->p_type_priority - $b->p_type_priority;
        }

        /**
         * usort() custom function, sort by ID
         *
         * @param $obj_a
         * @param $obj_b
         *
         * @return mixed
         */
        protected function compare_posts( $obj_a, $obj_b ) {
            return $obj_a->id - $obj_b->id;
        }

        /**
         * usort() custom function, sort by priority > relevance > date > title
         *
         * @param $a
         * @param $b
         *
         * @return int
         */
        protected function compare_by_rp( $a, $b ) {
            if ( $a->priority === $b->priority ) {
                if ( $a->relevance === $b->relevance ) {
                    if ( $a->date != null && $a->date != "" ) {
                        return strtotime( $b->date ) - strtotime( $a->date );
                    } else {
                        return strcasecmp( $a->title, $b->title );
                    }
                } else {
                    return $b->relevance - $a->relevance;
                }
            }

            return $b->priority - $a->priority;
        }

        /**
         * usort() custom function, sort by priority > date ascending
         *
         * @param $a
         * @param $b
         *
         * @return int
         */
        protected function compare_by_rd_asc( $a, $b ) {
            if ( $a->priority === $b->priority ) {
                return strtotime( $a->date ) - strtotime( $b->date );
            }

            return $b->priority - $a->priority;
        }

        /**
         * usort() custom function, sort by priority > date descending
         *
         * @param $a
         * @param $b
         *
         * @return int
         */
        protected function compare_by_rd_desc( $a, $b ) {
            if ( $a->priority === $b->priority ) {
                return strtotime( $b->date ) - strtotime( $a->date );
            }

            return $b->priority - $a->priority;
        }

        /**
         * usort() custom function, sort by title descending
         *
         * @param $a
         * @param $b
         *
         * @return int
         */
        protected function compare_by_title_desc( $a, $b ) {
            return strcasecmp( $b->title, $a->title );
        }

        /**
         * usort() custom function, sort by title ascending
         *
         * @param $a
         * @param $b
         *
         * @return int
         */
        protected function compare_by_title_asc( $a, $b ) {
            return strcasecmp( $a->title, $b->title );
        }


        /**
         * Builds the query from the parts
         *
         * @param $parts
         * @param bool $is_multi tells if all the parts (like and relevance) are passed at once
         *
         * @return string query
         */
        protected function build_query( $parts, $is_multi = false ) {

            $args = &$this->args;

            $l_parts = array(); // like parts
            $r_parts = array(); // relevance parts

            if ( $is_multi == true ) {
                foreach ( $parts as $part ) {
                    $l_parts = array_merge( $l_parts, $part[0] );
                    $r_parts = array_merge( $r_parts, $part[1] );
                }
            } else if ( count($parts) > 0 ) {
                $l_parts = $parts[0];
                $r_parts = $parts[1];
            }

            /*------------------------- Build like --------------------------*/
            $like_query = implode( ' OR ', $l_parts );
            if ( $like_query == "" ) {
                $like_query = "(1)";
            } else {
                $like_query = "($like_query)";
            }
            /*---------------------------------------------------------------*/

            /*---------------------- Build relevance ------------------------*/
            $relevance = implode( ' + ', $r_parts );
            if ( $args['_post_use_relevance'] != 1 || $relevance == "" ) {
                $relevance = "(1)";
            } else {
                $relevance = "($relevance)";
            }
            /*---------------------------------------------------------------*/

            if ( $this->limit_start != 0 )
                $limit = $this->limit_start . ", ".$this->remaining_limit;
            else
                $limit = $this->remaining_limit;

            return str_replace(
                array( "{relevance_query}", "{like_query}", "{remaining_limit}" ),
                array( $relevance, $like_query, $limit ),
                $this->query
            );

        }

        /**
         * Post-processes the results
         *
         * @return array of results
         */
        protected function post_process() {

            $pageposts  = is_array( $this->results ) ? $this->results : array();
            $s          = $this->s;
            $_s         = $this->_s;
            $args = $this->args;

            do_action("asp_start_post_processing");

            // No post processing is needed on non-ajax search or if the search data param is missing
            if ( !$args['_ajax_search'] || !isset($args['_sd']) || $args['_no_post_process'] ) {
                $this->results = $pageposts;
                return $pageposts;
            }

            $sd = $args['_sd'];
            $searchId = $args['_sid'];
            $com_options = wd_asp()->o['asp_compatibility'];

            foreach ( $pageposts as $k => $v ) {
                $r          = &$pageposts[ $k ];
                $r->title   = w_isset_def( $r->title, null );
                $r->content = w_isset_def( $r->content, null );
                $r->image   = w_isset_def( $r->image, null );
                $r->author  = w_isset_def( $r->author, null );
                $r->date    = w_isset_def( $r->date, null );
            }

            /*--------------------- For Image Parser -----------------------*/
            // Do not select the content field, if it is not used at all
            $get_content = !(
                ( $sd['showdescription'] == 1 ) ||
                ( $sd['resultstype'] == "isotopic" && $sd['i_ifnoimage'] == 'description' ) ||
                ( $sd['resultstype'] == "polaroid" && ($sd['pifnoimage'] == 'descinstead' || $sd['pshowdesc'] == 1) )
            );

            // Do not select excerpt if its not used at all
            $get_excerpt = !(
                $sd['primary_titlefield'] == 1 ||
                $sd['secondary_titlefield'] == 1 ||
                $sd['primary_descriptionfield'] == 1 ||
                $sd['secondary_descriptionfield'] == 1
            );
            /*---------------------------------------------------------------*/

            // VC 4.6+ fix: Shortcodes are not loaded in ajax responses
            // class_exists() is mandatory, some PHP versions fail
            if ( class_exists("WPBMap") && method_exists("WPBMap", "addAllMappedShortcodes") )
                WPBMap::addAllMappedShortcodes();

            //remove the search shortcode properly
            add_shortcode( 'wpdreams_ajaxsearchpro', array( $this, 'return_empty_string' ) );

            aspDebug::start( '--searchContent-posptrocess' );

            /* Images, title, desc */
            foreach ( $pageposts as $k => $v ) {

                // Let's simplify things
                $r = &$pageposts[ $k ];

                if ( isset( $args['_switch_on_preprocess'] ) && is_multisite() ) {
                    switch_to_blog( $r->blogid );
                }

                $r          = apply_filters( 'asp_result_before_prostproc', $r, $searchId );
                $r->title   = apply_filters( 'asp_result_title_before_prostproc', $r->title, $r->id, $searchId );
                $r->content = apply_filters( 'asp_result_content_before_prostproc', $r->content, $r->id, $searchId );
                $r->image   = apply_filters( 'asp_result_image_before_prostproc', $r->image, $r->id, $searchId );
                $r->author  = apply_filters( 'asp_result_author_before_prostproc', $r->author, $r->id, $searchId );
                $r->date    = apply_filters( 'asp_result_date_before_prostproc', $r->date, $r->id, $searchId );

                // ---- URL FIX for WooCommerce product variations
                $wc_prod_var_o = null; // Reset for each loop
                if ( $r->post_type == 'product_variation' && class_exists( 'WC_Product_Variation' ) ) {
                    $wc_prod_var_o = wc_get_product( $r->id );
                    $r->link       = $wc_prod_var_o->get_permalink();
                } else {
                    $r->link = get_permalink( $v->id );
                }
                // Filter it though WPML
                if ( $args['_wpml_lang'] != '')
                    $r->link = apply_filters( 'wpml_permalink', $r->link, $args['_wpml_lang'] );

                $image_settings = $sd['image_options'];

                if ( $image_settings['show_images'] != 0 &&
                    '' !== ($im = $this->getBFIimage( $r, $get_content, $get_excerpt ))
                ) {
                    if ( $image_settings['image_cropping'] == 0 ) {
                        $r->image = $im;
                    } else {
                        if ( strpos( $im, "mshots/v1" ) === false ) {
                            $bfi_params = array( 'width'  => $image_settings['image_width'],
                                                 'height' => $image_settings['image_height'],
                                                 'crop'   => true
                            );
                            if ( w_isset_def( $image_settings['image_transparency'], 1 ) != 1 )
                                $bfi_params['color'] = wpdreams_rgb2hex( $image_settings['image_bg_color'] );

                            $r->image = bfi_thumb( $im, $bfi_params );
                        } else {
                            $r->image = $im;
                        }
                    }
                }

                // If no image and defined, remove the result here, to perevent JS confusions
                if ( empty($r->image) && $sd['resultstype'] == "isotopic" && $sd['i_ifnoimage'] == 'removeres' ) {
                    unset($pageposts[ $k ]);
                    continue;
                }
                /* Same for polaroid mode */
                if (empty($r->image) && isset($sd['resultstype']) &&
                    $sd['resultstype'] == 'polaroid' && $sd['pifnoimage'] == 'removeres') {
                    unset($pageposts[$k]);
                    continue;
                }

                $_t_keys = array('primary_titlefield', 'secondary_titlefield');

                foreach ($_t_keys as $tk) {
                    $sd[$tk] = $sd[$tk] . ''; // Convert for the switch statement
                    if ( $sd[$tk] == '-1' ) continue;

                    switch($sd[$tk]) {
                        case '0':
                            if ( isset($wc_prod_var_o) ) {
                                $r->title = $wc_prod_var_o->get_title();
                            } else {
                                $r->title = get_the_title($r->id);
                            }
                            break;
                        case '1':
                            if ( ASP_mb::strlen( $r->excerpt ) >= 200 ) {
                                $r->title = wd_substr_at_word( $r->excerpt, 200 );
                            } else {
                                $r->title = $r->excerpt;
                            }
                            break;
                        case 'c__f':
                            if ( $sd[$tk.'_cf'] == '' ) {
                                $r->title = get_the_title( $r->id );
                            } else {
                                $field_val = ASP_Helpers::getCFValue($sd[$tk.'_cf'], $r, $com_options['use_acf_getfield'], $args);
                                if ( $field_val != '' ) {
                                    $r->title = $field_val;
                                } else {
                                    if ( isset($wc_prod_var_o) ) {
                                        $r->title = $wc_prod_var_o->get_title();
                                    } else {
                                        $r->title = get_the_title($r->id);
                                    }
                                }
                            }
                            break;
                        default:
                            if ( isset($wc_prod_var_o) ) {
                                $r->title = $wc_prod_var_o->get_title();
                            } else {
                                $r->title = get_the_title($r->id);
                            }
                    }

                    if ($r->title != "") break;
                }

                if ( !empty($sd['advtitlefield']) )
                    $r->title = $this->adv_field(
                        array(
                            'main_field_slug' => 'titlefield',
                            'main_field_value'=> $r->title,
                            'r' => $r,
                            'field_pattern' => stripslashes( $sd['advtitlefield'] )
                        ),
                        $com_options['use_acf_getfield']
                    );

                if ( ! isset( $sd['striptagsexclude'] ) ) {
                    $sd['striptagsexclude'] = "<a><span>";
                }

                $_t_keys = array('primary_descriptionfield', 'secondary_descriptionfield');

                foreach ($_t_keys as $tk) {
                    $sd[$tk] = $sd[$tk] . ''; // Convert for the switch statement
                    if ( $sd[$tk] == '-1' ) continue;

                    switch ($sd[$tk]) {
                        case '1':
                            if ( function_exists( 'qtranxf_use' ) && $args['_qtranslate_lang'] != "" ) {
                                $r->excerpt = qtranxf_use($args['_qtranslate_lang'], $r->excerpt, false);
                            }
                            $_content = strip_tags( $r->excerpt, $sd['striptagsexclude'] );
                            break;
                        case '2':
                            $_content = strip_tags( get_the_title( $r->id ), $sd['striptagsexclude'] );
                            break;
                        case 'c__f':
                            if ( $sd[$tk.'_cf'] == '' ) {
                                $_content = '';
                            } else {
                                $field_val = ASP_Helpers::getCFValue($sd[$tk.'_cf'], $r, $com_options['use_acf_getfield'], $args);
                                if ( $field_val != '' ) {
                                    $_content = strip_tags($field_val, $sd['striptagsexclude']);
                                } else {
                                    $_content = '';
                                }
                            }
                            break;
                        default: //including option '0', alias content
                            if ( function_exists( 'qtranxf_use' ) && $args['_qtranslate_lang'] != "" ) {
                                $r->content = qtranxf_use($args['_qtranslate_lang'], $r->content, false);
                            }
                            // For product variations, do something special
                            if ( isset($wc_prod_var_o) ) {
                                $r->content = $wc_prod_var_o->get_description();
                                if ( $r->content == '') {
                                    $_pprod = wc_get_product($wc_prod_var_o->get_parent_id());
                                    $r->content = $_pprod->get_description();
                                }
                            }
                            $_content = strip_tags( $r->content, $sd['striptagsexclude'] );
                            break;
                    }

                    // Deal with the shortcodes here, for more accuracy
                    if ( $sd['shortcode_op'] == "remove" ) {
                        if ( $_content != "" ) {
                            // Remove shortcodes, keep the content, really fast and effective method
                            $_content = preg_replace("~(?:\[/?)[^\]]+/?\]~su", '', $_content);
                        }
                    } else {
                        if ( $_content != "" ) {
                            $_content = apply_filters( 'the_content', $_content, $searchId );
                        }
                    }

                    if ( $_content != '') break;
                }

                // Remove styles and scripts
                $_content = preg_replace( array(
                    '#<script(.*?)>(.*?)</script>#is',
                    '#<style(.*?)>(.*?)</style>#is'
                ), '', $_content );

                $_content = strip_tags( $_content, $sd['striptagsexclude'] );

                // Get the words from around the search phrase, or just the description
                if ( $sd['description_context'] == 1 && count( $_s ) > 0 && $s != '') {
                    // Try for an exact match
                    $_ex_content = $this->context_find(
                        $_content, $s,
                        floor($sd['descriptionlength'] / 6),
                        $sd['descriptionlength'],
                        $sd['description_context_depth'],
                        true
                    );
                    if ( $_ex_content === false ) {
                        // No exact match, go with the first keyword
                        $_content = $this->context_find(
                            $_content, $_s[0],
                            floor($sd['descriptionlength'] / 6),
                            $sd['descriptionlength'],
                            $sd['description_context_depth']
                        );
                    } else {
                        $_content = $_ex_content;
                    }
                } else if ( $_content != '' && (  ASP_mb::strlen( $_content ) > $sd['descriptionlength'] ) ) {
                    $_content = wd_substr_at_word($_content, $sd['descriptionlength']) . "...";
                }

                $_content   = wd_closetags( $_content );

                if ( !empty($sd['advtitlefield']) )
                    $r->content = $this->adv_field(
                        array(
                            'main_field_slug' => 'descriptionfield',
                            'main_field_value'=> $_content,
                            'r' => $r,
                            'field_pattern' => stripslashes( $sd['advdescriptionfield'] )
                        ),
                        $com_options['use_acf_getfield']
                    );

                // --------------------------------- DATE -----------------------------------
                if ($sd["showdate"] == 1) {
                    $post_time = strtotime($r->date);

                    if ( $sd['custom_date'] == 1) {
                        $date_format = w_isset_def($sd['custom_date_format'], "Y-m-d H:i:s");
                    } else {
                        $date_format = get_option('date_format', "Y-m-d") . " " . get_option('time_format', "H:i:s");
                    }

                    $r->date = @date_i18n($date_format, $post_time);
                }
                // --------------------------------------------------------------------------


                $r          = apply_filters( 'asp_result_after_prostproc', $r, $searchId );
                $r->title   = apply_filters( 'asp_result_title_after_prostproc', $r->title, $r->id, $searchId );
                $r->content = apply_filters( 'asp_result_content_after_prostproc', $r->content, $r->id, $searchId );
                $r->image   = apply_filters( 'asp_result_image_after_prostproc', $r->image, $r->id, $searchId );
                $r->author  = apply_filters( 'asp_result_author_after_prostproc', $r->author, $r->id, $searchId );
                $r->date    = apply_filters( 'asp_result_date_after_prostproc', $r->date, $r->id, $searchId );

            }
            aspDebug::stop( '--searchContent-posptrocess' );

            if ( isset( $args['_switch_on_preprocess'] ) && is_multisite() ) {
                restore_current_blog();
            }

            $this->results = $pageposts;

            return $pageposts;

        }

        /**
         * Fetches an image for bfi class
         */
        protected function getBFIimage( $post, $get_content = false, $get_excerpt = false ) {
            if ( ! isset( $post->image ) || $post->image == null ) {
                $args = $this->args;
                if ( !isset($args['_sd']['image_options']) )
                    return "";
                $image_settings = $args['_sd']['image_options'];

                if ( ! isset( $post->id ) ) {
                    return "";
                }
                $i  = 1;
                $im = "";
                for ( $i == 1; $i < 6; $i ++ ) {
                    switch ( $image_settings[ 'image_source' . $i ] ) {
                        case "featured":
                            if ( $image_settings['image_source_featured'] == "original" ) {
                                $im = wp_get_attachment_url(get_post_thumbnail_id($post->id));
                            } else {
                                $imx = wp_get_attachment_image_src(
                                    get_post_thumbnail_id($post->id), $image_settings['image_source_featured'], false
                                );
                                if ( $imx !== false && isset($imx[0]) )
                                    $im = $imx[0];
                            }
                            break;
                        case "content":
                            $content = $get_content ? get_post_field('post_content', $post->id) : $post->content;

                            if ( $image_settings['apply_content_filter'] == 1 )
                                $content = apply_filters('the_content', $content);

                            $im = wpdreams_get_image_from_content( $content, 0 );
                            break;
                        case "excerpt":
                            $excerpt = $get_excerpt ? get_post_field('post_excerpt', $post->id) : $post->excerpt;

                            $im = wpdreams_get_image_from_content( $excerpt, 0 );
                            break;
                        case "screenshot":
                            $im = 'http://s.wordpress.com/mshots/v1/' . urlencode( get_permalink( $post->id ) ) .
                                '?w=' . $image_settings['image_width'] . '&h=' . $image_settings['image_height'];
                            break;
                        case "post_format":
                            $format = get_post_format( $post->id );

                            switch ($format) {
                                case "audio":
                                    $im = ASP_URL_NP . "img/post_format/audio.png";
                                    break;
                                case "video":
                                    $im = ASP_URL_NP . "img/post_format/video.png";
                                    break;
                                case "quote":
                                    $im = ASP_URL_NP . "img/post_format/quote.png";
                                    break;
                                case "image":
                                    $im = ASP_URL_NP . "img/post_format/image.png";
                                    break;
                                case "gallery":
                                    $im = ASP_URL_NP . "img/post_format/gallery.png";
                                    break;
                                case "link":
                                    $im = ASP_URL_NP . "img/post_format/link.png";
                                    break;
                                default:
                                    $im = ASP_URL_NP . "img/post_format/default.png";
                                    break;
                            }
                            break;
                        case "custom":
                            if ( $image_settings['image_custom_field'] != "" ) {
                                $val = get_post_meta( $post->id, $image_settings['image_custom_field'], true );
                                if ( $val != null && $val != "" ) {
                                    if ( is_numeric($val) ) {
                                        $im = wp_get_attachment_url( $val );
                                    } else {
                                        $im = $val;
                                    }
                                }
                            }
                            break;
                        case "default":
                            if ( $image_settings['image_default'] != "" ) {
                                $im = $image_settings['image_default'];
                            }
                            break;
                        default:
                            $im = "";
                            break;
                    }
                    if ( $im != null && $im != '' ) {
                        break;
                    }
                }
                if ( !is_wp_error($im) )
                    return $im;
                return '';
            } else {
                return $post->image;
            }
        }


        /**
         * Generates the final field, based on the advanced field pattern
         *
         * @uses ASP_Helpers::getCFValue()
         *
         * @param array     $f_args             Field related arguments
         * @param boolean   $use_acf            If true, uses ACF get_field() function to get the meta
         * @param boolean   $empty_on_missing   If true, returns an empty string if any of the fields is empty.
         *
         * @return string Final post title
         */
        protected function adv_field( $f_args, $use_acf = false, $empty_on_missing = false ) {
            $args = &$this->args;

            $f_args = wp_parse_args($f_args, array(
                'main_field_slug' => 'titlefield',  // The 'slug', aka the original field name
                'main_field_value'=> '',            // The default field value
                'r' => null,                        // Result object
                'field_pattern' => '{titlefield}'   // The field pattern
            ));
            $_f_args = $f_args;

            if ( $f_args['field_pattern'] == '' ) {
                return $f_args['field_value'];
            }
            $field_pattern = $f_args['field_pattern']; // Lets not make changes to arguments, shall we.

            // Find conditional patterns, like [prefix {field} suffix}
            preg_match_all( "/(\[.*?\])/", $field_pattern, $matches );
            if ( isset( $matches[0] ) && isset( $matches[1] ) && is_array( $matches[1] ) ) {
                foreach ( $matches[1] as $fieldset ) {
                    // Pass on each section to this function again, the code will never get here
                    $_f_args['field_pattern'] = str_replace(array('[', ']'), '', $fieldset);
                    $processed_fieldset = $this->adv_field(
                        $_f_args,
                        $use_acf,
                        true
                    );
                    // Replace the original with the processed version, first occurrence, in case of duplicates
                    $field_pattern = ASP_Helpers::replaceFirst($fieldset, $processed_fieldset, $field_pattern);
                }
            }

            preg_match_all( "/{(.*?)}/", $field_pattern, $matches );
            if ( isset( $matches[0] ) && isset( $matches[1] ) && is_array( $matches[1] ) ) {
                foreach ( $matches[1] as $field ) {
                    if ( $field == $f_args['main_field_slug'] ) {
                        $field_pattern = str_replace( '{'.$f_args['main_field_slug'].'}', $f_args['main_field_value'], $field_pattern );
                    } else {
                        $val        = ASP_Helpers::getCFValue($field, $f_args['r'], $use_acf, $args);
                        // For the recursive call to break, if any of the fields is empty
                        if ( $empty_on_missing && $val == '')
                            return '';
                        $field_pattern = str_replace( '{' . $field . '}', $val, $field_pattern );
                    }
                }
            }

            return $field_pattern;
        }

        /**
         * An empty function to override individual shortcodes, this must be public
         *
         * @return string
         */
        public function return_empty_string() {
            return "";
        }
    }
}