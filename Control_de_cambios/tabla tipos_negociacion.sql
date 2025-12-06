CREATE TABLE `tipos_negociacion` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` char(60) NOT NULL,
  `CreatedBy` char(10) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `UpdatedBy` char(10) NOT NULL,
  `UpdatedDate` datetime NOT NULL,
  `DeletedBy` char(10) NOT NULL,
  `DeletedDate` datetime NOT NULL,  
  PRIMARY KEY (`Id`)
) AUTO_INCREMENT=0 DEFAULT CHARSET=latin1 COMMENT='Tipos de negociaciones';

ALTER TABLE `convenios`.`tipos_negociacion`
  ADD COLUMN `Plazo_maximo` tinyint(3) NOT NULL DEFAULT 0 AFTER `Nombre`;

ALTER TABLE `convenios`.`tipos_negociacion`
  ADD COLUMN `Mismo_mes` bit(1) NOT NULL DEFAULT b'0' AFTER `Plazo_maximo`;

ALTER TABLE `convenios`.`tipos_negociacion`
  ADD COLUMN `Pct_antpo` numeric(5,2) NOT NULL DEFAULT 0 AFTER `Mismo_mes`;

ALTER TABLE `convenios`.`tipos_negociacion`
  ADD COLUMN `Solo_parcial` bit(1) NOT NULL DEFAULT b'0' AFTER `Pct_antpo`;

ALTER TABLE `convenios`.`tipos_negociacion`
  ADD COLUMN `Con_descuento` bit(1) NOT NULL DEFAULT b'0' AFTER `Idcartaconv`;

ALTER TABLE `convenios`.`tipos_negociacion`
  ADD COLUMN `Con_excepcion` bit(1) NOT NULL DEFAULT b'0' AFTER `Con_descuento`;

ALTER TABLE `convenios`.`tipos_negociacion`
  ADD COLUMN `Idcarta_tdc` int(11) NOT NULL DEFAULT b'0' AFTER `Con_excepcion`;

ALTER TABLE `convenios`.`tipos_negociacion`
  ADD COLUMN `Idcarta_krn` int(11) NOT NULL DEFAULT b'0' AFTER `Idcarta_tdc`;

ALTER TABLE `convenios`.`tipos_negociacion`
  ADD COLUMN `Idcarta_con` int(11) NOT NULL DEFAULT b'0' AFTER `Idcarta_krn`;

ALTER TABLE `convenios`.`tipos_negociacion`
  ADD COLUMN `Idcarta_hip` int(11) NOT NULL DEFAULT b'0' AFTER `Idcarta_con`;

ALTER TABLE `convenios`.`tipos_negociacion`
  ADD COLUMN `Clavecrm` varchar(5) NOT NULL DEFAULT '' AFTER `Idcarta_hip`;
