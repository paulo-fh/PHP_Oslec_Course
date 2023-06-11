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
    <title>Tela de menu</title>
    <link rel="stylesheet" href="css/menus.css">
</head>
<body id="tela-menu">
    
    <header id="menu">        
        <a href="logout.php">Logout</a>
        <h1>OSLEC Tecnology</h1>
        <p>Curso Digital</p>
        <a href="menu.php" id="email">Voltar</a>
    </header>
    
    <main>
        <?php 
            if(isset($_GET['id_up'])) //verificar se clicou em editar
            {
                $id_update = addslashes($_GET['id_up']);
                $res = $clien->buscarDadosCursos($id_update);
            }
        
        ?>
        <section>
            <form method="post">
                <h2>CADASTRAR CURSOS</h2>
                <label for="curso">Nome do Curso</label>
                <input name="curso" type="text" id="curso" value="<?php if(isset($res)){echo $res['nome_Curso'];} ?>">
                <label for="carga_horaria">Carga Horária</label>
                <input name="carga_horaria" type="text" id="carga_horaria" value="<?php if(isset($res)){echo $res['carga_Horaria'];} ?>">
                <label for="descritivo">Descritivo</label>
                <input name="descritivo" type="text" id="descritivo" value="<?php if(isset($res)){echo $res['descritivo'];} ?>">
                <input type="submit" value="<?php if(isset($res)){echo "Atualizar";}else{echo "Cadastrar";}?>">
            </form>
            <?php 
                if(isset($_POST['curso'])) //clicou no botão cadastrar ou editar
                {
                    //botão editar
                    if(isset($_GET['id_up']) && !empty($_GET['id_up']))
                    {
                        $id_upd = addslashes($_GET['id_up']);
                        $curso = addslashes($_POST['curso']);
                        $carga_horaria = addslashes($_POST['carga_horaria']);
                        $descritivo = addslashes($_POST['descritivo']);
                        if(!empty($curso) && !empty($carga_horaria) && !empty($descritivo))
                        {
                            //Editar
                            $clien->atualizarDados($id_upd, $curso, $carga_horaria, $descritivo);  
                            header("location: cursos.php");                 
                        }
                        else
                        {
            ?>
                            <div class="aviso">
                                <h4>Preencha todos os campos!</h4>
                            </div>
            <?php 
                        }

                    }
                    else // Cadastrar
                    {
                        $curso = addslashes($_POST['curso']);
                        $carga_horaria = addslashes($_POST['carga_horaria']);
                        $descritivo = addslashes($_POST['descritivo']);
                        if(!empty($curso) && !empty($carga_horaria) && !empty($descritivo))
                        {
                            //cadastrar
                            if(!$clien->cadastrarCursos($curso, $carga_horaria, $descritivo))
                            {
            ?>
                            <div class="aviso">
                                <h4>Email já está cadastrado</h4>
                            </div>
            <?php 
                                
                            }
                        }
                        else
                        {
            ?>
                            <div class="aviso">
                                <h4>Preencha todos os campos!</h4>
                            </div>
            <?php 
                            
                        }
                    }

                }
            
            ?>
        </section>
      
        <section id="tabela">
            <table>
                <h2 id="tabela">CURSOS CADASTRADOS</h2>
                <tr id="titulo">
                    <td>ID</td>
                    <td>CURSO</td>
                    <td>CARGA HORÁRIA</td>
                    <td colspan="1">DESCRITIVO</td>
                </tr>
                <?php 
                    $dados = $clien->buscarDados();
                    if(count($dados) > 0) //Tem pessoas cadastradas no banco
                    {
                        for ($i=0; $i < count($dados); $i++) 
                        { 
                            echo "<tr>";
                            foreach($dados[$i] as $k => $v)
                            {
                                // if($k != "id_Curso")
                                // {
                                    echo "<td>$v</td>";
                                // }
                            }   
                ?>
                    <td>
                        <a href="cursos.php?id_up=<?= $dados[$i]['id_Curso'] ?>">Editar</a>
                        <a href="cursos.php?id=<?= $dados[$i]['id_Curso'] ?>">Excluir</a>
                    </td>
                <?php
                            echo "</tr>"; 
                                   
                        }                                             
                    }
                    else  //O banco está vazio
                    {
                ?>
                
            </table>
                        <div class="aviso">
                            <h4>Ainda não há cursos cadastrados!</h4>
                        </div>
                    <?php 
                    }
                    ?>
         
        </section>
    </main>
 
</body>
</html>

<?php 
    if(isset($_GET['id']))
    {
        $id_course = addslashes($_GET['id']);
        $clien->excluirCurso($id_course);
        header("location: cursos.php");
    }
?>