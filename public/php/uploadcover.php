<?php
require_once '../../inc/global.inc.php';

$valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "PNG", "JPG", "JPEG", "GIF", "BMP");
if (isset($_POST) && $_SERVER['REQUEST_METHOD'] == "POST" && isset($_SESSION['_id'])) {
    $name = $_FILES['photoimg']['name'];
    $size = $_FILES['photoimg']['size'];
    
    if (strlen($name)) {
        $ext = Utils::getExtension($name);
        if (in_array($ext, $valid_formats)) {
            if ($size < (1024 * 1024)) {
                $hash = time() . $_SESSION['_id'] . "." . $ext;
                $bgSave = '<div id="uX' . $_SESSION['_id'] . '" class="bgSave wallbutton blackButton btn-file"><button type="button" class="btn btn-success" style="font-weight: bold;"><i class="fa fa-floppy-o"></i></button></div>';

                $conn = new MongoClient();         // Connect
			    $db = $conn->ifpi;                // Select DB
			    $grid = $db->getGridFS();                    // Initialize GridFS
			    $file = $grid->storeUpload('photoimg');    // Store uploaded file to GridFS
			    //echo $id;
			    
                if ($file){
                	$user = $db->users;
                    $data = array('$set' => array('cover' => $file));
                    $res = $user->update(array('_id' => $_SESSION['_id']), $data);
                    if ($res){
                    	echo $bgSave . '<img src="public/php/search.php?id='.$file.'"  id="timelineBGload" class="headerimage ui-corner-all" style="top:0px"/>';
			    		$conn->close(); // Close connection
			    	}
                } 
                else {
                    echo "Fail upload folder with read access.";
                }
            } 
            else echo "Image file size max 1 MB";
        } 
        else echo "Invalid file format.";
    } 
    else echo "Please select image..!";
    
    exit;
}
?>