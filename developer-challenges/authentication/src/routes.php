<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$app->get('/', function (Request $request, Response $response, array $args) {

  return $this->renderer->render($response, 'index.phtml', $args);

});

$app->get('/two-factor/{twoFactorCode}/{word}', function (Request $request, Response $response, array $args) {

  return $this->renderer->render($response, 'two-factor.phtml', $args);

});

$app->get('/check-two-factor/{twoFactorCode}', function (Request $request, Response $response, array $args) {

  $database = new Database();
  $connection = $database->getConnection();
  $authenticate = new Authenticate($connection);
  $authenticated = $authenticate->checkTwoFactor($args['twoFactorCode']);

  return $response->withJson(['authenticated' => $authenticated]);

});

$app->get('/home', function (Request $request, Response $response, array $args) {

  return $this->renderer->render($response, 'home.phtml', $args);

});

$app->post('/check-login', function (Request $request, Response $response, array $args) {

  $database = new Database();
  $connection = $database->getConnection();
  $authenticate = new Authenticate($connection);
  $authenticated = $authenticate->checkUserDetails($_POST['username'], $_POST['password']);

  if(!$authenticated) {
    return $response->withRedirect('/developer-challenges/authentication/public');
  }

  $twoFactorCode = uniqid();

  $word = 'house';

  $authenticate->initiateTwoFactor($_POST['username'], $twoFactorCode, $word);

  return $response->withRedirect('two-factor/' . $twoFactorCode . '/' . $word);

});

$app->post('/google-authenticate', function (Request $request, Response $response, array $args) {

  $parsedBody = $request->getParsedBody();

  $database = new Database();
  $connection = $database->getConnection();
  $authenticate = new Authenticate($connection);
  $authenticate->googleAuthenticate($parsedBody['result']['parameters']['word']);

  $googleHome = new GoogleHome();

  $googleResponse = $googleHome->format_reponse(
    "Your word is " . $parsedBody['result']['parameters']['word'],
    "Your word is " . $parsedBody['result']['parameters']['word']
  );

  return $response->withJson($googleResponse);

});