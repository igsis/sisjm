<?php
include "includes/menu.php";

$con = bancoMysqli();

$url = 'http://' . $_SERVER['HTTP_HOST'] . '/sisjm/funcoes/api_verifica_email.php';
$user = 'http://' . $_SERVER['HTTP_HOST'] . '/sisjm/funcoes/api_verifica_usuario.php';

if (isset($_POST['cadastra'])) {
    $nome = $_POST['nome'];
    $RF = $_POST['rf'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];
    $confirmaSenha = $_POST['confirmaSenha'];
    $data = date("Y-m-d g:i:s");

    if ($senha == $confirmaSenha) {
        $senha = md5($senha);
        $sql = "INSERT INTO usuarios (nome_completo, usuario, senha, RF, telefone, email, data_cadastro, publicado)
        VALUES ('$nome', '$usuario','$senha', '$RF', '$telefone', '$email', '$data', 1)";

        if (mysqli_query($con, $sql)) {
            $mensagem = mensagem("success", "Usuário cadastrado com sucesso!");
        } else {
            $mensagem = mensagem("danger", "Erro no cadastro de usuário! Tente novamente.");
        }
    } else {
        $mensagem = mensagem("danger", "Senhas não conferem!");
    }
}
?>

<div class="content-wrapper">
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Cadastro Administrador</h3>
            </div>
            <div class="row" align="center">
                <?php if (isset($mensagem)) {
                    echo $mensagem;
                }; ?>
            </div>
            <form method="POST" action="?perfil=cadastro_usuario" role="form">
                <div class="box-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="nome">Nome Completo* </label>
                            <input type="text" id="nome" name="nome" class="form-control" required>
                        </div>

                        <div class="form-group col-md-6" id="divUsuario">
                            <label for="usuario">Usuário* </label>
                            <input type="usuario" id="usuario" name="usuario" class="form-control" maxlength="7"
                                   required>
                            <span class="help-block" id="spanHelpUser"></span>
                        </div>

                        <div class="form-group col-md-6" id="divEmail">
                            <label for="email">E-mail* </label>
                            <input type="email" id="email" name="email" class="form-control" maxlength="100"
                                   required>
                            <span class="help-block" id="spanHelp"></span>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="rf_usuario">RF* </label>
                            <input type="text" id="rf" name="rf" class="form-control" data-mask="000.000/0" maxlength="9" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="tel_usuario">Telefone* </label>
                            <input type="text" data-mask="(00) 00000-0000" id="telefone" name="telefone"
                                   class="form-control" required>
                        </div>
                    </div>
                    <div class="row">

                        <div class="form-group col-md-6">
                            <label for="senha">Senha* </label>
                            <input type="password" class="form-control" id="senha" name="senha" onblur="comparaSenhas()"
                                   onkeypress="comparaSenhas()" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="confirmaSenha">Confirmar Senha* </label>
                            <input type="password" class="form-control" id="confirmaSenha" name="confirmaSenha"
                                   onblur="comparaSenhas()" onkeypress="comparaSenhas()" required>
                        </div>
                    </div>

                    <div class="box-footer">
                        <a href="../../index.php">
                            <button type="button" class="btn btn-primary pull-left">Voltar</button>
                        </a>
                        <button type="submit" name="cadastra" id="cadastra" class="btn btn-primary pull-right">
                            Cadastrar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>

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

    //verifica email em uso

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

    //verifica usuario em uso

    const user = `<?=$user?>`;

    var usuario = $("#usuario");

    // adiciona o evento de onblur no campo de email
    usuario.blur(function () {
        $.ajax({
            url: user,
            type: 'POST',
            data: {"usuario": usuario.val()},

            success: function (data) {

                let divUsuario = document.querySelector('#divUsuario');

                // verifica se o que esta sendo retornado é 1 ou 0
                if (data.ok) {
                    divUsuario.classList.remove("has-error");
                    document.getElementById("spanHelpUser").innerHTML = '';
                    $('#cadastra').attr('disabled', false);
                } else {
                    divUsuario.classList.add("has-error");
                    document.getElementById("spanHelpUser").innerHTML = "Usuário em uso!";
                    $('#cadastra').attr('disabled', true);
                }
            }
        });
    });
</script>

