<?php
include "includes/menu.php";
$con = bancoCapac();
$idJm = $_POST['idJm'];

if(isset($_POST['apagar']))
{
    $idArquivo = $_POST['apagar'];
    $sql_apagar_arquivo = "UPDATE upload_arquivo SET publicado = 0 WHERE idUploadListaDocumento = '$idArquivo'";
    if(mysqli_query($con,$sql_apagar_arquivo))
    {
        $mensagem2 = "<font color='#01DF3A'><strong>Arquivo apagado com sucesso!</strong></font>";
        gravarLog($sql_apagar_arquivo);
    }
    else
    {
        $mensagem2 = "<font color='#FF0000'><strong>Erro ao apagar arquivo!</strong></font>";
    }
}

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


$sql = "SELECT pf.id AS idJm, pf.nome, pf.nomeArtistico, pf.email, pf.rg, pf.cpf, pf.dataNascimento, pf.logradouro, pf.bairro, pf.cidade, pf.estado, pf.cep, pf.numero, pf.idUsuario, jm.ativo, jm.valido
        FROM pessoa_fisica AS pf 
        JOIN jm_dados AS jm ON pf.id = jm.pessoa_fisica_id
        WHERE pf.publicado = 1 AND jm.pessoa_fisica_id = '$idJm'";
$query = mysqli_query($con, $sql);
$jm = mysqli_fetch_array($query);
?>
<section class="content-wrapper">
    <div class="content">
        <h4>DADOS JOVEM MONITOR</h4>
        <?php if (isset($mensagem)) {
            echo $mensagem;
        }
        if (isset($mensagem2)) {
            echo $mensagem2;
        }?>
        <form method="POST" action="?perfil=visualizar_jm">
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="nome">Nome Completo </label>
                    <input type="text" class="form-control" id="nome" name="nome" maxlength="240" required
                           value="<?= $jm['nome'] ?>" readonly>
                </div>
                <div class="form-group col-md-6">
                    <label for="nome_social">Nome Social </label>
                    <input type="text" class="form-control" id="nomeSocial" name="nomeSocial" maxlength="240" required
                           value="<?= $jm['nomeArtistico'] ?>" readonly>
                </div>
                <div class="form-group col-md-4">
                    <label for="rg">RG</label>
                    <input type="text" class="form-control" id="rg" name="rg" required
                           value="<?= $jm['rg'] ?>" readonly>
                </div>
                <div class="form-group col-md-4">
                    <label for="cpf">CPF </label>
                    <input type="text" class="form-control" id="cpf" name="cpf" required
                           value="<?= $jm['cpf'] ?>" readonly>
                </div>
                <div class="form-group col-md-4">
                    <label">Data Nascimento </label>
                    <input type="text" class="form-control" id="dataNascimento" name="dataNascimento" required
                           value="<?= exibirDataBr($jm['dataNascimento']) ?>" readonly>
                </div>
            </div>
            <h4>ENDEREÇO</h4>
            <div class="row">
                <div class="form-group col-md-4">
                    <label>Logradouro</label>
                    <input type="text" class="form-control" id="logradouro" name="logradouro" required
                           value="<?= $jm['logradouro'] ?>" readonly>
                </div>
                <div class="form-group col-md-4">
                    <label>Número </label>
                    <input type="text" class="form-control" id="numero" name="numero" required
                           value="<?= $jm['numero'] ?>" readonly>
                </div>
                <div class="form-group col-md-4">
                    <label>Bairro</label>
                    <input type="text" class="form-control" id="bairro" name="bairro" required
                           value="<?= $jm['bairro'] ?>" readonly>
                </div>
                <div class="form-group col-md-4">
                    <label>CEP</label>
                    <input type="text" class="form-control" id="cep" name="cep" required
                           value="<?= $jm['cep'] ?>" readonly>
                </div>
                <div class="form-group col-md-4">
                    <label>Cidade</label>
                    <input type="text" class="form-control" id="cidade" name="cidade" required
                           value="<?= $jm['cidade'] ?>" readonly>
                </div>
                <div class="form-group col-md-4">
                    <label>Estado</label>
                    <input type="text" class="form-control" id="estado" name="estado" required
                           value="<?= $jm['estado'] ?>" readonly>
                </div>
            </div>
            <!-- Exibir arquivos -->
            <div class="form-group">
                <div class="col-md-12">
                    <div class="table-responsive list_info"><h5> <b>Arquivo(s) Anexado(s) </b></h5>
                        <?php listaArquivosPessoa($jm['idUsuario'], 7, 'visualizar_jm', $idJm); ?>
                    </div>
                </div>
            </div>

            <!-- Fim exbir arquivos-->
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
                <a href="?perfil=inicio"><button type="button" class="btn btn-info pull-left">Voltar</button></a>
                <input type="hidden" name="idJm" id="idJm" value="<?= $idJm?>">
                <button type="submit" name="edita" class="btn btn-info pull-right">Gravar</button>
            </div>
        </form>
    </div>
</section>



