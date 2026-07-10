<?php
/**
 * =====================================================================================
 * TELA 5: LISTAGEM DE PRODUTOS CADASTRADOS (produtos.php)
 * =====================================================================================
 * Esta tela exibe todos os produtos salvos na tabela `produtos_cadastrados`.
 * Conforme novos cadastros são feitos no fluxo, eles aparecem aqui instantaneamente.
 * Para enriquecer o aprendizado dos alunos, incluímos também a operação de **DELETE**,
 * fechando o ciclo básico de manipulação de dados (CRUD).
 * 
 * Didática abordada:
 * - Leitura e listagem de linhas usando loops `while` com consultas SQL (`SELECT`).
 * - Formatação de moedas nacionais em PHP (`number_format`).
 * - Processamento de requisições de exclusão (`DELETE`).
 * - Alertas visuais dinâmicos de feedback ao usuário.
 */

// Importa a conexão com o banco de dados.
require_once "conexao.php";

// [BLOCO DE OPERAÇÃO: EXCLUSÃO DE ANÚNCIO (DELETE)]
// Se a URL contiver 'action=excluir' e um ID numérico válido, processamos a exclusão.
if (isset($_GET['action']) && $_GET['action'] === 'excluir' && isset($_GET['id'])) {
    
    // Obtém e converte o ID para inteiro para prevenir injeções de SQL.
    $id_excluir = intval($_GET['id']);
    
    // SQL estruturado com prepared statement.
    $sql_delete = "DELETE FROM `produtos_cadastrados` WHERE `id` = ?";
    
    if ($stmt = $conexao->prepare($sql_delete)) {
        // Vincula o ID inteiro ("i").
        $stmt->bind_param("i", $id_excluir);
        
        // Executa a exclusão física no banco de dados.
        if ($stmt->execute()) {
            $stmt->close();
            // Redireciona de volta para a mesma página, limpando os parâmetros anteriores da URL
            // e adicionando o aviso de excluido.
            header("Location: produtos.php?excluido=1");
            exit();
        } else {
            echo "Erro ao excluir produto: " . $stmt->error;
        }
        $stmt->close();
    }
}

// [BLOCO DE LEITURA: BUSCAR ANÚNCIOS CADASTRADOS]
// Consulta todos os produtos cadastrados ordenados pelo ID de forma decrescente (mais novos primeiro).
$sql_select = "SELECT * FROM `produtos_cadastrados` ORDER BY `id` DESC";
$resultado = $conexao->query($sql_select);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Anúncios - Mercado Livre</title>
    
    <!-- Link do Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- CSS Customizado -->
    <link href="css/custom.css" rel="stylesheet">
</head>
<body>

    <!-- Header padrão amarelo -->
    <header class="ml-header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <a href="index.php">
                    <svg class="ml-logo" viewBox="0 0 160 45" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="160" height="45" rx="4" fill="#fff159" />
                        <path d="M22 28.5c-1.5 0-3-.5-4-1.5l-4-4c-1-1-1-2.5 0-3.5s2.5-1 3.5 0l2 2 4-4c1-1 2.5-1 3.5 0s1 2.5 0 3.5l-5 5c-.3.3-.6.5-1 .5z" fill="#2D3277" stroke="#2D3277" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M31 16.5c-1-1-2.5-1-3.5 0l-5.5 5.5-1-1 4.5-4.5c1-1 1-2.5 0-3.5s-2.5-1-3.5 0l-6.5 6.5" fill="none" stroke="#2D3277" stroke-width="1.5" stroke-linecap="round"/>
                        <text x="45" y="22" font-family="'Roboto', sans-serif" font-weight="900" font-size="15" fill="#2D3277">mercado</text>
                        <text x="45" y="34" font-family="'Roboto', sans-serif" font-weight="900" font-size="15" fill="#2D3277">livre</text>
                    </svg>
                </a>
                
                <div class="d-flex gap-3 align-items-center">
                    <div class="rounded-circle bg-secondary text-white d-inline-flex justify-content-center align-items-center" style="width: 24px; height: 24px; font-size: 11px; font-weight: bold;">
                        VL
                    </div>
                    <span class="ml-nav-link text-uppercase fw-bold" style="font-size: 12px; cursor: pointer;">
                        Vitor Br... <span style="font-size: 10px;">▼</span>
                    </span>
                    <a href="#" class="ml-nav-link">Contato</a>
                    <a href="produtos.php" class="btn btn-sm btn-dark fw-medium px-3" style="font-size: 12px; border-radius: 4px;">Meus Anúncios</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Área Principal de Conteúdo -->
    <main class="py-5" style="min-height: calc(100vh - 200px);">
        <div class="container" style="max-width: 900px;">
            
            <!-- [ALERTAS DE SUCEESSO E EXCLUSÃO] -->
            <?php if (isset($_GET['sucesso']) && $_GET['sucesso'] == 1): ?>
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="background-color: #00a650; color: #ffffff; border-radius: 6px;">
                    <strong>Parabéns!</strong> Seu anúncio foi publicado com sucesso no Mercado Livre.
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['excluido']) && $_GET['excluido'] == 1): ?>
                <div class="alert alert-info alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="background-color: #3483fa; color: #ffffff; border-radius: 6px;">
                    O anúncio foi <strong>removido</strong> do sistema com sucesso.
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- Cabeçalho do Painel -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="fs-3 fw-bold text-dark mb-1">Meus anúncios cadastrados</h1>
                    <p class="text-secondary mb-0" style="font-size: 14px;">Gerencie os produtos publicados que você cadastrou no sistema.</p>
                </div>
                <!-- Botão de atalho para criar novo anúncio -->
                <a href="index.php" class="btn-ml-primary py-2 px-4" style="font-size: 15px;">+ Novo Anúncio</a>
            </div>

            <!-- Container Principal (Lista de Itens) -->
            <div class="card border-0 shadow-sm" style="border-radius: 6px; overflow: hidden;">
                
                <!-- 
                    [CONDICIONAL PHP]: Se a tabela de produtos cadastrados estiver vazia,
                    exibe um card informativo incentivando o cadastro.
                -->
                <?php if ($resultado->num_rows === 0): ?>
                    <div class="p-5 text-center bg-white">
                        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#cccccc" stroke-width="2" class="mb-3">
                            <rect x="3" y="3" width="18" height="18" rx="2"/>
                            <path d="M9 17h6M9 12h6M9 7h6"/>
                        </svg>
                        <h3 class="fs-5 fw-bold text-dark">Nenhum anúncio ativo no momento</h3>
                        <p class="text-secondary mb-4" style="font-size: 14px;">Você ainda não possui produtos cadastrados no sistema.</p>
                        <a href="index.php" class="btn-ml-primary py-2">Cadastrar meu primeiro produto</a>
                    </div>
                <?php else: ?>
                    
                    <!-- 
                        Loop que percorre cada registro encontrado no banco de dados.
                        O método fetch_assoc() retorna o próximo registro como array associativo.
                    -->
                    <?php while ($row = $resultado->fetch_assoc()): ?>
                        
                        <!-- 
                            Item Individual do Produto.
                            Estilizado com flexbox e layout responsivo.
                        -->
                        <div class="ml-product-list-card border-bottom bg-white flex-column flex-md-row text-center text-md-start">
                            
                            <!-- Foto do Produto -->
                            <div class="mb-3 mb-md-0 me-md-4">
                                <img 
                                    src="<?php echo htmlspecialchars($row['imagem_url']); ?>" 
                                    alt="<?php echo htmlspecialchars($row['titulo']); ?>" 
                                    class="img-fluid rounded-2 border p-1" 
                                    style="width: 100px; height: 100px; object-fit: contain; background-color: #ffffff;"
                                >
                            </div>

                            <!-- Informações Básicas do Produto (Alinhado no centro/esquerda) -->
                            <div class="flex-grow-1 mb-3 mb-md-0">
                                
                                <!-- Nome do item -->
                                <h2 class="fs-6 fw-bold mb-1 text-dark"><?php echo htmlspecialchars($row['titulo']); ?></h2>
                                
                                <!-- Marca, Modelo e Variação -->
                                <p class="text-secondary mb-2" style="font-size: 13px;">
                                    Marca: <strong><?php echo htmlspecialchars($row['marca']); ?></strong> | 
                                    Modelo: <strong><?php echo htmlspecialchars($row['modelo']); ?></strong> | 
                                    Variação: <strong><?php echo htmlspecialchars($row['voltagem_selecionada']); ?></strong>
                                </p>

                                <!-- Badges informativos de Condição (Novo/Usado) e Estoque -->
                                <div class="d-flex gap-2 justify-content-center justify-content-md-start">
                                    <!-- Badge de Condição -->
                                    <span class="ml-badge-success">
                                        <?php echo htmlspecialchars($row['condicao']); ?>
                                    </span>
                                    
                                    <!-- Badge de estoque -->
                                    <span class="badge bg-light text-dark border align-self-center" style="font-size: 11px; padding: 4px 8px;">
                                        Qtd: <?php echo intval($row['estoque']); ?> em estoque
                                    </span>
                                </div>
                            </div>

                            <!-- Coluna do Preço e Ações de Gerenciamento -->
                            <div class="text-md-end ps-md-4">
                                
                                <!-- Preço formatado com centavos sobressalentes estilo Mercado Livre -->
                                <div class="mb-3">
                                    <?php 
                                        // Formata o preço usando vírgulas decimais e pontos de milhar (ex: 4.850,99).
                                        $preco_formatado = number_format($row['preco_venda'], 2, ',', '.');
                                        
                                        // Divide o preço em Reais e Centavos a partir da vírgula.
                                        $partes = explode(',', $preco_formatado);
                                        $reais = $partes[0];
                                        $centavos = $partes[1];
                                    ?>
                                    <span class="ml-price">
                                        <span style="font-size: 14px; font-weight: 500;">R$</span> 
                                        <strong><?php echo $reais; ?></strong>
                                        <span class="ml-price-cents"><?php echo $centavos; ?></span>
                                    </span>
                                </div>

                                <!-- Botões de Ações CRUD -->
                                <div class="d-flex gap-2 justify-content-center justify-content-md-end">
                                    <!-- Botão decorativo simulando visualização -->
                                    <button class="btn btn-sm btn-outline-secondary px-3" style="font-size: 13px; border-radius: 4px;" onclick="alert('Visualização rápida do anúncio.')">
                                        Ver
                                    </button>
                                    
                                    <!-- 
                                        Botão Excluir.
                                        Dispara uma confirmação javascript no navegador. Se o usuário confirmar,
                                        redireciona para o link informando action=excluir e o ID do anúncio.
                                    -->
                                    <a 
                                        href="produtos.php?action=excluir&id=<?php echo $row['id']; ?>" 
                                        class="btn btn-sm btn-outline-danger px-3" 
                                        style="font-size: 13px; border-radius: 4px;"
                                        onclick="return confirm('Deseja realmente excluir este anúncio permanentemente do sistema?');"
                                    >
                                        Excluir
                                    </a>
                                </div>
                            </div>

                        </div>
                    <?php endwhile; ?>
                    
                <?php endif; ?>

            </div>

        </div>
    </main>

    <!-- Rodapé Padrão -->
    <footer class="ml-footer">
        <div class="container">
            <p class="text-center mb-4 text-secondary">
                Certifique-se de que seu anúncio cumpre com as 
                <a href="#" style="color: #3483fa;">Políticas do Mercado Livre</a>.
            </p>
            <div class="d-flex flex-wrap justify-content-center gap-3 mb-3 text-center">
                <a href="#">Trabalhe conosco</a>
                <a href="#">Termos e condições</a>
                <a href="#">Promoções</a>
                <a href="#">Como cuidamos da sua privacidade</a>
                <a href="#">Acessibilidade</a>
                <a href="#">Contato</a>
                <a href="#">Informações sobre seguros</a>
                <a href="#">Programa de Afiliados</a>
            </div>
            <div class="text-center text-secondary" style="font-size: 11px;">
                <p class="mb-1">Copyright © 1999-2026 Mercado Livre Brasil Ltda.</p>
                <p class="mb-0">CNPJ n.º 03.007.331/0001-41 / Av. das Nações Unidas, nº 3.003, Bonfim, Osasco/SP - CEP 06233-903 - empresa do grupo Mercado Livre.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
