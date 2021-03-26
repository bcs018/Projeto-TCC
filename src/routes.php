<?php
use core\Router;
use src\controllers\CadastroController;

$router = new Router();

$router->get('/', 'HomeController@index');

$router->get('/crie-sua-loja', 'CadastroController@index');
$router->post('/crie-sua-loja/inserir', 'CadastroController@inserir');
$router->post('/crie-sua-loja/verifica-cpf', 'CadastroController@verifica_cpf_cadastrado');
$router->get('/crie-sua-loja/pagamento', 'CadastroController@pagamento');
$router->get('/crie-sua-loja/pagamento/cartao/{pl}', 'PgCheckTransPrincipalController@pagamentoPlano');
$router->get('/crie-sua-loja/pagamento/boleto/checkout/{pl}', 'BoletoController@checkout');
$router->get('/crie-sua-loja/pagamento/obrigado/{id}', 'BoletoController@obrigado');
$router->get('/retornar-info', 'BoletoController@retornaInfo');
$router->post('/crie-sua-loja/escolha-pagamento', 'OpcaoPgmController@escolhaPagamento');
$router->get('/crie-sua-loja/obrigado', 'CadastroController@inserirCadastroFree');
$router->post('/checkout', 'PgCheckTransPrincipalController@checkout');
$router->post('/cartao/notification', 'PgCheckTransPrincipalController@notification');
$router->post('/boleto/notification', 'BoletoController@notification');

$router->post('/consulta-cep', 'CadastroController@consultarCep');

$router->get('/admin-bwcommerce', 'LoginController@admin');

$router->get('/login', 'LoginController@index');
$router->post('/login/validar/user', 'LoginController@validarUser');
$router->post('/login/validar/admin', 'LoginController@validarAdmin');
$router->get('/sair', 'LoginController@sair');
$router->get('/sair/admin', 'LoginController@sairAdmin');


$router->get('/info-cadastro', 'InfoCadastroController@index');

$router->get('/painel/admin', 'PainelController@index');
$router->get('/painel/alterar-dados-pessoais', 'PainelController@alterarDadosPessoaisView');
$router->post('/painel/alterar-dados-pessoais/update', 'PainelController@alterarDadosPessoais');
$router->get('/painel/novo-plano', 'PainelController@novoPlano');



