<?php
// open connection to MongoDB server
$conn = new MongoClient();

// access database
$db = $conn->ifpi;

// get GridFS files collection
$grid = $db->getGridFS();
$cursor = $grid->find(array('filename' => new MongoRegex('/^thumb_/')));

foreach ($cursor as $obj) {// iterate through the results
    echo "<img src='search.php?id=".$obj->file['_id']."'><br>";
}
?>