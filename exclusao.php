<?php
$server = "127.0.0.1";
$database = "pidw";
$uid = "root";
$password = "123deolivera4";

// Criar uma conexão
$connection = new mysqli($server, $uid, $password, $database);

// Verificar a conexão
if ($connection->connect_error) {
    die("Conexão falhou: " . $connection->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idUsuario = $connection->real_escape_string($_POST["idUsuario"]);

    // Construir a consulta SQL para exclusão
    $sql = "DELETE FROM usuarios WHERE id = $idUsuario";

    if ($connection->query($sql) === TRUE) {
        echo "Usuário excluído com sucesso.";
    } else {
        echo "Erro ao excluir o usuário: " . $connection->error;
    }

}

// Fechar a conexão
$connection->close();
?>
