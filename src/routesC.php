<?php
use core\Router;
use src\controllers\CadastroController;

$router = new Router(); 

/************************  ROTAS ECOMMERCE ************************/

$router->get('/', 'HomeController@index');

// -- Painel Usuario
$router->get('/admin', 'AdminController@index');
$router->post('/admin/logar', 'AdminController@logar');
$router->get('/admin/painel', 'AdminController@painel');
$router->get('/admin/sair', 'AdminController@sair');
$router->get('/admin/painel/alterar-dados-pessoais', 'AdminController@ediDadosPessoais');
$router->post('/admin/painel/alterar-dados-pessoais/action', 'AdminController@ediDadosPessoaisAction');
$router->post('/consulta-cep', 'AdminController@consultarCep');
$router->get('/admin/painel/add-novo-usuario', 'AdminController@addNovoUsu');

// -- Produtos
$router->get('/admin/painel/produtos', 'ProdutoController@conProduto');
$router->get('/admin/painel/cadastrar-produtos', 'ProdutoController@cadProduto');
$router->post('/admin/painel/cadastrar-produtos/first', 'ProdutoController@cadProdutoActionFirst');
$router->post('/admin/painel/cadastrar-produtos/second', 'ProdutoController@cadProdutoActionSecond');
$router->get('/admin/painel/cadastrar-produtos/{id}', 'ProdutoController@cadProdutoSecond');
$router->get('/admin/painel/editar-produto/{id}', 'ProdutoController@ediProduto');
$router->post('/admin/painel/editar-produto', 'ProdutoController@ediProdutoAction');
$router->get('/admin/painel/detalhes-produto/{id}', 'ProdutoController@conDetalheProduto');
$router->get('/admin/painel/excluir-img/{idimg}/{idprod}', 'ProdutoController@excImagem');
$router->get('/admin/painel/excluir-produto/{id}', 'ProdutoController@excProduto');

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

