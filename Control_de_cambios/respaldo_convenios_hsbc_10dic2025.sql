# Host: localhost  (Version 5.5.5-10.4.11-MariaDB)
# Date: 2025-12-10 14:25:54
# Generator: MySQL-Front 6.0  (Build 2.20)


#
# Structure for table "bitacora"
#

DROP TABLE IF EXISTS `bitacora`;
CREATE TABLE `bitacora` (
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
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=latin1 COMMENT='Bitacora de eventos';

#
# Data for table "bitacora"
#

/*!40000 ALTER TABLE `bitacora` DISABLE KEYS */;
INSERT INTO `bitacora` VALUES (19,1,11,'00','Se creo simulacion de convenio LP1225-0001 para la cuenta: 0004524216005845657/MINERVA VERONICA BECERRA MARROQUIN','2025-12-09 09:32:52',1);
/*!40000 ALTER TABLE `bitacora` ENABLE KEYS */;

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

#
# Structure for table "details_convenios"
#

DROP TABLE IF EXISTS `details_convenios`;
CREATE TABLE `details_convenios` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Convenio_id` int(11) NOT NULL,
  `Fecha_pago` date NOT NULL,
  `Importe_pago` double(10,2) NOT NULL,
  `Cancelado` bit(1) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `idx1` (`Convenio_id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=latin1 COMMENT='Detalle pagos de convenios';

#
# Data for table "details_convenios"
#

/*!40000 ALTER TABLE `details_convenios` DISABLE KEYS */;
INSERT INTO `details_convenios` VALUES (35,1,'2025-12-12',100.00,b'0');
/*!40000 ALTER TABLE `details_convenios` ENABLE KEYS */;

#
# Structure for table "grupomodulos"
#

DROP TABLE IF EXISTS `grupomodulos`;
CREATE TABLE `grupomodulos` (
  `Id` int(11) NOT NULL,
  `Nombre` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Data for table "grupomodulos"
#

INSERT INTO `grupomodulos` VALUES (1,'Convenios'),(4,'Catalogos'),(5,'Especiales'),(3,'Reportes');

#
# Structure for table "master_convenios"
#

DROP TABLE IF EXISTS `master_convenios`;
CREATE TABLE `master_convenios` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Dmssnum` varchar(20) NOT NULL,
  `Dmacct` varchar(20) NOT NULL,
  `Uxmescast` int(5) NOT NULL,
  `Dmcurbal` double(10,2) NOT NULL,
  `Uxtot_adeu` double(10,2) NOT NULL,
  `Dmpayoff` double(10,2) NOT NULL,
  `Uxsdo_vi_v` double(10,2) NOT NULL,
  `Uxcap_cred` double(10,2) NOT NULL,
  `Uxint_cred` double(10,2) NOT NULL,
  `Uxmora_cred` double(10,2) NOT NULL,
  `Uxexig_cre` double(10,2) NOT NULL,
  `Dmamtdlq` double(10,2) NOT NULL,
  `U6pag_min` double(10,2) NOT NULL,
  `U6sdo_cort` double(10,2) NOT NULL,
  `plastico_pago` varchar(20) NOT NULL,
  `billing` varchar(20) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Fec_ape` date NOT NULL,
  `Cepa` varchar(10) DEFAULT NULL,
  `Modalidad` varchar(10) DEFAULT NULL,
  `Macro_gen` varchar(30) DEFAULT NULL,
  `Gpo_meta` varchar(30) DEFAULT NULL,
  `Spei_num_key` varchar(20) DEFAULT NULL,
  `Portafolio` varchar(30) DEFAULT NULL,
  `Mto_principal` double(10,2) NOT NULL,
  `Int_ordinario` double(10,2) NOT NULL,
  `Moratorios` double(10,2) NOT NULL,
  `Comp_exigible` double(10,2) NOT NULL,
  `Total_adeudo` double(10,2) NOT NULL,
  `Saldo_contable` double(10,2) NOT NULL,
  `Moneda` int(4) NOT NULL,
  `Cliente` int(5) NOT NULL,
  `Producto` int(5) NOT NULL,
  `Fecha_neg` date NOT NULL,
  `Fecha_emi` date NOT NULL,
  `Quita_max_st` double(6,2) NOT NULL,
  `Quita_max_sc` double(6,2) NOT NULL,
  `Quita_neg` double(6,2) NOT NULL,
  `Total_pago` double(10,2) NOT NULL,
  `Saldo_usado` char(1) NOT NULL,
  `Observaciones` varchar(255) DEFAULT NULL,
  `Estado_conv` int(2) NOT NULL,
  `Folio_pre` varchar(10) NOT NULL,
  `Folio_cons` int(4) NOT NULL,
  `Cancelado` bit(1) NOT NULL,
  `Excepcion` int(1) NOT NULL,
  `Auto_excep` char(10) NOT NULL,
  `Telefono` varchar(13) NOT NULL,
  `Tipo_tel` varchar(10) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Etapa` varchar(13) NOT NULL,
  `Restitucion` varchar(15) NOT NULL,
  `Tipo_negoid` int(11) NOT NULL,
  `Tipo_convid` int(11) NOT NULL,
  `Tipo_convid_alt` int(11) NOT NULL,
  `Plataforma` varchar(3) NOT NULL,
  `Periodicidad` varchar(1) NOT NULL,
  `Fechas_esp` int(1) NOT NULL,
  `Llamada` varchar(5) NOT NULL,
  `Accion` varchar(5) NOT NULL,
  `Resultado` varchar(5) NOT NULL,
  `Causanp` varchar(5) NOT NULL,
  `Grupoconv` varchar(5) NOT NULL,
  `Peso` varchar(5) NOT NULL,
  `Agente` varchar(10) NOT NULL,
  `CreatedBy` char(10) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `UpdatedBy` char(10) NOT NULL,
  `UpdatedDate` datetime NOT NULL,
  `DeletedBy` char(10) NOT NULL,
  `DeletedDate` datetime NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `idx5` (`Folio_pre`,`Folio_cons`),
  KEY `idx1` (`Dmacct`),
  KEY `idx2` (`Dmssnum`),
  KEY `idx3` (`Fecha_neg`),
  KEY `idx4` (`Nombre`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COMMENT='Master de convenios';

#
# Data for table "master_convenios"
#

/*!40000 ALTER TABLE `master_convenios` DISABLE KEYS */;
INSERT INTO `master_convenios` VALUES (1,'000000038280564','0004524216005845657',8,411075.10,411075.10,0.00,0.00,0.00,0.00,0.00,0.00,0.00,6166.12,411075.10,'4524216005845657','0004524216005845657','MINERVA VERONICA BECERRA MARROQUIN','2025-12-09','61EX','0','','000','021975212050772358','',0.00,0.00,0.00,0.00,0.00,0.00,1,32,40,'2025-12-09','2025-12-09',90.00,90.00,0.00,100.00,'T','KKLLKJFLKJKL',0,'LP1225',1,b'0',0,'','3333333333','Movil','mail@mail.com','ETAPA 2','NO',1,1,0,'CYB','U',0,'LLE','CDT','PP','B311','B138','+A07','736','00','2025-12-09 09:32:52','00','2025-12-09 09:32:52','','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `master_convenios` ENABLE KEYS */;

#
# Structure for table "modulospermiso"
#

DROP TABLE IF EXISTS `modulospermiso`;
CREATE TABLE `modulospermiso` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) NOT NULL,
  `Idgrupomodulo` int(11) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

#
# Data for table "modulospermiso"
#

INSERT INTO `modulospermiso` VALUES (1,'Usuarios del sistema',4),(2,'Convenios',1),(3,'Exportar convenios',3),(10,'Parametros',5),(11,'Productos y quitas',4);

#
# Structure for table "niveles"
#

DROP TABLE IF EXISTS `niveles`;
CREATE TABLE `niveles` (
  `id` int(1) NOT NULL,
  `nombre` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

#
# Data for table "niveles"
#

INSERT INTO `niveles` VALUES (0,'ADMINISTRADOR'),(1,'USUARIO');

#
# Structure for table "parametros"
#

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

#
# Data for table "parametros"
#

INSERT INTO `parametros` VALUES ('Corporativo de Servicios Legaxxi S.C. ','pendiente','pendiente',NULL,'Ciudad de México','HSBC MÉXICO, S.A., INSTITUCIÓN DE BANCA MÚLTIPLE, GRUPO FINANCIERO HSBC','HSBC','pendiente','Jesus Salvador Aranda Rodríguez','Avenida Paseo de la Reforma # 347, Torre HSBC, Colonia Cuauhtémoc, Alcaldía Cuauhtémoc, Ciudad de México. C.P. 06500','55 5721 5661','','img/firma_aranda.png','1. Para aclaraciones o quejas, por favor comunicarse a HSBC al 55 5721 3390; o a la Unidad Especializada de Atención a Usuarios (UNE) al teléfono 55 5721 5661, correo electrónico mexico_une@hsbc.com.mx o personalmente en Avenida Paseo de la Reforma # 347, Torre HSBC, Colonia Cuauhtémoc, Alcaldía Cuauhtémoc, Ciudad de México. C.P. 06500, de lunes a viernes de 9:00 a 15:00 horas en la Ciudad de México o a través del Registro de Despachos de Cobranza (REDECO) que puede encontrar en la página de CONDUSEF. 2. En ningún caso entregue dinero en efectivo, cheque, dádiva o cortesía al representante o gestor que lo visite realizando labor de cobro. Únicamente deposite en su número de cuenta o en la cuenta RAP que se le indique. 3. Para cualquier otra duda o aclaración sobre ésta negociación puede comunicarse al 55 4749 0770. 4. Puede realizar sus pagos en cualquier lugar a través de nuestra App Móvil HSBC México y Banca por Internet, en la sucursal HSBC de su preferencia o en nuestras alianzas comerciales, consulte detalle de alianzas comerciales vigentes en https://www.hsbc.com.mx/alianzas. Los pagos en las alianzas comerciales generan comisiones. 5. En caso de haber realizado el pago, favor de hacer caso omiso de esta comunicación. 6. Consulte el Aviso de Privacidad del Grupo HSBC México en www.hsbc.com.mx o en la sucursal HSBC de su preferencia. O bien consulte el aviso de privacidad de datos personales en www.legaxxi.com. 7. Cualquier pago con descuento quedará reportado ante Sociedad de Información Crediticia. 8. Este convenio se realiza con HSBC México, S.A., Institución de Banca Múltiple, Grupo Financiero HSBC (HSBC). La Agencia de Cobranza mencionada en la parte superior derecha proporciona servicios de cobro en representación de HSBC.',0,0,'00','2025-10-22 12:58:46','1',NULL);

#
# Structure for table "permisosusuarios"
#

DROP TABLE IF EXISTS `permisosusuarios`;
CREATE TABLE `permisosusuarios` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Idpermiso` int(11) NOT NULL,
  `Active` bit(1) NOT NULL,
  `Claveusuario` char(10) NOT NULL DEFAULT '',
  PRIMARY KEY (`Id`),
  UNIQUE KEY `idx2` (`Claveusuario`,`Idpermiso`),
  KEY `idx1` (`Claveusuario`,`Active`)
) ENGINE=InnoDB AUTO_INCREMENT=988 DEFAULT CHARSET=latin1;

#
# Data for table "permisosusuarios"
#

INSERT INTO `permisosusuarios` VALUES (507,1,b'1','00'),(508,2,b'1','00'),(509,3,b'1','00'),(510,4,b'1','00'),(511,5,b'1','00'),(512,6,b'1','00'),(513,7,b'1','00'),(514,8,b'1','00'),(515,9,b'1','00'),(516,10,b'1','00'),(517,11,b'0','00'),(518,12,b'0','00'),(519,13,b'0','00'),(520,14,b'0','00'),(521,15,b'0','00'),(522,16,b'0','00'),(523,17,b'0','00'),(524,18,b'0','00'),(525,19,b'0','00'),(526,20,b'0','00'),(527,21,b'0','00'),(528,22,b'0','00'),(529,25,b'0','00'),(530,26,b'1','00'),(531,27,b'1','00'),(532,23,b'0','00'),(533,24,b'0','00'),(534,28,b'1','00'),(552,29,b'1','00'),(554,30,b'1','00'),(578,31,b'1','00'),(581,32,b'0','00'),(582,33,b'0','00'),(625,34,b'0','00'),(626,35,b'0','00'),(657,36,b'0','00');

#
# Structure for table "permisosweb"
#

DROP TABLE IF EXISTS `permisosweb`;
CREATE TABLE `permisosweb` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Idmodulopermiso` int(11) NOT NULL,
  `Controlador` varchar(100) NOT NULL,
  `Accion` varchar(100) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `idx1` (`Idmodulopermiso`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

#
# Data for table "permisosweb"
#

INSERT INTO `permisosweb` VALUES (1,1,'Users','Create','Crear'),(2,1,'Users','Edit','Editar'),(3,1,'Users','Details','Detalles'),(4,1,'Users','Delete','Inactivar'),(5,1,'Users','ChangePassword','Cambiar contraseÃ±a'),(6,2,'Convenios','Create','Crear'),(7,2,'Convenios','Edit','Autorizar'),(8,2,'Convenios','Details','Detalles'),(9,2,'Convenios','Delete','Cancelar'),(10,3,'Reportes','ExportaConvenios','Exportar'),(26,10,'Parametros','Edit','Editar'),(27,10,'Parametros','Details','Detalles'),(28,11,'Productos','Create','Crear'),(29,11,'Productos','Edit','Editar'),(30,11,'Productos','Details','Detalles'),(31,11,'Productos','Delete','Inactivar');

#
# Structure for table "pivot_negopdtocarta"
#

DROP TABLE IF EXISTS `pivot_negopdtocarta`;
CREATE TABLE `pivot_negopdtocarta` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Id_nego` int(11) NOT NULL DEFAULT 0,
  `Id_pdto` int(11) NOT NULL DEFAULT 0,
  `Id_carta` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`Id`),
  KEY `idx1` (`Id_nego`),
  KEY `idx2` (`Id_pdto`),
  KEY `idx3` (`Id_carta`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1 COMMENT='Pivote negocacion producto carta';

#
# Data for table "pivot_negopdtocarta"
#

INSERT INTO `pivot_negopdtocarta` VALUES (1,1,40,1),(2,1,41,4),(3,1,42,7),(4,1,44,4),(5,1,46,1),(6,1,47,4),(7,2,40,2),(8,2,41,5),(9,2,42,8),(10,2,44,5),(11,2,46,2),(12,2,47,5),(13,3,40,3),(14,3,41,5),(15,3,42,8),(16,3,44,5),(17,3,46,3),(18,3,47,5),(19,4,40,3),(20,4,41,5),(21,4,42,8),(22,4,44,5),(23,4,46,3),(24,4,47,5),(25,5,40,3),(26,5,41,6),(27,5,42,8),(28,5,44,5),(29,5,46,3),(30,5,47,5),(31,6,40,2),(32,6,41,5),(33,6,42,8),(34,6,44,5),(35,6,46,2),(36,6,47,5),(37,7,40,2),(38,7,41,5),(39,7,42,8),(40,7,44,5),(41,7,46,2),(42,7,47,5);

#
# Structure for table "productos_hsbc"
#

DROP TABLE IF EXISTS `productos_hsbc`;
CREATE TABLE `productos_hsbc` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(60) NOT NULL,
  `Numero` int(3) NOT NULL DEFAULT 0,
  `Active` bit(1) NOT NULL DEFAULT b'1',
  `CreatedBy` char(10) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `UpdatedBy` char(10) NOT NULL,
  `UpdatedDate` datetime NOT NULL,
  `DeletedBy` char(10) NOT NULL,
  `DeletedDate` datetime NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `Idx1` (`Numero`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1 COMMENT='Tablas de productos hsbc';

#
# Data for table "productos_hsbc"
#

INSERT INTO `productos_hsbc` VALUES (4,'TDC',40,b'1','00','2025-11-12 12:27:28','00','2025-11-12 12:27:28','','0000-00-00 00:00:00'),(5,'PERSONALES Y OCC',41,b'1','00','2025-11-12 12:34:03','00','2025-11-12 12:34:03','','0000-00-00 00:00:00'),(6,'PAYROLL',42,b'1','00','2025-11-12 12:35:14','00','2025-11-12 12:35:14','','0000-00-00 00:00:00'),(7,'AUTO',44,b'1','00','2025-11-12 12:38:06','00','2025-11-12 12:38:06','','0000-00-00 00:00:00'),(8,'HIPOTECARIO CASTIGOS',45,b'1','00','2025-11-12 12:40:19','00','2025-11-12 12:40:19','','0000-00-00 00:00:00'),(9,'PYME TDC',46,b'1','00','2025-11-12 12:41:50','00','2025-11-12 12:41:50','','0000-00-00 00:00:00'),(10,'PYME KRONER',47,b'1','00','2025-11-12 12:43:20','00','2025-11-12 12:43:20','','0000-00-00 00:00:00'),(11,'HIPOTECARIO VENCIDO',48,b'1','00','2025-11-12 12:44:54','00','2025-11-12 12:44:54','','0000-00-00 00:00:00');

#
# Structure for table "tabla_quitas"
#

DROP TABLE IF EXISTS `tabla_quitas`;
CREATE TABLE `tabla_quitas` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Producto_hsbc` int(11) NOT NULL,
  `Limite_inf` int(4) NOT NULL,
  `Limite_sup` int(4) NOT NULL,
  `Quita_st` double(5,2) NOT NULL,
  `Quita_sc` double(5,2) NOT NULL,
  `Vigencia` date NOT NULL,
  `CreatedBy` char(10) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `UpdatedBy` char(10) NOT NULL,
  `UpdatedDate` datetime NOT NULL,
  `DeletedBy` char(10) NOT NULL,
  `DeletedDate` datetime NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=54 DEFAULT CHARSET=latin1 COMMENT='Tablas de quitas';

#
# Data for table "tabla_quitas"
#

/*!40000 ALTER TABLE `tabla_quitas` DISABLE KEYS */;
INSERT INTO `tabla_quitas` VALUES (11,4,0,5,85.00,85.00,'2025-12-30','00','2025-11-12 12:28:49','00','2025-11-12 12:28:49','','0000-00-00 00:00:00'),(12,4,6,24,90.00,90.00,'2025-12-30','00','2025-11-12 12:28:49','00','2025-11-12 12:28:49','','0000-00-00 00:00:00'),(13,4,25,9999,95.00,95.00,'2025-12-30','00','2025-11-12 12:28:49','00','2025-11-12 12:28:49','','0000-00-00 00:00:00'),(14,5,0,5,85.00,85.00,'2025-12-30','00','2025-11-12 12:35:02','00','2025-11-12 12:35:02','','0000-00-00 00:00:00'),(15,5,6,24,90.00,90.00,'2025-12-30','00','2025-11-12 12:35:02','00','2025-11-12 12:35:02','','0000-00-00 00:00:00'),(16,5,25,9999,95.00,95.00,'2025-12-30','00','2025-11-12 12:35:02','00','2025-11-12 12:35:02','','0000-00-00 00:00:00'),(20,7,0,5,70.00,70.00,'2025-12-30','00','2025-11-12 12:39:13','00','2025-11-12 12:39:13','','0000-00-00 00:00:00'),(21,7,6,11,75.00,75.00,'2025-12-30','00','2025-11-12 12:39:13','00','2025-11-12 12:39:13','','0000-00-00 00:00:00'),(22,7,12,42,80.00,80.00,'2025-12-30','00','2025-11-12 12:39:13','00','2025-11-12 12:39:13','','0000-00-00 00:00:00'),(23,7,43,9999,85.00,85.00,'2025-12-30','00','2025-11-12 12:39:13','00','2025-11-12 12:39:13','','0000-00-00 00:00:00'),(24,8,0,5,85.00,85.00,'2025-12-30','00','2025-11-12 12:41:16','00','2025-11-12 12:41:16','','0000-00-00 00:00:00'),(25,8,6,24,90.00,90.00,'2025-12-30','00','2025-11-12 12:41:16','00','2025-11-12 12:41:16','','0000-00-00 00:00:00'),(26,8,25,9999,95.00,95.00,'2025-12-30','00','2025-11-12 12:41:16','00','2025-11-12 12:41:16','','0000-00-00 00:00:00'),(27,9,0,5,70.00,70.00,'2025-12-30','00','2025-11-12 12:42:59','00','2025-11-12 12:42:59','','0000-00-00 00:00:00'),(28,9,6,11,72.00,72.00,'2025-12-30','00','2025-11-12 12:42:59','00','2025-11-12 12:42:59','','0000-00-00 00:00:00'),(29,9,12,24,75.00,75.00,'2025-12-30','00','2025-11-12 12:42:59','00','2025-11-12 12:42:59','','0000-00-00 00:00:00'),(30,9,25,9999,80.00,80.00,'2025-12-30','00','2025-11-12 12:42:59','00','2025-11-12 12:42:59','','0000-00-00 00:00:00'),(31,10,0,5,70.00,70.00,'2025-12-30','00','2025-11-12 12:44:16','00','2025-11-12 12:44:16','','0000-00-00 00:00:00'),(32,10,6,11,72.00,72.00,'2025-12-30','00','2025-11-12 12:44:16','00','2025-11-12 12:44:16','','0000-00-00 00:00:00'),(33,10,12,24,75.00,75.00,'2025-12-30','00','2025-11-12 12:44:16','00','2025-11-12 12:44:16','','0000-00-00 00:00:00'),(34,10,25,9999,80.00,80.00,'2025-12-30','00','2025-11-12 12:44:16','00','2025-11-12 12:44:16','','0000-00-00 00:00:00'),(35,11,0,9999,0.00,0.00,'2025-12-31','00','2025-11-12 12:45:15','00','2025-11-12 12:45:15','','0000-00-00 00:00:00'),(51,6,25,9999,95.00,95.00,'2025-12-30','00','2025-11-27 14:46:49','00','2025-11-27 14:46:49','','0000-00-00 00:00:00'),(52,6,6,24,90.00,90.00,'2025-12-30','00','2025-11-27 14:46:49','00','2025-11-27 14:46:49','','0000-00-00 00:00:00'),(53,6,0,5,85.00,85.00,'2025-12-30','00','2025-11-27 14:46:49','00','2025-11-27 14:46:49','','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `tabla_quitas` ENABLE KEYS */;

#
# Structure for table "tipos_convenios"
#

DROP TABLE IF EXISTS `tipos_convenios`;
CREATE TABLE `tipos_convenios` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` char(60) NOT NULL,
  `Plazo_maximo` tinyint(3) NOT NULL DEFAULT 0,
  `Mismo_mes` bit(1) NOT NULL DEFAULT b'0',
  `Pct_antpo` decimal(5,2) NOT NULL DEFAULT 0.00,
  `Solo_parcial` bit(1) NOT NULL DEFAULT b'0',
  `Plataforma` varchar(3) NOT NULL DEFAULT '',
  `CreatedBy` char(10) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `UpdatedBy` char(10) NOT NULL,
  `UpdatedDate` datetime NOT NULL,
  `DeletedBy` char(10) NOT NULL,
  `DeletedDate` datetime NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1 COMMENT='Tipos de convenios';

#
# Data for table "tipos_convenios"
#

INSERT INTO `tipos_convenios` VALUES (1,'TDC PAGO PARCIAL',3,b'1',0.00,b'1','CYB','00','2025-10-23 00:00:00','00','2025-10-23 00:00:00','','0000-00-00 00:00:00'),(2,'TDC LIQUIDACION PAGO UNICO',3,b'1',0.00,b'0','CYB','00','2025-10-23 00:00:00','00','2025-10-23 00:00:00','','0000-00-00 00:00:00'),(3,'TDC LIQUIDACION MAS DE UN PAGO',12,b'0',30.00,b'0','CYB','00','2025-10-23 00:00:00','00','2025-10-23 00:00:00','','0000-00-00 00:00:00'),(4,'KRONER PAGO PARCIAL',3,b'1',0.00,b'1','KRN','00','2025-10-23 00:00:00','00','2025-10-23 00:00:00','','0000-00-00 00:00:00'),(5,'KRONER LIQUIDACION PAGO UNICO',3,b'1',0.00,b'0','KRN','00','2025-10-23 00:00:00','00','2025-10-23 00:00:00','','0000-00-00 00:00:00'),(6,'KRONER LIQUIDACION MAS DE UN PAGO',12,b'0',25.00,b'0','KRN','00','2025-10-23 00:00:00','00','2025-10-23 00:00:00','','0000-00-00 00:00:00'),(7,'CONSUMER PARCIAL',3,b'1',0.00,b'1','KRN','00','2025-10-23 00:00:00','00','2025-10-23 00:00:00','','0000-00-00 00:00:00'),(8,'CONSUMER LIQUIDACION PAGO UNICO',3,b'1',0.00,b'0','KRN','00','2025-10-23 00:00:00','00','2025-10-23 00:00:00','','0000-00-00 00:00:00'),(9,'CONSUMER LIQUIDACION MAS DE UN PAGO',12,b'0',25.00,b'0','KRN','00','2025-10-23 00:00:00','00','2025-10-23 00:00:00','','0000-00-00 00:00:00'),(10,'HIPOTECARIO PARCIAL UDI',3,b'1',0.00,b'1','KRN','00','2025-10-23 00:00:00','00','2025-10-23 00:00:00','','0000-00-00 00:00:00'),(11,'HIPOTECARIO LIQUIDACION UDI',3,b'1',0.00,b'0','KRN','00','2025-10-23 00:00:00','00','2025-10-23 00:00:00','','0000-00-00 00:00:00'),(12,'HIPOTECARIO UDI MAS DE UN PAGO',12,b'0',25.00,b'0','KRN','00','2025-10-23 00:00:00','00','2025-10-23 00:00:00','','0000-00-00 00:00:00');

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

#
# Structure for table "usuarios"
#

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `UID` char(10) NOT NULL DEFAULT '',
  `Name` char(50) NOT NULL DEFAULT '',
  `PWD` char(50) NOT NULL DEFAULT '',
  `Level` int(1) NOT NULL DEFAULT 0,
  `Active` int(1) NOT NULL DEFAULT 0,
  `email` varchar(100) DEFAULT NULL,
  `changepwd` int(1) unsigned DEFAULT 0,
  `lastchangepwd` datetime DEFAULT NULL,
  `CreatedBy` char(10) NOT NULL DEFAULT '',
  `CreatedDate` datetime NOT NULL DEFAULT '1753-01-01 00:00:00',
  `UpdatedBy` char(10) NOT NULL DEFAULT '',
  `UpdatedDate` datetime NOT NULL DEFAULT '1753-01-01 00:00:00',
  `InactivatedBy` char(10) NOT NULL DEFAULT '',
  `InactivatedDate` datetime NOT NULL DEFAULT '1753-01-01 00:00:00',
  PRIMARY KEY (`UID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC COMMENT='Catálogo de Usuarios';

#
# Data for table "usuarios"
#

INSERT INTO `usuarios` VALUES ('00','ADMINISTRADOR','4C5D02884DF091C8A2CB328D044C108C',0,1,'cotaemilio@hotmail.com',0,NULL,'00','0000-00-00 00:00:00','00','2025-12-08 10:30:23','','0000-00-00 00:00:00');
