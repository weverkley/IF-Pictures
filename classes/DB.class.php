<?php
/**
*  Classe para conexão com banco de dados MongoDB
*/
class DB
{

	protected $mongo = null;
	protected $db = null;

	/**
	 * Construtor para a classe.
	 */
	public function __construct($db="ifpi")
	{
		try{
			$this->mongo = new MongoClient();
			$this->db = $this->mongo->selectDB($db);
		} catch (MongoConnectionException $e) {
			//throw $e;
			throw new Exception('Erro na conexão com o banco de dados!');
		}
	}

	public function __destruct(){
		$this->mongo->close();
	}
}
?>