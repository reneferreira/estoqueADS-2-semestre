-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 07/10/2026 às 13:07
-- Versão do servidor: 8.3.0
-- Versão do PHP: 8.2.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `estoque_ads`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

DROP TABLE IF EXISTS `produtos`;
CREATE TABLE IF NOT EXISTS `produtos` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `categoria` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantidade` int UNSIGNED NOT NULL DEFAULT '0',
  `estoque_minimo` int NOT NULL,
  `preco` decimal(10,2) NOT NULL DEFAULT '0.00',
  `cadastrado_em` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`id`, `nome`, `categoria`, `quantidade`, `estoque_minimo`, `preco`, `cadastrado_em`) VALUES
(2, 'Caderno', 'Escritório', 20, 50, 200.00, '2026-10-01 15:35:46'),
(3, 'Lápis', 'Escritório', 250, 50, 2.50, '2026-10-01 15:36:33'),
(12, 'Caneta Preta', 'Escritório', 1000, 100, 0.20, '2026-10-06 18:42:33'),
(11, 'Caneta-Azul', 'Escritório', 1000, 100, 0.20, '2026-10-03 21:30:30'),
(9, 'Caderno capa dura', 'Escritório', 10, 1, 1.20, '2026-10-03 21:19:33');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
