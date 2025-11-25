CREATE TABLE `Bitacora` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Log_modulo` int(3) NOT NULL,
  `Log_codigoevento` int(4) NOT NULL,
  `Log_usuario` char(10) NOT NULL,
  `Log_descrip` varchar(300) NOT NULL,
  `Log_fechahora` datetime NOT NULL,
  `Log_idreferencia` int(11) NOT NULL,  
  PRIMARY KEY (`Id`),
  KEY `idx1` (`Log_usuario`),
  KEY `idx2` (`Log_fechahora`),
  KEY `idx3` (`Log_codigoevento`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=latin1 COMMENT='Bitacora de eventos';
