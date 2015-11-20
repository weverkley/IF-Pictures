<?php
require_once 'DB.class.php';
/**
* Classe para gestão de usuários
*/
class User extends DB
{
	/**
	* Variável para tabela de usuário;
	*/
	private $users;

	private $select;

	/**
	*
	*/
	function __construct()
	{
		try {
			parent::__construct();

			$this->users = ($this->mongo->selectCollection($this->db, 'users'))? : $this->db->createCollection('users');
		} catch (MongoConnectionException $e) {
			throw $e;
		}
	}

	/**
	* Método para inserir um usuário no banco.
	*	$users = new user();
	*	$data = array('coluna' => 'valor', 'data' => new MongoDate());
	*	$users->Insert($data);
	*/
	public function Insert($data){
		try {
			$this->users->insert($data);
			return true;
		} catch (Exception $e) {
			return false;
		}
	}

	/**
	* Método para retornar vários usuário no banco.
	*	$users = new user();
	* 	$t = $users->Select();
	*	foreach ($t as $user) {
	*		echo $user['name'];
	*		echo $user['login'];
	*	}
	*/
	public function Select($where = array()){
		try {
			$this->select = $this->users->find($where);
			return $this->select;
		} catch (Exception $e) {
			return false;
		}
	}

	/**
	* Método para retornar um usuários no banco.
	*	$users = new user();
	* 	$where= array('login' => 'valor');
	* 	$t = $users->SelectOne($where);
	*/
	public function SelectOne($where){
		try {
			$this->select = $this->users->findOne($where);
			return $this->select;
		} catch (Exception $e) {
			return false;
		}
	}
	/**
	* Método para alterar um usuário do banco.
	*	$users = new user();
	*	$id = $_POST["id"];
	*	$where = array('_id' => new MongoId($id));
	*	$data = array('coluna' => 'valor');
	*	$users->Update($data, $where);
	*/
	public function Update($where, $data){
		try {
			$this->users->update($where, $data);
			return true;
		} catch (Exception $e) {
			return false;
		}
	}


	/**
	* Método para deletar um usuário do banco.
	*	$users = new user();
	*	$id = $_POST["id"];
	*	$where = array('_id' => new MongoId($id));
	*	$data = array('coluna' => 'valor');
	*	$users->Delete($data, $where);
	*/
	public function Delete($data, $where){
		try {
			if ($this->users->count($where) == 1){
				$this->users->remove($where);
				return true;
			} else return false;
		} catch (Exception $e) {
			return false;
		}
	}

	/**
	* Método para contar usuários do banco.
	*	$users = new user();
	*	$users->Count();
	*/
	public function Count(){
		try {
			return $this->users->count();
		} catch (Exception $e) {
			return false;
		}
	}
}
?>