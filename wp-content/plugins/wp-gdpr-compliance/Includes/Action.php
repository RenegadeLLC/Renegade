<?php

namespace WPGDPRC\Includes;

/**
 * Class Action
 * @package WPGDPRC\Includes
 */
class Action {
    /** @var null */
    private static $instance = null;

    /**
     * Stop WordPress from sending anything but essential data during the update check
     * @param array $query
     * @return array
     */
    public function onlySendEssentialDataDuringUpdateCheck($query = array()) {
        unset($query['php']);
        unset($query['mysql']);
        unset($query['local_package']);
        unset($query['blogs']);
        unset($query['users']);
        unset($query['multisite_enabled']);
        unset($query['initial_db_version']);
        return $query;
    }

    public function processEnableAccessRequest() {
        $enabled = Helper::isEnabled('enable_access_request', 'settings');
        if ($enabled) {
            $accessRequest = AccessRequest::databaseTableExists();
            $deleteRequest = DeleteRequest::databaseTableExists();
            if (!$accessRequest || !$deleteRequest) {
                Helper::createUserRequestDataTables();
                $result = wp_insert_post(array(
                    'post_type' => 'page',
                    'post_status' => 'private',
                    'post_title' => __('Data Access Request', WP_GDPR_C_SLUG),
                    'post_content' => '[wpgdprc_access_request_form]',
                    'meta_input' => array(
                        '_wpgdprc_access_request' => 1,
                    ),
                ), true);
                if (!is_wp_error($result)) {
                    update_option(WP_GDPR_C_PREFIX . '_settings_access_request_page', $result);
                }
            }
        }
    }

    public function processToggleAccessRequest() {
        $page = Helper::getAccessRequestPage();
        if (!empty($page)) {
            $enabled = Helper::isEnabled('enable_access_request', 'settings');
            $status = ($enabled) ? 'private' : 'draft';
            wp_update_post(array(
                'ID' => $page->ID,
                'post_status' => $status
            ));
        }
    }

    public function showNoticesRequestUserData() {
        $enabled = Helper::isEnabled('enable_access_request', 'settings');
        if ($enabled) {
            $accessRequest = AccessRequest::databaseTableExists();
            $deleteRequest = DeleteRequest::databaseTableExists();
            if (!$accessRequest || !$deleteRequest) {
                $pluginData = Helper::getPluginData();
                printf(
                    '<div class="%s"><p><strong>%s:</strong> %s %s</p></div>',
                    'notice notice-error',
                    $pluginData['Name'],
                    __('Couldn\'t create the required database tables.', WP_GDPR_C_SLUG),
                    sprintf(
                        '<a class="button" href="%s">%s</a>',
                        add_query_arg(
                            array('wpgdprc-action' => 'create_request_tables'),
                            Helper::getPluginAdminUrl()
                        ),
                        __('Retry', WP_GDPR_C_SLUG)
                    )
                );
            }
        }
    }

    /**
     * @return null|Action
     */
    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}