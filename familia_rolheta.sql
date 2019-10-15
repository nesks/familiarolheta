-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 21-Ago-2017 às 14:49
-- Versão do servidor: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `familia_rolheta`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `cepa`
--

CREATE TABLE `cepa` (
  `Nome` varchar(30) NOT NULL,
  `Regiao_Origem` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `cepa`
--

INSERT INTO `cepa` (`Nome`, `Regiao_Origem`) VALUES
('Uva Branca', 'Baviera'),
('Uva marron', 'cochileus'),
('Uva verde', 'roma');

-- --------------------------------------------------------

--
-- Estrutura da tabela `colheita`
--

CREATE TABLE `colheita` (
  `Numero` int(11) NOT NULL,
  `Material` varchar(50) DEFAULT NULL,
  `Vindima` date DEFAULT NULL,
  `Info` varchar(100) DEFAULT NULL,
  `Codigo_Parreiral` int(11) DEFAULT NULL,
  `Codigo_Safra` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `contato`
--

CREATE TABLE `contato` (
  `Nome_Propriedade` varchar(30) NOT NULL,
  `Email` varchar(30) DEFAULT NULL,
  `Telefone` int(11) DEFAULT NULL,
  `Endereco` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `contato`
--

INSERT INTO `contato` (`Nome_Propriedade`, `Email`, `Telefone`, `Endereco`) VALUES
('Alcatraz', 'alcatraz@hotmail.com', 432432423, 'rua sao lo');

-- --------------------------------------------------------

--
-- Estrutura da tabela `data_plantio`
--

CREATE TABLE `data_plantio` (
  `Codigo_Parreiral` int(11) NOT NULL,
  `Data_Plantio` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `parreiral`
--

CREATE TABLE `parreiral` (
  `Codigo` int(11) NOT NULL,
  `Quantidade_Vinhas` int(11) DEFAULT NULL,
  `Area` double DEFAULT NULL,
  `Nome_Propriedade` varchar(30) DEFAULT NULL,
  `Nome_Cepa` varchar(30) DEFAULT NULL,
  `Data_Plantio` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `parreiral`
--

INSERT INTO `parreiral` (`Codigo`, `Quantidade_Vinhas`, `Area`, `Nome_Propriedade`, `Nome_Cepa`, `Data_Plantio`) VALUES
(125, 10, 423, 'Alcatraz', 'Uva marron', '0000-00-00'),
(126, 40, 329, 'Alcatraz', 'Uva verde', '0000-00-00'),
(127, 10, 432, 'Alcatraz', 'Uva marron', '2010-10-10'),
(128, 43, 543, 'Alcatraz', 'Uva Branca', '2010-10-10');

-- --------------------------------------------------------

--
-- Estrutura da tabela `propriedade`
--

CREATE TABLE `propriedade` (
  `Nome` varchar(30) NOT NULL,
  `Administrador` varchar(30) NOT NULL,
  `Terroir_Regiao` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `propriedade`
--

INSERT INTO `propriedade` (`Nome`, `Administrador`, `Terroir_Regiao`) VALUES
('Alcatraz', 'indigente', 'terroir');

-- --------------------------------------------------------

--
-- Estrutura da tabela `regiao`
--

CREATE TABLE `regiao` (
  `Terroir` varchar(30) NOT NULL,
  `Clima` varchar(30) DEFAULT NULL,
  `Umidade` double DEFAULT NULL,
  `altitude` double DEFAULT NULL,
  `Indice_Pluviometrico` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `regiao`
--

INSERT INTO `regiao` (`Terroir`, `Clima`, `Umidade`, `altitude`, `Indice_Pluviometrico`) VALUES
('terroir', 'clima', 423, 42, 123);

-- --------------------------------------------------------

--
-- Estrutura da tabela `safra`
--

CREATE TABLE `safra` (
  `Codigo_Vinho` int(11) DEFAULT NULL,
  `Ano` int(11) DEFAULT NULL,
  `Quantidade_Garrafas` int(11) DEFAULT NULL,
  `Tipo_Safra` varchar(30) DEFAULT NULL,
  `Codigo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `vinho`
--

CREATE TABLE `vinho` (
  `Codigo` int(11) NOT NULL,
  `Nome` varchar(30) NOT NULL,
  `Rotulo` varchar(256) DEFAULT NULL,
  `Classificacao` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cepa`
--
ALTER TABLE `cepa`
  ADD PRIMARY KEY (`Nome`);

--
-- Indexes for table `colheita`
--
ALTER TABLE `colheita`
  ADD PRIMARY KEY (`Numero`),
  ADD KEY `Codigo_Parreiral` (`Codigo_Parreiral`),
  ADD KEY `Codigo_Safra` (`Codigo_Safra`);

--
-- Indexes for table `contato`
--
ALTER TABLE `contato`
  ADD PRIMARY KEY (`Nome_Propriedade`);

--
-- Indexes for table `data_plantio`
--
ALTER TABLE `data_plantio`
  ADD PRIMARY KEY (`Codigo_Parreiral`,`Data_Plantio`);

--
-- Indexes for table `parreiral`
--
ALTER TABLE `parreiral`
  ADD PRIMARY KEY (`Codigo`),
  ADD KEY `Nome_Propriedade` (`Nome_Propriedade`),
  ADD KEY `Nome_Cepa` (`Nome_Cepa`);

--
-- Indexes for table `propriedade`
--
ALTER TABLE `propriedade`
  ADD PRIMARY KEY (`Nome`),
  ADD KEY `Terroir_Regiao` (`Terroir_Regiao`);

--
-- Indexes for table `regiao`
--
ALTER TABLE `regiao`
  ADD PRIMARY KEY (`Terroir`);

--
-- Indexes for table `safra`
--
ALTER TABLE `safra`
  ADD PRIMARY KEY (`Codigo`),
  ADD KEY `Codigo_Vinho` (`Codigo_Vinho`);

--
-- Indexes for table `vinho`
--
ALTER TABLE `vinho`
  ADD PRIMARY KEY (`Codigo`,`Nome`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `colheita`
--
ALTER TABLE `colheita`
  MODIFY `Numero` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;
--
-- AUTO_INCREMENT for table `parreiral`
--
ALTER TABLE `parreiral`
  MODIFY `Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;
--
-- AUTO_INCREMENT for table `safra`
--
ALTER TABLE `safra`
  MODIFY `Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `vinho`
--
ALTER TABLE `vinho`
  MODIFY `Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `parreiral`
--
ALTER TABLE `parreiral`
  ADD CONSTRAINT `parreiral_ibfk_1` FOREIGN KEY (`Nome_Propriedade`) REFERENCES `propriedade` (`Nome`),
  ADD CONSTRAINT `parreiral_ibfk_2` FOREIGN KEY (`Nome_Cepa`) REFERENCES `cepa` (`Nome`);

--
-- Limitadores para a tabela `propriedade`
--
ALTER TABLE `propriedade`
  ADD CONSTRAINT `propriedade_ibfk_1` FOREIGN KEY (`Terroir_Regiao`) REFERENCES `regiao` (`Terroir`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
