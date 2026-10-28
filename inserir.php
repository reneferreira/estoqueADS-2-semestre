<?php
// Ao abrir este arquivo diretamente, carrega a tela e o contexto comum.
if (!defined('CONTEXTO_PRODUTOS')) {
    $operacaoProduto = 'inserir';
    require __DIR__ . '/produtos.php';
    exit;
}
// POST recebe os campos; a validação impede gravar dados inválidos.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require __DIR__ . '/validar-produto.php';
    if (!$erros) {
        // INSERT cria um novo registro. Os valores são enviados separadamente.
        $sql = 'INSERT INTO produtos (nome, categoria, quantidade, estoque_minimo, preco)
                VALUES (:nome, :categoria, :quantidade, :estoque_minimo, :preco)';
        $dados = [
            'nome' => $nome,
            'categoria' => $categoria,
            'quantidade' => $quantidade,
            'estoque_minimo' => $estoqueMinimo,
            'preco' => $preco
        ];
        $comando = $pdo->prepare($sql);
        $comando->execute($dados);
        $_SESSION['sucesso_produto'] = 'Produto adicionado com sucesso!';
        header('Location: ' . $paginaProdutos, true, 303);
        exit;
    }
}