<?php

	session_start();
	
	// inclusão
  include_once("back-end/configdb.php");
  include_once("back-end/create_all.php");
  
  if (!isset($_SESSION['logado']) == FALSE) {
	    // conexão
        $conn = iniciaDB("codexp49_usuarios");
        
        // buscar por foto
        $b_foto_usuario = "SELECT foto FROM users WHERE id = '{$_SESSION['id']}'";
        
        $res_foto_user = $conn -> query($b_foto_usuario);
        $list_foto_user = $res_foto_user -> fetchAll();
        
        foreach ($list_foto_user as $values) {
            $foto_usuario = $values[0];
        }
        
	}

?>
<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	
	<!-- Estilo CSS -->
	<link rel="stylesheet" type="text/css" href="css/sobre.css">
	<link rel="icon" href="img/logo.ico">

	<!--Normalize HTML-->
	<link rel="stylesheet" type="text/css" href="css/normalize.css">
	<title>Codex & Projectu</title>
</head>
<body>
<!--- inicio menu --->
 <header>
    <nav class="navbar navbar-expand-md">
        <div class="container">
         <a href="home.php" class="navbar-brand"><img src="img/logo.png" width="70px"></a>
            <button class="navbar-toggler" data-toggle="collapse" data-target="#menu"><i class="fas fa-bars text-white"></i></button>
         <div class="collapse navbar-collapse" id="menu">
          <ul class="navbar-nav ml-auto">
              <li class="nav-item"><a href="home.php" class="nav-link">Home</a></li>
              <li class="nav-item"><a href="#" class="nav-link">Sobre nós</a></li>
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
						echo "<a href='user/userinterface.php'><img src='user/upload/$foto_usuario' width='40px' style='border-radius: 50%;'></a>";
					}
			  ?></li>
          </ul>
        </div>
        </div>
    </nav>   
   </header>
   <!--- final menu --->
   
     
     <!--- inicio conteúdo --->
			<section id="conteudo"> 
				<div class="container"> 
					<div class="row">
						<div class="col-sm-12 mt-4">
							<h3> Sobre a Codex & Projectu</h3>
							<p>É uma aplicação web e mobile  desenvolvida para facilitar a construção de times de desenvolvedores, possuimos um ambiente integrado que tem por objetivo facilitar  e gerênciar  o seu projeto, além de possuirmos sistemas que facilitam o suporte, gerênciamento e coordenação do seu projeto, temos também um sistema de  busca  por tecnologia, tudo isso é arquitetado  por  categoria de tecnologia e baseado na  utilização da  mesma para construção da sua  <span> API, SOFTWARES, JOGOS</span>  e outros, nós estamos aqui para lhe dar  ajudar a construir a melhor equipe para o desenvolvimento do seu projeto. </p>
						</div>
					</div>
				</div>
				</div>
			</section>


    <!--- final conteúdo --->


   <!---rodapé --->
	 <footer id="rodape" style='margin-top: 22%;'>
		  <img src="img/logo.png" width="70px">Todos os direitos reservados &copy; LilCode Team 2021<br>
		  <ul><li style='display: inline;'><a href='other/politica.php' style='color:white;'>POLÍTICA</a></li> | <li style='display: inline;'><a href='other/termos-uso.php'  style='color:white;'>TERMOS DE USO</a></li></ul>
	 </footer>
	

              


		<!--Boostrap Scrpit links-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>