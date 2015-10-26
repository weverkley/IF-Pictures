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
$ansewr = $_POST['ansewr'];

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
	'ansewr' => $ansewr
);
$user->Insert($data);

?>