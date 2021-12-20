<?php
    session_start();

    // inclusões
    include_once("configdb.php");
    include_once("create_all.php");

    // conexão
    $conn_users = iniciaDB('codexp49_projetos');

    // variaveis
    $id_arq = $_GET['cod'];

    // deletar mensagem
    $deletar = "DELETE FROM arquivos WHERE id = '$id_arq';";

    $run = $conn_users -> exec($deletar);

    if ($run) {
        echo "<script>window.history.back();</script>";
    }
