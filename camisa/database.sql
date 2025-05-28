-- Criação do banco de dados
CREATE DATABASE IF NOT EXISTS loja_camisas;
USE loja_camisas;

-- Tabela de usuários admin
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Inserção de um usuário admin padrão (senha: admin123)
INSERT INTO usuarios (nome, email, senha) VALUES 
('Administrador', 'admin@camisasdetimes.com', '$2y$10$8tGmGPvlG1.vHGpxgAH9eeZQS1rRZMKfBuLR6jCxqZxHhwdHBtPcK');

-- Tabela de categorias
CREATE TABLE IF NOT EXISTS categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Inserção de categorias iniciais
INSERT INTO categorias (nome) VALUES 
('Times Brasileiros'),
('Times Europeus'),
('Seleções Nacionais'),
('Times Históricos');

-- Tabela de produtos
CREATE TABLE IF NOT EXISTS produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    preco DECIMAL(10,2) NOT NULL,
    imagem VARCHAR(255),
    estoque INT NOT NULL DEFAULT 0,
    categoria_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE CASCADE
);

-- Inserção de produtos iniciais
INSERT INTO produtos (nome, descricao, preco, imagem, estoque, categoria_id) VALUES 
('Camisa Flamengo 2023', 'Camisa oficial do Flamengo temporada 2023', 249.90, 'flamengo.jpg', 50, 1),
('Camisa Corinthians 2023', 'Camisa oficial do Corinthians temporada 2023', 249.90, 'corinthians.jpg', 45, 1),
('Camisa São Paulo 2023', 'Camisa oficial do São Paulo temporada 2023', 239.90, 'saopaulo.jpg', 40, 1),
('Camisa Barcelona 2023', 'Camisa oficial do Barcelona temporada 2023', 299.90, 'barcelona.jpg', 30, 2),
('Camisa Real Madrid 2023', 'Camisa oficial do Real Madrid temporada 2023', 299.90, 'realmadrid.jpg', 35, 2),
('Camisa Brasil 2022', 'Camisa oficial da Seleção Brasileira Copa 2022', 349.90, 'brasil.jpg', 60, 3),
('Camisa Argentina 2022', 'Camisa oficial da Seleção Argentina Copa 2022', 329.90, 'argentina.jpg', 25, 3),
('Camisa Santos 1962', 'Camisa retrô do Santos de 1962 - Era Pelé', 199.90, 'santos1962.jpg', 15, 4);

-- Tabela de vendas
CREATE TABLE IF NOT EXISTS vendas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_cliente VARCHAR(100) NOT NULL,
    email_cliente VARCHAR(100) NOT NULL,
    endereco_cliente TEXT NOT NULL,
    telefone_cliente VARCHAR(20) NOT NULL,
    valor_total DECIMAL(10,2) NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'Pendente',
    data_venda TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de itens de venda
CREATE TABLE IF NOT EXISTS vendas_itens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    venda_id INT NOT NULL,
    produto_id INT NOT NULL,
    quantidade INT NOT NULL,
    preco_unitario DECIMAL(10,2) NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (venda_id) REFERENCES vendas(id) ON DELETE CASCADE,
    FOREIGN KEY (produto_id) REFERENCES produtos(id) ON DELETE CASCADE
);
