<?php

namespace Cli;

class Cli{

  public $namespace;
  var $class;
  var $method;
  var $params = array();

  function __construct($namespace, $argv = null, $config = null){
    $this->namespace = $namespace;
    $this->config = $config;

    if($argv !== null){
      $this->argv = $argv;

      if(isset($argv[1])){
        $method = str_replace("-", "", $argv[1]);
        if(method_exists($this, $method)){
          $this->$method();
        } else {
          echo "method not found \n";
        }
      }
    }
  }

  function fetch($cmd){
    preg_match('/(\\\\?\w+?\\\\?\w+)\.?(\w+)\((.+)?\)/', $cmd, $matches);
    $this->class = $this->namespace.'\\'.$matches[1];
    $this->method = trim($matches[2]);
    if(isset($matches[3])){
      foreach(explode(",", $matches[3]) as $param){
        $this->params[] = trim($param);
      }
    }
  }

  function x(){
    if(!isset($this->argv[2])){
      echo "Something is missing.. \n";
      exit;
    }

    // if true, no orders will be executed
    $test = false;
    if(isset($this->argv[3])){
      $test = (in_array($this->argv[3], array("test", "setup"))) ? true : $test ;
    }
    define("TEST", $test);

    if(TEST){
      echo "TEST !! \n";
    }

    $this->fetch($this->argv[2]);

    $c = $this->class;
    $m = $this->method;
    $p = $this->params;

    if(!class_exists($c)){
      echo "Class $c not found \n";
      return ;
    }

    if($this->config !== null){
      $C = new $c((object)["config" => $this->config]);
    } else {
      $C = new $c();
    }

    if(!method_exists($C, $m)){
      echo "method $c::$m not found \n";
      return ;
    }

    call_user_func_array(array($C, $m), $p);
  }

}

