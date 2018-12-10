CREATE DATABASE  IF NOT EXISTS `dbdesafiotovts` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `dbdesafiotovts`;
-- MySQL dump 10.13  Distrib 8.0.12, for macos10.13 (x86_64)
--
-- Host: localhost    Database: dbdesafiotovts
-- ------------------------------------------------------
-- Server version	8.0.12

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
 SET NAMES utf8 ;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tbl_lance`
--

DROP TABLE IF EXISTS `tbl_lance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `tbl_lance` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Chave primária do lance',
  `tbl_usuario_id` int(11) NOT NULL COMMENT 'Usuário vinculado ao lance ( chave estrangeira )',
  `tbl_leilao_id` int(11) NOT NULL COMMENT 'Leilão vinculado ao lance ( chave estrangeira )',
  `dtlance` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Data e hora de criação do lance ( por padrão data e hora do momento da inserção na base )',
  `valorlance` decimal(10,2) NOT NULL COMMENT 'Valor do lance',
  PRIMARY KEY (`id`),
  KEY `fk_tbl_lance_tbl_usuario1_idx` (`tbl_usuario_id`),
  KEY `fk_tbl_lance_tbl_leilao1_idx` (`tbl_leilao_id`),
  CONSTRAINT `fk_tbl_lance_tbl_leilao1` FOREIGN KEY (`tbl_leilao_id`) REFERENCES `tbl_leilao` (`id`),
  CONSTRAINT `fk_tbl_lance_tbl_usuario1` FOREIGN KEY (`tbl_usuario_id`) REFERENCES `tbl_usuario` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_lance`
--

LOCK TABLES `tbl_lance` WRITE;
/*!40000 ALTER TABLE `tbl_lance` DISABLE KEYS */;
INSERT INTO `tbl_lance` VALUES (1,2,1,'2018-12-09 17:57:02',201.00),(2,1,1,'2018-12-09 17:57:02',202.00),(3,3,1,'2018-12-09 17:57:02',203.00),(4,1,1,'2018-12-09 17:57:02',205.00),(5,22,1,'2018-12-09 17:59:29',210.15);
/*!40000 ALTER TABLE `tbl_lance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_leilao`
--

DROP TABLE IF EXISTS `tbl_leilao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `tbl_leilao` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Chave primária do leilão',
  `tbl_usuario_id` int(11) NOT NULL COMMENT 'Usuário criador do leilão ( chave estrangeira )',
  `tbl_situacao_id` int(11) NOT NULL COMMENT 'Situação do item do leilão ( chave estrangeira )',
  `descricao` varchar(150) NOT NULL COMMENT 'Descrição do leilão',
  `valorinicial` decimal(10,2) NOT NULL COMMENT 'Valor de início do leilão',
  `dtabertura` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Data e hora de criação do leilão ( por padrão data e hora do momento da inserção na base )',
  `dtfinalizacao` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Data e hora de finalização do leilão ( por padrão data e hora do momento da inserção na base )',
  `leilativo` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Validador se o leilão está ativo no sistema\n\nAtivo - 1\nInativo - 0',
  PRIMARY KEY (`id`),
  KEY `fk_tblleilao_tbl_situacao1_idx` (`tbl_situacao_id`),
  KEY `fk_tblleilao_tbl_usuario1_idx` (`tbl_usuario_id`),
  CONSTRAINT `fk_tblleilao_tblsituacao1` FOREIGN KEY (`tbl_situacao_id`) REFERENCES `tbl_situacao` (`id`),
  CONSTRAINT `fk_tblleilao_tblusuario1` FOREIGN KEY (`tbl_usuario_id`) REFERENCES `tbl_usuario` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_leilao`
--

LOCK TABLES `tbl_leilao` WRITE;
/*!40000 ALTER TABLE `tbl_leilao` DISABLE KEYS */;
INSERT INTO `tbl_leilao` VALUES (1,1,2,'Leilão de Fitas SNES',200.00,'2018-12-09 09:19:59','2018-12-15 10:00:00',1),(2,1,1,'Leilão Jukebox',15000.00,'2018-12-01 09:27:15','2018-12-09 09:27:15',0),(3,1,2,'Leilão de Nintendo 64 Completo',890.00,'2018-12-07 09:27:15','2018-12-08 09:27:15',1),(4,1,1,'Casa Top D+++',120890.00,'2018-12-20 00:00:00','2019-01-01 00:00:00',1);
/*!40000 ALTER TABLE `tbl_leilao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_situacao`
--

DROP TABLE IF EXISTS `tbl_situacao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `tbl_situacao` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Chave primária da situação do item do lance',
  `descricao` varchar(50) NOT NULL COMMENT 'Descrição da situação do item do leilão ( novo / usado )',
  `stcativo` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Validador se a situação está ativa no sistema\n\nAtivo - 1\nInativo - 0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `descricao_UNIQUE` (`descricao`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_situacao`
--

LOCK TABLES `tbl_situacao` WRITE;
/*!40000 ALTER TABLE `tbl_situacao` DISABLE KEYS */;
INSERT INTO `tbl_situacao` VALUES (1,'Novo',1),(2,'Usado',1),(3,'Indefinido',0);
/*!40000 ALTER TABLE `tbl_situacao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_usuario`
--

DROP TABLE IF EXISTS `tbl_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `tbl_usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Chave primária do usuário',
  `nome` varchar(150) NOT NULL COMMENT 'Nome do usuário',
  `email` varchar(100) NOT NULL COMMENT 'E-mail do usuário - ( deve ser único na base )',
  `cpf` varchar(15) NOT NULL COMMENT 'CPF do usuário - ( deve ser único na base )\n',
  `usuario` varchar(50) NOT NULL COMMENT 'Usuário de acesso - ( deve ser único na base )',
  `senha` varchar(50) NOT NULL COMMENT 'Senha do usuário - ( Criptografia em nível de código )',
  `usradmin` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Validador se o usuário é administrador do sistema\n\nAtivo - 1\nInativo - 0',
  `usrativo` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Validador se o usuário está ativo no sistema\n\nAtivo - 1\nInativo - 0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  UNIQUE KEY `cpf_UNIQUE` (`cpf`),
  UNIQUE KEY `usuario_UNIQUE` (`usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_usuario`
--

LOCK TABLES `tbl_usuario` WRITE;
/*!40000 ALTER TABLE `tbl_usuario` DISABLE KEYS */;
INSERT INTO `tbl_usuario` VALUES (1,'Maicon Borges','ms.borges@outlook.com','06687446932','msborges','123456',1,1),(2,'João Alfredo','alfredojoao@gmail.com','06687446933','jalfredo','123456',0,1),(3,'Luís Henrique','hhenriques@icloud.com','06687446934','henriques','123456',0,0),(22,'Vanessa Borges','vms.bio@gmail.com','09024607906','vms.bio','12345678910',0,0);
/*!40000 ALTER TABLE `tbl_usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-12-10  7:58:04
