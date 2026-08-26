<?php
date_default_timezone_set("America/Cuiaba");
$data = date("d/m/Y");
$hora = date("H:i");
$usuario = "Administrativo";
$tituloPagina = $tituloPagina ?? "Visão geral";
?>
<header class="cabecalho">
    <div>
        <span class="saudacao">Olá, <?= $usuario ?>. Hoje é <?= $data ?> - <?= $hora ?></span>
        <h1><?= htmlspecialchars($tituloPagina, ENT_QUOTES, "UTF-8") ?></h1>
    </div>
    <span class="usuario"><?= $usuario ?></span>
</header>
