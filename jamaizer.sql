-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 21 juil. 2021 à 11:29
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
-- Structure de la table `date`
--

CREATE TABLE `date` (
  `id` int(11) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `date_start` datetime DEFAULT NULL,
  `date_end` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `date_registration`
--

CREATE TABLE `date_registration` (
  `id` int(11) NOT NULL,
  `date_id` int(11) DEFAULT NULL,
  `event_registration_id` int(11) DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `events`
--

INSERT INTO `events` (`id`, `group_id`, `name`, `description`, `date_start`, `date_end`, `created_at`, `updated_at`) VALUES
(1, 1, 'La jam des chatons', 'C\'est gé-ni-al. Au top.\r\nAllez viens !', '2021-07-07', '2021-08-21', '2021-07-19 11:35:53', '2021-07-19 11:35:53'),
(2, 1, 'Le festival des 1000 chatons', 'Plein d\'événements, des concerts et des répétitions, dès que les dates seront programmées... Ok ?', '2021-07-08', '0000-00-00', '2021-07-19 12:26:27', '2021-07-19 12:26:27'),
(3, 1, 'L\'autruche est sur le toit', 'c\'est pas commun ça', NULL, NULL, '2021-07-19 15:12:38', '2021-07-19 15:12:38'),
(4, 1, 'L\'autruche est sur le toit', 'c\'est pas commun ça', NULL, NULL, '2021-07-19 15:35:44', '2021-07-19 15:35:44'),
(5, 1, 'La danse des canards', 'On danse en canards', NULL, NULL, '2021-07-19 15:36:09', '2021-07-19 15:36:09'),
(6, 1, 'La danse des canards', 'On danse en canards', NULL, NULL, '2021-07-19 15:36:56', '2021-07-19 15:36:56'),
(7, 1, 'a', 'a', NULL, NULL, '2021-07-19 15:37:47', '2021-07-19 15:37:47'),
(8, 6, 'Go Pelicans, go !', 'En fait c\'est pas un concert mais une course. Bah ouai.', '2021-07-19', '2021-07-25', '2021-07-19 17:06:16', '2021-07-19 17:06:16');

-- --------------------------------------------------------

--
-- Structure de la table `event_registration`
--

CREATE TABLE `event_registration` (
  `id` int(11) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `event_registration`
--

INSERT INTO `event_registration` (`id`, `event_id`, `member_id`, `is_admin`) VALUES
(1, 4, 14, 1),
(2, 5, 14, 1),
(3, 6, 14, 1),
(4, 7, 14, 1),
(5, 8, 11, 1);

-- --------------------------------------------------------

--
-- Structure de la table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(50) NOT NULL,
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

INSERT INTO `groups` (`id`, `name`, `slug`, `description`, `picture`, `city`, `is_valid`, `created_at`, `updated_at`) VALUES
(1, 'Les chatons', 'les-chatons', 'top! vive les chatons', '/chatons-groupe.jpg', 'Grenoble', 1, '2021-07-06 15:04:53', '2021-07-06 15:04:53'),
(3, 'Les pélicans', 'les-pélicans', 'Un groupe pour chanter ensemble, toutes voix, c\'est fun avec un répertoire varié.', NULL, 'Toulouse', 1, '2021-07-06 15:31:36', '2021-07-06 15:31:36'),
(4, 'Les autruches', 'les-autruches', 'Un groupe pour chanter ensemble, toutes voix, c\'est fun avec un répertoire varié.', NULL, 'Toulouse', 0, '2021-07-06 15:34:08', '2021-07-06 15:34:08'),
(5, 'The chatons', 'the-chatons', 'We love the chatons ! C\'est vraiment super extra génial.', NULL, 'Versaille', 1, '2021-07-06 15:35:49', '2021-07-06 15:35:49'),
(6, 'The pelicans', 'the-pelicans', 'Un groupe pour chanter ensemble, toutes voix, c\'est fun avec un répertoire varié.', '1626357360_4373d914fe17e5e1029e.jpg', 'Toulouse', 1, '2021-07-06 15:37:15', '2021-07-06 15:37:15'),
(8, 'truc', 'truc', 'bidule', NULL, 'là', 0, '2021-07-07 12:53:16', '2021-07-07 12:53:16'),
(12, 'vbrt  sioln Dncdosl éà', 'vbrt-sioln-dncdosl-éà', 'bvjifdk,', NULL, 'vnbdkjf nlv,', 1, '2021-07-07 13:18:02', '2021-07-07 13:18:02'),
(13, '#Bidule', 'bidule', 'dbcsf hifoezj feozjf iozej kls lq ioez', NULL, 'Ici', 0, '2021-07-07 14:26:09', '2021-07-07 14:26:09'),
(14, 'éàèù$$µ&', 'éàèùµ', 'console.log(\'coucou\');', NULL, NULL, 1, '2021-07-07 15:57:03', '2021-07-07 15:57:03'),
(15, 'a', 'a', 'a', '1626356968_3928d02e5e9ef2753496.jpg', 'là', 1, '2021-07-15 13:41:18', '2021-07-15 13:41:18');

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
(1, 6, 11, 1, 1, 1),
(2, 1, 14, 1, 1, 1),
(3, 3, 10, 1, 1, 1),
(4, 4, 4, 1, 1, 1),
(5, 5, 11, 1, 1, 1),
(7, 8, 11, 1, 1, 1),
(11, 12, 14, 1, 1, 1),
(12, 13, 11, 1, 1, 1),
(13, 14, 11, 1, 1, 1),
(14, 15, 25, 1, 1, 1),
(17, 1, 11, NULL, NULL, 0),
(18, 6, 14, NULL, NULL, 0),
(21, 1, 19, NULL, NULL, 0),
(22, 1, 21, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Structure de la table `member`
--

CREATE TABLE `member` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(50) DEFAULT NULL,
  `is_super_admin` tinyint(1) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `is_email_valid` tinyint(4) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `picture` varchar(255) NOT NULL,
  `birth` date DEFAULT NULL,
  `gender` tinyint(4) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_access` datetime DEFAULT NULL,
  `cookie_str` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `member`
--

INSERT INTO `member` (`id`, `pseudo`, `is_super_admin`, `email`, `is_email_valid`, `password`, `name`, `first_name`, `picture`, `birth`, `gender`, `phone`, `created_at`, `updated_at`, `date_access`, `cookie_str`) VALUES
(4, 'fgbfdshuij', 0, 'bhgjdkomspk@njfi.cbsd', NULL, '$2y$10$3ILUAvQMZ/gxtfzHkmwFgesgOFcgIs9cWXgbhJK2mW5AhKu2ptV46', NULL, NULL, '', NULL, NULL, NULL, NULL, '2021-06-29 14:13:16', NULL, ''),
(10, 'testt', 0, 'test@test.test', NULL, '$2y$10$NDQSfmjzvp5MwJWx1uScLeXE4bRJaLITKCquib2MhAolvjwQFF9mK', NULL, NULL, '', NULL, NULL, NULL, NULL, '2021-06-30 17:34:35', NULL, ''),
(11, 'coco', 1, 'coco@coco.coco', NULL, '$2y$10$WmPT9K30DXeKNAFgl2fTbuq2R8LD4Gsew8Ntv4ZwR.nTzigojeWdm', 'B', 'Coralie', '1626357520_40bb8b18936c9f735603.jpg', '2021-07-01', 2, '0987654321', NULL, '2021-07-01 16:29:50', '2021-07-21 10:23:51', '6OU9ciiWB1NbuADQ6EJe8ZsH7w2VafptkFsdqFrdnhCBXTRm5eGHXDuJxwyvqlPg'),
(12, 'co', 0, 'co@coco.coco', NULL, '$2y$10$vzKqGJ7J99ukqmvrfCxoje8ItUYpbd2rr5bgeSTh2kIBhyE4tSwo6', NULL, NULL, '', NULL, NULL, NULL, NULL, '2021-07-01 16:31:46', NULL, ''),
(13, 'Lélé', 0, 'lele@lele.lele', NULL, '$2y$10$Y/tIe8AysF3WipDs8Zsf9.9DZppazb4kxvnJ9dCtOiKRoLJuCyt2e', NULL, NULL, '', NULL, NULL, NULL, NULL, '2021-07-02 13:33:44', NULL, ''),
(14, 'azerty', 0, 'azerty@bfi.dsfg', NULL, '$2y$10$jZqMXTHHk689.PT.l6EZ1e8FasbmoqhVdjFQDy9Lc/JrUvg6L28z.', 'Az', 'Erty', '', '2021-07-07', 2, '1234567890', NULL, '2021-07-02 15:50:03', '2021-07-21 10:19:00', ''),
(15, 'Autruche', NULL, 'autruche@aut.ruche', NULL, '$2y$10$Fok7/VH4BbNDW3QWnQsCReh6b4kjFxFJNwEkTj7JWN8B.WM/e.4qW', 'Aut', 'Ruche', '', '2021-04-28', 0, '', '2021-07-08 14:28:58', '2021-07-08 14:28:58', NULL, ''),
(16, 'xfghjk', NULL, 'bhdsjk@vnkjf.com', NULL, '$2y$10$bOB0a.MAy8lWvBbYc96Ziui2TMHLMB3gZm/QTZx8i/U.WFP/8bg8y', '', '', '', '2021-07-07', 0, '', '2021-07-13 07:38:15', '2021-07-13 07:38:15', NULL, ''),
(17, 'aqw', NULL, 'aqw@aqw.aw', NULL, '$2y$10$zNQI3p.9g0Ze1E0k3y2ZruWyrcI01UT/Sm2agh0gPkPlZdrjcPWS2', '', '', '', '2021-07-20', 0, '', '2021-07-15 09:32:23', '2021-07-15 09:32:23', NULL, ''),
(18, 'zsx', NULL, 'zsx@zsx.zsx', NULL, '$2y$10$d3vJQLstn0Z/zGxJ78/SSOKIH2heKFV6NFC8kPGv/ymsumlxTYKfa', '', '', '1626341641_13ee63c895bacf24ce4e.jpg', '2021-06-28', 0, '', '2021-07-15 09:34:01', '2021-07-15 09:34:01', NULL, ''),
(19, 'a', NULL, 'a@a.A', NULL, '$2y$10$0PE5U7BPN3wsoeoTD1Dyk.I7obDeUkJhy.rfhKBLwqTbQ/Gdp0u0S', '', '', '', '2021-07-06', 0, '', '2021-07-15 09:49:59', '2021-07-15 09:49:59', '2021-07-21 11:24:23', 'JAbVBC6zhIGjcZamHQXMLEeuYlotGx0qrkrJyD4nawRnPfhE52p14AN7zvlH05P6'),
(20, 'q', NULL, 'q@q.q', NULL, '$2y$10$KodDANjXzMfVmCtJqEPDBOiEcDPaLwboAowM12mO7pqxP7K4F2xfO', '', '', '1626342870_7bc33a7c7fd8d88910a1.jpg', '2021-07-06', 0, '', '2021-07-15 09:54:30', '2021-07-15 09:54:30', '2021-07-20 17:19:49', ''),
(21, 'w', NULL, 'w@w.w', NULL, '$2y$10$n3F9AKF7O3enBKdPNruz..vsZxDWtlwz/sVavKFrAoEjvata6ejh6', '', '', '1626343448_fe5b914974eddfa21257.jpg', '2021-07-09', 0, '', '2021-07-15 10:04:08', '2021-07-15 10:04:08', '2021-07-19 17:48:43', ''),
(22, 't', NULL, 't@t.t', NULL, '$2y$10$D4ZhOU4b383ZBZ5.8Y9mVuF58Yw34sIEhm7v6u4Obm2hzmf6oi1vi', 'T', '', '', '2021-07-03', 1, '', '2021-07-15 12:32:32', '2021-07-15 12:32:32', NULL, ''),
(23, 'd', NULL, 'd@d.d', NULL, '$2y$10$4rZYYnOaYgHxXVJAULdYl.NrRG9nUW3TvetQQIQZo02bd1KU3kqbK', '', '', '', '2021-07-12', 0, '', '2021-07-15 13:26:11', '2021-07-15 13:26:11', NULL, ''),
(24, 'e', NULL, 'e@e.e', NULL, '$2y$10$7VFIpepwTKlzbVpRpruqKudZYX9cgYukwS/emXyoFkDFJcvFtW93C', '', '', '', '2021-07-03', 0, '', '2021-07-15 13:28:43', '2021-07-15 13:28:43', NULL, ''),
(25, 'c', NULL, 'c@c.c', NULL, '$2y$10$MnQjElrn0LMPWFGJ./YuduDhYL0mpwdlfIoCcv8b.OngtN6CTdJAy', '', '', '1626355870_9d1949a069dbf11e6ffd.jpg', '2021-07-19', 0, '', '2021-07-15 13:30:16', '2021-07-15 13:30:16', NULL, ''),
(26, 'truc', NULL, 'truc@truc.truc', NULL, '$2y$10$CNJbmfOQ9pSIp8Dyfy28X.RM1LZIb.o6saICsjMao6aDEa8wrLDAC', '', '', '', '2021-07-29', 0, '', '2021-07-21 09:09:56', '2021-07-21 09:09:56', NULL, '');

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

-- --------------------------------------------------------

--
-- Structure de la table `request`
--

CREATE TABLE `request` (
  `id` int(11) NOT NULL,
  `message` text NOT NULL,
  `member_id` int(11) DEFAULT NULL,
  `sent_by_member` tinyint(1) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `date_id` int(11) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `request`
--

INSERT INTO `request` (`id`, `message`, `member_id`, `sent_by_member`, `group_id`, `event_id`, `date_id`, `admin_id`, `created_at`, `updated_at`) VALUES
(2, 'Volons ensemble ami.es Pélicans !', 14, 1, 6, NULL, NULL, NULL, '2021-07-16 14:08:08', '2021-07-16 14:08:08'),
(3, 'Je n\'ai rien compris', 19, 1, 14, NULL, NULL, NULL, '2021-07-16 14:40:38', '2021-07-16 14:40:38'),
(5, 'Oooooooooooh', 19, 1, 6, NULL, NULL, NULL, '2021-07-16 14:43:37', '2021-07-16 14:43:37'),
(6, 'a', 19, 1, NULL, 7, NULL, NULL, '2021-07-19 17:30:12', '2021-07-19 17:30:12'),
(8, 'a', 14, 1, NULL, 2, NULL, NULL, '2021-07-19 17:51:01', '2021-07-19 17:51:01'),
(9, 'yo', 11, 1, NULL, 4, NULL, NULL, '2021-07-20 10:49:23', '2021-07-20 10:49:23'),
(10, 'je m\'inscris', 14, 1, NULL, 1, NULL, NULL, '2021-07-20 11:04:07', '2021-07-20 11:04:07'),
(11, 'hello', 19, 1, NULL, 1, NULL, NULL, '2021-07-20 17:18:08', '2021-07-20 17:18:08'),
(12, 'poiuytrez', 11, 1, NULL, 1, NULL, NULL, '2021-07-20 17:24:56', '2021-07-20 17:24:56');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `date`
--
ALTER TABLE `date`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`);

--
-- Index pour la table `date_registration`
--
ALTER TABLE `date_registration`
  ADD PRIMARY KEY (`id`),
  ADD KEY `date_id` (`date_id`),
  ADD KEY `event_registration_id` (`event_registration_id`);

--
-- Index pour la table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_id` (`group_id`);

--
-- Index pour la table `event_registration`
--
ALTER TABLE `event_registration`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `member_id` (`member_id`);

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
-- Index pour la table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `date_id` (`date_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `date`
--
ALTER TABLE `date`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `date_registration`
--
ALTER TABLE `date_registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `event_registration`
--
ALTER TABLE `event_registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `group_member`
--
ALTER TABLE `group_member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `member`
--
ALTER TABLE `member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

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
-- AUTO_INCREMENT pour la table `request`
--
ALTER TABLE `request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `date`
--
ALTER TABLE `date`
  ADD CONSTRAINT `date_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`);

--
-- Contraintes pour la table `date_registration`
--
ALTER TABLE `date_registration`
  ADD CONSTRAINT `date_registration_ibfk_1` FOREIGN KEY (`date_id`) REFERENCES `date` (`id`),
  ADD CONSTRAINT `date_registration_ibfk_2` FOREIGN KEY (`event_registration_id`) REFERENCES `event_registration` (`id`);

--
-- Contraintes pour la table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`);

--
-- Contraintes pour la table `event_registration`
--
ALTER TABLE `event_registration`
  ADD CONSTRAINT `event_registration_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`),
  ADD CONSTRAINT `event_registration_ibfk_2` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`);

--
-- Contraintes pour la table `group_member`
--
ALTER TABLE `group_member`
  ADD CONSTRAINT `group_member_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`),
  ADD CONSTRAINT `group_member_ibfk_2` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`);

--
-- Contraintes pour la table `request`
--
ALTER TABLE `request`
  ADD CONSTRAINT `request_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`),
  ADD CONSTRAINT `request_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`),
  ADD CONSTRAINT `request_ibfk_3` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`),
  ADD CONSTRAINT `request_ibfk_4` FOREIGN KEY (`date_id`) REFERENCES `date` (`id`),
  ADD CONSTRAINT `request_ibfk_5` FOREIGN KEY (`admin_id`) REFERENCES `member` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
