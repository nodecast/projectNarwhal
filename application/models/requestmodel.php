<?php
class RequestModel extends CI_Model {

	function __construct()
	{	
		parent::__construct();
		$this->load->library('textformat');
		$this->ci = get_instance();
	}
}
?>
