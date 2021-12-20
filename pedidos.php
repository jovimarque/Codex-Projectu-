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
						echo "<a href='../user/userinterface.php'>FOTO AQUI</a>";
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
                    <h2>Pedidos</h2>

                    <hr>

                    <?php

                        // inclusões
                        include_once("create_all.php");
                        include_once("configdb.php");

                        // conexão
                        $conn = iniciaDB("codexp49_projetos");
                        $conn_user = iniciaDB("codexp49_usuarios");

                        // variáveis
                        $projeto = $_GET['proj'];

                        // buscar pedidos
                        $search = "SELECT * FROM pedidos WHERE proj = '$projeto'";
                        $res = $conn -> query($search);
                        $lista = $res -> fetchAll();

                        // membros
                        $select_membros = "SELECT membros FROM projs WHERE id ='$projeto'";
                        $res_membros = $conn -> query($select_membros);

                        $list_membros = $res_membros -> fetchALL();

                        foreach ($list_membros as $valores) {
                            $membros = $valores[0];
                        }

                        foreach ($lista as $pedido) {
                            $descricao = $pedido[1];
                            $criador_pedido = $pedido[2];

                            // informações do usuário
                            $search_u = "SELECT id, nome, foto FROM users WHERE id = '$criador_pedido'";
                            $res_u = $conn_user -> query($search_u);
                            $lista_u = $res_u -> fetchAll();

                            foreach ($lista_u as $dado) {
                                $id_user = $dado[0];
                                $nome = $dado[1];
                                $foto = $dado[2];
                            }

                            $pattern = '/' . $id_user . '/i';
                            if (preg_match($pattern, $membros)) {
                                echo "<div style='padding: 8px;'>
                                <img src='../user/upload/$foto' width='30px' style='border-radius: 50%;display: inline'> <h6 style='display: inline;'><a href='usuario.php?cod=$id_user' style='color: white;'>$nome</a></h6><br><br>

                                <p>$descricao</p>

                                <b>Membro já aceito no projeto</b>
                                </div>";
                            } else {
                                echo "<div style='padding: 8px;'>
                                <img src='../user/upload/$foto' width='30px' style='border-radius: 50%;display: inline'> <h6 style='display: inline;'>$nome</h6><br><br>

                                <p>$descricao</p>

                                <form method='POST'>
                                    <input type='submit' class='btn btn-success' name='aceitar' value='Aceitar Membro'>
                                </form>
                                </div>";
                            }
                        }

                        // aceitar membro
                        if (!isset($_POST['aceitar']) == FALSE) {
                            // update
                            $update = "UPDATE projs SET membros = CONCAT(membros, ', ', $id_user), num_membros = num_membros + 1 WHERE id = '$projeto'";

                            $run = $conn -> query ($update);

                            if ($run) {
                                echo "<script>alert('Membro '$nome' aceito!');</script>";
                                echo "<script>window.history.back();</script>";
                            }
                            
                        }
                    
                    ?>

                    <hr>
                    
                    <a href='../user/meus_proj.php'><button class='btn btn-success mr-3'>Voltar</button></a>
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
