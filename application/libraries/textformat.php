<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class TextFormat {
  public static function do_youtube($bbcode, $action, $name, $default, $params, $content) {
    $pattern = '/https?:\/\/[^\]]+v=([\w-]+)/is';
    if ($action == BBCODE_CHECK) {
      if(!preg_match($pattern, $content))
        return true;
    }

    preg_match($pattern, $content, $matches);
    $ytid = $matches[1];
    return "<iframe width=\"640\" height=\"360\" src=\"http://www.youtube-nocookie.com/embed/$ytid\" frameborder=\"0\" allowfullscreen></iframe>";
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
            '_default' => '/^left|right$/'
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
  }

  public function parse($raw) {
    return $this->bbcode->Parse($raw);
  }
}

