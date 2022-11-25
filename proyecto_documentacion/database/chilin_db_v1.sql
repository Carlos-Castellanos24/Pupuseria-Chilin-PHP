DROP DATABASE IF EXISTS chilin_db;
CREATE DATABASE chilin_db;
USE chilin_db;

-- [01 / 10] TABLA CLIENTE 
CREATE TABLE IF NOT EXISTS cliente(
id_cliente        int             NOT NULL  AUTO_INCREMENT,
nombre_cliente    varchar(50)     NOT NULL,
apellido_cliente  varchar(50)     NOT NULL,
dui               varchar(15)     NOT NULL,
telefono          int(8)          NOT NULL,
rol               char(2)         NOT NULL,
correo            varchar(30)     NULL,
direccion         varchar(120)    NULL,
sexo              ENUM('M', 'F')  NOT NULL,            -- Delimitamos a M o F el dato en el sexo
estado_cliente    char(2)         NOT NULL,
CONSTRAINT pk_id_cliente PRIMARY KEY(id_cliente),      -- Establecimos la llave primaria de la tabla cliente
CONSTRAINT uq_telefono_cliente UNIQUE (telefono)       -- El teléfono del cliente sera único para la identificación en la tabla cliente
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- [02 / 10] TABLA CATEGORIA 
CREATE TABLE IF NOT EXISTS categoria(
id_categoria      int          NOT NULL AUTO_INCREMENT,
nombre_categoria  varchar(50)  NOT NULL,
estado_categoria  char(2)      NOT NULL,
CONSTRAINT pk_id_categoria PRIMARY KEY(id_categoria)   -- Establecimos la llave primaria de la tabla categoria
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- [03 / 10] TABLA RESERVA 
CREATE TABLE IF NOT EXISTS reserva(
id_reservacion     int      NOT NULL AUTO_INCREMENT,
id_cliente         int      NOT NULL,
estado_reserva     char(2)  NOT NULL,
CONSTRAINT pk_id_reserva PRIMARY KEY(id_reservacion)   -- Establecimos la llave primaria de la tabla reserva
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- [04 / 10] TABLA PRODUCTO 
CREATE TABLE IF NOT EXISTS producto(
id_producto        int          NOT NULL AUTO_INCREMENT,
id_categoria       int          NOT NULL,
nombre_producto    varchar(50)  NOT NULL,
fecha_ingreso      date         NOT NULL,
fecha_vencimiento  date         NOT NULL,
costo              decimal(6,2) NOT NULL,
precio             decimal(6,2) NOT NULL,
stock              int          NOT NULL,
estado_producto    char(2)      NOT NULL,
CONSTRAINT pk_id_producto PRIMARY KEY(id_producto)     -- Establecimos la llave primaria de la tabla producto
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- [05 / 10] TABLA PEDIDO 
CREATE TABLE IF NOT EXISTS pedido(
id_pedido        int     NOT NULL  AUTO_INCREMENT,
correlativo      int     NOT NULL,
id_cliente       int     NOT NULL,
id_producto      int     NOT NULL,
cantidad         int     NOT NULL,
fecha            date    NOT NULL,
hora             time    NOT NULL,
estado_pedido    char(2) NOT NULL,
CONSTRAINT pk_id_pedido PRIMARY KEY(id_pedido)         -- Establecimos la llave primaria de la tabla pedido
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- [06 / 10] TABLA MESA 
CREATE TABLE IF NOT EXISTS mesa(
id_mesa          int     NOT NULL AUTO_INCREMENT,
id_reservacion   int     NOT NULL,
id_pedido        int     NOT NULL,
cant_sillas      int     NOT NULL,
fecha            date    NOT NULL,
hora_inicio      time    NOT NULL,
hora_final       time    NOT NULL,
comentario       text    NULL,
estado_mesa      char(2) NOT NULL,
CONSTRAINT pk_id_mesa PRIMARY KEY(id_mesa)             -- Establecimos la llave primaria de la tabla mesa
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- [07 / 10] TABLA COMENTARIO 
CREATE TABLE IF NOT EXISTS comentario(
id_comentario         int        NOT NULL AUTO_INCREMENT,
id_cliente            int        NOT NULL,
id_pedido             int        NOT NULL,
tipo_cometario        char(2)    NOT NULL,
asunto                text       NULL,
comentario            text       NULL,
fecha                 datetime   NULL,
estado_comentario     char(2)    NOT NULL,
CONSTRAINT pk_id_comentario PRIMARY KEY(id_comentario) -- Establecimos la llave primaria de la tabla comentario
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- [8 / 10] TABLA FACTURA 
CREATE TABLE IF NOT EXISTS factura(
id_factura       int          NOT NULL AUTO_INCREMENT,
id_pedido        int          NOT NULL,
fecha            datetime     NOT NULL,
total_pagar      decimal(6,2) NOT NULL,
tipo_factura     char(2)      NOT NULL,
estado_factura   char(2)      NOT NULL,
CONSTRAINT pk_id_factura PRIMARY KEY(id_factura)       -- Establecimos la llave primaria de la tabla factura
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- [09 / 10] TABLA PAGO 
CREATE TABLE IF NOT EXISTS pago(
id_pago        int          NOT NULL AUTO_INCREMENT,
id_factura     int          NOT NULL,
fecha          datetime     NOT NULL,
total_pagar    decimal(6,2) NOT NULL,
pago_cliente   decimal(6,2) NOT NULL,
vuelto         decimal(6,2) NOT NULL,
estado_pago    char(2)      NOT NULL,
CONSTRAINT pk_id_pago PRIMARY KEY(id_pago)             -- Establecimos la llave primaria de la tabla pago
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- [10 / 10] TABLA DESPACHO 
CREATE TABLE IF NOT EXISTS despacho(
id_despacho     int         NOT NULL AUTO_INCREMENT,
id_pago         int         NOT NULL,
id_pedido       int         NOT NULL,
fecha           datetime    NOT NULL,
comentario      text        NULL,
estado_despacho char(2)     NOT NULL,
CONSTRAINT pk_id_despacho PRIMARY KEY(id_despacho)     -- Establecimos la llave primaria de la tabla despacho
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Establecemos las relaciones necesarias entre las tablas a traves del ALTER TABLE agregando la FOREIGN KEY 
--
-- TABLA RESERVA
ALTER TABLE reserva ADD CONSTRAINT fk_reserva_cliente        FOREIGN KEY(id_cliente) REFERENCES cliente(id_cliente);
-- TABLA PRODUCTO
ALTER TABLE producto ADD CONSTRAINT fk_producto_categoria    FOREIGN KEY(id_categoria) REFERENCES categoria(id_categoria);
-- TABLA PEDIDO
ALTER TABLE pedido ADD CONSTRAINT fk_pedido_cliente          FOREIGN KEY(id_cliente) REFERENCES cliente(id_cliente);
ALTER TABLE pedido ADD CONSTRAINT fk_pedido_producto         FOREIGN KEY(id_producto) REFERENCES producto(id_producto);
-- TABLA MESA
ALTER TABLE mesa ADD CONSTRAINT fk_mesa_reserva              FOREIGN KEY(id_reservacion) REFERENCES reserva(id_reservacion);
ALTER TABLE mesa ADD CONSTRAINT fk_mesa_pedido               FOREIGN KEY(id_pedido) REFERENCES pedido(id_pedido);
-- TABLA COMENTARIO
ALTER TABLE comentario ADD CONSTRAINT fk_comentario_cliente  FOREIGN KEY(id_cliente) REFERENCES cliente(id_cliente);
ALTER TABLE comentario ADD CONSTRAINT fk_comentario_pedido   FOREIGN KEY(id_pedido) REFERENCES pedido(id_pedido);
-- TABLA FACTURA
ALTER TABLE factura ADD CONSTRAINT fk_factura_pedido         FOREIGN KEY(id_pedido) REFERENCES pedido(id_pedido);
-- TABLA PAGO
ALTER TABLE pago ADD CONSTRAINT fk_pago_factura              FOREIGN KEY(id_factura) REFERENCES factura(id_factura);
-- TABLA DESPACHO
ALTER TABLE despacho ADD CONSTRAINT fk_despacho_pago         FOREIGN KEY(id_pago) REFERENCES pago(id_pago);
ALTER TABLE despacho ADD CONSTRAINT fk_despacho_pedido       FOREIGN KEY(id_pedido) REFERENCES pedido(id_pedido);

-- 
-- Agregamos datos predeterminados a cada tabla 
-- *** Los datos se agregan para el manejo de datos, en la version final estos datos no se tomaran en cuenta 
--
INSERT INTO cliente VALUES (NULL, 'Estefany Elizabeth', 'Ramírez Nuñez', '00000000-0', 64229837, 1, 'usuario@chilin.com', 'Lourdes colón, la libertad', 'F', 'A');
INSERT INTO categoria VALUES (NULL, 'Pupusas tradicionales', 'A');
INSERT INTO reserva VALUES (NULL, 1, 'A');
INSERT INTO producto VALUES (NULL, 1, 'Frijol con queso', '0', '0', 0.35, 0.50, 0, 'A');
INSERT INTO pedido VALUES (NULL, 1, 1, 1, 4, '0', '0', 'A');
INSERT INTO pedido VALUES (NULL, 1, 1, 1, 7, '0', '0', 'A');
INSERT INTO pedido VALUES (NULL, 2, 1, 1, 1, '0', '0', 'A');
INSERT INTO mesa	VALUES (NULL, 1, 1, 5, '0', '0', '0', 'Comentrio generico', 'A');
INSERT INTO comentario VALUES (NULL, 1, 1, 'B', 'Buen servicio', 'Contecto del comentario, contexto del comentario. Contecto del comentario, contexto del comentario. Contecto del comentario, contexto del comentario. ', '0', 'A');
INSERT INTO factura VALUES (NULL, 1, '0', 10.55, 'I', 'P');
INSERT INTO pago VALUES (NULL, 1, 0, 10.55, 11.00, 0.45, 'C');
INSERT INTO despacho VALUES (NULL, 1, 1, '0', 'Se entrego a tiempo', 'F');

--
-- TRIGGERS 
--
DROP TRIGGER IF EXISTS TR_reserva_validar;
DELIMITER $$
CREATE TRIGGER TR_reserva_validar
BEFORE INSERT ON reserva
FOR EACH ROW
BEGIN

DECLARE cant int default 0;
SET cant = (SELECT COUNT(*) FROM reserva WHERE id_cliente = NEW.id_cliente AND estado_reserva = 'A');

IF cant > 0 THEN
 INSERT INTO reserva VALUES (NULL, NEW.id_cliente, 'A');
END IF;

END$$
DELIMITER ;

--
-- PA 
--
USE chilin_db;

-- Verificamos que el procedimiento exista, si existe que lo elimine e inserte la nueva version
DROP PROCEDURE IF EXISTS insertar_cliente; 
-- Creamos el procedimiento 
CREATE PROCEDURE insertar_cliente
(in nombre_cliente varchar(50),
	in apellido_cliente varchar(50),
	in dui varchar(15),
	in telefono int(8),
	in rol char(2),
 in correo varchar(30),
 in direccion varchar(120),
 in sexo ENUM('M', 'F'),
 in estado_cliente char(2)
)
not deterministic contains sql sql security 
definer
-- Damos la indicacion de que ejecucion DML vamos hacer 
INSERT INTO cliente
VALUES ('NULL', nombre_cliente, apellido_cliente, dui, telefono, rol, correo, direccion, sexo,estado_cliente);

-- Asi lo mandamos a llamar para la insersion de datos
CALL insertar_cliente('Fernando Miguel', 'Cuatro Rivera', '00000000-0', 64229838, 2, 'fernando@chilin.com', 'Lourdes colón, la libertad', 'M', 'A');


