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

-- Dumping data for table barcode_db.absensi: ~0 rows (approximately)
INSERT INTO `absensi` (`id_absensi`, `id_user`, `tanggal`, `status`, `mood`, `reason`, `timestamp`) VALUES
	(6, 13, '2025-01-19', 'Hadir', 'Baik', 'Baik', '05:38:18');

-- Dumping data for table barcode_db.jurusan: ~5 rows (approximately)
INSERT INTO `jurusan` (`kode_jurusan`, `nama_jurusan`) VALUES
	('PH', 'Perhotelan'),
	('RPL', 'Rekayasa Perangkat Lunak'),
	('TBG', 'Tata Boga'),
	('TBS', 'Tata Busana'),
	('ULW', 'Usaha Layanan Pariwisata');

-- Dumping data for table barcode_db.kelas: ~15 rows (approximately)
INSERT INTO `kelas` (`id_kelas`, `kelas`) VALUES
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

-- Dumping data for table barcode_db.qrcode: ~0 rows (approximately)
INSERT INTO `qrcode` (`id_qrcode`, `key_qrcode`, `tanggal_aktif`) VALUES
	(1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJkYXRhIjoiNWVhOTk5YjEtY2M3OC0zZTU4LWI5MjAtMTEwN2RiYTk4NTM0IiwidGFuZ2dhbCI6IjIwMjUtMDEtMTIifQ.ftDPFjPgbJsRFstR7u6hoc7tp2DaOq3FcZbJGrdmjh4', '2025-01-12'),
	(2, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJkYXRhIjoiMjVhNjYwYmYtZDhmMy0zYmMxLWE1ZTQtNzI3Mjg4NjgwOTNmIiwidGFuZ2dhbCI6IjIwMjUtMDEtMTQifQ.Di330wzsNYzyZXp7A8RvGSfixar69brD1mtiBxLUDnQ', '2025-01-14'),
	(3, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJkYXRhIjoiOTA2M2NjNWYtNWRkNS0zOWE3LTkzOGEtMDFhOWU0MTJjN2NjIiwidGFuZ2dhbCI6IjIwMjUtMDEtMTkifQ.DV7eHeoin8Yoo_Bo0h3k--3CCnUVv6YXAF6Cq1NWh2g', '2025-01-19'),
	(4, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJkYXRhIjoiYmU4MjUwYjctMGM3My0zZTc5LWE4MTktYzk2ZDFmMTI3NWFhIiwidGFuZ2dhbCI6IjIwMjUtMDEtMjAifQ.hyY_MvecA-cxznzQGwGUWaliYcloO1TPLaqKp1B7j6o', '2025-01-20'),
	(5, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJkYXRhIjoiNjBhZWFhNjUtMWYyMC0zOTBlLWE1OWUtNmU5MWQxMzViODBhIiwidGFuZ2dhbCI6IjIwMjUtMDEtMjEifQ.KjONfLtO-XXha_eYSMxdf4yVOgF1rQ1ZwHk9F0tjRD8', '2025-01-21');

-- Dumping data for table barcode_db.users: ~6 rows (approximately)
INSERT INTO `users` (`id_user`, `email`, `password`, `id_role`) VALUES
	(1, 'admin@email.com', '123', 3),
	(2, 'aa@gmail.com', '123', 1),
	(3, 'guru1@gmail.com', '123', 2),
	(4, 'usea@gmail.com', '123', 1),
	(13, 'user3@gmail.com', '123', 1),
	(17, 'user4@gmail.com', '13', 1);

-- Dumping data for table barcode_db.user_roles: ~2 rows (approximately)
INSERT INTO `user_roles` (`id_role`, `name_role`) VALUES
	(1, 'Siswa'),
	(2, 'Guru'),
	(3, 'Admin');

-- Dumping data for table barcode_db.u_guru: ~0 rows (approximately)
INSERT INTO `u_guru` (`id_guru`, `id_user`, `nama`, `nip`) VALUES
	(1, 3, 'Guru', '123');

-- Dumping data for table barcode_db.u_siswa: ~4 rows (approximately)
INSERT INTO `u_siswa` (`id_siswa`, `id_user`, `nama`, `id_kelas`, `kode_jurusan`, `no_absen`, `nis`, `nisn`, `foto`) VALUES
	(3, 2, 'halo', 1, 'RPL', '1', '1\n', 1, '1737527023_395e37a7386fd3e04b88.jpg'),
	(6, 4, 'a', 2, 'RPL', '1', '2', 2, ''),
	(7, 13, 'a', 1, 'RPL', '2', '3', 3, ''),
	(10, 17, 'a', 1, 'RPL', '3', '4', 4, '');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
