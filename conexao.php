<?php
/**
 * =====================================================================================
 * SCRIPT DE CONEXÃO COM O BANCO DE DADOS (MySQLi - Orientado a Objetos)
 * =====================================================================================
 * Este arquivo estabelece a comunicação entre a aplicação PHP e o banco de dados MySQL.
 * Ele deve ser incluído (via `require_once`) em todas as páginas que precisarem consultar
 * ou salvar informações no banco de dados.
 */

// [DEFINIÇÃO DE VARIÁVEIS DE CONFIGURAÇÃO]
// Definimos as constantes ou variáveis que guardam as credenciais de acesso ao servidor MySQL.
$host = "localhost";      // O endereço do servidor de banco de dados (localhost indica a máquina local).
$usuario = "root";       // O nome do usuário padrão do MySQL (no ambiente local, geralmente é 'root').
$senha = "";             // A senha do usuário (em instalações locais como XAMPP/WAMP, normalmente vem em branco '').
$banco = "mercado_livre_db"; // O nome exato da base de dados que criamos no arquivo SQL.

// [TENTATIVA DE CONEXÃO COM O MySQLi]
// A classe mysqli é nativa do PHP e serve para gerenciar conexões e consultas com o MySQL.
// Instanciamos um novo objeto passando as variáveis de configuração como argumentos do construtor.
$conexao = new mysqli($host, $usuario, $senha, $banco);

// [VERIFICAÇÃO DE ERROS DE CONEXÃO]
// O atributo 'connect_error' da classe mysqli guarda a descrição de qualquer falha na conexão.
// Se houver algum erro, a condição será verdadeira e o script será interrompido.
if ($conexao->connect_error) {
    // A função die() interrompe imediatamente a execução da página e exibe a mensagem de erro.
    // Isso evita que a página continue rodando sem acesso ao banco de dados, o que geraria mais erros.
    die("Falha na conexão com o banco de dados: " . $conexao->connect_error);
}

// [CONFIGURAÇÃO DE CHARSET UTF-8]
// Método que define o conjunto de caracteres da conexão para UTF-8.
// Isso garante que acentuações (como 'ã', 'é', 'ç') e caracteres especiais recuperados ou inseridos
// no banco de dados não fiquem desconfigurados (por exemplo, exibindo caracteres como ).
if (!$conexao->set_charset("utf8mb4")) {
    // Se falhar por algum motivo, exibe o erro detalhado do MySQL.
    printf("Erro ao configurar conjunto de caracteres utf8mb4: %s\n", $conexao->error);
    exit();
}

// [EXPORTANDO A CONEXÃO]
// A partir daqui, a variável $conexao estará disponível e pronta para uso nas páginas que incluírem este arquivo.
?>
