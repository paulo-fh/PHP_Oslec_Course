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
    <title>Cadastro de Mentores</title>
    <link rel="stylesheet" href="menus.css">
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
                $res = $clien->buscarDadosMentor($id_update);
            }
        
        ?>
        <section>
            <form method="post">
                <h2>CADASTRAR MENTORES</h2>
                <label for="mentor">Nome do Mentor</label>
                <input name="mentor" type="text" id="mentor" value="<?php if(isset($res)){echo $res['nome_Mentor'];} ?>">
            
                <label for="email">Email</label>
                <input name="email" type="email" id="email" value="<?php if(isset($res)){echo $res['email_Mentor'];} ?>">

                <label for="telefone">Telefone</label>
                <input name="telefone" type="text" id="telefone" value="<?php if(isset($res)){echo $res['telefone'];} ?>">

                <label for="especialidade">Especialidade</label>
                <input name="especialidade" type="text" id="especialidade" value="<?php if(isset($res)){echo $res['especialidade'];} ?>">

                <label for="curso">Id Curso</label> 
                 <select name="id_course">
                    <option value="">Selecione</option>
                    <?php 
                        $linhas = $clien->buscarDados();
                        foreach($linhas as $linha){
                            echo "<option value='" . $linha['id_Curso'] . "'>" . $linha["nome_Curso"] . "</option>";
                        }
                    ?>
                 </select>          

                <input type="submit" value="<?php if(isset($res)){echo "Atualizar";}else{echo "Cadastrar";}?>">
            </form>
            <?php 
                if(isset($_POST['mentor'])) //clicou no botão cadastrar ou editar
                {
                    //botão editar
                    if(isset($_GET['id_up']) && !empty($_GET['id_up']))
                    {
                        $id_upd = addslashes($_GET['id_up']);
                        $nome_Mentor = addslashes($_POST['mentor']);
                        $email_Mentor = addslashes($_POST['email']);
                        $telefone = addslashes($_POST['telefone']);
                        $especialidade = addslashes($_POST['especialidade']);
                        $id_course = addslashes($_POST['id_course']);
                        if(!empty($nome_Mentor) && !empty($email_Mentor) && !empty($telefone) && !empty($especialidade) && !empty($id_course ))
                        {
                            //Editar
                            $clien->atualizarDadosMentores($id_upd, $nome_Mentor, $email_Mentor, $telefone, $especialidade, $id_course );  
                            header("location: mentores.php");                 
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
                        $nome_Mentor = addslashes($_POST['mentor']);
                        $email_Mentor = addslashes($_POST['email']);
                        $telefone = addslashes($_POST['telefone']);
                        $especialidade = addslashes($_POST['especialidade']);
                        $id_course = addslashes($_POST['id_course']);
                        if(!empty($nome_Mentor) && !empty($email_Mentor) && !empty($telefone) && !empty($especialidade) && !empty($id_course))
                        {
                            //cadastrar
                            if(!$clien->cadastrarMentores($nome_Mentor, $email_Mentor, $telefone, $especialidade, $id_course ))
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
                <h2 id="tabela">MENTORES CADASTRADOS</h2>
                <tr id="titulo">
                    <td>NOME</td>
                    <td>EMAIL</td>
                    <td>TELEFONE</td>
                    <td >ESPECIALIDADE</td>
                    <td colspan="1">Nome DO CURSO</td>
                </tr>
                <?php 
                    $dados = $clien->buscarDadosMentores();
                    if(count($dados) > 0) //Tem mentores cadastradas no banco
                    {
                        for ($i=0; $i < count($dados); $i++) 
                        { 
                            echo "<tr>";
                            foreach($dados[$i] as $k => $v)
                            {
                                if($k != "id_Mentor" && $k != "id_Curso" && $k != "carga_Horaria" && $k != "descritivo")
                                {
                                    echo "<td>$v</td>";
                                }
                            }   
                ?>
                    <td>
                        <a href="mentores.php?id_up=<?= $dados[$i]['id_Mentor'] ?>">Editar</a>
                        <a href="mentores.php?id=<?= $dados[$i]['id_Mentor'] ?>">Excluir</a>
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
                            <h4>Ainda não há mentores cadastradas!</h4>
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
        $id_prof = addslashes($_GET['id']);
        $clien->excluirMentor($id_prof);
        header("location: mentores.php");
    }
?>