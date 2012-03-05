<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

/*****************************************************************
Because of the way these are called, they cannot be put into the
Utility class. If somebody can figure out how to do it, feel free
to move them into the class.
******************************************************************/
function _bbcode_img($action, $attr, $content, $params, $node_obj) {
  $whitelisted_hosts = array(
    'http://i.imgur.com',
    'http://i.min.us',
    'http://i.minus.com',
    'http://upload.wikimedia.org/wikipedia/commons/',
    'https://upload.wikimedia.org/wikipedia/commons/'
  );

  if (!isset($attr['default'])) {
    $url = htmlspecialchars($content);
    $alt = $url;
  } else {
    $url = htmlspecialchars($attr['default']);
    $alt = htmlspecialchars($content);
  }

  if ($action == 'validate') {
      foreach ($whitelisted_hosts as $host) {
        if (substr($url, 0, strlen($host)) === $host)
          return true;
      }

      return false;
  }

  return '<img src="'.$url.'" alt="'.$alt.'" />';
}

function _bbcode_url($action, $attr, $content, $params, $node_obj) {
  if (!isset($attr['default'])) {
    $url = $content;
    $text = htmlspecialchars ($content);
  } else {
    $url = $attr['default'];
    $text = $content;
  }

  return '<a href="'.htmlspecialchars('http://www.dereferer.org/?'.$url).'">'.$text.'</a>';
}

class BBCode {
  public function __construct() {
    require_once(APPPATH.'/libraries/stringparser_bbcode.class.php');

    $bbcode = new StringParser_BBCode();
    $bbcode->addFilter (STRINGPARSER_FILTER_PRE, 'convertlinebreaks');

    $bbcode->addParser (array ('block', 'inline', 'link', 'listitem'), 'htmlspecialchars');
    $bbcode->addParser (array ('block', 'inline', 'link', 'listitem'), 'nl2br');
    $bbcode->addParser ('list', 'bbcode_stripcontents');

    $bbcode->addCode ('b', 'simple_replace', null, array ('start_tag' => '<b>', 'end_tag' => '</b>'),
                      'inline', array ('listitem', 'block', 'inline', 'link'), array ());
    $bbcode->addCode ('i', 'simple_replace', null, array ('start_tag' => '<i>', 'end_tag' => '</i>'),
                      'inline', array ('listitem', 'block', 'inline', 'link'), array ());
    $bbcode->addCode ('u', 'simple_replace', null, array ('start_tag' => '<u>', 'end_tag' => '</u>'),
                      'inline', array ('listitem', 'block', 'inline', 'link'), array ());
    $bbcode->addCode ('s', 'simple_replace', null, array ('start_tag' => '<del>', 'end_tag' => '</del>'),
                      'inline', array ('listitem', 'block', 'inline', 'link'), array ());
    $bbcode->addCode ('url', 'usecontent?', '_bbcode_url', array ('usecontent_param' => 'default'),
                      'link', array ('listitem', 'block', 'inline'), array ('link'));
    $bbcode->addCode ('link', 'callback_replace_single', 'do_bbcode_url', array (),
                      'link', array ('listitem', 'block', 'inline'), array ('link'));
    $bbcode->addCode ('img', 'usecontent', '_bbcode_img', array (),
                      'image', array ('listitem', 'block', 'inline', 'link'), array ());
    $bbcode->addCode ('bild', 'usecontent', '_bbcode_img', array (),
                      'image', array ('listitem', 'block', 'inline', 'link'), array ());
    $bbcode->setOccurrenceType ('img', 'image');
    $bbcode->setOccurrenceType ('bild', 'image');
    $bbcode->setMaxOccurrences ('image', 2);
    $bbcode->addCode ('list', 'simple_replace', null, array ('start_tag' => '<ul>', 'end_tag' => '</ul>'),
                      'list', array ('block', 'listitem'), array ());
    $bbcode->addCode ('*', 'simple_replace', null, array ('start_tag' => '<li>', 'end_tag' => '</li>'),
                      'listitem', array ('list'), array ());
    $bbcode->setCodeFlag ('*', 'closetag', BBCODE_CLOSETAG_OPTIONAL);
    $bbcode->setCodeFlag ('*', 'paragraphs', true);
    $bbcode->setCodeFlag ('list', 'paragraph_type', BBCODE_PARAGRAPH_BLOCK_ELEMENT);
    $bbcode->setCodeFlag ('list', 'opentag.before.newline', BBCODE_NEWLINE_DROP);
    $bbcode->setCodeFlag ('list', 'closetag.before.newline', BBCODE_NEWLINE_DROP);
    $bbcode->setRootParagraphHandling (true);

    $this->bbcode = $bbcode;
  }

  public function render($raw) {
    return $this->bbcode->parse($raw);
  }
}