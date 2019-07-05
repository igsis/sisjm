<?php
    include "includes/menu.php";
    $con = bancoCapac();
    $idJm = isset($_SESSION['idJm']) ?? null;
    //$jovem_monitor = recuperaDados("pessoa_fisica", "id", $idJm);

    $sql = "SELECT pf.id, pf.nome, pf.nomeArtistico, pf.rg, pf.cpf, pf.dataNascimento, pf.logadouro, pf.bairro, pf.cidade, pf.estado, pf.cep, pf.numero, jm.ativo 
            FROM pessoa_fisica AS pf 
            JOIN jm_dados AS jm ON pf.id = jm.pessoa_fisica_id
            WHERE pf.publicado = 1 AND jm.pessoa_fisica_id = '$idJm'";
    $query = mysqli_query($con, $sql);

    $jovem_monitor = recuperaDados('pessoa_fisica', 'idUsuario', $idUser);
    $idJovemMonitor = $jovem_monitor['idUsuario'] ?? null;
?>

<section class="content-wrapper">
    <div class="content">
        <h4>DADOS JOVEM MONITOR</h4>
        <div class="row">
            <div class="form-group col-md-6">
                <label for="nome">Nome Completo </label>
                <input type="text" class="form-control" id="nome" name="nome" maxlength="240" required value="" readonly>
            </div>
            <div class="form-group col-md-6">
                <label for="nome">Nome Social </label>
                <input type="text" class="form-control" id="nome" name="nome" maxlength="240" required value="" readonly>
            </div>
            <div class="form-group col-md-4">
                <label for="nome">RG</label>
                <input type="text" class="form-control" id="nome" name="nome" maxlength="240" required value="" readonly>
            </div>
            <div class="form-group col-md-4">
                <label for="nome">CPF </label>
                <input type="text" class="form-control" id="nome" name="nome" maxlength="240" required value="" readonly>
            </div>
            <div class="form-group col-md-4">
                <label for="nome">Data Nascimento </label>
                <input type="text" class="form-control" id="nome" name="nome" maxlength="240" required value="" readonly>
            </div>
        </div>

        <h4>ENDEREÇO</h4>
        <div class="row">
            <div class="form-group col-md-4">
                <label for="nome">Logadouro</label>
                <input type="text" class="form-control" id="nome" name="nome" maxlength="240" required value="" readonly>
            </div>
            <div class="form-group col-md-4">
                <label for="nome">Número </label>
                <input type="text" class="form-control" id="numero" name="numero" maxlength="240" required value="" readonly>
            </div>
            <div class="form-group col-md-4">
                <label for="nome">Bairro</label>
                <input type="text" class="form-control" id="bairro" name="bairro" maxlength="240" required value="" readonly>
            </div>
            <div class="form-group col-md-4">
                <label for="nome">CEP</label>
                <input type="text" class="form-control" id="cep" name="cep" maxlength="240" required value="" readonly>
            </div>
            <div class="form-group col-md-4">
                <label for="nome">Cidade</label>
                <input type="text" class="form-control" id="cidade" name="cidade" maxlength="240" required value="" readonly>
            </div>
            <div class="form-group col-md-4">
                <label for="nome">Estado</label>
                <input type="text" class="form-control" id="estado" name="estado" maxlength="240" required value="" readonly>
            </div>
        </div>

        <!--<div class="row">
            <div class="form-group col-md-4">
                <label for="ativo">Ativo/Inativo</label> <br>
                <label><input type="radio" class="ativo" name="ativo" value="1" id="sim"  <?= $evento['ativo'] == 1 ? 'checked' : NULL ?>> Ativo </label>&nbsp;&nbsp;
                <label><input type="radio" class="ativo" name="ativo" value="0" id="nao"  <?= $evento['ativo'] == 0 ? 'checked' : NULL ?>> Inativo </label>
            </div>
        </div> -->
    </div>
</section>


