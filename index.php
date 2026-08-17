<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estoque Facil | Painel</title>

    <style>
        * {
            box-sizing: border-box;
        }

        :root {
            --verde-escuro: #15251e;
            --verde: #176b4d;
            --verde-claro: #e6f3ed;
            --fundo: #f4f7f5;
            --branco: #ffffff;
            --texto: #17221d;
            --texto-claro: #68736d;
            --borda: #dce3df;
            --vermelho: #b33b36;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background-color: var(--fundo);
            color: var(--texto);
        }

        .pagina {
            min-height: 100vh;
        }

        /* Conteudo principal */
        .conteudo {
            min-height: 100vh;
            margin-left: 240px;
            padding: 0 34px;
        }

        .cabecalho {
            height: 96px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 28px;
            border-bottom: 1px solid var(--borda);
        }

        .cabecalho h1 {
            margin: 3px 0 0;
            font-size: 25px;
        }

        .saudacao {
            color: var(--texto-claro);
            font-size: 12px;
        }

        .usuario {
            padding: 9px 12px;
            border: 1px solid var(--borda);
            border-radius: 6px;
            background-color: var(--branco);
            font-size: 12px;
            font-weight: bold;
        }

        /* Cartoes de resumo */
        .resumo {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 18px;
        }

        .cartao {
            padding: 20px;
            border: 1px solid var(--borda);
            border-top: 3px solid var(--verde);
            border-radius: 7px;
            background-color: var(--branco);
        }

        .cartao.alerta {
            border-top-color: #b66a16;
        }

        .cartao span,
        .cartao small {
            display: block;
            color: var(--texto-claro);
        }

        .cartao strong {
            display: block;
            margin: 10px 0 5px;
            font-size: 25px;
        }

        .cartao small {
            font-size: 11px;
        }

        /* Atalhos */
        .atalhos {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 22px;
        }

        .atalho {
            padding: 17px 20px;
            border-radius: 7px;
            background-color: var(--verde-escuro);
            color: var(--branco);
            text-decoration: none;
        }

        .atalho span {
            display: block;
            margin-top: 5px;
            color: #a9b8b0;
            font-size: 12px;
        }

        /* Paineis inferiores */
        .grade-paineis {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 18px;
        }

        .painel {
            overflow: hidden;
            border: 1px solid var(--borda);
            border-radius: 7px;
            background-color: var(--branco);
            box-shadow: 0 2px 10px rgba(23, 34, 29, 0.07);
        }

        .painel-titulo {
            padding: 19px 20px;
            border-bottom: 1px solid var(--borda);
        }

        .painel-titulo h2 {
            margin: 0;
            font-size: 16px;
        }

        .painel-titulo p {
            margin: 5px 0 0;
            color: var(--texto-claro);
            font-size: 12px;
        }

        .tabela-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            min-width: 620px;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 14px 18px;
            border-bottom: 1px solid #edf0ee;
            text-align: left;
        }

        th {
            background-color: #fafbfa;
            color: var(--texto-claro);
            font-size: 11px;
            text-transform: uppercase;
        }

        td small {
            display: block;
            margin-top: 4px;
            color: var(--texto-claro);
            font-size: 11px;
        }

        .etiqueta {
            display: inline-block;
            padding: 5px 8px;
            border-radius: 4px;
            background-color: var(--verde-claro);
            color: var(--verde);
            font-size: 11px;
            font-weight: bold;
        }

        .etiqueta.saida {
            background-color: #f9e7e5;
            color: #982f2b;
        }

        .lista-produtos {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .lista-produtos li {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 20px;
            border-bottom: 1px solid #edf0ee;
        }

        .lista-produtos small {
            display: block;
            margin-top: 4px;
            color: var(--texto-claro);
        }

        .lista-produtos b {
            color: var(--vermelho);
        }

        .rodape {
            padding: 36px 0 24px;
            color: #8a948f;
            font-size: 12px;
            text-align: center;
        }

        /* Ajustes para telas menores */
        @media (max-width: 1000px) {
            .resumo {
                grid-template-columns: 1fr 1fr;
            }

            .grade-paineis {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 700px) {
            .conteudo {
                margin-left: 0;
                padding: 0 16px;
            }

            .resumo,
            .atalhos {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="pagina">
        

        <main class="conteudo">
            <header class="cabecalho">
                <div>
                    <span class="saudacao">Ola, Alunos de ADS</span>
                    <h1>Visao geral</h1>
                </div>
                <span class="usuario">Administrador</span>
            </header>

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
                    <small>produtos pedindo atencao</small>
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
                        <h2>Movimentacoes recentes</h2>
                        <p>Ultimas operacoes registradas</p>
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
                                    <td><strong>Teclado USB</strong><small>Informatica</small></td>
                                    <td><span class="etiqueta">Entrada</span></td>
                                    <td>10</td>
                                    <td>14/08/2026</td>
                                </tr>
                                <tr>
                                    <td><strong>Mouse sem fio</strong><small>Informatica</small></td>
                                    <td><span class="etiqueta saida">Saida</span></td>
                                    <td>2</td>
                                    <td>13/08/2026</td>
                                </tr>
                                <tr>
                                    <td><strong>Papel A4</strong><small>Escritorio</small></td>
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
                        <h2>Reposicao necessaria</h2>
                        <p>Produtos no limite minimo</p>
                    </div>

                    <ul class="lista-produtos">
                        <li>
                            <span><strong>Mouse sem fio</strong><small>Minimo: 5</small></span>
                            <b>3 un.</b>
                        </li>
                        <li>
                            <span><strong>Toner preto</strong><small>Minimo: 3</small></span>
                            <b>2 un.</b>
                        </li>
                        <li>
                            <span><strong>Cabo HDMI</strong><small>Minimo: 5</small></span>
                            <b>4 un.</b>
                        </li>
                    </ul>
                </section>
            </div>

            <footer class="rodape">
                Estoque Facil &copy; 2026 - Projeto educacional
            </footer>
        </main>
    </div>
</body>
</html>
