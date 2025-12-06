CREATE TABLE `causas_nopago` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Clave` varchar(10) NOT NULL,
  `Nombre` varchar(60) NOT NULL,
  `Active` bit(1) NOT NULL default b'1',
  `CreatedBy` char(10) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `UpdatedBy` char(10) NOT NULL,
  `UpdatedDate` datetime NOT NULL,
  `DeletedBy` char(10) NOT NULL,
  `DeletedDate` datetime NOT NULL,
  PRIMARY KEY (`Id`)
 ) AUTO_INCREMENT=0 DEFAULT CHARSET=latin1 COMMENT='Causas de no pago';

ALTER TABLE `convenios`.`causas_nopago`
  ADD INDEX `Idx1` (`Clave`);
