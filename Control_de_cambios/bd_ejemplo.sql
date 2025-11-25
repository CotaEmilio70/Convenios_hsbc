# Host: localhost  (Version 5.5.5-10.4.11-MariaDB)
# Date: 2024-05-24 15:22:16
# Generator: MySQL-Front 6.0  (Build 2.20)


#
# Structure for table "grupomodulos"
#

CREATE TABLE `grupomodulos` (
  `Id` int(11) NOT NULL,
  `Nombre` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Data for table "grupomodulos"
#

INSERT INTO `grupomodulos` VALUES (1,'Boletos'),(4,'Catalogos'),(5,'Especiales');

#
# Structure for table "modulospermiso"
#

CREATE TABLE `modulospermiso` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) NOT NULL,
  `Idgrupomodulo` int(11) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

#
# Data for table "modulospermiso"
#

INSERT INTO `modulospermiso` VALUES (1,'Usuarios del sistema',4),(10,'Parametros',5);

#
# Structure for table "niveles"
#

CREATE TABLE `niveles` (
  `id` int(1) NOT NULL,
  `nombre` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

#
# Data for table "niveles"
#

INSERT INTO `niveles` VALUES (0,'ADMINISTRADOR'),(1,'TAQUILLA'),(2,'KONICA'),(3,'PATRONATO'),(4,'EGO DANCE'),(5,'OTRO'),(6,'EXTERNO');

#
# Structure for table "parametros"
#

CREATE TABLE `parametros` (
  `razon_soc` varchar(50) DEFAULT '0',
  `direccion` varchar(50) DEFAULT NULL,
  `rfc` varchar(13) DEFAULT NULL,
  `observacio` varchar(254) DEFAULT NULL,
  `claveobra` char(4) NOT NULL DEFAULT '',
  `UpdatedBy` char(4) NOT NULL DEFAULT '',
  `UpdatedDate` datetime NOT NULL DEFAULT '1753-01-01 00:00:00',
  `Clave` char(4) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

#
# Data for table "parametros"
#

INSERT INTO `parametros` VALUES ('INSTITUTO FRANCISCO JAVIER SAETA IAP.','ISRAEL GONZALEZ 101','IFJ','','2401','00','2024-03-08 15:34:00','1');

#
# Structure for table "permisosusuarios"
#

CREATE TABLE `permisosusuarios` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Idpermiso` int(11) NOT NULL,
  `Active` bit(1) NOT NULL,
  `Claveusuario` char(4) NOT NULL DEFAULT '',
  PRIMARY KEY (`Id`),
  UNIQUE KEY `idx2` (`Claveusuario`,`Idpermiso`),
  KEY `idx1` (`Claveusuario`,`Active`)
) ENGINE=InnoDB AUTO_INCREMENT=694 DEFAULT CHARSET=latin1;

#
# Data for table "permisosusuarios"
#

INSERT INTO `permisosusuarios` VALUES (507,1,b'1','00'),(508,2,b'1','00'),(509,3,b'1','00'),(510,4,b'1','00'),(511,5,b'1','00'),(512,6,b'1','00'),(513,7,b'1','00'),(514,8,b'1','00'),(515,9,b'1','00'),(516,10,b'1','00'),(517,11,b'1','00'),(518,12,b'1','00'),(519,13,b'1','00'),(520,14,b'1','00'),(521,15,b'1','00'),(522,16,b'1','00'),(523,17,b'1','00'),(524,18,b'1','00'),(525,19,b'1','00'),(526,20,b'1','00'),(527,21,b'1','00'),(528,22,b'1','00'),(529,25,b'1','00'),(530,26,b'1','00'),(531,27,b'1','00'),(532,23,b'1','00'),(533,24,b'1','00'),(534,28,b'1','00'),(552,29,b'1','00'),(554,30,b'1','00'),(578,31,b'1','00'),(581,32,b'1','00'),(582,33,b'1','00'),(593,23,b'1','CLAU'),(594,24,b'1','CLAU'),(595,28,b'1','CLAU'),(596,31,b'1','CLAU'),(597,32,b'1','CLAU'),(598,1,b'1','CLAU'),(599,2,b'1','CLAU'),(600,3,b'1','CLAU'),(601,4,b'1','CLAU'),(602,5,b'1','CLAU'),(603,6,b'1','CLAU'),(604,7,b'1','CLAU'),(605,8,b'1','CLAU'),(606,9,b'1','CLAU'),(607,10,b'1','CLAU'),(608,11,b'1','CLAU'),(609,12,b'1','CLAU'),(610,13,b'1','CLAU'),(611,14,b'1','CLAU'),(612,15,b'1','CLAU'),(613,16,b'1','CLAU'),(614,17,b'1','CLAU'),(615,18,b'1','CLAU'),(616,19,b'1','CLAU'),(617,20,b'1','CLAU'),(618,21,b'1','CLAU'),(619,22,b'1','CLAU'),(620,26,b'1','CLAU'),(621,27,b'1','CLAU'),(622,29,b'1','CLAU'),(623,30,b'1','CLAU'),(624,33,b'1','CLAU'),(625,34,b'1','00'),(626,35,b'1','00'),(627,34,b'1','CLAU'),(628,35,b'1','CLAU'),(629,23,b'1','VTA1'),(630,24,b'1','VTA1'),(631,28,b'0','VTA1'),(632,31,b'1','VTA1'),(633,32,b'1','VTA1'),(634,23,b'1','VTA2'),(635,24,b'1','VTA2'),(636,28,b'0','VTA2'),(637,31,b'1','VTA2'),(638,32,b'1','VTA2'),(639,29,b'1','VTA2'),(640,29,b'1','VTA1'),(641,23,b'1','VTA3'),(642,24,b'1','VTA3'),(643,28,b'0','VTA3'),(644,31,b'1','VTA3'),(645,32,b'1','VTA3'),(646,29,b'1','VTA3'),(647,23,b'1','VTA4'),(648,24,b'1','VTA4'),(649,28,b'0','VTA4'),(650,31,b'1','VTA4'),(651,32,b'1','VTA4'),(652,29,b'1','VTA4'),(653,33,b'1','VTA1'),(654,33,b'1','VTA2'),(655,33,b'1','VTA3'),(656,33,b'1','VTA4'),(657,36,b'1','00'),(658,36,b'1','CLAU'),(659,36,b'1','VTA1'),(660,23,b'1','BEOH'),(661,24,b'1','BEOH'),(662,28,b'1','BEOH'),(663,31,b'1','BEOH'),(664,32,b'1','BEOH'),(665,36,b'1','BEOH'),(666,29,b'1','BEOH'),(667,30,b'1','BEOH'),(668,33,b'1','BEOH'),(669,34,b'1','BEOH'),(670,35,b'1','BEOH'),(671,23,b'1','MARS'),(672,24,b'1','MARS'),(673,31,b'1','MARS'),(674,32,b'1','MARS'),(675,36,b'1','MARS'),(676,23,b'1','JESS'),(677,24,b'1','JESS'),(678,28,b'1','JESS'),(679,31,b'1','JESS'),(680,32,b'1','JESS'),(681,36,b'1','JESS'),(682,29,b'1','JESS'),(683,30,b'1','JESS'),(684,33,b'1','JESS'),(685,34,b'1','JESS'),(686,35,b'1','JESS'),(687,29,b'1','MARS'),(688,33,b'1','MARS'),(689,30,b'1','MARS'),(690,34,b'1','MARS'),(691,35,b'1','MARS'),(692,23,b'1','0EGO'),(693,23,b'1','EXT1');

#
# Structure for table "permisosweb"
#

CREATE TABLE `permisosweb` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Idmodulopermiso` int(11) NOT NULL,
  `Controlador` varchar(100) NOT NULL,
  `Accion` varchar(100) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `idx1` (`Idmodulopermiso`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

#
# Data for table "permisosweb"
#

INSERT INTO `permisosweb` VALUES (1,1,'Users','Create','Crear'),(2,1,'Users','Edit','Editar'),(3,1,'Users','Details','Detalles'),(4,1,'Users','Delete','Inactivar'),(5,1,'Users','ChangePassword','Cambiar contraseÃ±a'),(6,2,'Teatros','Create','Crear'),(7,2,'Teatros','Edit','Editar'),(8,2,'Teatros','Details','Detalles'),(9,2,'Teatros','Delete','Eliminar'),(10,3,'Aforos','Edit','Editar'),(11,4,'Secciones','Create','Crear'),(12,4,'Secciones','Edit','Editar'),(13,4,'Secciones','Details','Detalles'),(14,4,'Secciones','Delete','Eliminar'),(15,5,'Obras','Create','Crear'),(16,5,'Obras','Edit','Editar'),(17,5,'Obras','Details','Detalles'),(18,5,'Obras','Delete','Eliminar'),(19,6,'Funciones','Create','Crear'),(20,6,'Funciones','Edit','Editar'),(21,6,'Funciones','Details','Detalles'),(22,6,'Funciones','Delete','Eliminar'),(23,7,'Taquilla','Edit','Permitido'),(24,8,'Cortecaja','Edit','Permitido'),(25,9,'Solicitarrecibo','Edit','Permitido'),(26,10,'Parametros','Edit','Editar'),(27,10,'Parametros','Details','Detalles'),(28,11,'TaquillaSaeta','Edit','Capturar'),(29,12,'Reportes','Cortefechausuario','Generar'),(30,13,'Reportes','Reporteventas','Generar'),(31,14,'Consultaycancela','Edit','Permitido'),(32,15,'Consultaycancela','Consultamovtos','Permitido'),(33,16,'Reportes','Detalleventas','Generar'),(34,17,'Reportes','Resumenvtafecha','Generar'),(35,18,'Reportes','Detallefoliosventa','Generar'),(36,19,'Consultaycancela','Devolutions','Permitido');


#
# Structure for table "usuarios"
#

CREATE TABLE `usuarios` (
  `UID` char(4) NOT NULL,
  `Name` char(50) NOT NULL DEFAULT '',
  `PWD` char(50) NOT NULL DEFAULT '',
  `Level` int(1) NOT NULL DEFAULT 0,
  `Active` int(1) NOT NULL DEFAULT 0,
  `email` varchar(100) DEFAULT NULL,
  `changepwd` int(1) unsigned DEFAULT 0,
  `lastchangepwd` datetime DEFAULT NULL,
  `CreatedBy` char(4) NOT NULL DEFAULT '',
  `CreatedDate` datetime NOT NULL DEFAULT '1753-01-01 00:00:00',
  `UpdatedBy` char(4) NOT NULL DEFAULT '',
  `UpdatedDate` datetime NOT NULL DEFAULT '1753-01-01 00:00:00',
  `InactivatedBy` char(4) NOT NULL DEFAULT '',
  `InactivatedDate` datetime NOT NULL DEFAULT '1753-01-01 00:00:00',
  PRIMARY KEY (`UID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC COMMENT='Catálogo de Usuarios';

#
# Data for table "usuarios"
#

INSERT INTO `usuarios` VALUES ('00','ADMINISTRADOR','4C5D02884DF091C8A2CB328D044C108C',0,1,'cotaemilio@hotmail.com',0,NULL,'00','0000-00-00 00:00:00','00','2024-03-15 16:17:13','','0000-00-00 00:00:00'),('0EGO','EDITH GONZALEZ','6CB2F7584159E0753C2E0861BA28C94F',4,1,'direccion@ifjsaeta.org.mx',0,NULL,'CLAU','2024-03-19 09:22:15','CLAU','2024-03-19 09:28:32','','0000-00-00 00:00:00'),('BEOH','BEATRIZ ORTEGA H.','7FE53F99193FD138F34C4B75D129AB54',2,1,'la_tita@hotmail.com',0,NULL,'00','2024-03-16 09:48:12','00','2024-03-16 09:48:12','','0000-00-00 00:00:00'),('CLAU','CLAUDIA VERGARA','EEC89B8AA7B4F11199C95EBB5FAA4947',0,1,'direccion@ifjsaeta.org.mx',0,NULL,'00','2024-03-08 11:48:00','00','2024-03-15 16:17:25','','0000-00-00 00:00:00'),('EXT1','EXTERNO','83E13FCEF0E52E2168B13513B1C1B301',6,1,'',0,NULL,'00','2024-03-21 09:56:45','00','2024-03-21 09:56:45','','0000-00-00 00:00:00'),('JESS','JESSICA GUTIERREZ','60E08CC281F7C5C10B9BB825F8043FBA',0,1,'liderdeproyectos3@ifjsaeta.org.mx',0,NULL,'00','2024-03-16 09:57:13','00','2024-03-16 09:57:13','','0000-00-00 00:00:00'),('MARS','MARGARITA SALAZAR','F3BBB70BE4F318B952995EAC4387D828',2,1,'aventas@konicas.com.mx',0,NULL,'00','2024-03-16 09:52:58','00','2024-03-17 09:52:31','','0000-00-00 00:00:00'),('VTA1','VENTAS 1','D1A309B944C22D4FED128764DE7DBB46',1,0,'',0,NULL,'00','2024-03-14 09:32:32','00','2024-03-15 16:17:44','00','2024-03-16 09:51:39'),('VTA2','VENTAS 2','D1A309B944C22D4FED128764DE7DBB46',1,0,'',0,NULL,'00','2024-03-14 09:32:58','00','2024-03-14 17:05:44','00','2024-03-16 10:01:18'),('VTA3','VENTAS 3','D1A309B944C22D4FED128764DE7DBB46',1,0,'',0,NULL,'00','2024-03-14 11:36:30','00','2024-03-14 17:05:33','00','2024-03-16 10:01:30'),('VTA4','VENTAS 4','D1A309B944C22D4FED128764DE7DBB46',1,0,'',0,NULL,'00','2024-03-14 11:38:41','00','2024-03-14 17:05:15','00','2024-03-16 10:01:40');
