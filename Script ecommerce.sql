/*
* Script para criação do banco de dados do ecommerce
*/

drop database ecommerce;

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
    cpf int not null,
    email varchar(100) not null,
    rua varchar(100) not null,
    bairro varchar(100) not null,
    numero int not null,
    cep int not null,
    
    primary key(usuario_id),
    foreign key (estado_id) references estado(estado_id)
)default charset utf8;

create table ecommerce_usu(
	ecommerce_id int not null auto_increment,
    usuario_id int not null,
    sub_dominio varchar(50) not null,
    nome_fantasia varchar(50) not null,
    cnpj int,
    
    primary key(ecommerce_id),
    foreign key(usuario_id) references usuario(usuario_id)
)default charset utf8;

create table usuario_ecommerce(
	ue_id int not null auto_increment,
    nome_usu_ue varchar(100) not null,
    cpf_ue int not null,
    endereco_ue varchar(100),
    
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
    sub_cat int,
    nome_cat varchar(50) not null,
    
    primary key(categoria_id)
)default charset utf8;

create table marca(
	marca_id int not null auto_increment,
    nome_mar varchar(50) not null,
    
    primary key(marca_id)
)default charset utf8;

create table produto(
	produto_id int not null auto_increment,
    categoria_id int not null,
    marca_id int not null,
    ecommerce_id int not null,
    nome_pro varchar(50) not null,
    descricao varchar(100),
    estoque int not null,
    preco int not null,
    preco_antigo int not null default 0,
    media_avaliacao int,
    promocao tinyint default 0,
    novo_produto tinyint default 0,
    opcoes varchar(100),
    
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
    valor_cupom int not null,
    
    primary key(cupom_id)
)default charset utf8;

create table compra(
	compra_id int not null auto_increment,
    usuario_id int not null,
    cupom_id int not null,
    ecommerce_id int not null,
    total_compra int not null,
    tipo_pagamento int not null,
    status_pagamanto int not null,
    
    primary key(compra_id),
	foreign key(usuario_id) references usuario_ecommerce(ue_id),
	foreign key(cupom_id) references cupom(cupom_id),
    foreign key(ecommerce_id) references ecommerce_usu(ecommerce_id)
)default charset utf8;

create table transacao_compra(
	tc_id int not null auto_increment,
    compra_id int not null,
    valor_pago int not null,
    cod_transacao varchar(100),
    
    primary key(tc_id),
    foreign key (compra_id) references compra(compra_id)
)default charset utf8;

create table compra_prod(
	cp_id int not null auto_increment,
    produto_id int not null,
    compra_id int not null,
    
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
