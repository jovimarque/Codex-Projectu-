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
         <a href="../home.php" class="navbar-brand"><img src="../img/logo.png" width="70px"></a>
            <button class="navbar-toggler" data-toggle="collapse" data-target="#menu"><i class="fas fa-bars text-white"></i></button>
         <div class="collapse navbar-collapse" id="menu">
          <ul class="navbar-nav ml-auto">
			<li class="nav-item"><a href="../home.php" class="nav-link">Home</a></li>
			<li class="nav-item"><a href="../sobre.php" class="nav-link">Sobre nós</a></li>
			<li class="nav-item"><a href="../projetos.php" class="nav-link">Projetos</a></li>
			<?php

                if (!isset($_SESSION['logado'])) {
                  echo '<li class="nav-item"><a href="cadastro.php" class="nav-link">Inscrever-se</a></li>';
                }

            ?>
			<li class="nav-item">
				<?php
					if (!isset($_SESSION['logado'])) {
						echo '<a href="entrar.php" class="btn btn-outline-light">Entrar</a>';
					} else if ($_SESSION['logado'] == "true") {
						echo "<a href='#'>FOTO AQUI</a>";
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
				<div id='box' class="mt-4" style='height: 24rem;width:100%;overflow-y: scroll;overflow-x: hidden;position: relative;'>
					<?php
					    if (!isset($_SESSION['logado']) == TRUE) {
					        echo "<script>alert('Você não está logado!');</script>";
					        echo "<script>window.location.href='../home.php';</script>";
					    }
					
						// inclusões
						include_once("../back-end/configdb.php");
						include_once("../back-end/create_all.php");

						if (!isset($_POST['sair']) == FALSE) {
							session_destroy();
							echo "<script>alert('Usuário deslogado!');</script>";
							echo "<script>window.location.href='../home.php';</script>";
						}

						$id = $_SESSION['id'];
					
						// conexão
						$conn = iniciaDB("codexp49_usuarios");
						$conn2 = iniciaDB("codexp49_projetos");

						// informações usuário
						$busca = "SELECT * FROM users WHERE id = '$id'";

						$res = $conn -> query($busca);
						$lista = $res -> fetchAll();

						foreach ($lista as $value) {
							// campos
							$nome = $value[1];
							$foto = $value[4];
							$email = $value[2];
						}

						// informações projetos
						$b_proj = "SELECT * FROM projs WHERE criador = '$id'";
						$r_proj = $conn2 -> query($b_proj);
						$q_proj = $r_proj -> rowCount();

						// projetos fechados - quantia
						$b_proj_c = "SELECT * FROM projs WHERE criador = '$id' AND estado = 'fechado'";
						$r_proj_c = $conn2 -> query($b_proj_c);
						$q_proj_c = $r_proj_c -> rowCount();

					?>
					<?php
					
						echo "<h3><img src='upload/$foto' width='40px' style='border-radius: 50%;'> $nome - Usuário Comum</h3>";
						echo "$email";

					?>

					<hr>
					<h5>Informações Básicas</h5>

					<?php
					
						echo "<ul id='menu-profile'>
						
							<li>Projetos criados: $q_proj</li>
							<li>Projetos fechados: $q_proj_c</li>
						
						</ul>";	

					?>
						
					<hr>
					<h5>Informações Avançadas</h5>
					<ul id="menu-profile">
						<li class="nav-item"><a href='meus_dados.php?opc=see' class='nav-link' style='color: white;'>Meus dados</a></li>
						<li class="nav-item"><a href='meus_proj.php' class='nav-link' style='color: white;'>Meus Projetos</a></li>
						<li class="nav-item"><a href='user_avancado.php' class='nav-link' style='color: white;'>Avançado</a></li>
					</ul>

					<form method='POST'>
						<input class='btn btn-danger' type='submit' value='Sair' name='sair' id='sair'>
					</form>
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