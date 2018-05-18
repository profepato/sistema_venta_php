<?php
//require_once "../model/Producto.php";
require_once "../model/Data.php";

$p = new Producto();

$p->cantidad = $_POST["txtCantidad"];

if($p->cantidad > 0){
    $p->id = $_POST["txtId"];
    $p->nombre = $_POST["txtNombre"];
    $p->precio = $_POST["txtPrecio"];
    $p->stock = $_POST["txtStock"];
    $p->subTotal = $p->precio * $p->cantidad;

    $d = new Data();
    
    session_start();
    if(isset($_SESSION["carrito"])){
        $carrito = $_SESSION["carrito"];
    }else{
        $carrito = array();
    }

    $sumaCantidades = 0;
    foreach ($carrito as $pro) {
        if($pro->id == $p->id){
            $sumaCantidades += $pro->cantidad;
        }
    }

    $sumaCantidades += $p->cantidad;

    if($p->stock >= $sumaCantidades){
        // tengo stock
        array_push($carrito, $p);
        $_SESSION["carrito"] = $carrito;
        header("location: ../index.php");
    }else{
        // no tiene stock
        header("location: ../index.php?m=1");
    }
}else{
    header("location: ../index.php?m=2");
}

?>
