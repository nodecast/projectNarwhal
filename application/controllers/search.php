<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller {
  
  public function __construct() {
    parent::__construct();
    $this->utility->enforce_login();
    $this->load->library('solr');
  }

  public function index() {
  }

  public function users($id = "@") {
    $id = $this->input->get('username');

    $start = $this->input->get('start');
    if ($start < 0)
      $start = 0;

    $rows = $this->input->get('rows');
    if ($rows <= 0 || $rows >= 50)
      $rows = 10;

    if ($id) {
      $res = $this->solr->query('ns:narwhal.users AND username:'.$id, intval($start), intval($rows));
    } else {
      $res = array('response' => array('numFound' => 0));
    }

    $data['resp'] = $res['response'];

    $this->load->view('search/users', $data);
  }
}