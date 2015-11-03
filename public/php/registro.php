<?php
require_once '../../inc/global.inc.php';

$name = $_POST['name'];
$surname = $_POST['surname'];
$borndate = $_POST['born-date'];
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
	echo json_encode("1");
}
else {
	echo json_encode("2");
}

?>