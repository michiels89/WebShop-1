<?php
use Cart\App;
use Slim\Views\Twig;
use Illuminate\Database\Capsule\Manager as Capsule;
use Braintree_Gateway;

session_start();

require __DIR__ . '/../vendor/autoload.php';

$app = new App;

$container = $app->getContainer();

$capsule = new Capsule;

$capsule->addConnection([
    
    'driver'=> 'mysql',
//    'host'=> 'localhost',
//    'database' => 'lynnmxu249_webshop',
//    'username' => 'lynnmxu249_rooot',
//    'password' => 'qofack7f',
    'host'=> '127.0.0.1',
    'database' => 'cart',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => ''
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

$gateway = new Braintree_Gateway([
  'environment' => 'sandbox',
  'merchantId' => 'vj6vv9gttn3rxpmf',
  'publicKey' => 'vcpgwy2hjhb623rw',
  'privateKey' => '2b5f73e3e2c22b9f56dc49c3d1624df7'
]);

require __DIR__ . '/../app/routes.php';

$app->add(new \Cart\Middleware\ValidationErrorsMiddleware($container->get(Twig::class)));
$app->add(new \Cart\Middleware\OldInputMiddleware($container->get(Twig::class)));