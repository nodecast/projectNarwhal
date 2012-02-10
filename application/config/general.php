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
$config['torrent_cache'] = 60; // 1 min

//user classes, for permissions and stuff. actual permissions and levels can be found in the collection 'permissions'
$config['classes'] = array('USER' => 2, 'MEMBER' => 3, 'POWER' => 4, 'DONOR' => 20, 'ARTIST' => 18, 'ELITE' => 5, 'VIP' => 6, 'TORRENT_MASTER' => 7, 'LEGEND' => 8, 'CELEB' => 9, 'COMM_MOD' => 10, 'MOD' => 11, 'STAFF_LEADER' => 12, 'DESIGNER' => 13, 'CODER' => 14, 'ADMIN' => 1, 'SYSOP' => 15);

//categories
$config['categories'] = array('Music', 'Applications', 'E-Books', 'Audiobooks', 'E-Learning Videos', 'Magazines', 'Comics', 'Anime', 'Movies', 'TV', 'Games - PC', 'Games - Console', 'Documentaries', 'Misc');

//category icons
$config['category_icons'] = array('music.png', 'apps.png', 'ebook.png', 'audiobook.png', 'elearning.png', 'magazines.png', 'comics.png', 'anime.png', 'movies.png', 'tv.png', 'games-pc.png', 'games-console.png', 'documentaries.png','misc.png');
