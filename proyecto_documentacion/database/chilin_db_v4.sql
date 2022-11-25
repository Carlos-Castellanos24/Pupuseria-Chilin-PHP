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
pw	  			          varchar(250)	   NOT NULL,
rol               char(2)         NOT NULL,
correo            varchar(30)     NULL,
direccion         varchar(120)    NULL,
nacimiento        date            NOT NULL,
sexo              ENUM('M','F')   NOT NULL,            -- Delimitamos a M o F el dato en el sexo
estado_cliente    ENUM('A','I')   NOT NULL,			         -- Delimitamos a A o I el dato del estado del cliente
CONSTRAINT pk_id_cliente PRIMARY KEY(id_cliente),      -- Establecimos la llave primaria de la tabla cliente
CONSTRAINT uq_telefono_cliente UNIQUE (telefono)       -- El teléfono del cliente sera único para la identificación en la tabla cliente
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- [02 / 10] TABLA CATEGORIA 
CREATE TABLE IF NOT EXISTS categoria(
id_categoria      int          NOT NULL AUTO_INCREMENT,
nombre_categoria  varchar(50)  NOT NULL,
estado_categoria  ENUM('A','I')NOT NULL,               -- Delimitamos a A o I el estado de la categoria
CONSTRAINT pk_id_categoria PRIMARY KEY(id_categoria)   -- Establecimos la llave primaria de la tabla categoria
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- [03 / 10] TABLA RESERVA 
CREATE TABLE IF NOT EXISTS reserva(
id_reservacion     int            NOT NULL AUTO_INCREMENT,
id_cliente         int            NOT NULL,
estado_reserva     ENUM('A','I')  NOT NULL,            -- Delimitamos a A o I el estado de la reservacion hecha por el cliente
CONSTRAINT pk_id_reserva PRIMARY KEY(id_reservacion)   -- Establecimos la llave primaria de la tabla reserva
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- [04 / 10] TABLA PRODUCTO 
CREATE TABLE IF NOT EXISTS producto(
id_producto        int             NOT NULL AUTO_INCREMENT,
id_categoria       int             NOT NULL,
nombre_producto    varchar(50)     NOT NULL,
fecha_ingreso      date            NOT NULL,
fecha_vencimiento  date            NOT NULL,
costo              decimal(6,2)    NOT NULL,
precio             decimal(6,2)    NOT NULL,
stock              int             NOT NULL,
estado_producto    ENUM('A','I')   NOT NULL,           -- Delimitamos a A o I el estado del producto en Stock
CONSTRAINT pk_id_producto PRIMARY KEY(id_producto)     -- Establecimos la llave primaria de la tabla producto
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- [05 / 10] TABLA PEDIDO 
CREATE TABLE IF NOT EXISTS pedido(
id_pedido        int           NOT NULL  AUTO_INCREMENT,
correlativo      int           NOT NULL,
id_cliente       int           NOT NULL,
id_producto      int           NOT NULL,
cantidad         int           NOT NULL,
fecha            date          NOT NULL,
hora             time          NOT NULL,
estado_pedido    ENUM('A','I') NOT NULL,               -- Delimitamos a A o I el estado del pedido
CONSTRAINT pk_id_pedido PRIMARY KEY(id_pedido)         -- Establecimos la llave primaria de la tabla pedido
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- [06 / 10] TABLA MESA 
CREATE TABLE IF NOT EXISTS mesa(
id_mesa          int               NOT NULL AUTO_INCREMENT,
id_reservacion   int               NOT NULL,
id_pedido        int               NOT NULL,
cant_sillas      int               NOT NULL,
fecha            date              NOT NULL,
hora_inicio      time              NOT NULL,
hora_final       time              NOT NULL,
comentario       text              NULL,
estado_mesa      ENUM('D','R','I') NOT NULL,           -- Delimitamos a D, R o I el estado de la reserva (Disponible,Reservado,Inactivo)
CONSTRAINT pk_id_mesa PRIMARY KEY(id_mesa)             -- Establecimos la llave primaria de la tabla mesa
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- [07 / 10] TABLA COMENTARIO 
CREATE TABLE IF NOT EXISTS comentario(
id_comentario         int               NOT NULL AUTO_INCREMENT,
id_cliente            int               NOT NULL,
id_pedido             int               NOT NULL,
tipo_cometario        ENUM('B','R','M') NOT NULL,      -- Delimitamos a D, R o M el tipo de comentario (Bueno,Regular,Malo)
asunto                text              NULL,
comentario            text              NULL,
fecha                 datetime          NULL,
estado_comentario     ENUM('A','I')     NOT NULL,      -- Delimitamos a A o I el estado del comentario
CONSTRAINT pk_id_comentario PRIMARY KEY(id_comentario) -- Establecimos la llave primaria de la tabla comentario
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- [8 / 10] TABLA FACTURA 
CREATE TABLE IF NOT EXISTS factura(
id_factura       int          NOT NULL AUTO_INCREMENT,
id_pedido        int          NOT NULL,
fecha            datetime     NOT NULL,
total_pagar      decimal(6,2) NOT NULL,
tipo_factura  ENUM('E','I')   NOT NULL, -- Delimitamos a E o I el tipo de factura (Electronica,Impresa)
estado_factura ENUM('A','I','P')  NOT NULL, -- Delimitamos a A, I o P el estado de la factura (Activo,Inactivo,Pendiente)
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
estado_pago ENUM('P','C')   NOT NULL, -- Delimitamos a P o C el estado del pago (Pendiente,Cancelado)
CONSTRAINT pk_id_pago PRIMARY KEY(id_pago)             -- Establecimos la llave primaria de la tabla pago
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- [10 / 10] TABLA DESPACHO 
CREATE TABLE IF NOT EXISTS despacho(
id_despacho     int               NOT NULL AUTO_INCREMENT,
id_pago         int               NOT NULL,
id_pedido       int               NOT NULL,
fecha           datetime          NOT NULL,
comentario      text              NULL,
estado_despacho ENUM('A','P','F') NOT NULL, -- Delimitamos a A, P o F el estado del despacho (Activo,Pendiente,Finalizado)
CONSTRAINT pk_id_despacho PRIMARY KEY(id_despacho)     -- Establecimos la llave primaria de la tabla despacho
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

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
INSERT INTO cliente    VALUES (NULL, 'Estefany Elizabeth', 'Ramírez Nuñez', '0', 64229837,'08d4efef87e3a5bef4efc25bc2268498ae3d12699a43b6a54fe13159f6a4cde0f50123280f65c24c6365f43c3aad09c441b95664c41ddf90e729404481221db0', 1, 'usuario@chilin.com', 'Lourdes colón, la libertad','0','F', 'A');
INSERT INTO categoria  VALUES (NULL, 'Pupusas tradicionales', 'A');
INSERT INTO reserva    VALUES (NULL, 1, 'A');
INSERT INTO producto   VALUES (NULL, 1, 'Frijol con queso', '2021-12-02', '2022-10-01', 0.35, 0.50, 0, 'A');
INSERT INTO pedido     VALUES (NULL, 1, 1, 1, 4, '2021-12-02', '0', 'A');
INSERT INTO pedido     VALUES (NULL, 1, 1, 1, 7, '2021-12-02', '0', 'A');
INSERT INTO pedido     VALUES (NULL, 2, 1, 1, 1, '2021-12-02', '0', 'A');
INSERT INTO mesa	   VALUES (NULL, 1, 1, 5, '2021-12-02', '0', '0', 'Comentrio generico', 'A');
INSERT INTO comentario VALUES (NULL, 1, 1, 'B', 'Buen servicio', 'Contecto del comentario, contexto del comentario. Contecto del comentario, contexto del comentario. Contecto del comentario, contexto del comentario. ', '2021-12-02', 'A');
INSERT INTO factura    VALUES (NULL, 1, '2021-12-02', 10.55, 'I', 'P');
INSERT INTO pago       VALUES (NULL, 1, 0, 10.55, 11.00, 0.45, 'C');
INSERT INTO despacho   VALUES (NULL, 1, 1, '2021-12-02', 'Se entrego a tiempo', 'F');

-- PA
-- TABLA CLIENTE
-- ====================================================================
-- PROCEDIMIENTO ALAMACENADO PARA AGREGAR REGISTROS A LA TABLA CLIENTE.
USE chilin_db;
DROP PROCEDURE IF EXISTS agregar_cliente; 
CREATE PROCEDURE agregar_cliente(
in nombre_cliente varchar(50),
in apellido_cliente varchar(50),
in dui varchar(15),
in telefono int(8),
in pw	varchar(250),
in rol char(2),
in correo varchar(30),
in direccion varchar(120),
in nacimiento date,
in sexo ENUM('M', 'F'),
in estado_cliente ENUM('A','I')
)
NOT DETERMINISTIC CONTAINS SQL SQL SECURITY
DEFINER
INSERT INTO cliente
VALUES ('NULL', nombre_cliente, apellido_cliente, dui, telefono, pw, rol, correo, direccion, nacimiento, sexo, estado_cliente);

-- CREAR PROCEDIMIENTO ALAMACENADO PARA ACTUALIZAR REGISTROS A LA TABLA CLIENTE.
USE chilin_db;
DROP PROCEDURE IF EXISTS actualizar_cliente;
CREATE PROCEDURE actualizar_cliente(
in id_cliente2 int,
in nombre_cliente2 varchar(50),
in apellido_cliente2 varchar(50),
in dui2 varchar(15),
in telefono2 int(8),
in rol2 char(2),
in correo2 varchar(30),
in direccion2 varchar(120),
in nacimiento2 date,
in sexo2 ENUM('M', 'F'),
in estado_cliente2 ENUM('A','I')
)
NOT DETERMINISTIC CONTAINS SQL SQL SECURITY
DEFINER
UPDATE cliente SET nombre_cliente= nombre_cliente2, apellido_cliente= apellido_cliente2, dui= dui2, telefono= telefono2, rol= rol2, correo= correo2, direccion= direccion2, nacimiento=nacimiento2, sexo= sexo2, estado_cliente= estado_cliente2 WHERE id_cliente= id_cliente2;

-- CREAR SEGUNDO PROCEDIMIENTO ALAMACENADO PARA ACTUALIZAR REGISTROS A LA TABLA CLIENTE.
USE chilin_db;
DROP PROCEDURE IF EXISTS actualizar_cliente2;
CREATE PROCEDURE actualizar_cliente2(
in id_cliente3 int,
in apellido_cliente3 varchar(50),
in dui3 varchar(15),
in correo3 varchar(30),
in direccion3 varchar(120),
in nacimiento3 date,
in sexo3 ENUM('M','F')
)NOT DETERMINISTIC CONTAINS SQL SQL SECURITY
DEFINER
UPDATE cliente SET apellido_cliente = apellido_cliente3, dui = dui3, correo = correo3, direccion = direccion3, nacimiento=nacimiento3, sexo = sexo3 WHERE id_cliente = id_cliente3;

-- CREAR PROCEDIMIENTO ALMACENADO PARA ELIMINAR REGISTROS EN LA TABLA CLIENTE.
USE chilin_db;
DROP PROCEDURE IF EXISTS eliminar_cliente;
CREATE PROCEDURE eliminar_cliente(
in id_cliente1 int
)
NOT DETERMINISTIC CONTAINS SQL SQL SECURITY 
DEFINER DELETE FROM cliente WHERE id_cliente = id_cliente1;

-- CREAR PROCEDIMIENTO ALMACENADO PARA BUSCAR REGISTROS EN LA TABLA CLIENTE.
USE chilin_db;
DROP PROCEDURE IF EXISTS buscar_cliente;
CREATE PROCEDURE buscar_cliente(
in id_cliente1 int
)NOT DETERMINISTIC CONTAINS SQL SQL SECURITY 
DEFINER SELECT * FROM cliente WHERE id_cliente = id_cliente1;


-- CREAR PROCEDIMIENTO ALMACENADO PARA BUSCAR REGISTROS EN EL LOGIN.
USE chilin_db;
DROP PROCEDURE IF EXISTS login_cliente;
CREATE PROCEDURE login_cliente(
in telefono1 int(8),
in pw1 varchar(250)
)NOT DETERMINISTIC CONTAINS SQL SQL SECURITY 
DEFINER SELECT * FROM cliente WHERE telefono = telefono1 and pw = pw1;


-- CREAR PROCEDIMIENTO ALMACENADO PARA BUSCAR EL TELEFONO DEL CLIENTE.
USE chilin_db;
DROP PROCEDURE IF EXISTS buscar_telefono_cliente;
CREATE PROCEDURE buscar_telefono_cliente(
in telefono1 int(8)
)NOT DETERMINISTIC CONTAINS SQL SQL SECURITY 
DEFINER SELECT * FROM cliente WHERE telefono = telefono1;


-- PA
-- TABLA CATEGORIA
-- ====================================================================
-- PROCEDIMIENTO ALAMACENADO PARA AGREGAR REGISTROS A LA TABLA CATEGORIA.
use chilin_db;
drop procedure if exists agregar_categoria;
create procedure agregar_categoria(
in nombre_categoria varchar(50),
in estado_categoria ENUM('A','I')
)
NOT DETERMINISTIC CONTAINS SQL SQL SECURITY
DEFINER
insert into categoria
values ('NULL',nombre_categoria,estado_categoria);

-- CREAR PROCEDIMIENTO ALAMACENADO PARA ACTUALIZAR REGISTROS A LA TABLA CATEGORIA.
USE chilin_db;
DROP PROCEDURE IF EXISTS actualizar_categoria;
CREATE PROCEDURE actualizar_categoria(
in id_categoria2     int,
in nombre_categoria2  varchar(50),
in estado_categoria2  ENUM('A','I')
)
NOT DETERMINISTIC CONTAINS SQL SQL SECURITY
DEFINER
UPDATE categoria SET nombre_categoria = nombre_categoria2, estado_categoria = estado_categoria2 WHERE id_categoria= id_categoria2;

-- CREAR PROCEDIMIENTO ALMACENADO PARA ELIMINAR REGISTROS EN LA TABLA CATEGORIA.
USE chilin_db;
DROP PROCEDURE IF EXISTS eliminar_categoria;
CREATE PROCEDURE eliminar_categoria(
in id_categoria1 int
)
NOT DETERMINISTIC CONTAINS SQL SQL SECURITY 
DEFINER DELETE FROM categoria WHERE id_categoria = id_categoria1;


-- CREAR PROCEDIMIENTO ALMACENADO PARA BUSCAR REGISTROS EN LA TABLA CATEGORIA.
USE chilin_db;
DROP PROCEDURE IF EXISTS buscar_categoria;
CREATE PROCEDURE buscar_categoria(
in id_categoria1 int
)NOT DETERMINISTIC CONTAINS SQL SQL SECURITY 
DEFINER SELECT * FROM categoria WHERE id_categoria = id_categoria1;

-- PA
-- TABLA RESERVA
-- ====================================================================
-- CREAR PROCEDIMIENTO ALMACENADO PARA AGREGAR REGISTROS A LA TABLA RESERVA.
USE chilin_db;
DROP PROCEDURE IF EXISTS agregar_reserva;
CREATE PROCEDURE agregar_reserva(
IN id_cliente int,
IN estado_reserva ENUM('A','I')
)
NOT DETERMINISTIC CONTAINS SQL SQL SECURITY
DEFINER
INSERT INTO reserva
VALUES ('null',id_cliente,estado_reserva);

-- CREAR PROCEDIMIENTO ALMACENADO PARA ACTUALIZAR REGISTROS A LA TABLA RESERVA.
USE chilin_db;
DROP PROCEDURE IF EXISTS actualizar_reserva;
CREATE PROCEDURE actualizar_reserva(
IN id_reservacion2 int,
IN id_cliente2 int,
IN estado_reserva2 ENUM('A','I')
)
NOT DETERMINISTIC CONTAINS SQL SQL SECURITY
definer
UPDATE reserva SET id_reservacion = id_reservacion2, id_cliente = id_cliente2, estado_reserva = estado_reserva2 WHERE id_reservacion = id_reservacion2;

-- CREAR PROCEDIMIENTO ALMACENADO PARA ELIMINAR REGISTROS EN LA TABLA RESERVA.
USE chilin_db;
DROP PROCEDURE IF EXISTS eliminar_reserva;
CREATE PROCEDURE eliminar_reserva(
IN id_reservacion1 int
)
NOT DETERMINISTIC CONTAINS SQL SQL SECURITY
DEFINER
DELETE FROM reserva where id_reservacion = id_reservacion1;

-- CREAR PROCEDIMIENTO ALMACENADO PARA BUSCAR REGISTROS EN LA TABLA RESERVA.
USE chilin_db;
DROP PROCEDURE IF EXISTS buscar_reserva;
CREATE PROCEDURE buscar_reserva(
in id_reservacion1 int
)NOT DETERMINISTIC CONTAINS SQL SQL SECURITY 
DEFINER SELECT * FROM reserva WHERE id_reservacion = id_reservacion1;

-- PA
-- TABLA PRODUCTO
-- ====================================================================
-- CREAR PROCEDIMIENTO ALMACENADO PARA AGREGAR REGISTROS A LA TABLA PRODUCTO.
USE chilin_db;
DROP PROCEDURE IF EXISTS agregar_producto;
CREATE PROCEDURE agregar_producto(
IN id_categoria int,
IN nombre_producto varchar(50),
IN fecha_ingreso date,
IN fecha_vencimiento date,
IN costo decimal(6,2),
IN precio decimal(6,2),
IN stock int,
IN estado_producto ENUM('A','I')
)
NOT DETERMINISTIC CONTAINS SQL SQL SECURITY
DEFINER
INSERT INTO producto
values ('NULL',id_categoria,nombre_producto,fecha_ingreso,fecha_vencimiento,
costo,precio,stock,estado_producto);

-- CREAR PROCEDIMIENTO ALMACENADO PARA ACTUALIZAR REGISTROS A LA TABLA PRODUCTO.
USE chilin_db;
DROP PROCEDURE IF EXISTS actualizar_producto;
CREATE PROCEDURE actualizar_producto(
IN id_producto2 int,
IN id_categoria2 int,
IN nombre_producto2 varchar(50),
IN fecha_ingreso2 date,
IN fecha_vencimiento2 date,
IN costo2 decimal(6,2),
IN precio2 decimal(6,2),
IN stock2 int,
IN estado_producto2 ENUM('A','I')
)
NOT DETERMINISTIC CONTAINS SQL SQL SECURITY
DEFINER
UPDATE producto SET id_categoria = id_categoria2, nombre_producto = nombre_producto2, 
fecha_ingreso = fecha_ingreso2,fecha_vencimiento = fecha_vencimiento2, costo = costo2,
 precio=precio2, stock = stock2, estado_producto = estado_producto2
WHERE id_producto=id_producto2;

-- CREAR PROCEDIMIENTO ALMACENADO PARA ELIMINAR REGISTROS EN LA TABLA PRODUCTO.
USE chilin_db;
DROP PROCEDURE IF EXISTS eliminar_producto;
CREATE PROCEDURE eliminar_producto(
IN id_producto1 int
)
NOT DETERMINISTIC CONTAINS SQL SQL SECURITY
DEFINER
DELETE FROM producto WHERE id_producto=id_producto1;

-- CREAR PROCEDIMIENTO ALMACENADO PARA BUSCAR REGISTROS EN LA TABLA PRODUCTO.
USE chilin_db;
DROP PROCEDURE IF EXISTS buscar_producto;
CREATE PROCEDURE buscar_producto(
in id_producto1 int
)NOT DETERMINISTIC CONTAINS SQL SQL SECURITY 
DEFINER SELECT * FROM producto WHERE id_producto = id_producto1;

-- PA
-- TABLA PEDIDO
-- ====================================================================
-- CREAR PROCEDIMIENTO ALMACENADO PARA AGREGAR REGISTROS A LA TABLA PEDIDO
USE chilin_db;
DROP PROCEDURE IF EXISTS agregar_pedido;
CREATE PROCEDURE agregar_pedido(
in correlativo  int, 
in id_cliente   int,
in id_producto  int,
in cantidad     int,
in fecha        date,
in hora         time, 
in estado_pedido ENUM('A','I')
)
NOT DETERMINISTIC CONTAINS SQL SQL SECURITY
DEFINER
INSERT INTO pedido
values ('NULL',correlativo, id_cliente,id_producto,cantidad,fecha,hora,estado_pedido);

-- CREAR PROCEDIMIENTO ALAMACENADO PARA ACTUALIZAR REGISTROS A LA TABLA PEDIDO.
USE chilin_db;
DROP PROCEDURE IF EXISTS actualizar_pedido;
CREATE PROCEDURE actualizar_pedido(
in id_pedido2    int,
in correlativo2  int, 
in id_cliente2   int,
in id_producto2  int,
in cantidad2     int,
in fecha2        date,
in hora2         time, 
in estado_pedido2 ENUM('A','I')
)
NOT DETERMINISTIC CONTAINS SQL SQL SECURITY
DEFINER
UPDATE pedido SET correlativo = correlativo2, id_cliente = id_cliente2, id_producto = id_producto2, cantidad = cantidad2, fecha = fecha2, hora = hora2, estado_pedido = estado_pedido2 WHERE id_pedido = id_pedido2;

-- CREAR PROCEDIMIENTO ALMACENADO PARA ELIMINAR REGISTROS DE LA TABLA PEDIDO.
USE chilin_db;
DROP PROCEDURE IF EXISTS eliminar_pedido;
CREATE PROCEDURE eliminar_pedido(
in id_pedido1 int
)
NOT DETERMINISTIC CONTAINS SQL SQL SECURITY
DEFINER DELETE FROM pedido WHERE id_pedido = id_pedido1;

-- CREAR PROCEDIMIENTO ALMACENADO PARA BUSCAR REGISTROS EN LA TABLA PEDIDO.
USE chilin_db;
DROP PROCEDURE IF EXISTS buscar_pedido;
CREATE PROCEDURE buscar_pedido(
in id_pedido1 int
)NOT DETERMINISTIC CONTAINS SQL SQL SECURITY 
DEFINER SELECT * FROM pedido WHERE id_pedido = id_pedido1;

-- PA
-- TABLA MESA
-- ====================================================================
-- CREAR PROCEDIMIENTO ALMACENADO PARA AGREGAR REGISTROS A LA TABLA MESA.
USE chilin_db;
DROP PROCEDURE IF EXISTS agregar_mesa;
CREATE PROCEDURE agregar_mesa(
in id_reservacion   int ,
in id_pedido        int ,
in cant_sillas      int ,
in fecha            date,
in hora_inicio      time,
in hora_final       time,
in comentario       text,
in estado_mesa      ENUM('D','R','I')
)
NOT DETERMINISTIC CONTAINS SQL SQL SECURITY
DEFINER
INSERT INTO mesa
values ('NULL',id_reservacion,id_pedido,cant_sillas,fecha,hora_inicio,hora_final,comentario,estado_mesa);

-- CREAR PROCEDIMIENTO ALAMACENADO PARA ACTUALIZAR REGISTROS A LA TABLA MESA.
USE chilin_db;
DROP PROCEDURE IF EXISTS actualizar_mesa;
CREATE PROCEDURE actualizar_mesa(
in id_mesa2          int, 
in id_reservacion2   int,
in id_pedido2        int,
in cant_sillas2      int,
in fecha2            date,
in hora_inicio2      time,
in hora_final2       time,
in comentario2       text,
in estado_mesa2      ENUM('D','R','I')
)
NOT DETERMINISTIC CONTAINS SQL SQL SECURITY
DEFINER
UPDATE mesa SET id_reservacion = id_reservacion2, id_pedido = id_pedido2, cant_sillas = cant_sillas2, fecha = fecha2, hora_inicio = hora_inicio2, hora_final = hora_final2, comentario = comentario2, estado_mesa = estado_mesa WHERE id_mesa = id_mesa2;

-- CREAR PROCEDIMIENTO ALMACENADO PARA ELIMINAR REGISTROS DE LA TABLA MESA.
USE chilin_db;
DROP PROCEDURE IF EXISTS eliminar_mesa;
CREATE PROCEDURE eliminar_mesa(
in id_mesa1 int
)
NOT DETERMINISTIC CONTAINS SQL SQL SECURITY
DEFINER DELETE FROM mesa WHERE id_mesa = id_mesa1;

-- CREAR PROCEDIMIENTO ALMACENADO PARA BUSCAR REGISTROS EN LA TABLA MESA.
USE chilin_db;
DROP PROCEDURE IF EXISTS buscar_mesa;
CREATE PROCEDURE buscar_mesa(
in id_mesa1 int
)NOT DETERMINISTIC CONTAINS SQL SQL SECURITY 
DEFINER SELECT * FROM mesa WHERE id_mesa = id_mesa1;

-- PA
-- TABLA COMENTARIO
-- ====================================================================
-- CREAR PROCEDIMIENTO ALMACENADO PARA AGREGAR REGISTROS A LA TABLA COMENTARIO
USE chilin_db;
DROP PROCEDURE IF EXISTS agregar_comentario;
CREATE PROCEDURE agregar_comentario
(in id_cliente int ,
 in id_pedido int,
 in tipo_comentario ENUM('B','R','M'),
 in asunto text,
 in comentario text,
 in fecha datetime,
 in estado_comentario ENUM('A','I')
 )
NOT DETERMINISTIC CONTAINS SQL SQL SECURITY DEFINER
INSERT INTO comentario
VALUES('NULL', id_cliente,id_pedido,tipo_comentario,asunto,comentario,fecha,estado_comentario);

-- CREAR PROCEDIMIENTO ALMACENADO PARA ACTUALIZAR REGISTROS A LA TABLA COMENTARIO.
USE chilin_db;
DROP PROCEDURE IF EXISTS actualizar_comentario;
CREATE PROCEDURE actualizar_comentario(
in id_comentario2  int,
in id_cliente2  int, 
in id_pedido2 int ,
in tipo_comentario2 ENUM('B','R','M'),
in asunto2 text,
in comentario2 text,
in fecha2 datetime,
in estado_comentario2 ENUM('A','I')  
)
NOT DETERMINISTIC CONTAINS SQL SQL SECURITY
DEFINER
UPDATE comentario SET id_cliente = id_cliente2 ,id_pedido = id_pedido2, tipo_comentario = tipo_comentario2,asunto= asunto2, comentario = comentario2,fecha=fecha2,estado_comentario=estado_comentario2 WHERE id_comentario = id_comentario2;

-- CREAR PROCEDIMIENTO ALMACENADO PARA ELIMINAR REGISTROS DE LA TABLA COMENTARIO.
USE chilin_db;
DROP PROCEDURE IF EXISTS eliminar_comentario;

CREATE PROCEDURE eliminar_comentario(
in id_comentario1 int
)
NOT DETERMINISTIC CONTAINS SQL SQL SECURITY 
DEFINER DELETE FROM comentario WHERE id_comentario = id_comentario1;


-- CREAR PROCEDIMIENTO ALMACENADO PARA BUSCAR REGISTROS EN LA TABLA COMENTARIO.
USE chilin_db;
DROP PROCEDURE IF EXISTS buscar_comentario;
CREATE PROCEDURE buscar_comentario(
in id_comentario1 int
)NOT DETERMINISTIC CONTAINS SQL SQL SECURITY 
DEFINER SELECT * FROM comentario WHERE id_comentario = id_comentario1;

-- PA
-- TABLA FACTURA
-- ====================================================================
-- CREAR PROCEDIMIENTO ALMACENADO PARA AGREGAR REGISTROS A LA TABLA FACTURA
USE chilin_db;
DROP PROCEDURE IF EXISTS agregar_factura;
CREATE PROCEDURE agregar_factura(
in id_pedido int,
in fecha datetime,
in total_pagar decimal(6,2),
in tipo_factura ENUM('E','I'),
in estado_factura ENUM('A','I','P')
)
NOT DETERMINISTIC CONTAINS SQL SQL SECURITY
DEFINER
INSERT INTO factura
VALUES('NULL',id_pedido,fecha,total_pagar,tipo_factura,estado_factura);

-- CREAR PROCEDIMIENTO ALMACENADO PARA ACTUALIZAR REGISTROS A LA TABLA FACTURA. 
USE chilin_db;
DROP PROCEDURE IF EXISTS actualizar_factura;
CREATE PROCEDURE actualizar_factura(
in id_factura2    int,
in id_pedido2  int, 
in fecha2 datetime ,
in total_pagar2 decimal(6,2),
in tipo_factura2 ENUM('E','I'),
in estado_factura2 ENUM('A','I','P')
)
NOT DETERMINISTIC CONTAINS SQL SQL SECURITY
DEFINER
UPDATE factura SET id_pedido = id_pedido2, fecha = fecha2, total_pagar = total_pagar2, tipo_factura = tipo_factura2, estado_factura = estado_factura2 WHERE id_factura = id_factura2;

-- CREAR PROCEDIMIENTO ALMACENADO PARA ELIMINAR REGISTROS DE LA TABLA FACTURA.
USE chilin_db;
DROP PROCEDURE IF EXISTS eliminar_factura;
CREATE PROCEDURE eliminar_factura(
in id_factura1 int
)
NOT DETERMINISTIC CONTAINS SQL SQL SECURITY 
DEFINER DELETE FROM factura WHERE id_factura = id_factura1;

-- CREAR PROCEDIMIENTO ALMACENADO PARA BUSCAR REGISTROS EN LA TABLA FACTURA.
USE chilin_db;
DROP PROCEDURE IF EXISTS buscar_factura;
CREATE PROCEDURE buscar_factura(
in id_factura1 int
)NOT DETERMINISTIC CONTAINS SQL SQL SECURITY 
DEFINER SELECT * FROM factura WHERE id_factura = id_factura1;

-- PA
-- TABLA PAGO
-- ====================================================================
-- CREAR PROCEDIMIENTO ALMACENADO PARA AGREGAR REGISTROS A LA TABLA PAGO.
USE chilin_db;
DROP PROCEDURE IF EXISTS agregar_pago;
CREATE PROCEDURE agregar_pago(
in id_factura     int,
in fecha          datetime,
in total_pagar    decimal(6,2),
in pago_cliente   decimal(6,2),
in vuelto         decimal(6,2),
in estado_pago    ENUM('P','C') 
)
NOT DETERMINISTIC CONTAINS SQL SQL SECURITY
DEFINER
insert into pago
values ('NULL',id_factura,fecha,total_pagar,pago_cliente,vuelto,estado_pago);


-- CREAR PROCEDIMIENTO ALMACENADO PARA ACTUALIZAR REGISTROS DE LA TABLA PAGO.
USE chilin_db;
DROP PROCEDURE IF EXISTS actualizar_pago;
CREATE PROCEDURE actualizar_pago(
in id_pago2        int,
in id_factura2     int,
in fecha2          datetime,
in total_pagar2    decimal(6,2),
in pago_cliente2   decimal(6,2),
in vuelto2         decimal(6,2),
in estado_pago2    ENUM('P','C') 
)
NOT DETERMINISTIC CONTAINS SQL SQL SECURITY
DEFINER
UPDATE pago SET id_factura = id_factura2, fecha = fecha2, total_pagar = total_pagar2, pago_cliente=pago_cliente2,vuelto=vuelto2,estado_pago=estado_pago2 WHERE id_pago = id_pago2;

-- CREAR PROCEDIMIENTO ALAMACENADO PARA ELIMINAR REGISTROS DE LA TABLA PAGO.
USE chilin_db;
DROP PROCEDURE IF EXISTS eliminar_pago;
CREATE PROCEDURE eliminar_pago(
in id_pago1 int
)
NOT DETERMINISTIC CONTAINS SQL SQL SECURITY 
DEFINER
 DELETE FROM pago WHERE id_pago = id_pago1;

-- CREAR PROCEDIMIENTO ALMACENADO PARA BUSCAR REGISTROS EN LA TABLA PAGO.
 USE chilin_db;
DROP PROCEDURE IF EXISTS buscar_pago;
CREATE PROCEDURE buscar_pago(
in id_pago1 int
)NOT DETERMINISTIC CONTAINS SQL SQL SECURITY 
DEFINER SELECT * FROM pago WHERE id_pago = id_pago1;

-- PA
-- TABLA DESPACHO
-- ====================================================================
-- CREAR PROCEDIMIENTO ALMACENADO PARA AGREGAR REGISTROS A LA TABLA DESPACHO.
USE chilin_db;
DROP PROCEDURE IF EXISTS agregar_despacho;
CREATE PROCEDURE agregar_despacho(
in id_pago         int,
in id_pedido       int,
in fecha           datetime,
in comentario      text,
in estado_despacho ENUM('A','P','F')
)
NOT DETERMINISTIC CONTAINS SQL SQL SECURITY
DEFINER
INSERT INTO despacho
VALUES ('NULL',id_pago,id_pedido,fecha,comentario,estado_despacho);

-- CREAR PROCEDIMIENTO ALAMACENADO PARA ACTUALIZAR REGISTROS A LA TABLA DESPACHO.
USE chilin_db;
DROP PROCEDURE IF EXISTS actualizar_despacho;
CREATE PROCEDURE actualizar_despacho(
in id_despacho2		int,
in id_pago2         int,
in id_pedido2       int,
in fecha2      datetime,
in comentario2      text,
in estado_despacho2 ENUM('A','P','F')
)
NOT DETERMINISTIC CONTAINS SQL SQL SECURITY
DEFINER
UPDATE despacho SET id_pago=id_pago2,id_pedido=id_pedido2,fecha=fecha2,comentario=comentario2,estado_despacho=estado_despacho2 WHERE id_despacho=id_despacho2;

-- CREAR PROCEDIMIENTO ALAMACENADO PARA ELIMINAR REGISTROS DE LA TABLA DESPACHO.
USE chilin_db;
DROP PROCEDURE IF EXISTS eliminar_despacho;
CREATE PROCEDURE eliminar_despacho(
in id_despacho1 int
)
NOT DETERMINISTIC CONTAINS SQL SQL SECURITY 
DEFINER
 DELETE FROM despacho WHERE id_despacho = id_despacho1;

-- CREAR PROCEDIMIENTO ALMACENADO PARA BUSCAR REGISTROS EN LA TABLA DESPACHO.
USE chilin_db;
DROP PROCEDURE IF EXISTS buscar_despacho;
CREATE PROCEDURE buscar_despacho(
in id_despacho1 int
)NOT DETERMINISTIC CONTAINS SQL SQL SECURITY 
DEFINER SELECT * FROM despacho WHERE id_despacho = id_despacho1;

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

