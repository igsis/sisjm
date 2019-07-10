<?php
include "includes/menu.php";
$con = bancoCapac();

if (isset($_POST['filtrar'])) {
    $data = ($_POST['data']);
    $nome = $_POST['nome'] ?? null;
    $rg = $_POST['rg'] ?? null;
    $projeto = $_POST['cpf'] ?? null;

    if ($data != '') {
        $filtro_data = "pf.dataAtualizacao > '$data'";
    }else{
        $filtro_data = "";
    }

    if ($nome!= '') {
        $filtro_nome = "AND pf.nome = 'nome'";
    } else {
        $filtro_nome = "";
    }

    if ($rg!= '') {
        $filtro_rg = "AND pf.rg = 'rg'";
    } else {
        $filtro_rg = "";
    }

    if ($cpf!= '') {
        $filtro_cpf = "AND pf.cpf = '$cpf'";
    } else {
        $filtro_cpf = "";
    }

    $sql = "SELECT pf.id AS idJm, pf.nome, pf.rg, pf.cpf, pf.dataAtualizacao, jm.ativo,  
            FROM pessoa_fisica AS pf 
            JOIN jm_dados AS jm ON pf.id = jm.pessoa_fisica_id
            WHERE
            $filtro_data
            $filtro_nome
            $filtro_rg
            $filtro_cpf AND
            pf.publicado = 1
            ORDER BY pf.dataAtualizacao";

    $query = mysqli_query($con, $sql);
    $num = mysqli_num_rows($query);

    if ($num > 0) {
        $mensagem = "Foram encontrados $num resultados";
        $consulta = 1;
        $displayForm = 'none';
        $displayBotoes = 'block';

    } else {
        $consulta = 0;
        $mensagem = "Não foram encontrados resultados para esta pesquisa!";
    }
}

?>

<section class="content-wrapper">
    <form method="POST" action="?perfil=consulta">
        <div class="row">
            <div class="col-md-offset-3 col-md-3">
                <label>Data</label>
                <input type="date" name="data" class="form-control" id="data" placeholder="">
            </div>
        </div>
        <input type="submit" class="btn btn-theme btn-block" name="filtrar" id="filtrar" value="Filtrar">
    </form>
</section>
