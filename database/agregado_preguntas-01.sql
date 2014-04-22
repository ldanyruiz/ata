UPDATE pregunta SET ord_pregunta=1 WHERE id_pregunta = 36;
UPDATE pregunta SET ord_pregunta=2 WHERE id_pregunta = 37;
UPDATE pregunta SET ord_pregunta=3 WHERE id_pregunta = 38;
UPDATE pregunta SET ord_pregunta=4 WHERE id_pregunta = 39;
INSERT INTO pregunta VALUES(NULL, 4, 'FUNPUEACT0007', 'Grado de complejidad o dificultad', 'S', 1, 1, 5, 0, 35, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 4, 'FUNPUEACT0008', 'Grado de importancia', 'S', 1, 1, 6, 0, 35, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 4, 'FUNPUEACT0009', 'Consecuencia de la no aplicaci&oacute;n de la actividad', 'S', 1, 1, 7, 0, 35, NULL, NULL, NOW(), NULL);
INSERT INTO pregunta VALUES(NULL, 4, 'FUNPUEACT0010', '&iquest;A qu&eacute; &aacute;reas y procesos afectar&iacute;a?', 'D', 1, 1, 8, 0, 35, NULL, NULL, NOW(), NULL);
UPDATE pregunta SET ord_pregunta=9 WHERE id_pregunta = 40;
UPDATE pregunta SET ord_pregunta=10 WHERE id_pregunta = 41;
UPDATE pregunta SET ord_pregunta=11 WHERE id_pregunta = 42;
UPDATE pregunta SET ord_pregunta=12 WHERE id_pregunta = 43;
UPDATE pregunta SET ord_pregunta=13 WHERE id_pregunta = 44;

ALTER TABLE alternativa MODIFY COLUMN text_alternativa VARCHAR(1000);

SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta = 'FUNPUEACT0007'); 
INSERT INTO alternativa VALUES(NULL, @preg, '5', 'M&aacute;xima complejidad: la actividad demanda el mayor grado de esfuerzo / conocimientos / habilidades.', 0);
INSERT INTO alternativa VALUES(NULL, @preg, '4', 'Alta complejidad: la actividad demanda un considerable nivel de esfuerzo / conocimientos / habilidades.', 0);
INSERT INTO alternativa VALUES(NULL, @preg, '3', 'Complejidad moderada: la actividad requiere un grado medio de esfuerzo / conocimientos / habilidades.', 0);
INSERT INTO alternativa VALUES(NULL, @preg, '2', 'Baja complejidad: la actividad requiere un bajo nivel de esfuerzo / conocimientos / habilidades.', 0);
INSERT INTO alternativa VALUES(NULL, @preg, '1', 'M&iacute;nima complejidad: la actividad requiere un m&iacute;nimo nivel de esfuerzo / conocimientos / habilidades.', 0);

SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta = 'FUNPUEACT0008'); 
INSERT INTO alternativa VALUES(NULL, @preg, '5', 'Muy importante', 0);
INSERT INTO alternativa VALUES(NULL, @preg, '4', 'Medianamente importante', 0);
INSERT INTO alternativa VALUES(NULL, @preg, '3', 'Neutral', 0);
INSERT INTO alternativa VALUES(NULL, @preg, '2', 'Poco importante', 0);
INSERT INTO alternativa VALUES(NULL, @preg, '1', 'Nada importante', 0);


SET @preg = (SELECT id_pregunta FROM pregunta WHERE cod_pregunta = 'FUNPUEACT0009'); 
INSERT INTO alternativa VALUES(NULL, @preg, '5', 'Consecuencias muy graves: pueden afectar a toda la organizaci&oacute;n en m&uacute;ltiples aspectos.', 0);
INSERT INTO alternativa VALUES(NULL, @preg, '4', 'Consecuencias graves: pueden afectar resultados, procesos o &aacute;reas funcionales de la organizaci&oacute;n.', 0);
INSERT INTO alternativa VALUES(NULL, @preg, '3', 'Consecuencias considerables: repercuten negativamente en los resultados o trabajos de otros.', 0);
INSERT INTO alternativa VALUES(NULL, @preg, '2', 'Consecuencias menores: cierta incidencia en resultados o actividades que pertenecen al mismo puesto.', 0);
INSERT INTO alternativa VALUES(NULL, @preg, '1', 'Consecuencias m&iacute;nimas: poca o ninguna incidencia en actividades o resultados.', 0);
