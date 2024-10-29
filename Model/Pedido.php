<?php 

class Pedido {
    public $id_pedido;
    public $id_cliente;
    public $data;

    function __construct($id_pedido_informado, $id_cliente_informado, $data_informada) {
        $this->id_pedido = $id_pedido_informado;
        $this->id_cliente = $id_cliente_informado;
        $this->data = $data_informada;
    }
}
?>
