<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chat extends CI_Controller {
  
  public function __construct()
  {
    parent::__construct();
    $this->utility->enforce_login();
  }

  public function index()
  {
    $this->utility->page_title('Web IRC');
    $this->load->view('chat/index');
  }

}

?>