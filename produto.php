<?php
$paginaProdutos = 'produto.php';
require __DIR__ . '/contexto-produtos.php';
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
                    <h2><?= $idEdicao ? 'Editar produto' : 'Cadastrar produto' ?></h2>
                    <p>Preencha os campos e salve o produto.</p>
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
                <form class="formulario-produto" method="POST" action="<?= $idEdicao ? 'editar.php' : 'inserir.php' ?>">
                    <input type="hidden" name="origem" value="<?= $paginaProdutos ?>">
                    <input type="hidden" name="acao" value="<?= $idEdicao ? 'editar' : 'cadastrar' ?>">
                    <input type="hidden" name="id" value="<?= escaparProduto($idEdicao) ?>">
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

                    <button class="botao-primario" type="submit"><?= $idEdicao ? 'Salvar alterações' : 'Adicionar produto' ?></button>
                    <?php if ($idEdicao): ?>
                        <a class="botao-secundario" href="<?= $paginaProdutos ?>">Cancelar edição</a>
                    <?php endif; ?>
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
                            <tr>
                                <th>Produto</th>
                                <th>Quantidade</th>
                                <th>Situação</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($produtos as $produto) { ?>
                                <tr class="<?= $produto["quantidade"] <= $produto["estoque_minimo"] ? "baixo-estoque" : "" ?>">
                                    <td><strong><?= htmlspecialchars($produto["nome"], ENT_QUOTES, "UTF-8") ?></strong></td>
                                    <td><?= (int) $produto["quantidade"] ?> un.</td>
                                    <td><span class="etiqueta <?= $produto["quantidade"] <= $produto["estoque_minimo"] ? "estoque-baixo" : "" ?>"><?= $produto["quantidade"] <= $produto["estoque_minimo"] ? "Estoque baixo" : "Disponivel" ?></span></td>
                                    <td>
                                        <div class="acoes-produto">
                                            <a class="botao-secundario" href="editar.php?origem=<?= $paginaProdutos ?>&amp;editar=<?= (int) $produto['id'] ?>">Editar</a>
                                            <!-- Cada formulário envia apenas o ID da sua linha. -->


                                            <form method="POST" action="deletar.php" onsubmit="return confirm('Deseja excluir este produto? Esta ação não pode ser desfeita.');">
                                                <input type="hidden" name="origem" value="<?= $paginaProdutos ?>">
                                                <input type="hidden" name="acao" value="excluir">
                                                <input type="hidden" name="id" value="<?= (int) $produto['id'] ?>">
                                                <input type="hidden" name="csrf" value="<?= escaparProduto($_SESSION['csrf_produto']) ?>">
                                                <button class="botao-excluir" type="submit">Exclui</button>
                                            </form>
                                        </div>
                                    </td>
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