<?php

    // inclusões
    include_once("configdb.php");
    include_once("create_all.php");

    // conexão
    $conn = iniciaDB("codexp49_projetos");

    // variáveis
    $id_ped = $_GET['ped'];

    // remoção
    $remover = "DELETE FROM pedidos WHERE id='$id_ped';";
    $run = $conn -> exec($remover);

    if ($run) {
        echo "<script>alert('Seu pedido foi removido.');</script>";
        echo "<script>window.location.href='../user/userinterface.php';</script>";
    }
?>
