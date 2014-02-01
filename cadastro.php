<?php include('include/header.php'); ?>

<?php  
// já está logado redireciona para a home
	if(isset($_SESSION['logado']) && $_SESSION['logado'])
	{
		echo "<script> window.location.href = 'index.php'; </script>";
	}
		

	// form submetido trata o login
	if(isset($_POST['submitted'])){
		// processa login e redireciona
		$nome  = addslashes($_POST['nome']);
		$email = addslashes($_POST['email']);
		$senha = md5(addslashes($_POST['senha']));

		$query = mysql_query(" insert into usuarios (nome, email, senha) values ('".$nome."', '".$email."', '".$senha."') ");

		$id = mysql_insert_id();

		if($query){
			$query = mysql_query("select * from usuarios where id = ".$id);
			$user = mysql_fetch_array($query);

			$_SESSION['usuario'] = $user;
			$_SESSION['logado']  = true;

			if(isset($_POST['redirect']) && !$_POST['redirect'])
				echo "<script> window.location.href = '".$_POST['redirect']."'; </script>";
			else
				echo " <script> window.location.href = 'index.php'; </script>";

		}else{
			$error = "Error ao cadastrar";
		}

	}
?>


<?php if(!empty($error)) { ?>

	<div class="alert alert-error">
		<a class="close" data-dismiss="alert">×</a>
		<?php echo $error; ?>
	</div>

<?php } ?>

<div class="row" style="margin-top:50px;">
	<div class="span6 offset3">
		<div class="page-header">
			<h1>Cadastro</h1>
		</div>
		<form accept-charset="utf-8" method="post" action="cadastro.php">
			<input type="hidden" name="submitted" value="submitted" />
			<input type="hidden" value="<?php echo isset($_POST['redirect']) ? $_POST['redirect'] : ''; ?>" name="redirect"/>

			<fieldset>
				<div class="row">
					<div class="span6">
						<label for="nome">Nome</label>
						<input class="span6" type="text" name="nome" placeholder="Seu nome" required>
					</div>
				</div>
				<div class="row">	
					<div class="span3">
						<label for="email">Email</label>
						<input class="span3" type="text" name="email" placeholder="Seu email" required>
					</div>
				
					<div class="span3">
						<label for="senha">Senha</label>
						<input class="span3" type="password" name="senha" placeholder="Informe uma senha" required>
					</div>
				</div>
			
				
				<input type="submit" value="Cadastrar" class="btn btn-primary" />
			</fieldset>
		</form>
	
		<div style="text-align:center;">
			<a href="login.php">Ir para login</a>
		</div>
	</div>
</div>
<?php include('include/footer.php'); ?>