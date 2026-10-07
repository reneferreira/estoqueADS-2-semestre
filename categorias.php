<?php
$produtos = [
    ["nome" => "Teclado", "quantidade" => 8],
    ["nome" => "Mouse", "quantidade" => 3]
];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST["nome"] ?? "");
    $qtd = (int) ($_POST["quantidade"] ?? 0);

    if ($nome !== "" && $qtd >= 0) {
        $produtos[] = ["nome" => $nome, "quantidade" => $qtd];
    }
}

require_once "conexao.php";


$tituloPagina = "Categorias";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estoque Facil | Categorias</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <div class="pagina">
        <?php include "menu.php"; ?>
        <main class="conteudo">
            <?php include "cabecalho.php"; ?>

            <section class="painel painel-produtos">
                <div class="painel-titulo">
                    <h2>Cadastrar Categoria</h2>
                    <p>Preencha os campos para adicionar um item ao estoque.</p>
                </div>
                <form class="formulario-produto" method="POST">
                    <div class="campo-formulario">
                        <label for="nome">Nome do produto</label>
                        <input type="text" name="nome" id="nome" placeholder="Ex.: Teclado USB" required>
                    </div>

                    <div class="campo-formulario">
                        <label for="quantidade_produto">Quantidade</label>
                        <input type="number" name="quantidade_produto" id="quantidade_produto" min="0" placeholder="0" required>
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
                                <tr class="<?= $produto["quantidade"] <= 5 ? "baixo-estoque" : "" ?>">
                                    <td><strong><?= htmlspecialchars($produto["nome"], ENT_QUOTES, "UTF-8") ?></strong></td>
                                    <td><?= $produto["quantidade"] ?> un.</td>
                                    <td><span class="etiqueta <?= $produto["quantidade"] <= 5 ? "estoque-baixo" : "" ?>"><?= $produto["quantidade"] <= 5 ? "Estoque baixo" : "Disponivel" ?></span></td>
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
