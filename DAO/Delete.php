<?php 

// DELETE Cliente
function deletar_cliente($conexao, $id) {
   // Excluir pedidos relacionados ao cliente
   $sql_delete_pedidos = "DELETE FROM pedidos WHERE id_cliente = $id;";
   $res_pedidos = mysqli_query($conexao, $sql_delete_pedidos) or die("Erro ao tentar deletar pedidos relacionados: " . mysqli_error($conexao));

   // Depois excluir o cliente
   $sql_delete_cliente = "DELETE FROM Clientes WHERE ID = $id;";
   $res_cliente = mysqli_query($conexao, $sql_delete_cliente) or die("Erro ao tentar deletar cliente: " . mysqli_error($conexao));

   // Não fechar a conexão aqui
   return $res_cliente; // Retorna o resultado da exclusão do cliente
}

//DELETE Produto
function deletar_produto($conexao, $id_produto) {
   // Primeiro, exclui os produtos relacionados na tabela pedidos_produtos
   $sql_delete_pedidos_produtos = "DELETE FROM pedidos_produtos WHERE id_produto = $id_produto;";
   $res_pedidos_produtos = mysqli_query($conexao, $sql_delete_pedidos_produtos) 
       or die("Erro ao tentar deletar produtos do pedido: " . mysqli_error($conexao));

   // Agora, exclui o produto
   $sql = "DELETE FROM Produtos WHERE ID = $id_produto;";
   $res = mysqli_query($conexao, $sql) 
       or die("Erro ao tentar deletar produto: " . mysqli_error($conexao));

   fecharConexao($conexao);
   return $res;
}


// DELETE Pedido
function deletar_pedido($conexao, $id) {
   // Excluir produtos relacionados ao pedido
   $sql_produtos = "DELETE FROM pedidos_produtos WHERE id_pedido = $id;";
   $res_produtos = mysqli_query($conexao, $sql_produtos) or die("Erro ao tentar deletar produtos do pedido: " . mysqli_error($conexao));

   // Agora que os produtos foram excluídos, podemos excluir o pedido
   $sql_pedido = "DELETE FROM Pedidos WHERE id_pedido = $id;";
   $res_pedido = mysqli_query($conexao, $sql_pedido) or die("Erro ao tentar deletar pedido: " . mysqli_error($conexao));

   // Não fechar a conexão aqui
   return $res_pedido; // Retornar o resultado da exclusão do pedido
}

// DELETE Pedido_Produto
function deletar_pedido_produto($conexao, $id_pedido, $id_produto) {
   $sql = "DELETE FROM pedidos_produtos WHERE id_pedido = $id_pedido AND id_produto = $id_produto;";
   $res = mysqli_query($conexao, $sql) or die("Erro ao tentar deletar produto do pedido: " . mysqli_error($conexao));
   return $res;
}

function buscarPedidosPorCliente($conexao, $id_cliente) {
   $sql = "SELECT * FROM Pedidos WHERE id_cliente = $id_cliente;";
   $result = mysqli_query($conexao, $sql);
   return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function buscarProdutosPorPedido($conexao, $id_pedido) {
   $sql = "SELECT id_produto FROM pedidos_produtos WHERE id_pedido = $id_pedido;";
   $result = mysqli_query($conexao, $sql);
   return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function deletar_pedido_produto_por_pedido($conexao, $id_pedido) {
   $sql = "DELETE FROM pedidos_produtos WHERE id_pedido = $id_pedido;";
   $res = mysqli_query($conexao, $sql) or die("Erro ao tentar deletar produtos do pedido: " . mysqli_error($conexao));
   return $res;
}

?>
