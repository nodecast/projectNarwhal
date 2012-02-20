<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class TextFormat {
	function convertlinebreaks($text) {
    	return str_replace("\n", "<br>\n", $text);
	}
	
	function do_bbcode_url($action, $attributes, $content, $params, $node_object) {
		if(!isset($attributes['default'])) {
			$url = $content;
			$text = htmlspecialchars($content);
		} else {
			$url = $attributes['default'];
			$text = $content;
		}
		if($action == 'validate') {
			if(substr($url, 0, 5) == 'data:' || substr($url, 0, 5) == 'file:' || substr($url, 0, 11) == 'javascript:' || substr($url, 0, 4) == 'jar:')
				return false;
    	    return true;
    	}
    	return '<a href="http://dereferer.org/?'.htmlspecialchars($url).'">'.$text.'</a>';
	}
	
	function do_bbcode_img($action, $attributes, $content, $params, $node_object) {
		if ($action == 'validate') {
			$pattern = '/(https?:\/\/'.$this->CI->config->item('allowed_imagehosts').'[^\s\'\"<>()]+(\.(jpg|jpeg|gif|png|tif|tiff|bmp)))/is';
			if(!preg_match($pattern, $content))
            	return false;
        	return true;
		}
		return '<img src="'.htmlspecialchars($content).'" alt="'.htmlspecialchars($content).'" onload="scale(this);" onclick="scale(this);" >';
	}
	
	public function __construct()
	{
		$this->CI =& get_instance();
		require_once('stringparser_bbcode.class.php');
		
		$this->bbcode = new StringParser_BBCode();
		$this->bbcode->addFilter(STRINGPARSER_FILTER_PRE, array(&$this, 'convertlinebreaks'));
		
		$this->bbcode->addCode('b', 'simple_replace', null, array('start_tag' => '<strong>', 'end_tag' => '</strong>'), 'inline', array('block', 'inline'), array());
		$this->bbcode->addCode('i', 'simple_replace', null, array('start_tag' => '<em>', 'end_tag' => '</em>'), 'inline', array('block', 'inline'), array());
		$this->bbcode->addCode('u', 'simple_replace', null, array('start_tag' => '<u>', 'end_tag' => '</u>'), 'inline', array('block', 'inline'), array());
		$this->bbcode->addCode('s', 'simple_replace', null, array('start_tag' => '<s>', 'end_tag' => '</s>'), 'inline', array('block', 'inline'), array());
		$this->bbcode->addCode('url', 'usecontent', array(&$this, 'do_bbcode_url'), array('usecontent_param' => 'default'), 'link', array('block', 'inline'), array());
		$this->bbcode->addCode('img', 'usecontent', array(&$this, 'do_bbcode_img'), array(), 'inline', array('block', 'inline'), array());
		
		/*bbcode_add_smiley($this->bbcode, "\n", '<br>');
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
		$this->smiley(':iluvbacon:', '/static/common/smileys/ilbacon.gif');*/
	}
	
	public function parse($str) {
		return $this->bbcode->parse($str);
	}
	
	public function __destruct()
	{
		bbcode_destroy($this->bbcode);
	}
}
