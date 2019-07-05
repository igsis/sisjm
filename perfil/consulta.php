<?php
include "includes/menu.php";
$con = bancoCapac();

//$jovem_monitor = recuperaDados("pessoa_fisica", "id");
$sql = "SELECT pf.id AS idJm, pf.nome, pf.rg, pf.cpf, jm.ativo 
        FROM pessoa_fisica AS pf 
        JOIN jm_dados AS jm ON pf.id = jm.pessoa_fisica_id
        WHERE pf.publicado = 1";
$query = mysqli_query($con, $sql);
$linha = mysqli_num_rows($query);
if ($linha >= 1) {
    $tem = 1;
} else {
    $tem = 0;
}
?>

<section class="content-wrapper">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Tela de consulta</h3>
                </div>
                <?php
                if ($tem == 0) {
                    $mensagem1 = mensagem("info", "Nenhum Jovem Monitor cadastrado!");
                    echo $mensagem1;
                } else {

                    ?>
                    <div class="row" align="center">
                        <?php if (isset($mensagem)) {
                            echo $mensagem;
                        }; ?>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="tbl" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Nome</th>
                                <th>RG</th>
                                <th>CPF</th>
                                <th>Ano</th>
                                <th>Ativo/Inativo</th>
                                <th>Visualizar</th>
                                <th>Apagar</th>
                            </tr>
                            </thead>

                            <?php
                            echo "<tbody>";
                            while ($jovem_monitor = mysqli_fetch_array($query)) {
                                if($jovem_monitor['ativo'] == 1){
                                    $ativo = "Ativo";
                                }else{
                                    $ativo = "Inativo";
                                }
                                echo "<tr>";
                                echo "<td>" . $jovem_monitor['nome'] . "</td>";
                                echo "<td>" . $jovem_monitor['rg'] . "</td>";
                                echo "<td>" . $jovem_monitor['cpf'] . "</td>";
                                echo "<td>" . $jovem_monitor['cpf'] . "</td>";
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
                                        <input type="hidden" name="idJm" value="<?= $jovem_monitor['id'] ?>">
                                        <button type="button" class="btn btn-block btn-danger" id="excluiJm"
                                                data-toggle="modal" data-target="#exclusao" name="excluiJm"
                                                data-name="<?= $jovem_monitor['nome'] ?>"
                                                data-id="<?= $jovem_monitor['id'] ?>">
                                            <span class="glyphicon glyphicon-trash"></span></button>
                                    </form>
                                </td>
                                <?php
                                echo "</tr>";
                            }
                            echo "</tbody>";
                            ?>
                            <tfoot>
                            <tr>
                                <th>Nome</th>
                                <th>RG</th>
                                <th>CPF</th>
                                <th>Ano</th>
                                <th>Ativo/Inativo</th>
                                <th colspan="2" width="15%"></th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.box-body -->
                    <?php
                }
                ?>
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
</section>

<div id="exclusao" class="modal modal-danger modal fade in" role="dialog">
    <div class="modal-dialog">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">x</button>
            <h4 class="modal-title">Confirmação de Exclusão</h4>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir este Jovem Monitor?</p>
                <div class="modal-footer">
                    <form action="?perfil=agendao&p=evento_lista" method="post">
                        <input type="hidden" name="idEvent" id="idEvent" value="">
                        <input type="hidden" name="apagar" id="apagar">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                        <input class="btn btn-danger btn-outline" type="submit" name="excluir" value="Apagar">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script defer src="../visual/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script defer src="../visual/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<script type="text/javascript">
    $('#exclusao').on('show.bs.modal',function (e){
        let evento = $(e.relatedTarget).attr('data-name');
        let id = $(e.relatedTarget).attr('data-id');

        $(this).find('p').text(`Tem certeza que deseja excluir o evento ${evento}?`);
        $(this).find('#idEvent').attr('value',`${id}`);
    })
</script><script type="text/javascript">
    $('#exclusao').on('show.bs.modal',function (e){
        let evento = $(e.relatedTarget).attr('data-name');
        let id = $(e.relatedTarget).attr('data-id');

        $(this).find('p').text(`Tem certeza que deseja excluir o evento ${evento}?`);
        $(this).find('#idEvent').attr('value',`${id}`);
    })
</script>
