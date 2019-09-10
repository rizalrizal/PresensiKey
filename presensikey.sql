-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 10 Sep 2019 pada 04.14
-- Versi server: 10.1.37-MariaDB
-- Versi PHP: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `presensikey`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_detail_presensi`
--

CREATE TABLE `tbl_detail_presensi` (
  `id_presensi_detail` int(11) NOT NULL,
  `id_presensi` int(11) DEFAULT NULL,
  `id_peserta` int(11) DEFAULT NULL,
  `ho` enum('0','1') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_detail_presensi`
--

INSERT INTO `tbl_detail_presensi` (`id_presensi_detail`, `id_presensi`, `id_peserta`, `ho`) VALUES
(25, 5, 41, '0'),
(26, 5, 20, '0');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_episode`
--

CREATE TABLE `tbl_episode` (
  `id_episode` int(11) NOT NULL,
  `id_sesi` int(11) DEFAULT NULL,
  `nama_episode` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_episode`
--

INSERT INTO `tbl_episode` (`id_episode`, `id_sesi`, `nama_episode`) VALUES
(1, 1, 'Episode 01'),
(2, 1, 'Episode 02'),
(3, 1, 'Epsiode 03'),
(4, 1, 'Episode 04'),
(5, 1, 'Rihlah'),
(6, 2, 'Episode 01'),
(7, 2, 'Episode 02'),
(8, 2, 'Episode 03'),
(9, 2, 'Episode 04'),
(10, 2, 'Hang Out Akbar'),
(11, 3, 'Episode 01'),
(12, 3, 'Episode 02'),
(13, 3, 'Episode 03'),
(14, 3, 'Episode 04'),
(15, 4, 'Episode 01'),
(16, 4, 'Episode 02'),
(17, 4, 'Episode 03'),
(18, 4, 'Episode 04'),
(19, 5, 'Muslim Power Camp');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_peserta`
--

CREATE TABLE `tbl_peserta` (
  `id_peserta` int(11) NOT NULL,
  `nama` varchar(200) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `alamat` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_peserta`
--

INSERT INTO `tbl_peserta` (`id_peserta`, `nama`, `email`, `alamat`) VALUES
(1, 'Eko Budiyanto', 'eko@gmail.com', 'jayapura'),
(2, 'Aji Abdul Ratman', NULL, NULL),
(3, 'Emil Nurdwiyanto', NULL, NULL),
(4, 'Novaldi Mustamin\r\n', NULL, NULL),
(5, 'Agus Setiawan Adi Nugroho\r\n', NULL, NULL),
(6, 'Andri Perdana\r\n', NULL, NULL),
(7, 'Ryan Fajar Ardianto Wishnu Irwanantyo\r\n', NULL, NULL),
(8, 'Arif Budi Kusuma\r\n', NULL, NULL),
(9, 'Rizki Surtiyan Surya\r\n', NULL, NULL),
(10, 'Ganda Anugerah Marryos\r\n', NULL, NULL),
(11, 'Dicky Panji Ismaya', NULL, NULL),
(12, 'Yogandana', NULL, NULL),
(13, 'Yakub Setyawan\r\n', NULL, NULL),
(14, 'Pribadi Halim\r\n', NULL, NULL),
(15, 'Achmad Suryono\r\n', NULL, NULL),
(16, 'Adiyan Satya Dwi Purnama\r\n', NULL, NULL),
(17, 'Muhammad Rojihan Alfi Choir\r\n', NULL, NULL),
(18, 'Andika Chosy Pratama\r\n', NULL, NULL),
(19, 'Yuda Adi Wibowo', NULL, NULL),
(20, 'Bambang Triono\r\n', NULL, NULL),
(21, 'Henry Eka Pradana\r\n', NULL, NULL),
(22, 'M. Zufar Taqiuddin\r\n', NULL, NULL),
(23, 'Ahmad Dwi Setiawan\r\n', NULL, NULL),
(24, 'Anggit Apriansa\r\n', NULL, NULL),
(25, 'Muhammad Arifaza R. Bintang\r\n', NULL, NULL),
(26, 'Aruniyal Haqqi \r\n', NULL, NULL),
(27, 'Mulyono\r\n', NULL, NULL),
(28, 'Hasbi Hurlian\r\n', NULL, NULL),
(29, 'Septian Tri Cahyo\r\n', NULL, NULL),
(30, 'Bagas Hendrayudha\r\n', NULL, NULL),
(31, 'Afroni\r\n', NULL, NULL),
(32, 'Deni Ridwan Daru \r\n', NULL, NULL),
(33, 'Ganesha Amrina Wijaya\r\n', NULL, NULL),
(34, 'Raghda Hassa Parardhya Cornika\r\n', NULL, NULL),
(35, 'Usamah Saiful Haq\r\n', NULL, NULL),
(36, 'Maki Lukmanul Hakim\r\n', NULL, NULL),
(37, 'Agus Nurcahyo\r\n', NULL, NULL),
(38, 'ilham feriyanto \r\n', NULL, NULL),
(39, 'Bagas pribadi\r\n', NULL, NULL),
(40, 'Aldi Hendarsyah\r\n', NULL, NULL),
(41, 'Arif Budi Almawan\r\n', NULL, NULL),
(42, 'Muhammad Fajar Nuryana\r\n', NULL, NULL),
(43, 'Nova Pramono Putro\r\n', NULL, NULL),
(44, 'Tri Heri Setiawan\r\n', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_presensi`
--

CREATE TABLE `tbl_presensi` (
  `id_presensi` int(11) NOT NULL,
  `id_episode` int(11) DEFAULT NULL,
  `tempat` varchar(200) DEFAULT NULL,
  `tanggal` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_presensi`
--

INSERT INTO `tbl_presensi` (`id_presensi`, `id_episode`, `tempat`, `tanggal`) VALUES
(5, 1, 'Hotel GP', '2019-08-21');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_sesi`
--

CREATE TABLE `tbl_sesi` (
  `id_sesi` int(11) NOT NULL,
  `nama_sesi` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_sesi`
--

INSERT INTO `tbl_sesi` (`id_sesi`, `nama_sesi`) VALUES
(1, 'Sesi Aqidah'),
(2, 'Sesi Hijrah'),
(3, 'Sesi Sejarah'),
(4, 'Sesi Dakwah'),
(5, 'Sesi Muslim Power Camp');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL,
  `nama` varchar(200) DEFAULT NULL,
  `username` varchar(200) DEFAULT NULL,
  `password` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `nama`, `username`, `password`) VALUES
(1, 'Dimas', 'yukngaji', '83e32c3527fa77872926562172dc501cb50ab51f9b36f4eed94f888614a05301f156e3ef655c9c82d3a1c89ab3f49b0fc5f7e072a73e7a4dc638c7020342cd0b');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tbl_detail_presensi`
--
ALTER TABLE `tbl_detail_presensi`
  ADD PRIMARY KEY (`id_presensi_detail`),
  ADD KEY `id_presensi` (`id_presensi`),
  ADD KEY `id_peserta` (`id_peserta`);

--
-- Indeks untuk tabel `tbl_episode`
--
ALTER TABLE `tbl_episode`
  ADD PRIMARY KEY (`id_episode`),
  ADD KEY `id_sesi` (`id_sesi`);

--
-- Indeks untuk tabel `tbl_peserta`
--
ALTER TABLE `tbl_peserta`
  ADD PRIMARY KEY (`id_peserta`);

--
-- Indeks untuk tabel `tbl_presensi`
--
ALTER TABLE `tbl_presensi`
  ADD PRIMARY KEY (`id_presensi`),
  ADD KEY `id_episode` (`id_episode`);

--
-- Indeks untuk tabel `tbl_sesi`
--
ALTER TABLE `tbl_sesi`
  ADD PRIMARY KEY (`id_sesi`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tbl_detail_presensi`
--
ALTER TABLE `tbl_detail_presensi`
  MODIFY `id_presensi_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `tbl_episode`
--
ALTER TABLE `tbl_episode`
  MODIFY `id_episode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `tbl_peserta`
--
ALTER TABLE `tbl_peserta`
  MODIFY `id_peserta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT untuk tabel `tbl_presensi`
--
ALTER TABLE `tbl_presensi`
  MODIFY `id_presensi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tbl_sesi`
--
ALTER TABLE `tbl_sesi`
  MODIFY `id_sesi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tbl_detail_presensi`
--
ALTER TABLE `tbl_detail_presensi`
  ADD CONSTRAINT `tbl_detail_presensi_ibfk_1` FOREIGN KEY (`id_presensi`) REFERENCES `tbl_presensi` (`id_presensi`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_detail_presensi_ibfk_2` FOREIGN KEY (`id_peserta`) REFERENCES `tbl_peserta` (`id_peserta`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tbl_episode`
--
ALTER TABLE `tbl_episode`
  ADD CONSTRAINT `tbl_episode_ibfk_1` FOREIGN KEY (`id_sesi`) REFERENCES `tbl_sesi` (`id_sesi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tbl_presensi`
--
ALTER TABLE `tbl_presensi`
  ADD CONSTRAINT `tbl_presensi_ibfk_1` FOREIGN KEY (`id_episode`) REFERENCES `tbl_episode` (`id_episode`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
