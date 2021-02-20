<?php
use core\Router;

$router = new Router();

$router->get('/', 'HomeController@index');
$router->get('/sobre/{nome}', 'HomeController@sobreP');


$router->get('/crie-sua-loja', 'CadastroController@index');
$router->post('/crie-sua-loja/inserir', 'CadastroController@inserir');
$router->post('/crie-sua-loja/verifica-cpf', 'CadastroController@verifica_cpf_cadastrado');
$router->get('/crie-sua-loja/pagamento', 'CadastroController@pagamento');
$router->get('/crie-sua-loja/opcao-pagamento/{pl}', 'OpcaoPgmController@index');


$router->get('/login', 'LoginController@index');
$router->post('/login/validar', 'LoginController@validar');
$router->get('/sair', 'LoginController@sair');

$router->get('/painel', 'PainelController@index');

$router->post('/checkout', 'PgCheckTransPrincipalController@checkout');
$router->post('/notification', 'PgCheckTransPrincipalController@notification');

//$router->get('/crie-sua-loja/pagamento/{pl}/transacao', 'PgCheckTransPrincipalController@index');

