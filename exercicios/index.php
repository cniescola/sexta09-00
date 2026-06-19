<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">
</head>
  <body>
    
    <header class="container-fluid p-3 d-flex justify-content-between align-itens" style="background-color:#fff159;">
        <a href="#"><img src="logo.png" class="logo" style="height:3rem"></a>
        <div class="btn-hover">Cadastro Produto</div>
        <div class="row">
            <div class="col"><i class="bi bi-person-circle"></i>Login</div>
            <div class="col">Contato</div>
        </div>
    </header>

    <main class="container-fluid p-0">
        <section class="d-flex flex-column">
            <div class="superior w-100 p-3" style="background-color: #f5f5f5">
                <div class="btn-hover container">< Anterior</div>
                <div class="container mt-5 text-secondary">Etapa 1 de 2</div>
                <div class="container mt-2"><h2>Para anunciar mais rápido,</h2></div>
                <div class="container"><h2>procure seu produto em nosso catalógo</h2></div> 

                <div class="container card mt-5">
                    <div class="row mt-4">
                        <label class="form-label"> Digite o nome do produto:</label>
                        <input type="text" class="form-control width"></input>
                    </div>
                    <div class="col dir">
                        <button class="btn btn-success">Confimar</button>
                    </div>



                </div>
            </div>

            <div class="inferior w-100" style="background-color: #ededed">
            </div>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html> 