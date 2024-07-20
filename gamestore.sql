-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : sam. 20 juil. 2024 à 13:18
-- Version du serveur : 5.7.24
-- Version de PHP : 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gamestore`
--

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

CREATE TABLE `commandes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_commande` datetime DEFAULT CURRENT_TIMESTAMP,
  `total` decimal(10,2) NOT NULL,
  `statut` varchar(50) NOT NULL DEFAULT 'en_attente',
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `commandes`
--

INSERT INTO `commandes` (`id`, `user_id`, `date_commande`, `total`, `statut`, `nom`, `prenom`) VALUES
(1, 1, '2024-06-10 12:59:35', '0.00', 'livré', NULL, NULL),
(2, 1, '2024-06-10 14:59:50', '240.00', 'livré', NULL, NULL),
(3, 1, '2024-06-10 13:00:16', '0.00', 'livré', NULL, NULL),
(4, 1, '2024-06-21 15:16:39', '120.00', 'livré', NULL, NULL),
(5, 1, '2024-06-21 15:19:30', '0.00', 'en_attente', NULL, NULL),
(6, 1, '2024-06-21 15:19:51', '120.00', 'en_attente', NULL, NULL),
(7, 1, '2024-06-25 14:36:39', '120.00', 'livré', NULL, NULL),
(8, 1, '2024-06-25 14:36:55', '120.00', 'livré', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `commande_details`
--

CREATE TABLE `commande_details` (
  `id` int(11) NOT NULL,
  `commande_id` int(11) NOT NULL,
  `jeu_id` int(11) NOT NULL,
  `quantite` int(11) NOT NULL,
  `prix` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `commande_details`
--

INSERT INTO `commande_details` (`id`, `commande_id`, `jeu_id`, `quantite`, `prix`) VALUES
(1, 2, 1, 2, '120.00'),
(2, 4, 1, 1, '120.00'),
(3, 6, 1, 1, '120.00'),
(4, 7, 1, 1, '120.00'),
(5, 8, 1, 1, '120.00');

-- --------------------------------------------------------

--
-- Structure de la table `jeux_video`
--

CREATE TABLE `jeux_video` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `pegi` text NOT NULL,
  `genre` text NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `quantite` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `jeux_video`
--

INSERT INTO `jeux_video` (`id`, `libelle`, `description`, `pegi`, `genre`, `prix`, `quantite`, `image`) VALUES
(1, 'ARK', 'ce jeux est consui que pour vous ', 'Action ', 'action', '120.00', 391, 'images/Ark.webp'),
(2, 'Angry Brid', 'Angry Birds est un jeu mobile où le joueur utilise une fronde pour lancer des oiseaux aux capacités spéciales afin de détruire des structures et éliminer des cochons verts qui ont volé leurs œufs.', ' puzzle', 'puzzle', '20.00', 12, 'uploads/angry-birds.jpg'),
(3, 'FIFA 2024', 'Pour les fans de foot, FIFA 2024 vous offre une expérience inoubliable.', 'football', 'football', '50.00', 78, 'uploads/FIFA.jpg'),
(4, 'CSGO', 'Counter-Strike: Global Offensive est un jeu de tir à la première personne compétitif ', 'action', 'actio', '120.00', 300, 'uploads/csgo.jpg'),
(5, 'Jeux de voiture', 'Vous aimez conduire alle en y va !!!!', 'voiture', 'voiture', '30.00', 122, 'uploads/voiture.jpeg'),
(6, 'Jeux educatif ', 'On apprend tout en s\'amusant.', 'educatif', 'educatif', '32.00', 12, 'uploads/jeux educatif.png'),
(7, 'Jeux de fille', 'Coiffez, maquillez, changez de look avec ce jeu, spécialement pour vous.\r\n\r\n\r\n\r\n\r\n\r\n\r\n', 'jeux de fille', 'jeux de fille', '12.00', 21, 'uploads/téléchargement.jpeg'),
(8, 'jeux princesses', 'jeux princesses', 'jeux de fille', 'jeux de fille', '15.00', 21, 'uploads/jeux de fille.jpeg'),
(9, 'Jeux d \'aventure', 'aventure pine', 'aventure', 'aventure', '13.00', 14, 'uploads/aventure pine.png');

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--

CREATE TABLE `panier` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `jeu_id` int(11) NOT NULL,
  `quantite` int(11) DEFAULT '1',
  `agence` text NOT NULL,
  `date_de_retrait` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `panier`
--

INSERT INTO `panier` (`id`, `user_id`, `jeu_id`, `quantite`, `agence`, `date_de_retrait`) VALUES
(8, 1, 1, 1, 'Default Agency', '2024-06-25');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `adresse_postale` text NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `nom`, `prenom`, `email`, `adresse_postale`, `mot_de_passe`) VALUES
(1, 'sasa', 'sasa', 'sasa@gmail.com', '11 chemin de 14 ', '$2y$10$Ar.YgGSdDaenowlkOUDBpugxEdoUCVQ63Jg.NEqcdqfN5luMOEpRm'),
(10, 'sasa', 'sasa', 'dahoufatma@gmail.com', '11 chemin de 14 ', '$2y$10$HTAz.2Te.VfyiHl6q1/zde27y8P6MmXtVxyGq9OMaB1QpqYrdPprW'),
(19, 'sasa', 'lala', 'gewejok820@atebin.com', '15 Allée Beethoven', '$2y$10$FrHUHWVF/4d7hS/OuzcP5OA8BtkVXKeLuOMmRAWHb16FCrSGw1Foa');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `role` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `pseudo`, `mail`, `mot_de_passe`, `role`) VALUES
(4, 'sasa', 'sasa@gmail.com', '$2y$10$QwmYFQwuolN8npBBXSc2nubqU/mDZv.dfYQy2Uq/JkDCESVJUsrwO', 'producteur'),
(5, 'kaka', 'kaka@gmail.com', '$2y$10$tvUlhSu9lXJNokjo2liQ5Ooi7ShVrXTxwXDHLLfM3jG9WDPtNtSJe', 'producteur');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `commande_details`
--
ALTER TABLE `commande_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `commande_id` (`commande_id`),
  ADD KEY `jeu_id` (`jeu_id`);

--
-- Index pour la table `jeux_video`
--
ALTER TABLE `jeux_video`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `panier`
--
ALTER TABLE `panier`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `jeu_id` (`jeu_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `commandes`
--
ALTER TABLE `commandes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `commande_details`
--
ALTER TABLE `commande_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `jeux_video`
--
ALTER TABLE `jeux_video`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `panier`
--
ALTER TABLE `panier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD CONSTRAINT `commandes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `commande_details`
--
ALTER TABLE `commande_details`
  ADD CONSTRAINT `commande_details_ibfk_1` FOREIGN KEY (`commande_id`) REFERENCES `commandes` (`id`),
  ADD CONSTRAINT `commande_details_ibfk_2` FOREIGN KEY (`jeu_id`) REFERENCES `jeux_video` (`id`);

--
-- Contraintes pour la table `panier`
--
ALTER TABLE `panier`
  ADD CONSTRAINT `panier_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `panier_ibfk_2` FOREIGN KEY (`jeu_id`) REFERENCES `jeux_video` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
