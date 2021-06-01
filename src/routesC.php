<?php
use core\Router;
use src\controllers\CadastroController;

$router = new Router(); 

/************************  ROTAS ECOMMERCE ************************/

$router->get('/', 'HomeController@index');

$router->get('/admin', 'AdminController@index');
$router->post('/admin/logar', 'AdminController@logar');
$router->get('/admin/painel', 'AdminController@painel');
$router->get('/admin/sair', 'AdminController@sair');
$router->get('/admin/painel/adicionar-produto', 'AdminController@addProduto');

