<?php
    session_start();

    // inclusões
    include_once("configdb.php");
    include_once("create_all.php");

    // conexão
    $conn_users = iniciaDB('codexp49_projetos');
    $conn2 = iniciaDB('codexp49_usuarios');

    // variaveis
    $id_panel = $_GET['cod'];
    $panel = $_GET['painel'];

    // deletar painel
    $deletar = "DELETE FROM paineis WHERE id = '$id_panel';";

    $run = $conn_users -> exec($deletar);

    // deletar mensagens do painel
    $deletar_msg = "DELETE FROM mensagens WHERE painel = '$panel'";

    $run2 = $conn2 -> exec($deletar_msg);

    if ($run2 == FALSE) {
        $run2 = TRUE;
    }

    if ($run && $run2) {
        echo "<script>window.location.href='../user/meus_proj.php'</script>";
    }
