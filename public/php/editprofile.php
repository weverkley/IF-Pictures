<?php
require_once '../../inc/global.inc.php';
array_walk_recursive($_POST,function ($item, $key){
	$user = new User();
	$data = array('$set' => array($key => $item));
	$user->Update(array('_id' => $_SESSION['_id']), $data);
    echo "$key holds $item";
});

/*foreach ($_POST as $indice => $valor) {
	$user = new User();
	$data = array('$set' => array($indice => $valor));
	$user->Update(array('_id' => $_SESSION['_id']), $data);
    echo "$indice holds $valor";
}*/
?>