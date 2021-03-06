-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 03, 2018 at 12:16 PM
-- Server version: 10.1.35-MariaDB
-- PHP Version: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `library`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `id_address` int(11) NOT NULL,
  `zip_code` int(11) NOT NULL,
  `street_address` varchar(255) COLLATE utf32_croatian_ci NOT NULL,
  `city` varchar(255) COLLATE utf32_croatian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_croatian_ci;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`id_address`, `zip_code`, `street_address`, `city`) VALUES
(1, 75000, 'Musala', 'Tuzla'),
(2, 75000, 'Husinskih rudara', 'Tuzla'),
(3, 76300, 'RaÄanska', 'Bijeljina'),
(4, 76300, 'MajeviÄka', 'Bijeljina'),
(28, 75000, 'Turalibegova', 'Tuzla'),
(29, 75000, 'Franjevačka', 'Tuzla'),
(30, 75000, 'Mije Kerosevica 20', 'Tuzla'),
(31, 11070, 'Omladinskih brigada 102', 'Novi Beograd'),
(32, 11070, '70 Zaplanjska', 'Beograd'),
(33, 11120, 'Dimitrija Tucovića 41', 'Beograd'),
(34, 11000, 'Resavska 33', 'Beograd');

-- --------------------------------------------------------

--
-- Table structure for table `author`
--

CREATE TABLE `author` (
  `id_author` int(11) NOT NULL,
  `firstname` varchar(255) COLLATE utf32_croatian_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf32_croatian_ci NOT NULL,
  `date_of_birth` date NOT NULL,
  `short_biography` text COLLATE utf32_croatian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_croatian_ci;

--
-- Dumping data for table `author`
--

INSERT INTO `author` (`id_author`, `firstname`, `lastname`, `date_of_birth`, `short_biography`) VALUES
(7, 'Viktor', 'Milardić', '1971-03-07', 'Currently he is with the Department of High Voltage and Power System of Faculty of Electrical Engineering and Computing, University of Zagreb. His main topics of research are surge protection, lightning  protection, grounding, electric traction, \r\nelectromagnetic compatibility and HV laboratory testing. '),
(12, 'Joanne', 'Rowling', '1965-07-31', 'Joanne Rowling, writing under the pen names J. K. Rowling and Robert Galbraith, is a British novelist, philanthropist, film producer, television producer and screenwriter, best known for writing the Harry Potter fantasy series.'),
(13, 'Jack', 'Thorne', '1978-12-06', 'Jack Thorne is an English screenwriter and playwright. '),
(14, 'John', 'Tiffany', '1971-06-27', 'John Richard Tiffany is an English theatre director. '),
(15, 'Agatha', 'Christie', '1890-09-15', 'Dame Agatha Mary Clarissa Christie was an English writer known for her 66 detective novels and 14 short story collections, particularly those revolving around her fictional detectives Hercule Poirot and Miss Marple.'),
(16, 'George', 'Martin', '1948-09-20', 'George Raymond Richard Martin, also known as GRRM, is an American novelist and short-story writer in the fantasy, horror, and science fiction genres, screenwriter, and television producer. He is best known for his series of epic fantasy novels, A Song of Ice and Fire, which was later adapted into the HBO series Game of Thrones.'),
(17, 'Amir', 'Tokić', '1970-06-09', 'Professor at Faculty of Electrical Engineering in Tuzla. Has expertise Industrial Engineering, Electronic Engineering and Electrical Engineering.');

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `id_book` int(11) NOT NULL,
  `book_title` varchar(255) COLLATE utf32_croatian_ci NOT NULL,
  `original_book_title` varchar(255) COLLATE utf32_croatian_ci NOT NULL,
  `id_category` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_croatian_ci;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`id_book`, `book_title`, `original_book_title`, `id_category`) VALUES
(9, 'Quality of electrical energy', 'Kvalitet elektri?ne energije', 7),
(10, 'Harry Potter and the Deathy Hallows', 'Harry Potter and the Deathy Hallows', 6),
(11, 'Harry Potter and the Cursed Child', 'Harry Potter and the Cursed Child', 6),
(12, 'Hallowe\'en Party', 'Hallowe\'en Party', 6),
(13, 'A Storm of Swords', 'A Storm of Swords', 6),
(14, 'A Game of Thrones', 'A Game of Thrones', 6);

-- --------------------------------------------------------

--
-- Table structure for table `book_author`
--

CREATE TABLE `book_author` (
  `id_book` int(11) NOT NULL,
  `id_author` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_croatian_ci;

--
-- Dumping data for table `book_author`
--

INSERT INTO `book_author` (`id_book`, `id_author`) VALUES
(9, 7),
(9, 17),
(10, 12),
(11, 12),
(11, 13),
(11, 14),
(12, 15),
(13, 16),
(14, 16);

-- --------------------------------------------------------

--
-- Table structure for table `book_copy`
--

CREATE TABLE `book_copy` (
  `id_book_copy` int(11) NOT NULL,
  `year_of_publication` year(4) NOT NULL,
  `number_of_pages` int(11) NOT NULL,
  `available` tinyint(11) NOT NULL,
  `id_book` int(11) NOT NULL,
  `id_publisher` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_croatian_ci;

--
-- Dumping data for table `book_copy`
--

INSERT INTO `book_copy` (`id_book_copy`, `year_of_publication`, `number_of_pages`, `available`, `id_book`, `id_publisher`) VALUES
(1, 2014, 973, 0, 13, 2),
(2, 2011, 206, 0, 12, 16),
(3, 2015, 319, 0, 9, 1),
(4, 2016, 320, 0, 11, 12),
(5, 2008, 640, 1, 10, 12),
(6, 2011, 694, 1, 14, 2);

-- --------------------------------------------------------

--
-- Table structure for table `book_genre`
--

CREATE TABLE `book_genre` (
  `id_book` int(11) NOT NULL,
  `id_genre` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_croatian_ci;

--
-- Dumping data for table `book_genre`
--

INSERT INTO `book_genre` (`id_book`, `id_genre`) VALUES
(10, 5),
(10, 10),
(11, 5),
(11, 10),
(12, 4),
(12, 7),
(13, 4),
(13, 5),
(13, 10),
(14, 4),
(14, 5),
(14, 10);

-- --------------------------------------------------------

--
-- Table structure for table `book_lend`
--

CREATE TABLE `book_lend` (
  `id_lend` int(11) NOT NULL,
  `lend_date` date NOT NULL,
  `return_date` date NOT NULL,
  `approved` tinyint(4) NOT NULL,
  `id_book_copy` int(11) NOT NULL,
  `id_member` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_croatian_ci;

--
-- Dumping data for table `book_lend`
--

INSERT INTO `book_lend` (`id_lend`, `lend_date`, `return_date`, `approved`, `id_book_copy`, `id_member`) VALUES
(23, '2018-10-02', '2018-10-16', 1, 1, 1),
(24, '2018-10-02', '2018-10-16', 1, 2, 8),
(25, '2018-10-02', '2018-10-16', 0, 3, 8),
(26, '2018-10-03', '2018-10-17', 0, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id_category` int(11) NOT NULL,
  `category_title` varchar(255) COLLATE utf32_croatian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_croatian_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id_category`, `category_title`) VALUES
(1, 'Encyclopedia'),
(2, 'Journal'),
(3, 'Newspaper'),
(4, 'Article'),
(5, 'Scientific paper'),
(6, 'Novel'),
(7, 'School book'),
(8, 'Novelette');

-- --------------------------------------------------------

--
-- Table structure for table `genre`
--

CREATE TABLE `genre` (
  `id_genre` int(11) NOT NULL,
  `genre_title` varchar(255) COLLATE utf32_croatian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_croatian_ci;

--
-- Dumping data for table `genre`
--

INSERT INTO `genre` (`id_genre`, `genre_title`) VALUES
(1, 'Horror'),
(2, 'Comedy'),
(4, 'Drama'),
(5, 'Science fiction'),
(6, 'Action'),
(7, 'Mystery'),
(9, 'Tragedy'),
(10, 'Fantasy'),
(11, 'Satire');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `id_member` int(11) NOT NULL,
  `member_phone` varchar(255) COLLATE utf32_croatian_ci NOT NULL,
  `member_mobile` varchar(255) COLLATE utf32_croatian_ci NOT NULL,
  `member_from` date NOT NULL,
  `member_to` date NOT NULL,
  `penality_points` int(11) NOT NULL,
  `notes` text COLLATE utf32_croatian_ci NOT NULL,
  `id_address` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_croatian_ci;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`id_member`, `member_phone`, `member_mobile`, `member_from`, `member_to`, `penality_points`, `notes`, `id_address`, `id_user`) VALUES
(1, '055/258-742', '065/858-964', '2017-11-10', '2019-11-10', 1, 'notes', 1, 4),
(8, '055/667-854', '065/854-987', '2018-10-02', '2019-10-02', 0, 'note', 4, 5),
(9, '035/253-150', '062/124-854', '2018-10-03', '2019-10-03', 0, '', 29, 6),
(10, '035/258-587', '061/857-965', '2018-10-03', '2019-10-03', 0, '', 2, 7);

-- --------------------------------------------------------

--
-- Table structure for table `publisher`
--

CREATE TABLE `publisher` (
  `id_publisher` int(11) NOT NULL,
  `publisher_name` varchar(255) COLLATE utf32_croatian_ci NOT NULL,
  `id_address` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_croatian_ci;

--
-- Dumping data for table `publisher`
--

INSERT INTO `publisher` (`id_publisher`, `publisher_name`, `id_address`) VALUES
(1, 'PrintCom', 30),
(2, 'Laguna', 34),
(12, 'Evro-book', 33),
(13, 'Carobna knjiga', 32),
(16, 'Mladinska knjiga', 31);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id_role` int(11) NOT NULL,
  `role_title` varchar(255) COLLATE utf32_croatian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_croatian_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id_role`, `role_title`) VALUES
(1, 'administrator'),
(2, 'librarian'),
(3, 'user');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `firstname` varchar(255) COLLATE utf32_croatian_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf32_croatian_ci NOT NULL,
  `date_of_birth` date NOT NULL,
  `e_mail` varchar(50) COLLATE utf32_croatian_ci NOT NULL,
  `username` varchar(20) COLLATE utf32_croatian_ci NOT NULL,
  `password` varchar(255) COLLATE utf32_croatian_ci NOT NULL,
  `approval` tinyint(4) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `id_role` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_croatian_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `firstname`, `lastname`, `date_of_birth`, `e_mail`, `username`, `password`, `approval`, `status`, `id_role`) VALUES
(1, 'Logan', 'Hammel', '1988-10-11', 'logan.h88@mail.com', 'admin', '$2y$10$.Fznhy92sSi8DsGa5qNHHOqI6KiVbEhDYXUp.EsDexR7uHP0QOBbq', 1, 1, 1),
(2, 'Stephen', 'Fullmer', '1990-09-03', 'steve.fm@mail.com', 'librarian', '$2y$10$.Fznhy92sSi8DsGa5qNHHOqI6KiVbEhDYXUp.EsDexR7uHP0QOBbq', 1, 1, 2),
(4, 'Nancy', 'Eldermann', '1979-09-05', 'nan.el@mail.com', 'user', '$2y$10$PQAn9MA24.FHgQSlBscHKOARal2RnxZcwSpqTWESSciD4dSxhpN32', 1, 1, 3),
(5, 'Norman', 'Lockley', '1980-09-03', 'norman.el80@mail.com', 'norm80', '$2y$10$RD8Lm7Ca9IHWZhD2abEP5eyXQsTb4Yr8baIcEht57XAAbNvj8R1mu', 1, 1, 3),
(6, 'Angelica', 'Metzer', '1991-05-06', 'angie91@mail.com', 'angie91', '$2y$10$P6FlBC3ENxnbdZT5wjEpuOC0.r0/dYHI08iTa.vm/XjXpX9eQz29q', 1, 1, 3),
(7, 'Maude', 'Pontes', '1984-01-13', 'maud84@mail.com', 'mpont84', '$2y$10$.Fznhy92sSi8DsGa5qNHHOqI6KiVbEhDYXUp.EsDexR7uHP0QOBbq', 1, 1, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id_address`);

--
-- Indexes for table `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`id_author`);

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`id_book`),
  ADD KEY `id_category` (`id_category`);

--
-- Indexes for table `book_author`
--
ALTER TABLE `book_author`
  ADD PRIMARY KEY (`id_book`,`id_author`),
  ADD KEY `book_author_ibfk_2` (`id_author`),
  ADD KEY `id_book` (`id_book`);

--
-- Indexes for table `book_copy`
--
ALTER TABLE `book_copy`
  ADD PRIMARY KEY (`id_book_copy`),
  ADD KEY `id_book` (`id_book`),
  ADD KEY `id_publisher` (`id_publisher`);

--
-- Indexes for table `book_genre`
--
ALTER TABLE `book_genre`
  ADD PRIMARY KEY (`id_book`,`id_genre`),
  ADD KEY `book_genre_ibfk_2` (`id_genre`);

--
-- Indexes for table `book_lend`
--
ALTER TABLE `book_lend`
  ADD PRIMARY KEY (`id_lend`),
  ADD KEY `book_lend_ibfk_1` (`id_book_copy`),
  ADD KEY `book_lend_ibfk_2` (`id_member`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id_category`);

--
-- Indexes for table `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`id_genre`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id_member`),
  ADD KEY `id_address` (`id_address`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `publisher`
--
ALTER TABLE `publisher`
  ADD PRIMARY KEY (`id_publisher`),
  ADD KEY `id_address` (`id_address`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id_role`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `e_mail` (`e_mail`),
  ADD KEY `id_role` (`id_role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `id_address` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `author`
--
ALTER TABLE `author`
  MODIFY `id_author` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `id_book` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `book_copy`
--
ALTER TABLE `book_copy`
  MODIFY `id_book_copy` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `book_lend`
--
ALTER TABLE `book_lend`
  MODIFY `id_lend` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `genre`
--
ALTER TABLE `genre`
  MODIFY `id_genre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `id_member` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `publisher`
--
ALTER TABLE `publisher`
  MODIFY `id_publisher` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `book`
--
ALTER TABLE `book`
  ADD CONSTRAINT `book_ibfk_1` FOREIGN KEY (`id_category`) REFERENCES `category` (`id_category`) ON UPDATE CASCADE;

--
-- Constraints for table `book_author`
--
ALTER TABLE `book_author`
  ADD CONSTRAINT `book_author_ibfk_1` FOREIGN KEY (`id_book`) REFERENCES `book` (`id_book`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `book_author_ibfk_2` FOREIGN KEY (`id_author`) REFERENCES `author` (`id_author`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `book_copy`
--
ALTER TABLE `book_copy`
  ADD CONSTRAINT `book_copy_ibfk_1` FOREIGN KEY (`id_book`) REFERENCES `book` (`id_book`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `book_copy_ibfk_2` FOREIGN KEY (`id_publisher`) REFERENCES `publisher` (`id_publisher`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `book_genre`
--
ALTER TABLE `book_genre`
  ADD CONSTRAINT `book_genre_ibfk_1` FOREIGN KEY (`id_book`) REFERENCES `book` (`id_book`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `book_genre_ibfk_2` FOREIGN KEY (`id_genre`) REFERENCES `genre` (`id_genre`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `book_lend`
--
ALTER TABLE `book_lend`
  ADD CONSTRAINT `book_lend_ibfk_1` FOREIGN KEY (`id_book_copy`) REFERENCES `book_copy` (`id_book_copy`) ON UPDATE CASCADE,
  ADD CONSTRAINT `book_lend_ibfk_2` FOREIGN KEY (`id_member`) REFERENCES `member` (`id_member`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `member`
--
ALTER TABLE `member`
  ADD CONSTRAINT `member_ibfk_1` FOREIGN KEY (`id_address`) REFERENCES `address` (`id_address`) ON UPDATE CASCADE,
  ADD CONSTRAINT `member_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `publisher`
--
ALTER TABLE `publisher`
  ADD CONSTRAINT `publisher_ibfk_1` FOREIGN KEY (`id_address`) REFERENCES `address` (`id_address`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_role_fk` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
