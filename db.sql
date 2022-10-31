-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 31, 2022 at 03:35 PM
-- Server version: 10.5.15-MariaDB-0+deb11u1
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `WS301022_wad`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_announcements`
--

CREATE TABLE `tbl_announcements` (
  `AID` int(11) NOT NULL,
  `UID` int(11) NOT NULL,
  `Time` timestamp NOT NULL DEFAULT current_timestamp(),
  `Details` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_announcements`
--

INSERT INTO `tbl_announcements` (`AID`, `UID`, `Time`, `Details`) VALUES
(1, 1, '2021-11-12 10:19:05', '<script type=\"text/javascript\">window.location.href = \"https://jackkimmins.com/\";</script>');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_courses`
--

CREATE TABLE `tbl_courses` (
  `CID` int(11) NOT NULL,
  `Course Name` varchar(48) NOT NULL,
  `Course Details` mediumtext NOT NULL,
  `Course Lecturer` varchar(64) NOT NULL,
  `Course Start` date NOT NULL,
  `Course Finish` date NOT NULL,
  `Max Attendees` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_courses`
--

INSERT INTO `tbl_courses` (`CID`, `Course Name`, `Course Details`, `Course Lecturer`, `Course Start`, `Course Finish`, `Max Attendees`) VALUES
(11, 'Level 2 Computing', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed blandit mattis congue. Vestibulum blandit consequat leo. Suspendisse in imperdiet nunc. Vestibulum aliquet quis orci at porta. Proin faucibus leo id ex scelerisque vehicula. Duis cursus magna eu ultrices lacinia. Proin vel varius massa. Suspendisse et tincidunt nisl.', 'Jason', '2022-02-10', '2024-08-14', 18),
(15, 'Level 3 Computing', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed blandit mattis congue. Vestibulum blandit consequat leo. Suspendisse in imperdiet nunc. Vestibulum aliquet quis orci at porta. Proin faucibus leo id ex scelerisque vehicula. Duis cursus magna eu ultrices lacinia. Proin vel varius massa. Suspendisse et tincidunt nisl.', 'Jason', '2022-01-06', '2024-08-14', 2),
(17, 'Level 3 Computing', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed blandit mattis congue. Vestibulum blandit consequat leo. Suspendisse in imperdiet nunc. Vestibulum aliquet quis orci at porta. Proin faucibus leo id ex scelerisque vehicula. Duis cursus magna eu ultrices lacinia. Proin vel varius massa. Suspendisse et tincidunt nisl.', 'Jason', '2022-03-24', '2024-08-14', 2),
(18, 'Level 1 Animal Care', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed blandit mattis congue. Vestibulum blandit consequat leo. Suspendisse in imperdiet nunc. Vestibulum aliquet quis orci at porta. Proin faucibus leo id ex scelerisque vehicula. Duis cursus magna eu ultrices lacinia. Proin vel varius massa. Suspendisse et tincidunt nisl.', 'Jason', '2022-08-14', '2024-08-14', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_course_attendees`
--

CREATE TABLE `tbl_course_attendees` (
  `CID` int(11) NOT NULL,
  `UID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_course_attendees`
--

INSERT INTO `tbl_course_attendees` (`CID`, `UID`) VALUES
(17, 1),
(18, 52);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `UID` int(11) NOT NULL,
  `Email` varchar(64) NOT NULL,
  `First Name` varchar(32) NOT NULL,
  `Last Name` varchar(32) NOT NULL,
  `Job Title` varchar(32) NOT NULL,
  `Password` varchar(128) NOT NULL,
  `MemorableInfo` varchar(128) NOT NULL,
  `Usergroup` varchar(16) NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`UID`, `Email`, `First Name`, `Last Name`, `Job Title`, `Password`, `MemorableInfo`, `Usergroup`, `Timestamp`) VALUES
(1, 'rypwhite@protonmail.com', 'Ryan', 'White', 'Admin', '$2y$10$q7r2UiNoTCB1OqI6ucApQ.QQ12bKEMvJAbdyberoYvFC4ZnwayMzG', '$2y$10$q7r2UiNoTCB1OqI6ucApQ.QQ12bKEMvJAbdyberoYvFC4ZnwayMzG', 'Admin', '2021-10-15 09:27:35'),
(52, 'contact@jackkimmins.com', 'Jack', 'Kimmins', 'Admin', '$2y$10$q7r2UiNoTCB1OqI6ucApQ.QQ12bKEMvJAbdyberoYvFC4ZnwayMzG', '$2y$10$q7r2UiNoTCB1OqI6ucApQ.QQ12bKEMvJAbdyberoYvFC4ZnwayMzG', 'Admin', '2021-10-15 09:28:03'),
(62, 'djebrb@protonmail.com', 'Mike', 'kimmins', 'Default', '$2y$10$q7r2UiNoTCB1OqI6ucApQ.QQ12bKEMvJAbdyberoYvFC4ZnwayMzG', '$2y$10$q7r2UiNoTCB1OqI6ucApQ.QQ12bKEMvJAbdyberoYvFC4ZnwayMzG', 'User', '2021-10-15 09:28:03'),
(63, 'ruthtaylor@protonmail.com', 'Ruth', 'Taylor', 'Default', '$2y$10$q7r2UiNoTCB1OqI6ucApQ.QQ12bKEMvJAbdyberoYvFC4ZnwayMzG', '$2y$10$q7r2UiNoTCB1OqI6ucApQ.QQ12bKEMvJAbdyberoYvFC4ZnwayMzG', 'User', '2022-03-30 22:50:45'),
(65, 'audreyiris@protonmail.com', 'Audrey', 'Iris', 'Default', '$2y$10$q7r2UiNoTCB1OqI6ucApQ.QQ12bKEMvJAbdyberoYvFC4ZnwayMzG', '$2y$10$q7r2UiNoTCB1OqI6ucApQ.QQ12bKEMvJAbdyberoYvFC4ZnwayMzG', 'User', '2022-03-30 22:52:05'),
(70, 'hattiebright@protonmail.com', 'Hattie', 'Bright', 'Default', '$2y$10$q7r2UiNoTCB1OqI6ucApQ.QQ12bKEMvJAbdyberoYvFC4ZnwayMzG', '$2y$10$q7r2UiNoTCB1OqI6ucApQ.QQ12bKEMvJAbdyberoYvFC4ZnwayMzG', 'User', '2022-03-31 14:34:10'),
(73, 'irenesales@protonmail.com', 'Irene', 'Sales', 'Default', '$2y$10$q7r2UiNoTCB1OqI6ucApQ.QQ12bKEMvJAbdyberoYvFC4ZnwayMzG', '$2y$10$q7r2UiNoTCB1OqI6ucApQ.QQ12bKEMvJAbdyberoYvFC4ZnwayMzG', 'User', '2022-04-01 14:07:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_announcements`
--
ALTER TABLE `tbl_announcements`
  ADD PRIMARY KEY (`AID`),
  ADD KEY `UID` (`UID`);

--
-- Indexes for table `tbl_courses`
--
ALTER TABLE `tbl_courses`
  ADD PRIMARY KEY (`CID`);

--
-- Indexes for table `tbl_course_attendees`
--
ALTER TABLE `tbl_course_attendees`
  ADD KEY `CID_2` (`CID`),
  ADD KEY `UID_2` (`UID`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`UID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_announcements`
--
ALTER TABLE `tbl_announcements`
  MODIFY `AID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `tbl_courses`
--
ALTER TABLE `tbl_courses`
  MODIFY `CID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `UID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_course_attendees`
--
ALTER TABLE `tbl_course_attendees`
  ADD CONSTRAINT `tbl_course_attendees_ibfk_1` FOREIGN KEY (`UID`) REFERENCES `tbl_users` (`UID`),
  ADD CONSTRAINT `tbl_course_attendees_ibfk_2` FOREIGN KEY (`CID`) REFERENCES `tbl_courses` (`CID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
