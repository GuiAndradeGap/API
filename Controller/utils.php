<?php 

//Clientes
function criarRespostaCliente($status, $msg) {
   $resp = new Resposta($status, $msg);
   return $resp;
}
     
function receberDadosCliente() {
   $dados = json_decode(file_get_contents('php://input'));
     
   // Campos relacionados à tabela Clientes
   $nome = $dados->nome;
   $endereco = $dados->endereco; 
   $cpf = $dados->cpf;           
   $telefone = $dados->telefone;
   $email = $dados->email;
   $dataNascimento = $dados->dataNascimento;
     
      // Cria uma instância do objeto Cliente
   $cliente = new Clientes("", $nome, $endereco, $cpf, $telefone, $email, $dataNascimento);
   return $cliente;
}


// Função para criar resposta para Produtos
function criarRespostaProduto($status, $msg) {
   $resp = new Resposta($status, $msg);
   return $resp;
}

// Função para receber os dados de um produto
function receberDadosProduto() {
   $dados = json_decode(file_get_contents('php://input'));

   // Campos relacionados à tabela Produtos
   $nome = $dados->nome;
   $descricao = $dados->descricao;
   $qtd = $dados->qtd; // Novo campo para a quantidade (Qtd)
   $marca = $dados->marca;
   $preco = $dados->preco;
   $validade = $dados->validade; // Campo de validade (formato: YYYY-MM-DD)

   // Cria uma instância do objeto Produto com os novos campos
   $produto = new Produto("", $nome, $descricao, $qtd, $marca, $preco, $validade);
   return $produto;
}


// Função para criar resposta para Pedidos
function criarRespostaPedido($status, $msg) {
   $resp = new Resposta($status, $msg);
   return $resp;
}

// Função para receber os dados de um pedido
function receberDadosPedido() {
   $dados = json_decode(file_get_contents('php://input'));

   // Campos relacionados à tabela Pedidos
   $id_cliente = $dados->id_cliente; // ID do cliente
   $data = $dados->data; // Data do pedido

   // Cria uma instância do objeto Pedido
   $pedido = new Pedido("", $id_cliente, $data, "", ""); // id_pedido pode ser gerado pelo banco
   return $pedido;
}

// Função para verificar se o id_cliente existe no banco de dados
function verificarClienteExiste($conexao, $id_cliente) {
   $query = "SELECT COUNT(*) FROM Clientes WHERE ID = ?";
   $stmt = $conexao->prepare($query);
   $stmt->bind_param("i", $id_cliente);
   $stmt->execute();
   $stmt->bind_result($count);
   $stmt->fetch();
   $stmt->close();

   return $count > 0; // Retorna true se o cliente existir
}

// Função para criar resposta para Pedidos Produtos
function criarRespostaPedidoProduto($status, $msg) { 
   $resp = new Resposta($status, $msg);
   return $resp;
}

// Função para receber os dados de um pedido_produto
function receberDadosPedidoProduto() {
   $dados = json_decode(file_get_contents('php://input'));

   // Campos relacionados à tabela pedidos_produtos
   $id_pedido = $dados->id_pedido;
   $id_produto = $dados->id_produto;
   $qtd = $dados->qtd;  // Corrigido para usar 'qtd' que é a quantidade

   // Cria uma instância do objeto PedidoProduto
   $pedido_produto = new PedidoProduto($id_pedido, $id_produto, $qtd);
   return $pedido_produto;
}

// Função para verificar se um pedido existe
function verificarPedidoExiste($conexao, $id_pedido) {
   $query = "SELECT COUNT(*) as total FROM pedidos WHERE id_pedido = ?";
   $stmt = $conexao->prepare($query);
   $stmt->bind_param("i", $id_pedido); // 'i' para inteiro
   $stmt->execute();
   $result = $stmt->get_result();
   $row = $result->fetch_assoc();
   
   return $row['total'] > 0; // Retorna true se o pedido existe
}

// Função para verificar se um produto existe
function verificarProdutoExiste($conexao, $id_produto) {
   $query = "SELECT COUNT(*) as total FROM produtos WHERE ID = ?";
   $stmt = $conexao->prepare($query);
   $stmt->bind_param("i", $id_produto); // 'i' para inteiro
   $stmt->execute();
   $result = $stmt->get_result();
   $row = $result->fetch_assoc();
   
   return $row['total'] > 0; // Retorna true se o produto existe
}

function verificarPedidoProdutoExiste($conexao, $id_pedido, $id_produto) {
   $query = "SELECT COUNT(*) FROM pedidos_produtos WHERE id_pedido = ? AND id_produto = ?";
   $stmt = $conexao->prepare($query);
   
   $stmt->bind_param("ii", $id_pedido, $id_produto);
   
   $stmt->execute();
 
   $stmt->bind_result($count);
   $stmt->fetch();

   return $count > 0;
}




?>