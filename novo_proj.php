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
                    <h2>Novo Projeto</h2>

                    <hr>
                    <?php
                        // inclusões
                        include_once('../back-end/configdb.php');
                        include_once('../back-end/create_all.php');

                        if (!isset($_SESSION['logado'])) {
                            echo "<h2>Você precisa estar logado para criar um projeto!</h2>";
                        } else if ($_SESSION['logado'] == "true") {
                            if (!isset($_POST['criar']) == FALSE) {
                                // conexão
                                $conn = iniciaDB("codexp49_projetos");

                                // variáveis
                                $nome = $_POST['nome'];
                                $desc = $_POST['descricao'];
                                $max_membros = $_POST['max-membros'];
                                $langs = $_POST['langs'];
                                $oferece = $_POST['oferece'];
                                $data = date('y/m/d');

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
                                    if (preg_match("/$verificar[0]/i", "".trim($nome)."")) {
                                        $novo_nome = substr_replace("/$verificar[0]/i", $texto, 0); //Vamos substituír as palavras pela palavra "[Proibido]"
                                        $permitido = FALSE;
                                    } if (preg_match("/$verificar[0]/i", "".trim($desc)."")) {
                                        $novo_sobre = substr_replace("/$verificar[0]/i", $texto, 0); //Vamos substituír as palavras pela palavra "[Proibido]"
                                        $permitido = FALSE;
                                    } if (preg_match("/$verificar[0]/i", "".trim($langs)."")) {
                                        $novas_habilidades = substr_replace("/$verificar[0]/i", $texto, 0); //Vamos substituír as palavras pela palavra "[Proibido]"
                                        $permitido = FALSE;
                                    } if (preg_match("/$verificar[0]/i", "".trim($oferece)."")) {
                                        $novas_habilidades = substr_replace("/$verificar[0]/i", $texto, 0); //Vamos substituír as palavras pela palavra "[Proibido]"
                                        $permitido = FALSE;
                                    }
                                }

                                if ($permitido == FALSE) {
                                    echo "<script>alert('Um dos campos contém palavras indevidas. Por favor, insira as informações novamente.');</script>";
                                } else if ($permitido == TRUE) {
                                    // inserção
                                    $insert = "INSERT INTO projs (nome, descricao, max_membros, langs, oferece, data_de_criacao, criador, membros, estado) VALUES (:nome, :descricao, :max_membros, :langs, :oferece, :data_de_criacao, :criador, ' ', 'aberto');";

                                    $stmt = $conn -> prepare($insert);

                                    $stmt -> bindValue(":nome", $nome);
                                    $stmt -> bindValue(":descricao", $desc);
                                    $stmt -> bindValue(":max_membros", $max_membros);
                                    $stmt -> bindValue(":langs", $langs);
                                    $stmt -> bindValue(":oferece", $oferece);
                                    $stmt -> bindValue(":data_de_criacao", $data);
                                    $stmt -> bindValue(":criador", $_SESSION['id']);

                                    // execução
                                    $run = $stmt -> execute();

                                    if ($run) {
                                        echo "<script>alert('Seu projeto foi criado com sucesso!');</script>";
                                        echo "<script>window.location.href='meus_proj.php';</script>";
                                    } else {
                                        echo "<script>alert('Ocorreu um erro ao criar o projeto.');</script>";
                                    }
                                }
                            }

                            echo "<form method='POST'>
                            <label for='nome'>Nome do projeto</label><br>
                            <input type='text' name='nome' style='padding: 5px;border-radius:4px;background: none;border: 2px solid white;color: white;' id='nome' placeholder='Ex: App para celular' required><br><br>

                            <label for='descricao'>Descrição do projeto</label><br>
                            <textarea id='descricao' name='descricao' style='width: 50%;' required></textarea><br><br>

                            <label for='max-membros'>Número máximo de membros</label><br>
                            <select id='max-membros' name='max-membros'>
                                <option value='none'>- Selecione -</option>
                                <option value='2'>2</option>
                                <option value='4'>4</option>
                                <option value='6'>6</option>
                                <option value='8'>8</option>
                            </select><br><br>
                            
                            <label for='s-langs'>Linguagens requeridas</label><br>
                            <select id='s-langs' required>
                                <option value='none'>- Selecione -</option>
                                <option value='php'>PHP</option>
                                <option value='js'>JavaScript</option>
                                <option value='html'>HTML</option>
                                <option value='css'>CSS</option>
                                <option value='python'>Python</option>
                                <option value='cpp'>C++</option>
                                <option value='csharp'>C#</option>
                                <option value='c'>C</option>
                                <option value='dart'>Dart</option>
                                <option value='swift'>Swift</option>
                                <option value='java'>Java</option>
                            </select><span class='btn btn-primary ml-sm-3' onclick=addLangF()>+</span><br><br>

                            <input type='text' id='langs' name='langs' style='padding: 5px;border-radius:4px;background: none;border: 2px solid white;color: white;' placeholder='Nenhuma linguagem escolhida' readonly required><br><br>

                            <label for='oferece'>O que tenho a oferecer</label><br>
                            <input type='text' name='oferece' style='padding: 5px;border-radius:4px;background: none;border: 2px solid white;color: white;' id='oferece' placeholder='Ex: Divisão dos lucros' required><br><br>

                            <input type='submit' class='btn btn-success' name='criar' value='Criar Projeto'>
                        </form>";
                        }
                    ?>

                    <hr>
                    
                    <a href='../projetos.php'><button class='btn btn-success mr-3'>Voltar</button></a>
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

    <!--Scripts-->
    <script>
        var langs_s = Array();
        function addLangF() {
            let s_langs = document.getElementById('s-langs');
            let langs = document.getElementById('langs');

            if (s_langs.value == "none") {
                alert('Não há linguagens selecionadas para adicionar.');
            } else if (s_langs.value != "none") {
                langs_s.push(s_langs.value);
                langs.value = langs_s;
            }
        }

    </script>

		<!-- Boostrap Script Links -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>