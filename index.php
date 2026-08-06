
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>"Sistema de Controle de Estoque"</title>


        <style>
        /* Estilos aplicados ao elemento body de toda a página */
        body {
            margin: 0; /* Remove a margem padrão do navegador */
            font-family: Arial, sans-serif; /* Define fonte padrão para o texto */
            background-color: #f4f6f8; /* Define a cor de fundo da página */
            color: #263238; /* Define a cor padrão do texto */
        }

        /* Estilos para o cabeçalho da página */
        header {
            padding: 24px; /* Espaçamento interno ao redor do conteúdo do cabeçalho */
            background-color: #1565c0; /* Cor de fundo azul do cabeçalho */
            color: white; /* Cor do texto dentro do cabeçalho */
        }

        /* Estilos para a área principal do conteúdo */
        main {
            max-width: 1000px; /* Limita a largura máxima do conteúdo */
            margin: 30px auto; /* Centraliza horizontalmente e adiciona espaço acima/abaixo */
            padding: 0 20px; /* Espaçamento interno nas laterais */
        }

        /* Estilos para cada painel de informação */
        .painel {
            margin-bottom: 24px; /* Espaçamento abaixo do painel */
            padding: 20px; /* Espaçamento interno do painel */
            background-color: white; /* Cor de fundo branca do painel */
            border-radius: 8px; /* Cantos arredondados do painel */
        }

        /* Estilos para o contêiner de resumo com cartões */
        .resumo {
            display: flex; /* Exibe os itens em linha usando flexbox */
            gap: 16px; /* Espaçamento entre os cards */
        }

        /* Estilos para cada cartão dentro do resumo */
        .cartao {
            flex: 1; /* Faz cada cartão ocupar espaço igual */
            padding: 18px; /* Espaçamento interno do cartão */
            background-color: #e3f2fd; /* Cor de fundo azul claro do cartão */
            border-radius: 8px; /* Cantos arredondados do cartão */
        }

        /* Estilos para a tabela de produtos */
        table {
            width: 100%; /* Faz a tabela ocupar toda a largura disponível */
            border-collapse: collapse; /* Remove espaçamento entre bordas de células */
        }

        /* Estilos comuns para cabeçalhos e células da tabela */
        th,
        td {
            padding: 12px; /* Espaçamento interno das células */
            border-bottom: 1px solid #dddddd; /* Linha inferior de separação entre linhas */
            text-align: left; /* Alinha o texto à esquerda */
        }

        /* Estilos específicos apenas para os cabeçalhos da tabela */
        th {
            background-color: #1565c0; /* Cor de fundo azul dos cabeçalhos */
            color: white; /* Cor do texto dos cabeçalhos */
        }

        /* Estilos para indicar itens com baixo estoque */
        .baixo-estoque {
            color: #c62828; /* Texto vermelho para destacar alerta */
            font-weight: bold; /* Texto em negrito para maior destaque */
        }
    </style>

</head>

<body>
    <header>
        <h1>Sistema de Controle de Estoque</h1>

        <p>
            Usuário: Aluno |
            Data: 4/8/2026|
            Hora: 19:30
        </p>
    </header>

    <main>
        <section class="painel">
            <h2>Resumo do estoque</h2>

            <div class="resumo">
                  <div class="cartao">
                    <strong>Produtos cadastrados</strong>
                    <p>3</p>
                </div>

                <div class="cartao">
                    <strong>Status do sistema</strong>
                    <p>Em desenvolvimento</p>
                </div>
            </div>
        </section>

        <section class="painel">
            <h2>Produtos</h2>

            <table>
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Categoria</th>
                        <th>Quantidade</th>
                        <th>Preço</th>
                    </tr>
                </thead>

                <tbody>
                   
                        <tr>
                            <td>Nome</td>
                            <td>categoria</td>
                            <td>quantidade</td>
                            <td>10,00 </td>
                        </tr>
                  
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>