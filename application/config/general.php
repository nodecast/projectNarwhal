<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Whether to use IRC based features
$config['irc_enabled'] = true;

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
$config['site_name'] = "Project Narwhal";

//Page title - DO NOT CHANGE
$config['page_title'] = $config['site_name'];

//static server, '/static' by default
$config['static_server'] = '/static';

//Default Avatar
$config['default_avatar'] = $config['static_server'].'/common/avatar.png';

//Max torrent size.
$config['torrent_maxsize'] = 2097152; // 2 MiB

//Freeleech size, any torrents larger than this are freeleech
$config['freeleech_size'] = 10737418240; // 10 GiB

//Avatar for 'system'
$config['system_avatar'] = $config['static_server'].'/common/avatar_system.png';

//stylesheets
$config['stylesheets'] = array($config['static_server'].'/styles/default/style.css');

//regarding posts
$config['max_img_per_post'] = 7;
$config['max_yt_per_post'] = 2;
$config['max_bytes_per_post'] = 8192; //8KiB
$config['max_bytes_per_message'] = 8192; //8KiB

//CACHE
//User data cache time, in seconds
$config['userdata_cache'] = 300; // 5 min
//Stats cache time, in seconds
$config['stats_cache'] = 86400; // 24 hours
//Configuration data cache time, in seconds
$config['config_cache'] = 900; // 15 min
//Torrent data (browsing, etc.) cache time, in seconds
$config['torrent_cache'] = 300; // 5 min
//KB data cache time, in seconds
$config['kb_cache'] = 86400; // 24 hours
//News data cache time, in seconds
$config['news_cache'] = 1800; // 30 minutes
//Alert cache time, in seconds -- Q: "Why is this so high?" A: "Because the cache value is deleted after sending a new alert"
$config['alert_cache'] = 600; // 10 min
//Message cache time, in seconds, alright, seriously? why am I still writing this out; it's self explanatory.
$config['message_cache'] = 10; // 10 seconds
$config['forums_cache'] = 60; // 1 min

//PERPAGE
$config['torrent_perpage'] = 50;
$config['torrent_comments_perpage'] = 10;
$config['messages_perpage'] = 25;
$config['threads_perpage'] = 25;
$config['posts_perpage'] = 25;

//site urls
$config['https_siteurl'] = 'phos.projectnarwhal.org';
$config['http_siteurl'] = 'phos.projectnarwhal.org';
$config['announce_url'] = 'http://phos.projectnarwhal.org:9999';
$config['chat_url'] = 'http://phos.projectnarwhal.org:9090';

//allowed image hosts
$config['allowed_imagehosts'] = '('
	.'baconbits\.org|'
	.'(i\.)?imgur\.com|'
	.'[a-z]\.imagehost\.org|'
	.'img[0-9]+\.imageshack\.us|'
	.'upload\.wikimedia\.org|'
	.'commons\.wikimedia\.org|'
	.'whatimg\.com|'
	.'madderist\.baconbits\.org|'
	// i.min.us issues 302 redirects to i.minus.com
	// so i.minus.com is the preferred host
	.'(i\.)?min\.us|'
	.'(i\.)?minus\.com|'
	.'images\.baconbits\.org'
	.')\/';

//user classes, for permissions and stuff. actual permissions and levels can be found in the collection 'permissions'
$config['classes'] = array('USER' => 2, 'MEMBER' => 3, 'POWER' => 4, 'ELITE' => 5, 'VIP' => 6, 'TORRENT_MASTER' => 7, 'HELPER' => 10, 'MOD' => 11, 'DEVELOPER' => 14, 'ADMIN' => 1, 'SYSOP' => 15);

//categories
//secondary [metadata], this will be displayed in search results nex to the title (like author/artist/etc.), also format
$config['categories'] = array(
	array('name' => 'Music', 'icon' => 'music.png', 'metadata' => array()),
	array('name' => 'Applications', 'icon' => 'apps.png', 'metadata' => array()),
	array('name' => 'E-Books', 'icon' => 'ebook.png', 'metadata' => array('author', 'format_ebook', 'isbn', 'genre_ebook', 'retail_ebook'), 'secondary' => array('author', 'format_ebook', 'retail_ebook')),
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
//search[types], only applies for type:0 ^^, 0- exact, 1- text, split by <space>, for each word check subject *word* 
// TODO complete this, as well as put it in ^^ above
$config['metadata'] = array(
	// ebooks
	'format_ebook' => array('display' => 'Format(s)', 'type' => 1, 'multiple' => true, 'required' => true, 'enum' => array('EPUB', 'MOBI', 'HTML', 'PDF', 'DJVU', 'LRF', 'RTF')),
	'isbn' => array('display' => 'ISBN', 'type' => 0, 'multiple' => false, 'required' => true),
	'author' => array('display' => 'Author(s)', 'type' => 0, 'multiple' => true, 'required' => true),
	'genre_ebook' => array('display' => 'Genre(s)', 'type' => 1, 'multiple' => true, 'required' => true, 'enum' => array('Action/Adventure', 'Crime/Thriller', 'Food', 'History', 'Humor', 'Juvenile', 'Literary Classics', 'Math/Science/Tech', 'Political/Sociological/Religion', 'Romance', 'Science Fiction/Fantasy', 'Young Adult')),
	'retail_ebook' => array('display' => 'Retail', 'type' => 2, 'required' => true)
 );

// default user settings
$config['default_user_settings'] = array(
	'download_as_txt' => false
);

// exchange
$config['exchange_items'] = array(
	'upload' => array(
		'title' => 'Convert BP to Upload',
		'price' => '1,000 BP/GiB',
		'tax' => 0.00,
		'action' => 'Convert BP'
	),
	'invite' => array(
		'title' => 'Buy an invite! Invite your friends!',
		'price' => '10,000 BP',
		'tax' => 0.00,
		'action' => 'Buy Invite'
	),
	'transfer' => array(
		'title' => 'Transfer points to anyone else!',
		'price' => 'N/A',
		'tax' => 0.20,
		'action' => 'Transfer BP',
	),
	'vhost' => array(
		'title' => 'Buy a custom vhost!',
		'price' => '5,000 BP',
		'tax' => 0.00,
		'action' => 'Change Vhost',
	),
);

define('SYSTEM_ID', 'aaaaaaaaaaaaaaaaaaaaaaaa');
