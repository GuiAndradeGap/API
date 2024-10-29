<?php 
   
// GET Cliente
function obter_clientes($conexao) {
    $sql = "SELECT * FROM Clientes;";
    $res = mysqli_query($conexao, $sql);

    $clientes = [];

    while ($registro = mysqli_fetch_array($res)) {
        $id = utf8_encode($registro['ID']);
        $nome = utf8_encode($registro['Nome']);
        $endereco = utf8_encode($registro['Endereco']); // Campo Endereco
        $cpf = utf8_encode($registro['CPF']); // Campo CPF
        $telefone = utf8_encode($registro['Telefone']);
        $email = utf8_encode($registro['Email']);
        $dataNascimento = utf8_encode($registro['DataNascimento']);
        
        // Criação de um novo cliente com os novos campos
        $novo_cliente = new Clientes($id, $nome, $endereco, $cpf, $telefone, $email, $dataNascimento);
        array_push($clientes, $novo_cliente);
    }

    fecharConexao($conexao);

    return $clientes; // Retorna a lista de clientes
}


//GET Produtos
function obter_produtos($conexao) {
    $sql = "SELECT * FROM Produtos;";
    $res = mysqli_query($conexao, $sql);

    $produtos = [];

    while ($registro = mysqli_fetch_array($res)) {
        $id_produto = utf8_encode($registro['ID']);
        $nome = utf8_encode($registro['Nome']);
        $descricao = utf8_encode($registro['Descricao']);
        $qtd = utf8_encode($registro['qtd']);
        $marca = utf8_encode($registro['Marca']);
        $preco = utf8_encode($registro['Preco']);
        $validade = utf8_encode($registro['Validade']);

        $novo_produto = new Produto($id_produto, $nome, $descricao, $qtd, $marca, $preco, $validade);
        array_push($produtos, $novo_produto);
    }

    fecharConexao($conexao);
    return $produtos;
}


//GET Pedidos
function obter_pedidos($conexao) {
    $sql = "SELECT * FROM Pedidos;";
    $res = mysqli_query($conexao, $sql);

    $pedidos = [];

    while ($registro = mysqli_fetch_array($res)) {
        $id_pedido = utf8_encode($registro['id_pedido']);
        $id_cliente = utf8_encode($registro['id_cliente']);
        $data = utf8_encode($registro['data']);

        $novo_pedido = new Pedido($id_pedido, $id_cliente, $data);
        array_push($pedidos, $novo_pedido);
    }

    fecharConexao($conexao);
    return $pedidos;
}



//GET Pedidos_Produtos
function obter_pedidos_produtos($conexao) {
    $sql = "SELECT * FROM pedidos_produtos;";
    $res = mysqli_query($conexao, $sql);

    $pedidos_produtos = [];

    while ($registro = mysqli_fetch_array($res)) {
        $id_pedido = utf8_encode($registro['id_pedido']);
        $id_produto = utf8_encode($registro['id_produto']);
        $qtd = utf8_encode($registro['qtd']);

        $novo_pedido_produto = new PedidoProduto($id_pedido, $id_produto, $qtd);
        array_push($pedidos_produtos, $novo_pedido_produto);
    }

    fecharConexao($conexao);
    return $pedidos_produtos;
}



   
?>