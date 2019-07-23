<?php
include "funcoes/funcoesConecta.php";
include "funcoes/funcoesGerais.php";
$con = bancoMysqli();

if (isset($_POST['enviarEmail']))
{
    $token = bin2hex(random_bytes(50));
    $email = trim($_POST['email']);

    $sqlConsulta = "SELECT * FROM `usuarios` WHERE email = '$email'";
    $queryConsulta = $con->query($sqlConsulta);
    if ($queryConsulta->num_rows > 0)
    {
        // store token in the password-reset database table against the user's email
        $sqlConsultaToken = "SELECT * FROM `reset_senhas` WHERE `email` = '$email'";
        if ($con->query($sqlConsultaToken)->num_rows > 0)
        {
            $sqlToken = "UPDATE `reset_senhas` SET `token` = '$token' WHERE `email` = '$email'";
        }
        else
        {
            $sqlToken = "INSERT INTO `reset_senhas`(email, token) VALUES ('$email', '$token')";
        }
        $results = $con->query($sqlToken);

        // Send email to user with the token in a link they can click on
        $to = $email;
        $subject = "SISJM - Recuperação de Senha";
        $msg = emailReset($token);

        // To send HTML mail, the Content-type header must be set
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

        // Create email headers
        $headers .= "De: no.reply.smcsistemas@gmail.com\r\n";
        mail($to, $subject, $msg, $headers);

        $mensagem = "<span style='color: #00a201; '>Enviamos um email para <b>$email</b> para a reiniciarmos sua senha. <br>
                    Por favor acesse seu email e clique no link recebido para cadastrar uma nova senha! (Lembre-se de verificar o spam)</span>";
    }
    else
    {
        $mensagem = "<span style='color: #ff0000; '><strong>E-mail não encontrado em nossa base de dados. </strong></span>";
    }

}

?>

<html ng-app="jovemMonitor">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sistema Jovem Monitor | Log in</title>
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

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">



</head>
<body class="hold-transition login-page">
<div class="login-box">
    <!-- /.login-logo -->
    <div class="login-box-body">
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <h4> <center> ESQUECEU SUA SENHA? </center></h4>
                <h4><?php if(isset($mensagem)){echo $mensagem;}?></h4>
                <hr>
                <form method="POST" action="esqueceu_senha.php">
                    <div class="row">
                        <div class="form-group has-feedback">
                            <label>Digite Seu E-mail:</label>
                            <input type="email" name="email" class="form-control">
                        </div>
                        <div class="box-footer">
                            <a href="index.php">
                                <button type="button" class="btn btn-primary pull-left">Voltar</button>
                            </a>
                            <button type="submit" name="enviarEmail" value="Enviar" class="btn btn-primary pull-right">Enviar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="visual/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="visual/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="visual/plugins/iCheck/icheck.min.js"></script>
<!--Frufru do login em angular-->
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.5/angular.min.js"></script>

</body>
</html>

