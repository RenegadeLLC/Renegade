<?php

    require_once( dirname(__FILE__). DIRECTORY_SEPARATOR . "mb" . DIRECTORY_SEPARATOR . "SDK" . DIRECTORY_SEPARATOR . "Common.php");

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
            $text = preg_replace ( '/\n+/','',$msg );
            echo "<p>$text</p>";
        }
    }


    function restore_file($file_path)
    {
        $path = pathinfo($file_path);
        $ext = $path['extension'];
        if( strcmp($ext,QTR_CURE_EXTENSION) == 0 )
        {
            /*
             * This is quarantined file, restore it
             */
            $original_file_length = strpos($file_path, QTR_CURE_EXTENSION) - 1; /* -1 for dot */
            $original_file_name = substr($file_path,0, $original_file_length);
            if( file_exists($original_file_name) )
            {
                @rename($original_file_name, $original_file_name.".qtr_rst_bk");
            }
            echo "Renaming $file_path to $original_file_name\n";
            @rename($file_path,$original_file_name);
        }else{
            echo "Skipping $file_path\n";
        }
    }

    /*
     * restore quarantined files __qtr__
     */
    function restore_files($dir)
    {
        if (is_dir($dir))
        {
            $objects = scandir($dir);
            foreach ($objects as $object)
            {
                if ($object != "." && $object != "..")
                {
                    if (is_dir($dir.DIRECTORY_SEPARATOR.$object))
                    {
                        message("Restore folder: ".DIRECTORY_SEPARATOR.$object);
                        restore_files($dir.DIRECTORY_SEPARATOR.$object);
                    }
                    else
                    {
                        message("Restoring file: ".$dir.DIRECTORY_SEPARATOR.$object);
                        restore_files($dir.DIRECTORY_SEPARATOR.$object);
                    }
                }
            }
        }
        else
        {
            if (file_exists($dir))
            {
                message("Restoring file: " . $dir);
                restore_file($dir); 
            }
        }
    }

    function main()
    {
        global $argv;

        if(!IsCli())
        {
            echo "<html><head></head><body>\n";
            echo "<b>Restoring all quarantined files.</b>";
        }
        else
        {
            echo "Restoring all  quarantined files.\n";
        }

        if( count($argv) < 2 ){
            echo "Failed to locate path to restore.\n";
            echo sprintf("%s <path>",$argv[0]) . "\n";
            return;
        }

        $restore_path = $argv[1];
        if(!is_dir($restore_path) and !is_file($restore_path)){
            echo "Provided path ($restore_path) is invalid\n";
        }else{
            restore_files($restore_path);
        }
    }

    main();
?>
