<?php
    session_start();

    if ($_POST['mensagem'] != "") {
        // inclusões
        include_once("configdb.php");

        // conexão
        $conn_users = iniciaDB('codexp49_usuarios');

        // variaveis
        $meu_id = $_SESSION['id'];
        $id_proj = $_GET['id_proj'];
        $painel = $_GET['painel'];

        // campos
        $mensagem = $_POST['mensagem'];
        $data = date("y/m/d");

        // informações do usuário
        $buscar = "SELECT nome FROM users WHERE id = '$meu_id'";
        $res = $conn_users -> query($buscar);
        $lista = $res -> fetchAll();

        foreach ($lista as $values) {
            $nome_user = $values[0];
        }

        // inserir mensagem
        $inserir = "INSERT INTO mensagens (nome, msg, criador, data_da_msg, proj, painel) VALUES (:nome, :msg, :criador, :data_da_msg, :proj, :painel);";

        $stmt = $conn_users -> prepare($inserir);

        $stmt -> bindValue(':nome', $nome_user);
        $stmt -> bindValue(':msg', $mensagem);
        $stmt -> bindValue(':criador', $meu_id);
        $stmt -> bindValue(':data_da_msg', $data);
        $stmt -> bindValue(':proj', $id_proj);
        $stmt -> bindValue(':painel', $painel);

        $run = $stmt -> execute();

        if ($run) {
            echo "<script>window.history.back();</script>";
        }
    }
