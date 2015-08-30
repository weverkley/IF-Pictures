<?php
require_once 'config.php';

include './classes/Mongo.class.php';

set_include_path(implode(PATH_SEPARATOR, array(
    realpath(ROOT_PATH.DS.CLASSES_DIR),
    realpath(ROOT_PATH.DS.PUBLIC_DIR),
    realpath(ROOT_PATH.DS.INC_DIR),
    get_include_path()
)));

function showPage() {
	if (isset($_GET['p'])) {
	    $file = "/public/" . $_GET['p'] . '.php';
	    if (file_exists($file)) {
	        include ('$file');
	    } 
	    else {
	        include '/public/404.php';
	    }
	} else {
		include '/public/inicio.php';
	}
}
?>