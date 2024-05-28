<html>
<head>
    <meta charset="UTF-8">
    <title>Sua Página de Consulta</title>
    <link rel="stylesheet" type="text/css" href="consultaphp.css">
</head>
<body>
<?php
$server = "";
$database = "pidw";
$uid = "root";
$password = "";

// Criar a conexão
$connection = new mysqli($server, $uid, $password, $database);

// Verificar a conexão
if ($connection->connect_error) {
    die("Conexão falhou: " . $connection->connect_error);
}

// Processar a consulta na DB
if (isset($_POST['campoConsulta'])) {
    $consulta = $connection->real_escape_string($_POST['campoConsulta']); // Evitar SQL Injection

    //Consulta SQL para cada tabela
    $sqlUsuarios = "SELECT * FROM usuarios WHERE nome LIKE '%$consulta%'";
    $sqlPedidos = "SELECT * FROM pedidos WHERE nome LIKE '%$consulta%'";
    $sqlEntregador = "SELECT * FROM entregador WHERE nome LIKE '%$consulta%'";
    $sqlLojas = "SELECT * FROM lojas WHERE nome LIKE '%$consulta'";

    // Executar as consultas 
    $resultUsuarios = $connection->query($sqlUsuarios);
    $resultPedidos = $connection->query($sqlPedidos);
    $resultEntregador = $connection->query($sqlEntregador);
    $resultLojas = $connection->query($sqlLojas);

    if ($resultUsuarios->num_rows > 0 || $resultPedidos->num_rows > 0 || $resultEntregador->num_rows > 0 || $resultLojas->num_rows > 0) {
        echo "Resultados da consulta para: " . $consulta . "<br>";
        
        // Exibir resultados em colunas separadas
        echo "<table>";
        
        // Exibir resultados da tabela "usuarios"
        if ($resultUsuarios->num_rows > 0) {
            echo "<th>Resultados da tabela Usuarios</th>";
            echo "<tr>";
            while ($row = $resultUsuarios->fetch_assoc()) {
                echo "<td>";
                echo 
                "<p>Id: " . $row["id"] . "</p>".
                "<p>Nome: " . $row["nome"] . "</p>" .
                "<p>Email: " . $row["email"] . "</p>" .
                "<p>Condominio: " . $row["condominio"] . "</p>" .
                "<p>Apartamento: " . $row["apartamento"] . "</p>";
                echo "<button onclick='editarRegistro(" . $row["id"] . ")'>Editar</button>";
                echo "</td>";
            }
            echo "</tr>";
        }

        // Exibir resultados da tabela "pedidos"
        if ($resultPedidos->num_rows > 0) {
            echo "<th>Resultados da tabela Pedidos</th>";
            echo "<tr>";
            while ($row = $resultPedidos->fetch_assoc()) {
                echo "<td>";
                echo 
                "<p>Id: " . $row["id"] . "</p>".
                "<p>Nome: " . $row["nome"] . "</p>" .
                "<p>Loja: " . $row["loja"] . "</p>" .
                "<p>Condominio: " . $row["condominio"] . "</p>" .
                "<p>Preco: " . $row["preco"] . "</p>";
                echo "<button onclick='editarRegistro(" . $row["id"] . ")'>Editar</button>";
                echo "</td>";
            }
            echo "</tr>";
        }

        // Exibir resultados da tabela "entregador"
        if ($resultEntregador->num_rows > 0) {
            echo "<th>Resultados da tabela Entregador</th>";
            echo "<tr>";
            while ($row = $resultEntregador->fetch_assoc()) {
                echo "<td>";
                echo 
                "<p>Id: " . $row["id"] . "</p>".
                "<p>Nome: " . $row["nome"] . "</p>" .
                "<p>Lojas: " . $row["loja"] . "</p>" .
                "<p>Apartamento: " . $row["apartamento"] . "</p>";
                echo "<button onclick='editarRegistro(" . $row["id"] . ")'>Editar</button>";
                echo "</td>";
            }
            echo "</tr>";
        }
        // Exibir resultados da tabela "lojas"
        if ($resultLojas->num_rows > 0) {
            echo "<th>Resultados da tabela Lojas</th>";
            echo "<tr>";
            while ($row = $resultLojas->fetch_assoc()) {
                echo "<td>";
                echo 
                "<p>Id: " . $row["id"] . "</p>".
                "<p>Nome: " . $row["nome"] . "</p>" .
                "<p>Email: " . $row["email"] . "</p>" .
                "<p>Condominio: " . $row["condominio"] . "</p>" .
                "<p>Apartamento: " . $row["apartamento"] . "</p>";
                echo "<button onclick='editarRegistro(" . $row["id"] . ")'>Editar</button>";
                echo "</td>";
            }
            echo "</tr>";
        }

        echo "</table>";

    } else {
        echo "Nenhum resultado encontrado para a consulta: " . $consulta;
    }

    // Fechar os resultados
    $resultUsuarios->close();
    $resultPedidos->close();
    $resultEntregador->close();
    $resultLojas->close();
}

// Fechar a conexão
$connection->close();

?>
<script>
function editarRegistro(id) {
    // Redirecione para uma página de edição com o ID do registro
    window.location = "pagina_edicao.php?id=" + id;
}
</script>

</body>
</html>
