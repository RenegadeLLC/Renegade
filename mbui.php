<?php
/* 
 * request proxy module
 * if invoked in CLI content, then it will call CLI implementation wrapper
 * if invoked in web server context, the it will call HTTP/HTML implementation wrapper
 */
    define( "MB_ROOT", dirname(__FILE__) );

    require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . "mb" .  DIRECTORY_SEPARATOR . "libs" . DIRECTORY_SEPARATOR . "Json.php");
    require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . "mb" .  DIRECTORY_SEPARATOR . "libs" . DIRECTORY_SEPARATOR . "IpUtils.php");


    define('MBUI',true);

    date_default_timezone_set('UTC');
    /*
     * changing default memory limit
     */    
    ini_set('memory_limit', '2024M');

    define('AUTH_COOKIE_NAME',"malbuster_authorized_user");
    define('AUTH_USER_ID',"malbuster_authorized_user_id");
    define('ACCESS_FILE',"mb_access");
    define('IP_FILE', "mb_hosts");

    $users                  = array();
    $hosts                  = array();

    /*
    function get_remote_ip(){
        if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
        {
          $ip=$_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
        {
          $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else
        {
          $ip=$_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }*/


    function load_access_file(){
        global $users;
        global $hosts;

        $users = ReadJsonFromFile( ACCESS_FILE );
        if( count($users) == 0 ){
            $users = array();
            $users["support@quttera.com"] = "nDGSCmL4HRZVKvEg2TZT2Yg0PNIXWCrX";
            store_access_file(); 
        }
    }


    function store_access_file(){
        global $users;
        global $hosts;

        WriteToFile($users,ACCESS_FILE); 
    }


    function load_hosts_file(){
        global $users;
        global $hosts;

        $hosts = ReadJsonFromFile( IP_FILE );
        if( count($hosts) == 0 ){
            $hosts = array();
            array_push($hosts,"127.0.0.1");
            store_hosts_file();
        }
    }

    function store_hosts_file(){
        global $users;
        global $hosts;

        WriteToFile($hosts,IP_FILE);
    }

    function is_authorized(){
        global $users;
        global $hosts;

        load_hosts_file();
        $ip = GetRemoteIp();
        if( in_array($ip,$hosts)){
            return true;
        }

        return false;
    }


    function set_authorized(){
        global $users;
        global $hosts;

        $ip = GetRemoteIp();
        array_push($hosts,$ip);
        store_hosts_file();
    }

    function show_login_page( $message = NULL ){
$ip = GetRemoteIp();
$login_page =<<< HTML_LOGIN_PAGE
<html>
    <head>
        <title>Malbuster Login</title>
    </head>

    <body>
        <h2>MalBuster Login Page (access IP: $ip)</h2>
        <form action="mbui.php" method="post">
            <fieldset>
                <p>
                    <label for="malbuster_username">Username</label>
                    <input type="text" id="malbuster_username" name="malbuster_username" value="" maxlength="64" />
                </p>
                <p>
                    <label for="malbuster_password">Password</label>
                    <input type="text" id="malbuster_password" name="malbuster_password" value="" maxlength="64" />
                </p>
                <p>
                    <input type="submit" value="→ Login" />
                </p>
            </fieldset>
        </form>
        <p><b>$message</b></p>
    </body>
</html>
HTML_LOGIN_PAGE;
        echo $login_page;
    }

    function authenticate(){
        global $users;
        global $hosts;

        if(!isset($_POST["malbuster_username"]) || !isset($_POST["malbuster_password"])){
            return false;
        }
        
        load_access_file();    
        $user_name = trim($_POST["malbuster_username"]);

        if(!isset($users[$user_name]) ){
            return false;
        }

        if( isset( $users[$_POST["malbuster_username"]] )  && 
            $users[$_POST["malbuster_username"]] == $_POST["malbuster_password"] )
        {
            set_authorized();
            return true;
        }
        
        return false;
    }
    

    function handle_request(){
        require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . "mb" .  DIRECTORY_SEPARATOR . "webui" . DIRECTORY_SEPARATOR . "webui.php");
        $mbwebui = new MbWebUI();
        $mbwebui->RenderPage( $_SERVER["REQUEST_URI"] );
    }

    #
    # entry point
    #

    /*
    if( isset($_SERVER["QUERY_STRING"]) && strpos( $_SERVER["QUERY_STRING"],"install") !== FALSE ){
        #
        # install procedure called
        #
        die();
    }*/

    # if( is_authorized() == true || GetRemoteIp() == "127.0.0.1" )
    if( is_authorized() == true ){
        handle_request();
    }else{
        # echo "Uset not authorized";

        #
        # not authorized user
        # 
        if( $_SERVER['REQUEST_METHOD'] != "POST" ){
            show_login_page();
        }else{
            if( authenticate() == false ){
                #
                # authentication failed, generate login page once again
                #
                show_login_page( "Authentication failed, Try again." );
            }else{
                # echo "Authentication passed!";
                handle_request();
            }
        }
    }
?>

