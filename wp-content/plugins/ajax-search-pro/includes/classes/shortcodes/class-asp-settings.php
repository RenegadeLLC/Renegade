<?php
if (!defined('ABSPATH')) die('-1');

if (!class_exists("WD_ASP_Settings_Shortcode")) {
    /**
     * Class WD_ASP_Settings_Shortcode
     *
     * Settings drop-down shortcode
     *
     * @class         WD_ASP_Settings_Shortcode
     * @version       1.0
     * @package       AjaxSearchPro/Classes/Shortcodes
     * @category      Class
     * @author        Ernest Marcinko
     */
    class WD_ASP_Settings_Shortcode extends WD_ASP_Shortcode_Abstract {

        function handle( $atts ) {
            extract( shortcode_atts( array(
                'id' => '0',
                'element' => 'div',
                'display_on_mobile' => 1
            ), $atts ) );
            if ($id == "") return;

            $mdetectObj = new WD_MobileDetect();
            if ( $display_on_mobile == 0 && $mdetectObj->isMobile() ) return;

            // Visual composer bug, get the first instance ID
            if ($id == 99999) {
                $_instances = wd_asp()->instances->get();
                if ( empty($_instances) )
                    return "";

                $search = reset($_instances);
                $id = $search['id'];
            }

            return "<".$element." id='wpdreams_asp_settings_".$id."'></".$element.">";
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