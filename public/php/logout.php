<?php
if(isset($_POST['action'])  && $_POST['action'] == "logout" ){
    session_start();
	session_destroy();
}
?>