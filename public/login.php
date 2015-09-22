<?php
require_once realpath(dirname(__FILE__).'/../inc/global.inc.php');

$user = new User();
$where = array('name' => $_POST['login']);
if ($array = $user->SelectOne($where)){
	if ($array['password'] == md5($_POST['password'])) {
		echo $data = 0;
	} else {
		echo $data = 1; //"Senhas digitadas não são iguais";
	}
} else {
	echo $data = 2; //"Este usuário não existe";
}
?>