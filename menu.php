<?php 
    session_start();
    if(!isset($_SESSION['id_usuario']))
    {
        header("location: index.php");
        exit;
    }

    require_once 'classes/cliente.php';
    $clien = new Cliente("oslec_course","localhost","root","");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Envio de Email</title>
    <link rel="stylesheet" href="css/menus.css">
</head>
<body id="tela-menu">
    <header style="padding-bottom: 37px;" id="menu">        
        <a href="logout.php">Logout</a>
        <h1>OSLEC Tecnology</h1>
        <p>Marketing Digital</p>
    </header>

    <main>
        <section class="opcaoCadastro">
            <a href="cursos.php" rel="next" target="_self">
                <button class="cadastros">CADASTRAR CURSOS</button>
            </a>        
            <a href="mentores.php" rel="next" target="_self">
                <button class="cadastros">CADASTRAR MENTORES</button>
            </a>       
            <a href="mentorados.php" rel="next" target="_self">
                <button class="cadastros">CADASTRAR MENTORADOS</button>
            </a>    
        </section>
    </main>
</body>
</html>

