-- ============================================
-- Complete Fix for Missing Columns + Seeder Data
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
-- Insert Sample Blog Posts (Sahabat RA)
-- ============================================

INSERT INTO `posts` (`id`, `title`, `slug`, `category`, `content`, `thumbnail`, `is_published`, `published_at`, `created_at`, `updated_at`) VALUES
(1, 'Tips Sukses Menghadapi Ujian Nasional', 'tips-sukses-menghadapi-ujian-nasional', 'Info', '<h2>Persiapan Mental dan Fisik</h2><p>Ujian Nasional adalah momen penting bagi setiap siswa. Persiapan yang matang tidak hanya dari segi akademis, tetapi juga mental dan fisik sangat diperlukan.</p><h3>1. Buat Jadwal Belajar yang Teratur</h3><p>Susun jadwal belajar yang realistis dan konsisten. Jangan lupa sisipkan waktu istirahat agar otak tidak jenuh.</p><h3>2. Perbanyak Latihan Soal</h3><p>Kerjakan soal-soal latihan dari tahun-tahun sebelumnya untuk membiasakan diri dengan tipe soal yang akan keluar.</p><h3>3. Jaga Kesehatan</h3><p>Tidur yang cukup, makan bergizi, dan olahraga ringan akan membantu menjaga kondisi tubuh tetap prima.</p>', 'posts/thumbnails/tips-ujian.jpg', 1, NOW(), NOW(), NOW()),

(2, 'Pendaftaran Program Intensif Persiapan Masuk SMP Favorit Dibuka!', 'pendaftaran-program-intensif-persiapan-masuk-smp-favorit-dibuka', 'Kabar Rumba', '<h2>Program Persiapan Masuk SMP Favorit</h2><p>Rumba Athaya membuka pendaftaran program intensif persiapan masuk SMP favorit untuk tahun ajaran 2024/2025!</p><h3>Keunggulan Program:</h3><ul><li>Materi lengkap sesuai standar sekolah favorit</li><li>Tutor berpengalaman dan berkompeten</li><li>Try out berkala dengan sistem CBT</li><li>Bimbingan psikotes dan wawancara</li><li>Kelas kecil maksimal 10 siswa</li></ul><h3>Fasilitas:</h3><ul><li>Modul pembelajaran eksklusif</li><li>Akses e-learning 24/7</li><li>Konsultasi gratis dengan psikolog pendidikan</li><li>Laporan perkembangan belajar rutin</li></ul><p><strong>Daftar sekarang dan dapatkan diskon early bird 20%!</strong></p>', 'posts/thumbnails/program-smp.jpg', 1, NOW(), NOW(), NOW()),

(3, 'Karya Siswa: Lomba Menulis Cerita Pendek', 'karya-siswa-lomba-menulis-cerita-pendek', 'Karya Siswa', '<h2>Prestasi Gemilang Siswa Rumba Athaya</h2><p>Selamat kepada para siswa Rumba Athaya yang telah berhasil meraih juara dalam Lomba Menulis Cerita Pendek tingkat Kota!</p><h3>Pemenang:</h3><ul><li><strong>Juara 1:</strong> Anisa Putri Maharani (Kelas 6) - "Petualangan di Negeri Dongeng"</li><li><strong>Juara 2:</strong> Muhammad Rizki Ramadhan (Kelas 5) - "Sahabat Sejati"</li><li><strong>Juara 3:</strong> Zahra Amelia (Kelas 6) - "Mimpi Menjadi Dokter"</li></ul><p>Karya-karya mereka menunjukkan kreativitas dan kemampuan menulis yang luar biasa. Kami sangat bangga dengan prestasi ini!</p>', 'posts/thumbnails/lomba-menulis.jpg', 1, NOW(), NOW(), NOW()),

(4, 'Metode Belajar Calistung yang Efektif untuk Anak TK', 'metode-belajar-calistung-yang-efektif-untuk-anak-tk', 'Info', '<h2>Calistung: Fondasi Penting Pendidikan Anak</h2><p>Membaca, menulis, dan berhitung (Calistung) adalah kemampuan dasar yang harus dikuasai anak sebelum memasuki SD.</p><h3>Metode Pembelajaran yang Kami Gunakan:</h3><ol><li><strong>Metode Bermain Sambil Belajar</strong> - Anak belajar melalui permainan edukatif yang menyenangkan</li><li><strong>Metode Fonik</strong> - Mengenalkan bunyi huruf untuk memudahkan membaca</li><li><strong>Metode Multisensori</strong> - Melibatkan penglihatan, pendengaran, dan gerakan</li><li><strong>Metode Bertahap</strong> - Dari yang mudah ke yang lebih kompleks</li></ol><h3>Tips untuk Orang Tua:</h3><ul><li>Buat suasana belajar yang menyenangkan</li><li>Berikan pujian untuk setiap pencapaian</li><li>Jangan memaksakan target yang terlalu tinggi</li><li>Konsisten dalam jadwal belajar</li></ul>', 'posts/thumbnails/calistung-tk.jpg', 1, NOW(), NOW(), NOW()),

(5, 'Kegiatan Belajar Outdoor: Belajar Sambil Bermain', 'kegiatan-belajar-outdoor-belajar-sambil-bermain', 'Kabar Rumba', '<h2>Outdoor Learning di Rumba Athaya</h2><p>Minggu lalu, siswa-siswi Rumba Athaya mengikuti kegiatan belajar outdoor yang sangat seru dan edukatif!</p><h3>Kegiatan yang Dilakukan:</h3><ul><li>Observasi tumbuhan dan hewan di taman</li><li>Eksperimen sains sederhana di alam terbuka</li><li>Permainan edukatif berkelompok</li><li>Menggambar pemandangan alam</li></ul><p>Kegiatan outdoor learning ini bertujuan untuk:</p><ol><li>Meningkatkan rasa ingin tahu anak</li><li>Mengembangkan kemampuan observasi</li><li>Melatih kerjasama tim</li><li>Memberikan pengalaman belajar yang berbeda</li></ol><p>Antusiasme anak-anak sangat tinggi dan mereka mendapatkan banyak pengetahuan baru dari pengalaman langsung di alam!</p>', 'posts/thumbnails/outdoor-learning.jpg', 1, NOW(), NOW(), NOW()),

(6, 'Prestasi Siswa: Juara Olimpiade Matematika', 'prestasi-siswa-juara-olimpiade-matematika', 'Karya Siswa', '<h2>Siswa Rumba Athaya Raih Medali Emas!</h2><p>Kami dengan bangga mengumumkan bahwa siswa kami, <strong>Farhan Maulana (Kelas 6)</strong>, berhasil meraih <strong>Medali Emas</strong> dalam Olimpiade Matematika Tingkat Provinsi!</p><h3>Perjalanan Menuju Juara:</h3><p>Farhan telah mempersiapkan diri dengan sangat serius selama 6 bulan. Ia rutin mengikuti:</p><ul><li>Kelas intensif matematika 3x seminggu</li><li>Latihan soal olimpiade setiap hari</li><li>Try out rutin setiap minggu</li><li>Konsultasi dengan mentor olimpiade</li></ul><h3>Pesan dari Farhan:</h3><blockquote>"Kunci sukses adalah konsisten belajar dan jangan pernah menyerah. Terima kasih kepada guru-guru di Rumba Athaya yang selalu mendukung dan membimbing saya!"</blockquote><p>Selamat Farhan! Semoga prestasi ini menjadi motivasi bagi siswa lainnya.</p>', 'posts/thumbnails/olimpiade-math.jpg', 1, NOW(), NOW(), NOW());

-- ============================================
-- Insert Sample Registrations Data
-- ============================================

INSERT INTO `registrations` (`id`, `student_name`, `student_email`, `student_phone`, `student_address`, `parent_name`, `parent_phone`, `parent_email`, `school_name`, `current_grade`, `program`, `subjects`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'Ahmad Fauzi', 'ahmad.fauzi@email.com', '081234567801', 'Jl. Merdeka No. 123, Jakarta', 'Bapak Fauzi Rahman', '081234567891', 'fauzi.rahman@email.com', 'SD Negeri 01 Jakarta', 'Kelas 5', 'Bimbel SD Reguler', 'Matematika, IPA', 'approved', 'Siswa aktif dan antusias', NOW(), NOW()),
(2, 'Siti Aisyah', 'siti.aisyah@email.com', '081234567802', 'Jl. Sudirman No. 45, Jakarta', 'Ibu Aisyah Nur', '081234567892', 'aisyah.nur@email.com', 'SD Islam Al-Azhar', 'Kelas 6', 'Persiapan Masuk SMP Favorit', 'Matematika, IPA, Bahasa Inggris', 'approved', 'Target masuk SMPN 8 Jakarta', NOW(), NOW()),
(3, 'Muhammad Rizki', 'rizki.m@email.com', '081234567803', 'Jl. Gatot Subroto No. 78, Jakarta', 'Bapak Rizki Hidayat', '081234567893', 'rizki.hidayat@email.com', 'TK Harapan Bangsa', 'TK B', 'Calistung TK', 'Calistung', 'pending', 'Menunggu konfirmasi jadwal', NOW(), NOW()),
(4, 'Zahra Amelia', 'zahra.amelia@email.com', '081234567804', 'Jl. Thamrin No. 90, Jakarta', 'Ibu Amelia Putri', '081234567894', 'amelia.putri@email.com', 'SD Pelita Harapan', 'Kelas 4', 'Bimbel SD Reguler', 'Matematika, Bahasa Indonesia', 'approved', 'Fokus meningkatkan nilai matematika', NOW(), NOW()),
(5, 'Farhan Maulana', 'farhan.m@email.com', '081234567805', 'Jl. Kuningan No. 12, Jakarta', 'Bapak Maulana Yusuf', '081234567895', 'maulana.yusuf@email.com', 'SD Negeri 05 Jakarta', 'Kelas 6', 'Persiapan Olimpiade', 'Matematika', 'approved', 'Persiapan olimpiade matematika tingkat nasional', NOW(), NOW());

-- ============================================
-- Verify the changes
-- ============================================

SELECT '=== TESTIMONIALS TABLE ===' as Info;
DESCRIBE `testimonials`;

SELECT '=== DOCUMENTATIONS TABLE ===' as Info;
DESCRIBE `documentations`;

SELECT '=== SAMPLE DATA COUNT ===' as Info;
SELECT 
    (SELECT COUNT(*) FROM testimonials) as total_testimonials,
    (SELECT COUNT(*) FROM documentations) as total_documentations,
    (SELECT COUNT(*) FROM posts) as total_posts,
    (SELECT COUNT(*) FROM registrations) as total_registrations;
