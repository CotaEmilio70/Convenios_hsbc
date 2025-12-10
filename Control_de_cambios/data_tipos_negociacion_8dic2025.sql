# Host: localhost  (Version 5.5.5-10.4.11-MariaDB)
# Date: 2025-12-08 07:56:57
# Generator: MySQL-Front 6.0  (Build 2.20)


#
# Structure for table "tipos_negociacion"
#

DROP TABLE IF EXISTS `tipos_negociacion`;
CREATE TABLE `tipos_negociacion` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` char(60) NOT NULL,
  `Plazo_maximo` tinyint(3) NOT NULL DEFAULT 0,
  `Mismo_mes` bit(1) NOT NULL DEFAULT b'0',
  `Pct_antpo` decimal(5,2) NOT NULL DEFAULT 0.00,
  `Solo_parcial` bit(1) NOT NULL DEFAULT b'0',
  `Con_descuento` bit(1) NOT NULL DEFAULT b'0',
  `Con_excepcion` bit(1) NOT NULL DEFAULT b'0',
  `Idcarta_tdc` int(11) NOT NULL DEFAULT 0,
  `Idcarta_krn` int(11) NOT NULL DEFAULT 0,
  `Idcarta_con` int(11) NOT NULL DEFAULT 0,
  `Idcarta_hip` int(11) NOT NULL DEFAULT 0,
  `Clavecrm` varchar(5) NOT NULL DEFAULT '',
  `CreatedBy` char(10) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `UpdatedBy` char(10) NOT NULL,
  `UpdatedDate` datetime NOT NULL,
  `DeletedBy` char(10) NOT NULL,
  `DeletedDate` datetime NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 COMMENT='Tipos de negociaciones';

#
# Data for table "tipos_negociacion"
#

INSERT INTO `tipos_negociacion` VALUES (1,'Pago parcial',1,b'1',0.00,b'1',b'0',b'0',1,4,7,10,'B138','00','2025-11-13 00:00:00','00','2025-11-13 00:00:00','','0000-00-00 00:00:00'),(2,'Liquidacion con descuento',1,b'1',0.00,b'0',b'1',b'1',2,5,8,11,'B128','00','2025-11-13 00:00:00','00','2025-11-13 00:00:00','','0000-00-00 00:00:00'),(3,'Liquidacion con descuento en exhibiciones',3,b'1',35.00,b'0',b'1',b'1',3,6,9,12,'B131','00','2025-11-13 00:00:00','00','2025-11-13 00:00:00','','0000-00-00 00:00:00'),(4,'Liquidacion a plazos sin descuento',12,b'0',0.00,b'0',b'0',b'0',3,6,9,12,'B302','00','2025-11-13 00:00:00','00','2025-11-13 00:00:00','','0000-00-00 00:00:00'),(5,'Liquidacion a plazos con descuento',12,b'0',35.00,b'0',b'1',b'0',3,6,9,12,'B301','00','2025-11-13 00:00:00','00','2025-11-13 00:00:00','','0000-00-00 00:00:00'),(6,'Liquidacion sin descuento',1,b'1',0.00,b'0',b'0',b'0',2,5,8,11,'B126','00','2025-11-13 00:00:00','00','2025-11-13 00:00:00','','0000-00-00 00:00:00'),(7,'Liquidacion sin descuento en exhibiciones',12,b'1',0.00,b'0',b'0',b'0',3,6,9,12,'B304','00','2025-11-13 00:00:00','00','2025-11-13 00:00:00','','0000-00-00 00:00:00');
