<?php 



//POST Cliente
function incluir_cliente($conexao, $cliente) {
      $sql = "INSERT INTO Clientes (Nome, Endereco, CPF, Telefone, Email, DataNascimento) 
              VALUES ('$cliente->nome', '$cliente->endereco', '$cliente->cpf', '$cliente->telefone', '$cliente->email', '$cliente->dataNascimento');";
      
      $res = mysqli_query($conexao, $sql) or die("Erro ao tentar incluir cliente: " . mysqli_error($conexao));
      
      fecharConexao($conexao);
      return $res;
  }

//POST Produto
function incluir_produto($conexao, $produto) {
   $sql = "INSERT INTO Produtos (Nome, Descricao, qtd, Marca, Preco, Validade) 
           VALUES ('$produto->nome', '$produto->descricao', '$produto->qtd', '$produto->marca', '$produto->preco', '$produto->validade');";
   
   $res = mysqli_query($conexao, $sql) or die("Erro ao tentar incluir produto: " . mysqli_error($conexao));
   
   fecharConexao($conexao);
   return $res;
}

//POST Pedido
function incluir_pedido($conexao, $pedido) {
   $sql = "INSERT INTO Pedidos (id_cliente, data) 
           VALUES ('$pedido->id_cliente', '$pedido->data');";
   
   $res = mysqli_query($conexao, $sql) or die("Erro ao tentar incluir pedido: " . mysqli_error($conexao));
   
   fecharConexao($conexao);
   return $res;
}

//POST Pedido_Produto
function incluir_pedido_produto($conexao, $pedido_produto) {
   $sql = "INSERT INTO pedidos_produtos (id_pedido, id_produto, qtd) 
           VALUES ('$pedido_produto->id_pedido', '$pedido_produto->id_produto', '$pedido_produto->qtd');";
   
   $res = mysqli_query($conexao, $sql) or die("Erro ao tentar incluir produto no pedido: " . mysqli_error($conexao));
   
   fecharConexao($conexao);
   return $res;
}

?>