<?php
$idUsuario = $_SESSION['idUser'];

$con = bancoMysqli();
$sql_user = "SELECT id from usuarios WHERE id = '$idUsuario'";
$query_user = mysqli_query($con,$sql_user);
$user = mysqli_fetch_array($query_user);
$u_perfil = $user['id'];

$sql_perfil = "SELECT * FROM modulo_perfis 
              INNER JOIN modulos AS m ON modulo_perfis.modulo_id = m.id 
              INNER JOIN cores ON m.cor_id = cores.id
              WHERE perfil_id = '$u_perfil' ORDER BY descricao";
$query_perfil = mysqli_query($con,$sql_perfil);
?>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MÓDULOS</li>
            <li><a href="?secao=perfil"><i class="fa fa-circle-o text-aqua"></i><span>Home - Listagem</span></a></li>
            <li><a href="?perfil=exportar"><i class="fa fa-circle-o text-aqua"></i><span>Exportar para Excel</span></a></li>
            <li><a href="?perfil=cadastro_usuario"><i class="fa fa-circle-o text-aqua"></i><span>Cadastrar administrador</span></a></li>
            <li><a href="?perfil=frm_habilita_cadastro_capac"><i class="fa fa-circle-o text-aqua"></i><span>Cadastro CAPAC</span></a></li>

            <li class="header">MAIS</li>
            <li><a href="?perfil=usuario/minha_conta"><i class="fa fa-user"></i><span>Minha Conta</span></a></li>
            <li><a href="../include/logoff.php"><i class="fa fa-sign-out"></i><span>Sair</span></a></li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>