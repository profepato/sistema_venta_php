create database ventas;

use ventas;

create table producto(
    id int auto_increment,
    nombre varchar(100),
    precio int,
    stock int,
    primary key(id)
);

insert into producto values(null, 'Leche','100','10');
insert into producto values(null, 'Dulce de leche','200','20');
insert into producto values(null, 'Sal','300','30');
insert into producto values(null, 'Pimienta','400','40');
insert into producto values(null, 'Orégano','500','50');

create table venta(
    id int auto_increment,
    fecha datetime,
    total int,
    primary key(id)
);

create table detalle(
    id int auto_increment,
    venta int,
    producto int,
    cantidad int,
    subTotal int,
    primary key(id)
);

select * from producto;
select * from venta;
select * from detalle;

/*1.- Ver detalle de venta a través de su ID*/
select d.id, p.nombre, d.cantidad, d.subTotal, p.precio
from detalle d, producto p
where d.producto = p.id and
d.venta = 1;
