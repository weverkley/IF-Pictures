<?php
$id = $_GET['id'];
try {

    // open connection to MongoDB server
    $conn = new MongoClient();

    // access database
    $db = $conn->ifpi;

    // get GridFS files collection
    $grid = $db->getGridFS();

    // retrieve file from collection
    $object = $grid->findOne(array('_id' => new MongoId($id)));

    //find the chunks for this file
    $chunks = $conn->ifpi->fs->chunks->find(array('files_id' => $object->file['_id']))->sort(array('n' => 1));
    //header('Content-type: '.$object->file['filetype']);
    header('Content-type: image/png');

    //output the data in chunks
    foreach($chunks as $chunk){
        echo $chunk['data']->bin;
    }

    // disconnect from server
    $conn->close();
}
catch(MongoConnectionException $e) {
    die('Error connecting to MongoDB server');
}
catch(MongoException $e) {
    die('Error: ' . $e->getMessage());
}
?>