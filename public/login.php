<?php
if (empty($_POST['login']) || empty($_POST['password'])) {
	echo $data = 2; //"Este usuário não existe";
} else {
	require_once realpath(dirname(__FILE__).'/../inc/global.inc.php');
	$user = new User();
	$where = array('name' => $_POST['login']);
	if ($array = $user->SelectOne($where)){
		if ($array['password'] == md5($_POST['password'])) {
			if ($_POST['remember'] == '1'){
				$_SESSION['remember'] = 'lembrar';
			}
			$_SESSION['logged-in'] = true;
			echo $data = 0;
		} else {
			echo $data = 1; //"Senhas digitadas não são iguais";
		}
	} else {
		echo $data = 2; //"Este usuário não existe";
	}
}
?>