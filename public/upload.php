<?php
$m = new Mongo();
$db = $m->example;
$gridFS = $db->getGridFS();

$id = 123;

// store
$gridFS->storeFile("someFile.jpg", array("_id" => $id));

// retrieve
echo $gridFS->findOne(array("_id" => $id))->getBytes();
?>