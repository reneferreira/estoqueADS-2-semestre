<?php
// Ao abrir este arquivo diretamente, carrega a tela e o contexto comum.
if (!defined('CONTEXTO_PRODUTOS')) {
    $operacaoProduto = 'listar';
    require __DIR__ . '/produtos.php';
    exit;
}
// Consulta sem entrada do usuário: query() pode ser usado diretamente.
$produtos = $pdo->query('SELECT id, nome, quantidade, estoque_minimo FROM produtos ORDER BY id DESC')->fetchAll();
