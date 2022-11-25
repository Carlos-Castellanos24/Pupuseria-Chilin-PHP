DROP DATABASE IF EXISTS chilin_db;
CREATE DATABASE chilin_db;
USE chilin_db;

-- [01 / 08] TABLA CLIENTE 
CREATE TABLE IF NOT EXISTS cliente(
id_cliente        int             NOT NULL  AUTO_INCREMENT,
nombre_cliente    varchar(50)     NOT NULL,
apellido_cliente  varchar(50)     NOT NULL,
dui               varchar(15)     NOT NULL,
telefono          int(8)          NOT NULL,
nacimiento        date            NOT NULL,
correo            varchar(30)     NULL,
direccion         varchar(120)    NULL,
pw	  			          varchar(250)	   NOT NULL,
sexo              ENUM('M','F')   NOT NULL,            -- Delimitamos a M o F el dato en el sexo
estado_cliente    ENUM('A','I')   NOT NULL,			         -- Delimitamos a A o I el dato del estado del cliente
CONSTRAINT pk_id_cliente PRIMARY KEY(id_cliente),      -- Establecimos la llave primaria de la tabla cliente
CONSTRAINT uq_telefono_cliente UNIQUE (telefono)       -- El teléfono del cliente sera único para la identificación en la tabla cliente
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- [02 / 08] TABLA CATEGORIA 
CREATE TABLE IF NOT EXISTS categoria(
id_categoria      int          NOT NULL AUTO_INCREMENT,
nombre_categoria  varchar(50)  NOT NULL,
estado_categoria  ENUM('A','I')NOT NULL,               -- Delimitamos a A o I el estado de la categoria
CONSTRAINT pk_id_categoria PRIMARY KEY(id_categoria)   -- Establecimos la llave primaria de la tabla categoria
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- [03 / 08] TABLA PRODUCTO 
CREATE TABLE IF NOT EXISTS producto(
id_producto        int             NOT NULL AUTO_INCREMENT,
id_categoria       int             NOT NULL,
nombre_producto    varchar(50)     NOT NULL,
fecha_ingreso      date            NOT NULL,
fecha_vencimiento  date            NOT NULL,
costo              decimal(6,2)    NOT NULL,
precio             decimal(6,2)    NOT NULL,
foto               varchar(150)    NOT NULL,
estado_producto    ENUM('A','I')   NOT NULL,           -- Delimitamos a A o I el estado del producto en Stock
CONSTRAINT pk_id_producto PRIMARY KEY(id_producto)     -- Establecimos la llave primaria de la tabla producto
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- [04 / 08] TABLA PEDIDO 
CREATE TABLE IF NOT EXISTS pedido(
id_pedido        int           NOT NULL  AUTO_INCREMENT,
correlativo      int           NOT NULL,
id_cliente       int           NOT NULL,
id_producto      int           NOT NULL,
cantidad         int           NOT NULL,
estado_pedido    ENUM('A','I') NOT NULL,               -- Delimitamos a A o I el estado del pedido
CONSTRAINT pk_id_pedido PRIMARY KEY(id_pedido)         -- Establecimos la llave primaria de la tabla pedido
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- [05 / 08] TABLA COMENTARIO 
CREATE TABLE IF NOT EXISTS comentario(
id_comentario         int               NOT NULL AUTO_INCREMENT,
id_cliente            int               NOT NULL,
tipo_cometario        ENUM('B','R','M') NOT NULL,      -- Delimitamos a D, R o M el tipo de comentario (Bueno,Regular,Malo)
asunto                text              NULL,
comentario            text              NULL,
fecha                 datetime          NULL,
estado_comentario     ENUM('A','I')     NOT NULL,      -- Delimitamos a A o I el estado del comentario
CONSTRAINT pk_id_comentario PRIMARY KEY(id_comentario) -- Establecimos la llave primaria de la tabla comentario
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- [06 / 08] TABLA FACTURA 
CREATE TABLE IF NOT EXISTS factura(
id_factura       int                NOT NULL AUTO_INCREMENT,
id_pedido        int                NOT NULL,
correlativo      int                NOT NULL,
fecha            date               NOT NULL,
hora             time               NOT NULL,
total_pagar      decimal(6,2)       NOT NULL,
tipo_factura     ENUM('E','I')      NOT NULL,           -- Delimitamos a E o I el tipo de factura (Electronica,Impresa)
estado_factura   ENUM('A','I','P')  NOT NULL,           -- Delimitamos a A, I o P el estado de la factura (Activo,Inactivo,Pendiente)
CONSTRAINT pk_id_factura PRIMARY KEY(id_factura)        -- Establecimos la llave primaria de la tabla factura
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- [07 / 08] TABLA PAGO 
CREATE TABLE IF NOT EXISTS pago(
id_pago        int          NOT NULL AUTO_INCREMENT,
id_factura     int          NOT NULL,
fecha          datetime     NOT NULL,
pago_cliente   decimal(6,2) NOT NULL,
vuelto         decimal(6,2) NOT NULL,
estado_pago ENUM('P','C')   NOT NULL,                  -- Delimitamos a P o C el estado del pago (Pendiente,Cancelado)
CONSTRAINT pk_id_pago PRIMARY KEY(id_pago)             -- Establecimos la llave primaria de la tabla pago
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- [08 / 08] TABLA DESPACHO 
CREATE TABLE IF NOT EXISTS despacho(
id_despacho     int               NOT NULL AUTO_INCREMENT,
id_pago         int               NOT NULL,
id_pedido       int               NOT NULL,
fecha           datetime          NOT NULL,
comentario      text              NULL,
estado_despacho ENUM('A','P','F') NOT NULL,            -- Delimitamos a A, P o F el estado del despacho (Activo,Pendiente,Finalizado)
CONSTRAINT pk_id_despacho PRIMARY KEY(id_despacho)     -- Establecimos la llave primaria de la tabla despacho
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- Establecemos las relaciones necesarias entre las tablas a traves del ALTER TABLE agregando la FOREIGN KEY 
--
-- TABLA PRODUCTO
ALTER TABLE producto ADD CONSTRAINT fk_producto_categoria    FOREIGN KEY(id_categoria) REFERENCES categoria(id_categoria);
-- TABLA PEDIDO
ALTER TABLE pedido ADD CONSTRAINT fk_pedido_cliente          FOREIGN KEY(id_cliente) REFERENCES cliente(id_cliente);
ALTER TABLE pedido ADD CONSTRAINT fk_pedido_producto         FOREIGN KEY(id_producto) REFERENCES producto(id_producto);
-- TABLA COMENTARIO
ALTER TABLE comentario ADD CONSTRAINT fk_comentario_cliente  FOREIGN KEY(id_cliente) REFERENCES cliente(id_cliente);
-- TABLA FACTURA
ALTER TABLE factura ADD CONSTRAINT fk_factura_pedido         FOREIGN KEY(id_pedido) REFERENCES pedido(id_pedido);
-- TABLA PAGO
ALTER TABLE pago ADD CONSTRAINT fk_pago_factura              FOREIGN KEY(id_factura) REFERENCES factura(id_factura);
-- TABLA DESPACHO
ALTER TABLE despacho ADD CONSTRAINT fk_despacho_pago         FOREIGN KEY(id_pago) REFERENCES pago(id_pago);
ALTER TABLE despacho ADD CONSTRAINT fk_despacho_pedido       FOREIGN KEY(id_pedido) REFERENCES pedido(id_pedido);

-- Procedimientos Almacenados

-- ====================================================================
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
in nacimiento date,
in correo varchar(30),
in direccion varchar(120),
in pw	varchar(250),
in sexo ENUM('M', 'F'),
in estado_cliente ENUM('A','I')
)
NOT DETERMINISTIC CONTAINS SQL SQL SECURITY
DEFINER
INSERT INTO cliente
VALUES ('NULL', nombre_cliente, apellido_cliente, dui, telefono, nacimiento, correo, direccion, pw, sexo, estado_cliente);

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

-- ====================================================================
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
in estado_categoria2  ENUM('A','I')
)
NOT DETERMINISTIC CONTAINS SQL SQL SECURITY
DEFINER
UPDATE categoria SET estado_categoria = estado_categoria2 WHERE id_categoria= id_categoria2;

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

-- ====================================================================
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
IN foto varchar(150),
IN estado_producto ENUM('A','I')
)
NOT DETERMINISTIC CONTAINS SQL SQL SECURITY
DEFINER
INSERT INTO producto
values ('NULL',id_categoria,nombre_producto,fecha_ingreso,fecha_vencimiento,costo,precio,foto,estado_producto);

-- CREAR PROCEDIMIENTO ALMACENADO PARA ACTUALIZAR REGISTROS A LA TABLA PRODUCTO.
USE chilin_db;
DROP PROCEDURE IF EXISTS actualizar_producto;
CREATE PROCEDURE actualizar_producto(
IN nombre_producto2 varchar(50),
IN fecha_ingreso2 date,
IN fecha_vencimiento2 date,
IN costo2 decimal(6,2),
IN precio2 decimal(6,2),
IN estado_producto2 ENUM('A','I'),
IN id_producto2 int
)
NOT DETERMINISTIC CONTAINS SQL SQL SECURITY
DEFINER
UPDATE producto SET 
nombre_producto=nombre_producto2,
fecha_ingreso=fecha_ingreso2,
fecha_vencimiento=fecha_vencimiento2,
costo=costo2,
precio=precio2,
estado_producto=estado_producto2 
WHERE id_producto=id_producto2;

-- CREAR PROCEDIMIENTO ALMACENADO PARA ELIMINAR REGISTROS EN LA TABLA PRODUCTO.
USE chilin_db;
DROP PROCEDURE IF EXISTS eliminar_producto;
CREATE PROCEDURE eliminar_producto(
IN id_producto1 int
)
NOT DETERMINISTIC CONTAINS SQL SQL SECURITY
DEFINER
UPDATE producto SET estado_producto='I' WHERE id_producto = id_producto1;

-- CREAR PROCEDIMIENTO ALMACENADO PARA BUSCAR REGISTROS EN LA TABLA PRODUCTO.
USE chilin_db;
DROP PROCEDURE IF EXISTS buscar_producto;
CREATE PROCEDURE buscar_producto(
in id_producto1 int
)NOT DETERMINISTIC CONTAINS SQL SQL SECURITY 
DEFINER SELECT * FROM producto WHERE id_producto = id_producto1;

-- ====================================================================
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
in estado_pedido ENUM('A','I')
)
NOT DETERMINISTIC CONTAINS SQL SQL SECURITY
DEFINER
INSERT INTO pedido
values ('NULL',correlativo, id_cliente,id_producto,cantidad,estado_pedido);

-- CREAR PROCEDIMIENTO ALAMACENADO PARA ACTUALIZAR REGISTROS A LA TABLA PEDIDO.
USE chilin_db;
DROP PROCEDURE IF EXISTS actualizar_pedido;
CREATE PROCEDURE actualizar_pedido(
in id_pedido2    int,
in correlativo2  int, 
in id_cliente2   int,
in id_producto2  int,
in cantidad2     int,
in estado_pedido2 ENUM('A','I')
)
NOT DETERMINISTIC CONTAINS SQL SQL SECURITY
DEFINER
UPDATE pedido SET correlativo = correlativo2, id_cliente = id_cliente2, id_producto = id_producto2, cantidad = cantidad2, estado_pedido = estado_pedido2 WHERE id_pedido = id_pedido2;

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

-- ====================================================================
-- TABLA COMENTARIO
-- ====================================================================
-- CREAR PROCEDIMIENTO ALMACENADO PARA AGREGAR REGISTROS A LA TABLA COMENTARIO
USE chilin_db;
DROP PROCEDURE IF EXISTS agregar_comentario;
CREATE PROCEDURE agregar_comentario
(in id_cliente int ,
 in tipo_comentario ENUM('B','R','M'),
 in asunto text,
 in comentario text,
 in fecha datetime,
 in estado_comentario ENUM('A','I')
 )
NOT DETERMINISTIC CONTAINS SQL SQL SECURITY DEFINER
INSERT INTO comentario
VALUES('NULL', id_cliente,tipo_comentario,asunto,comentario,fecha,estado_comentario);

-- CREAR PROCEDIMIENTO ALMACENADO PARA ACTUALIZAR REGISTROS A LA TABLA COMENTARIO.
USE chilin_db;
DROP PROCEDURE IF EXISTS actualizar_comentario;
CREATE PROCEDURE actualizar_comentario(
in id_comentario2  int,
in id_cliente2  int, 
in tipo_comentario2 ENUM('B','R','M'),
in asunto2 text,
in comentario2 text,
in fecha2 datetime,
in estado_comentario2 ENUM('A','I')  
)
NOT DETERMINISTIC CONTAINS SQL SQL SECURITY
DEFINER
UPDATE comentario SET id_cliente = id_cliente2, tipo_comentario = tipo_comentario2,asunto= asunto2, comentario = comentario2,fecha=fecha2,estado_comentario=estado_comentario2 WHERE id_comentario = id_comentario2;

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

-- ====================================================================
-- TABLA FACTURA
-- ====================================================================
-- CREAR PROCEDIMIENTO ALMACENADO PARA AGREGAR REGISTROS A LA TABLA FACTURA
USE chilin_db;
DROP PROCEDURE IF EXISTS agregar_factura;
CREATE PROCEDURE agregar_factura(
in id_pedido int,
in correlativo int,
in fecha date,
in hora time,
in total_pagar decimal(6,2),
in tipo_factura ENUM('E','I'),
in estado_factura ENUM('A','I','P')
)
NOT DETERMINISTIC CONTAINS SQL SQL SECURITY
DEFINER
INSERT INTO factura
VALUES('NULL',id_pedido,correlativo,fecha,hora,total_pagar,tipo_factura,estado_factura);

-- CREAR PROCEDIMIENTO ALMACENADO PARA ACTUALIZAR REGISTROS A LA TABLA FACTURA. 
USE chilin_db;
DROP PROCEDURE IF EXISTS actualizar_factura;
CREATE PROCEDURE actualizar_factura(
in id_factura2    int,
in correlativo2 int,
in id_pedido2  int, 
in fecha2 datetime ,
in total_pagar2 decimal(6,2),
in tipo_factura2 ENUM('E','I'),
in estado_factura2 ENUM('A','I','P')
)
NOT DETERMINISTIC CONTAINS SQL SQL SECURITY
DEFINER
UPDATE factura SET id_pedido = id_pedido2, correlativo = correlativo2, fecha = fecha2, total_pagar = total_pagar2, tipo_factura = tipo_factura2, estado_factura = estado_factura2 WHERE id_factura = id_factura2;

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

-- ====================================================================
-- TABLA PAGO
-- ====================================================================
-- CREAR PROCEDIMIENTO ALMACENADO PARA AGREGAR REGISTROS A LA TABLA PAGO.
USE chilin_db;
DROP PROCEDURE IF EXISTS agregar_pago;
CREATE PROCEDURE agregar_pago(
in id_factura     int,
in fecha          datetime,
in pago_cliente   decimal(6,2),
in vuelto         decimal(6,2),
in estado_pago    ENUM('P','C') 
)
NOT DETERMINISTIC CONTAINS SQL SQL SECURITY
DEFINER
insert into pago
values ('NULL',id_factura,fecha,pago_cliente,vuelto,estado_pago);


-- CREAR PROCEDIMIENTO ALMACENADO PARA ACTUALIZAR REGISTROS DE LA TABLA PAGO.
USE chilin_db;
DROP PROCEDURE IF EXISTS actualizar_pago;
CREATE PROCEDURE actualizar_pago(
in id_pago2        int,
in id_factura2     int,
in fecha2          datetime,
in pago_cliente2   decimal(6,2),
in vuelto2         decimal(6,2),
in estado_pago2    ENUM('P','C') 
)
NOT DETERMINISTIC CONTAINS SQL SQL SECURITY
DEFINER
UPDATE pago SET id_factura = id_factura2, fecha = fecha2, pago_cliente=pago_cliente2,vuelto=vuelto2,estado_pago=estado_pago2 WHERE id_pago = id_pago2;

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

-- ====================================================================
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
)
NOT DETERMINISTIC CONTAINS SQL SQL SECURITY 
DEFINER SELECT * FROM despacho WHERE id_despacho = id_despacho1;

-- CREAR PROCEDIMIENTO ALMACENADO PARA LISTAR LAS CATEGORIAS Y MOSTRAR SUS PRODUCTOS
USE chilin_db;
DROP PROCEDURE IF EXISTS mostrar_productos;
CREATE PROCEDURE mostrar_productos(
in id_categoria2 int
)
NOT DETERMINISTIC CONTAINS SQL SQL SECURITY 
DEFINER
SELECT categoria.nombre_categoria, categoria.estado_categoria, id_producto, nombre_producto, precio, foto	FROM producto 
Inner Join categoria ON producto.id_categoria = categoria.id_categoria 
WHERE producto.id_categoria = id_categoria2 AND estado_producto = 'A' AND categoria.estado_categoria = 'A';

-- Vistas
-- Tabla pedido
CREATE VIEW vw_pedido AS
SELECT pedido.id_pedido, pedido.correlativo, cliente.id_cliente,cliente.nombre_cliente, producto.nombre_producto,
pedido.cantidad,factura.estado_factura
FROM pedido
INNER JOIN cliente ON pedido.id_cliente = cliente.id_cliente
INNER JOIN producto ON pedido.id_producto = producto.id_producto
INNER JOIN factura ON pedido.correlativo = factura.correlativo;

-- Tabla comentario
CREATE VIEW vw_comentario AS
SELECT comentario.id_comentario,cliente.nombre_cliente,
comentario.tipo_cometario,comentario.asunto,comentario.comentario,comentario.fecha,comentario.estado_comentario
FROM comentario
INNER JOIN cliente ON comentario.id_cliente = cliente.id_cliente;
-- Tabla factura
CREATE VIEW vw_factura AS
SELECT factura.id_factura,pedido.id_pedido,factura.correlativo,cliente.id_cliente,cliente.nombre_cliente,factura.fecha,factura.hora,
factura.total_pagar,factura.tipo_factura,factura.estado_factura
FROM factura
INNER JOIN pedido ON factura.id_pedido = pedido.id_pedido
INNER JOIN cliente ON pedido.id_cliente = cliente.id_cliente;
-- Tabla pago
CREATE VIEW vw_pago AS
SELECT pago.id_pago,pago.id_factura,cliente.nombre_cliente,pago.fecha,factura.total_pagar,pago.pago_cliente,pago.vuelto,pago.estado_pago
FROM pago
INNER JOIN factura ON pago.id_factura = factura.id_factura
INNER JOIN pedido  ON factura.id_pedido =  pedido.id_pedido
INNER JOIN cliente ON pedido.id_cliente = cliente.id_cliente;
-- Tabla productos
CREATE VIEW vw_productos AS
SELECT producto.id_producto, categoria.nombre_categoria, producto.nombre_producto, producto.fecha_ingreso, producto.fecha_vencimiento, producto.costo, producto.precio, producto.foto, producto.estado_producto
FROM producto
INNER JOIN categoria ON producto.id_categoria = categoria.id_categoria;

-- NUEVOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOO
-- NUEVOOOOOOOOOOO AGREGADO PARA QUE SE SUME A
-- LOS DATOS DE ABAJOOOOOOOOO

USE chilin_db;
DROP PROCEDURE IF EXISTS obtener_correlativo;
CREATE PROCEDURE obtener_correlativo(
)
NOT DETERMINISTIC CONTAINS SQL SQL SECURITY 
DEFINER
SELECT correlativo FROM pedido ORDER by correlativo DESC LIMIT 1;

USE chilin_db;
DROP PROCEDURE IF EXISTS obtener_pedido;
CREATE PROCEDURE obtener_pedido(
)
NOT DETERMINISTIC CONTAINS SQL SQL SECURITY 
DEFINER
SELECT id_pedido FROM pedido ORDER by 	id_pedido DESC LIMIT 1;

USE chilin_db;
DROP PROCEDURE IF EXISTS buscar_comentario_cliente;
CREATE PROCEDURE buscar_comentario_cliente(
in id_cliente1 int
)NOT DETERMINISTIC CONTAINS SQL SQL SECURITY 
DEFINER SELECT * FROM comentario WHERE id_cliente = id_cliente1;

USE chilin_db;
DROP PROCEDURE IF EXISTS obtener_factura;
CREATE PROCEDURE obtener_factura(
in id_cliente2 int
)NOT DETERMINISTIC CONTAINS SQL SQL SECURITY 
DEFINER SELECT * FROM factura INNER JOIN pedido ON factura.id_pedido = pedido.id_pedido WHERE pedido.id_cliente = id_cliente2;

USE chilin_db;
DROP PROCEDURE IF EXISTS listar_pedido;
CREATE PROCEDURE listar_pedido(
in correlativo1 int
)NOT DETERMINISTIC CONTAINS SQL SQL SECURITY 
DEFINER SELECT * FROM pedido INNER JOIN producto ON producto.id_producto = pedido.id_producto WHERE correlativo = correlativo1;

USE chilin_db;
DROP PROCEDURE IF EXISTS producto_completo;
CREATE PROCEDURE producto_completo(
in id_producto1 int
)NOT DETERMINISTIC CONTAINS SQL SQL SECURITY 
DEFINER 
SELECT
categoria.id_categoria,
producto.id_producto,
categoria.nombre_categoria,
producto.nombre_producto,
producto.fecha_ingreso,
producto.fecha_vencimiento,
producto.costo,
producto.precio,
producto.foto,
producto.estado_producto
FROM producto
Inner Join categoria ON producto.id_categoria = categoria.id_categoria WHERE id_producto = id_producto1;

USE chilin_db;
DROP PROCEDURE IF EXISTS cambiar_categoria;
CREATE PROCEDURE cambiar_categoria(
IN estado_categoria2 char,
IN id_categoria2 int
)
NOT DETERMINISTIC CONTAINS SQL SQL SECURITY
DEFINER
UPDATE categoria SET estado_categoria=estado_categoria2 WHERE id_categoria = id_categoria2;

USE chilin_db;
DROP PROCEDURE IF EXISTS cancelar_factura;
CREATE PROCEDURE cancelar_factura(
IN id_factura2 int
)
NOT DETERMINISTIC CONTAINS SQL SQL SECURITY
DEFINER
UPDATE factura SET estado_factura='I' WHERE id_factura = id_factura2;

USE chilin_db;
DROP PROCEDURE IF EXISTS obtener_pago;
CREATE PROCEDURE obtener_pago(
)
NOT DETERMINISTIC CONTAINS SQL SQL SECURITY 
DEFINER
SELECT id_pago FROM pago ORDER by	id_pago DESC LIMIT 1;

USE chilin_db;
DROP PROCEDURE IF EXISTS cambiar_comentario;
CREATE PROCEDURE cambiar_comentario(
IN estado_comentario2 char,
IN id_comentario2 int
)
NOT DETERMINISTIC CONTAINS SQL SQL SECURITY
DEFINER
UPDATE comentario SET estado_comentario=estado_comentario2 WHERE id_comentario = id_comentario2;

-- Tabla clientes
CREATE VIEW vw_clientes AS
SELECT * FROM cliente;
-- Tabla despacho
CREATE VIEW vw_despacho AS
SELECT * FROM despacho;
-- Tabla categoria
CREATE VIEW vw_categoria AS
SELECT * FROM categoria;

USE chilin_db;
DROP PROCEDURE IF EXISTS buscar_comentario_cliente;
CREATE PROCEDURE buscar_comentario_cliente(
in id_cliente1 int
)NOT DETERMINISTIC CONTAINS SQL SQL SECURITY 
DEFINER SELECT * FROM comentario WHERE id_cliente = id_cliente1;

USE chilin_db;
DROP PROCEDURE IF EXISTS cargar_facturas;
CREATE PROCEDURE cargar_facturas(
in id_factura1 int
)NOT DETERMINISTIC CONTAINS SQL SQL SECURITY 
DEFINER SELECT * FROM factura WHERE id_factura = id_factura1;


-- AQUI TERMINA LO NUEVOOOOOOOOOOOOOOOOOOOOOO

-- 
-- Agregamos datos predeterminados a cada tabla 
-- *** Los datos se agregan para el manejo de datos, en la version final estos datos no se tomaran en cuenta 
--
call agregar_cliente('Estefany Elizabeth', 'Ramírez Nuñez', '0', 64229837,'0000-00-00','usuario@chilin.com','Lourdes colón, la libertad','08d4efef87e3a5bef4efc25bc2268498ae3d12699a43b6a54fe13159f6a4cde0f50123280f65c24c6365f43c3aad09c441b95664c41ddf90e729404481221db0','F', 'A');
call agregar_categoria('Pupusas Tradicionales', 'A');
call agregar_categoria('Pupusas Especialidades', 'A');
call agregar_categoria('Bebidas frias', 'A');
call agregar_categoria('Bebidas calientes', 'A');
call agregar_categoria('Bebidas naturales', 'A');
call agregar_categoria('Reposterias', 'A');
call agregar_producto(1, 'Frijol con queso', '0000-00-00', '0000-00-00', 0.35, 0.50, 'pupusas.jpg', 'A');

-- RECUENTO DE PROCEDIMIENTOS ALMACENADOS:
-- [TABLA CLIENTE]
-- 7 Procedimientos Almacenados (1 de agregar, 2 de actualizar, 1 de eliminar, 3 de buscar)
-- [TABLA CATEGORIA]
-- 4 Procedimientos Almacenados (1 de agregar, 1 de actualizar, 1 de eliminar, 1 de buscar)
-- [TABLA PRODUCTO]
-- 4 Procedimientos Almacenados (1 de agregar, 1 de actualizar, 1 de eliminar, 1 de buscar)
-- [TABLA PEDIDO]
-- 4 Procedimientos Almacenados (1 de agregar, 1 de actualizar, 1 de eliminar, 1 de buscar)
-- [TABLA COMENTARIO]
-- 4 Procedimientos Almacenados (1 de agregar, 1 de actualizar, 1 de eliminar, 1 de buscar)
-- [FACTURA]
-- 4 Procedimientos Almacenados (1 de agregar, 1 de actualizar, 1 de eliminar, 1 de buscar)
-- [PAGO]
-- 4 Procedimientos Almacenados (1 de agregar, 1 de actualizar, 1 de eliminar, 1 de buscar)
-- [DESPACHO]
-- 4 Procedimientos Almacenados (1 de agregar, 1 de actualizar, 1 de eliminar, 1 de buscar)
-- [TOTAL DE PROCEDIMIENTOS ALMACENADOS: 35]

-- [INNER JOIN]
-- 1 Inner Join de las tablas Producto y Categoria.
-- 2 Inner Join de las tablas Cliente, Producto y Pedido.
-- 1 Inner Join de las tablas Cliente y Comentario.
-- 2 Inner Join de las tablas Cliente, Pedido y Factura. 
-- 3 Inner Join de las tablas Factura, Pedido, Cliente y Pago.
-- [TOTAL DE INNER JOIN: 9]

-- [VISTAS]
-- 1 Vista para la tabla Pedido.
-- 1 vista para la tabla comentario.
-- 1 Vista para la tabla Factura.
-- 1 Vista para la tabla Pago.
-- [TOTAL DE VISTAS: 4]

-- [TOTAL DE TODO: 48]

