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
	Gets threads in a specific forum
	*/
	function getThreads($forum, $limit = 25, $skip = 0) {
		$key = 'forums_threads_forum_'.$forum.'_'.$limit.'_'.$skip;
		
		if(($data = $this->mcache->get($key)) === FALSE) {
			$result = $this->mongo->db->forum_threads->find(array('forum' => new MongoId($forum)))->sort(array('stickied' => -1, 'lastupdate' => -1))->limit($limit)->skip($skip);
			$array = iterator_to_array($result);
			$data = array('data' => $array, 'count' => $result->count());
			$this->mcache->set($key, $data, $this->config->item('forums_cache'));
		}
		return $data;
	}
	
	/*
	Gets the last post in a thread, as well as the total number of posts
	*/
	function getLastPost($thread) {
		$key = 'forums_lastpost_'.$thread;
		
		if(($data = $this->mcache->get($key)) === FALSE) {
			$result = $this->mongo->db->forum_posts->find(array('thread' => new MongoId($thread)))->sort(array('time' => -1));
			$count = $result->count();
			$result = $result->hasNext() ? $result->getNext() : null;
			$data = array('data' => $result, 'count' => $count);
			$this->mcache->set($key, $data, $this->config->item('forums_cache'));
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
	Gets the posts in a specific thread
	*/
	function getPosts($thread, $limit = 25, $skip = 0) {
		$key = 'forums_posts_thread_'.$thread.'_'.$limit.'_'.$skip;
		
		if(($data = $this->mcache->get($key)) === FALSE) {
			$result = $this->mongo->db->forum_posts->find(array('thread' => new MongoId($thread)))->sort(array('time' => 1))->limit($limit)->skip($skip);
			$array = iterator_to_array($result);
			$data = array('data' => $array, 'count' => $result->count());
			$this->mcache->set($key, $data, $this->config->item('forums_cache'));
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
	Gets the number of posts in a given thread
	*/
	function countPostsInThread($id) {
		if(($data = $this->mcache->get('forums_thread_count_posts_'.$id)) === FALSE) {
			$data = $this->mongo->db->forum_posts->find(array('thread' => new MongoId($id)))->count();
			$this->mcache->set('forums_thread_count_posts_'.$id, $data, $this->config->item('forums_cache'));
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
	
	/*
	Marks all forums and threads as read for a user
	*/
	function catchup($user) {
		$this->mongo->db->users->update(array('_id' => new MongoId($user)), array('$set' => array('catchuptime' => time())));
		$this->mongo->db->forum_forums->update(array(), array('$addToSet' => array('read' => new MongoId($user))), array('multiple' => true));
	}
	
	/*
	Marks a forum as read for a specific user
	*/
	function markForumAsRead($forum, $user) {
		$this->mongo->db->forum_forums->update(array('_id' => new MongoId($forum)), array('$addToSet' => array('read' => new MongoId($user))));
	}
	
	/*
	Creates a thread in the given forum, by the given user, with the given title, with the given body
	Returns the _id of the new thread.
	*/
	function createThread($forum, $owner, $title, $body) {
		$thread = array('forum' => new MongoId($forum), 'name' => $title, 'owner' => new MongoId($owner), 'read' => array(new MongoId($owner)), 'lastupdate' => time(), 'locked' => false, 'stickied' => false);
		$this->mongo->db->forum_threads->save($thread);
		
		$post = array('forum' => $thread['forum'], 'thread' => $thread['_id'], 'owner' => $thread['owner'], 'time' => time(), 'body' => $body, 'lastedit' => array());
		$this->mongo->db->forum_posts->save($post);
		
		$this->mcache->delete('forums_threads_forum_'.$thread['forum'].'_'.$this->config->item('threads_perpage').'_0');
		
		return $thread['_id'];
	}
	
	/*
	Changes the lastupdate on a thread to time()
	*/
	function updateThread($thread) {
		$this->mongo->db->forum_threads->update(array('_id' => new MongoId($thread)), array('$set' => array('lastupdate' => time())));
	}
	
	/*
	Adds a reply to the given thread, returns an array of the new post containing the page that it's on, as well as the 
	*/
	function replyToThread($thread, $owner, $body) {
		$thread = $this->getThread($thread);
		$this->updateThread($thread['_id']);
		$post = array('forum' => $thread['forum'], 'thread' => $thread['_id'], 'owner' => new MongoId($owner), 'time' => time(), 'body' => $body, 'lastedit' => array());
		$this->mongo->db->forum_posts->save($post);
		
		$this->mcache->delete('forums_threads_forum_'.$thread['forum'].'_'.$this->config->item('threads_perpage').'_'.(0));
		$this->mcache->delete('forums_thread_count_posts_'.$thread['_id']);
		
		$postsperpage = $this->config->item('posts_perpage');
		$page = floor($this->countPostsInThread($thread['_id']) / $postsperpage) + 1;
		$this->mcache->delete('forums_posts_thread_'.$thread['_id'].'_'.$postsperpage.'_'.($postsperpage * ($page - 1)));
		
		return array('_id' => $post['_id'], 'page' => $page);
	}
	
	/*
	Edits the given post
	*/
	function editPost($post, $body) {
		$this->mongo->db->forum_posts->update(array('_id' => new MongoId($post)), array('$set' => array('body' => $body)));
		$this->mcache->delete('forums_post_'.$post);
	}
}
?>
