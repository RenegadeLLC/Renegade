<?php
if (!defined('ABSPATH')) die('-1');

if (!class_exists("ASP_Helpers")) {
    /**
     * Class ASP_Helpers
     *
     * Compatibility and other helper functions for data translations
     *
     * @class         ASP_Helpers
     * @version       1.0
     * @package       AjaxSearchPro/Classes/Etc
     * @category      Class
     * @author        Ernest Marcinko
     */
    class ASP_Helpers {

        /**
         * Performs a safe sanitation and escape for strings and numeric values in LIKE type queries.
         * This is not to be used on whole queries, only values.
         *
         * @uses wd_mysql_escape_mimic()
         * @param $string
         * @return array|mixed
         */
        public static function escape( $string ) {

            // recursively go through if it is an array
            if ( is_array($string) ) {
                foreach ($string as $k => $v) {
                    $string[$k] = self::escape($v);
                }
                return $string;
            }

            if ( is_float( $string ) )
                return $string + 0;

            if ( function_exists( 'esc_sql' ) )
                return esc_sql( $string );

            // Okay, what? Not one function is present, use the one we have
            return wd_mysql_escape_mimic($string);
        }

        /**
         * Checks if the given date matches the pattern
         *
         * @param $date
         * @return bool
         */
        public static function check_date( $date ) {
            if ( ASP_mb::strlen( $date ) != 10 ) return false;

            return preg_match('/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}\z/', $date);
        }

        /**
         * Converts a string to number, array of strings to array of numbers
         *
         * Since esc_like() does not escape numeric values, casting them is the easiest way to go
         *
         * @param $number string or array of strings
         * @return mixed number or array of numbers
         */
        public static function force_numeric ( $number ) {
            if ( is_array($number) ) {
                foreach ($number as $k => $v) {
                    $number[$k] = self::force_numeric($v);
                }
                return $number;
            } else {
                // Replace any non-numeric and decimal point character
                $number = preg_replace("/[^0-9\.]+/", "", $number);
                $number = $number + 0;
            }

            return $number;
        }

        /**
         * Generates a string reverse, support multibite strings, plus fallback if mbstring not avail
         *
         * @param $string
         * @return string
         */
        public static function reverseString ( $string ) {

            /*
             * Not sure if using extension_loaded(...) is enough.
             */
            if (
                function_exists('mb_detect_encoding') &&
                function_exists('mb_strlen') &&
                function_exists('mb_substr')
            ) {
                // Using mbstring
                $encoding = mb_detect_encoding($string);
                $length   = mb_strlen($string, $encoding);
                $reversed = '';
                while ($length-- > 0) {
                    $reversed .= mb_substr($string, $length, 1, $encoding);
                }

                return $reversed;

            } else {
                // Good old regex method, still supporting fully UFT8
                preg_match_all('/./us', $string, $ar);
                return implode(array_reverse($ar[0]));
            }

        }

        /**
         * Clears and trims a search phrase from extra slashes and extra space characters
         *
         * @param $s
         * @return mixed
         */
        public static function clear_phrase($s) {
            return preg_replace( '/\s+/', ' ', trim(stripcslashes($s)) );
        }


        /**
         * Removes given tags and it's contents from a text
         *
         * @param string|array $text
         * @param array $tags
         * @return string
         */
        public static function stripTagsWithContent($text, $tags = array()) {
            if ( !is_array($tags) ) {
                $tags = str_replace(',', ' ', $tags);
                $tags = preg_replace('/\s+/', ' ',$tags);
                $tags = explode(' ', $tags);
            }
            foreach ($tags as $tag) {
                $text = preg_replace("/<\\/?" . $tag . "(.|\\s)*?>/", '', $text);
            }
            return $text;
        }

        /**
         * Calculates the weeks passed between two dates
         *
         * @param $date1
         * @param $date2
         * @return int
         */
        public static function datediffInWeeks($date1, $date2) {
            if ( !class_exists('DateTime') )
                return 0;
            if( $date1 > $date2 )
                return datediffInWeeks($date2, $date1);

            $first = DateTime::createFromFormat('m/d/Y', $date1);
            $second = DateTime::createFromFormat('m/d/Y', $date2);

            return floor($first->diff($second)->days/7);
        }

        /**
         * Replaces the first occurrence of the $find string with $replace within the $subject.
         *
         * @since 4.11
         *
         * @param string $find
         * @param string $replace
         * @param string $subject
         * @return string
         */
        public static function replaceFirst($find, $replace, $subject) {
            // From the comments at PHP.net/str_replace
            // Splits $subject into an array of 2 items by $find,
            // and then joins the array with $replace
            return implode($replace, explode($find, $subject, 2));
        }

        public static function resolveBracketSyntax( $content, $fields = array(), $empty_on_missing = false ) {

            if ( empty($fields) )
                return $content;

            // Find conditional patterns, like [prefix {field} suffix]
            preg_match_all( "/(\[.*?\])/", $content, $matches );
            if ( isset( $matches[0] ) && isset( $matches[1] ) && is_array( $matches[1] ) ) {
                foreach ( $matches[1] as $fieldset ) {
                    // Pass on each section to this function again, the code will never get here
                    $stripped_fieldset = str_replace(array('[', ']'), '', $fieldset);
                    $processed_content = ASP_Helpers::resolveBracketSyntax($stripped_fieldset, $fields, true);

                    // Replace the original with the processed version, first occurrence, in case of duplicates
                    $content = ASP_Helpers::replaceFirst($fieldset, $processed_content, $content);
                }
            }

            preg_match_all( "/{(.*?)}/", $content, $matches );
            if ( isset( $matches[0] ) && isset( $matches[1] ) && is_array( $matches[1] ) ) {
                foreach ( $matches[1] as $field ) {
                    $val = isset($fields[$field]) ? $fields[$field] : '';
                    // For the recursive call to break, if any of the fields is empty
                    if ( $empty_on_missing && $val == '')
                        return '';
                    $content = str_replace( '{' . $field . '}', $val, $content );
                }
            }

            return $content;
        }

        /**
         * Gets the custom user meta field value, supporting ACF get_field()
         *
         * @see get_field()                                     ACF post meta parsing.
         * @since 4.12
         *
         * @param string    $field      Custom field label
         * @param object    $r          Result object
         * @param bool      $use_acf    If true, will use the get_field() function from ACF
         * @return string
         */
        public static function getUserCFValue($field, $r, $use_acf = false) {
            $ret = '';

            if ( $use_acf && function_exists('get_field') ) {
                $mykey_values = get_field($field, 'user_'.$r->id, true);
                if (!is_null($mykey_values) && $mykey_values != '' && $mykey_values !== false ) {
                    if (is_array($mykey_values)) {
                        if (!is_object($mykey_values[0])) {
                            $ret = implode(', ', $mykey_values);
                        }
                    } else {
                        $ret = $mykey_values;
                    }
                }
            } else {
                $mykey_values = get_user_meta($r->id, $field);
                if (isset($mykey_values[0])) {
                    $ret = $mykey_values[0];
                }
            }

            return $ret;
        }

        /**
         * Gets the custom field value, supporting ACF get_field() and WooCommerce multi currency
         *
         * @see ASP_Helpers::woo_formattedPriceWithCurrency()   To get the currency formatted field.
         * @see get_field()                                     ACF post meta parsing.
         * @since 4.11
         *
         * @param string    $field      Custom field label
         * @param object    $r          Result object
         * @param bool      $use_acf    If true, will use the get_field() function from ACF
         * @param array     $args       Search arguments
         * @return string
         */
        public static function getCFValue($field, $r, $use_acf = false, $args = array()) {
            $ret = '';

            if ( in_array($field, array('_price', '_tax_price', '_sale_price', '_regular_price')) &&
                isset($r->post_type) &&
                in_array($r->post_type, array('product', 'product_variation')) &&
                function_exists('wc_get_product')
            ) { // Is this a WooCommerce price related field?
                $ret = ASP_Helpers::woo_formattedPriceWithCurrency($r->id, $field, $args);
            } else { // ..or just a regular field?
                if ( $use_acf && function_exists('get_field') ) {
                    $mykey_values = get_field($field, $r->id, true);
                    if (!is_null($mykey_values) && $mykey_values != '' && $mykey_values !== false ) {
                        if (is_array($mykey_values)) {
                            if (!is_object($mykey_values[0])) {
                                $ret = implode(', ', $mykey_values);
                            }
                        } else {
                            $ret = $mykey_values;
                        }
                    }
                } else {
                    $mykey_values = get_post_custom_values($field, $r->id);
                    if (isset($mykey_values[0])) {
                        $ret = $mykey_values[0];
                    }
                }
            }

            return $ret;
        }

        /**
         * Gets the WooCommerce formatted currency, supporting multiple currencies WPML, WCML
         *
         * @since 4.11
         * @see wc_get_product()    Getting the WooCommerce product.
         * @see $woocommerce_wpml->multi_currency->prices->get_product_price_in_currency() For multi currency parsing.
         * @see wc_price()          Price formatting.
         *
         * @param int       $id         Product or variation ID
         * @param string    $field      Field label
         * @param array     $args       Search arguments
         * @return string
         */
        public static function woo_formattedPriceWithCurrency($id, $field, $args) {
            global $woocommerce_wpml;
            global $sitepress;

            $currency = isset($args['woo_currency']) ?
                $args['woo_currency'] :
                (function_exists('get_woocommerce_currency') ?
                    get_woocommerce_currency() : '');

            $price = '';
            $p = wc_get_product( $id );

            // WCML Section, copied and modified from
            // ..\wp-content\plugins\wpml-woocommerce\inc\currencies\class-wcml-multi-currency-prices.php
            // line 139, function product_price_filter(..)
            if ( isset($sitepress, $woocommerce_wpml, $woocommerce_wpml->multi_currency) ) {
                $original_object_id = apply_filters( 'translate_object_id', $id, get_post_type($id), false, $sitepress->get_default_language() );
                $ccr = get_post_meta($original_object_id, '_custom_conversion_rate', true);

                if( in_array($field, array('_price', '_regular_price', '_sale_price')) && !empty($ccr) && isset($ccr[$field][$currency]) ){
                    $price_original = get_post_meta($original_object_id, $field, true);
                    $price = $price_original * $ccr[$field][$currency];
                } else {
                    $manual_prices = $woocommerce_wpml->multi_currency->custom_prices->get_product_custom_prices($id, $currency);
                    if($manual_prices && !empty($manual_prices[$field])){
                        $price = $manual_prices[$field];
                    } else {
                        // 2. automatic conversion
                        $price = get_post_meta($id, $field, true);
                        $price = apply_filters('wcml_raw_price_amount', $price, $currency );
                    }
                }

                if ( $price != '') {
                    $price = wc_price($price, array('currency' => $currency));
                }
            } else {
                // For variable products _regular_price, _sale_price are not defined
                // ..however are most likely used together. So in case of _regular_price display the range,
                // ..but do not deal with _sale_price at all
                if ( $p->is_type('variable') && !in_array($field, array('_sale_price')) ) {
                    $price = $p->get_price_html();
                } else {
                    switch ($field) {
                        case '_regular_price':
                            $price = $p->get_regular_price();
                            break;
                        case '_sale_price':
                            $price = $p->get_sale_price();
                            break;
                        case '_tax_price':
                            $price = $p->get_price_including_tax();
                            break;
                        default:
                            $price = $p->get_price();
                            break;
                    }
                    if ( $price != '' ) {
                        if ($currency != '')
                            $price = wc_price($price, array('currency' => $currency));
                        else
                            $price = wc_price($price);
                    }
                }
            }

            return $price;
        }

        /**
         * Converts the results array to HTML code
         *
         * Since ASP 4.0 the results are returned as plain HTML codes instead of JSON
         * to allow templating. This function includes the needed template files
         * to generate the correct HTML code. Supports grouping.
         *
         * @since 4.0
         * @param $results
         * @param $s_options
         * @param $phrase
         * @return string
         */
        public static function generateHTMLResults($results, $s_options, $id, $phrase = '') {
            $html = "";
            $theme = $s_options['resultstype'];
            $theme_path = get_stylesheet_directory() . "/asp/";

            $phrase = strip_tags( ASP_Helpers::escape( ASP_Helpers::clear_phrase($phrase) ) );

            $comp_settings = wd_asp()->o['asp_compatibility'];
            $load_lazy = w_isset_def($comp_settings['load_lazy_js'], 0);

            if (empty($results) || !empty($results['nores'])) {
                if (!empty($results['keywords'])) {
                    $s_keywords = $results['keywords'];
                    // Get the keyword suggestions template
                    ob_start();
                    if ( file_exists( $theme_path . "keyword-suggestions.php" ) )
                        include( $theme_path . "keyword-suggestions.php" );
                    else
                        include( ASP_INCLUDES_PATH . "views/results/keyword-suggestions.php" );
                    $html .= ob_get_clean();
                } else {
                    // No results at all.
                    ob_start();
                    if ( file_exists( $theme_path . "no-results.php" ) )
                        include( $theme_path . "no-results.php" );
                    else
                        include( ASP_INCLUDES_PATH . "views/results/no-results.php" );
                    $html .= ob_get_clean();
                }
            } else {
                if (isset($results['grouped'])) {
                    foreach($results['groups'] as $k=>$g) {
                        $group_name = $g['title'];

                        // Get the group headers
                        ob_start();
                        if ( file_exists( $theme_path . "group-header.php" ) )
                            include( $theme_path . "group-header.php" );
                        else
                            include(ASP_INCLUDES_PATH . "views/results/group-header.php");
                        $html .= ob_get_clean();

                        // Get the item HTML
                        foreach($g['items'] as $kk=>$r) {
                            $asp_res_css_class = ' asp_r_' . $r->content_type . ' asp_r_' . $r->content_type . '_' .$r->id;
                            if ( isset($r->post_type) ) {
                                $asp_res_css_class .= ' asp_r_' . $r->post_type;
                            } else if ( isset($r->taxonomy) ) {
                                $asp_res_css_class .= ' asp_r_' . $r->taxonomy;
                            }
                            ob_start();
                            if ( file_exists( $theme_path . $theme . ".php" ) )
                                include( $theme_path . $theme . ".php" );
                            else
                                include( ASP_INCLUDES_PATH . "views/results/" . $theme . ".php" );
                            $html .= ob_get_clean();
                        }

                        // Display no results in group where no items are present
                        if ( empty($g['items']) ) {
                            ob_start();
                            if ( file_exists( $theme_path . "no-results.php" ) )
                                include( $theme_path . "no-results.php" );
                            else
                                include( ASP_INCLUDES_PATH . "views/results/no-results.php" );
                            $html .= ob_get_clean();
                        }

                        // Get the group footers
                        ob_start();
                        if ( file_exists( $theme_path . "group-footer.php" ) )
                            include( $theme_path . "group-footer.php" );
                        else
                            include( ASP_INCLUDES_PATH . "views/results/group-footer.php" );
                        $html .= ob_get_clean();
                    }
                } else {
                    // Get the item HTML
                    foreach($results as $k=>$r) {
                        $asp_res_css_class = ' asp_r_' . $r->content_type . ' asp_r_' . $r->content_type . '_' .$r->id;
                        if ( isset($r->post_type) ) {
                            $asp_res_css_class .= ' asp_r_' . $r->post_type;
                        } else if ( isset($r->taxonomy) ) {
                            $asp_res_css_class .= ' asp_r_' . $r->taxonomy;
                        }
                        ob_start();
                        if ( file_exists( $theme_path . $theme . ".php" ) )
                            include( $theme_path . $theme . ".php" );
                        else
                            include(ASP_INCLUDES_PATH . "views/results/" . $theme . ".php");
                        $html .= ob_get_clean();
                    }
                }
            }
            return preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $html);
        }

        /**
         * Translates search data and $_POST options to query arguments to use with ASP_Query
         *
         * @param $search_id
         * @param $o
         * @return mixed
         */
        public static function toQueryArgs($search_id, $o) {
            // When $o is (bool)false, then this is called individually

            // Always return an emtpy array if something goes wrong
            if ( !wd_asp()->instances->exists($search_id) )
                return array();

            $search = wd_asp()->instances->get($search_id);
            $sd = $search['data'];
            // See if we post the preview data through
            if ( !empty($_POST['asp_preview_options']) && (current_user_can("manage_options") || ASP_DEMO) ) {
                if ( is_array($_POST['asp_preview_options']) )
                    $sd = array_merge($sd, $_POST['asp_preview_options']);
                else
                    $sd = array_merge($sd, unserialize(base64_decode($_POST['asp_preview_options'])));
            }

            $args = ASP_Query::$defaults;
            $comp_options = wd_asp()->o['asp_compatibility'];
            $it_options = wd_asp()->o['asp_it_options'];

            $exclude_post_ids = array_unique(array_merge(
                $sd['exclude_cpt']['ids'],
                explode(',', str_replace(' ', '', $sd['excludeposts']))
            ));
            foreach ( $exclude_post_ids as $k=>$v)
                if ( $v == '' )
                    unset($exclude_post_ids[$k]);


            // ----------------------------------------------------------------
            // 1. CPT + INDEXTABLE (class-asp-search-cpt.php, class-asp-search-indextable.php)
            // ----------------------------------------------------------------
            $args = array_merge($args, array(
                "_sd"                   => $sd, // Search Data
                '_sid'                  => $search_id,
                "keyword_logic"         => $sd['keyword_logic'],
                'secondary_logic'       => $sd['secondary_kw_logic'],
                'engine'                => $sd['search_engine'],
                "post_not_in"           => $exclude_post_ids,
                "post_primary_order"    => $sd['orderby_primary'],
                "post_secondary_order"  => $sd['orderby'],
                '_post_meta_allow_null' => $sd['cf_allow_null'],
                '_post_meta_logic'      => $sd['cf_logic'],
                '_post_use_relevance'   => $sd['userelevance'],
                '_db_force_case'        => $comp_options['db_force_case'],
                '_db_force_utf8_like'   => $comp_options['db_force_utf8_like'],
                '_db_force_unicode'     => $comp_options['db_force_unicode'],
                '_post_allow_empty_tax_term' => $sd["frontend_terms_empty"],
                '_taxonomy_group_logic' =>  $sd['taxonomy_logic'],

                // LIMITS
                'posts_limit' => $sd['posts_limit'],
                'posts_limit_override' => $sd['posts_limit_override'],
                'posts_limit_distribute' => $sd['posts_limit_distribute'],
                'taxonomies_limit'  => $sd['taxonomies_limit'],
                'taxonomies_limit_override' => $sd['taxonomies_limit_override'],
                'users_limit' => $sd['users_limit'],
                'users_limit_override' => $sd['users_limit_override'],
                'blogs_limit' => $sd['blogs_limit'],
                'blogs_limit_override' => $sd['blogs_limit_override'],
                'buddypress_limit' => $sd['buddypress_limit'],
                'buddypress_limit_override' => $sd['buddypress_limit_override'],
                'comments_limit' => $sd['comments_limit'],
                'comments_limit_override' => $sd['comments_limit_override'],
                'attachments_limit' => $sd['attachments_limit'],
                'attachments_limit_override' => $sd['attachments_limit_override']
            ));
            $args["_qtranslate_lang"] = isset($o['qtranslate_lang'])?$o['qtranslate_lang']:"";
            $args["_polylang_lang"] = $sd['polylang_compatibility'] == 1 && isset($o['polylang_lang']) ? $o['polylang_lang'] : "";

            $args["_exact_matches"] = isset($o['asp_gen']) && is_array($o['asp_gen']) && in_array('exact', $o['asp_gen']) ? 1 : 0;
            $args["_exact_match_location"] = $sd['exact_match_location'];

            // Is the secondary logic allowed on exact matching?
            if ( $args["_exact_matches"] == 1 && $sd['exact_m_secondary'] == 0 )
                $args['secondary_logic'] = 'none';

            // Minimal word length to be a keyword
            $args["min_word_length"] = $sd['min_word_length'];

            /*----------------------- Meta key order ------------------------*/
            if ( strpos($sd['orderby_primary'], 'customfp') !== false ) {
                if ( !empty($sd['orderby_primary_cf']) ) {
                    $args['_post_primary_order_metakey'] = $sd['orderby_primary_cf'];
                    $args['post_primary_order_metatype'] = $sd['orderby_primary_cf_type'];
                }
            }
            if ( strpos($sd['orderby'], 'customfs') !== false ) {
                if ( !empty($sd['orderby_secondary_cf']) ) {
                    $args['_post_secondary_order_metakey'] = $sd['orderby_secondary_cf'];
                    $args['post_secondary_order_metatype'] = $sd['orderby_secondary_cf_type'];
                }
            }

            /*----------------------- Auto populate -------------------------*/
            if ( isset($o['force_count']) ) {
                // Set the advanced limit parameter to be distributed later
                $args['limit'] = $o['force_count'] + 0;
                $args['force_count'] = $o['force_count'] + 0;
            }
            if ( isset($o['force_order']) ) {
                if ( $o['force_order'] == 1 ) {
                    $args["post_primary_order"] = "post_date DESC";
                    $args['force_order'] = 1;
                } else if ( $o['force_order'] == 2 ) {
                    $args["post_primary_order"] = "RAND()";
                    $args['force_order'] = 2;
                }
            }

            /*------------------------- Statuses ----------------------------*/
            $args['post_status'] = explode(',', str_replace(' ', '', $sd['post_status']));

            /*----------------------- Gather Types --------------------------*/
            $args['post_type'] = array();
            if ($o === false) {
                if ( in_array('page', $sd['customtypes']) ) {
                    if ( count($sd['exclude_cpt']['parent_ids']) > 0 )
                        $args['_exclude_page_parent_child'] = implode(',', $sd['exclude_cpt']['parent_ids']);
                }
                if ( isset( $sd['customtypes'] ) && count( $sd['customtypes'] ) > 0 )
                    $args['post_type'] = array_merge( $args['post_type'], $sd['customtypes'] );
            } else {
                if ( isset( $o['customset'] ) && count( $o['customset'] ) > 0 )
                    $args['post_type'] = array_merge( $args['post_type'], $o['customset'] );
                foreach ( $args['post_type'] as $kk => $vv) {
                    if ( $vv == "page" && count($sd['exclude_cpt']['parent_ids']) > 0 ) {
                        $args['_exclude_page_parent_child'] = implode(',', $sd['exclude_cpt']['parent_ids']);
                        //unset($args['post_type'][$kk]);
                        break;
                    }
                }
            }

            /*--------------------- GENERAL FIELDS --------------------------*/
            $args['search_type'] = array();
            $args['post_fields'] = array();
            if ($sd['searchinterms'] == 1)
                $args['post_fields'][] = "terms";
            if ($o === false) {
                if ( $sd['searchintitle'] = 1 ) $args['post_fields'][] = 'title';
                if ( $sd['searchincontent'] = 1 ) $args['post_fields'][] = 'content';
                if ( $sd['searchinexcerpt'] = 1 ) $args['post_fields'][] = 'excerpt';
            } else {
                if ( isset($o['asp_gen']) && is_array($o['asp_gen']) ) {
                    if (in_array('title', $o['asp_gen'])) $args['post_fields'][] = 'title';
                    if (in_array('content', $o['asp_gen'])) $args['post_fields'][] = 'content';
                    if (in_array('excerpt', $o['asp_gen'])) $args['post_fields'][] = 'excerpt';
                }
            }
            if ( $sd['search_in_ids'] ) $args['post_fields'][] = "ids";
            if ( $sd['search_in_permalinks'] ) $args['post_fields'][] = "permalink";

            /*--------------------- CUSTOM FIELDS ---------------------------*/
            $args['post_custom_fields_all'] = $sd['search_all_cf'];
            $args['post_custom_fields'] = isset($sd['selected-customfields']) ? $sd['selected-customfields'] : array();

            if ( count($args['post_fields']) > 0 ||
                $args['post_custom_fields_all'] == 1 ||
                count($args['post_custom_fields']) > 0
            )
                $args['search_type'][] = "cpt";

            // Are there any additional tags?
            if (
                count(wd_asp()->o['asp_glob']['additional_tag_posts']) > 0 &&
                !in_array('_asp_additional_tags', $args['post_custom_fields'])
            ) {
                $args['post_custom_fields'][] = '_asp_additional_tags';
            }

            /*-------------------------- WPML -------------------------------*/
            if ( $sd['wpml_compatibility'] == 1 )
                if ( isset( $o['wpml_lang'] ) )
                    $args['_wpml_lang'] = $o['wpml_lang'];
                elseif (defined('ICL_LANGUAGE_CODE')
                    && ICL_LANGUAGE_CODE != ''
                    && defined('ICL_SITEPRESS_VERSION')
                )
                    $args['_wpml_lang'] = ICL_LANGUAGE_CODE;

            /*-------------------- Content, Excerpt -------------------------*/
            $args['_post_get_content'] = (
                ( $sd['showdescription'] == 1 ) ||
                ( $sd['resultstype'] == "isotopic" && $sd['i_ifnoimage'] == 'description' ) ||
                ( $sd['resultstype'] == "polaroid" && ($sd['pifnoimage'] == 'descinstead' || $sd['pshowdesc'] == 1) )
            );
            $args['_post_get_excerpt'] = (
                $sd['primary_titlefield'] == 1 ||
                $sd['secondary_titlefield'] == 1 ||
                $sd['primary_descriptionfield'] == 1 ||
                $sd['secondary_descriptionfield'] == 1
            );

            /*---------------------- Taxonomy Terms -------------------------*/
            $args['post_tax_filter'] = self::toQueryArgs_Taxonomies($sd, $o);

            /*--------------------------- Tags ------------------------------*/
            self::toQueryArgs_Tags($sd, $o, $args);

            /*----------------------- Custom Fields -------------------------*/
            $args['post_meta_filter'] = self::toQueryArgs_Custom_Fields($sd, $o);

            /*----------------------- Date Filters --------------------------*/
            $args['post_date_filter'] = self::toQueryArgs_Dates($sd, $o);

            /*----------------------- User Filters --------------------------*/
            if ( count($sd['exclude_content_by_users']['users']) ) {
                foreach ($sd['exclude_content_by_users']['users'] as $uk => $uv) {
                    if ( $uv == -2 )
                        $sd['exclude_content_by_users']['users'][$uk] = get_current_user_id();
                }
                $args['post_user_filter'][$sd['exclude_content_by_users']['op_type']] = $sd['exclude_content_by_users']['users'];
            }

                /*---------------------- Selected blogs -------------------------*/
            $args['_selected_blogs'] = w_isset_def($sd['selected-blogs'], array(0 => get_current_blog_id()));
            if ($args['_selected_blogs'] === "all") {
                if (is_multisite())
                    $args['_selected_blogs'] = wpdreams_get_blog_list(0, "all", true);
                else
                    $args['_selected_blogs'] = array(0 => get_current_blog_id());
            }
            if (count($args['_selected_blogs']) <= 0) {
                $args['_selected_blogs'] = array(0 => get_current_blog_id());
            }

            // ----------------------------------------------------------------
            // 2. ATTACHMENTS (class-asp-search-attachments.php)
            // ----------------------------------------------------------------
            if ( $sd['return_attachments'] == 1 )
                $args['search_type'][] = "attachments";
            /*-------------------- Allowed mime types -----------------------*/
            if ( $sd['attachment_mime_types'] != "") {
                $args['attachment_mime_types'] = explode(",", base64_decode($sd['attachment_mime_types']));
                foreach ($args['attachment_mime_types'] as $k => $v) {
                    $args['attachment_mime_types'][$k] = trim($v);
                }

            }
            /*------------------------ Exclusions ---------------------------*/

            if ( $sd['attachment_exclude'] != '') {
                $args['attachment_exclude'] = explode(',', str_replace(' ', '', $sd['attachment_exclude']));
            }

            $args['attachments_use_index'] = $sd['attachments_use_index'] == 'index';
            $args['attachments_search_terms'] = $sd['search_attachments_terms'] == 1;
            $args['attachments_search_title'] = $sd['search_attachments_title'] == 1;
            $args['attachments_search_content'] = $sd['search_attachments_content'] == 1;
            $args['attachments_search_caption'] = $sd['search_attachments_caption'] == 1;
            $args['attachments_search_ids'] = $sd['search_attachments_ids'] == 1;
            $args['attachments_cf_filters'] = $sd['search_attachments_cf_filters'] == 1;
            $args['attachment_use_image'] = $sd['attachment_use_image'] == 1;

            // ----------------------------------------------------------------
            // 3. BLOGS
            // ----------------------------------------------------------------
            if ( $sd['searchinblogtitles'] == 1 )
                $args['search_type'][] = "blogs";

            // ----------------------------------------------------------------
            // 4. BUDDYPRESS
            // ----------------------------------------------------------------
            $args['bp_groups_search'] = $sd['search_in_bp_groups'] == 1;
            $args['bp_groups_search_public'] = $sd['search_in_bp_groups_public'] == 1;
            $args['bp_groups_search_private'] = $sd['search_in_bp_groups_private'] == 1;
            $args['bp_groups_search_hidden'] = $sd['search_in_bp_groups_hidden'] == 1;
            $args['bp_activities_search'] = $sd['search_in_bp_activities'] == 1;
            if ($args['bp_groups_search'] || $sd['search_in_bp_activities'])
                $args['search_type'][] = "buddypress";

            // ----------------------------------------------------------------
            // 5. COMMENTS
            // ----------------------------------------------------------------
            if ( isset($o['asp_gen']) && is_array($o['asp_gen']) && in_array('comments', $o['asp_gen']) ) {
                $args['search_type'][] = "comments";
                $args['comments_search'] = true;
            }

            // ----------------------------------------------------------------
            // 6. TAXONOMY TERMS
            // ----------------------------------------------------------------
            $args['taxonomy_include'] = array();

            if ( $sd['return_categories'] == 1 ) $args['taxonomy_include'][] = "category";
	        if ( $sd['return_tags'] == 1 ) $args['taxonomy_include'][] = "post_tag";
            if ( count(w_isset_def($sd['selected-return_terms'], array())) > 0 )
                $args['taxonomy_include'] = array_merge($args['taxonomy_include'], $sd['selected-return_terms']);
            $args['taxonomy_terms_exclude'] = $sd['return_terms_exclude'];     // terms to exclude by ID
            if ( count($args['taxonomy_include']) > 0 )
                $args['search_type'][] = "taxonomies";
            $args['taxonomy_terms_search_description'] = $sd['search_term_descriptions'] == 1;

            // ----------------------------------------------------------------
            // 7. USERS results
            // ----------------------------------------------------------------
            if ( $sd['user_search'] == 1 )
                $args['search_type'][] = "users";
            $args['user_login_search'] = $sd['user_login_search'];
            $args['user_display_name_search'] = $sd['user_display_name_search'];
            $args['user_first_name_search'] = $sd['user_first_name_search'];
            $args['user_last_name_search'] = $sd['user_last_name_search'];
            $args['user_bio_search'] = $sd['user_bio_search'];
            $args['user_email_search'] = $sd['user_email_search'];
            $args['user_search_meta_fields'] = $sd['user_search_meta_fields'];
            $args['user_search_bp_fields'] = w_isset_def( $sd['selected-user_bp_fields'], array() );
            $args['user_search_exclude_roles'] = w_isset_def( $sd['selected-user_search_exclude_roles'], array() );
            if ( count($sd['user_search_exclude_users']['users']) ) {
                foreach ($sd['user_search_exclude_users']['users'] as $uk => $uv) {
                    if ( $uv == -2 )
                        $sd['user_search_exclude_users']['users'][$uk] = get_current_user_id();
                }
                $args['user_search_exclude'][$sd['user_search_exclude_users']['op_type']] = $sd['user_search_exclude_users']['users'];
            }
            // ----------------------------------------------------------------

            // ----------------------------------------------------------------
            // 8. Content Type filters
            // ---------------------------------------------------------------
            self::toQueryArgs_ContentTypes($sd, $o, $args);

            // ----------------------------------------------------------------
            // 9. INDEX TABLE SEARCH
            // ---------------------------------------------------------------
            if ( $it_options['it_pool_size_auto'] ) {
                $s_pool_s = asp_indexTable::suggestPoolSizes();
                $args['it_pool_size_one'] = $s_pool_s['one'];
                $args['it_pool_size_two'] = $s_pool_s['two'];
                $args['it_pool_size_three'] = $s_pool_s['three'];
                $args['it_pool_size_rest'] = $s_pool_s['rest'];
            } else {
                $args['it_pool_size_one'] = $it_options['it_pool_size_one'];
                $args['it_pool_size_two'] = $it_options['it_pool_size_two'];
                $args['it_pool_size_three'] = $it_options['it_pool_size_three'];
                $args['it_pool_size_rest'] = $it_options['it_pool_size_rest'];
            }

            // ----------------------------------------------------------------
            // X. MISC FIXES
            // ----------------------------------------------------------------
            $args['_show_more_results'] = $sd['showmoreresults'] == 1;
            $args["woo_currency"] = isset($o['woo_currency']) ? $o['woo_currency'] : ( function_exists('get_woocommerce_currency') ? get_woocommerce_currency() : '' );
            $args['_page_id'] = isset($o['current_page_id']) ? $o['current_page_id'] : $args['_page_id'];
            // Reset search type and post types for WooCommerce search results page
            if ( isset($_GET['post_type']) && $_GET['post_type'] == "product") {
                $args['search_type'] = array("cpt");
                $old_ptype = $args['post_type'];
                $args['post_type'] = array();
                if ( in_array("product", $old_ptype) ) {
                    $args['post_type'][] = "product";
                }
                if ( in_array("product_variation", $old_ptype) ) {
                    $args['post_type'][] = "product_variation";
                }
            }
            // ----------------------------------------------------------------
            return $args;
        }

        /**
         * Converts search data and options to Taxonomy Term query argument arrays to use with ASP_Query
         *
         * @param $sd
         * @param $o
         * @return array
         */
        private static function toQueryArgs_Taxonomies($sd, $o) {
            $ret = array();

            if ( ! isset( $o['termset'] ) || $o['termset'] == "" )
                $o['termset'] = array();

            $taxonomies = array();

            // Excluded by terms (advanced option -> exclude results)
            $sd_exclude = array();
            foreach($sd['exclude_by_terms']['terms'] as $t) {
                if ( !in_array($t['taxonomy'], $taxonomies) )
                    $taxonomies[] = $t['taxonomy'];

                if ( !isset($sd_exclude[$t['taxonomy']]) )
                    $sd_exclude[$t['taxonomy']] = array();
                if ($t['id'] == -1) {
                    $tt_terms = get_terms($t['taxonomy'], array(
                        'hide_empty' => false,
                        'fields' => 'ids'
                    ));
                    if ( !is_wp_error($tt_terms) ) {
                        $sd_exclude[$t['taxonomy']] = $tt_terms;
                    }
                } else {
                    $sd_exclude[$t['taxonomy']][] = $t['id'];
                }
            }

            // Include by terms (advanced option -> exclude results)
            $sd_include = array();
            foreach($sd['include_by_terms']['terms'] as $t) {
                if ( !in_array($t['taxonomy'], $taxonomies) )
                    $taxonomies[] = $t['taxonomy'];

                if ( !isset($sd_include[$t['taxonomy']]) )
                    $sd_include[$t['taxonomy']] = array();
                if ($t['id'] == -1) {
                    $tt_terms = get_terms($t['taxonomy'], array(
                        'hide_empty' => false,
                        'fields' => 'ids'
                    ));
                    if ( !is_wp_error($tt_terms) ) {
                        $sd_include[$t['taxonomy']] = $tt_terms;
                    }
                } else {
                    $sd_include[$t['taxonomy']][] = $t['id'];
                }
            }

            if ( count( $sd['show_terms']['terms'] ) > 0 ||
                count( $sd_exclude ) > 0 ||
                count( $sd_include ) > 0 ||
                count( $o['termset'] ) > 0
            ) {
                // If the term settings are invisible, ignore the excluded frontend terms, reset to empty array
                if ( $sd['showsearchintaxonomies'] == 0 ) {
                    $sd['show_terms']['terms'] = array();
                }

                // First task is to get any taxonomy related
                foreach ($sd['show_terms']['terms'] as $t)
                    if ( !in_array($t['taxonomy'], $taxonomies) )
                        $taxonomies[] = $t['taxonomy'];

                // Terms count to display on the front-end
                $front_end_terms_count = 0;
                if ( count($sd['show_terms']['terms']) > 0 ) {
                    $front_end_terms_count += count($sd['show_terms']['terms']);
                    $front_end_terms_count += count($sd['show_terms']['un_checked']);
                }

                foreach ($taxonomies as $taxonomy) {
                    // If no value is selected, transform it to an array
                    if ( isset($o['termset_single']) )
                        $option_set = $o['termset_single'];
                    else
                        $option_set = !isset($o['termset'][$taxonomy]) ? array() : $o['termset'][$taxonomy];

                    // If radio or drop is selected, convert it to array
                    $option_set =
                        !is_array( $option_set ) ? array( $option_set ) : $option_set;

                    if (
                        count($option_set) == 1 && in_array(-1, $option_set) // Is it the "Choose one" option?
                    ) {
                        continue;
                    }


                    // No point of taking this into account, as the user selects the terms, thus they must exsist
                    $no_terms_exist = false;

                    $term_logic = $sd['term_logic'];
                    $is_checkboxes = true;
                    // If not the checkboxes are used, and there is no forced inclusion, temporary force the OR logic
                    if ( count($sd['show_terms']['display_mode']) > 0 ) {
                        if ( $sd['show_terms']['separate_filter_boxes'] != 1 ) {
                            if ( isset($sd['show_terms']['display_mode']['all']) &&
                                $sd['show_terms']['display_mode']['all']['type'] != "checkboxes"
                            ) {
                                //$term_logic = "or";
                                $is_checkboxes = false;
                            }
                        } else if (isset($sd['show_terms']['display_mode'][$taxonomy])) {
                            if ( $sd['show_terms']['display_mode'][$taxonomy]['type'] != "checkboxes" ) {
                                //$term_logic = "or";
                                $is_checkboxes = false;
                            }
                        }
                    }

                    // Check if the term filters are visible for the user?
                    if ( $sd['showsearchintaxonomies'] == 0 || count( $sd['show_terms']['terms'] ) == 0 )
                        $term_filters_visible = false;
                    else
                        $term_filters_visible =
                            $sd['box_sett_hide_box'] == 1 ||
                            $sd['show_frontend_search_settings'] == 1 ||
                            $sd['frontend_search_settings_visible'] == 1;

                    // If the term settings are invisible,
                    // ..or nothing is chosen, but filters are active
                    // ignore the excluded frontend terms, reset to empty array
                    if (
                        !$term_filters_visible ||
                        ( $term_filters_visible && $sd['frontend_terms_ignore_empty'] == 1 && empty($option_set) ) ||
                        !$is_checkboxes
                    ) {
                        $exclude_showterms = array();
                    } else {
                        $exclude_showterms = array();
                        foreach($sd['show_terms']['terms'] as $t) {
                            if ($t['taxonomy'] == $taxonomy) {
                                if ( $t['id'] == -1 ) {
                                    $t_terms = get_terms( $taxonomy, array(
                                        'hide_empty' => false,
                                        'fields' => 'ids',
                                        'exclude' => $t["ex_ids"]
                                    ) );
                                    if ( $taxonomy == 'post_format' )
                                        $t_terms[] = -200;
                                    if ( !is_wp_error($t_terms) )
                                        $exclude_showterms = array_merge($exclude_showterms, $t_terms);
                                } else {
                                    $exclude_showterms[] = $t['id'];
                                }
                            }
                        }
                        //$exclude_showterms = isset($sd['show_terms']['terms'][$taxonomy]) ? $sd['show_terms']['terms'][$taxonomy] : array();
                    }

                    $exclude_t = isset( $sd_exclude[$taxonomy] ) ? $sd_exclude[$taxonomy] : array();

                    /*
                     AND -> Posts NOT in an array of term ids
                     OR  -> Posts in an array of term ids
                    */
                    if ( $term_logic == 'and' ) {
                        if ( $is_checkboxes || !$term_filters_visible ) {
                            $include_terms = array();
                        } else {
                            if ( $sd['frontend_terms_ignore_empty'] == 1 && empty($option_set) ) {
                                $include_terms = array();
                            } else {
                                $include_terms = count($option_set) == 0 ? array(-10) : $option_set;
                                if ( count($option_set) > 0 )
                                    $term_logic = 'andex';
                            }
                        }

                        if ( $term_filters_visible ) {
                            $exclude_terms = array_diff( array_merge($exclude_t, $exclude_showterms) , $option_set );
                            /*if ( count($option_set) > 0 && count($exclude_terms) == 0 )
                                $exclude_terms = array(-11);*/
                        } else {
                            $exclude_terms = $exclude_t;
                        }
                    } else if ( $term_logic == 'or' || $term_logic == 'andex' ) {
                        $exclude_terms = $exclude_t;

                        // If there are no tags at all, then show all posts, because no filtering is required
                        if ($no_terms_exist) {
                            $include_terms = count($option_set) == 0 ? array() : $option_set;
                        } else {
                            if ( $term_filters_visible ) {
                                if ( $sd['frontend_terms_ignore_empty'] == 1 && empty($option_set) )
                                    $include_terms = array();
                                else
                                    $include_terms = count( $option_set ) == 0 ? array( -10 ) : $option_set;
                            } else {
                                $include_terms = array();
                            }
                        }
                    }

                    // Manage inclusions from the back-end
                    if ( isset($sd_include[$taxonomy]) && count($sd_include[$taxonomy]) > 0 )
                        $include_terms = array_unique( array_merge($include_terms, $sd_include[$taxonomy]) );

                    if ( !empty($include_terms) || !empty($exclude_terms) ) {
                        $ret[] = array(
                            'taxonomy' => $taxonomy,
                            'include'  => $include_terms,
                            'exclude'  => $exclude_terms,
                            'logic'    => $term_logic,
                            '_termset' => isset($o['termset'][$taxonomy]) ? $o['termset'][$taxonomy] : array(),
                            '_is_checkbox' => $is_checkboxes
                        );
                    }
                }
            }
            return $ret;
        }

        /**
         * Converts search data and options to Tag query argument arrays to use with ASP_Query
         *
         * @param $sd
         * @param $o
         * @param $args
         */
        private static function toQueryArgs_Tags($sd, $o, &$args) {

            // Get the tag options, by default the active param is enough, as it is disabled.
            $st_options = w_isset_def( $sd["selected-show_frontend_tags"], array("active" => 0) );
            $tag_logic = $sd["frontend_tags_logic"];
            $no_tags_exist = false;
            $exc_tags = w_isset_def( $sd['selected-exclude_post_tags'], array() );

            $args['_post_tags_active'] = $st_options['active'];
            $args['_post_tags_logic'] = $sd["frontend_tags_logic"];
            $args['_post_tags_empty'] = $sd['frontend_tags_empty'];

            $exclude_tags = array();
            $include_tags = array();

            if ( ($st_options['active'] == 1) || count($exc_tags) > 0) {
                // If no value is selected, transform it to an array
                $o['post_tag_set'] = !isset($o['post_tag_set']) ? array() : $o['post_tag_set'];
                // If radio or drop is selected, convert it to array
                $o['post_tag_set'] =
                    !is_array( $o['post_tag_set'] ) ? array( $o['post_tag_set'] ) : $o['post_tag_set'];

                // Is this the "All" option?
                if (
                    count($o['post_tag_set']) == 1 && in_array(-1, $o['post_tag_set']) ||
                    ( $sd['frontend_terms_ignore_empty'] == 1 && empty($o['post_tag_set']) )
                ) {
                    if ( count($exc_tags) > 0 || count($include_tags) > 0 )
                        $args['post_tax_filter'][] = array(
                            "taxonomy" => 'post_tag',
                            "include"  => $include_tags,
                            "exclude"  => $exc_tags,
                            'allow_empty' => true // Needs to be allowed, as otherwise posts with no tags will be hidden
                        );
                    return;
                }

                // If not the checkboxes are used, force the OR logic
                if ($st_options['display_mode'] != "checkboxes")
                    $tag_logic = "or";

                if ($st_options['source'] == "all") {
                    // Limit all tags to 500. I mean that should be more than enough..
                    $exclude_showtags = get_terms("post_tag", array("number"=>400, "fields"=>"ids"));
                    if ( is_wp_error($exclude_showtags) || count($exclude_showtags) == 0)
                        $no_tags_exist = true;
                } else {
                    $exclude_showtags = $st_options['tag_ids'];
                }

                /*
                 AND -> Posts NOT in an array of term ids
                 OR  -> Posts in an array of term ids
                */
                if ( $tag_logic == 'and' ) {
                    if ( $st_options['active'] == 1 ) {
                        $exclude_tags = array_diff( array_merge($exc_tags, $exclude_showtags) , $o['post_tag_set'] );
                    } else {
                        $exclude_tags = $exc_tags;
                    }

                } else {
                    $exclude_tags = $exc_tags;

                    // If there are no tags at all, then show all posts, because no filtering is required
                    if ($no_tags_exist) {
                        $include_tags = count($o['post_tag_set']) == 0 ? array() : $o['post_tag_set'];
                    } else {
                        if ( $st_options['active'] == 1 ) {
                            $include_tags = count( $o['post_tag_set'] ) == 0 ? array( -10 ) : $o['post_tag_set'];
                        } else {
                            $include_tags = array();
                        }
                    }

                }
            }

            $args['_post_tags_exclude'] = $exclude_tags;
            $args['_post_tags_include'] = $include_tags;

            /**
             * @since 4.10
             * Append to post tax filter to use, instead of separate query
             */
            if ( count($exclude_tags) > 0 || count($include_tags) > 0 )
                $args['post_tax_filter'][] = array(
                    "taxonomy" => 'post_tag',
                    "include"  => $include_tags,
                    "exclude"  => $exclude_tags
                );
        }

        /**
         * Converts search data and options to Custom Field query argument arrays to use with ASP_Query
         *
         * @param $sd
         * @param $o
         * @return array
         */
        private static function toQueryArgs_Custom_Fields($sd, $o) {
            $_cf_items = explode("|", $sd['custom_field_items']);

            $meta_fields = array();

            if ( isset( $o['aspf'] ) && !empty( $_cf_items ) ) {
                $cf_i = 0;

                foreach ( $_cf_items as $u_data ) {
                    // Have to increase here, start from 0, because of the possible continue statement
                    $cf_i++;

                    $data   = json_decode( base64_decode( $u_data ) );

                    // Field is missing, continue
                    if ( !isset($o['aspf'][ $data->asp_f_field . "_" . $cf_i ]) ) continue;
                    // For hidden inputs, posted value is the preset value
                    if ( $data->asp_f_type != 'hidden' )
                        $posted = self::escape( $o['aspf'][ $data->asp_f_field . "_" . $cf_i ] );
                    else
                        $posted = $data->asp_f_hidden_value;
                    // NULL (empty) values accept
                    if ( $posted == "" && $data->asp_f_type != 'hidden' ) continue;

                    if ( isset( $data->asp_f_operator ) ) {
                        switch ( $data->asp_f_operator ) {
                            case 'eq':
                                $operator = "=";
                                $posted   = self::force_numeric( $posted );
                                break;
                            case 'neq':
                                $operator = "<>";
                                $posted   = self::force_numeric( $posted );
                                break;
                            case 'lt':
                                $operator = "<";
                                $posted   = self::force_numeric( $posted );
                                break;
                            case 'let':
                                $operator = "<=";
                                $posted   = self::force_numeric( $posted );
                                break;
                            case 'gt':
                                $operator = ">";
                                $posted   = self::force_numeric( $posted );
                                break;
                            case 'get':
                                $operator = ">=";
                                $posted   = self::force_numeric( $posted );
                                break;
                            case 'elike':
                                $operator = "ELIKE";
                                break;
                            case 'like':
                                $operator = "LIKE";
                                break;
                            case 'in':
                                $operator = "IN";
                                break;
                            default:
                                $operator = "=";
                                $posted   = self::force_numeric( $posted );
                                break;
                        }
                    }

                    if ( $data->asp_f_type == 'range' )
                        $operator = "BETWEEN";

                    if ( $data->asp_f_type == 'range' || $data->asp_f_type == 'slider')
                        $posted   = self::force_numeric( $posted );

                    if ( !empty($data->asp_f_datepicker_operator) ) {
                        switch ( $data->asp_f_datepicker_operator ) {
                            case 'match':
                                $operator = "=";
                                break;
                            case 'nomatch':
                                $operator = "<>";
                                break;
                            case 'before':
                                $operator = "<";
                                break;
                            case 'after':
                                $operator = ">";
                                break;
                            default:
                                $operator = "<";
                                break;
                        }

                        switch ( w_isset_def($data->asp_f_datepicker_store_format, "acf") ) {
                            case 'datetime':
                                /**
                                 * Format YY MM DD is accepted by strtotime as ISO8601 Notation
                                 * http://php.net/manual/en/datetime.formats.date.php
                                 */
                                $posted   = self::force_numeric( $posted );
                                if ( strlen($posted) == 8 ) {
                                    $posted = strtotime($posted, time());
                                    $posted = date("Y-m-d", $posted);
                                    $operator = "datetime ".$operator;
                                }
                                break;
                            case 'timestamp':
                                $posted   = self::force_numeric( $posted );
                                if ( strlen($posted) == 8 ) {
                                    $posted   = strtotime($posted, time());
                                    $operator = "timestamp ".$operator;
                                }
                                break;
                            default:
                                /**
                                 * This is ACF aka. yymmdd aka. 20170101
                                 * ..so the operators need to be adjusted in cases of < and > to <= and >=
                                 **/
                                $posted   = self::force_numeric( $posted );
                                if ( $operator == '<' || $operator == '>' )
                                    $operator .= '=';
                                break;
                        }
                    }

                    if ( is_array($posted) )
                        $posted = array_values($posted);

                    $arr = array(
                        'key'     => $data->asp_f_field,
                        'value'   => $posted,
                        'operator'=> $operator
                    );
                    if ( !empty($data->asp_f_checkboxes_logic) )
                        $arr['logic'] = $data->asp_f_checkboxes_logic;

                    $meta_fields[] = $arr;
                }
            }

            return $meta_fields;

        }

        /**
         * Converts search data and options to Date query argument arrays to use with ASP_Query
         *
         * @param $sd
         * @param $o
         * @return array
         */
        private static function toQueryArgs_Dates($sd, $o) {
            $date_parts = array();
            if ($sd['exclude_dates_on'] == 1) {
                $exc_dates = &$sd['selected-exclude_dates'];
                if ($exc_dates['from'] != "disabled") {
                    if ( $exc_dates['from'] == "date" ) {
                        $exc_from_d = $exc_dates["fromDate"];
                    } else {
                        $exc_from_d = date(
                            "y-m-d",
                            strtotime(" ".(-1) * $exc_dates['fromInt'][0]." year ".(-1) * $exc_dates['fromInt'][1]." month ".(-1) * $exc_dates['fromInt'][2]." day",
                                time())
                        );
                    }
                    $date_parts[] = array(
                        'date'     => $exc_from_d,
                        'operator' => $exc_dates['mode'],
                        'interval' => 'after'
                    );
                }
                if ($exc_dates['to'] != "disabled") {
                    if ( $exc_dates['to'] == "date" ) {
                        $exc_to_d = $exc_dates["toDate"];
                    } else {
                        $exc_to_d = date(
                            "y-m-d",
                            strtotime(" ".(-1) * $exc_dates['toInt'][0]." year ".(-1) * $exc_dates['toInt'][1]." month ".(-1) * $exc_dates['toInt'][2]." day",
                                time())
                        );
                    }
                    $date_parts[] = array(
                        'date'     => $exc_to_d,
                        'operator' => $exc_dates['mode'],
                        'interval' => 'before'
                    );
                }
            }

            // Filters from front-end
            if ( !empty($o['post_date_from']) && self::check_date($o['post_date_from']) ) {
                //preg_match("/(\d+)\-(\d+)\-(\d+)$/", $o['post_date_from'], $m);
                $date_parts[] = array(
                    'date'     => $o['post_date_from'],
                    'operator' => 'include',
                    'interval' => 'after'
                );
            }

            if ( !empty($o['post_date_to'])  && self::check_date($o['post_date_to']) ) {
                //preg_match("/(\d+)\-(\d+)\-(\d+)$/", $o['post_date_to'], $m);
                $date_parts[] = array(
                    'date'     => $o['post_date_to'],
                    'operator' => 'include',
                    'interval' => 'before'
                );
            }

            return $date_parts;
        }


        private static function toQueryArgs_ContentTypes($sd, $o, &$args) {
            $ctf = $sd['content_type_filter'];
            if ( count($ctf['selected']) > 0 ) {
                $o['asp_ctf'] = !isset($o['asp_ctf']) ? array() : $o['asp_ctf'];
                $o['asp_ctf'] = !is_array($o['asp_ctf']) ? array($o['asp_ctf']) : $o['asp_ctf'];
                if ( $ctf['display_mode'] == 'checkboxes' ) {
                    $unchecked = array_diff($ctf['selected'], $o['asp_ctf']);
                    $args['search_type'] = array_diff($args['search_type'], $unchecked);
                } else {
                    // Only if 'Choose any' is not selected
                    if ( !in_array(-1, $o['asp_ctf']) )
                        $args['search_type'] = array_intersect($args['search_type'], $o['asp_ctf']);
                }
            }
        }
    }
}