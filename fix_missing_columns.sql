-- ============================================
-- Complete Fix for Missing Columns
-- Run this in phpMyAdmin SQL tab
-- ============================================

-- 1. Fix testimonials table - Add is_published column
ALTER TABLE `testimonials` 
ADD COLUMN IF NOT EXISTS `is_published` tinyint(1) NOT NULL DEFAULT 1 AFTER `is_featured`;

-- 2. Drop and recreate documentations table with correct structure
DROP TABLE IF EXISTS `documentations`;

CREATE TABLE `documentations` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `type` enum('photo','video') NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `category` enum('Kegiatan Belajar','Event','Karya Siswa','Testimoni','Lainnya') NOT NULL DEFAULT 'Kegiatan Belajar',
  `event_date` date DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Insert Sample Documentation Data
-- ============================================

INSERT INTO `documentations` (`id`, `title`, `description`, `type`, `file_path`, `video_url`, `thumbnail`, `category`, `event_date`, `is_published`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Kegiatan Belajar Matematika Kelas 6', 'Siswa-siswi kelas 6 sedang belajar matematika dengan metode yang menyenangkan', 'photo', 'documentations/math-class-1.jpg', NULL, NULL, 'Kegiatan Belajar', '2024-01-15', 1, 1, NOW(), NOW()),
(2, 'Lomba Cerdas Cermat Antar Kelas', 'Kompetisi cerdas cermat yang diikuti oleh seluruh siswa dengan antusias tinggi', 'photo', 'documentations/quiz-competition.jpg', NULL, NULL, 'Event', '2024-01-20', 1, 2, NOW(), NOW()),
(3, 'Karya Siswa: Poster Lingkungan', 'Hasil karya siswa dalam membuat poster tentang pelestarian lingkungan', 'photo', 'documentations/student-poster.jpg', NULL, NULL, 'Karya Siswa', '2024-01-25', 1, 3, NOW(), NOW()),
(4, 'Testimoni Orang Tua Siswa', 'Video testimoni dari orang tua siswa tentang pengalaman belajar di Rumba Athaya', 'video', NULL, 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'documentations/testimonial-thumb.jpg', 'Testimoni', '2024-02-01', 1, 4, NOW(), NOW()),
(5, 'Belajar Bahasa Inggris dengan Games', 'Metode pembelajaran bahasa Inggris yang interaktif dan menyenangkan', 'photo', 'documentations/english-class.jpg', NULL, NULL, 'Kegiatan Belajar', '2024-02-05', 1, 5, NOW(), NOW()),
(6, 'Perayaan Hari Pendidikan Nasional', 'Kegiatan memperingati Hari Pendidikan Nasional dengan berbagai lomba', 'photo', 'documentations/hardiknas-event.jpg', NULL, NULL, 'Event', '2024-05-02', 1, 6, NOW(), NOW()),
(7, 'Eksperimen Sains Sederhana', 'Siswa melakukan eksperimen sains sederhana untuk memahami konsep fisika', 'photo', 'documentations/science-experiment.jpg', NULL, NULL, 'Kegiatan Belajar', '2024-02-10', 1, 7, NOW(), NOW()),
(8, 'Karya Siswa: Cerita Bergambar', 'Kumpulan cerita bergambar hasil kreativitas siswa', 'photo', 'documentations/student-stories.jpg', NULL, NULL, 'Karya Siswa', '2024-02-15', 1, 8, NOW(), NOW()),
(9, 'Tutorial Belajar Calistung', 'Video tutorial metode pembelajaran membaca, menulis, dan berhitung untuk TK', 'video', NULL, 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'documentations/calistung-thumb.jpg', 'Kegiatan Belajar', '2024-02-20', 1, 9, NOW(), NOW()),
(10, 'Kunjungan ke Perpustakaan Kota', 'Kegiatan field trip siswa ke perpustakaan kota untuk menumbuhkan minat baca', 'photo', 'documentations/library-visit.jpg', NULL, NULL, 'Event', '2024-03-01', 1, 10, NOW(), NOW());

-- ============================================
-- Insert Sample Testimonials Data
-- ============================================

INSERT INTO `testimonials` (`id`, `name`, `role`, `content`, `rating`, `avatar`, `is_featured`, `is_published`, `created_at`, `updated_at`) VALUES
(1, 'Ibu Siti Nurhaliza', 'Orang Tua Siswa Kelas 5', 'Alhamdulillah, sejak belajar di Rumba Athaya, nilai anak saya meningkat drastis. Guru-gurunya sangat sabar dan metode belajarnya menyenangkan!', 5, NULL, 1, 1, NOW(), NOW()),
(2, 'Bapak Ahmad Dahlan', 'Orang Tua Siswa Kelas 6', 'Sangat puas dengan pelayanan dan kualitas pengajaran di Rumba Athaya. Anak saya jadi lebih percaya diri dan semangat belajar.', 5, NULL, 1, 1, NOW(), NOW()),
(3, 'Ibu Kartini Wijaya', 'Orang Tua Siswa TK', 'Program Calistung di Rumba Athaya sangat bagus! Anak saya yang tadinya belum bisa membaca, sekarang sudah lancar. Terima kasih!', 5, NULL, 1, 1, NOW(), NOW()),
(4, 'Bapak Budi Santoso', 'Orang Tua Siswa SMP', 'Persiapan masuk SMP favorit di Rumba Athaya sangat membantu. Anak saya berhasil diterima di sekolah impiannya!', 5, NULL, 1, 1, NOW(), NOW()),
(5, 'Ibu Dewi Lestari', 'Orang Tua Siswa Kelas 4', 'Guru-guru di Rumba Athaya sangat profesional dan peduli terhadap perkembangan anak. Highly recommended!', 5, NULL, 1, 1, NOW(), NOW()),
(6, 'Bapak Hendra Gunawan', 'Orang Tua Siswa Kelas 3', 'Fasilitas belajar lengkap, suasana nyaman, dan harga terjangkau. Pilihan terbaik untuk les anak!', 5, NULL, 1, 1, NOW(), NOW());

-- ============================================
-- Verify the changes
-- ============================================

SELECT 'Testimonials table structure:' as Info;
DESCRIBE `testimonials`;

SELECT 'Documentations table structure:' as Info;
DESCRIBE `documentations`;

SELECT 'Sample testimonials data:' as Info;
SELECT id, name, role, is_published FROM `testimonials` LIMIT 5;

SELECT 'Sample documentations data:' as Info;
SELECT id, title, type, category, event_date, is_published FROM `documentations` LIMIT 5;
