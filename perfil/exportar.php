<?php
include "includes/menu.php";
$con = bancoCapac();

$consulta = isset($_POST['filtrar']) ? 1 : 0;
$displayForm = 'block';
$displayBotoes = 'none';

if (isset($_POST['filtrar'])) {
    $datainicio = ($_POST['inicio']);
    $datafim = $_POST['final'] ?? null;

    if ($datainicio != '') {
        if ($datafim != '') {
            $datafim = ($_POST['final']);
            $filtro_data = "jm.data_cadastro BETWEEN '$datainicio' AND '$datafim'";
        } else {
            $filtro_data = "jm.data_cadastro >= '$datainicio'";
        }
    } else {
        $mensagem = "Informe uma data para inicio da consulta";
        $consulta = 0;
    }

    $sql = "SELECT pf.id AS idJm, pf.nome, pf.nomeArtistico, pf.email, pf.rg, pf.cpf, pf.dataNascimento, pf.logradouro, pf.bairro, pf.cidade, pf.estado, pf.cep, pf.numero, jm.data_cadastro
            FROM pessoa_fisica AS pf 
            JOIN jm_dados AS jm ON pf.id = jm.pessoa_fisica_id
            WHERE $filtro_data AND pf.publicado = 1 AND 
            jm.ativo = 1 AND jm.valido = 1";

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
if(isset($_POST['excluir'])){
    echo "teste";
    $idJm = $_POST['idJm'];
    $sql_apagar = "UPDATE jm_dados SET publicado = 0 WHERE pessoa_fisica_id = '$idJm'";
    If(mysqli_query($con,$sql_apagar)){
        $mensagem = mensagem("success","Alteração realizada com sucesso!");
    }else{
        $mensagem = mensagem("danger","Erro ao gravar! Tente novamente.");
    }
}
?>
<section class="content-wrapper">
    <div class="box-body">
        <form method="POST" action="?perfil=exportar">
            <h4 align="center"><b> Exportar Jovem Monitor - Excel </b></h4>
            <div class="row">
                <br>
                <div class="col-md-offset-3 col-md-3">
                    <label>Data início *</label>
                    <input type="date" name="inicio" class="form-control" id="inicio" onchange="desabilitaFiltrar()" placeholder="">
                </div>
                <div class="col-md-3">
                    <label>Data final</label>
                    <input type="date" name="final" class="form-control" id="final" placeholder="">
                    <br>
                </div>
            </div>
            <br>
                <input type="submit" class="btn btn-primary btn-lg btn-block" name="filtrar" id="filtrar" value="Filtrar" disabled>
        <h5 align="center   "><?php if (isset($mensagem)) {
                echo $mensagem;
            } ?></h5>
        </form>
    </div>


    <div  id="resultado">
        <?php
        if ($consulta == 1) {
            ?>
            <form method="post" action="../pdf/exportar_excel.php">
                <div class="form-group">
                    <br/>
                    <input type="hidden" name="sql" value="<?= $sql ?>">
                     <center>
                         <input type="submit" class="btn btn-lg btn-primary" name="exportar" value="Baixar Arquivo Excel" >
                     </center>
                    <br>
                </div>
            </form>
            <table id="tbl" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>Nome Social</th>
                    <th>Email</th>
                    <th>RG</th>
                    <th>CPF</th>
                    <th>Data Nascimento</th>
                    <th>Logradouro</th>
                    <th>Número</th>
                    <th>Bairro</th>
                    <th>CEP</th>
                    <th>Cidade</th>
                    <th>Estado</th>
                    <th>Data Cadastro</th>
                </tr>
                </thead>

                <?php
                echo "<tbody>";
                while ($jovem_monitor = mysqli_fetch_array($query)) {
                    echo "<tr>";
                    echo "<td>" . $jovem_monitor['nome'] . "</td>";
                    echo "<td>" . $jovem_monitor['nomeArtistico'] . "</td>";
                    echo "<td>" . $jovem_monitor['email'] . "</td>";
                    echo "<td>" . $jovem_monitor['rg'] . "</td>";
                    echo "<td>" . $jovem_monitor['cpf'] . "</td>";
                    echo "<td>" . $jovem_monitor['dataNascimento'] . "</td>";
                    echo "<td>" . $jovem_monitor['logradouro'] . "</td>";
                    echo "<td>" . $jovem_monitor['numero'] . "</td>";
                    echo "<td>" . $jovem_monitor['bairro'] . "</td>";
                    echo "<td>" . $jovem_monitor['cep'] . "</td>";
                    echo "<td>" . $jovem_monitor['cidade'] . "</td>";
                    echo "<td>" . $jovem_monitor['estado'] . "</td>";
                    echo "<td>" . exibirDataBr($jovem_monitor['data_cadastro']) . "</td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                ?>
            </table>
            <?php
        }
        ?>
    </div>
</section>


<script type="text/javascript">
    $(function () {
        $('#tbl').DataTable({
            "language": {
                "url": 'bower_components/datatables.net/Portuguese-Brasil.json'
            },
            "responsive": true,
            "dom": "<'row'<'col-sm-6'l><'col-sm-6 text-right'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7 text-right'p>>",
        });
    });
</script>
<script>
    function desabilitaFiltrar() {

        var inicio = document.querySelector("#inicio");
        var filtrar = document.querySelector("#filtrar");

        if (inicio.value.length != 0) {
            filtrar.disabled = false;
        } else {
            filtrar.disabled = true;
        }
    }
    function mostraDiv() {
        let form = document.querySelector('#testeTana');
        form.style.display = 'block';

        let botoes = document.querySelector('#botoes');
        botoes.style.display = 'none';

        let resultado = document.querySelector('#resultado');
        resultado.style.display = 'none';
    }
</script>
