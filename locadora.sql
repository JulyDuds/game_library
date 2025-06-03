-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 22, 2025 at 12:14 PM
-- Server version: 8.0.30
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `locadora`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$WF.V0n57VP8yWIfH9fbMFeFhY3KXy9N0hfTJVUFQ0uEXYyfd192e6');

-- --------------------------------------------------------

--
-- Table structure for table `emprestimos`
--

CREATE TABLE `emprestimos` (
  `id` int NOT NULL,
  `id_jogo` int NOT NULL,
  `nome_cliente` varchar(100) NOT NULL,
  `data_emprestimo` date NOT NULL,
  `data_devolucao` date DEFAULT NULL,
  `devolvido` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `emprestimos`
--

INSERT INTO `emprestimos` (`id`, `id_jogo`, `nome_cliente`, `data_emprestimo`, `data_devolucao`, `devolvido`) VALUES
(1, 1, 'Thalyson', '2025-05-22', '2025-05-21', 1),
(2, 1, 'Thalyson', '2025-05-22', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `jogos`
--

CREATE TABLE `jogos` (
  `id` int NOT NULL,
  `nome` varchar(100) NOT NULL,
  `plataforma` enum('PC','Nintendo Switch','Xbox','PS4','PS5') NOT NULL,
  `categoria` enum('Open World','Sandbox','Esporte','Aventura') NOT NULL,
  `ano_lancamento` int DEFAULT NULL,
  `disponivel` tinyint(1) DEFAULT '1',
  `imagem` varchar(255) DEFAULT 'default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `jogos`
--

INSERT INTO `jogos` (`id`, `nome`, `plataforma`, `categoria`, `ano_lancamento`, `disponivel`, `imagem`) VALUES
(1, 'The Legend of Zelda: Breath of the Wild', 'Nintendo Switch', 'Aventura', 2017, 0, 'zelda.jpg'),
(5, 'Red Dead Redemption 2', 'PS4', 'Open World', 2018, 1, 'rdr2.jpg'),
(6, 'Forza Horizon 5', 'Xbox', 'Esporte', 2021, 1, 'forza5.jpg'),
(7, 'Super Mario Odyssey', 'Nintendo Switch', 'Aventura', 2017, 1, 'mario.jpg'),
(8, 'Cyberpunk 2077', 'PC', 'Open World', 2020, 1, 'cyberpunk.jpg'),
(9, 'FIFA 22', 'PS5', 'Esporte', 2021, 1, 'fifa22.jpg'),
(10, 'Animal Crossing: New Horizons', 'Nintendo Switch', 'Sandbox', 2020, 1, 'acnh.jpg'),
(11, 'The Sims 4', 'PC', 'Sandbox', 2014, 1, 'sims4.jpg'),
(12, 'Spider-Man: Miles Morales', 'PS5', 'Aventura', 2020, 1, 'spiderman.jpg'),
(13, 'Halo Infinite', 'Xbox', 'Aventura', 2021, 1, 'halo.jpg'),
(14, 'Gran Turismo 7', 'PS5', 'Esporte', 2022, 1, 'gt7.jpg'),
(15, 'Assassin\'s Creed Valhalla', 'PC', 'Open World', 2020, 1, 'acvalhalla.jpg'),
(16, 'NBA 2K23', 'PS4', 'Esporte', 2022, 1, 'nba2k23.jpg'),
(17, 'Pokémon Legends: Arceus', 'Nintendo Switch', 'Aventura', 2022, 1, 'pokemonarceus.jpg'),
(39, 'God of War', 'PS4', 'Aventura', 2018, 1, 'gow.jpg'),
(40, 'FIFA 23', 'Xbox', 'Esporte', 2022, 1, 'fifa23.jpg'),
(41, 'Minecraft', 'PC', 'Sandbox', 2011, 1, 'minecraft.jpg'),
(42, 'Grand Theft Auto V', 'PS5', 'Open World', 2013, 1, 'gtav.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'JulyJudy', '$2y$10$Tb6WOMt3E6shV9cvQ6mSjuqIjElAb5Wpb57dZr3oNTF8CQ/uSYXzC', '2025-05-21 19:04:48'),
(2, 'Ju', '$2y$10$v3aABrsTdZhgDLM7jI5KzezAIqx46UWcSt3lexFLd9X240fhR8tqi', '2025-05-21 19:05:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `emprestimos`
--
ALTER TABLE `emprestimos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_jogo` (`id_jogo`);

--
-- Indexes for table `jogos`
--
ALTER TABLE `jogos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `emprestimos`
--
ALTER TABLE `emprestimos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jogos`
--
ALTER TABLE `jogos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `emprestimos`
--
ALTER TABLE `emprestimos`
  ADD CONSTRAINT `emprestimos_ibfk_1` FOREIGN KEY (`id_jogo`) REFERENCES `jogos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
