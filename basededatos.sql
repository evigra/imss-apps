-- MySQL dump 10.13  Distrib 5.7.18, for Linux (x86_64)
--
-- Host: localhost    Database: imss
-- ------------------------------------------------------
-- Server version	5.7.18-0ubuntu0.16.04.1

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
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `nivel` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` VALUES (1,'Dios',1,0),(2,'Administrador',1,10),(3,'Usuario',1,20),(4,'Dios',2,0),(5,'Administrador',2,10),(6,'Usuario',2,20);
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `link` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `type` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `parent` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu`
--

LOCK TABLES `menu` WRITE;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
INSERT INTO `menu` VALUES (1,'Personal','../','menu',NULL),(2,'Configuracion',NULL,'menu',NULL),(3,'General',NULL,'submenu',1),(4,'TxT','../personal_txt/','opcion',3),(5,'General',NULL,'submenu',2),(6,'Trabajadores','../usuarios/','opcion',5);
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modulos`
--

DROP TABLE IF EXISTS `modulos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modulos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clase` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `descripcion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `name` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modulos`
--

LOCK TABLES `modulos` WRITE;
/*!40000 ALTER TABLE `modulos` DISABLE KEYS */;
INSERT INTO `modulos` VALUES (1,'usuario','',NULL),(2,'sesion',NULL,NULL),(3,'personal_txt',NULL,NULL),(4,'groups',NULL,NULL);
/*!40000 ALTER TABLE `modulos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_txt`
--

DROP TABLE IF EXISTS `personal_txt`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_txt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trabajador_clave` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `trabajador_nombre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `trabajador_puesto` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `trabajador_horario` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `sustituto_clave` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `sustituto_nombre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `dias` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `total` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_txt`
--

LOCK TABLES `personal_txt` WRITE;
/*!40000 ALTER TABLE `personal_txt` DISABLE KEYS */;
INSERT INTO `personal_txt` VALUES (1,'99064616','Eduardo Vizcaino','Auxiliar Universal','08:00 a 16:00','99064617','Carlos Mariano','17/5/17',1),(2,'99064617','Carlos Mariano','Industrial',NULL,'99064616','Eduardo Vizcaino Granados Ch','17/5/17, 19/5/17, 24/5/17',3),(3,'99064616','Eduardo Vizcaino Granados Ch','Auxiliar Universal','08:00 a 16:00','99064617','Carlos Mariano','9/5/17, 13/5/17, 17/5/17, 19/5/17',4),(4,'99064616','Eduardo Vizcaino Granados','Auxiliar Universal','08:00 a 16:00','999',NULL,'4/5/17, 8/5/17, 18/5/17, 20/5/17',4),(5,'99064616','Eduardo Vizcaino Granados','Auxiliar Universal','08:00 a 16:00','99064617','Carlos Mariano','25/5/17, 26/5/17',2);
/*!40000 ALTER TABLE `personal_txt` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sesion`
--

DROP TABLE IF EXISTS `sesion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sesion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `server_addr` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `http_user_agent` varchar(150) COLLATE utf8_spanish_ci DEFAULT NULL,
  `remote_addr` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `last_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sesion`
--

LOCK TABLES `sesion` WRITE;
/*!40000 ALTER TABLE `sesion` DISABLE KEYS */;
INSERT INTO `sesion` VALUES (1,'2','127.0.0.1','2017-05-24 13:20:17','Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:53.0) Gecko/20100101 Firefox/53.0','127.0.0.1',NULL),(2,'2','127.0.0.1','2017-05-24 13:21:16','Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:53.0) Gecko/20100101 Firefox/53.0','127.0.0.1',NULL),(3,'2','127.0.0.1','2017-05-24 13:24:35','Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:53.0) Gecko/20100101 Firefox/53.0','127.0.0.1',NULL),(4,'2','127.0.0.1','2017-05-24 18:52:14','Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:53.0) Gecko/20100101 Firefox/53.0','127.0.0.1',NULL);
/*!40000 ALTER TABLE `sesion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_group`
--

DROP TABLE IF EXISTS `user_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_group` (
  `userid` int(11) NOT NULL,
  `groupid` int(11) NOT NULL,
  `active` int(1) DEFAULT NULL,
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `company_id` int(3) DEFAULT NULL,
  `user_id` int(5) DEFAULT NULL,
  `menu_id` int(3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_group`
--

LOCK TABLES `user_group` WRITE;
/*!40000 ALTER TABLE `user_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clave` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nombre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `password` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `puesto` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `horario` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'','e.vizcaino@solesgps.com','9c58ffe558e7f8957c56112afbfa1232',NULL,NULL),(2,'99064616','Eduardo Vizcaino Granados','9c58ffe558e7f8957c56112afbfa1232','Auxiliar Universal','08:00 a 16:00'),(3,'99064617','Carlos Mariano','c7d5c4f4f47da4b24c8a1ec0919d1777','Industrial',NULL);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;



CREATE TABLE `imss`.`personal` (
  `matricula` INT NOT NULL,
  `nombre` VARCHAR(100) NULL,
  `categoria_id` VARCHAR(45) NULL,
  `puesto_id` VARCHAR(45) NULL,
  `puesto` VARCHAR(120) NULL,
  `telefono` VARCHAR(45) NULL,
  `status` VARCHAR(45) NULL,
  `tipo_empleado` VARCHAR(45) NULL,
  `tipo_contratacion` VARCHAR(45) NULL,
  PRIMARY KEY (`matricula`));
  
  
  CREATE TABLE `imss`.`plazas` (
  `matricula` INT NOT NULL,
  `clave` VARCHAR(45) NULL,
  `puesto_id` VARCHAR(45) NULL,
  `puesto` VARCHAR(120) NULL,
  `departamento_id` VARCHAR(45) NULL,
  `departamento` VARCHAR(120) NULL,
  `horario_id` VARCHAR(45) NULL,
  `horario` VARCHAR(45) NULL,
  `b2` INT NULL,
  `b3` INT NULL,
  `b4` INT NULL,
  `b5` INT NULL,
  `b6` INT NULL,
  `b7` INT NULL,
  `b8` INT NULL,
  `b9` INT NULL,
  `sueldo` INT NULL,
  `turno` VARCHAR(45) NULL,
  `conceptos` VARCHAR(45) NULL,
  PRIMARY KEY (`matricula`));


CREATE TABLE `imss`.`permiso` (
  `id` INT NOT NULL,
  `usergroup_id` INT NULL,
  `menu_id` INT NULL,
  `s` VARCHAR(45) NULL,
  `c` VARCHAR(45) NULL,
  `w` VARCHAR(45) NULL,
  `d` VARCHAR(45) NULL,
  PRIMARY KEY (`id`));


CREATE TABLE `imss`.`personal_pase` (
  `id` INT NOT NULL,
  `matricula` INT NULL,
  `departamento_id` VARCHAR(45) NULL,
  `hora` DATETIME NULL,
  `estatus` DATETIME NULL,
  `c` VARCHAR(45) NULL,
  `w` VARCHAR(45) NULL,
  `d` VARCHAR(45) NULL,
  PRIMARY KEY (`id`));

CREATE TABLE `imss`.`historico` (
  `id` INT NOT NULL,
  `tabla` VARCHAR(35) NULL,
  `objeto` VARCHAR(45) NULL,
  `matricula` VARCHAR(12) NULL,
  `trabajador` VARCHAR(100) NULL,
  `fecha` DATETIME NULL,
  `descripcion` VARCHAR(150) NULL,
  PRIMARY KEY (`id`));
  --
-- Dumping events for database 'imss'
--

--
-- Dumping routines for database 'imss'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-05-25  9:05:41
