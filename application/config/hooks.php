<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/

/* For Header and Footer */
$hook['pre_controller'][] = array(
								'class'		=> 'Design',
								'function'	=> 'header',
								'filename'	=> 'design.php',
								'filepath'	=> 'hooks',
								'params'	=> array()
								);

$hook['post_controller'][] = array(
								'class'		=> 'Design',
								'function'	=> 'footer',
								'filename'	=> 'design.php',
								'filepath'	=> 'hooks',
								'params'	=> array()
								);
$hook['pre_system'][] = array(
								'class'		=> 'CSRF',
								'function'	=> '_disable_csrf',
								'filename'	=> 'csrf.php',
								'filepath'	=> 'hooks',
								'params'	=> array()
								);

/* End of file hooks.php */
/* Location: ./application/config/hooks.php */
