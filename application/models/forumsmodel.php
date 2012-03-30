<?php
class ForumsModel extends CI_Model {

	function __construct()
	{	
		parent::__construct();
	}
	
	/*
	Gets the list of forums.
	*/
	function getForums() {
		if(($data = $this->mcache->get('forums_list')) === FALSE) {
			$data = $this->mongo->db->forum_forums->find()->sort(array('weight' => 1));
			$data = iterator_to_array($data);
			$this->mcache->set('forums_list', $data, $this->config->item('forums_cache'));
		}
		return $data;
	}
	
	/*
	Gets data for a specific forum
	*/
	function getForum($id) {
		if(($data = $this->mcache->get('forums_'.$id)) === FALSE) {
			$data = $this->mongo->db->forum_forums->findOne(array('_id' => new MongoId($id)));
			$this->mcache->set('forums_'.$id, $data, $this->config->item('forums_cache'));
		}
		return $data;
	}
	
	/*
	Gets data for a specific thread
	*/
	function getThread($id) {
		if(($data = $this->mcache->get('forums_thread_'.$id)) === FALSE) {
			$data = $this->mongo->db->forum_threads->findOne(array('_id' => new MongoId($id)));
			$this->mcache->set('forums_thread_'.$id, $data, $this->config->item('forums_cache'));
		}
		return $data;
	}
	
	/*
	Gets data for a specific post
	*/
	function getPost($id) {
		if(($data = $this->mcache->get('forums_post_'.$id)) === FALSE) {
			$data = $this->mongo->db->forum_posts->findOne(array('_id' => new MongoId($id)));
			$this->mcache->set('forums_post_'.$id, $data, $this->config->item('forums_cache'));
		}
		return $data;
	}
	
	/*
	Gets the number of threads in a given forum
	*/
	function countThreadsInForum($id) {
		if(($data = $this->mcache->get('forums_count_threads_'.$id)) === FALSE) {
			$data = $this->mongo->db->forum_threads->find(array('forum' => new MongoId($id)))->count();
			$this->mcache->set('forums_count_threads_'.$id, $data, $this->config->item('forums_cache'));
		}
		return $data;
	}
	
	/*
	Gets the number of posts in a given forum
	*/
	function countPostsInForum($id) {
		if(($data = $this->mcache->get('forums_count_posts_'.$id)) === FALSE) {
			$data = $this->mongo->db->forum_posts->find(array('forum' => new MongoId($id)))->count();
			$this->mcache->set('forums_count_posts_'.$id, $data, $this->config->item('forums_cache'));
		}
		return $data;
	}
	
	/*
	Gets the most recent post in a given forum
	*/
	function getMostRecentPost($id) {
		if(($data = $this->mcache->get('forums_recent_post_'.$id)) === FALSE) {
			$data = $this->mongo->db->forum_posts->find(array('forum' => new MongoId($id)))->sort(array('time' => -1))->limit(1);
			$data = $data->hasNext() ? $data->getNext() : null;
			$this->mcache->set('forums_recent_post_'.$id, $data, $this->config->item('forums_cache'));
		}
		return $data;
	}
}
?>
