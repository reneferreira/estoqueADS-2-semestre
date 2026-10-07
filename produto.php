<?php
session_start();
$produtos = [];
$erros = [];
$sucesso = $_SESSION['sucesso_produto'] ?? '';
unset($_SESSION['sucesso_produto']);

$_SESSION['csrf_produto'] ??= bin2hex(random_bytes(32));
$campos = array_fill_keys(['nome', 'categoria_id', 'quantidade_produto', 'estoque_minimo', 'preco_unitario'], '');

$categorias = [
  ["id" => 1, "nome" => "Informática"],
  ["id" => 2, "nome" => "Escritório"],
  ["id" => 3, "nome" => "Acessórios"]
];

try {
    require_once "conexao.php";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        foreach ($campos as $campo => $valor) {
            $campos[$campo] = is_string($_POST[$campo] ?? null) ? trim($_POST[$campo]) : '';
        }
        if (!is_string($_POST['csrf'] ?? null) || !hash_equals($_SESSION['csrf_produto'], $_POST['csrf'])) {
            $erros[] = 'Formulário expirado ou inválido. Recarregue a página e tente novamente.';
        }
        $nome = $campos['nome'];
        if ($nome === '' || mb_strlen($nome, 'UTF-8') > 120) {
            $erros[] = 'Informe um nome com até 120 caracteres.';
        }

        $categoriasPermitidas = array_column($categorias, 'nome', 'id');
        $categoria = $categoriasPermitidas[$campos['categoria_id']] ?? null;
        if ($categoria === null) {
            $erros[] = 'Selecione uma categoria válida.';
        }
        $quantidade = filter_var($campos['quantidade_produto'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 0, 'max_range' => 4294967295]]);
        $estoqueMinimo = filter_var($campos['estoque_minimo'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 0, 'max_range' => 2147483647]]);
        if ($quantidade === false || $estoqueMinimo === false) {
            $erros[] = 'Quantidade e estoque mínimo devem ser números inteiros não negativos, dentro do limite do banco.';
        }


        $preco = str_replace(',', '.', $campos['preco_unitario']);
        if (!preg_match('/^[0-9]{1,8}(\.[0-9]{1,2})?$/D', $preco)) {
            $erros[] = 'Informe um preço de 0 até 99999999,99, com no máximo duas casas decimais.';
        }

        if (!$erros) {
            $sql = 'INSERT INTO produtos (nome, categoria, quantidade, estoque_minimo, preco)
            VALUES (:nome, :categoria, :quantidade, :estoque_minimo, :preco)';
            $comando = $pdo->prepare($sql);
            $comando->execute([
                'nome' => $nome,
                'categoria' => $categoria,
                'quantidade' => $quantidade,
                'estoque_minimo' => $estoqueMinimo,
                'preco' => $preco
            ]);
            $_SESSION['sucesso_produto'] = 'Produto adicionado com sucesso!';
            header('Location: produtos.php', true, 303);
            exit;
        }
    }


    $produtos = $pdo->query('SELECT id, nome, quantidade, estoque_minimo FROM produtos ORDER BY id DESC')->fetchAll();
} catch (PDOException $erro) {

    error_log('Erro no banco de produtos: ' . $erro->getMessage());
    $erros[] = 'Não foi possível acessar o banco de dados. Tente novamente em instantes.';
}


function escaparProduto($valor): string {
    return htmlspecialchars((string) $valor, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$tituloPagina = "Produtos";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estoque Facil | Produtos</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <div class="pagina">
        <?php include "menu.php"; ?>
        <main class="conteudo">
            <?php include "cabecalho.php"; ?>

            <section class="painel painel-produtos">
                <div class="painel-titulo">
                    <h2>Cadastrar produto</h2>
                    <p>Preencha os campos para adicionar um item ao estoque.</p>
                </div>
                <?php if ($sucesso !== ''): ?>
                    <p class="mensagem-sucesso" role="status">
                        <span class="mensagem-sucesso-icone" aria-hidden="true">&#10003;</span>
                        <span><?= escaparProduto($sucesso)  ?></span>
                    </p>
                <?php endif; ?>
                <?php foreach ($erros as $mensagem): ?>
                    <p role="alert"><?= escaparProduto($mensagem) ?></p>
                <?php endforeach; ?>
                <form class="formulario-produto" method="POST">
                    <input type="hidden" name="csrf" value="<?= escaparProduto($_SESSION['csrf_produto']) ?>">
                    <div class="campo-formulario">
                        <label for="nome">Nome do produto</label>
                        <input type="text" name="nome" id="nome" maxlength="120" value="<?= escaparProduto($campos['nome']) ?>" placeholder="Ex.: Teclado USB" required>
                    </div>
                    <div class="campo-formulario">
                        <label for="categoria_id">Categoria</label>
                    <select name="categoria_id" id="categoria_id" required>
                        <option value="">Selecione</option>
                        <?php foreach ($categorias as $categoria): ?>
                            <option value="<?= $categoria["id"] ?>" <?= $campos['categoria_id'] === (string) $categoria['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($categoria["nome"]) ?>
                            </option>
                        <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="campo-formulario">
                        <label for="quantidade_produto">Quantidade</label>
                        <input type="number" name="quantidade_produto" id="quantidade_produto" value="<?= escaparProduto($campos['quantidade_produto']) ?>" min="0" placeholder="0" required>
                    </div>

                    <div class="campo-formulario">
                        <label for="estoque_minimo">Estoque Mínimo</label>
                        <input type="number" name="estoque_minimo" id="estoque_minimo" value="<?= escaparProduto($campos['estoque_minimo']) ?>" min="0" placeholder="0" required>
                    </div>
                    <div class="campo-formulario">
                        <label for="preco_unitario">Preço Unitário</label>
                        <input type="number" name="preco_unitario" id="preco_unitario" value="<?= escaparProduto($campos['preco_unitario']) ?>"
                            min="0" step="0.01" required>
                    </div>

                    <button class="botao-primario" type="submit">Adicionar produto</button>
                </form>
            </section>

            <section class="painel painel-produtos">
                <div class="painel-titulo">
                    <h2>Produtos cadastrados</h2>
                    <p><?= count($produtos) ?> itens encontrados no estoque.</p>
                </div>
                <div class="tabela-container">
                    <table>
                        <thead>
                            <tr><th>Produto</th><th>Quantidade</th><th>Situacao</th></tr>
                        </thead>
                        <tbody>
                            <?php foreach ($produtos as $produto) { ?>
                                <tr class="<?= $produto["quantidade"] <= $produto["estoque_minimo"] ? "baixo-estoque" : "" ?>">
                                    <td><strong><?= htmlspecialchars($produto["nome"], ENT_QUOTES, "UTF-8") ?></strong></td>
                                    <td><?= (int) $produto["quantidade"] ?> un.</td>
                                    <td><span class="etiqueta <?= $produto["quantidade"] <= $produto["estoque_minimo"] ? "estoque-baixo" : "" ?>"><?= $produto["quantidade"] <= $produto["estoque_minimo"] ? "Estoque baixo" : "Disponivel" ?></span></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <?php include "rodape.php"; ?>
        </main>
    </div>
</body>
</html>
