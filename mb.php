#!/usr/bin/php

<?php
/* 
 * request proxy module
 * if invoked in CLI content, then it will call CLI implementation wrapper
 * if invoked in web server context, the it will call HTTP/HTML implementation wrapper
 */

define( "MB_ROOT", dirname(__FILE__) );

ini_set('memory_limit', '2024M');

if( function_exists("date_default_timezone_set") )
{
    date_default_timezone_set('UTC');
}

function IsCli()
{
    return php_sapi_name() == 'cli';
}


if( IsCli() == true )
{
    require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . "mb" . DIRECTORY_SEPARATOR . "CLI" . DIRECTORY_SEPARATOR . "cli.php");
    $mbcli = new MbCli();
    $mbcli->HandleCommand( $argv );
}
else
{
    header('HTTP/1.0 403 Access Forbidden');
    die();   
}

?>
