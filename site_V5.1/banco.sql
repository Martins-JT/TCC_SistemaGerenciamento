CREATE DATABASE IF NOT EXISTS sistema_gerenciamento_db;

USE sistema_gerenciamento_db;

CREATE TABLE IF NOT EXISTS CONTRATOS
(ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
FORNECEDOR_ID TINYINT NOT NULL,
PRODUTO_ID INT NOT NULL,
ID_OFERTA INT NOT NULL,
DATA_CRIACAO DATE NOT NULL,
VALIDADE DATE NOT NULL,
valor_final decimal(8,2) NOT NULL);

CREATE TABLE IF NOT EXISTS FORNECEDORES
(ID TINYINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
EMAIL VARCHAR(100) NOT NULL UNIQUE,
SENHA VARCHAR(256) NOT NULL,
NOME_EMPRESA VARCHAR(50) NOT NULL,
CNPJ CHAR(18) NOT NULL,
INTERESSES VARCHAR(255),
TELEFONE CHAR(10),
RUA VARCHAR(50) NOT NULL,
NUMERO TINYINT,
CIDADE VARCHAR(50) NOT NULL,
ESTADO CHAR(2) NOT NULL,
CEP CHAR(9),
foto varchar(100) not null,
permissoes ENUM('usuario', 'admin') not null);

 /* TABELA DO ALEXANDRE
 
 CREATE TABLE IF NOT EXISTS PRODUTOS
(ID TINYINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
CATEGORIA_ID INT NOT NULL,
UNIDADE CHAR(10) NOT NULL); #UNIDADE DE MEDIDA DO PRODUTO () */

CREATE TABLE IF NOT EXISTS produtos
(
id_produto TINYINT auto_increment PRIMARY KEY not null,
id_fornecedor int not null,
produto VARCHAR(50) not null,
caracteristica VARCHAR(50) not null,
peso_unidade VARCHAR(50) not null,
estoque VARCHAR(50) not null,
descricao VARCHAR(50) not null,
categoria VARCHAR(50) not null,
valor decimal(8,2) not null,
status bool not null
);
CREATE TABLE IF NOT EXISTS ofertas
(
id_oferta TINYINT auto_increment PRIMARY KEY,
id_fornecedor int NOT NULL,
id_produto int not null,
data_inicio DATETIME NOT NULL,
dias INT NOT NULL,
status bool not null

/* FOREIGN KEY (id_fornecedor) REFERENCES fornecedores(id) */
);

/* TABELA DO ALEXANDRE
CREATE TABLE IF NOT EXISTS REQUISICOES
(ID TINYINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
PRODUTO_ID INT NOT NULL,
QUANTIDADE FLOAT(5,2) NOT NULL,
UNIDADE CHAR(10) NOT NULL); */


CREATE TABLE IF NOT EXISTS CATEGORIAS
(ID TINYINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
NOME VARCHAR(50) NOT NULL);

update fornecedores set permissoes = 'admin' where id = 2;
update fornecedores set foto = "img/jogo1.png" where id = '4';
#CREATE TABLE IF NOT EXISTS INTERESSE_FORNECEDORES
#(ID TINYINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
#ID_CATEGORIA TINYINT NOT NULL,
#ID_CLIENTE TINYINT NOT NULL);
INSERT INTO produtos (id_fornecedor, produto, caracteristica, peso_unidade, estoque, descricao, categoria, valor, status)
VALUES
(1, 'Cimento Portland', 'Secagem Rápida', '20kg', '200 sacos', 'Cimento de alta resistência', 'Material de Construção', 450.0, 1);


