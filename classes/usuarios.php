<?php 

    class Usuario
    {
        private $pdo;
        public $msgErro = "";

        // Conexão com o banco de dados
        public function conectar($nome, $host, $usuario, $senha)
        {
            global $pdo;

            try {
                $pdo = new PDO("mysql:dbname=".$nome.";host=".$host, $usuario, $senha);
                
            } catch (PDOException $e) {
                $msgErro = $e->getMessage();
            }
        }

        //Cadastro de usuários no banco de dados
        public function cadastrar($nome, $telefone, $email, $senha)
        {
            global $pdo;
            //Verificar se já existe o email cadastrado
            $sql = $pdo->prepare("SELECT id_usuario FROM login_usuarios WHERE email = :e");
            $sql->bindValue(":e",$email);
            $sql->execute();
            if($sql->rowCount() > 0) //ja esta cadastrado
            {
                return false; 
            }
            else // caso não, cadastrar
            {
                $sql = $pdo->prepare("INSERT INTO login_usuarios (nome, telefone, email, senha) VALUES (:n, :t, :e, :s)");
                $sql->bindValue(":n",$nome);
                $sql->bindValue(":t",$telefone);
                $sql->bindValue(":e",$email);
                $sql->bindValue(":s",md5($senha));
                $sql->execute();
                return true; //cadastrado com sucesso
            }
        }

        //Acesso(logar) ao banco de dados
        public function logar($email, $senha)
        {
            global $pdo;
            //Verificar se o email e senha estão cadastrados, se sim 
            $sql = $pdo->prepare("SELECT id_usuario FROM login_usuarios WHERE email = :e AND senha = :s");
            $sql->bindValue(":e",$email);
            $sql->bindValue(":s",md5($senha));
            $sql->execute();
            if($sql->rowCount() > 0)
            {
                //entrar no sistema
                $dado = $sql->fetch();
                session_start();
                $_SESSION['id_usuario'] = $dado['id_usuario'];
                return true; //logado com sucesso
            }
            else
            {
                return false; //não foi possível logar
            }
            
        }

    }



?>