<?php
class NewsModel extends CI_Model {

	function __construct()
	{	
		parent::__construct();
	}

	function getNews($start = 0, $limit = 5)
	{
		$news = array();
		$result = $this->mongo->db->news->find()->sort(array('time'=>-1))->limit($limit)->skip($start);
		foreach($result as $item) {
			$item['ago'] = $this->utility->time_diff_string($item['time']);
			array_push($news, $item);
		}
		return $news;
	}
}
?>
