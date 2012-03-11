<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Solr {
  public function __construct()
  {

    $this->ci =& get_instance();
    $this->ci->load->config('solr');
    
    $options = array();
    $options['hostname'] = $this->ci->config->item('solr_server');
    $options['port'] = $this->ci->config->item('solr_port');

    if ($this->ci->config->item('solr_auth')) {
      $options['login'] = $this->ci->config->item('solr_username');
      $options['password'] = $this->ci->config->item('solr_password');
    }

    $this->client = new SolrClient($options);
  }

  public function query($q, $start = 0, $rows = 50) {
    $query = new SolrQuery();

    $query->setQuery($q);
    $query->setStart($start);
    $query->setRows($rows);
    $query_response = $this->client->query($query);
    $response = $query_response->getResponse();

    return $response;
  }

  static public function escapeValue($string) {
    $match = array('\\', '+', '-', '&', '|', '!', '(', ')', '{', '}', '[', ']', '^', '~', '*', '?', ':', '"', ';', ' ');
    $replace = array('\\\\', '\\+', '\\-', '\\&', '\\|', '\\!', '\\(', '\\)', '\\{', '\\}', '\\[', '\\]', '\\^', '\\~', '\\*', '\\?', '\\:', '\\"', '\\;', '\\ ');
    $string = str_replace($match, $replace, $string);
 
    return $string;
  }
}

