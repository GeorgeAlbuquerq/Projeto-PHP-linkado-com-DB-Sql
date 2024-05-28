<?php
$server = "";
$database = "pidw";
$uid = "root";
$password = "";

// Criar uma conexão
$connection = new mysqli($server, $uid, $password, $database);

// Verificar a conexão
if ($connection->connect_error) {
    die("Conexão falhou: " . $connection->connect_error);
}

// Verificar se a solicitação é uma consulta
if (isset($_GET["consulta"])) {
    $consulta = $connection->real_escape_string($_GET["consulta"]);

    // Construir a consulta SQL para consulta (ajuste conforme necessário)
    $sql = "SELECT * FROM usuarios WHERE nome LIKE '%$consulta%'";

    $resultado = $connection->query($sql);

    if ($resultado->num_rows > 0) {
        // Retorne os resultados em formato JSON (você pode ajustar isso conforme necessário)
        $resultados = [];
        while ($row = $resultado->fetch_assoc()) {
            $resultados[] = $row;
        }
        echo json_encode($resultados);
    } else {
        echo "Nenhum resultado encontrado.";
    }
} else {
    // Verificar se o formulário foi submetido
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nome = $connection->real_escape_string($_POST["nome"]);
        $email = $connection->real_escape_string($_POST["email"]);
        $condominio = $connection->real_escape_string($_POST["condominio"]);
        $apartamento = $connection->real_escape_string($_POST["apartamento"]);

        // Construir a consulta SQL para inserção
        $sql = "INSERT INTO usuarios (nome, email, condominio, apartamento) VALUES ('$nome', '$email', '$condominio', '$apartamento')";

        if ($connection->query($sql) === TRUE) {
            echo "Registro inserido com sucesso.";
        } else {
            echo "Erro ao inserir o registro: " . $connection->error;
        }
    }
}

// Fechar a conexão
$connection->close();
?>
