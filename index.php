<?php

$nomeSistema = "Estoque Fácil";
$produtos = [
    [
        "nome" => "Teclado",
        "categoria" => "Informática",
        "quantidade" => 10,
        "preco" => 99.90
    ],
    [
        "nome" => "Mouse",
        "categoria" => "Informática",
        "quantidade" => 5,
        "preco" => 49.90
    ],
    [
        "nome" => "Caderno",
        "categoria" => "Papelaria",
        "quantidade" => 20,
        "preco" => 15.50
    ]
];

$totalProdutos = count($produtos);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $nomeSistema ?> | Painel</title>
    <link rel="stylesheet" href="css/estilo.css">
  
</head>

<body>
    <div class="pagina">

    <!-- inicio menu lateral -->

     <?php include "menu.php"; ?>
        <main class="conteudo">
          
        <?php include "cabecalho.php"; ?>

            <section class="resumo">
                <article class="cartao">
                    <span>Produtos ativos</span>
                    <strong>24</strong>
                    <small>itens cadastrados</small>
                </article>

                <article class="cartao">
                    <span>Unidades em estoque</span>
                    <strong>387</strong>
                    <small>saldo total disponivel</small>
                </article>

                <article class="cartao">
                    <span>Valor em estoque</span>
                    <strong>R$ 8.450,00</strong>
                    <small>baseado no preco de custo</small>
                </article>

                <article class="cartao alerta">
                    <span>Estoque baixo</span>
                    <strong>3</strong>
                    <small>produtos pedindo atenção</small>
                </article>
            </section>

            <section class="atalhos">
                <a class="atalho" href="#">
                    <strong>Registrar entrada</strong>
                    <span>Atualizar produtos recebidos</span>
                </a>

                <a class="atalho" href="#">
                    <strong>Registrar saida</strong>
                    <span>Dar baixa no estoque</span>
                </a>

                <a class="atalho" href="#">
                    <strong>Novo produto</strong>
                    <span>Adicionar item ao catalogo</span>
                </a>
            </section>

            <div class="grade-paineis">
                <section class="painel">
                    <div class="painel-titulo">
                        <h2>Movimentações recentes</h2>
                        <p>Últimas operações registradas</p>
                    </div>

                    <div class="tabela-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Produto</th>
                                    <th>Tipo</th>
                                    <th>Quantidade</th>
                                    <th>Data</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>Teclado USB</strong><small>Informática</small></td>
                                    <td><span class="etiqueta">Entrada</span></td>
                                    <td>10</td>
                                    <td>14/08/2026</td>
                                </tr>
                                <tr>
                                    <td><strong>Mouse sem fio</strong><small>Informática</small></td>
                                    <td><span class="etiqueta saida">Saída</span></td>
                                    <td>2</td>
                                    <td>13/08/2026</td>
                                </tr>
                                <tr>
                                    <td><strong>Papel A4</strong><small>Escritório</small></td>
                                    <td><span class="etiqueta">Entrada</span></td>
                                    <td>20</td>
                                    <td>12/08/2026</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>

                <section class="painel">
                    <div class="painel-titulo">
                        <h2>Reposição necessária</h2>
                        <p>Produtos no limite mínimo</p>
                    </div>

                    <ul class="lista-produtos">
                        <li>
                            <span><strong>Mouse sem fio</strong><small>Mínimo: 5</small></span>
                            <b>3 un.</b>
                        </li>
                        <li>
                            <span><strong>Toner preto</strong><small>Mínimo: 3</small></span>
                            <b>2 un.</b>
                        </li>
                        <li>
                            <span><strong>Cabo HDMI</strong><small>Mínimo: 5</small></span>
                            <b>4 un.</b>
                        </li>
                    </ul>
                </section>
            </div>

         <?php include "rodape.php"; ?>
        </main>
    </div>
</body>
</html>
