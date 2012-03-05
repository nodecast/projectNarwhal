<?php
class NewsModel extends CI_Model {

	function __construct()
	{	
		parent::__construct();
		$this->load->library('textformat');
		$this->ci = get_instance();
	}

	function getNews($start = 0, $limit = 5)
	{
		if(!($n = $this->mcache->get('news_'.$start.'_'.$limit))) {
			$n = array();
			$result = $this->mongo->db->news->find()->sort(array('time'=>-1))->limit($limit)->skip($start);
			foreach($result as $item) {
				$item['ago'] = $this->utility->time_diff_string($item['time']);
				$item['html'] = $this->ci->textformat->parse($item['body']);
				array_push($n, $item);
			}
			$this->mcache->set('news_'.$start.'_'.$limit, $n, $this->config->item('news_config'));
		}
		return $n;
	}
}
?>
