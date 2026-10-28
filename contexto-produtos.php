<?php
// Este arquivo prepara os dados usados pelas duas versões da tela.
session_start();
define('CONTEXTO_PRODUTOS', true);
$origem = $_POST['origem'] ?? $_GET['origem'] ?? $paginaProdutos;
// Lista fixa: nunca redirecionamos para um endereço fornecido livremente.
$paginaProdutos = $origem === 'produto.php' ? 'produto.php' : 'produtos.php';
$idEdicao = null;
$produtos = [];
$erros = [];
$sucesso = $_SESSION['sucesso_produto'] ?? '';
unset($_SESSION['sucesso_produto']);
$_SESSION['csrf_produto'] ??= bin2hex(random_bytes(32));
$campos = array_fill_keys(['nome', 'categoria_id', 'quantidade_produto', 'estoque_minimo', 'preco_unitario'], '');
$categorias = [
    ['id' => 1, 'nome' => 'Informática'],
    ['id' => 2, 'nome' => 'Escritório'],
    ['id' => 3, 'nome' => 'Acessórios']
];
try {
    require __DIR__ . '/conexao.php';
    // Cada operação tem um arquivo próprio. Os nomes abaixo são fixos.
    if (($operacaoProduto ?? '') === 'editar' || isset($_GET['editar'])) {
        require __DIR__ . '/editar.php';
    } elseif (($operacaoProduto ?? '') === 'deletar') {
        require __DIR__ . '/deletar.php';
    } elseif (($operacaoProduto ?? '') === 'inserir') {
        require __DIR__ . '/inserir.php';
    }
    require __DIR__ . '/listar.php';
} catch (PDOException $erro) {
    error_log('Erro no banco de produtos: ' . $erro->getMessage());
    $erros[] = 'Não foi possível acessar o banco de dados. Tente novamente em instantes.';
}
function escaparProduto($valor): string {
    return htmlspecialchars((string) $valor, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
$tituloPagina = 'Produtos';