<?php
class KbModel extends CI_Model {

  /*

  narwhal.kb:
    _id        ObjectId   | MongoDB Unique Object Identifer
    id         Integer    | Auto-incrementing integer
    name       String     | Title of the article
    bb_src     String     | BB Code source of the article

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

      if ($cache) {
        $this->mcache->set($key, $data, $this->config->item('kb_cache'));
      }
    }

    return $data;
  }

  function getArticle($id, $cache = true) {
    $key = 'kb_articles_'.$id;
    $id = intval($id);
    $data = array();

    if (!$cache || ($data = $this->mcache->get($key)) === FALSE) {
      $data = $this->mongo->db->kb->findOne(array('id' => $id));

      if ($data) {
        $data['html_src'] = $this->utility->render_bbcode($data['bb_src']);

        if ($cache) {
          $this->mcache->set($key, $data, $this->config->item('kb_cache'));
        }
      }
    }

    return $data;
  }
}
?>
