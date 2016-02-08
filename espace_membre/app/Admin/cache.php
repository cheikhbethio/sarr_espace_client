<?php

require 'lib/inc.prepend.php';

$cache_path = 'cache/';
$cache_lifetime = 3600;

if (isset($_GET['filename'])) {
    $File = new FileFromDB($_GET['filename']);
    $FileHeaders = $File->headers();
    $file_cache = $cache_path.$FileHeaders->name;
    if (!file_exists($file_cache)
    || filemtime($file_cache)+$cache_lifetime<time()
    || filemtime($file_cache)<=$FileHeaders->updated_date) {
        $File->output($file_cache);
    }
    header("Content-Type: {$FileHeaders->type}");
    header("Content-Disposition: inline; filename={$FileHeaders->name}");
    header("Last-Modified: ".date('r', $FileHeaders->updated_date));
    readfile($file_cache);
}


?>