<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bootstrap demo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>

<body>

  <header class="container-fluid d-flex justify-content-between align-items-center" style="background-color:#fff159">
    <a href="#"><img src="logo.png" id="imgfoda" class="logo"></a>
    <div class="btn-hover">Cadastro Produto</div>
    <div class="row">
      <div class="col flex-row d-flex"><i class="bi bi-person-circle"></i>Login</div>
      <div class="col">Contatos</div>
    </div>

  </header>
  <main class="container-fluid p-0">
    <section class="d-flex flex-column">
      <div class="superior" style="background-color:#f5f5f5">
        <div class="container mt-4"><a href="#" class="text-decoration-none">
            < Anterior</a>
        </div>
        <div class="container mt-5 text-secondary">
          <h6> Etapa 2 de 2</h6>
        </div>
        <div class="container mt-1">
          <h1> Para Concluir,</h1>
        </div>
        <div class="container">
          <h1> Faça coisas Fodas</h1>
        </div>
        <div class="container mt-5 card">
          <div class="row">
            <div class="col">
            <h6 class="mt-4">Qual e o Preço?</h6>
            <input class="mt-4" id="InputFoda" placeholder="R$">
            </div>
            <div class="col">
            <input type="button" class="btn btn-success" value="Enviar">
          </div>
            </div>
          </div>
      </div>
      <div class="inferior" style="background-color:#ededed"></div>

    </section>

  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>