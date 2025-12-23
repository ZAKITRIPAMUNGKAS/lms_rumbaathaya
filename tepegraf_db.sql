-- ============================================
-- LMS Rumba Athaya Database Schema
-- Database: tepegraf_db
-- Compatible with MySQL/MariaDB for cPanel
-- ============================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- ============================================
-- Create Database (Optional - uncomment if needed)
-- ============================================
-- CREATE DATABASE IF NOT EXISTS `tepegraf_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
-- USE `tepegraf_db`;

-- ============================================
-- Table: users
-- ============================================
CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','tutor','student') NOT NULL DEFAULT 'student',
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Table: password_reset_tokens
-- ============================================
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Table: sessions
-- ============================================
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Table: cache
-- ============================================
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Table: jobs
-- ============================================
CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `job_batches` (
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

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Table: personal_access_tokens
-- ============================================
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Table: class_levels
-- ============================================
CREATE TABLE `class_levels` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Table: subjects
-- ============================================
CREATE TABLE `subjects` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Table: students
-- ============================================
CREATE TABLE `students` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `class_level_id` bigint(20) UNSIGNED DEFAULT NULL,
  `parent_name` varchar(255) DEFAULT NULL,
  `parent_phone` varchar(20) DEFAULT NULL,
  `school_name` varchar(255) DEFAULT NULL,
  `enrollment_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `students_user_id_foreign` (`user_id`),
  KEY `students_class_level_id_foreign` (`class_level_id`),
  CONSTRAINT `students_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `students_class_level_id_foreign` FOREIGN KEY (`class_level_id`) REFERENCES `class_levels` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Table: schedules
-- ============================================
CREATE TABLE `schedules` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `tutor_id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `day_of_week` varchar(20) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `schedules_student_id_foreign` (`student_id`),
  KEY `schedules_tutor_id_foreign` (`tutor_id`),
  KEY `schedules_subject_id_foreign` (`subject_id`),
  CONSTRAINT `schedules_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  CONSTRAINT `schedules_tutor_id_foreign` FOREIGN KEY (`tutor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `schedules_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Table: attendances
-- ============================================
CREATE TABLE `attendances` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `schedule_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `status` enum('present','absent','sick','permission') NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `attendances_schedule_id_foreign` (`schedule_id`),
  CONSTRAINT `attendances_schedule_id_foreign` FOREIGN KEY (`schedule_id`) REFERENCES `schedules` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Table: materials
-- ============================================
CREATE TABLE `materials` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `class_level_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `file_type` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `materials_subject_id_foreign` (`subject_id`),
  KEY `materials_class_level_id_foreign` (`class_level_id`),
  CONSTRAINT `materials_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE,
  CONSTRAINT `materials_class_level_id_foreign` FOREIGN KEY (`class_level_id`) REFERENCES `class_levels` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Table: student_reports
-- ============================================
CREATE TABLE `student_reports` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `report_date` date NOT NULL,
  `score` decimal(5,2) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `student_reports_student_id_foreign` (`student_id`),
  KEY `student_reports_subject_id_foreign` (`subject_id`),
  CONSTRAINT `student_reports_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  CONSTRAINT `student_reports_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Table: posts (Blog/Sahabat RA)
-- ============================================
CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `category` enum('Kabar Rumba','Karya Siswa','Info') NOT NULL,
  `content` text DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `posts_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Table: registrations
-- ============================================
CREATE TABLE `registrations` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `student_name` varchar(255) NOT NULL,
  `student_email` varchar(255) NOT NULL,
  `student_phone` varchar(20) NOT NULL,
  `student_address` text DEFAULT NULL,
  `parent_name` varchar(255) NOT NULL,
  `parent_phone` varchar(20) NOT NULL,
  `parent_email` varchar(255) DEFAULT NULL,
  `school_name` varchar(255) DEFAULT NULL,
  `current_grade` varchar(50) DEFAULT NULL,
  `program` varchar(255) NOT NULL,
  `subjects` text DEFAULT NULL,
  `preferred_schedule` text DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Table: documentations
-- ============================================
CREATE TABLE `documentations` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image_path` varchar(255) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Table: testimonials
-- ============================================
CREATE TABLE `testimonials` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `role` varchar(100) DEFAULT NULL,
  `content` text NOT NULL,
  `rating` tinyint(3) UNSIGNED NOT NULL DEFAULT 5,
  `avatar` varchar(255) DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Table: bimbel_journals
-- ============================================
CREATE TABLE `bimbel_journals` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `schedule_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `topic` varchar(255) NOT NULL,
  `activities` text DEFAULT NULL,
  `student_progress` text DEFAULT NULL,
  `homework` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bimbel_journals_schedule_id_foreign` (`schedule_id`),
  CONSTRAINT `bimbel_journals_schedule_id_foreign` FOREIGN KEY (`schedule_id`) REFERENCES `schedules` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Insert Default Admin User
-- Password: password (hashed with bcrypt)
-- ============================================
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `phone`, `address`, `avatar`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin@rumbaathaya.com', NOW(), '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewY5NANh6wHRQ3K2', 'admin', '081234567890', 'Jl. Pendidikan No. 123', NULL, NULL, NOW(), NOW());

-- ============================================
-- Insert Sample Class Levels
-- ============================================
INSERT INTO `class_levels` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'TK', 'Taman Kanak-Kanak', NOW(), NOW()),
(2, 'SD Kelas 1-3', 'Sekolah Dasar Kelas 1 sampai 3', NOW(), NOW()),
(3, 'SD Kelas 4-6', 'Sekolah Dasar Kelas 4 sampai 6', NOW(), NOW()),
(4, 'SMP', 'Sekolah Menengah Pertama', NOW(), NOW()),
(5, 'SMA', 'Sekolah Menengah Atas', NOW(), NOW());

-- ============================================
-- Insert Sample Subjects
-- ============================================
INSERT INTO `subjects` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Matematika', 'Mata pelajaran Matematika', NOW(), NOW()),
(2, 'Bahasa Indonesia', 'Mata pelajaran Bahasa Indonesia', NOW(), NOW()),
(3, 'Bahasa Inggris', 'Mata pelajaran Bahasa Inggris', NOW(), NOW()),
(4, 'IPA', 'Ilmu Pengetahuan Alam', NOW(), NOW()),
(5, 'IPS', 'Ilmu Pengetahuan Sosial', NOW(), NOW()),
(6, 'Calistung', 'Baca Tulis Hitung untuk TK dan SD Kelas 1-3', NOW(), NOW());

COMMIT;

-- ============================================
-- End of SQL Script
-- ============================================
