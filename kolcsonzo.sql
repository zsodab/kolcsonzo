-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.28-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.6.0.6765
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for kolcsonzo
CREATE DATABASE IF NOT EXISTS `kolcsonzo` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `kolcsonzo`;

-- Dumping structure for table kolcsonzo.admin
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `oUserID` int(11) NOT NULL,
  `oUserName` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `oUserID` (`oUserID`),
  KEY `oUserName` (`oUserName`),
  CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`oUserID`) REFERENCES `onlineuser` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `admin_ibfk_2` FOREIGN KEY (`oUserName`) REFERENCES `onlineuser` (`username`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table kolcsonzo.admin: ~1 rows (approximately)
INSERT INTO `admin` (`id`, `oUserID`, `oUserName`) VALUES
	(1, 1, 'admin');

-- Dumping structure for table kolcsonzo.booking_data
CREATE TABLE IF NOT EXISTS `booking_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(255) NOT NULL,
  `datePickup` datetime NOT NULL,
  `dateReturn` datetime NOT NULL,
  `returnedOnTime` tinyint(1) DEFAULT NULL,
  `priceEstimate` int(11) NOT NULL,
  `pricePaid` int(11) DEFAULT NULL,
  `wantsCallBack` tinyint(1) DEFAULT NULL,
  `dshipID` int(11) NOT NULL,
  `carID` int(11) DEFAULT NULL,
  `oUserID` int(11) DEFAULT NULL,
  `userID` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `dshipID` (`dshipID`),
  KEY `carID` (`carID`),
  KEY `oUserID` (`oUserID`),
  KEY `userID` (`userID`),
  CONSTRAINT `booking_data_ibfk_1` FOREIGN KEY (`dshipID`) REFERENCES `dealership` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `booking_data_ibfk_2` FOREIGN KEY (`carID`) REFERENCES `car` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `booking_data_ibfk_3` FOREIGN KEY (`oUserID`) REFERENCES `onlineuser` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `booking_data_ibfk_4` FOREIGN KEY (`userID`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table kolcsonzo.booking_data: ~3 rows (approximately)
INSERT INTO `booking_data` (`id`, `status`, `datePickup`, `dateReturn`, `returnedOnTime`, `priceEstimate`, `pricePaid`, `wantsCallBack`, `dshipID`, `carID`, `oUserID`, `userID`) VALUES
	(1, 'active', '2024-11-28 12:00:00', '2024-12-07 12:00:00', NULL, 112500, 10000, NULL, 1, 1, 2, 2),
	(2, 'active', '2024-11-26 12:00:00', '2024-12-05 12:00:00', NULL, 140000, 10000, NULL, 2, 15, NULL, 8),
	(3, 'active', '2024-11-27 12:00:00', '2024-11-29 12:00:00', NULL, 25000, 10000, NULL, 3, 21, 3, 3);

-- Dumping structure for table kolcsonzo.car
CREATE TABLE IF NOT EXISTS `car` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `isAvailable` tinyint(1) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `year` int(11) NOT NULL,
  `capacity` int(11) NOT NULL,
  `fuelType` varchar(255) NOT NULL,
  `fuelConsumption` int(11) NOT NULL,
  `description` text NOT NULL,
  `depositAmount` int(11) NOT NULL,
  `tierIduration` int(11) NOT NULL,
  `tierIprice` int(11) NOT NULL,
  `tierIIduration` int(11) NOT NULL,
  `tierIIprice` int(11) NOT NULL,
  `tierCustomNotes` text DEFAULT NULL,
  `dealerID` int(11) NOT NULL,
  `picture` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `dealerID` (`dealerID`),
  CONSTRAINT `car_ibfk_1` FOREIGN KEY (`dealerID`) REFERENCES `dealer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table kolcsonzo.car: ~54 rows (approximately)
INSERT INTO `car` (`id`, `isAvailable`, `brand`, `model`, `year`, `capacity`, `fuelType`, `fuelConsumption`, `description`, `depositAmount`, `tierIduration`, `tierIprice`, `tierIIduration`, `tierIIprice`, `tierCustomNotes`, `dealerID`, `picture`) VALUES
	(1, 0, 'Audi', 'A4', 2019, 5, 'benzin', 7, 'Ez egy nagyon szép autó.', 10000, 10, 12500, 30, 7700, NULL, 1, 'kepek/autok/audi.jpg'),
	(2, 1, 'Audi', 'A6', 2019, 5, 'benzin', 7, 'Ez egy nagyon szép autó.', 10000, 10, 21500, 30, 16550, NULL, 1, 'kepek/autok/audi.jpg'),
	(3, 1, 'Audi', 'A8', 2019, 5, 'benzin', 7, 'Ez egy nagyon szép autó.', 10000, 10, 11000, 30, 8500, NULL, 1, 'kepek/autok/audi.jpg'),
	(4, 1, 'Audi', 'Q3', 2019, 5, 'benzin', 7, 'Ez egy nagyon szép autó.', 10000, 10, 16000, 30, 12000, NULL, 1, 'kepek/autok/audi.jpg'),
	(5, 1, 'Audi', 'Q5', 2019, 5, 'benzin', 7, 'Ez egy nagyon szép autó.', 10000, 10, 14000, 30, 10000, NULL, 1, 'kepek/autok/audi.jpg'),
	(6, 1, 'Audi', 'Q7', 2019, 5, 'benzin', 7, 'Ez egy nagyon szép autó.', 10000, 10, 17000, 0, 0, '10 nap felett személyes ajánlatot kínálunk', 1, 'kepek/autok/audi.jpg'),
	(7, 1, 'Audi', 'Q8', 2019, 5, 'benzin', 7, 'Ez egy nagyon szép autó.', 10000, 10, 20500, 30, 17500, NULL, 1, 'kepek/autok/audi.jpg'),
	(8, 1, 'Audi', 'TT', 2019, 5, 'benzin', 7, 'Ez egy nagyon szép autó.', 10000, 10, 18000, 30, 25000, NULL, 1, 'kepek/autok/audi.jpg'),
	(9, 1, 'Audi', 'R8', 2019, 5, 'benzin', 7, 'Ez egy nagyon szép autó.', 10000, 10, 25000, 0, 0, '10-20 napig 22500Ft, efelett érdeklődni személyesen', 1, 'kepek/autok/audi.jpg'),
	(10, 1, 'Audi', 'RS3', 2019, 5, 'benzin', 7, 'Ez egy nagyon szép autó.', 10000, 10, 20000, 30, 16500, NULL, 1, 'kepek/autok/audi.jpg'),
	(11, 1, 'BMW', '1-es', 2019, 5, 'benzin', 7, 'Ez egy nagyon szép autó.', 10000, 10, 12500, 30, 7700, NULL, 2, 'kepek/autok/bmw.jpg'),
	(12, 1, 'BMW', '2-es', 2019, 5, 'benzin', 7, 'Ez egy nagyon szép autó.', 10000, 10, 21500, 30, 16550, NULL, 2, 'kepek/autok/bmw.jpg'),
	(13, 1, 'BMW', '3-as', 2019, 5, 'benzin', 7, 'Ez egy nagyon szép autó.', 10000, 10, 11000, 30, 8500, NULL, 2, 'kepek/autok/bmw.jpg'),
	(14, 1, 'BMW', '4-es', 2019, 5, 'benzin', 7, 'Ez egy nagyon szép autó.', 10000, 10, 16000, 30, 12000, NULL, 2, 'kepek/autok/bmw.jpg'),
	(15, 0, 'BMW', '5-ös', 2019, 5, 'benzin', 7, 'Ez egy nagyon szép autó.', 10000, 10, 14000, 30, 10000, NULL, 2, 'kepek/autok/bmw.jpg'),
	(16, 1, 'BMW', '6-os', 2019, 5, 'benzin', 7, 'Ez egy nagyon szép autó.', 10000, 10, 17000, 0, 0, '10 nap felett személyes ajánlatot kínálunk', 2, 'kepek/autok/bmw.jpg'),
	(17, 1, 'BMW', '7-es', 2019, 5, 'benzin', 7, 'Ez egy nagyon szép autó.', 10000, 10, 20500, 30, 17500, NULL, 2, 'kepek/autok/bmw.jpg'),
	(18, 1, 'BMW', 'X1', 2019, 5, 'benzin', 7, 'Ez egy nagyon szép autó.', 10000, 10, 18000, 30, 16000, NULL, 2, 'kepek/autok/bmw.jpg'),
	(19, 1, 'BMW', 'X2', 2019, 5, 'benzin', 7, 'Ez egy nagyon szép autó.', 10000, 10, 25000, 0, 0, '10-20 napig 22500Ft, efelett érdeklődni személyesen', 2, 'kepek/autok/bmw.jpg'),
	(20, 1, 'BMW', 'X3', 2019, 5, 'benzin', 7, 'Ez egy nagyon szép autó.', 10000, 10, 20000, 30, 16500, NULL, 2, 'kepek/autok/bmw.jpg'),
	(21, 0, 'Mercedes', 'A-osztály', 2019, 5, 'benzin', 7, 'Ez egy nagyon szép autó.', 10000, 10, 12500, 30, 7700, NULL, 3, 'kepek/autok/mercedes.jpg'),
	(22, 1, 'Mercedes', 'B-osztály', 2019, 5, 'benzin', 7, 'Ez egy nagyon szép autó.', 10000, 10, 21500, 30, 16550, NULL, 3, 'kepek/autok/mercedes.jpg'),
	(23, 1, 'Mercedes', 'C-osztály', 2019, 5, 'benzin', 7, 'Ez egy nagyon szép autó.', 10000, 10, 11000, 30, 8500, NULL, 3, 'kepek/autok/mercedes.jpg'),
	(24, 1, 'Mercedes', 'E-osztály', 2019, 5, 'benzin', 7, 'Ez egy nagyon szép autó.', 10000, 10, 16000, 30, 12000, NULL, 3, 'kepek/autok/mercedes.jpg'),
	(25, 1, 'Mercedes', 'S-osztály', 2019, 5, 'benzin', 7, 'Ez egy nagyon szép autó.', 10000, 10, 14000, 30, 10000, NULL, 3, 'kepek/autok/mercedes.jpg'),
	(26, 1, 'Mercedes', 'GLA', 2019, 5, 'benzin', 7, 'Ez egy nagyon szép autó.', 10000, 10, 17000, 0, 0, '10 nap felett személyes ajánlatot kínálunk', 3, 'kepek/autok/mercedes.jpg'),
	(27, 1, 'Mercedes', 'GLC', 2019, 5, 'benzin', 7, 'Ez egy nagyon szép autó.', 10000, 10, 20500, 30, 17500, NULL, 3, 'kepek/autok/mercedes.jpg'),
	(28, 1, 'Mercedes', 'GLE', 2019, 5, 'benzin', 7, 'Ez egy nagyon szép autó.', 10000, 10, 18000, 30, 16000, NULL, 3, 'kepek/autok/mercedes.jpg'),
	(29, 1, 'Mercedes', 'GLS', 2019, 5, 'benzin', 7, 'Ez egy nagyon szép autó.', 10000, 10, 25000, 0, 0, '10-20 napig 22500Ft, efelett érdeklődni személyesen', 3, 'kepek/autok/mercedes.jpg'),
	(30, 1, 'Mercedes', 'AMG GT', 2019, 5, 'benzin', 7, 'Ez egy nagyon szép autó.', 10000, 10, 20000, 30, 16500, NULL, 3, 'kepek/autok/mercedes.jpg'),
	(31, 1, 'Suzuki', 'SX4', 2010, 5, 'dízel', 6, 'Ez egy Suzuki', 10000, 10, 10500, 30, 8000, NULL, 1, 'kepek/autok/suzuki.jpg'),
	(32, 1, 'Opel', 'Insignia', 2016, 5, 'benzin', 7, 'Ez egy Open', 10000, 10, 18500, 30, 1600, NULL, 1, 'kepek/autok/opel.jpg'),
	(33, 1, 'Ford', 'Focus', 2018, 5, 'dízel', 5, 'Ez egy Ford', 10000, 10, 15500, 30, 13000, NULL, 1, 'kepek/autok/ford.jpg'),
	(34, 1, 'Toyota', 'Corolla', 2019, 5, 'benzin', 6, 'Ez egy Toyota', 10000, 10, 17500, 30, 15000, NULL, 1, 'kepek/autok/toyota.jpg'),
	(35, 1, 'Volkswagen', 'Passat', 2017, 5, 'dízel', 5, 'Ez egy Volkswagen', 10000, 10, 16500, 30, 14000, NULL, 1, 'kepek/autok/volkswagen.jpg'),
	(36, 1, 'BMW', '3', 2016, 5, 'dízel', 6, 'Ez egy BMW', 10000, 10, 18500, 30, 16000, NULL, 1, 'kepek/autok/bmw.jpg'),
	(37, 1, 'Mercedes', 'C', 2017, 5, 'benzin', 7, 'Ez egy Mercedes', 10000, 10, 19500, 30, 17000, NULL, 1, 'kepek/autok/mercedes.jpg'),
	(38, 1, 'Skoda', 'Octavia', 2018, 5, 'dízel', 5, 'Ez egy Skoda', 10000, 10, 15500, 30, 13000, NULL, 1, 'kepek/autok/skoda.jpg'),
	(39, 1, 'Suzuki', 'SX4', 2010, 5, 'dízel', 6, 'Ez egy Suzuki', 10000, 10, 10500, 30, 8000, NULL, 2, 'kepek/autok/suzuki.jpg'),
	(40, 1, 'Opel', 'Insignia', 2016, 5, 'benzin', 7, 'Ez egy Open', 10000, 10, 18500, 30, 1600, NULL, 2, 'kepek/autok/opel.jpg'),
	(41, 1, 'Ford', 'Focus', 2018, 5, 'dízel', 5, 'Ez egy Ford', 10000, 10, 15500, 30, 13000, NULL, 2, 'kepek/autok/ford.jpg'),
	(42, 1, 'Toyota', 'Corolla', 2019, 5, 'benzin', 6, 'Ez egy Toyota', 10000, 10, 17500, 30, 15000, NULL, 2, 'kepek/autok/toyota.jpg'),
	(43, 1, 'Volkswagen', 'Passat', 2017, 5, 'dízel', 5, 'Ez egy Volkswagen', 10000, 10, 16500, 30, 14000, NULL, 2, 'kepek/autok/volkswagen.jpg'),
	(44, 1, 'BMW', '3', 2016, 5, 'dízel', 6, 'Ez egy BMW', 10000, 10, 18500, 30, 16000, NULL, 2, 'kepek/autok/bmw.jpg'),
	(45, 1, 'Mercedes', 'C', 2017, 5, 'benzin', 7, 'Ez egy Mercedes', 10000, 10, 19500, 30, 17000, NULL, 2, 'kepek/autok/mercedes.jpg'),
	(46, 1, 'Skoda', 'Octavia', 2018, 5, 'dízel', 5, 'Ez egy Skoda', 10000, 10, 15500, 30, 13000, NULL, 2, 'kepek/autok/skoda.jpg'),
	(47, 1, 'Suzuki', 'SX4', 2010, 5, 'dízel', 6, 'Ez egy Suzuki', 10000, 10, 10500, 30, 8000, NULL, 3, 'kepek/autok/suzuki.jpg'),
	(48, 1, 'Opel', 'Insignia', 2016, 5, 'benzin', 7, 'Ez egy Open', 10000, 10, 18500, 30, 1600, NULL, 3, 'kepek/autok/opel.jpg'),
	(49, 1, 'Ford', 'Focus', 2018, 5, 'dízel', 5, 'Ez egy Ford', 10000, 10, 15500, 30, 13000, NULL, 3, 'kepek/autok/ford.jpg'),
	(50, 1, 'Toyota', 'Corolla', 2019, 5, 'benzin', 6, 'Ez egy Toyota', 10000, 10, 17500, 30, 15000, NULL, 3, 'kepek/autok/toyota.jpg'),
	(51, 1, 'Volkswagen', 'Passat', 2017, 5, 'dízel', 5, 'Ez egy Volkswagen', 10000, 10, 16500, 30, 14000, NULL, 3, 'kepek/autok/volkswagen.jpg'),
	(52, 1, 'BMW', '3', 2016, 5, 'dízel', 6, 'Ez egy BMW', 10000, 10, 18500, 30, 16000, NULL, 3, 'kepek/autok/bmw.jpg'),
	(53, 1, 'Mercedes', 'C', 2017, 5, 'benzin', 7, 'Ez egy Mercedes', 10000, 10, 19500, 30, 17000, NULL, 3, 'kepek/autok/mercedes.jpg'),
	(54, 1, 'Skoda', 'Octavia', 2018, 5, 'dízel', 5, 'Ez egy Skoda', 10000, 10, 15500, 30, 13000, NULL, 3, 'kepek/autok/skoda.jpg');

-- Dumping structure for table kolcsonzo.conversation
CREATE TABLE IF NOT EXISTS `conversation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  `isClosed` tinyint(1) NOT NULL,
  `isDeleted` tinyint(1) NOT NULL,
  `oUserID` int(11) DEFAULT NULL,
  `dshipID` int(11) DEFAULT NULL,
  `carID` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oUserID` (`oUserID`),
  KEY `dshipID` (`dshipID`),
  KEY `carID` (`carID`),
  CONSTRAINT `conversation_ibfk_1` FOREIGN KEY (`oUserID`) REFERENCES `onlineuser` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `conversation_ibfk_2` FOREIGN KEY (`dshipID`) REFERENCES `dealership` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `conversation_ibfk_3` FOREIGN KEY (`carID`) REFERENCES `car` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table kolcsonzo.conversation: ~0 rows (approximately)

-- Dumping structure for table kolcsonzo.dealer
CREATE TABLE IF NOT EXISTS `dealer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `oUserID` int(11) NOT NULL,
  `oUserName` varchar(255) NOT NULL,
  `dshipID` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `oUserID` (`oUserID`),
  KEY `oUserName` (`oUserName`),
  KEY `dshipID` (`dshipID`),
  CONSTRAINT `dealer_ibfk_1` FOREIGN KEY (`oUserID`) REFERENCES `onlineuser` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `dealer_ibfk_2` FOREIGN KEY (`oUserName`) REFERENCES `onlineuser` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `dealer_ibfk_3` FOREIGN KEY (`dshipID`) REFERENCES `dealership` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table kolcsonzo.dealer: ~3 rows (approximately)
INSERT INTO `dealer` (`id`, `oUserID`, `oUserName`, `dshipID`) VALUES
	(1, 5, 'd_Szeged1', 1),
	(2, 6, 'd_Debrecen1', 2),
	(3, 7, 'd_Budapest1', 3);

-- Dumping structure for table kolcsonzo.dealership
CREATE TABLE IF NOT EXISTS `dealership` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  `city` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table kolcsonzo.dealership: ~3 rows (approximately)
INSERT INTO `dealership` (`id`, `name`, `isActive`, `city`, `address`, `phone`) VALUES
	(1, 'Kocsimánia', 1, 'Szeged', 'Kossuth Lajos utca 5', '+36201111111'),
	(2, 'Autókölcsönző KFT', 1, 'Debrecen', 'Piac utca 8', '+36202222222'),
	(3, 'KölcsönAutó', 1, 'Budapest', 'Andrássy út 10', '+36203333333');

-- Dumping structure for table kolcsonzo.message
CREATE TABLE IF NOT EXISTS `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `date` datetime NOT NULL,
  `isDeleted` tinyint(1) NOT NULL,
  `senderID` int(11) DEFAULT NULL,
  `convID` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `senderID` (`senderID`),
  KEY `convID` (`convID`),
  CONSTRAINT `message_ibfk_1` FOREIGN KEY (`senderID`) REFERENCES `onlineuser` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `message_ibfk_2` FOREIGN KEY (`convID`) REFERENCES `conversation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table kolcsonzo.message: ~0 rows (approximately)

-- Dumping structure for table kolcsonzo.onlineuser
CREATE TABLE IF NOT EXISTS `onlineuser` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `userID` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `userID` (`userID`),
  CONSTRAINT `onlineuser_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table kolcsonzo.onlineuser: ~7 rows (approximately)
INSERT INTO `onlineuser` (`id`, `username`, `password`, `userID`) VALUES
	(1, 'admin', '$2y$10$5KdAG3BuKIrbb/n4kNEHK.dCO5pIgCrGlpLq8HV5icnE7BHRac35O', 1),
	(2, 'nagyjani1', '$2y$10$4BHQH7hlWbCZC97lTWTRlePbJntDuNytykM4WoovQ0VmTHqMr4Gf.', 2),
	(3, 'kecske3', '$2y$10$rUwHfJS/hySVNXA6vN/z/uWflrkmUz9.fntCbn3G3HS.iqwOcgK2m', 3),
	(4, 'lilla0134', '$2y$10$2FjVzFpsRaKYoaQVcIXtHOWqtHj3DDaGqI0dy8kPDCNIECj4TJMLW', 4),
	(5, 'd_Szeged1', '$2y$10$AvKiJpiQHpb.cgHVDqDvc.T1F7jgKHgV.s1ryEEFqEia./goDM4j2', 5),
	(6, 'd_Debrecen1', '$2y$10$xeVX0KsbFNgqDsSafMvy6.EuUBir96UStqY1M1wBsSIFKtbnvB9Cu', 6),
	(7, 'd_Budapest1', '$2y$10$TmPzJ6ZCtlomOSfmpX3FnusgerXkW6O7vhqHLlunGqjJyWRGooTVe', 7);

-- Dumping structure for table kolcsonzo.review
CREATE TABLE IF NOT EXISTS `review` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rating` int(11) NOT NULL,
  `messageID` int(11) NOT NULL,
  `bookingID` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `messageID` (`messageID`),
  KEY `bookingID` (`bookingID`),
  CONSTRAINT `review_ibfk_1` FOREIGN KEY (`messageID`) REFERENCES `message` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `review_ibfk_2` FOREIGN KEY (`bookingID`) REFERENCES `booking_data` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table kolcsonzo.review: ~0 rows (approximately)

-- Dumping structure for table kolcsonzo.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(255) NOT NULL,
  `dateofbirth` date NOT NULL,
  `phone` varchar(255) NOT NULL,
  `hasActiveBooking` tinyint(1) NOT NULL,
  `registerDate` datetime NOT NULL,
  `deleteDate` datetime DEFAULT NULL,
  `isDeleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `phone` (`phone`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table kolcsonzo.user: ~8 rows (approximately)
INSERT INTO `user` (`id`, `fullname`, `dateofbirth`, `phone`, `hasActiveBooking`, `registerDate`, `deleteDate`, `isDeleted`) VALUES
	(1, 'Admin', '2000-01-01', '+36301234567', 0, '2024-11-29 21:14:13', NULL, 0),
	(2, 'Nagy János', '1998-03-14', '+36301111222', 1, '2024-11-29 21:17:03', NULL, 0),
	(3, 'Kerekes Ábel', '2002-10-01', '+36309876543', 1, '2024-11-29 21:18:05', NULL, 0),
	(4, 'Kékesi Lilla', '2001-11-03', '+36302345678', 0, '2024-11-29 21:18:49', NULL, 0),
	(5, 'Szegedi Balázs', '2000-08-07', '+36201234567', 0, '2024-11-29 21:20:19', NULL, 0),
	(6, 'Debreceni Péter', '1997-05-24', '+36202345678', 0, '2024-11-29 21:21:13', NULL, 0),
	(7, 'Budapesti Károly', '1999-07-11', '+36203456789', 0, '2024-11-29 21:21:51', NULL, 0),
	(8, 'Apátsági Béla', '1990-01-01', '06301212121', 1, '2024-11-25 12:00:00', NULL, 0);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
