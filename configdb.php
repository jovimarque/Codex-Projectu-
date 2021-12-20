<?php

    function iniciaDB($database=null, $host='br990.hostgator.com.br', $user='codexp49', $password='4L9lYjbm06') {

        if ($database == null) {
            $database = "";
        } if ($password == null) {
            $password = "";
        }

        try {
            if ($database == "") {
                $conn = new PDO ("mysql:host=$host;user=$user;password=$password");
                return $conn;
            } else if ($database != "" || $database != null) {
                $conn = new PDO ("mysql:dbname=$database;host=$host;user=$user;password=$password");
                return $conn;
            }
        } catch (PDOException $error) {
            echo "<br>Ocorreu um erro, por favor, contate o desenvolvedor!<br><br>";
            echo "Número do erro: " . $error -> getCode() . " | Erro: " . $error -> getMessage();
        }

    }

