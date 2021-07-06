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

// -- Produtos
$router->get('/admin/painel/produtos', 'ProdutoController@conProduto');
$router->get('/admin/painel/cadastrar-produtos', 'ProdutoController@cadProduto');
$router->post('/admin/painel/cadastrar-produtos/first', 'ProdutoController@cadProdutoActionFirst');
$router->post('/admin/painel/cadastrar-produtos/{id}', 'ProdutoController@cadProdutoActionSecond');

// -- Categorias
$router->get('/admin/painel/categorias', 'CategoriaController@conCategoria');
$router->get('/admin/painel/cadastrar-categorias', 'CategoriaController@cadCategoria');
$router->post('/admin/painel/cadastrar-categorias/action', 'CategoriaController@cadCategoriaAction');
$router->get('/admin/painel/editar-categoria/{id}', 'CategoriaController@ediCategoria');
$router->post('/admin/painel/editar-categoria/action', 'CategoriaController@ediCategoriaAction');
$router->get('/admin/painel/excluir-categoria/action/{id}', 'CategoriaController@excCategoriaAction');

// -- Marcas
$router->get('/admin/painel/marcas', 'MarcaController@conMarca');
$router->get('/admin/painel/cadastrar-marcas', 'MarcaController@cadMarca');
$router->post('/admin/painel/cadastrar-marcas/action', 'MarcaController@cadMarcaAction');
$router->get('/admin/painel/excluir-marca/action/{id}', 'MarcaController@excMarcaAction');
$router->get('/admin/painel/editar-marca/{id}', 'MarcaController@ediMarca');
$router->post('/admin/painel/editar-marca/action', 'MarcaController@ediMarcaAction');

