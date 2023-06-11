CREATE DATABASE  IF NOT EXISTS `oslec_course` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `oslec_course`;
-- MariaDB dump 10.19  Distrib 10.4.28-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: oslec_course
-- ------------------------------------------------------
-- Server version	10.4.28-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cursos`
--

DROP TABLE IF EXISTS `cursos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cursos` (
  `id_Curso` int(11) NOT NULL AUTO_INCREMENT,
  `nome_Curso` varchar(30) NOT NULL,
  `carga_Horaria` int(11) NOT NULL,
  `descritivo` char(200) DEFAULT NULL,
  PRIMARY KEY (`id_Curso`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cursos`
--

LOCK TABLES `cursos` WRITE;
/*!40000 ALTER TABLE `cursos` DISABLE KEYS */;
INSERT INTO `cursos` VALUES (1,'DEV',1000,'Desenvolvimento de sistemas'),(2,'Redes',220,'Cabeamento estruturado'),(3,'excel',120,'basico'),(6,'Banco de dados',560,'mysql');
/*!40000 ALTER TABLE `cursos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `login_usuarios`
--

DROP TABLE IF EXISTS `login_usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `login_usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(30) DEFAULT NULL,
  `telefone` varchar(30) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `senha` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login_usuarios`
--

LOCK TABLES `login_usuarios` WRITE;
/*!40000 ALTER TABLE `login_usuarios` DISABLE KEYS */;
INSERT INTO `login_usuarios` VALUES (1,'Rejane','71993997173','rejane@gmail.com','202cb962ac59075b964b07152d234b70'),(2,'teste','88686','teste@gmail.com','202cb962ac59075b964b07152d234b70');
/*!40000 ALTER TABLE `login_usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mentorados`
--

DROP TABLE IF EXISTS `mentorados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mentorados` (
  `id_Aluno` int(11) NOT NULL AUTO_INCREMENT,
  `nome_Aluno` varchar(30) NOT NULL,
  `email_Aluno` varchar(30) NOT NULL,
  `telefone` char(15) NOT NULL,
  `periodo_inicial` date NOT NULL,
  `periodo_final` date NOT NULL,
  `id_Curso` int(11) DEFAULT NULL,
  `cod_certificado` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_Aluno`),
  KEY `curso_fk_mentorados` (`id_Curso`),
  CONSTRAINT `curso_fk_mentorados` FOREIGN KEY (`id_Curso`) REFERENCES `cursos` (`id_Curso`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mentorados`
--

LOCK TABLES `mentorados` WRITE;
/*!40000 ALTER TABLE `mentorados` DISABLE KEYS */;
INSERT INTO `mentorados` VALUES (9,'Paulo ','paulo86@ba.estudante.senai.br','71992974020','2020-08-08','2023-09-08',3,0),(10,'Ronaldo','ronaldo@ba.estudante.senai.br','71992974020','2018-08-08','2023-09-06',1,0),(21,'Yasmin','Yasmin@senai','71992973568','2000-11-15','2022-05-19',6,2),(23,'jaiane','Jaiane@senai','71992975895','2000-11-15','2021-03-10',2,3),(24,'Medeiros','Medeiros@Medeiros','11111111','2018-08-08','2000-11-25',1,4),(25,'Glauco','Glauco@Glauco','11111111','0000-00-00','2021-01-01',3,5);
/*!40000 ALTER TABLE `mentorados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mentores`
--

DROP TABLE IF EXISTS `mentores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mentores` (
  `id_Mentor` int(11) NOT NULL AUTO_INCREMENT,
  `nome_Mentor` varchar(30) NOT NULL,
  `email_Mentor` varchar(30) NOT NULL,
  `telefone` varchar(15) NOT NULL,
  `especialidade` varchar(20) NOT NULL,
  `id_Curso` int(11) DEFAULT NULL,
  `nome_Curso` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_Mentor`),
  KEY `curso_fk_mentores` (`id_Curso`),
  CONSTRAINT `curso_fk_mentores` FOREIGN KEY (`id_Curso`) REFERENCES `cursos` (`id_Curso`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mentores`
--

LOCK TABLES `mentores` WRITE;
/*!40000 ALTER TABLE `mentores` DISABLE KEYS */;
INSERT INTO `mentores` VALUES (2,'Celso da Silva Castro','celso@ba.docente.senai.br','(71)98564-7582','PHP',1,NULL),(3,'Jorge','Jorge@senai.com','(71)98568-7482','office',3,NULL),(18,'Ronaldo Alves','ronaldo@ba.estudante.senai.br','7198985-6845','Banco de dados',3,NULL);
/*!40000 ALTER TABLE `mentores` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-06-11 14:08:10
