# Host: localhost  (Version 5.7.23)
# Date: 2019-01-10 22:30:49
# Generator: MySQL-Front 6.1  (Build 1.26)


#
# Structure for table "groups"
#

DROP TABLE IF EXISTS `groups`;
CREATE TABLE `groups` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

#
# Data for table "groups"
#

INSERT INTO `groups` VALUES (1,'Geral'),(2,'Testes'),(3,'Desenvolvimento'),(9,'Criado via Sistema'),(10,'Teste1');

#
# Structure for table "messages"
#

DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `id_group` int(11) DEFAULT NULL,
  `date_msg` datetime DEFAULT NULL,
  `msg` text,
  `msg_type` varchar(20) DEFAULT 'text',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

#
# Data for table "messages"
#

INSERT INTO `messages` VALUES (1,2,9,'2019-01-09 21:08:29','testando','text'),(2,2,1,'2019-01-09 21:09:09','Mais um teste','text'),(3,2,9,'2019-01-09 22:04:43','testando 123...','text'),(4,2,9,'2019-01-09 22:13:31','teste','text'),(5,2,9,'2019-01-09 22:16:25','teste','text'),(6,2,9,'2019-01-09 22:16:54','teste2','text'),(7,2,9,'2019-01-09 22:17:45','teste','text'),(8,2,9,'2019-01-09 22:18:19','testando','text'),(9,2,9,'2019-01-09 22:18:58','teste','text'),(10,2,9,'2019-01-09 22:19:16','te22','text'),(11,2,9,'2019-01-09 22:22:12','testestes','text'),(12,2,9,'2019-01-09 22:29:17','teste','text'),(13,2,9,'2019-01-09 22:40:23','mensagem eventual','text'),(14,2,9,'2019-01-09 22:41:07','mensagem eventual','text'),(15,3,9,'2019-01-09 22:42:49','testando aqui','text'),(16,2,9,'2019-01-09 22:42:57','Boa Noite','text'),(17,2,9,'2019-01-09 22:52:57','Fiz um teste','text'),(18,2,3,'2019-01-09 22:53:10','estou aqui','text'),(19,2,9,'2019-01-09 22:53:14','e aqui','text'),(20,2,9,'2019-01-09 22:54:03','teste','text'),(21,2,9,'2019-01-10 00:30:00','opa blza?','text'),(22,2,9,'2019-01-10 00:30:08','testando','text'),(23,2,9,'2019-01-10 00:58:07','f3897806c9f7610c3fd9d51faf5a7259.jpg','img'),(24,2,9,'2019-01-10 00:58:52','e8eb260905ca690239ca858feb14c557.jpg','img'),(25,2,9,'2019-01-10 00:59:37','50b7c7897bbe45877e03ed4026adb9db.jpg','img'),(26,2,9,'2019-01-10 01:02:34','5e42765122faba4f919567f5ef135da2.jpg','img'),(27,2,9,'2019-01-10 01:03:46','a9a14cd853d4945d795628341573e9a1.jpg','img');

#
# Structure for table "users"
#

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `pass` varchar(255) DEFAULT NULL,
  `loginhash` varchar(32) DEFAULT NULL,
  `last_update` datetime DEFAULT NULL,
  `groups` text,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

#
# Data for table "users"
#

INSERT INTO `users` VALUES (2,'douglaspoma','$2y$10$mw5rewKnDg9SdPN0fpMEb.w3SmmcGZCK1rSrL/5VNuOQF/LT.9WT6','74520f5b9f06d24e25f097e4fb6d7fc7','2019-01-10 02:58:50','!10!'),(3,'teste','$2y$10$O0Ifacb.dprP2hU9B0NXwODOK.Zte7ZEwlj2yGiuHjmwlwvsvnzX2','817559334f9f37ec84ef008a7a1cf3dc','2019-01-10 02:32:36','');
