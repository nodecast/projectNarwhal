<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{  
		if($this->utility->logged_in()) {
			$this->load->model('newsmodel');
			$this->load->model('statsmodel');

			$data = array();
			$data['user'] = $this->session->all_userdata();
			$data['news'] = $this->newsmodel->getNews();

			$stats = array();
			$stats['max_users'] = number_format($this->config->item('max_users'));
			$stats['enabled_users'] = number_format($this->statsmodel->getEnabledUsers());
			$stats['online_users'] = number_format($this->statsmodel->getActiveUsers(60 * 10));
			$stats['users_active_day'] = number_format($this->statsmodel->getActiveUsers(24 * 3600));
			$stats['users_active_week'] = number_format($this->statsmodel->getActiveUsers(7 * 24 * 3600));
			$stats['users_active_month'] = number_format($this->statsmodel->getActiveUsers(30 * 24 * 3600));
			$stats['torrents'] = number_format($this->statsmodel->getTorrents());
			$r = $this->statsmodel->getRequests();
			$stats['requests'] = number_format($r);
			$stats['requests_percent'] = number_format(($this->statsmodel->getRequestsFilled() / ($r == 0 ? 1 : $r)) * 100, 2);
			$stats['snatches'] = number_format($this->statsmodel->getSnatches());
			
			//TODO peer stats

			$data['stats'] = $stats;
			$this->utility->page_title('News');
			$this->load->view('index/privateindex', $data);
		} else {
			$this->utility->page_title('');
			$this->load->view('index/publicindex');
		}
	}
}
