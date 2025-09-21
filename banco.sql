CREATE DATABASE IF NOT EXISTS sistema_gerenciamento_db;

USE sistema_gerenciamento_db;

CREATE TABLE IF NOT EXISTS CONTRATOS
(ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
FORNECEDOR_ID TINYINT NOT NULL,
PRODUTO_ID INT NOT NULL,
ID_OFERTA INT NOT NULL,
DATA_CRIACAO DATE NOT NULL,
VALIDADE DATE NOT NULL,
valor_oferta decimal(10,2) not null,
valor_final decimal(10,2) NOT NULL);

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
peso_unidade decimal(10,2) not null,
estoque VARCHAR(50) not null,
descricao VARCHAR(100) not null,
categoria VARCHAR(50) not null,
valor decimal(8,2) not null,
marca varchar(50) not null,
unidade_medida varchar(50) not null,
estado_produto bool not null,
exibir_vitrine bool not null
);


CREATE TABLE IF NOT EXISTS ofertas
(
id_oferta int auto_increment PRIMARY KEY,
id_fornecedor int NOT NULL,
id_produto int not null,
data_inicio DATETIME NOT NULL,
dias INT NOT NULL,
status bool not null,
exibir_vitrine bool not null,
carrinho bool not null,
identificador bool not null /* CASO FOR 0 É USUÁRIO E SE FOR 1 É ADMIN*/

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
INSERT INTO produtos 
(id_fornecedor, produto, caracteristica, peso_unidade, estoque, descricao, categoria, valor, marca, unidade_medida, status) 
VALUES 
(1, 'Cimento', 'Portland', 50.00, '100 sacos', 'Cimento de alta resistência para construção civil', 'Cimentos', 30.50, 'Votorantim', 'kg', TRUE),
(1, 'Areia', 'Fina', 1000.00, '500 metros cúbicos', 'Areia fina para construção e alvenaria', 'Areias', 120.00, 'Votorantim', 'm3', TRUE),
(1, 'Tijolo', 'Maciço', 2.50, '2000 unidades', 'Tijolo de barro maciço para construção de paredes', 'Materiais para Alvenaria', 1.80, 'Cerâmica São João', 'unidade', TRUE),
(1, 'Cal', 'Hidratada', 25.00, '300 sacos', 'Cal hidratada usada em acabamentos de obra', 'Cal e Gesso', 12.30, 'Limeira', 'kg', TRUE),
(1, 'Ferro', '5/16', 6.00, '500 barras', 'Ferro para construção de armaduras e estruturas metálicas', 'Ferros e Aços', 9.50, 'Gerdau', 'barra', TRUE),
(1, 'Tinta', 'Acrílica', 18.00, '150 latas', 'Tinta acrílica para pintura interna e externa', 'Tintas', 85.75, 'Suvinil', 'litro', TRUE),
(1, 'Pedra', 'Brita 1', 1000.00, '100 metros cúbicos', 'Pedra brita para fundações e asfaltamento', 'Pedras e Britas', 130.00, 'Pedras & Cia', 'm3', TRUE),
(1, 'Madeira', 'Pinus', 12.00, '50 tábuas', 'Madeira de pinus para construção de telhados', 'Madeiras', 40.00, 'Sólida Madeiras', 'unidade', TRUE),
(1, 'Cimento', 'CP II', 40.00, '250 sacos', 'Cimento CP II para uso geral em construções', 'Cimentos', 28.40, 'Cimento Cauê', 'kg', TRUE),
(1, 'Argamassa', 'Colante', 20.00, '200 sacos', 'Argamassa colante para assentamento de cerâmicas e pisos', 'Argamassas', 18.20, 'Quartzolit', 'kg', TRUE);


/* 
CRIAR CAMPO PARA MARCA,
UNIDADE_MEDIDA,

*/