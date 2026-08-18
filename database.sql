-- Database: sfm_db
-- Schema & Initial Seed Data for Laravel 7 (MySQL & MariaDB Compatible)

SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS `detil_form_penilaian`;
DROP TABLE IF EXISTS `penilaian`;
DROP TABLE IF EXISTS `form_penilaian`;
DROP TABLE IF EXISTS `indikator`;
DROP TABLE IF EXISTS `kriteria`;
DROP TABLE IF EXISTS `pengajuan_cuti`;
DROP TABLE IF EXISTS `absensi`;
DROP TABLE IF EXISTS `sanksi`;
DROP TABLE IF EXISTS `penjualan`;
DROP TABLE IF EXISTS `karyawan`;
DROP TABLE IF EXISTS `admin`;
DROP TABLE IF EXISTS `log`;
DROP TABLE IF EXISTS `failed_jobs`;
DROP TABLE IF EXISTS `password_resets`;
DROP TABLE IF EXISTS `jabatan`;
DROP TABLE IF EXISTS `departemen`;
DROP TABLE IF EXISTS `users`;
SET FOREIGN_KEY_CHECKS=1;

-- 1. Table: users
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Table: departemen
CREATE TABLE `departemen` (
  `id_departemen` int(11) NOT NULL AUTO_INCREMENT,
  `nama_departemen` varchar(100) NOT NULL,
  PRIMARY KEY (`id_departemen`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Table: jabatan
CREATE TABLE `jabatan` (
  `id_jabatan` int(11) NOT NULL AUTO_INCREMENT,
  `nama_jabatan` varchar(100) NOT NULL,
  `nilai_bonus_gaji` double DEFAULT 0,
  PRIMARY KEY (`id_jabatan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Table: karyawan
CREATE TABLE `karyawan` (
  `id_karyawan` int(11) NOT NULL AUTO_INCREMENT,
  `user_id_user` bigint(20) unsigned DEFAULT NULL,
  `departemen_id_departemen` int(11) DEFAULT NULL,
  `jabatan_id_jabatan` int(11) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `no_hp` varchar(45) DEFAULT NULL,
  `gaji_pokok` double DEFAULT 0,
  `status_karyawan` varchar(45) DEFAULT 'Aktif',
  PRIMARY KEY (`id_karyawan`),
  KEY `fk_karyawan_user` (`user_id_user`),
  KEY `fk_karyawan_departemen` (`departemen_id_departemen`),
  KEY `fk_karyawan_jabatan` (`jabatan_id_jabatan`),
  CONSTRAINT `fk_karyawan_user` FOREIGN KEY (`user_id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_karyawan_departemen` FOREIGN KEY (`departemen_id_departemen`) REFERENCES `departemen` (`id_departemen`) ON DELETE SET NULL,
  CONSTRAINT `fk_karyawan_jabatan` FOREIGN KEY (`jabatan_id_jabatan`) REFERENCES `jabatan` (`id_jabatan`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Table: admin
CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL AUTO_INCREMENT,
  `user_id_user` bigint(20) unsigned NOT NULL,
  `role` varchar(50) DEFAULT 'admin',
  PRIMARY KEY (`id_admin`),
  KEY `fk_admin_user` (`user_id_user`),
  CONSTRAINT `fk_admin_user` FOREIGN KEY (`user_id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. Table: absensi
CREATE TABLE `absensi` (
  `id_absensi` int(11) NOT NULL AUTO_INCREMENT,
  `karyawan_id_karyawan` int(11) NOT NULL,
  `tanggaldanwaktu_absensi` datetime NOT NULL,
  `tipe_absensi` varchar(50) NOT NULL,
  `keterangan_absensi` varchar(255) DEFAULT NULL,
  `status_hari` varchar(50) DEFAULT 'masuk',
  PRIMARY KEY (`id_absensi`),
  KEY `fk_absensi_karyawan` (`karyawan_id_karyawan`),
  CONSTRAINT `fk_absensi_karyawan` FOREIGN KEY (`karyawan_id_karyawan`) REFERENCES `karyawan` (`id_karyawan`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 7. Table: pengajuan_cuti
CREATE TABLE `pengajuan_cuti` (
  `idpengajuan_cuti` int(11) NOT NULL AUTO_INCREMENT,
  `karyawan_id_karyawan` int(11) NOT NULL,
  `tanggal_mulai_cuti` datetime NOT NULL,
  `tanggal_selesai_cuti` datetime NOT NULL,
  `keterangan_cuti` varchar(255) DEFAULT NULL,
  `status_cuti` varchar(50) DEFAULT 'pending',
  `absensi_id_absensi` int(11) DEFAULT NULL,
  PRIMARY KEY (`idpengajuan_cuti`),
  KEY `fk_pengajuan_cuti_karyawan` (`karyawan_id_karyawan`),
  CONSTRAINT `fk_pengajuan_cuti_karyawan` FOREIGN KEY (`karyawan_id_karyawan`) REFERENCES `karyawan` (`id_karyawan`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 8. Table: sanksi
CREATE TABLE `sanksi` (
  `id_sanksi` int(11) NOT NULL AUTO_INCREMENT,
  `karyawan_id_karyawan` int(11) NOT NULL,
  `keterangan_sanksi` varchar(255) NOT NULL,
  `waktu_sanksi` datetime NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `users_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_sanksi`),
  KEY `fk_sanksi_karyawan` (`karyawan_id_karyawan`),
  CONSTRAINT `fk_sanksi_karyawan` FOREIGN KEY (`karyawan_id_karyawan`) REFERENCES `karyawan` (`id_karyawan`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 9. Table: kriteria
CREATE TABLE `kriteria` (
  `id_kriteria` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kriteria` varchar(100) NOT NULL,
  PRIMARY KEY (`id_kriteria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 10. Table: indikator
CREATE TABLE `indikator` (
  `id_indikator` int(11) NOT NULL AUTO_INCREMENT,
  `kriteria_id_kriteria` int(11) NOT NULL,
  `nama_indikator` varchar(100) NOT NULL,
  PRIMARY KEY (`id_indikator`),
  KEY `fk_indikator_kriteria` (`kriteria_id_kriteria`),
  CONSTRAINT `fk_indikator_kriteria` FOREIGN KEY (`kriteria_id_kriteria`) REFERENCES `kriteria` (`id_kriteria`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 11. Table: form_penilaian
CREATE TABLE `form_penilaian` (
  `idform_penilaian` int(11) NOT NULL AUTO_INCREMENT,
  `nama_form_penilaian` varchar(100) NOT NULL,
  PRIMARY KEY (`idform_penilaian`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 12. Table: detil_form_penilaian
CREATE TABLE `detil_form_penilaian` (
  `id_detil_form_penilaian` int(11) NOT NULL AUTO_INCREMENT,
  `form_penilaian_idform_penilaian` int(11) NOT NULL,
  `indikator_id_indikator` int(11) NOT NULL,
  `bobot` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_detil_form_penilaian`),
  KEY `fk_detil_form` (`form_penilaian_idform_penilaian`),
  KEY `fk_detil_indikator` (`indikator_id_indikator`),
  CONSTRAINT `fk_detil_form` FOREIGN KEY (`form_penilaian_idform_penilaian`) REFERENCES `form_penilaian` (`idform_penilaian`) ON DELETE CASCADE,
  CONSTRAINT `fk_detil_indikator` FOREIGN KEY (`indikator_id_indikator`) REFERENCES `indikator` (`id_indikator`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 13. Table: penilaian
CREATE TABLE `penilaian` (
  `id_penilaian` int(11) NOT NULL AUTO_INCREMENT,
  `karyawan_id_karyawan` int(11) NOT NULL,
  `form_penilaian_idtable1` int(11) NOT NULL,
  `nilai_skor` double NOT NULL DEFAULT 0,
  `waktu_penilaian` datetime NOT NULL,
  `periode_penilaian` varchar(50) DEFAULT NULL,
  `nama_penilai` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_penilaian`),
  KEY `fk_penilaian_karyawan` (`karyawan_id_karyawan`),
  KEY `fk_penilaian_form` (`form_penilaian_idtable1`),
  CONSTRAINT `fk_penilaian_karyawan` FOREIGN KEY (`karyawan_id_karyawan`) REFERENCES `karyawan` (`id_karyawan`) ON DELETE CASCADE,
  CONSTRAINT `fk_penilaian_form` FOREIGN KEY (`form_penilaian_idtable1`) REFERENCES `form_penilaian` (`idform_penilaian`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 14. Table: penjualan
CREATE TABLE `penjualan` (
  `id_penjualan` int(11) NOT NULL AUTO_INCREMENT,
  `karyawan_id_karyawan` int(11) NOT NULL,
  `merk` varchar(100) NOT NULL,
  `jenis_mobil` varchar(100) NOT NULL,
  `harga` double NOT NULL DEFAULT 0,
  `unit` int(11) NOT NULL DEFAULT 1,
  `tanggal_penjualan` date NOT NULL,
  PRIMARY KEY (`id_penjualan`),
  KEY `fk_penjualan_karyawan` (`karyawan_id_karyawan`),
  CONSTRAINT `fk_penjualan_karyawan` FOREIGN KEY (`karyawan_id_karyawan`) REFERENCES `karyawan` (`id_karyawan`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 15. Table: log
CREATE TABLE `log` (
  `id_log` int(11) NOT NULL AUTO_INCREMENT,
  `user_id_user` bigint(20) unsigned DEFAULT NULL,
  `aksi` varchar(255) NOT NULL,
  `fitur` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_log`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 16. Table: password_resets & failed_jobs
CREATE TABLE `password_resets` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ========================================================
-- INITIAL SEED DATA
-- ========================================================

-- Users (Password: password)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'admin@gmail.com', NOW(), '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NOW(), NOW()),
(2, 'Budi Santoso', 'budi@gmail.com', NOW(), '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NOW(), NOW()),
(3, 'Siti Rahma', 'siti@gmail.com', NOW(), '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NOW(), NOW());

-- Admin Record
INSERT INTO `admin` (`id_admin`, `user_id_user`, `role`) VALUES
(1, 1, 'superadmin');

-- Departemen (ID 1 is Penjualan, used in PenjualanController)
INSERT INTO `departemen` (`id_departemen`, `nama_departemen`) VALUES
(1, 'Penjualan'),
(2, 'Bengkel'),
(3, 'Keuangan'),
(4, 'Administrasi');

-- Jabatan
INSERT INTO `jabatan` (`id_jabatan`, `nama_jabatan`, `nilai_bonus_gaji`) VALUES
(1, 'Manager Penjualan', 20),
(2, 'Sales Executive', 15),
(3, 'Kepala Mekanik', 15),
(4, 'Staff Administrasi', 10);

-- Karyawan
INSERT INTO `karyawan` (`id_karyawan`, `user_id_user`, `departemen_id_departemen`, `jabatan_id_jabatan`, `alamat`, `no_hp`, `gaji_pokok`, `status_karyawan`) VALUES
(1, 2, 1, 2, 'Jl. Sudirman No. 45, Jakarta', '081234567890', 4500000, 'Aktif'),
(2, 3, 2, 3, 'Jl. Gatot Subroto No. 12, Jakarta', '081298765432', 4000000, 'Aktif');

-- Kriteria & Indikator
INSERT INTO `kriteria` (`id_kriteria`, `nama_kriteria`) VALUES
(1, 'Kedisiplinan'),
(2, 'Kinerja & Target');

INSERT INTO `indikator` (`id_indikator`, `kriteria_id_kriteria`, `nama_indikator`) VALUES
(1, 1, 'Ketepatan Waktu Kerja'),
(2, 1, 'Kepatuhan Prosedur'),
(3, 2, 'Pencapaian Target Penjualan'),
(4, 2, 'Kualitas Layanan Pelanggan');

-- Form Penilaian
INSERT INTO `form_penilaian` (`idform_penilaian`, `nama_form_penilaian`) VALUES
(1, 'Form Evaluasi Kinerja Bulanan');

INSERT INTO `detil_form_penilaian` (`id_detil_form_penilaian`, `form_penilaian_idform_penilaian`, `indikator_id_indikator`, `bobot`) VALUES
(1, 1, 1, '25'),
(2, 1, 2, '25'),
(3, 1, 3, '25'),
(4, 1, 4, '25');
