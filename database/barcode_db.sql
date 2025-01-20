-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               11.4.2-MariaDB-log - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table barcode_db.absensi
CREATE TABLE IF NOT EXISTS `absensi` (
  `id_absensi` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `status` enum('Hadir','Terlambat') NOT NULL,
  `mood` varchar(50) NOT NULL,
  `reason` text DEFAULT NULL,
  `timestamp` time NOT NULL,
  PRIMARY KEY (`id_absensi`),
  KEY `FK_absensi_users` (`id_user`),
  CONSTRAINT `FK_absensi_users` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table barcode_db.absensi: ~0 rows (approximately)

-- Dumping structure for table barcode_db.jurusan
CREATE TABLE IF NOT EXISTS `jurusan` (
  `kode_jurusan` varchar(3) NOT NULL,
  `nama_jurusan` varchar(50) NOT NULL,
  PRIMARY KEY (`kode_jurusan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table barcode_db.jurusan: ~5 rows (approximately)
REPLACE INTO `jurusan` (`kode_jurusan`, `nama_jurusan`) VALUES
	('PH', 'Perhotelan'),
	('RPL', 'Rekayasa Perangkat Lunak'),
	('TBG', 'Tata Boga'),
	('TBS', 'Tata Busana'),
	('ULW', 'Usaha Layanan Pariwisata');

-- Dumping structure for table barcode_db.kelas
CREATE TABLE IF NOT EXISTS `kelas` (
  `id_kelas` int(11) NOT NULL AUTO_INCREMENT,
  `kelas` varchar(25) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_kelas`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table barcode_db.kelas: ~15 rows (approximately)
REPLACE INTO `kelas` (`id_kelas`, `kelas`) VALUES
	(1, '10 RPL 1'),
	(2, '10 RPL 2'),
	(3, '11 RPL 1'),
	(4, '11 RPL 2'),
	(5, '12 RPL 1'),
	(6, '12 RPL 2'),
	(7, '10 TBG 1'),
	(8, '10 TBG 2'),
	(9, '10 TBG 3'),
	(10, '11 TBG 1'),
	(11, '11 TBG 2'),
	(12, '11 TBG 3'),
	(13, '12 TBG 1'),
	(14, '12 TBG 2'),
	(15, '12 TBG 3');

-- Dumping structure for table barcode_db.qrcode
CREATE TABLE IF NOT EXISTS `qrcode` (
  `id_qrcode` int(11) NOT NULL AUTO_INCREMENT,
  `key_qrcode` varchar(255) NOT NULL,
  `tanggal_aktif` date NOT NULL,
  PRIMARY KEY (`id_qrcode`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table barcode_db.qrcode: ~0 rows (approximately)
REPLACE INTO `qrcode` (`id_qrcode`, `key_qrcode`, `tanggal_aktif`) VALUES
	(1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJkYXRhIjoiNWVhOTk5YjEtY2M3OC0zZTU4LWI5MjAtMTEwN2RiYTk4NTM0IiwidGFuZ2dhbCI6IjIwMjUtMDEtMTIifQ.ftDPFjPgbJsRFstR7u6hoc7tp2DaOq3FcZbJGrdmjh4', '2025-01-12'),
	(2, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJkYXRhIjoiMjVhNjYwYmYtZDhmMy0zYmMxLWE1ZTQtNzI3Mjg4NjgwOTNmIiwidGFuZ2dhbCI6IjIwMjUtMDEtMTQifQ.Di330wzsNYzyZXp7A8RvGSfixar69brD1mtiBxLUDnQ', '2025-01-14'),
	(3, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJkYXRhIjoiOTA2M2NjNWYtNWRkNS0zOWE3LTkzOGEtMDFhOWU0MTJjN2NjIiwidGFuZ2dhbCI6IjIwMjUtMDEtMTkifQ.DV7eHeoin8Yoo_Bo0h3k--3CCnUVv6YXAF6Cq1NWh2g', '2025-01-19'),
	(4, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJkYXRhIjoiYmU4MjUwYjctMGM3My0zZTc5LWE4MTktYzk2ZDFmMTI3NWFhIiwidGFuZ2dhbCI6IjIwMjUtMDEtMjAifQ.hyY_MvecA-cxznzQGwGUWaliYcloO1TPLaqKp1B7j6o', '2025-01-20');

-- Dumping structure for table barcode_db.users
CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(70) NOT NULL,
  `password` varchar(255) NOT NULL,
  `id_role` int(11) NOT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `email` (`email`),
  KEY `FK_users_user_roles` (`id_role`),
  CONSTRAINT `FK_users_user_roles` FOREIGN KEY (`id_role`) REFERENCES `user_roles` (`id_role`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table barcode_db.users: ~6 rows (approximately)
REPLACE INTO `users` (`id_user`, `email`, `password`, `id_role`) VALUES
	(1, 'admin@email.com', '123', 3),
	(2, 'aa@gmail.com', '123', 1),
	(3, 'guru1@gmail.com', '123', 2),
	(4, 'usea@gmail.com', '123', 1),
	(13, 'user3@gmail.com', '123', 1),
	(17, 'user4@gmail.com', '13', 1);

-- Dumping structure for table barcode_db.user_roles
CREATE TABLE IF NOT EXISTS `user_roles` (
  `id_role` int(11) NOT NULL AUTO_INCREMENT,
  `name_role` varchar(50) NOT NULL,
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table barcode_db.user_roles: ~2 rows (approximately)
REPLACE INTO `user_roles` (`id_role`, `name_role`) VALUES
	(1, 'Siswa'),
	(2, 'Guru'),
	(3, 'Admin');

-- Dumping structure for table barcode_db.u_guru
CREATE TABLE IF NOT EXISTS `u_guru` (
  `id_guru` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nip` varchar(50) NOT NULL,
  PRIMARY KEY (`id_guru`),
  KEY `FK_u_guru_users` (`id_user`),
  CONSTRAINT `FK_u_guru_users` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table barcode_db.u_guru: ~0 rows (approximately)
REPLACE INTO `u_guru` (`id_guru`, `id_user`, `nama`, `nip`) VALUES
	(1, 3, 'Guru', '123');

-- Dumping structure for table barcode_db.u_siswa
CREATE TABLE IF NOT EXISTS `u_siswa` (
  `id_siswa` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `id_kelas` int(11) NOT NULL DEFAULT 0,
  `kode_jurusan` varchar(3) NOT NULL,
  `no_absen` varchar(2) NOT NULL,
  `nis` varchar(10) NOT NULL,
  `nisn` int(20) NOT NULL,
  `foto` varchar(255) NOT NULL,
  PRIMARY KEY (`id_siswa`) USING BTREE,
  UNIQUE KEY `nis` (`nis`),
  UNIQUE KEY `nisn` (`nisn`),
  UNIQUE KEY `id_user_uniq` (`id_user`),
  UNIQUE KEY `kelas_kode_jurusan_no_absen` (`id_kelas`,`kode_jurusan`,`no_absen`) USING BTREE,
  KEY `id_user` (`id_user`),
  KEY `kode_jurusan` (`kode_jurusan`),
  KEY `id_kelas` (`id_kelas`) USING BTREE,
  CONSTRAINT `FK_u_siswa_jurusan` FOREIGN KEY (`kode_jurusan`) REFERENCES `jurusan` (`kode_jurusan`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_u_siswa_kelas` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `u_siswa_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table barcode_db.u_siswa: ~4 rows (approximately)
REPLACE INTO `u_siswa` (`id_siswa`, `id_user`, `nama`, `id_kelas`, `kode_jurusan`, `no_absen`, `nis`, `nisn`, `foto`) VALUES
	(3, 2, 'tes', 1, 'RPL', '1', '1', 1, 'img/tes.png'),
	(6, 4, 'a', 2, 'RPL', '', '2', 2, ''),
	(7, 13, 'a', 1, 'RPL', '2', '3', 3, ''),
	(10, 17, 'a', 1, 'RPL', '', '4', 4, '');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
