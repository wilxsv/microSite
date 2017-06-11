<?php
global $wpdb;
$user_count = $wpdb->get_var( "show tables like 'pnc'");
if(count($user_count)==0){
  try {
    $con = new PDO("mysql:host=".$wpdb->dbhost.";dbname=".$wpdb->dbname,$wpdb->dbuser,$wpdb->dbpassword);
    $con->query("SET NAMES utf8;
SET time_zone = '+00:00';

DROP TABLE IF EXISTS `accidentes`;
CREATE TABLE `accidentes` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `cuenta` int(11) NOT NULL,
  `departamento` text,
  `municipio` text,
  `anyo` int(11) DEFAULT NULL,
  `mes` text,
  `dia` text,
  `hora` text,
  `rangohora` text,
  `tipoaccidente` text,
  `tipovehiculo` text,
  `danyos` text,
  `area` text,
  `causa` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `delitos`;
CREATE TABLE `delitos` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `cuenta` int(10) unsigned DEFAULT '1',
  `departamento` text,
  `municipio` text,
  `anyo` int(11) DEFAULT NULL,
  `mes` text,
  `dia` text,
  `hora` text,
  `rangohora` text,
  `arma` text,
  `delito` text,
  `area` text,
  `unidadpolicial` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `delitossexuales`;
CREATE TABLE `delitossexuales` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `cuenta` int(11) NOT NULL,
  `departamento` text,
  `municipio` text,
  `anyo` int(11) DEFAULT NULL,
  `mes` text,
  `dia` text,
  `hora` text,
  `rangohora` text,
  `arma` text,
  `delito` text,
  `area` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `detenidos`;
CREATE TABLE `detenidos` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `cuenta` int(10) unsigned DEFAULT '1',
  `departamento` text,
  `municipio` text,
  `anyo` int(11) DEFAULT NULL,
  `mes` text,
  `dia` text,
  `hora` text,
  `rangohora` text,
  `sexo` text,
  `edad` int(11) DEFAULT NULL,
  `grupoedad` text,
  `delito` text,
  `estructuracriminal` text,
  `tipodetencion` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `victimas`;
CREATE TABLE `victimas` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `cuenta` int(10) unsigned DEFAULT '1',
  `departamento` text,
  `municipio` text,
  `anyo` int(11) DEFAULT NULL,
  `mes` text,
  `dia` text,
  `hora` text,
  `rangohora` text,
  `tipoarma` text,
  `sexo` text,
  `edad` int(11) DEFAULT NULL,
  `grupoedad` text,
  `delito` text,
  `pertenecepandilla` text,
  `relacionvictimavictimario` text,
  `area` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
    //$con->query();
    $con = null;
  }catch (PDOException $e) {
    print "¡Error!: " . $e->getMessage() . "<br/>";
    //die();
  }
      
}

?>
