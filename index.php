<?php
include "funcoes/funcoesGerais.php";
require "funcoes/funcoesConecta.php";

//autentica login e cria inicia uma session
if(isset($_POST['login']))
{
	$login = $_POST['login'];
	$senha = $_POST['senha'];
	$sql = "SELECT * FROM usuarios AS usr
	WHERE usr.usuario = '$login' LIMIT 0,1";
	$con = bancoMysqli();
	$query = mysqli_query($con,$sql);
	//query que seleciona os campos que voltarão para na matriz
	if($query)
	{
		//verifica erro no banco de dados
		if(mysqli_num_rows($query) > 0)
		{
			// verifica se retorna usuário válido
			$user = mysqli_fetch_array($query);
			if($user['senha'] == md5($_POST['senha']))
			{
				// compara as senhas
				session_start();
				$_SESSION['login'] = $user['usuario'];
				$_SESSION['nome'] = $user['nome_completo'];
				$_SESSION['idUser'] = $user['id'];
				$log = "Fez login.";
				gravarLog($log);
				header("Location: visual/index.php");
				gravarLog($sql);
			}
			else
			{
			$mensagem = "<span style=\"color: #FF0000; \"><strong>A senha está incorreta!</strong></span>";
			}
		}
		else
		{
			$mensagem = "<span style=\"color: #FF0000; \"><strong>O usuário não existe.</strong></span>";
		}
	}
	else
	{
		$mensagem = "<span style=\"color: #FF0000; \"><strong>Erro no banco de dados!</strong></span>";
	}
}
?>
<!DOCTYPE html>
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
    <div class="login-logo"><b>Jovem Monitor</b></div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg"><?php if(isset($mensagem)){ echo $mensagem; } ?></p>
        <form action="index.php" method="post">
            <div class="form-group has-feedback">
                <label>Usuário</label>
                <input type="text" name="login" class="form-control" ng-model="login.usuario" maxlength="7" required>
            </div>
            <div class="form-group has-feedback">
                <label>Senha</label>
                <input type="password" name="senha" class="form-control" ng-model="login.senha" placeholder="Senha" maxlength="70" required>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8"></div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" ng-disabled="!login.usuario || !login.senha" class="btn btn-primary btn-block btn-flat">Entrar</button>
                </div>
                <!-- /.col -->
            </div>
        </form>
        <label> Esqueceu a senha? <a href="esqueceu_senha.php" class="text-center">Clique aqui.</a></label>
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




<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });

</script>
</body>
</html>
