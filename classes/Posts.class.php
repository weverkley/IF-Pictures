<?php
require_once 'DB.class.php';
/**
* Classe para gestão de usuários
*/
class Posts extends DB
{
	/**
	* Variável para tabela de usuário;
	*/
	private $posts;

	/**
	*
	*/
	function __construct()
	{
		try {
			parent::__construct();

			$this->posts = ($this->mongo->selectCollection($this->db, 'posts'))? : $this->db->createCollection('posts');
		} catch (MongoConnectionException $e) {
			throw $e;
		}
	}

	public function insertPost($post){
		$timestamp = date('D, d-M-Y');
		$data = array ('_id' => new MongoId(),
			'author' => new MongoId($_SESSION['_id']),
		    'text' => $post,
		    'comments' => array(),
			'totalComments' => 0,
		    'timestamp'=> new MongoDate());
		if ($this->posts->insert($data)){
			return $data;
		} else {
			return false;
		}
	}

	public function insertComment($postid, $userid, $text){
		$data = array (
		    '_id' => new MongoId(),
			'userId' => $userid,
		    'text' => $text,
		    'timestamp' => new MongoDate(),
		    );
		$res = $this->posts->update(array('_id' => $postid), array('$push' => array('comments' => $data),'$inc' => array('totalComments' => 1 )));

		if ($res){
			return $data;
		} else {
			return false;
		}
	}

	public function showPosts($where = null){
		return $this->posts->find($where)->sort(array('_id'=>-1)); 
	}

	public function findAuthor($id){
		return $this->mongo->selectCollection($this->db, 'users')->findOne(array('_id' => new MongoId($id)));
	}
}