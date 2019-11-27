-- MySQL dump 10.16  Distrib 10.1.34-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: tahani
-- ------------------------------------------------------
-- Server version	10.1.34-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `karyawan`
--

DROP TABLE IF EXISTS `karyawan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `karyawan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nip` varchar(191) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `tahun_masuk` varchar(255) NOT NULL,
  `gaji` int(11) DEFAULT NULL,
  `umur` int(11) DEFAULT NULL,
  `masa_kerja` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nip` (`nip`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `karyawan`
--

LOCK TABLES `karyawan` WRITE;
/*!40000 ALTER TABLE `karyawan` DISABLE KEYS */;
INSERT INTO `karyawan` VALUES (1,'01','Lia','1972-06-03','1996',750000,30,6),(2,'02','Iwan','1954-09-23','1985',1255000,48,17),(3,'03','Sari','1966-12-12','1988',1500000,36,14),(4,'04','Andi','1965-03-06','1998',1040000,37,4),(5,'05','Budi','1960-12-04','1990',950000,42,12),(6,'06','Amir','1963-11-18','1989',1600000,39,13),(7,'07','Rian','1965-05-28','1997',1250000,37,5),(8,'08','Kiki','1971-07-09','2001',550000,32,1),(9,'09','Alda','1967-08-14','1999',735000,35,3),(10,'10','Yoga','1977-09-17','2000',860000,25,2);
/*!40000 ALTER TABLE `karyawan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `keanggotaan`
--

DROP TABLE IF EXISTS `keanggotaan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `keanggotaan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `bawah` float(10,2) NOT NULL,
  `tengah` float(10,2) NOT NULL,
  `atas` float(10,2) NOT NULL,
  `kelompok_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_KelompokAnggota` (`kelompok_id`),
  CONSTRAINT `FK_KelompokAnggota` FOREIGN KEY (`kelompok_id`) REFERENCES `kelompok` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `keanggotaan`
--

LOCK TABLES `keanggotaan` WRITE;
/*!40000 ALTER TABLE `keanggotaan` DISABLE KEYS */;
INSERT INTO `keanggotaan` VALUES (1,'Muda',0.00,30.00,40.00,1),(2,'Parobaya',35.00,45.00,50.00,1),(3,'Tua',40.00,50.00,100.00,1),(4,'Baru',0.00,5.00,15.00,2),(5,'Lama',10.00,25.00,100.00,2),(6,'Rendah',0.00,300000.00,800000.00,3),(7,'Sedang',500000.00,1000000.00,1500000.00,3),(8,'Tinggi',1000000.00,2000000.00,100000000.00,3);
/*!40000 ALTER TABLE `keanggotaan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kelompok`
--

DROP TABLE IF EXISTS `kelompok`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kelompok` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kelompok`
--

LOCK TABLES `kelompok` WRITE;
/*!40000 ALTER TABLE `kelompok` DISABLE KEYS */;
INSERT INTO `kelompok` VALUES (1,'Umur'),(2,'Masa Kerja'),(3,'Gaji');
/*!40000 ALTER TABLE `kelompok` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-11-27 11:27:52
