<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estoque Facil | Painel</title>

    <style>
        * {
            box-sizing: border-box; /* Inclui bordas e preenchimento no tamanho total dos elementos. */
        }

        :root {
            --verde-escuro: #15251e; /* Armazena o verde escuro usado no menu e nos atalhos. */
            --verde: #176b4d; /* Armazena a cor verde principal da interface. */
            --verde-claro: #e6f3ed; /* Armazena o verde claro usado em destaques. */
            --fundo: #f4f7f5; /* Armazena a cor de fundo geral da pagina. */
            --branco: #ffffff; /* Armazena a cor branca usada nos componentes. */
            --texto: #17221d; /* Armazena a cor principal dos textos. */
            --texto-claro: #68736d; /* Armazena a cor dos textos secundarios. */
            --borda: #dce3df; /* Armazena a cor padrao das bordas. */
            --vermelho: #b33b36; /* Armazena a cor usada em alertas. */
        }

        body {
            margin: 0; /* Remove a margem padrao aplicada pelo navegador. */
            font-family: Arial, Helvetica, sans-serif; /* Define a familia de fontes da pagina. */
            background-color: var(--fundo); /* Aplica a cor de fundo geral. */
            color: var(--texto); /* Define a cor principal do texto. */
        }

        .pagina {
            min-height: 100vh; /* Garante que a pagina tenha ao menos a altura da tela. */
        }

        /* Conteudo principal */
        .conteudo {
            min-height: 100vh; /* Garante que o conteudo cubra a altura da tela. */
            margin-left: 240px; /* Reserva espaco para o menu lateral. */
            padding: 0 34px; /* Adiciona espacamento nas laterais do conteudo. */
        }

        .cabecalho {
            height: 96px; /* Define a altura do cabecalho. */
            display: flex; /* Organiza os elementos do cabecalho lado a lado. */
            align-items: center; /* Centraliza os elementos verticalmente. */
            justify-content: space-between; /* Posiciona os elementos nas extremidades. */
            margin-bottom: 28px; /* Separa o cabecalho do conteudo seguinte. */
            border-bottom: 1px solid var(--borda); /* Adiciona uma linha abaixo do cabecalho. */
        }

        .cabecalho h1 {
            margin: 3px 0 0; /* Adiciona uma pequena margem acima do titulo. */
            font-size: 25px; /* Define o tamanho do titulo principal. */
        }

        .saudacao {
            color: var(--texto-claro); /* Aplica uma cor secundaria a saudacao. */
            font-size: 12px; /* Define um tamanho menor para a saudacao. */
        }

        .usuario {
            padding: 9px 12px; /* Cria espacamento interno no identificador do usuario. */
            border: 1px solid var(--borda); /* Adiciona uma borda ao identificador. */
            border-radius: 6px; /* Arredonda os cantos do identificador. */
            background-color: var(--branco); /* Aplica fundo branco ao identificador. */
            font-size: 12px; /* Define o tamanho do nome do usuario. */
            font-weight: bold; /* Exibe o nome do usuario em negrito. */
        }

        /* Cartoes de resumo */
        .resumo {
            display: grid; /* Organiza os cartoes em uma grade. */
            grid-template-columns: repeat(4, 1fr); /* Cria quatro colunas de mesma largura. */
            gap: 16px; /* Define a distancia entre os cartoes. */
            margin-bottom: 18px; /* Separa o resumo da secao seguinte. */
        }

        .cartao {
            padding: 20px; /* Cria espacamento interno no cartao. */
            border: 1px solid var(--borda); /* Adiciona uma borda ao redor do cartao. */
            border-top: 3px solid var(--verde); /* Destaca o topo do cartao em verde. */
            border-radius: 7px; /* Arredonda os cantos do cartao. */
            background-color: var(--branco); /* Aplica fundo branco ao cartao. */
        }

        .cartao.alerta {
            border-top-color: #b66a16; /* Altera a borda superior para indicar alerta. */
        }

        .cartao span,
        .cartao small {
            display: block; /* Faz cada texto ocupar uma linha propria. */
            color: var(--texto-claro); /* Aplica uma cor secundaria aos textos. */
        }

        .cartao strong {
            display: block; /* Faz o valor ocupar uma linha propria. */
            margin: 10px 0 5px; /* Separa o valor dos textos ao redor. */
            font-size: 25px; /* Destaca o valor com fonte maior. */
        }

        .cartao small {
            font-size: 11px; /* Define um tamanho pequeno para a descricao. */
        }

        /* Atalhos */
        .atalhos {
            display: grid; /* Organiza os atalhos em uma grade. */
            grid-template-columns: repeat(3, 1fr); /* Cria tres colunas de mesma largura. */
            gap: 16px; /* Define a distancia entre os atalhos. */
            margin-bottom: 22px; /* Separa os atalhos dos paineis. */
        }

        .atalho {
            padding: 17px 20px; /* Cria espacamento interno no atalho. */
            border-radius: 7px; /* Arredonda os cantos do atalho. */
            background-color: var(--verde-escuro); /* Aplica fundo verde escuro ao atalho. */
            color: var(--branco); /* Define a cor branca para o texto. */
            text-decoration: none; /* Remove o sublinhado do link. */
        }

        .atalho span {
            display: block; /* Faz a descricao ocupar uma linha propria. */
            margin-top: 5px; /* Separa a descricao do titulo do atalho. */
            color: #a9b8b0; /* Aplica uma cor suave a descricao. */
            font-size: 12px; /* Define um tamanho menor para a descricao. */
        }

        /* Paineis inferiores */
        .grade-paineis {
            display: grid; /* Organiza os paineis inferiores em uma grade. */
            grid-template-columns: 2fr 1fr; /* Deixa o primeiro painel duas vezes mais largo. */
            gap: 18px; /* Define a distancia entre os paineis. */
        }

        .painel {
            overflow: hidden; /* Oculta conteudo que ultrapasse os cantos do painel. */
            border: 1px solid var(--borda); /* Adiciona uma borda ao painel. */
            border-radius: 7px; /* Arredonda os cantos do painel. */
            background-color: var(--branco); /* Aplica fundo branco ao painel. */
            box-shadow: 0 2px 10px rgba(23, 34, 29, 0.07); /* Adiciona uma sombra suave ao painel. */
        }

        .painel-titulo {
            padding: 19px 20px; /* Cria espacamento interno no cabecalho do painel. */
            border-bottom: 1px solid var(--borda); /* Separa o titulo do conteudo do painel. */
        }

        .painel-titulo h2 {
            margin: 0; /* Remove a margem padrao do titulo. */
            font-size: 16px; /* Define o tamanho do titulo do painel. */
        }

        .painel-titulo p {
            margin: 5px 0 0; /* Adiciona espaco acima da descricao. */
            color: var(--texto-claro); /* Aplica cor secundaria a descricao. */
            font-size: 12px; /* Define um tamanho menor para a descricao. */
        }

        .tabela-container {
            overflow-x: auto; /* Permite rolagem horizontal quando necessario. */
        }

        table {
            width: 100%; /* Faz a tabela ocupar toda a largura do painel. */
            min-width: 620px; /* Evita que a tabela fique estreita demais. */
            border-collapse: collapse; /* Une as bordas das celulas adjacentes. */
        }

        th,
        td {
            padding: 14px 18px; /* Cria espacamento interno nas celulas. */
            border-bottom: 1px solid #edf0ee; /* Separa visualmente as linhas da tabela. */
            text-align: left; /* Alinha o conteudo das celulas a esquerda. */
        }

        th {
            background-color: #fafbfa; /* Aplica um fundo suave ao cabecalho da tabela. */
            color: var(--texto-claro); /* Aplica cor secundaria aos titulos. */
            font-size: 11px; /* Define um tamanho pequeno para os titulos. */
            text-transform: uppercase; /* Exibe os titulos em letras maiusculas. */
        }

        td small {
            display: block; /* Faz o texto auxiliar ocupar uma linha propria. */
            margin-top: 4px; /* Separa o texto auxiliar do texto principal. */
            color: var(--texto-claro); /* Aplica cor secundaria ao texto auxiliar. */
            font-size: 11px; /* Reduz o tamanho do texto auxiliar. */
        }

        .etiqueta {
            display: inline-block; /* Permite dimensionar a etiqueta mantendo-a na linha. */
            padding: 5px 8px; /* Cria espacamento interno na etiqueta. */
            border-radius: 4px; /* Arredonda os cantos da etiqueta. */
            background-color: var(--verde-claro); /* Aplica fundo verde claro a etiqueta. */
            color: var(--verde); /* Define a cor verde para o texto. */
            font-size: 11px; /* Define um tamanho pequeno para o texto. */
            font-weight: bold; /* Exibe o texto da etiqueta em negrito. */
        }

        .etiqueta.saida {
            background-color: #f9e7e5; /* Aplica fundo avermelhado a etiqueta de saida. */
            color: #982f2b; /* Define texto vermelho para indicar saida. */
        }

        .lista-produtos {
            margin: 0; /* Remove a margem padrao da lista. */
            padding: 0; /* Remove o preenchimento padrao da lista. */
            list-style: none; /* Remove os marcadores dos itens. */
        }

        .lista-produtos li {
            display: flex; /* Organiza as informacoes do produto lado a lado. */
            align-items: center; /* Centraliza verticalmente o conteudo do item. */
            justify-content: space-between; /* Separa o nome e a quantidade nas extremidades. */
            padding: 15px 20px; /* Cria espacamento interno no item. */
            border-bottom: 1px solid #edf0ee; /* Separa visualmente os itens da lista. */
        }

        .lista-produtos small {
            display: block; /* Faz a informacao secundaria ocupar uma linha propria. */
            margin-top: 4px; /* Separa a informacao secundaria do nome. */
            color: var(--texto-claro); /* Aplica cor secundaria a informacao. */
        }

        .lista-produtos b {
            color: var(--vermelho); /* Destaca em vermelho a quantidade baixa. */
        }

        .rodape {
            padding: 36px 0 24px; /* Cria espacamento vertical no rodape. */
            color: #8a948f; /* Aplica uma cor discreta ao texto do rodape. */
            font-size: 12px; /* Define um tamanho pequeno para o texto. */
            text-align: center; /* Centraliza o texto do rodape. */
        }

        /* Ajustes para telas menores */
        @media (max-width: 1000px) {
            .resumo {
                grid-template-columns: 1fr 1fr; /* Reduz o resumo para duas colunas. */
            }

            .grade-paineis {
                grid-template-columns: 1fr; /* Empilha os paineis em uma unica coluna. */
            }
        }

        @media (max-width: 700px) {
            .conteudo {
                margin-left: 0; /* Remove o espaco reservado ao menu lateral. */
                padding: 0 16px; /* Reduz o espacamento lateral do conteudo. */
            }

            .resumo,
            .atalhos {
                grid-template-columns: 1fr; /* Empilha os elementos em uma unica coluna. */
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
