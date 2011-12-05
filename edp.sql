-- phpMyAdmin SQL Dump
-- version 3.4.5deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 05, 2011 at 10:32 PM
-- Server version: 5.1.58
-- PHP Version: 5.3.6-13ubuntu3.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `edp`
--

-- --------------------------------------------------------

--
-- Table structure for table `cambio`
--

CREATE TABLE IF NOT EXISTS `cambio` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `fecha_cambio` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `descripcion` text NOT NULL,
  `autor_cambio` smallint(5) unsigned NOT NULL,
  `id_paquete` smallint(5) unsigned NOT NULL,
  `tipo_cambio` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `conversacion`
--

CREATE TABLE IF NOT EXISTS `conversacion` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `id_paquete` smallint(5) unsigned NOT NULL,
  `id_usuario` smallint(5) unsigned NOT NULL,
  `contenido` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `paquete`
--

CREATE TABLE IF NOT EXISTS `paquete` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `id_padre` smallint(5) unsigned NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `responsable` smallint(5) unsigned NOT NULL,
  `fecha_inicio` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `fecha_fin` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `fecha_cambio` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `autor_cambio` smallint(5) unsigned DEFAULT NULL,
  `duracion` float(5,2) DEFAULT NULL,
  `fecha_alta` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `autor_alta` smallint(5) unsigned NOT NULL,
  `entregable` varchar(255) DEFAULT NULL,
  `fecha_entregable` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `hito` varchar(255) DEFAULT NULL,
  `coste` float(8,2) DEFAULT NULL,
  `codigo` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=74 ;

-- --------------------------------------------------------

--
-- Table structure for table `tipo`
--

CREATE TABLE IF NOT EXISTS `tipo` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tipo`
--

INSERT INTO `tipo` (`id`, `nombre`) VALUES
(1, 'propiedad'),
(2, 'dp'),
(3, 'miembro');

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `id_tipo` smallint(5) unsigned NOT NULL,
  `alias` varchar(15) NOT NULL,
  `clave` varchar(32) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellidos` varchar(50) DEFAULT NULL,
  `coste_hora` float(4,2) NOT NULL,
  `fecha_alta` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fecha_baja` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ultima_visita` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `email` varchar(100) DEFAULT NULL,
  `dni` varchar(9) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`id`, `id_tipo`, `alias`, `clave`, `nombre`, `apellidos`, `coste_hora`, `fecha_alta`, `fecha_baja`, `ultima_visita`, `email`, `dni`, `telefono`) VALUES
(1, 2, 'c3jud0', '4e367a44908b571090f6fa74d964292d', 'Javier', 'Cejudo', 10.00, '2011-11-22 23:15:08', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'c3jud0@gmail.com', '16620151Y', '699797434');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
