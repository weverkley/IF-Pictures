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
	private $idThumb;

	/**
	*
	*/
	private $idMain;

	/**
	*
	*/
	private $idImage;

	/**
	* diretório temporário para armazenar imagens
	*/
	private $path = 'temp/';

	/**
	*
	*/
	private $thumbName;

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
		    $this->thumbName = Utils::clearText('thumb_'.$FILE['name']);
		    $this->fileName = Utils::clearText($FILE['name']);
		    $filetype = $FILE['type'];

		    self::makeThumb($FILE);

		    $files = scandir($this->path);
		    foreach ($files as $thumbTemp){
		        if(($thumbTemp != '.') && ($thumbTemp != '..') && ($thumbTemp == $this->thumbName)){
		            $realpath = $_SERVER['DOCUMENT_ROOT'].'/IF-Pictures/public/php/'.$this->path.$thumbTemp; // Caminho absoluto até o arquivo
		            $this->idThumb = $this->grid->storeFile($realpath, array('filename' => $this->thumbName, 'filetype' => $filetype, 'owner' => $_SESSION['_id'])); // Guardar thumbnail
		            $this->idMain = $this->grid->storeUpload('upload', array('filename' => $this->fileName, 'filetype' => $filetype, 'owner' => $_SESSION['_id'])); // Upload da imagem
		            unlink($realpath);
		        }
		    }

		    $data = array(
		    	'owner' => $_SESSION['_id'],
		    	'imageName' => $this->fileName,
		    	'imageId' => $this->idMain,
		    	'thumbName' => $this->thumbName,
		    	'thumbId' => $this->idThumb,
		    	'type' => $FILE['type'],
		    	'date' => new MongoDate(),
		    	'protected' =>  false
			);

			$this->idImage = $this->images->insert($data);

		    return 'Main ID: '.$this->idMain.'<br>Thumbnail ID: '.$this->idThumb;
		} catch (Exception $e) {
		    throw new Exception($e->getMessage());
		}
	}

	/**
	* Método para criar a thumbnail.
	*/
	public function makeThumb($FILE){
		$img = new SimpleImage();
		$img->load($FILE['tmp_name']);
		$img->resize(250, 150);
		$img->crop(250, 150, 0, 0);
		$img->save($this->path.Utils::clearText($this->thumbName));
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