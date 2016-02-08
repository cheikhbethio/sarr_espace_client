<?php

require 'lib/inc.prepend.php';

if (isset($_GET['filename'])) {
    $File = new FileFromDB($_GET['filename']);
    $File->output();
}

?>