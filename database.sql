-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               10.5.5-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for pengolahsampah
CREATE DATABASE IF NOT EXISTS `pengolahsampah` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `pengolahsampah`;

-- Dumping structure for table pengolahsampah.daurulang
CREATE TABLE IF NOT EXISTS `daurulang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_sampah` int(11) DEFAULT NULL,
  `id_kategori` int(11) DEFAULT NULL,
  `jumlah` int(100) DEFAULT NULL,
  `keterangan` varchar(50) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_sampah` (`id_sampah`),
  KEY `kategori` (`id_kategori`),
  CONSTRAINT `FK_banksampah_kategori` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`),
  CONSTRAINT `FK_banksampah_sampah` FOREIGN KEY (`id_sampah`) REFERENCES `sampah` (`id_sampah`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Dumping data for table pengolahsampah.daurulang: ~3 rows (approximately)
/*!40000 ALTER TABLE `daurulang` DISABLE KEYS */;
REPLACE INTO `daurulang` (`id`, `id_sampah`, `id_kategori`, `jumlah`, `keterangan`, `tanggal`) VALUES
	(3, NULL, 1, 2, 'ton', '2020-12-02'),
	(4, NULL, 1, 2, 'pcs', '2020-12-02');
/*!40000 ALTER TABLE `daurulang` ENABLE KEYS */;

-- Dumping structure for table pengolahsampah.kategori
CREATE TABLE IF NOT EXISTS `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_kategori`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table pengolahsampah.kategori: ~4 rows (approximately)
/*!40000 ALTER TABLE `kategori` DISABLE KEYS */;
REPLACE INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
	(1, 'Kaleng Bekas'),
	(2, 'Karton/Dus'),
	(3, 'Kertas'),
	(4, 'Botol Plastik');
/*!40000 ALTER TABLE `kategori` ENABLE KEYS */;

-- Dumping structure for table pengolahsampah.komposter
CREATE TABLE IF NOT EXISTS `komposter` (
  `id_kompos` int(11) NOT NULL AUTO_INCREMENT,
  `id_sampah` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `suhu` int(11) DEFAULT NULL,
  `kondisi` varchar(50) DEFAULT NULL,
  `keterangan` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_kompos`),
  KEY `id_sampah` (`id_sampah`),
  CONSTRAINT `FK_komposter_sampah` FOREIGN KEY (`id_sampah`) REFERENCES `sampah` (`id_sampah`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dumping data for table pengolahsampah.komposter: ~3 rows (approximately)
/*!40000 ALTER TABLE `komposter` DISABLE KEYS */;
REPLACE INTO `komposter` (`id_kompos`, `id_sampah`, `tanggal`, `suhu`, `kondisi`, `keterangan`) VALUES
	(1, 2, '2020-11-11', 24, 'masih basah', 'awal masuk'),
	(2, NULL, '2020-12-02', 26, 'berwarna hitam', 'dsa'),
	(4, NULL, '2020-12-02', 26, 'sad', '');
/*!40000 ALTER TABLE `komposter` ENABLE KEYS */;

-- Dumping structure for table pengolahsampah.level
CREATE TABLE IF NOT EXISTS `level` (
  `id_level` int(11) NOT NULL,
  `nama_level` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_level`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table pengolahsampah.level: ~2 rows (approximately)
/*!40000 ALTER TABLE `level` DISABLE KEYS */;
REPLACE INTO `level` (`id_level`, `nama_level`) VALUES
	(1, 'admin'),
	(2, 'user');
/*!40000 ALTER TABLE `level` ENABLE KEYS */;

-- Dumping structure for table pengolahsampah.sampah
CREATE TABLE IF NOT EXISTS `sampah` (
  `id_sampah` int(11) NOT NULL AUTO_INCREMENT,
  `massa_total` int(11) DEFAULT NULL,
  `organik` int(11) DEFAULT NULL,
  `anorganik` int(11) DEFAULT NULL,
  `residu` int(11) DEFAULT NULL,
  `tanggal_masuk` date DEFAULT NULL,
  PRIMARY KEY (`id_sampah`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

-- Dumping data for table pengolahsampah.sampah: ~5 rows (approximately)
/*!40000 ALTER TABLE `sampah` DISABLE KEYS */;
REPLACE INTO `sampah` (`id_sampah`, `massa_total`, `organik`, `anorganik`, `residu`, `tanggal_masuk`) VALUES
	(1, 2, 1, 1, 0, '2020-12-01'),
	(2, 4, NULL, NULL, NULL, '2020-11-11'),
	(3, 1, NULL, NULL, NULL, '2020-11-11'),
	(9, 7, NULL, NULL, NULL, '2020-11-30'),
	(15, 2, 2, 2, 2, '2020-12-02');
/*!40000 ALTER TABLE `sampah` ENABLE KEYS */;

-- Dumping structure for table pengolahsampah.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL,
  `pass` varchar(50) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pass` (`pass`),
  KEY `level` (`level`),
  CONSTRAINT `FK_user_level` FOREIGN KEY (`level`) REFERENCES `level` (`id_level`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table pengolahsampah.user: ~2 rows (approximately)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
REPLACE INTO `user` (`id`, `pass`, `level`, `username`) VALUES
	(1, '13213', 1, 'aqimuddin225'),
	(2, '2313', 2, 'test');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
