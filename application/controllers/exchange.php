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
    $this->load->library('atheme');
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
      $ul = intval(($amount / 1000) /* GiB */ * 1024 /* MiB*/ * 1024 /* KiB */ * 1024 /* B */);

      $uid = $this->utility->current_user('_id');

      $data = $this->mongo->db->users->findOne(array('_id' => new MongoId($uid)));

      $data['points'] -= $amount;
      $data['upload'] += $ul;

      $this->mongo->db->users->save($data);

      redirect('/exchange/');
    }
  }

  public function invite()
  {
    $this->utility->page_title('Buy an Invite');

    $this->form_validation->set_error_delimiters('<div class="error_message">', '</div>');
    $this->form_validation->set_rules('amount', 'Amount', 'required|is_natural|callback__has_enough_points_invite');

    $amount = $this->input->post('amount');

    if ($this->form_validation->run() == FALSE) {
      $this->load->view('exchange/invite');
    } else {
      $new_invites = $amount;

      $uid = $this->utility->current_user('_id');

      $user = $this->mongo->db->users->findOne(array('_id' => new MongoId($uid)));

      $user['points'] -= $new_invites * 10000;
      $user['invites'] += $new_invites;

      $this->mongo->db->users->save($user);

      redirect('/exchange/');
    }
  }

  public function transfer($un = '')
  {
    $this->utility->page_title('Transfer BP');

    $this->form_validation->set_error_delimiters('<div class="error_message">', '</div>');
    $this->form_validation->set_rules('username', 'Username', 'required|callback__user_exists');
    $this->form_validation->set_rules('amount', 'Amount', 'required|is_natural|callback__has_enough_points');

    $amount = $this->input->post('amount');
    $confirm = $this->input->post('confirm');
    $username = $this->input->post('username');

    if ($this->form_validation->run() == FALSE) {
      $data = array();
      if ($un != '') $data['username'] = $un;
      $this->load->view('exchange/transfer', $data);
    } else {
      if ($confirm != FALSE) {
        $fromuser = $this->utility->current_user();
        $touser = $this->usermodel->getDataForUsername($username);

        $toamt = intval($amount * 0.80);

        $fromuser['points'] -= $amount;
        $touser['points'] += $toamt;

        $this->mongo->db->users->save($fromuser);
        $this->mongo->db->users->save($touser);

        $this->atheme->announce($fromuser['username'].' sent '.$toamt.' points to '.$touser['username']);

        redirect('/exchange/');
      } else {
        $data['target'] = $this->usermodel->getDataForUsername($username);
        $this->load->view('exchange/transfer', $data);
      }
    }
  }

  public function vhost()
  {
    $this->utility->page_title('Change Vhost');

    $this->form_validation->set_error_delimiters('<div class="error_message">', '</div>');
    $this->form_validation->set_rules('vhost', 'Vhost', 'required|callback__check_vhost');

    $vhost = $this->input->post('vhost');
    $confirm = $this->input->post('confirm');

    if ($this->form_validation->run() == FALSE || !$this->_has_enough_points(5000)) {
      $data = array();
      $data['vhost'] = $vhost;
      $this->load->view('exchange/vhost', $data);
    } else {
      $user = $this->utility->current_user();
      $user['points'] -= 5000;
      $this->mongo->db->users->save($user);

      $this->atheme->setVhost($user['username'], $vhost);

      redirect('/exchange/');
    }
  }

  public function _check_vhost($vhost) {
    $url = $this->config->item('http_siteurl');
    if ((strpos($vhost, $url) === false) &&
         preg_match('/^([\w\.\-]{3,63})$/', $vhost)) {
      return true;
    } else {
      $this->form_validation->set_message('_check_vhost', 'Invalid vhost.');
      return false;
    }
  }

  public function _has_enough_points($amt) {
    if ($this->utility->current_user('points') >= $amt) {
      return true;
    } else {
      $this->form_validation->set_message('_has_enough_points', 'You don\'t have enough points!');
      return false;
    }
  }

  public function _has_enough_points_invite($invites) {
    if ($this->_has_enough_points($invites * 10000)) {
      return true;
    } else {
      $this->form_validation->set_message('_has_enough_points_invite', 'You don\'t have enough points!');
      return false;
    }
  }

  public function _user_exists($username) {
    if ($username != $this->utility->current_user('username') && $this->mongo->db->users->findOne(array('username' => $username))) {
      return true;
    } else {
      $this->form_validation->set_message('_user_exists', 'Invalid user!');
      return false;
    }
  }
}
