<?php

    try {

        // inclusões
        include_once("configdb.php");

        // conexão
        $conn = iniciaDB();

        // Usuários
        $query_users = "CREATE DATABASE IF NOT EXISTS codexp49_usuarios";
        $table_users = "CREATE TABLE IF NOT EXISTS users (
            id INT(50) AUTO_INCREMENT NOT NULL,
            nome VARCHAR(200) NOT NULL,
            email VARCHAR(200) NOT NULL,
            senha VARCHAR(200) NOT NULL,
            foto VARCHAR(4000),
            sobre VARCHAR(5000),
            habilidades VARCHAR(1000),
            sexo VARCHAR(200),
            estado VARCHAR(200),
            token VARCHAR(2000),
            PRIMARY KEY (id)
        );";

        $conn -> exec($query_users);

        // conexão renovada para tabela
        $conn = iniciaDB("codexp49_usuarios");
        $conn -> exec($table_users);

        // Projetos
        $query_projs = "CREATE DATABASE IF NOT EXISTS codexp49_projetos";
        $table_projs = "CREATE TABLE IF NOT EXISTS projs (
            id INT(50) AUTO_INCREMENT NOT NULL,
            nome VARCHAR(200) NOT NULL,
            descricao VARCHAR(5000) NOT NULL,
            criador INT(50) NOT NULL,
            max_membros INT(50) NOT NULL,
            membros VARCHAR(3000) NOT NULL,
            langs VARCHAR(2000) NOT NULL,
            oferece VARCHAR(1000) NOT NULL,
            data_de_criacao DATE NOT NULL,
            num_membros INT(50) NOT NULL,
            estado VARCHAR(200) NOT NULL,
            PRIMARY KEY (id)
        );";

        $conn -> exec($query_projs);

        // conexão renovada para tabela
        $conn = iniciaDB("codexp49_projetos");
        $conn -> exec($table_projs);

        // Mensagens
        $table_msg = "CREATE TABLE IF NOT EXISTS mensagens (
            id INT(50) AUTO_INCREMENT NOT NULL,
            nome VARCHAR(200) NOT NULL,
            msg VARCHAR(8000) NOT NULL,
            criador INT(50) NOT NULL,
            data_da_msg DATE NOT NULL,
            proj INT(50) NOT NULL,
            painel VARCHAR(200) NOT NULL,
            PRIMARY KEY (id)
        );";

        $conn = iniciaDB("codexp49_usuarios");
        $conn -> exec($table_msg);

        // Arquivos
        $table_arq = "CREATE TABLE IF NOT EXISTS arquivos (
            id INT(50) AUTO_INCREMENT NOT NULL,
            link VARCHAR(8000) NOT NULL,
            descricao VARCHAR(8000) NOT NULL,
            criador INT(50) NOT NULL,
            data_do_arq DATE NOT NULL,
            proj INT(50) NOT NULL,
            PRIMARY KEY (id)
        );";

        $conn = iniciaDB("codexp49_projetos");
        $conn -> exec($table_arq);

        // Painéis
        $table_panel = "CREATE TABLE IF NOT EXISTS paineis (
            id INT(50) AUTO_INCREMENT NOT NULL,
            nome VARCHAR(8000) NOT NULL,
            proj INT(50) NOT NULL,
            PRIMARY KEY (id)
        );";

        $conn = iniciaDB("codexp49_projetos");
        $conn -> exec($table_panel);

        // Pedidos
        $table_pedi = "CREATE TABLE IF NOT EXISTS pedidos (
            id INT(50) AUTO_INCREMENT NOT NULL,
            descricao VARCHAR(8000) NOT NULL,
            criador INT(50) NOT NULL,
            proj INT(50) NOT NULL,
            PRIMARY KEY (id)
        );";

        $conn = iniciaDB("codexp49_projetos");
        $conn -> exec($table_pedi);

    } catch (PDOException $error) {
        echo "<br>Ocorreu um erro, por favor, contate o desenvolvedor!<br><br>";
        echo "Número do erro: " . $error -> getCode() . " | Erro: " . $error -> getMessage();
    }

?>