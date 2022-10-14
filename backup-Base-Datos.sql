/*
SQLyog Ultimate v12.09 (32 bit)
MySQL - 10.2.31-MariaDB : Database - u229811426_alta
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`u229811426_alta` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;

USE `u229811426_alta`;

/*Table structure for table `contacto` */

DROP TABLE IF EXISTS `contacto`;

CREATE TABLE `contacto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `correo` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comentario` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hora` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `contacto` */

insert  into `contacto`(`id`,`nombre`,`correo`,`telefono`,`comentario`,`fecha`,`hora`) values (1,'Diego','macrodiego24@yahoo.es','3163542654','Probando la aplicacion','20200511','09:49:30');

/*Table structure for table `events` */

DROP TABLE IF EXISTS `events`;

CREATE TABLE `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `color` varchar(7) DEFAULT NULL,
  `start` datetime NOT NULL,
  `end` datetime DEFAULT NULL,
  `idusuario` int(11) DEFAULT NULL,
  `img` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `events` */

insert  into `events`(`id`,`title`,`color`,`start`,`end`,`idusuario`,`img`) values (1,'1','#0071c5','2017-08-01 00:00:00','2017-08-02 00:00:00',1,NULL),(2,'2','#40E0D0','2017-08-02 00:00:00','2017-08-03 00:00:00',1,NULL),(3,'3','#008000','2017-08-03 00:00:00','2017-08-07 00:00:00',1,NULL),(4,'1','#B200B2','2020-05-11 00:00:00','2020-05-12 00:00:00',1,'ICON-06.png');

/*Table structure for table `ma_categorias` */

DROP TABLE IF EXISTS `ma_categorias`;

CREATE TABLE `ma_categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria` varchar(100) NOT NULL,
  `img` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='Categorias Matilda';

/*Data for the table `ma_categorias` */

insert  into `ma_categorias`(`id`,`categoria`,`img`) values (1,'Cortes, cepillado y peinado','ICON-06.png'),(2,'Coloracion, Mechas y Alisados','ICON-05.png'),(3,'Manicura y Pedicura','ICON-04.png'),(4,'Depilacion con cera','ICON-03.png'),(5,'Maquillaje','ICON-02.png'),(6,'Cejas semipermanentes','ICON-02.png'),(7,'Tratamientos Capilares','ICON-01.png');

/*Table structure for table `ma_horario` */

DROP TABLE IF EXISTS `ma_horario`;

CREATE TABLE `ma_horario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `de` varchar(20) NOT NULL,
  `a` varchar(20) NOT NULL,
  `horaini` varchar(4) NOT NULL,
  `horafin` varchar(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `ma_horario` */

insert  into `ma_horario`(`id`,`de`,`a`,`horaini`,`horafin`) values (1,'Lunes','Domingo','0800','1900');

/*Table structure for table `suscritos` */

DROP TABLE IF EXISTS `suscritos`;

CREATE TABLE `suscritos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hora` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `acepto` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `suscritos` */

/*Table structure for table `usuarios` */

DROP TABLE IF EXISTS `usuarios`;

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `clave` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `apellidos` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cedula` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sexo` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fechanac` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fechareg` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `horareg` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reciboferta` varchar(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `acepto` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `usuarios` */

insert  into `usuarios`(`id`,`email`,`clave`,`nombre`,`apellidos`,`cedula`,`tipo`,`sexo`,`fechanac`,`fechareg`,`horareg`,`reciboferta`,`acepto`) values (1,'macrodiego24@yahoo.es','041b9a27f435eaa4b1cf4ca6323a4be7','Diego Fernando','Albarracin Rodríguez','91522337','cc','','','20200511','15:41:13','si','si');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
