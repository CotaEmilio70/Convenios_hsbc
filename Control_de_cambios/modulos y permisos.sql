#Modulos y permisos 
INSERT INTO `modulospermiso` (`Id`, `Nombre`, `Idgrupomodulo`) VALUES ('1', 'Usuarios del sistema','4');
INSERT INTO `permisosweb` (`Id`, `Idmodulopermiso`, `Controlador`, `Accion`, `Nombre`) VALUES ('1', '1', 'Users', 'Create', 'Crear');
INSERT INTO `permisosweb` (`Id`, `Idmodulopermiso`, `Controlador`, `Accion`, `Nombre`) VALUES ('2', '1', 'Users', 'Edit', 'Editar');
INSERT INTO `permisosweb` (`Id`, `Idmodulopermiso`, `Controlador`, `Accion`, `Nombre`) VALUES ('3', '1', 'Users', 'Details', 'Detalles');
INSERT INTO `permisosweb` (`Id`, `Idmodulopermiso`, `Controlador`, `Accion`, `Nombre`) VALUES ('4', '1', 'Users', 'Delete', 'Inactivar');
INSERT INTO `permisosweb` (`Id`, `Idmodulopermiso`, `Controlador`, `Accion`, `Nombre`) VALUES ('5', '1', 'Users', 'ChangePassword', 'Cambiar contraseÃ±a');

INSERT INTO `modulospermiso` (`Id`, `Nombre`, `Idgrupomodulo`) VALUES ('2', 'Convenios','1');
INSERT INTO `permisosweb` (`Id`, `Idmodulopermiso`, `Controlador`, `Accion`, `Nombre`) VALUES ('6', '2', 'Convenios', 'Create', 'Crear');
INSERT INTO `permisosweb` (`Id`, `Idmodulopermiso`, `Controlador`, `Accion`, `Nombre`) VALUES ('7', '2', 'Convenios', 'Edit', 'Editar');
INSERT INTO `permisosweb` (`Id`, `Idmodulopermiso`, `Controlador`, `Accion`, `Nombre`) VALUES ('8', '2', 'Convenios', 'Details', 'Detalles');
INSERT INTO `permisosweb` (`Id`, `Idmodulopermiso`, `Controlador`, `Accion`, `Nombre`) VALUES ('9', '2', 'Convenios', 'Delete', 'Cancelar');

INSERT INTO `modulospermiso` (`Id`, `Nombre`, `Idgrupomodulo`) VALUES ('3', 'Exportar convenios','3');
-- INSERT INTO `permisosweb` (`Id`, `Idmodulopermiso`, `Controlador`, `Accion`, `Nombre`) VALUES ('10', '3', 'ExportaConvenios', 'Exportar', 'Exportar');
INSERT INTO `permisosweb` (`Id`, `Idmodulopermiso`, `Controlador`, `Accion`, `Nombre`) VALUES ('10', '3', 'Reportes', 'ExportaConvenios', 'Exportar');

INSERT INTO `modulospermiso` (`Id`, `Nombre`, `Idgrupomodulo`) VALUES ('10', 'Parametros','5');
INSERT INTO `permisosweb` (`Id`, `Idmodulopermiso`, `Controlador`, `Accion`, `Nombre`) VALUES ('26', '10', 'Parametros', 'Edit', 'Editar');
INSERT INTO `permisosweb` (`Id`, `Idmodulopermiso`, `Controlador`, `Accion`, `Nombre`) VALUES ('27', '10', 'Parametros', 'Details', 'Detalles');

INSERT INTO `modulospermiso` (`Id`, `Nombre`, `Idgrupomodulo`) VALUES ('11', 'Productos y quitas','4');
INSERT INTO `permisosweb` (`Id`, `Idmodulopermiso`, `Controlador`, `Accion`, `Nombre`) VALUES ('28', '11', 'Productos', 'Create', 'Crear');
INSERT INTO `permisosweb` (`Id`, `Idmodulopermiso`, `Controlador`, `Accion`, `Nombre`) VALUES ('29', '11', 'Productos', 'Edit', 'Editar');
INSERT INTO `permisosweb` (`Id`, `Idmodulopermiso`, `Controlador`, `Accion`, `Nombre`) VALUES ('30', '11', 'Productos', 'Details', 'Detalles');
INSERT INTO `permisosweb` (`Id`, `Idmodulopermiso`, `Controlador`, `Accion`, `Nombre`) VALUES ('31', '11', 'Productos', 'Delete', 'Inactivar');


