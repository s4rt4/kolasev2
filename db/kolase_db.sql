-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
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


-- Dumping database structure for kolase_db
CREATE DATABASE IF NOT EXISTS `kolase_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `kolase_db`;

-- Dumping structure for table kolase_db.admin
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table kolase_db.admin: ~1 rows (approximately)
INSERT INTO `admin` (`id`, `username`, `password`) VALUES
	(3, 'admin', '$2y$10$jWw6MZL4ng4iNs3Y9aWWIuK7wYn0HoXEOQ5g42ZOINmrHFCDAyZeC');

-- Dumping structure for table kolase_db.foto
CREATE TABLE IF NOT EXISTS `foto` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_foto` varchar(150) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `kategori_id` int NOT NULL,
  `fotografer_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kategori_id` (`kategori_id`),
  KEY `fotografer_id` (`fotografer_id`),
  CONSTRAINT `foto_ibfk_1` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`),
  CONSTRAINT `foto_ibfk_2` FOREIGN KEY (`fotografer_id`) REFERENCES `fotografer` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table kolase_db.foto: ~30 rows (approximately)
INSERT INTO `foto` (`id`, `nama_foto`, `file_path`, `tanggal`, `kategori_id`, `fotografer_id`) VALUES
	(1, 'landscape of lake', '1757233074_1.webp', '2025-07-08', 1, 1),
	(2, 'mountain at night', '1757233114_2.webp', '2025-07-17', 4, 2),
	(3, 'windows', '1757237017_3.webp', '2025-07-10', 5, 3),
	(4, 'blue car', '1757237047_4.webp', '2025-04-17', 6, 1),
	(5, 'muslim', '1757240958_5.webp', '2025-06-12', 2, 3),
	(7, 'bunga pink', '1757241049_6.webp', '2025-06-18', 4, 2),
	(8, 'jendela', '1757241072_7.webp', '2025-09-07', 5, NULL),
	(9, 'ban mobil', '1757241098_8.webp', '2025-06-19', 6, 3),
	(10, 'penari', '1757241118_9.webp', '2025-09-01', 2, 3),
	(11, 'ruang tamu', '1757241147_10.webp', '2025-07-23', 5, 1),
	(12, 'arsitektur', '1757242303_11.webp', '2025-09-03', 5, 2),
	(13, 'hutan', '1757242319_12.webp', '2025-09-02', 4, 1),
	(14, 'orang di mobil', '1757242342_13.webp', '2025-07-10', 2, 4),
	(15, 'gunung pasir', '1757242364_14.webp', '2025-08-13', 1, 3),
	(16, 'lampu kamar', '1757300478_15.webp', '2025-06-04', 6, 1),
	(17, 'pemandangan danau du tengah gunung', '1757300505_16.webp', '2025-09-05', 1, 3),
	(18, 'alat alat travel', '1757300529_17.webp', '2025-03-06', 6, 4),
	(19, 'bangunan bersejarah', '1757300559_18.webp', '2025-08-13', 5, 4),
	(20, 'perempuan cantik', '1757300589_19.webp', '2025-09-01', 2, 1),
	(21, 'ruangan', '1757300614_20.webp', '2025-08-28', 5, 1),
	(22, 'bunga putih indah', '1757300641_21.webp', '2025-08-21', 4, 2),
	(23, 'pemandangan langit berbintang', '1757300932_22.webp', '2025-08-12', 1, 2),
	(24, 'orang di pantai', '1757300955_23.webp', '2025-08-20', 2, 3),
	(25, 'zoom muka orang', '1757300987_24.webp', '2025-06-12', 2, 3),
	(26, 'logo ferrari', '1757301021_25.webp', '2025-07-17', 6, 4),
	(27, 'kursi biru', '1757301048_26.webp', '2025-08-20', 6, 3),
	(28, 'rumah asri', '1757301099_27.webp', '2025-06-25', 5, 2),
	(29, 'galaxy', '1757301134_28.webp', '2025-09-05', 1, 4),
	(30, 'pemandangan gunung', '1757301159_29.webp', '2025-09-03', 1, 3),
	(31, 'orang minum', '1757301183_34.webp', '2025-09-04', 2, 1);

-- Dumping structure for table kolase_db.fotografer
CREATE TABLE IF NOT EXISTS `fotografer` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_fotografer` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table kolase_db.fotografer: ~4 rows (approximately)
INSERT INTO `fotografer` (`id`, `nama_fotografer`) VALUES
	(1, 'sarta wijaya'),
	(2, 'sarta abi umay'),
	(3, 'sarta saja'),
	(4, 'sarta doang');

-- Dumping structure for table kolase_db.kategori
CREATE TABLE IF NOT EXISTS `kategori` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table kolase_db.kategori: ~6 rows (approximately)
INSERT INTO `kategori` (`id`, `nama_kategori`) VALUES
	(1, 'landscape'),
	(2, 'people'),
	(3, 'public'),
	(4, 'nature'),
	(5, 'arsitektur'),
	(6, 'benda');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
