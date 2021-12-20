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
                    <?php
                    
                        // inclusões
                        include_once("configdb.php");
                        include_once("create_all.php");

                        // conexão
                        $conn = iniciaDB("codexp49_projetos");
                        $conn2 = iniciaDB("codexp49_usuarios");

                        // variáveis
                        $id_proj = $_GET['cod'];

                        // membros
                        $select_membros = "SELECT membros FROM projs WHERE id ='$id_proj'";
                        $res_membros = $conn -> query($select_membros);

                        $list_membros = $res_membros -> fetchALL();

                        foreach ($list_membros as $valores) {
                            $membros = $valores[0];
                        }

                        // buscar informações
                        $buscar = "SELECT * FROM projs WHERE id = '$id_proj'";
                        $res = $conn -> query($buscar);
                        $lista = $res -> fetchAll();

                        foreach ($lista as $values) {
                            $projeto = $values[1];
                            $descricao = $values[2];
                            $criador = $values[3];
                            $langs = $values[6];
                            $oferece = $values[7];
                            $data = $values[8];
                            $dia = substr($data, -2, 2);
                            $mes = substr($data, -5, 2);
                            $ano = substr($data, -10, 4);
                            $data = "{$dia}/{$mes}/{$ano}";

                            // criador
                            $creator = "SELECT nome, foto FROM users WHERE id = '$criador'";
                            $res_creator = $conn2 -> query($creator);
                            $lista_creator = $res_creator -> fetchAll();

                            foreach ($lista_creator as $value_) {
                                $nome_creator = $value_[0];
                                $foto_creator = $value_[1];
                            }

                            echo "<h4>$projeto - $data</h4>
                                Por <img src='../user/upload/$foto_creator' width='26px' style='border-radius: 50%;'> <b><a href='usuario.php?cod=$criador' style='color: white;'>$nome_creator</a></b><br><br>

                                $descricao<br><br>
                                
                                <b>Oferece</b>: $oferece<br>
                                <b>Linguagens Requeridas</b>: $langs<br>
                                <b>* A CP não se responsabiliza por transações monetárias</b><br><br>

                                <hr style='border: 1px solid white;'>

                            ";

                            // Pedidos

                            $aceito = FALSE;

                            // buscar por todos os pedidos
                            $buscar_pedidos = "SELECT * FROM pedidos WHERE proj = '$id_proj'";
                            $res_pedidos = $conn -> query($buscar_pedidos);
                            $list_pedidos = $res_pedidos -> fetchAll();
                            $rows_pedidos = $res_pedidos -> rowCount();

                            echo "Pedidos - $rows_pedidos<br><br>";

                            foreach ($list_pedidos as $pedido) {
                                $id_pedido = $pedido[0];
                                $descricao = $pedido[1];
                                $criador_pedido = $pedido[2];

                                // buscar pelas informações do criador
                                $c_pedido = "SELECT id, nome, foto FROM users WHERE id = '$criador_pedido'";
                                $r_c_pedido = $conn2 -> query($c_pedido);
                                $l_c_pedido = $r_c_pedido -> fetchAll();

                                foreach ($l_c_pedido as $c_valor) {
                                    $id_user = $c_valor[0];
                                    $nome = $c_valor[1];
                                    $foto = $c_valor[2];
                                }

                                if (!isset($_SESSION['id']) == FALSE && $_SESSION['id'] == $criador_pedido) {
                                    echo "<div style='padding: 8px;' class='mb-3'><img src='../user/upload/$foto' width='30px' style='border-radius: 50%;display: inline'> <h6 style='display: inline;'>$nome</h6><br>
                                    <b>A descrição só aparece para você!</b><br>
                                    <p>$descricao</p>
                                    </div>";

                                    $pattern = '/' . $id_user . '/i';
                                    if (preg_match($pattern, $membros) == FALSE) {
                                        
                                        echo "<a href='remove_pedido.php?ped=$id_pedido' style='color: red;'>Remover Pedido</a><br><br>";
                                    } else {
                                        $aceito = TRUE;
                                    }
                                } else {
                                    echo "<div style='padding: 8px;' class='mb-3'><img src='../user/upload/$foto' width='30px' style='border-radius: 50%;display: inline'> <h6 style='display: inline;'>$nome</h6><br>
                                    <b>Informações do pedido privadas</b></div>";
                                }
                            }

                            echo "<a href='../projetos.php'><button class='btn btn-success mr-md-1'>Voltar</button></a>";

                            if (!isset($_SESSION['id']) == FALSE && $_SESSION['id'] == $criador) {
                                echo "<a href='../user/avan/manusear.php?cod=$id_proj&cria=$criador'><button class='btn btn-warning'>Manusear</button></a>";
                            } if ($aceito == TRUE) {
                                echo "<a href='../user/avan/manusear.php?cod=$id_proj&cria=$criador'><button class='btn btn-warning'>Manusear</button></a>";
                            }
                            
                            // buscar por pedido
                            $busca_pedido = "SELECT * FROM pedidos WHERE criador = '{$_SESSION['id']}' AND proj = '$id_proj'";

                            $res_pedido = $conn -> query($busca_pedido);
                            $rows = $res_pedido -> rowCount();

                            if ($rows == 0) {
                                if (!isset($_SESSION['id']) == FALSE && $_SESSION['id'] != $criador) {
                                    echo "<a href='pedir.php?proj=$id_proj'><button class='btn btn-warning'>Pedir para participar</button></a>";
                                }
                            } else if ($rows >= 1 && $aceito == FALSE) {
                                echo "<button class='btn btn-success disabled'>Aguardando Resposta</button>";
                            }

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