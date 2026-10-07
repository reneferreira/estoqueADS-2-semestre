<?php

// Configuração do ambiente local de aula (WampServer).
// Em produção, use um usuário próprio do sistema, com senha e permissões limitadas.

$host = "localhost"; // Endereço do servidor MySQL; localhost indica este computador.
$banco = "estoque_ads"; // Nome do banco que contém a tabela produtos.
$usuario = "root"; // Usuário do MySQL usado no ambiente local de aula.
$senha = ""; // Senha desse usuário; neste ambiente local ela está vazia.

$pdo = new PDO( // Cria o objeto de conexão; falhas serão tratadas no catch de produtos.php.
    "mysql:host=$host;dbname=$banco;charset=utf8mb4", // DSN: informa o driver, o servidor, o banco e a codificação que suporta acentos e emojis.
    $usuario, 
    $senha, 
    [ 
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Faz erros do banco lançarem exceções PDOException; :: acessa constantes da classe PDO.
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Retorna as linhas como arrays com nomes de colunas: $produto['nome'], por exemplo.
    
        PDO::ATTR_EMULATE_PREPARES => false // Desativa a emulação: usa a preparação nativa do MySQL para separar SQL e dados.
    ] 
); 
