<?php
require 'utils.php';
require_once '../DAO/conexao.php';
require_once '../DAO/Get.php';
require_once '../DAO/Post.php';
require_once '../DAO/Put.php';
require_once '../DAO/Patch.php';
require '../DAO/Delete.php';
require '../Model/Pedido.php';
require '../Model/Resposta.php';

$req = $_SERVER;
$conexao = conectar();

switch ($req["REQUEST_METHOD"]) {
    case 'GET':
        // Obter todos os pedidos
        $pedidos = obter_pedidos($conexao);
        echo json_encode($pedidos);
        break;

    case 'POST':
        // Receber e incluir um novo pedido
        $dados = receberDadosPedido();
        $id_cliente = $dados->id_cliente;

        // Verifica se o cliente existe antes de criar o pedido
        if (verificarClienteExiste($conexao, $id_cliente)) {
            $resp = incluir_pedido($conexao, $dados);
            $resposta = $resp ? criarRespostaPedido('201', 'Pedido incluído com sucesso')
                              : criarRespostaPedido('400', 'Não foi possível incluir o pedido');
        } else {
            $resposta = criarRespostaPedido('400', 'Cliente não encontrado');
        }

        echo json_encode($resposta);
        break;

    case 'PUT':
        // Atualizar um pedido completo
        $dados = json_decode(file_get_contents('php://input'));
        $id_pedido = $dados->id_pedido;
        $id_cliente = $dados->id_cliente;

        // Verifica se o cliente existe antes de atualizar o pedido
        if (verificarClienteExiste($conexao, $id_cliente)) {
            $resp = editar_pedido($conexao, $dados, $id_pedido);
            $resposta = $resp ? criarRespostaPedido('204', 'Pedido atualizado com sucesso')
                              : criarRespostaPedido('400', 'Não foi possível atualizar o pedido');
        } else {
            $resposta = criarRespostaPedido('400', 'Cliente não encontrado');
        }

        echo json_encode($resposta);
        break;

    case 'PATCH':
        // Atualizar parcialmente um pedido
        $dados = json_decode(file_get_contents('php://input'), true);
        $id_pedido = $dados['id_pedido'];
        $campos_para_atualizar = $dados['atualizacoes'];

        // Verifica se o id_cliente foi incluído nas atualizações
        if (isset($campos_para_atualizar['id_cliente']) && !verificarClienteExiste($conexao, $campos_para_atualizar['id_cliente'])) {
            $resposta = criarRespostaPedido('400', 'Cliente não encontrado');
        } else {
            $resp = editar_pedido_parcialmente($conexao, $id_pedido, $campos_para_atualizar);
            $resposta = $resp ? criarRespostaPedido('204', 'Pedido atualizado parcialmente com sucesso')
                              : criarRespostaPedido('400', 'Não foi possível atualizar o pedido');
        }

        echo json_encode($resposta);
        break;

    case 'DELETE':
        // Excluir um pedido
        $dados = json_decode(file_get_contents('php://input'));
        $id_pedido = $dados->id_pedido;

        $resp = deletar_pedido($conexao, $id_pedido);
        $resposta = $resp ? criarRespostaPedido('204', 'Pedido excluído com sucesso')
                          : criarRespostaPedido('400', 'Não foi possível excluir o pedido');

        echo json_encode($resposta);
        break;

    default:
        // Método não permitido
        http_response_code(405);
        echo json_encode(criarRespostaPedido('405', 'Método não permitido'));
        break;
}
?>
