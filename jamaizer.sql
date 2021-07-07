-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 07 juil. 2021 à 10:07
-- Version du serveur :  10.4.18-MariaDB
-- Version de PHP : 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `jamaizer`
--

-- --------------------------------------------------------

--
-- Structure de la table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `is_valid` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`, `picture`, `city`, `is_valid`, `created_at`, `updated_at`) VALUES
(1, 'Les chatons', 'Un groupe pour chanter ensemble, toutes voix, c\'est fun avec un répertoire varié.', NULL, 'Grenoble', NULL, '2021-07-06 15:04:53', '2021-07-06 15:04:53'),
(3, 'Les pélicans', 'Un groupe pour chanter ensemble, toutes voix, c\'est fun avec un répertoire varié.', NULL, 'Toulouse', 0, '2021-07-06 15:31:36', '2021-07-06 15:31:36'),
(4, 'Les autruches', 'Un groupe pour chanter ensemble, toutes voix, c\'est fun avec un répertoire varié.', NULL, 'Toulouse', 0, '2021-07-06 15:34:08', '2021-07-06 15:34:08'),
(5, 'The chatons', 'Un groupe pour chanter ensemble, toutes voix, c\'est fun avec un répertoire varié.', NULL, 'Toulouse', 0, '2021-07-06 15:35:49', '2021-07-06 15:35:49'),
(6, 'The pelicans', 'Un groupe pour chanter ensemble, toutes voix, c\'est fun avec un répertoire varié.', NULL, 'Toulouse', 0, '2021-07-06 15:37:15', '2021-07-06 15:37:15');

-- --------------------------------------------------------

--
-- Structure de la table `group_member`
--

CREATE TABLE `group_member` (
  `id` int(11) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `is_group_ok` tinyint(1) DEFAULT NULL,
  `is_member_ok` tinyint(1) DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `group_member`
--

INSERT INTO `group_member` (`id`, `group_id`, `member_id`, `is_group_ok`, `is_member_ok`, `is_admin`) VALUES
(1, 6, 11, 1, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `member`
--

CREATE TABLE `member` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `is_email_valid` tinyint(4) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `birth` date DEFAULT NULL,
  `gender` tinyint(4) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_access` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `member`
--

INSERT INTO `member` (`id`, `pseudo`, `email`, `is_email_valid`, `password`, `name`, `first_name`, `birth`, `gender`, `phone`, `created_at`, `updated_at`, `date_access`) VALUES
(4, 'fgbfdshuij', 'bhgjdkomspk@njfi.cbsd', NULL, '$2y$10$3ILUAvQMZ/gxtfzHkmwFgesgOFcgIs9cWXgbhJK2mW5AhKu2ptV46', NULL, NULL, NULL, NULL, NULL, NULL, '2021-06-29 14:13:16', NULL),
(10, 'testt', 'test@test.test', NULL, '$2y$10$NDQSfmjzvp5MwJWx1uScLeXE4bRJaLITKCquib2MhAolvjwQFF9mK', NULL, NULL, NULL, NULL, NULL, NULL, '2021-06-30 17:34:35', NULL),
(11, 'coco', 'coco@coco.coco', NULL, '$2y$10$WmPT9K30DXeKNAFgl2fTbuq2R8LD4Gsew8Ntv4ZwR.nTzigojeWdm', 'B', 'Coralie', '2021-07-01', 2, '0987654321', NULL, '2021-07-01 16:29:50', NULL),
(12, 'co', 'co@coco.coco', NULL, '$2y$10$vzKqGJ7J99ukqmvrfCxoje8ItUYpbd2rr5bgeSTh2kIBhyE4tSwo6', NULL, NULL, NULL, NULL, NULL, NULL, '2021-07-01 16:31:46', NULL),
(13, 'Lélé', 'lele@lele.lele', NULL, '$2y$10$Y/tIe8AysF3WipDs8Zsf9.9DZppazb4kxvnJ9dCtOiKRoLJuCyt2e', NULL, NULL, NULL, NULL, NULL, NULL, '2021-07-02 13:33:44', NULL),
(14, 'azerty', 'azerty@bfi.dsfg', NULL, '$2y$10$jZqMXTHHk689.PT.l6EZ1e8FasbmoqhVdjFQDy9Lc/JrUvg6L28z.', 'Az', 'Erty', '2021-07-07', 2, '1234567890', NULL, '2021-07-02 15:50:03', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2021-06-25-095604', 'App\\Database\\Migrations\\Member', 'default', 'App', 1624615104, 1);

-- --------------------------------------------------------

--
-- Structure de la table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `slug` varchar(128) NOT NULL,
  `body` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `news`
--

INSERT INTO `news` (`id`, `title`, `slug`, `body`) VALUES
(1, 'Truc machin chouette', 'bidule', 'blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla blabla '),
(2, 'pfffff', 'pfffff', 'bla ble bli blo blu'),
(3, 'htegr', 'htegr', 'rhefdsc');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `group_member`
--
ALTER TABLE `group_member`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `member_id` (`member_id`);

--
-- Index pour la table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pseudo` (`pseudo`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `slug` (`slug`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `group_member`
--
ALTER TABLE `group_member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `member`
--
ALTER TABLE `member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `group_member`
--
ALTER TABLE `group_member`
  ADD CONSTRAINT `group_member_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`),
  ADD CONSTRAINT `group_member_ibfk_2` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
