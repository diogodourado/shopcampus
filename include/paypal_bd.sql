-- phpMyAdmin SQL Dump
-- version 4.0.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 01, 2014 at 06:58 AM
-- Server version: 5.5.34-cll
-- PHP Version: 5.3.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `paypal_bd`
--

-- --------------------------------------------------------

--
-- Table structure for table `assinaturas`
--

CREATE TABLE IF NOT EXISTS `assinaturas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `usuario` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `usuario` (`usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `pedidos`
--

CREATE TABLE IF NOT EXISTS `pedidos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero` varchar(50) NOT NULL,
  `data` datetime NOT NULL,
  `total` decimal(8,2) NOT NULL,
  `status` varchar(50) NOT NULL,
  `usuarios_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `pedidos_produtos`
--

CREATE TABLE IF NOT EXISTS `pedidos_produtos` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `pedidos_id` int(10) NOT NULL,
  `produtos_id` int(10) NOT NULL,
  `quantidade` int(10) NOT NULL,
  `total` decimal(8,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `produtos`
--

CREATE TABLE IF NOT EXISTS `produtos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(250) NOT NULL,
  `preco` decimal(8,2) DEFAULT NULL,
  `descricao` text,
  `tipo` enum('produto','servico') NOT NULL DEFAULT 'produto',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `produtos`
--

INSERT INTO `produtos` (`id`, `nome`, `preco`, `descricao`, `tipo`) VALUES
(1, 'Camera Digital Nikon', '1800.00', 'A D3100 foi concebida para os principiantes na fotografia D-SLR', 'produto'),
(2, 'Smartphone Samsung Galaxy', '320.00', 'Sistema operacional Android 4.0 ', 'produto'),
(3, 'GPS Guia Quatro Rodas', '450.00', 'Tela 7.0 Slim c/ TV Digital e Camera de Re', 'produto'),
(4, 'Consultoria em Redes', '160.00', '* Valor da Assinatura diaria', 'servico'),
(5, 'Consultoria em Seguranca', '310.00', '* Valor da Assinatura diaria', 'servico'),
(6, 'Consultoria em TI', '210.00', '* Valor da Assinatura diaria', 'servico');

-- --------------------------------------------------------

--
-- Table structure for table `transacoes`
--

CREATE TABLE IF NOT EXISTS `transacoes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `transaction` varchar(100) NOT NULL,
  `assinatura` varchar(250) DEFAULT NULL,
  `pedidos_id` int(10) NOT NULL,
  `data` datetime NOT NULL,
  `status` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `senha` char(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `usuarios`
--

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
