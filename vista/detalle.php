<?php
require_once "../model/Data.php";
$idVenta = $_GET["id"];
$d = new Data();

$detalles = $d->getDetalles($idVenta);

echo "<h1>Detalles de venta ID: $idVenta </h1>";

echo "<table border='1'>";
    echo "<tr>";
        echo "<th>ID</th>";
        echo "<th>Producto</th>";
        echo "<th>Cantidad</th>";
        echo "<th>SubTotal</th>";
    echo "</tr>";

    $total = 0;
    foreach ($detalles as $det) {
        echo "<tr>";
            echo "<td>".$det->id."</td>";
            echo "<td>".$det->nomProducto."</td>";
            echo "<td>".$det->cantidad." x $".$det->precio."</td>";
            echo "<td>$".$det->subTotal."</td>";
            $total += $det->subTotal;
        echo "</tr>";
    }
    echo "<tr>";
        echo "<td colspan='3'><b>Total</b></td>";
        echo "<td><b>$$total</b></td>";
    echo "</tr>";
echo "</table>";

echo "<a href='ventas.php'>Volver a ventas</a>";
?>
