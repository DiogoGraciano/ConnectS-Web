-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 13-Abr-2024 às 20:31
-- Versão do servidor: 8.0.31
-- versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `app`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_agendamento`
--

DROP TABLE IF EXISTS `tb_agendamento`;
CREATE TABLE IF NOT EXISTS `tb_agendamento` (
  `cd_agenda` int NOT NULL,
  `cd_cliente` int DEFAULT NULL,
  `cd_funcionario` int DEFAULT NULL,
  `titulo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `obs` varchar(150) DEFAULT NULL,
  `dt_inicio` datetime DEFAULT NULL,
  `dt_fim` datetime DEFAULT NULL,
  `cor` varchar(150) DEFAULT NULL,
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`cd_agenda`),
  KEY `fk_tb_cliente_agendamento_cd_cliente` (`cd_cliente`),
  KEY `fk_tb_cliente_ramal_cd_funcionario` (`cd_funcionario`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_cliente`
--

DROP TABLE IF EXISTS `tb_cliente`;
CREATE TABLE IF NOT EXISTS `tb_cliente` (
  `cd_cliente` int NOT NULL,
  `nm_cliente` varchar(100) NOT NULL,
  `nr_loja` int NOT NULL,
  PRIMARY KEY (`cd_cliente`),
  UNIQUE KEY `nm_cliente` (`nm_cliente`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_conexao`
--

DROP TABLE IF EXISTS `tb_conexao`;
CREATE TABLE IF NOT EXISTS `tb_conexao` (
  `cd_conexao` int NOT NULL,
  `id_conexao` varchar(150) NOT NULL,
  `cd_cliente` int NOT NULL,
  `nm_terminal` varchar(50) NOT NULL,
  `nm_programa` varchar(50) NOT NULL,
  `nm_usuario` varchar(150) DEFAULT NULL,
  `senha` varchar(150) DEFAULT NULL,
  `obs` varchar(300) DEFAULT NULL,
  `nr_caixa` int DEFAULT NULL,
  PRIMARY KEY (`cd_conexao`),
  KEY `fk_tb_conexao_cd_cliente` (`cd_cliente`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_funcionario`
--

DROP TABLE IF EXISTS `tb_funcionario`;
CREATE TABLE IF NOT EXISTS `tb_funcionario` (
  `cd_funcionario` int NOT NULL,
  `nm_funcionario` varchar(150) NOT NULL,
  `nr_ramal` int DEFAULT NULL,
  `nr_telefone` varchar(150) NOT NULL,
  `nr_ip` varchar(150) DEFAULT NULL,
  `nm_usuario` varchar(150) DEFAULT NULL,
  `senha` varchar(150) DEFAULT NULL,
  `obs` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`cd_funcionario`),
  UNIQUE KEY `nm_funcionario` (`nm_funcionario`),
  UNIQUE KEY `nr_telefone` (`nr_telefone`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_login`
--

DROP TABLE IF EXISTS `tb_login`;
CREATE TABLE IF NOT EXISTS `tb_login` (
  `cd_login` int NOT NULL,
  `nm_usuario` varchar(20) NOT NULL,
  `senha` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`cd_login`),
  UNIQUE KEY `nm_usuario` (`nm_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_login_api`
--

DROP TABLE IF EXISTS `tb_login_api`;
CREATE TABLE IF NOT EXISTS `tb_login_api` (
  `cd_login_api` int NOT NULL,
  `nm_usuario` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `senha` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`cd_login_api`) USING BTREE,
  UNIQUE KEY `usuario` (`nm_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_usuario`
--

DROP TABLE IF EXISTS `tb_usuario`;
CREATE TABLE IF NOT EXISTS `tb_usuario` (
  `cd_usuario` int NOT NULL,
  `cd_cliente` int NOT NULL,
  `nm_usuario` varchar(150) NOT NULL,
  `senha` varchar(150) NOT NULL,
  `nm_sistema` varchar(150) NOT NULL,
  `nm_terminal` varchar(150) NOT NULL,
  `obs` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`cd_usuario`),
  KEY `tb_usuario_tb_cliente_fk` (`cd_cliente`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
COMMIT;

INSERT INTO `tb_login` (`cd_login`, `nm_usuario`, `senha`) VALUES
(1, 'ADMIN', '$2y$10$/.plRm/Wpb4DfkGaAPYlWukffnb7sKFFErdObnYImsXpM7ueJ90Fi')
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
