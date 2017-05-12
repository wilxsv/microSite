<?php
global $wpdb;
$user_count = $wpdb->get_var( "show tables like 'pnc'");
if(count($user_count)==0){
  try {
    $con = new PDO("mysql:host=".$wpdb->dbhost.";dbname=".$wpdb->dbname,$wpdb->dbuser,$wpdb->dbpassword);
    $con->query("-- Adminer 4.2.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

CREATE DATABASE `oip` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_bin */;
USE `oip`;

DROP TABLE IF EXISTS `pnc_area`;
CREATE TABLE `pnc_area` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombre_area` varchar(150) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `pnc_arma`;
CREATE TABLE `pnc_arma` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombre_arma` varchar(150) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `pnc_causa`;
CREATE TABLE `pnc_causa` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombre_causa` varchar(150) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `pnc_delito`;
CREATE TABLE `pnc_delito` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombre_delito` varchar(150) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `pnc_departamento`;
CREATE TABLE `pnc_departamento` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombre_departamento` varchar(150) COLLATE utf8_bin NOT NULL,
  `lat_departamento` double NOT NULL,
  `lon_departamento` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `pnc_droga`;
CREATE TABLE `pnc_droga` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombre_droga` varchar(150) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `pnc_esquela`;
CREATE TABLE `pnc_esquela` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `costo_esquela` double NOT NULL,
  `nombre_esquela` varchar(150) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `pnc_hechos`;
CREATE TABLE `pnc_hechos` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `dump_hecho` bigint(20) NOT NULL,
  `registro_hecho` datetime NOT NULL,
  `fecha_hecho` datetime NOT NULL,
  `delito_hecho` bigint(20) NOT NULL,
  `departamento_hecho` bigint(20) NOT NULL,
  `municipio_hecho` bigint(20) NOT NULL,
  `area_hecho` bigint(20) NOT NULL,
  `sexo_hecho` bigint(20) NOT NULL,
  `edad_hecho` bigint(20) NOT NULL,
  `arma_hecho` bigint(20) NOT NULL,
  `vapp_hecho` bigint(20) NOT NULL,
  `voip_hecho` bigint(20) NOT NULL,
  `movil_hecho` text COLLATE utf8_bin NOT NULL,
  `vrelacion_hecho` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `delito_hecho` (`delito_hecho`),
  KEY `departamento_hecho` (`departamento_hecho`),
  KEY `municipio_hecho` (`municipio_hecho`),
  KEY `area_hecho` (`area_hecho`),
  KEY `sexo_hecho` (`sexo_hecho`),
  KEY `arma_hecho` (`arma_hecho`),
  CONSTRAINT `pnc_hechos_ibfk_1` FOREIGN KEY (`delito_hecho`) REFERENCES `pnc_delito` (`id`),
  CONSTRAINT `pnc_hechos_ibfk_2` FOREIGN KEY (`departamento_hecho`) REFERENCES `pnc_departamento` (`id`),
  CONSTRAINT `pnc_hechos_ibfk_3` FOREIGN KEY (`municipio_hecho`) REFERENCES `pnc_municipio` (`id`),
  CONSTRAINT `pnc_hechos_ibfk_4` FOREIGN KEY (`area_hecho`) REFERENCES `pnc_area` (`id`),
  CONSTRAINT `pnc_hechos_ibfk_5` FOREIGN KEY (`sexo_hecho`) REFERENCES `pnc_sexo` (`id`),
  CONSTRAINT `pnc_hechos_ibfk_6` FOREIGN KEY (`arma_hecho`) REFERENCES `pnc_arma` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `pnc_incautacion`;
CREATE TABLE `pnc_incautacion` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `dump_incautacion` bigint(20) NOT NULL,
  `registro_incautacion` datetime NOT NULL,
  `fecha_incautacion` datetime NOT NULL,
  `delito_incautacion` bigint(20) NOT NULL,
  `departamento_incautacion` bigint(20) NOT NULL,
  `municipio_incautacion` bigint(20) NOT NULL,
  `area_incautacion` bigint(20) DEFAULT NULL,
  `cantidad_incautacion` bigint(20) NOT NULL,
  `unidad_incautacion` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `delito_incautacion` (`delito_incautacion`),
  KEY `departamento_incautacion` (`departamento_incautacion`),
  KEY `municipio_incautacion` (`municipio_incautacion`),
  KEY `area_incautacion` (`area_incautacion`),
  CONSTRAINT `pnc_incautacion_ibfk_1` FOREIGN KEY (`delito_incautacion`) REFERENCES `pnc_delito` (`id`),
  CONSTRAINT `pnc_incautacion_ibfk_2` FOREIGN KEY (`departamento_incautacion`) REFERENCES `pnc_departamento` (`id`),
  CONSTRAINT `pnc_incautacion_ibfk_3` FOREIGN KEY (`municipio_incautacion`) REFERENCES `pnc_municipio` (`id`),
  CONSTRAINT `pnc_incautacion_ibfk_4` FOREIGN KEY (`area_incautacion`) REFERENCES `pnc_area` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `pnc_municipio`;
CREATE TABLE `pnc_municipio` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombre_municipio` varchar(150) COLLATE utf8_bin NOT NULL,
  `lat_municipio` double NOT NULL,
  `lon_municipio` double NOT NULL,
  `departamento_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `departamento_id` (`departamento_id`),
  CONSTRAINT `pnc_municipio_ibfk_1` FOREIGN KEY (`departamento_id`) REFERENCES `pnc_departamento` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `pnc_sexo`;
CREATE TABLE `pnc_sexo` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombre_sexo` varchar(150) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `pnc_transito`;
CREATE TABLE `pnc_transito` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `dump_transito` bigint(20) NOT NULL,
  `registro_transito` datetime NOT NULL,
  `fecha_transito` datetime NOT NULL,
  `causa_transito` bigint(20) NOT NULL,
  `departamento_transito` bigint(20) NOT NULL,
  `municipio_transito` bigint(20) NOT NULL,
  `area_transito` bigint(20) NOT NULL,
  `sexo_transito` bigint(20) NOT NULL,
  `vehiculo_transito` bigint(20) NOT NULL,
  `esquela_transito` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `area_transito` (`area_transito`),
  KEY `causa_transito` (`causa_transito`),
  KEY `departamento_transito` (`departamento_transito`),
  KEY `municipio_transito` (`municipio_transito`),
  KEY `sexo_transito` (`sexo_transito`),
  KEY `vehiculo_transito` (`vehiculo_transito`),
  KEY `esquela_transito` (`esquela_transito`),
  CONSTRAINT `pnc_transito_ibfk_6` FOREIGN KEY (`causa_transito`) REFERENCES `pnc_causa` (`id`),
  CONSTRAINT `pnc_transito_ibfk_7` FOREIGN KEY (`departamento_transito`) REFERENCES `pnc_departamento` (`id`),
  CONSTRAINT `pnc_transito_ibfk_8` FOREIGN KEY (`municipio_transito`) REFERENCES `pnc_municipio` (`id`),
  CONSTRAINT `pnc_transito_ibfk_9` FOREIGN KEY (`sexo_transito`) REFERENCES `pnc_sexo` (`id`),
  CONSTRAINT `pnc_transito_ibfk_10` FOREIGN KEY (`vehiculo_transito`) REFERENCES `pnc_vehiculo` (`id`),
  CONSTRAINT `pnc_transito_ibfk_11` FOREIGN KEY (`esquela_transito`) REFERENCES `pnc_esquela` (`id`),
  CONSTRAINT `pnc_transito_ibfk_1` FOREIGN KEY (`causa_transito`) REFERENCES `pnc_causa` (`id`),
  CONSTRAINT `pnc_transito_ibfk_2` FOREIGN KEY (`departamento_transito`) REFERENCES `pnc_departamento` (`id`),
  CONSTRAINT `pnc_transito_ibfk_3` FOREIGN KEY (`municipio_transito`) REFERENCES `pnc_municipio` (`id`),
  CONSTRAINT `pnc_transito_ibfk_4` FOREIGN KEY (`area_transito`) REFERENCES `pnc_area` (`id`),
  CONSTRAINT `pnc_transito_ibfk_5` FOREIGN KEY (`sexo_transito`) REFERENCES `pnc_sexo` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `pnc_umedida`;
CREATE TABLE `pnc_umedida` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombre_umedida` varchar(150) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `pnc_vehiculo`;
CREATE TABLE `pnc_vehiculo` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombre_vehiculo` varchar(150) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


-- 2017-05-02 07:11:19
");
    //$con->query();
    $con = null;
  }catch (PDOException $e) {
    print "¡Error!: " . $e->getMessage() . "<br/>";
    //die();
  }
      
}

?>
