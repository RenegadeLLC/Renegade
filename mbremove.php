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
            $text = preg_replace ( '/\n+/','',$msg );
            echo "<p>$text</p>";
        }
    }

    function remfile($dir)
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
                        message("Deleting folder: ".DIRECTORY_SEPARATOR.$object);
                        remfile($dir.DIRECTORY_SEPARATOR.$object);
                    }
                    else
                    {
                        message("Deleting file: ".$dir.DIRECTORY_SEPARATOR.$object);
                        @unlink($dir.DIRECTORY_SEPARATOR.$object);
                    }
                }
            }
            @rmdir($dir);
        }
        else
        {
            if (file_exists($dir))
            {
                message("Deleting file: " . $dir);
                @unlink ($dir);               
            }
        }
    }

    function main()
    {
        if(!IsCli())
        {
            echo "<html><head></head><body>\n";
            echo "<b>Uninstalling all files.</b>";
        }
        else
        {
            echo "Uninstalling all files.\n";
        }
        $current_dir = dirname(__FILE__);
        $toremove = array("mb.php","mbinstall.php","mbui.php","mbupdate.php","clean_qtr.sh","dirscan.sh","mbapi.php",
                        "find_qtr.sh","mbscanner.sh","quarantine.sh","mbrestore.php","mb","mbtmp","mb_access","mb_hosts","quarantine");
        foreach ($toremove as $file)
        {
            remfile($current_dir.DIRECTORY_SEPARATOR.$file);
        }
        remfile(__FILE__);
    }

    main();
?>
