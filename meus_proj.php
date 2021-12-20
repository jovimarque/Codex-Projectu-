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
						echo "<a href='userinterface.php'>FOTO AQUI</a>";
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
          <h5>Meus Projetos</h5>

          <?php
          
            // inclusões
            include_once("../back-end/configdb.php");
            include_once("../back-end/create_all.php");

            // conexão
            $conn = iniciaDB("codexp49_projetos");

            // variáveis
            $id = $_SESSION['id'];

            // buscar
            $busca = "SELECT * FROM projs WHERE criador = '$id'";
            $res = $conn -> query($busca);
            $lista = $res -> fetchAll();

            foreach ($lista as $valores) {
              // variáveis
              $id_proj = $valores[0];
              $nome_proj = $valores[1];
              $descricao = $valores[2];
              $descricao = substr($descricao, 0, 35) . "...";
              $criador = $valores[3];
              $max_membros = $valores[4];
              $num_membros = $valores[9];
              $langs = $valores[6];
              $data_de_criacao = $valores[8];
              $dia = substr($data_de_criacao, -2, 2);
              $mes = substr($data_de_criacao, -5, 2);
              $ano = substr($data_de_criacao, -10, 4);
              $data_de_criacao = "{$dia}/{$mes}/{$ano}";
              $estado = $valores[10];

              if ($estado == "aberto") {
                echo "<div style='padding: 5px; border-top: 1px solid white; border-bottom: 1px solid white;'>
                <h5>$nome_proj - $data_de_criacao (Aberto)</h5>
                Descrição: $descricao<br>
                Espaços: $num_membros/$max_membros<br>
                Langs: $langs<br><br>

                <a href='../back-end/projeto.php?cod=$id_proj'><button class='btn btn-primary'>Ver Mais</button></a>
                <a href='avan/manusear.php?cod=$id_proj&cria=$criador'><button class='btn btn-warning'>Manusear</button></a>";

                if ($_SESSION['id'] == $criador) {
                  echo "<a href='../back-end/fin_proj.php?cod=$id_proj&cria=$criador'><button class='btn btn-light mt-sm-3 mt-md-0 ml-md-1'>Finalizar Projeto</button></a>
                  <a href='avan/confirmpage.php?k=p&proj=$id_proj'><button class='btn btn-danger mt-sm-3 mt-md-0 ml-md-2'>Excluir Projeto</button></a>
                  <a href='../back-end/pedidos.php?proj=$id_proj'><button class='btn btn-light mt-sm-3 mt-md-0 ml-md-1'>Ver pedidos</button></a>
                  </div>";
                }
              } else if ($estado == "fechado") {
                echo "<div style='padding: 5px; border-top: 1px solid white; border-bottom: 1px solid white;'>
                <h5>$nome_proj - $data_de_criacao (Fechado)</h5>
                Descrição: $descricao<br>
                Espaços: $num_membros/$max_membros<br>
                Langs: $langs<br><br>

                <a href='../back-end/projeto.php?cod=$id_proj'><button class='btn btn-primary'>Ver Mais</button></a>
                <a href='avan/manusear.php?cod=$id_proj&cria=$criador'><button class='btn btn-warning'>Manusear</button></a>";

                if ($_SESSION['id'] == $criador) {
                  echo "<a href='avan/confirmpage.php?k=p&proj=$id_proj'><button class='btn btn-danger mt-sm-3 mt-md-0 ml-md-2'>Excluir Projeto</button></a>
                  </div>";
                }
              }
            }
          ?>

          <hr style='border: 1px solid white'>

          <h5>Projetos em que faço parte</h5>

          <?php
          
            // buscar projetos
            $search_projects = "SELECT * FROM projs";
            $res_projects = $conn -> query($search_projects);
            $list_projects = $res_projects -> fetchAll();

            foreach ($list_projects as $project) {
              // variáveis
              $id_proj = $project[0];
              $nome_proj = $project[1];
              $descricao = $project[2];
              $descricao = substr($descricao, 0, 35) . "...";
              $criador = $project[3];
              $max_membros = $project[4];
              $membros = $project[5];
              $num_membros = $project[9];
              $langs = $project[6];
              $data_de_criacao = $project[8];
              $dia = substr($data_de_criacao, -2, 2);
              $mes = substr($data_de_criacao, -5, 2);
              $ano = substr($data_de_criacao, -10, 4);
              $data_de_criacao = "{$dia}/{$mes}/{$ano}";
              $estado = $project[10];

              $termo = '/' . $_SESSION['id'] . '/i';

              if (preg_match($termo, $membros)) {
                echo "<div style='padding: 5px; border-top: 1px solid white; border-bottom: 1px solid white;'>
                <h5>$nome_proj - $data_de_criacao ($estado)</h5>
                Descrição: $descricao<br>
                Espaços: $num_membros/$max_membros<br>
                Langs: $langs<br><br>

                <a href='../back-end/projeto.php?cod=$id_proj'><button class='btn btn-primary'>Ver Mais</button></a>
                <a href='avan/manusear.php?cod=$id_proj&cria=$criador'><button class='btn btn-warning'>Manusear</button></a></div>"; 
              }
            }
          
          ?>

          <a href='userinterface.php'><button class='btn btn-success mr-3 mt-4'>Voltar</button></a>
	      </div>
      </div>
    </div>
  </div>
	<!-- Final Conteúdo -->
 
   

   <!---rodapé --->
	 <footer id="rodape" style='margin-top: 22%;' class='p-0'>
		  <img src="../img/logo.png" width="40px">Todos os direitos reservados &copy; LilCode Team 2021<br>
		  <ul><li style='display: inline;'><a href='../other/politica.php' style='color:white;'>POLÍTICA</a></li> | <li style='display: inline;'><a href='../other/termos-uso.php'  style='color:white;'>TERMOS DE USO</a></li></ul>
	 </footer>

		<!-- Boostrap Script Links -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>