CREATE TABLE `tipos_convenios` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` char(60) NOT NULL,
  `CreatedBy` char(10) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `UpdatedBy` char(10) NOT NULL,
  `UpdatedDate` datetime NOT NULL,
  `DeletedBy` char(10) NOT NULL,
  `DeletedDate` datetime NOT NULL,  
  PRIMARY KEY (`Id`)
) AUTO_INCREMENT=0 DEFAULT CHARSET=latin1 COMMENT='Tipos de convenios';

ALTER TABLE `convenios`.`tipos_convenios`
  ADD COLUMN `Plazo_maximo` tinyint(3) NOT NULL DEFAULT 0 AFTER `Nombre`;

ALTER TABLE `convenios`.`tipos_convenios`
  ADD COLUMN `Mismo_mes` bit(1) NOT NULL DEFAULT b'0' AFTER `Plazo_maximo`;

ALTER TABLE `convenios`.`tipos_convenios`
  ADD COLUMN `Pct_antpo` numeric(5,2) NOT NULL DEFAULT 0 AFTER `Mismo_mes`;

ALTER TABLE `convenios`.`tipos_convenios`
  ADD COLUMN `Solo_parcial` bit(1) NOT NULL DEFAULT b'0' AFTER `Pct_antpo`;

ALTER TABLE `convenios`.`tipos_convenios`
  ADD COLUMN `Plataforma` varchar(3) NOT NULL DEFAULT '' AFTER `Solo_parcial`;
