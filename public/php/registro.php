<?php
require_once '../../inc/global.inc.php';
$data = 0;
$user = new User();
if ($_POST['email']) {
	$where = array('email' => $_POST['email']);
	if($user->SelectOne($where)){
		$data = 1; // email existe
	}
}
if ($_POST['login']) {
	$where = array('login' => $_POST['login']);
	if($user->SelectOne($where)){
		$data = 2; // login existe
	}
}

if ($data == 0) {
	$name = $_POST['name'];
	$surname = $_POST['surname'];
	$borndate = $_POST['born'];
	$sex = $_POST['sex'];
	$login = $_POST['login'];
	$password = $_POST['password'];
	$rpassword = $_POST['rpassword'];
	$email = $_POST['email'];
	$question = $_POST['question'];
	$answer = $_POST['answer'];

	$user = new User();
	$data = array(
		'name' => $name,
		'surname' => $surname,
		'borndate' => $borndate,
		'sex' => $sex,
		'login' => $login,
		'password' => md5($password),
		'email' => $email,
		'question' => $question,
		'answer' => $answer,
		//----//
		'avatar' => null,
		'cover' => null,
		'thoughts' => array(),
		'job' => null,
		'state' => null,
		'city' => null,
	);
	if($user->Insert($data)){
		echo 3;
	}
} else echo $data;

?>