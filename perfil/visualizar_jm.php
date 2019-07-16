<?php
include "includes/menu.php";
$con = bancoCapac();
$idJm = $_POST['idJm'];
$jovem_monitor = recuperaDadosCapac('pessoa_fisica', 'id', $idJm);

$sql = "SELECT pf.id, jm.ativo, jm.valido
        FROM pessoa_fisica AS pf 
        JOIN jm_dados AS jm ON pf.id = jm.pessoa_fisica_id
        WHERE pf.publicado = 1 AND jm.pessoa_fisica_id = '$idJm'";
$query = mysqli_query($con, $sql);
$jm = mysqli_fetch_array($query);

if (isset($_POST['edita'])){
    $ativo = $_POST['ativo'];
    $valido = $_POST['valido'];
    $sql_update = "UPDATE jm_dados SET  ativo = '$ativo', valido = '$valido' WHERE pessoa_fisica_id = '$idJm'";
    If(mysqli_query($con,$sql_update)){
        $mensagem = mensagem("success","Alteração realizada com sucesso!");
    }else{
        $mensagem = mensagem("danger","Erro ao gravar! Tente novamente.");
    }
}


/*if(isset($_POST['apagar']))
{
    $idArquivo = $_POST['apagar'];
    $sql_apagar_arquivo = "UPDATE upload_arquivo SET publicado = 0 WHERE idUploadListaDocumento = '$idArquivo'";
    if(mysqli_query($con,$sql_apagar_arquivo))
    {
        $mensagem = "<font color='#01DF3A'><strong>Arquivo apagado com sucesso!</strong></font>";
        gravarLog($sql_apagar_arquivo);
    }
    else
    {
        $mensagem = "<font color='#FF0000'><strong>Erro ao apagar arquivo!</strong></font>";
    }
}*/
?>

<section class="content-wrapper">
    <div class="content">
        <h4>DADOS JOVEM MONITOR</h4>
        <?php if (isset($mensagem)) {
            echo $mensagem;
        } ?>
        <form method="POST" action="?perfil=visualizar_jm">
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="nome">Nome Completo </label>
                    <input type="text" class="form-control" id="nome" name="nome" maxlength="240" required
                           value="<?= $jovem_monitor['nome'] ?>" readonly>
                </div>
                <div class="form-group col-md-6">
                    <label for="nome">Nome Social </label>
                    <input type="text" class="form-control" id="nomeSocial" name="nomeSocial" maxlength="240" required
                           value="<?= $jovem_monitor['nomeArtistico'] ?>" readonly>
                </div>
                <div class="form-group col-md-4">
                    <label for="nome">RG</label>
                    <input type="text" class="form-control" id="rg" name="rg" required
                           value="<?= $jovem_monitor['rg'] ?>" readonly>
                </div>
                <div class="form-group col-md-4">
                    <label for="nome">CPF </label>
                    <input type="text" class="form-control" id="cpf" name="cpf" required
                           value="<?= $jovem_monitor['cpf'] ?>" readonly>
                </div>
                <div class="form-group col-md-4">
                    <label for="nome">Data Nascimento </label>
                    <input type="text" class="form-control" id="nome" name="nome" required
                           value="<?= exibirDataBr($jovem_monitor['dataNascimento']) ?>" readonly>
                </div>
            </div>
            <h4>ENDEREÇO</h4>
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="nome">Logradouro</label>
                    <input type="text" class="form-control" id="logradouro" name="logradouro" required
                           value="<?= $jovem_monitor['logradouro'] ?>" readonly>
                </div>
                <div class="form-group col-md-4">
                    <label for="nome">Número </label>
                    <input type="text" class="form-control" id="numero" name="numero" required
                           value="<?= $jovem_monitor['numero'] ?>" readonly>
                </div>
                <div class="form-group col-md-4">
                    <label for="nome">Bairro</label>
                    <input type="text" class="form-control" id="bairro" name="bairro" required
                           value="<?= $jovem_monitor['bairro'] ?>" readonly>
                </div>
                <div class="form-group col-md-4">
                    <label for="nome">CEP</label>
                    <input type="text" class="form-control" id="cep" name="cep" required
                           value="<?= $jovem_monitor['cep'] ?>" readonly>
                </div>
                <div class="form-group col-md-4">
                    <label for="nome">Cidade</label>
                    <input type="text" class="form-control" id="cidade" name="cidade" required
                           value="<?= $jovem_monitor['cidade'] ?>" readonly>
                </div>
                <div class="form-group col-md-4">
                    <label for="nome">Estado</label>
                    <input type="text" class="form-control" id="estado" name="estado" required
                           value="<?= $jovem_monitor['estado'] ?>" readonly>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-12">
                    <div class="table-responsive list_info"><h6>Arquivo(s) Anexado(s)</h6>
                        <?php listaArquivosPessoa($jovem_monitor['idUsuario'], 7, 'visualizar_jm'); ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="ativo">Válidar Cadastro:</label> <br>
                    <select class="form-control"  name="valido" id="valido">
                        <option name="valido" value="1" id="sim" <?= $jm['valido'] == 1 ? 'selected' : NULL ?>>Válido</option>
                        <option name="valido" value="0" id="nao" <?= $jm['valido'] == 0 ? 'selected' : NULL ?>>Inválido</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="ativo">Atividade do Jovem Monitor:</label> <br>
                    <select class="form-control"  name="ativo" id="ativo">
                        <option name="ativo" value="1" id="sim" <?= $jm['ativo'] == 1 ? 'selected' : NULL ?>>Ativo</option>
                        <option name="ativo" value="0" id="nao" <?= $jm['ativo'] == 0 ? 'selected' : NULL ?>>Inativo</option>
                    </select>
                </div>
            </div>
            <div class="box-footer">
                <a href="?perfil=consulta"><button type="button" class="btn btn-info pull-left">Voltar</button></a>
                <input type="hidden" name="idJm" id="idJm" value="<?= $idJm?>">
                <button type="submit" name="edita" class="btn btn-info pull-right">Gravar</button>
            </div>
        </form>
    </div>

    <div class="modal fade" id="confirmApagar" role="dialog" aria-labelledby="confirmApagarLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Excluir Arquivo?</h4>
                </div>
                <div class="modal-body">
                    <p>Deseja excluir este arquivo?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirm">Remover</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Fim Confirmação de Exclusão -->
</section>



