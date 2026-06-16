-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.4.3 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table db_laporan_tambang.alat_tambangs
CREATE TABLE IF NOT EXISTS `alat_tambangs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kode_alat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_alat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipe_alat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kapasitas` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jam_kerja` int NOT NULL DEFAULT '0',
  `status` enum('Aktif','Perawatan','Rusak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_laporan_tambang.alat_tambangs: ~3 rows (approximately)
INSERT INTO `alat_tambangs` (`id`, `gambar`, `kode_alat`, `nama_alat`, `tipe_alat`, `kapasitas`, `jam_kerja`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'alat/QwtScAZn7K7vGfXZndy8E4mBBFB2rRkyT9FYuLuE.png', 'Exca-0211', 'Excavator CAT 320D', 'Excavator', '1200', 200, 'Aktif', '2026-03-11 20:01:59', '2026-03-12 21:39:47'),
	(2, 'alat/zP4pwDQJmTs0AXLKzUr42ZXHTEOFR4n8x53e3uAU.jpg', 'Exca-0212', 'Exca-01 : CAT 320D', 'Excavator', '1200', 0, 'Aktif', '2026-03-11 20:41:53', '2026-03-12 21:40:03'),
	(5, 'alat/6F6MeMmwnHUuPQqt317Pt5pqUheJDiEZdqC9Rqoa.jpg', 'Exca-03', 'CAT-310A', 'Excavator', '1245', 2, 'Aktif', '2026-03-12 04:23:44', '2026-03-12 04:24:56');

-- Dumping structure for table db_laporan_tambang.audit_logs
CREATE TABLE IF NOT EXISTS `audit_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `aksi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `detail` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `audit_logs_user_id_foreign` (`user_id`),
  CONSTRAINT `audit_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_laporan_tambang.audit_logs: ~12 rows (approximately)
INSERT INTO `audit_logs` (`id`, `user_id`, `aksi`, `modul`, `detail`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Menambah', 'Manajemen Lokasi', 'Penambahan lokasi baru:\nNama: Blok D \nKoordinator: Agus Wijaya', '2026-03-12 00:46:34', '2026-03-12 00:46:34'),
	(2, 1, 'Menambah', 'Manajemen Lokasi', 'Memperbarui lokasi:\nNama: Blok G \nKoordinator: Agus Wijaya', '2026-03-12 00:49:14', '2026-03-12 00:49:14'),
	(3, 1, 'Menghapus', 'Manajemen Lokasi', 'Menghapus lokasi:\nNama: Blok D \nKoordinator: Agus Wijaya', '2026-03-12 00:50:09', '2026-03-12 00:50:09'),
	(4, 1, 'Menambah', 'Manajemen Alat', 'Penambahan alat baru:\nKode: Exca-03 \nNama: CAT-310A', '2026-03-12 04:23:45', '2026-03-12 04:23:45'),
	(5, 1, 'Memoerbarui', 'Manajemen Alat', 'Memperbarui alat baru:\nKode: Exca-03 \nNama: CAT-310A', '2026-03-12 04:24:56', '2026-03-12 04:24:56'),
	(6, 1, 'Memperbarui', 'Manajemen Lokasi', 'Memperbarui lokasi:\nNama: Blok D \nKoordinator: Agus Wijaya', '2026-03-12 04:25:37', '2026-03-12 04:25:37'),
	(7, 1, 'Menghapus', 'Manajemen Alat', 'Menghapus alat baru:\nKode: Exca-02 \nNama: CAT-310A', '2026-03-12 04:26:04', '2026-03-12 04:26:04'),
	(8, 1, 'Menambah', 'Manajemen Pengguna', 'Penambahan pengguna baru:\nNama: Rifky \nRole: Admin', '2026-03-12 04:30:12', '2026-03-12 04:30:12'),
	(9, 1, 'Memperbarui', 'Manajemen Pengguna', 'Memperbarui pengguna baru:\nNama: Rifky123 \nRole: Admin', '2026-03-12 04:30:55', '2026-03-12 04:30:55'),
	(10, 1, 'Menghapus', 'Manajemen Pengguna', 'Menghapus pengguna baru:\nNama: Rifky123 \nRole: Admin', '2026-03-12 04:31:03', '2026-03-12 04:31:03'),
	(11, 2, 'Verivikasi', 'Verifikasi Laporan Harian', 'Verifikasi laporan harian:\nId: 17 \nSupervisor: {auth()->nama_lengkap}', '2026-03-12 04:46:01', '2026-03-12 04:46:01'),
	(12, 2, 'Verivikasi', 'Verifikasi Laporan Harian', 'Verifikasi laporan harian:\nId: 18 \nSupervisor: Agus Wijaya', '2026-03-12 04:48:28', '2026-03-12 04:48:28'),
	(13, 3, 'Menambah', 'Manajemen Laporan Harian', 'Penambahan laporan baru:\nId: 21 \nOperator:Joko Prasetyo', '2026-03-12 04:53:31', '2026-03-12 04:53:31'),
	(14, 3, 'Memperbarui', 'Memperbarui Laporan Harian', 'Memperbarui lokasi baru:\nId: 21 \\Operator:Joko Prasetyo', '2026-03-12 04:55:06', '2026-03-12 04:55:06'),
	(15, 1, 'Memoerbarui', 'Manajemen Alat', 'Memperbarui alat baru:\nKode: Exca-0211 \nNama: Excavator CAT 320D', '2026-03-12 21:39:47', '2026-03-12 21:39:47'),
	(16, 1, 'Memoerbarui', 'Manajemen Alat', 'Memperbarui alat baru:\nKode: Exca-0212 \nNama: Exca-01 : CAT 320D', '2026-03-12 21:40:03', '2026-03-12 21:40:03'),
	(17, 2, 'VerivikasiDisetujui', 'Verifikasi Laporan', 'Verifikasi laporan:\nId: 19 \nSupervisor: Agus Wijaya', '2026-03-16 18:51:43', '2026-03-16 18:51:43');

-- Dumping structure for table db_laporan_tambang.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_laporan_tambang.cache: ~2 rows (approximately)
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
	('laporan-tambang-cache-spatie.permission.cache', 'a:3:{s:5:"alias";a:4:{s:1:"a";s:2:"id";s:1:"b";s:4:"name";s:1:"c";s:10:"guard_name";s:1:"r";s:5:"roles";}s:11:"permissions";a:7:{i:0;a:4:{s:1:"a";i:1;s:1:"b";s:9:"dashboard";s:1:"c";s:3:"web";s:1:"r";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:1;a:4:{s:1:"a";i:2;s:1:"b";s:5:"input";s:1:"c";s:3:"web";s:1:"r";a:2:{i:0;i:2;i:1;i:3;}}i:2;a:4:{s:1:"a";i:3;s:1:"b";s:10:"verifikasi";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:2;}}i:3;a:4:{s:1:"a";i:4;s:1:"b";s:7:"riwayat";s:1:"c";s:3:"web";s:1:"r";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:4;a:4:{s:1:"a";i:5;s:1:"b";s:8:"pengguna";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:5;a:4:{s:1:"a";i:6;s:1:"b";s:6:"lokasi";s:1:"c";s:3:"web";s:1:"r";a:2:{i:0;i:1;i:1;i:2;}}i:6;a:4:{s:1:"a";i:7;s:1:"b";s:4:"alat";s:1:"c";s:3:"web";s:1:"r";a:2:{i:0;i:1;i:1;i:2;}}}s:5:"roles";a:3:{i:0;a:3:{s:1:"a";i:1;s:1:"b";s:5:"Admin";s:1:"c";s:3:"web";}i:1;a:3:{s:1:"a";i:2;s:1:"b";s:10:"Supervisor";s:1:"c";s:3:"web";}i:2;a:3:{s:1:"a";i:3;s:1:"b";s:8:"Operator";s:1:"c";s:3:"web";}}}', 1775979516),
	('laravel-cache-spatie.permission.cache', 'a:3:{s:5:"alias";a:4:{s:1:"a";s:2:"id";s:1:"b";s:4:"name";s:1:"c";s:10:"guard_name";s:1:"r";s:5:"roles";}s:11:"permissions";a:7:{i:0;a:4:{s:1:"a";i:1;s:1:"b";s:9:"dashboard";s:1:"c";s:3:"web";s:1:"r";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:1;a:4:{s:1:"a";i:2;s:1:"b";s:5:"input";s:1:"c";s:3:"web";s:1:"r";a:2:{i:0;i:2;i:1;i:3;}}i:2;a:4:{s:1:"a";i:3;s:1:"b";s:10:"verifikasi";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:2;}}i:3;a:4:{s:1:"a";i:4;s:1:"b";s:7:"riwayat";s:1:"c";s:3:"web";s:1:"r";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:4;a:4:{s:1:"a";i:5;s:1:"b";s:8:"pengguna";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:5;a:4:{s:1:"a";i:6;s:1:"b";s:6:"lokasi";s:1:"c";s:3:"web";s:1:"r";a:2:{i:0;i:1;i:1;i:2;}}i:6;a:4:{s:1:"a";i:7;s:1:"b";s:4:"alat";s:1:"c";s:3:"web";s:1:"r";a:2:{i:0;i:1;i:1;i:2;}}}s:5:"roles";a:3:{i:0;a:3:{s:1:"a";i:1;s:1:"b";s:5:"Admin";s:1:"c";s:3:"web";}i:1;a:3:{s:1:"a";i:2;s:1:"b";s:10:"Supervisor";s:1:"c";s:3:"web";}i:2;a:3:{s:1:"a";i:3;s:1:"b";s:8:"Operator";s:1:"c";s:3:"web";}}}', 1773457660);

-- Dumping structure for table db_laporan_tambang.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_laporan_tambang.cache_locks: ~0 rows (approximately)

-- Dumping structure for table db_laporan_tambang.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_laporan_tambang.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table db_laporan_tambang.hambatans
CREATE TABLE IF NOT EXISTS `hambatans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `produksi_harian_id` bigint unsigned NOT NULL,
  `jenis_hambatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `durasi` int NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `hambatans_produksi_harian_id_foreign` (`produksi_harian_id`),
  CONSTRAINT `hambatans_produksi_harian_id_foreign` FOREIGN KEY (`produksi_harian_id`) REFERENCES `produksi_harians` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_laporan_tambang.hambatans: ~0 rows (approximately)

-- Dumping structure for table db_laporan_tambang.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_reserved_at_available_at_index` (`queue`,`reserved_at`,`available_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_laporan_tambang.jobs: ~0 rows (approximately)

-- Dumping structure for table db_laporan_tambang.job_batches
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_laporan_tambang.job_batches: ~0 rows (approximately)

-- Dumping structure for table db_laporan_tambang.lokasi_tambangs
CREATE TABLE IF NOT EXISTS `lokasi_tambangs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_lokasi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `koordinat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `luas_area` int DEFAULT NULL,
  `koordinator` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_laporan_tambang.lokasi_tambangs: ~4 rows (approximately)
INSERT INTO `lokasi_tambangs` (`id`, `nama_lokasi`, `koordinat`, `luas_area`, `koordinator`, `created_at`, `updated_at`) VALUES
	(1, 'Blok E', '-3.43939, 345.5435.5', 450, 'Joko Prasetyo', '2026-03-12 00:29:48', '2026-03-12 00:31:53'),
	(2, 'Blok G', '-4.43939, 345.544235.5', 100, 'Agus Wijaya', '2026-03-12 00:45:24', '2026-03-12 00:48:06'),
	(3, 'Blok D', '-4.43939, 345.544235.3', 100, 'Agus Wijaya', '2026-03-12 00:45:49', '2026-03-12 04:25:37');

-- Dumping structure for table db_laporan_tambang.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_laporan_tambang.migrations: ~12 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '0001_01_01_000001_create_cache_table', 1),
	(3, '0001_01_01_000002_create_jobs_table', 1),
	(4, '2026_03_12_021903_create_alat_tambangs_table', 1),
	(5, '2026_03_12_021904_create_produksi_harians_table', 1),
	(6, '2026_03_12_021905_create_hambatans_table', 1),
	(7, '2026_03_12_021906_create_validasis_table', 1),
	(8, '2026_03_12_044624_add_extra_columns_to_produksi_harians_table', 2),
	(9, '2026_03_12_051052_make_material_nullable_in_produksi_harians', 3),
	(10, '2026_03_12_064342_add_keterangan_to_alat_tambangs_table', 4),
	(11, '2026_03_12_071940_create_lokasi_tambangs_table', 5),
	(12, '2026_03_12_074129_create_audit_logs_table', 6),
	(13, '2026_03_13_011512_create_permission_tables', 7),
	(14, '2026_03_13_032538_add_foto_profil_to_users_table', 8);

-- Dumping structure for table db_laporan_tambang.model_has_permissions
CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_laporan_tambang.model_has_permissions: ~0 rows (approximately)

-- Dumping structure for table db_laporan_tambang.model_has_roles
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_laporan_tambang.model_has_roles: ~2 rows (approximately)
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
	(1, 'App\\Models\\User', 1),
	(2, 'App\\Models\\User', 2),
	(3, 'App\\Models\\User', 3);

-- Dumping structure for table db_laporan_tambang.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_laporan_tambang.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table db_laporan_tambang.permissions
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_laporan_tambang.permissions: ~7 rows (approximately)
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
	(1, 'dashboard', 'web', '2026-03-12 18:16:28', '2026-03-12 18:16:28'),
	(2, 'input', 'web', '2026-03-12 18:16:28', '2026-03-12 18:16:28'),
	(3, 'verifikasi', 'web', '2026-03-12 18:16:28', '2026-03-12 18:16:28'),
	(4, 'riwayat', 'web', '2026-03-12 18:16:28', '2026-03-12 18:16:28'),
	(5, 'pengguna', 'web', '2026-03-12 18:16:28', '2026-03-12 18:16:28'),
	(6, 'lokasi', 'web', '2026-03-12 18:16:28', '2026-03-12 18:16:28'),
	(7, 'alat', 'web', '2026-03-12 18:16:28', '2026-03-12 18:16:28');

-- Dumping structure for table db_laporan_tambang.produksi_harians
CREATE TABLE IF NOT EXISTS `produksi_harians` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `alat_tambang_id` bigint unsigned NOT NULL,
  `tanggal` date NOT NULL,
  `shift` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Shift 1',
  `material` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `volume` decimal(10,2) NOT NULL,
  `jarak_angkut` int NOT NULL DEFAULT '500',
  `jam_operasi` int NOT NULL,
  `lokasi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bahan_bakar` decimal(8,2) NOT NULL,
  `cuaca` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Cerah',
  `hambatan_operasional` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Tidak Ada',
  `catatan_tambahan` text COLLATE utf8mb4_unicode_ci,
  `status_laporan` enum('Pending','Disetujui','Revisi') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `produksi_harians_user_id_foreign` (`user_id`),
  KEY `produksi_harians_alat_tambang_id_foreign` (`alat_tambang_id`),
  CONSTRAINT `produksi_harians_alat_tambang_id_foreign` FOREIGN KEY (`alat_tambang_id`) REFERENCES `alat_tambangs` (`id`) ON DELETE CASCADE,
  CONSTRAINT `produksi_harians_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_laporan_tambang.produksi_harians: ~21 rows (approximately)
INSERT INTO `produksi_harians` (`id`, `user_id`, `alat_tambang_id`, `tanggal`, `shift`, `material`, `volume`, `jarak_angkut`, `jam_operasi`, `lokasi`, `bahan_bakar`, `cuaca`, `hambatan_operasional`, `catatan_tambahan`, `status_laporan`, `created_at`, `updated_at`) VALUES
	(1, 3, 1, '2026-03-12', 'Shift 1', 'Overburden', 2500.00, 500, 1, 'Blok A', 220.00, 'Cerah', 'Tidak Ada', NULL, 'Disetujui', '2026-03-11 20:03:38', '2026-03-11 20:21:30'),
	(2, 3, 2, '2026-02-26', 'Shift 1', 'Overburden', 1097.00, 500, 8, 'Blok B', 220.00, 'Cerah', 'Tidak Ada', NULL, 'Disetujui', '2026-03-11 20:41:53', '2026-03-11 20:41:53'),
	(3, 3, 2, '2026-02-27', 'Shift 1', 'Overburden', 1111.00, 500, 8, 'Blok B', 220.00, 'Cerah', 'Tidak Ada', NULL, 'Disetujui', '2026-03-11 20:41:53', '2026-03-11 20:41:53'),
	(4, 3, 2, '2026-02-28', 'Shift 1', 'Overburden', 1426.00, 500, 8, 'Blok A', 220.00, 'Cerah', 'Tidak Ada', NULL, 'Disetujui', '2026-03-11 20:41:53', '2026-03-11 20:41:53'),
	(5, 3, 2, '2026-03-01', 'Shift 1', 'Overburden', 1454.00, 500, 8, 'Blok A', 220.00, 'Cerah', 'Tidak Ada', NULL, 'Disetujui', '2026-03-11 20:41:53', '2026-03-11 20:41:53'),
	(6, 3, 2, '2026-03-02', 'Shift 1', 'Overburden', 1190.00, 500, 8, 'Blok B', 220.00, 'Cerah', 'Tidak Ada', NULL, 'Disetujui', '2026-03-11 20:41:53', '2026-03-11 20:41:53'),
	(7, 3, 2, '2026-03-03', 'Shift 1', 'Overburden', 1386.00, 500, 8, 'Blok B', 220.00, 'Cerah', 'Tidak Ada', NULL, 'Disetujui', '2026-03-11 20:41:53', '2026-03-11 20:41:53'),
	(8, 3, 2, '2026-03-04', 'Shift 1', 'Overburden', 1066.00, 500, 8, 'Blok B', 220.00, 'Cerah', 'Tidak Ada', NULL, 'Disetujui', '2026-03-11 20:41:53', '2026-03-11 20:41:53'),
	(9, 3, 2, '2026-03-05', 'Shift 1', 'Overburden', 1082.00, 500, 8, 'Blok B', 220.00, 'Cerah', 'Tidak Ada', NULL, 'Disetujui', '2026-03-11 20:41:53', '2026-03-11 20:41:53'),
	(10, 3, 2, '2026-03-06', 'Shift 1', 'Overburden', 1036.00, 500, 8, 'Blok B', 220.00, 'Cerah', 'Tidak Ada', NULL, 'Disetujui', '2026-03-11 20:41:53', '2026-03-11 20:41:53'),
	(11, 3, 2, '2026-03-07', 'Shift 1', 'Overburden', 1275.00, 500, 8, 'Blok B', 220.00, 'Cerah', 'Tidak Ada', NULL, 'Disetujui', '2026-03-11 20:41:53', '2026-03-11 20:41:53'),
	(12, 3, 2, '2026-03-08', 'Shift 1', 'Overburden', 1060.00, 500, 8, 'Blok B', 220.00, 'Cerah', 'Tidak Ada', NULL, 'Disetujui', '2026-03-11 20:41:53', '2026-03-11 20:41:53'),
	(13, 3, 2, '2026-03-09', 'Shift 1', 'Overburden', 1072.00, 500, 8, 'Blok A', 220.00, 'Cerah', 'Tidak Ada', NULL, 'Disetujui', '2026-03-11 20:41:53', '2026-03-11 20:41:53'),
	(14, 3, 2, '2026-03-10', 'Shift 1', 'Overburden', 1273.00, 500, 8, 'Blok A', 220.00, 'Cerah', 'Tidak Ada', NULL, 'Disetujui', '2026-03-11 20:41:53', '2026-03-11 20:41:53'),
	(15, 3, 2, '2026-03-11', 'Shift 1', 'Overburden', 1117.00, 500, 8, 'Blok B', 220.00, 'Cerah', 'Tidak Ada', NULL, 'Disetujui', '2026-03-11 20:41:53', '2026-03-11 20:41:53'),
	(16, 3, 2, '2026-03-12', 'Shift 1', 'Overburden', 1471.00, 500, 8, 'Blok A', 220.00, 'Cerah', 'Tidak Ada', NULL, 'Disetujui', '2026-03-11 20:41:53', '2026-03-11 20:41:53'),
	(17, 2, 2, '2026-03-12', 'Shift 2', NULL, 2500.00, 500, 8, 'Blok A', 220.00, 'Hujan', 'Breakdown', NULL, 'Disetujui', '2026-03-11 22:12:09', '2026-03-12 04:44:15'),
	(18, 2, 1, '2026-03-13', 'Shift 1', NULL, 2500.00, 500, 8, 'Blok A', 220.00, 'Berawan', 'Breakdown', NULL, 'Disetujui', '2026-03-12 22:14:23', '2026-03-13 04:48:28'),
	(19, 2, 2, '2026-03-12', 'Shift 2', NULL, 2000.00, 500, 12, 'Blok A', 180.00, 'Cerah', 'Tidak Ada', NULL, 'Disetujui', '2026-03-11 22:19:56', '2026-03-16 18:51:43'),
	(20, 3, 5, '2026-03-12', 'Shift 1', NULL, 2000.00, 500, 8, 'Blok A', 200.00, 'Cerah', 'Tidak Ada', NULL, 'Pending', '2026-03-12 04:49:32', '2026-03-12 04:49:32'),
	(21, 3, 5, '2026-03-13', 'Shift 1', NULL, 2000.00, 500, 8, 'Blok A', 200.00, 'Cerah', 'Tidak Ada', 'sasdadad', 'Pending', '2026-03-13 04:53:31', '2026-03-13 04:55:05');

-- Dumping structure for table db_laporan_tambang.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_laporan_tambang.roles: ~3 rows (approximately)
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
	(1, 'Admin', 'web', '2026-03-12 18:16:28', '2026-03-12 18:16:28'),
	(2, 'Supervisor', 'web', '2026-03-12 18:16:28', '2026-03-12 18:16:28'),
	(3, 'Operator', 'web', '2026-03-12 18:16:28', '2026-03-12 18:16:28');

-- Dumping structure for table db_laporan_tambang.role_has_permissions
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_laporan_tambang.role_has_permissions: ~14 rows (approximately)
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
	(1, 1),
	(4, 1),
	(5, 1),
	(6, 1),
	(7, 1),
	(1, 2),
	(2, 2),
	(3, 2),
	(4, 2),
	(6, 2),
	(7, 2),
	(1, 3),
	(2, 3),
	(4, 3);

-- Dumping structure for table db_laporan_tambang.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_laporan_tambang.sessions: ~2 rows (approximately)
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('6VaJTNEL9lOEXQKQtMbRN5gUzerSbe97cfSbgpYZ', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZmZFWGVFd3J0RVAwVzJaSU1vcmRjd1VRSnJUUjhKY2g2TUVTcmRGVCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQ/YnVsYW49MDImdGFodW49MjAyNiI7czo1OiJyb3V0ZSI7czo5OiJkYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1775895155),
	('Omo6lflpsF0ewiiw2BBQxGPOsYelUvMUX1Uq5pzu', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTjNWREVjYkJocG5ObmI0S2lVVE1DVW1hSGlDakx5aXZwREtSdmgySSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fX0=', 1773712337);

-- Dumping structure for table db_laporan_tambang.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_lengkap` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto_profil` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_hp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('Admin','Supervisor','Operator') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Operator',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_laporan_tambang.users: ~3 rows (approximately)
INSERT INTO `users` (`id`, `nama_lengkap`, `email`, `foto_profil`, `nomor_hp`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Administrator System', 'admin@tambang.com', 'profil/uqIkdIZo1oXi7vdKl3YNEcoTTdRvMQgdxmxApwbI.jpg', '081100001111', 'Admin', NULL, '$2y$12$J3cI7JwGbGo0LiLuq1J8XOGeLdETu2IBBI8l7z8Y30RKtkF0lvNzu', NULL, '2026-03-11 19:47:05', '2026-03-12 20:32:19'),
	(2, 'Agus Wijaya', 'supervisor@tambang.com', 'profil/z0aDBT6nYyHuDcPGmxmmgz6c7R3OWTeeZCsTzI39.jpg', '081100002222', 'Supervisor', NULL, '$2y$12$XxH2m6ApVMZULhxNgn4ZX.zBpunFYrNY0mkklZ8PF.bceQEwwfZUG', NULL, '2026-03-11 19:47:05', '2026-03-12 20:33:21'),
	(3, 'Joko Prasetyo', 'operator@tambang.com', NULL, '081100003333', 'Operator', NULL, '$2y$12$Anae21wNrvyuHV9RMJVkJ.vatVDMC0gDpW1zQ7uZjAS.Eq6EHStCa', NULL, '2026-03-11 19:47:06', '2026-03-11 19:47:06');

-- Dumping structure for table db_laporan_tambang.validasis
CREATE TABLE IF NOT EXISTS `validasis` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `produksi_harian_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `tanggal_validasi` datetime NOT NULL,
  `status_validasi` enum('Disetujui','Ditolak','Revisi') COLLATE utf8mb4_unicode_ci NOT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `validasis_produksi_harian_id_foreign` (`produksi_harian_id`),
  KEY `validasis_user_id_foreign` (`user_id`),
  CONSTRAINT `validasis_produksi_harian_id_foreign` FOREIGN KEY (`produksi_harian_id`) REFERENCES `produksi_harians` (`id`) ON DELETE CASCADE,
  CONSTRAINT `validasis_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_laporan_tambang.validasis: ~5 rows (approximately)
INSERT INTO `validasis` (`id`, `produksi_harian_id`, `user_id`, `tanggal_validasi`, `status_validasi`, `catatan`, `created_at`, `updated_at`) VALUES
	(1, 1, 2, '2026-03-12 03:21:30', 'Disetujui', NULL, '2026-03-11 20:21:30', '2026-03-11 20:21:30'),
	(2, 17, 2, '2026-03-12 11:44:15', 'Disetujui', NULL, '2026-03-12 04:44:15', '2026-03-12 04:44:15'),
	(3, 17, 2, '2026-03-12 11:45:07', 'Disetujui', NULL, '2026-03-12 04:45:07', '2026-03-12 04:45:07'),
	(4, 17, 2, '2026-03-12 11:45:55', 'Disetujui', NULL, '2026-03-12 04:45:55', '2026-03-12 04:45:55'),
	(5, 17, 2, '2026-03-12 11:46:01', 'Disetujui', NULL, '2026-03-12 04:46:01', '2026-03-12 04:46:01'),
	(6, 18, 2, '2026-03-12 11:48:28', 'Disetujui', NULL, '2026-03-12 04:48:28', '2026-03-12 04:48:28'),
	(7, 19, 2, '2026-03-17 01:51:43', 'Disetujui', NULL, '2026-03-16 18:51:43', '2026-03-16 18:51:43');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
