<?php
session_start();
require '../vendor/autoload.php';
require '../src/routes.php';

// echo $_SERVER['HTTP_HOST']. '<BR>';
// echo $_SERVER['SERVER_PORT']. '<BR>';
// echo $_SERVER['SERVER_NAME'];
// $dominio = explode('.',$_SERVER['HTTP_HOST']);
// print_r($dominio);
// //exit;
$router->run( $router->routes );