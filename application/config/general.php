<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Public contact email
$config['contact_email'] = "narwhal@projectnarwhal.org";

//Should be equal to SITE_SALT from gazelle. Will be used to keep backwards compatibility with hashes
//Once you set this, do. not. change it
$config['site_salt']      = 'SECURE';

//Free points given on register
$config['free_points']		= 5000;

//Minutes until a cached page is marked dirty
$config['cache_time'] = 5;
