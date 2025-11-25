CREATE TABLE `pivot_negopdtocarta` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Id_nego` int(11) NOT NULL DEFAULT 0,
  `Id_pdto` int(5) NOT NULL DEFAULT 0,
  `Id_carta` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`Id`),
  KEY `idx1` (`Id_nego`),
  KEY `idx2` (`Id_pdto`),
  KEY `idx3` (`Id_carta`)
) AUTO_INCREMENT=0 DEFAULT CHARSET=latin1 COMMENT='Pivote negocacion producto carta';

