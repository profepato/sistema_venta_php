<?php
class Producto{
    public $id;
    public $nombre;
    public $precio;
    public $stock;
    public $cantidad;
    public $subTotal;/*precio * cantidad*/

    public function __toString(){
        return $this->id."-".$this->nombre."-".$this->precio.
        "-".$this->stock."-".$this->cantidad."-".$this->subTotal;
    }
}
?>
