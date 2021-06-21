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

$router->get('/admin/painel/marcas', 'AdminController@conMarca');
$router->get('/admin/painel/cadastrar-marcas', 'AdminController@cadMarca');

$router->get('/admin/painel/categorias', 'AdminController@conCategoria');
$router->get('/admin/painel/cadastrar-categorias', 'AdminController@cadCategoria');

$router->get('/admin/painel/produtos', 'AdminController@conProduto');
$router->get('/admin/painel/cadastrar-produtos', 'AdminController@cadProduto');
$router->post('/admin/painel/cadastrar-produtos/first-part', 'AdminController@cadProdutoActionFirst');

$router->post('/admin/painel/cadastrar-categorias/action', 'AdminController@cadCategoriaAction');
$router->post('/admin/painel/cadastrar-marcas/action', 'AdminController@cadMarcaAction');

