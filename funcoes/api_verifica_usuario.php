<?php
require_once 'funcoesConecta.php';
// require "../funcoes/";

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: *');
header('Content-Type: application/json');

if(isset($_POST['usuario'])){

    #Recebe o usuario Postado
    $usuarioPostado = $_POST['usuario'];

    #Conecta banco de dados
    $con = bancoMysqli();
    $sql = mysqli_query($con, "SELECT * FROM usuarios WHERE usuario = '{$usuarioPostado}'") or print mysql_error();

    #Se o retorno for maior do que zero, diz que já existe um.
    if(mysqli_num_rows($sql)>0)
        $usuario =  json_encode(array('usuario' => 'Usuário em uso!', 'ok' => 0));
    else
        $usuario = json_encode(array('usuario' => 'Usuário ok', 'ok' => 1));

    print_r($usuario);
}

