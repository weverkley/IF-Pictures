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
	$sex = $_POST['sex'];
	$user = new User();
	$data = array(
		'name' => $_POST['name'],
		'surname' => $_POST['surname'],
		'borndate' => $_POST['born'],
		'sex' => $sex,
		'login' => $_POST['login'],
		'password' => md5($_POST['password']),
		'email' => $_POST['email'],
		'question' => $_POST['question'],
		'answer' => $_POST['answer'],
		'cover' => null,
		if ($sex == 'm') {
			'profilepicture' => 'public/img/panel/user_male.png',
		} else {
			'profilepicture' => 'public/img/panel/user_female.png',
		}
		'job' => null,
		'state' => null,
		'city' => null,
	);
	if($user->Insert($data)){
		echo 3;
	}
} else echo $data;
?>