<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mercado Livre</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">
</head>
  <body>

    <header class="ml-header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <img  src="imgs/logo.png" id="logo" alt="Logo mercado livre">

                <div class="gap-3 d-flex align-items-center">
                    <div class="rounded-circle bg-secondary d-flex justify-content-center align-items-center text-white">EP</div>
                    <span class="ml-nav-link">Ethan Pav...<span><i class="bi bi-caret-down-fill"></i></span></span></span>
                    <span class="ml-nav-link" class="fontisize:18px">Contato</span>
                    <a href="produtos.php" class="btn btn-outline-dark" style="font-size: 0.75rem">Meus Produtos</a>
                </div>
            </div>
        </div>
    </header>

    <main class="py-5">
      <section class="container">
        <div class="text-center mb-5">
          <h1 class="ml-title">Ola! Antes de mais nada,<br>o que você quer anunciar?</h1>
        </div>
      </section>

      <div class="row justify-content-center g-4">
        <div class="col-2">
          <a href="#" class="category-card text-decoration-none">
            <i id="icones" class="bi bi-box-seam"></i>
            <h3 class="fs-6 fw-bold mt-4">Produtos</h3>
          </a>
        </div>
        <div class="col-2">
          <a href="#" class="category-card text-decoration-none">
            <i id="icones" class="bi bi-car-front-fill"></i>
            <h3 class="fs-6 fw-bold mt-4">Carros</h3>
          </a>
        </div>
        <div class="col-2">
          <a href="#" class="category-card text-decoration-none">
            <i id="icones" class="bi bi-house"></i>
            <h3 class="fs-6 fw-bold mt-4">Imovéis</h3>
          </a>
        </div>
        <div class="col-2">
          <a href="#" class="category-card text-decoration-none">
            <i id="icones" class="bi bi-tools"></i>
            <h3 class="fs-6 fw-bold mt-4">Serviços</h3>
          </a>
        </div>
      </div>
      <div class="row text-center mt-5">
        <div class="col">
          <h6 id="corfonte" class="fs-6"><i class="bi bi-list-columns"></i> Para enviar vários produtos, você pode <a href="#" class="text-decoration-none">ir para Anunciador em massa</a></h6>
        </div>
      </div>
    </main>

    <footer>
      <div class="row text-center">
        <div class="col">
          <span id="corfonte2">Certifique-se de que seu anúncio faz cumpre as <a href="#" class="text-decoration-none">Políticas do Mercado Livre.</a></span>
        </div>
      </div>
      <div class="row">
        <div class="d-flex flex-wrap justify-content-center gap-3 mb-3 text-center mt-4">
          <a id="corfonte2" class="text-decoration-none" href="#">Trabalhe conosco</a>
          <a id="corfonte2" class="text-decoration-none" href="#">Termos e condições</a>
          <a id="corfonte2" class="text-decoration-none" href="#">Promoções</a>
          <a id="corfonte2" class="text-decoration-none" href="#">Como cuidamos da sua privacidade</a>
          <a id="corfonte2" class="text-decoration-none" href="#">Acessibilidade</a>
          <a id="corfonte2" class="text-decoration-none" href="#">Contato</a>
          <a id="corfonte2" class="text-decoration-none" href="#">Informações sobre seguros</a>
          <a id="corfonte2" class="text-decoration-none" href="#">Programa de Afiliados</a>
        </div>
      </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>