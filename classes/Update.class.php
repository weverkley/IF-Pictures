<?php

/**
* Classe para gestão de  atualizações
*/
class Update extends DB
{
	/**
	* Variável para tabela de atualizações;
	*/
	private $update;

	function __construct()
	{
		try {
			parent::__construct();
			$this->update = ($this->mongo->selectCollection($this->db, 'update'))? : $this->db->createCollection('update');
		} catch (MongoConnectionException $e) {
			throw $e;
		}
	}

	public function view(){
		return $this->update->find();
	}
}