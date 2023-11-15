-- SQL Manager for PostgreSQL 6.4.2.56477
-- ---------------------------------------
-- Host      : 192.168.60.206:5433
-- Database  : app
-- Version   : PostgreSQL 13.10, compiled by Visual C++ build 1914, 64-bit



CREATE SCHEMA app AUTHORIZATION postgres;
SET check_function_bodies = false;
--
-- Structure for table tb_cliente (OID = 16549) :
--
SET search_path = app, pg_catalog;
CREATE TABLE app.tb_cliente (
    cd_cliente integer NOT NULL,
    nm_cliente varchar(100) NOT NULL,
    nr_loja integer NOT NULL
)
WITH (oids = false);
--
-- Structure for table tb_conexao (OID = 16552) :
--
CREATE TABLE app.tb_conexao (
    cd_conexao integer NOT NULL,
    id_conexao varchar(150) NOT NULL,
    cd_cliente integer NOT NULL,
    nm_terminal varchar(50) NOT NULL,
    nm_programa varchar(50) NOT NULL,
    nm_usuario varchar(150),
    senha varchar(150),
    obs varchar(300),
    nr_caixa integer
)
WITH (oids = false);
--
-- Structure for table tb_login (OID = 16558) :
--
CREATE TABLE app.tb_login (
    cd_login integer NOT NULL,
    nm_usuario varchar(20) NOT NULL,
    senha varchar(30) NOT NULL
)
WITH (oids = false);
--
-- Structure for table tb_ramal (OID = 16561) :
--
CREATE TABLE app.tb_ramal (
    cd_ramal integer NOT NULL,
    nm_funcionario varchar NOT NULL,
    nr_ramal integer,
    nr_telefone varchar NOT NULL,
    nr_ip varchar,
    nm_usuario varchar,
    senha varchar,
    obs varchar
)
WITH (oids = false);
ALTER TABLE  app.tb_ramal ALTER COLUMN cd_ramal SET STATISTICS 0;
ALTER TABLE  app.tb_ramal ALTER COLUMN nm_funcionario SET STATISTICS 0;
ALTER TABLE  app.tb_ramal ALTER COLUMN nr_ramal SET STATISTICS 0;
ALTER TABLE  app.tb_ramal ALTER COLUMN nr_telefone SET STATISTICS 0;
--
-- Structure for table tb_agendamento (OID = 16619) :
--
CREATE TABLE app.tb_agendamento (
    cd_agenda integer NOT NULL,
    cd_cliente integer,
    cd_funcionario integer,
    obs varchar,
    dt_inicio date,
    dt_fim date,
    cor varchar,
    status varchar(20) NOT NULL
)
WITH (oids = false);
ALTER TABLE  app.tb_agendamento ALTER COLUMN cd_agenda SET STATISTICS 0;
--
-- Structure for table tb_usuario (OID = 16637) :
--
CREATE TABLE app.tb_usuario (
    cd_usuario integer NOT NULL,
    cd_cliente integer NOT NULL,
    nm_usuario varchar NOT NULL,
    senha varchar NOT NULL,
    nm_sistema varchar NOT NULL,
    nm_terminal varchar NOT NULL,
    obs varchar
)
WITH (oids = false);
--
-- Data for table app.tb_login (OID = 16558) (LIMIT 0,1)
--
INSERT INTO app.tb_login (cd_login, nm_usuario, senha)  
VALUES (1, 'DIOGO', '154326');

--
-- Data for table app.tb_ramal (OID = 16561) (LIMIT 0,21)
--
INSERT INTO app.tb_ramal (cd_ramal, nm_funcionario, nr_ramal, nr_telefone, nr_ip, nm_usuario, senha, obs)  
VALUES (1, 'BERNARDINHO', 205, '(48)99931-3717', NULL, NULL, NULL, NULL);

INSERT INTO app.tb_ramal (cd_ramal, nm_funcionario, nr_ramal, nr_telefone, nr_ip, nm_usuario, senha, obs)  
VALUES (4, 'GUINTHER', 202, '(48)99200-0653', NULL, NULL, NULL, NULL);

INSERT INTO app.tb_ramal (cd_ramal, nm_funcionario, nr_ramal, nr_telefone, nr_ip, nm_usuario, senha, obs)  
VALUES (5, 'GUSTAVO', 215, '(48)99835-4993', NULL, NULL, NULL, NULL);

INSERT INTO app.tb_ramal (cd_ramal, nm_funcionario, nr_ramal, nr_telefone, nr_ip, nm_usuario, senha, obs)  
VALUES (6, 'HALLAN', 211, '(48)98425-7749', NULL, NULL, NULL, NULL);

INSERT INTO app.tb_ramal (cd_ramal, nm_funcionario, nr_ramal, nr_telefone, nr_ip, nm_usuario, senha, obs)  
VALUES (7, 'ISAQUE', 217, '(48)99128-9162', NULL, NULL, NULL, NULL);

INSERT INTO app.tb_ramal (cd_ramal, nm_funcionario, nr_ramal, nr_telefone, nr_ip, nm_usuario, senha, obs)  
VALUES (8, 'JANETE', 200, '(48)99917-4630', NULL, NULL, NULL, NULL);

INSERT INTO app.tb_ramal (cd_ramal, nm_funcionario, nr_ramal, nr_telefone, nr_ip, nm_usuario, senha, obs)  
VALUES (9, 'JOSUÉ', 222, '(48)99964-8268', NULL, NULL, NULL, NULL);

INSERT INTO app.tb_ramal (cd_ramal, nm_funcionario, nr_ramal, nr_telefone, nr_ip, nm_usuario, senha, obs)  
VALUES (10, 'JUNIOR', 216, '(48)98827-1828', NULL, NULL, NULL, NULL);

INSERT INTO app.tb_ramal (cd_ramal, nm_funcionario, nr_ramal, nr_telefone, nr_ip, nm_usuario, senha, obs)  
VALUES (12, 'LUIS', 212, '(48)98841-7522', NULL, NULL, NULL, NULL);

INSERT INTO app.tb_ramal (cd_ramal, nm_funcionario, nr_ramal, nr_telefone, nr_ip, nm_usuario, senha, obs)  
VALUES (15, 'MIEHE', 209, '(48)99943-3560', NULL, NULL, NULL, NULL);

INSERT INTO app.tb_ramal (cd_ramal, nm_funcionario, nr_ramal, nr_telefone, nr_ip, nm_usuario, senha, obs)  
VALUES (17, 'RAFAEL W', 208, '(48)99927-8925', NULL, NULL, NULL, NULL);

INSERT INTO app.tb_ramal (cd_ramal, nm_funcionario, nr_ramal, nr_telefone, nr_ip, nm_usuario, senha, obs)  
VALUES (18, 'TIAGO', 204, '(48)99940-0689', NULL, NULL, NULL, NULL);

INSERT INTO app.tb_ramal (cd_ramal, nm_funcionario, nr_ramal, nr_telefone, nr_ip, nm_usuario, senha, obs)  
VALUES (11, 'LEDIO', 222, '(48)99974-4678', NULL, NULL, NULL, NULL);

INSERT INTO app.tb_ramal (cd_ramal, nm_funcionario, nr_ramal, nr_telefone, nr_ip, nm_usuario, senha, obs)  
VALUES (16, 'OLIVEIRA', 212, '(48)99924-9557', NULL, NULL, NULL, NULL);

INSERT INTO app.tb_ramal (cd_ramal, nm_funcionario, nr_ramal, nr_telefone, nr_ip, nm_usuario, senha, obs)  
VALUES (14, 'MATHEUS', 220, '(48)99146-4585', NULL, NULL, NULL, NULL);

INSERT INTO app.tb_ramal (cd_ramal, nm_funcionario, nr_ramal, nr_telefone, nr_ip, nm_usuario, senha, obs)  
VALUES (22, 'MATHEUS M', 207, '(48)98850-2653', NULL, NULL, NULL, NULL);

INSERT INTO app.tb_ramal (cd_ramal, nm_funcionario, nr_ramal, nr_telefone, nr_ip, nm_usuario, senha, obs)  
VALUES (23, 'BERNARDO', 218, '(48)99978-6037', '', '', '', '');

INSERT INTO app.tb_ramal (cd_ramal, nm_funcionario, nr_ramal, nr_telefone, nr_ip, nm_usuario, senha, obs)  
VALUES (3, 'DIOGO', 203, '(48)99654-5657', '192.168.60.206', 'DIOGO', '123456', 'MUITO BOM ESSE CARA');

INSERT INTO app.tb_ramal (cd_ramal, nm_funcionario, nr_ramal, nr_telefone, nr_ip, nm_usuario, senha, obs)  
VALUES (19, 'FRANCISCO', NULL, '(48)99946-5876', '', '', '', '');

INSERT INTO app.tb_ramal (cd_ramal, nm_funcionario, nr_ramal, nr_telefone, nr_ip, nm_usuario, senha, obs)  
VALUES (20, 'IVAN', NULL, '(47)98870-2888', '', '', '', '');

INSERT INTO app.tb_ramal (cd_ramal, nm_funcionario, nr_ramal, nr_telefone, nr_ip, nm_usuario, senha, obs)  
VALUES (21, 'RAFAEL EFF', NULL, '(48)99978-2918', '', '', '', '');

ALTER TABLE  app.tb_conexao
    ADD CONSTRAINT tb_conexao_pkey
    PRIMARY KEY (cd_conexao);

ALTER TABLE  app.tb_login
    ADD CONSTRAINT tb_login_pkey
    PRIMARY KEY (cd_login);

ALTER TABLE  app.tb_cliente
    ADD CONSTRAINT unique_tb_cliente
    UNIQUE (cd_cliente, nm_cliente);

ALTER TABLE  app.tb_conexao
    ADD CONSTRAINT unique_tb_conexao
    UNIQUE (cd_conexao, cd_cliente, id_conexao);

ALTER TABLE  app.tb_cliente
    ADD CONSTRAINT tb_cliente_pkey
    PRIMARY KEY (cd_cliente);

ALTER TABLE  app.tb_conexao
    ADD CONSTRAINT fk_tb_conexao_cd_cliente
    FOREIGN KEY (cd_cliente) REFERENCES tb_cliente(cd_cliente) MATCH FULL ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE  app.tb_cliente
    ADD CONSTRAINT tb_cliente_nm_cliente_key
    UNIQUE (nm_cliente);

ALTER TABLE  app.tb_ramal
    ADD CONSTRAINT tb_ramal_pkey
    PRIMARY KEY (cd_ramal);

ALTER TABLE  app.tb_ramal
    ADD CONSTRAINT tb_ramal_nm_funcionario_key
    UNIQUE (nm_funcionario);

ALTER TABLE  app.tb_ramal
    ADD CONSTRAINT tb_ramal_nr_telefone_key
    UNIQUE (nr_telefone);

ALTER TABLE  app.tb_agendamento
    ADD CONSTRAINT tb_agendamento_pkey
    PRIMARY KEY (cd_agenda);

ALTER TABLE  app.tb_agendamento
    ADD CONSTRAINT fk_tb_cliente_ramal_cd_funcionario
    FOREIGN KEY (cd_funcionario) REFERENCES tb_ramal(cd_ramal) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE  app.tb_agendamento
    ADD CONSTRAINT fk_tb_cliente_agendamento_cd_cliente
    FOREIGN KEY (cd_cliente) REFERENCES tb_cliente(cd_cliente) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE  app.tb_usuario
    ADD CONSTRAINT tb_usuario_pkey
    PRIMARY KEY (cd_usuario);

ALTER TABLE  app.tb_usuario
    ADD CONSTRAINT tb_usuario_tb_cliente_fk
    FOREIGN KEY (cd_cliente) REFERENCES tb_cliente(cd_cliente) ON UPDATE CASCADE ON DELETE CASCADE;