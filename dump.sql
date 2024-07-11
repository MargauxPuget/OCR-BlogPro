-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: db:3306
-- Generation Time: Jul 11, 2024 at 12:58 PM
-- Server version: 8.4.0
-- PHP Version: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `OCR_blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `id` int NOT NULL,
  `status` int NOT NULL COMMENT '-1: refus de publication, 0: en attendant en publication, 1: publié',
  `body` text NOT NULL,
  `user_id` int NOT NULL,
  `post_id` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id`, `status`, `body`, `user_id`, `post_id`, `created_at`, `updated_at`) VALUES
(142, 1, 'Certains artisants ont de l\'or dans les mains ! tellement ils font de belles choses <3', 98, 132, '2024-06-21 12:12:33', NULL),
(143, 1, 'Oui, c\'est une certitude.', 98, 132, '2024-06-21 12:13:06', NULL),
(144, 0, 'C\'est pas toujours facile de trouver un bon maçon !', 98, 133, '2024-06-21 12:13:41', NULL),
(146, 1, 'On en a trouvé un super qui à fait notre table de salon !!', 96, 130, '2024-06-21 12:17:57', NULL),
(147, 1, 'Nous sommes à la recherche d\'une personnes qui travail le métal ;)', 96, 132, '2024-06-21 12:18:30', NULL),
(151, -1, 'Il est nul votre site :(', 98, 132, '2024-06-21 12:29:48', NULL),
(152, 1, 'C\'est déliceux', 91, 135, '2024-06-28 09:13:05', NULL),
(153, 0, 'Mon papa est tapissier', 91, 134, '2024-06-28 09:13:33', NULL),
(154, -1, 'J\'en veux bien un !', 91, 135, '2024-06-28 09:33:05', NULL),
(155, 1, 'J\'adore les gâteaux!', 98, 135, '2024-07-11 08:50:19', NULL),
(156, 0, 'J\'ai un super nom a partager.', 98, 133, '2024-07-11 08:57:09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `id` int NOT NULL,
  `status` text NOT NULL,
  `title` varchar(128) NOT NULL,
  `image` text,
  `chapo` text NOT NULL,
  `body` text NOT NULL,
  `user_id` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `status`, `title`, `image`, `chapo`, `body`, `user_id`, `created_at`, `updated_at`) VALUES
(130, 'active', 'Ebeniste', '3543349.jpg', 'Un ebeniste traville le bois.', 'Un ebeniste traville le bois. Il peut fabriquer de nouveau meuble ou restaurer des pièces anciennes.', 98, '2024-06-21 11:27:13', NULL),
(131, 'active', 'Fleuriste', '6466e54c-d311-4a21-b303-c73b44c57a38.jpg', 'Artisant utilise les fleurs.', 'Un fleuriste est un artisan spécialisé dans la vente de fleurs et la confection de bouquets de fleurs et d\'assemblages appelés « compositions ».\r\n\r\nIl s\'approvisionne chez un horticulteur1 ou chez un grossiste2 ou même « au cadran » principalement aux Pays-Bas3. Il compose des bouquets et peut renseigner les clients sur les caractéristiques de chaque plante ou fleur.\r\n\r\nAutrefois, le nom des fleuristes était « bouquetières », car à l’époque on vendait des petits bouquets sur le marché. ', 98, '2024-06-21 11:31:17', '2024-06-21 11:31:51'),
(132, 'active', 'Artisant', NULL, 'Artistes qui utilisent ses mains pour créer des objets.', 'L’artisanat est la transformation de produits ou la mise en œuvre de services grâce à un savoir-faire particulier et hors contexte industriel de masse : l\'artisan assure en général tous les stades de sa transformation, de réparation ou de prestation de services, et leur commercialisation. C\'est aussi une identité individuelle et collective (appartenance à une catégorie de métiers plus ou moins créatifs et de professions généralement indépendantes)1. ', 98, '2024-06-21 11:45:15', '2024-06-21 11:56:37'),
(133, 'active', 'Maçon', 'trowel_195387.png', 'Le maçon peut construire les murs d\'un maison.', 'Le maçon est un ouvrier du bâtiment qui pratique la maçonnerie. Cette discipline consiste à créer, choisir et utiliser des éléments de construction composés de divers matériaux : pierre naturelle ou pierre artificielle (briques, blocs , etc.), mais aussi d\'autres matériaux : paille, torchis, terre, bois, métaux, béton, etc.', 98, '2024-06-21 11:59:10', '2024-06-21 12:01:34'),
(134, 'active', 'Tapissier', NULL, 'Les tapissiers sont des artisants en charge du mobiliers de maison tel que les sièges, canapés, lits, mais aussi rideau ou toile tendu (sur les murs où le plafond).', 'Le tapissier garnisseur est l\'artisan qui met en place la tapisserie d\'ameublement, réalise des garnitures et des couvertures de sièges ou tout autre meuble recouvert de tissu ou de cuir. ', 98, '2024-06-28 08:50:36', NULL),
(135, 'active', 'PatissierS', NULL, 'Spécialiste dans la fabrication des desserts où patisseries.', 'À partir du 19e siècle, le pâtissier est un artisan ou un ouvrier spécialisé dans la fabrication des pâtisseries. Dans le commerce de détail, le métier de pâtissier est souvent couplé à d\'autres activités proches : boulanger, chocolatier, confiseur, glacier, voire traiteur. ', 98, '2024-06-28 08:52:14', '2024-07-11 09:48:04'),
(136, 'archive', 'un test', NULL, 'chapô', 'article', 98, '2024-07-11 09:48:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `role` int DEFAULT '0' COMMENT '0= utilisateur, 1= admin',
  `firstname` text NOT NULL,
  `lastname` text NOT NULL,
  `picture` text,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `role`, `firstname`, `lastname`, `picture`, `email`, `password`, `created_at`, `updated_at`) VALUES
(91, 0, 'Mélanie', 'Puget', NULL, 'mel.pu@gmail.com', '2606ef19bb567028d8092cfab355b4cd', '2024-03-22 16:01:02', '2024-04-11 14:34:30'),
(95, 0, 'Jimmy', 'Vion', 'employe.png', 'jim.vi@gmail.com', '2606ef19bb567028d8092cfab355b4cd', '2024-04-11 14:46:24', NULL),
(96, 0, 'Louise', 'ter', 'femme.png', 'lou.ter@gmail.com', '2303c613982012d8de6ff26670e536aa', '2024-06-21 12:16:13', NULL),
(98, 1, 'Margaux', 'Puget', NULL, 'mar.pu@gmail.com', '2606ef19bb567028d8092cfab355b4cd', '2024-07-11 08:54:48', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
