<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Utility {
	public function __construct()
	{
		$this->CI =& get_instance();
	}

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
		return sha1(md5($Secret).$Str.sha1($Secret).$this->CI->config->item("site_salt"));
	}

	function logged_in() {
		return $this->CI->session->userdata('logged_in');
	}

	function enforce_login() {
		if(!$this->logged_in()) {
			$this->CI->session->set_flashdata('login_redirect', $_SERVER['REQUEST_URI']);
			redirect("login");
		}
	}

	function format_bytes($bytes) {
		$suffix = array(' B', ' KiB', ' MiB', ' GiB', ' TiB', ' PiB', ' EiB');
		$step = 0;
		while($bytes >= 1024) {
			$step++;
			$bytes /= 1024;
		}
		return number_format($bytes, 2).$suffix[$step];
	}

	function get_ratio_color($ratio) {
		if ($ratio < 0.1) return 'r00';
		if ($ratio < 0.2) return 'r01';
		if ($ratio < 0.3) return 'r02';
		if ($ratio < 0.4) return 'r03';
		if ($ratio < 0.5) return 'r04';
		if ($ratio < 0.6) return 'r05';
		if ($ratio < 0.7) return 'r06';
		if ($ratio < 0.8) return 'r07';
		if ($ratio < 0.9) return 'r08';
		if ($ratio < 1) return 'r09';
		if ($ratio < 2) return 'r10';
		if ($ratio < 5) return 'r20';
		return 'r50';
	}

	function ratio($ul, $dl, $color = true) {
		if($dl == 0 && $ul == 0)
			return '--';
		elseif($dl == 0)
			return ($color) ? '<span class="r99">&#8734;</span>' : '&#8734';
		elseif($ul == 0 && $dl > 0)
			return ($color) ? '<span class="r00">-&#8734;</span>' : '-&#8734';

		$ratio = number_format($ul/$dl, 2);
		if($color) {
			$class = $this->get_ratio_color($ratio);
			if($class)
				$ratio = '<span class="'.$class.'">'.$ratio.'</span>';
		}
		return $ratio;
	}

	function time_diff_string($t1, $t2 = -1) {
		if($t2 == -1)
			$t2 = time();
		$diffu = array('seconds'=>2, 'minutes' => 120, 'hours' => 7200, 'days' => 172800, 'months' => 5259487, 'years' =>  63113851);
		$diff = $t2 - $t1;
		$dt = '0 seconds';
		foreach($diffu as $u => $n)
			if($diff>$n)
				$dt = floor($diff / (.5 * $n)).' '.$u;
		return $dt;
	}
	
	function update_user_data() {
		$this->CI->load->model('usermodel');
		$res = $this->CI->usermodel->getData($this->CI->session->userdata('id'), true);
		$this->CI->session->set_userdata($res);
	}

	function page_title($title) {
		$title = (strlen($title)) ? ($title." :: ") : "";
		$this->CI->config->set_item('page_title', $title.$this->CI->config->item('site_name'));
	}
}

