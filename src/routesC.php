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
$router->post('/admin/painel/add-usuario/action', 'AdminController@addNovoUsuAction');
$router->get('/admin/painel/layout', 'AdminController@layout');
$router->post('/admin/painel/edi-layout', 'AdminController@ediLayoutAction');

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
$router->get('/admin/painel/excluir-ban/{idprod}', 'ProdutoController@excBanner');
$router->get('/admin/painel/excluir-produto/{id}', 'ProdutoController@excProduto');
$router->get('/visualizar/produto/{id}', 'HomeController@visProduto');

// -- Carrinho
$router->post('/add-carrinho', 'CarrinhoController@addCarrinho');
$router->post('/calcular-subtotal', 'CarrinhoController@calTotalProduto');
$router->post('/calcular-preco', 'CarrinhoController@calPrecoProduto');
$router->get('/carrinho', 'CarrinhoController@index');
$router->get('/deletar/item/carrinho/{id}', 'CarrinhoController@delItem');

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
$router->get('/admin/painel/excluir-img-marca/{id}', 'MarcaController@excImgMarcaAction');
$router->post('/admin/painel/editar-marca/action', 'MarcaController@ediMarcaAction');

