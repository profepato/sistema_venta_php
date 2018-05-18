CREATE DATABASE ventas;

USE ventas;

CREATE TABLE producto(
    id INT AUTO_INCREMENT,
    nombre VARCHAR(100),
    precio INT,
    stock INT,
    PRIMARY KEY(id)
);

INSERT INTO producto VALUES(null, 'Leche','100','10');
INSERT INTO producto VALUES(null, 'Dulce de leche','200','20');
INSERT INTO producto VALUES(null, 'Sal','300','30');
INSERT INTO producto VALUES(null, 'Pimienta','400','40');
INSERT INTO producto VALUES(null, 'Orégano','500','50');

CREATE TABLE venta(
    id INT AUTO_INCREMENT,
    fecha DATETIME,
    total INT,
    PRIMARY KEY(id)
);

CREATE TABLE detalle(
    id INT AUTO_INCREMENT,
    venta INT,
    producto INT,
    cantidad INT,
    subTotal INT,
    PRIMARY KEY(id)
);

SELECT * FROM producto;
SELECT * FROM venta;
SELECT * FROM detalle;

DELETE FROM detalle;
DELETE FROM producto;
DELETE FROM venta;

DROP DATABASE ventas;

/*1.- Ver detalle de venta a través de su ID*/
SELECT 
    d.id, 
    p.nombre, 
    d.cantidad, 
    d.subTotal, 
    p.precio
FROM 
    detalle d, 
    producto p
WHERE 
    d.producto = p.id AND
    d.venta = 1;
