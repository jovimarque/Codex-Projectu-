<?php

    // inclusões
    include_once("configdb.php");
    include_once("create_all.php");

    // conexão
    $conn = iniciaDB("codexp49_projetos");
    $conn_user = iniciaDB("codexp49_usuarios");

    // variáveis
    $id_proj = $_GET['proj'];
    $id_member = $_GET['cod'];

    // buscar membros
    $buscar = "SELECT membros FROM projs WHERE id='$id_proj'";
    $res = $conn -> query($buscar);
    $lista = $res -> fetchAll();

    foreach ($lista as $values) {
        $membros = $values[0];

        $membros = str_replace( $membros, "{$id_member}, ", "_");
        
        // update
        $update = "UPDATE projs SET membros = '$membros', num_membros = num_membros - 1 WHERE id = '$id_proj';";
        $run = $conn -> exec($update);

        if ($run) {
            echo "<script>alert('Membro removido da equipe!');</script>";
            $data = date("y/m/d");

            // nova mensagem
            $nova_msg = "INSERT INTO mensagens (nome, msg, data_da_msg, proj, painel) VALUES ('Sistema', 'Um membro foi removido da equipe, veja o painel de membros.', '$data', '$id_proj', 'chat');";
            $conn_user -> exec($nova_msg);

            echo "<script>window.history.back();</script>";

        }
    }

?>
