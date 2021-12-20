<?php

	session_start();

?>
<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	
	<!-- Estilo CSS -->
	<link rel="stylesheet" type="text/css" href="css/entrar.css">
	<link rel="icon" href="img/logo.ico">
	<title>Codex & Projectu</title>
</head>
<body>
<!--- inicio menu --->
 <header>
    <nav class="navbar navbar-expand-md">
        <div class="container">
         <a href="" class="navbar-brand"><img src="img/logo.png" width="70px"></a>
            <button class="navbar-toggler" data-toggle="collapse" data-target="#menu"><i class="fas fa-bars text-white"></i></button>
         <div class="collapse navbar-collapse" id="menu">
          <ul class="navbar-nav ml-auto">
              <li class="nav-item"><a href="home.php" class="nav-link">Home</a></li>
              <li class="nav-item"><a href="sobre.php" class="nav-link">Sobre nós</a></li>
              <li class="nav-item"><a href="projetos.php" class="nav-link">Projetos</a></li>
              <?php

                if (!isset($_SESSION['logado'])) {
                  echo '<li class="nav-item"><a href="cadastro.php" class="nav-link">Inscrever-se</a></li>';
                }

              ?>
              <li class="nav-item"><?php
					if (!isset($_SESSION['logado'])) {
						echo '<a href="entrar.php" class="btn btn-outline-light">Entrar</a>';
					} else if ($_SESSION['logado'] == "true") {
						echo "<a href='user/userinterface.php'>FOTO AQUI</a>";
					}
			  ?></li>
          </ul>
        </div>
        </div>
    </nav>   
   </header>
   <!--- final menu --->
   
     
     <!--- inicio login --->
    <div class="container">
      <div class="row">
        <div class='col-sm-12'>
          <div class="box mt-4" style='height: 18rem;width: 16rem;position: relative;'>
            <?php

              if (!isset($_POST['entrar']) == FALSE) {
                // inclusões
                include_once("back-end/configdb.php");
                include_once("back-end/create_all.php");

                // campos
                $email = $_POST['email'];
                $senha = $_POST['senha'];

                // verficar se os campos estão vazios
                if (!isset($email) == TRUE || !isset($email) == TRUE) {
                  echo "<script>alert('Todos os campos são requeridos.');</script>";
                } else {
                  
                  // conexão
                  $conn = iniciaDB("codexp49_usuarios");

                  // buscar por usuário
                  $busca = "SELECT * FROM users WHERE email = :email AND senha = :senha;";

                  $stmt = $conn -> prepare($busca);

                  // valores
                  $stmt -> bindValue(':email', $email);
                  $stmt -> bindValue(':senha', md5($senha));

                  $stmt -> execute();
                  $rows = $stmt -> rowCount();
                  $lista = $stmt -> fetchAll();

                  foreach ($lista as $value) {
                    $id = $value[0];
                    $estado = $value[8];
                  }

                  if ($rows == 0) {
                    echo "<script>alert('Usuário ou senha incorretos.');</script>";
                  } else if ($rows == 1) {
                    if ($estado == "Cadastrado") {
                      echo "<script>alert('Usuário logado com sucesso!');</script>";
                      $_SESSION['logado'] = 'true';
                      $_SESSION['id'] = $id;
                      echo "<script>window.location.href='home.php'</script>";
                    } else if ($estado == "Em análise") {
                      echo "<script>alert('Você ainda não confirmou o seu email!');</script>";
                      $_SESSION['id'] = $id;
                      echo "<script>window.location.href='other/confirmMail.php';</script>";
                    }
                  }
                }
              }
            
            ?>
            <h2>Entrar</h2>

            <form method="post">

              <input type="email" name="email" placeholder="Digite o seu email" required>
              <br>
              <input type="password" name="senha" placeholder="Digite a sua senha" required>
              <br>
              <input type="submit" value="Entrar" name='entrar'><br><br>

              <a href="#" style='color: white;'>Recuperar senha</a><br>
              <a href="cadastro.php" style='color: white;'>Criar conta</a>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!--- final login --->


   <!---rodapé --->
	 <footer id="rodape" class='p-0' style='margin-top: 22%;'>
		  <img src="img/logo.png" width="70px">Todos os direitos reservados &copy; LilCode Team 2021<br>
      <ul><li style='display: inline;'><a href='other/politica.php' style='color:white;'>POLÍTICA</a></li> | <li style='display: inline;'><a href='other/termos-uso.php'  style='color:white;'>TERMOS DE USO</a></li></ul>
	 </footer>
	

              


		<!--Boostrap Scrpit links-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
