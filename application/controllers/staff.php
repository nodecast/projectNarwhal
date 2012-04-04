<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Staff extends CI_Controller {
  
  public function __construct()
  {
    parent::__construct();
    $this->utility->enforce_login();
    $this->load->model('usermodel');
  }

  public function index()
  {
    $classes = $this->config->item('classes');
    $data['staff'] = array();
    $data['staff']['Helper'] = $this->usermodel->getUsersForClass($classes['HELPER']);
    $data['staff']['Moderator'] = $this->usermodel->getUsersForClass($classes['MOD']);
    $data['staff']['Developer'] = $this->usermodel->getUsersForClass($classes['DEVELOPER']);
    $data['staff']['Admin'] = $this->usermodel->getUsersForClass($classes['ADMIN']);
    $data['staff']['SysOp'] = $this->usermodel->getUsersForClass($classes['SYSOP']);
    $this->utility->page_title('Staff');
    $this->load->view('staff/index', $data);
  }

}