<?php

	session_start();

?>
<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

	<!-- Ícone e Estilo CSS-->
	<link rel="icon" href="img/logo.ico">
	<link rel="stylesheet" type="text/css" href="css/cadastro.css">
	<title>Codex & Projectu</title>
</head>
<body>
 <!-- Início Header -->
	<header>
		<nav class="navbar navbar-expand-md">
			<div class="container">
			 <a href="" class="navbar-brand"><img src="img/logo.png" width="50px"></a>
				<button class="navbar-toggler" data-toggle="collapse" data-target="#menu"><i class="fas fa-bars text-white"></i></button>
			 <div class="collapse navbar-collapse" id="menu">
			  <ul class="navbar-nav ml-auto">
				  <li class="nav-item"><a href="home.php" class="nav-link">Home</a></li>
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
						echo "<a href='user/userinterface.php'>FOTO AQUI</a>";
					}
			  ?></li>
			  </ul>
			</div>
			</div>
		</nav>   
	</header>
	<!-- Fim Header -->

	<!-- Início Conteúdo -->
    <div class="container">
      	<div class="row">
			<div class='col-sm-12'>
				<div class="box mt-4" style='height: 20rem;width: 20rem;position: relative;'>
					<?php
					
						if (!isset($_POST['cadastrar']) == FALSE) {
							// inclusões
							include_once("back-end/configdb.php");
							include_once("back-end/create_all.php");

							// conexão
							$conn = iniciaDB("codexp49_usuarios");

							// campos
							$nome = $_POST['nome'];
							$email = $_POST['email'];
							$sexo = $_POST['sexo'];
							$senha = $_POST['senha'];
							$c_senha = $_POST['c-senha'];
							$length = 78;
							$token = bin2hex(random_bytes($length));
							
                            if ($sexo != "homem" && $sexo != "mulher" && $sexo != "outro") {
                                echo "<script>alert('Sexo inválido.');</script>";
                                echo "<script>window.location.href='home.php';</script>";
                            }

							// verificar se campos estão vazios
							if (!isset($nome) == TRUE || !isset($email) == TRUE || !isset($sexo) == TRUE || !isset($senha) == TRUE || !isset($c_senha) == TRUE) {
								echo "<script>alert('Todos os campos são requeridos.');</script>";
							} else {
								// verificar o tamanho da senha
								if (strlen($senha) < 8) {
									echo "<script>alert('Senha pequena demais, é necessário que ela tenha 8 ou mais caracteres.');</script>";
								} else if (strlen($senha >= 8)) {

									// verificar termos do nome
									
									$permitido = TRUE;

									// Lê o conteúdo do arquivo
									$filtroname = "back-end/filtro.txt"; //Filtro contendo a lista de palavras
									$filtro = file($filtroname); //Arquivo de filtro em array
									$linhas = count($filtro); //Contamos o número de linhas
									$texto = "[PROIBIDO]";  //Texto a ser reposto
									$fraselimpa = $nome; //Texto limpo vindo do formulário
									$frase = '';
									for ($i = $linhas-1; $i>= 0; $i--) //Vamos percorrer a lista
									{
										$verificar = @explode(";",$filtro[$i]); //lemos até o;
										if (preg_match("/$verificar[0]/i", "".trim($nome)."")) {
											$frase = substr_replace("/$verificar[0]/i", $texto, 0); //Vamos substituír as palavras pela palavra "[Proibido]"
										}
									}

									if ($frase == "[PROIBIDO]") {
										$permitido = FALSE;
										echo "<script>alert('Seu nome contém palavras indevidas.');</script>";
									}

									if ($permitido) {
										// verificar confirmação de senha
										if ($senha === $c_senha) {
											// busca
											$busca = "SELECT * FROM users WHERE email = :email AND senha = :senha";

											$stmt = $conn -> prepare($busca);
											
											$stmt -> bindValue(':email', $email);
											$stmt -> bindValue(':senha', md5($senha));

											$stmt -> execute();

											$rows = $stmt -> rowCount();

											if ($rows == 0) {

												// execução
												$query = "INSERT INTO users (nome, email, senha, sexo, estado, token, foto) VALUES (:nome, :email, :senha, :sexo, :estado, :token, :foto);";

												$stmt = $conn -> prepare($query);

												$stmt -> bindValue(':nome', $nome);
												$stmt -> bindValue(':email', $email);
												$stmt -> bindValue(':senha', md5($senha));
												$stmt -> bindValue(':sexo', $sexo);
												$stmt -> bindValue(':estado', 'Em análise');
												$stmt -> bindValue(':token', $token);
												$stmt -> bindValue(':foto', 'default.jpg');

												$run = $stmt -> execute();

												// buscar ID
												$buscar_id = "SELECT id FROM users WHERE email = :email";
												$stmt = $conn -> prepare($buscar_id);

												$stmt -> bindValue(":email", $email);

												$stmt -> execute();

												$lista = $stmt -> fetchAll();

												foreach ($lista as $value) {
													$id = $value[0];
												}

												if ($run) {
													echo "<script>alert('Usuário cadastrado com sucesso! Confirme o seu email!');</script>";
													$_SESSION['id'] = $id;
													echo "<script>window.location.href='other/confirmMail.php';</script>";
												} else {
													echo "<script>alert('Confirmação de senha incorreta.');</script>";
												}
											} else if ($rows >= 1) {
												echo "<script>alert('Já existe um usuário com esse email ($email). Utilize outro.');</script>";
											}

										} else {
											echo "<script>alert('Confirmação de senha incorreta!');</script>";
										}
									}
								}
							}
						}
					
					?>
					<h2>Cadastro</h2>
					<form method="POST">

						<input type="text"  name="nome" placeholder="Seu Nome Completo" required><br>

						<span>Homem <input type="radio" name="sexo" value="homem" style="margin-right: 7px;"  required></span>
						<span>Mulher <input type="radio" id="mulher" name="sexo" value="mulher" style="margin-right: 7px;"></span>
						<span>Outro <input type="radio" name="sexo" value="outro"></span>

						<input type="email" name="email" placeholder="Digite o seu email" required>
						<br>
						<input type="password" name="senha" placeholder="Digite a sua senha" id="senha" onkeyup=ForcaSenha() required>
						<br>
						<input type="password" name="c-senha" placeholder="Digite a sua senha" id="c-senha" onkeyup=ConfirmationSenha() required>
						<span id="status">Status</span>
						<input type="submit" value="Cadastrar" name='cadastrar' id='cadastrar'>
						
						
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- Fim Header -->

	 
	 <!-- Rodapé -->
	 <footer id="rodape" class='p-0' style='margin-top: 22%;'>
		Todos os direitos reservados &copy; LilCode Team 2021<br>
		<ul><li style='display: inline;'><a href='other/politica.php' style='color:white;'>POLÍTICA</a></li> | <li style='display: inline;'><a href='other/termos-uso.php'  style='color:white;'>TERMOS DE USO</a></li></ul>
	 </footer>
	

              

		<!-- Boostrap Script Links -->
		<script src="js/cadastro.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
