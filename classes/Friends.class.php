<?php

/**
* Classe para gestão de  imagens
*/
class Friends extends DB
{
	/**
	* Variável para tabela de imagens;
	*/
	private $friends;

	function __construct()
	{
		try {
			parent::__construct();
			$this->friends = ($this->mongo->selectCollection($this->db, 'friends'))? : $this->db->createCollection('friends');
		} catch (MongoConnectionException $e) {
			throw $e;
		}
	}

	public function add($data){
		//INSERT INTO friends (friend_one,friend_two) VALUES ('$user_id','$friend_id');
		$this->friends->insert($data);
	}

	public function confirm($id){
		//UPDATE friends SET status="1" WHERE (friend_one="$user_id" OR friend_two="$user_id") AND (friend_one="$friend_id" OR friend_two="$friend_id");
		return $this->friends->update(array('_id' => $id), array('$set' => array('status' => 1)));
	}

	public function decline($id){
		//UPDATE friends SET status="1" WHERE (friend_one="$user_id" OR friend_two="$user_id") AND (friend_one="$friend_id" OR friend_two="$friend_id");
		return $this->friends->remove(array('_id' => $id));
	}

	public function check($data = array()){
		/*SELECT * FROM friends WHERE
		(friend_one="$user_id" OR friend_two="$user_id")
		AND
		(friend_one="$friend_id" OR friend_two="$friend_id")*/

		$cond0 = array('friend_one' => $data['_id']);
		$cond1 = array('friend_one' => new MongoId($data['search']));
		$cond2 = array('friend_two' => new MongoId($data['search']));
		$cond3 = array('friend_two' => $data['_id']);
		$or0 = array('$or' => array($cond0, $cond1));
		$or1 = array('$or' => array($cond2, $cond3));
		return $this->friends->find(array('$and' => array($or0, $or1)));
		
	}

	public function select($data = array()){
		if (empty($data)){
			return $this->friends->find();
		} else {
			return $this->friends->find($data);
		}
	}

	public function countRequest(){
		try {
			$where = array('friend_two' => $_SESSION['_id'], 'status' => 0);
			$res = $this->friends->find($where);
			return $res->count();
		} catch (Exception $e) {
			return 0;
		}
	}

	public function friendRequest(){
		try {
			$where = array('friend_two' => $_SESSION['_id'], 'status' => 0);
			$r = $this->friends->find($where);
			 if ($r->count() > 0) {
				$div = "";
				$user = new User();
				foreach ($r as $v) {
					$u = $user->SelectOne(array('_id' => $v['friend_one']));
					$div .= '<li id="'.$v['_id'].'" class="dropdown-submenu">
							 <a href="index.php?u=perfil.html&search='.$u['_id'].'">'.$u['name'].'</a><a class="pull-right" tabindex="-1" href=""><i class="fa fa-bars"></i></a>
							 <ul class="dropdown-menu">
							 	<li role="presentation" align="center" style="margin-bottom: 3px;"><button type="button" name="'.$v['_id'].'" class="btn btn-xs btn-primary" onclick="confirmDropdown(this.name);"><i class="fa fa-plus-square"></i> Confirmar</button></li>
							 	<li role="presentation" align="center"><button type="button" name="'.$v['_id'].'" class="btn btn-xs btn-warning" onclick="declineDropdown(this.name);"><i class="fa fa-minus-square"></i> Recusar</button></li>
							 </ul>
							 </li>';
					/*$div .= '<button type="button" class="pull-right btn btn-xs btn-primary"><span class="fa fa-plus"></span> Confirmar</button></li>';*/
			        $div .= '<li id="'.$v['_id'].'" class="divider"></li>';
				}
			    return $div;
			 }else return '<li class="text-center">Nenhum pedido pendente.</li>';
		} catch (Exception $e) {
		}
	}
}