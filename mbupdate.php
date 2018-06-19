<?php
    /*
     * This module contains malbuster update functionality
     * Upon update command a new archive is loaded and extracted into temporary directory
     * Further extracted files copied to permanent installation directory
     */
    function rrmdir($dir) 
    { 
        if (is_dir($dir)) 
        { 
            $objects = scandir($dir); 

            foreach ($objects as $object){ 
                if ($object == "." || $object == ".."){ 
                    continue;
                }
                 
                if (filetype($dir. DIRECTORY_SEPARATOR .$object) == "dir"){
                    if ( rrmdir($dir. DIRECTORY_SEPARATOR .$object) == false ){
                        return false;
                    }
                }else {
                    if( unlink($dir. DIRECTORY_SEPARATOR  .$object) == false ){
                        return false;   
                    }
                }
            }
            reset($objects); 
            rmdir($dir); 
        }

        return true;
    } 


    function download_file($remote, $local = NULL )
    {
        message("Download $remote");

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $remote);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        $data = curl_exec($curl);
        curl_close($curl);

        if(!$data)
        {
            message("Failed to download [$remote] file");
            return false;
        }

        if(!$local)
        {
            return $data;
        }

        $f = fopen($local,"w");
        if( !$f )
        {
            message("Failed to store [$remote] as [$local]");
            return false;
        }

        fwrite($f,$data);
        fclose($f);
        return true;        
    }


    function IsCli()
    {
        return php_sapi_name() == 'cli';
    }


    function message($msg)
    {
        if( IsCli() )
        {
            echo $msg . "\n";
        }
        else
        {
            $text = preg_replace ( '/\n+/','<br>',$msg );
            echo "<p>$text</p>";
            flush();
            ob_flush();
        }
    }


    function extract_archive($archive, $path )
    {
        if( class_exists('ZipArchive') )
        { 
            message("Extracting archive using ZipArchive");
            $zip = new ZipArchive();
            if ($zip->open( $archive ) === TRUE) 
            {
                $zip->extractTo($path);
                $zip->close();
                message("Extract procedure finished successfully");
                return true;
            } 
            else 
            {
                message("Failed to open archive $archive");
                return false;
            }
        }
        else
        {
            message("Trying to extract archive using zip tool");
            message("Executing: [which unzip]");
            message(shell_exec("which unzip"));

            message("Executing: [which zip]");
            message(shell_exec("which zip"));

            message(shell_exec("unzip $archive -d $path"));
            return true;
        }
    }


    if( IsCli() == false )
    {
        ob_start();
        echo "<html><head></head><body>\n";
        flush();
        ob_flush();
    }

    message("Startin malbuster updating procedure " .  date("m.d.y.H.i.s") );
    $remote_archive = "http://malbuster.net/archives/";
    $latest         = $remote_archive . "latest";
    $archive_name   = trim(download_file($latest));
    $latest_package = $remote_archive . $archive_name;
#
    if( $latest_package == $remote_archive ){
        message("Error failed to retrieve name of latest archive\n");
        die();
    }else{
        if( is_file( $latest_package ) )
        {
            unlink($latest_package);
        }
        message("Latest archive URL: $latest_package");
        message("Download latest archive from remote");
        # file_put_contents($archive_name, fopen($latest_package, 'r'));
        download_file($latest_package,$archive_name);

        if(!is_file($archive_name))
        {
            message("Failed to download remote file. Try it manually");
            die();
        }

        message("Remote archive $remote_archive downloaded successfully");  

        #
        #
        # 1 - download and extract archive in tmp directory
        # 2 - copy operational files from previous install ( catalogs  CDB?  config  _ignore  mblogs  mbreports  mbsnapshot  meta  _quarantine )
        # 3 - rename previous installation to mb.(date)
        # 4 - move new installation to the ./mb location
        #

        $tmp_dir = getcwd() . DIRECTORY_SEPARATOR . "mbtmp";
        if( is_dir($tmp_dir) )
        {
            if( rrmdir($tmp_dir) == false )
            {
                message("Failed to remove old temporary directory. Please remove it manually and rerun script again");
                die();
            }
        }
        
        message("Creating temporary directory $tmp_dir");
        mkdir( $tmp_dir );
        if( !is_dir($tmp_dir) )
        {
            message("Failed to create temporary directory for update. Cannot continue");
            die();
        }
        message("Directory $tmp_dir created successfully");

        if( extract_archive( $archive_name, $tmp_dir ) == FALSE ){
            message("Archive extraction failed");
            die();
        }else{
            message("Archive extracted successfully to $tmp_dir");
        }
 
        $install_path = getcwd() . DIRECTORY_SEPARATOR . "mb";

        if( is_dir( $install_path ) )
        {
            #
            # merge old installation directories
            #
            $directories = array("config", "_ignore", "mblogs", "mbreports", "mbsnapshot", "meta", "_quarantine");

            foreach( $directories as $dir )
            {
                $old_path = getcwd() . DIRECTORY_SEPARATOR . "mb" . DIRECTORY_SEPARATOR . $dir;
                message("Testing directory $old_path");

                if( !is_dir($old_path) )
                {
                    message("$old_path is missing. Nothing to copy.");
                    continue;
                }

                $tmp_path = $tmp_dir . DIRECTORY_SEPARATOR . "mb" . DIRECTORY_SEPARATOR . $dir;
                message("Removing $tmp_path");
                rrmdir( $tmp_path );
                message("Moving $old_path to $tmp_path");
                $rc = rename( $old_path, $tmp_path );
                if( !$rc )
                {
                    message("Failed to rename $old_path to $tmp_path");
                    message("Stoping upgrade");
                    die();
                }
                else
                {
                    message("$old_path renamed to $tmp_path");
                }
            }
        }

        if( is_dir($install_path ) )
        {
            message("Suspend previous installation");
            $suspend_path = $install_path . "." . date("m.d.y.H.i.s");
            rename( $install_path, $suspend_path );
        }

        message("Move new installation to permanent location");
        message(shell_exec("mv $tmp_dir/* ./"));
        
        if( !is_dir( $install_path) ){
            message("Failed to extract malbuster archive to " . getcwd());
            die();
        }

        message("Latest malbuster extracted successfully");
    }

?>
