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
         <a href="home.php" class="navbar-brand"><img src="img/logo.png" width="70px"></a>
            <button class="navbar-toggler" data-toggle="collapse" data-target="#menu"><i class="fas fa-bars text-white"></i></button>
         <div class="collapse navbar-collapse" id="menu">
          <ul class="navbar-nav ml-auto">
              <li class="nav-item"><a href="home.php" class="nav-link">Home</a></li>
              <li class="nav-item"><a href="sobre.php" class="nav-link">Sobre nós</a></li>
              <li class="nav-item"><a href="#" class="nav-link">Projetos</a></li>
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
    <section id="conteudo" style='margin-top: 30px;'>
      <div class="container">
        <div class="row">
          <div class="col-md-3 col-sm-12 mb-4"> 
            <form method='GET' style='background: rgb(173, 45, 233);padding: 20px;border-radius: 4px;color: white;' action='projetos.php'>
                <label for='order'>Ordenar</label><br>
                <select id='order' name='order' style='max-width: 100%;'>
                  <option value='none'>- Selecione -</option>
                  <option value='m-recente'>Mais recente</option>
                  <option value='mi-recente'>Menos recente</option>
                  <option value='mi-pedidos'>Menos pedidos</option>
                  <option value='m-pedidos'>Mais pedidos</option>
                </select>

                <hr>

                <input type='submit' value='Aplicar' class="btn btn-outline-light">
            </form>
          </div> 
          <div class="col-md-8 col-sm-12" style='overflox-y: scroll;overflow-x: none;'>
            <?php

              if (!isset($_SESSION['logado']) == FALSE) {
                echo "<a href='user/novo_proj.php'><button class='btn btn-success'>Criar Projeto</button></a> - <b>Crie um projeto! É de graça!</b><br><br>";
              }

              // conexão
              $conn = iniciaDB("codexp49_projetos");

              // buscar projetos
              $buscar = "SELECT * FROM projs";
              $res = $conn -> query($buscar);
              $lista = $res -> fetchAll();
              $quantia = $res -> rowCount();

              if ($quantia == 0) {
                echo "<h2>Sem projetos no momento.</h2>";
              } else if ($quantia >= 1) {
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
                    echo "<div style='padding: 5px; border-top: 1px solid black; border-bottom: 1px solid black;'>
                    <h5>$nome_proj - $data_de_criacao</h5>
                    Descrição: $descricao<br>
                    Espaços: $num_membros/$max_membros<br>
                    Langs: $langs<br><br>

                    <a href='back-end/projeto.php?cod=$id_proj'><button class='btn btn-primary'>Ver Mais</button></a>
                    </div>";
                  }
                }
              }
            ?>
          </div> 
        </div>
      </div>  
    </section>
    <!--- final slide --->
   

   <!---rodapé --->
	 <footer id="rodape" style='margin-top: 22%;'>
		  <img src="img/logo.png" width="40px">Todos os direitos reservados &copy; LilCode Team 2021<br>
      <ul><li style='display: inline;'><a href='other/politica.php' style='color:white;'>POLÍTICA</a></li> | <li style='display: inline;'><a href='other/termos-uso.php'  style='color:white;'>TERMOS DE USO</a></li></ul>
	 </footer>
	

              
  
		<!-- Boostrap Script Links -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>