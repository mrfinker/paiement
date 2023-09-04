-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : lun. 04 sep. 2023 à 14:56
-- Version du serveur : 8.0.30
-- Version de PHP : 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `paiment`
--

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `company_id` int DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type_id` int DEFAULT NULL,
  `phone` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `country_id` int DEFAULT NULL,
  `user_role_id` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `company_id`, `name`, `email`, `username`, `password`, `user_type_id`, `phone`, `address`, `image`, `country_id`, `user_role_id`, `created_at`) VALUES
(22, NULL, 'Kiangebeni Demissa Caleb', 'caalebs@gmail.com', 'mrfinker', '$2y$10$n1s/.shpj2.Gkziv8sxhS.Q6wUFl1cmw8mxyverBEawRGN0uFtdHu', NULL, '123', '123', NULL, NULL, NULL, '2023-09-04 00:32:17'),
(25, NULL, 'dknknkqd', '123@gmail.com', 'caaleb', '$2y$10$tWJ0fKQa8plfPq.1UVE/0eos8DxPceSIsqAuzRWV6Umwg/wQvwRkG', NULL, '123', '123', NULL, NULL, NULL, '2023-09-04 01:30:53'),
(26, NULL, 'adonai', 'adonai@gmail.com', 'adonai', '$2y$10$nfg9OfGfpsHSGOyGA2PAfe/D1roPGiQPVS.ho21G.v9Wyjop/xc6G', NULL, '123', '123', NULL, NULL, NULL, '2023-09-04 07:48:15'),
(27, NULL, 'test1', 'test@gmail.com', 'tets1', '$2y$10$oasPAVBkfEcHR2Jrgs4rRePMow2/pQzZpE75rnmzsxHJh49.Z8KPS', NULL, '123', '14789', NULL, NULL, NULL, '2023-09-04 09:35:40');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
