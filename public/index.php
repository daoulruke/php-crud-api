<?php

  namespace Tqdev\PhpCrudApi;

  use Tqdev\PhpCrudApi\Api;
  use Tqdev\PhpCrudApi\Config\Config;
  use Tqdev\PhpCrudApi\RequestFactory;
  use Tqdev\PhpCrudApi\ResponseUtils;

  include('api.include.php');

  $config = new Config([
      'debug' => true,
      'driver' => '',
      'address' => '',
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
