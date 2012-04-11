<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class CSRF {
	public function _disable_csrf() {
		if(stripos($_SERVER["REQUEST_URI"],'/ajax') !== FALSE) {
        	$config =& load_class('Config', 'core');
        	$config->set_item('csrf_protection', FALSE);
        }
	}
}
