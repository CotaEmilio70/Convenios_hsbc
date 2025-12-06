CREATE TABLE `details_convenios` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Convenio_id` int(11) NOT NULL,
  `Fecha_pago` date NOT NULL,
  `Importe_pago` double(10,2) NOT NULL,
  `Cancelado` bit(1) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `idx1` (`Convenio_id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=latin1 COMMENT='Detalle pagos de convenios';
