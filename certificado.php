<?php
   require_once 'config.php';
    // Realize a conexão com o banco de dados aqui (usando mysqli, PDO ou qualquer outra biblioteca)

    // Execute uma consulta para buscar os códigos disponíveis
    $sql = "SELECT * FROM mentorados";
    $result = $conn->query($sql);
  
?>

<!DOCTYPE html>
<html>
<head>
    <title>Selecionar nome do aluno</title>
    <link rel="stylesheet" href="./menus.css">
    <style>
        /* body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        } */

        h1 {
            margin: 20px;
            text-align: center;
            /* color: #333; */
        }

        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            display: block;
            width: 100%;
            padding: 3px;
            background-color: #000082;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <header id="menu">        
        <a href="logout.php">Logout</a>
        <h1>OSLEC Tecnology</h1>
        <p>Curso Digital</p>
        <a href="menu.php" id="email">Voltar</a>
    </header>
    <h1 style="text-align: center;">Selecionar nome do aluno</h1>

    <form action="teste.php" method="POST">
        <label for="codigo">Nome:</label>
        <select name="codigo" id="codigo">
            <?php
               // Itere sobre os resultados da consulta e exiba cada código como uma opção
                foreach ($result as $linha) {
                    echo "<option value='" . $linha['id_Aluno'] . "'>" . $linha["nome_Aluno"] . "</option>";
                }                               
            ?>
        </select>

        <input type="submit" value="Gerar Certificado">
    </form>
</body>
</html>