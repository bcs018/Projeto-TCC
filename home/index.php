<?php
session_start();
require '../vendor/autoload.php';
use \src\Config;

// Se o endereço for igual ao setado no config então chama o routes.php onde contem as rotas do site principal
if($_SERVER['HTTP_HOST'] == Config::URL_DEFAULT){
    require '../src/routes.php';
    // Seta o folde para prin, para o arquivo RouterBase.php eu selecionar a pasta certa
    $folder = 'prin';
}else{
    // Senão eu chamo o arquivo routesC.php onde contem as rotas do ecommerces
    require '../src/routesC.php';
    $folder = 'come';
}

// Envio para o metodo run do RouterBase todoas as rotas e o folder setado
$router->run( $router->routes, $folder );