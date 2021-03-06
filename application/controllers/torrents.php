<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Torrents extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->utility->enforce_login();
		$this->load->model('torrentmodel');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('atheme');
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
	
		$query = array();
		
		$query = (count($query)) ? array(($this->input->post('match_method') == 'or' ? '$or' : '$and') => $query) : array();
		$data = array();
		$t = $this->torrentmodel->getTorrents($this->config->item('torrent_perpage'), $off, $query);
		$data['torrents'] = $t['data'];
		$data['perpage'] = $this->config->item('torrent_perpage');
		$data['results'] = $t['count'];
		$data['categories'] = $this->config->item('categories');
		$data['ci'] =& get_instance();
		$data['page'] = $page;
		$data['off'] = $off;
		$data['static_server'] = $this->config->item('static_server');
		$data['cats'] = $this->config->item('categories');
		$data['metadata'] = $this->config->item('metadata');
		
		$this->utility->page_title('Browse Torrents');
		$this->load->view('torrents/browse', $data);
		
		//new MongoRegex('/^'.preg_quote($name).'$/i')
	}
	
	public function upload() {
		$this->utility->enforce_perm('site_torrents_upload');
		$this->utility->page_title('Upload');
		
		$this->form_validation->set_error_delimiters('<div class="error_message">', '</div>');
		$this->form_validation->set_rules('title', 'title', 'required');
		$this->form_validation->set_rules('type', 'category', 'required');
		$this->form_validation->set_rules('tags[]', 'tags', 'required');
		$this->form_validation->set_rules('description', 'description', 'required');
		$this->form_validation->set_rules('file_input', 'file_input', 'callback__file_upload');
		
		//metadata based rules
		$c = $this->config->item('categories');
		foreach($c[$this->input->post('type')]['metadata'] as $m) {
			$key = $m;
			$m = $this->config->item('metadata');
			$m = $m[$key];
			
			$rules = (($m['required'] && !($m['type'] == 2)) ? 'required|' : '');
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
			$data['announce'] = $this->config->item('announce_url').'/'.$this->utility->current_user('torrent_pass').'/announce';
			$this->load->view('torrents/upload', $data);
		} else {
			//continue processing on the torrent files
			$data = array();
			$data['name'] = $this->input->post('title');
			$data['owner'] = $this->utility->current_user('_id');
			$data['description'] = $this->input->post('description');
			$data['category'] = $this->input->post('type');
			$data['seeders'] = 0;
			$data['leechers'] = 0;
			$data['snatched'] = 0;
			$data['size'] = $this->totalsize;
			$data['files'] = array();
			foreach($this->files as $f) {
				$data['files'][] = array('name' => $f[1], 'size' => $f[0]);
			}
			$data['time'] = time();
			$img = $this->input->post('image');
			$data['image'] = ($this->utility->is_valid_image($img)) ? $img : '';
			$data['comments'] = array();
			$data['info_hash'] = bin2hex($this->infohash);
			$data['freetorrent'] = ($data['size'] < $this->config->item('freeleech_size')) ? 0 : 1;
			$data['tags'] = array_map("trim", array_filter(explode(',', $this->input->post('tags')), 'trim'));
			$data['metadata'] = array();
			$data['data'] = new MongoBinData($this->torrent->enc());
			$cat = $this->config->item('categories');
			$meta_schema = $this->config->item('metadata');
			$cat = $cat[$data['category']];
			foreach($cat['metadata'] as $m) {
				$schema = $meta_schema[$m];
				$val = $this->input->post('metadata-'.$m);
				if($schema['type'] === 0 && $schema['multiple']) {
					$val = array_map("trim", array_filter(explode(',', $val), 'trim'));
				}
				$val = (is_array($val)) ? $val : array($val);
				$data['metadata'][$m] = $val;
			}
			$this->mongo->db->torrents->save($data);

			$logline = $this->utility->current_user('username').' ('.$this->utility->current_user('_id').') has uploaded torrent '.$data['_id'].' "'.$data['name'].'"';

			// log
			$this->utility->log($logline);
			
			// IRC announce
			$this->atheme->announce($logline);
			$this->atheme->say('#torrents', $logline);
			
			redirect('/torrents/view/'.$data['_id']);
		}
	}
	
	public function _file_upload($file) {
		$file = $_FILES['file_input'];

		if($file['error'] > 2 && $file['error'] != 4) {
			$this->form_validation->set_message('_file_upload', 'An unexpected error has occurred. Please try again. Code: '.$file['error']);
			return false;
		}
		if($file['size'] > $this->config->item('torrent_maxsize') || $file['error'] == 1 || $file['error'] == 2) {
			$this->form_validation->set_message('_file_upload', 'Your torrent file may not be larger than '.$this->utility->format_bytes($file['size']).'. Try increasing your piece size.');
			return false;
		}
		if(!is_uploaded_file($file['tmp_name']) || !filesize($file['tmp_name']) || $file['error'] == 4) {
			$this->form_validation->set_message('_file_upload', 'You must select a file to upload!');
			return false;
		}
		if(end(explode('.', $file['name'])) !== "torrent") {
			$this->form_validation->set_message('_file_upload', 'You have not selected a valid torrent file.');
			return false;
		}
		
		require(APPPATH.'/libraries/torrent.php');
		$this->torrent = new TORRENT(file_get_contents($file['tmp_name']));
		$this->torrent->make_private();
		$this->torrent->set_announce_url('ANNOUNCE_URL');
		
		list($totalSize, $files) = $this->torrent->file_list();
		$this->totalsize = $totalSize;
		$this->files = $files;
		
		$this->infohash = pack("H*", sha1($this->torrent->Val['info']->enc()));
		if($this->torrentmodel->getByInfohash($this->infohash)) {
			$this->form_validation->set_message('_file_upload', 'The same torrent has already been uploaded.');
			return false;
		}
	
		return true;
	}
	
	public function view($id = -1, $page = 1) {
		$this->utility->enforce_perm('site_torrents_view');
		$this->load->model('usermodel');
		$this->load->library('textformat');
		$torrent = $this->torrentmodel->getData($id, false);
		
		if($page < 1)
			$page = 1;
		$off = ($page - 1) * $this->config->item('torrent_comments_perpage');
		
		if(!$torrent) {
			$this->utility->page_title('Non-existant torrent');
			$this->load->view('torrents/view_dne');
		} else {
			$data = array();
			$data['torrent'] = $torrent;
			$data['owner'] = $this->usermodel->getData($torrent['owner']);
			$data['user'] = $this->utility->current_user();
			$data['categories'] = $this->config->item('categories');
			$data['ci'] =& get_instance();
			$data['can_delete_tags'] = $this->utility->check_perm('site_torrents_tags_delete');
			$data['can_add_tags'] = $this->utility->check_perm('site_torrents_tags_add');
			$data['per_page'] = $this->config->item('torrent_comments_perpage');
			$data['comments'] = $this->torrentmodel->getComments($id, $data['per_page'], $off, false);
			$data['results'] = $data['comments']['length'];
			$data['comments'] = $data['comments']['data'];
			$data['page'] = $page;
			$data['static_server'] = $this->config->item('static_server');
			
			if($this->input->post('action') == 'reply') {
				$this->utility->enforce_perm('site_torrents_comment');
				$this->form_validation->set_error_delimiters('<div class="error_message">', '</div>');
				$this->form_validation->set_rules('text', 'text', 'required|max_length['.$this->config->item('max_bytes_per_post').']');
				if($this->form_validation->run()) {
					$c = $this->torrentmodel->addComment($id, $this->utility->current_user('_id'), $this->input->post('text'));
					redirect('/torrents/view/'.$id.'/'.ceil(($data['results']+1) / 10).'#post'.$c);
				}
			}
			
			$this->utility->page_title($data['torrent']['name']);
			$this->load->view('torrents/view', $data);
		}
	}
	
	public function download($id = -1) {
		$this->utility->enforce_perm('site_torrents_download');
		$this->load->model('usermodel');
		require(APPPATH.'/libraries/torrent.php');
		
		if(!($data = $this->torrentmodel->getData($id)))
			show_404();

		$tor = new TORRENT($data['data']->bin);
		//$tor->set_announce_url($this->config->item('announce_url').'/'.$this->session->userdata('torrent_pass').'/announce');

		if (!$this->utility->user_setting('download_as_txt')) {
			header('Content-Disposition: attachment; filename="'.$this->utility->torrent_name($id, false).'.torrent"');
			header('Content-Type: application/x-bittorrent');
		} else {
			header('Content-Disposition: attachment; filename="'.$this->utility->torrent_name($id, false).'.txt"');
			header('Content-Type: text/plain');
		}
		echo $tor->enc();
		$this->utility->log($this->utility->current_user('username').' ('.$this->utility->current_user('_id').') downloaded torrent '.$id);
		exit();
	}
	
	public function tag() {
		$action = $this->input->post('action');
		$id = $this->input->post('id');
		$tag = $this->input->post('tag');
		if(!$this->torrentmodel->getData($id)) {
			show_404();
		}
		if(!$tag) {
			redirect('/torrents/view/'.$id);
		}
		if($action == 'add') {
			$this->utility->enforce_perm('site_torrents_tags_add');
			$this->torrentmodel->addTag($id, $tag);
			redirect('/torrents/view/'.$id);
		} else if($action == 'delete') {
			$this->utility->enforce_perm('site_torrents_tags_delete');
			$this->torrentmodel->removeTag($id, $tag);
			redirect('/torrents/view/'.$id);
		} else {
			show_404();
		}
	}
}
