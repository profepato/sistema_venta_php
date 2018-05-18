USE ventas;

DELIMITER $$
CREATE PROCEDURE getDetalles(idVenta INT)
BEGIN 
    SELECT 
        d.id, p.nombre, d.cantidad, d.subTotal, p.precio
    FROM 
        detalle d
    INNER JOIN 
        producto p ON d.producto = p.id
    WHERE 
        d.venta = idVenta;
END $$
DELIMITER ;






DELIMITER $$
CREATE PROCEDURE crearVenta(total INT)
BEGIN 
    INSERT INTO venta VALUES(NULL, NOW(), total);
END $$
DELIMITER ;






DELIMITER $$
CREATE FUNCTION getMaxIdVenta() RETURNS INT DETERMINISTIC
BEGIN 
    DECLARE maxID INT;

    SET maxID = (SELECT MAX(id) FROM venta);

    RETURN maxID;
END $$
DELIMITER ;



DELIMITER $$
CREATE PROCEDURE crearDetalle(id_producto INT, cant_producto INT, sub_total INT)
BEGIN 
    DECLARE maxID INT;

    SET maxID = (SELECT getMaxIdVenta());

    INSERT INTO detalle 
    VALUES(
        NULL,
        maxID,
        id_producto,
        cant_producto,
        sub_total
    );

    CALL actualizarStock(id_producto, cant_producto);
END $$
DELIMITER ;






DELIMITER $$
CREATE FUNCTION getStock(id_producto INT) RETURNS INT DETERMINISTIC
BEGIN 
    DECLARE stProd INT;

    SET stProd = (SELECT stock FROM producto WHERE id = id_producto);

    RETURN stProd;
END $$
DELIMITER ;







DELIMITER $$
CREATE PROCEDURE actualizarStock(id_producto INT, stockADescontar INT)
BEGIN 
    DECLARE stProd INT;
    DECLARE stActual INT; /*stock actual*/

    SET stProd = (SELECT getStock(id_producto));
    SET stActual = stProd - stockADescontar;

    UPDATE producto SET stock = stActual WHERE id = id_producto;
END $$
DELIMITER ;


/*Test de procedimientos*/
CALL getDetalles(1);
CALL getMaxIdVenta();
SELECT getMaxIdVenta();
SELECT getStock(1);
/*Test de procedimientos*/

/*DROP de procedimientos*/
DROP PROCEDURE getDetalles;
DROP PROCEDURE crearVenta;
DROP FUNCTION getMaxIdVenta;
DROP PROCEDURE crearDetalle;
DROP FUNCTION getStock;
DROP PROCEDURE actualizarStock;
/*DROP de procedimientos*/