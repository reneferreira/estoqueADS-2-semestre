<?php
date_default_timezone_set('America/Cuiaba');

$data = date('d,m,Y');
$hora = date('H:i');

$usuario = "Administrativo";

?>
  
  <header class="cabecalho">
    <div>
        <span class="saudacao">Olá, <?= $usuario ?> Hoje é <?= $data ?> - <?= $hora ?></span>
    <h1>Visão geral</h1>
    </div>
    <span class="usuario"><?= $usuario ?></span>
 </header>