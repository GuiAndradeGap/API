<?php 
require 'utils.php';
require_once '../DAO/conexao.php';
require_once '../DAO/Get.php';
require_once '../DAO/Post.php';
require_once '../DAO/Put.php';
require_once '../DAO/Patch.php';
require '../DAO/Delete.php';
require '../Model/Pedido_Produto.php';
require '../Model/Resposta.php';

$req = $_SERVER;
$conexao = conectar();

switch ($req["REQUEST_METHOD"]) {
    case 'GET':
        echo json_encode(obter_pedidos_produtos($conexao));
        break;

    case 'POST':
        $dados = receberDadosPedidoProduto();
        $id_pedido = $dados->id_pedido;
        $id_produto = $dados->id_produto;
        $qtd = $dados->qtd;

        if (verificarPedidoExiste($conexao, $id_pedido) && verificarProdutoExiste($conexao, $id_produto)) {
            if (verificarPedidoProdutoExiste($conexao, $id_pedido, $id_produto)) {
                $resposta = criarRespostaPedidoProduto('400', 'Pedido Produto já existe com esta combinação.');
            } else {
                $resp = incluir_pedido_produto($conexao, $dados);
                $resposta = $resp 
                    ? criarRespostaPedidoProduto('201', 'Pedido Produto incluído com sucesso')
                    : criarRespostaPedidoProduto('400', 'Não foi possível incluir o Pedido Produto');
            }
        } else {
            $resposta = criarRespostaPedidoProduto('400', 'Pedido ou Produto não encontrado');
        }

        echo json_encode($resposta);
        break;

    case 'PUT':
        $dados = json_decode(file_get_contents('php://input'));
        $id_pedido = $dados->id_pedido;
        $id_produto = $dados->id_produto;
        $qtd = $dados->qtd;
        $pedido_produto = new PedidoProduto($id_pedido, $id_produto, $qtd);

        if (verificarPedidoExiste($conexao, $id_pedido) && verificarProdutoExiste($conexao, $id_produto)) {
            $resp = editar_pedido_produto($conexao, $pedido_produto, $id_pedido, $id_produto);
            $resposta = $resp 
                ? criarRespostaPedidoProduto('204', 'Pedido Produto atualizado com sucesso')
                : criarRespostaPedidoProduto('400', 'Não foi possível atualizar o Pedido Produto');
        } else {
            $resposta = criarRespostaPedidoProduto('400', 'Pedido ou Produto não encontrado');
        }
        
        echo json_encode($resposta);
        break;

    case 'PATCH':
        $dados = json_decode(file_get_contents('php://input'), true);
        $id_pedido = $dados['pedido_id'];
        $id_produto = $dados['produto_id'];
        $campos_para_atualizar = $dados['atualizacoes'];

        if (!verificarPedidoExiste($conexao, $id_pedido) || !verificarProdutoExiste($conexao, $id_produto)) {
            $resposta = criarRespostaPedidoProduto('400', 'Pedido ou Produto não encontrado');
        } else {
            if (isset($campos_para_atualizar['qtd'])) {
                $campos_para_atualizar['qtd'] = $dados['atualizacoes']['qtd'];
            }

            $resp = editar_pedido_produto_parcialmente($conexao, $id_pedido, $id_produto, $campos_para_atualizar);
            $resposta = $resp 
                ? criarRespostaPedidoProduto('204', 'Pedido Produto atualizado parcialmente com sucesso')
                : criarRespostaPedidoProduto('400', 'Não foi possível atualizar o Pedido Produto');
        }

        echo json_encode($resposta);
        break;

    case 'DELETE':
        $dados = json_decode(file_get_contents('php://input'));
        $id_pedido = $dados->id_pedido;
        $id_produto = $dados->id_produto;

        if (verificarPedidoExiste($conexao, $id_pedido) && verificarProdutoExiste($conexao, $id_produto)) {
            $resp = deletar_pedido_produto($conexao, $id_pedido, $id_produto);
            $resposta = $resp 
                ? criarRespostaPedidoProduto('204', 'Pedido Produto excluído com sucesso')
                : criarRespostaPedidoProduto('400', 'Não foi possível excluir o Pedido Produto');
        } else {
            $resposta = criarRespostaPedidoProduto('400', 'Pedido ou Produto não encontrado');
        }

        echo json_encode($resposta);
        break;

    default:
        http_response_code(405);
        echo json_encode(criarRespostaPedidoProduto('405', 'Método não permitido'));
        break;
}
?>
