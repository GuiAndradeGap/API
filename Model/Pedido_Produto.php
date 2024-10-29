<?php 

class PedidoProduto {
    public $id_pedido;
    public $id_produto;
    public $qtd;

    function __construct($id_pedido_informado, $id_produto_informado, $qtd_informada) {
        $this->id_pedido = $id_pedido_informado;
        $this->id_produto = $id_produto_informado;
        $this->qtd = $qtd_informada;
    }
}
?>
