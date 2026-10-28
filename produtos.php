<?php
$paginaProdutos = 'produtos.php';
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
        <?php /* include carrega o HTML e o PHP do menu nesta posição da página. */ ?>
        <?php include "menu.php"; ?>
        <main class="conteudo">
            <?php /* Inclui o cabeçalho, que utiliza a variável $tituloPagina definida acima. */ ?>
            <?php include "cabecalho.php"; ?>

            <section class="painel painel-produtos">
                <div class="painel-titulo">
                    <h2><?= $idEdicao ? 'Editar produto' : 'Cadastrar produto' ?></h2>
                    <p>Preencha os campos e salve o produto.</p>
                </div>
                <?php /* Só mostra o aviso quando há uma mensagem de sucesso; !== significa diferente em valor ou tipo. */ ?>
                <?php if ($sucesso !== ''): ?>
                    <p class="mensagem-sucesso" role="status">
                        <span class="mensagem-sucesso-icone" aria-hidden="true">&#10003;</span>
                        <span><?= escaparProduto($sucesso) /* Exibe a mensagem com caracteres HTML escapados. */ ?></span>
                    </p>
                    <?php /* Encerra o if escrito na sintaxe alternativa com dois-pontos, útil ao misturar PHP e HTML. */ ?>
                <?php endif; ?>
                <?php /* Percorre as mensagens de erro para exibir uma de cada vez. */ ?>
                <?php foreach ($erros as $mensagem): ?>
                    <?php /* <?= é a forma curta de echo: imprime a mensagem escapada no HTML. */ ?>
                    <p role="alert"><?= escaparProduto($mensagem) ?></p>
                    <?php /* Encerra o foreach escrito na sintaxe alternativa com dois-pontos. */ ?>
                <?php endforeach; ?>
                <form class="formulario-produto" method="POST" action="<?= $idEdicao ? 'editar.php' : 'inserir.php' ?>">
                    <input type="hidden" name="origem" value="<?= $paginaProdutos ?>">
                    <input type="hidden" name="acao" value="<?= $idEdicao ? 'editar' : 'cadastrar' ?>">
                    <input type="hidden" name="id" value="<?= escaparProduto($idEdicao) ?>">
                    <?php /* Envia o token da sessão em um campo oculto para conferência no próximo POST. */ ?>
                    <input type="hidden" name="csrf" value="<?= escaparProduto($_SESSION['csrf_produto']) ?>">
                    <div class="campo-formulario">
                        <label for="nome">Nome do produto</label>
                        <?php /* Reexibe o nome enviado quando a validação falha; escaparProduto protege o atributo HTML. */ ?>
                        <input type="text" name="nome" id="nome" maxlength="120" value="<?= escaparProduto($campos['nome']) ?>" placeholder="Ex.: Teclado USB" required>
                    </div>
                    <div class="campo-formulario">
                        <label for="categoria_id">Categoria</label>
                        <select name="categoria_id" id="categoria_id" required>
                            <option value="">Selecione</option>
                            <?php /* Repete as opções do select, usando uma categoria por passagem do laço. */ ?>
                            <?php foreach ($categorias as $categoria): ?>
                                <?php /* Envia o id da categoria; o ternário imprime selected se esta foi a opção enviada anteriormente. */ ?>
                                <option value="<?= $categoria["id"] ?>" <?= $campos['categoria_id'] === (string) $categoria['id'] ? 'selected' : '' ?>>
                                    <?php /* Exibe o nome da categoria escapando caracteres especiais do HTML. */ ?>
                                    <?= htmlspecialchars($categoria["nome"]) ?>
                                </option>
                                <?php /* Encerra o foreach escrito na sintaxe alternativa com dois-pontos. */ ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="campo-formulario">
                        <label for="quantidade_produto">Quantidade</label>
                        <?php /* Mantém a quantidade digitada quando o formulário precisa ser corrigido. */ ?>
                        <input type="number" name="quantidade_produto" id="quantidade_produto" value="<?= escaparProduto($campos['quantidade_produto']) ?>" min="0" placeholder="0" required>
                    </div>

                    <div class="campo-formulario">
                        <label for="estoque_minimo">Estoque Mínimo</label>
                        <?php /* Mantém o estoque mínimo digitado, escapado para uso no atributo value. */ ?>
                        <input type="number" name="estoque_minimo" id="estoque_minimo" value="<?= escaparProduto($campos['estoque_minimo']) ?>" min="0" placeholder="0" required>
                    </div>
                    <div class="campo-formulario">
                        <label for="preco_unitario">Preço Unitário</label>
                        <?php /* Mantém o preço digitado para que o aluno possa corrigir o formulário sem preenchê-lo novamente. */ ?>
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
                    <?php /* count conta os elementos do array e exibe o total de produtos retornados pelo banco. */ ?>
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
                            <?php /* Percorre os produtos consultados e gera uma linha da tabela para cada um. */ ?>
                            <?php foreach ($produtos as $produto) { ?>
                                <?php /* Se a quantidade for menor ou igual ao mínimo, aplica a classe CSS baixo-estoque; senão, deixa a classe vazia. */ ?>
                                <tr class="<?= $produto["quantidade"] <= $produto["estoque_minimo"] ? "baixo-estoque" : "" ?>">
                                    <?php /* Exibe o nome como texto: ENT_QUOTES escapa também as aspas, impedindo que o nome seja interpretado como HTML. */ ?>
                                    <td><strong><?= htmlspecialchars($produto["nome"], ENT_QUOTES, "UTF-8") ?></strong></td>
                                    <?php /* (int) converte a quantidade para inteiro antes de exibi-la. */ ?>
                                    <td><?= (int) $produto["quantidade"] ?> un.</td>
                                    <?php /* Os dois ternários escolhem a classe CSS e o texto da situação conforme o estoque mínimo do produto. */ ?>
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
                                                <button class="botao-excluir" type="submit">Excluir</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <?php /* Fecha o foreach dos produtos, encerrando a repetição das linhas da tabela. */ ?>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <?php /* Inclui o rodapé compartilhado pelas páginas. */ ?>
            <?php include "rodape.php"; ?>
        </main>
    </div>
</body>

</html>