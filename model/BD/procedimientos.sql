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

/*Test de procedimientos*/
CALL getDetalles(1);
/*Test de procedimientos*/

/*DROP de procedimientos*/
DROP PROCEDURE getDetalles;
/*DROP de procedimientos*/