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

	function current_user() {
		return $this->CI->session->userdata;
	}

	function user_setting($key) {
		$ud = $this->current_user();
		return $ud['settings'][$key];
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

	function format_ratio_history($h) {
		return json_encode(array_slice($h, -31, 30));
	}

	function format_percent($pct) {
		return number_format($pct * 100, 0).'%';
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

	function time_diff_string($t1, $t2 = -1, $ago = true) {
		if($t1 == 0)
			return "Never";
		if($t2 == -1)
			$t2 = time();
		$diffu = array('seconds' => 2, 'minutes' => 120, 'hours' => 7200, 'days' => 172800, 'months' => 5259487, 'years' =>  63113851);
		$diff = $t2 - $t1;
		$dt = '0 seconds';
		foreach($diffu as $u => $n)
			if($diff>$n)
				$dt = floor($diff / (.5 * $n)).' '.$u;
		return $dt.($ago ? " ago" : "");
	}
	
	function format_datetime($t = -1) {
		if($t == -1)
			$t = time();
		return date('M d Y, H:i', $t);
	}
	
	function update_user_data() {
		$this->CI->load->model('usermodel');
		$res = $this->CI->usermodel->getData($this->CI->session->userdata('_id'), true);
		$this->CI->session->set_userdata($res);
	}

	function page_title($title) {
		$title = (strlen($title)) ? ($title." :: ") : "";
		$this->CI->config->set_item('page_title', $title.$this->CI->config->item('site_name'));
	}
	
	function check_perm($perm, $id = -1) {
		if($id == -1)
			$id = $this->CI->session->userdata('_id');
		$this->CI->load->model('usermodel');
		
		$p = $this->CI->usermodel->getPermissions($id);
		return in_array($perm, $p['values']);
	}
	
	function enforce_perm($perm) {
		// TODO undo this
		return;
		if(!$this->check_perm($perm))
			show_error('You are not authorized to use this feature.', 403);
	}
	
	// TODO rewrite this
	function get_page_nav($location, $start_item, $total_number, $per_page, $show_record_count = true, $show_pages = 10) {
		$pages = "";
		$start_item = ceil($start_item);
		if($start_item == 0)
			$start_item = 1;

		if($total_number > 0) {
			if($start_item > ceil($total_number / $per_page))
				$start_item = ceil($total_number / $per_page);
			$show_pages--;
			$total_pages = ceil($total_number / $per_page);

			if($total_pages > $show_pages) {
				$start_position = $start_item - round($show_pages / 2);
				if($start_position <= 0) {
					$start_position = 1;
				} else {
					if($start_position >= ($total_pages - $show_pages))
						$start_position = $total_pages - $show_pages;
				}
				$stop_page = $show_pages + $start_position;
			} else {
				$stop_page = $total_pages;
				$start_position = 1;
			}
			if($start_position < 1)
				$start_position = 1;
			if($start_item > 1) {
				$pages = '<a href="'.$location.'1"><strong>&lt;&lt; First</strong></a> ';
				$pages .= '<a href="'.$location.($start_item-1).'"><strong>&lt; Prev</strong></a> | ';
			}
			for($i = $start_position; $i <= $stop_page; $i++) {
				if($i != $start_item)
					$pages .= '<a href="'.$location.$i.'">';
				$pages .= "<strong>";
				if($show_record_count) {
					if($i * $per_page > $total_number)
						$pages .= ((($i - 1) * $per_page) + 1).'-'.($total_number);
					else
						$pages .= ((($i - 1) * $per_page) + 1).'-'.($i * $per_page);
				} else {
					$pages .= $i;
				}
				$pages .= "</strong>";
				if($i != $start_item)
					$pages .= '</a>';
				if($i < $stop_page)
					$pages .= " | ";
			}

			if ($start_item < $total_pages) {
				$pages .= ' | <a href="'.$location.($start_item + 1).'"><strong>Next &gt;</strong></a> ';
				$pages .= '<a href="'.$location.$total_pages.'"><strong> Last &gt;&gt;</strong></a>';
			}
		}

		if ($total_pages>1) { return $pages; }
	}
	
	function torrent_name($id, $pretty = true) {
		$this->CI->load->model('torrentmodel');
		$d = $this->CI->torrentmodel->getData($id);
		return $d['name'];
		// TODO metadata and such
	}
	
	function format_name($id) {
		$this->CI->load->model('usermodel');
		$data = $this->CI->usermodel->getData($id);
		
		return '<a class="username" href="/user/view/'.$data['_id'].'">'.$data['username'].'</a>';
	}
	
	// TODO this does nothing right now
	/* codes:
	0 - normal
	-10 - problem
	*/
	function log($str, $code = 0) {
	}

	function get_seq_id($name) {
		$c = $this->CI->mongo->db->command(
			array(
				'findandmodify' => 'counters',
				'query'=> array('name'=>$name),
				'update' => array('$inc'=>array('c'=>1))
			)
		);

		return $c['value']['c'];
	}

	function is_valid_image($img) {
		return preg_match('/^\/static/', $img) || preg_match('/^(https?:\/\/'.$this->CI->config->item('allowed_imagehosts').'[^\s\'\"<>()]+(\.(jpg|jpeg|gif|png|tif|tiff|bmp)))$/is', $img);
	}
}

