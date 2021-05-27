<?php
use core\Router;
use src\controllers\CadastroController;

$router = new Router(); 

/************************  ROTAS ECOMMERCE ************************/

$router->get('/', 'HomeController@index');

$router->get('/admin', 'AdminController@index');
$router->post('/admin/logar', 'AdminController@logar');
