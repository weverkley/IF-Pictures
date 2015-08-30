<?php 
// timezone padrão
date_default_timezone_set( "America/Sao_Paulo" );

// dominio do website com http ou https
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
	defined("SITE_URL")
	    || define("SITE_URL", "https://".$_SERVER['SERVER_NAME']);
} else {
	defined("SITE_URL")
    	|| define("SITE_URL", "http://".$_SERVER['SERVER_NAME']);
}
// separador de diretorio
defined("DS")
    || define("DS", DIRECTORY_SEPARATOR);
// diretório root
defined("ROOT_PATH")
    || define("ROOT_PATH", realpath(dirname(__FILE__) . DS."..".DS));
// diretório de classes
defined("CLASSES_DIR")
    || define("CLASSES_DIR", "classes");
// diretório público
defined("PUBLIC_DIR")
    || define("PUBLIC_DIR", "public");
// diretório include
defined("INC_DIR")
    || define("INC_DIR", "inc");
?>