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
                $res = $clien->buscarDadosAluno($id_update);
            }
        
        ?>
        <section>
            <form method="post">
                <h2>CADASTRAR ALUNOS</h2>
                
                <label for="aluno">Nome do Aluno</label>
                <input name="aluno" type="text" id="aluno" value="<?php if(isset($res)){echo $res['nome_Aluno'];} ?>">
                
                <label for="email_aluno">E-mail</label>
                <input name="email_aluno" type="text" id="email_aluno" value="<?php if(isset($res)){echo $res['email_Aluno'];} ?>">
                
                <label for="telefone_Aluno">Telefone</label>
                <input name="telefone_Aluno" type="text" id="telefone_Aluno" value="<?php if(isset($res)){echo $res['telefone'];} ?>">
                
                <label for="inicio">Data de Inicio</label>
                <input name="inicio" type="text" id="inicio" value="<?php if(isset($res)){echo $res['periodo_inicial'];} ?>">
                
                <label for="final">Data de Conclusão</label>
                <input name="final" type="text" id="final" value="<?php if(isset($res)){echo $res['periodo_final'];} ?>">

                <label for="curso">Nome do Curso</label>  
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
                if(isset($_POST['aluno'])) //clicou no botão cadastrar ou editar
                {
                    //botão editar
                    if(isset($_GET['id_up']) && !empty($_GET['id_up']))
                    {
                        $id_upd = addslashes($_GET['id_up']);
                        $aluno = addslashes($_POST['aluno']);
                        $email_aluno = addslashes($_POST['email_aluno']);
                        $telefone = addslashes($_POST['telefone_Aluno']);
                        $inicio = addslashes($_POST['inicio']);
                        $final = addslashes($_POST['final']);
                        $id_course = addslashes($_POST['id_course']);
                        if(!empty($aluno) && !empty($email_aluno) && !empty($telefone) && !empty($inicio) && !empty($final) && !empty($id_course))
                        {
                            //Editar
                            $clien->atualizarDadosAlunos($id_upd, $aluno, $email_aluno, $telefone, $inicio, $final, $id_course);   
                            header("location: mentorados.php");                 
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
                        $aluno = addslashes($_POST['aluno']);
                        $email_aluno = addslashes($_POST['email_aluno']);
                        $telefone = addslashes($_POST['telefone_Aluno']);
                        $inicio = addslashes($_POST['inicio']);
                        $final = addslashes($_POST['final']);
                        $id_course = addslashes($_POST['id_course']);
                        if(!empty($aluno) && !empty($email_aluno) && !empty($telefone) && !empty($inicio) && !empty($final) && !empty($id_course))
                        {
                            //cadastrar
                            if(!$clien->cadastrarAlunos($aluno, $email_aluno, $telefone, $inicio, $final, $id_course))
                                // if($clien->cadastrarCertificado($))
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
        <div style= "margin:10px; max-width: 230px;">
            <button style="  background-color: #372991;  font-size: 1.3em;" ><a style="color: white; text-decoration: none; padding: 30px;"  href="certificado.php">Emitir Certificado</a></button>
        </div>
            <table>
                <h2 id="tabela">ALUNOS CADASTRADOS </h2>
                
                <tr id="titulo">
                    <td>ALUNO</td>
                    <td>EMAIL</td>
                    <td>TELEFONE</td>
                    <td>INICIO</td>
                    <td>FIM</td>
                    <td colspan="1">NOME DO CURSO</td>
                </tr>
                <?php 
                    $dados = $clien->buscarDadosAlunos();
                    if(count($dados) > 0) //Tem pessoas cadastradas no banco
                    {
                        for ($i=0; $i < count($dados); $i++) 
                        { 
                            echo "<tr>";
                            foreach($dados[$i] as $k => $v)
                            {
                                if($k != "id_Aluno" && $k != "id_Curso" && $k != "carga_Horaria" && $k != "descritivo" && $k != "cod_certificado")
                                {
                                    echo "<td>$v</td>";
                                }
                            }   
                ?>
                    <td>
                        <a href="mentorados.php?id_up=<?= $dados[$i]['id_Aluno'] ?>">Editar</a>
                        <a href="mentorados.php?id=<?= $dados[$i]['id_Aluno'] ?>">Excluir</a>                        
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
                            <h4>Ainda não há pessoas cadastradas!</h4>
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
        $id_alu = addslashes($_GET['id']);
        $clien->excluirAluno($id_alu);
        header("location: mentorados.php");
    }
?>