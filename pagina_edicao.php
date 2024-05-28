<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edição de Registro</title>
    <link rel="stylesheet" type="text/css" href="consultaphp.css">
    <style>
        body {
            background-image: url(condominio6.webp);
            font-family: 'Open Sans', Arial, sans-serif;
            margin: 10;
            padding: 10;
        }

        h2 {
            color: #fff;
            font-size: 24px;
            margin: 20px 0;
            text-align: center;
        }

        /* Estilos para o formulário */
        form {
            background-color: #fff;
            padding: 20px;
            margin: 20px;
            border: 5px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 40%; 
            margin: 0 auto; 
        }

        label {
            display: block;
            font-weight: bold;
            margin-top: 10px;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
        }

        input[type="submit"] {
            background-color: #3498db;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #2980b9;
        }
    </style>

</head>
<body>
<?php
$server = "127.0.0.1";
$database = "pidw";
$uid = "root";
$password = "123deolivera4";

$connection = new mysqli($server, $uid, $password, $database);

if ($connection->connect_error) {
    die("Conexão falhou: " . $connection->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Verifique se um ID foi passado como parâmetro
    if (isset($_GET['id'])) {
        $id = $connection->real_escape_string($_GET['id']);

        // Consulta SQL para obter os dados do registro com o ID especificado
        $sql = "SELECT * FROM usuarios WHERE id = $id";

        $result = $connection->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            // Preencha o formulário com os dados existentes
            ?>
            <h2>Edição de Registro</h2>

            <form id="edicao-form" method="post" action="processar_edicao.php">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <label for="nome">Nome:</label>
                <input type="text" name="nome" value="<?php echo $row['nome']; ?>" required><br>
                <label for="nome">Email:</label>
                <input type="text" name="email" value="<?php echo $row['email']; ?>" required><br>
                <label for="nome">Condomínio:</label>
                <input type="text" name="condominio" value="<?php echo $row['condominio']; ?>" required><br>
                <label for="nome">Apartamento:</label>
                <input type="text" name="apartamento" value="<?php echo $row['apartamento']; ?>" required><br>

                <!-- Outros campos do seu registro -->

                <input type="submit" value="Salvar Alterações" onclick="enviarFormulario()">
            </form>
            <script>
    function enviarFormulario() {
        var form = document.getElementById('edicao-form');
        form.action = 'javascript:void(0)';  // Define uma ação JavaScript vazia

        // Use AJAX para enviar o formulário para processar_edicao.php
        // e mostrar o alerta com a resposta
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'processar_edicao.php', true);

        // Define uma função para processar a resposta
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                alert(xhr.responseText); // Mostra o alerta com a resposta
            }
        };

        // Crie um objeto FormData para coletar todos os dados do formulário
        var formData = new FormData(form);

        // Envie o formulário
        xhr.send(formData);

        // Evite o envio padrão do formulário
        return false;
    }
</script>
            <?php
        } else {
            echo "Registro não encontrado.";
        }

        $result->close();
    } else {
        echo "ID do registro não especificado.";
    }
}

// Feche a conexão
$connection->close();
?>
</body>
</html>
