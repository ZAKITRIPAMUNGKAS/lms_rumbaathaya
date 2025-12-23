-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               12.0.2-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.11.0.7065
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table lms_db.attendances
CREATE TABLE IF NOT EXISTS `attendances` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `schedule_id` bigint(20) unsigned DEFAULT NULL,
  `tutor_id` bigint(20) unsigned NOT NULL,
  `student_id` bigint(20) unsigned NOT NULL,
  `date` date NOT NULL,
  `topic_taught` text NOT NULL,
  `student_progress_note` text DEFAULT NULL,
  `photo_evidence_path` varchar(255) DEFAULT NULL,
  `status` enum('present','absent','permission','sick') DEFAULT 'present',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `attendances_schedule_id_foreign` (`schedule_id`),
  KEY `attendances_date_index` (`date`),
  KEY `attendances_tutor_id_index` (`tutor_id`),
  KEY `attendances_student_id_index` (`student_id`),
  KEY `attendances_status_index` (`status`),
  KEY `attendances_student_status_date_idx` (`student_id`,`status`,`date`),
  KEY `attendances_student_id_date_index` (`student_id`,`date`),
  KEY `attendances_tutor_id_date_index` (`tutor_id`,`date`),
  CONSTRAINT `attendances_schedule_id_foreign` FOREIGN KEY (`schedule_id`) REFERENCES `schedules` (`id`) ON DELETE SET NULL,
  CONSTRAINT `attendances_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  CONSTRAINT `attendances_tutor_id_foreign` FOREIGN KEY (`tutor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table lms_db.attendances: ~51 rows (approximately)
INSERT INTO `attendances` (`id`, `schedule_id`, `tutor_id`, `student_id`, `date`, `topic_taught`, `student_progress_note`, `photo_evidence_path`, `status`, `created_at`, `updated_at`) VALUES
	(1, 1, 5, 1, '2025-12-20', 'ASDAS', 'ASDASDAS', NULL, 'present', '2025-12-20 08:01:46', '2025-12-20 08:01:46'),
	(2, 2, 12, 1, '2025-12-16', 'Materi Bab 1: Pengenalan IPS', 'Siswa memahami materi dengan baik.', NULL, 'present', '2025-12-23 10:34:21', '2025-12-23 10:34:21'),
	(3, 2, 12, 1, '2025-12-09', 'Materi Bab 2: Pengenalan IPS', 'Siswa memahami materi dengan baik.', NULL, 'present', '2025-12-23 10:34:21', '2025-12-23 10:34:21'),
	(4, 2, 12, 1, '2025-12-02', 'Materi Bab 3: Pengenalan IPS', 'Siswa memahami materi dengan baik.', NULL, 'present', '2025-12-23 10:34:21', '2025-12-23 10:34:21'),
	(5, 2, 12, 1, '2025-11-25', 'Materi Bab 4: Pengenalan IPS', 'Siswa memahami materi dengan baik.', NULL, 'present', '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(6, 3, 12, 1, '2025-12-16', 'Materi Bab 1: Pengenalan Bahasa Indonesia', 'Siswa memahami materi dengan baik.', NULL, 'present', '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(7, 3, 12, 1, '2025-12-09', 'Materi Bab 2: Pengenalan Bahasa Indonesia', 'Siswa memahami materi dengan baik.', NULL, 'present', '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(8, 3, 12, 1, '2025-12-02', 'Materi Bab 3: Pengenalan Bahasa Indonesia', NULL, NULL, 'absent', '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(9, 3, 12, 1, '2025-11-25', 'Materi Bab 4: Pengenalan Bahasa Indonesia', NULL, NULL, 'absent', '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(10, 3, 12, 1, '2025-12-23', 'Materi Bab 5: Latihan Soal', 'Sedang mengerjakan latihan.', NULL, 'present', '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(11, 4, 12, 2, '2025-12-16', 'Materi Bab 1: Pengenalan Matematika', NULL, NULL, 'absent', '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(12, 4, 12, 2, '2025-12-09', 'Materi Bab 2: Pengenalan Matematika', 'Siswa memahami materi dengan baik.', NULL, 'present', '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(13, 4, 12, 2, '2025-12-02', 'Materi Bab 3: Pengenalan Matematika', 'Siswa memahami materi dengan baik.', NULL, 'present', '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(14, 4, 12, 2, '2025-11-25', 'Materi Bab 4: Pengenalan Matematika', 'Siswa memahami materi dengan baik.', NULL, 'present', '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(15, 5, 12, 3, '2025-12-20', 'Materi Bab 1: Pengenalan Matematika', 'Siswa memahami materi dengan baik.', NULL, 'present', '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(16, 5, 12, 3, '2025-12-13', 'Materi Bab 2: Pengenalan Matematika', NULL, NULL, 'absent', '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(17, 5, 12, 3, '2025-12-06', 'Materi Bab 3: Pengenalan Matematika', 'Siswa memahami materi dengan baik.', NULL, 'present', '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(18, 5, 12, 3, '2025-11-29', 'Materi Bab 4: Pengenalan Matematika', 'Siswa memahami materi dengan baik.', NULL, 'present', '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(19, 6, 12, 3, '2025-12-19', 'Materi Bab 1: Pengenalan Bahasa Indonesia', 'Siswa memahami materi dengan baik.', NULL, 'present', '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(20, 6, 12, 3, '2025-12-12', 'Materi Bab 2: Pengenalan Bahasa Indonesia', NULL, NULL, 'permission', '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(21, 6, 12, 3, '2025-12-05', 'Materi Bab 3: Pengenalan Bahasa Indonesia', NULL, NULL, 'absent', '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(22, 6, 12, 3, '2025-11-28', 'Materi Bab 4: Pengenalan Bahasa Indonesia', NULL, NULL, 'absent', '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(23, 7, 12, 4, '2025-12-19', 'Materi Bab 1: Pengenalan Matematika', NULL, NULL, 'permission', '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(24, 7, 12, 4, '2025-12-12', 'Materi Bab 2: Pengenalan Matematika', 'Siswa memahami materi dengan baik.', NULL, 'present', '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(25, 7, 12, 4, '2025-12-05', 'Materi Bab 3: Pengenalan Matematika', 'Siswa memahami materi dengan baik.', NULL, 'present', '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(26, 7, 12, 4, '2025-11-28', 'Materi Bab 4: Pengenalan Matematika', 'Siswa memahami materi dengan baik.', NULL, 'present', '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(27, 8, 12, 4, '2025-12-22', 'Materi Bab 1: Pengenalan IPS', NULL, NULL, 'absent', '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(28, 8, 12, 4, '2025-12-15', 'Materi Bab 2: Pengenalan IPS', 'Siswa memahami materi dengan baik.', NULL, 'present', '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(29, 8, 12, 4, '2025-12-08', 'Materi Bab 3: Pengenalan IPS', NULL, NULL, 'permission', '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(30, 8, 12, 4, '2025-12-01', 'Materi Bab 4: Pengenalan IPS', 'Siswa memahami materi dengan baik.', NULL, 'present', '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(31, 9, 12, 5, '2025-12-20', 'Materi Bab 1: Pengenalan Matematika', 'Siswa memahami materi dengan baik.', NULL, 'present', '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(32, 9, 12, 5, '2025-12-13', 'Materi Bab 2: Pengenalan Matematika', 'Siswa memahami materi dengan baik.', NULL, 'present', '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(33, 9, 12, 5, '2025-12-06', 'Materi Bab 3: Pengenalan Matematika', 'Siswa memahami materi dengan baik.', NULL, 'present', '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(34, 9, 12, 5, '2025-11-29', 'Materi Bab 4: Pengenalan Matematika', 'Siswa memahami materi dengan baik.', NULL, 'present', '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(35, 10, 12, 5, '2025-12-20', 'Materi Bab 1: Pengenalan Bahasa Indonesia', NULL, NULL, 'absent', '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(36, 10, 12, 5, '2025-12-13', 'Materi Bab 2: Pengenalan Bahasa Indonesia', 'Siswa memahami materi dengan baik.', NULL, 'present', '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(37, 10, 12, 5, '2025-12-06', 'Materi Bab 3: Pengenalan Bahasa Indonesia', 'Siswa memahami materi dengan baik.', NULL, 'present', '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(38, 10, 12, 5, '2025-11-29', 'Materi Bab 4: Pengenalan Bahasa Indonesia', 'Siswa memahami materi dengan baik.', NULL, 'present', '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(39, 11, 12, 6, '2025-12-18', 'Materi Bab 1: Pengenalan Bahasa Indonesia', NULL, NULL, 'absent', '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(40, 11, 12, 6, '2025-12-11', 'Materi Bab 2: Pengenalan Bahasa Indonesia', 'Siswa memahami materi dengan baik.', NULL, 'present', '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(41, 11, 12, 6, '2025-12-04', 'Materi Bab 3: Pengenalan Bahasa Indonesia', 'Siswa memahami materi dengan baik.', NULL, 'present', '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(42, 11, 12, 6, '2025-11-27', 'Materi Bab 4: Pengenalan Bahasa Indonesia', 'Siswa memahami materi dengan baik.', NULL, 'present', '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(43, 12, 12, 7, '2025-12-17', 'Materi Bab 1: Pengenalan Matematika', 'Siswa memahami materi dengan baik.', NULL, 'present', '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(44, 12, 12, 7, '2025-12-10', 'Materi Bab 2: Pengenalan Matematika', 'Siswa memahami materi dengan baik.', NULL, 'present', '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(45, 12, 12, 7, '2025-12-03', 'Materi Bab 3: Pengenalan Matematika', 'Siswa memahami materi dengan baik.', NULL, 'present', '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(46, 12, 12, 7, '2025-11-26', 'Materi Bab 4: Pengenalan Matematika', 'Siswa memahami materi dengan baik.', NULL, 'present', '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(47, 13, 12, 7, '2025-12-18', 'Materi Bab 1: Pengenalan Bahasa Indonesia', 'Siswa memahami materi dengan baik.', NULL, 'present', '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(48, 13, 12, 7, '2025-12-11', 'Materi Bab 2: Pengenalan Bahasa Indonesia', 'Siswa memahami materi dengan baik.', NULL, 'present', '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(49, 13, 12, 7, '2025-12-04', 'Materi Bab 3: Pengenalan Bahasa Indonesia', NULL, NULL, 'absent', '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(50, 13, 12, 7, '2025-11-27', 'Materi Bab 4: Pengenalan Bahasa Indonesia', NULL, NULL, 'permission', '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(51, 2, 12, 1, '2025-12-23', 'asasad', 'asdasdadsasd', NULL, 'present', '2025-12-23 11:23:12', '2025-12-23 11:23:12');

-- Dumping structure for table lms_db.bimbel_journals
CREATE TABLE IF NOT EXISTS `bimbel_journals` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tutor_id` bigint(20) unsigned NOT NULL,
  `schedule_id` bigint(20) unsigned DEFAULT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `material` text NOT NULL,
  `documentation_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bimbel_journals_tutor_id_foreign` (`tutor_id`),
  KEY `bimbel_journals_schedule_id_foreign` (`schedule_id`),
  CONSTRAINT `bimbel_journals_schedule_id_foreign` FOREIGN KEY (`schedule_id`) REFERENCES `schedules` (`id`) ON DELETE SET NULL,
  CONSTRAINT `bimbel_journals_tutor_id_foreign` FOREIGN KEY (`tutor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table lms_db.bimbel_journals: ~35 rows (approximately)
INSERT INTO `bimbel_journals` (`id`, `tutor_id`, `schedule_id`, `date`, `time`, `material`, `documentation_path`, `created_at`, `updated_at`) VALUES
	(1, 12, 2, '2025-12-16', '13:00:00', 'Materi Bab 1', NULL, '2025-12-23 10:34:21', '2025-12-23 10:34:21'),
	(2, 12, 2, '2025-12-09', '13:00:00', 'Materi Bab 2', NULL, '2025-12-23 10:34:21', '2025-12-23 10:34:21'),
	(3, 12, 2, '2025-12-02', '13:00:00', 'Materi Bab 3', NULL, '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(4, 12, 2, '2025-11-25', '13:00:00', 'Materi Bab 4', NULL, '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(5, 12, 3, '2025-12-16', '16:00:00', 'Materi Bab 1', NULL, '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(6, 12, 3, '2025-12-09', '16:00:00', 'Materi Bab 2', NULL, '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(7, 12, 4, '2025-12-09', '16:00:00', 'Materi Bab 2', NULL, '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(8, 12, 4, '2025-12-02', '16:00:00', 'Materi Bab 3', NULL, '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(9, 12, 4, '2025-11-25', '16:00:00', 'Materi Bab 4', NULL, '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(10, 12, 5, '2025-12-20', '16:00:00', 'Materi Bab 1', NULL, '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(11, 12, 5, '2025-12-06', '16:00:00', 'Materi Bab 3', NULL, '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(12, 12, 5, '2025-11-29', '16:00:00', 'Materi Bab 4', NULL, '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(13, 12, 6, '2025-12-19', '13:00:00', 'Materi Bab 1', NULL, '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(14, 12, 7, '2025-12-12', '17:00:00', 'Materi Bab 2', NULL, '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(15, 12, 7, '2025-12-05', '17:00:00', 'Materi Bab 3', NULL, '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(16, 12, 7, '2025-11-28', '17:00:00', 'Materi Bab 4', NULL, '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(17, 12, 8, '2025-12-15', '13:00:00', 'Materi Bab 2', NULL, '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(18, 12, 8, '2025-12-01', '13:00:00', 'Materi Bab 4', NULL, '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(19, 12, 9, '2025-12-20', '13:00:00', 'Materi Bab 1', NULL, '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(20, 12, 9, '2025-12-13', '13:00:00', 'Materi Bab 2', NULL, '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(21, 12, 9, '2025-12-06', '13:00:00', 'Materi Bab 3', NULL, '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(22, 12, 9, '2025-11-29', '13:00:00', 'Materi Bab 4', NULL, '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(23, 12, 10, '2025-12-13', '15:00:00', 'Materi Bab 2', NULL, '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(24, 12, 10, '2025-12-06', '15:00:00', 'Materi Bab 3', NULL, '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(25, 12, 10, '2025-11-29', '15:00:00', 'Materi Bab 4', NULL, '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(26, 12, 11, '2025-12-11', '16:00:00', 'Materi Bab 2', NULL, '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(27, 12, 11, '2025-12-04', '16:00:00', 'Materi Bab 3', NULL, '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(28, 12, 11, '2025-11-27', '16:00:00', 'Materi Bab 4', NULL, '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(29, 12, 12, '2025-12-17', '17:00:00', 'Materi Bab 1', NULL, '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(30, 12, 12, '2025-12-10', '17:00:00', 'Materi Bab 2', NULL, '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(31, 12, 12, '2025-12-03', '17:00:00', 'Materi Bab 3', NULL, '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(32, 12, 12, '2025-11-26', '17:00:00', 'Materi Bab 4', NULL, '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(33, 12, 13, '2025-12-18', '14:00:00', 'Materi Bab 1', NULL, '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(34, 12, 13, '2025-12-11', '14:00:00', 'Materi Bab 2', NULL, '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(35, 12, 2, '2025-12-23', '18:23:00', 'asasad', NULL, '2025-12-23 11:23:12', '2025-12-23 11:23:12');

-- Dumping structure for table lms_db.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table lms_db.cache: ~2 rows (approximately)
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
	('laravel-cache-tutor_dashboard_stats_12_2025-12-23-19', 'a:5:{s:15:"active_students";i:7;s:14:"active_classes";i:12;s:18:"materials_uploaded";i:3;s:16:"today_attendance";i:2;s:18:"monthly_attendance";i:28;}', 1766519487),
	('laravel-cache-tutor_schedules_12_2025-12-23-19', 'O:39:"Illuminate\\Database\\Eloquent\\Collection":2:{s:8:"\0*\0items";a:10:{i:0;O:19:"App\\Models\\Schedule":33:{s:13:"\0*\0connection";s:5:"mysql";s:8:"\0*\0table";s:9:"schedules";s:13:"\0*\0primaryKey";s:2:"id";s:10:"\0*\0keyType";s:3:"int";s:12:"incrementing";b:1;s:7:"\0*\0with";a:0:{}s:12:"\0*\0withCount";a:0:{}s:19:"preventsLazyLoading";b:0;s:10:"\0*\0perPage";i:15;s:6:"exists";b:1;s:18:"wasRecentlyCreated";b:0;s:28:"\0*\0escapeWhenCastingToString";b:0;s:13:"\0*\0attributes";a:10:{s:2:"id";i:6;s:8:"tutor_id";i:12;s:10:"student_id";i:3;s:10:"subject_id";i:3;s:11:"day_of_week";s:6:"Friday";s:10:"time_start";s:8:"13:00:00";s:8:"time_end";s:8:"14:30:00";s:9:"is_active";i:1;s:10:"created_at";s:19:"2025-12-23 17:34:22";s:10:"updated_at";s:19:"2025-12-23 17:34:22";}s:11:"\0*\0original";a:10:{s:2:"id";i:6;s:8:"tutor_id";i:12;s:10:"student_id";i:3;s:10:"subject_id";i:3;s:11:"day_of_week";s:6:"Friday";s:10:"time_start";s:8:"13:00:00";s:8:"time_end";s:8:"14:30:00";s:9:"is_active";i:1;s:10:"created_at";s:19:"2025-12-23 17:34:22";s:10:"updated_at";s:19:"2025-12-23 17:34:22";}s:10:"\0*\0changes";a:0:{}s:11:"\0*\0previous";a:0:{}s:8:"\0*\0casts";a:1:{s:9:"is_active";s:7:"boolean";}s:17:"\0*\0classCastCache";a:0:{}s:21:"\0*\0attributeCastCache";a:0:{}s:13:"\0*\0dateFormat";N;s:10:"\0*\0appends";a:0:{}s:19:"\0*\0dispatchesEvents";a:0:{}s:14:"\0*\0observables";a:0:{}s:12:"\0*\0relations";a:2:{s:7:"subject";O:18:"App\\Models\\Subject":33:{s:13:"\0*\0connection";s:5:"mysql";s:8:"\0*\0table";s:8:"subjects";s:13:"\0*\0primaryKey";s:2:"id";s:10:"\0*\0keyType";s:3:"int";s:12:"incrementing";b:1;s:7:"\0*\0with";a:0:{}s:12:"\0*\0withCount";a:0:{}s:19:"preventsLazyLoading";b:0;s:10:"\0*\0perPage";i:15;s:6:"exists";b:1;s:18:"wasRecentlyCreated";b:0;s:28:"\0*\0escapeWhenCastingToString";b:0;s:13:"\0*\0attributes";a:5:{s:2:"id";i:3;s:4:"name";s:16:"Bahasa Indonesia";s:4:"slug";s:16:"bahasa-indonesia";s:10:"created_at";s:19:"2025-12-19 22:42:03";s:10:"updated_at";s:19:"2025-12-19 22:42:03";}s:11:"\0*\0original";a:5:{s:2:"id";i:3;s:4:"name";s:16:"Bahasa Indonesia";s:4:"slug";s:16:"bahasa-indonesia";s:10:"created_at";s:19:"2025-12-19 22:42:03";s:10:"updated_at";s:19:"2025-12-19 22:42:03";}s:10:"\0*\0changes";a:0:{}s:11:"\0*\0previous";a:0:{}s:8:"\0*\0casts";a:0:{}s:17:"\0*\0classCastCache";a:0:{}s:21:"\0*\0attributeCastCache";a:0:{}s:13:"\0*\0dateFormat";N;s:10:"\0*\0appends";a:0:{}s:19:"\0*\0dispatchesEvents";a:0:{}s:14:"\0*\0observables";a:0:{}s:12:"\0*\0relations";a:0:{}s:10:"\0*\0touches";a:0:{}s:27:"\0*\0relationAutoloadCallback";N;s:26:"\0*\0relationAutoloadContext";N;s:10:"timestamps";b:1;s:13:"usesUniqueIds";b:0;s:9:"\0*\0hidden";a:0:{}s:10:"\0*\0visible";a:0:{}s:11:"\0*\0fillable";a:2:{i:0;s:4:"name";i:1;s:4:"slug";}s:10:"\0*\0guarded";a:1:{i:0;s:1:"*";}}s:7:"student";O:18:"App\\Models\\Student":33:{s:13:"\0*\0connection";s:5:"mysql";s:8:"\0*\0table";s:8:"students";s:13:"\0*\0primaryKey";s:2:"id";s:10:"\0*\0keyType";s:3:"int";s:12:"incrementing";b:1;s:7:"\0*\0with";a:0:{}s:12:"\0*\0withCount";a:0:{}s:19:"preventsLazyLoading";b:0;s:10:"\0*\0perPage";i:15;s:6:"exists";b:1;s:18:"wasRecentlyCreated";b:0;s:28:"\0*\0escapeWhenCastingToString";b:0;s:13:"\0*\0attributes";a:15:{s:2:"id";i:3;s:7:"user_id";N;s:4:"name";s:14:"Siti Nurhaliza";s:8:"nickname";s:4:"Siti";s:14:"place_of_birth";s:9:"Surakarta";s:13:"date_of_birth";s:10:"2017-08-20";s:7:"address";s:30:"Jl. Sudirman No. 45, Surakarta";s:16:"program_interest";s:8:"Mapel SD";s:18:"profile_photo_path";N;s:12:"parent_phone";s:12:"081234567891";s:15:"whatsapp_number";N;s:13:"school_origin";s:21:"SD Negeri 1 Surakarta";s:14:"class_level_id";i:1;s:10:"created_at";s:19:"2025-12-23 17:32:54";s:10:"updated_at";s:19:"2025-12-23 17:32:54";}s:11:"\0*\0original";a:15:{s:2:"id";i:3;s:7:"user_id";N;s:4:"name";s:14:"Siti Nurhaliza";s:8:"nickname";s:4:"Siti";s:14:"place_of_birth";s:9:"Surakarta";s:13:"date_of_birth";s:10:"2017-08-20";s:7:"address";s:30:"Jl. Sudirman No. 45, Surakarta";s:16:"program_interest";s:8:"Mapel SD";s:18:"profile_photo_path";N;s:12:"parent_phone";s:12:"081234567891";s:15:"whatsapp_number";N;s:13:"school_origin";s:21:"SD Negeri 1 Surakarta";s:14:"class_level_id";i:1;s:10:"created_at";s:19:"2025-12-23 17:32:54";s:10:"updated_at";s:19:"2025-12-23 17:32:54";}s:10:"\0*\0changes";a:0:{}s:11:"\0*\0previous";a:0:{}s:8:"\0*\0casts";a:1:{s:13:"date_of_birth";s:4:"date";}s:17:"\0*\0classCastCache";a:0:{}s:21:"\0*\0attributeCastCache";a:0:{}s:13:"\0*\0dateFormat";N;s:10:"\0*\0appends";a:0:{}s:19:"\0*\0dispatchesEvents";a:0:{}s:14:"\0*\0observables";a:0:{}s:12:"\0*\0relations";a:0:{}s:10:"\0*\0touches";a:0:{}s:27:"\0*\0relationAutoloadCallback";N;s:26:"\0*\0relationAutoloadContext";N;s:10:"timestamps";b:1;s:13:"usesUniqueIds";b:0;s:9:"\0*\0hidden";a:0:{}s:10:"\0*\0visible";a:0:{}s:11:"\0*\0fillable";a:12:{i:0;s:7:"user_id";i:1;s:4:"name";i:2;s:8:"nickname";i:3;s:14:"place_of_birth";i:4;s:13:"date_of_birth";i:5;s:7:"address";i:6;s:16:"program_interest";i:7;s:18:"profile_photo_path";i:8;s:12:"parent_phone";i:9;s:15:"whatsapp_number";i:10;s:13:"school_origin";i:11;s:14:"class_level_id";}s:10:"\0*\0guarded";a:1:{i:0;s:1:"*";}}}s:10:"\0*\0touches";a:0:{}s:27:"\0*\0relationAutoloadCallback";N;s:26:"\0*\0relationAutoloadContext";N;s:10:"timestamps";b:1;s:13:"usesUniqueIds";b:0;s:9:"\0*\0hidden";a:0:{}s:10:"\0*\0visible";a:0:{}s:11:"\0*\0fillable";a:7:{i:0;s:8:"tutor_id";i:1;s:10:"student_id";i:2;s:10:"subject_id";i:3;s:11:"day_of_week";i:4;s:10:"time_start";i:5;s:8:"time_end";i:6;s:9:"is_active";}s:10:"\0*\0guarded";a:1:{i:0;s:1:"*";}}i:1;O:19:"App\\Models\\Schedule":33:{s:13:"\0*\0connection";s:5:"mysql";s:8:"\0*\0table";s:9:"schedules";s:13:"\0*\0primaryKey";s:2:"id";s:10:"\0*\0keyType";s:3:"int";s:12:"incrementing";b:1;s:7:"\0*\0with";a:0:{}s:12:"\0*\0withCount";a:0:{}s:19:"preventsLazyLoading";b:0;s:10:"\0*\0perPage";i:15;s:6:"exists";b:1;s:18:"wasRecentlyCreated";b:0;s:28:"\0*\0escapeWhenCastingToString";b:0;s:13:"\0*\0attributes";a:10:{s:2:"id";i:7;s:8:"tutor_id";i:12;s:10:"student_id";i:4;s:10:"subject_id";i:1;s:11:"day_of_week";s:6:"Friday";s:10:"time_start";s:8:"17:00:00";s:8:"time_end";s:8:"18:30:00";s:9:"is_active";i:1;s:10:"created_at";s:19:"2025-12-23 17:34:22";s:10:"updated_at";s:19:"2025-12-23 17:34:22";}s:11:"\0*\0original";a:10:{s:2:"id";i:7;s:8:"tutor_id";i:12;s:10:"student_id";i:4;s:10:"subject_id";i:1;s:11:"day_of_week";s:6:"Friday";s:10:"time_start";s:8:"17:00:00";s:8:"time_end";s:8:"18:30:00";s:9:"is_active";i:1;s:10:"created_at";s:19:"2025-12-23 17:34:22";s:10:"updated_at";s:19:"2025-12-23 17:34:22";}s:10:"\0*\0changes";a:0:{}s:11:"\0*\0previous";a:0:{}s:8:"\0*\0casts";a:1:{s:9:"is_active";s:7:"boolean";}s:17:"\0*\0classCastCache";a:0:{}s:21:"\0*\0attributeCastCache";a:0:{}s:13:"\0*\0dateFormat";N;s:10:"\0*\0appends";a:0:{}s:19:"\0*\0dispatchesEvents";a:0:{}s:14:"\0*\0observables";a:0:{}s:12:"\0*\0relations";a:2:{s:7:"subject";O:18:"App\\Models\\Subject":33:{s:13:"\0*\0connection";s:5:"mysql";s:8:"\0*\0table";s:8:"subjects";s:13:"\0*\0primaryKey";s:2:"id";s:10:"\0*\0keyType";s:3:"int";s:12:"incrementing";b:1;s:7:"\0*\0with";a:0:{}s:12:"\0*\0withCount";a:0:{}s:19:"preventsLazyLoading";b:0;s:10:"\0*\0perPage";i:15;s:6:"exists";b:1;s:18:"wasRecentlyCreated";b:0;s:28:"\0*\0escapeWhenCastingToString";b:0;s:13:"\0*\0attributes";a:5:{s:2:"id";i:1;s:4:"name";s:10:"Matematika";s:4:"slug";s:10:"matematika";s:10:"created_at";s:19:"2025-12-19 22:36:46";s:10:"updated_at";s:19:"2025-12-19 22:36:46";}s:11:"\0*\0original";a:5:{s:2:"id";i:1;s:4:"name";s:10:"Matematika";s:4:"slug";s:10:"matematika";s:10:"created_at";s:19:"2025-12-19 22:36:46";s:10:"updated_at";s:19:"2025-12-19 22:36:46";}s:10:"\0*\0changes";a:0:{}s:11:"\0*\0previous";a:0:{}s:8:"\0*\0casts";a:0:{}s:17:"\0*\0classCastCache";a:0:{}s:21:"\0*\0attributeCastCache";a:0:{}s:13:"\0*\0dateFormat";N;s:10:"\0*\0appends";a:0:{}s:19:"\0*\0dispatchesEvents";a:0:{}s:14:"\0*\0observables";a:0:{}s:12:"\0*\0relations";a:0:{}s:10:"\0*\0touches";a:0:{}s:27:"\0*\0relationAutoloadCallback";N;s:26:"\0*\0relationAutoloadContext";N;s:10:"timestamps";b:1;s:13:"usesUniqueIds";b:0;s:9:"\0*\0hidden";a:0:{}s:10:"\0*\0visible";a:0:{}s:11:"\0*\0fillable";a:2:{i:0;s:4:"name";i:1;s:4:"slug";}s:10:"\0*\0guarded";a:1:{i:0;s:1:"*";}}s:7:"student";O:18:"App\\Models\\Student":33:{s:13:"\0*\0connection";s:5:"mysql";s:8:"\0*\0table";s:8:"students";s:13:"\0*\0primaryKey";s:2:"id";s:10:"\0*\0keyType";s:3:"int";s:12:"incrementing";b:1;s:7:"\0*\0with";a:0:{}s:12:"\0*\0withCount";a:0:{}s:19:"preventsLazyLoading";b:0;s:10:"\0*\0perPage";i:15;s:6:"exists";b:1;s:18:"wasRecentlyCreated";b:0;s:28:"\0*\0escapeWhenCastingToString";b:0;s:13:"\0*\0attributes";a:15:{s:2:"id";i:4;s:7:"user_id";N;s:4:"name";s:12:"Budi Pratama";s:8:"nickname";s:4:"Budi";s:14:"place_of_birth";s:7:"Jakarta";s:13:"date_of_birth";s:10:"2014-03-10";s:7:"address";s:33:"Jl. Gatot Subroto No. 78, Jakarta";s:16:"program_interest";s:8:"Mapel SD";s:18:"profile_photo_path";N;s:12:"parent_phone";s:12:"081234567892";s:15:"whatsapp_number";N;s:13:"school_origin";s:16:"SD Islam Terpadu";s:14:"class_level_id";i:6;s:10:"created_at";s:19:"2025-12-23 17:32:54";s:10:"updated_at";s:19:"2025-12-23 17:32:54";}s:11:"\0*\0original";a:15:{s:2:"id";i:4;s:7:"user_id";N;s:4:"name";s:12:"Budi Pratama";s:8:"nickname";s:4:"Budi";s:14:"place_of_birth";s:7:"Jakarta";s:13:"date_of_birth";s:10:"2014-03-10";s:7:"address";s:33:"Jl. Gatot Subroto No. 78, Jakarta";s:16:"program_interest";s:8:"Mapel SD";s:18:"profile_photo_path";N;s:12:"parent_phone";s:12:"081234567892";s:15:"whatsapp_number";N;s:13:"school_origin";s:16:"SD Islam Terpadu";s:14:"class_level_id";i:6;s:10:"created_at";s:19:"2025-12-23 17:32:54";s:10:"updated_at";s:19:"2025-12-23 17:32:54";}s:10:"\0*\0changes";a:0:{}s:11:"\0*\0previous";a:0:{}s:8:"\0*\0casts";a:1:{s:13:"date_of_birth";s:4:"date";}s:17:"\0*\0classCastCache";a:0:{}s:21:"\0*\0attributeCastCache";a:0:{}s:13:"\0*\0dateFormat";N;s:10:"\0*\0appends";a:0:{}s:19:"\0*\0dispatchesEvents";a:0:{}s:14:"\0*\0observables";a:0:{}s:12:"\0*\0relations";a:0:{}s:10:"\0*\0touches";a:0:{}s:27:"\0*\0relationAutoloadCallback";N;s:26:"\0*\0relationAutoloadContext";N;s:10:"timestamps";b:1;s:13:"usesUniqueIds";b:0;s:9:"\0*\0hidden";a:0:{}s:10:"\0*\0visible";a:0:{}s:11:"\0*\0fillable";a:12:{i:0;s:7:"user_id";i:1;s:4:"name";i:2;s:8:"nickname";i:3;s:14:"place_of_birth";i:4;s:13:"date_of_birth";i:5;s:7:"address";i:6;s:16:"program_interest";i:7;s:18:"profile_photo_path";i:8;s:12:"parent_phone";i:9;s:15:"whatsapp_number";i:10;s:13:"school_origin";i:11;s:14:"class_level_id";}s:10:"\0*\0guarded";a:1:{i:0;s:1:"*";}}}s:10:"\0*\0touches";a:0:{}s:27:"\0*\0relationAutoloadCallback";N;s:26:"\0*\0relationAutoloadContext";N;s:10:"timestamps";b:1;s:13:"usesUniqueIds";b:0;s:9:"\0*\0hidden";a:0:{}s:10:"\0*\0visible";a:0:{}s:11:"\0*\0fillable";a:7:{i:0;s:8:"tutor_id";i:1;s:10:"student_id";i:2;s:10:"subject_id";i:3;s:11:"day_of_week";i:4;s:10:"time_start";i:5;s:8:"time_end";i:6;s:9:"is_active";}s:10:"\0*\0guarded";a:1:{i:0;s:1:"*";}}i:2;O:19:"App\\Models\\Schedule":33:{s:13:"\0*\0connection";s:5:"mysql";s:8:"\0*\0table";s:9:"schedules";s:13:"\0*\0primaryKey";s:2:"id";s:10:"\0*\0keyType";s:3:"int";s:12:"incrementing";b:1;s:7:"\0*\0with";a:0:{}s:12:"\0*\0withCount";a:0:{}s:19:"preventsLazyLoading";b:0;s:10:"\0*\0perPage";i:15;s:6:"exists";b:1;s:18:"wasRecentlyCreated";b:0;s:28:"\0*\0escapeWhenCastingToString";b:0;s:13:"\0*\0attributes";a:10:{s:2:"id";i:8;s:8:"tutor_id";i:12;s:10:"student_id";i:4;s:10:"subject_id";i:2;s:11:"day_of_week";s:6:"Monday";s:10:"time_start";s:8:"13:00:00";s:8:"time_end";s:8:"14:30:00";s:9:"is_active";i:1;s:10:"created_at";s:19:"2025-12-23 17:34:22";s:10:"updated_at";s:19:"2025-12-23 17:34:22";}s:11:"\0*\0original";a:10:{s:2:"id";i:8;s:8:"tutor_id";i:12;s:10:"student_id";i:4;s:10:"subject_id";i:2;s:11:"day_of_week";s:6:"Monday";s:10:"time_start";s:8:"13:00:00";s:8:"time_end";s:8:"14:30:00";s:9:"is_active";i:1;s:10:"created_at";s:19:"2025-12-23 17:34:22";s:10:"updated_at";s:19:"2025-12-23 17:34:22";}s:10:"\0*\0changes";a:0:{}s:11:"\0*\0previous";a:0:{}s:8:"\0*\0casts";a:1:{s:9:"is_active";s:7:"boolean";}s:17:"\0*\0classCastCache";a:0:{}s:21:"\0*\0attributeCastCache";a:0:{}s:13:"\0*\0dateFormat";N;s:10:"\0*\0appends";a:0:{}s:19:"\0*\0dispatchesEvents";a:0:{}s:14:"\0*\0observables";a:0:{}s:12:"\0*\0relations";a:2:{s:7:"subject";O:18:"App\\Models\\Subject":33:{s:13:"\0*\0connection";s:5:"mysql";s:8:"\0*\0table";s:8:"subjects";s:13:"\0*\0primaryKey";s:2:"id";s:10:"\0*\0keyType";s:3:"int";s:12:"incrementing";b:1;s:7:"\0*\0with";a:0:{}s:12:"\0*\0withCount";a:0:{}s:19:"preventsLazyLoading";b:0;s:10:"\0*\0perPage";i:15;s:6:"exists";b:1;s:18:"wasRecentlyCreated";b:0;s:28:"\0*\0escapeWhenCastingToString";b:0;s:13:"\0*\0attributes";a:5:{s:2:"id";i:2;s:4:"name";s:3:"IPS";s:4:"slug";s:3:"ips";s:10:"created_at";s:19:"2025-12-19 22:36:55";s:10:"updated_at";s:19:"2025-12-21 05:53:25";}s:11:"\0*\0original";a:5:{s:2:"id";i:2;s:4:"name";s:3:"IPS";s:4:"slug";s:3:"ips";s:10:"created_at";s:19:"2025-12-19 22:36:55";s:10:"updated_at";s:19:"2025-12-21 05:53:25";}s:10:"\0*\0changes";a:0:{}s:11:"\0*\0previous";a:0:{}s:8:"\0*\0casts";a:0:{}s:17:"\0*\0classCastCache";a:0:{}s:21:"\0*\0attributeCastCache";a:0:{}s:13:"\0*\0dateFormat";N;s:10:"\0*\0appends";a:0:{}s:19:"\0*\0dispatchesEvents";a:0:{}s:14:"\0*\0observables";a:0:{}s:12:"\0*\0relations";a:0:{}s:10:"\0*\0touches";a:0:{}s:27:"\0*\0relationAutoloadCallback";N;s:26:"\0*\0relationAutoloadContext";N;s:10:"timestamps";b:1;s:13:"usesUniqueIds";b:0;s:9:"\0*\0hidden";a:0:{}s:10:"\0*\0visible";a:0:{}s:11:"\0*\0fillable";a:2:{i:0;s:4:"name";i:1;s:4:"slug";}s:10:"\0*\0guarded";a:1:{i:0;s:1:"*";}}s:7:"student";r:284;}s:10:"\0*\0touches";a:0:{}s:27:"\0*\0relationAutoloadCallback";N;s:26:"\0*\0relationAutoloadContext";N;s:10:"timestamps";b:1;s:13:"usesUniqueIds";b:0;s:9:"\0*\0hidden";a:0:{}s:10:"\0*\0visible";a:0:{}s:11:"\0*\0fillable";a:7:{i:0;s:8:"tutor_id";i:1;s:10:"student_id";i:2;s:10:"subject_id";i:3;s:11:"day_of_week";i:4;s:10:"time_start";i:5;s:8:"time_end";i:6;s:9:"is_active";}s:10:"\0*\0guarded";a:1:{i:0;s:1:"*";}}i:3;O:19:"App\\Models\\Schedule":33:{s:13:"\0*\0connection";s:5:"mysql";s:8:"\0*\0table";s:9:"schedules";s:13:"\0*\0primaryKey";s:2:"id";s:10:"\0*\0keyType";s:3:"int";s:12:"incrementing";b:1;s:7:"\0*\0with";a:0:{}s:12:"\0*\0withCount";a:0:{}s:19:"preventsLazyLoading";b:0;s:10:"\0*\0perPage";i:15;s:6:"exists";b:1;s:18:"wasRecentlyCreated";b:0;s:28:"\0*\0escapeWhenCastingToString";b:0;s:13:"\0*\0attributes";a:10:{s:2:"id";i:9;s:8:"tutor_id";i:12;s:10:"student_id";i:5;s:10:"subject_id";i:1;s:11:"day_of_week";s:8:"Saturday";s:10:"time_start";s:8:"13:00:00";s:8:"time_end";s:8:"14:30:00";s:9:"is_active";i:1;s:10:"created_at";s:19:"2025-12-23 17:34:22";s:10:"updated_at";s:19:"2025-12-23 17:34:22";}s:11:"\0*\0original";a:10:{s:2:"id";i:9;s:8:"tutor_id";i:12;s:10:"student_id";i:5;s:10:"subject_id";i:1;s:11:"day_of_week";s:8:"Saturday";s:10:"time_start";s:8:"13:00:00";s:8:"time_end";s:8:"14:30:00";s:9:"is_active";i:1;s:10:"created_at";s:19:"2025-12-23 17:34:22";s:10:"updated_at";s:19:"2025-12-23 17:34:22";}s:10:"\0*\0changes";a:0:{}s:11:"\0*\0previous";a:0:{}s:8:"\0*\0casts";a:1:{s:9:"is_active";s:7:"boolean";}s:17:"\0*\0classCastCache";a:0:{}s:21:"\0*\0attributeCastCache";a:0:{}s:13:"\0*\0dateFormat";N;s:10:"\0*\0appends";a:0:{}s:19:"\0*\0dispatchesEvents";a:0:{}s:14:"\0*\0observables";a:0:{}s:12:"\0*\0relations";a:2:{s:7:"subject";r:237;s:7:"student";O:18:"App\\Models\\Student":33:{s:13:"\0*\0connection";s:5:"mysql";s:8:"\0*\0table";s:8:"students";s:13:"\0*\0primaryKey";s:2:"id";s:10:"\0*\0keyType";s:3:"int";s:12:"incrementing";b:1;s:7:"\0*\0with";a:0:{}s:12:"\0*\0withCount";a:0:{}s:19:"preventsLazyLoading";b:0;s:10:"\0*\0perPage";i:15;s:6:"exists";b:1;s:18:"wasRecentlyCreated";b:0;s:28:"\0*\0escapeWhenCastingToString";b:0;s:13:"\0*\0attributes";a:15:{s:2:"id";i:5;s:7:"user_id";N;s:4:"name";s:12:"Dewi Lestari";s:8:"nickname";s:4:"Dewi";s:14:"place_of_birth";s:7:"Bandung";s:13:"date_of_birth";s:10:"2011-11-25";s:7:"address";s:24:"Jl. Dago No. 12, Bandung";s:16:"program_interest";s:9:"Mapel SMP";s:18:"profile_photo_path";N;s:12:"parent_phone";s:12:"081234567893";s:15:"whatsapp_number";N;s:13:"school_origin";s:20:"SMP Negeri 5 Bandung";s:14:"class_level_id";i:9;s:10:"created_at";s:19:"2025-12-23 17:32:54";s:10:"updated_at";s:19:"2025-12-23 17:32:54";}s:11:"\0*\0original";a:15:{s:2:"id";i:5;s:7:"user_id";N;s:4:"name";s:12:"Dewi Lestari";s:8:"nickname";s:4:"Dewi";s:14:"place_of_birth";s:7:"Bandung";s:13:"date_of_birth";s:10:"2011-11-25";s:7:"address";s:24:"Jl. Dago No. 12, Bandung";s:16:"program_interest";s:9:"Mapel SMP";s:18:"profile_photo_path";N;s:12:"parent_phone";s:12:"081234567893";s:15:"whatsapp_number";N;s:13:"school_origin";s:20:"SMP Negeri 5 Bandung";s:14:"class_level_id";i:9;s:10:"created_at";s:19:"2025-12-23 17:32:54";s:10:"updated_at";s:19:"2025-12-23 17:32:54";}s:10:"\0*\0changes";a:0:{}s:11:"\0*\0previous";a:0:{}s:8:"\0*\0casts";a:1:{s:13:"date_of_birth";s:4:"date";}s:17:"\0*\0classCastCache";a:0:{}s:21:"\0*\0attributeCastCache";a:0:{}s:13:"\0*\0dateFormat";N;s:10:"\0*\0appends";a:0:{}s:19:"\0*\0dispatchesEvents";a:0:{}s:14:"\0*\0observables";a:0:{}s:12:"\0*\0relations";a:0:{}s:10:"\0*\0touches";a:0:{}s:27:"\0*\0relationAutoloadCallback";N;s:26:"\0*\0relationAutoloadContext";N;s:10:"timestamps";b:1;s:13:"usesUniqueIds";b:0;s:9:"\0*\0hidden";a:0:{}s:10:"\0*\0visible";a:0:{}s:11:"\0*\0fillable";a:12:{i:0;s:7:"user_id";i:1;s:4:"name";i:2;s:8:"nickname";i:3;s:14:"place_of_birth";i:4;s:13:"date_of_birth";i:5;s:7:"address";i:6;s:16:"program_interest";i:7;s:18:"profile_photo_path";i:8;s:12:"parent_phone";i:9;s:15:"whatsapp_number";i:10;s:13:"school_origin";i:11;s:14:"class_level_id";}s:10:"\0*\0guarded";a:1:{i:0;s:1:"*";}}}s:10:"\0*\0touches";a:0:{}s:27:"\0*\0relationAutoloadCallback";N;s:26:"\0*\0relationAutoloadContext";N;s:10:"timestamps";b:1;s:13:"usesUniqueIds";b:0;s:9:"\0*\0hidden";a:0:{}s:10:"\0*\0visible";a:0:{}s:11:"\0*\0fillable";a:7:{i:0;s:8:"tutor_id";i:1;s:10:"student_id";i:2;s:10:"subject_id";i:3;s:11:"day_of_week";i:4;s:10:"time_start";i:5;s:8:"time_end";i:6;s:9:"is_active";}s:10:"\0*\0guarded";a:1:{i:0;s:1:"*";}}i:4;O:19:"App\\Models\\Schedule":33:{s:13:"\0*\0connection";s:5:"mysql";s:8:"\0*\0table";s:9:"schedules";s:13:"\0*\0primaryKey";s:2:"id";s:10:"\0*\0keyType";s:3:"int";s:12:"incrementing";b:1;s:7:"\0*\0with";a:0:{}s:12:"\0*\0withCount";a:0:{}s:19:"preventsLazyLoading";b:0;s:10:"\0*\0perPage";i:15;s:6:"exists";b:1;s:18:"wasRecentlyCreated";b:0;s:28:"\0*\0escapeWhenCastingToString";b:0;s:13:"\0*\0attributes";a:10:{s:2:"id";i:10;s:8:"tutor_id";i:12;s:10:"student_id";i:5;s:10:"subject_id";i:3;s:11:"day_of_week";s:8:"Saturday";s:10:"time_start";s:8:"15:00:00";s:8:"time_end";s:8:"16:30:00";s:9:"is_active";i:1;s:10:"created_at";s:19:"2025-12-23 17:34:22";s:10:"updated_at";s:19:"2025-12-23 17:34:22";}s:11:"\0*\0original";a:10:{s:2:"id";i:10;s:8:"tutor_id";i:12;s:10:"student_id";i:5;s:10:"subject_id";i:3;s:11:"day_of_week";s:8:"Saturday";s:10:"time_start";s:8:"15:00:00";s:8:"time_end";s:8:"16:30:00";s:9:"is_active";i:1;s:10:"created_at";s:19:"2025-12-23 17:34:22";s:10:"updated_at";s:19:"2025-12-23 17:34:22";}s:10:"\0*\0changes";a:0:{}s:11:"\0*\0previous";a:0:{}s:8:"\0*\0casts";a:1:{s:9:"is_active";s:7:"boolean";}s:17:"\0*\0classCastCache";a:0:{}s:21:"\0*\0attributeCastCache";a:0:{}s:13:"\0*\0dateFormat";N;s:10:"\0*\0appends";a:0:{}s:19:"\0*\0dispatchesEvents";a:0:{}s:14:"\0*\0observables";a:0:{}s:12:"\0*\0relations";a:2:{s:7:"subject";r:49;s:7:"student";r:537;}s:10:"\0*\0touches";a:0:{}s:27:"\0*\0relationAutoloadCallback";N;s:26:"\0*\0relationAutoloadContext";N;s:10:"timestamps";b:1;s:13:"usesUniqueIds";b:0;s:9:"\0*\0hidden";a:0:{}s:10:"\0*\0visible";a:0:{}s:11:"\0*\0fillable";a:7:{i:0;s:8:"tutor_id";i:1;s:10:"student_id";i:2;s:10:"subject_id";i:3;s:11:"day_of_week";i:4;s:10:"time_start";i:5;s:8:"time_end";i:6;s:9:"is_active";}s:10:"\0*\0guarded";a:1:{i:0;s:1:"*";}}i:5;O:19:"App\\Models\\Schedule":33:{s:13:"\0*\0connection";s:5:"mysql";s:8:"\0*\0table";s:9:"schedules";s:13:"\0*\0primaryKey";s:2:"id";s:10:"\0*\0keyType";s:3:"int";s:12:"incrementing";b:1;s:7:"\0*\0with";a:0:{}s:12:"\0*\0withCount";a:0:{}s:19:"preventsLazyLoading";b:0;s:10:"\0*\0perPage";i:15;s:6:"exists";b:1;s:18:"wasRecentlyCreated";b:0;s:28:"\0*\0escapeWhenCastingToString";b:0;s:13:"\0*\0attributes";a:10:{s:2:"id";i:5;s:8:"tutor_id";i:12;s:10:"student_id";i:3;s:10:"subject_id";i:1;s:11:"day_of_week";s:8:"Saturday";s:10:"time_start";s:8:"16:00:00";s:8:"time_end";s:8:"17:30:00";s:9:"is_active";i:1;s:10:"created_at";s:19:"2025-12-23 17:34:22";s:10:"updated_at";s:19:"2025-12-23 17:34:22";}s:11:"\0*\0original";a:10:{s:2:"id";i:5;s:8:"tutor_id";i:12;s:10:"student_id";i:3;s:10:"subject_id";i:1;s:11:"day_of_week";s:8:"Saturday";s:10:"time_start";s:8:"16:00:00";s:8:"time_end";s:8:"17:30:00";s:9:"is_active";i:1;s:10:"created_at";s:19:"2025-12-23 17:34:22";s:10:"updated_at";s:19:"2025-12-23 17:34:22";}s:10:"\0*\0changes";a:0:{}s:11:"\0*\0previous";a:0:{}s:8:"\0*\0casts";a:1:{s:9:"is_active";s:7:"boolean";}s:17:"\0*\0classCastCache";a:0:{}s:21:"\0*\0attributeCastCache";a:0:{}s:13:"\0*\0dateFormat";N;s:10:"\0*\0appends";a:0:{}s:19:"\0*\0dispatchesEvents";a:0:{}s:14:"\0*\0observables";a:0:{}s:12:"\0*\0relations";a:2:{s:7:"subject";r:237;s:7:"student";r:96;}s:10:"\0*\0touches";a:0:{}s:27:"\0*\0relationAutoloadCallback";N;s:26:"\0*\0relationAutoloadContext";N;s:10:"timestamps";b:1;s:13:"usesUniqueIds";b:0;s:9:"\0*\0hidden";a:0:{}s:10:"\0*\0visible";a:0:{}s:11:"\0*\0fillable";a:7:{i:0;s:8:"tutor_id";i:1;s:10:"student_id";i:2;s:10:"subject_id";i:3;s:11:"day_of_week";i:4;s:10:"time_start";i:5;s:8:"time_end";i:6;s:9:"is_active";}s:10:"\0*\0guarded";a:1:{i:0;s:1:"*";}}i:6;O:19:"App\\Models\\Schedule":33:{s:13:"\0*\0connection";s:5:"mysql";s:8:"\0*\0table";s:9:"schedules";s:13:"\0*\0primaryKey";s:2:"id";s:10:"\0*\0keyType";s:3:"int";s:12:"incrementing";b:1;s:7:"\0*\0with";a:0:{}s:12:"\0*\0withCount";a:0:{}s:19:"preventsLazyLoading";b:0;s:10:"\0*\0perPage";i:15;s:6:"exists";b:1;s:18:"wasRecentlyCreated";b:0;s:28:"\0*\0escapeWhenCastingToString";b:0;s:13:"\0*\0attributes";a:10:{s:2:"id";i:13;s:8:"tutor_id";i:12;s:10:"student_id";i:7;s:10:"subject_id";i:3;s:11:"day_of_week";s:8:"Thursday";s:10:"time_start";s:8:"14:00:00";s:8:"time_end";s:8:"15:30:00";s:9:"is_active";i:1;s:10:"created_at";s:19:"2025-12-23 17:34:22";s:10:"updated_at";s:19:"2025-12-23 17:34:22";}s:11:"\0*\0original";a:10:{s:2:"id";i:13;s:8:"tutor_id";i:12;s:10:"student_id";i:7;s:10:"subject_id";i:3;s:11:"day_of_week";s:8:"Thursday";s:10:"time_start";s:8:"14:00:00";s:8:"time_end";s:8:"15:30:00";s:9:"is_active";i:1;s:10:"created_at";s:19:"2025-12-23 17:34:22";s:10:"updated_at";s:19:"2025-12-23 17:34:22";}s:10:"\0*\0changes";a:0:{}s:11:"\0*\0previous";a:0:{}s:8:"\0*\0casts";a:1:{s:9:"is_active";s:7:"boolean";}s:17:"\0*\0classCastCache";a:0:{}s:21:"\0*\0attributeCastCache";a:0:{}s:13:"\0*\0dateFormat";N;s:10:"\0*\0appends";a:0:{}s:19:"\0*\0dispatchesEvents";a:0:{}s:14:"\0*\0observables";a:0:{}s:12:"\0*\0relations";a:2:{s:7:"subject";r:49;s:7:"student";O:18:"App\\Models\\Student":33:{s:13:"\0*\0connection";s:5:"mysql";s:8:"\0*\0table";s:8:"students";s:13:"\0*\0primaryKey";s:2:"id";s:10:"\0*\0keyType";s:3:"int";s:12:"incrementing";b:1;s:7:"\0*\0with";a:0:{}s:12:"\0*\0withCount";a:0:{}s:19:"preventsLazyLoading";b:0;s:10:"\0*\0perPage";i:15;s:6:"exists";b:1;s:18:"wasRecentlyCreated";b:0;s:28:"\0*\0escapeWhenCastingToString";b:0;s:13:"\0*\0attributes";a:15:{s:2:"id";i:7;s:7:"user_id";N;s:4:"name";s:12:"Kartika Sari";s:8:"nickname";s:7:"Kartika";s:14:"place_of_birth";s:8:"Surabaya";s:13:"date_of_birth";s:10:"2016-09-30";s:7:"address";s:31:"Jl. Diponegoro No. 56, Surabaya";s:16:"program_interest";s:7:"Tahfidz";s:18:"profile_photo_path";N;s:12:"parent_phone";s:12:"081234567895";s:15:"whatsapp_number";N;s:13:"school_origin";s:18:"SD Plus Al-Kautsar";s:14:"class_level_id";i:1;s:10:"created_at";s:19:"2025-12-23 17:32:54";s:10:"updated_at";s:19:"2025-12-23 17:32:54";}s:11:"\0*\0original";a:15:{s:2:"id";i:7;s:7:"user_id";N;s:4:"name";s:12:"Kartika Sari";s:8:"nickname";s:7:"Kartika";s:14:"place_of_birth";s:8:"Surabaya";s:13:"date_of_birth";s:10:"2016-09-30";s:7:"address";s:31:"Jl. Diponegoro No. 56, Surabaya";s:16:"program_interest";s:7:"Tahfidz";s:18:"profile_photo_path";N;s:12:"parent_phone";s:12:"081234567895";s:15:"whatsapp_number";N;s:13:"school_origin";s:18:"SD Plus Al-Kautsar";s:14:"class_level_id";i:1;s:10:"created_at";s:19:"2025-12-23 17:32:54";s:10:"updated_at";s:19:"2025-12-23 17:32:54";}s:10:"\0*\0changes";a:0:{}s:11:"\0*\0previous";a:0:{}s:8:"\0*\0casts";a:1:{s:13:"date_of_birth";s:4:"date";}s:17:"\0*\0classCastCache";a:0:{}s:21:"\0*\0attributeCastCache";a:0:{}s:13:"\0*\0dateFormat";N;s:10:"\0*\0appends";a:0:{}s:19:"\0*\0dispatchesEvents";a:0:{}s:14:"\0*\0observables";a:0:{}s:12:"\0*\0relations";a:0:{}s:10:"\0*\0touches";a:0:{}s:27:"\0*\0relationAutoloadCallback";N;s:26:"\0*\0relationAutoloadContext";N;s:10:"timestamps";b:1;s:13:"usesUniqueIds";b:0;s:9:"\0*\0hidden";a:0:{}s:10:"\0*\0visible";a:0:{}s:11:"\0*\0fillable";a:12:{i:0;s:7:"user_id";i:1;s:4:"name";i:2;s:8:"nickname";i:3;s:14:"place_of_birth";i:4;s:13:"date_of_birth";i:5;s:7:"address";i:6;s:16:"program_interest";i:7;s:18:"profile_photo_path";i:8;s:12:"parent_phone";i:9;s:15:"whatsapp_number";i:10;s:13:"school_origin";i:11;s:14:"class_level_id";}s:10:"\0*\0guarded";a:1:{i:0;s:1:"*";}}}s:10:"\0*\0touches";a:0:{}s:27:"\0*\0relationAutoloadCallback";N;s:26:"\0*\0relationAutoloadContext";N;s:10:"timestamps";b:1;s:13:"usesUniqueIds";b:0;s:9:"\0*\0hidden";a:0:{}s:10:"\0*\0visible";a:0:{}s:11:"\0*\0fillable";a:7:{i:0;s:8:"tutor_id";i:1;s:10:"student_id";i:2;s:10:"subject_id";i:3;s:11:"day_of_week";i:4;s:10:"time_start";i:5;s:8:"time_end";i:6;s:9:"is_active";}s:10:"\0*\0guarded";a:1:{i:0;s:1:"*";}}i:7;O:19:"App\\Models\\Schedule":33:{s:13:"\0*\0connection";s:5:"mysql";s:8:"\0*\0table";s:9:"schedules";s:13:"\0*\0primaryKey";s:2:"id";s:10:"\0*\0keyType";s:3:"int";s:12:"incrementing";b:1;s:7:"\0*\0with";a:0:{}s:12:"\0*\0withCount";a:0:{}s:19:"preventsLazyLoading";b:0;s:10:"\0*\0perPage";i:15;s:6:"exists";b:1;s:18:"wasRecentlyCreated";b:0;s:28:"\0*\0escapeWhenCastingToString";b:0;s:13:"\0*\0attributes";a:10:{s:2:"id";i:11;s:8:"tutor_id";i:12;s:10:"student_id";i:6;s:10:"subject_id";i:3;s:11:"day_of_week";s:8:"Thursday";s:10:"time_start";s:8:"16:00:00";s:8:"time_end";s:8:"17:30:00";s:9:"is_active";i:1;s:10:"created_at";s:19:"2025-12-23 17:34:22";s:10:"updated_at";s:19:"2025-12-23 17:34:22";}s:11:"\0*\0original";a:10:{s:2:"id";i:11;s:8:"tutor_id";i:12;s:10:"student_id";i:6;s:10:"subject_id";i:3;s:11:"day_of_week";s:8:"Thursday";s:10:"time_start";s:8:"16:00:00";s:8:"time_end";s:8:"17:30:00";s:9:"is_active";i:1;s:10:"created_at";s:19:"2025-12-23 17:34:22";s:10:"updated_at";s:19:"2025-12-23 17:34:22";}s:10:"\0*\0changes";a:0:{}s:11:"\0*\0previous";a:0:{}s:8:"\0*\0casts";a:1:{s:9:"is_active";s:7:"boolean";}s:17:"\0*\0classCastCache";a:0:{}s:21:"\0*\0attributeCastCache";a:0:{}s:13:"\0*\0dateFormat";N;s:10:"\0*\0appends";a:0:{}s:19:"\0*\0dispatchesEvents";a:0:{}s:14:"\0*\0observables";a:0:{}s:12:"\0*\0relations";a:2:{s:7:"subject";r:49;s:7:"student";O:18:"App\\Models\\Student":33:{s:13:"\0*\0connection";s:5:"mysql";s:8:"\0*\0table";s:8:"students";s:13:"\0*\0primaryKey";s:2:"id";s:10:"\0*\0keyType";s:3:"int";s:12:"incrementing";b:1;s:7:"\0*\0with";a:0:{}s:12:"\0*\0withCount";a:0:{}s:19:"preventsLazyLoading";b:0;s:10:"\0*\0perPage";i:15;s:6:"exists";b:1;s:18:"wasRecentlyCreated";b:0;s:28:"\0*\0escapeWhenCastingToString";b:0;s:13:"\0*\0attributes";a:15:{s:2:"id";i:6;s:7:"user_id";N;s:4:"name";s:14:"Muhammad Fahri";s:8:"nickname";s:5:"Fahri";s:14:"place_of_birth";s:10:"Yogyakarta";s:13:"date_of_birth";s:10:"2018-01-05";s:7:"address";s:30:"Jl. Kaliurang KM 5, Yogyakarta";s:16:"program_interest";s:7:"Tahfidz";s:18:"profile_photo_path";N;s:12:"parent_phone";s:12:"081234567894";s:15:"whatsapp_number";N;s:13:"school_origin";s:11:"TK Al-Quran";s:14:"class_level_id";i:15;s:10:"created_at";s:19:"2025-12-23 17:32:54";s:10:"updated_at";s:19:"2025-12-23 17:32:54";}s:11:"\0*\0original";a:15:{s:2:"id";i:6;s:7:"user_id";N;s:4:"name";s:14:"Muhammad Fahri";s:8:"nickname";s:5:"Fahri";s:14:"place_of_birth";s:10:"Yogyakarta";s:13:"date_of_birth";s:10:"2018-01-05";s:7:"address";s:30:"Jl. Kaliurang KM 5, Yogyakarta";s:16:"program_interest";s:7:"Tahfidz";s:18:"profile_photo_path";N;s:12:"parent_phone";s:12:"081234567894";s:15:"whatsapp_number";N;s:13:"school_origin";s:11:"TK Al-Quran";s:14:"class_level_id";i:15;s:10:"created_at";s:19:"2025-12-23 17:32:54";s:10:"updated_at";s:19:"2025-12-23 17:32:54";}s:10:"\0*\0changes";a:0:{}s:11:"\0*\0previous";a:0:{}s:8:"\0*\0casts";a:1:{s:13:"date_of_birth";s:4:"date";}s:17:"\0*\0classCastCache";a:0:{}s:21:"\0*\0attributeCastCache";a:0:{}s:13:"\0*\0dateFormat";N;s:10:"\0*\0appends";a:0:{}s:19:"\0*\0dispatchesEvents";a:0:{}s:14:"\0*\0observables";a:0:{}s:12:"\0*\0relations";a:0:{}s:10:"\0*\0touches";a:0:{}s:27:"\0*\0relationAutoloadCallback";N;s:26:"\0*\0relationAutoloadContext";N;s:10:"timestamps";b:1;s:13:"usesUniqueIds";b:0;s:9:"\0*\0hidden";a:0:{}s:10:"\0*\0visible";a:0:{}s:11:"\0*\0fillable";a:12:{i:0;s:7:"user_id";i:1;s:4:"name";i:2;s:8:"nickname";i:3;s:14:"place_of_birth";i:4;s:13:"date_of_birth";i:5;s:7:"address";i:6;s:16:"program_interest";i:7;s:18:"profile_photo_path";i:8;s:12:"parent_phone";i:9;s:15:"whatsapp_number";i:10;s:13:"school_origin";i:11;s:14:"class_level_id";}s:10:"\0*\0guarded";a:1:{i:0;s:1:"*";}}}s:10:"\0*\0touches";a:0:{}s:27:"\0*\0relationAutoloadCallback";N;s:26:"\0*\0relationAutoloadContext";N;s:10:"timestamps";b:1;s:13:"usesUniqueIds";b:0;s:9:"\0*\0hidden";a:0:{}s:10:"\0*\0visible";a:0:{}s:11:"\0*\0fillable";a:7:{i:0;s:8:"tutor_id";i:1;s:10:"student_id";i:2;s:10:"subject_id";i:3;s:11:"day_of_week";i:4;s:10:"time_start";i:5;s:8:"time_end";i:6;s:9:"is_active";}s:10:"\0*\0guarded";a:1:{i:0;s:1:"*";}}i:8;O:19:"App\\Models\\Schedule":33:{s:13:"\0*\0connection";s:5:"mysql";s:8:"\0*\0table";s:9:"schedules";s:13:"\0*\0primaryKey";s:2:"id";s:10:"\0*\0keyType";s:3:"int";s:12:"incrementing";b:1;s:7:"\0*\0with";a:0:{}s:12:"\0*\0withCount";a:0:{}s:19:"preventsLazyLoading";b:0;s:10:"\0*\0perPage";i:15;s:6:"exists";b:1;s:18:"wasRecentlyCreated";b:0;s:28:"\0*\0escapeWhenCastingToString";b:0;s:13:"\0*\0attributes";a:10:{s:2:"id";i:2;s:8:"tutor_id";i:12;s:10:"student_id";i:1;s:10:"subject_id";i:2;s:11:"day_of_week";s:7:"Tuesday";s:10:"time_start";s:8:"13:00:00";s:8:"time_end";s:8:"14:30:00";s:9:"is_active";i:1;s:10:"created_at";s:19:"2025-12-23 17:34:21";s:10:"updated_at";s:19:"2025-12-23 17:34:21";}s:11:"\0*\0original";a:10:{s:2:"id";i:2;s:8:"tutor_id";i:12;s:10:"student_id";i:1;s:10:"subject_id";i:2;s:11:"day_of_week";s:7:"Tuesday";s:10:"time_start";s:8:"13:00:00";s:8:"time_end";s:8:"14:30:00";s:9:"is_active";i:1;s:10:"created_at";s:19:"2025-12-23 17:34:21";s:10:"updated_at";s:19:"2025-12-23 17:34:21";}s:10:"\0*\0changes";a:0:{}s:11:"\0*\0previous";a:0:{}s:8:"\0*\0casts";a:1:{s:9:"is_active";s:7:"boolean";}s:17:"\0*\0classCastCache";a:0:{}s:21:"\0*\0attributeCastCache";a:0:{}s:13:"\0*\0dateFormat";N;s:10:"\0*\0appends";a:0:{}s:19:"\0*\0dispatchesEvents";a:0:{}s:14:"\0*\0observables";a:0:{}s:12:"\0*\0relations";a:2:{s:7:"subject";r:425;s:7:"student";O:18:"App\\Models\\Student":33:{s:13:"\0*\0connection";s:5:"mysql";s:8:"\0*\0table";s:8:"students";s:13:"\0*\0primaryKey";s:2:"id";s:10:"\0*\0keyType";s:3:"int";s:12:"incrementing";b:1;s:7:"\0*\0with";a:0:{}s:12:"\0*\0withCount";a:0:{}s:19:"preventsLazyLoading";b:0;s:10:"\0*\0perPage";i:15;s:6:"exists";b:1;s:18:"wasRecentlyCreated";b:0;s:28:"\0*\0escapeWhenCastingToString";b:0;s:13:"\0*\0attributes";a:15:{s:2:"id";i:1;s:7:"user_id";i:11;s:4:"name";s:4:"Juki";s:8:"nickname";s:4:"Tepe";s:14:"place_of_birth";N;s:13:"date_of_birth";s:10:"2025-12-20";s:7:"address";s:58:"JL. Derpoyudo, Munggur Kidul RT 03 RW 13 Bejen Karanganyar";s:16:"program_interest";s:7:"Tahfidz";s:18:"profile_photo_path";s:59:"profile-photos/pRuxIHY1RH8RMqSYv1d7bMKDmsNE3QUh0V1VJYUT.jpg";s:12:"parent_phone";s:11:"08572526535";s:15:"whatsapp_number";N;s:13:"school_origin";s:17:"MAN 1 Karanganyar";s:14:"class_level_id";i:2;s:10:"created_at";s:19:"2025-12-18 19:41:25";s:10:"updated_at";s:19:"2025-12-23 15:16:50";}s:11:"\0*\0original";a:15:{s:2:"id";i:1;s:7:"user_id";i:11;s:4:"name";s:4:"Juki";s:8:"nickname";s:4:"Tepe";s:14:"place_of_birth";N;s:13:"date_of_birth";s:10:"2025-12-20";s:7:"address";s:58:"JL. Derpoyudo, Munggur Kidul RT 03 RW 13 Bejen Karanganyar";s:16:"program_interest";s:7:"Tahfidz";s:18:"profile_photo_path";s:59:"profile-photos/pRuxIHY1RH8RMqSYv1d7bMKDmsNE3QUh0V1VJYUT.jpg";s:12:"parent_phone";s:11:"08572526535";s:15:"whatsapp_number";N;s:13:"school_origin";s:17:"MAN 1 Karanganyar";s:14:"class_level_id";i:2;s:10:"created_at";s:19:"2025-12-18 19:41:25";s:10:"updated_at";s:19:"2025-12-23 15:16:50";}s:10:"\0*\0changes";a:0:{}s:11:"\0*\0previous";a:0:{}s:8:"\0*\0casts";a:1:{s:13:"date_of_birth";s:4:"date";}s:17:"\0*\0classCastCache";a:0:{}s:21:"\0*\0attributeCastCache";a:0:{}s:13:"\0*\0dateFormat";N;s:10:"\0*\0appends";a:0:{}s:19:"\0*\0dispatchesEvents";a:0:{}s:14:"\0*\0observables";a:0:{}s:12:"\0*\0relations";a:0:{}s:10:"\0*\0touches";a:0:{}s:27:"\0*\0relationAutoloadCallback";N;s:26:"\0*\0relationAutoloadContext";N;s:10:"timestamps";b:1;s:13:"usesUniqueIds";b:0;s:9:"\0*\0hidden";a:0:{}s:10:"\0*\0visible";a:0:{}s:11:"\0*\0fillable";a:12:{i:0;s:7:"user_id";i:1;s:4:"name";i:2;s:8:"nickname";i:3;s:14:"place_of_birth";i:4;s:13:"date_of_birth";i:5;s:7:"address";i:6;s:16:"program_interest";i:7;s:18:"profile_photo_path";i:8;s:12:"parent_phone";i:9;s:15:"whatsapp_number";i:10;s:13:"school_origin";i:11;s:14:"class_level_id";}s:10:"\0*\0guarded";a:1:{i:0;s:1:"*";}}}s:10:"\0*\0touches";a:0:{}s:27:"\0*\0relationAutoloadCallback";N;s:26:"\0*\0relationAutoloadContext";N;s:10:"timestamps";b:1;s:13:"usesUniqueIds";b:0;s:9:"\0*\0hidden";a:0:{}s:10:"\0*\0visible";a:0:{}s:11:"\0*\0fillable";a:7:{i:0;s:8:"tutor_id";i:1;s:10:"student_id";i:2;s:10:"subject_id";i:3;s:11:"day_of_week";i:4;s:10:"time_start";i:5;s:8:"time_end";i:6;s:9:"is_active";}s:10:"\0*\0guarded";a:1:{i:0;s:1:"*";}}i:9;O:19:"App\\Models\\Schedule":33:{s:13:"\0*\0connection";s:5:"mysql";s:8:"\0*\0table";s:9:"schedules";s:13:"\0*\0primaryKey";s:2:"id";s:10:"\0*\0keyType";s:3:"int";s:12:"incrementing";b:1;s:7:"\0*\0with";a:0:{}s:12:"\0*\0withCount";a:0:{}s:19:"preventsLazyLoading";b:0;s:10:"\0*\0perPage";i:15;s:6:"exists";b:1;s:18:"wasRecentlyCreated";b:0;s:28:"\0*\0escapeWhenCastingToString";b:0;s:13:"\0*\0attributes";a:10:{s:2:"id";i:3;s:8:"tutor_id";i:12;s:10:"student_id";i:1;s:10:"subject_id";i:3;s:11:"day_of_week";s:7:"Tuesday";s:10:"time_start";s:8:"16:00:00";s:8:"time_end";s:8:"17:30:00";s:9:"is_active";i:1;s:10:"created_at";s:19:"2025-12-23 17:34:22";s:10:"updated_at";s:19:"2025-12-23 17:34:22";}s:11:"\0*\0original";a:10:{s:2:"id";i:3;s:8:"tutor_id";i:12;s:10:"student_id";i:1;s:10:"subject_id";i:3;s:11:"day_of_week";s:7:"Tuesday";s:10:"time_start";s:8:"16:00:00";s:8:"time_end";s:8:"17:30:00";s:9:"is_active";i:1;s:10:"created_at";s:19:"2025-12-23 17:34:22";s:10:"updated_at";s:19:"2025-12-23 17:34:22";}s:10:"\0*\0changes";a:0:{}s:11:"\0*\0previous";a:0:{}s:8:"\0*\0casts";a:1:{s:9:"is_active";s:7:"boolean";}s:17:"\0*\0classCastCache";a:0:{}s:21:"\0*\0attributeCastCache";a:0:{}s:13:"\0*\0dateFormat";N;s:10:"\0*\0appends";a:0:{}s:19:"\0*\0dispatchesEvents";a:0:{}s:14:"\0*\0observables";a:0:{}s:12:"\0*\0relations";a:2:{s:7:"subject";r:49;s:7:"student";r:1093;}s:10:"\0*\0touches";a:0:{}s:27:"\0*\0relationAutoloadCallback";N;s:26:"\0*\0relationAutoloadContext";N;s:10:"timestamps";b:1;s:13:"usesUniqueIds";b:0;s:9:"\0*\0hidden";a:0:{}s:10:"\0*\0visible";a:0:{}s:11:"\0*\0fillable";a:7:{i:0;s:8:"tutor_id";i:1;s:10:"student_id";i:2;s:10:"subject_id";i:3;s:11:"day_of_week";i:4;s:10:"time_start";i:5;s:8:"time_end";i:6;s:9:"is_active";}s:10:"\0*\0guarded";a:1:{i:0;s:1:"*";}}}s:28:"\0*\0escapeWhenCastingToString";b:0;}', 1766519487);

-- Dumping structure for table lms_db.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table lms_db.cache_locks: ~0 rows (approximately)

-- Dumping structure for table lms_db.class_levels
CREATE TABLE IF NOT EXISTS `class_levels` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table lms_db.class_levels: ~15 rows (approximately)
INSERT INTO `class_levels` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(1, 'SD Kelas 1', '2025-12-18 12:41:25', '2025-12-18 12:41:25'),
	(2, 'SMA kelas 1', '2025-12-19 15:41:00', '2025-12-19 15:41:00'),
	(3, 'TK', '2025-12-23 10:32:54', '2025-12-23 10:32:54'),
	(4, 'SD Kelas 2', '2025-12-23 10:32:54', '2025-12-23 10:32:54'),
	(5, 'SD Kelas 3', '2025-12-23 10:32:54', '2025-12-23 10:32:54'),
	(6, 'SD Kelas 4', '2025-12-23 10:32:54', '2025-12-23 10:32:54'),
	(7, 'SD Kelas 5', '2025-12-23 10:32:54', '2025-12-23 10:32:54'),
	(8, 'SD Kelas 6', '2025-12-23 10:32:54', '2025-12-23 10:32:54'),
	(9, 'SMP Kelas 7', '2025-12-23 10:32:54', '2025-12-23 10:32:54'),
	(10, 'SMP Kelas 8', '2025-12-23 10:32:54', '2025-12-23 10:32:54'),
	(11, 'SMP Kelas 9', '2025-12-23 10:32:54', '2025-12-23 10:32:54'),
	(12, 'SMA Kelas 10', '2025-12-23 10:32:54', '2025-12-23 10:32:54'),
	(13, 'SMA Kelas 11', '2025-12-23 10:32:54', '2025-12-23 10:32:54'),
	(14, 'SMA Kelas 12', '2025-12-23 10:32:54', '2025-12-23 10:32:54'),
	(15, 'Tahfidz', '2025-12-23 10:32:54', '2025-12-23 10:32:54');

-- Dumping structure for table lms_db.documentations
CREATE TABLE IF NOT EXISTS `documentations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `type` enum('photo','video') NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `category` enum('Kegiatan Belajar','Event','Karya Siswa','Testimoni','Quotes','Lainnya') DEFAULT 'Kegiatan Belajar',
  `event_date` date DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `documentations_title_index` (`title`),
  KEY `documentations_type_index` (`type`),
  KEY `documentations_category_index` (`category`),
  KEY `documentations_is_published_index` (`is_published`),
  KEY `documentations_sort_order_index` (`sort_order`),
  KEY `documentations_event_date_index` (`event_date`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table lms_db.documentations: ~0 rows (approximately)
INSERT INTO `documentations` (`id`, `title`, `description`, `type`, `file_path`, `video_url`, `thumbnail`, `category`, `event_date`, `is_published`, `sort_order`, `created_at`, `updated_at`) VALUES
	(1, 'ASDASD', 'ASDASD', 'photo', 'documentations/QluYjnCRdWj4g77jDu3SgCbEBySXQHK2mo8OqLYt.png', NULL, NULL, 'Quotes', '2025-12-20', 1, 0, '2025-12-20 05:55:34', '2025-12-20 05:55:34');

-- Dumping structure for table lms_db.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table lms_db.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table lms_db.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table lms_db.jobs: ~0 rows (approximately)

-- Dumping structure for table lms_db.job_batches
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table lms_db.job_batches: ~0 rows (approximately)

-- Dumping structure for table lms_db.materials
CREATE TABLE IF NOT EXISTS `materials` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `subject_id` bigint(20) unsigned NOT NULL,
  `class_level_id` bigint(20) unsigned NOT NULL,
  `tutor_id` bigint(20) unsigned DEFAULT NULL,
  `uploaded_by` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `materials_subject_id_index` (`subject_id`),
  KEY `materials_class_level_id_index` (`class_level_id`),
  KEY `materials_uploaded_by_index` (`uploaded_by`),
  KEY `materials_title_index` (`title`),
  KEY `materials_tutor_id_foreign` (`tutor_id`),
  CONSTRAINT `materials_class_level_id_foreign` FOREIGN KEY (`class_level_id`) REFERENCES `class_levels` (`id`) ON DELETE CASCADE,
  CONSTRAINT `materials_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE,
  CONSTRAINT `materials_tutor_id_foreign` FOREIGN KEY (`tutor_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `materials_uploaded_by_foreign` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table lms_db.materials: ~6 rows (approximately)
INSERT INTO `materials` (`id`, `title`, `description`, `file_path`, `video_url`, `subject_id`, `class_level_id`, `tutor_id`, `uploaded_by`, `created_at`, `updated_at`) VALUES
	(1, 'matematika-berhitung', 'asdadsadads', 'materials/an3lIiFfBVweEhaMFAxtSHG7xY8ftQW50J12uZo6.pdf', NULL, 1, 1, 5, 2, '2025-12-19 16:07:20', '2025-12-19 16:07:20'),
	(2, 'INI', '<p style="text-align: left;">ASDASD ASD SAD AS </p>', 'materials/kzWpSZlCtQ93ck9iKVBRuFNzgdaWmLtzZfuLQWZE.pdf', NULL, 3, 1, 5, 5, '2025-12-20 07:16:45', '2025-12-20 07:16:45'),
	(3, 'sjkhakjsd', '<p style="text-align: left;">jangan lupa dipelajari</p>', 'materials/VnON0PJcVv15UvhBptdkgEJMFi6n8nEl74UASZkS.pdf', NULL, 3, 2, 5, 5, '2025-12-20 23:45:28', '2025-12-20 23:45:28'),
	(4, 'Modul Belajar Matematika - Bab 4', 'Materi pembelajaran lengkap untuk Matematika tingkat dasar dan menengah. Mencakup teori dan latihan soal.', NULL, NULL, 1, 12, 12, 12, '2025-12-23 10:34:21', '2025-12-23 10:34:21'),
	(5, 'Modul Belajar IPS - Bab 2', 'Materi pembelajaran lengkap untuk IPS tingkat dasar dan menengah. Mencakup teori dan latihan soal.', NULL, NULL, 2, 2, 12, 12, '2025-12-23 10:34:21', '2025-12-23 10:34:21'),
	(6, 'Modul Belajar Bahasa Indonesia - Bab 1', 'Materi pembelajaran lengkap untuk Bahasa Indonesia tingkat dasar dan menengah. Mencakup teori dan latihan soal.', NULL, NULL, 3, 10, 12, 12, '2025-12-23 10:34:21', '2025-12-23 10:34:21');

-- Dumping structure for table lms_db.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table lms_db.migrations: ~29 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '0001_01_01_000001_create_cache_table', 1),
	(3, '0001_01_01_000002_create_jobs_table', 1),
	(4, '2025_12_07_061826_add_role_avatar_bio_to_users_table', 1),
	(5, '2025_12_07_061828_create_subjects_table', 1),
	(6, '2025_12_07_061829_create_class_levels_table', 1),
	(7, '2025_12_07_061831_create_students_table', 1),
	(8, '2025_12_07_061832_create_materials_table', 1),
	(9, '2025_12_07_061833_create_attendances_table', 1),
	(10, '2025_12_07_061833_create_schedules_table', 1),
	(11, '2025_12_07_070613_add_schedule_foreign_key_to_attendances_table', 2),
	(12, '2025_12_07_071936_create_student_reports_table', 3),
	(13, '2025_12_15_041954_create_posts_table', 4),
	(14, '2025_12_15_170000_add_indexes_for_performance', 5),
	(15, '2025_01_16_000000_add_indexes_to_student_reports', 6),
	(16, '2025_12_16_000000_create_registrations_table', 6),
	(17, '2025_12_16_100000_add_additional_fields_to_students_table', 6),
	(18, '2025_12_16_110000_add_password_to_registrations_table', 6),
	(19, '2025_01_16_000001_add_composite_indexes_for_performance', 7),
	(21, '2025_12_17_171137_create_documentations_table', 8),
	(22, '2025_01_17_000001_add_indexes_for_filament_performance', 9),
	(23, '2025_01_20_000000_create_personal_access_tokens_table', 10),
	(24, '2025_12_17_000000_add_fields_to_registrations_table', 11),
	(25, '2025_12_18_231528_create_testimonials_table', 12),
	(26, '2025_12_18_231609_add_indexes_to_testimonials_table', 13),
	(27, '2025_12_19_000016_create_bimbel_journals_table', 14),
	(28, '2025_12_19_152558_add_schedule_id_to_bimbel_journals_table', 15),
	(29, '2025_12_19_224534_add_tutor_id_to_materials_table', 15),
	(30, '2025_12_19_231227_add_quotes_to_documentations_category_enum', 16),
	(31, '2025_12_20_145603_add_sick_status_to_attendances_table', 17),
	(32, '2025_12_21_183118_add_whatsapp_number_to_students_table', 17),
	(33, '2025_12_23_165234_add_phone_number_to_users_table', 18);

-- Dumping structure for table lms_db.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table lms_db.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table lms_db.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table lms_db.personal_access_tokens: ~28 rows (approximately)
INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
	(1, 'App\\Models\\User', 2, 'api-token', '31b7760226de3c655d89d09f2ec28966c4ad774cbed5aab3e4e1a20e54c0fbd6', '["*"]', NULL, '2026-01-16 16:00:45', '2025-12-17 16:00:45', '2025-12-17 16:00:45'),
	(2, 'App\\Models\\User', 2, 'api-token', 'acd29b42ae52e0da20886abf4d778b997ea9b39e4a9472c7369addb92b04fe99', '["*"]', '2025-12-18 12:14:50', '2026-01-17 12:14:47', '2025-12-18 12:14:47', '2025-12-18 12:14:50'),
	(3, 'App\\Models\\User', 11, 'api-token', 'a5d8dcbe212a6cc7ad201ddf78f523fa7eb54cfa501c3278f9638c66dae430a0', '["*"]', '2025-12-18 12:42:26', '2026-01-17 12:42:15', '2025-12-18 12:42:15', '2025-12-18 12:42:26'),
	(4, 'App\\Models\\User', 11, 'api-token', 'e34487155f72f30d384bad8ca29f372e8af11837862043feeb4009bc8ec6f196', '["*"]', '2025-12-18 12:51:13', '2026-01-17 12:51:03', '2025-12-18 12:51:03', '2025-12-18 12:51:13'),
	(5, 'App\\Models\\User', 2, 'api-token', 'c6110a97d25980bed67585e7d1198a2a2e7ece846ab13e1f30b9b490df3d0a82', '["*"]', '2025-12-18 13:07:22', '2026-01-17 12:56:23', '2025-12-18 12:56:23', '2025-12-18 13:07:22'),
	(6, 'App\\Models\\User', 2, 'api-token', 'd6ae8662a3104390a1fc39a65731101fa9d538128436253892712a7e9d7d8063', '["*"]', '2025-12-18 14:32:54', '2026-01-17 14:31:57', '2025-12-18 14:31:57', '2025-12-18 14:32:54'),
	(7, 'App\\Models\\User', 2, 'api-token', '9881380d403929f53c4f42718d1eb79d42845527d0958767cf65d673ae3136c9', '["*"]', '2025-12-18 14:55:58', '2026-01-17 14:54:54', '2025-12-18 14:54:54', '2025-12-18 14:55:58'),
	(8, 'App\\Models\\User', 2, 'api-token', '359292b612407c9242ebfc17d51a9f5b8bcc1fbb6b6b43e75c847dee7587f0c4', '["*"]', '2025-12-18 15:44:32', '2026-01-17 15:31:08', '2025-12-18 15:31:08', '2025-12-18 15:44:32'),
	(12, 'App\\Models\\User', 2, 'api-token', '9e4478a3baee1aee93bf10b07a71c56e282d5fe17107323592bfadd25ff1ea01', '["*"]', '2025-12-18 21:09:37', '2026-01-17 17:10:15', '2025-12-18 17:10:15', '2025-12-18 21:09:37'),
	(13, 'App\\Models\\User', 2, 'api-token', '7754b212ea6e9749acba40e4bb72a897aee30631f46214196b59a58251e73888', '["*"]', '2025-12-18 21:25:51', '2026-01-17 21:16:10', '2025-12-18 21:16:10', '2025-12-18 21:25:51'),
	(14, 'App\\Models\\User', 2, 'api-token', '3154eda75f90198d08076ccc41c4d7d6ed8f54d3f50980f93e3b63f950c68672', '["*"]', '2025-12-18 22:36:11', '2026-01-17 22:36:03', '2025-12-18 22:36:03', '2025-12-18 22:36:11'),
	(15, 'App\\Models\\User', 2, 'api-token', 'b4803e5b6ec472774154ad8b2b4a743ded3b6aca311cf154d72e670de4c4aacf', '["*"]', '2025-12-18 23:08:45', '2026-01-17 23:08:21', '2025-12-18 23:08:21', '2025-12-18 23:08:45'),
	(16, 'App\\Models\\User', 2, 'api-token', '5af76dc06e30d0aa43779d4587b6cff19119dfb353c519d5d94c7c98b4361dda', '["*"]', '2025-12-18 23:34:18', '2026-01-17 23:34:15', '2025-12-18 23:34:15', '2025-12-18 23:34:18'),
	(17, 'App\\Models\\User', 2, 'api-token', 'be6493a98f60ee79da866f7254193e1e2aa6906a918628a8513128e488161ab2', '["*"]', '2025-12-18 23:54:25', '2026-01-17 23:54:24', '2025-12-18 23:54:24', '2025-12-18 23:54:25'),
	(18, 'App\\Models\\User', 2, 'api-token', 'f67be0d21e3973688742b28be50467492b3417a6812542202a806c3ea62eaaf0', '["*"]', '2025-12-19 06:40:31', '2026-01-18 06:40:28', '2025-12-19 06:40:28', '2025-12-19 06:40:31'),
	(19, 'App\\Models\\User', 11, 'api-token', '972db14f99dab2973bddd591891db69faa5f8bcdaa32705de324b6adf4f5f97e', '["*"]', '2025-12-19 06:40:57', '2026-01-18 06:40:56', '2025-12-19 06:40:56', '2025-12-19 06:40:57'),
	(20, 'App\\Models\\User', 2, 'api-token', 'e5cf1cb1de0937c57ae30ffaea5998f3d31cdc19d2944a69cdc34742f91acfb6', '["*"]', '2025-12-19 06:52:04', '2026-01-18 06:52:01', '2025-12-19 06:52:01', '2025-12-19 06:52:04'),
	(21, 'App\\Models\\User', 2, 'api-token', 'd093d9ab720df86c78b7fc4fa0920686bbc0249b57d61c7c86ac80b5d55f203a', '["*"]', NULL, '2026-01-18 07:44:52', '2025-12-19 07:44:52', '2025-12-19 07:44:52'),
	(23, 'App\\Models\\User', 2, 'api-token', 'e1ad1e902d33c89a90641456a199cf1099f43861ab0c9b001047628f9ff77a94', '["*"]', '2025-12-19 15:16:49', '2026-01-18 15:15:34', '2025-12-19 15:15:34', '2025-12-19 15:16:49'),
	(24, 'App\\Models\\User', 2, 'api-token', '276b628aaeb17f49ad2854477d79f3f4af61752533dc030b078ee2ebc17378f3', '["*"]', '2025-12-19 16:55:02', '2026-01-18 15:26:52', '2025-12-19 15:26:52', '2025-12-19 16:55:02'),
	(26, 'App\\Models\\User', 11, 'api-token', '5b8b614e888b332a78a0b4cee6803a6738c77989c4e6944ee5f689e474384d57', '["*"]', '2025-12-20 06:07:45', '2026-01-19 06:00:03', '2025-12-20 06:00:03', '2025-12-20 06:07:45'),
	(30, 'App\\Models\\User', 2, 'api-token', '840e27d034983b1122e6d9cb837bf22d5179502f80e873f91b5459c1228bfa4e', '["*"]', '2025-12-20 09:06:13', '2026-01-19 08:23:14', '2025-12-20 08:23:14', '2025-12-20 09:06:13'),
	(31, 'App\\Models\\User', 2, 'api-token', '93ec666fa040d8dbd82fcae4b8691d52afd0d623af281101a992a98a424865e0', '["*"]', '2025-12-20 10:18:27', '2026-01-19 09:08:38', '2025-12-20 09:08:38', '2025-12-20 10:18:27'),
	(32, 'App\\Models\\User', 11, 'api-token', 'ecbae87e5f859ea3e6c57eb6205dff5e9648594e10c49059031ef372249deeb0', '["*"]', '2025-12-20 10:30:54', '2026-01-19 10:25:08', '2025-12-20 10:25:08', '2025-12-20 10:30:54'),
	(34, 'App\\Models\\User', 2, 'api-token', '037180319bea411d01e15feb9bf55f275cec12a87eb92b7235162e65e2b2f091', '["*"]', '2025-12-20 10:36:51', '2026-01-19 10:36:32', '2025-12-20 10:36:32', '2025-12-20 10:36:51'),
	(35, 'App\\Models\\User', 11, 'api-token', '41486da87ce3691afe01b04945cba9931fcdb41e2759e40b9bae246989c1ca80', '["*"]', '2025-12-20 10:42:07', '2026-01-19 10:38:51', '2025-12-20 10:38:51', '2025-12-20 10:42:07'),
	(36, 'App\\Models\\User', 11, 'api-token', 'd18b7b8338168a9ce820a27bb49982cb781aebcd6cdb6b7a948c2f1aa384e143', '["*"]', '2025-12-20 10:53:46', '2026-01-19 10:53:01', '2025-12-20 10:53:01', '2025-12-20 10:53:46'),
	(38, 'App\\Models\\User', 2, 'api-token', 'e12945906705283c034d445c29615f0b9eec6a75252513b7a085a9a570d8691e', '["*"]', '2025-12-20 18:21:27', '2026-01-19 10:55:20', '2025-12-20 10:55:20', '2025-12-20 18:21:27'),
	(41, 'App\\Models\\User', 5, 'api-token', 'b2025f1bddbdc6dcebc3687e253de917feb9b6fd18e533f912739b7eba0806dd', '["*"]', '2025-12-20 23:51:42', '2026-01-19 23:38:19', '2025-12-20 23:38:19', '2025-12-20 23:51:42');

-- Dumping structure for table lms_db.posts
CREATE TABLE IF NOT EXISTS `posts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `category` enum('Kabar Rumba','Karya Siswa','Info') NOT NULL,
  `content` text NOT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `posts_slug_unique` (`slug`),
  KEY `posts_is_published_published_at_index` (`is_published`,`published_at`),
  KEY `posts_slug_index` (`slug`),
  KEY `posts_title_index` (`title`),
  KEY `posts_category_index` (`category`),
  KEY `posts_is_published_index` (`is_published`),
  KEY `posts_published_at_index` (`published_at`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table lms_db.posts: ~5 rows (approximately)
INSERT INTO `posts` (`id`, `title`, `slug`, `category`, `content`, `thumbnail`, `is_published`, `published_at`, `created_at`, `updated_at`) VALUES
	(3, 'bikini botom', 'zxczaczxczxzx', 'Kabar Rumba', '<p style="text-align: justify;">Di Bikini Bottom hari ini terjadi <strong>krisis serius</strong>: Plankton mengumumkan ia <em>berhasil mencuri</em> resep Krabby Patty… tapi setelah dibuka isinya cuma tulisan:</p><p style="text-align: justify;"><strong>“Resepnya adalah kerja keras dan senyum Pak Krabs 😁”</strong></p><p style="text-align: justify;">Plankton langsung stres, Karen minta <em>update software</em>, SpongeBob tetap tertawa sambil bilang, “Wah, berarti aku sudah jadi bagian dari resep ya, Pak Krabs!”</p><p style="text-align: justify;">Sementara itu Squidward mengeluh karena <strong>bahkan di hari krisis pun dia tetap harus masuk kerja.</strong> 🗿</p>', 'posts/thumbnails/tSoZPj1CXwwiesa9FKgbdaPLGRIM5mZ7nDoQvo4e.png', 1, '2025-12-15 17:00:00', '2025-12-16 10:38:52', '2025-12-20 05:39:18'),
	(4, 'Selamat, Rumba Athaya Raih Penghargaan Bimbel Terbaik!', 'selamat-rumba-athaya-raih-penghargaan-bimbel-terbaik', 'Kabar Rumba', '<div style="text-align: justify;"><span style="font-size: 1rem;">Rumba Athaya kembali menorehkan prestasi dengan meraih penghargaan sebagai Bimbingan Belajar Terbaik di Kota Semarang. Penghargaan ini diberikan atas dedikasi kami dalam memberikan layanan pendidikan berkualitas bagi siswa-siswi SD hingga SMA. Terima kasih atas kepercayaan Sahabat Rumba dan Orang Tua!</span></div>', 'posts/thumbnails/wa8Nrk1BtljXzRkGA32HI1g6iU3bzEXD7rG8v2Cf.jpg', 1, '2025-12-21 02:46:00', '2025-12-23 02:46:10', '2025-12-23 12:29:22'),
	(5, 'Tips Sukses Menghadapi Ujian Nasional', 'tips-sukses-menghadapi-ujian-nasional', 'Info', '<div style="text-align: justify;"><span style="font-size: 1rem;">Ujian Nasional semakin dekat! Jangan panik, Sahabat Rumba. Yuk simak tips jitu dari Tutor Rumba Athaya agar kamu bisa menghadapi ujian dengan tenang dan mendapatkan nilai maksimal. Mulai dari manajemen waktu, cara meringkas materi, hingga menjaga kesehatan.</span></div>', 'posts/thumbnails/0Q0ml82A817kUMzHDUhiqbVgiyOIUqlVpg4mCEZK.jpg', 1, '2025-12-18 02:47:00', '2025-12-23 02:47:08', '2025-12-23 12:29:30'),
	(6, 'Karya Siswa: Puisi "Guruku Pahlawanku"', 'karya-siswa-puisi-guruku-pahlawanku', 'Karya Siswa', '<div style="text-align: justify;"><span style="font-size: 1rem;">Simak puisi indah karya Aninda, siswa kelas 5 SD Rumba Athaya, yang dipersembahkan untuk para guru di Hari Guru Nasional. Bakat sastra Sahabat Rumba memang luar biasa! Terus berkarya ya, Aninda.</span></div>', 'posts/thumbnails/AH8G5dmDd9cg7JzQ4uJ51NunOr7TCShy4EubkwNY.jpg', 1, '2025-12-13 02:47:00', '2025-12-23 02:47:08', '2025-12-23 12:29:44'),
	(7, 'Pendaftaran Program Intensif Persiapan masuk SMP Favorit Dibuka!', 'pendaftaran-program-intensif-persiapan-masuk-smp-favorit-dibuka', 'Info', '<div style="text-align: justify;"><span style="font-size: 1rem;">Bagi Sahabat Rumba kelas 6 SD yang ingin masuk SMP Favorit, segera daftarkan dirimu di Program Intensif Rumba Athaya. Kuota terbatas! Dapatkan materi eksklusif, drill soal, dan try out berkala.</span></div>', 'posts/thumbnails/JNgolNvj7wTiqV1k2oo5tX5PxYAl4kP6FokVPwAT.jpg', 1, '2025-12-22 02:47:00', '2025-12-23 02:47:08', '2025-12-23 12:29:13');

-- Dumping structure for table lms_db.registrations
CREATE TABLE IF NOT EXISTS `registrations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `full_name` varchar(255) NOT NULL,
  `nickname` varchar(255) NOT NULL,
  `birth_place` varchar(255) NOT NULL,
  `birth_date` date NOT NULL,
  `address` text NOT NULL,
  `school_name` varchar(255) NOT NULL,
  `program` enum('Calistung (TK-SD Kelas 1)','MAPEL SD','MAPEL SMP','MAPEL SMA','Tahfidz','Yang lain') NOT NULL,
  `program_other` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `whatsapp_number` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `registrations_full_name_index` (`full_name`),
  KEY `registrations_nickname_index` (`nickname`),
  KEY `registrations_program_index` (`program`),
  KEY `registrations_status_index` (`status`),
  KEY `registrations_created_at_index` (`created_at`),
  KEY `registrations_user_id_foreign` (`user_id`),
  CONSTRAINT `registrations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table lms_db.registrations: ~0 rows (approximately)
INSERT INTO `registrations` (`id`, `user_id`, `full_name`, `nickname`, `birth_place`, `birth_date`, `address`, `school_name`, `program`, `program_other`, `photo`, `email`, `phone`, `whatsapp_number`, `password`, `status`, `notes`, `created_at`, `updated_at`) VALUES
	(1, 11, 'asdasd', 'asdasdas', '', '2222-02-22', '', '', 'Tahfidz', NULL, 'registrations/photos/asdasd-1766086884.png', 'zakitripamungkas03@gmail.com', '0982039810231', NULL, '$2y$12$SrzAg/Uwx1BOggzXV9/bPuNcXU22G0KqWjmv95NXT/Zky6OYqahLO', 'pending', NULL, '2025-12-18 12:41:25', '2025-12-18 12:41:25');

-- Dumping structure for table lms_db.schedules
CREATE TABLE IF NOT EXISTS `schedules` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tutor_id` bigint(20) unsigned NOT NULL,
  `student_id` bigint(20) unsigned NOT NULL,
  `subject_id` bigint(20) unsigned NOT NULL,
  `day_of_week` varchar(255) NOT NULL,
  `time_start` time NOT NULL,
  `time_end` time NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `schedules_tutor_id_index` (`tutor_id`),
  KEY `schedules_student_id_index` (`student_id`),
  KEY `schedules_is_active_index` (`is_active`),
  KEY `schedules_student_active_idx` (`student_id`,`is_active`),
  KEY `schedules_subject_id_index` (`subject_id`),
  KEY `schedules_day_of_week_index` (`day_of_week`),
  KEY `schedules_day_of_week_is_active_index` (`day_of_week`,`is_active`),
  CONSTRAINT `schedules_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  CONSTRAINT `schedules_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE,
  CONSTRAINT `schedules_tutor_id_foreign` FOREIGN KEY (`tutor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table lms_db.schedules: ~13 rows (approximately)
INSERT INTO `schedules` (`id`, `tutor_id`, `student_id`, `subject_id`, `day_of_week`, `time_start`, `time_end`, `is_active`, `created_at`, `updated_at`) VALUES
	(1, 5, 1, 1, 'Monday', '06:24:00', '08:24:00', 1, '2025-12-19 16:24:13', '2025-12-19 16:24:13'),
	(2, 12, 1, 2, 'Tuesday', '13:00:00', '14:30:00', 1, '2025-12-23 10:34:21', '2025-12-23 10:34:21'),
	(3, 12, 1, 3, 'Tuesday', '16:00:00', '17:30:00', 1, '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(4, 12, 2, 1, 'Tuesday', '16:00:00', '17:30:00', 1, '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(5, 12, 3, 1, 'Saturday', '16:00:00', '17:30:00', 1, '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(6, 12, 3, 3, 'Friday', '13:00:00', '14:30:00', 1, '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(7, 12, 4, 1, 'Friday', '17:00:00', '18:30:00', 1, '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(8, 12, 4, 2, 'Monday', '13:00:00', '14:30:00', 1, '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(9, 12, 5, 1, 'Saturday', '13:00:00', '14:30:00', 1, '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(10, 12, 5, 3, 'Saturday', '15:00:00', '16:30:00', 1, '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(11, 12, 6, 3, 'Thursday', '16:00:00', '17:30:00', 1, '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(12, 12, 7, 1, 'Wednesday', '17:00:00', '18:30:00', 1, '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(13, 12, 7, 3, 'Thursday', '14:00:00', '15:30:00', 1, '2025-12-23 10:34:22', '2025-12-23 10:34:22');

-- Dumping structure for table lms_db.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table lms_db.sessions: ~2 rows (approximately)
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('6HUOI0SjGf4hZPQR7os9oHPb331aeRpsjYHgcojD', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYU5Ta0kwbzZZMUF0dm5qNXA0UlZHZ1RCT3AwVkRYYmJkTG9xUnRPSCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9', 1766519333),
	('NR5pRpthtgKgtcQB6wYZCfqHopH3JXF4LaoeLz2o', 12, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMG13Y0xiYmUzTXFVMmNjb3pqdjZLQnlFck5iakdQWHlrZEZ0dXdNOSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zYWhhYmF0LXJhIjtzOjU6InJvdXRlIjtzOjExOiJwb3N0cy5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjEyO30=', 1766519343);

-- Dumping structure for table lms_db.students
CREATE TABLE IF NOT EXISTS `students` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `nickname` varchar(255) DEFAULT NULL,
  `place_of_birth` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `address` text DEFAULT NULL,
  `program_interest` enum('Calistung','Mapel SD','Mapel SMP','Mapel SMA','Tahfidz') DEFAULT NULL,
  `profile_photo_path` varchar(255) DEFAULT NULL,
  `parent_phone` varchar(255) NOT NULL,
  `whatsapp_number` varchar(255) DEFAULT NULL,
  `school_origin` varchar(255) DEFAULT NULL,
  `class_level_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `students_class_level_id_index` (`class_level_id`),
  KEY `students_user_id_index` (`user_id`),
  KEY `students_name_index` (`name`),
  KEY `students_nickname_index` (`nickname`),
  KEY `students_program_interest_index` (`program_interest`),
  KEY `students_parent_phone_index` (`parent_phone`),
  KEY `students_school_origin_index` (`school_origin`),
  CONSTRAINT `students_class_level_id_foreign` FOREIGN KEY (`class_level_id`) REFERENCES `class_levels` (`id`) ON DELETE CASCADE,
  CONSTRAINT `students_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table lms_db.students: ~7 rows (approximately)
INSERT INTO `students` (`id`, `user_id`, `name`, `nickname`, `place_of_birth`, `date_of_birth`, `address`, `program_interest`, `profile_photo_path`, `parent_phone`, `whatsapp_number`, `school_origin`, `class_level_id`, `created_at`, `updated_at`) VALUES
	(1, 11, 'Juki', 'Tepe', NULL, '2025-12-20', 'JL. Derpoyudo, Munggur Kidul RT 03 RW 13 Bejen Karanganyar', 'Tahfidz', 'profile-photos/pRuxIHY1RH8RMqSYv1d7bMKDmsNE3QUh0V1VJYUT.jpg', '08572526535', NULL, 'MAN 1 Karanganyar', 2, '2025-12-18 12:41:25', '2025-12-23 08:16:50'),
	(2, NULL, 'Ahmad Rizki', 'Rizki', 'Yogyakarta', '2018-05-15', 'Jl. Malioboro No. 123, Yogyakarta', 'Calistung', NULL, '081234567890', NULL, 'TK Permata Hati', 3, '2025-12-23 10:32:54', '2025-12-23 10:32:54'),
	(3, NULL, 'Siti Nurhaliza', 'Siti', 'Surakarta', '2017-08-20', 'Jl. Sudirman No. 45, Surakarta', 'Mapel SD', NULL, '081234567891', NULL, 'SD Negeri 1 Surakarta', 1, '2025-12-23 10:32:54', '2025-12-23 10:32:54'),
	(4, NULL, 'Budi Pratama', 'Budi', 'Jakarta', '2014-03-10', 'Jl. Gatot Subroto No. 78, Jakarta', 'Mapel SD', NULL, '081234567892', NULL, 'SD Islam Terpadu', 6, '2025-12-23 10:32:54', '2025-12-23 10:32:54'),
	(5, NULL, 'Dewi Lestari', 'Dewi', 'Bandung', '2011-11-25', 'Jl. Dago No. 12, Bandung', 'Mapel SMP', NULL, '081234567893', NULL, 'SMP Negeri 5 Bandung', 9, '2025-12-23 10:32:54', '2025-12-23 10:32:54'),
	(6, NULL, 'Muhammad Fahri', 'Fahri', 'Yogyakarta', '2018-01-05', 'Jl. Kaliurang KM 5, Yogyakarta', 'Tahfidz', NULL, '081234567894', NULL, 'TK Al-Quran', 15, '2025-12-23 10:32:54', '2025-12-23 10:32:54'),
	(7, NULL, 'Kartika Sari', 'Kartika', 'Surabaya', '2016-09-30', 'Jl. Diponegoro No. 56, Surabaya', 'Tahfidz', NULL, '081234567895', NULL, 'SD Plus Al-Kautsar', 1, '2025-12-23 10:32:54', '2025-12-23 10:32:54');

-- Dumping structure for table lms_db.student_reports
CREATE TABLE IF NOT EXISTS `student_reports` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `student_id` bigint(20) unsigned NOT NULL,
  `subject_id` bigint(20) unsigned NOT NULL,
  `score` int(11) NOT NULL DEFAULT 0 COMMENT 'Score 0-100',
  `attendance_count` int(11) DEFAULT NULL COMMENT 'Summary of attendance',
  `notes` text DEFAULT NULL COMMENT 'Qualitative feedback',
  `period` varchar(255) NOT NULL COMMENT 'e.g., "December 2024" or "Semester 1"',
  `report_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `student_reports_student_id_index` (`student_id`),
  KEY `student_reports_report_date_index` (`report_date`),
  KEY `student_reports_student_id_report_date_index` (`student_id`,`report_date`),
  KEY `student_reports_subject_id_index` (`subject_id`),
  KEY `student_reports_period_index` (`period`),
  KEY `student_reports_student_id_subject_id_index` (`student_id`,`subject_id`),
  CONSTRAINT `student_reports_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  CONSTRAINT `student_reports_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table lms_db.student_reports: ~5 rows (approximately)
INSERT INTO `student_reports` (`id`, `student_id`, `subject_id`, `score`, `attendance_count`, `notes`, `period`, `report_date`, `created_at`, `updated_at`) VALUES
	(1, 2, 1, 92, 10, 'Perkembangan siswa sangat baik, perlu ditingkatkan ketelitiannya.', 'Desember 2025', '2025-12-18', '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(2, 3, 1, 95, 11, 'Perkembangan siswa sangat baik, perlu ditingkatkan ketelitiannya.', 'Desember 2025', '2025-12-14', '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(3, 4, 3, 99, 10, 'Perkembangan siswa sangat baik, perlu ditingkatkan ketelitiannya.', 'Desember 2025', '2025-12-17', '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(4, 5, 2, 98, 12, 'Perkembangan siswa sangat baik, perlu ditingkatkan ketelitiannya.', 'Desember 2025', '2025-12-22', '2025-12-23 10:34:22', '2025-12-23 10:34:22'),
	(5, 7, 1, 77, 11, 'Perkembangan siswa sangat baik, perlu ditingkatkan ketelitiannya.', 'Desember 2025', '2025-12-19', '2025-12-23 10:34:22', '2025-12-23 10:34:22');

-- Dumping structure for table lms_db.subjects
CREATE TABLE IF NOT EXISTS `subjects` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `subjects_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table lms_db.subjects: ~2 rows (approximately)
INSERT INTO `subjects` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
	(1, 'Matematika', 'matematika', '2025-12-19 15:36:46', '2025-12-19 15:36:46'),
	(2, 'IPS', 'ips', '2025-12-19 15:36:55', '2025-12-20 22:53:25'),
	(3, 'Bahasa Indonesia', 'bahasa-indonesia', '2025-12-19 15:42:03', '2025-12-19 15:42:03');

-- Dumping structure for table lms_db.testimonials
CREATE TABLE IF NOT EXISTS `testimonials` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `role` varchar(255) DEFAULT NULL,
  `content` text NOT NULL,
  `rating` int(11) NOT NULL DEFAULT 5 COMMENT 'Rating 1-5',
  `photo_path` varchar(255) DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `testimonials_is_published_index` (`is_published`),
  KEY `testimonials_sort_order_index` (`sort_order`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table lms_db.testimonials: ~0 rows (approximately)
INSERT INTO `testimonials` (`id`, `name`, `role`, `content`, `rating`, `photo_path`, `is_published`, `sort_order`, `created_at`, `updated_at`) VALUES
	(1, 'SDFSDFS', 'SDFSDF', 'ASDASD ASD AS DAS DASDASD AS DAS', 5, 'testimonials/FR91ZzaJP4RJWhOoSzYDNq01KShSPeQM6DE1uVhp.jpg', 1, 0, '2025-12-20 05:57:42', '2025-12-20 05:57:42');

-- Dumping structure for table lms_db.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','tutor','student') NOT NULL DEFAULT 'student',
  `avatar_url` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_role_index` (`role`),
  KEY `users_email_index` (`email`),
  KEY `users_name_index` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table lms_db.users: ~5 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `phone_number`, `email_verified_at`, `password`, `role`, `avatar_url`, `bio`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'tepe', '1@2', NULL, NULL, '$2y$12$NtnkuxUTBzSyVlRqjmD7D.wg.LLz25BUxPGwZwCMvlAy6NvI8mb5C', 'student', 'avatars/01KCM4CJVR3XC3E5KSA7NPH6WW.png', 'asdasdasdasdsad', 'd6mwhxgtJTRSX6LFRKB8jMuSyODHqCtvvVA8b0emw8y4RfYubnI5wJ6q2Po0', '2025-12-07 00:09:26', '2025-12-16 10:47:34'),
	(2, 'Admin Rumba Athaya', 'admin@rumbaathaya.com', NULL, '2025-12-23 10:21:53', '$2y$12$GxJi8.006yPKx1mFjfx7Qe51zf5HzRjR0Ez20VYg6XV8w5xGq3RPS', 'admin', NULL, NULL, 'OU94nsukpPL1ULKgsusskpxf4NPmnuh4dvhoFwXtqlJwy7Ve9GhAhmAVAg8o', '2025-12-15 09:18:22', '2025-12-23 10:21:54'),
	(5, 'NARUTO', '1@1', NULL, NULL, '$2y$12$aOuQZQkiQohXKvxKhfRuF.YdpxmaewOFcURRtfTGPeQtj9GsXLHOq', 'tutor', 'avatars/9YeQfs2dDCA6KRGbVxrqsS3kQFqm9D3UoDd2Q0ij.jpg', 'hai aku hokage', NULL, '2025-12-16 10:25:11', '2025-12-19 16:17:11'),
	(11, 'Juki', 'zakitripamungkas03@gmail.com', NULL, NULL, '$2y$12$SrzAg/Uwx1BOggzXV9/bPuNcXU22G0KqWjmv95NXT/Zky6OYqahLO', 'student', 'profile-photos/pRuxIHY1RH8RMqSYv1d7bMKDmsNE3QUh0V1VJYUT.jpg', NULL, NULL, '2025-12-18 12:41:25', '2025-12-23 08:16:50'),
	(12, 'Jerome Polin', 'tutor@rumbaathaya.com', NULL, '2025-12-23 10:21:54', '$2y$12$BmB1Sd0KhXpxW0QMd4u/Yul9iKM4qXpWtQ4GoFqO3RZKa.5ZSh41K', 'tutor', 'avatars/BG7VfyqD87wXk9fCUuX2uBQA9mtCsTx9arN26mFR.jpg', NULL, NULL, '2025-12-23 10:21:54', '2025-12-23 11:23:39');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
