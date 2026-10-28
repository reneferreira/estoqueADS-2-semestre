<?php
// Ao abrir este arquivo diretamente, carrega a tela e o contexto comum.
if (!defined('CONTEXTO_PRODUTOS')) {
    $operacaoProduto = 'deletar';
    require __DIR__ . '/produtos.php';
    exit;
}
    // Excluir usa POST e token CSRF. Um link GET nunca apaga registros.
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = filter_var($_POST['id'] ?? '', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
        if (!is_string($_POST['csrf'] ?? null) || !hash_equals($_SESSION['csrf_produto'], $_POST['csrf'])) {
            $erros[] = 'Formulário inválido. Recarregue a página.';
        } elseif ($id === false) {
            $erros[] = 'Identificador inválido.';
        } else {
            // WHERE limita a exclusão ao produto escolhido. Nunca omita essa condição!
            $comando = $pdo->prepare('DELETE FROM produtos WHERE id = :id');
            $comando->execute(['id' => $id]);
            if ($comando->rowCount() === 0) {
                $erros[] = 'Produto não encontrado.';
            } else {
                $_SESSION['sucesso_produto'] = 'Produto excluído com sucesso!';
                header('Location: ' . $paginaProdutos, true, 303);
                exit;
            }
        }
    }
