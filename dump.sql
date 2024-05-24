-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : ven. 10 mai 2024 à 12:21
-- Version du serveur :  10.3.25-MariaDB-0ubuntu0.20.04.1
-- Version de PHP : 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `OCR-blog`
--

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `status` int(11) NOT NULL COMMENT '-1: refus de publication, 0: en attendant en publication, 1: publié',
  `body` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id`, `status`, `body`, `user_id`, `post_id`, `created_at`, `updated_at`) VALUES
(105, 1, 'commentaire de 91 rejeté', 92, 7, '2024-04-05 06:38:56', NULL),
(106, 1, 'commentaire de 91 en attente', 92, 8, '2024-04-05 06:38:56', NULL),
(107, -1, 'commentaire de 91 validé', 92, 8, '2024-04-05 06:38:56', NULL),
(108, 1, 'commentaire de 92 rejeté', 92, 7, '2024-04-05 06:38:59', NULL),
(109, -1, 'commentaire de 92 en attente', 92, 8, '2024-04-05 06:38:59', NULL),
(110, -1, 'commentaire de 92 validé', 92, 8, '2024-04-05 06:38:59', NULL),
(111, 1, 'un commentaire', 92, 7, '2024-04-11 14:05:14', NULL),
(112, -1, 'un commentaire', 92, 7, '2024-04-11 14:05:27', NULL),
(113, 1, 'un commentaire', 92, 7, '2024-04-11 14:06:31', NULL),
(114, 1, 'coucou', 92, 7, '2024-04-11 14:07:03', NULL),
(115, -1, 'coucou', 92, 7, '2024-04-11 14:11:32', NULL),
(116, 1, 'coucou', 92, 7, '2024-04-11 14:11:35', NULL),
(117, -1, 'coucou', 92, 7, '2024-04-11 14:11:41', NULL),
(118, 1, 'coucou', 92, 7, '2024-04-11 14:11:58', NULL),
(119, 1, 'coucou', 92, 7, '2024-04-11 14:12:03', NULL),
(120, 1, 'Heloo !!\r\n', 92, 7, '2024-04-11 14:12:09', NULL),
(121, 1, 'Mel comment\'', 91, 7, '2024-04-11 14:32:07', NULL),
(122, 1, 'uns second', 91, 7, '2024-04-11 14:33:36', NULL),
(123, -1, 'un troisième', 91, 7, '2024-04-11 14:33:47', NULL),
(124, 1, 'un comm', 92, 38, '2024-04-12 15:55:18', NULL),
(125, 1, 'coucou\r\n', 92, 38, '2024-04-12 16:08:19', NULL),
(126, 1, 'nouveauté', 92, 7, '2024-04-12 16:10:45', NULL),
(127, 1, 'dezef', 92, 7, '2024-04-12 16:13:22', NULL),
(128, 1, 'Hello', 92, 7, '2024-04-12 16:15:43', NULL),
(129, -1, 'test', 92, 7, '2024-04-12 16:20:46', NULL),
(130, -1, 'd', 92, 7, '2024-04-12 16:32:49', NULL),
(131, -1, 'd', 92, 7, '2024-04-12 16:33:06', NULL),
(132, -1, 'ss', 92, 7, '2024-04-12 16:33:16', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `status` varchar(128) NOT NULL DEFAULT 'active',
  `title` varchar(128) NOT NULL,
  `image` text DEFAULT NULL,
  `chapo` text NOT NULL,
  `body` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `post`
--

INSERT INTO `post` (`id`, `status`, `title`, `image`, `chapo`, `body`, `user_id`, `created_at`, `updated_at`) VALUES
(7, 'archive', 'Post du 8 février !!!!', 'employe.png', 'Cupcake ipsum dolor sit amet. Lemon drops croissant sesame snaps cookie jelly beans tootsie roll muffin. Liquorice liquorice fruitcake tiramisu sesame snaps sugar plum lollipop gummi bears cookie.', 'Cupcake ipsum dolor sit amet. Lemon drops croissant sesame snaps cookie jelly beans tootsie roll muffin. Liquorice liquorice fruitcake tiramisu sesame snaps sugar plum lollipop gummi bears cookie.\r\n\r\nSugar plum sugar plum pie I love gummi bears sweet roll bear claw. Jelly-o dessert cookie powder I love dessert wafer jelly-o candy. Danish ice cream dragée wafer topping topping icing chocolate chupa chups.\r\n\r\nSoufflé shortbread chupa chups lollipop carrot cake lollipop gingerbread. Chocolate cake topping caramels cupcake chocolate bar apple pie. Cotton candy pastry fruitcake shortbread jelly-o gummi bears. Icing fruitcake dragée pie cheesecake pastry.\r\n\r\nApple pie apple pie candy canes cookie I love tart. Candy canes muffin sweet roll jujubes tootsie roll. I love pudding jujubes bear claw pastry cupcake. Danish soufflé marshmallow chupa chups I love cookie apple pie.\r\n\r\nSoufflé marshmallow I love cheesecake bonbon. Toffee macaroon croissant macaroon sweet roll. Jelly brownie ice cream wafer sugar plum macaroon. Marzipan cake I love shortbread lollipop.', 2, '2024-02-08 11:02:32', '2024-02-09 16:28:11'),
(8, 'archive', 'titre 1', NULL, 'chapo 1', 'body 1', 91, '2024-03-07 15:10:18', NULL),
(37, 'active', 'Encore un', NULL, '', 'et oui !', 11, '2024-02-09 16:04:03', NULL),
(38, 'archive', 'coucou', NULL, '', 'teste encore !', 6, '2024-02-09 21:14:56', '2024-02-09 21:16:40'),
(40, 'archive', 'coucou', NULL, '', 'holalala', 1, '2024-02-09 21:15:37', '2024-02-09 21:16:58'),
(44, 'archive', 'titre 2 test supp', NULL, 'chapo 2', 'body 2', 1, '2024-03-07 15:10:18', NULL),
(45, 'archive', 'titre 1', NULL, 'chapo 1', 'body 1', 1, '2024-03-07 15:12:02', NULL),
(46, 'archive', 'titre 2', NULL, 'chapo 2', 'body 2', 1, '2024-03-07 15:12:02', NULL),
(47, 'archive', 'titre 3', NULL, 'chapo 3', 'body 3', 1, '2024-03-07 15:12:02', NULL),
(48, 'active', 'titre 4', NULL, 'chapo 4', 'body 4', 1, '2024-03-07 15:12:02', NULL),
(49, 'active', 'titre 5', NULL, 'chapo 5', 'body 5', 1, '2024-03-07 15:12:02', NULL),
(50, 'active', 'titre 6', NULL, 'chapo 6', 'body 6', 1, '2024-03-07 15:12:02', NULL),
(93, 'active', '', NULL, '', '', 92, '2024-05-10 10:21:04', NULL),
(94, 'active', '', NULL, '', '', 92, '2024-05-10 10:22:37', NULL),
(95, 'active', '', NULL, '', '', 92, '2024-05-10 10:23:02', NULL),
(96, 'active', 'Cette un poste ajouter', NULL, 'avecun chapo', 'et un article à lire ', 92, '2024-05-10 10:23:41', NULL),
(97, 'active', 'c\'est un post avec image', NULL, 'mais aussi un chapo', 'est biensure un article trés intéréssant à lire !', 92, '2024-05-10 10:25:40', NULL),
(98, 'archive', 'titre', NULL, 'chapo', 'descri', 92, '2024-05-10 11:11:50', NULL),
(109, 'active', 'et coucouc', 'article.png', 'dezfzg', 'sgrh', 92, '2024-05-10 11:24:28', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `role` int(11) DEFAULT 0 COMMENT '0= utilisateur, 1= admin',
  `firstname` text NOT NULL,
  `lastname` text NOT NULL,
  `picture` text DEFAULT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `role`, `firstname`, `lastname`, `picture`, `email`, `password`, `created_at`, `updated_at`) VALUES
(91, 0, 'Mélanie', 'Puget', NULL, 'mel.pu@gmail.com', '2606ef19bb567028d8092cfab355b4cd', '2024-03-22 16:01:02', '2024-04-11 14:34:30'),
(92, 1, 'Margaux', 'Puget', 'employe.png', 'mar.pu@gmail.com', '2606ef19bb567028d8092cfab355b4cd', '2024-03-22 16:01:38', '2024-04-12 09:53:57'),
(95, 0, 'Jimmy', 'Vion', 'employe.png', 'jim.vi@gmail.com', '2606ef19bb567028d8092cfab355b4cd', '2024-04-11 14:46:24', NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- AUTO_INCREMENT pour la table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
