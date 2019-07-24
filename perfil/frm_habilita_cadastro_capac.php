<?php
include 'includes/menu.php';
$con = bancoCapac();
if (isset($_POST['cadastro']))
{
    $situacao = $_POST['situacao'];
    if ($situacao == 1)
    {
        $status = ['0', 'BLOQUEADO'];
        $dataReferencia = "";
    }
    else
    {
        $data = exibirDataMysql($_POST['data']);
        $status = ['1', 'LIBERADO'];
        $dataReferencia = ", `data` = '$data.\" \".date(\"g:i:s\")'";
    }
//2019-01-01 00:00:00
    $sqlCadastro = "UPDATE `jm_cadastro` SET `situacao_atual` = '".$status[0]."', `descricao_situacao` = '".$status[1]."'$dataReferencia WHERE `id` = '1'";
    $queryCadastro = $con->query($sqlCadastro);

    if ($queryCadastro)
    {
        gravarLog($sqlCadastro);
    }
}

$formacaoCadastro = $con->query('SELECT * FROM `jm_cadastro`')->fetch_assoc();

$situacao = $formacaoCadastro['situacao_atual'];
$descricao = $formacaoCadastro['descricao_situacao'];
$dataCadastro = $formacaoCadastro['data'];

switch ($situacao)
{
    case 1:
        $msgStatus = "<span style='color: #ef0000'>BLOQUEAR</span>";
        break;
    case 0:
        $msgStatus = "<span style='color: #00a201'>LIBERAR</span>";
        break;
    default:
        $status = null;
        $msgStatus = null;
        break;
}

?>

<section class="content-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-offset-2 col-md-8">
                <h4 align="center"><b> Habilitar Cadastro no CAPAC </b></h4>
                <br>
                <div class="alert <?= ($situacao == 1) ? 'alert-success' : 'alert-danger' ?>">
                    <p align="center"><strong>CADASTRO NO CAPAC: <?= $descricao ?></strong></p>
                </div>
                <div class="row" align="center">
                    <h5>Deseja <?=$msgStatus?> o cadastro de artistas para formação no CAPAC?</h5>
                </div>

                <div class="col-md-offset-2 col-md-8">
                    <form method='POST' action='?perfil=frm_habilita_cadastro_capac' enctype='multipart/form-data'>
                        <input type="hidden" name="situacao" value="<?=$situacao?>">

                        <?php if ($situacao == 0) {?>
                            <div class="row">
                                <div class="form-group col-md-offset-4 col-md-4">
                                    <strong>Data Referência do cadastro:</strong><br/>
                                    <input type="text" class="form-control" id="data" name="data" data-mask="00/00/0000" value="<?= exibirDataBr($dataCadastro)?>">
                            </div>
                        <?php } ?>

                        <div class="row">
                            <div class="form-group">
                                <input type='submit' name='cadastro' class='btn btn-theme btn-lg btn-block for' value='SIM'
                                       onclick="return confirm('Tem certeza que deseja realizar essa ação?')">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
