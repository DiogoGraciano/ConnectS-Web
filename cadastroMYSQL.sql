-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 12/04/2024 às 23:08
-- Versão do servidor: 8.3.0
-- Versão do PHP: 8.3.4

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
-- Estrutura para tabela `tb_agendamento`
--

DROP TABLE IF EXISTS `tb_agendamento`;
CREATE TABLE IF NOT EXISTS `tb_agendamento` (
  `cd_agenda` int NOT NULL,
  `cd_cliente` int DEFAULT NULL,
  `cd_funcionario` int DEFAULT NULL,
  `obs` varchar(150) DEFAULT NULL,
  `dt_inicio` date DEFAULT NULL,
  `dt_fim` date DEFAULT NULL,
  `cor` varchar(150) DEFAULT NULL,
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`cd_agenda`),
  KEY `fk_tb_cliente_agendamento_cd_cliente` (`cd_cliente`),
  KEY `fk_funcionario_agenda` (`cd_funcionario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_cliente`
--

DROP TABLE IF EXISTS `tb_cliente`;
CREATE TABLE IF NOT EXISTS `tb_cliente` (
  `cd_cliente` int NOT NULL,
  `nm_cliente` varchar(100) NOT NULL,
  `nr_loja` int NOT NULL,
  PRIMARY KEY (`cd_cliente`),
  UNIQUE KEY `nm_cliente` (`nm_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_conexao`
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
  KEY `cd_cliente_conexeo` (`cd_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_login`
--

DROP TABLE IF EXISTS `tb_login`;
CREATE TABLE IF NOT EXISTS `tb_login` (
  `cd_login` int NOT NULL,
  `nm_usuario` varchar(20) NOT NULL,
  `senha` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`cd_login`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_login_api`
--

DROP TABLE IF EXISTS `tb_login_api`;
CREATE TABLE IF NOT EXISTS `tb_login_api` (
  `cd_login_api` int NOT NULL,
  `usuario` varchar(64) NOT NULL,
  `senha` varchar(64) NOT NULL,
  UNIQUE KEY `cd_login_api` (`usuario`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_ramal`
--

DROP TABLE IF EXISTS `tb_ramal`;
CREATE TABLE IF NOT EXISTS `tb_ramal` (
  `cd_ramal` int NOT NULL,
  `nm_funcionario` varchar(150) NOT NULL,
  `nr_ramal` int DEFAULT NULL,
  `nr_telefone` varchar(150) NOT NULL,
  `nr_ip` varchar(150) DEFAULT NULL,
  `nm_usuario` varchar(150) DEFAULT NULL,
  `senha` varchar(150) DEFAULT NULL,
  `obs` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`cd_ramal`),
  UNIQUE KEY `nm_funcionario` (`nm_funcionario`),
  UNIQUE KEY `nr_telefone` (`nr_telefone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_usuario`
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
  KEY `fk_cliente_usuario` (`cd_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `tb_agendamento`
--
ALTER TABLE `tb_agendamento`
  ADD CONSTRAINT `fk_cliente_agenda` FOREIGN KEY (`cd_agenda`) REFERENCES `tb_cliente` (`cd_cliente`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_funcionario_agenda` FOREIGN KEY (`cd_funcionario`) REFERENCES `tb_ramal` (`cd_ramal`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Restrições para tabelas `tb_conexao`
--
ALTER TABLE `tb_conexao`
  ADD CONSTRAINT `cd_cliente_conexeo` FOREIGN KEY (`cd_cliente`) REFERENCES `tb_cliente` (`cd_cliente`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Restrições para tabelas `tb_usuario`
--
ALTER TABLE `tb_usuario`
  ADD CONSTRAINT `fk_cliente_usuario` FOREIGN KEY (`cd_cliente`) REFERENCES `tb_cliente` (`cd_cliente`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
