<?php
require_once '../../inc/global.inc.php';
    $image = new Image();
    $image->delete($_POST['file']);
?>