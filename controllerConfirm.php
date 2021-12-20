<?php
    // inclusões
    include_once("configdb.php");

    // conexão
    $conn = iniciaDB("codexp49_usuarios");

    // token
    $token = $_GET['token'];

    // Update
    $update = "UPDATE users SET estado = 'Cadastrado' WHERE token = '$token'";
    $run = $conn -> exec($update);

    if ($run) {
        echo "<script>alert('Conta verificada.');</script>";
        echo "<script>window.location.href='../entrar.php';</script>";
    }

?>
