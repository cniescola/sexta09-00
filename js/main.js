/**
 * =====================================================================================
 * SCRIPT JAVASCRIPT CUSTOMIZADO (js/main.js)
 * =====================================================================================
 * Este arquivo contém as interações do lado do cliente (Front-End) para a tela de confirmação
 * de produtos do catálogo.
 * 
 * Assuntos abordados:
 * - Manipulação de DOM (Document Object Model).
 * - Tratamento de eventos de clique.
 * - Adição e remoção dinâmica de classes CSS.
 * - Alteração de atributos HTML (src, value).
 */

/**
 * [FUNÇÃO]: trocarImagemPrincipal
 * Esta função é acionada quando o usuário clica em alguma das imagens da galeria de miniaturas.
 * Ela atualiza a imagem principal exibida no centro do card.
 * 
 * @param {string} caminhoImagem - O caminho físico da imagem clicada (ex: 'assets/gelopar_main.png').
 * @param {HTMLElement} elementoClicado - A referência do próprio elemento <img> que foi clicado.
 */
function trocarImagemPrincipal(caminhoImagem, elementoClicado) {
    
    // [PASSO 1: Selecionar o elemento da imagem principal]
    // A função document.getElementById localiza um elemento HTML através do seu atributo ID único.
    const imgPrincipal = document.getElementById('imagem-principal-exibicao');
    
    // [PASSO 2: Alterar o atributo 'src']
    // Atualiza o atributo 'src' (source) da imagem grande para o caminho da miniatura clicada.
    if (imgPrincipal) {
        imgPrincipal.src = caminhoImagem;
    }
    
    // [PASSO 3: Remover a classe 'active' das outras miniaturas]
    // A função document.querySelectorAll busca todos os elementos que possuem a classe '.thumb-item'.
    // Ela retorna uma lista (NodeList) contendo todas as tags <img> da galeria.
    const todasMiniaturas = document.querySelectorAll('.thumb-item');
    
    // O método forEach percorre cada item da lista (semelhante ao foreach do PHP ou para cada do Portugol).
    todasMiniaturas.forEach(function(miniatura) {
        // O classList.remove remove a classe 'active' do elemento, removendo a borda azul de destaque.
        miniatura.classList.remove('active');
    });
    
    // [PASSO 4: Adicionar a classe 'active' apenas na miniatura clicada]
    // Adiciona a classe 'active' à imagem que disparou o evento de clique, exibindo o destaque azul nela.
    elementoClicado.classList.add('active');
}

/**
 * [FUNÇÃO]: selecionarVoltagem
 * Esta função é acionada ao clicar em um dos botões de voltagem (127V ou 220V).
 * Ela atualiza o campo oculto que será enviado ao servidor (Back-End) e atualiza o visual da tela.
 * 
 * @param {string} valorVoltagem - O valor do botão selecionado (ex: '127V' ou '220V').
 * @param {HTMLElement} botaoClicado - A referência do próprio botão <button> que foi clicado.
 */
function selecionarVoltagem(valorVoltagem, botaoClicado) {
    
    // [PASSO 1: Atualizar o valor do campo oculto (input hidden)]
    // Encontra o input oculto pelo ID e altera a propriedade 'value' dele.
    // Isso garante que quando o formulário for enviado (POST), o PHP receba o valor correto selecionado.
    const inputVoltagem = document.getElementById('input-voltagem');
    if (inputVoltagem) {
        inputVoltagem.value = valorVoltagem;
    }
    
    // [PASSO 2: Atualizar o rótulo de texto explicativo (Label)]
    // Encontra a tag <strong> que exibe a voltagem em texto e atualiza seu conteúdo.
    const labelVoltagem = document.getElementById('voltagem-selecionada-label');
    if (labelVoltagem) {
        labelVoltagem.textContent = valorVoltagem;
    }
    
    // [PASSO 3: Remover a classe 'active' dos outros botões de variação]
    // Seleciona todos os botões que possuem a classe '.variation-btn'.
    const todosBotoes = document.querySelectorAll('.variation-btn');
    
    // Percorre cada botão removendo a classe 'active' (que coloca a borda azul grossa).
    todosBotoes.forEach(function(botao) {
        botao.classList.remove('active');
    });
    
    // [PASSO 4: Adicionar a classe 'active' apenas no botão clicado]
    // Adiciona a classe 'active' no botão atual selecionado pelo usuário.
    botaoClicado.classList.add('active');
}
