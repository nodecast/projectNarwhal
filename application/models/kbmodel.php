<?php
class KbModel extends CI_Model {

  /*

  narwhal.kb:
    _id        ObjectId   | MongoDB Unique Object Identifer
    name       String     | Title of the article
    bb_src     String     | BB Code source of the article
    html_src   String     | Compiled HTML of the article

  */

  function __construct()
  { 
    parent::__construct();
  }
  
  function getArticles($cache = true) {
    $key = 'kb_articles_list';

    if (!$cache || ($data = $this->mcache->get($key)) === FALSE) {
      $result = $this->mongo->db->kb->find();
      $count = $result->count();

      $result = iterator_to_array($result);
      $data = array('data' => $result, 'count' => $count);

      $this->mcache->set($key, $data, $this->config->item('kb_cache'));
    }

    return $data;
  }

  function getArticle($id, $cache = true) {
    $key = 'kb_articles_'.$id;
    $data = array();

    if (!$cache || ($data = $this->mcache->get($key)) === FALSE) {
      $data = $this->mongo->db->kb->findOne(array('_id' => new MongoId($id)));

      if ($cache) {
        $this->mcache->set($key, $data, $this->config->item('kb_cache'));
      }
    }

    return $data;
  }
}
?>
