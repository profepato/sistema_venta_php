<?php
require_once "Conexion.php";
require_once "Producto.php";
require_once "Venta.php";
require_once "Detalle.php";

class Data{
    private $con;

    public function __construct(){
        $this->con = new Conexion("localhost", "ventas", "root", "123456");
    }

    public function getProductos(){
        $productos = array();

        $query = "select * from producto";
        $res = $this->con->ejecutar($query);

        while($reg = mysql_fetch_array($res)){
            $p = new Producto();

            $p->id = $reg[0];
            $p->nombre = $reg[1];
            $p->precio = $reg[2];
            $p->stock = $reg[3];

            array_push($productos, $p);
        }

        return $productos;
    }

    public function getVentas(){
        $ventas = array();

        $query = "select * from venta";
        $res = $this->con->ejecutar($query);

        while($reg = mysql_fetch_array($res)){
            $v = new Venta();

            $v->id = $reg[0];
            $v->fecha = $reg[1];
            $v->total = $reg[2];

            array_push($ventas, $v);
        }

        return $ventas;
    }

    public function getDetalles($idVenta){
        $query = "select d.id, p.nombre, d.cantidad, d.subTotal, p.precio
        from detalle d, producto p
        where d.producto = p.id and
        d.venta = $idVenta";

        $detalles = array();

        $res = $this->con->ejecutar($query);
        while($reg = mysql_fetch_array($res)){
            $d = new Detalle();

            $d->id = $reg[0];
            $d->nomProducto = $reg[1];
            $d->cantidad = $reg[2];
            $d->subTotal = $reg[3];
            $d->precio = $reg[4];

            array_push($detalles, $d);
        }

        return $detalles;
    }

    public function crearVenta($listaProductos, $total){
        // crear la venta
        $query = "insert into venta values(null, now(), $total)";
        $this->con->ejecutar($query);

        // rescatar la última venta (id)
        $query = "select max(id) from venta";
        $res = $this->con->ejecutar($query);

        $idUltimaVenta = 0;
        if($reg = mysql_fetch_array($res)){
            $idUltimaVenta = $reg[0];
        }

        // los insert en el detalle
        foreach ($listaProductos as $p) {
            $query = "insert into detalle values(null,
            '".$idUltimaVenta."',
            '".$p->id."',
            '".$p->cantidad."',
            '".$p->subTotal."')";

            $this->con->ejecutar($query);
            $this->actualizarStock($p->id, $p->cantidad);
        }

    }

    public function actualizarStock($id, $stockADescontar){
        $query = "select stock from producto where id = $id";
        $res = $this->con->ejecutar($query);

        $stockActual = 0;
        if($reg = mysql_fetch_array($res)){
            $stockActual = $reg[0];
        }

        $stockActual -= $stockADescontar;

        $query = "update producto set stock = $stockActual where id = $id";
        $this->con->ejecutar($query);
    }

    /*
    public function tieneStock($id, $stock){
        $query = "select stock from producto where id = $id";
        echo $query;
        echo "<br>";

        $res = $this->con->ejecutar($query);
        $stockActual = 0;

        if($reg = mysql_fetch_array($res)){
            $stockActual = $reg[0];
        }

        echo "Stock actual: ".$stockActual;
        echo "<br>";
        echo "Stock: ".$stock;
        echo "<br>";
        return $stockActual >= $stock;
    }
    */
}
?>
