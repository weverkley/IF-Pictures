<?php
require_once '../../inc/global.inc.php';
$data = 0;
$user = new User();
if ($_POST['email'] && $_POST['question'] && $_POST['answer']) {
	$where = array('email' => $_POST['email'], 'question' => $_POST['question'], 'answer' => $_POST['answer']);
	if(!$user->SelectOne($where)){
		$data = 1; // dados invalidos
	}
}

if ($data == 0) {
	$data = array('$set' => array('password' => md5($_POST['password'])));
	if($user->Update(array('email' => $_POST['email']), $data)){
		echo 2; //atualizou
	}
} else echo $data;

?>