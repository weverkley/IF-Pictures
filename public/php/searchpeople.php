<?php
require_once '../../inc/global.inc.php';
if (isset($_POST['search_keyword'])) {
	$string = $_POST['search_keyword'];
	$user = new User();
	$name = array('name' => new MongoRegex('/.'.$string.'./i') );
	$surname = array('surname' => new MongoRegex('/.'.$string.'./i') );
	$nameUpper = array('name' => new MongoRegex('/^'.$string.'./i') );
	$surnameUpper = array('surname' => new MongoRegex('/^'.$string.'./i') );

	$where = array('$or' => array($name, $surname, $nameUpper, $surnameUpper));
	$cursor = $user->Select($where);

    if ($cursor === false) {
        throw new Exception("Error Processing Request", 1);
    } 
    else {
		$count = $cursor->count();
    }
    
    $boldString = '<strong>' . $string . '</strong>';
    if ($count > 0) {
        foreach ($cursor as $field) {
        	echo '<a href="index.php?u=perfil.html&search='.$field['_id'].'"><div class="show" align="left"><img src="public/img/panel/user_male.png" width="30" alt=""> <span class="searchName">'.$field['name'].' '.$field['surname'].'</span></div></a>';
        }
    } 
    else {
        echo '<div>Nenhum resultado foi encontrado.</div>';
    }
}
?>