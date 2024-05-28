<?php
$server = "";
$database = "pidw";
$uid = "root";
$password = "";

$connection = new mysqli($server, $uid, $password, $database);

if ($connection->connect_error) {
    die("Conexão falhou: " . $connection->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifique se os dados do formulário foram enviados
    if (isset($_POST['id'], $_POST['nome'])) {
        $id = $connection->real_escape_string($_POST['id']);
        $nome = $connection->real_escape_string($_POST['nome']);
        $email = $connection->real_escape_string($_POST['email']);
        $condominio = $connection->real_escape_string($_POST['condominio']);
        $apartamento = $connection->real_escape_string($_POST['apartamento']);
        // Outros campos do seu registro

        // Consulta SQL para atualizar os dados no banco de dados
        $sql = "UPDATE usuarios SET nome = '$nome', email = '$email', condominio = '$condominio', apartamento = '$apartamento' WHERE id = $id";

        if ($connection->query($sql) === TRUE) {
            echo "Registro atualizado com sucesso.";
        } else {
            echo "Erro ao atualizar o registro: " . $connection->error;
        }
    } else {
        echo "Dados do formulário incompletos.";
    }
} else {
    echo "Método inválido para esta página.";
}

// Feche a conexão
$connection->close();
?>
