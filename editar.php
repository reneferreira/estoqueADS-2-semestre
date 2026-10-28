<?php
// Ao abrir este arquivo diretamente, carrega a tela e o contexto comum.
if (!defined('CONTEXTO_PRODUTOS')) {
    $operacaoProduto = 'editar';
    require __DIR__ . '/produtos.php';
    exit;
}
    // Editar começa com uma consulta por ID para preencher o formulário.
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['editar'])) {
        $id = filter_var($_GET['editar'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
        if ($id === false) {
            $erros[] = 'Identificador inválido.';
        } else {
            $comando = $pdo->prepare('SELECT * FROM produtos WHERE id = :id');
            $comando->execute(['id' => $id]);
            $registro = $comando->fetch();
            if (!$registro) {
                $erros[] = 'Produto não encontrado.';
            } else {
                $idEdicao = $id;
                $campos['nome'] = $registro['nome'];
                $campos['categoria_id'] = (string) (array_search($registro['categoria'], array_column($categorias, 'nome', 'id'), true) ?: '');
                $campos['quantidade_produto'] = (string) $registro['quantidade'];
                $campos['estoque_minimo'] = (string) $registro['estoque_minimo'];
                $campos['preco_unitario'] = $registro['preco'];
            }
        }
    }
// GET preenche o formulário; POST valida e salva as alterações.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idEdicao = filter_var($_POST['id'] ?? '', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    if ($idEdicao === false) {
        $erros[] = 'Identificador inválido.';
    } else {
        $comando = $pdo->prepare('SELECT id FROM produtos WHERE id = :id');
        $comando->execute(['id' => $idEdicao]);
        if (!$comando->fetch()) {
            $erros[] = 'Produto não encontrado.';
        }
    }
    require __DIR__ . '/validar-produto.php';
    if (!$erros) {
        // WHERE é obrigatório para alterar somente o produto escolhido.
        $sql = 'UPDATE produtos SET nome = :nome, categoria = :categoria,
                quantidade = :quantidade, estoque_minimo = :estoque_minimo,
                preco = :preco WHERE id = :id';
        $dados = [
            'nome' => $nome,
            'categoria' => $categoria,
            'quantidade' => $quantidade,
            'estoque_minimo' => $estoqueMinimo,
            'preco' => $preco
        ];
        $dados['id'] = $idEdicao;
        $comando = $pdo->prepare($sql);
        $comando->execute($dados);
        $_SESSION['sucesso_produto'] = 'Produto atualizado com sucesso!';
        header('Location: ' . $paginaProdutos, true, 303);
        exit;
    }
}