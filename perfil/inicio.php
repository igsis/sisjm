<?php
include "includes/menu.php";
$con = bancoMysqli();
$conn = bancoCapac();
$sql = "SELECT pf.id AS idJm, pf.nome, pf.nomeArtistico, pf.email, pf.rg, pf.cpf, jm.data_cadastro 
            FROM pessoa_fisica AS pf 
            JOIN jm_dados AS jm ON pf.id = jm.pessoa_fisica_id
            WHERE pf.publicado = 1 AND jm.ativo = 1 AND jm.valido = 1 ORDER BY nome ASC";
$query = mysqli_query($conn, $sql);
$num = mysqli_num_rows($query);
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <!-- START ACCORDION-->
        <h2 class="page-header"><?= saudacao() . ", " . $_SESSION['nome'] ?>!</h2>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Listagem de cadastros válidos e ativos</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="box-group" id="accordion">
                            <table id="tbl" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Nome Social</th>
                                    <th>Email</th>
                                    <th>RG</th>
                                    <th>CPF</th>
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
                                    echo "<td>" . exibirDataBr($jovem_monitor['data_cadastro']) . "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";
                                ?>
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
<!--
</section>-->


