<?php
class UserModel extends CI_Model {

	function __construct()
	{	
		parent::__construct();
	}

	/*
	Gets the data for a given username.
	*/
	function getData($id, $cache = true) {
		if($cache) {
			if(!($data = $this->mcache->m->get('user_'.$id.'_data'))) {
				$data = $this->mongo->db->users->findOne(array('id'=>$id));
				$this->mcache->m->set('user_'.$id.'_data', $data, $this->config->item('userdata_cache'));
			}
			return $data;
		} else {
			return $this->mongo->db->users->findOne(array('id'=>$id));
		}
	}
}
?>
