<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class TextFormat {
	public function __construct()
	{
		$this->CI =& get_instance();
		
		$tags = array();
		$tags['b'] = array('type' => BBCODE_TYPE_NOARG, 'open_tag' => '<strong>', 'close_tag' => '</strong>', 'flags' => BBCODE_FLAGS_ARG_PARSING);
		$tags['i'] = array('type' => BBCODE_TYPE_NOARG, 'open_tag' => '<em>', 'close_tag' => '</em>', 'flags' => BBCODE_FLAGS_ARG_PARSING);
		$tags['u'] = array('type' => BBCODE_TYPE_NOARG, 'open_tag' => '<u>', 'close_tag' => '</u>', 'flags' => BBCODE_FLAGS_ARG_PARSING);
		$tags['url'] = array(
		'type'              =>  BBCODE_TYPE_OPTARG, 
		'open_tag'          =>  '<a href="{PARAM}">', 
		'close_tag'         =>  '</a>',
		'childs'            =>	'b,i,img',
		'default_arg'       =>	'{CONTENT}',
		);
		
		$this->bbcode = bbcode_create($tags);
		
		bbcode_add_smiley($this->bbcode, "\n", '<br>');
		$this->smiley(':angry:', '/static/common/smileys/angry.gif');
		$this->smiley(':-D'	, '/static/common/smileys/biggrin.gif');
		$this->smiley(':D'	, '/static/common/smileys/biggrin.gif');
		$this->smiley(':|'	, '/static/common/smileys/blank.gif');
		$this->smiley(':-|'	, '/static/common/smileys/blank.gif');
		$this->smiley(':blush:', '/static/common/smileys/blush.gif');
		$this->smiley(':cool:', '/static/common/smileys/cool.gif');
		$this->smiley(':\'('	, '/static/common/smileys/crying.gif');
		$this->smiley('&gt;.&gt;', '/static/common/smileys/eyesright.gif');
		$this->smiley(':frown:', '/static/common/smileys/frown.gif');
		$this->smiley('&lt;3'	, '/static/common/smileys/heart.gif');
		$this->smiley(':unsure:', '/static/common/smileys/hmm.gif');
		$this->smiley(':lol:'	, '/static/common/smileys/laughing.gif');
		$this->smiley(':loveflac:', '/static/common/smileys/loveflac.gif');
		$this->smiley(':ninja:', '/static/common/smileys/ninja.gif');
		$this->smiley(':no:'	, '/static/common/smileys/no.gif');
		$this->smiley(':nod:'	, '/static/common/smileys/nod.gif');
		$this->smiley(':ohno:', '/static/common/smileys/ohnoes.gif');
		$this->smiley(':ohnoes:', '/static/common/smileys/ohnoes.gif');
		$this->smiley(':omg:'	, '/static/common/smileys/omg.gif');
		$this->smiley(':o'	, '/static/common/smileys/ohshit.gif');
		$this->smiley(':O'	, '/static/common/smileys/ohshit.gif');
		$this->smiley(':paddle:', '/static/common/smileys/paddle.gif');
		$this->smiley(':('	, '/static/common/smileys/sad.gif');
		$this->smiley(':-('	, '/static/common/smileys/sad.gif');
		$this->smiley(':shifty:', '/static/common/smileys/shifty.gif');
		$this->smiley(':sick:', '/static/common/smileys/sick.gif');
		$this->smiley(':)'	, '/static/common/smileys/smile.gif');
		$this->smiley(':-)'	, '/static/common/smileys/smile.gif');
		$this->smiley(':sorry:', '/static/common/smileys/sorry.gif');
		$this->smiley(':thanks:', '/static/common/smileys/thanks.gif');
		$this->smiley(':P'	, '/static/common/smileys/tongue.gif');
		$this->smiley(':-P'	, '/static/common/smileys/tongue.gif');
		$this->smiley(':-p'	, '/static/common/smileys/tongue.gif');
		$this->smiley(':wave:', '/static/common/smileys/wave.gif');
		$this->smiley(':wink:', '/static/common/smileys/wink.gif');
		$this->smiley(':worried:', '/static/common/smileys/worried.gif');
		$this->smiley(':wtf:'	, '/static/common/smileys/wtf.gif');
		$this->smiley(':wub:'	, '/static/common/smileys/wub.gif');
		$this->smiley(':baconbits:', '/static/common/smileys/ilbb.gif');
		$this->smiley(':iluvbacon:', '/static/common/smileys/ilbacon.gif');
	}
	
	public function parse($str) {
		return auto_link(bbcode_parse($this->bbcode, $str));
	}
	
	public function smiley($t, $img) {
		bbcode_add_smiley($this->bbcode, $t, '<img src="'.$img.'" alt="'.$t.'">');
	}
	
	public function __destruct()
	{
		bbcode_destroy($this->bbcode);
	}
}
