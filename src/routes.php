<?php
use core\Router;

$router = new Router();

$router->get('/', 'HomeController@index');
$router->get('/sobre/{nome}', 'HomeController@sobreP');


$router->get('/crie-sua-loja', 'CadastroController@index');
$router->post('/crie-sua-loja/inserir', 'CadastroController@inserir');
$router->post('/crie-sua-loja/verifica-cpf', 'CadastroController@verifica_cpf_cadastrado');
$router->get('/crie-sua-loja/pagamento', 'CadastroController@pagamento');
$router->get('/crie-sua-loja/pagamento/cartao/{pl}', 'PgCheckTransPrincipalController@pagamentoPlano');
$router->get('/crie-sua-loja/pagamento/boleto/checkout/{pl}', 'BoletoController@checkout');
$router->get('/crie-sua-loja/pagamento/obrigado/{id}', 'BoletoController@obrigado');

$router->post('/crie-sua-loja/escolha-pagamento', 'OpcaoPgmController@escolhaPagamento');
$router->get('/crie-sua-loja/obrigado', 'CadastroController@inserirCadastroFree');
$router->post('/checkout', 'PgCheckTransPrincipalController@checkout');
$router->post('/cartao/notification', 'PgCheckTransPrincipalController@notification');
$router->post('/boleto/notification', 'BoletoController@notification');



$router->get('/login', 'LoginController@index');
$router->post('/login/validar', 'LoginController@validar');
$router->get('/painel', 'PainelController@index');
$router->get('/sair', 'LoginController@sair');
