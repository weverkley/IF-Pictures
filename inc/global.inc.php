<?php
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
require_once realpath(dirname(__FILE__).'/config.php');

if (!isset($_SESSION)) session_start();

set_include_path(implode(PATH_SEPARATOR, array(
    realpath(ROOT_PATH.DS.CLASSES_DIR),
    realpath(ROOT_PATH.DS.PUBLIC_DIR),
    realpath(ROOT_PATH.DS.INC_DIR),
    get_include_path()
)));

require_once realpath(dirname(__FILE__).'/../classes/DB.class.php');
require_once realpath(dirname(__FILE__).'/../classes/Utils.class.php');
require_once realpath(dirname(__FILE__).'/../classes/User.class.php');
require_once realpath(dirname(__FILE__).'/../classes/SimpleImage.php');
require_once realpath(dirname(__FILE__).'/../classes/Image.class.php');
require_once realpath(dirname(__FILE__).'/../classes/Friends.class.php');
require_once realpath(dirname(__FILE__).'/../classes/Update.class.php');
require_once realpath(dirname(__FILE__).'/../classes/Posts.class.php');
require_once realpath(dirname(__FILE__).'/../classes/Feed.class.php');

function incPage($default, $get, $notallowed = array(), $allowed = array()) {
	if (isset($_GET[$get])) {
		//$notallowed = array('login.php', 'logout.php', 'painel.html'); // array com páginas bloqueadas;
		if (preg_match('/.php/i', $_GET[$get])) {
			$file = PUBLIC_DIR.'/'.$_GET[$get];
			(file_exists($file) && in_array($_GET[$get], $allowed)) ? require_once PUBLIC_DIR.'/'.$_GET[$get] : require_once PUBLIC_DIR.'/404.html';
		} elseif (preg_match('/.html/i', $_GET[$get])) {
			$file = PUBLIC_DIR.'/'.$_GET[$get];
			if (!in_array($_GET[$get], $notallowed)) (file_exists($file) && in_array($_GET[$get], $allowed)) ? require_once PUBLIC_DIR.'/'.$_GET[$get] : require_once PUBLIC_DIR.'/404.html';
			else require_once PUBLIC_DIR.'/404.html';
		} elseif (empty($_GET[$get]) || !file_exists($_GET[$get])) require_once PUBLIC_DIR.'/404.html';
	} else require_once PUBLIC_DIR.$default;
}

function showPage() {
	if (!isset($_SESSION['logged-in'])) {
		$notallowed = array('login.php', 'logout.php', 'painel.html');
		$allowed = array('registro.html', 'galeria.html', 'inicio.html', 'visualizar.html');
		incPage('/inicio.html', 'p', $notallowed, $allowed);
	} else {
		$notallowed = array('login.php', 'logout.php', 'inicio.html');
		$allowed = array('painel.html', 'perfil.html', 'imagens.html', 'painel.html', 'visualizar.html', 'sobre.html', 'amigos.html');
		incPage('/painel.html', 'u', $notallowed, $allowed);
	}
}
?>