<?php
/**
 * =====================================================================================
 * TELA 1: SELEÇÃO DE CATEGORIA (index.php)
 * =====================================================================================
 * Esta é a tela inicial do fluxo de anúncios.
 * O usuário escolhe o tipo de item que deseja anunciar.
 * Para fins didáticos, o card de "Produtos" redirecionará para a etapa de busca.
 */

// Incluímos a conexão por segurança, embora nesta tela inicial
// não façamos consultas diretas ao banco, isso mostra aos alunos a estrutura padrão.
require_once "conexao.php";
?>
<!DOCTYPE html>
<!-- 
    [TAG]: html
    A tag raiz de todo documento HTML. O atributo 'lang="pt-br"' define o idioma da página
    para que navegadores e leitores de tela entendam a pronúncia correta do conteúdo.
-->
<html lang="pt-br">
<head>
    <!-- 
        [TAG]: meta charset
        Define a codificação de caracteres UTF-8. Impede que acentuações quebrem no navegador.
    -->
    <meta charset="UTF-8">
    
    <!-- 
        [TAG]: meta viewport
        Crucial para design responsivo. Garante que a página renderize na largura correta
        de qualquer dispositivo (celulares, tablets ou computadores), controlando o zoom inicial.
    -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- 
        [TAG]: title
        O título da página exibido na aba do navegador. Relevante para SEO e usabilidade.
    -->
    <title>Olá! Antes de mais nada, o que você vai anunciar? - Mercado Livre</title>
    
    <!-- 
        [TAG]: link (Bootstrap CDN)
        Importa o framework CSS Bootstrap versão 5 direto dos servidores CDN.
        O Bootstrap agiliza o desenvolvimento fornecendo classes pré-prontas de grid e componentes.
    -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- 
        [TAG]: link (Custom CSS)
        Importa o nosso arquivo de estilo customizado que reescreve estilos do Bootstrap
        para aplicar as cores e formas fiéis do Mercado Livre.
    -->
    <link href="css/custom.css" rel="stylesheet">
</head>
<body>

    <!-- 
        [TAG SEMÂNTICA]: header
        Define o cabeçalho do site. Usamos a classe customizada '.ml-header' para dar o fundo amarelo.
    -->
    <header class="ml-header">
        <!-- 
            [CLASSE BOOTSTRAP]: container
            Centraliza horizontalmente os elementos na tela e define larguras máximas responsivas.
        -->
        <div class="container">
            <!-- 
                [CLASSES BOOTSTRAP]: d-flex, justify-content-between, align-items-center
                - d-flex: Ativa o modelo Flexbox de layout unidimensional.
                - justify-content-between: Empurra o logo para a esquerda e o menu para a direita.
                - align-items-center: Alinha verticalmente os elementos no centro do cabeçalho.
            -->
            <div class="d-flex justify-content-between align-items-center">
                <!-- Link que envelopa o logotipo -->
                <a href="index.php">
                    <!-- 
                        [TAG]: svg (Logotipo desenhado via vetor)
                        Usamos vetores SVG em vez de imagens pesadas. Este código desenha o aperto de mãos
                        junto ao texto "mercado livre". É escalável, leve e nítido em qualquer tela.
                    -->
                    <svg class="ml-logo" viewBox="0 0 160 45" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="Logo Mercado Livre">
                        <!-- O retângulo amarelo de fundo -->
                        <rect width="160" height="45" rx="4" fill="#fff159" />
                        <!-- Desenho das duas mãos se cumprimentando (Vetor sutil do Mercado Livre) -->
                        <path d="M22 28.5c-1.5 0-3-.5-4-1.5l-4-4c-1-1-1-2.5 0-3.5s2.5-1 3.5 0l2 2 4-4c1-1 2.5-1 3.5 0s1 2.5 0 3.5l-5 5c-.3.3-.6.5-1 .5z" fill="#2D3277" stroke="#2D3277" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M31 16.5c-1-1-2.5-1-3.5 0l-5.5 5.5-1-1 4.5-4.5c1-1 1-2.5 0-3.5s-2.5-1-3.5 0l-6.5 6.5" fill="none" stroke="#2D3277" stroke-width="1.5" stroke-linecap="round"/>
                        <!-- Texto escrito "mercado livre" com estilo próprio -->
                        <text x="45" y="22" font-family="'Roboto', sans-serif" font-weight="900" font-size="15" fill="#2D3277">mercado</text>
                        <text x="45" y="34" font-family="'Roboto', sans-serif" font-weight="900" font-size="15" fill="#2D3277">livre</text>
                    </svg>
                </a>
                
                <!-- 
                    [CLASSES BOOTSTRAP]: d-flex, gap-3
                    - gap-3: Cria um espaçamento de 1rem (16px) entre os itens do menu (Flexbox).
                -->
                <div class="d-flex gap-3 align-items-center">
                    <!-- 
                        [CLASSES BOOTSTRAP]: rounded-circle, bg-secondary, text-white, d-inline-flex, justify-content-center, align-items-center
                        Criamos a bolinha do perfil "VL" do usuário VITOR BR...
                    -->
                    <div class="rounded-circle bg-secondary text-white d-inline-flex justify-content-center align-items-center" style="width: 24px; height: 24px; font-size: 11px; font-weight: bold;">
                        VL
                    </div>
                    <!-- Menu de usuário dropdown simples -->
                    <span class="ml-nav-link text-uppercase fw-bold" style="font-size: 12px; cursor: pointer;">
                        Vitor Br... <span style="font-size: 10px;">▼</span>
                    </span>
                    <a href="#" class="ml-nav-link">Contato</a>
                    <a href="produtos.php" class="btn btn-sm btn-outline-dark fw-medium px-3" style="font-size: 12px; border-radius: 4px;">Meus Anúncios</a>
                </div>
            </div>
        </div>
    </header>

    <!-- 
        [TAG SEMÂNTICA]: main
        Representa a área de conteúdo principal da página, que muda em cada arquivo.
        - py-5 (Bootstrap): Adiciona preenchimento (padding) interno de 3rem nas partes superior e inferior.
    -->
    <main class="py-5" style="min-height: calc(100vh - 200px);">
        <div class="container">
            
            <!-- Título Principal Centralizado -->
            <div class="text-center mb-5">
                <h1 class="ml-title mb-3">Olá! Antes de mais nada,<br>o que você vai anunciar?</h1>
            </div>

            <!-- 
                [CLASSE BOOTSTRAP]: row
                Inicia um sistema de linhas da grade do Bootstrap.
                - justify-content-center: Centraliza as colunas caso não preencham toda a largura.
                - g-4: Adiciona espaçamento (gutter) de 1.5rem entre as colunas.
            -->
            <div class="row justify-content-center g-4">
                
                <!-- 
                    [CLASSE BOOTSTRAP]: col-6, col-md-3, col-lg-2
                    - col-6: Ocupa metade da largura em telas pequenas (celulares).
                    - col-md-3: Ocupa 3 colunas das 12 disponíveis em telas médias (tablets).
                    - col-lg-2: Ocupa 2 colunas das 12 em telas grandes (computadores).
                    Isso garante o layout de 4 cards lado a lado no desktop e organizados no mobile.
                -->
                <div class="col-6 col-md-3 col-lg-2">
                    <!-- 
                        Card clicável para Categoria PRODUTOS.
                        Redireciona para o buscar.php onde inicia o fluxo de cadastro.
                    -->
                    <a href="buscar.php" class="category-card text-decoration-none">
                        <!-- 
                            [TAG]: svg (Ícone de Tênis/Sapato)
                            Um vetor inline desenhando um sapato/tênis esportivo para simbolizar Produtos.
                        -->
                        <svg class="category-icon" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="64" height="64" rx="32" fill="#F5F5F5"/>
                            <path d="M16 42 L24 24 L34 26 L48 34 L48 42 Z" stroke="#333333" stroke-width="2" stroke-linejoin="round"/>
                            <path d="M24 24 L20 28 L16 42" stroke="#333333" stroke-width="2"/>
                            <path d="M34 26 L30 32 L44 38" stroke="#333333" stroke-width="2" stroke-linecap="round"/>
                            <path d="M22 36 L48 36" stroke="#fff159" stroke-width="3" stroke-linecap="round"/>
                        </svg>
                        <h3 class="fs-6 fw-bold mt-2">Produtos</h3>
                    </a>
                </div>

                <!-- Card de Categoria VEÍCULOS (Desativado / Apenas Demonstração) -->
                <div class="col-6 col-md-3 col-lg-2">
                    <a href="#" class="category-card opacity-75" onclick="alert('Funcionalidade de demonstração. Por favor, selecione a categoria de Produtos para prosseguir.'); return false;">
                        <!-- Vetor inline de um Carro -->
                        <svg class="category-icon" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="64" height="64" rx="32" fill="#F5F5F5"/>
                            <path d="M18 42 H46 V32 H18 Z" stroke="#333333" stroke-width="2"/>
                            <path d="M22 32 L26 22 H38 L42 32" stroke="#333333" stroke-width="2" stroke-linejoin="round"/>
                            <circle cx="24" cy="42" r="5" fill="#ffffff" stroke="#333333" stroke-width="2"/>
                            <circle cx="40" cy="42" r="5" fill="#ffffff" stroke="#333333" stroke-width="2"/>
                        </svg>
                        <h3 class="fs-6 fw-bold mt-2">Veículos</h3>
                    </a>
                </div>

                <!-- Card de Categoria IMÓVEIS (Desativado / Apenas Demonstração) -->
                <div class="col-6 col-md-3 col-lg-2">
                    <a href="#" class="category-card opacity-75" onclick="alert('Funcionalidade de demonstração. Por favor, selecione a categoria de Produtos para prosseguir.'); return false;">
                        <!-- Vetor inline de uma Casa -->
                        <svg class="category-icon" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="64" height="64" rx="32" fill="#F5F5F5"/>
                            <path d="M16 44 V28 L32 16 L48 28 V44 H16 Z" stroke="#333333" stroke-width="2" stroke-linejoin="round"/>
                            <rect x="26" y="32" width="12" height="12" stroke="#333333" stroke-width="2" fill="#fff159"/>
                        </svg>
                        <h3 class="fs-6 fw-bold mt-2">Imóveis</h3>
                    </a>
                </div>

                <!-- Card de Categoria SERVIÇOS (Desativado / Apenas Demonstração) -->
                <div class="col-6 col-md-3 col-lg-2">
                    <a href="#" class="category-card opacity-75" onclick="alert('Funcionalidade de demonstração. Por favor, selecione a categoria de Produtos para prosseguir.'); return false;">
                        <!-- Vetor inline de Ferramentas/Serviços -->
                        <svg class="category-icon" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="64" height="64" rx="32" fill="#F5F5F5"/>
                            <path d="M20 44 L32 32 M32 32 L44 20 M32 32 L44 44 M32 32 L20 20" stroke="#333333" stroke-width="2" stroke-linecap="round"/>
                            <circle cx="32" cy="32" r="6" fill="#fff159" stroke="#333333" stroke-width="2"/>
                        </svg>
                        <h3 class="fs-6 fw-bold mt-2">Serviços</h3>
                    </a>
                </div>

            </div>

            <!-- Informações adicionais na parte inferior da seleção -->
            <div class="text-center mt-5">
                <!-- 
                    [CLASSES BOOTSTRAP]: d-inline-flex, align-items-center, gap-2
                    Cria uma linha flexível com o ícone sutil e o texto complementar.
                -->
                <div class="d-inline-flex align-items-center gap-2 text-secondary" style="font-size: 13px;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="18" height="18" rx="2"/>
                        <path d="M9 17h6M9 12h6M9 7h6"/>
                    </svg>
                    <span>Para enviar vários produtos, você pode <a href="#" class="text-decoration-none" style="color: #3483fa;">ir para Anunciador em massa</a></span>
                </div>
            </div>

        </div>
    </main>

    <!-- 
        [TAG SEMÂNTICA]: footer
        Rodapé institucional padrão das páginas.
    -->
    <footer class="ml-footer">
        <div class="container">
            <!-- Linha superior de políticas -->
            <p class="text-center mb-4 text-secondary">
                Certifique-se de que seu anúncio cumpre com as 
                <a href="#" style="color: #3483fa;">Políticas do Mercado Livre</a>.
            </p>
            
            <!-- Lista horizontal de links secundários -->
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
            
            <!-- Direitos autorais e dados da empresa mockados -->
            <div class="text-center text-secondary" style="font-size: 11px;">
                <p class="mb-1">Copyright © 1999-2026 Mercado Livre Brasil Ltda.</p>
                <p class="mb-0">CNPJ n.º 03.007.331/0001-41 / Av. das Nações Unidas, nº 3.003, Bonfim, Osasco/SP - CEP 06233-903 - empresa do grupo Mercado Livre.</p>
            </div>
        </div>
    </footer>

    <!-- 
        [TAG]: script (Bootstrap JS Bundle)
        Importa o arquivo JavaScript do Bootstrap. Embora não utilizemos muito JS interativo nativo dele,
        é fundamental importá-lo se formos utilizar modais, dropdowns ou tooltips do próprio framework.
    -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
