<?php 
    class Cliente{

        private $pdo;

        /*==================  CONSTRUTOR - Conexão com o Banco de dados  ====================*/
        public function __construct($dbname, $host, $user, $senha)
        {
            try {
                $this->pdo = new PDO("mysql:dbname=".$dbname.";host=".$host,$user,$senha);
            } catch (PDOException $e) {
                echo "Erro com o banco de dados: ".$e->getMessage();
                exit();
            } catch (Exception $e){
                echo "Erro generico: ".$e->getMessage();
                exit();
            }
        }  /* End conexão */

        /*===================  FUNÇÕES PARA TABELA CURSOS  =============================*/
        //Função para buscar os dados e imprimir na tabela criada
        public function buscarDados()
        {
            $res = array();
            $cmd = $this->pdo->query("SELECT * FROM cursos ORDER BY nome_Curso");
            $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        }

        //Função para cadastrar os cursos no banco de dados
        public function cadastrarCursos($curso, $carga_horaria, $descritivo)
        {
            //Antes de cadastrar verificar se ja tem o curso
            $cmd = $this->pdo->prepare("SELECT id_Curso FROM cursos WHERE nome_Curso = :c");
            $cmd->bindValue(":c",$curso);
            $cmd->execute();
            if ($cmd->rowCount() > 0) //curso já existe no banco
            {
                return false;
            }
            else //não foi encontrado o curso no banco
            {
                $cmd = $this->pdo->prepare("INSERT INTO cursos (nome_Curso, carga_Horaria, descritivo) VALUES (:c, :ch, :d)");
                $cmd->bindValue(":c", $curso);
                $cmd->bindValue(":ch", $carga_horaria);
                $cmd->bindValue(":d", $descritivo);
                $cmd->execute();
                return true;
            }
        }

        //Função para excluir cursos no banco de dados
        public function excluirCurso($id)
        {
            $cmd = $this->pdo->prepare("DELETE FROM cursos WHERE id_Curso = :id");
            $cmd->bindValue(":id",$id);
            $cmd->execute();
        }

        //Função para buscar dados de um curso
        public function buscarDadosCursos($id)
        {
            $res = array();
            $cmd = $this->pdo->prepare("SELECT * FROM cursos WHERE id_Curso = :id");
            $cmd->bindValue(":id", $id);
            $cmd->execute();
            $res = $cmd->fetch(PDO::FETCH_ASSOC);
            return $res;
        }

        //Atualizar dados do curso no banco
        public function atualizarDados($id, $nome, $carga_horaria, $descritivo)
        {           
            $cmd = $this->pdo->prepare("UPDATE cursos SET nome_Curso = :n, carga_Horaria = :ch, descritivo = :d WHERE id_Curso = :id");
            $cmd->bindValue(":n", $nome);
            $cmd->bindValue(":ch", $carga_horaria);
            $cmd->bindValue(":d", $descritivo);
            $cmd->bindValue(":id", $id);
            $cmd->execute();
        }
        /*===================  END FUNÇÕES PARA TABELA CURSOS  =============================*/


        /*===================  FUNÇÕES PARA TABELA DE MENTORES  =============================*/
        //Função para buscar os dados dos mentores e imprimir na tabela criada
        public function buscarDadosMentores()
        {
            $res = array();
            $cmd = $this->pdo->query("SELECT * FROM mentores m INNER JOIN cursos c ON m.id_Curso = c.id_Curso ORDER BY nome_Mentor");
            $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        }

         //Função para cadastrar os mentores no banco de dados
        public function cadastrarMentores($nome, $email, $telefone, $especialidade, $id_curso)
        {
            //Antes de cadastrar verificar se ja tem o mentor
            $cmd = $this->pdo->prepare("SELECT id_Mentor FROM mentores WHERE email_Mentor = :e");
            $cmd->bindValue(":e",$email);
            $cmd->execute();
            if ($cmd->rowCount() > 0) //email já existe no banco
            {
                return false;
            }
            else //não foi encontrado o email no banco
            {
                $cmd = $this->pdo->prepare("INSERT INTO mentores (nome_Mentor, email_Mentor, telefone, especialidade, id_Curso) VALUES (:n, :e, :t, :es, :i)");
                $cmd->bindValue(":n", $nome);
                $cmd->bindValue(":e", $email);
                $cmd->bindValue(":t", $telefone);
                $cmd->bindValue(":es", $especialidade);
                $cmd->bindValue(":i", $id_curso);
                $cmd->execute();
                return true;
            }
        }
        
         //Função para buscar dados de um mentor
         public function buscarDadosMentor($id)
         {
             $res = array();
             $cmd = $this->pdo->prepare("SELECT * FROM mentores WHERE id_Mentor = :id");
             $cmd->bindValue(":id", $id);
             $cmd->execute();
             $res = $cmd->fetch(PDO::FETCH_ASSOC);
             return $res;
         }

          //Atualizar dados do mentor no banco
        public function atualizarDadosMentores($id, $nome, $email, $telefone, $especialidade, $id_curso)
        {
           
            $cmd = $this->pdo->prepare("UPDATE mentores SET nome_Mentor = :n, email_Mentor = :e, telefone = :t, especialidade = :es , id_Curso = :i WHERE id_Mentor = :id");
            $cmd->bindValue(":n", $nome);
            $cmd->bindValue(":e", $email);
            $cmd->bindValue(":t", $telefone);
            $cmd->bindValue(":es", $especialidade);
            $cmd->bindValue(":i", $id_curso);
            $cmd->bindValue(":id", $id);
            $cmd->execute();
        }

        //Função para excluir mentor no banco de dados
        public function excluirMentor($id)
        {
            $cmd = $this->pdo->prepare("DELETE FROM mentores WHERE id_Mentor = :id");
            $cmd->bindValue(":id",$id);
            $cmd->execute();
        }        
        /*=================== END FUNÇÕES PARA TABELA DE MENTORES  =============================*/

        /*===================  FUNÇÕES PARA TABELA DE MENTORADOS  =============================*/
        //Função para buscar os dados dos mentores e imprimir na tabela criada
        public function buscarDadosAlunos()
        {
            $res = array();
            $cmd = $this->pdo->query("SELECT * FROM mentorados m INNER JOIN cursos c ON m.id_Curso = c.id_Curso ORDER BY nome_Aluno");
            $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        }

        //Função para cadastrar os alunos no banco de dados
        public function cadastrarAlunos($nome, $email, $telefone, $inicio, $final, $id_curso)
        {
            //Antes de cadastrar verificar se ja tem o mentor
            $cmd = $this->pdo->prepare("SELECT id_Aluno FROM mentorados WHERE email_Aluno = :e");
            $cmd->bindValue(":e",$email);
            $cmd->execute();
            if ($cmd->rowCount() > 0) //email já existe no banco
            {
                return false;
            }
            else //não foi encontrado o email no banco
            {
                $cmd = $this->pdo->prepare("INSERT INTO mentorados (nome_Aluno, email_Aluno, telefone, periodo_inicial, periodo_final, id_Curso) VALUES (:n, :e, :t, :pi, :pf, :i)");
                $cmd->bindValue(":n", $nome);
                $cmd->bindValue(":e", $email);
                $cmd->bindValue(":t", $telefone);
                $cmd->bindValue(":pi", $inicio);
                $cmd->bindValue(":pf", $final);
                $cmd->bindValue(":i", $id_curso);
                $cmd->execute();
                return true;
            }
        }

         //Função para buscar dados de um aluno
         public function buscarDadosAluno($id)
         {
             $res = array();
             $cmd = $this->pdo->prepare("SELECT * FROM mentorados WHERE id_Aluno = :id");
             $cmd->bindValue(":id", $id);
             $cmd->execute();
             $res = $cmd->fetch(PDO::FETCH_ASSOC);
             return $res;
         }


         //Atualizar dados do curso no banco
        public function atualizarDadosAlunos($id, $nome, $email, $telefone, $inicio, $final, $id_curso)
        {           
            $cmd = $this->pdo->prepare("UPDATE mentorados SET nome_Aluno = :n, email_Aluno = :e, telefone = :t, periodo_inicial = :pi, periodo_final = :pf, id_Curso = :i  WHERE id_Aluno = :id");
            $cmd->bindValue(":n", $nome);
            $cmd->bindValue(":e", $email);
            $cmd->bindValue(":t", $telefone);
            $cmd->bindValue(":pi", $inicio);
            $cmd->bindValue(":pf", $final);
            $cmd->bindValue(":i", $id_curso);
            $cmd->bindValue(":id", $id);
            $cmd->execute();
        }

           //Função para excluir aluno no banco de dados
        public function excluirAluno($id)
        {
            $cmd = $this->pdo->prepare("DELETE FROM mentorados WHERE id_Aluno = :id");
            $cmd->bindValue(":id",$id);
            $cmd->execute();
        }   



        //Função para cadastrar os certificaos no banco de dados
        public function cadastrarCertificado($id_Aluno)
        {
            //Antes de cadastrar verificar se ja tem o curso
            $cmd = $this->pdo->prepare("SELECT codigo_Certificado FROM certificados WHERE id_Aluno = :c");
            $cmd->bindValue(":c",$id_Aluno);
            $cmd->execute();
            if ($cmd->rowCount() > 0) //curso já existe no banco
            {
                return false;
            }
            else //não foi encontrado o curso no banco
            {
                $cmd = $this->pdo->prepare("INSERT INTO certificados (id_Aluno) VALUES (:c)");
                $cmd->bindValue(":c", $id_Aluno);
                $cmd->execute();
                return true;
            }
        }
    }
?>




        