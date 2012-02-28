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
		$data['static_server'] = $this->config->item('static_server');
		
		$this->load->view('torrents/browse', $data);
	}
	
	public function upload() {
		$this->utility->enforce_perm('site_torrents_upload');
		
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
			$data['announce'] = $this->config->item('announce_url').'/'.$this->session->userdata('torrent_pass').'/announce';
			$this->load->view('torrents/upload', $data);
		} else {
			//continue processing on the torrent files
			$c = $this->mongo->db->command(array('findandmodify'=>'counters', 'query'=>array('name'=>'torrentid'), 'update'=>array('$inc'=>array('c'=>1))));
			
			$data = array();
			$data['id'] = $c['value']['c'];
			$data['name'] = $this->input->post('title');
			$data['owner'] = $this->session->userdata('id');
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
			$data['image'] = (preg_match('/^https?:\/\/([a-zA-Z0-9\-\_]+\.)+([a-zA-Z]{1,5}[^\.])(\/[^<>]+)+\.(jpg|jpeg|gif|png|tif|tiff|bmp)$/i', $img)) ? $img : '';
			$data['comments'] = array();
			$data['info_hash'] = new MongoBinData($this->infohash);
			$data['freetorrent'] = ($data['size'] < $this->config->item('freeleech_size')) ? 0 : 1;
			$data['tags'] = $this->input->post('tags');
			$data['metadata'] = array();
			$cat = $this->config->item('categories');
			$cat = $cat[$data['category']];
			foreach($cat['metadata'] as $m) {
				$val = $this->input->post('metadata-'.$m);
				$val = (is_array($val)) ? $val : array($val);
				$data['metadata'][$m] = $val;
			}
			$this->mongo->db->torrents->save($data);
			
			//save the file
			file_put_contents(APPPATH.'/torrents/'.$data['id'].'.torrent', $this->torrent->enc());
			
			// log
			$this->utility->log($this->session->userdata('username').' ('.$this->session->userdata('id').') has uploaded torrent '.$data['id'].' "'.$data['name'].'"');
			
			// TODO irc announce
			
			redirect('/torrents/view/'.$data['id']);
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
			$this->load->view('torrents/view_dne');
		} else {
			$data = array();
			$data['torrent'] = $torrent;
			$data['owner'] = $this->usermodel->getData($torrent['owner']);
			$data['user'] = $this->session->all_userdata();
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
			$this->load->view('torrents/view', $data);
		}
	}
	
	public function download($id = -1) {
		$this->utility->enforce_perm('site_torrents_download');
		$this->load->model('usermodel');
		require(APPPATH.'/libraries/torrent.php');
		
		if(!is_numeric($id))
			show_error('Torrent not found.', 404);
		$file = APPPATH.'/torrents/'.$id.'.torrent';
		if (!is_file($file) || !is_readable($file))
			show_error('Torrent not found.', 404);
		
		$tor = new TORRENT(file_get_contents($file));
		$tor->set_announce_url($this->config->item('announce_url').'/'.$this->session->userdata('torrent_pass').'/announce');
		unset($tor->Val['announce-list']);
		
		//TODO txt download
		header('Content-Disposition: attachment; filename="'.$this->utility->torrent_name($id, false).'.torrent"');
		header('Content-Type: application/x-bittorrent');
		
		echo $tor->enc();
		$this->utility->log($this->session->userdata('username').' ('.$this->session->userdata('id').') downloaded torrent '.$id);
		exit();
	}
	
	public function tag() {
		$action = $this->input->post('action');
		$id = $this->input->post('id');
		$tag = $this->input->post('tag');
		if(!$this->torrentmodel->getData($id)) {
			show_error('The page you have requested could not be found.', 404);
		}
		if(!$tag) {
			redirect('/torrents/view/'.$id);
		}
		if($action == 'add') {
			$this->utility->enforce_perm('site_torrents_tags_add');
			$this->torrentmodel->addTag(intval($id), $tag);
			redirect('/torrents/view/'.$id);
		} else if($action == 'delete') {
			$this->utility->enforce_perm('site_torrents_tags_delete');
			$this->torrentmodel->removeTag(intval($id), $tag);
			redirect('/torrents/view/'.$id);
		} else {
			show_error('The page you have requested could not be found.', 404);
		}
	}
}
