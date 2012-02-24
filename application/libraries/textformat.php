<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class TextFormat {
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
	
	function do_bbcode_quote($action, $attributes, $content, $params, $node_object) {
		if($action == 'validate') {
    	    return true;
    	}
		$str = '';
		if(isset($attributes['default'])) {
			$str .= '<strong>'.$attributes['default'].'</strong> Wrote:';
		}
		$str .= '<blockquote>'.$content.'</blockquote>';
		return $str;
	}
	
	function do_bbcode_img($action, $attributes, $content, $params, $node_object) {
		if(isset($attributes['default'])) {
			$content = $attributes['default'];
		}
		if ($action == 'validate') {
			$pattern = '/(https?:\/\/'.$this->CI->config->item('allowed_imagehosts').'[^\s\'\"<>()]+(\.(jpg|jpeg|gif|png|tif|tiff|bmp)))/is';
			if(!preg_match($pattern, $content))
            	return false;
        	return true;
		}
		return '<img src="'.htmlspecialchars($content).'" alt="'.htmlspecialchars($content).'" onload="scale(this);" onclick="scale(this);" >';
	}
	
	function do_bbcode_yt($action, $attributes, $content, $params, $node_object) {
		if ($action == 'validate') {
			$pattern = '/http:\/\/[^\]]+v=([\w-]+)/is';
			if(!preg_match($pattern, $content))
            	return false;
        	return true;
		}
		$pattern = '/http:\/\/[^\]]+v=([\w-]+)/is';
		preg_match($pattern, $content, $matches);
		return '<iframe width="480" height="320" src="http://www.youtube.com/embed/'.$matches[1].'?rel=0&wmode=opaque" frameborder="0" allowfullscreen></iframe>';
	}
	
	function do_bbcode_color($action, $attributes, $content, $params, $node_object) {
		if ($action == 'validate') {
			$pattern = '/(#[0-9a-f]{6}|rgb\(\d{1,3},\d{1,3},\d{1,3}\)|aqua|black|blue|fuchsia|green|grey|lime|maroon|navy|olive|purple|red|silver|teal|white|yellow)/is';
			if(preg_match($pattern, $attributes['default']))
        		return true;
        	return false;
		}
		return '<span style="color: '.$attributes['default'].';">'.$content.'</span>';
	}
	
	function do_bbcode_align($action, $attributes, $content, $params, $node_object) {
		if ($action == 'validate') {
			if(in_array($attributes['default'], array('center', 'left', 'right')))
        		return true;
        	return false;
		}
		return '<div style="text-align: '.$attributes['default'].';">'.$content.'</div>';
	}
	
	function do_bbcode_size($action, $attributes, $content, $params, $node_object) {
		if ($action == 'validate') {
			return true;
		}
		$size = floor($attributes['default']);
		$size = min($size, 10);
		$size = max(0, $size);
		return '<span class="size'.$size.'">'.$content.'</span>';
	}
	
	function do_bbcode_spoiler($action, $attributes, $content, $params, $node_object) {
		if(!isset($attributes['default'])) {
			$text = 'Spoiler';
		} else {
			$text = $attributes['default'];
		}
		if($action == 'validate') {
    	    return true;
    	}
    	$spoiler1 = <<<DERP
<div><div style="text-align:center;"><input type="button" value="Show/Hide %s" onclick="if (this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display != '') { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = '';this.innerText = ''; this.value = 'Hide %s'; } else { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = 'none'; this.innerText = ''; this.value = 'Show %s'; }"></div><div><div style="display: none;">
DERP;
		$spoiler2 = '</div></div></div>';
    	return sprintf($spoiler1, $text, $text, $text).$content.$spoiler2;
	}
	
	public function __construct()
	{
		$this->CI =& get_instance();
		require_once(APPPATH.'/libraries/stringparser_bbcode.class.php');
		
		$this->bbcode = new StringParser_BBCode();
		$this->bbcode->setGlobalCaseSensitive(false);
		$this->bbcode->addParser(array('block', 'inline', 'link'), 'nl2br');
		$this->bbcode->addParser(array('block', 'inline'), array($this, 'smileys'));
		$this->bbcode->addParser(array('block', 'inline'), array($this, 'urls'));
		
		$this->bbcode->addCode('b', 'simple_replace', null, array('start_tag' => '<strong>', 'end_tag' => '</strong>'), 'inline', array('block', 'inline', 'list'), array());
		$this->bbcode->addCode('i', 'simple_replace', null, array('start_tag' => '<em>', 'end_tag' => '</em>'), 'inline', array('block', 'inline', 'list'), array());
		$this->bbcode->addCode('u', 'simple_replace', null, array('start_tag' => '<u>', 'end_tag' => '</u>'), 'inline', array('block', 'inline', 'list'), array());
		$this->bbcode->addCode('s', 'simple_replace', null, array('start_tag' => '<s>', 'end_tag' => '</s>'), 'inline', array('block', 'inline', 'list'), array());
		$this->bbcode->addCode('url', 'usecontent?', array(&$this, 'do_bbcode_url'), array('usecontent_param' => 'default'), 'link', array('block', 'inline', 'list'), array());
		$this->bbcode->addCode('quote', 'callback_replace', array(&$this, 'do_bbcode_quote'), array(), 'block', array('block', 'inline'), array());
		$this->bbcode->addCode('align', 'usecontent?', array(&$this, 'do_bbcode_align'), array('usecontent_param' => 'default'), 'inline', array('block', 'inline', 'list'), array());
		$this->bbcode->addCode('size', 'usecontent?', array(&$this, 'do_bbcode_size'), array('usecontent_param' => 'default'), 'inline', array('block', 'inline', 'list'), array());
		$this->bbcode->addCode('img', 'usecontent?', array(&$this, 'do_bbcode_img'), array('usecontent_param' => 'default'), 'img', array('block', 'inline', 'list'), array());
		$this->bbcode->addCode('youtube', 'usecontent?', array(&$this, 'do_bbcode_yt'), array(), 'block', array('block', 'inline', 'list'), array());
		$this->bbcode->addCode('color', 'usecontent?', array(&$this, 'do_bbcode_color'), array('usecontent_param' => 'default'), 'inline', array('block', 'inline', 'list'), array());
		$this->bbcode->addCode('list', 'simple_replace', null, array('start_tag' => '<ul>', 'end_tag' => '</ul>'), 'list', array('block', 'inline', 'listitem'), array());
		$this->bbcode->addCode('*', 'simple_replace', null, array('start_tag' => '<li>', 'end_tag' => '</li>'), 'listitem', array('list'), array());
		$this->bbcode->addCode('code', 'simple_replace', null, array('start_tag' => '<pre>', 'end_tag' => '</pre>'), 'pre', array('block', 'inline', 'list'), array());
		$this->bbcode->addCode('pre', 'simple_replace', null, array('start_tag' => '<pre>', 'end_tag' => '</pre>'), 'pre', array('block', 'inline', 'list'), array());
		
		$this->bbcode->setOccurrenceType('img', 'image');
		$this->bbcode->setOccurrenceType('youtube', 'video');
		$this->bbcode->setMaxOccurrences('image', $this->CI->config->item('max_img_per_post'));
		$this->bbcode->setMaxOccurrences('video', $this->CI->config->item('max_yt_per_post'));
		
		$mediainfo1 = <<<DERP
<div><div style="text-align:center;"><input type="button" value="Show/Hide MediaInfo" onclick="if (this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display != '') { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = '';this.innerText = ''; this.value = 'Hide MediaInfo'; } else { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = 'none'; this.innerText = ''; this.value = 'Show MediaInfo'; }"></div><div><div style="display: none;"><pre>
DERP;
		$mediainfo2 = '</pre></div></div></div>';
		$this->bbcode->addCode('mediainfo', 'simple_replace', null, array('start_tag' => $mediainfo1, 'end_tag' => $mediainfo2), 'pre', array('block', 'inline'), array());
		
		$this->bbcode->addCode('spoiler', 'callback_replace', array(&$this, 'do_bbcode_spoiler'), array(), 'block', array('block', 'inline', 'list'), array());
		
		$this->bbcode->setCodeFlag('*', 'closetag', BBCODE_CLOSETAG_OPTIONAL);
		$this->bbcode->setCodeFlag('img', 'closetag', BBCODE_CLOSETAG_OPTIONAL);
		
		$this->smileys = array(
			':angry:' => 'angry.gif',
			':-D' => 'biggrin.gif',
			':D' => 'biggrin.gif',
			':|' => 'blank.gif',
			':-|' => 'blank.gif',
			':blush:' => 'blush.gif',
			':cool:' => 'cool.gif',
			':\'(' => 'crying.gif',
			'&gt;.&gt;' => 'eyesright.gif',
			':frown:' => 'frown.gif',
			'&lt;3' => 'heart.gif',
			':unsure:' => 'hmm.gif',
			':lol:' => 'laughing.gif',
			':loveflac:' => 'loveflac.gif',
			':ninja:' => 'ninja.gif',
			':no:' => 'no.gif',
			':nod:' => 'nod.gif',
			':ohno:' => 'ohnoes.gif',
			':ohnoes:' => 'ohnoes.gif',
			':omg:' => 'omg.gif',
			':o' => 'ohshit.gif',
			':O' => 'ohshit.gif',
			':paddle:' => 'paddle.gif',
			':(' => 'sad.gif',
			':-(' => 'sad.gif',
			':shifty:' => 'shifty.gif',
			':sick:' => 'sick.gif',
			':)' => 'smile.gif',
			':-)' => 'smile.gif',
			':sorry:' => 'sorry.gif',
			':thanks:' => 'thanks.gif',
			':P' => 'tongue.gif',
			':-P' => 'tongue.gif',
			':-p' => 'tongue.gif',
			':wave:' => 'wave.gif',
			':wink:' => 'wink.gif',
			':worried:' => 'worried.gif',
			':wtf:' => 'wtf.gif',
			':wub:' => 'wub.gif',
			':baconbits:' => 'ilbb.gif',
			':iluvbacon:' => 'ilbacon.gif'
		);
	}
	
	public function parse($str) {
		return $this->bbcode->parse($str);
	}
	
	public function smileys($str) {
		foreach($this->smileys as $k => $v) {
			$str = str_replace($k, '<img src="/static/common/smileys/'.$v.'" alt="'.$k.'" title="'.$k.'">', $str);
		}
		return $str;
	}
	
	function urls($Str) {
		$Str = preg_replace("/(\A|[^=\]'\"a-zA-Z0-9\?])((http|ftp|https|ftps|irc):\/\/[^<>\s()]+)/i",
					"\\1<a href='http://dereferer.org/?\\2' target='_blank'>\\2</a>", $Str);

		$Str = str_replace("http://dereferer.org/?http://" . $this->CI->config->item('http_siteurl'), "http://" . $this->CI->config->item('http_siteurl'), $Str);
		$Str = str_replace("http://dereferer.org/?https://" . $this->CI->config->item('https_siteurl'), "https://" . $this->CI->config->item('https_siteurl'), $Str);	
		/*// VULNERABLE
		// Local site links
		$Replace[] = '/(<a href=[\'"]?)?http(s)?:\/\/www\.'.preg_quote($this->CI->config->item('http_siteurl'),'/').'\/?([^<>\s]*)([\'"]>)?/i';
		$Replace[] = '/(<a href=[\'"]?)?http(s)?:\/\/'.preg_quote($this->CI->config->item('http_siteurl'),'/').'\/?([^<>\s]*)([\'"]>)?/i';
		$Replace[] = '/(<a href=[\'"]?)?http(s)?:\/\/'.preg_quote($this->CI->config->item('https_siteurl'),'/').'\/?([^<>\s]*)([\'"]>)?/i';
		$Str = preg_replace_callback($Replace, array($this, 'fix_url'),$Str);*/
		return $Str;
	}
	
	// Fix a URL to our site to be relative instead of absolute
	function fix_url($Str) {
		$URL = stripslashes($Str[3]);
		$IsLink = stripslashes($Str[1]);

		if($URL == "'") { $URL = "/'"; }
		elseif($URL == '"') { $URL = '/"'; }

		if ($IsLink && !$URL) { return $IsLink.'/'; }
		elseif ($IsLink && $URL) { return $IsLink.$URL; }
		elseif (!$IsLink && (!$URL || $URL == '/"' || $URL == "/'")) { return $this->CI->config->item('site_name'); }
		elseif (!$IsLink && $URL) { return $URL; }
	}
}
