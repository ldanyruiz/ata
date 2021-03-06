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

/* LLENANDO LA TABLA HOLDING Y EMPRESA*/
/*INSERT INTO holding VALUES(NULL, 'Prueba de Holding');
INSERT INTO empresa VALUES(NULL, LAST_INSERT_ID(), 'Prueba de Empresa');

/* LLENANDO LA TABLA CAMPANA */
/*INSERT INTO campana VALUES(NULL, 1, 'Diagnostico de prueba', NOW(), '2013-12-31', 1);

/* LLENANDO LA TABLA NIVEL_TIPO Y NIVEL */
/*INSERT INTO nivel_tipo VALUES(NULL, 1, 'NIVEL', 0);
INSERT INTO nivel_tipo VALUES(NULL, 1, 'SUBNIVEL', 1);
INSERT INTO nivel_tipo VALUES(NULL, 1, 'INFRANIVEL', 2);

INSERT INTO nivel VALUES(NULL, 1, 'NIVEL 1', 0);
INSERT INTO nivel VALUES(NULL, 1, 'NIVEL 2', 0);

INSERT INTO nivel VALUES(NULL, 2, 'SUBNIVEL 1', 1);
INSERT INTO nivel VALUES(NULL, 2, 'SUBNIVEL 2', 1);
INSERT INTO nivel VALUES(NULL, 2, 'SUBNIVEL 3', 2);
INSERT INTO nivel VALUES(NULL, 2, 'SUBNIVEL 4', 2);

INSERT INTO nivel VALUES(NULL, 3, 'INFRANIVEL 1', 3);
INSERT INTO nivel VALUES(NULL, 3, 'INFRANIVEL 2', 3);
INSERT INTO nivel VALUES(NULL, 3, 'INFRANIVEL 3', 3);
INSERT INTO nivel VALUES(NULL, 3, 'INFRANIVEL 4', 3);
INSERT INTO nivel VALUES(NULL, 3, 'INFRANIVEL 5', 3);
INSERT INTO nivel VALUES(NULL, 3, 'INFRANIVEL 6', 4);
INSERT INTO nivel VALUES(NULL, 3, 'INFRANIVEL 7', 4);
INSERT INTO nivel VALUES(NULL, 3, 'INFRANIVEL 8', 4);
INSERT INTO nivel VALUES(NULL, 3, 'INFRANIVEL 9', 4);
INSERT INTO nivel VALUES(NULL, 3, 'INFRANIVEL 10', 4);
INSERT INTO nivel VALUES(NULL, 3, 'INFRANIVEL 11', 5);
INSERT INTO nivel VALUES(NULL, 3, 'INFRANIVEL 12', 5);
INSERT INTO nivel VALUES(NULL, 3, 'INFRANIVEL 13', 5);
INSERT INTO nivel VALUES(NULL, 3, 'INFRANIVEL 14', 5);
INSERT INTO nivel VALUES(NULL, 3, 'INFRANIVEL 15', 5);
INSERT INTO nivel VALUES(NULL, 3, 'INFRANIVEL 16', 6);
INSERT INTO nivel VALUES(NULL, 3, 'INFRANIVEL 17', 6);
INSERT INTO nivel VALUES(NULL, 3, 'INFRANIVEL 18', 6);
INSERT INTO nivel VALUES(NULL, 3, 'INFRANIVEL 19', 6);
INSERT INTO nivel VALUES(NULL, 3, 'INFRANIVEL 20', 6);

/* LLENANDO LA TABLA PREGUNTA_GRUPO */
INSERT INTO pregunta_grupo VALUES(NULL, 'FORACAD', 'FORMACI&Oacute;N ACAD&Eacute;MICA', '', 1,1);
INSERT INTO pregunta_grupo VALUES(NULL, 'DATPUEACT', 'DATOS DEL PUESTO ACTUAL', '', 0,2);
INSERT INTO pregunta_grupo VALUES(NULL, 'DATJER', 'DATOS JER&Aacute;RQUICOS', '', 0,3);
INSERT INTO pregunta_grupo VALUES(NULL, 'FUNPUEACT', 'FUNCIONES DEL PUESTO ACTUAL', '', 0,4);
INSERT INTO pregunta_grupo VALUES(NULL, 'DATPUESANT', 'DATOS DE PUESTOS ANTERIORES EN LA EMPRESA', 'En caso de no tener puestos anteriores dentro de la empresa obviar este campo y dar click a "Guardar y continuar"', 1,5);
INSERT INTO pregunta_grupo VALUES(NULL, 'EXPLAB', 'EXPERIENCIA LABORAL PREVIA A LA EMPRESA', '', 1,6);
INSERT INTO pregunta_grupo VALUES(NULL, 'CULT', 'CULTURA', '', 0,7);
INSERT INTO pregunta_grupo VALUES(NULL, 'CAP', 'CAPACITACIONES', '', 0,8);
INSERT INTO pregunta_grupo VALUES(NULL, 'CLIM', 'CLIMA', '', 0,9);
INSERT INTO pregunta_grupo VALUES(NULL, 'SISTINF', 'SISTEMAS INFORM&Aacute;TICOS', '', 0,10);
INSERT INTO pregunta_grupo VALUES(NULL, 'INFADI', 'INFORMACI&Oacute;N ADICIONAL', '', 0,11);

/* LLENANDO LA TABLA PREGUNTA */
INSERT INTO pregunta VALUES(NULL, 1, 'FORACAD0001', 'Nivel de estudios *', 'S', 0,1,1,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 1, 'FORACAD0002', 'Situaci&oacute;n *', 'S', 0,1,2,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 1, 'FORACAD0003', 'Nombre de la carrera estudiada *', 'T', 0,1,3,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 1, 'FORACAD0004', 'Nombre de la Instituci&oacute;n donde realizaste los estudios *', 'T', 0,1,4,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 2, 'DATPUEACT0001', 'Indique en que SEDE labora *', 'R', 0,1,1,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 2, 'DATPUEACT0002', 'Nombre la Sede', 'T', 0,0,NULL,0,5, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 2, 'DATPUEACT0003', '&Aacute;rea/Departamento donde desarrolla sus actividades *', 'T', 0,1,2,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 2, 'DATPUEACT0004', 'Nombre del puesto en planilla *', 'T', 0,1,3,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 2, 'DATPUEACT0005', 'Nombre del puesto real (puesto que ejerce) *', 'T', 0,1,4,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 2, 'DATPUEACT0006', 'Fecha de ingreso a la empresa *', 'F', 0,1,5,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 2, 'DATPUEACT0007', 'Fecha de inicio en el puesto *', 'F', 0,1,6,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 2, 'DATPUEACT0008', 'Describa el objetivo principal del puesto *', 'D', 0,1,7,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 2, 'DATPUEACT0009', 'Mencione las &aacute;reas con las que se relaciona para poder cumplir con el objetivo de su puesto *', 'T', 1,1,8,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 2, 'DATPUEACT0010', 'Mencione las habilidades personales necesarias para realizar las actividades de su puesto *', 'T', 1,1,9,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 2, 'DATPUEACT0011', 'Mencione los conocimientos t&eacute;cnicos necesarios para realizar las actividades de su puesto *', 'T', 1,1,10,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 3, 'DATJER0001', 'Colaborador que lo reemplaza en caso de ausencia', 'N', 1,0,1,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 3, 'DATJER0002', 'Puesto', 'T', 1,0,NULL,0,16, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 3, 'DATJER0003', 'Nombre', 'T', 1,0,NULL,0,16, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 3, 'DATJER0004', 'Colaborador a quien usted reemplaza en caso de ausencia *', 'N', 1,1,2,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 3, 'DATJER0005', 'Puesto', 'T', 1,1,NULL,0,19, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 3, 'DATJER0006', 'Nombre', 'T', 1,1,NULL,0,19, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 3, 'DATJER0007', '&iquest;Cuenta usted con personal a su cargo?', 'R', 1,0,3,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 3, 'DATJER0008', 'Puesto que ocupa', 'T', 1,0,NULL,0,22, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 3, 'DATJER0009', 'Nombre del colaborador', 'T', 1,0,NULL,0,22, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 3, 'DATJER0010', 'Reportes que recibe', 'T', 1,0,NULL,0,22, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 3, 'DATJER0011', 'Datos del Jefe Inmediato', 'N', 1,0,4,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 3, 'DATJER0012', 'Cargo del Jefe Inmediato', 'T', 1,0,NULL,0,26, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 3, 'DATJER0013', 'Nombre del Jefe Inmediato', 'T', 1,0,NULL,0,26, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 3, 'DATJER0014', 'Reportes enviados al jefe inmediato', 'D', 1,0,NULL,0,26, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 3, 'DATJER0015', '&iquest;Consideras que tu Jefe tiene capacidad de liderazgo? ', 'S', 1,0,NULL,0,26, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 3, 'DATJER0016', '&iquest;Porqu&eacute;? *', 'D', 1,1,NULL,0,26, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 3, 'DATJER0017', '&iquest;Consideras que tu Jefe posee una adecuada capacidad de gesti&oacute;n? *', 'S', 1,1,NULL,0,26, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 3, 'DATJER0018', '&iquest;Porqu&eacute;? *', 'D', 1,1,NULL,0,26, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 4, 'FUNPUEACT0001', 'Si conoces los procesos en los que participas, enum&eacute;ralos en orden de importancia (agregue una respuesta por cada proceso) *', 'T', 1,1,1,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 4, 'FUNPUEACT0002', 'Indique las actividades que realiza por orden de importancia (agregue una respuesta por cada actividad) *', 'N', 1,1,2,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 4, 'FUNPUEACT0003', 'Actividad', 'D', 1,1,NULL,0,35, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 4, 'FUNPUEACT0004', 'Frecuencia', 'T', 1,1,NULL,1,35, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 4, 'FUNPUEACT0005', 'Veces al', 'S', 1,1,NULL,0,35, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 4, 'FUNPUEACT0006', 'Tiempo de ejecuci&oacute;n (horas)', 'T', 1,1,NULL,1,35, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 4, 'FUNPUEACT0007', 'Puesto de la persona con la que se relaciona', 'T', 1,1,NULL,0,35, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 4, 'FUNPUEACT0008', 'Nombre de la persona con la que se relaciona', 'T', 1,1,NULL,0,35, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 4, 'FUNPUEACT0009', '&Aacute;rea de la persona con la que se relaciona', 'T', 1,1,NULL,0,35, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 4, 'FUNPUEACT0010', 'Documentos recibidos', 'T', 1,1,NULL,0,35, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 4, 'FUNPUEACT0011', 'Documentos enviados', 'T', 1,1,NULL,0,35, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 4, 'FUNPUEACT0012', '&iquest;Cu&aacute;les son las dificultades presentadas para realizar estas actividades? *', 'T', 1,1,3,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 4, 'FUNPUEACT0013', 'Desde tu punto de vista, &iquest;c&oacute;mo podr&iacute;an solucionarse estas dificultades? *', 'D', 0,1,4,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 4, 'FUNPUEACT0014', '&iquest;Cu&aacute;les son los indicadores que utiliza para medir las actividades que realiza? *', 'T', 1,1,5,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 4, 'FUNPUEACT0015', '&iquest;Qu&eacute; formatos utiliza al realizar sus actividades? *', 'T', 1,1,6,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 4, 'FUNPUEACT0016', '&iquest;Considera que las actividades que realiza guardan relaci&oacute;n con su puesto? *', 'R', 0,1,7,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 4, 'FUNPUEACT0017', '&iquest;Porqu&eacute;? *', 'D', 0,1,NULL,0,49, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 5, 'DATPUESANT0001', 'Nombre del puesto anterior', 'T', 0,0,1,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 5, 'DATPUESANT0002', 'Cantidad', 'T', 0,0,2,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 5, 'DATPUESANT0003', 'Tiempo', 'S', 0,0,3,1,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 6, 'EXPLAB0001', 'Empresa', 'T', 0,0,1,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 6, 'EXPLAB0002', 'Nombre del puesto ', 'T', 0,0,2,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 6, 'EXPLAB0003', 'Descripci&oacute;n del puesto', 'D', 0,0,3,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 6, 'EXPLAB0004', '&Aacute;rea en que desarrollo sus labores ', 'T', 0,0,4,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 6, 'EXPLAB0005', 'Fecha de ingreso', 'F', 0,0,5,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 6, 'EXPLAB0006', 'Fecha de salida', 'F', 0,0,6,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 7, 'CULT0001', '&iquest;Conoces el Plan Estrat&eacute;gico de la Empresa?', 'R', 0,0,1,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 7, 'CULT0002', 'Se&ntilde;ale cu&aacute;les son los objetivos estrat&eacute;gicos de la empresa', 'D', 1,0,NULL,0,60, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 7, 'CULT0003', 'Considera que su empresa se rige por el plan estrat&eacute;gico.', 'R', 0,0,NULL,0,60, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 7, 'CULT0004', '&iquest;Porqu&eacute;? *', 'D', 0,1,NULL,0,60, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 7, 'CULT0005', 'De conocerla indique cu&aacute;l es la misi&oacute;n de la empresa', 'D', 0,0,2,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 7, 'CULT0006', 'De conocerla indique cu&aacute;l es la visi&oacute;n de la Empresa', 'D', 0,0,3,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 7, 'CULT0007', '&iquest;Est&aacute; usted de acuerdo con la misi&oacute;n y visi&oacute;n?', 'R', 0,0,4,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 7, 'CULT0008', 'De acuerdo a su percepci&oacute;n: &iquest;Cu&aacute;l deber&iacute;a ser la misi&oacute;n y visi&oacute;n de la Empresa?', 'D', 0,0,NULL,0,66, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 7, 'CULT0009', 'Indica las principales fortalezas de la empresa', 'T', 1,0,5,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 7, 'CULT0010', 'Indica las principales oportunidades de la empresa', 'T', 1,0,6,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 7, 'CULT0011', 'Indica las principales debilidades de la empresa', 'T', 1,0,7,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 7, 'CULT0012', 'Indica las principales amenazas de la empresa', 'T', 1,0,8,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 7, 'CULT0013', '&iquest;Qu&eacute; documentos de gesti&oacute;n de la Empresa conoce? *', 'T', 1,1,9,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 7, 'CULT0014', '&iquest;Conoce los valores institucionales de la Empresa?', 'R', 0,0,10,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 7, 'CULT0015', '&iquest;Cu&aacute;les son?', 'D', 0,0,NULL,0,73, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 7, 'CULT0016', '&iquest;Considera que dichos valores son aplicados en la Empresa? Explique su respuesta', 'R', 0,0,11,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 7, 'CULT0017', '&iquest;Porqu&eacute;? *', 'D', 0,1,NULL,0,75, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 7, 'CULT0018', '&iquest;Cu&aacute;l es el valor con el que m&aacute;s te identificas? &iquest;Por qu&eacute;?', 'D', 0,0,12,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 7, 'CULT0019', '&iquest;Qu&eacute; aspectos / cualidades identifican a los colaboradores de la Empresa?', 'T', 1,0,13,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 8, 'CAP0001', '&iquest;Has recibido inducci&oacute;n?', 'R', 0,0,1,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 8, 'CAP0002', '&iquest;Consideras que la informaci&oacute;n recibida ha sido suficiente? Expl&iacute;quese', 'R', 0,0,NULL,0,79, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 8, 'CAP0003', '&iquest;Porqu&eacute;? *', 'D', 0,1,NULL,0,79, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 8, 'CAP0004', '&iquest;Existe un plan de capacitaci&oacute;n?', 'R', 0,0,2,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 8, 'CAP0005', '&iquest;Has recibido capacitaciones por parte de la empresa?', 'R', 0,0,3,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 8, 'CAP0006', '&iquest;Cu&aacute;les?', 'D', 1,0,NULL,0,83, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 8, 'CAP0007', '&iquest;Est&aacute;s conforme con la capacitaci&oacute;n recibida?', 'R', 0,0,4,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 8, 'CAP0008', '&iquest;Porqu&eacute;? *', 'D', 0,1,NULL,0,85, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 8, 'CAP0009', '&iquest;Qu&eacute; consideras deber&iacute;as recibir para mejorar tu desempe&ntilde;o laboral?', 'T', 1,0,5,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 9, 'CLIM0001', '&iquest;C&oacute;mo percibes el clima laboral en la Empresa?', 'R', 0,0,1,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 9, 'CLIM0002', 'Explique su respuesta', 'D', 0,0,2,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 9, 'CLIM0003', '&iquest;Qu&eacute; har&iacute;a para mejorar el clima laboral en la Empresa?', 'D', 1,0,3,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 9, 'CLIM0004', '&iquest;Consideras que el ambiente f&iacute;sico donde trabajas es el adecuado? *', 'R', 0,1,4,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 9, 'CLIM0005', '&iquest;Porqu&eacute;? *', 'D', 0,1,NULL,0,91, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 9, 'CLIM0006', '&iquest;Consideras que el personal contratado es el adecuado?', 'R', 0,0,5,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 9, 'CLIM0007', '&iquest;Porqu&eacute;? *', 'D', 0,1,NULL,0,93, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 9, 'CLIM0008', '&iquest;Consideras que el personal contratado es suficiente?', 'R', 0,0,6,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 9, 'CLIM0009', '&iquest;Porqu&eacute;? *', 'D', 0,1,NULL,0,95, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 9, 'CLIM0010', '&iquest;Considera que tu trabajo es valorado por tu Jefe? *', 'R', 0,1,7,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 9, 'CLIM0011', '&iquest;Porqu&eacute;? *', 'D', 0,1,NULL,0,97, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 9, 'CLIM0012', '&iquest;Existe l&iacute;nea de carrera en la Empresa?', 'R', 0,0,8,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 9, 'CLIM0013', '&iquest;D&oacute;nde desarrollar&iacute;as tu l&iacute;nea de carrera? *', 'R', 0,1,9,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 9, 'CLIM0014', '&iquest;En qu&eacute; otra &aacute;rea y porqu&eacute;?', 'D', 0,1,NULL,0,100, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 9, 'CLIM0015', 'Indique el puesto que aspira conseguir en la Empresa *', 'T', 0,1,10,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 9, 'CLIM0016', 'En que tiempo esperar&iacute;a ascender *', 'R', 0,1,11,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 9, 'CLIM0017', '&iquest;Existe una buena comunicaci&oacute;n entre &aacute;reas?', 'R', 0,0,12,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 9, 'CLIM0018', '&iquest;A qu&eacute; cree que se debe?', 'D', 0,0,NULL,0,104, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 9, 'CLIM0019', '&iquest;Qu&eacute; acciones propone para mejorar la comunicaci&oacute;n?', 'T', 1,0,13,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 9, 'CLIM0020', '&iquest;La documentaci&oacute;n administrativa fluye &aacute;gil y oportunamente entre &aacute;reas?', 'R', 0,0,14,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 9, 'CLIM0021', 'Se siente orgulloso de pertenecer a la Empresa.', 'R', 0,0,15,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 9, 'CLIM0022', '&iquest;Porqu&eacute;? *', 'D', 0,1,NULL,0,108, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 9, 'CLIM0023', '&iquest;Considera que la imagen p&uacute;blica de la Empresa es la adecuada?', 'R', 0,0,16,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 9, 'CLIM0024', '&iquest;Porqu&eacute;? *', 'D', 0,1,NULL,0,110, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 9, 'CLIM0025', '&iquest;Cu&aacute;l es tu percepci&oacute;n de la Empresa respecto a la competencia?', 'D', 0,0,17,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 9, 'CLIM0026', '&iquest;Cu&aacute;l es tu percepci&oacute;n sobre el futuro de la Empresa?', 'D', 0,0,18,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 9, 'CLIM0027', 'Si fuera su Empresa, &iquest;que har&iacute;a para mejorar la eficiencia?', 'D', 0,0,19,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 10, 'SISTINF0001', '&iquest;Utilizas alg&uacute;n sistema inform&aacute;tico para realizar tu trabajo?', 'R', 1,1,1,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 10, 'SISTINF0002', 'Nombre del sistema inform&aacute;tico', 'T', 1,1,NULL,0,115, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 10, 'SISTINF0003', 'Califica el sistema inform&aacute;tico', 'S', 1,1,NULL,0,115, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 10, 'SISTINF0004', '&iquest;De qu&eacute; manera este sistema te ayuda a realizar tu trabajo?', 'D', 1,1,NULL,0,115, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 10, 'SISTINF0005', 'Indica las dificultades que presenta el sistema mencionado y c&oacute;mo estas interfieren en tu trabajo', 'D', 1,1,NULL,0,115, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 11, 'INFADI0001', '&iquest;Qu&eacute; problemas observa o percibe en otras &aacute;reas?', 'D', 1,0,1,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 11, 'INFADI0002', 'Seg&uacute;n su percepci&oacute;n la calidad interna de servicio es:', 'R', 0,0,2,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 11, 'INFADI0003', '&iquest;Qu&eacute; har&iacute;a para mejorarla?', 'D', 1,0,3,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 11, 'INFADI0004', '&iquest;Conoce todos los servicios y/o productos que ofrece la empresa a sus clientes?', 'R', 0,0,4,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 11, 'INFADI0005', '&iquest;Considera que la Empresa es socialmente responsable?', 'R', 0,0,5,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 11, 'INFADI0006', 'Proponga acciones para mejorar la responsabilidad social de la Empresa', 'D', 1,0,6,0,0, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 11, 'INFADI0007', 'Comentario adicionales', 'D', 0,0,7,0,0, NULL, NULL, NOW(), NULL);


/* LLENANDO LA TABLA ALTERNATIVA */
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'FORACAD0001'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Secundaria', 'Secundaria', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'FORACAD0001'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Tecnico', 'T&eacute;cnico', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'FORACAD0001'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Universitario', 'Universitario', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'FORACAD0001'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Especializacion', 'Especializaci&oacute;n', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'FORACAD0001'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Maestria', 'Maestr&iacute;a', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'FORACAD0001'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Doctorado', 'Doctorado', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'FORACAD0001'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Curso', 'Curso', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'FORACAD0001'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Diplomado', 'Diplomado', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'FORACAD0001'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Postgrado', 'Postgrado', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'FORACAD0001'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Taller', 'Taller', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'FORACAD0001'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Otro', 'Otro', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'FORACAD0002'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Estudiando', 'Estudiando', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'FORACAD0002'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Incompleto', 'Incompleto', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'FORACAD0002'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Completo', 'Completo', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'FORACAD0002'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Egresado', 'Egresado', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'FORACAD0002'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Titulado', 'Titulado', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'FORACAD0002'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Bachiller', 'Bachiller', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'DATPUEACT0001'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Principal', 'Principal', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'DATPUEACT0001'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Otro', 'Otro', 1);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'DATJER0007'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Si', 'S&iacute;', 1);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'DATJER0007'); INSERT INTO alternativa VALUES(NULL,  @preg, 'No', 'No', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'DATJER0015'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Si', 'S&iacute;', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'DATJER0015'); INSERT INTO alternativa VALUES(NULL,  @preg, 'No', 'No', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'DATJER0017'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Si', 'S&iacute;', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'DATJER0017'); INSERT INTO alternativa VALUES(NULL,  @preg, 'No', 'No', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'FUNPUEACT0005'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Dia', 'D&iacute;a', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'FUNPUEACT0005'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Semana', 'Semana', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'FUNPUEACT0005'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Mes', 'Mes', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'FUNPUEACT0005'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Ano', 'A&ntilde;o', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'FUNPUEACT0016'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Si', 'S&iacute;', 1);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'FUNPUEACT0016'); INSERT INTO alternativa VALUES(NULL,  @preg, 'No', 'No', 1);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'DATPUESANT0003'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Meses', 'Meses', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'DATPUESANT0003'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Anos', 'A&ntilde;os', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'CULT0001'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Si', 'S&iacute;', 1);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'CULT0001'); INSERT INTO alternativa VALUES(NULL,  @preg, 'No', 'No', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'CULT0003'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Si', 'S&iacute;', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'CULT0003'); INSERT INTO alternativa VALUES(NULL,  @preg, 'No', 'No', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'CULT0007'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Si', 'S&iacute;', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'CULT0007'); INSERT INTO alternativa VALUES(NULL,  @preg, 'No', 'No', 1);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'CULT0014'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Si', 'S&iacute;', 1);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'CULT0014'); INSERT INTO alternativa VALUES(NULL,  @preg, 'No', 'No', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'CULT0016'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Si', 'S&iacute;', 1);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'CULT0016'); INSERT INTO alternativa VALUES(NULL,  @preg, 'No', 'No', 1);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'CAP0001'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Si', 'S&iacute;', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'CAP0001'); INSERT INTO alternativa VALUES(NULL,  @preg, 'No', 'No', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'CAP0002'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Si', 'S&iacute;', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'CAP0002'); INSERT INTO alternativa VALUES(NULL,  @preg, 'No', 'No', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'CAP0004'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Si', 'S&iacute;', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'CAP0004'); INSERT INTO alternativa VALUES(NULL,  @preg, 'No', 'No', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'CAP0005'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Si, los del plan de capacitacion', 'S&iacute;, los del plan de capacitaci&oacute;n', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'CAP0005'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Si, otros', 'S&iacute;, otros', 1);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'CAP0005'); INSERT INTO alternativa VALUES(NULL,  @preg, 'No', 'No', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'CAP0007'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Si', 'S&iacute;', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'CAP0007'); INSERT INTO alternativa VALUES(NULL,  @preg, 'No', 'No', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'CLIM0001'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Pesimo', 'P&eacute;simo', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'CLIM0001'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Malo', 'Malo', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'CLIM0001'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Regular', 'Regular', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'CLIM0001'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Bueno', 'Bueno', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'CLIM0001'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Excelente', 'Excelente', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'CLIM0004'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Si', 'S&iacute;', 1);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'CLIM0004'); INSERT INTO alternativa VALUES(NULL,  @preg, 'No', 'No', 1);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'CLIM0006'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Si', 'S&iacute;', 1);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'CLIM0006'); INSERT INTO alternativa VALUES(NULL,  @preg, 'No', 'No', 1);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'CLIM0008'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Si', 'S&iacute;', 1);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'CLIM0008'); INSERT INTO alternativa VALUES(NULL,  @preg, 'No', 'No', 1);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'CLIM0010'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Si', 'S&iacute;', 1);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'CLIM0010'); INSERT INTO alternativa VALUES(NULL,  @preg, 'No', 'No', 1);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'CLIM0012'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Si', 'S&iacute;', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'CLIM0012'); INSERT INTO alternativa VALUES(NULL,  @preg, 'No', 'No', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'CLIM0013'); INSERT INTO alternativa VALUES(NULL,  @preg, 'En su area', 'En su &aacute;rea', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'CLIM0013'); INSERT INTO alternativa VALUES(NULL,  @preg, 'En otra area', 'En otra &aacute;rea', 1);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'CLIM0016'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Menos de 6 meses', 'Menos de 6 meses', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'CLIM0016'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Menos de 1 ano', 'Menos de 1 a&ntilde;o', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'CLIM0016'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Menos de 2 anos', 'Menos de 2 a&ntilde;os', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'CLIM0016'); INSERT INTO alternativa VALUES(NULL,  @preg, 'De 2 anos o mas', 'De 2 a&ntilde;os a m&aacute;s', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'CLIM0017'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Si', 'S&iacute;', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'CLIM0017'); INSERT INTO alternativa VALUES(NULL,  @preg, 'No', 'No', 1);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'CLIM0020'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Si', 'S&iacute;', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'CLIM0020'); INSERT INTO alternativa VALUES(NULL,  @preg, 'No', 'No', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'CLIM0021'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Si', 'S&iacute;', 1);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'CLIM0021'); INSERT INTO alternativa VALUES(NULL,  @preg, 'No', 'No', 1);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'CLIM0023'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Si', 'S&iacute;', 1);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'CLIM0023'); INSERT INTO alternativa VALUES(NULL,  @preg, 'No', 'No', 1);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'SISTINF0001'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Si', 'S&iacute;', 1);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'SISTINF0001'); INSERT INTO alternativa VALUES(NULL,  @preg, 'No', 'No', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'SISTINF0003'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Pesimo', 'P&eacute;simo', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'SISTINF0003'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Malo', 'Malo', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'SISTINF0003'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Regular', 'Regular', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'SISTINF0003'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Bueno', 'Bueno', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'SISTINF0003'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Excelente', 'Excelente', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'INFADI0002'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Pesimo', 'P&eacute;simo', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'INFADI0002'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Malo', 'Malo', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'INFADI0002'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Regular', 'Regular', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'INFADI0002'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Bueno', 'Bueno', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'INFADI0002'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Excelente', 'Excelente', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'INFADI0004'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Si', 'S&iacute;', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'INFADI0004'); INSERT INTO alternativa VALUES(NULL,  @preg, 'No', 'No', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'INFADI0005'); INSERT INTO alternativa VALUES(NULL,  @preg, 'Si', 'S&iacute;', 0);
SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta LIKE 'INFADI0005'); INSERT INTO alternativa VALUES(NULL,  @preg, 'No', 'No', 0);


/* LLENANDO LA TABLA USUARIO */
INSERT INTO usuario VALUES(NULL, 'R', 'Reportes', NULL, NULL, 'reportes', MD5('reportesDHO'), NULL, NULL, NULL, NULL, 'A', NULL, NULL, NOW(), NULL);
INSERT INTO usuario VALUES(NULL, 'A', 'Administrador DHO', NULL, NULL, 'adminDHO', MD5('adminDHO'), NULL, NULL, NULL, NULL, 'A', NULL, NULL, NOW(), NULL);

/* LLENANDO LA TABLA USUARIO_CAMPANA */
/*INSERT INTO usuario VALUES(NULL, 'U', 'Prueba', NULL, NULL, '00000001', MD5('123'), NULL, NULL, NULL, NULL, 'A', NULL, NULL, NOW(), NULL);
INSERT INTO usuario_campana SELECT NULL, 1, id_usuario, NULL, NULL, NULL, NULL FROM usuario WHERE rol_usuario = 'U';*/