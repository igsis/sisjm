<?php
include "includes/menu.php";
$con = bancoMysqli();
$conn = bancoCapac();

$filtro = "";
$ativo = 3;
if(isset($_POST['filtrar'])){
    $ativo = $_POST['ativo'];
    if ($ativo == 1){
        $filtro = "AND jm.ativo = 1";
    } elseif ($ativo == 0) {
        $filtro = "AND jm.ativo = 0";
    }else{
        $filtro = "";
    }
}

if(isset($_POST['excluir'])){
    $idJm = $_POST['idJm'];
    $sql_apagar = "UPDATE jm_dados SET publicado = 0 WHERE pessoa_fisica_id = '$idJm'";
    If(mysqli_query($conn,$sql_apagar)){
        $mensagem = mensagem("success","Exclusão realizada com sucesso!");
    }else{
        $mensagem = mensagem("danger","Erro ao apagar! Tente novamente.");
    }
}
$sql = "SELECT pf.id AS idJm, pf.nome, pf.nomeArtistico, pf.email, pf.rg, pf.cpf, jm.valido, jm.data_cadastro 
                    FROM pessoa_fisica AS pf 
                    JOIN jm_dados AS jm ON pf.id = jm.pessoa_fisica_id
                    WHERE pf.publicado = 1 AND jm.publicado = 1 $filtro ORDER BY nome ASC";
$query = mysqli_query($conn, $sql);
$num = mysqli_num_rows($query);
?>

<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <!-- START ACCORDION-->
        <h2 class="page-header"><?= saudacao() . ", " . $_SESSION['nome'] ?>!</h2>
        <div class="row">
            <form method="POST" action="?perfil=inicio">
                <div class="col-md-3">
                    <label for="ativo">Filtrar cadastros ativos/inativos:</label> <br>
                    <select class="form-control"  name="ativo" id="ativo">
                        <option name="ativo" value="3" <?= $ativo == 3 ? 'selected' : NULL ?>>Todos</option>>
                        <option name="ativo" value="1" <?= $ativo == 1 ? 'selected' : NULL ?>>Ativos</option>
                        <option name="ativo" value="0" <?= $ativo == 0 ? 'selected' : NULL ?>>Inativos</option>
                    </select>
                    <br/>
                </div>
                <div class="col-md-6">
                    <br/>
                    <input type="hidden" name="idJm" id="idJm" value="<?= $idJm?>">
                    <button type="submit" name="filtrar" class="btn btn-primary pull-left">Filtrar</button>
                </div>
            </form>
            <?php if (isset($mensagem)) {
            echo $mensagem;
            }
            ?>
            <div class="col-md-12">
                <div class="box box-solid">
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="box-group" id="accordion">
                            <table id="tbl" class="table table-bordered table-striped table-responsive">
                                <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>RG</th>
                                    <th>CPF</th>
                                    <th>Data Cadastro</th>
                                    <th>Válido/Inválido</th>
                                    <th>Visualizar</th>
                                    <th>Apagar</th>
                                </tr>
                                </thead>

                                <?php
                                echo "<tbody>";
                                while ($jovem_monitor = mysqli_fetch_array($query)) {
                                    if ($jovem_monitor['valido'] == 1) {
                                        $valido = "Válido";
                                    } else {
                                        $valido = "Inválido";
                                    }
                                    echo "<tr>";
                                    echo "<td>" . $jovem_monitor['nome'] . "</td>";
                                    echo "<td>" . $jovem_monitor['rg'] . "</td>";
                                    echo "<td>" . $jovem_monitor['cpf'] . "</td>";
                                    echo "<td>" . exibirDataBr($jovem_monitor['data_cadastro']) . "</td>";
                                    echo "<td>" . $valido . "</td>";
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
                                                    <form action="?perfil=inicio" method="post">
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
                                    <th>Válido/Inválido</th>
                                    <th> </th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        <!-- END ACCORDION & CAROUSEL-->
    </section>
    <!-- /.content -->
</div>

<script defer src="../visual/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script defer src="../visual/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

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


    $('#exclusao').on('show.bs.modal', function (e){
        let jm = $(e.relatedTarget).attr('data-name');
        let id = $(e.relatedTarget).attr('data-id');

        $(this).find('p').text(`Tem certeza que deseja excluir o Jovem Monitor ${jm} ?`);
        $(this).find('#idJm').attr('value', `${id}`);
    })
</script>