<style>
    /* Estilos exclusivos do menu lateral */
    .menu-lateral {
        position: fixed; /* Mantem o menu fixo na tela durante a rolagem. */
        top: 0; /* Alinha o menu ao topo da tela. */
        bottom: 0; /* Estende o menu ate a parte inferior da tela. */
        left: 0; /* Alinha o menu ao lado esquerdo da tela. */
        width: 240px; /* Define a largura do menu lateral. */
        padding: 24px 16px; /* Cria espacamento interno vertical e horizontal. */
        display: flex; /* Organiza os elementos com o modelo flexivel. */
        flex-direction: column; /* Distribui os elementos em uma coluna. */
        background-color: var(--verde-escuro); /* Aplica a cor verde escura ao fundo. */
        color: var(--branco); /* Define a cor branca como cor padrao do texto. */
    }

    .marca {
        display: flex; /* Organiza o icone e o texto lado a lado. */
        align-items: center; /* Centraliza verticalmente os itens da marca. */
        gap: 11px; /* Define a distancia entre o icone e o texto. */
        margin-bottom: 25px; /* Separa a marca dos links do menu. */
        padding: 0 8px; /* Adiciona espacamento interno apenas nas laterais. */
        color: var(--branco); /* Define a cor branca para o texto da marca. */
        text-decoration: none; /* Remove o sublinhado do link. */
        font-size: 17px; /* Define o tamanho do texto principal da marca. */
        font-weight: bold; /* Exibe o texto da marca em negrito. */
    }

    .marca-icone {
        width: 38px; /* Define a largura do icone. */
        height: 38px; /* Define a altura do icone. */
        display: grid; /* Usa o modelo de grade para posicionar o conteudo. */
        place-items: center; /* Centraliza o conteudo nos dois eixos. */
        border-radius: 6px; /* Arredonda os cantos do icone. */
        background-color: #3da477; /* Aplica o fundo verde ao icone. */
    }

    .marca small {
        display: block; /* Faz o texto secundario ocupar uma linha propria. */
        margin-top: 3px; /* Separa o texto secundario do texto principal. */
        color: #93a49c; /* Aplica uma cor mais discreta ao texto secundario. */
        font-size: 11px; /* Reduz o tamanho do texto secundario. */
        font-weight: normal; /* Remove o negrito herdado da marca. */
    }

    .menu-lateral nav {
        display: flex; /* Ativa o modelo flexivel para a navegacao. */
        flex-direction: column; /* Organiza os links verticalmente. */
        gap: 3px; /* Cria uma pequena distancia entre os links. */
    }

    .menu-lateral nav a,
    .sair {
        padding: 11px 12px; /* Define o espacamento interno dos links. */
        border-radius: 6px; /* Arredonda os cantos dos links. */
        color: #d5dfda; /* Define uma cor clara para o texto. */
        text-decoration: none; /* Remove o sublinhado dos links. */
    }

    .menu-lateral nav a:hover,
    .menu-lateral nav a.ativo {
        background-color: #243a30; /* Destaca o link ativo ou sob o cursor. */
        color: var(--branco); /* Clareia o texto do link destacado. */
    }

    .titulo-menu {
        margin: 18px 12px 4px; /* Define o espacamento externo do titulo. */
        color: #758b80; /* Usa uma cor discreta no titulo da secao. */
        font-size: 10px; /* Define um tamanho pequeno para o titulo. */
        font-weight: bold; /* Exibe o titulo em negrito. */
        text-transform: uppercase; /* Converte o texto para letras maiusculas. */
    }

    .sair {
        margin-top: auto; /* Empurra o link de saida para o fim do menu. */
        border-top: 1px solid #2d4037; /* Adiciona uma linha separadora acima do link. */
        border-radius: 0; /* Remove o arredondamento do link de saida. */
    }

    @media (max-width: 700px) {
        .menu-lateral {
            position: static; /* Recoloca o menu no fluxo normal da pagina. */
            width: 100%; /* Faz o menu ocupar toda a largura disponivel. */
        }

        .menu-lateral nav {
            display: grid; /* Organiza os links em uma grade. */
            grid-template-columns: 1fr 1fr; /* Cria duas colunas de mesma largura. */
        }

        .titulo-menu,
        .sair {
            display: none; /* Oculta os elementos em telas pequenas. */
        }
    }
</style>

<aside class="menu-lateral">
            <a class="marca" href="#">
                <span class="marca-icone">EF</span>
                <span>Estoque Facil<small>Gestao integrada</small></span>
            </a>

            <nav>
                <a class="ativo" href="#">Visao geral</a>

                <span class="titulo-menu">Catalogo</span>
                <a href="#">Produtos</a>
                <a href="#">Categorias</a>

                <span class="titulo-menu">Operacoes</span>
                <a href="#">Nova entrada</a>
                <a href="#">Nova saida</a>
                <a href="#">Historico</a>
            </nav>

            <a class="sair" href="#">Encerrar sessao</a>
        </aside>
