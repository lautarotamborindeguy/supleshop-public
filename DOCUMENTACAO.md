# SupleStore

## Integrantes

Lautaro Tamborindeguy

## Objetivo do sistema

SupleStore e um sistema web para uma loja de suplementos esportivos. O objetivo e permitir que visitantes vejam produtos ativos no catalogo, filtrem por categoria, adicionem itens ao carrinho e enviem um pedido por email. O sistema tambem possui uma area administrativa protegida por login para gerenciar produtos.

## Tecnologias utilizadas

- HTML5 semantico
- CSS3
- JavaScript puro
- PHP puro
- MySQL
- PDO para conexao com banco de dados
- Sessoes PHP para login administrativo
- localStorage para o carrinho

## Funcionalidades

- Home publica com apresentacao da loja.
- Catalogo publico de produtos ativos.
- Busca publica por nome, descricao ou categoria.
- Filtro publico por categoria.
- Carrinho de compras com JavaScript e localStorage.
- Checkout por email usando `mailto:`.
- Pagina Sobre.
- Pagina Contato com validacao simples em JavaScript.
- Login administrativo com sessao PHP.
- Dashboard administrativo protegido.
- CRUD completo de produtos:
  - Cadastro
  - Listagem
  - Atualizacao
  - Exclusao
  - Busca

## Estrutura de paginas

- `index.php`: pagina inicial.
- `produtos.php`: catalogo publico de produtos.
- `carrinho.php`: carrinho de compras.
- `checkout.php`: formulario final do pedido.
- `sobre.php`: informacoes sobre o projeto e a loja.
- `contato.php`: contato com validacao de campos.
- `login.php`: login administrativo.
- `logout.php`: encerramento da sessao.
- `admin/dashboard.php`: painel administrativo.
- `admin/produtos/index.php`: listagem e busca de produtos.
- `admin/produtos/create.php`: cadastro de produto.
- `admin/produtos/edit.php`: edicao de produto.
- `admin/produtos/delete.php`: exclusao de produto.

## Estrutura do banco de dados

Banco de dados: `suple_store`

### Tabela `users`

- `id`: chave primaria.
- `username`: nome do usuario administrador.
- `password`: senha criptografada.
- `created_at`: data de criacao.

### Tabela `categories`

- `id`: chave primaria.
- `name`: nome da categoria.
- `created_at`: data de criacao.

### Tabela `products`

- `id`: chave primaria.
- `category_id`: chave estrangeira para `categories.id`.
- `name`: nome do produto.
- `description`: descricao do produto.
- `price`: preco.
- `stock`: estoque.
- `image`: nome do arquivo de imagem.
- `active`: status do produto.
- `created_at`: data de criacao.

## Relacionamento entre tabelas

A tabela `categories` se relaciona com a tabela `products` em uma relacao 1 para N.

Uma categoria pode ter varios produtos, mas cada produto pertence a apenas uma categoria.

Exemplo:

- Categoria: Creatinas
- Produtos: Creatina Monohidratada 300g, Creatina Monohidratada 1kg

A chave estrangeira `products.category_id` referencia a chave primaria `categories.id`.

## Como executar localmente

1. Instalar um ambiente local com PHP e MySQL, como XAMPP, WAMP ou Laragon.
2. Copiar a pasta do projeto para a pasta publica do servidor local.
3. Criar o banco importando o arquivo `database/database.sql` no MySQL.
4. Conferir os dados de conexao em `includes/db.php`:
   - host: `localhost`
   - banco: `suple_store`
   - usuario: `root`
   - senha: vazia por padrao
5. Acessar `index.php` pelo navegador.
6. Para acessar o painel administrativo:
   - URL: `login.php`
   - Usuario: `admin`
   - Senha: `admin123`

## Prints do sistema

### Home

Inserir print da Home.

### Catalogo publico

Inserir print do catalogo de produtos.

### Carrinho

Inserir print do carrinho.

### Checkout

Inserir print do checkout.

### Login administrativo

Inserir print do login administrativo.

### CRUD de produtos

Inserir print do CRUD.

## Funcionamento do carrinho

O carrinho e controlado pelo arquivo `assets/js/cart.js`. Quando o usuario clica em "Agregar al carrito", o JavaScript le os atributos `data-id`, `data-name`, `data-price` e `data-image` do botao.

Os produtos sao guardados em um array de objetos com:

- `id`
- `name`
- `price`
- `image`
- `quantity`

Esse array e salvo no `localStorage`, por isso o carrinho continua disponivel ao navegar entre paginas. O JavaScript tambem atualiza o contador do carrinho, renderiza os itens em `carrinho.php`, recalcula subtotais e total geral.

## Funcionamento do login administrativo

O login fica em `login.php`. O sistema consulta a tabela `users` usando PDO e verifica a senha com `password_verify()`.

Quando o login esta correto, o PHP cria variaveis de sessao:

- `$_SESSION['user_id']`
- `$_SESSION['username']`

As paginas administrativas usam `requireLogin()` do arquivo `includes/auth.php`. Se nao existir usuario logado, o sistema redireciona para `login.php`.

## Validacoes implementadas

- Campos vazios no login.
- Campos vazios no cadastro e edicao de produtos.
- Preco numerico e maior que zero.
- Estoque numerico e maior ou igual a zero.
- Email valido no checkout.
- Telefone valido no checkout.
- Carrinho vazio bloqueado no checkout.
- Formulario de contato com validacao de campos e email.

## Melhorias futuras

- Guardar pedidos em MySQL.
- Criar combos de produtos.
- Agregar metodo de pago.
- Upload real de imagens.
- Dashboard com estatisticas.

## Checklist da consigna

- HTML5 semantico: atendido.
- `header`, `nav`, `main`, `section`, `article`, `aside`, `footer`: atendido.
- CSS3 com classes, IDs, Box Model, Flexbox, posicionamento, hover e responsividade: atendido.
- JavaScript com variaveis, operadores, decisoes, repeticoes, arrays, funcoes, objetos, DOM, eventos e validacoes: atendido.
- PHP e MySQL: atendido.
- PDO: atendido.
- Minimo 2 tabelas relacionadas: atendido com `categories` e `products`.
- Chave primaria e chave estrangeira: atendido.
- Login administrativo com sessoes: atendido.
- CRUD completo de produtos: atendido.
- Cadastro, listagem, atualizacao, exclusao e busca: atendido.
- Home, Cadastro, Listagem, Sobre e Contato: atendido.
- Carrinho com localStorage: atendido.
- Checkout por email com `mailto:`: atendido.
