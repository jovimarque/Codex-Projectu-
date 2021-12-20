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

                if (!isset($_SESSION['logado']) && !isset($_SESSION['email'])) {
                  echo '<li class="nav-item"><a href="cadastro.php" class="nav-link">Inscrever-se</a></li>';
                }

            ?>
			<li class="nav-item">
				<?php
					if (!isset($_SESSION['logado']) && !isset($_SESSION['email'])) {
						echo '<a href="entrar.php" class="btn btn-outline-light">Entrar</a>';
					} else if ($_SESSION['logado'] == "true") {
						$foto = $_SESSION['foto'];
						echo "<a href='userinterface.php'><img src='../back-end/web/$foto' width='40px' height='40px'style='border-radius: 50%;'/></a>";
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
	<div id="box" style='max-height: 450px;width:70%;min-width: 230px;overflow-y: scroll;overflow-x: none;'>
        <?php
            $proj = $_GET['proj'];
            $criador = $_GET['criador'];

            echo "<h2>Pedido - $proj</h2>";
            echo "<hr>";

            if (!isset($_SESSION['logado'])) {
                echo "<h2>Você precisa estar logado para realizar um pedido!</h2>";
            } else if ($_SESSION['logado'] == "true") {
                $user = $_SESSION['nome'];
                echo "
                    <form method='POST' action='../back-end/projects/pedir.php?proj=$proj&user=$user&criador=$criador'>
                        <label for='descricao'>Descreva seu pedido</label><br>
                        <textarea id='descricao' name='descricao' style='width: 50%;' required></textarea><br><br>

                        <b>* Não compartilhe suas informações pessoais (conta bancária, número para contato...etc) até que seja aceito</b><br><br>

                        <input type='submit' value='Pedir' class='btn btn-warning'>
                    </form>
                ";
            }
        ?>

        <hr>
		
		<a href='../projetos.php'><button class='btn btn-success mr-3'>Voltar</button></a>
	</div>
	<!-- Final Conteúdo -->
 
   

   <!---rodapé --->
	 <footer id="rodape" style='margin-top: 22%;'>
		  <img src="../img/logo.png" width="40px">Todos os direitos reservados &copy; LilCode Team 2021<br>
		  <ul><li style='display: inline;'><a href='../other/politica.php' style='color:white;'>POLÍTICA</a></li> | <li style='display: inline;'><a href='../other/termos-uso.php'  style='color:white;'>TERMOS DE USO</a></li></ul>
	 </footer>

		<!-- Boostrap Script Links -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>