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
    
    $this->load->view('kb/browse', $data);
  }

  public function view($id = -1) {
    $this->utility->enforce_perm('site_kb_view');
    
    if (!$article = $this->kbmodel->getArticle($id, false)) {
      $this->utility->page_title('Non-existant article');
      $this->load->view('kb/view_dne');
    } else {
      $this->utility->page_title('KB Article ('.$article['name'].')');

      $data = array();
      $data['article'] = $article;
      
      $this->load->view('kb/view', $data);
    }
  }
}
