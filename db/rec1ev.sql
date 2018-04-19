DROP TABLE IF EXISTS usuarios CASCADE;

CREATE TABLE usuarios
(
    id       bigserial    PRIMARY KEY
  , nombre   varchar(255) NOT NULL UNIQUE
  , numero   smallint     NOT NULL UNIQUE
  , password varchar(64)
);

INSERT
    INTO usuarios (nombre, numero, password)
  VALUES ('pepe', '001', crypt('pepe', gen_salt('bf', 11)))
         ,('juan', '002', crypt('juan', gen_salt('bf', 11)));

DROP TABLE IF EXISTS citas CASCADE;

CREATE TABLE citas
(
    id         bigserial PRIMARY KEY
  , fecha      date      NOT NULL
  , hora       time      NOT NULL
  , usuario_id bigint    NOT NULL REFERENCES usuarios (id)
                         ON DELETE CASCADE ON UPDATE CASCADE
);
