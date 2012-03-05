<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kb extends CI_Controller {
  
  public function __construct()
  {
    parent::__construct();
    $this->utility->enforce_login();
    $this->load->model('kbmodel');
    $this->load->helper('form');
    $this->load->library('form_validation');
  }

  public function index()
  {
    redirect('/kb/browse/');
  }

  public function browse() {
    $this->utility->enforce_perm('site_kb_search');
    
    $this->utility->page_title('KB Articles');

    $articles = $this->kbmodel->getArticles();

    $data = array();
    $data['articles'] = $articles;
    $data['can_create'] = $this->utility->check_perm('site_kb_new');
    
    $this->load->view('kb/browse', $data);
  }

  public function view($id = -1) {
    $this->utility->enforce_perm('site_kb_view');
    
    if (!$article = $this->kbmodel->getArticle($id)) {
      $this->utility->page_title('Non-existant article');
      $this->load->view('kb/view_dne');
    } else {
      $this->utility->page_title('KB Article ('.$article['name'].')');

      $data = array();
      $data['article'] = $article;
      $data['can_edit'] = $this->utility->check_perm('site_kb_edit');
      
      $this->load->view('kb/view', $data);
    }
  }

  public function create() {
    $this->utility->enforce_perm('site_kb_new');

    $this->utility->page_title('New KB Article');

    $this->form_validation->set_error_delimiters('<div class="error_message">', '</div>');
    $this->form_validation->set_rules('name', 'Name', 'required');
    $this->form_validation->set_rules('bb_src', 'Content', 'required');

    if ($this->form_validation->run() == FALSE) {
      $data = array();
      $data['formurl'] = 'kb/create';
      $data['ucverb'] = 'Create';
      $this->load->view('kb/form', $data);
    } else {
      $c = $this->mongo->db->command(array('findandmodify'=>'counters', 'query'=>array('name'=>'kbarticleid'), 'update'=>array('$inc'=>array('c'=>1))));

      $data = array();
      $data['id'] = $c['value']['c'];
      $data['name'] = $this->input->post('name');
      $data['bb_src'] = $this->input->post('bb_src');
      $data['html_src'] = $this->utility->render_bbcode($data['bb_src']);
      $data['owner'] = $this->session->userdata('id');

      $this->mongo->db->kb->save($data);

      $this->utility->log($this->session->userdata('username').' ('.$this->session->userdata('id').') has created KB Article '.$data['id'].' "'.$data['name'].'"');

      redirect('/kb/view/'.$data['id']);
    }
  }

  public function edit($id = -1) {
    $this->utility->enforce_perm('site_kb_edit');

    if (!$article = $this->kbmodel->getArticle($id)) {
      $this->utility->page_title('Non-existant article');
      $this->load->view('kb/view_dne');
    } else {
      $this->utility->page_title('Edit KB Article ('.$article['name'].')');

      $this->form_validation->set_error_delimiters('<div class="error_message">', '</div>');
      $this->form_validation->set_rules('name', 'Name', 'required');
      $this->form_validation->set_rules('bb_src', 'Content', 'required');

      if ($this->form_validation->run() == FALSE) {
        $data = array();
        $data['name'] = $article['name'];
        $data['bb_src'] = $article['bb_src'];
        $data['formurl'] = 'kb/edit/'.$article['id'];
        $data['ucverb'] = 'Edit';
        $this->load->view('kb/form', $data);
      } else {
        $article['name'] = $this->input->post('name');
        $article['bb_src'] = $this->input->post('bb_src');
        $article['html_src'] = $this->utility->render_bbcode($article['bb_src']);

        $this->mongo->db->kb->save($article);

        redirect('/kb/view/'.$article['id']);
      }
    }
  }
}
