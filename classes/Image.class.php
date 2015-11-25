<?php

/**
* Classe para gestão de  imagens
*/
class Image extends DB
{
	/**
	* Variável para tabela de imagens;
	*/
	private $images;

	/**
	* Variável para manter a tabela onde estão guardadas as imgagens;
	*/
	private $grid;

	/**
	*
	*/
	private $fileName;
	/**
	* Construtor da classe extendendo a conexão com o banco.
	*/
	function __construct()
	{
		try {
			parent::__construct();

			$this->images = ($this->mongo->selectCollection($this->db, 'images'))? : $this->db->createCollection('images');
			$this->grid = $this->db->getGridFS();
		} catch (MongoConnectionException $e) {
			throw $e;
		}
	}

	/**
	* Método para inserir imagens no banco.
	* Corta a thumbnail, armazena e também armazena a imagem original.
	*/
	public function upload($FILE){
		try {
		    $base = dirname(__DIR__);
		    $thumbnail = sprintf('%s/%s', $base, "public/upload/thumbnail/");
		    $large = sprintf('%s/%s', $base, "public/upload/large/");

		    $path_parts = pathinfo($FILE['name']);
		    $extension = $path_parts['extension'];
		    $this->fileName = $FILE['name'];
		    $hash = md5($FILE['name']).'_'.date('dmYHis').'.'.$extension;
		    //check and set folder permission 
		    
		    Utils::createFolder($thumbnail);
		    Utils::createFolder($large);

		    $imgThumb = new SimpleImage();
		    $imgThumb->load($FILE['tmp_name']);
		    $imgThumb->best_fit(350, 200);
		    //$img->crop(250, 150, 0, 0);
		    $imgThumb->save($thumbnail.$hash);

		    $imgLarge = new SimpleImage();
		    $imgLarge->load($FILE['tmp_name']);
		    $imgLarge->save($large.$hash);

		    $data = array(
		    	'owner' => $_SESSION['_id'],
		    	'hash' => $hash,
		    	'name' => $this->fileName,
		    	'descripton' => null,
		    	'comments' => array(),
		    	'total' => 0,
		    	'timestamp' => new MongoDate(),
		    	'protected' =>  false
			);

			$this->images->insert($data);

		    return $data;
		} catch (Exception $e) {
		    throw new Exception($e->getMessage());
		}
	}

	/**
	* Método para retornar imagens.
	*/
	public function ImageFind($array = array()){
		return $this->images->find($array)->sort(array('_id'=>-1));
	}

	/**
	* Método para apagar imagens.
	*/
	public function delete($hash){
		$feed = $this->mongo->selectCollection($this->db, 'feed');
		$feed->remove(array('hash' => $hash), array("justOne" => true));
		$this->images->remove(array('hash' => $hash), array("justOne" => true));
		unlink(PUBLIC_DIR.'/upload/large/'.$hash);
		unlink(PUBLIC_DIR.'/upload/thumbnail/'.$hash);
	}

	/**
	* Método para retornar imagens.
	*/
	public function Gridfind($array){
		return $this->grid->find($array);
	}

	/**
	* Método para retornar uma imagen.
	*/
	public function GridfindOne($array){
		return $this->grid->findOne($array);
	} 

	/**
	* Método para retornar uma imagen.
	*/
	public function getImagem($hash){
		return $this->images->find(array('hash' => $hash))->limit(1);
	}

	public function insertComment($id, $userid, $text){
		$data = array (
		    '_id' => new MongoId(),
			'userId' => $userid,
			'profilepicture' => $_SESSION['profilepicture'],
		    'text' => $text,
		    'timestamp' => new MongoDate(),
		    );
		$res = $this->images->update(array('_id' => $id), array('$push' => array('comments' => $data),'$inc' => array('totalComments' => 1 )));

		if ($res){
			return $data;
		} else {
			return false;
		}
	}
	
	public function __destruct(){
		$this->mongo->close();
	}
}
?>