<?php
require_once '../../inc/global.inc.php';
if (isset($_GET['page']) && $_GET['page'] != '') {
    $page = $_GET['page'];
    $limit = 16;
    ($page == 1)? $skip = 0 : $skip = ($page - 1) * $limit;

    $image = new Image();
	$cursor = $image->Gridfind(array('filename' => new MongoRegex('/^thumb_/')))->skip($skip)->limit($limit);
    if ($cursor->count() > 0) {
        foreach ($cursor as $obj) {
			echo '<div class="col-lg-3 col-md-4 col-xs-6 thumb">';
		    echo '<img class="img-responsive lazy thumbnails" src="public/php/search.php?id='.$obj->file['_id'].'" ><br>';
		    echo '</div>';
		    echo "<input type='hidden' class='nextpage' value='" . ($page + 1) . "'><input type='hidden' class='isload' value='true'>";
		}
    } else echo "<input type='hidden' class='isload' value='false'><p class='text-center'>Não há imagens a se mostrar.</p>";
}
?>