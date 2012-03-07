<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class TextFormat {
  public static function do_youtube($bbcode, $action, $name, $default, $params, $content) {
    if ($action == BBCODE_CHECK) {
      return true;
    }

    $pattern = '/https?:\/\/[^\]]+v=([\w-]+)/is';
    $n = preg_match($pattern, $content, $matches);
    $ytid = $matches[1];

    if ($ytid)
      return "<iframe width=\"640\" height=\"360\" src=\"http://www.youtube-nocookie.com/embed/$ytid\" frameborder=\"0\" allowfullscreen></iframe>";
    else
      return "<b>INVALID YOUTUBE URL</b>";
  }

  public static function do_spoiler($bbcode, $action, $name, $default, $params, $content) {
    if ($action == BBCODE_CHECK) {
      return true;
    }

    $pattern = '/^([\w_ ]+)$/i';
    preg_match($pattern, $default, $matches);

    if ($params['_default'])
      $name = htmlspecialchars($params['_default']);
    else
      $name = "Spoiler";

    return '<div class="bbcode_spoiler_box"><input type="button" class="bbcode_spoiler_btn" value="Show/Hide '.$name.'" /><br /><div class="bbcode_spoiler">'.$content.'</div></div>';
  }

  public function __construct() {
    require_once(APPPATH.'/libraries/nbbc.php');
    $this->CI =& get_instance();
    $this->bbcode = new BBCode;

    // [pre]$BODY[/pre]
    $this->bbcode->AddRule('pre', Array(
      'simple_start' => '<pre>',
      'simple_end' => '</pre>',
      'class' => 'block',
      'content' => BBCODE_VERBATIM,
      'allow_in' => Array('listitem', 'block', 'columns', 'link'),
    ));

    // [align=(left|right)]$BODY[/align]
    $this->bbcode->AddRule('align',  Array(
        'mode' => BBCODE_MODE_ENHANCED,
        'template' => '<div class="bbcode_align_{$_default}">{$_content}</div>',
        'allow' => Array(
            '_default' => '/^left|center|right$/'
        ),
        'class' => 'block',
        'allow_in' => Array('listitem', 'block', 'columns'),
    ));

    // [youtube]$URL[/youtube]
    $this->bbcode->AddRule('youtube',  Array(
        'mode' => BBCODE_MODE_CALLBACK,
        'method' => array(&$this, 'do_youtube'),
        'class' => 'block',
        'allow_in' => Array('listitem', 'block', 'columns'),
    ));

    // [spoiler=$NAME?]$BODY[/spoiler]
    $this->bbcode->AddRule('spoiler',  Array(
        'mode' => BBCODE_MODE_CALLBACK,
        'method' => array(&$this, 'do_spoiler'),
        'class' => 'block',
        'allow_in' => Array('listitem', 'block', 'columns'),
    ));

    // [mediainfo]$BODY[/mediainfo]
    $this->bbcode->AddRule('mediainfo', Array(
      'simple_start' => '<div class="bbcode_spoiler_box"><input type="button" class="bbcode_spoiler_btn" value="Mediainfo" /><br /><div class="bbcode_spoiler"><pre>',
      'simple_end' => '</pre></div></div>',
      'class' => 'code',
      'content' => BBCODE_VERBATIM,
      'allow_in' => Array(
        'block',
        'columns'
      )
    ));
  }

  public function parse($raw) {
    return $this->bbcode->Parse($raw);
  }
}

