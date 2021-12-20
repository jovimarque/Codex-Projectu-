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
                <div id="box" class='mt-4' style='height: 20rem;width:100%;overflow-y: scroll;overflow-x: hidden;position: relative;'>
                    <h2>Meus dados</h2>

                    <hr>

                    <?php

                        // inclusões
						include_once("../back-end/configdb.php");
						include_once("../back-end/create_all.php");

						$id = $_SESSION['id'];
					
						// conexão
						$conn = iniciaDB("codexp49_usuarios");

						// informações básicas
						$busca = "SELECT * FROM users WHERE id = '$id'";

						$res = $conn -> query($busca);
						$lista = $res -> fetchAll();

						foreach ($lista as $value) {
							// campos
							$nome = $value[1];
							$email = $value[2];
							$foto = $value[4];
                            $sobre = $value[5];
                            $habilidades = $value[6];
                            $sexo = $value[7];

                            if ($habilidades == NULL) {
                                $habilidades = "<b>Não preencheu este campo ainda</b>";
                            } if ($sobre == NULL) {
                                $sobre = "<b>Não preencheu este campo ainda</b>";
                            }
						}


                        // formulário de edição
                        if (!isset($_POST['salvar']) == FALSE) {
                            // campos
                            if (!isset($_POST['nome']) == FALSE) {
                                $novo_nome = $_POST['nome'];
                            }
                            if (!isset($_POST['sobre']) == FALSE) {
                                $novo_sobre = $_POST['sobre'];
                            }
                            if (!isset($_POST['habilidades']) == FALSE) {
                                $novas_habilidades = $_POST['habilidades'];
                            }
                            if (!isset($_FILES['foto']) == FALSE) {
                                $nova_foto = $_FILES['foto'];
                            }

                            // palavras indevidas
                            $permitido = TRUE;

                            // Lê o conteúdo do arquivo
                            $filtroname = "../back-end/filtro.txt"; //Filtro contendo a lista de palavras
                            $filtro = file($filtroname); //Arquivo de filtro em array
                            $linhas = count($filtro); //Contamos o número de linhas
                            $texto = "[PROIBIDO]";  //Texto a ser reposto
                            for ($i = $linhas-1; $i>= 0; $i--) //Vamos percorrer a lista
                            {
                                $verificar = @explode(";",$filtro[$i]); //lemos até o;
                                if (preg_match("/$verificar[0]/i", "".trim($novo_nome)."")) {
                                    $novo_nome = substr_replace("/$verificar[0]/i", $texto, 0); //Vamos substituír as palavras pela palavra "[Proibido]"
                                } if (preg_match("/$verificar[0]/i", "".trim($novo_sobre)."")) {
                                    $novo_sobre = substr_replace("/$verificar[0]/i", $texto, 0); //Vamos substituír as palavras pela palavra "[Proibido]"
                                } if (preg_match("/$verificar[0]/i", "".trim($novas_habilidades)."")) {
                                    $novas_habilidades = substr_replace("/$verificar[0]/i", $texto, 0); //Vamos substituír as palavras pela palavra "[Proibido]"
                                }
                            }

                            if ($novo_nome == "[PROIBIDO]" || $novo_sobre == "[PROIBIDO]" || $novas_habilidades == "[PROIBIDO]") {
                                $permitido = FALSE;
                                echo "<script>alert('Um dos campos possui palavras indevidas. Por favor, insira os dados novamente.');</script>";
                            }

                            if ($permitido == TRUE) {
                                // conexão
                                $conn = iniciaDB("codexp49_usuarios");

                                foreach ($_POST as $key => $value) {
                                    if ($key != 'salvar' && $_POST[$key] != "" && $key != "foto") {
                                        $atualizar = "UPDATE users SET $key = :campo WHERE id = '{$_SESSION['id']}'";

                                        $stmt = $conn -> prepare($atualizar);

                                        $stmt -> bindValue(":campo", $_POST[$key]);

                                        // execução
                                        $run = $stmt -> execute();

                                        if ($run == TRUE) {
                                            echo "<script>alert('$key alterado!');</script>";
                                        }
                                    }
                                }
                                if (!isset($_FILES['foto']) == FALSE && $_FILES['foto']['name'] != "") {
                                    if ($_FILES['foto']['type'] == 'image/jpeg' || $_FILES['foto']['type'] == 'image/png') {
                                        // deletar foto anterior
                                        $buscar = "SELECT foto FROM users WHERE id = '{$_SESSION['id']}'";
                                        $res = $conn -> query($buscar);
                                        $lista = $res -> fetchAll();

                                        foreach ($lista as $values) {
                                            $foto = $values[0];
                                        }

                                        unlink('upload/'.$foto);

                                        // colocar nova foto
                                        $extensao = substr(strtolower($_FILES['foto']['name']), -4);
                                        $novo_n_foto = md5(time()) . $extensao;
                                        $diretorio = 'upload/';

                                        move_uploaded_file($_FILES['foto']['tmp_name'], $diretorio.$novo_n_foto);

                                        $query = "UPDATE users SET foto = :foto WHERE id = '{$_SESSION['id']}'";

                                        $stmt = $conn -> prepare($query);

                                        $stmt -> bindValue(':foto', $novo_n_foto);

                                        $run = $stmt -> execute();

                                        if ($run) {
                                           echo "<script>alert('Foto alterada com sucesso!');</script>";
                                        }
                                    } else {
                                        echo "<script>alert('Sua foto tem uma extensão não permitida.');</script>";
                                    } 
                                }
                                echo "<script>window.location.href='userinterface.php';</script>";
                            }
                        }


                        // opção
                        $opc = $_GET['opc'];

                        if ($opc == "see") {
                            echo "Foto: <img src='upload/$foto' width='40px' style='border-radius:50%;'><br>";
                            echo "Nome: $nome<br>";
                            echo "Email: $email<br>";
                            echo "Sobre: $sobre<br>";
                            echo "Habilidades: $habilidades<br>";
                            echo "Sexo: $sexo<br><br>";
                            echo "<a href='userinterface.php'><button class='btn btn-success'>Voltar</button></a>";
                            echo "<a href='?opc=edit'><button class='btn btn-primary ml-2'>Editar</button></a>";
                        } else if ($opc == "edit") {
                            echo "<form method='POST' enctype='multipart/form-data' style='display: inline;'>
                                Foto atual: <img src='upload/$foto' width='40px' style='border-radius:50%;'><br>
                                <input type='file' id='foto' name='foto' style='width: 50%;min-width:180px;'><br><br>

                                <label for='nome'>Nome atual: $nome</label><br>
                                <input type='text' name='nome' id='nome' placeholder='Novo nome' style='padding: 5px;border-radius: 3px; background: none;border: 2px solid white;'><br><br>  
                                
                                <label for='sobre'>Sobre atual: $sobre</label><br>
                                <textarea id='sobre' name='sobre' style='width: 50%;padding: 5px;border-radius: 3px; background: none;border: 2px solid white;' placeholder='Novo sobre'></textarea><br><br>

                                <label for='new_h'>Habilidades atuais: $habilidades</label><br>
                                <input type='text' id='new_h' placeholder='Insira uma nova habilidade' style='padding: 5px;border-radius: 3px; background: none;border: 2px solid white;'><span class='btn btn-primary' onmouseup=addHab()>+</span><br>

                                <input type='text' id='habilidades' name='habilidades' placeholder='Nenhuma habilidade inserida' style='padding: 5px;border-radius: 3px; background: none;border: 2px solid white;' readonly>

                                <hr>

                                <input type='submit' name='salvar' value='Salvar' class='btn btn-success'>

                            </form>";

                            echo "<a href='?opc=see'><button class='btn btn-danger'>Cancelar</button></a>";
                        }
                    ?>
                    
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
	

              
    <!--Scripts-->
    <script>
            var h_array = Array();
            function addHab() {
                let nova_h = document.getElementById("new_h").value;
                let h = document.getElementById('habilidades');

                if (nova_h == "") {
                    alert('Não há habilidades para adicionar');
                } else if (nova_h != "") {
                    h_array.push(nova_h);
                    h.value = h_array;
                }
            }

    </script>

		<!-- Boostrap Script Links -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>