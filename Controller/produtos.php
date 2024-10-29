<?php
require 'utils.php';
require_once '../DAO/conexao.php';
require_once '../DAO/Get.php';
require_once '../DAO/Post.php';
require_once '../DAO/Put.php';
require_once '../DAO/Patch.php';
require '../DAO/Delete.php';
require '../Model/Produto.php';
require '../Model/Resposta.php';

$req = $_SERVER;
$conexao = conectar();

switch ($req["REQUEST_METHOD"]) {
    case 'GET':
        // Obter todos os produtos
        $produtos = obter_produtos($conexao);
        echo json_encode($produtos);
        break;

    case 'POST':
        // Receber e incluir um novo produto
        $dados = receberDadosProduto();
        $resp = incluir_produto($conexao, $dados);

        $resposta = new Resposta('', '');
        if ($resp) {
            $resposta = criarRespostaProduto('201', 'Produto incluído com sucesso');
        } else {
            $resposta = criarRespostaProduto('400', 'Não foi possível incluir o produto');
        }
        echo json_encode($resposta);
        break;

    case 'PUT':
        // Atualizar um produto completo
        $dados = json_decode(file_get_contents('php://input'));
        $id_produto = $dados->id_produto; // Usando id_produto
        $produto = receberDadosProduto();

        $resp = editar_produto($conexao, $produto, $id_produto); // Usando id_produto
        $resposta = new Resposta('', '');
        if ($resp) {
            $resposta = criarRespostaProduto('204', 'Produto atualizado com sucesso');
        } else {
            $resposta = criarRespostaProduto('400', 'Não foi possível atualizar o produto');
        }
        echo json_encode($resposta);
        break;

    case 'PATCH':
        // Atualizar parcialmente um produto
        $dados = json_decode(file_get_contents('php://input'), true); // Usando `true` para obter um array associativo
        $id_produto = $dados['id_produto']; // Usando id_produto
        $campos_para_atualizar = $dados['atualizacoes']; // Array associativo com campos a serem atualizados

        $resp = editar_produto_parcialmente($conexao, $id_produto, $campos_para_atualizar); // Usando id_produto
        $resposta = new Resposta('', '');

        if ($resp) {
            $resposta = criarRespostaProduto('204', 'Produto atualizado parcialmente com sucesso');
        } else {
            $resposta = criarRespostaProduto('400', 'Não foi possível atualizar o produto');
        }

        echo json_encode($resposta);
        break;

    case 'DELETE':
        // Excluir um produto
        $dados = json_decode(file_get_contents('php://input'));
        $id_produto = $dados->id_produto; // Usando id_produto
        
        // Verifica se o produto existe antes de excluir
        if (verificarProdutoExiste($conexao, $id_produto)) {
            $resp = deletar_produto($conexao, $id_produto); // Usando id_produto
            $resposta = $resp ? criarRespostaProduto('204', 'Produto excluído com sucesso')
                              : criarRespostaProduto('400', 'Não foi possível excluir o produto');
        } else {
            $resposta = criarRespostaProduto('400', 'Produto não encontrado');
        }

        echo json_encode($resposta);
        break;

    default:
        // Método não permitido
        http_response_code(405);
        echo json_encode(criarRespostaProduto('405', 'Método não permitido'));
        break;
}
?>
