/* LLENANDO LA TABLA FORMULARIO*/
INSERT INTO formulario VALUES(NULL, 'Cuestionario', 'cuestionario.php', 'icon_test.png', 'U');
INSERT INTO formulario VALUES(NULL, 'Reportes', 'reporte.php', 'icon_report.png', 'R');
INSERT INTO formulario VALUES(NULL, 'Campa&ntilde;as', 'campana.php', 'icon_campaign.png', 'A');
INSERT INTO formulario VALUES(NULL, 'Reportes', 'reporte.php', 'icon_report.png', 'A');
INSERT INTO formulario VALUES(NULL, 'Constructor de Reportes', 'constructor.php', 'icon_constructor.png', 'A');
INSERT INTO formulario VALUES(NULL, 'Campa&ntilde;as', 'campana.php', 'icon_campaign.png', 'S');
INSERT INTO formulario VALUES(NULL, 'Reportes', 'reporte.php', 'icon_report.png', 'S');
INSERT INTO formulario VALUES(NULL, 'Constructor de Reportes', 'constructor.php', 'icon_constructor.png', 'S');
INSERT INTO formulario VALUES(NULL, 'Usuarios del Sistema', 'usuarios.php', 'icon_users.png', 'S');

/* LLENANDO LA TABLA USUARIO */
INSERT INTO usuario VALUES(NULL, 'R', 'Reportes', NULL, NULL, 'reportes', MD5('reportesDHO'), NULL, NULL, NULL, NULL, 'A', NULL, NULL, NOW(), NULL);
INSERT INTO usuario VALUES(NULL, 'A', 'Administrador DHO', NULL, NULL, 'adminDHO', MD5('adminDHO'), NULL, NULL, NULL, NULL, 'A', NULL, NULL, NOW(), NULL);

/* LLENANDO LA TABLA USUARIO_CAMPANA */
/*INSERT INTO usuario VALUES(NULL, 'U', 'Prueba', NULL, NULL, '00000001', MD5('123'), NULL, NULL, NULL, NULL, 'A', NULL, NULL, NOW(), NULL);
INSERT INTO usuario_campana SELECT NULL, 1, id_usuario, NULL, NULL, NULL, NULL FROM usuario WHERE rol_usuario = 'U';*/