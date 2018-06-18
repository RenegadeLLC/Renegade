<?php
if (!defined('ABSPATH')) die('-1');

if (!class_exists("WD_ASP_IndexTable_Action")) {
    /**
     * Class WD_ASP_IndexTable_Action
     *
     * Handles index table actions
     *
     * @class         WD_ASP_IndexTable_Action
     * @version       1.0
     * @package       AjaxSearchPro/Classes/Actions
     * @category      Class
     * @author        Ernest Marcinko
     */
    class WD_ASP_IndexTable_Action extends WD_ASP_Action_Abstract {

        public function handle() {}

        public function update( $post_id=null, $_post=null, $update=false ) {
            /**
             * Argument default values are set to NULL, as some developers like to call
             * this action without arguments, which causes an error.
             */
            if ( !isset($post_id) || wp_is_post_revision( $post_id ) )
                return false;

            $it_options = wd_asp()->o['asp_it_options'];

            if ($it_options !== false) {

                /**
                 * In some cases custom fields are not created in time of saving the post.
                 * To solve that, the user has an option to turn off automatic indexing
                 * when the post is created - but not when updated, or when a CRON job is executed.
                 */
                if ( $it_options['it_index_on_save'] == 0 && $update == false )
                    return false;

                $args = array();
                foreach ($it_options as $k => $o) {
                    $args[str_replace('it_', '', $k)] = $o;
                }
                $it_o = new asp_indexTable( $args );

                $post_status = get_post_status( $post_id );
                $allowed_statuses = explode(',', $args['post_statuses']);
                if ( count($allowed_statuses) <= 0 )
                    return false;
                foreach ($allowed_statuses as $k => &$v)
                    $v = trim($v);

                if ($post_status == 'trash' || !in_array($post_status, $allowed_statuses)) {
                    $this->delete( $post_id );
                    return true;
                }

                $post_type = get_post_type( $post_id );
                $allowed_types = $args['post_types'];
                // If this is a product, and product variations should be indexed, index them as well
                if ( class_exists('WooCommerce') &&
                    in_array($post_type, array('product', 'product_variation'))
                ) { // Woo products and variations
                    if ( $post_type === 'product'  ) { // Product saving
                        // Save the variations, if selected
                        if ( in_array('product_variation', $allowed_types) ) {
                            $args = array(
                                'post_type'   => 'product_variation',
                                'post_status' => $allowed_statuses,
                                'numberposts' => -1,
                                'fields'      => 'ids',
                                'post_parent' => $post_id // $post->ID
                            );
                            $variations = get_posts($args);
                            foreach ($variations as $variation) {
                                if (!is_array($variation) && !is_object($variation))
                                    $it_o->indexDocument($variation, true, true);
                            }
                        }
                        // Save the product, if selected
                        if ( in_array('product', $allowed_types) )
                            $it_o->indexDocument( $post_id, true, true );
                    } else if ( in_array('product_variation', $allowed_types) && $post_type === 'product_variation' ) { // variation saving
                        // Check if post parent status before indexing
                        $parent = wp_get_post_parent_id( $post_id );
                        if ( $parent !== false ) {
                            $parent_post_status = get_post_status( $parent );
                            if ( in_array($parent_post_status, $allowed_statuses) )
                                $it_o->indexDocument( $post_id, true, true );
                        }
                    }
                } else { // Any other post type
                    $it_o->indexDocument( $post_id, true, true );
                }
            }

        }


        public function delete( $post_id ) {
            $it_o = new asp_indexTable();

            $post_type = get_post_type( $post_id );
            if ( class_exists('WooCommerce') &&
                $post_type === 'product'
            ) {
                $args = array(
                    'post_type'     => 'product_variation',
                    'post_status'   => 'any',
                    'numberposts'   => -1,
                    'fields'        => 'ids',
                    'post_parent'   => $post_id // $post->ID
                );
                $variations = get_posts( $args );
                $variations[] = $post_id;
                $it_o->removeDocument( $variations );
            } else {
                $it_o->removeDocument( $post_id );
            }
        }

        public function extend() {
            $asp_it_options = wd_asp()->o['asp_it_options'];

            if ($asp_it_options !== false) {
                $args = array();
                foreach ($asp_it_options as $k => $o) {
                    $args[str_replace('it_', '', $k)] = $o;
                }
                $it_obj = new asp_indexTable( $args );
                $res = $it_obj->extendIndex( );
                update_option("asp_it_cron", array(
                    "last_run"  => time(),
                    "result"    => $res
                ));
            }

        }

        public function cron_extend() {
            // Index Table CRON
            if ( !wp_next_scheduled( 'asp_cron_it_extend' ) ) {

                $asp_it_options = wd_asp()->o['asp_it_options'];

                if ($asp_it_options !== false) {
                    if ( w_isset_def($asp_it_options['it_cron_enable'], 0) == 1 )
                        wp_schedule_event( time(), w_isset_def($asp_it_options['it_cron_period'], "hourly"), 'asp_cron_it_extend' );
                }
            }
        }

        // ------------------------------------------------------------
        //   ---------------- SINGLETON SPECIFIC --------------------
        // ------------------------------------------------------------
        public static function getInstance() {
            if ( ! ( self::$_instance instanceof self ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }
    }
}