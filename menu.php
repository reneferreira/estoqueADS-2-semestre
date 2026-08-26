<?php $paginaAtual = basename($_SERVER["PHP_SELF"]); ?>

    <aside class="menu-lateral">
            <a class="marca" href="index.php">
                <span class="marca-icone">EF</span>
                <span>Estoque Facil<small>Gestao integrada</small></span>
            </a>

            <nav>
                <a class="<?= $paginaAtual === "index.php" ? "ativo" : "" ?>" href="index.php">Visão geral</a>

                <span class="titulo-menu">Catálogo</span>
                <a class="<?= $paginaAtual === "produtos.php" ? "ativo" : "" ?>" href="produtos.php">Produtos</a>
                <a href="#">Categorias</a>

                <span class="titulo-menu">Operacoes</span>
                <a href="#">Nova entrada</a>
                <a href="#">Nova saida</a>
                <a href="#">Historico</a>
            </nav>

            <a class="sair" href="#">Encerrar sessao</a>
    </aside>
