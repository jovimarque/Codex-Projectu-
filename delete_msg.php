<?php
    session_start();

    // inclusões
    include_once("configdb.php");

    // conexão
    $conn_users = iniciaDB('codexp49_usuarios');

    // variaveis
    $id_proj = $_GET['cod'];
    $panel = $_GET['painel'];

    // deletar mensagem
    $deletar = "DELETE FROM mensagens WHERE id = '$id_proj' AND painel = '$panel';";

    $run = $conn_users -> exec($deletar);

    if ($run) {
        echo "<script>window.history.back();</script>";
    }
