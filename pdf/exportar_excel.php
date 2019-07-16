<?php
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

include '../funcoes/funcoesConecta.php';
$con = bancoCapac();
// Incluimos a classe PHPExcel
require_once("../include/phpexcel/Classes/PHPExcel.php");
require_once("../funcoes/funcoesConecta.php");
require_once("../funcoes/funcoesGerais.php");

$sql = $_POST['sql'];
$query = mysqli_query($con, $sql);

// Instanciamos a classe
$objPHPExcel = new PHPExcel();


// Podemos renomear o nome das planilha atual, lembrando que um único arquivo pode ter várias planilhas
$objPHPExcel->getProperties()->setCreator("Sistema Jovem Monitor");
$objPHPExcel->getProperties()->setLastModifiedBy("Sistema Jovem Monitor");
$objPHPExcel->getProperties()->setTitle("Relatório de Jovem Monitor");
$objPHPExcel->getProperties()->setSubject("Relatório de Jovem Monitor");
$objPHPExcel->getProperties()->setDescription("Gerado automaticamente a partir do Sistema Jovem Monitor");
$objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");
$objPHPExcel->getProperties()->setCategory("Inscritos");

// Criamos as colunas
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue("B1", "Nome Completo")
    ->setCellValue("C1", "Nome Social")
    ->setCellValue("D1", "RG")
    ->setCellValue("F1", "CPF")
    ->setCellValue("G1", "Data Nascimento")
    ->setCellValue("H1", "Email")
    ->setCellValue("I1", "Endereço Completo")
    ->setCellValue("J1", "Data de Cadastro");

// Definimos o estilo da fonte
$objPHPExcel->getActiveSheet()->getStyle('A1:AH1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1:AH1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

//Colorir a primeira linha
$objPHPExcel->getActiveSheet()->getStyle('A1:AH1')->applyFromArray
(
    array
    (
        'fill' => array
        (
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'E0EEEE')
        ),
    )
);

$cont = 2;
while($linha = mysqli_fetch_array($query))
{
    $a = "A".$cont;
    $b = "B".$cont;
    $c = "C".$cont;
    $d = "D".$cont;
    $e = "E".$cont;
    $f = "F".$cont;
    $g = "G".$cont;
    $h = "H".$cont;
    $i = "I".$cont;
    $j = "J".$cont;
    $k = "K".$cont;
    $l = "L".$cont;
    $m = "M".$cont;
    $n = "N".$cont;
    $o = "O".$cont;
    $p = "P".$cont;
    $q = "Q".$cont;
    $r = "R".$cont;
    $s = "S".$cont;
    $t = "T".$cont;
    $u = "U".$cont;
    $v = "V".$cont;
    $w = "W".$cont;
    $x = "X".$cont;
    $y = "Y".$cont;
    $z = "Z".$cont;

    $enderecoCompleto = [
        $linha['logradouro'],
        $linha['numero'],
        $linha['bairro'],
        $linha['cep'],
        $linha['cidade'],
        $linha['estado']
    ];

    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue($b, $linha['nome'])
        ->setCellValue($c, $linha['nomeArtistico'])
        ->setCellValue($d, $linha['rg'])
        ->setCellValue($f, $linha['cpf'])
        ->setCellValue($g, exibirDataBr($linha['dataNascimento']))
        ->setCellValue($h, $linha['email'])
        ->setCellValue($i, implode(", ", $enderecoCompleto)." - CEP: ".$linha['cep'])
        ->setCellValue($j, "");

    $objPHPExcel->getActiveSheet()->getStyle($a . ":" . $z)->getAlignment()->setWrapText(true);
    $objPHPExcel->getActiveSheet()->getStyle($a . ":" . $z)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle($a . ":" . $z)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    $cont++;

}
// Renomeia a guia
$objPHPExcel->getActiveSheet()->setTitle('Inscritos');

for ($col = 'A'; $col !== 'Z'; $col++){
    $objPHPExcel->getActiveSheet()
        ->getColumnDimension($col)
        ->setAutoSize(true);
}

$objPHPExcel->setActiveSheetIndex(0);
ob_end_clean();
ob_start();

$nome_arquivo = "jovem_monitor.xls";


// Cabeçalho do arquivo para ele baixar(Excel2007)
header('Content-Type: text/html; charset=ISO-8859-1');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$nome_arquivo.'"');
header('Cache-Control: max-age=0');
// Se for o IE9, isso talvez seja necessário
header('Cache-Control: max-age=1');

// Acessamos o 'Writer' para poder salvar o arquivo
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

// Salva diretamente no output, poderíamos mudar arqui para um nome de arquivo em um diretório ,caso não quisessemos jogar na tela
$objWriter->save('php://output');

exit;
