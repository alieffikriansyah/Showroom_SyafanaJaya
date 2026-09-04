-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 04, 2026 at 12:30 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sfm_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id_absensi` int(11) NOT NULL,
  `karyawan_id_karyawan` int(11) NOT NULL,
  `tanggaldanwaktu_absensi` datetime NOT NULL,
  `tipe_absensi` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan_absensi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_hari` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'masuk'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`id_absensi`, `karyawan_id_karyawan`, `tanggaldanwaktu_absensi`, `tipe_absensi`, `keterangan_absensi`, `status_hari`) VALUES
(1, 1, '2026-08-18 20:19:00', 'hadir', NULL, 'masuk');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `user_id_user` bigint(20) UNSIGNED NOT NULL,
  `role` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `user_id_user`, `role`) VALUES
(1, 1, 'superadmin');

-- --------------------------------------------------------

--
-- Table structure for table `departemen`
--

CREATE TABLE `departemen` (
  `id_departemen` int(11) NOT NULL,
  `nama_departemen` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departemen`
--

INSERT INTO `departemen` (`id_departemen`, `nama_departemen`) VALUES
(1, 'Penjualan'),
(2, 'Bengkel'),
(3, 'Keuangan'),
(4, 'Administrasi');

-- --------------------------------------------------------

--
-- Table structure for table `detil_form_penilaian`
--

CREATE TABLE `detil_form_penilaian` (
  `id_detil_form_penilaian` int(11) NOT NULL,
  `form_penilaian_idform_penilaian` int(11) NOT NULL,
  `indikator_id_indikator` int(11) NOT NULL,
  `bobot` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `detil_form_penilaian`
--

INSERT INTO `detil_form_penilaian` (`id_detil_form_penilaian`, `form_penilaian_idform_penilaian`, `indikator_id_indikator`, `bobot`) VALUES
(1, 1, 1, '25'),
(2, 1, 2, '25'),
(3, 1, 3, '25'),
(4, 1, 4, '25');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `form_penilaian`
--

CREATE TABLE `form_penilaian` (
  `idform_penilaian` int(11) NOT NULL,
  `nama_form_penilaian` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `form_penilaian`
--

INSERT INTO `form_penilaian` (`idform_penilaian`, `nama_form_penilaian`) VALUES
(1, 'Form Evaluasi Kinerja Bulanan');

-- --------------------------------------------------------

--
-- Table structure for table `indikator`
--

CREATE TABLE `indikator` (
  `id_indikator` int(11) NOT NULL,
  `kriteria_id_kriteria` int(11) NOT NULL,
  `nama_indikator` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `indikator`
--

INSERT INTO `indikator` (`id_indikator`, `kriteria_id_kriteria`, `nama_indikator`) VALUES
(1, 1, 'Ketepatan Waktu Kerja'),
(2, 1, 'Kepatuhan Prosedur'),
(3, 2, 'Pencapaian Target Penjualan'),
(4, 2, 'Kualitas Layanan Pelanggan');

-- --------------------------------------------------------

--
-- Table structure for table `jabatan`
--

CREATE TABLE `jabatan` (
  `id_jabatan` int(11) NOT NULL,
  `nama_jabatan` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nilai_bonus_gaji` double DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jabatan`
--

INSERT INTO `jabatan` (`id_jabatan`, `nama_jabatan`, `nilai_bonus_gaji`) VALUES
(1, 'Manager Penjualan', 20),
(2, 'Sales Executive', 15),
(3, 'Kepala Mekanik', 15),
(4, 'Staff Administrasi', 10);

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `id_karyawan` int(11) NOT NULL,
  `user_id_user` bigint(20) UNSIGNED DEFAULT NULL,
  `departemen_id_departemen` int(11) DEFAULT NULL,
  `jabatan_id_jabatan` int(11) DEFAULT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_hp` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gaji_pokok` double DEFAULT '0',
  `status_karyawan` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT 'Aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`id_karyawan`, `user_id_user`, `departemen_id_departemen`, `jabatan_id_jabatan`, `alamat`, `no_hp`, `gaji_pokok`, `status_karyawan`) VALUES
(1, 2, 1, 2, 'Jl. Sudirman No. 45, Jakarta', '081234567890', 4500000, 'Aktif'),
(2, 3, 2, 3, 'Jl. Gatot Subroto No. 12, Jakarta', '081298765432', 4000000, 'Aktif');

-- --------------------------------------------------------

--
-- Table structure for table `kriteria`
--

CREATE TABLE `kriteria` (
  `id_kriteria` int(11) NOT NULL,
  `nama_kriteria` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kriteria`
--

INSERT INTO `kriteria` (`id_kriteria`, `nama_kriteria`) VALUES
(1, 'Kedisiplinan'),
(2, 'Kinerja & Target');

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `id_log` int(11) NOT NULL,
  `user_id_user` bigint(20) UNSIGNED DEFAULT NULL,
  `aksi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fitur` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `log`
--

INSERT INTO `log` (`id_log`, `user_id_user`, `aksi`, `fitur`, `created_at`, `updated_at`) VALUES
(1, 1, 'Tambah Penjualan', 'penjualan', '2026-08-18 12:43:43', NULL),
(2, 1, 'Tambah Sanksi', 'sanksi', '2026-08-18 12:46:16', NULL),
(3, 1, 'Tambah Presensi Karyawan', 'presensi', '2026-08-18 06:19:43', '2026-08-18 06:19:43'),
(4, 1, 'Tambah Penilaian Budi Santoso', 'penilaian', '2026-08-18 06:20:29', '2026-08-18 06:20:29'),
(5, 1, 'Update Nilai Skor Penilaian Budi Santoso', 'penilaian', '2026-08-18 06:33:04', '2026-08-18 06:33:04'),
(6, 1, 'Tambah Penilaian Siti Rahma', 'penilaian', '2026-08-18 06:47:29', '2026-08-18 06:47:29'),
(7, 1, 'Update Nilai Skor Penilaian Siti Rahma', 'penilaian', '2026-08-23 20:31:11', '2026-08-23 20:31:11');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan_cuti`
--

CREATE TABLE `pengajuan_cuti` (
  `idpengajuan_cuti` int(11) NOT NULL,
  `karyawan_id_karyawan` int(11) NOT NULL,
  `tanggal_mulai_cuti` datetime NOT NULL,
  `tanggal_selesai_cuti` datetime NOT NULL,
  `keterangan_cuti` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_cuti` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `absensi_id_absensi` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penilaian`
--

CREATE TABLE `penilaian` (
  `id_penilaian` int(11) NOT NULL,
  `karyawan_id_karyawan` int(11) NOT NULL,
  `form_penilaian_idtable1` int(11) NOT NULL,
  `nilai_skor` double NOT NULL DEFAULT '0',
  `waktu_penilaian` datetime NOT NULL,
  `periode_penilaian` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_penilai` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `penilaian`
--

INSERT INTO `penilaian` (`id_penilaian`, `karyawan_id_karyawan`, `form_penilaian_idtable1`, `nilai_skor`, `waktu_penilaian`, `periode_penilaian`, `nama_penilai`) VALUES
(1, 1, 1, 75, '2026-08-18 20:20:00', '2026-08-18T20:20', 'Super Admin'),
(2, 2, 1, 100, '2026-08-18 20:47:00', '2026-08-18T20:47', 'Super Admin');

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `id_penjualan` int(11) NOT NULL,
  `karyawan_id_karyawan` int(11) NOT NULL,
  `merk` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_mobil` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` double NOT NULL DEFAULT '0',
  `unit` int(11) NOT NULL DEFAULT '1',
  `tanggal_penjualan` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`id_penjualan`, `karyawan_id_karyawan`, `merk`, `jenis_mobil`, `harga`, `unit`, `tanggal_penjualan`) VALUES
(1, 1, 'toyota', 'pickup', 60000000, 1, '2026-08-18'),
(2, 1, 'Toyota', 'Avanza Veloz', 250000000, 2, '2026-05-10'),
(3, 1, 'Honda', 'HR-V Turbo', 380000000, 1, '2026-06-15'),
(4, 1, 'Mitsubishi', 'Xpander Cross', 310000000, 2, '2026-07-20'),
(5, 1, 'Daihatsu', 'Rocky 1.0T', 220000000, 1, '2026-08-05');

-- --------------------------------------------------------

--
-- Table structure for table `sanksi`
--

CREATE TABLE `sanksi` (
  `id_sanksi` int(11) NOT NULL,
  `karyawan_id_karyawan` int(11) NOT NULL,
  `keterangan_sanksi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `waktu_sanksi` datetime NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `users_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sanksi`
--

INSERT INTO `sanksi` (`id_sanksi`, `karyawan_id_karyawan`, `keterangan_sanksi`, `waktu_sanksi`, `foto`, `users_id`) VALUES
(1, 1, 'melanggar', '2026-08-18 19:46:00', 'e-drive-e-drive-Assistant.png', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'admin@gmail.com', '2026-08-18 12:34:59', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, '2026-08-18 12:34:59', '2026-08-18 12:34:59'),
(2, 'Budi Santoso', 'budi@gmail.com', '2026-08-18 12:34:59', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, '2026-08-18 12:34:59', '2026-08-18 12:34:59'),
(3, 'Siti Rahma', 'siti@gmail.com', '2026-08-18 12:34:59', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, '2026-08-18 12:34:59', '2026-08-18 12:34:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id_absensi`),
  ADD KEY `fk_absensi_karyawan` (`karyawan_id_karyawan`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD KEY `fk_admin_user` (`user_id_user`);

--
-- Indexes for table `departemen`
--
ALTER TABLE `departemen`
  ADD PRIMARY KEY (`id_departemen`);

--
-- Indexes for table `detil_form_penilaian`
--
ALTER TABLE `detil_form_penilaian`
  ADD PRIMARY KEY (`id_detil_form_penilaian`),
  ADD KEY `fk_detil_form` (`form_penilaian_idform_penilaian`),
  ADD KEY `fk_detil_indikator` (`indikator_id_indikator`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `form_penilaian`
--
ALTER TABLE `form_penilaian`
  ADD PRIMARY KEY (`idform_penilaian`);

--
-- Indexes for table `indikator`
--
ALTER TABLE `indikator`
  ADD PRIMARY KEY (`id_indikator`),
  ADD KEY `fk_indikator_kriteria` (`kriteria_id_kriteria`);

--
-- Indexes for table `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`id_jabatan`);

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id_karyawan`),
  ADD KEY `fk_karyawan_user` (`user_id_user`),
  ADD KEY `fk_karyawan_departemen` (`departemen_id_departemen`),
  ADD KEY `fk_karyawan_jabatan` (`jabatan_id_jabatan`);

--
-- Indexes for table `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`id_kriteria`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id_log`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `pengajuan_cuti`
--
ALTER TABLE `pengajuan_cuti`
  ADD PRIMARY KEY (`idpengajuan_cuti`),
  ADD KEY `fk_pengajuan_cuti_karyawan` (`karyawan_id_karyawan`);

--
-- Indexes for table `penilaian`
--
ALTER TABLE `penilaian`
  ADD PRIMARY KEY (`id_penilaian`),
  ADD KEY `fk_penilaian_karyawan` (`karyawan_id_karyawan`),
  ADD KEY `fk_penilaian_form` (`form_penilaian_idtable1`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id_penjualan`),
  ADD KEY `fk_penjualan_karyawan` (`karyawan_id_karyawan`);

--
-- Indexes for table `sanksi`
--
ALTER TABLE `sanksi`
  ADD PRIMARY KEY (`id_sanksi`),
  ADD KEY `fk_sanksi_karyawan` (`karyawan_id_karyawan`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id_absensi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `departemen`
--
ALTER TABLE `departemen`
  MODIFY `id_departemen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `detil_form_penilaian`
--
ALTER TABLE `detil_form_penilaian`
  MODIFY `id_detil_form_penilaian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `form_penilaian`
--
ALTER TABLE `form_penilaian`
  MODIFY `idform_penilaian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `indikator`
--
ALTER TABLE `indikator`
  MODIFY `id_indikator` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `id_jabatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id_karyawan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `kriteria`
--
ALTER TABLE `kriteria`
  MODIFY `id_kriteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pengajuan_cuti`
--
ALTER TABLE `pengajuan_cuti`
  MODIFY `idpengajuan_cuti` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `penilaian`
--
ALTER TABLE `penilaian`
  MODIFY `id_penilaian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id_penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sanksi`
--
ALTER TABLE `sanksi`
  MODIFY `id_sanksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `fk_absensi_karyawan` FOREIGN KEY (`karyawan_id_karyawan`) REFERENCES `karyawan` (`id_karyawan`) ON DELETE CASCADE;

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `fk_admin_user` FOREIGN KEY (`user_id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `detil_form_penilaian`
--
ALTER TABLE `detil_form_penilaian`
  ADD CONSTRAINT `fk_detil_form` FOREIGN KEY (`form_penilaian_idform_penilaian`) REFERENCES `form_penilaian` (`idform_penilaian`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_detil_indikator` FOREIGN KEY (`indikator_id_indikator`) REFERENCES `indikator` (`id_indikator`) ON DELETE CASCADE;

--
-- Constraints for table `indikator`
--
ALTER TABLE `indikator`
  ADD CONSTRAINT `fk_indikator_kriteria` FOREIGN KEY (`kriteria_id_kriteria`) REFERENCES `kriteria` (`id_kriteria`) ON DELETE CASCADE;

--
-- Constraints for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD CONSTRAINT `fk_karyawan_departemen` FOREIGN KEY (`departemen_id_departemen`) REFERENCES `departemen` (`id_departemen`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_karyawan_jabatan` FOREIGN KEY (`jabatan_id_jabatan`) REFERENCES `jabatan` (`id_jabatan`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_karyawan_user` FOREIGN KEY (`user_id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pengajuan_cuti`
--
ALTER TABLE `pengajuan_cuti`
  ADD CONSTRAINT `fk_pengajuan_cuti_karyawan` FOREIGN KEY (`karyawan_id_karyawan`) REFERENCES `karyawan` (`id_karyawan`) ON DELETE CASCADE;

--
-- Constraints for table `penilaian`
--
ALTER TABLE `penilaian`
  ADD CONSTRAINT `fk_penilaian_form` FOREIGN KEY (`form_penilaian_idtable1`) REFERENCES `form_penilaian` (`idform_penilaian`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_penilaian_karyawan` FOREIGN KEY (`karyawan_id_karyawan`) REFERENCES `karyawan` (`id_karyawan`) ON DELETE CASCADE;

--
-- Constraints for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD CONSTRAINT `fk_penjualan_karyawan` FOREIGN KEY (`karyawan_id_karyawan`) REFERENCES `karyawan` (`id_karyawan`) ON DELETE CASCADE;

--
-- Constraints for table `sanksi`
--
ALTER TABLE `sanksi`
  ADD CONSTRAINT `fk_sanksi_karyawan` FOREIGN KEY (`karyawan_id_karyawan`) REFERENCES `karyawan` (`id_karyawan`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
