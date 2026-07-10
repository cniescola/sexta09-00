-- =====================================================================================
-- SCRIPT DE CRIAÇÃO DO BANCO DE DADOS (ESTILO MERCADO LIVRE)
-- Este arquivo foi criado para uso dos alunos no MySQL Workbench.
-- Cada comando está minuciosamente comentado explicando sua finalidade e sintaxe.
-- =====================================================================================

-- [COMANDO]: CREATE DATABASE
-- O comando CREATE DATABASE cria um novo banco de dados (esquema) no servidor MySQL.
-- O trecho IF NOT EXISTS é uma cláusula de segurança que impede erros caso o banco já exista.
-- DEFAULT CHARACTER SET define o conjunto de caracteres padrão como utf8mb4 para aceitar acentos, emojis e símbolos especiais.
-- DEFAULT COLLATE define as regras de comparação e ordenação de caracteres de forma insensível a maiúsculas/minúsculas (ci).
CREATE DATABASE IF NOT EXISTS `mercado_livre_db`
    DEFAULT CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

-- [COMANDO]: USE
-- O comando USE informa ao servidor MySQL que todas as operações subsequentes devem ser executadas dentro deste banco de dados.
USE `mercado_livre_db`;

-- =====================================================================================
-- TABELA 1: catalogo_sugestoes
-- Esta tabela armazena os produtos que já existem no "Catálogo Geral" do Mercado Livre.
-- Ela serve para simular a busca automatizada ("Encontre seu produto no catálogo").
-- =====================================================================================

-- [COMANDO]: CREATE TABLE
-- Cria a estrutura física da tabela se ela ainda não existir no banco selecionado.
CREATE TABLE IF NOT EXISTS `catalogo_sugestoes` (
    
    -- [CAMPO]: id
    -- INT: Tipo inteiro para armazenar números inteiros.
    -- NOT NULL: Impede que o campo fique vazio (nulo).
    -- AUTO_INCREMENT: O MySQL gera automaticamente o próximo número sequencial (1, 2, 3...) ao inserir um registro.
    `id` INT NOT NULL AUTO_INCREMENT,
    
    -- [CAMPO]: titulo
    -- VARCHAR(255): Tipo texto de tamanho variável até 255 caracteres. Adequado para nomes e títulos.
    `titulo` VARCHAR(255) NOT NULL,
    
    -- [CAMPO]: categoria
    -- VARCHAR(100): Armazena a categoria (ex: 'Produtos', 'Veículos') para filtragem.
    `categoria` VARCHAR(100) NOT NULL,
    
    -- [CAMPO]: marca
    -- VARCHAR(100): Armazena a marca do produto (ex: 'Gelopar', 'Samsung').
    `marca` VARCHAR(100) NOT NULL,
    
    -- [CAMPO]: modelo
    -- VARCHAR(100): Armazena o modelo técnico do produto (ex: 'Gesg-12', 'A56 5G').
    `modelo` VARCHAR(100) NOT NULL,
    
    -- [CAMPO]: voltagem_opcoes
    -- VARCHAR(255): Armazena as opções de variação separadas por vírgula (ex: '127V, 220V' ou 'Sem voltagem').
    `voltagem_opcoes` VARCHAR(255) DEFAULT NULL,
    
    -- [CAMPO]: imagem_principal
    -- VARCHAR(255): Guarda o caminho físico ou link da imagem que representará o produto.
    `imagem_principal` VARCHAR(255) NOT NULL,
    
    -- [CAMPO]: imagens_galeria
    -- TEXT: Tipo texto ilimitado usado para salvar os caminhos das outras fotos da galeria separados por vírgula.
    `imagens_galeria` TEXT DEFAULT NULL,
    
    -- [CAMPO]: preco_sugerido
    -- DECIMAL(10,2): Número decimal com 10 dígitos no total e 2 casas após a vírgula (ex: 2999.99). Ideal para valores monetários.
    `preco_sugerido` DECIMAL(10,2) NOT NULL,
    
    -- [CHAVE PRIMÁRIA]: PRIMARY KEY
    -- Define o campo 'id' como a chave de identificação única e exclusiva de cada linha desta tabela.
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================================================
-- TABELA 2: produtos_cadastrados
-- Esta tabela armazena os produtos que o usuário de fato cadastrou para venda.
-- O fluxo insere dados aqui quando o usuário clica em "Confirmar" e define preço/estoque.
-- =====================================================================================

CREATE TABLE IF NOT EXISTS `produtos_cadastrados` (
    `id` INT NOT NULL AUTO_INCREMENT,
    
    -- [CAMPO]: catalogo_id
    -- Guarda o ID de referência do catálogo para que saibamos de qual produto original ele se originou (Chave Estrangeira lógica).
    `catalogo_id` INT DEFAULT NULL,
    
    `titulo` VARCHAR(255) NOT NULL,
    `categoria` VARCHAR(100) NOT NULL,
    `marca` VARCHAR(100) NOT NULL,
    `modelo` VARCHAR(100) NOT NULL,
    
    -- [CAMPO]: voltagem_selecionada
    -- Salva a variação específica escolhida pelo usuário durante o fluxo (ex: '220V').
    `voltagem_selecionada` VARCHAR(50) DEFAULT NULL,
    
    `imagem_url` VARCHAR(255) NOT NULL,
    
    -- [CAMPO]: preco_venda
    -- O valor pelo qual o usuário deseja vender o produto, preenchido na etapa final.
    `preco_venda` DECIMAL(10,2) NOT NULL,
    
    -- [CAMPO]: estoque
    -- Quantidade disponível do produto cadastrado.
    `estoque` INT NOT NULL DEFAULT 1,
    
    -- [CAMPO]: condicao
    -- Define se o item é 'Novo' ou 'Usado'.
    `condicao` VARCHAR(50) NOT NULL DEFAULT 'Novo',
    
    -- [CAMPO]: data_cadastro
    -- TIMESTAMP: Grava a data e hora exata do cadastro.
    -- DEFAULT CURRENT_TIMESTAMP: O MySQL preenche automaticamente com o horário do sistema se nada for enviado.
    `data_cadastro` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- =====================================================================================
-- INSERÇÃO DE DADOS MOCKADOS (POPULANDO O CATÁLOGO DE SUGESTÕES)
-- INSERT INTO insere linhas nas tabelas criadas.
-- Inseriremos o expositor Gelopar da imagem e o Samsung Galaxy A56 para os testes de busca.
-- =====================================================================================

-- [COMANDO]: INSERT INTO
-- Especifica a tabela e quais colunas receberão os dados, seguidos pelos valores na cláusula VALUES.
INSERT INTO `catalogo_sugestoes` 
    (`titulo`, `categoria`, `marca`, `modelo`, `voltagem_opcoes`, `imagem_principal`, `imagens_galeria`, `preco_sugerido`) 
VALUES 
    (
        'Expositor Para Sorvetes De Massa Gesg-12 Pr Gelopar', 
        'Produtos', 
        'Gelopar', 
        'Gesg-12 Pr', 
        '127V, 220V', 
        'assets/gelopar_main.png', 
        'assets/gelopar_main.png,assets/gelopar_side1.png,assets/gelopar_side2.png,assets/gelopar_side3.png,assets/gelopar_side4.png', 
        4850.00
    ),
    (
        'Celular Samsung Galaxy A56 5G 256gb 8gb Ram Cinza', 
        'Produtos', 
        'Samsung', 
        'Galaxy A56 5G', 
        'Bivolt', 
        'assets/samsung_a56.png', 
        'assets/samsung_a56.png,assets/samsung_a56_back.png', 
        2199.00
    ),
    (
        'Tênis Adidas Coreracer Masculino Preto', 
        'Produtos', 
        'Adidas', 
        'Coreracer', 
        'Sem voltagem', 
        'assets/adidas_coreracer.png', 
        'assets/adidas_coreracer.png', 
        189.90
    );
