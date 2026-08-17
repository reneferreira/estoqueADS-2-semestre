<style>
    /* Estilos exclusivos do menu lateral */
    .menu-lateral {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        width: 240px;
        padding: 24px 16px;
        display: flex;
        flex-direction: column;
        background-color: var(--verde-escuro);
        color: var(--branco);
    }

    .marca {
        display: flex;
        align-items: center;
        gap: 11px;
        margin-bottom: 25px;
        padding: 0 8px;
        color: var(--branco);
        text-decoration: none;
        font-size: 17px;
        font-weight: bold;
    }

    .marca-icone {
        width: 38px;
        height: 38px;
        display: grid;
        place-items: center;
        border-radius: 6px;
        background-color: #3da477;
    }

    .marca small {
        display: block;
        margin-top: 3px;
        color: #93a49c;
        font-size: 11px;
        font-weight: normal;
    }

    .menu-lateral nav {
        display: flex;
        flex-direction: column;
        gap: 3px;
    }

    .menu-lateral nav a,
    .sair {
        padding: 11px 12px;
        border-radius: 6px;
        color: #d5dfda;
        text-decoration: none;
    }

    .menu-lateral nav a:hover,
    .menu-lateral nav a.ativo {
        background-color: #243a30;
        color: var(--branco);
    }

    .titulo-menu {
        margin: 18px 12px 4px;
        color: #758b80;
        font-size: 10px;
        font-weight: bold;
        text-transform: uppercase;
    }

    .sair {
        margin-top: auto;
        border-top: 1px solid #2d4037;
        border-radius: 0;
    }

    @media (max-width: 700px) {
        .menu-lateral {
            position: static;
            width: 100%;
        }

        .menu-lateral nav {
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        .titulo-menu,
        .sair {
            display: none;
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
