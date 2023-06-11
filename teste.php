<?php
    use Dompdf\Dompdf;
    require_once 'config.php';
    require_once 'dompdf/autoload.inc.php';

    $html = '';
    $codigoSelecionado = $_POST['codigo']; // Código que será selecionado

    //$sql = "SELECT * FROM mentorados m INNER JOIN certificados c ON m.id_Aluno = c.id_Aluno INNER JOIN cursos co ON m.id_Curso = co.id_Curso WHERE m.id_Aluno = '$codigoSelecionado'";
    $sql = "SELECT * FROM mentorados m INNER JOIN cursos co ON m.id_Curso = co.id_Curso WHERE m.id_Aluno = '$codigoSelecionado'"; //modificado
    
    $res = $conn->query($sql);

    $html .= "<style>
                body {
                    background-color: #222244;
                    padding: 0;
                    margin: 0;
                    font-family: Arial, sans-serif;
                    border-radius: 10px;
                }
                h1 {
                    text-align: center;
                    color: white;
                    margin-bottom: 50px;
                }
                .certificado {
                    background-color: #222244;
                    color: #ffffff;
                    padding: 20px;
                    border-radius: 10px;
                    text-align: center;
                    margin: 0 auto;
                    max-width: 600px;
                    box-shadow: 0 0 20px rgba(0, 0, 0, 0.4);
                }
                .certificado h2 {
                    margin-bottom: 30px;
                    color: #ffffff;
                    text-transform: uppercase;
                    font-size: 28px;
                    font-weight: bold;
                    letter-spacing: 1px;
                }
                .certificado p {
                    margin-bottom: 20px;
                    color: #ffffff;
                    font-size: 16px;
                }
                
                .codigo-verificacao {
                    color: #cccccc;
                    font-size: 14px;
                }
                .assinatura {
                    margin-top: 50px;
                    text-align: right;
                    color: #ffffff;
                    font-style: italic;
                    font-size: 18px;
                }
                .border-line {
                    position: relative;
                    margin: 20px 0;
                    border-top: 1px solid #ffffff;
                }
                .border-line:before,
                .border-line:after {
                    content: '';
                    position: absolute;
                    top: -1px;
                    width: 20px;
                    height: 2px;
                    background-color: #ffffff;
                }
                .border-line:before {
                    left: -20px;
                }
                .border-line:after {
                    right: -20px;
                }
            </style>";
    $html .= "<h1>Oslec Course</h1>";

    if ($res->num_rows > 0) {
        while($row = $res->fetch_object()) {
            $html .= "<div class='certificado'>";
            
            $html .= "<h2>Certificado</h2>";
            $html .= "<p>Este certificado é conferido a:</p>";
            $html .= "<h3>" . $row->nome_Aluno . "</h3>";
            $html .= "<p>por sua participação e conclusão do curso de " . $row->nome_Curso . "</p>";
            $html .= "<p>no período de " . $row->periodo_inicial . " a " . $row->periodo_final . "</p>";
            $html .= "<div class='border-line'></div>";
            $html .= "<p class='codigo-verificacao'>Código de Verificação: 10023" . $row->cod_certificado . "</p>"; //modificado 
            $html .= "<div class='assinatura'>Assinatura</div>";
            $html .= "</div>";
        }
    } else {
        $html = "Nenhum dado encontrado para o código $codigoSelecionado.";
    }

    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->set_option('defaultFont', 'Arial');
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();
    $dompdf->stream("certificados.pdf", array("Attachment" => false));
?>
