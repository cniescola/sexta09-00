<?php
/**
 * =====================================================================================
 * TELA 4: DETALHES FINAIS E SALVAMENTO NO BANCO (finalizar.php)
 * =====================================================================================
 * Esta página possui dupla função:
 * 1. Exibir o formulário final para inserção de Preço, Estoque e Condição do item selecionado.
 * 2. Processar a gravação física (INSERT) dos dados no banco MySQL usando MySQLi + Prepared Statements.
 * 
 * Didática abordada:
 * - Validação de dados vindos via formulário HTTP POST (`$_POST`).
 * - Envio de dados invisíveis via campos ocultos (`<input type="hidden">`).
 * - Execução de comandos SQL de inserção (`INSERT INTO`).
 * - Redirecionamento de páginas no lado do servidor com a função `header("Location: ...")`.
 */

// Importa a conexão com o banco de dados.
require_once "conexao.php";

// [FASE DE PROCESSAMENTO: SALVAMENTO DO PRODUTO]
// Verifica se a requisição é do tipo POST e se o parâmetro 'action' é igual a 'salvar'.
// Isso indica que o usuário preencheu o formulário desta página e clicou em "Finalizar Anúncio".
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'salvar') {
    
    // Captura os dados do formulário POST.
    $catalogo_id = intval($_POST['catalogo_id']); // Converte para inteiro por segurança.
    $titulo = trim($_POST['titulo']);
    $categoria = trim($_POST['categoria']);
    $marca = trim($_POST['marca']);
    $modelo = trim($_POST['modelo']);
    $voltagem_selecionada = trim($_POST['voltagem_selecionada']);
    $imagem_url = trim($_POST['imagem_url']);
    
    // Captura os campos preenchidos pelo usuário nesta etapa final.
    // floatval() converte a string do preço em um número de ponto flutuante.
    // Usamos str_replace para substituir eventuais vírgulas decimais por pontos (formato padrão do banco de dados).
    $preco_venda = floatval(str_replace(',', '.', $_POST['preco_venda']));
    $estoque = intval($_POST['estoque']);
    $condicao = trim($_POST['condicao']);
    
    // [VALIDAÇÃO SIMPLES DOS CAMPOS]
    if (empty($titulo) || $preco_venda <= 0 || $estoque < 1) {
        die("Erro: Dados de entrada inválidos. Verifique se o preço é maior que zero e o estoque é pelo menos 1.");
    }
    
    // [INSERÇÃO NO BANCO DE DADOS: PREPARED STATEMENT]
    // A query INSERT INTO adiciona uma nova linha à tabela 'produtos_cadastrados'.
    $sql = "INSERT INTO `produtos_cadastrados` 
            (`catalogo_id`, `titulo`, `categoria`, `marca`, `modelo`, `voltagem_selecionada`, `imagem_url`, `preco_venda`, `estoque`, `condicao`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
    // Prepara a consulta no servidor MySQL.
    if ($stmt = $conexao->prepare($sql)) {
        
        // Vincula as variáveis aos parâmetros.
        // O primeiro argumento "issssssdis" representa os tipos de cada dado na ordem:
        // i = inteiro, s = string, d = decimal/double
        $stmt->bind_param(
            "issssssdis", 
            $catalogo_id, 
            $titulo, 
            $categoria, 
            $marca, 
            $modelo, 
            $voltagem_selecionada, 
            $imagem_url, 
            $preco_venda, 
            $estoque, 
            $condicao
        );
        
        // Executa a query no banco de dados.
        if ($stmt->execute()) {
            // Se gravado com sucesso, fecha o statement.
            $stmt->close();
            
            // Redireciona o navegador do usuário imediatamente para a tela 5 (produtos.php)
            // onde ele poderá visualizar a lista atualizada de produtos.
            header("Location: produtos.php?sucesso=1");
            exit(); // Para a execução do script para garantir que o redirecionamento aconteça sem carregar o resto.
        } else {
            echo "Erro ao gravar anúncio: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Erro de preparação da query: " . $conexao->error;
    }
}

// [FASE DE EXIBIÇÃO: FORMULÁRIO DE PREÇO/ESTOQUE]
// Se o script não for um redirecionamento de gravação, precisamos dos dados básicos do produto
// enviados a partir da página anterior (buscar.php). Se não existirem, mandamos de volta para buscar.
if (!isset($_POST['catalogo_id'])) {
    header("Location: buscar.php");
    exit();
}

// Recebe os dados da confirmação do catálogo da página buscar.php.
$catalogo_id = $_POST['catalogo_id'];
$titulo = $_POST['titulo'];
$categoria = $_POST['categoria'];
$marca = $_POST['marca'];
$modelo = $_POST['modelo'];
$voltagem_selecionada = $_POST['voltagem_selecionada'];
$imagem_url = $_POST['imagem_url'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizar Anúncio - Mercado Livre</title>
    
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
                    <a href="produtos.php" class="btn btn-sm btn-outline-dark fw-medium px-3" style="font-size: 12px; border-radius: 4px;">Meus Anúncios</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Área Principal de Conteúdo -->
    <main class="py-4" style="min-height: calc(100vh - 200px);">
        <div class="container" style="max-width: 800px;">
            
            <!-- Link de retorno para a busca -->
            <div class="mb-4">
                <!-- Envia de volta para recomeçar o processo de catálogo -->
                <a href="buscar.php" class="back-link">&lt; Escolher outro produto</a>
            </div>

            <!-- Título da Etapa -->
            <span class="step-indicator">Etapa 2 de 3</span>
            <h1 class="fs-3 fw-bold mt-1 mb-4 text-dark">Preencha as informações comerciais do seu anúncio</h1>

            <!-- Card de Confirmação e Dados Finais -->
            <div class="ml-card p-4">
                
                <!-- Resumo do Produto Selecionado do Catálogo -->
                <div class="d-flex align-items-center gap-3 p-3 bg-light rounded-2 border mb-4">
                    <!-- Foto em miniatura -->
                    <img 
                        src="<?php echo htmlspecialchars($imagem_url); ?>" 
                        alt="Miniatura do Produto" 
                        class="img-thumbnail" 
                        style="width: 60px; height: 60px; object-fit: contain;"
                    >
                    <div>
                        <!-- Título e variação de voltagem exibidos de forma clara -->
                        <h4 class="fs-6 fw-bold mb-1 text-dark"><?php echo htmlspecialchars($titulo); ?></h4>
                        <span class="text-secondary" style="font-size: 13px;">
                            Categoria: <strong><?php echo htmlspecialchars($categoria); ?></strong> | 
                            Variação: <strong><?php echo htmlspecialchars($voltagem_selecionada); ?></strong>
                        </span>
                    </div>
                </div>

                <!-- 
                    Formulário Final.
                    Este formulário envia seus dados para esta mesma página (finalizar.php) via POST,
                    onde o bloco PHP no topo interceptará a requisição para realizar a gravação no banco.
                -->
                <form action="finalizar.php" method="POST">
                    
                    <!-- 
                        Parâmetro de controle.
                        Informa ao bloco PHP que o usuário deseja de fato persistir os dados.
                    -->
                    <input type="hidden" name="action" value="salvar">
                    
                    <!-- Envio oculto dos atributos do produto que vieram da busca -->
                    <input type="hidden" name="catalogo_id" value="<?php echo htmlspecialchars($catalogo_id); ?>">
                    <input type="hidden" name="titulo" value="<?php echo htmlspecialchars($titulo); ?>">
                    <input type="hidden" name="categoria" value="<?php echo htmlspecialchars($categoria); ?>">
                    <input type="hidden" name="marca" value="<?php echo htmlspecialchars($marca); ?>">
                    <input type="hidden" name="modelo" value="<?php echo htmlspecialchars($modelo); ?>">
                    <input type="hidden" name="voltagem_selecionada" value="<?php echo htmlspecialchars($voltagem_selecionada); ?>">
                    <input type="hidden" name="imagem_url" value="<?php echo htmlspecialchars($imagem_url); ?>">

                    <div class="row g-4">
                        
                        <!-- Campo 1: Preço de Venda -->
                        <div class="col-md-6">
                            <!-- 
                                [CLASSE BOOTSTRAP]: form-label
                                Estiliza o rótulo do campo com distanciamento apropriado.
                            -->
                            <label for="preco_venda" class="form-label fw-medium text-dark" style="font-size: 14px;">Preço de Venda (R$)</label>
                            
                            <!-- 
                                [CLASSE BOOTSTRAP]: input-group
                                Permite agrupar ícones ou textos fixos ao lado do campo (no caso, o cifrão R$).
                            -->
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 text-secondary" style="border-radius: 6px 0 0 6px;">R$</span>
                                <input 
                                    type="text" 
                                    name="preco_venda" 
                                    id="preco_venda"
                                    class="form-control border-start-0 ps-1" 
                                    placeholder="Ex.: 4500.00" 
                                    style="border-radius: 0 6px 6px 0; height: 48px;"
                                    required
                                >
                            </div>
                            <span class="text-secondary d-block mt-1" style="font-size: 12px;">Use ponto para separar centavos (ex: 4500.99).</span>
                        </div>

                        <!-- Campo 2: Quantidade em Estoque -->
                        <div class="col-md-6">
                            <label for="estoque" class="form-label fw-medium text-dark" style="font-size: 14px;">Estoque Disponível</label>
                            <input 
                                type="number" 
                                name="estoque" 
                                id="estoque"
                                class="form-control" 
                                min="1" 
                                value="1" 
                                style="border-radius: 6px; height: 48px;"
                                required
                            >
                            <span class="text-secondary d-block mt-1" style="font-size: 12px;">Defina a quantidade real que você possui para venda.</span>
                        </div>

                        <!-- Campo 3: Condição do Produto -->
                        <div class="col-md-12">
                            <label class="form-label fw-medium text-dark d-block mb-3" style="font-size: 14px;">Condição do Produto</label>
                            
                            <!-- Opções lado a lado (Novo / Usado) usando Radio Buttons do Bootstrap -->
                            <div class="d-flex gap-4">
                                <!-- Opção Novo -->
                                <div class="form-check">
                                    <input 
                                        class="form-check-input" 
                                        type="radio" 
                                        name="condicao" 
                                        id="condicao_novo" 
                                        value="Novo" 
                                        checked
                                    >
                                    <label class="form-check-label text-dark" for="condicao_novo" style="font-size: 14px;">
                                        Novo
                                    </label>
                                </div>
                                
                                <!-- Opção Usado -->
                                <div class="form-check">
                                    <input 
                                        class="form-check-input" 
                                        type="radio" 
                                        name="condicao" 
                                        id="condicao_usado" 
                                        value="Usado"
                                    >
                                    <label class="form-check-label text-dark" for="condicao_usado" style="font-size: 14px;">
                                        Usado
                                    </label>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Botões de Ação na base do formulário -->
                    <div class="d-flex flex-column flex-sm-row gap-3 pt-4 mt-4 border-top justify-content-end">
                        <!-- Botão que cancela e retorna para a busca -->
                        <a href="buscar.php" class="btn-ml-secondary">Cancelar</a>
                        
                        <!-- Botão de finalização (submete o form) -->
                        <button type="submit" class="btn-ml-primary">Finalizar e Anunciar</button>
                    </div>

                </form>

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
