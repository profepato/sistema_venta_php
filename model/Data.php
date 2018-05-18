<?php
require_once "Conexion.php";
require_once "Producto.php";
require_once "Venta.php";
require_once "Detalle.php";

class Data{
    private $con;

    public function __construct(){
        $this->con = new Conexion("ventas");
    }

    public function getProductos(){
        $productos = array();

        $query = "SELECT * FROM getProductos";

        $this->con->conectar();
        $rs = $this->con->ejecutar($query);

        while($reg = $rs->fetch_array()){
            $p = new Producto();

            $p->id = $reg[0];
            $p->nombre = $reg[1];
            $p->precio = $reg[2];
            $p->stock = $reg[3];

            array_push($productos, $p);
        }

        $this->con->desconectar();

        return $productos;
    }

    public function getVentas(){
        $ventas = array();

        $query = "SELECT * FROM getVentas";

        $this->con->conectar();
        $rs = $this->con->ejecutar($query);

        while($reg = $rs->fetch_array()){
            $v = new Venta();

            $v->id = $reg[0];
            $v->fecha = $reg[1];
            $v->total = $reg[2];

            array_push($ventas, $v);
        }
        $this->con->desconectar();


        return $ventas;
    }

    public function getDetalles($idVenta){
        $query = "CALL getDetalles($idVenta)";

        $detalles = array();
        
        $this->con->conectar();
        $rs = $this->con->ejecutar($query);
        while($reg = $rs->fetch_array()){
            $d = new Detalle();

            $d->id = $reg[0];
            $d->nomProducto = $reg[1];
            $d->cantidad = $reg[2];
            $d->subTotal = $reg[3];
            $d->precio = $reg[4];

            array_push($detalles, $d);
        }

        $this->con->desconectar();

        return $detalles;
    }

    public function crearVenta($listaProductos, $total){
        $query = "CALL crearVenta($total)";

        $this->con->conectar();
        $this->con->ejecutar($query);

        foreach ($listaProductos as $p) {
            /*
            En el procedimiento crearDetalle, se crea el detalle en la tabla
            intermedia, y además se actualiza el stock en la tabla producto
            */
            $query = "CALL crearDetalle($p->id, $p->cantidad, $p->subTotal)";

            $this->con->ejecutar($query);
        }
        $this->con->desconectar();
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
