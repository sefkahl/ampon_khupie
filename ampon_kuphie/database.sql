-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 02 Nov 2026 pada 13.51
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ampon_kuphie`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_jabatan`
--

CREATE TABLE `m_jabatan` (
  `id_jabatan` int(11) NOT NULL,
  `nama_jabatan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `m_jabatan`
--

INSERT INTO `m_jabatan` (`id_jabatan`, `nama_jabatan`) VALUES
(1, 'Admin'),
(2, 'Owner'),
(3, 'Pegawai'),
(4, 'Staf Gudang'),
(5, 'Kasir'),
(6, 'Barista'),
(7, 'Supervisor'),
(8, 'Akuntan'),
(9, 'Kepala Gudang'),
(10, 'HRD'),
(11, 'c');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_barang`
--

CREATE TABLE `tbl_barang` (
  `id_barang` int(11) NOT NULL,
  `kode_barang` varchar(20) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `id_satuan` int(11) NOT NULL,
  `stok` int(11) NOT NULL DEFAULT 0,
  `harga_average` decimal(15,2) NOT NULL DEFAULT 0.00,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tbl_barang`
--

INSERT INTO `tbl_barang` (`id_barang`, `kode_barang`, `nama_barang`, `id_satuan`, `stok`, `harga_average`, `keterangan`) VALUES
(14, 'BRG-002', 'NASIO', 7, 2, 11000.00, '-'),
(15, 'BRG-003', 'CV Coklat Prima Rasa', 2, 0, 0.00, 'q');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_barang_keluar`
--

CREATE TABLE `tbl_barang_keluar` (
  `id_barang_keluar` int(11) NOT NULL,
  `nomor_transaksi` varchar(20) DEFAULT NULL,
  `id_barang` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga_pokok` decimal(15,2) NOT NULL DEFAULT 0.00,
  `tanggal` date NOT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_barang_masuk`
--

CREATE TABLE `tbl_barang_masuk` (
  `id_barang_masuk` int(11) NOT NULL,
  `nomor_transaksi` varchar(20) DEFAULT NULL,
  `id_barang` int(11) NOT NULL,
  `id_supplier` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga_beli` decimal(15,2) NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tbl_barang_masuk`
--

INSERT INTO `tbl_barang_masuk` (`id_barang_masuk`, `nomor_transaksi`, `id_barang`, `id_supplier`, `jumlah`, `harga_beli`, `tanggal`, `keterangan`, `created_at`) VALUES
(18, 'BM00001', 14, 18, 1, 10000.00, '2026-08-03', '-', '2026-08-02 20:53:24'),
(19, 'BM00002', 14, 18, 1, 12000.00, '2026-08-03', '-', '2026-08-02 20:54:57');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_kartu_persediaan`
--

CREATE TABLE `tbl_kartu_persediaan` (
  `id_kartu_persediaan` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `id_barang_masuk` int(11) DEFAULT NULL,
  `id_barang_keluar` int(11) DEFAULT NULL,
  `tanggal` date NOT NULL,
  `jenis` varchar(10) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga` decimal(15,2) NOT NULL,
  `total` decimal(15,2) NOT NULL,
  `saldo_stok` int(11) NOT NULL,
  `saldo_nilai` decimal(15,2) NOT NULL,
  `harga_average` decimal(15,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tbl_kartu_persediaan`
--

INSERT INTO `tbl_kartu_persediaan` (`id_kartu_persediaan`, `id_barang`, `id_barang_masuk`, `id_barang_keluar`, `tanggal`, `jenis`, `jumlah`, `harga`, `total`, `saldo_stok`, `saldo_nilai`, `harga_average`, `created_at`) VALUES
(30, 14, 18, NULL, '2026-08-03', 'Masuk', 1, 10000.00, 10000.00, 1, 10000.00, 10000.00, '2026-08-02 20:53:24'),
(31, 14, 19, NULL, '2026-08-03', 'Masuk', 1, 12000.00, 12000.00, 2, 22000.00, 11000.00, '2026-08-02 20:54:57');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_pegawai`
--

CREATE TABLE `tbl_pegawai` (
  `id_pegawai` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jabatan_id` int(11) DEFAULT NULL,
  `nomor_hp` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tbl_pegawai`
--

INSERT INTO `tbl_pegawai` (`id_pegawai`, `nama`, `jabatan_id`, `nomor_hp`, `alamat`) VALUES
(1, 'Administrator', 1, '081234567101', 'Jl. Melati No. 1, Jakarta'),
(2, 'Budi Santoso', 4, '081234567102', 'Jl. Mawar No. 2, Depok'),
(4, 'Andi Wijaya', 5, '081234567104', 'Jl. Anggrek No. 4, Tangerang'),
(5, 'Dewi Lestari', 6, '081234567105', 'Jl. Cempaka No. 5, Bekasi'),
(7, 'Ratna SariQQ', 8, '081234567107QQ', 'Jl. Kamboja No. 7, DepokQQ'),
(8, 'Joko Prasetyo', 9, '081234567108', 'Jl. Dahlia No. 8, Bogor'),
(9, 'Maya Anggraini', 3, '081234567109', 'Jl. Teratai No. 9, Tangerang'),
(10, 'Agus Salim', 10, '081234567110', 'Jl. Bougenville No. 10, Bekasi'),
(12, 'CV Coklat Prima Rasa', 6, 'S', 'S'),
(13, 'uco', 10, '081234567009', '=');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_satuan`
--

CREATE TABLE `tbl_satuan` (
  `id_satuan` int(11) NOT NULL,
  `nama_satuan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tbl_satuan`
--

INSERT INTO `tbl_satuan` (`id_satuan`, `nama_satuan`) VALUES
(1, 'Pcs'),
(2, 'Box'),
(3, 'Dus'),
(4, 'Kg'),
(5, 'Liter'),
(6, 'Pack'),
(7, 'Botol'),
(8, 'Gelas'),
(9, 'TEST'),
(10, 'Karung');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_supplier`
--

CREATE TABLE `tbl_supplier` (
  `id_supplier` int(11) NOT NULL,
  `kode_supplier` varchar(20) NOT NULL,
  `nama_supplier` varchar(100) NOT NULL,
  `alamat` text DEFAULT NULL,
  `nomor_hp` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tbl_supplier`
--

INSERT INTO `tbl_supplier` (`id_supplier`, `kode_supplier`, `nama_supplier`, `alamat`, `nomor_hp`) VALUES
(18, 'SPL001', 'CV Coklat Prima Rasa', 'S', 'S');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL,
  `id_pegawai` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tbl_user`
--

INSERT INTO `tbl_user` (`id_user`, `username`, `password`, `role`, `id_pegawai`) VALUES
(1, 'admin@gmail.com', '$2y$10$FojEZpWc81OmbJqgp8T89OvQ2OyYa9ZBM7bfA7JR5CyMtP8QJkz06', 'Admin', 1),
(2, 'user', '$2y$10$kP15meO/20TSZkK7I9cSuOe4Ks8/DtKnVjNBKSLx0hv6TyCrwjWgu', 'Petugas', 2),
(3, 'user01', '$2y$10$wLs3QC/IRX3OYiOPme8cPOHmuZEEk80RtRCUI1QIG3DadF/QAtjHm', 'Owner', NULL),
(4, 'user04', '$2y$10$y.w5mQtZLuSvvgHzg6YWM.rlPWSB55ofmKWA36ZjTXnxQA6J35sU.', 'Admin', 4),
(5, 'user05', '$2y$10$y.w5mQtZLuSvvgHzg6YWM.rlPWSB55ofmKWA36ZjTXnxQA6J35sU.', 'Owner', 5),
(6, 'user06', '$2y$10$y.w5mQtZLuSvvgHzg6YWM.rlPWSB55ofmKWA36ZjTXnxQA6J35sU.', 'Owner', NULL),
(7, 'user07', '$2y$10$y.w5mQtZLuSvvgHzg6YWM.rlPWSB55ofmKWA36ZjTXnxQA6J35sU.', 'Owner', 7),
(8, 'user08', '$2y$10$y.w5mQtZLuSvvgHzg6YWM.rlPWSB55ofmKWA36ZjTXnxQA6J35sU.', 'Petugas', 8),
(9, 'user09', '$2y$10$y.w5mQtZLuSvvgHzg6YWM.rlPWSB55ofmKWA36ZjTXnxQA6J35sU.', 'Petugas', 9),
(10, 'user10', '$2y$10$y.w5mQtZLuSvvgHzg6YWM.rlPWSB55ofmKWA36ZjTXnxQA6J35sU.', 'Petugas', 10);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `m_jabatan`
--
ALTER TABLE `m_jabatan`
  ADD PRIMARY KEY (`id_jabatan`);

--
-- Indeks untuk tabel `tbl_barang`
--
ALTER TABLE `tbl_barang`
  ADD PRIMARY KEY (`id_barang`),
  ADD UNIQUE KEY `kode_barang` (`kode_barang`),
  ADD KEY `id_satuan` (`id_satuan`);

--
-- Indeks untuk tabel `tbl_barang_keluar`
--
ALTER TABLE `tbl_barang_keluar`
  ADD PRIMARY KEY (`id_barang_keluar`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indeks untuk tabel `tbl_barang_masuk`
--
ALTER TABLE `tbl_barang_masuk`
  ADD PRIMARY KEY (`id_barang_masuk`),
  ADD KEY `id_barang` (`id_barang`),
  ADD KEY `id_supplier` (`id_supplier`);

--
-- Indeks untuk tabel `tbl_kartu_persediaan`
--
ALTER TABLE `tbl_kartu_persediaan`
  ADD PRIMARY KEY (`id_kartu_persediaan`),
  ADD KEY `id_barang` (`id_barang`),
  ADD KEY `id_barang_masuk` (`id_barang_masuk`),
  ADD KEY `id_barang_keluar` (`id_barang_keluar`);

--
-- Indeks untuk tabel `tbl_pegawai`
--
ALTER TABLE `tbl_pegawai`
  ADD PRIMARY KEY (`id_pegawai`),
  ADD KEY `fk_pegawai_jabatan` (`jabatan_id`);

--
-- Indeks untuk tabel `tbl_satuan`
--
ALTER TABLE `tbl_satuan`
  ADD PRIMARY KEY (`id_satuan`);

--
-- Indeks untuk tabel `tbl_supplier`
--
ALTER TABLE `tbl_supplier`
  ADD PRIMARY KEY (`id_supplier`),
  ADD UNIQUE KEY `kode_supplier` (`kode_supplier`);

--
-- Indeks untuk tabel `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `id_pegawai` (`id_pegawai`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `m_jabatan`
--
ALTER TABLE `m_jabatan`
  MODIFY `id_jabatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `tbl_barang`
--
ALTER TABLE `tbl_barang`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `tbl_barang_keluar`
--
ALTER TABLE `tbl_barang_keluar`
  MODIFY `id_barang_keluar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `tbl_barang_masuk`
--
ALTER TABLE `tbl_barang_masuk`
  MODIFY `id_barang_masuk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `tbl_kartu_persediaan`
--
ALTER TABLE `tbl_kartu_persediaan`
  MODIFY `id_kartu_persediaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT untuk tabel `tbl_pegawai`
--
ALTER TABLE `tbl_pegawai`
  MODIFY `id_pegawai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `tbl_satuan`
--
ALTER TABLE `tbl_satuan`
  MODIFY `id_satuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `tbl_supplier`
--
ALTER TABLE `tbl_supplier`
  MODIFY `id_supplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tbl_barang`
--
ALTER TABLE `tbl_barang`
  ADD CONSTRAINT `tbl_barang_ibfk_1` FOREIGN KEY (`id_satuan`) REFERENCES `tbl_satuan` (`id_satuan`);

--
-- Ketidakleluasaan untuk tabel `tbl_barang_keluar`
--
ALTER TABLE `tbl_barang_keluar`
  ADD CONSTRAINT `tbl_barang_keluar_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `tbl_barang` (`id_barang`);

--
-- Ketidakleluasaan untuk tabel `tbl_barang_masuk`
--
ALTER TABLE `tbl_barang_masuk`
  ADD CONSTRAINT `tbl_barang_masuk_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `tbl_barang` (`id_barang`),
  ADD CONSTRAINT `tbl_barang_masuk_ibfk_2` FOREIGN KEY (`id_supplier`) REFERENCES `tbl_supplier` (`id_supplier`);

--
-- Ketidakleluasaan untuk tabel `tbl_kartu_persediaan`
--
ALTER TABLE `tbl_kartu_persediaan`
  ADD CONSTRAINT `tbl_kartu_persediaan_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `tbl_barang` (`id_barang`),
  ADD CONSTRAINT `tbl_kartu_persediaan_ibfk_2` FOREIGN KEY (`id_barang_masuk`) REFERENCES `tbl_barang_masuk` (`id_barang_masuk`),
  ADD CONSTRAINT `tbl_kartu_persediaan_ibfk_3` FOREIGN KEY (`id_barang_keluar`) REFERENCES `tbl_barang_keluar` (`id_barang_keluar`);

--
-- Ketidakleluasaan untuk tabel `tbl_pegawai`
--
ALTER TABLE `tbl_pegawai`
  ADD CONSTRAINT `fk_pegawai_jabatan` FOREIGN KEY (`jabatan_id`) REFERENCES `m_jabatan` (`id_jabatan`);

--
-- Ketidakleluasaan untuk tabel `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD CONSTRAINT `tbl_user_ibfk_1` FOREIGN KEY (`id_pegawai`) REFERENCES `tbl_pegawai` (`id_pegawai`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
