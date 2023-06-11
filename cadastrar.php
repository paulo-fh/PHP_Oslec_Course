<?php 
    require_once 'classes/usuarios.php';
    $u = new Usuario;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de Login</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <div id="form-login">
        <h1>Cadastrar</h1>
        <form method="post">
            <input type="text" name="nome"  class="login" placeholder="Nome Completo" maxlength="30">
            <input type="text" name="telefone"  class="login" placeholder="Telefone" maxlength="30">
            <input type="email" name="email"  class="login" placeholder="Usuário" maxlength="40">
            <input type="password" name="senha"  class="login" placeholder="Senha" maxlength="15">
            <input type="password" name="confSenha"  class="login" placeholder="Confirmar Senha">
            <input type="submit" value="Cadastrar" class="login" >
            <a href="index.php">Já possui uma conta?<strong> Entrar!</strong></a>
        </form>
        <?php 
            //verificar se clicou no botão
            if(isset($_POST['nome']))
            {
                $nome = addslashes($_POST['nome']);
                $telefone = addslashes($_POST['telefone']);
                $email = addslashes($_POST['email']);
                $senha = addslashes($_POST['senha']);
                $confirmarSenha = addslashes($_POST['confSenha']);
                
                //verificar se esta preenchido
                if(!empty($nome) && !empty($telefone) && !empty($email) && !empty($senha) && !empty($confirmarSenha))
                {
                    $u->conectar("oslec_course","localhost","root","");
                    if($u->msgErro == "")
                    {
                        if($senha == $confirmarSenha)
                        {
                            if($u->cadastrar($nome, $telefone, $email, $senha))
                            {
            ?>                        
                                <div id="msg-sucesso">
                                    Cadastrado com sucesso! Acesse para entrar!
                                </div>
                                
            <?php 
                            }
                            else
                            {
            ?>
                                <div class="msg-erro">
                                    Email já cadastrado
                                </div>
            <?php 
                            }
                        }
                        else
                        {
            ?>
                            <div class="msg-erro">
                                Senha e confirma senha não correspondem!
                            </div>
            <?php 
                            
                        }
                    }
                    else
                    {
            ?>
                        <div class="msg-erro">
                            <?php echo "Erro: ".$u->msgErro; ?> 
                        </div>
            <?php 
                        
                    }
                }
                else
                {
            ?>
                    <div class="msg-erro">
                        Preencha todos os campos!
                    </div>
            <?php 
                    
                }
            }
            
            ?>
    </div>

    
</body>
</html>