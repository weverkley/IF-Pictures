<?php
require_once realpath(dirname(__FILE__).'/config.php');


if (!isset($_SESSION)) session_start();

set_include_path(implode(PATH_SEPARATOR, array(
    realpath(ROOT_PATH.DS.CLASSES_DIR),
    realpath(ROOT_PATH.DS.PUBLIC_DIR),
    realpath(ROOT_PATH.DS.INC_DIR),
    get_include_path()
)));

require_once realpath(dirname(__FILE__).'/../classes/User.class.php');

function showPage() {
	if (isset($_GET['p'])) {
		if (preg_match('/.php/i', $_GET['p'])) {
			$file = PUBLIC_DIR.'/'.$_GET['p'];
			(file_exists($file)) ? require_once PUBLIC_DIR.'/'.$_GET['p'] : require_once PUBLIC_DIR.'/404.html';
		} elseif (preg_match('/.html/i', $_GET['p'])) {
			$file = PUBLIC_DIR.'/'.$_GET['p'];
		    (file_exists($file)) ? require_once PUBLIC_DIR.'/'.$_GET['p'] : require_once PUBLIC_DIR.'/404.html';
		} elseif (empty($_GET['p']) || !file_exists($_GET['p'])) require_once PUBLIC_DIR.'/404.html';
	} else require_once PUBLIC_DIR.'/inicio.html';
}

function ajax() {
	return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}
?>