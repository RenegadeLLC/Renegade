<?php
header('Content-type: application/json'); 
$json = file_get_contents('https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyATSoDd4sGLMKhsYH49MHjKVHd01FWcyfQ'); 
die($json); // prints JSON to the screen that jQuery can use