<?php
use core\Router;
use src\controllers\CadastroController;

$router = new Router(); 

/************************  ROTAS ECOMMERCE ************************/

$router->get('/', 'HomeController@index');

// -- Painel Usuario Empreendedor
$router->get('/admin', 'LoginController@login');
$router->post('/admin/logar', 'LoginController@loginAction');
$router->get('/admin/painel', 'AdminController@painel');
$router->get('/admin/sair', 'LoginController@sair');
$router->get('/admin/painel/alterar-dados-pessoais', 'AdminController@ediDadosPessoais');
$router->post('/admin/painel/alterar-dados-pessoais/action', 'AdminController@ediDadosPessoaisAction');
$router->post('/consulta-cep', 'AdminController@consultarCep');
$router->get('/admin/painel/add-novo-usuario', 'AdminController@addNovoUsu');
$router->post('/admin/painel/add-usuario/action', 'AdminController@addNovoUsuAction');
$router->get('/admin/painel/layout', 'AdminController@layout');
$router->get('/admin/painel/layout/2', 'AdminController@layout_dois');
$router->post('/admin/painel/edi-layout', 'AdminController@ediLayoutAction');
$router->get('/admin/painel/cadastrar-dados-recebimento', 'AdminController@cadDadosRecebimento');
$router->post('/admin/painel/cadastrar-dados-recebimento/action', 'AdminController@cadDadosRecebimentoAction');
$router->get('/admin/painel/relatorio', 'AdminController@relVendas');
$router->post('/admin/painel/relatorio-intervalo', 'AdminController@relVendasAction');
$router->get('/admin/painel/relatorio-intervalo', 'AdminController@relVendasAction');
$router->get('/admin/painel/vendas-pendentes', 'VendaController@vendasPendendes');
$router->get('/admin/painel/venda/{id}', 'VendaController@vendaPendente');
$router->get('/admin/painel/questionario', 'AdminController@questionario');
$router->post('/admin/painel/marcar-enviado', 'VendaController@marcarEnviado');
$router->post('/admin/painel/marcar-nao-enviado', 'VendaController@marcarNEnviado');
$router->post('/admin/painel/ler-notificacao', 'NotificacaoController@lerNotificacao');
$router->post('/admin/painel/ler-todas-notificacao', 'NotificacaoController@lerTdNotificacao');
$router->post('/admin/painel/ler-todas-notificacao-cli', 'NotificacaoController@lerTdNotificacaoCli');
$router->get('/admin/painel/entenda-o-valor-a-receber', 'VendaController@juros');

// Painel Usuario Cliente
$router->get('/login', 'LoginController@loginC');
$router->get('/login/{control}', 'LoginController@loginC');
$router->post('/cliente/logar', 'LoginController@loginCAction');
$router->get('/cliente/painel', 'AdminCController@painel');
$router->get('/cliente/painel/alterar-dados-pessoais', 'AdminCController@ediDadosPessoais');
$router->post('/cliente/painel/alterar-dados-pessoais/action', 'AdminCController@ediDadosPessoaisAction');
$router->get('/cliente/sair/c', 'LoginController@sairC');
$router->get('/cliente/painel/contato', 'AdminCController@contato');
$router->get('/cliente/painel/meus-pedidos', 'AdminCController@pedidos');
$router->get('/cliente/painel/meus-pedidos/{id}', 'AdminCController@pedido');
$router->post('/cliente/painel/marcar-recebido', 'AdminCController@marcarRecebido');
$router->get('/cliente/painel/questionario', 'AdminCController@questionario');

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
$router->get('/produtos', 'HomeController@produtos');
$router->get('/produtos/categoria/{id}', 'HomeController@produtosCategoria');

// -- Pesquisa de produtos
$router->post('/pesquisa-produtos', 'PesquisaController@pesquisa');

// -- Carrinho
$router->post('/add-carrinho', 'CarrinhoController@addCarrinho');
$router->post('/calcular-subtotal', 'CarrinhoController@calTotalProduto');
$router->post('/calcular-preco', 'CarrinhoController@calPrecoProduto');
$router->get('/carrinho', 'CarrinhoController@index');
$router->get('/deletar/item/carrinho/{id}', 'CarrinhoController@delItem');
$router->post('/calcula-frete', 'CarrinhoController@calcFrete');
$router->post('/deleta-sessao-frete', 'CarrinhoController@delSessaoFrete');
$router->post('/verifica-log-usuario', 'CarrinhoController@verUsuarioLogado');

// -- Pagamento
$router->get('/cria-cliente', 'PagamentoController@criaCliente');

$router->post('/sel-pagamento', 'PagamentoController@index');
$router->get('/pagamento', 'PagamentoController@index');
$router->post('/pagamento/action/{flag}', 'PagamentoController@atuDadosEntregaAction');
$router->get('/pagamento/2', 'PagamentoController@pagamentoSecond');
$router->get('/gerar-boleto/2', 'PagamentoController@gerarBoletoSecond');
$router->get('/gerar-boleto', 'PagamentoController@gerarBoleto');
$router->post('/checkout', 'PgCheckTransPrincipalController@checkout');
$router->post('/checkoutBol', 'PgCheckTransPrincipalController@checkoutBol');
$router->post('/checkout_mp', 'MpCheckTransPrincipalController@checkout');
$router->post('/checkout_mpBol', 'MpCheckTransPrincipalController@checkout_mpBol');
$router->post('/checkout_gere', 'GereCheckTransPrincipalController@checkout_gere');
$router->post('/checkout_gere_bol', 'GereCheckTransPrincipalController@checkoutbol_gere');
$router->get('/pagamento/concluido/{id}', 'PagamentoController@fimPagamento');
$router->get('/notification/cliente', 'PgCheckTransPrincipalController@notification');

// -- Cadastro de clientes do ecommerce
$router->get('/cadastrar', 'CadastroController@index');
$router->post('/cadastrar-usuario', 'CadastroController@cadUsuarioAction');


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

