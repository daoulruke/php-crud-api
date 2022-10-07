<?php

  namespace Tqdev\PhpCrudApi;

  use Tqdev\PhpCrudApi\Api;
  use Tqdev\PhpCrudApi\Config\Config;
  use Tqdev\PhpCrudApi\RequestFactory;
  use Tqdev\PhpCrudApi\ResponseUtils;

  //Establish environment variables

  if(file_exists('../.env')) {
      $env_vars = file('../.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
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

  var_dump($_ENV);

  include('api.include.php');

  $config = new Config([
      'debug' => true,
      'driver' => '',
      'port' => '',
      'username' => '',
      'password' => '',
      'database' => ''
  ]);

  $request = RequestFactory::fromGlobals();
  $api = new Api($config);

  $response = $api->handle($request);
  ResponseUtils::output($response);

  //file_put_contents('request.log',RequestUtils::toString($request)."===\n",FILE_APPEND);
  //file_put_contents('request.log',ResponseUtils::toString($response)."===\n",FILE_APPEND);

?>
