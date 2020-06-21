-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 21. Jun 2020 um 16:16
-- Server-Version: 10.4.11-MariaDB
-- PHP-Version: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `recipes`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cooking_style`
--

CREATE TABLE `cooking_style` (
  `cooking_style_nr` int(10) UNSIGNED NOT NULL,
  `cooking_style_name` varchar(50) NOT NULL
) ENGINE=Aria DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `cooking_style`
--

INSERT INTO `cooking_style` (`cooking_style_nr`, `cooking_style_name`) VALUES
(1, 'paleo'),
(2, 'vegan'),
(3, 'vegetarian'),
(4, 'gourmet'),
(5, 'budget_cooking'),
(6, 'cooking_for_kids');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ingredient`
--

CREATE TABLE `ingredient` (
  `ingredient_nr` int(10) UNSIGNED NOT NULL,
  `ingredient_name` varchar(50) NOT NULL
) ENGINE=Aria DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `ingredient`
--

INSERT INTO `ingredient` (`ingredient_nr`, `ingredient_name`) VALUES
(1, 'water'),
(2, 'salt'),
(3, 'pasta'),
(4, 'milk'),
(5, 'shredded Cheddar cheese'),
(6, 'shredded Parmesan cheese'),
(7, 'ground black pepper'),
(8, 'Dijon mustard'),
(9, 'olive oil'),
(10, 'chicken breast'),
(11, 'sweet potato'),
(12, 'Irish whiskey'),
(13, 'minced fresh sage'),
(14, 'pear'),
(15, 'spinach'),
(16, 'hazelnuts');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `meal_type`
--

CREATE TABLE `meal_type` (
  `meal_type_nr` int(10) UNSIGNED NOT NULL,
  `meal_type_name` varchar(50) NOT NULL
) ENGINE=Aria DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `meal_type`
--

INSERT INTO `meal_type` (`meal_type_nr`, `meal_type_name`) VALUES
(1, 'starter'),
(2, 'main_course'),
(3, 'dessert');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `measurement`
--

CREATE TABLE `measurement` (
  `measurement_nr` int(10) UNSIGNED NOT NULL,
  `measurement_name` varchar(10) NOT NULL
) ENGINE=Aria DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `measurement`
--

INSERT INTO `measurement` (`measurement_nr`, `measurement_name`) VALUES
(1, 'oz'),
(2, 'cloves'),
(3, 'NULL'),
(4, 'lb'),
(5, 'g'),
(6, 'kg'),
(7, 'tbsp'),
(8, 'tsp'),
(9, 'cup'),
(10, 'bunch'),
(11, 'l'),
(12, 'ml'),
(13, 'pinch');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `recipes`
--

CREATE TABLE `recipes` (
  `recipe_nr` int(10) UNSIGNED NOT NULL,
  `title` varchar(50) NOT NULL,
  `instructions` text NOT NULL,
  `world_cuisine_fk` int(10) UNSIGNED NOT NULL,
  `cooking_style_fk` int(10) UNSIGNED NOT NULL,
  `meal_type_fk` int(10) UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL,
  `score` tinyint(1) UNSIGNED NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=Aria DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `recipes`
--

INSERT INTO `recipes` (`recipe_nr`, `title`, `instructions`, `world_cuisine_fk`, `cooking_style_fk`, `meal_type_fk`, `image`, `score`, `date`) VALUES
(1, 'Chicken Sweet Potato Skillet', ' Step 1\r\nHeat olive oil in a skillet over medium heat; cook and stir chicken in the hot oil until browned, 3 to 5 minutes. Remove chicken with a slotted spoon and place on a plate.\r\n\r\n Step 2\r\nCook and stir sweet potato in the same skillet over medium heat until slightly browned, 5 to 10 minutes; return chicken to the skillet. Add whiskey, sage, pear, and water; stir well. Partially cover skillet, lower heat to medium-low, and cook until chicken is no longer pink in the center and sweet potato is tender, about 10 minutes.\r\n\r\n Step 3\r\nRemove lid and sprinkle spinach over the chicken-sweet potato mixture; cook, stirring occasionally, until spinach is wilted, about 5 minutes. Stir in hazelnuts; season with salt and black pepper.', 7, 4, 2, '', 1, '2020-06-14 12:31:22'),
(2, 'Best One Pot Cheese and Macaroni', 'Step 1\r\nPour water and salt into a medium pot and bring to a rolling boil over high heat. Once the water is boiling, stir in the shell pasta, and return to a boil. Cook the pasta uncovered, stirring occasionally, until the water has cooked down a bit, about 5 minutes.\r\n\r\n Step 2\r\nStir in the milk, and continue boiling for another 5 minutes. Add the Cheddar, Parmesan, pepper, and mustard; stir until the cheese melts and the sauce is thick and creamy. The starch from the pasta thickens the sauce as the pasta cooks.', 7, 5, 2, '', 5, '2020-06-14 12:55:53');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `recipe_ingredients`
--

CREATE TABLE `recipe_ingredients` (
  `recipe_fk` int(11) NOT NULL,
  `ingredient_fk` int(11) NOT NULL,
  `measurement_fk` int(11) NOT NULL,
  `amount` decimal(10,2) UNSIGNED NOT NULL
) ENGINE=Aria DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `recipe_ingredients`
--

INSERT INTO `recipe_ingredients` (`recipe_fk`, `ingredient_fk`, `measurement_fk`, `amount`) VALUES
(1, 9, 7, '1.00'),
(1, 10, 3, '1.00'),
(1, 11, 3, '1.00'),
(1, 12, 7, '1.00'),
(1, 13, 7, '1.00'),
(1, 14, 3, '1.00'),
(1, 1, 9, '0.50'),
(1, 15, 9, '2.00'),
(1, 16, 9, '0.50'),
(1, 2, 13, '1.00'),
(2, 1, 9, '1.00'),
(2, 5, 9, '4.00'),
(2, 6, 9, '1.00'),
(2, 7, 8, '0.25'),
(2, 8, 8, '1.00'),
(2, 2, 8, '0.50'),
(2, 3, 1, '8.00'),
(2, 4, 9, '1.00');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
  `user_nr` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `login` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=Aria DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `watchlist`
--

CREATE TABLE `watchlist` (
  `user_fk` int(10) UNSIGNED NOT NULL,
  `recipe_fk` int(10) UNSIGNED NOT NULL
) ENGINE=Aria DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `world_cuisine`
--

CREATE TABLE `world_cuisine` (
  `world_cuisine_nr` int(10) UNSIGNED NOT NULL,
  `world_cuisine_name` varchar(50) NOT NULL
) ENGINE=Aria DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `world_cuisine`
--

INSERT INTO `world_cuisine` (`world_cuisine_nr`, `world_cuisine_name`) VALUES
(1, 'chinese'),
(2, 'mexican'),
(3, 'italian'),
(4, 'indian'),
(5, 'german'),
(6, 'french'),
(7, 'none');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `cooking_style`
--
ALTER TABLE `cooking_style`
  ADD PRIMARY KEY (`cooking_style_nr`);

--
-- Indizes für die Tabelle `ingredient`
--
ALTER TABLE `ingredient`
  ADD PRIMARY KEY (`ingredient_nr`);

--
-- Indizes für die Tabelle `meal_type`
--
ALTER TABLE `meal_type`
  ADD PRIMARY KEY (`meal_type_nr`);

--
-- Indizes für die Tabelle `measurement`
--
ALTER TABLE `measurement`
  ADD PRIMARY KEY (`measurement_nr`);

--
-- Indizes für die Tabelle `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`recipe_nr`),
  ADD KEY `world_cuisine_fk` (`world_cuisine_fk`),
  ADD KEY `cooking_style_fk` (`cooking_style_fk`),
  ADD KEY `meal_type_fk` (`meal_type_fk`),
  ADD KEY `world_cuisine_fk_2` (`world_cuisine_fk`),
  ADD KEY `world_cuisine_fk_3` (`world_cuisine_fk`);

--
-- Indizes für die Tabelle `recipe_ingredients`
--
ALTER TABLE `recipe_ingredients`
  ADD KEY `recipe_fk` (`recipe_fk`),
  ADD KEY `ingredient_fk` (`ingredient_fk`),
  ADD KEY `measurement_fk` (`measurement_fk`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_nr`),
  ADD UNIQUE KEY `login_name` (`login`),
  ADD KEY `email` (`email`);

--
-- Indizes für die Tabelle `watchlist`
--
ALTER TABLE `watchlist`
  ADD KEY `user_fk` (`user_fk`),
  ADD KEY `recipe_fk` (`recipe_fk`);

--
-- Indizes für die Tabelle `world_cuisine`
--
ALTER TABLE `world_cuisine`
  ADD PRIMARY KEY (`world_cuisine_nr`),
  ADD KEY `world_cuisine_name` (`world_cuisine_name`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `cooking_style`
--
ALTER TABLE `cooking_style`
  MODIFY `cooking_style_nr` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT für Tabelle `ingredient`
--
ALTER TABLE `ingredient`
  MODIFY `ingredient_nr` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT für Tabelle `meal_type`
--
ALTER TABLE `meal_type`
  MODIFY `meal_type_nr` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT für Tabelle `measurement`
--
ALTER TABLE `measurement`
  MODIFY `measurement_nr` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT für Tabelle `recipes`
--
ALTER TABLE `recipes`
  MODIFY `recipe_nr` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
  MODIFY `user_nr` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `world_cuisine`
--
ALTER TABLE `world_cuisine`
  MODIFY `world_cuisine_nr` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
