<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Utility {
	function make_secret($length = 32) {
		$Secret = "";
		$Chars='abcdefghijklmnopqrstuvwxyz0123456789';
		for($i=0; $i < $length; $i++) {
			$rand = mt_rand(0, strlen($Chars)-1);
			$Secret.= substr($Chars, $rand, 1);
		}
		return str_shuffle($Secret);
	}

	function make_hash($Str,$Secret) {
		$CI =& get_instance();
		return sha1(md5($Secret).$Str.sha1($Secret).$CI->config->item("site_salt"));
	}

	function logged_in() {
		$CI =& get_instance();
		return $CI->session->userdata('logged_in');
	}

	function enforce_login() {
		$CI =& get_instance();
		if(!$this->logged_in()) {
			$CI->session->set_flashdata('login_redirect', $_SERVER['REQUEST_URI']);
			redirect("/login/");
		}
	}
}

