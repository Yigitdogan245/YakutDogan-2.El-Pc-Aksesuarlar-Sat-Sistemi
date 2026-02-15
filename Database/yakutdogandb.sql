CREATE DATABASE  IF NOT EXISTS `yakutdogandb` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `yakutdogandb`;
-- MySQL dump 10.13  Distrib 8.0.44, for Win64 (x86_64)
--
-- Host: localhost    Database: yakutdogandb
-- ------------------------------------------------------
-- Server version	8.4.6

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cart` (
  `CartID` int NOT NULL AUTO_INCREMENT,
  `UserID` int NOT NULL,
  `ProductID` int NOT NULL,
  `CreatedAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`CartID`),
  UNIQUE KEY `unique_item` (`UserID`,`ProductID`),
  KEY `ProductID` (`ProductID`),
  CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE,
  CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`ProductID`) REFERENCES `products` (`ProductID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart`
--

LOCK TABLES `cart` WRITE;
/*!40000 ALTER TABLE `cart` DISABLE KEYS */;
INSERT INTO `cart` VALUES (3,4,3,'2025-12-11 20:19:54');
/*!40000 ALTER TABLE `cart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `CategoryID` int NOT NULL AUTO_INCREMENT,
  `CategoryName` varchar(100) COLLATE utf8mb4_turkish_ci NOT NULL,
  PRIMARY KEY (`CategoryID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Ekran Kartı'),(2,'Anakart'),(3,'RAM Bellek'),(4,'İşlemci'),(5,'SSD/HDD Depolama'),(6,'Güç Kaynağı');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `ProductID` int NOT NULL AUTO_INCREMENT,
  `UserID` int NOT NULL,
  `CategoryID` int NOT NULL,
  `ProductName` varchar(150) COLLATE utf8mb4_turkish_ci NOT NULL,
  `Price` decimal(10,2) NOT NULL,
  `Description` text COLLATE utf8mb4_turkish_ci,
  `Status` varchar(50) COLLATE utf8mb4_turkish_ci NOT NULL,
  `ImagePath` varchar(255) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `IsSwapAvailable` tinyint(1) DEFAULT '0',
  `CreatedAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `IsSold` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`ProductID`),
  KEY `UserID` (`UserID`),
  KEY `CategoryID` (`CategoryID`),
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE,
  CONSTRAINT `products_ibfk_2` FOREIGN KEY (`CategoryID`) REFERENCES `categories` (`CategoryID`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,2,1,'ASUS ROG ASTRAL RTX5090',80000.00,'Aldim Para gerektiği için yeni kartımı satıyorum eski 3090 anıma geri dönücem kullanalı 2 ay oldu cihazi durumu gayet iyidir','Az Kullanılmış','urun_693a9296134ef.jpg',0,'2025-12-11 09:44:54',0),(2,2,2,'MSI Pro Series B460 VDH-WIFI',3000.00,'Az kullanılmış anakart bluetooth ve wifi si üzerinde var 2 slot 3.nesil nvme slotu vardir.','Az Kullanılmış','',0,'2025-12-11 10:05:27',1),(3,4,6,'ASUS ROG STRIX 1000G-1000W',3500.00,'Düzgün çalışmaktadır fakat fan eski olduğu için gürültüsü var ama onun dışında hiç bir sıkıntısı yoktur.\r\nTakasa açığımdır koyduğum fiyata eş değer parçalara ilgiliyim.','Hasarlı','urun_693afcc560ded.jpg',1,'2025-12-11 17:17:57',0),(4,6,5,'Seagate SkyHawk, 4 TB, Dahili Sabit Disk, 3,5&quot; SATA 6 Gb/s, 256 MB Önbellek, DVR NVR Gözetleme Sistemi için, Video Depolama için,',2100.00,'Sistemime SATA SSD almaya karar verdim. Bu yüzden eski HDD mi satıyorum yaklaşık 1 yıl oldu kullanalı.','Az Kullanılmış','urun_693be8cf1c54c.jpg',0,'2025-12-12 10:05:03',0),(5,6,5,'Toshiba S300 4TB 3.5” Dahili HDD – 256MB Cache, 6Gb/s, 5400RPM, Güvenlik ve Gözetim, HDWT840UZSVA',3000.00,'Yeni aldım pek kullanmadım sıfır ayarındadir ssd ile takas ederim.','Sıfır Ayarında','urun_693bea79988cb.jpg',1,'2025-12-12 10:12:09',0),(6,6,5,'Canvio Basic 4TB 2.5 Inç USB 3.0 Taşınabilir Disk HDTB440EK3CA',800.00,'Uzun süredir kullandım Hasarlı diye etiketledim çünkü yüksek sesli ve titreşimli olabiliyor ama düzgün çalışıyor veri saklama transferde herhangi bir sorunu yoktur.','Hasarlı','urun_693bec3bc518c.jpg',0,'2025-12-12 10:19:39',0),(7,6,5,'Kingston NV3 1TB PCI-Express 4.0 M.2 6000/4000 Mb/s SSD Bellek SNV3S/1000G',2500.00,'Az kullanılmış SSD kendime daha büyük depolama sağlayan yeni ssd almaya karar verdiğim için satıyorum','Az Kullanılmış','urun_693bef0d48392.jpg',0,'2025-12-12 10:31:41',0),(8,2,5,'Western Digital Green SN3000 NVMe 500 GB (5.000 MB/sn&#039;ye kadar okuma 4.000 MB/sn&#039;ye kadar yazma) - WDS500G4G0E',999.00,'1.5 sene kullandim bilgisiyarıma daha fazla depolama gerektiği için yeni bir ssd almaya karar verdim bu yüzden satıyorum herhangi bir sıkıntısı yoktur','Az Kullanılmış','urun_693bf17719d90.jpg',0,'2025-12-12 10:41:59',0),(9,2,5,'Samsung 990 PRO PCIe 4.0 M.2, 2 TB SSD, 7.450 MB/sn Okuma, 6.900 MB/sn Yazma , ‎ MZ-V9P2T0BW',2000.00,'Yeni aldığım bir ürün evimde elektrik gidip geldi pc yi yeniden açınca bios ekranimin ssd yi görmediğini fark ettim hiç bir şekilde düzeltemedim Arızalı parçayı alıp tamir etmek istiyenler için ucuza satıyorum.','Arızalı','urun_693bf3fb19d9a.webp',0,'2025-12-12 10:52:43',0),(10,2,1,'Ouitble AMD Radeon RX 580 8GB GDDR5 grafik kartı 256-Bit 2048SP',2000.00,'Sistemimi yenilemeye karar verdiğim için eski ekran kartımı satıyorum 1.5 senedir kullandım temizlettim parçayı hiç bir sıkıntısı yoktur','Az Kullanılmış','urun_693bf577b80d1.jpg',0,'2025-12-12 10:59:03',0),(11,2,1,'ASUS PRIME RTX5070TI, O16G, NVIDIA, GeForce RTX 5070 TI, 16GB GDDR7, 256bit, OC, 2xHDMI, 3xDP, DLSS4 Ekran Kartı',52000.00,'Sıfır Ayarındadır  sadece 1 gün kullanıldı eşdeğer AMD kart ile Takas Kabul ederim','Sıfır Ayarında','urun_693bf69b69c78.webp',1,'2025-12-12 11:03:55',0),(12,2,1,'SAPPHIRE PURE AMD RADEON™ RX 9060 XT GAMING OC 16GB DUAL HDMI/DP GPU, Ekran Kartı',15000.00,'yaklaşık 3 aydır kullandım hiç bir sıkıntısı yoktur eş değer NVIDIA kart ile takas edebilirim.','Az Kullanılmış','urun_693bf7cf6f3af.webp',1,'2025-12-12 11:09:03',0),(13,2,2,'ASUS ROG CROSSHAIR X870E HERO AMD X870E AM5 DDR5 8400 HDMI 2xUSB4 5x M2 USB3.2 WiFi 7',30000.00,'acil para gerektiği için oyun bilgisiyarımı parçalayıp satmaya karar verdim 2 aylıktır parca hiç bir sıkıntısı yoktur son tekliftir indirim payı yoktur.','Az Kullanılmış','urun_693bf9b24af1d.jpg',0,'2025-12-12 11:17:06',0),(14,2,2,'Luocute A520m K Anakart, DDR4 64GB, Gigabit Ethernet, 4 Bellek yuvası Ve İngilizce/Çin BIOS Anahtarlama, Destek 1000-5000',2000.00,'5 ay kullanılmıştır hiç bir sıkıntısı yoktur','Az Kullanılmış','urun_693bfa929e246.webp',0,'2025-12-12 11:20:50',0),(15,4,3,'Corsair VENGEANCE SODIMM DDR5 RAM 16GB (2x8GB) 4800MHz CL40 Intel XMP iCUE Uyumlu Bilgisayar Belleği - Siyah',3500.00,'6 ay kullandım pc deki belleğimi arttırmak için yeni parça alıcam bu yüzden eski parcamı satıyorum hiç bir şeyi yoktur','Az Kullanılmış','urun_693bfc5078fde.webp',0,'2025-12-12 11:28:16',0),(16,4,3,'Yüksek Hızlı 800MHz DDR2 4GB RAM Bellek Modülü - Kararlı Veri İletimi, İşlemciler, 240pin DDR2 Oyuncular Için',100.00,'evimde buldum çalışıyor mu bi fikrim yok öylesine satıyorum ilgilenen varsa satarım','Hasarlı','urun_693bfd1f9fffd.webp',0,'2025-12-12 11:31:43',0),(17,4,6,'MSI PSU MAG A500N-H 500W POWER SUPPLY',900.00,'Yeni sistem toplamaya karar verdim eski PSU mu satiyorum 1 sene kullandım hiç birsıkıntısı yoktur','Az Kullanılmış','urun_693bfdc8d4861.webp',0,'2025-12-12 11:34:32',0),(18,5,4,'AMD AMD Ryzen 7 5700 8 Çekirdek 3.7 GHz',3000.00,'3 ay kullanılmış amd işlemci hiç bir sıkıntısı yoktur','Az Kullanılmış','urun_693c003a567bd.jpg',0,'2025-12-12 11:44:58',0),(19,5,4,'Intel i7-12700F On İki Çekirdek 2.1 GHz',9000.00,'Kutusundan çıkalı 7 gün oldu nerdeyse sıfır ayarındadır','Sıfır Ayarında','urun_693c0122b39e8.jpg',0,'2025-12-12 11:48:50',0);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `UserID` int NOT NULL AUTO_INCREMENT,
  `Username` varchar(50) COLLATE utf8mb4_turkish_ci NOT NULL,
  `Email` varchar(100) COLLATE utf8mb4_turkish_ci NOT NULL,
  `Password` varchar(255) COLLATE utf8mb4_turkish_ci NOT NULL,
  `Role` enum('admin','user') COLLATE utf8mb4_turkish_ci DEFAULT 'user',
  `CreatedAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `reset_token` varchar(255) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  PRIMARY KEY (`UserID`),
  UNIQUE KEY `Username` (`Username`),
  UNIQUE KEY `Email` (`Email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'ilkdeneme','admin@site.com','1234','user','2025-12-11 07:27:57',NULL),(2,'Deneme123','deneme@example.com','$2y$10$NsqVsdYTELE3CkYXkjEBtu0DF3xPobnnu6HGq7OzQJ9tRs0ENG17G','user','2025-12-11 09:17:25',NULL),(3,'boom','boom@gmail.com','$2y$10$dDx2SuCCheHr/2Awh9wchObjAVk1DuYtUrCU/AIL2/6NEE.HhR8/O','user','2025-12-11 09:25:41',NULL),(4,'GOGO','gogo@example.com','$2y$10$/DyzUZLd8HxhZ374kzawnu2HPVjGPcap2VIDHXVARb/bDFKdYLSmq','user','2025-12-11 17:13:30',NULL),(5,'KEREM','kerem@example.com','$2y$10$XHzK4crudKzI50eFF/5Uhu19hYYnqNbWThk2qtJ1OZHvYOQ9X9YoS','user','2025-12-12 09:17:45',NULL),(6,'alper','aaaaa@hotmail.com','$2y$10$Kd7h2ggAHvkYUerngBUK7e4Vav.3fHrRDp1/POjEq4gDKAjonrjgW','user','2025-12-12 09:28:58',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'yakutdogandb'
--

--
-- Dumping routines for database 'yakutdogandb'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-12-14 22:14:38
