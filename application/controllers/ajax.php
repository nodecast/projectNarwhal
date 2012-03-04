<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
	}

	public function upload_form($id = -1)
	{
		if($id < 0 || $id > count($this->config->item('categories')))
			return;
			
		$data = array();
		$data['categories'] = $this->config->item('categories');
		$data['categoryID'] = $id;
		$data['category'] = $data['categories'][$id];
		$data['metadata'] = $this->config->item('metadata');
		
		$this->load->view('ajax/upload_form', $data);
	}
	
	public function peerlist($id = -1)
	{
		//TODO
		$this->load->view('ajax/peerlist');
	}
	
	public function preview()
	{
		$this->load->library('textformat');
		echo $this->textformat->parse($this->input->post('text'));
	}
	
	public function search_field($name = '')
	{
		if($name == '')
			return;
		
		$metadata = $this->config->item('metadata');
		
		if($name == 'title' || $name == 'tags' || $name == 'category') {
			$type = 0;
		} else {
			$m = $metadata[$name];
			$type = $m['type'];
		}
		
		if($type == 0)
			echo '<input type="text" size="60" name="data[]">';
		if($type == 1) {
			$str = '<select name="data[]">';
			for($i = 0; $i < count($m['enum']); $i++) {
				$str .= '<option value="'.$i.'">'.$m['enum'][$i].'</option>';
			}
			echo $str.'</select>';
		}
		if($type == 2) {
			echo '<input type="checkbox" name="data[]">';
		}
	}
}
