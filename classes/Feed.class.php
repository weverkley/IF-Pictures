<?php
/**
* 
*/
class Feed extends DB
{
	
	private $feed;

	public function __construct()
	{
		try {
			parent::__construct();
			$this->feed = ($this->mongo->selectCollection($this->db, 'feed'))? : $this->db->createCollection('feed');
		} catch (MongoConnectionException $e) {
			throw $e;
		}
	}

	public function showFeed(){
        $friend = new Friends();
        $or = array('$or' => array(array('friend_one' => $_SESSION['_id'], 'status' => 1), array('friend_two' => $_SESSION['_id'], 'status' => 1)));
        $f = $friend->select($or);
        $fv = array();
        $fv[] = $_SESSION['_id'];
        foreach ($f as $d) {
            if ($d['friend_one'] != $_SESSION['_id']) {
                $fv[] = $d['friend_one'];
            }
            if ($d['friend_two'] != $_SESSION['_id']) {
                $fv[] = $d['friend_two'];
            }
        }
        $data = array();
        for ($i=0; $i < count($fv); $i++) { 
            $data[] = $this->feed->find(array('userid' => $fv[$i]))->sort(array('_id' => -1));
        }
        /*var_dump($data);*/
        $result = array();
        if (count($data) > 0 ){
            for ($i=0; $i < count($data); $i++) {
                foreach ($data[$i] as $file) {
                    $result[] = $file;
                }
            }
            function sortByOption($a, $b) {
              return strcmp($b['timestamp'], $a['timestamp']);
            }
            usort($result, 'sortByOption');
            $un = new User();
            if($result != 0){
	            foreach ($result as $file) {
	                if (file_exists('public/upload/thumbnail/'.$file['hash'])) {
	                    echo '<div class="Image_Wrapper ImageWrapper ContentWrapperB chrome-fix">
	                            <a><img src="public/upload/thumbnail/'.$file['hash'].'" /></a>
	                        
                            <div class="ContentB">
                                <div class="Content">
                                    <h2>'.$file['name'].'</h2>Autor: '.$un->getName($file['userid']).'<br>Data: '.date('d-m-Y H:i:s', $file['timestamp']->sec).'
                                    <br><a target="_blank" class="btn btn-xs btn-success" href="'.SITE_URL.'/index.php?u=visualizar.html&image='.$file['hash'].'"><i class="fa fa-search"></i></a>
                                </div>
                            </div>
                            </div>
                            ';
	                }
	            }
	        } else {
	        	echo '<p style="text-center">Não há Nenhuma notícia a ser mostrada.</p>';
	        }
        } else {
            echo '<p style="text-center">Não há Nenhuma notícia a ser mostrada.</p>';
        }
	}
}
?>