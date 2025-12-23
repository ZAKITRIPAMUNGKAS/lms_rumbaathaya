-- ============================================
-- LMS Rumba Athaya - Complete Database Schema
-- Based on tepegraf_db.sql structure
-- Ready for cPanel/Production MySQL/MariaDB
-- ============================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- ============================================
-- Table: users
-- ============================================
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert Default Users (Admin & Tutor)
-- Password for all: "password"
INSERT INTO `users` (`id`, `name`, `email`, `phone_number`, `email_verified_at`, `password`, `role`, `avatar_url`, `bio`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin Rumba Athaya', 'admin@rumbaathaya.com', '081234567890', NOW(), '$2y$12$GxJi8.006yPKx1mFjfx7Qe51zf5HzRjR0Ez20VYg6XV8w5xGq3RPS', 'admin', NULL, 'Administrator sistem LMS Rumba Athaya', NULL, NOW(), NOW()),
(2, 'Jerome Polin', 'tutor@rumbaathaya.com', '081234567891', NOW(), '$2y$12$BmB1Sd0KhXpxW0QMd4u/Yul9iKM4qXpWtQ4GoFqO3RZKa.5ZSh41K', 'tutor', NULL, 'Tutor Matematika dan IPA', NULL, NOW(), NOW());

-- ============================================
-- Table: class_levels
-- ============================================
CREATE TABLE IF NOT EXISTS `class_levels` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `class_levels` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'TK', NOW(), NOW()),
(2, 'SD Kelas 1', NOW(), NOW()),
(3, 'SD Kelas 2', NOW(), NOW()),
(4, 'SD Kelas 3', NOW(), NOW()),
(5, 'SD Kelas 4', NOW(), NOW()),
(6, 'SD Kelas 5', NOW(), NOW()),
(7, 'SD Kelas 6', NOW(), NOW()),
(8, 'SMP Kelas 7', NOW(), NOW()),
(9, 'SMP Kelas 8', NOW(), NOW()),
(10, 'SMP Kelas 9', NOW(), NOW()),
(11, 'SMA Kelas 10', NOW(), NOW()),
(12, 'SMA Kelas 11', NOW(), NOW()),
(13, 'SMA Kelas 12', NOW(), NOW()),
(14, 'Tahfidz', NOW(), NOW());

-- ============================================
-- Table: subjects
-- ============================================
CREATE TABLE IF NOT EXISTS `subjects` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `subjects_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `subjects` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Matematika', 'matematika', NOW(), NOW()),
(2, 'IPA', 'ipa', NOW(), NOW()),
(3, 'Bahasa Indonesia', 'bahasa-indonesia', NOW(), NOW()),
(4, 'Bahasa Inggris', 'bahasa-inggris', NOW(), NOW()),
(5, 'IPS', 'ips', NOW(), NOW());

-- ============================================
-- Table: students
-- ============================================
CREATE TABLE IF NOT EXISTS `students` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
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
  `class_level_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `students_class_level_id_index` (`class_level_id`),
  KEY `students_user_id_index` (`user_id`),
  CONSTRAINT `students_class_level_id_foreign` FOREIGN KEY (`class_level_id`) REFERENCES `class_levels` (`id`) ON DELETE CASCADE,
  CONSTRAINT `students_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `students` (`id`, `user_id`, `name`, `nickname`, `place_of_birth`, `date_of_birth`, `address`, `program_interest`, `profile_photo_path`, `parent_phone`, `whatsapp_number`, `school_origin`, `class_level_id`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Ahmad Rizki Ramadhan', 'Rizki', 'Jakarta', '2015-03-15', 'Jl. Merdeka No. 123, Jakarta Pusat', 'Mapel SD', NULL, '081234567801', '081234567801', 'SD Negeri 01 Jakarta', 6, NOW(), NOW()),
(2, NULL, 'Siti Nurhaliza', 'Siti', 'Bandung', '2016-08-20', 'Jl. Sudirman No. 45, Bandung', 'Mapel SD', NULL, '081234567802', '081234567802', 'SD Islam Al-Azhar', 5, NOW(), NOW()),
(3, NULL, 'Budi Santoso', 'Budi', 'Surabaya', '2014-05-10', 'Jl. Pahlawan No. 78, Surabaya', 'Mapel SMP', NULL, '081234567803', '081234567803', 'SMP Negeri 5 Surabaya', 8, NOW(), NOW()),
(4, NULL, 'Dewi Lestari', 'Dewi', 'Yogyakarta', '2013-11-25', 'Jl. Malioboro No. 90, Yogyakarta', 'Mapel SMP', NULL, '081234567804', '081234567804', 'SMP Muhammadiyah 1', 9, NOW(), NOW()),
(5, NULL, 'Farhan Maulana', 'Farhan', 'Semarang', '2017-01-05', 'Jl. Pemuda No. 12, Semarang', 'Calistung', NULL, '081234567805', '081234567805', 'TK Harapan Bangsa', 1, NOW(), NOW());

-- ============================================
-- Table: schedules
-- ============================================
CREATE TABLE IF NOT EXISTS `schedules` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tutor_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `day_of_week` varchar(255) NOT NULL,
  `time_start` time NOT NULL,
  `time_end` time NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `schedules_tutor_id_index` (`tutor_id`),
  KEY `schedules_student_id_index` (`student_id`),
  KEY `schedules_subject_id_index` (`subject_id`),
  CONSTRAINT `schedules_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  CONSTRAINT `schedules_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE,
  CONSTRAINT `schedules_tutor_id_foreign` FOREIGN KEY (`tutor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `schedules` (`id`, `tutor_id`, `student_id`, `subject_id`, `day_of_week`, `time_start`, `time_end`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 1, 'Monday', '13:00:00', '14:30:00', 1, NOW(), NOW()),
(2, 2, 1, 2, 'Wednesday', '15:00:00', '16:30:00', 1, NOW(), NOW()),
(3, 2, 2, 1, 'Tuesday', '13:00:00', '14:30:00', 1, NOW(), NOW()),
(4, 2, 2, 3, 'Thursday', '15:00:00', '16:30:00', 1, NOW(), NOW()),
(5, 2, 3, 1, 'Friday', '13:00:00', '14:30:00', 1, NOW(), NOW());

-- ============================================
-- Table: attendances
-- ============================================
CREATE TABLE IF NOT EXISTS `attendances` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `schedule_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tutor_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `topic_taught` text NOT NULL,
  `student_progress_note` text DEFAULT NULL,
  `photo_evidence_path` varchar(255) DEFAULT NULL,
  `status` enum('present','absent','permission','sick') DEFAULT 'present',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `attendances_schedule_id_foreign` (`schedule_id`),
  KEY `attendances_tutor_id_index` (`tutor_id`),
  KEY `attendances_student_id_index` (`student_id`),
  KEY `attendances_date_index` (`date`),
  CONSTRAINT `attendances_schedule_id_foreign` FOREIGN KEY (`schedule_id`) REFERENCES `schedules` (`id`) ON DELETE SET NULL,
  CONSTRAINT `attendances_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  CONSTRAINT `attendances_tutor_id_foreign` FOREIGN KEY (`tutor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `attendances` (`id`, `schedule_id`, `tutor_id`, `student_id`, `date`, `topic_taught`, `student_progress_note`, `photo_evidence_path`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 1, '2024-12-20', 'Perkalian dan Pembagian', 'Siswa memahami materi dengan baik', NULL, 'present', NOW(), NOW()),
(2, 2, 2, 1, '2024-12-18', 'Sistem Tata Surya', 'Siswa antusias belajar tentang planet', NULL, 'present', NOW(), NOW()),
(3, 3, 2, 2, '2024-12-19', 'Aljabar Dasar', 'Perlu latihan lebih banyak', NULL, 'present', NOW(), NOW());

-- ============================================
-- Table: bimbel_journals
-- ============================================
CREATE TABLE IF NOT EXISTS `bimbel_journals` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tutor_id` bigint(20) UNSIGNED NOT NULL,
  `schedule_id` bigint(20) UNSIGNED DEFAULT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `bimbel_journals` (`id`, `tutor_id`, `schedule_id`, `date`, `time`, `material`, `documentation_path`, `created_at`, `updated_at`) VALUES
(1, 2, 1, '2024-12-20', '13:00:00', 'Materi Perkalian Bab 1', NULL, NOW(), NOW()),
(2, 2, 2, '2024-12-18', '15:00:00', 'Materi Tata Surya Bab 2', NULL, NOW(), NOW());

-- ============================================
-- Table: student_reports
-- ============================================
CREATE TABLE IF NOT EXISTS `student_reports` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `score` int(11) NOT NULL DEFAULT 0,
  `attendance_count` int(11) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `period` varchar(255) NOT NULL,
  `report_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `student_reports_student_id_index` (`student_id`),
  KEY `student_reports_subject_id_index` (`subject_id`),
  KEY `student_reports_report_date_index` (`report_date`),
  CONSTRAINT `student_reports_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  CONSTRAINT `student_reports_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `student_reports` (`id`, `student_id`, `subject_id`, `score`, `attendance_count`, `notes`, `period`, `report_date`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 85, 8, 'Perkembangan baik, perlu latihan lebih banyak', 'Desember 2024', '2024-12-20', NOW(), NOW()),
(2, 2, 1, 90, 10, 'Siswa sangat aktif dan memahami materi dengan cepat', 'Desember 2024', '2024-12-20', NOW(), NOW());

-- ============================================
-- Table: materials
-- ============================================
CREATE TABLE IF NOT EXISTS `materials` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `class_level_id` bigint(20) UNSIGNED NOT NULL,
  `tutor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `uploaded_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `materials_subject_id_index` (`subject_id`),
  KEY `materials_class_level_id_index` (`class_level_id`),
  KEY `materials_tutor_id_foreign` (`tutor_id`),
  CONSTRAINT `materials_class_level_id_foreign` FOREIGN KEY (`class_level_id`) REFERENCES `class_levels` (`id`) ON DELETE CASCADE,
  CONSTRAINT `materials_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE,
  CONSTRAINT `materials_tutor_id_foreign` FOREIGN KEY (`tutor_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `materials` (`id`, `title`, `description`, `file_path`, `video_url`, `subject_id`, `class_level_id`, `tutor_id`, `uploaded_by`, `created_at`, `updated_at`) VALUES
(1, 'Modul Matematika - Perkalian dan Pembagian', 'Materi lengkap tentang perkalian dan pembagian untuk SD', NULL, NULL, 1, 6, 2, 2, NOW(), NOW()),
(2, 'Modul IPA - Sistem Tata Surya', 'Pengenalan sistem tata surya dan planet-planet', NULL, NULL, 2, 6, 2, 2, NOW(), NOW()),
(3, 'Modul Bahasa Indonesia - Menulis Paragraf', 'Cara menulis paragraf yang baik dan benar', NULL, NULL, 3, 5, 2, 2, NOW(), NOW());

-- ============================================
-- Table: posts (Blog Sahabat RA)
-- ============================================
CREATE TABLE IF NOT EXISTS `posts` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
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
  KEY `posts_is_published_index` (`is_published`),
  KEY `posts_category_index` (`category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `posts` (`id`, `title`, `slug`, `category`, `content`, `thumbnail`, `is_published`, `published_at`, `created_at`, `updated_at`) VALUES
(1, 'Tips Sukses Menghadapi Ujian Nasional', 'tips-sukses-menghadapi-ujian-nasional', 'Info', '<h2>Persiapan Mental dan Fisik</h2><p>Ujian Nasional adalah momen penting bagi setiap siswa. Persiapan yang matang tidak hanya dari segi akademis, tetapi juga mental dan fisik sangat diperlukan.</p><h3>1. Buat Jadwal Belajar yang Teratur</h3><p>Susun jadwal belajar yang realistis dan konsisten. Jangan lupa sisipkan waktu istirahat agar otak tidak jenuh.</p><h3>2. Perbanyak Latihan Soal</h3><p>Kerjakan soal-soal latihan dari tahun-tahun sebelumnya untuk membiasakan diri dengan tipe soal yang akan keluar.</p>', 'posts/thumbnails/tips-ujian.jpg', 1, NOW(), NOW(), NOW()),
(2, 'Pendaftaran Program Intensif Persiapan Masuk SMP Favorit Dibuka!', 'pendaftaran-program-intensif-persiapan-masuk-smp-favorit-dibuka', 'Kabar Rumba', '<h2>Program Persiapan Masuk SMP Favorit</h2><p>Rumba Athaya membuka pendaftaran program intensif persiapan masuk SMP favorit!</p><h3>Keunggulan Program:</h3><ul><li>Materi lengkap sesuai standar sekolah favorit</li><li>Tutor berpengalaman dan berkompeten</li><li>Try out berkala dengan sistem CBT</li></ul>', 'posts/thumbnails/program-smp.jpg', 1, NOW(), NOW(), NOW()),
(3, 'Karya Siswa: Lomba Menulis Cerita Pendek', 'karya-siswa-lomba-menulis-cerita-pendek', 'Karya Siswa', '<h2>Prestasi Gemilang Siswa Rumba Athaya</h2><p>Selamat kepada para siswa Rumba Athaya yang telah berhasil meraih juara dalam Lomba Menulis Cerita Pendek tingkat Kota!</p>', 'posts/thumbnails/lomba-menulis.jpg', 1, NOW(), NOW(), NOW()),
(4, 'Metode Belajar Calistung yang Efektif untuk Anak TK', 'metode-belajar-calistung-yang-efektif-untuk-anak-tk', 'Info', '<h2>Calistung: Fondasi Penting Pendidikan Anak</h2><p>Membaca, menulis, dan berhitung (Calistung) adalah kemampuan dasar yang harus dikuasai anak sebelum memasuki SD.</p>', 'posts/thumbnails/calistung-tk.jpg', 1, NOW(), NOW(), NOW()),
(5, 'Kegiatan Belajar Outdoor: Belajar Sambil Bermain', 'kegiatan-belajar-outdoor-belajar-sambil-bermain', 'Kabar Rumba', '<h2>Outdoor Learning di Rumba Athaya</h2><p>Minggu lalu, siswa-siswi Rumba Athaya mengikuti kegiatan belajar outdoor yang sangat seru dan edukatif!</p>', 'posts/thumbnails/outdoor-learning.jpg', 1, NOW(), NOW(), NOW()),
(6, 'Prestasi Siswa: Juara Olimpiade Matematika', 'prestasi-siswa-juara-olimpiade-matematika', 'Karya Siswa', '<h2>Siswa Rumba Athaya Raih Medali Emas!</h2><p>Kami dengan bangga mengumumkan bahwa siswa kami berhasil meraih Medali Emas dalam Olimpiade Matematika Tingkat Provinsi!</p>', 'posts/thumbnails/olimpiade-math.jpg', 1, NOW(), NOW(), NOW());

-- ============================================
-- Table: documentations
-- ============================================
CREATE TABLE IF NOT EXISTS `documentations` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
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
  KEY `documentations_is_published_index` (`is_published`),
  KEY `documentations_event_date_index` (`event_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `documentations` (`id`, `title`, `description`, `type`, `file_path`, `video_url`, `thumbnail`, `category`, `event_date`, `is_published`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Kegiatan Belajar Matematika Kelas 6', 'Siswa-siswi kelas 6 sedang belajar matematika dengan metode yang menyenangkan', 'photo', 'documentations/math-class-1.jpg', NULL, NULL, 'Kegiatan Belajar', '2024-01-15', 1, 1, NOW(), NOW()),
(2, 'Lomba Cerdas Cermat Antar Kelas', 'Kompetisi cerdas cermat yang diikuti oleh seluruh siswa dengan antusias tinggi', 'photo', 'documentations/quiz-competition.jpg', NULL, NULL, 'Event', '2024-01-20', 1, 2, NOW(), NOW()),
(3, 'Karya Siswa: Poster Lingkungan', 'Hasil karya siswa dalam membuat poster tentang pelestarian lingkungan', 'photo', 'documentations/student-poster.jpg', NULL, NULL, 'Karya Siswa', '2024-01-25', 1, 3, NOW(), NOW()),
(4, 'Testimoni Orang Tua Siswa', 'Video testimoni dari orang tua siswa tentang pengalaman belajar di Rumba Athaya', 'video', NULL, 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'documentations/testimonial-thumb.jpg', 'Testimoni', '2024-02-01', 1, 4, NOW(), NOW()),
(5, 'Belajar Bahasa Inggris dengan Games', 'Metode pembelajaran bahasa Inggris yang interaktif dan menyenangkan', 'photo', 'documentations/english-class.jpg', NULL, NULL, 'Kegiatan Belajar', '2024-02-05', 1, 5, NOW(), NOW());

-- ============================================
-- Table: testimonials
-- ============================================
CREATE TABLE IF NOT EXISTS `testimonials` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `role` varchar(255) DEFAULT NULL,
  `content` text NOT NULL,
  `rating` int(11) NOT NULL DEFAULT 5,
  `photo_path` varchar(255) DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `testimonials_is_published_index` (`is_published`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `testimonials` (`id`, `name`, `role`, `content`, `rating`, `photo_path`, `is_published`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Ibu Siti Nurhaliza', 'Orang Tua Siswa Kelas 5', 'Alhamdulillah, sejak belajar di Rumba Athaya, nilai anak saya meningkat drastis. Guru-gurunya sangat sabar dan metode belajarnya menyenangkan!', 5, NULL, 1, 1, NOW(), NOW()),
(2, 'Bapak Ahmad Dahlan', 'Orang Tua Siswa Kelas 6', 'Sangat puas dengan pelayanan dan kualitas pengajaran di Rumba Athaya. Anak saya jadi lebih percaya diri dan semangat belajar.', 5, NULL, 1, 2, NOW(), NOW()),
(3, 'Ibu Kartini Wijaya', 'Orang Tua Siswa TK', 'Program Calistung di Rumba Athaya sangat bagus! Anak saya yang tadinya belum bisa membaca, sekarang sudah lancar. Terima kasih!', 5, NULL, 1, 3, NOW(), NOW()),
(4, 'Bapak Budi Santoso', 'Orang Tua Siswa SMP', 'Persiapan masuk SMP favorit di Rumba Athaya sangat membantu. Anak saya berhasil diterima di sekolah impiannya!', 5, NULL, 1, 4, NOW(), NOW()),
(5, 'Ibu Dewi Lestari', 'Orang Tua Siswa Kelas 4', 'Guru-guru di Rumba Athaya sangat profesional dan peduli terhadap perkembangan anak. Highly recommended!', 5, NULL, 1, 5, NOW(), NOW()),
(6, 'Bapak Hendra Gunawan', 'Orang Tua Siswa Kelas 3', 'Fasilitas belajar lengkap, suasana nyaman, dan harga terjangkau. Pilihan terbaik untuk les anak!', 5, NULL, 1, 6, NOW(), NOW());

-- ============================================
-- Table: registrations
-- ============================================
CREATE TABLE IF NOT EXISTS `registrations` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
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
  KEY `registrations_status_index` (`status`),
  KEY `registrations_user_id_foreign` (`user_id`),
  CONSTRAINT `registrations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `registrations` (`id`, `user_id`, `full_name`, `nickname`, `birth_place`, `birth_date`, `address`, `school_name`, `program`, `program_other`, `photo`, `email`, `phone`, `whatsapp_number`, `password`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Anisa Putri Maharani', 'Anisa', 'Jakarta', '2015-06-10', 'Jl. Kebon Jeruk No. 45, Jakarta Barat', 'SD Negeri 02 Jakarta', 'MAPEL SD', NULL, NULL, 'anisa.putri@email.com', '081234567806', '081234567806', NULL, 'pending', 'Menunggu konfirmasi jadwal', NOW(), NOW()),
(2, NULL, 'Muhammad Rizki', 'Rizki', 'Bandung', '2016-09-15', 'Jl. Cihampelas No. 78, Bandung', 'TK Harapan Bangsa', 'Calistung (TK-SD Kelas 1)', NULL, NULL, 'rizki.m@email.com', '081234567807', '081234567807', NULL, 'approved', 'Sudah dikonfirmasi, mulai belajar Senin depan', NOW(), NOW());

-- ============================================
-- Additional Tables (Cache, Sessions, etc.)
-- ============================================

CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `sessions` (
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

CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `failed_jobs` (
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

CREATE TABLE IF NOT EXISTS `jobs` (
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

CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
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

COMMIT;

-- ============================================
-- SUMMARY
-- ============================================
-- Tables Created: 21 (ALL COMPLETE)
-- Sample Data Inserted:
-- - Users: 2 (1 Admin, 1 Tutor)
-- - Class Levels: 14
-- - Subjects: 5
-- - Students: 5
-- - Schedules: 5
-- - Attendances: 3 ✅ NEW
-- - Bimbel Journals: 2 ✅ NEW
-- - Student Reports: 2 ✅ NEW
-- - Materials: 3
-- - Posts: 6
-- - Documentations: 5
-- - Testimonials: 6
-- - Registrations: 2
--
-- Default Login:
-- Admin: admin@rumbaathaya.com / password
-- Tutor: tutor@rumbaathaya.com / password
-- ============================================
