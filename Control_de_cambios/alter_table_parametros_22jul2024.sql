DROP TABLE IF EXISTS `parametros`;
CREATE TABLE `parametros` (
  `razon_soc` varchar(50) DEFAULT '0',
  `direccion` varchar(50) DEFAULT NULL,
  `rfc` varchar(13) DEFAULT NULL,
  `observacio` varchar(254) DEFAULT NULL,
  `cd_edo_expedicion` varchar(50) NOT NULL DEFAULT '',
  `entidad_financiera` varchar(100) NOT NULL DEFAULT '',
  `nombrecorto_ef` varchar(10) NOT NULL DEFAULT '',
  `nombrefirma_ef` varchar(60) NOT NULL DEFAULT '',
  `nombrefirma_ag` varchar(60) NOT NULL DEFAULT '',
  `direccion_ef` varchar(120) NOT NULL DEFAULT '',
  `telefono_ef` varchar(15) NOT NULL DEFAULT '',
  `imagen_firma_ef` varchar(100) NOT NULL DEFAULT '',
  `imagen_firma_ag` varchar(100) NOT NULL DEFAULT '',
  `nota_final` text NOT NULL DEFAULT '',
  `verconv_usr` int(10) NOT NULL DEFAULT 0,
  `verconv_sup` int(10) NOT NULL DEFAULT 0,
  `UpdatedBy` char(10) NOT NULL DEFAULT '',
  `UpdatedDate` datetime NOT NULL DEFAULT '1753-01-01 00:00:00',
  `Clave` char(4) NOT NULL DEFAULT '1',
  `month_pwd` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
