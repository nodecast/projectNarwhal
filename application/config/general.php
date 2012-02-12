<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Public contact email
$config['contact_email'] = "narwhal@projectnarwhal.org";

//Should be equal to SITE_SALT from gazelle. Will be used to keep backwards compatibility with hashes
//Once you set this, do. not. change it
$config['site_salt'] = 'SECURE';

//Free points given on register
$config['free_points'] = 5000;

//Is registration open?
$config['open_registration'] = true;

//What is the maximum number of users
$config['max_users'] = 5000;

//Site name
$config['site_name'] = "Narwhal";

//Page title - DO NOT CHANGE
$config['page_title'] = $config['site_name'];

//Default Avatar
$config['default_avatar'] = "/static/common/avatar.png";

//User data cache time, in seconds
$config['userdata_cache'] = 300; // 5 min

//Stats cache time, in seconds
$config['stats_cache'] = 86400; // 24 hours

//Configuration data cache time, in seconds
$config['config_cache'] = 900; // 15 min

//Torrent data (browsing, etc.) cache time, in seconds
$config['torrent_cache'] = 300; // 5 min

//user classes, for permissions and stuff. actual permissions and levels can be found in the collection 'permissions'
$config['classes'] = array('USER' => 2, 'MEMBER' => 3, 'POWER' => 4, 'DONOR' => 20, 'ARTIST' => 18, 'ELITE' => 5, 'VIP' => 6, 'TORRENT_MASTER' => 7, 'LEGEND' => 8, 'CELEB' => 9, 'COMM_MOD' => 10, 'MOD' => 11, 'STAFF_LEADER' => 12, 'DESIGNER' => 13, 'CODER' => 14, 'ADMIN' => 1, 'SYSOP' => 15);

//categories
$config['categories'] = array(
	array('name' => 'Music', 'icon' => 'music.png', 'metadata' => array()),
	array('name' => 'Applications', 'icon' => 'apps.png', 'metadata' => array()),
	array('name' => 'E-Books', 'icon' => 'ebook.png', 'metadata' => array('format_ebook', 'isbn')),
	array('name' => 'Audiobooks', 'icon' => 'audiobook.png', 'metadata' => array()),
	array('name' => 'E-Learning Videos', 'icon' => 'elearning.png', 'metadata' => array()),
	array('name' => 'Magazines', 'icon' => 'magazines.png', 'metadata' => array()),
	array('name' => 'Comics', 'icon' => 'comics.png', 'metadata' => array()),
	array('name' => 'Anime', 'icon' => 'anime.png', 'metadata' => array()),
	array('name' => 'Movies', 'icon' => 'movies.png', 'metadata' => array()),
	array('name' => 'TV', 'icon' => 'tv.png', 'metadata' => array()),
	array('name' => 'Games - PC', 'icon' => 'games-pc.png', 'metadata' => array()),
	array('name' => 'Games - Console', 'icon' => 'games-console.png', 'metadata' => array()),
	array('name' => 'Documentaries', 'icon' => 'documentaries.png', 'metadata' => array()),
	array('name' => 'Misc', 'icon' => 'misc.png', 'metadata' => array())
);
	
//metadata
//types: 0 - *, 1 - enum, 2 - true/false
//required: number required
// TODO complete this, as well as put it in ^^ above
$config['metadata'] = array(
	'format_ebook' => array('display' => 'Format', 'type' => 1, 'multiple' => true, 'required' => 1, 'enum' => array('EPUB', 'MOBI', 'HTML', 'PDF', 'LIT', 'LRF', 'RTF')),
	'isbn' => array('display' => 'ISBN', 'type' => 0, 'multiple' => false, 'required' => 1)
);

