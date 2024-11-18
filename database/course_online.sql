-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 18, 2024 at 05:43 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `course_online`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `email`, `password`, `nama_lengkap`) VALUES
(1, 'aba@gmail.com', '321', ''),
(2, 'admin@gmail.com', '123', '');

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `classid` int(11) NOT NULL,
  `nama_class` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`classid`, `nama_class`, `deskripsi`) VALUES
(1, 'Pemrograman Dasar', 'Kelas ini adalah pintu gerbang bagi siapa saja yang ingin belajar membuat program. Anda akan mempelajari dasar-dasar logika pemrograman, sintaks bahasa pemrograman populer seperti Python, JavaScript, atau Java, dan cara membangun aplikasi sederhana.'),
(2, 'Desain Web', 'Ingin membuat website yang menarik dan fungsional? Kelas desain web akan mengajarkan Anda cara merancang tampilan website yang user-friendly, membangun struktur website menggunakan HTML dan CSS, serta menambahkan interaktivitas dengan JavaScript.'),
(3, 'Kecerdasan Buatan (AI)', 'AI adalah salah satu teknologi paling menarik saat ini. Dalam kelas ini, Anda akan belajar tentang konsep dasar AI, seperti machine learning, deep learning, dan neural network. Anda juga akan mempelajari cara membangun model AI sederhana untuk berbagai aplikasi.'),
(4, 'Cybersecurity', 'Dengan semakin maraknya serangan siber, permintaan akan ahli keamanan siber terus meningkat. Kelas ini akan mengajarkan Anda cara melindungi sistem komputer dan jaringan dari ancaman seperti hacking, malware, dan phishing.'),
(5, 'Database', 'Database adalah jantung dari banyak aplikasi. Kelas ini akan mengajarkan Anda cara merancang, mengelola, dan mengakses data menggunakan sistem manajemen basis data seperti MySQL atau PostgreSQL.'),
(6, 'Analisis Data', 'Data adalah aset berharga bagi setiap bisnis. Kelas analisis data akan mengajarkan Anda cara mengumpulkan, membersihkan, dan menganalisis data menggunakan tools seperti Python (Pandas, NumPy) dan R.');

-- --------------------------------------------------------

--
-- Table structure for table `classes_access`
--

CREATE TABLE `classes_access` (
  `id_code_class` int(11) NOT NULL,
  `classid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `fotoid` int(11) NOT NULL,
  `code_access` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `classes_access`
--

INSERT INTO `classes_access` (`id_code_class`, `classid`, `uid`, `fotoid`, `code_access`) VALUES
(1, 1, 1, 5, 'ebRzgfFUyZjHl0ub9+e3NRkD8tmOmN6FYDScoe6V6Fg='),
(2, 2, 1, 8, '91sTyRcb/q8NQfmOFOnscg=='),
(3, 2, 1, 9, 'Cw39FL5/uCb2xsTEFU4loA=='),
(4, 4, 1, 12, 'G+rN6rM0UMHxz+KVB/PQFQ=='),
(5, 3, 1, 13, 'vDVy8J6HeODQh3rA6b1bGtejGlVte75tqYOi+VjuRxs=');

-- --------------------------------------------------------

--
-- Table structure for table `foto`
--

CREATE TABLE `foto` (
  `id_foto` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `classid` int(11) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `foto`
--

INSERT INTO `foto` (`id_foto`, `uid`, `classid`, `foto`, `status`) VALUES
(5, 1, 1, 'you are the.jpg', 'Terkonfirmasi'),
(8, 1, 2, 'pamfletjalansantai.png', 'Terkonfirmasi'),
(9, 1, 2, 'pamfletjalansantai.png', 'Terkonfirmasi'),
(12, 1, 4, 'WhatsApp Image 2024-11-12 at 4.57.50 PM.jpeg', 'Terkonfirmasi'),
(13, 1, 3, 'Page Managemen Event.png', 'Terkonfirmasi');

-- --------------------------------------------------------

--
-- Table structure for table `fotoenkrip`
--

CREATE TABLE `fotoenkrip` (
  `id` int(11) NOT NULL,
  `id_code_classes` int(11) NOT NULL,
  `fotoenkrip` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fotoenkrip`
--

INSERT INTO `fotoenkrip` (`id`, `id_code_classes`, `fotoenkrip`) VALUES
(4, 1, 'Page Managemen Event (1).png');

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `noteid` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `file` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `note_access`
--

CREATE TABLE `note_access` (
  `code_note` varchar(65) NOT NULL,
  `classid` int(11) NOT NULL,
  `noteid` int(11) NOT NULL,
  `uid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `uid` int(11) NOT NULL,
  `email_user` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `email_user`, `password`, `nama_lengkap`) VALUES
(1, 'ariffianto980@gmail.com', '123', 'Akbar Ariffianto');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`classid`);

--
-- Indexes for table `classes_access`
--
ALTER TABLE `classes_access`
  ADD PRIMARY KEY (`id_code_class`),
  ADD UNIQUE KEY `code_access` (`code_access`) USING HASH,
  ADD KEY `user` (`uid`),
  ADD KEY `foto` (`fotoid`),
  ADD KEY `course` (`classid`);

--
-- Indexes for table `foto`
--
ALTER TABLE `foto`
  ADD PRIMARY KEY (`id_foto`),
  ADD KEY `user1` (`uid`),
  ADD KEY `class1` (`classid`);

--
-- Indexes for table `fotoenkrip`
--
ALTER TABLE `fotoenkrip`
  ADD PRIMARY KEY (`id`),
  ADD KEY `codeclasses` (`id_code_classes`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`noteid`),
  ADD KEY `user2` (`uid`),
  ADD KEY `course2` (`class_id`);

--
-- Indexes for table `note_access`
--
ALTER TABLE `note_access`
  ADD PRIMARY KEY (`code_note`),
  ADD KEY `class` (`classid`),
  ADD KEY `note` (`noteid`),
  ADD KEY `userr` (`uid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `username` (`email_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `classid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `classes_access`
--
ALTER TABLE `classes_access`
  MODIFY `id_code_class` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `foto`
--
ALTER TABLE `foto`
  MODIFY `id_foto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `fotoenkrip`
--
ALTER TABLE `fotoenkrip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `noteid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `classes_access`
--
ALTER TABLE `classes_access`
  ADD CONSTRAINT `course` FOREIGN KEY (`classid`) REFERENCES `class` (`classid`),
  ADD CONSTRAINT `foto` FOREIGN KEY (`fotoid`) REFERENCES `foto` (`id_foto`),
  ADD CONSTRAINT `user` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`);

--
-- Constraints for table `foto`
--
ALTER TABLE `foto`
  ADD CONSTRAINT `class1` FOREIGN KEY (`classid`) REFERENCES `class` (`classid`),
  ADD CONSTRAINT `user1` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`);

--
-- Constraints for table `fotoenkrip`
--
ALTER TABLE `fotoenkrip`
  ADD CONSTRAINT `codeclasses` FOREIGN KEY (`id_code_classes`) REFERENCES `classes_access` (`id_code_class`);

--
-- Constraints for table `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `course2` FOREIGN KEY (`class_id`) REFERENCES `class` (`classid`),
  ADD CONSTRAINT `user2` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`);

--
-- Constraints for table `note_access`
--
ALTER TABLE `note_access`
  ADD CONSTRAINT `class` FOREIGN KEY (`classid`) REFERENCES `class` (`classid`),
  ADD CONSTRAINT `note` FOREIGN KEY (`noteid`) REFERENCES `notes` (`noteid`),
  ADD CONSTRAINT `userr` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
