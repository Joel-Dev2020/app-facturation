-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 02 jan. 2025 à 20:49
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `facturation2025`
--

-- --------------------------------------------------------

--
-- Structure de la table `devises`
--

CREATE TABLE `devises` (
  `id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `currency_code` varchar(10) DEFAULT NULL,
  `currency_name` varchar(30) NOT NULL,
  `left_symbol` varchar(12) DEFAULT NULL,
  `right_symbol` varchar(12) DEFAULT NULL,
  `decimal_symbol` varchar(1) DEFAULT NULL,
  `decimal_place` int(11) DEFAULT NULL,
  `thousands_separator` varchar(1) DEFAULT NULL,
  `exchanged_value` double DEFAULT NULL,
  `codeiso` int(11) DEFAULT NULL,
  `lang` varchar(255) DEFAULT NULL,
  `lang_code` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `is_active` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext NOT NULL,
  `headers` longtext NOT NULL,
  `queue_name` varchar(190) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `notifications`
--

CREATE TABLE `notifications` (
  `id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `content` longtext NOT NULL,
  `action` varchar(30) NOT NULL DEFAULT 'add',
  `channel` varchar(30) NOT NULL,
  `read_at` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `parametres`
--

CREATE TABLE `parametres` (
  `id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `filename` varchar(255) DEFAULT NULL,
  `filename2` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `parametres`
--

INSERT INTO `parametres` (`id`, `filename`, `filename2`, `icon`, `created_at`, `updated_at`) VALUES
(0x36313932393130372d633533392d3131, NULL, NULL, NULL, '2024-12-28 16:21:18', '2024-12-28 16:21:18');

-- --------------------------------------------------------

--
-- Structure de la table `reglages`
--

CREATE TABLE `reglages` (
  `id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `name` varchar(255) NOT NULL,
  `label` varchar(255) NOT NULL,
  `value` longtext DEFAULT NULL,
  `type` longtext NOT NULL,
  `created_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `reglages`
--

INSERT INTO `reglages` (`id`, `name`, `label`, `value`, `type`, `created_at`, `updated_at`) VALUES
(0x30313934306531362d366539612d3734, 'app_title', 'Raison sociale', 'INVOICES', 'Symfony\\Component\\Form\\Extension\\Core\\Type\\TextType', NULL, NULL),
(0x30313934306531382d633434612d3733, 'app_phone', 'Téléphone', '+2250778397063', 'Symfony\\Component\\Form\\Extension\\Core\\Type\\TextType', NULL, NULL),
(0x30313934306531382d653134392d3762, 'app_email', 'Email', 'dev@web-symphonie.com', 'Symfony\\Component\\Form\\Extension\\Core\\Type\\TextType', NULL, '2024-07-29 23:53:30'),
(0x30313934306531382d666366612d3737, 'app_address', 'Adresse', 'Abidjan - Côte d\'Ivoire', 'Symfony\\Component\\Form\\Extension\\Core\\Type\\TextType', NULL, NULL),
(0x30313934306531392d316166622d3762, 'app_paginate_limit', 'Pagination par page', '10', 'Symfony\\Component\\Form\\Extension\\Core\\Type\\IntegerType', NULL, NULL),
(0x30313934306531392d333962662d3762, 'app_code_postal', 'Code postal', 'BP 000 ABIDJAN 00', 'Symfony\\Component\\Form\\Extension\\Core\\Type\\TextType', NULL, '2024-11-09 17:44:08'),
(0x30313934306531392d393166612d3737, 'app_compte_contribuable', 'Compte contribuable (cc)', 'CC 1947713 S', 'Symfony\\Component\\Form\\Extension\\Core\\Type\\TextType', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `rememberme_token`
--

CREATE TABLE `rememberme_token` (
  `series` varchar(88) NOT NULL,
  `value` varchar(88) NOT NULL,
  `lastUsed` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `class` varchar(100) NOT NULL,
  `username` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `name` varchar(255) NOT NULL,
  `email` varchar(180) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `address` longtext DEFAULT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT '(DC2Type:json)' CHECK (json_valid(`roles`)),
  `password` varchar(255) NOT NULL,
  `enabled` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `organization` varchar(255) DEFAULT NULL,
  `owner_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `is_free` tinyint(1) DEFAULT 0,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `password_reset_requested_at` datetime DEFAULT NULL,
  `password_reset_expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `phone`, `address`, `roles`, `password`, `enabled`, `created_at`, `updated_at`, `organization`, `owner_id`, `is_free`, `password_reset_token`, `password_reset_requested_at`, `password_reset_expires_at`) VALUES
(0x0194170cd7ef726e89b572265347ee8a, 'Koffi Tchimou Joel', 'dev@web-symphonie.com', '0778397063', 'Cocody - Riviéra Anono', '[\"ROLE_SUPER_ADMIN\"]', '$2y$13$qAEcJ9LsLZIwp/y6vxwtcuo/CuFVm3glT/H9BuZVKBa5TJbWijlP2', 1, '2024-12-30 11:11:45', '2025-01-02 20:47:57', 'Web Symphonie', NULL, 0, NULL, '2025-01-02 20:46:45', NULL),
(0x01942748efc177b08395fc451764b844, 'Divine ornella', 'divineornella@gmail.com', '0504759502', 'Cocody', '[\"ROLE_ADMIN\"]', '$2y$13$JbU5HZcxAzuhW3huFhUG7ejXoa6sPuCPKzPdxhrw3/At4n9fDfL0G', 1, '2025-01-02 14:51:18', '2025-01-02 14:51:18', 'Divine Corporation', NULL, 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `user_reglages`
--

CREATE TABLE `user_reglages` (
  `id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `user_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `devises_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `tva` int(11) DEFAULT 0,
  `is_discount` tinyint(1) DEFAULT 1,
  `prefix_numero_invoice` varchar(4) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `devises`
--
ALTER TABLE `devises`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Index pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `parametres`
--
ALTER TABLE `parametres`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `reglages`
--
ALTER TABLE `reglages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_46E7DCF5E237E06` (`name`);

--
-- Index pour la table `rememberme_token`
--
ALTER TABLE `rememberme_token`
  ADD PRIMARY KEY (`series`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`),
  ADD KEY `idx_name` (`name`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `IDX_8D93D6497E3C61F9` (`owner_id`);

--
-- Index pour la table `user_reglages`
--
ALTER TABLE `user_reglages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_E4E399CF33C959A1` (`prefix_numero_invoice`),
  ADD UNIQUE KEY `UNIQ_E4E399CFA76ED395` (`user_id`),
  ADD KEY `IDX_E4E399CF658D0DB4` (`devises_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_8D93D6497E3C61F9` FOREIGN KEY (`owner_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `user_reglages`
--
ALTER TABLE `user_reglages`
  ADD CONSTRAINT `FK_E4E399CF658D0DB4` FOREIGN KEY (`devises_id`) REFERENCES `devises` (`id`),
  ADD CONSTRAINT `FK_E4E399CFA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
