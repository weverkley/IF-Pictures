<?php
try {
    $conn = new MongoClient();
    $db = $conn->ifpi;
    $grid = $db->getGridFS();
    $file = $grid->findOne(array('_id' => new MongoId($_GET['id'])));
    //header('Content-type: '.$file->file['filetype']);
    echo $file->getBytes();
    $conn->close();
    exit;
}
catch(MongoConnectionException $e) {
    die('Error connecting to MongoDB server');
}
catch(MongoException $e) {
    die('Error: ' . $e->getMessage());
}
?>