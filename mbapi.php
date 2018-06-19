<?php

/*
 * REST API entry point module
 * responsible valid access permissions by remote server 
 * and pass request to appropriate API handler
 *
 * Supported requests:
 *      POST rescan(path,force,severity,heuristic)
 *      GET  is_running - retrieve if there is any currently running operation
 *      GET  status     - current execution status
 *      GET  stop       - stop currently running scan if running
 *      GET  report     - return last investigation report
 *      GET  recover    - iterate over filesystem and locates installed CMSs
 */

define("MALBUSTER_API_ROOT",dirname(__FILE__));
date_default_timezone_set("UTC");

//require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . "mb" .  DIRECTORY_SEPARATOR . "libs" . DIRECTORY_SEPARATOR . "Json.php");
//require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . "mb" .  DIRECTORY_SEPARATOR . "libs" . DIRECTORY_SEPARATOR . "IpUtils.php");
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . "mb" .  DIRECTORY_SEPARATOR . "HTTP" . DIRECTORY_SEPARATOR . "restapi.php");


    #
    # regardless to output, this output will be in JSON format
    #
    header('Content-Type: application/json');
    $api = new MbRestApi();
    $output = $api->HandleRequest();
    if( !$output ){
        $rc = array();
        $rc["error"]        = 500;
        $rc["error_str"]    = "Internal Server Error";
        echo json_encode($rc);
    }else{
        echo json_encode($output);
    }

?>
