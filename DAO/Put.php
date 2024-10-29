<?php

// PUT Clientes
function editar_cliente($conexao, $clientes, $id) {
    $sql = "UPDATE Clientes SET 
            Nome = '$clientes->nome', 
            Endereco = '$clientes->endereco', 
            CPF = '$clientes->cpf', 
            Telefone = '$clientes->telefone', 
            Email = '$clientes->email', 
            DataNascimento = '$clientes->dataNascimento' 
            WHERE ID = $id;";
    $res = mysqli_query($conexao, $sql) or die("Erro ao tentar editar cliente: " . mysqli_error($conexao));
    fecharConexao($conexao);
    return $res;
}

// PUT Produto
function editar_produto($conexao, $produto, $id_produto) {
    $sql = "UPDATE Produtos SET 
            Nome = '$produto->nome', 
            Descricao = '$produto->descricao', 
            qtd = '$produto->qtd', 
            Marca = '$produto->marca', 
            Preco = '$produto->preco', 
            Validade = '$produto->validade' 
            WHERE ID = $id_produto;";
    $res = mysqli_query($conexao, $sql) or die("Erro ao tentar editar produto: " . mysqli_error($conexao));
    fecharConexao($conexao);
    return $res;
}

// PUT Pedido
function editar_pedido($conexao, $pedido, $id_pedido) {
    $sql = "UPDATE Pedidos SET 
            id_cliente = '$pedido->id_cliente', 
            data = '$pedido->data' 
            WHERE id_pedido = $id_pedido;";
    $res = mysqli_query($conexao, $sql) or die("Erro ao tentar editar pedido: " . mysqli_error($conexao));
    fecharConexao($conexao);
    return $res;
}

// PUT Pedido_Produto
function editar_pedido_produto($conexao, $pedido_produto, $id_pedido, $id_produto) {
    $sql = "UPDATE pedidos_produtos SET 
            qtd = '$pedido_produto->qtd' 
            WHERE id_pedido = $id_pedido AND id_produto = $id_produto;";
    $res = mysqli_query($conexao, $sql) or die("Erro ao tentar editar produto do pedido: " . mysqli_error($conexao));
    fecharConexao($conexao);
    return $res;
}

?>
