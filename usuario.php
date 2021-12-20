<?php

	session_start();

?>
<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">

	<!-- Ícone e Estilo CSS -->
	<link rel="stylesheet" type="text/css" href="../css/userinterface.css">
	<link rel="icon" href="../img/logo.ico">

	<!--Normalize HTML-->
	<link rel="stylesheet" type="text/css" href="../css/normalize.css">
	<title>Codex & Projectu</title>
</head>
<body>

 <!--- inicio menu --->
 <header>
    <nav class="navbar navbar-expand-md">
        <div class="container">
         <a href="../home.php" class="navbar-brand"><img src="../img/logo.png" width="50px"></a>
            <button class="navbar-toggler" data-toggle="collapse" data-target="#menu"><i class="fas fa-bars text-white"></i></button>
         <div class="collapse navbar-collapse" id="menu">
          <ul class="navbar-nav ml-auto">
			<li class="nav-item"><a href="../home.php" class="nav-link">Home</a></li>
			<li class="nav-item"><a href="../sobre.php" class="nav-link">Sobre nós</a></li>
			<li class="nav-item"><a href="../projetos.php" class="nav-link">Projetos</a></li>
			<?php

                if (!isset($_SESSION['logado'])) {
                  echo '<li class="nav-item"><a href="../cadastro.php" class="nav-link">Inscrever-se</a></li>';
                }

            ?>
			<li class="nav-item">
				<?php
					if (!isset($_SESSION['logado'])) {
						echo '<a href="../entrar.php" class="btn btn-outline-light">Entrar</a>';
					} else if ($_SESSION['logado'] == "true") {
						echo "<a href=../user/'userinterface.php'>FOTO AQUI</a>";
					}
				?>
			</li>
          </ul>
        </div>
        </div>
    </nav>   
  </header>

   <!--- final menu --->

	<!-- Início Conteúdo -->
	<div class="container">
      	<div class="row">
			<div class='col-sm-12'>
                <div id="box" class='mt-4' style='height: 20rem;width:100%;overflow-y: scroll;overflow-x: hidden;position: relative;'>
                    <?php
                    
                        // inclusões
                        include_once("configdb.php");
                        include_once("create_all.php");

                        // conexão
                        $conn = iniciaDB("codexp49_usuarios");

                        // variáveis
                        $id_user = $_GET['cod'];

                        // buscar informações
                        $buscar = "SELECT * FROM users WHERE id = '$id_user'";
                        $res = $conn -> query($buscar);
                        $lista = $res -> fetchAll();

                        foreach ($lista as $values) {
                            $nome = $values[1];
                            $email = $values[2];
                            $sobre = $values[5];
                            $habilidades = $values[6];
                            $foto = $values[4];
                            $sexo = $values[7];
                            
                            if ($sobre == NULL || $sobre == " ") {
                                $sobre = "<b>O usuário não tem uma descrição sobre ele.</b>";
                            } if ($habilidades == NULL || $sobre == " ") {
                                $habilidades = "<b>Sem habilidades</b>";
                            }

                            echo "<h4><img src='../user/upload/$foto' width='40px' style='border-radius: 50%;'> $nome</h4><br>

                                $sobre<br><br>
                                
                                <b>Habilidades</b>: $habilidades<br>
                                <b>Sexo:</b> $sexo<br>
                                <b>Contato:</b> $email<br><br>

                                <hr style='border: 1px solid white;'>
                                <a href='../projetos.php'><button class='btn btn-success'>Voltar</button></a>

                            ";

                        }

                    ?>
                </div>
            </div>
        </div>
    </div>
	<!-- Final Conteúdo -->
 
   

   <!---rodapé --->
	 <footer id="rodape" class='p-0' style='margin-top: 22%;'>
		  <img src="../img/logo.png" width="40px">Todos os direitos reservados &copy; LilCode Team 2021<br>
		  <ul><li style='display: inline;'><a href='../other/politica.php' style='color:white;'>POLÍTICA</a></li> | <li style='display: inline;'><a href='../other/termos-uso.php'  style='color:white;'>TERMOS DE USO</a></li></ul>
	 </footer>

	<!-- Boostrap Script Links -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>