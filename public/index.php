<?php

  namespace Tqdev\PhpCrudApi;

  use Tqdev\PhpCrudApi\Api;
  use Tqdev\PhpCrudApi\Config\Config;
  use Tqdev\PhpCrudApi\Database\GenericDB;
  use Tqdev\PhpCrudApi\RequestFactory;
  use Tqdev\PhpCrudApi\ResponseFactory;
  use Tqdev\PhpCrudApi\ResponseUtils;
  use Tqdev\PhpCrudApi\Middleware\Communication\VariableStore;

  use Nyholm\Psr7\Factory\Psr17Factory;

  if (session_status() === PHP_SESSION_NONE) {
      session_start();
      //$_SESSION['user']['code'] = 'authusersub';
      //$_SESSION['user']['universe_id'] = 'bbb2d5e4-2412-11ed-a282-7aa990d208bc';
      //$_SESSION['fk_mode'] = 'derived';
      //$_SESSION['subdomain'] = 'mysql8';
  }



  if(file_exists('../.env')) {
      $env_vars = file('../.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
      $_ENV = array();
  } else {
      echo '[NO-ENVIRONMENT]' . PHP_EOL;
      exit;
  }

  foreach ($env_vars AS $env_var) {

      if (strpos(trim($env_var), '#') === 0) {
          continue;
      }

      list($name, $value) = explode('=', $env_var, 2);

      $name = trim($name);
      $value = trim($value);

      if (!array_key_exists($name, $_ENV)) {
          putenv(sprintf('%s=%s', $name, $value));
          $_ENV[$name] = $value;
      }

  }

  if($_ENV['PHP_CRUD_API_DEBUG'] == true) {
      ini_set('display_errors', 1);
      ini_set('display_startup_errors', 1);
      error_reporting(E_ALL);
  }

  include('api.include.php');
  //require 'controllers.php';
  //require 'router.php';



  $config = new Config([
    // using $_ENV
  ]);

  $request = RequestFactory::fromGlobals();
  $original_request = $request;
  $api = new Api($config);

  $response = $api->handle($request);
  ResponseUtils::output($response);

  //file_put_contents('request.log',RequestUtils::toString($request)."===\n",FILE_APPEND);
  //file_put_contents('request.log',ResponseUtils::toString($response)."===\n",FILE_APPEND);

?>
