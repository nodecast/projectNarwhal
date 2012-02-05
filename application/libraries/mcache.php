<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class MCache {
	public function __construct()
	{
		$this->m = new Memcached();
		$this->m->addServer('localhost', 11211);
	}
}

