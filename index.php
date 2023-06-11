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
        <h1>Entrar</h1>
        <form method="post">
            <input type="email" name="email"  class="login" placeholder="Usuário">
            <input type="password" name="senha"  class="login" placeholder="Senha">
            <input type="submit" value="Acessar" class="login" >
            <a href="cadastrar.php">Ainda não é inscrito?<strong> Cadastre-se!</strong></a>
        </form>
        <?php 
         //verificar se clicou no botão
         if(isset($_POST['email']))
         {
             $email = addslashes($_POST['email']);
             $senha = addslashes($_POST['senha']);

             
             if(!empty($email) && !empty($senha))             
             {
                $u->conectar("oslec_course","localhost","root","");
                if($u->msgErro == "")
                {                
                    if($u->logar($email, $senha))
                    {
                        header("location: menu.php");
                    }
                    else
                    {
        ?>
                        <div class="msg-erro">
                            Email e/ou senha estão incorretos!
                        </div>
        <?php 
                    }
                }
                else
                {
        ?>
                    <div class="msg-erro">
                        <?php echo "Erro: ".$u->msgErro;?> 
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
