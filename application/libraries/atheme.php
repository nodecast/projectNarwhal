<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

require_once(APPPATH.'/libraries/xmlrpc.php');

class Atheme {
  public function __construct() {
    $this->ci =& get_instance();
    $this->ci->load->config('atheme');
  }

  private function run($service, $command, $params) {
    $hostname = $this->ci->config->item('atheme_server');
    $port = $this->ci->config->item('atheme_port');
    $path = $this->ci->config->item('atheme_path');
    $username = $this->ci->config->item('atheme_username');
    $password = $this->ci->config->item('atheme_password');
    $sourceip = '127.0.0.1';

    $message = new xmlrpcmsg("atheme.login");
    $message->addParam(new xmlrpcval($username, "string"));
    $message->addParam(new xmlrpcval($password, "string"));
    $client = new xmlrpc_client($path, $hostname, $port);
    $response = $client->send($message);

    $session = NULL;
    if (!$response->faultCode())
    {
      $session = explode("<string>", $response->serialize());
      $session = explode("</string", $session[1]);
      $session = $session[0];
    }
    else
    {
      return "Authorisation failed";
    }

    $message = new xmlrpcmsg("atheme.command");
    $message->addParam(new xmlrpcval($session, "string"));
    $message->addParam(new xmlrpcval($username, "string"));
    $message->addParam(new xmlrpcval($sourceip, "string"));
    $message->addParam(new xmlrpcval($service, "string"));
    $message->addParam(new xmlrpcval($command, "string"));
    if ($params != NULL)
    {
      if (sizeof($params) < 2)
      {
        foreach($params as $param)
        {
          $message->addParam(new xmlrpcval($param, "string"));
        }
      }
      else
      {
        $firstparam = $params[0];
        $secondparam = "";
        for ($i = 1; $i < sizeof($params); $i++)
        {
          $secondparam .= $params[$i] . " ";
        }
        $message->addParam(new xmlrpcval($firstparam, "string"));
        $message->addParam(new xmlrpcval($secondparam, "string"));
      }
      $response = $client->send($message);
    }

    if (!$response->faultCode())
    {
      return $response->serialize();
    }
    else
    {
      return "Command failed: " . $response->faultString();
    }

  }

  public function say($channel, $message) {
    return $this->run('BotServ', 'SAY', array($channel, $message));
  }

  public function announce($message) {
    return $this->say('#announce', $message);
  }
}

