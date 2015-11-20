<?php
require_once '../../inc/global.inc.php';


$conn = new MongoClient();         // Connect
$db = $conn->ifpi;                // Select DB
$user = $db->users;

if(isset($_POST['position']) && isset($_SESSION['_id'])){
    $data = array('$set' => array('position' => $_POST['position']));
    $res = $user->update(array('_id' => $_SESSION['_id']), $data);
	if($res) echo $_POST['position'];
}
?>