<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class MCache {
	public function __construct()
	{
		$this->m = new Memcached();
		$this->m->addServer('localhost', 11211);
	}
	public function set($key, $var, $expire = 0) 
	{
		return $this->m->set($key, $var, $expire);
	}
	public function get($key)
	{
		return $this->m->get($key);
	}
}

