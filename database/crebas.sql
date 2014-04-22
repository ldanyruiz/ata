/*==============================================================*/
/* dbms name:      mysql 5.0                                    */
/* created on:     22/08/2013 09:24:28 a.m.                     */
/*==============================================================*/

DROP SCHEMA IF EXISTS dhocompe_ais_final; CREATE SCHEMA dhocompe_ais_final; USE dhocompe_ais_final;

DROP TABLE IF EXISTS alternativa;

DROP TABLE IF EXISTS campana;

DROP TABLE IF EXISTS empresa;

DROP TABLE IF EXISTS formulario;

DROP TABLE IF EXISTS holding;

DROP TABLE IF EXISTS nivel;

DROP TABLE IF EXISTS nivel_tipo;

DROP TABLE IF EXISTS oculto;

DROP TABLE IF EXISTS pregunta;

DROP TABLE IF EXISTS pregunta_grupo;

DROP TABLE IF EXISTS reporte;

DROP TABLE IF EXISTS reporte_pregunta;

DROP TABLE IF EXISTS respuesta;

DROP TABLE IF EXISTS seccion;

DROP TABLE IF EXISTS usuario;

DROP TABLE IF EXISTS usuario_campana;

DROP TABLE IF EXISTS usuario_campana_reporte;

/*==============================================================*/
/* table: alternativa                                           */
/*==============================================================*/
CREATE TABLE alternativa
(
   id_alternativa       INT NOT NULL AUTO_INCREMENT,
   id_pregunta          INT,
   val_alternativa      VARCHAR(100),
   text_alternativa     VARCHAR(100),
   preg_alternativa     BOOL,
   PRIMARY KEY (id_alternativa)
);

/*==============================================================*/
/* table: campana                                               */
/*==============================================================*/
CREATE TABLE campana
(
   id_campana           INT NOT NULL AUTO_INCREMENT,
   id_empresa           INT,
   nom_campana          VARCHAR(100),
   inicio_campana       DATE,
   final_campana        DATE,
   est_campana          BOOL,
   PRIMARY KEY (id_campana)
);

/*==============================================================*/
/* table: empresa                                               */
/*==============================================================*/
CREATE TABLE empresa
(
   id_empresa           INT NOT NULL AUTO_INCREMENT,
   id_holding           INT,
   nom_empresa          VARCHAR(200),
   PRIMARY KEY (id_empresa)
);

/*==============================================================*/
/* table: formulario                                            */
/*==============================================================*/
CREATE TABLE formulario
(
   id_formulario        INT NOT NULL AUTO_INCREMENT,
   nom_formulario       VARCHAR(250),
   link_formulario      VARCHAR(250),
   ico_formulario       VARCHAR(250),
   rol_formulario       CHAR(1),
   PRIMARY KEY (id_formulario)
);

/*==============================================================*/
/* table: holding                                               */
/*==============================================================*/
CREATE TABLE holding
(
   id_holding           INT NOT NULL AUTO_INCREMENT,
   nom_holding          VARCHAR(200),
   PRIMARY KEY (id_holding)
);

/*==============================================================*/
/* table: nivel                                                 */
/*==============================================================*/
CREATE TABLE nivel
(
   id_nivel             INT NOT NULL AUTO_INCREMENT,
   id_nivel_tipo        INT,
   nom_nivel            VARCHAR(100),
   depen_nivel          INT,
   PRIMARY KEY (id_nivel)
);

/*==============================================================*/
/* table: nivel_tipo                                            */
/*==============================================================*/
CREATE TABLE nivel_tipo
(
   id_nivel_tipo        INT NOT NULL AUTO_INCREMENT,
   id_campana           INT,
   nom_nivel_tipo       VARCHAR(100),
   depen_nivel_tipo     INT,
   PRIMARY KEY (id_nivel_tipo)
);

/*==============================================================*/
/* table: oculto                                                */
/*==============================================================*/
CREATE TABLE oculto
(
   id_oculto            INT NOT NULL AUTO_INCREMENT,
   id_pregunta          INT,
   id_campana           INT,
   PRIMARY KEY (id_oculto)
);

/*==============================================================*/
/* table: pregunta                                              */
/*==============================================================*/
CREATE TABLE pregunta
(
   id_pregunta          INT NOT NULL AUTO_INCREMENT,
   id_pregunta_grupo    INT,
   cod_pregunta         VARCHAR(20),
   nom_pregunta         VARCHAR(500),
   descr_pregunta       VARCHAR(2000),
   tipo_pregunta        CHAR(1),
   multi_pregunta       BOOL,
   obli_pregunta        BOOL,
   ord_pregunta         INT,
   num_pregunta         BOOL,
   depen_pregunta       INT,
   usu_crea             INT,
   usu_edita            INT,
   fech_crea            DATETIME,
   fech_edita           DATETIME,
   tamano_texto         SMALLINT(4),
   valor_defecto	VARCHAR(40),
   PRIMARY KEY (id_pregunta)
);

/*==============================================================*/
/* table: pregunta_grupo                                        */
/*==============================================================*/
CREATE TABLE pregunta_grupo
(
   id_pregunta_grupo    INT NOT NULL AUTO_INCREMENT,
   cod_pregunta_grupo   VARCHAR(10),
   nom_pregunta_grupo   VARCHAR(500),
   descr_pregunta_grupo VARCHAR(1000),
   multi_pregunta_grupo BOOL,
   ord_pregunta_grupo   INT,
   PRIMARY KEY (id_pregunta_grupo)
);

/*==============================================================*/
/* table: reporte                                               */
/*==============================================================*/
CREATE TABLE reporte
(
   id_reporte           INT NOT NULL AUTO_INCREMENT,
   id_campana           INT,
   nom_reporte          VARCHAR(100),
   descr_reporte        VARCHAR(2000),
   est_reporte          TINYINT,
   usu_crea             INT,
   usu_edita            INT,
   fech_crea            DATE,
   fech_edita           DATE,
   PRIMARY KEY (id_reporte)
);

/*==============================================================*/
/* table: reporte_pregunta                                      */
/*==============================================================*/
CREATE TABLE reporte_pregunta
(
   id_reporte_pregunta  INT NOT NULL AUTO_INCREMENT,
   id_seccion           INT,
   id_pregunta          INT,
   PRIMARY KEY (id_reporte_pregunta)
);

/*==============================================================*/
/* table: respuesta                                             */
/*==============================================================*/
CREATE TABLE respuesta
(
   id_respuesta         INT NOT NULL AUTO_INCREMENT,
   id_pregunta          INT,
   id_usuario_campana   INT,
   cont_respuesta       VARCHAR(1000),
   ord_respuesta        INT,
   PRIMARY KEY (id_respuesta)
);

/*==============================================================*/
/* table: seccion                                               */
/*==============================================================*/
CREATE TABLE seccion
(
   id_seccion           INT NOT NULL AUTO_INCREMENT,
   id_reporte           INT,
   nom_seccion          VARCHAR(100),
   PRIMARY KEY (id_seccion)
);

/*==============================================================*/
/* table: usuario                                               */
/*==============================================================*/
CREATE TABLE usuario
(
   id_usuario           INT NOT NULL AUTO_INCREMENT,
   rol_usuario          CHAR(1),
   nom_usuario          VARCHAR(200),
   appat_usuario        VARCHAR(100),
   apmat_usuario        VARCHAR(100),
   login_usuario        VARCHAR(11),
   pass_usuario         VARCHAR(100),
   sex_usuario          CHAR(1),
   estciv_usuario       CHAR(1),
   fechnac_usuario      DATE,
   email_usuario        VARCHAR(250),
   est_usuario          CHAR(1),
   usu_crea             INT,
   usu_edita            INT,
   fech_crea            DATETIME,
   fech_edita           DATETIME,
   PRIMARY KEY (id_usuario)
);

/*==============================================================*/
/* table: usuario_campana                                       */
/*==============================================================*/
CREATE TABLE usuario_campana
(
   id_usuario_campana   INT NOT NULL AUTO_INCREMENT,
   id_campana           INT,
   id_usuario           INT,
   id_nivel             INT,
   profesion_usuario_campana VARCHAR(200),
   nivocu_usuario_campana VARCHAR(3),
   puesto_usuario_campana VARCHAR(200),
   PRIMARY KEY (id_usuario_campana)
);


CREATE TABLE usuario_campana_reporte (
  id_usuario_campana INT NOT NULL AUTO_INCREMENT,
  id_usuario INT,
  id_campana INT,
  PRIMARY KEY (id_usuario_campana)
);


ALTER TABLE alternativa ADD CONSTRAINT fk_reference_8 FOREIGN KEY (id_pregunta)
      REFERENCES pregunta (id_pregunta) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE campana ADD CONSTRAINT fk_reference_14 FOREIGN KEY (id_empresa)
      REFERENCES empresa (id_empresa) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE empresa ADD CONSTRAINT fk_reference_1 FOREIGN KEY (id_holding)
      REFERENCES holding (id_holding) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE nivel ADD CONSTRAINT fk_reference_2 FOREIGN KEY (id_nivel_tipo)
      REFERENCES nivel_tipo (id_nivel_tipo) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE nivel_tipo ADD CONSTRAINT fk_reference_15 FOREIGN KEY (id_campana)
      REFERENCES campana (id_campana) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE oculto ADD CONSTRAINT fk_reference_10 FOREIGN KEY (id_campana)
      REFERENCES campana (id_campana) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE oculto ADD CONSTRAINT fk_reference_9 FOREIGN KEY (id_pregunta)
      REFERENCES pregunta (id_pregunta) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE pregunta ADD CONSTRAINT fk_reference_7 FOREIGN KEY (id_pregunta_grupo)
      REFERENCES pregunta_grupo (id_pregunta_grupo) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE reporte ADD CONSTRAINT fk_reference_17 FOREIGN KEY (id_campana)
      REFERENCES campana (id_campana) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE reporte_pregunta ADD CONSTRAINT fk_reference_19 FOREIGN KEY (id_seccion)
      REFERENCES seccion (id_seccion) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE reporte_pregunta ADD CONSTRAINT fk_reference_20 FOREIGN KEY (id_pregunta)
      REFERENCES pregunta (id_pregunta) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE respuesta ADD CONSTRAINT fk_reference_12 FOREIGN KEY (id_pregunta)
      REFERENCES pregunta (id_pregunta) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE respuesta ADD CONSTRAINT fk_reference_16 FOREIGN KEY (id_usuario_campana)
      REFERENCES usuario_campana (id_usuario_campana) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE seccion ADD CONSTRAINT fk_reference_18 FOREIGN KEY (id_reporte)
      REFERENCES reporte (id_reporte) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE usuario_campana ADD CONSTRAINT fk_reference_11 FOREIGN KEY (id_nivel)
      REFERENCES nivel (id_nivel) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE usuario_campana ADD CONSTRAINT fk_reference_4 FOREIGN KEY (id_campana)
      REFERENCES campana (id_campana) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE usuario_campana ADD CONSTRAINT fk_reference_5 FOREIGN KEY (id_usuario)
      REFERENCES usuario (id_usuario) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE usuario_campana_reporte ADD CONSTRAINT fk_reference_6 FOREIGN KEY (id_usuario)
      REFERENCES usuario (id_usuario) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE usuario_campana_reporte ADD CONSTRAINT fk_reference_3 FOREIGN KEY (id_campana)
      REFERENCES campana (id_campana) ON DELETE RESTRICT ON UPDATE RESTRICT;
