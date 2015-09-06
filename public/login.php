<?php
require_once realpath(dirname(__FILE__).'/../inc/global.inc.php');

$user = new User();
$where = array('name' => $_POST['login'], 'password' => md5($_POST['password']));
if ($array = $user->SelectOne($where)){
	echo $msg['error'] = 1;
} else {
	echo $msg['error'] = 0;
}
?>