<?php
use core\Router;

$router = new Router();

$router->get('/', 'HomeController@index');
$router->get('/sobre/{nome}', 'HomeController@sobreP');


$router->get('/crie-sua-loja', 'CadastroController@index');

$router->post('/crie-sua-loja/inserir', 'CadastroController@inserir');