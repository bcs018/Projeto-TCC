/*
* Script para criação do banco de dados do ecommerce
*/

/* Seta o idioma como portugues - Brasil */
set @@lc_time_names = 'pt_BR';
set GLOBAL lc_time_names = 'pt_BR';

drop database if exists ecommerce;

/* Executar separadamente primeiro */
create database if not exists ecommerce
default character set utf8
default collate utf8_general_ci;

/* Executar separadamente segundo */
use ecommerce;

/* Executar o restante selecionado tudo */

create table estado(
	estado_id int not null auto_increment,
    nome_estado varchar(2) not null,
    
    primary key(estado_id)
)default charset utf8;

insert into estado (nome_estado)
values('AC'),('AL'),('AP'),('AM'),('BA'),('CE'),('ES'),('GO'),('MA'),('MT'),('MS'),('MG'),('PA'),('PB'),('PR'),('PE'),('PI'),('RJ'),('RN'),('RS'),('RO'),('RR'),('SC'),('SP'),('SE'),('TO'),('DF');

create table usuario(
	usuario_id int not null auto_increment,
    estado_id int not null,
    nome varchar(100) not null,
    sobrenome varchar(100) not null,
    celular varchar(30) not null,
    dt_nascimento varchar(11) not null,
    cpf varchar(11) not null,
    email varchar(100) not null,
    rua varchar(100) not null,
    bairro varchar(100) not null,
    numero int not null,
    cep int not null,
    cidade varchar(100) not null,
    complemento varchar(100),
    ativo int not null default 0,
    senha varchar(32) not null,
    tp_usuario tinyint(1) default 1, /* 1 = DONO DO ECOMMERCE, 2 = USUARIOS CRIADOS APÓS A CRAÇÃO DO ECOMMERCE */
    login varchar(20) not null unique,
    
    primary key(usuario_id),
    foreign key (estado_id) references estado(estado_id)
)default charset utf8;

create table plano(
    plano_id int not null auto_increment,
    nome_plano varchar(50),
    descricao_plano varchar(100),
    preco decimal(10,2),

    primary key(plano_id)
)default charset utf8;

insert into plano (nome_plano, descricao_plano, preco)
values ('Free', '5 produtos;Relatórios somente do mês;Suporte;Acesso a um template padrão', 0),
	   ('Pro', '15 produtos;Relatórios até 6 meses atrás;Suporte;Acesso a todos templates', 60),
       ('Super Pro', 'Produtos ilimitados;Relatórios desde o dia da criação da loja;Suporte;Acesso a todos templates', 100);

create table ecommerce_usu(
	ecommerce_id int not null auto_increment,
    /*usuario_id int not null,*/
    plano_id int,
    sub_dominio varchar(50) not null unique,
    nome_fantasia varchar(50) not null,
    cnpj int,
    layout varchar(50) not null,
    logotipo varchar(50) not null default 0,
    ico varchar(50) not null default 0,
    cor varchar (50) default '#adadad',
    cor_rodape varchar (50) default '#adadad',
    cor_letra_rodape varchar(50) default '#262626',
    tp_recebimento varchar(50) default '0' not null,
    data_cad date not null,
    -- ps_token varchar(200) default 0 not null, 
    -- ps_email varchar(100) default 0 not null, 
    -- mp_public_key varchar(300) default 0 not null,
    -- mp_access_token varchar(300) default 0 not null,
    chave_pix varchar(100) default '0',
    facebook varchar(100) default '0',
    instagram varchar(100) default '0',
    linkedin varchar(100) default '0',

    primary key(ecommerce_id),
    /*foreign key(usuario_id) references usuario(usuario_id),*/
    foreign key(plano_id) references plano(plano_id)
)default charset utf8;

/* Tabela que faz ligação de usuario com ecommerce_usu */
create table ecom_usua(
    ecus_id int not null auto_increment,
    usuario_id int not null,
    ecommerce_id int not null,

    primary key(ecus_id),
    foreign key(usuario_id) references usuario(usuario_id),
    foreign key(ecommerce_id) references ecommerce_usu(ecommerce_id)
)default charset utf8;

create table notificacao(
	notificacao_id int not null auto_increment,
    ecommerce_id int not null,
    texto varchar(100) not null,
    link varchar(100) default '',
    lido enum('1','0'),
    usu_ecommerce int default 0,
    
    primary key (notificacao_id),
    foreign key (ecommerce_id) references ecommerce_usu(ecommerce_id)
)default charset utf8;

create table layout_imagem(
    li_id int not null auto_increment,
    ecommerce_usu_id int not null,
    url varchar(150) not null,
    local_imagem varchar(50) not null,

    primary key(li_id),
    foreign key(ecommerce_usu_id) references ecommerce_usu(ecommerce_id)
)default charset utf8;

create table usuario_ecommerce(
	ue_id int not null auto_increment,
    nome_usu_ue varchar(100) not null,
    sobrenome varchar(100) not null,
    cpf_ue varchar(11) not null,
    email_ue varchar(100) not null,
    celular_ue varchar(30) not null,
    login_ue varchar(50) not null,
    senha_ue varchar(32) not null,
    data_cad date not null,
    
    primary key(ue_id)
)default charset utf8;

create table eco_usu(
	eu_id int not null auto_increment,
    ecommerce_id int not null,
    usuario_id int not null,
    
    primary key(eu_id),
    foreign key(ecommerce_id) references ecommerce_usu(ecommerce_id),
    foreign key(usuario_id) references usuario_ecommerce(ue_id)
)default charset utf8;

create table categoria(
	categoria_id int not null auto_increment,
    ecommerce_id int not null,
    sub_cat int,
    nome_cat varchar(50) not null,
    ativo enum('1','0') default '1',
    
    primary key(categoria_id),
    foreign key(ecommerce_id) references ecommerce_usu(ecommerce_id)
)default charset utf8;

create table marca(
	marca_id int not null auto_increment,
    ecommerce_id int not null,
    nome_mar varchar(50) not null,
    marca_img varchar (50) default 0,
    ativo enum('1','0') default '1',
    
    primary key(marca_id),
    foreign key(ecommerce_id) references ecommerce_usu(ecommerce_id)

)default charset utf8;

create table produto(
	produto_id int not null auto_increment,
    categoria_id int not null,
    marca_id int not null,
    ecommerce_id int not null,
    nome_pro varchar(50) not null,
    descricao LONGTEXT,
    estoque int not null,
    preco decimal(10,2) not null,
    preco_antigo decimal(10,2) not null default 0,
    media_avaliacao int,
    promocao tinyint default 0,
    novo_produto tinyint default 0,
    ativo enum('1','0') default '1' not null,
    opcoes varchar(100),
    banner_img varchar(50) default 0,
    peso decimal(10,2) not null,
    altura decimal(10,2) not null,
    largura decimal(10,2) not null,
    comprimento decimal(10,2) not null,
    diametro decimal(10,2) not null,
    
    primary key(produto_id),
    foreign key(categoria_id) references categoria(categoria_id),
	foreign key(marca_id) references marca(marca_id),
    foreign key(ecommerce_id) references ecommerce_usu(ecommerce_id)
)default charset utf8;

create table produto_imagem(
	pi_id int not null auto_increment,
    produto_id int not null,
    url varchar(100) not null,
    
    primary key(pi_id),
    foreign key(produto_id) references produto(produto_id)
)default charset utf8;

create table voto(
	voto_id int not null auto_increment,
    produto_id int not null,
    usuario_id int not null,
    data_votacao datetime not null,
    ponto int not null,
    comentario text,
    
    primary key(voto_id),
    foreign key(produto_id) references produto(produto_id),
    foreign key(usuario_id) references usuario_ecommerce(ue_id)
)default charset utf8;

create table cupom(
	cupom_id int not null auto_increment,
    nome_cupom varchar(10) not null,
    tipo_cupom int not null,
    valor_cupom decimal(10,2) not null,
    
    primary key(cupom_id)
)default charset utf8;

INSERT INTO cupom (nome_cupom, tipo_cupom, valor_cupom)
VALUES('Sem Cupom', 0, 0);

create table assinatura(
	assinatura_id int not null auto_increment,
    usuario_id int not null,
    cupom_id int,
    valor_total decimal(10,2),
    tipo_pagamento varchar(100),
    status_pagamento varchar(50),
    cod_transacao varchar(100),
    /*link_bol varchar(200),*/
    data_transacao date not null,
    hora_transacao time not null,
    data_pagamento date,
    hora_pagamento time,
    
    primary key(assinatura_id),
    foreign key(usuario_id) references usuario(usuario_id),
    foreign key(cupom_id) references cupom(cupom_id)
)default charset utf8;

create table boleto(
	id int not null auto_increment,
    assinatura_id int,
    link_boleto varchar(200),
	
    primary key(id),
    foreign key(assinatura_id) references assinatura(assinatura_id)
)default charset utf8;

create table compra(
	compra_id int not null auto_increment,
    usuario_id int not null,
    cupom_id int not null,
    ecommerce_id int not null,
    total_compra decimal(10,2) not null,
    subtotal_compra decimal(10,2) not null,
    frete decimal(10,2) not null,
    tipo_pagamento varchar(50) not null,
    data_compra date not null,
    hora_compra time not null,
    enviado enum('0','1') not null default '0',
    status_pagamento varchar(100) default 0 not null,
    cep_entrega varchar(100) not null,
    rua_entrega varchar(100) not null,
    bairro_entrega varchar(100) not null,
    numero_entrega varchar(100) not null,
    estado_entrega varchar(100) not null,
    cidade_entrega varchar(100) not null,
    complemento_entrega varchar(100) not null,
    recebido tinyint default 0,
    data_recebimento date not null,
    transferido tinyint default 0,
    cod_rastreio varchar(100) default '0',

    primary key(compra_id),
	foreign key(usuario_id) references usuario_ecommerce(ue_id),
	foreign key(cupom_id) references cupom(cupom_id),
    foreign key(ecommerce_id) references ecommerce_usu(ecommerce_id)
)default charset utf8;

create table transacao_compra(
	tc_id int not null auto_increment,
    compra_id int not null,
    valor_pago decimal(10,2) not null,
    cod_transacao varchar(100),
    parcela varchar(100) not null,
    link_bol varchar(300) default 0 not null,
    
    primary key(tc_id),
    foreign key (compra_id) references compra(compra_id)
)default charset utf8;

create table compra_prod(
	cp_id int not null auto_increment,
    produto_id int not null,
    compra_id int not null,
    quantidade int not null,
    
    primary key(cp_id),
    foreign key (compra_id) references compra(compra_id),
    foreign key (produto_id) references produto(produto_id)
)default charset utf8;

create table opcao(
	opcao_id int not null auto_increment,
    nome_opcao varchar(50) not null,
    
    primary key(opcao_id)
)default charset utf8;

create table produto_opcao(
	po_id int not null auto_increment,
    produto_id int not null,
    opcao_id int not null,
    
    primary key(po_id),
    foreign key (opcao_id) references opcao(opcao_id),
    foreign key (produto_id) references produto(produto_id)
)default charset utf8;

create table usuario_admin(
	usuarioadm_id int not null auto_increment,
    nome_user varchar(100) not null,
    login varchar(50) not null,
    senha varchar(32) not null,
    url_foto varchar(200),
    
    primary key(usuarioadm_id)
)default charset utf8;

create table notificacao_admin(
	notificacao_id int not null auto_increment,
    ecommerce_id int not null,
    texto varchar(100) not null,
    link varchar(100) default '',
    lido enum('1','0'),
    sub_dominio varchar(100),
    
    primary key (notificacao_id)
)default charset utf8;

insert into usuario_admin (nome_user, login, senha) 
values ('admin', 'admin', md5('admin@potlid123'));