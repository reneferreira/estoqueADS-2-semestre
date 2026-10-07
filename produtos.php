<?php
session_start(); // Inicia ou recupera a sessão: dados guardados no servidor entre acessos do mesmo navegador.
$produtos = []; // Cria uma lista vazia para receber os produtos consultados no banco.
$erros = []; // Cria uma lista vazia para acumular as mensagens de validação.
$sucesso = $_SESSION['sucesso_produto'] ?? ''; // Lê a mensagem da sessão; ?? usa texto vazio se ela não existir.
unset($_SESSION['sucesso_produto']); // Remove somente esta chave da sessão, para não repetir a mensagem no próximo acesso. $sucesso mantém a cópia.
// O token impede que outro site envie o formulário em nome do usuário.
$_SESSION['csrf_produto'] ??= bin2hex(random_bytes(32)); // ??= cria apenas se não existir; random_bytes gera bytes aleatórios e bin2hex os transforma em texto hexadecimal.
$campos = array_fill_keys(['nome', 'categoria_id', 'quantidade_produto', 'estoque_minimo', 'preco_unitario'], ''); // Cria um array com estas chaves, todas inicialmente com texto vazio.

$categorias = [ // Define as opções aceitas no cadastro; => associa uma chave ao seu valor.
  ["id" => 1, "nome" => "Informática"], // Primeira opção: identificador 1 e seu nome.
  ["id" => 2, "nome" => "Escritório"], // Segunda opção: identificador 2 e seu nome.
  ["id" => 3, "nome" => "Acessórios"] // Terceira opção: identificador 3 e seu nome.
]; // Encerra o array de categorias.

try { // Executa operações que podem lançar uma exceção, tratada pelo catch abaixo.
    require __DIR__ . '/conexao.php'; // Carrega a conexão; __DIR__ é a pasta deste arquivo e o ponto concatena textos.

    if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Só processa o cadastro quando o formulário é enviado por POST; === compara valor e tipo.
        // 1. Receber apenas textos e validar no servidor, mesmo usando required no HTML.
        foreach ($campos as $campo => $valor) { // Percorre cada chave e valor dos campos esperados.
            $campos[$campo] = is_string($_POST[$campo] ?? null) ? trim($_POST[$campo]) : ''; // Se for texto, remove espaços das extremidades; caso contrário, usa vazio. É o operador ternário: condição ? sim : não.
        } // Encerra a leitura dos campos.
        if (!is_string($_POST['csrf'] ?? null) || !hash_equals($_SESSION['csrf_produto'], $_POST['csrf'])) { // ! significa negação; || significa OU. Compara o token recebido com o da sessão de forma segura.
            $erros[] = 'Formulário expirado ou inválido. Recarregue a página e tente novamente.'; // [] acrescenta uma mensagem à lista de erros.
        } // Encerra a validação do token.
        $nome = $campos['nome']; // Copia o nome recebido para a variável usada no INSERT.
        if ($nome === '' || mb_strlen($nome, 'UTF-8') > 120) { // Rejeita nome vazio ou com mais de 120 caracteres, contando corretamente os acentos.
            $erros[] = 'Informe um nome com até 120 caracteres.'; // Registra o erro do nome.
        } // Encerra a validação do nome.
        // A tabela possui categoria (texto), não categoria_id.
        $categoriasPermitidas = array_column($categorias, 'nome', 'id'); // Monta um array de nomes indexado pelo id de cada categoria.
        $categoria = $categoriasPermitidas[$campos['categoria_id']] ?? null; // Busca o nome permitido; se o id não existir, usa null (ausência de valor).
        if ($categoria === null) { // Detecta uma categoria que não está na lista permitida.
            $erros[] = 'Selecione uma categoria válida.'; // Registra o erro da categoria.
        } // Encerra a validação da categoria.
        $quantidade = filter_var($campos['quantidade_produto'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 0, 'max_range' => 4294967295]]); // Valida inteiro no intervalo do INT UNSIGNED; retorna false se inválido.
        $estoqueMinimo = filter_var($campos['estoque_minimo'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 0, 'max_range' => 2147483647]]); // Valida inteiro não negativo no intervalo do INT da tabela.
        if ($quantidade === false || $estoqueMinimo === false) { // Compara com false de forma estrita, pois zero é um valor válido.
            $erros[] = 'Quantidade e estoque mínimo devem ser números inteiros não negativos, dentro do limite do banco.'; // Registra o erro numérico.
        } // Encerra a validação dos inteiros.
        // DECIMAL(10,2): até 8 dígitos inteiros e 2 casas decimais.
        // Mantemos o preço como texto para não introduzir arredondamentos de float.
        $preco = str_replace(',', '.', $campos['preco_unitario']); // Troca a vírgula decimal por ponto, formato esperado pelo banco.
        if (!preg_match('/^[0-9]{1,8}(\.[0-9]{1,2})?$/D', $preco)) { // A expressão regular aceita 1 a 8 dígitos e, opcionalmente, ponto seguido de 1 ou 2 dígitos, sem caracteres extras.
            $erros[] = 'Informe um preço de 0 até 99999999,99, com no máximo duas casas decimais.'; // Registra o erro do preço.
        } // Encerra a validação do preço.

        if (!$erros) { // Só grava quando a lista de erros está vazia.
            // 2. SQL fixo + parâmetros: nunca concatenar os dados do formulário no SQL.
            // prepare() define o comando; execute() envia os valores como dados.
            // Mesmo um nome contendo aspas ou comandos SQL será apenas um texto.
            // INSERT INTO indica a tabela e as colunas; VALUES usa marcadores :nome, :categoria etc. no lugar dos dados.
            $sql = 'INSERT INTO produtos (nome, categoria, quantidade, estoque_minimo, preco)
                    VALUES (:nome, :categoria, :quantidade, :estoque_minimo, :preco)';
            $comando = $pdo->prepare($sql); // Prepara a consulta usando a conexão PDO; -> chama um método do objeto.
            $comando->execute([ // Executa a consulta enviando separadamente um array de valores para os marcadores.
                'nome' => $nome, // Associa o texto do nome ao marcador :nome.
                'categoria' => $categoria, // Associa o nome da categoria ao marcador :categoria.
                'quantidade' => $quantidade, // Associa a quantidade validada ao marcador :quantidade.
                'estoque_minimo' => $estoqueMinimo, // Associa o mínimo validado ao marcador :estoque_minimo.
                'preco' => $preco // Associa o valor decimal ao marcador :preco.
            ]); // Fecha o array e a chamada de execute().
            // id e cadastrado_em são preenchidos automaticamente pelo banco.
            // 3. Redirecionar evita repetir o INSERT ao atualizar a página.
            $_SESSION['sucesso_produto'] = 'Produto adicionado com sucesso!'; // Guarda a mensagem para exibi-la no acesso após o redirecionamento.
            header('Location: produtos.php', true, 303); // Envia um redirecionamento HTTP 303: o navegador deve abrir a página por GET; true substitui um cabeçalho igual anterior.
            exit; // Interrompe o PHP imediatamente após enviar o redirecionamento.
        } // Encerra o bloco que grava um produto válido.
    } // Encerra o processamento do POST.

    // Sem entrada do usuário nesta consulta, podemos usar query().
    $produtos = $pdo->query('SELECT id, nome, quantidade, estoque_minimo FROM produtos ORDER BY id DESC')->fetchAll(); // SELECT consulta as colunas; DESC ordena os ids do maior para o menor; fetchAll retorna todas as linhas em um array.
} catch (PDOException $erro) { // Captura falhas do PDO ocorridas dentro do try, para tratá-las sem mostrar detalhes ao visitante.
    // Detalhes técnicos ficam no log do servidor, nunca na página pública.
    error_log('Erro no banco de produtos: ' . $erro->getMessage()); // Grava no log a mensagem técnica obtida por getMessage().
    $erros[] = 'Não foi possível acessar o banco de dados. Tente novamente em instantes.'; // Prepara uma mensagem pública sem expor a conexão ou o SQL.
} // Encerra o tratamento de falhas.

// htmlspecialchars protege a saída HTML contra XSS; não substitui o prepare().
function escaparProduto($valor): string { // Declara uma função que recebe um valor e sempre retorna uma string.
    return htmlspecialchars((string) $valor, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); // Converte para texto e escapa caracteres HTML; ENT_QUOTES inclui aspas e ENT_SUBSTITUTE substitui sequências inválidas. | combina as opções.
} // Encerra a função; return entrega o resultado para quem a chamou.

$tituloPagina = "Produtos"; // Define o título que será usado pelo arquivo cabecalho.php.
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estoque Facil | Produtos</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <div class="pagina">
        <?php /* include carrega o HTML e o PHP do menu nesta posição da página. */ ?>
        <?php include "menu.php"; ?>
        <main class="conteudo">
            <?php /* Inclui o cabeçalho, que utiliza a variável $tituloPagina definida acima. */ ?>
            <?php include "cabecalho.php"; ?>

            <section class="painel painel-produtos">
                <div class="painel-titulo">
                    <h2>Cadastrar produto</h2>
                    <p>Preencha os campos para adicionar um item ao estoque.</p>
                </div>
                <?php /* Só mostra o aviso quando há uma mensagem de sucesso; !== significa diferente em valor ou tipo. */ ?>
                <?php if ($sucesso !== ''): ?>
                    <p class="mensagem-sucesso" role="status">
                        <span class="mensagem-sucesso-icone" aria-hidden="true">&#10003;</span>
                        <span><?= escaparProduto($sucesso) /* Exibe a mensagem com caracteres HTML escapados. */ ?></span>
                    </p>
                <?php /* Encerra o if escrito na sintaxe alternativa com dois-pontos, útil ao misturar PHP e HTML. */ ?>
                <?php endif; ?>
                <?php /* Percorre as mensagens de erro para exibir uma de cada vez. */ ?>
                <?php foreach ($erros as $mensagem): ?>
                    <?php /* <?= é a forma curta de echo: imprime a mensagem escapada no HTML. */ ?>
                    <p role="alert"><?= escaparProduto($mensagem) ?></p>
                <?php /* Encerra o foreach escrito na sintaxe alternativa com dois-pontos. */ ?>
                <?php endforeach; ?>
                <form class="formulario-produto" method="POST">
                    <?php /* Envia o token da sessão em um campo oculto para conferência no próximo POST. */ ?>
                    <input type="hidden" name="csrf" value="<?= escaparProduto($_SESSION['csrf_produto']) ?>">
                    <div class="campo-formulario">
                        <label for="nome">Nome do produto</label>
                        <?php /* Reexibe o nome enviado quando a validação falha; escaparProduto protege o atributo HTML. */ ?>
                        <input type="text" name="nome" id="nome" maxlength="120" value="<?= escaparProduto($campos['nome']) ?>" placeholder="Ex.: Teclado USB" required>
                    </div>
                    <div class="campo-formulario">
                        <label for="categoria_id">Categoria</label>
                    <select name="categoria_id" id="categoria_id" required>
                        <option value="">Selecione</option>
                        <?php /* Repete as opções do select, usando uma categoria por passagem do laço. */ ?>
                        <?php foreach ($categorias as $categoria): ?>
                            <?php /* Envia o id da categoria; o ternário imprime selected se esta foi a opção enviada anteriormente. */ ?>
                            <option value="<?= $categoria["id"] ?>" <?= $campos['categoria_id'] === (string) $categoria['id'] ? 'selected' : '' ?>>
                            <?php /* Exibe o nome da categoria escapando caracteres especiais do HTML. */ ?>
                            <?= htmlspecialchars($categoria["nome"]) ?>
                            </option>
                        <?php /* Encerra o foreach escrito na sintaxe alternativa com dois-pontos. */ ?>
                        <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="campo-formulario">
                        <label for="quantidade_produto">Quantidade</label>
                        <?php /* Mantém a quantidade digitada quando o formulário precisa ser corrigido. */ ?>
                        <input type="number" name="quantidade_produto" id="quantidade_produto" value="<?= escaparProduto($campos['quantidade_produto']) ?>" min="0" placeholder="0" required>
                    </div>

                    <div class="campo-formulario">
                        <label for="estoque_minimo">Estoque Mínimo</label>
                        <?php /* Mantém o estoque mínimo digitado, escapado para uso no atributo value. */ ?>
                        <input type="number" name="estoque_minimo" id="estoque_minimo" value="<?= escaparProduto($campos['estoque_minimo']) ?>" min="0" placeholder="0" required>
                    </div>
                    <div class="campo-formulario">
                        <label for="preco_unitario">Preço Unitário</label>
                        <?php /* Mantém o preço digitado para que o aluno possa corrigir o formulário sem preenchê-lo novamente. */ ?>
                        <input type="number" name="preco_unitario" id="preco_unitario" value="<?= escaparProduto($campos['preco_unitario']) ?>"
                            min="0" step="0.01" required>
                    </div>

                    <button class="botao-primario" type="submit">Adicionar produto</button>
                </form>
            </section>

            <section class="painel painel-produtos">
                <div class="painel-titulo">
                    <h2>Produtos cadastrados</h2>
                    <?php /* count conta os elementos do array e exibe o total de produtos retornados pelo banco. */ ?>
                    <p><?= count($produtos) ?> itens encontrados no estoque.</p>
                </div>
                <div class="tabela-container">
                    <table>
                        <thead>
                            <tr><th>Produto</th><th>Quantidade</th><th>Situacao</th></tr>
                        </thead>
                        <tbody>
                            <?php /* Percorre os produtos consultados e gera uma linha da tabela para cada um. */ ?>
                            <?php foreach ($produtos as $produto) { ?>
                                <?php /* Se a quantidade for menor ou igual ao mínimo, aplica a classe CSS baixo-estoque; senão, deixa a classe vazia. */ ?>
                                <tr class="<?= $produto["quantidade"] <= $produto["estoque_minimo"] ? "baixo-estoque" : "" ?>">
                                    <?php /* Exibe o nome como texto: ENT_QUOTES escapa também as aspas, impedindo que o nome seja interpretado como HTML. */ ?>
                                    <td><strong><?= htmlspecialchars($produto["nome"], ENT_QUOTES, "UTF-8") ?></strong></td>
                                    <?php /* (int) converte a quantidade para inteiro antes de exibi-la. */ ?>
                                    <td><?= (int) $produto["quantidade"] ?> un.</td>
                                    <?php /* Os dois ternários escolhem a classe CSS e o texto da situação conforme o estoque mínimo do produto. */ ?>
                                    <td><span class="etiqueta <?= $produto["quantidade"] <= $produto["estoque_minimo"] ? "estoque-baixo" : "" ?>"><?= $produto["quantidade"] <= $produto["estoque_minimo"] ? "Estoque baixo" : "Disponivel" ?></span></td>
                                </tr>
                            <?php /* Fecha o foreach dos produtos, encerrando a repetição das linhas da tabela. */ ?>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <?php /* Inclui o rodapé compartilhado pelas páginas. */ ?>
            <?php include "rodape.php"; ?>
        </main>
    </div>
</body>
</html>
