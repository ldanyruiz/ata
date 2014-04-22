/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     22/08/2013 09:25:09 a.m.                     */
/*==============================================================*/
DROP TABLE IF EXISTS SECCION;
DROP TABLE IF EXISTS REPORTE_PREGUNTA;
DROP TABLE IF EXISTS REPORTE;
/*==============================================================*/
/* Table: REPORTE                                               */
/*==============================================================*/
CREATE TABLE REPORTE
(
   ID_REPORTE           INT NOT NULL AUTO_INCREMENT,
   ID_CAMPANA           INT,
   NOM_REPORTE          varchar(100),
   DESCR_REPORTE        varchar(2000),
   EST_REPORTE          tinyint,
   USU_CREA             int,
   USU_EDITA            int,
   FECH_CREA            date,
   FECH_EDITA           date,
   primary key (ID_REPORTE)
);

/*==============================================================*/
/* Table: REPORTE_PREGUNTA                                      */
/*==============================================================*/
create table REPORTE_PREGUNTA
(
   ID_REPORTE_PREGUNTA  int not null auto_increment,
   ID_SECCION           int,
   ID_PREGUNTA          int,
   primary key (ID_REPORTE_PREGUNTA)
);

/*==============================================================*/
/* Table: SECCION                                               */
/*==============================================================*/
create table SECCION
(
   ID_SECCION           int not null auto_increment,
   ID_REPORTE           int,
   NOM_SECCION          varchar(100),
   primary key (ID_SECCION)
);

alter table REPORTE add constraint FK_REFERENCE_17 foreign key (ID_CAMPANA)
      references CAMPANA (ID_CAMPANA) on delete restrict on update restrict;

alter table REPORTE_PREGUNTA add constraint FK_REFERENCE_19 foreign key (ID_SECCION)
      references SECCION (ID_SECCION) on delete restrict on update restrict;

alter table REPORTE_PREGUNTA add constraint FK_REFERENCE_20 foreign key (ID_PREGUNTA)
      references PREGUNTA (ID_PREGUNTA) on delete restrict on update restrict;

alter table SECCION add constraint FK_REFERENCE_18 foreign key (ID_REPORTE)
      references REPORTE (ID_REPORTE) on delete restrict on update restrict;

