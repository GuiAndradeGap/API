<?php
require 'utils.php';
require_once '../DAO/conexao.php';
require_once '../DAO/Get.php';
require_once '../DAO/Post.php';
require_once '../DAO/Put.php';
require_once '../DAO/Patch.php';
require '../DAO/Delete.php';
require '../Model/Clientes.php';
require '../Model/Resposta.php';

$req = $_SERVER;
$conexao = conectar();

switch ($req["REQUEST_METHOD"]) {
    case 'GET':
        $clientes = json_encode(obter_clientes($conexao));
        echo $clientes;
        break;

    case 'POST':
        $dados = receberDadosCliente();
        $resp = incluir_cliente($conexao, $dados);
        
        $resposta = new Resposta('', '');
        $resposta = $resp 
            ? criarRespostaCliente('201', 'Cliente incluído com sucesso') 
            : criarRespostaCliente('400', 'Não foi possível incluir o cliente');
        echo json_encode($resposta);
        break;

    case 'PUT':
        $dados = json_decode(file_get_contents('php://input'));
        $id = $dados->id;
        $cliente = receberDadosCliente();
        
        $resp = editar_cliente($conexao, $cliente, $id);
        $resposta = new Resposta('', '');
        $resposta = $resp 
            ? criarRespostaCliente('204', 'Cliente atualizado com sucesso') 
            : criarRespostaCliente('400', 'Não foi possível atualizar o cliente');
        echo json_encode($resposta);
        break;

    case 'PATCH':
        $dados = json_decode(file_get_contents('php://input'), true);
        $id = $dados['id'];
        $campos_para_atualizar = $dados['atualizacoes'];
        
        $resp = editar_cliente_parcialmente($conexao, $id, $campos_para_atualizar);
        $resposta = new Resposta('', '');
        $resposta = $resp 
            ? criarRespostaCliente('204', 'Cliente atualizado parcialmente com sucesso') 
            : criarRespostaCliente('400', 'Não foi possível atualizar o cliente');
        echo json_encode($resposta);
        break;

    case 'DELETE':
        $dados = json_decode(file_get_contents('php://input'));
        $id = $dados->id;
        
        $pedidos = buscarPedidosPorCliente($conexao, $id);
        foreach ($pedidos as $pedido) {
            deletar_pedido_produto_por_pedido($conexao, $pedido['id_pedido']);
            deletar_pedido($conexao, $pedido['id_pedido']);
        }
        
        $resp = deletar_cliente($conexao, $id);
        $resposta = $resp 
            ? criarRespostaCliente('204', 'Cliente excluído com sucesso') 
            : criarRespostaCliente('400', 'Não foi possível excluir o cliente');
        echo json_encode($resposta);
        fecharConexao($conexao);
        break;

    default:
        http_response_code(405);
        echo json_encode(criarRespostaCliente('405', 'Método não permitido'));
        break;
}
?>
