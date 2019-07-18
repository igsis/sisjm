<?php
include "funcoes/funcoesGerais.php";
require "funcoes/funcoesConecta.php";

$con = bancoMysqli();

$url = 'http://' . $_SERVER['HTTP_HOST'] . '/sisjm/funcoes/api_verifica_email.php';
$data = date('d/m/Y');
if (isset($_POST['cadastra'])) {
    $nome = $_POST['nome'];
    $RF = $_POST['rf'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];
    $confirmaSenha = $_POST['confirmaSenha'];

    if ($senha == $confirmaSenha) {
        $senha = md5($senha);
        $sql = "INSERT INTO usuarios (nome_completo, usuario, senha, RF, telefone, email, data_cadastro, publicado)
        VALUES ('$nome', '$usuario','$senha', '$RF', '$telefone', '$email', '$data', 1)";

        if (mysqli_query($con, $sql)) {
            $mensagem = mensagem("success", "Usuário cadastrado com sucesso! Você está sendo redirecionado para a tela de login.");
            echo "<script type=\"text/javascript\">
						  window.setTimeout(\"location.href='index.php';\", 4000);
					  </script>";

        } else {
            $mensagem = mensagem("danger", "Erro no cadastro de usuário! Tente novamente.");
        }
    } else {
        $mensagem = mensagem("danger", "Senhas não conferem!");
    }
}
?>
<html ng-app="sisjm">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sisjm | Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="visual/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="visual/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="visual/bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="visual/dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="visual/plugins/iCheck/square/blue.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body class="content-wrapper content hold-transition">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper content">
    <!-- Main content -->
    <section class="content">

        <!-- START FORM-->
        <h2 class="page-header">Cadastro de Usuário</h2>
        <div class="row" align="center">
            <?php if (isset($mensagem)) {
                echo $mensagem;
            }; ?>
        </div>
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Usuários</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form method="POST" action="cadastro_usuario.php" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="nome">Nome Completo* </label>
                                    <input type="text" id="nome" name="nome" class="form-control" required>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="rf_usuario">Usuário* </label>
                                    <div id='resposta'></div>
                                    <input type="text" id="usuario" name="usuario" class="form-control" required>
                                </div>

                                <div class="form-group col-md-4" id="divEmail">
                                    <label for="email">E-mail* </label>
                                    <input type="email" id="email" name="email" class="form-control" maxlength="100"
                                           required>
                                    <span class="help-block" id="spanHelp"></span>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="rf_usuario">RF* </label>
                                    <input type="text" id="rf" name="rf" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="tel_usuario">Telefone* </label>
                                    <input type="text" data-mask="(00) 00000-0000" id="telefone" name="telefone"
                                           class="form-control" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="senha">Senha: </label>
                                    <input type="password" class="form-control" id="senha" name="senha">
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="confirmaSenha">Confirmar Senha: </label>
                                    <input type="password" class="form-control" id="confirmaSenha" name="confirmaSenha">
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <a href="index.php">
                                <button type="button" class="btn btn-primary pull-left">Voltar</button>
                            </a>
                            <button type="submit" name="cadastra" id="cadastra" class="btn btn-primary pull-right">
                                Cadastrar
                            </button>
                        </div>
                    </form>
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
<!-- jQuery 3 -->
<script src="visual/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="visual/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="visual/plugins/iCheck/icheck.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>

<script>
    function comparaSenhas() {
        let senha = document.getElementById("senha");
        let confirmaSenha = document.getElementById("confirmaSenha");

        if (senha.value == confirmaSenha.value) {
            document.getElementById("cadastra").disabled = false;
        } else {
            document.getElementById("cadastra").disabled = true;
        }
    }

    const url = `<?=$url?>`;

    var email = $("#email");

    // adiciona o evento de onblur no campo de email
    email.blur(function () {
        $.ajax({
            url: url,
            type: 'POST',
            data: {"email": email.val()},

            success: function (data) {

                let divEmail = document.querySelector('#divEmail');

                // verifica se o que esta sendo retornado é 1 ou 0
                if (data.ok) {
                    divEmail.classList.remove("has-error");
                    document.getElementById("spanHelp").innerHTML = '';
                    $('#cadastra').attr('disabled', false);
                } else {
                    divEmail.classList.add("has-error");
                    document.getElementById("spanHelp").innerHTML = "Email em uso!";
                    $('#cadastra').attr('disabled', true);
                }
            }
        });
    });
    */
</script>
</body>
</html>
