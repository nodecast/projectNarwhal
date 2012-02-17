<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Torrents extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->utility->enforce_login();
		$this->load->model('torrentmodel');
		$this->load->helper('form');
		$this->load->library('form_validation');
	}

	public function index()
	{
		redirect('/torrents/browse/');
	}

	public function browse($page = 1) {
		$this->utility->enforce_perm('site_torrents_search');
		if($page < 1)
			$page = 1;
		$off = ($page - 1) * $this->config->item('torrent_perpage');
	
		$data = array();
		$t = $this->torrentmodel->getTorrents($this->config->item('torrent_perpage'), $off, null);
		$data['torrents'] = $t['data'];
		$data['perpage'] = $this->config->item('torrent_perpage');
		$data['results'] = $t['count'];
		$data['categories'] = $this->config->item('categories');
		$data['ci'] =& get_instance();
		$data['page'] = $page;
		$data['off'] = $off;
		
		$this->load->view('torrents/browse', $data);
	}
	
	public function upload() {
		$this->form_validation->set_error_delimiters('<div class="error_message">', '</div>');
		$this->form_validation->set_rules('title', 'title', 'required');
		$this->form_validation->set_rules('type', 'category', 'required');
		$this->form_validation->set_rules('tags[]', 'tags', 'required');
		$this->form_validation->set_rules('description', 'description', 'required');
		$this->form_validation->set_rules('file_input', 'file_input', 'callback_file_upload');
		
		//metadata based rules
		$c = $this->config->item('categories');
		foreach($c[$this->input->post('type')]['metadata'] as $m) {
			$key = $m;
			$m = $this->config->item('metadata');
			$m = $m[$key];
			
			$rules = (($m['required']) ? 'required|' : '');
			switch($m['type']) {
				case 0:
					// no additional rules
					break;
				case 1:
					$rules .= 'is_natural|less_than['.(count($m['enum']) + 1).']';
					break;
				case 2:
					//no additional rules
					break;
			}
			$this->form_validation->set_rules('metadata-'.$key.'[]', '\''.$m['display'].'\'', $rules);
		}
	
		if(!$this->form_validation->run()) {
			$data = array();
			$data['categories'] = $this->config->item('categories');
			$this->load->view('torrents/upload', $data);
		} else {
			//continue processing on the torrent files
			
		}
	}
	
	public function file_upload($file) {
		$file = $_FILES['file_input'];

		if($file['error'] > 2 && $file['error'] != 4) {
			$this->form_validation->set_message('file_upload', 'An unexpected error has occurred. Please try again. Code: '.$file['error']);
			return false;
		}
		if($file['size'] > $this->config->item('torrent_maxsize') || $file['error'] == 1 || $file['error'] == 2) {
			$this->form_validation->set_message('file_upload', 'Your torrent file may not be larger than '.$this->utility->format_bytes($file['size']).'. Try increasing your piece size.');
			return false;
		}
		if(!is_uploaded_file($file['tmp_name']) || !filesize($file['tmp_name']) || $file['error'] == 4) {
			$this->form_validation->set_message('file_upload', 'You must select a file to upload!');
			return false;
		}
		if(end(explode('.', $file['name'])) !== "torrent") {
			$this->form_validation->set_message('file_upload', 'You have not selected a valid torrent file.');
			return false;
		}
		
		require('/var/www/application/libraries/torrent.php');
		$this->torrent = new TORRENT(file_get_contents($file['tmp_name']));
		$this->torrent->make_private();
		$this->torrent->set_announce_url('ANNOUNCE_URL');
		
		list($totalSize, $files) = $this->torrent->file_list();
		$this->totalsize = $totalSize;
		$this->files = $files;
		
		$this->infohash = pack("H*", sha1($this->torrent->Val['info']->enc()));
		if($this->torrentmodel->getByInfohash($this->infohash)) {
			$this->form_validation->set_message('file_upload', 'The same torrent has already been uploaded.');
			return false;
		}
	
		return true;
	}
}
