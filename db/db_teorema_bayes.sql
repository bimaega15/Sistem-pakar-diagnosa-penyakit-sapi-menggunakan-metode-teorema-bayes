-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 12 Agu 2022 pada 10.28
-- Versi server: 10.4.20-MariaDB
-- Versi PHP: 7.4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_teorema_bayes`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `gejala`
--

CREATE TABLE `gejala` (
  `id_gejala` int(11) NOT NULL,
  `kode_gejala` varchar(50) NOT NULL,
  `nama_gejala` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `gejala`
--

INSERT INTO `gejala` (`id_gejala`, `kode_gejala`, `nama_gejala`) VALUES
(1, 'G01', 'Terasa lemah diseluruh tubuh'),
(2, 'G02', 'Merasakan sakit kepala'),
(3, 'G03', 'Nyeri pada dada'),
(5, 'G04', 'Demam'),
(6, 'G05', 'Keluar darah dari hidung/Mimisan'),
(7, 'G06', 'Kaki dan tangan terasa dingin'),
(8, 'G07', 'Kesemutan pada kaki'),
(9, 'G08', 'Kulit tampak pucat'),
(10, 'G09', 'Merasakan muntah-muntah/mual'),
(11, 'G10', 'Nyeri pada panggul hingga ke paha'),
(12, 'G11', 'Nyeri pada ulu hati'),
(13, 'G12', 'BAB mengeluarkaan darah');

-- --------------------------------------------------------

--
-- Struktur dari tabel `hasil`
--

CREATE TABLE `hasil` (
  `id_hasil` int(11) NOT NULL,
  `penyakit_id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `tingkat_keyakinan_hasil` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `hasil`
--

INSERT INTO `hasil` (`id_hasil`, `penyakit_id`, `users_id`, `tingkat_keyakinan_hasil`) VALUES
(6, 1, 5, 0.41842105263158),
(7, 1, 5, 0.47634730538922),
(8, 1, 5, 0.46061224489796);

-- --------------------------------------------------------

--
-- Struktur dari tabel `hasil_detail`
--

CREATE TABLE `hasil_detail` (
  `id_hasil_detail` int(11) NOT NULL,
  `gejala_id` int(11) NOT NULL,
  `hasil_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `hasil_detail`
--

INSERT INTO `hasil_detail` (`id_hasil_detail`, `gejala_id`, `hasil_id`) VALUES
(36, 1, 6),
(37, 2, 6),
(38, 5, 6),
(39, 6, 6),
(40, 7, 6),
(41, 8, 6),
(42, 10, 6),
(43, 11, 6),
(44, 13, 6),
(45, 1, 7),
(46, 2, 7),
(47, 3, 7),
(48, 6, 7),
(49, 8, 7),
(50, 9, 7),
(51, 11, 7),
(52, 12, 7),
(53, 1, 8),
(54, 2, 8),
(55, 3, 8),
(56, 6, 8),
(57, 8, 8),
(58, 10, 8),
(59, 11, 8),
(60, 13, 8);

-- --------------------------------------------------------

--
-- Struktur dari tabel `konfigurasi`
--

CREATE TABLE `konfigurasi` (
  `id_konfigurasi` int(11) NOT NULL,
  `instansi_konfigurasi` varchar(200) NOT NULL,
  `nama_konfigurasi` varchar(200) NOT NULL,
  `nohp_konfigurasi` varchar(25) NOT NULL,
  `alamat_konfigurasi` text NOT NULL,
  `email_konfigurasi` varchar(100) NOT NULL,
  `gambar_konfigurasi` varchar(300) NOT NULL,
  `copyright_konfigurasi` varchar(200) NOT NULL,
  `tentang_konfigurasi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `konfigurasi`
--

INSERT INTO `konfigurasi` (`id_konfigurasi`, `instansi_konfigurasi`, `nama_konfigurasi`, `nohp_konfigurasi`, `alamat_konfigurasi`, `email_konfigurasi`, `gambar_konfigurasi`, `copyright_konfigurasi`, `tentang_konfigurasi`) VALUES
(1, 'Kantor Wilayah Programmer', 'Sistem Pakar Diagnosa Penyakit Sapi Teorema Bayes', '082277506232', 'Alamat instansi gue bro', 'bimaega15@gmail.com', '37661654976636SuratKeteranganBebas.png', 'Bima Ega Fullstack Developer', ' Lorem ipsum dolor sit amet consectetur adipisicing elit. Illum labore perspiciatis reiciendis dolore doloremque cupiditate ipsum dolorem ducimus mollitia natus pariatur quaerat deserunt aperiam dignissimos eveniet facere ratione, nam, assumenda facilis a enim rem deleniti. Sit, omnis nobis eius, voluptate quasi ab facere saepe corrupti aliquam consectetur quibusdam quaerat quia voluptatibus distinctio dignissimos commodi quis odio esse sequi aperiam! Incidunt dignissimos illum magnam eum cupiditate? Minus facilis et culpa dicta vero nemo tempore voluptatum sit magni inventore, deserunt, facere sequi!');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penyakit`
--

CREATE TABLE `penyakit` (
  `id_penyakit` int(11) NOT NULL,
  `kode_penyakit` varchar(200) NOT NULL,
  `nama_penyakit` varchar(200) NOT NULL,
  `gambar_penyakit` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `penyakit`
--

INSERT INTO `penyakit` (`id_penyakit`, `kode_penyakit`, `nama_penyakit`, `gambar_penyakit`) VALUES
(1, 'P01', 'Anemia Aplastik', '180291654999091SuratKeteranganBebas.png'),
(2, 'P02', 'Anemia Definisi Zat Besi', '294461654999082PemindahBukuan.png'),
(3, 'P03', 'Anemia Kronis / Kronik', '531621654999075SKKPKP.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `probabilitas_pakar`
--

CREATE TABLE `probabilitas_pakar` (
  `id_probabilitas_pakar` int(11) NOT NULL,
  `gejala_id` int(11) NOT NULL,
  `penyakit_id` int(11) NOT NULL,
  `bobot_probabilitas_pakar` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `probabilitas_pakar`
--

INSERT INTO `probabilitas_pakar` (`id_probabilitas_pakar`, `gejala_id`, `penyakit_id`, `bobot_probabilitas_pakar`) VALUES
(1, 1, 1, 0.3),
(2, 2, 1, 0.3),
(3, 5, 1, 0.4),
(4, 6, 1, 0.8),
(5, 9, 1, 0.6),
(6, 10, 1, 0.4),
(7, 12, 1, 0.7),
(8, 1, 2, 0.3),
(9, 2, 2, 0.3),
(10, 3, 2, 0.8),
(11, 7, 2, 0.4),
(12, 8, 2, 0.5),
(13, 9, 2, 0.6),
(14, 11, 2, 0.5),
(15, 1, 3, 0.3),
(16, 2, 3, 0.3),
(17, 5, 3, 0.4),
(18, 7, 3, 0.4),
(19, 10, 3, 0.4),
(20, 11, 3, 0.5),
(21, 12, 3, 0.7),
(22, 13, 3, 0.8);

-- --------------------------------------------------------

--
-- Struktur dari tabel `profile`
--

CREATE TABLE `profile` (
  `id_profile` int(11) NOT NULL,
  `nama_profile` varchar(200) NOT NULL,
  `alamat_profile` text NOT NULL,
  `nohp_profile` varchar(20) NOT NULL,
  `jenis_kelamin_profile` enum('L','P') NOT NULL,
  `gambar_profile` varchar(200) DEFAULT NULL,
  `users_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `profile`
--

INSERT INTO `profile` (`id_profile`, `nama_profile`, `alamat_profile`, `nohp_profile`, `jenis_kelamin_profile`, `gambar_profile`, `users_id`) VALUES
(1, 'Bima Ega', '                                                              My alamat                                                              ', '0938247289', 'L', '665491654971113PemindahBukuan.png', 1),
(5, 'users123', 'users123', '23523623', 'L', '539591655724389PemindahBukuan.png', 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `rule`
--

CREATE TABLE `rule` (
  `id_rule` int(11) NOT NULL,
  `kode_rule` varchar(50) NOT NULL,
  `nama_rule` varchar(200) NOT NULL,
  `penyakit_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `rule`
--

INSERT INTO `rule` (`id_rule`, `kode_rule`, `nama_rule`, `penyakit_id`) VALUES
(2, 'R01', 'Rule 1', 1),
(3, 'R02', 'Rule 2', 2),
(4, 'R03', 'Rule 3', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `rule_detail`
--

CREATE TABLE `rule_detail` (
  `id_rule_detail` int(11) NOT NULL,
  `gejala_id` int(11) NOT NULL,
  `rule_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `rule_detail`
--

INSERT INTO `rule_detail` (`id_rule_detail`, `gejala_id`, `rule_id`) VALUES
(28, 1, 2),
(29, 2, 2),
(30, 5, 2),
(31, 6, 2),
(32, 9, 2),
(33, 10, 2),
(34, 12, 2),
(35, 1, 3),
(36, 2, 3),
(37, 3, 3),
(38, 7, 3),
(39, 8, 3),
(40, 9, 3),
(41, 11, 3),
(42, 1, 4),
(43, 2, 4),
(44, 5, 4),
(45, 7, 4),
(46, 10, 4),
(47, 11, 4),
(48, 12, 4),
(49, 13, 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `solusi`
--

CREATE TABLE `solusi` (
  `id_solusi` int(11) NOT NULL,
  `kode_solusi` varchar(50) NOT NULL,
  `keterangan_solusi` text NOT NULL,
  `penyakit_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `solusi`
--

INSERT INTO `solusi` (`id_solusi`, `kode_solusi`, `keterangan_solusi`, `penyakit_id`) VALUES
(1, 'S01', 'Solusi untuk anemia plastik\r\n', 1),
(4, 'S02', 'Solusi untuk anemia defisiensi zat besi', 2),
(6, 'S03', 'Solusi untuk anemia kronis / kronik', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_users` int(11) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `level` enum('admin','users') NOT NULL,
  `cookie` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_users`, `username`, `password`, `level`, `cookie`) VALUES
(1, 'admin123', '0192023a7bbd73250516f069df18b500', 'admin', 0),
(5, 'users123', 'd351331735b1980b6dee831c10abbc0b', 'users', 0);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `gejala`
--
ALTER TABLE `gejala`
  ADD PRIMARY KEY (`id_gejala`);

--
-- Indeks untuk tabel `hasil`
--
ALTER TABLE `hasil`
  ADD PRIMARY KEY (`id_hasil`),
  ADD KEY `penyakit_id` (`penyakit_id`),
  ADD KEY `users_id` (`users_id`);

--
-- Indeks untuk tabel `hasil_detail`
--
ALTER TABLE `hasil_detail`
  ADD PRIMARY KEY (`id_hasil_detail`),
  ADD KEY `gejala_id` (`gejala_id`),
  ADD KEY `hasil_id` (`hasil_id`);

--
-- Indeks untuk tabel `konfigurasi`
--
ALTER TABLE `konfigurasi`
  ADD PRIMARY KEY (`id_konfigurasi`);

--
-- Indeks untuk tabel `penyakit`
--
ALTER TABLE `penyakit`
  ADD PRIMARY KEY (`id_penyakit`);

--
-- Indeks untuk tabel `probabilitas_pakar`
--
ALTER TABLE `probabilitas_pakar`
  ADD PRIMARY KEY (`id_probabilitas_pakar`),
  ADD KEY `gejala_id` (`gejala_id`),
  ADD KEY `penyakit_id` (`penyakit_id`);

--
-- Indeks untuk tabel `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`id_profile`),
  ADD KEY `users_id` (`users_id`);

--
-- Indeks untuk tabel `rule`
--
ALTER TABLE `rule`
  ADD PRIMARY KEY (`id_rule`),
  ADD KEY `penyakit_id` (`penyakit_id`);

--
-- Indeks untuk tabel `rule_detail`
--
ALTER TABLE `rule_detail`
  ADD PRIMARY KEY (`id_rule_detail`),
  ADD KEY `gelaja_id` (`gejala_id`),
  ADD KEY `rule_id` (`rule_id`);

--
-- Indeks untuk tabel `solusi`
--
ALTER TABLE `solusi`
  ADD PRIMARY KEY (`id_solusi`),
  ADD KEY `penyakit_id` (`penyakit_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_users`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `gejala`
--
ALTER TABLE `gejala`
  MODIFY `id_gejala` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `hasil`
--
ALTER TABLE `hasil`
  MODIFY `id_hasil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `hasil_detail`
--
ALTER TABLE `hasil_detail`
  MODIFY `id_hasil_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT untuk tabel `konfigurasi`
--
ALTER TABLE `konfigurasi`
  MODIFY `id_konfigurasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `penyakit`
--
ALTER TABLE `penyakit`
  MODIFY `id_penyakit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `probabilitas_pakar`
--
ALTER TABLE `probabilitas_pakar`
  MODIFY `id_probabilitas_pakar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `profile`
--
ALTER TABLE `profile`
  MODIFY `id_profile` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `rule`
--
ALTER TABLE `rule`
  MODIFY `id_rule` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `rule_detail`
--
ALTER TABLE `rule_detail`
  MODIFY `id_rule_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT untuk tabel `solusi`
--
ALTER TABLE `solusi`
  MODIFY `id_solusi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_users` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `hasil`
--
ALTER TABLE `hasil`
  ADD CONSTRAINT `hasil_ibfk_1` FOREIGN KEY (`penyakit_id`) REFERENCES `penyakit` (`id_penyakit`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `hasil_ibfk_2` FOREIGN KEY (`users_id`) REFERENCES `users` (`id_users`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `hasil_detail`
--
ALTER TABLE `hasil_detail`
  ADD CONSTRAINT `hasil_detail_ibfk_1` FOREIGN KEY (`gejala_id`) REFERENCES `gejala` (`id_gejala`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `hasil_detail_ibfk_3` FOREIGN KEY (`hasil_id`) REFERENCES `hasil` (`id_hasil`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `probabilitas_pakar`
--
ALTER TABLE `probabilitas_pakar`
  ADD CONSTRAINT `probabilitas_pakar_ibfk_1` FOREIGN KEY (`gejala_id`) REFERENCES `gejala` (`id_gejala`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `probabilitas_pakar_ibfk_2` FOREIGN KEY (`penyakit_id`) REFERENCES `penyakit` (`id_penyakit`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `profile_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id_users`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `rule`
--
ALTER TABLE `rule`
  ADD CONSTRAINT `rule_ibfk_1` FOREIGN KEY (`penyakit_id`) REFERENCES `penyakit` (`id_penyakit`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `rule_detail`
--
ALTER TABLE `rule_detail`
  ADD CONSTRAINT `rule_detail_ibfk_1` FOREIGN KEY (`gejala_id`) REFERENCES `gejala` (`id_gejala`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rule_detail_ibfk_3` FOREIGN KEY (`rule_id`) REFERENCES `rule` (`id_rule`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `solusi`
--
ALTER TABLE `solusi`
  ADD CONSTRAINT `solusi_ibfk_1` FOREIGN KEY (`penyakit_id`) REFERENCES `penyakit` (`id_penyakit`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
