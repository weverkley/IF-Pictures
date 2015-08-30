<?php 
/**
*  Classe para conexão com banco de dados MongoDB
*/
class DB
{
	
	private $mongo = null;
	private $db = null;

	/**
	 * Construtor para a classe.
	 */
	public function __construct($db="ifpi")
	{
		$this->mongo = new MongoClient();
		$this->db = $this->mongo->selectDB($db);
	}
}
?>