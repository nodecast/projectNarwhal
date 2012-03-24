<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Exchange extends CI_Controller {
  
  public function __construct()
  {
    parent::__construct();
    $this->utility->enforce_login();
    $this->load->model('usermodel');
    $this->load->helper('form');
    $this->load->library('form_validation');
    $this->load->library('textformat');
  }

  public function index()
  {
    $data['items'] = $this->config->item('exchange_items');
    $data['ci'] =& get_instance();
    $this->utility->page_title('The Exchange');
    $this->load->view('exchange/index', $data);
  }

  public function upload()
  {
    $this->utility->page_title('Convert BP to Upload');

    $this->form_validation->set_error_delimiters('<div class="error_message">', '</div>');
    $this->form_validation->set_rules('amount', 'Amount', 'required|is_natural|callback__has_enough_points');

    $amount = $this->input->post('amount');

    if ($this->form_validation->run() == FALSE) {
      $this->load->view('exchange/upload');
    } else {
      $ul = ($amount / 1000) /* GiB */ * 1024 /* MiB*/ * 1024 /* KiB */ * 1024 /* B */;

      $user = $this->utility->current_user();
      $uid = $user['_id'];

      $data = $this->mongo->db->users->findOne(array('_id' => new MongoId($uid)));

      $data['points'] -= $amount;
      $data['upload'] += $ul;

      $this->mongo->db->users->save($data);

      redirect('/exchange/');
    }
  }

  public function _has_enough_points($amt) {
    // TODO
    return true;
  }

  public function _user_exists($username) {
    if ($this->mongo->db->findOne(array('username' => new MongoId($username)))) {
      return true;
    } else {
      $this->form_validation->set_message('_user_exists', 'User does not exist!');
      return false;
    }
  }
}
