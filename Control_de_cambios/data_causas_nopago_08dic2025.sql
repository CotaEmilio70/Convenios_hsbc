# Host: localhost  (Version 5.5.5-10.4.11-MariaDB)
# Date: 2025-12-08 07:52:46
# Generator: MySQL-Front 6.0  (Build 2.20)


#
# Structure for table "causas_nopago"
#

DROP TABLE IF EXISTS `causas_nopago`;
CREATE TABLE `causas_nopago` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Clave` varchar(10) NOT NULL,
  `Nombre` varchar(60) NOT NULL,
  `Active` bit(1) NOT NULL DEFAULT b'1',
  `CreatedBy` char(10) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `UpdatedBy` char(10) NOT NULL,
  `UpdatedDate` datetime NOT NULL,
  `DeletedBy` char(10) NOT NULL,
  `DeletedDate` datetime NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `Idx1` (`Clave`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 COMMENT='Causas de no pago';

#
# Data for table "causas_nopago"
#

INSERT INTO `causas_nopago` VALUES (1,'B305','ENFERMEDAD',b'1','00','2025-05-12 00:00:00','00','2025-05-12 00:00:00','','0000-00-00 00:00:00'),(2,'B306','DESEMPLEO',b'1','00','2025-05-12 00:00:00','00','2025-05-12 00:00:00','','0000-00-00 00:00:00'),(3,'B307','QUIEBRA DE NEGOCIO',b'1','00','2025-05-12 00:00:00','00','2025-05-12 00:00:00','','0000-00-00 00:00:00'),(4,'B308','INCAPACIDAD',b'1','00','2025-05-12 00:00:00','00','2025-05-12 00:00:00','','0000-00-00 00:00:00'),(5,'B309','PLAGIO',b'1','00','2025-05-12 00:00:00','00','2025-05-12 00:00:00','','0000-00-00 00:00:00'),(6,'B310','PROBLEMAS FINANCIEROS',b'1','00','2025-05-12 00:00:00','00','2025-05-12 00:00:00','','0000-00-00 00:00:00'),(7,'B311','BAJOS INGRESOS',b'1','00','2025-05-12 00:00:00','00','2025-05-12 00:00:00','','0000-00-00 00:00:00');
