<?php
/**
 * =====================================================================================
 * TELA 2 e 3: BUSCA E CONFIRMAÇÃO NO CATÁLOGO (buscar.php)
 * =====================================================================================
 * Esta tela permite ao usuário buscar o produto no catálogo geral (Tela 2)
 * e exibe o resultado encontrado para que ele selecione variações e confirme (Tela 3).
 * 
 * Didática abordada:
 * - Leitura de parâmetros da URL via método GET (`$_GET`).
 * - Proteção contra SQL Injection usando Prepared Statements (mysqli::prepare).
 * - Estruturas condicionais (`if/else`) para alternar a interface do usuário.
 */

// Importa a conexão com o banco de dados.
require_once "conexao.php";

// [INICIALIZAÇÃO DE VARIÁVEIS]
$termo_busca = ""; // Armazenará o termo digitado pelo usuário.
$produto_encontrado = null; // Guardará os dados do produto do catálogo, se houver match.
$imagens_galeria = []; // Array que guardará a lista de fotos do produto.

// [VERIFICAÇÃO DE CONSULTA]
// Se o parâmetro 'q' (query) estiver definido na URL, significa que o usuário disparou a busca.
if (isset($_GET['q']) && !empty(trim($_GET['q']))) {
    // Sanitiza e obtém o termo de busca (ex: "gesg").
    $termo_busca = trim($_GET['q']);
    
    // [SEGURANÇA: PREPARED STATEMENT]
    // Em vez de concatenar a variável diretamente na query (o que geraria risco de SQL Injection),
    // preparamos um modelo de query com o sinal de interrogação '?' como placeholder.
    $sql = "SELECT * FROM `catalogo_sugestoes` WHERE `titulo` LIKE ? OR `modelo` LIKE ? LIMIT 1";
    
    // Prepara a query no servidor MySQL.
    if ($stmt = $conexao->prepare($sql)) {
        
        // Define o termo com curingas '%' do SQL para buscar palavras parciais (ex: '%gesg%').
        $like_termo = "%" . $termo_busca . "%";
        
        // Vincula as variáveis aos placeholders '?'.
        // O primeiro argumento "ss" indica que os dois parâmetros vinculados são Strings.
        $stmt->bind_param("ss", $like_termo, $like_termo);
        
        // Executa a instrução preparada no banco de dados.
        $stmt->execute();
        
        // Obtém o conjunto de resultados da consulta.
        $resultado = $stmt->get_result();
        
        // Se retornar alguma linha, extraímos o produto encontrado.
        if ($resultado->num_rows > 0) {
            // fetch_assoc() transforma a linha de resultado em um array associativo (chave => valor).
            $produto_encontrado = $resultado->fetch_assoc();
            
            // Explode a string de imagens da galeria (separada por vírgula) em um array real do PHP.
            if (!empty($produto_encontrado['imagens_galeria'])) {
                $imagens_galeria = explode(',', $produto_encontrado['imagens_galeria']);
            }
        }
        
        // Fecha o prepared statement para liberar recursos do servidor de banco.
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anuncie no Catálogo - Mercado Livre</title>
    
    <!-- Link do Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Nosso CSS customizado -->
    <link href="css/custom.css" rel="stylesheet">
</head>
<body>

    <!-- Header padrão com fundo amarelo -->
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
        <div class="container">
            
            <!-- Link de retorno para a tela anterior -->
            <div class="mb-4">
                <a href="index.php" class="back-link">
                    <!-- Símbolo de menor '<' desenhado de forma simples -->
                    &lt; Anterior
                </a>
            </div>

            <!-- 
                Grelha de duas colunas:
                Esquerda (col-md-8): Título, subtítulo e o Card Principal de busca/resultado.
                Direita (col-md-4): Ilustração sutil de notebook com um produto.
            -->
            <div class="row g-4 align-items-start">
                
                <div class="col-lg-8">
                    <!-- Indicador de progresso do anúncio -->
                    <span class="step-indicator">Etapa 1 de 3</span>
                    <h1 class="fs-3 fw-bold mt-1 mb-4 text-dark" style="max-width: 600px;">
                        Para anunciar mais rápido, procure seu produto no nosso catálogo
                    </h1>

                    <!-- 
                        [CONDICIONAL PHP]: Se o produto NÃO foi encontrado ou nenhuma busca foi feita,
                        exibe a interface padrão de pesquisa (Abas + Input de busca).
                    -->
                    <?php if (!$produto_encontrado): ?>
                        
                        <!-- Card Principal Branco de Busca -->
                        <div class="ml-card p-4">
                            <!-- Abas Superiores -->
                            <div class="d-flex border-bottom mb-4">
                                <button type="button" class="tab-btn active">Por palavras-chave</button>
                                <button type="button" class="tab-btn position-relative" onclick="alert('Busca por foto indisponível nesta versão de demonstração.')">
                                    Por foto
                                    <span class="badge-novo">NOVO</span>
                                </button>
                                <button type="button" class="tab-btn" onclick="alert('Busca por código de barras indisponível nesta versão de demonstração.')">Por código</button>
                            </div>

                            <!-- Títulos explicativos internos do formulário -->
                            <h2 class="fs-6 fw-bold mb-1 text-dark">Escreva o nome, a marca, o modelo e outras características do produto</h2>
                            <p class="text-secondary mb-4" style="font-size: 14px;">Quanto mais detalhes você adicionar, melhores serão os resultados da busca.</p>

                            <!-- 
                                Formulário de Busca.
                                Envia os dados para a própria página (buscar.php) via método GET.
                            -->
                            <form action="buscar.php" method="GET">
                                <div class="row g-3">
                                    <div class="col-md-9">
                                        <!-- Container de entrada estilizado -->
                                        <div class="ml-input-group">
                                            <!-- Campo de Texto real -->
                                            <input 
                                                type="text" 
                                                name="q" 
                                                class="ml-input" 
                                                placeholder="Ex.: Celular Samsung Galaxy A56 5g 256gb 8gb Ram Cinza"
                                                value="<?php echo htmlspecialchars($termo_busca); ?>"
                                                required
                                            >
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <!-- Botão de submissão do formulário -->
                                        <button type="submit" class="btn-ml-primary w-100 h-100 py-3">Buscar</button>
                                    </div>
                                </div>
                            </form>

                            <!-- Feedback de erro caso a busca não retorne nada -->
                            <?php if (isset($_GET['q']) && !$produto_encontrado): ?>
                                <div class="alert alert-warning mt-4 text-center" role="alert" style="font-size: 14px; border-radius: 6px;">
                                    Não encontramos nenhum produto com <strong>"<?php echo htmlspecialchars($termo_busca); ?>"</strong> no catálogo de demonstração.<br>
                                    <span class="text-secondary">Dica: Tente pesquisar por <strong>"gesg"</strong>, <strong>"samsung"</strong> ou <strong>"adidas"</strong>.</span>
                                </div>
                            <?php endif; ?>
                        </div>

                    <!-- 
                        [CONDICIONAL PHP - ELSE]: Se o produto FOI encontrado,
                        exibe a tela 3 (detalhes do item do catálogo para confirmação).
                    -->
                    <?php else: ?>
                        
                        <!-- Card Principal Branco contendo o produto selecionado -->
                        <div class="ml-card p-4">
                            
                            <!-- 
                                Barra de pesquisa no topo com o termo digitado (conforme a imagem 3).
                                Permite alterar a busca se desejar.
                            -->
                            <form action="buscar.php" method="GET" class="mb-4 pb-4 border-bottom">
                                <div class="row g-2 align-items-center">
                                    <div class="col-md-9">
                                        <div class="ml-input-group px-2">
                                            <input 
                                                type="text" 
                                                name="q" 
                                                class="ml-input" 
                                                value="<?php echo htmlspecialchars($termo_busca); ?>"
                                                required
                                            >
                                            <!-- Botão X simples para limpar a busca -->
                                            <a href="buscar.php" class="text-secondary px-2 text-decoration-none fw-bold" style="font-size: 18px;">&times;</a>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" class="btn-ml-primary w-100 py-2" style="font-size: 15px;">Buscar</button>
                                    </div>
                                </div>
                            </form>

                            <!-- 
                                Detalhamento do Produto Encontrado no Catálogo.
                                Estrutura de Grid:
                                - Miniaturas (col-md-2)
                                - Imagem Principal (col-md-5)
                                - Informações técnicas e seleção de variação (col-md-5)
                            -->
                            <div class="row g-3">
                                
                                <!-- Coluna 1: Galeria de Miniaturas -->
                                <div class="col-2 col-sm-1 col-md-2 col-lg-1">
                                    <div class="thumbnail-gallery">
                                        <!-- Loop PHP que gera cada miniatura presente no banco de dados -->
                                        <?php foreach ($imagens_galeria as $index => $img): ?>
                                            <img 
                                                src="<?php echo htmlspecialchars($img); ?>" 
                                                alt="Miniatura <?php echo $index + 1; ?>"
                                                class="thumb-item <?php echo $index === 0 ? 'active' : ''; ?>"
                                                onclick="trocarImagemPrincipal('<?php echo htmlspecialchars($img); ?>', this)"
                                            >
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                                <!-- Coluna 2: Container da Imagem Principal Ampliada -->
                                <div class="col-10 col-sm-11 col-md-10 col-lg-6">
                                    <div class="main-image-container">
                                        <img 
                                            id="imagem-principal-exibicao" 
                                            src="<?php echo htmlspecialchars($produto_encontrado['imagem_principal']); ?>" 
                                            alt="Foto Principal do Produto"
                                        >
                                    </div>
                                </div>

                                <!-- Coluna 3: Ficha Técnica e Seleção de Variação -->
                                <div class="col-md-12 col-lg-5 ps-lg-4">
                                    <!-- Título do Produto no Catálogo -->
                                    <h3 class="fs-5 fw-bold mb-3 text-dark"><?php echo htmlspecialchars($produto_encontrado['titulo']); ?></h3>
                                    
                                    <!-- Formulário final que enviará o produto para cadastro definitivo -->
                                    <form action="finalizar.php" method="POST" id="form-confirmar">
                                        
                                        <!-- Inputs ocultos (hidden) para enviar os dados básicos via POST -->
                                        <input type="hidden" name="catalogo_id" value="<?php echo $produto_encontrado['id']; ?>">
                                        <input type="hidden" name="titulo" value="<?php echo htmlspecialchars($produto_encontrado['titulo']); ?>">
                                        <input type="hidden" name="categoria" value="<?php echo htmlspecialchars($produto_encontrado['categoria']); ?>">
                                        <input type="hidden" name="marca" value="<?php echo htmlspecialchars($produto_encontrado['marca']); ?>">
                                        <input type="hidden" name="modelo" value="<?php echo htmlspecialchars($produto_encontrado['modelo']); ?>">
                                        <input type="hidden" name="imagem_url" value="<?php echo htmlspecialchars($produto_encontrado['imagem_principal']); ?>">
                                        
                                        <!-- [BLOCO DE SELEÇÃO DE VARIAÇÃO: VOLTAGEM] -->
                                        <?php if (!empty($produto_encontrado['voltagem_opcoes']) && $produto_encontrado['voltagem_opcoes'] !== 'Sem voltagem'): ?>
                                            <div class="mb-4">
                                                <span class="d-block text-secondary mb-2" style="font-size: 13px;">Voltagem: 
                                                    <!-- Exibição dinâmica da voltagem ativa -->
                                                    <strong class="text-dark" id="voltagem-selecionada-label">127V</strong>
                                                </span>
                                                <div class="d-flex gap-2">
                                                    <!-- 
                                                        Transforma a string '127V, 220V' em array do PHP
                                                        e desenha cada botão para o usuário selecionar.
                                                    -->
                                                    <?php 
                                                    $volts = explode(',', $produto_encontrado['voltagem_opcoes']);
                                                    foreach ($volts as $idx => $v): 
                                                        $v = trim($v);
                                                    ?>
                                                        <button 
                                                            type="button" 
                                                            class="variation-btn <?php echo $idx === 0 ? 'active' : ''; ?>"
                                                            onclick="selecionarVoltagem('<?php echo $v; ?>', this)"
                                                        >
                                                            <?php echo $v; ?>
                                                        </button>
                                                    <?php endforeach; ?>
                                                </div>
                                                
                                                <!-- Campo oculto que salva a voltagem selecionada no formulário -->
                                                <input type="hidden" name="voltagem_selecionada" id="input-voltagem" value="<?php echo trim($volts[0]); ?>">
                                            </div>
                                        <?php else: ?>
                                            <!-- Se não possuir voltagem, envia vazio ou 'Não aplicável' -->
                                            <input type="hidden" name="voltagem_selecionada" value="Não se aplica">
                                        <?php endif; ?>

                                        <!-- Detalhes Técnicos listados (Ficha técnica resumida) -->
                                        <ul class="list-unstyled mb-4" style="font-size: 14px;">
                                            <li class="mb-2"><strong>Marca:</strong> <?php echo htmlspecialchars($produto_encontrado['marca']); ?></li>
                                            <li class="mb-2"><strong>Modelo:</strong> <?php echo htmlspecialchars($produto_encontrado['modelo']); ?></li>
                                        </ul>

                                        <!-- Link decorativo simulando o Mercado Livre original -->
                                        <a href="#" class="text-decoration-none d-block mb-4" style="font-size: 13px; color: #3483fa;" onclick="alert('Esta funcionalidade abriria a ficha técnica completa do catálogo.')">
                                            Mostrar todas as características
                                        </a>

                                        <!-- 
                                            Botões de Ação na base do formulário (Tela 3).
                                            - Não é o que eu vendo: Retorna para a tela de pesquisa limpa.
                                            - Confirmar: Envia o formulário POST com os detalhes para a página finalizar.php.
                                        -->
                                        <div class="d-flex flex-column flex-sm-row gap-3 pt-3 border-top justify-content-end">
                                            <a href="buscar.php" class="btn-ml-secondary">Não é o que eu vendo</a>
                                            <button type="submit" class="btn-ml-primary">Confirmar</button>
                                        </div>

                                    </form>
                                </div>

                            </div>

                        </div>
                    <?php endif; ?>

                </div>

                <!-- 
                    Coluna Direita: Ilustração de apoio (Desktop).
                    Exibe a imagem decorativa de anúncio rápido.
                    - d-none d-lg-block (Bootstrap): Oculta esta coluna em telas menores para focar na busca.
                -->
                <div class="col-lg-4 d-none d-lg-block text-center mt-5 pt-3">
                    <!-- Vetor ou imagem ilustrativa simplificada de um notebook com tênis na tela -->
                    <svg width="240" height="200" viewBox="0 0 240 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <!-- Tela do Computador -->
                        <rect x="30" y="20" width="180" height="120" rx="8" fill="#ebebeb" stroke="#cccccc" stroke-width="2"/>
                        <rect x="38" y="28" width="164" height="104" rx="4" fill="#ffffff"/>
                        <!-- Teclado / Base do Computador -->
                        <path d="M10 140 H230 L210 160 H30 Z" fill="#dddddd" stroke="#cccccc" stroke-width="2" stroke-linejoin="round"/>
                        <rect x="100" y="150" width="40" height="4" fill="#bbbbbb" rx="2"/>
                        <!-- Sapato ilustrativo na tela do note -->
                        <path d="M80 90 L110 65 L130 67 L160 85 L160 90 Z" fill="#ffffff" stroke="#bbbbbb" stroke-width="2"/>
                        <path d="M100 80 L130 80" stroke="#3483fa" stroke-width="2" stroke-linecap="round"/>
                        <circle cx="150" cy="80" r="1.5" fill="#3483fa"/>
                        <!-- Sombra abaixo do computador -->
                        <ellipse cx="120" cy="175" rx="90" ry="8" fill="#e0e0e0"/>
                    </svg>
                </div>

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

    <!-- Importação do arquivo JS do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- 
        [TAG]: script (Nosso JavaScript Customizado)
        Importa o arquivo js/main.js onde codificamos a lógica de troca de imagens de galeria
        e alteração visual/funcional de seleção das variações do produto.
    -->
    <script src="js/main.js"></script>
</body>
</html>
