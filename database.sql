-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 19, 2024 at 10:16 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `myproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `application`
--

CREATE TABLE `application` (
  `application_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `scholarship_id` int(11) NOT NULL,
  `course` varchar(255) DEFAULT NULL,
  `application_status` enum('pending','approved','rejected') DEFAULT 'pending',
  `submission_date` date NOT NULL,
  `supporting_documents` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `application`
--

INSERT INTO `application` (`application_id`, `user_id`, `scholarship_id`, `course`, `application_status`, `submission_date`, `supporting_documents`) VALUES
(7, 5, 15, 'Economics', 'approved', '2024-10-16', 'tekk.pdf'),
(8, 6, 11, 'English Literature', 'rejected', '2024-10-17', 'Below is the link to my identification document: http://example.com/id_document.pdf.'),
(9, 7, 14, 'English Literature', 'approved', '2024-10-17', 'You can find my supporting documents at the following link: http://example.com/recommendation.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `description`) VALUES
(11, 'Elimu', 'Categories related to educational scholarships and grants.'),
(12, 'Biashara', 'Scholarships supporting entrepreneurship and business development.'),
(13, 'Sayansi na Teknolojia', 'Scholarships for students pursuing degrees in science and technology.'),
(14, 'Sanaa na Utamaduni', 'Categories for scholarships in arts and cultural studies.'),
(15, 'Afya', 'Scholarships for students studying health-related fields.'),
(16, 'Uongozi', 'Scholarships focusing on leadership and civic engagement programs.'),
(17, 'Michezo', 'Scholarships for athletes and students excelling in sports.'),
(18, 'Mazao', 'Scholarships supporting agricultural studies and innovation.'),
(19, 'Teknolojia ya Habari', 'Scholarships for information technology and computer science students.'),
(20, 'Wanafunzi wa Kike', 'Scholarships specifically aimed at empowering female students.');

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('student','administrator') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`user_id`, `first_name`, `last_name`, `email`, `password`, `role`) VALUES
(4, 'Tek', 'Tim', 'tek@gmail.com', '$2y$10$lGfN.JSTA9LJFEWLhyiOVOq1.RYMKINEQUrw8SzTMvRrw1YmsSOoW', 'administrator'),
(5, 'samm', 'sam', 'sam@gmail.com', '$2y$10$t1cyDFOoPk.AbIIzgDK81.g4.ZX0tnlWW83Uk6.Z69ec7.EyUkdmK', 'student'),
(6, 'Otieno', 'Omondi', 'oti@gmail.com', '$2y$10$ZUy6D0BkEibfRMUrlMj2duLdddm2A3BsoP4d8JbHEWBhpoji8TbBW', 'student'),
(7, 'Dan', 'Otiyo', 'dan@gmail.com', '$2y$10$2dgkDws/VMRrNujkpMXPe.x/oVezg4OlDhTPcb9fFgtx7jRvDMrgu', 'student');

-- --------------------------------------------------------

--
-- Table structure for table `scholarship`
--

CREATE TABLE `scholarship` (
  `scholarship_id` int(11) NOT NULL,
  `scholarship_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `deadline` date NOT NULL,
  `criteria` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `scholarship`
--

INSERT INTO `scholarship` (`scholarship_id`, `scholarship_name`, `description`, `amount`, `deadline`, `criteria`) VALUES
(11, 'Elimu Bora Scholarship', 'Scholarship aimed at supporting students in secondary education.', 5500.00, '2024-12-31', 'Must be a Kenyan citizen and have a C+ average.'),
(12, 'Maendeleo Youth Scholarship', 'For young entrepreneurs pursuing vocational training.', 3000.00, '2025-01-15', 'Applicants must be aged 18-25 and have a business idea.'),
(13, 'Taaluma Nafasi Scholarship', 'Supports students in STEM fields at university level.', 3200.00, '2025-02-28', 'Must have a B+ average and be enrolled in a STEM program.'),
(14, 'Kiswahili Heritage Scholarship', 'For students pursuing courses in languages and cultural studies.', 40000.00, '2025-03-15', 'Must demonstrate proficiency in Kiswahili.'),
(15, 'Uwezo Fund Scholarship', 'Financial assistance for students in arts and humanities.', 2500.00, '2025-03-20', 'Open to all Kenyan citizens with financial need.'),
(16, 'Safari Scholarship', 'For students from rural areas pursuing higher education.', 7000.00, '2025-04-30', 'Must provide proof of residency in a rural area.'),
(17, 'Wanafunzi wa Kike Scholarship', 'Encourages girls to pursue education in non-traditional fields.', 6000.00, '2025-05-31', 'Female applicants only, must have a B average.'),
(18, 'Kiongozi Scholarship', 'Supports leadership training programs for university students.', 4500.00, '2025-06-18', 'Applicants must demonstrate leadership experience.'),
(19, 'Uhuru Scholarship', 'For students from disadvantaged backgrounds.', 5300.00, '2025-07-03', 'Must provide documentation of financial need.'),
(20, 'Maisha Mema Scholarship', 'A scholarship for students pursuing health-related courses.', 3000.00, '2025-07-15', 'Must have a B average and be enrolled in a health program.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `application`
--
ALTER TABLE `application`
  ADD PRIMARY KEY (`application_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `scholarship_id` (`scholarship_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `scholarship`
--
ALTER TABLE `scholarship`
  ADD PRIMARY KEY (`scholarship_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `application`
--
ALTER TABLE `application`
  MODIFY `application_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `scholarship`
--
ALTER TABLE `scholarship`
  MODIFY `scholarship_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `application`
--
ALTER TABLE `application`
  ADD CONSTRAINT `application_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `registration` (`user_id`),
  ADD CONSTRAINT `application_ibfk_2` FOREIGN KEY (`scholarship_id`) REFERENCES `scholarship` (`scholarship_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;