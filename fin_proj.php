<?php
    session_start();

    // inclusões
    include_once("configdb.php");
    include_once("create_all.php");

    // variáveis
    $id_proj = $_GET['cod'];
    $criador = $_GET['cria'];

    if ($_SESSION['id'] == $criador) {
        // conexão
        $conn = iniciaDB("codexp49_projetos");

        // alterar estado
        $update = "UPDATE projs SET estado = 'fechado' WHERE id = '$id_proj';";

        $run = $conn -> exec($update);

        if ($run) {
            echo "<script>alert('Projeto finalizado com sucesso!');</script>";
            echo "<script>window.location.href='../user/meus_proj.php'</script>";
        }

    } else {
        echo "<script>alert('Você não é o dono do projeto.');</script>";
        echo "<script>window.location.href='../user/meus_proj.php';</script>";
    }


?>
