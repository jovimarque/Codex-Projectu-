<?php

	session_start();
	
	// inclusões
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
	<meta
      name="description"
      content="Monte, gerencie e organize a melhor equipe para o seu projeto!"
    />
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

	<!-- Ícone e Estilo CSS -->
	<link rel="stylesheet" type="text/css" href="css/home.css">
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
         <a href="home.html" class="navbar-brand"><img src="img/logo.png" width="70px"></a>
            <button class="navbar-toggler" data-toggle="collapse" data-target="#menu"><i class="fas fa-bars text-white"></i></button>
         <div class="collapse navbar-collapse" id="menu">
          <ul class="navbar-nav ml-auto">
              <li class="nav-item"><a href="#" class="nav-link">Home</a></li>
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
						echo "<a href='user/userinterface.php'><img src='user/upload/$foto_usuario' width='40px' style='border-radius: 50%;'></a>";
					}
			  ?></li>
          </ul>
        </div>
        </div>
    </nav>   
   </header>

   <!--- final menu --->

   <!--- inicio slide --->
   <section id="home" class="d-flex">
       <div class="container align-self-center ">
            <div class="row">
                <div class="col-md-12">
										<div id="carouselHome" data-interval="3000" class="carousel slide" data-ride="carousel">
											<div class="carousel-inner">
												<div class="carousel-item active">
													<h1>MONTE A MELHOR EQUIPE PARA O SEU PROJETO</h1>
												</div>
												<div class="carousel-item">
													<h1>GERENCIE A SUA EQUIPE FACILMENTE</h1>
												</div>
												<div class="carousel-item">
													<h1>PARTICIPE DE UMA EQUIPE</h1>
												</div>
											</div>
                      <?php
                      
                        if (!isset($_SESSION['logado'])) {
                          echo '<a href="cadastro.php" class="btn">Inscrever-se</a>';
                        }

                      ?>
                </div>
            </div>    
       </div>
   </section>
   <!--- final slide --->
   
   <!--- inicio conteúdo --->
    <section id="conteudo">
      <div class="container">
        <div class="row">
          <div class="col-md-6 col-sm-12"> 
            <h2>Organize sua equipe</h2>
            <p>Escolha quem entra e quem sai do projeto de forma simples.</p>

            <h2>Deixe o chat a sua cara!</h2>
            <p>Crie diferentes paineis, para cada informação que queira compartilhar com a sua equipe, de forma simples, e rápida.</p>
               
						<h2>Chat e suas ferramentas</h2>
						<p>Você nem precisa sair da plataforma para conversar, organizar e gerenciar sua equipe! Nosso chat nativo tem tudo que você precisa.</p>

						<h2>Não importa o lugar</h2>
						<p>Tenha todas as ferramentas do site em suas mãos, em qualquer hora, dispositivo e local, tendo a mesma experiência de sempre.</p>
          </div> 
          <div class="col-md-6 "> 
            <img src="img/equipe.png" class="d-sm-block img-fluid mx-auto d-block" width="700" alt='equipe'>
          </div> 
        </div>
      </div>  
    </section>
    <!--- final slide --->
   

   <!---rodapé --->
	 <footer id="rodape">
		  <img src="img/logo.png" width="40px">Todos os direitos reservados &copy; LilCode Team 2021<br>
      <ul><li style='display: inline;'><a href='other/politica.php' style='color:white;'>POLÍTICA</a></li> | <li style='display: inline;'><a href='other/termos-uso.php'  style='color:white;'>TERMOS DE USO</a></li></ul>
	 </footer>
	

              

		<!-- Boostrap Script Links -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>