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
		    	'uploaded' => new MongoDate(),
		    	'protected' =>  false
			);

			$this->images->insert($data);

		    return 'Main file: '.$this->fileName;
		} catch (Exception $e) {
		    throw new Exception($e->getMessage());
		}
	}

	/**
	* Método para retornar imagens.
	*/
	public function ImageFind($array){
		return $this->images->find($array);
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

	public function __destruct(){
		$this->mongo->close();
	}
}
?>