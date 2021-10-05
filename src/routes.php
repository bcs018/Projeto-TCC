<?php
use core\Router;
use src\controllers\CadastroController;

$router = new Router(); 

/************************  ROTAS SITE PRINCIPAL ************************/

$router->get('/', 'HomeController@index');

$router->get('/crie-sua-loja', 'CadastroController@index');
$router->post('/crie-sua-loja/inserir', 'CadastroController@inserir');
$router->post('/crie-sua-loja/verifica-cpf', 'CadastroController@verifica_cpf_cadastrado');
$router->post('/crie-sua-loja/consulta-sub', 'CadastroController@consultaSubDominio');
$router->post('/crie-sua-loja/consulta-login', 'CadastroController@consultaLogin');
$router->get('/crie-sua-loja/pagamento', 'CadastroController@pagamento');
$router->get('/crie-sua-loja/pagamento/cartao/{pl}', 'PgCheckTransPrincipalController@pagamentoPlano');
$router->get('/crie-sua-loja/pagamento/boleto/checkout/{pl}', 'BoletoController@checkout');
$router->get('/crie-sua-loja/obrigado/{id}', 'BoletoController@obrigado');
$router->get('/retornar-info', 'BoletoController@retornaInfo');
$router->post('/crie-sua-loja/escolha-pagamento', 'OpcaoPgmController@escolhaPagamento');
$router->get('/crie-sua-loja/obrigado', 'CadastroController@inserirCadastroFree');
$router->post('/checkout', 'PgCheckTransPrincipalController@checkout');
$router->post('/cartao/notification', 'PgCheckTransPrincipalController@notification');
$router->get('/boleto/notification', 'BoletoController@notification');

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
$router->get('/painel/clientes', 'PainelController@clientes');
$router->get('/ativar/cliente/{id}', 'PainelController@ativarUsu');
$router->get('/inativar/cliente/{id}', 'PainelController@inativarUsu');
$router->get('/painel/relatorio', 'PainelController@relVendas');
$router->post('/painel/relatorio', 'PainelController@relVendas');
//$router->get('/painel/relatorio-intervalo', 'PainelController@relVendasAction');

$router->post('/painel/ler-notificacao', 'NotificacaoController@lerNotificacao');
$router->post('/painel/ler-todas-notificacao', 'NotificacaoController@lerTdNotificacao');

$router->get('/sub', 'HomeController@create_subdomain');


//$router->post('/notification/cliente', 'PgCheckTransPrincipalController@notification');
