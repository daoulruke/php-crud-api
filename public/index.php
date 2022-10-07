<?php

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

  function get_env_values($env_file) {
      $env_values = [];
      $env_contents = file($env_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
      foreach ($env_contents as $content) {
          if (strpos(trim($content), '#') === 0) {
              continue;
          }
          list($key, $value) = explode('=', $content, 2);
          $key = trim($key);
          $value = trim($value);
          $env_values[$key] = $value;
      }
      return $env_values;
  }

  $env_file = "{$_SERVER['DOCUMENT_ROOT']}/../.env";

  if (file_exists($env_file)) {
      $_ENV = get_env_values($env_file);
  } else {
      die('[FATAL ERROR] ENVIRONMENT UNKNOWN');
  }


  if($_SESSION['PHP_CRUD_API_DEBUG'] == true) {
      ini_set('display_errors', 1);
      ini_set('display_startup_errors', 1);
      error_reporting(E_ALL);
  }

  include('api.include.php');
  //require 'controllers.php';
  //require 'router.php';

  $request = RequestFactory::fromGlobals();
  $original_request = $request;


  $config = new Config([
    // using $_ENV
  ]);

  $request = RequestFactory::fromGlobals();
  $api = new Api($config);

  $response = $api->handle($request);
  ResponseUtils::output($response);

  //file_put_contents('request.log',RequestUtils::toString($request)."===\n",FILE_APPEND);
  //file_put_contents('request.log',ResponseUtils::toString($response)."===\n",FILE_APPEND);

?>
