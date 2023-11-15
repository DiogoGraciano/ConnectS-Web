-- Create the tb_agendamento table
CREATE TABLE tb_agendamento (
    cd_agenda INT NOT NULL,
    cd_cliente INT,
    cd_funcionario INT,
    obs VARCHAR(150),
    dt_inicio DATE,
    dt_fim DATE,
    cor VARCHAR(150),
    status VARCHAR(20) NOT NULL
);

-- Set statistics for columns (not available in MySQL)
-- ALTER TABLE tb_agendamento MODIFY COLUMN cd_agenda SET STATISTICS 0;

-- Change table owner (not available in MySQL)
-- ALTER TABLE tb_agendamento OWNER TO postgres;

-- Create the tb_cliente table
CREATE TABLE tb_cliente (
    cd_cliente INT NOT NULL,
    nm_cliente VARCHAR(100) NOT NULL,
    nr_loja INT NOT NULL
);

-- Change table owner (not available in MySQL)
-- ALTER TABLE tb_cliente OWNER TO postgres;

-- Create the tb_conexao table
CREATE TABLE tb_conexao (
    cd_conexao INT NOT NULL,
    id_conexao VARCHAR(150) NOT NULL,
    cd_cliente INT NOT NULL,
    nm_terminal VARCHAR(50) NOT NULL,
    nm_programa VARCHAR(50) NOT NULL,
    nm_usuario VARCHAR(150),
    senha VARCHAR(150),
    obs VARCHAR(300),
    nr_caixa INT
);

-- Change table owner (not available in MySQL)
-- ALTER TABLE tb_conexao OWNER TO postgres;

-- Create the tb_login table
CREATE TABLE tb_login (
    cd_login INT NOT NULL,
    nm_usuario VARCHAR(20) NOT NULL,
    senha VARCHAR(30) NOT NULL
);

-- Change table owner (not available in MySQL)
-- ALTER TABLE tb_login OWNER TO postgres;

-- Create the tb_ramal table
CREATE TABLE tb_ramal (
    cd_ramal INT NOT NULL,
    nm_funcionario VARCHAR(150) NOT NULL,
    nr_ramal INT,
    nr_telefone VARCHAR(150) NOT NULL,
    nr_ip VARCHAR(150),
    nm_usuario VARCHAR(150),
    senha VARCHAR(150),
    obs VARCHAR(150)
);

-- Set statistics for columns (not available in MySQL)
-- ALTER TABLE tb_ramal MODIFY COLUMN cd_ramal SET STATISTICS 0;
-- ALTER TABLE tb_ramal MODIFY COLUMN nm_funcionario SET STATISTICS 0;
-- ALTER TABLE tb_ramal MODIFY COLUMN nr_ramal SET STATISTICS 0;
-- ALTER TABLE tb_ramal MODIFY COLUMN nr_telefone SET STATISTICS 0;

-- Change table owner (not available in MySQL)
-- ALTER TABLE tb_ramal OWNER TO postgres;

-- Create the tb_usuario table
CREATE TABLE tb_usuario (
    cd_usuario INT NOT NULL,
    cd_cliente INT NOT NULL,
    nm_usuario VARCHAR(150) NOT NULL,
    senha VARCHAR(150) NOT NULL,
    nm_sistema VARCHAR(150) NOT NULL,
    nm_terminal VARCHAR(150) NOT NULL,
    obs VARCHAR(150)
);

-- Change table owner (not available in MySQL)
-- ALTER TABLE tb_usuario OWNER TO postgres;

-- Add data to the tables (COPY command not available in MySQL)

-- Add primary key constraints
ALTER TABLE tb_agendamento
    ADD PRIMARY KEY (cd_agenda);

ALTER TABLE tb_cliente
    ADD PRIMARY KEY (cd_cliente);

ALTER TABLE tb_conexao
    ADD PRIMARY KEY (cd_conexao);

ALTER TABLE tb_login
    ADD PRIMARY KEY (cd_login);

ALTER TABLE tb_ramal
    ADD PRIMARY KEY (cd_ramal);

ALTER TABLE tb_usuario
    ADD PRIMARY KEY (cd_usuario);

-- Add unique constraints
ALTER TABLE tb_cliente
    ADD UNIQUE (nm_cliente);

ALTER TABLE tb_ramal
    ADD UNIQUE (nm_funcionario);

ALTER TABLE tb_ramal
    ADD UNIQUE (nr_telefone);

-- Add foreign key constraints
ALTER TABLE tb_agendamento
    ADD CONSTRAINT fk_tb_cliente_agendamento_cd_cliente
    FOREIGN KEY (cd_cliente) REFERENCES tb_cliente(cd_cliente)
    ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE tb_agendamento
    ADD CONSTRAINT fk_tb_cliente_ramal_cd_funcionario
    FOREIGN KEY (cd_funcionario) REFERENCES tb_ramal(cd_ramal)
    ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE tb_conexao
    ADD CONSTRAINT fk_tb_conexao_cd_cliente
    FOREIGN KEY (cd_cliente) REFERENCES tb_cliente(cd_cliente)
    ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE tb_usuario
    ADD CONSTRAINT tb_usuario_tb_cliente_fk
    FOREIGN KEY (cd_cliente) REFERENCES tb_cliente(cd_cliente)
    ON UPDATE CASCADE ON DELETE CASCADE;
