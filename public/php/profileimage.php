<?php
require_once '../../inc/global.inc.php';
$acceptedExtension = Array('image/jpeg', 'image/jpg');
$maxSize = 256000;
$imgType = $_FILES["imageProfile"]["type"];
$imgSize = $_FILES["imageProfile"]["size"];
list($txt, $ext) = explode("image/", $imgType);
if (in_array($imgType, $acceptedExtension) && $imgSize <= $maxSize && $imgSize != "") {
    $conn = new MongoClient();
	$db = $conn->ifpi;
	$grid = $db->getGridFS();
	$file = $grid->storeUpload('imageProfile');
	if($file) {
 		$user = $db->users;
        $data = array('$set' => array('profilepicture' => $file));
        $res = $user->update(array('_id' => $_SESSION['_id']), $data);
		$text = '<div class="alert alert-success" role="alert">Imagem de perfil atualizada com sucesso.</div>';
		$dataBack = array('text' => $text, 'imgURL' => 'public/php/search.php?id='.$file);
		$_SESSION['profilepicture'] = 'public/php/search.php?id='.$file;
	}
} else {
	if (!in_array($imgType, $acceptedExtension)) $text = '<div class="alert alert-danger" role="alert">Formato errado, Formatos aceitos: jpeg, jpg.</div>';
	if ($imgSize > $maxSize) $text = '<div class="alert alert-danger" role="alert">Imagem muito grande, tamanho maximo 256 Kb.</div>';
	if ($imgSize == "") $text = '<div class="alert alert-danger" role="alert">Por favor escolha uma imagem.</div>';
	$dataBack = array('text' => $text);
}
echo json_encode($dataBack);
?>