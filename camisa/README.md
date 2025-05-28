# Sistema de Loja Virtual de Camisas de Times

Um sistema completo de loja virtual para venda de camisas de times, desenvolvido em PHP puro (sem frameworks), MySQL, HTML e CSS.

## Estrutura do Sistema

O sistema está dividido em duas áreas principais:

### Área Pública (Loja Virtual)
- Listagem de produtos por categoria
- Página de detalhes de produto
- Carrinho de compras
- Finalização de compra
- Página de agradecimento

### Área Administrativa (Painel de Controle)
- Login e logout com controle de sessão
- Dashboard com resumo de informações
- Gerenciamento de categorias (CRUD)
- Gerenciamento de produtos (CRUD)
- Visualização e gerenciamento de vendas

## Tecnologias Utilizadas

- **Backend**: PHP (sem frameworks)
- **Banco de Dados**: MySQL
- **Frontend**: HTML, CSS, JavaScript
- **Bibliotecas**: Bootstrap 5, Font Awesome, jQuery

## Requisitos

- PHP 7.4 ou superior
- MySQL 5.7 ou superior
- Servidor web (Apache, Nginx, etc.)

## Instalação

1. Clone ou baixe este repositório para o diretório do seu servidor web
2. Crie um banco de dados MySQL
3. Importe o arquivo `database.sql` para criar as tabelas e dados iniciais
4. Configure as informações de conexão com o banco de dados no arquivo `includes/config.php`
5. Acesse o sistema pelo navegador

## Acesso ao Painel Administrativo

- URL: `/admin/login.php`
- Email: admin@camisasdetimes.com
- Senha: admin123

## Funcionalidades

### Área Pública
- Navegação por categorias
- Busca de produtos
- Visualização detalhada de produtos
- Adição de produtos ao carrinho
- Gerenciamento do carrinho (adicionar, atualizar, remover)
- Finalização de compra com formulário de dados do cliente
- Confirmação de pedido

### Área Administrativa
- Autenticação segura
- Dashboard com estatísticas
- Gerenciamento completo de categorias
- Gerenciamento completo de produtos com upload de imagens
- Visualização e gerenciamento de vendas
- Marcação de vendas como concluídas

## Estrutura de Diretórios

```
/
├── admin/                  # Área administrativa
│   ├── categorias/         # Gerenciamento de categorias
│   ├── produtos/           # Gerenciamento de produtos
│   ├── vendas/             # Gerenciamento de vendas
│   ├── includes/           # Arquivos de inclusão da área admin
│   ├── index.php           # Dashboard administrativo
│   ├── login.php           # Login administrativo
│   └── logout.php          # Logout administrativo
├── assets/                 # Arquivos estáticos
│   ├── css/                # Arquivos CSS
│   ├── js/                 # Arquivos JavaScript
│   └── img/                # Imagens do sistema e produtos
├── includes/               # Arquivos de inclusão globais
│   ├── config.php          # Configurações do sistema
│   ├── database.php        # Classe de conexão com o banco
│   ├── functions.php       # Funções auxiliares
│   ├── header.php          # Cabeçalho do site
│   └── footer.php          # Rodapé do site
├── index.php               # Página inicial da loja
├── categoria.php           # Listagem de produtos por categoria
├── produto.php             # Página de detalhes do produto
├── carrinho.php            # Página do carrinho de compras
├── finalizar.php           # Página de finalização da compra
├── agradecimento.php       # Página de agradecimento após compra
├── database.sql            # Script SQL para criação do banco
└── README.md               # Este arquivo
```

## Segurança

- Proteção contra SQL Injection
- Validação de dados de entrada
- Controle de sessão para área administrativa
- Senhas armazenadas com hash seguro

## Autor

Este sistema foi desenvolvido como um projeto de exemplo para uma loja virtual de camisas de times.
