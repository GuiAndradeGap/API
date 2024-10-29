<?php


function editar_cliente_parcialmente($conexao, $id, $campos_para_atualizar) {
    // Validação básica
    if (empty($id) || empty($campos_para_atualizar)) {
        return false;
    }

    // Construção dinâmica da query
    $atualizacoes = [];
    foreach ($campos_para_atualizar as $campo => $valor) {
        // Sanitizar valores para evitar SQL injection (considerando que $valor pode ser string, int, etc.)
        $campo_sanitizado = mysqli_real_escape_string($conexao, $campo);
        $valor_sanitizado = mysqli_real_escape_string($conexao, $valor);

        // Adicionar campo e valor sanitizados ao array
        $atualizacoes[] = "$campo_sanitizado = '$valor_sanitizado'";
    }

    // Converter o array de atualizações em uma string separada por vírgula
    $atualizacoes_sql = implode(', ', $atualizacoes);

    // Query de atualização
    $sql = "UPDATE Clientes SET $atualizacoes_sql WHERE ID = " . intval($id);

    // Executar a query
    $res = mysqli_query($conexao, $sql);

    // Fechar a conexão
    fecharConexao($conexao);

    return $res;
}

// PATCH Produtos
function editar_produto_parcialmente($conexao, $id_produto, $campos_para_atualizar) {
    if (empty($id_produto) || empty($campos_para_atualizar)) {
        return false;
    }

    $atualizacoes = [];
    foreach ($campos_para_atualizar as $campo => $valor) {
        $campo_sanitizado = mysqli_real_escape_string($conexao, $campo);
        $valor_sanitizado = mysqli_real_escape_string($conexao, $valor);
        $atualizacoes[] = "$campo_sanitizado = '$valor_sanitizado'";
    }

    $atualizacoes_sql = implode(', ', $atualizacoes);
    $sql = "UPDATE Produtos SET $atualizacoes_sql WHERE ID = " . intval($id_produto);

    $res = mysqli_query($conexao, $sql);
    fecharConexao($conexao);

    return $res;
}


// PATCH Pedido
function editar_pedido_parcialmente($conexao, $id_pedido, $campos_para_atualizar) {
    if (empty($id_pedido) || empty($campos_para_atualizar)) {
        return false;
    }

    $atualizacoes = [];
    foreach ($campos_para_atualizar as $campo => $valor) {
        $campo_sanitizado = mysqli_real_escape_string($conexao, $campo);
        $valor_sanitizado = mysqli_real_escape_string($conexao, $valor);
        $atualizacoes[] = "$campo_sanitizado = '$valor_sanitizado'";
    }

    $atualizacoes_sql = implode(', ', $atualizacoes);
    $sql = "UPDATE Pedidos SET $atualizacoes_sql WHERE id_pedido = " . intval($id_pedido);

    $res = mysqli_query($conexao, $sql);
    fecharConexao($conexao);

    return $res;
}


// PATCH Pedido_Produto
function editar_pedido_produto_parcialmente($conexao, $pedido_id, $produto_id, $campos_para_atualizar) {
    if (empty($pedido_id) || empty($produto_id) || empty($campos_para_atualizar)) {
        return false;
    }

    $atualizacoes = [];
    foreach ($campos_para_atualizar as $campo => $valor) {
        $campo_sanitizado = mysqli_real_escape_string($conexao, $campo);
        $valor_sanitizado = mysqli_real_escape_string($conexao, $valor);
        $atualizacoes[] = "$campo_sanitizado = '$valor_sanitizado'";
    }

    $atualizacoes_sql = implode(', ', $atualizacoes);
    $sql = "UPDATE Pedido_Produto SET $atualizacoes_sql WHERE PedidoID = " . intval($pedido_id) . " AND ProdutoID = " . intval($produto_id);

    $res = mysqli_query($conexao, $sql);
    fecharConexao($conexao);

    return $res;
}




?>
