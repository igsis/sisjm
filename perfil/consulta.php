<?php
    include "includes/menu.php";
    $con = bancoCapac();

    $consulta = isset($_POST['filtrar']) ? 1 : 0;
    $displayForm = 'block';
    $displayBotoes = 'none';

    if (isset($_POST['filtrar'])) {
        $data = ($_POST['data']);
        $nome = $_POST['nome'] ?? null;
        $rg = $_POST['rg'] ?? null;
        $cpf = $_POST['cpf'] ?? null;

        if ($data != '') {
            $filtro_data = "AND jm.data_cadastro >= '$data'";
        } else {
            $filtro_data ="";
        }

        if ($nome != '') {
            $filtro_nome = "AND pf.nome = '$nome'";
        } else {
            $filtro_nome = "";
        }

        if ($rg != '') {
            $filtro_rg = "AND pf.rg = '$rg'";
        } else {
            $filtro_rg = "";
        }

        if ($cpf != '') {
            $filtro_cpf = "AND pf.cpf = '$cpf'";
        } else {
            $filtro_cpf = "";
        }

        $sql = "SELECT pf.id AS idJm, pf.nome, pf.rg, pf.cpf, jm.ativo, jm.data_cadastro
            FROM pessoa_fisica AS pf 
            JOIN jm_dados AS jm ON pf.id = jm.pessoa_fisica_id
            WHERE pf.publicado = 1 AND  jm.publicado = 1
            $filtro_data
            $filtro_nome
            $filtro_rg
            $filtro_cpf";

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
        <form method="POST" action="?perfil=consulta">
            <h4 align="center"><b> Consulta Jovem Monitor - Filtrar </b></h4>
            <br>
            <div class="justify-content-center align-items-center row">
                <div class="col-md-3">
                    <label> Nome</label> <br>
                    <input type="text" name="nome" class="form-control" id="nome" placeholder="" onchange="desabilitaFiltrar()" >
                </div>
                <div class="col-md-3">
                    <label>RG</label> <br>
                    <input type="text" name="rg" class="form-control" id="rg" placeholder="" onchange="desabilitaFiltrar()" >
                </div>
                <div class="col-md-3">
                    <label>CPF</label> <br>
                    <input type="text" name="cpf" class="form-control" id="cpf" placeholder="" onchange="desabilitaFiltrar()" >
                </div>
                <div class="col-md-3">
                    <label>Data</label>
                    <input type="date" name="data" class="form-control" id="data" placeholder="" onchange="desabilitaFiltrar()" >
                    <br>
                </div>
            </div>
            <br>
            <input type="submit" class="btn btn-primary btn-lg btn-block" name="filtrar" id="filtrar" value="Filtrar" disabled>
        </form>
        <h5><?php if (isset($mensagem)) {
                echo $mensagem;
            } ?></h5>
    </div>

    <div  id="resultado">
        <?php
        if ($consulta == 1) {
            ?>
            <table id="tbl" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>RG</th>
                    <th>CPF</th>
                    <th>Data Cadastro</th>
                    <th>Ativo/Inativo</th>
                    <th>Visualizar</th>
                    <th>Apagar</th>
                </tr>
                </thead>

                <?php
                echo "<tbody>";
                while ($jovem_monitor = mysqli_fetch_array($query)) {
                    if ($jovem_monitor['ativo'] == 1) {
                        $ativo = "Ativo";
                    } else {
                        $ativo = "Inativo";
                    }
                    echo "<tr>";
                    echo "<td>" . $jovem_monitor['nome'] . "</td>";
                    echo "<td>" . $jovem_monitor['rg'] . "</td>";
                    echo "<td>" . $jovem_monitor['cpf'] . "</td>";
                    echo "<td>" . exibirDataBr($jovem_monitor['data_cadastro']) . "</td>";
                    echo "<td>" . $ativo . "</td>";
                    echo "<td>
                                    <form method=\"POST\" action=\"?perfil=visualizar_jm\" role=\"form\">
                                    <input type='hidden' name='idJm' value='" . $jovem_monitor['idJm'] . "'>
                                    <button type=\"submit\" name='carregar' class=\"btn btn-block btn-primary\"><span class='glyphicon glyphicon-eye-open'></span></button>
                                    </form>
                                </td>";
                    ?>
                    <td>
                        <form method="post" id="formExcluir">
                            <input type="hidden" name="idJm" value="<?= $jovem_monitor['idJm'] ?>">
                            <button type="button" class="btn btn-block btn-danger" id="excluiEvento"
                                    data-toggle="modal" data-target="#exclusao" name="excluiEvento"
                                    data-name="<?= $jovem_monitor['nome'] ?>"
                                    data-id="<?= $jovem_monitor['idJm'] ?>"><span class="glyphicon glyphicon-trash"></span></button>
                        </form>
                    </td>
                    <?php
                    echo "</tr>";
                    ?>
                    <!-- Confirmação de Exclusão -->
                    <div id="exclusao" class="modal" role="dialog">
                                <div class="modal-dialog">
                                    <!--Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Confirmação de Exclusão</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p>Tem certeza que deseja excluir este Jovem Monitor?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <form action="?perfil=consulta" method="post">
                                                <input type="hidden" name="idJm" id="idJm" value="">
                                                <input type="hidden" name="apagar" id="apagar">
                                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar
                                                </button>
                                                <input class=" btn btn-danger" type="submit" name="excluir" value="Apagar">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <!-- Fim Confirmação de Exclusão -->
                <?php
                }
                echo "</tbody>";
                ?>
                <tfoot>
                <tr>
                    <th>Nome</th>
                    <th>RG</th>
                    <th>CPF</th>
                    <th>Data Cadastro</th>
                    <th>Ativo/Inativo</th>
                    <th colspan="2" width="15%"></th>
                </tr>
                </tfoot>
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

    function mostraDiv() {
        let form = document.querySelector('#testeTana');
        form.style.display = 'block';

        let botoes = document.querySelector('#botoes');
        botoes.style.display = 'none';

        let resultado = document.querySelector('#resultado');
        resultado.style.display = 'none';
    }

    function desabilitaFiltrar() {

        var nome = document.querySelector("#nome");
        var rg = document.querySelector("#rg");
        var filtrar = document.querySelector("#filtrar");

        if ((nome.value.length != 0) || (rg.value.length != 0) || (cpf.value.length != 0) || (data.value.length != 0)){
            filtrar.disabled = false;
        } else {
            filtrar.disabled = true;
        }
    }

    $('#exclusao').on('show.bs.modal', function (e){
        let jm = $(e.relatedTarget).attr('data-name');
        let id = $(e.relatedTarget).attr('data-id');

        $(this).find('p').text(`Tem certeza que deseja excluir o Jovem Monitor ${jm} ?`);
        $(this).find('#idJm').attr('value', `${id}`);
    })
</script>