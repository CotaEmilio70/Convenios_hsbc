CREATE TABLE `tabla_quitas_plazos` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Producto_hsbc` int(11) NOT NULL,
  `Limite_inf` int(4) NOT NULL,
  `Limite_sup` int(4) NOT NULL,
  `Quita_liqtot` double(5,2) NOT NULL,
  `Quita_2a6` double(5,2) NOT NULL,
  `Quita_7a12` double(5,2) NOT NULL,
  `Vigencia` date NOT NULL,
  `CreatedBy` char(10) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `UpdatedBy` char(10) NOT NULL,
  `UpdatedDate` datetime NOT NULL,
  `DeletedBy` char(10) NOT NULL,
  `DeletedDate` datetime NOT NULL,
  PRIMARY KEY (`Id`)
 ) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=latin1 COMMENT='Tablas de quitas a plazos';
