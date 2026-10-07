# Estoque Fácil — ADS, 2º semestre

Aplicação didática de controle de estoque desenvolvida com PHP, HTML, CSS e MySQL/MariaDB. Este guia acompanha quem está chegando agora ao curso, desde a instalação do ambiente até o primeiro cadastro no navegador.

## 1. Baixar e instalar o XAMPP no Windows

1. Acesse o [download oficial do XAMPP](https://www.apachefriends.org/download.html).
2. Na seção **XAMPP for Windows**, baixe o instalador com PHP 8.2.
3. Execute o instalador, mantenha os componentes Apache, MySQL, PHP e phpMyAdmin e conclua a instalação em `C:\xampp`.
4. Abra o **XAMPP Control Panel** pelo menu Iniciar ou por `C:\xampp\xampp-control.exe`.
5. Clique em **Start** nas linhas **Apache** e **MySQL**. Aguarde os dois serviços ficarem ativos.
6. Abra o navegador e digite `http://localhost/`. A página inicial do XAMPP deve aparecer.

O Apache executa o PHP; o serviço MySQL do painel fornece o banco MariaDB usado pelo XAMPP. Não é necessário instalar um banco separadamente. Veja também a [documentação oficial para Windows](https://www.apachefriends.org/faq_windows.html).

Se você já usa WampServer, pare seus serviços antes de iniciar o XAMPP para evitar disputa pelas mesmas portas. Para continuar usando WampServer, a pasta equivalente do projeto é `C:\wamp64\www\estoque`.

## 2. Baixar o projeto e criar a pasta estoque

1. Acesse o [repositório do curso](https://github.com/reneferreira/estoqueADS-2-semestre).
2. Clique no botão **Code** e depois em **Download ZIP**.
3. Extraia o ZIP pelo Explorador de Arquivos.
4. Entre em `C:\xampp\htdocs` e crie uma pasta chamada **estoque**.
5. Copie o conteúdo da pasta extraída para `C:\xampp\htdocs\estoque`.

O arquivo inicial precisa estar diretamente em `C:\xampp\htdocs\estoque\index.php`. Evite criar uma pasta extra como `estoque\estoqueADS-2-semestre-main\index.php`.

Confira a estrutura:

```text
C:\xampp\htdocs\estoque\
├── css\
│   └── estilo.css
├── cabecalho.php
├── categorias.php
├── conexao.php
├── estoque_ads.sql
├── index.php
├── menu.php
├── produto.php
├── produtos.php
├── README.md
└── rodape.php
```

Se você já tem Git instalado, pode usar esta alternativa no terminal, desde que a pasta de destino ainda não exista ou esteja vazia:

```powershell
cd C:\xampp\htdocs
git clone https://github.com/reneferreira/estoqueADS-2-semestre.git estoque
```

Não é necessário executar Composer, npm ou uma etapa de compilação.

## 3. Criar o banco e importar o arquivo SQL

O banco exportado está em [estoque_ads.sql](estoque_ads.sql), incluído no download do projeto. Ele contém a estrutura da tabela `produtos` e cinco produtos de exemplo.

1. Com Apache e MySQL ativos, abra `http://localhost/phpmyadmin/`.
2. Clique em **Novo** na barra lateral (ou na aba **Bancos de dados**).
3. No nome do banco, digite exatamente **estoque_ads**.
4. Escolha a collation **utf8mb4_unicode_ci** e clique em **Criar**.
5. Selecione **estoque_ads** na barra lateral.
6. Abra a aba **Importar**.
7. Clique em **Escolher arquivo** e selecione `C:\xampp\htdocs\estoque\estoque_ads.sql`.
8. Mantenha o formato **SQL** e a codificação **utf-8**, e clique em **Importar** ou **Executar**, conforme a versão do phpMyAdmin.
9. Aguarde a mensagem de sucesso. Clique na tabela **produtos** e em **Visualizar** para conferir os cinco registros.

Crie e selecione o banco antes da importação: o arquivo SQL não cria o banco automaticamente. O arquivo contém `DROP TABLE IF EXISTS produtos`: importá-lo novamente substitui a tabela e apaga os produtos cadastrados depois da importação anterior. Faça uma exportação de segurança antes de repetir esse processo em um banco com seus dados.

## 4. Conferir a conexão com o banco

Abra [conexao.php](conexao.php) em um editor de texto ou código. A configuração inicial é:

```php
$host = "localhost";
$banco = "estoque_ads";
$usuario = "root";
$senha = "";
```

Para uma instalação local padrão do XAMPP, mantenha esses valores. Se você definiu uma senha para o usuário `root`, informe-a em `$senha`. O nome em `$banco` deve ser igual ao banco criado no phpMyAdmin.

O projeto usa as extensões PHP `pdo_mysql` e `mbstring`. Caso estejam desativadas, abra **Config > PHP (php.ini)** na linha Apache do painel, localize `extension=pdo_mysql` e `extension=mbstring`, retire o `;` inicial dessas linhas, salve e reinicie o Apache.

## 5. Executar a aplicação e cadastrar um produto

1. Digite **http://localhost/estoque/** na barra de endereços do navegador.
2. A tela **Visão geral** deve aparecer.
3. No menu lateral, clique em **Produtos**, ou abra **http://localhost/estoque/produtos.php**.
4. Confira os produtos importados, como Caderno, Lápis e Caneta Preta.
5. Preencha um cadastro de teste:

   | Campo | Exemplo |
   | --- | --- |
   | Nome do produto | Teclado USB |
   | Categoria | Informática |
   | Quantidade | 10 |
   | Estoque mínimo | 5 |
   | Preço unitário | 49,90 (ou 49.90, conforme o navegador) |

6. Clique em **Adicionar produto**. A aplicação deve mostrar a mensagem de sucesso e o novo produto na lista.
7. Atualize a página: o produto deve continuar aparecendo, sem duplicar o cadastro.
8. No phpMyAdmin, abra `estoque_ads > produtos > Visualizar` para confirmar que o registro foi salvo.

Use sempre o endereço `http://localhost/estoque/`. Abrir o arquivo PHP com duplo clique, por um endereço `file:///`, não executa a aplicação. Nas próximas aulas, basta iniciar Apache e MySQL e abrir esse endereço; não é necessário importar o banco novamente.

## 6. O que já está implementado nesta etapa

- `produtos.php`: cadastro e listagem persistidos no banco, validação dos campos, proteção CSRF, consultas preparadas e indicação de estoque baixo quando a quantidade é menor ou igual ao mínimo.
- `produto.php`: outra versão da página de produtos, também presente nos arquivos da aula; o menu principal aponta para `produtos.php`, que contém comentários explicativos.
- `conexao.php`: conexão centralizada com PDO.
- `menu.php` e `css/estilo.css`: navegação e apresentação das telas atualizadas.
- `estoque_ads.sql`: exportação do banco com os dados desta etapa.

A **Visão geral** ainda usa dados fixos de exemplo e não acompanha os cadastros do banco. A tela **Categorias** é um exercício em desenvolvimento, com dados em memória, e ainda não mantém categorias no banco. As opções Nova entrada, Nova saída, Histórico e Encerrar sessão ainda são links demonstrativos. Não há tela de login nesta etapa.

## 7. Problemas comuns

| Problema | O que conferir |
| --- | --- |
| `localhost` não abre | Inicie o Apache no painel do XAMPP. |
| Apache ou MySQL não inicia | Consulte **Logs** no painel e verifique se WampServer ou outro serviço já está usando as portas 80/443 ou 3306. |
| Erro 404 em `/estoque/` | Confira se `index.php` está em `C:\xampp\htdocs\estoque`, sem uma pasta extra dentro. |
| A página mostra código PHP ou abre como arquivo | Acesse pelo endereço HTTP; confirme que o Apache está ativo. |
| Não foi possível acessar o banco | Inicie MySQL, confirme o banco `estoque_ads`, a importação e os dados em `conexao.php`. |
| `Unknown database` ou tabela `produtos` inexistente | Crie e selecione o banco, depois importe `estoque_ads.sql`. |
| `Access denied` | Confira usuário e senha em `conexao.php`. |
| `could not find driver` ou `undefined function mb_strlen` | Ative, respectivamente, `pdo_mysql` ou `mbstring` no PHP do Apache e reinicie o serviço. |
| Visão geral não mudou após um cadastro | Nesta etapa ela usa exemplos fixos. Confira os registros em **Produtos**. |

Se o Apache estiver configurado em outra porta, como 8080, use `http://localhost:8080/estoque/` e `http://localhost:8080/phpmyadmin/`. Se o banco estiver em outra porta, ajuste a string de conexão em `conexao.php`, por exemplo: `mysql:host=$host;port=3307;dbname=$banco;charset=utf8mb4`.

## 8. Exportar seu banco para guardar o progresso

1. Abra o phpMyAdmin e selecione **estoque_ads**.
2. Clique em **Exportar**.
3. Escolha o método **Rápido** e o formato **SQL**.
4. Clique em **Exportar/Executar** e guarde o arquivo baixado como uma cópia do seu progresso.

Os arquivos PHP e CSS são o código da aplicação; os cadastros ficam no banco. Para levar o projeto para outro computador, copie o código e exporte/importe também o banco.
