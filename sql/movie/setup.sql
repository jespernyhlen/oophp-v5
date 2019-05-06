--
-- Setup for the article:
-- https://dbwebb.se/kunskap/kom-igang-med-php-pdo-och-mysql
--

--
-- Create the database with a testuser
--
-- CREATE DATABASE IF NOT EXISTS oophp;
-- GRANT ALL ON oophp.* TO user@localhost IDENTIFIED BY "pass";
-- USE oophp;

-- Ensure UTF8 as chacrter encoding within connection.
SET NAMES utf8;


--
-- Create table for my own movie database
--
DROP TABLE IF EXISTS `movie`;
CREATE TABLE `movie`
(
    `id` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `title` VARCHAR(100) NOT NULL,
    `director` VARCHAR(100),
    `length` INT DEFAULT NULL,            -- Length in minutes
    `year` INT NOT NULL DEFAULT 1900,
    `plot` TEXT,                          -- Short intro to the movie
    `image` VARCHAR(100) DEFAULT NULL,    -- Link to an image
    `subtext` CHAR(3) DEFAULT NULL,       -- swe, fin, en, etc
    `speech` CHAR(3) DEFAULT NULL,        -- swe, fin, en, etc
    `quality` CHAR(3) DEFAULT NULL,
    `format` CHAR(3) DEFAULT NULL         -- mp4, divx, etc
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;

DELETE FROM `movie`;
INSERT INTO `movie` (`title`, `year`, `image`) VALUES
    ('Pulp fiction', 1994, '.image/movie/pulp-fiction.jpg?w=270&h=180&cf'),
    ('American Pie', 1999, '.image/movie/american-pie.jpg?w=270&h=180&cf'),
    ('Pokémon The Movie 2000', 1999, '.image/movie/pokemon.jpg?w=270&h=180&cf'),
    ('Kopps', 2003, '.image/movie/kopps.jpg?w=270&h=180&cf'),
    ('From Dusk Till Dawn', 1996, '.image/movie/from-dusk-till-dawn.jpg?w=270&h=180&cf')
;

SELECT * FROM `movie`;
