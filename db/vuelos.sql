------------------------------
-- Archivo de base de datos --
------------------------------

DROP TABLE IF EXISTS usuarios CASCADE;

CREATE TABLE usuarios
(
    id         bigserial    PRIMARY KEY
  , nombre     varchar(255) NOT NULL UNIQUE
  , password   varchar(255) NOT NULL
);

DROP TABLE IF EXISTS aeropuertos CASCADE;

CREATE TABLE aeropuertos
(
    id       bigserial    PRIMARY KEY
  , id_aero  varchar(3)   NOT NULL
  , den_aero varchar(255)
);

DROP TABLE IF EXISTS companias CASCADE;

CREATE TABLE companias
(
    id       bigserial    PRIMARY KEY
  , den_comp varchar(255)
);

DROP TABLE IF EXISTS vuelos CASCADE;

CREATE TABLE vuelos
(
    id       bigserial     PRIMARY KEY
  , id_vuelo varchar(6)    NOT NULL
  , orig_id  bigint        NOT NULL REFERENCES aeropuertos (id)
                           ON DELETE NO ACTION ON UPDATE CASCADE
  , dest_id  bigint        NOT NULL REFERENCES aeropuertos (id)
                           ON DELETE NO ACTION ON UPDATE CASCADE
  , comp_id  bigint        NOT NULL REFERENCES companias (id)
                           ON DELETE NO ACTION ON UPDATE CASCADE
  , salida   timestamp(0)  NOT NULL
  , llegada  timestamp(0)  NOT NULL
  , plazas   numeric(5)    NOT NULL
  , precio   numeric(10,2) NOT NULL
);

DROP TABLE IF EXISTS reservas CASCADE;

CREATE TABLE reservas
(
    id         bigserial    PRIMARY KEY
  , usuario_id bigint       NOT NULL REFERENCES usuarios (id)
                            ON DELETE NO ACTION ON UPDATE CASCADE
  , vuelo_id   bigint       NOT NULL REFERENCES vuelos (id)
                            ON DELETE NO ACTION ON UPDATE CASCADE
  , asiento    numeric(5)   NOT NULL
  , fecha_hora timestamp(0) NOT NULL DEFAULT localtimestamp
  , UNIQUE (usuario_id, vuelo_id)
);

INSERT INTO usuarios (nombre, password)
     VALUES('pepe', crypt('pepe', gen_salt('bf', 13)))
         , ('juan', crypt('juan', gen_salt('bf', 13)))
         , ('jose', crypt('jose', gen_salt('bf', 13)));

INSERT INTO aeropuertos (id_aero, den_aero)
     VALUES ('XRY', 'Jerez de la Frontera')
          , ('MAD', 'Madrid')
          , ('BCN', 'Barcelona')
          , ('SEV', 'Sevilla');

INSERT INTO companias (den_comp)
     VALUES ('Iberia')
          , ('Ryanair')
          , ('Vueling');

INSERT INTO vuelos (id_vuelo, orig_id, dest_id, comp_id, salida, llegada, plazas, precio)
     VALUES ('AA1111', 1, 3, 3, localtimestamp - 'P2D'::interval, localtimestamp + 'P2DT2H'::interval, 20, 70)
          , ('BB2222', 4, 2, 1, localtimestamp + 'P5D'::interval, localtimestamp + 'P5DT1H'::interval, 3, 40)
          , ('CC2222', 4, 1, 1, localtimestamp + 'P6D'::interval, localtimestamp + 'P5DT1H'::interval, 5, 40)
          , ('DD2222', 3, 2, 1, localtimestamp + 'P7D'::interval, localtimestamp + 'P5DT1H'::interval, 7, 40)
          , ('EE2222', 1, 2, 1, localtimestamp + 'P8D'::interval, localtimestamp + 'P5DT1H'::interval, 6, 40)
          , ('FF3333', 3, 2, 2, localtimestamp + 'P9D'::interval, localtimestamp + 'P7DT2H'::interval, 15, 80);

INSERT INTO reservas (usuario_id, vuelo_id, asiento, fecha_hora)
     VALUES (1, 2, 2, localtimestamp)
          , (2, 2, 3, localtimestamp)
          , (3, 1, 12, localtimestamp);
