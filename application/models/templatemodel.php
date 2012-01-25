<?php
class Templatemodel extends CI_Model {

  function __construct()
  {  
    parent::__construct();
    //Initialization code stuff here. Probably not really that needed
  }

  function somefunction()
  {
    //Accessed by $this->templatemodel->somefunction() elsewhere.
  }

}
?>
