<?php
class AuthTokenModel extends CI_Model {

  function __construct()
  { 
    parent::__construct();
    $this->ci = get_instance();
  }

  public function getUserForToken($tokenid) {
    $this->load->model('usermodel');

    if (($data = $this->mcache->get('auth_token_data_'.$tokenid)) === FALSE) {
      $tdata = $this->mongo->db->auth_tokens->findOne(array('_id' => new MongoId($tokenid)));
      if (!$tdata)
        return null;
      $data = $this->usermodel->getData($tdata['user']);
      $this->mcache->set('auth_token_data_'.$tokenid, $data, $this->config->item('userdata_cache'));
    }

    return $data;
  }

  public function createTokenForUser($uid, $expiration) {
    $data['_id'] = new MongoId();
    $data['user'] = new MongoId($uid);
    $data['expiration'] = $expiration;
    $this->mongo->db->auth_tokens->save($data);
    return $data['_id'];
  }

  public function is_expired($tid) {
    $tdata = $this->mongo->db->auth_tokens->findOne(array('_id' => new MongoId($tid)));
    return $tdata['expiration'] <= time();
  }

  public function delete($atid) {
    $this->mongo->db->auth_tokens->remove(array('_id' => new MongoId($atid)));
  }
}
?>
