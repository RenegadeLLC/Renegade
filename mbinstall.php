<?php

    function IsCli()
    {
        return php_sapi_name() == 'cli';
    }

    function message($msg)
    {
        if(IsCli())
        {
            echo $msg . "\n";
        }
        else
        {        
            $text = preg_replace ( '/\n+/','<br>',$msg );
            echo "<p>$text</p></br>";
        }
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

    echo "<html><head></head><body>\n";

    $remote_archive = "http://malbuster.net/archives/";
    $latest         = $remote_archive . "latest";
    $archive_name   = trim(download_file($latest));
    $latest_package = $remote_archive . $archive_name;

    if( $latest_package == $remote_archive ){
        message("Error failed to retrieve name of latest archive\n");
        exit();
    }else{
        message("Latest archive URL: $latest_package");
        message("Download latest archive from remote");
        # file_put_contents($archive_name, fopen($latest_package, 'r'));

        download_file($latest_package,$archive_name);

        if(!is_file($archive_name)){
            message("Failed to download remote file. Try it manually");
            exit();
        }
        
        if( is_dir("./mb") ){
            message("Old malbuster archive still exist. Please remove it before you install new version on " . getcwd());
            exit();
        }

        if( extract_archive($archive_name,"./") == FALSE )
        {
            message("Archive extraction failed");
            exit();
        }

        $install_path = getcwd() . DIRECTORY_SEPARATOR . "mb";
        if( !is_dir( $install_path) ){
            message("Failed to extract malbuster archive to " . getcwd());
            exit();
        }

        message("Latest malbuster extracted successfully");
    }
?>