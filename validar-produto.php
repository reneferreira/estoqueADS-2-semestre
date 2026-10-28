<?php
// Validação compartilhada pelo cadastro e pela edição.
        foreach ($campos as $campo => $valor) {
            $campos[$campo] = is_string($_POST[$campo] ?? null) ? trim($_POST[$campo]) : '';
        }
        if (
            !is_string($_POST['csrf'] ?? null) ||
            !hash_equals($_SESSION['csrf_produto'], $_POST['csrf'])
        ) {
            $erros[] = 'Formulário expirado ou inválido. Recarregue a página e tente novamente.';
        }
        $nome = $campos['nome'];
        if ($nome === '' || mb_strlen($nome, 'UTF-8') > 120) {
            $erros[] = 'Informe um nome com até 120 caracteres.';
        }

        $categoriasPermitidas = array_column($categorias, 'nome', 'id');
        $categoria = $categoriasPermitidas[$campos['categoria_id']] ?? null;
        if ($categoria === null) {
            $erros[] = 'Selecione uma categoria válida.';
        }
        $quantidade = filter_var($campos['quantidade_produto'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 0, 'max_range' => 4294967295]]);
        $estoqueMinimo = filter_var($campos['estoque_minimo'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 0, 'max_range' => 2147483647]]);
        if ($quantidade === false || $estoqueMinimo === false) {
            $erros[] = 'Quantidade e estoque mínimo devem ser números inteiros não negativos, dentro do limite do banco.';
        }


        $preco = str_replace(',', '.', $campos['preco_unitario']);
        if (!preg_match('/^[0-9]{1,8}(\.[0-9]{1,2})?$/D', $preco)) {
            $erros[] = 'Informe um preço de 0 até 99999999,99, com no máximo duas casas decimais.';
        }

