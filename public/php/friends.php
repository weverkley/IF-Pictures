<?php
require_once '../../inc/global.inc.php';
if (isset($_POST) && !empty($_POST)) {
	$friend = new Friends();
	switch ($_POST['action']) {
		case 'add':
			$where = array('_id' => $_SESSION['_id'], 'search' => $_POST['search']);
			$data = array('friend_one' => $_SESSION['_id'], 'friend_two' => new MongoId($_POST['search']), 'status' => 0);
			if ($friend->check($where)->count() == 0) {
				echo ($friend->add($data))? 0 : 1;
			}
			break;
		case 'confirm':
			echo ($friend->confirm(new MongoId($_POST['id'])))? 1 : 0;
			break;
		case 'decline':
			echo ($friend->decline(new MongoId($_POST['id'])))? 1 : 0;
			break;
		case 'check':
			$friend->check($data);
			break;
	}
}
?>