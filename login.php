<?php include('include/header.php'); ?>

<?php 
	// request para fazer logout
	if(isset($_GET['p'])){
		if($_GET['p'] == 'sair'){
			session_destroy();
			echo " <script> windows.location = 'index.php'; </script>";
		}
	}

	// já está logado redireciona para a home
	if(isset($_SESSION['logado']) && $_SESSION['logado']){

		if (count($_SESSION['carrinho']['itens'])>0) {
			echo " <script> window.location.href = 'carrinho.php'; </script>";
		} else {
			echo " <script> window.location.href = 'index.php'; </script>";
		}

	}
		
		

	// form submetido trata o login
	if(isset($_POST['submitted'])){
		// processa login e redireciona
		$email = addslashes($_POST['email']);
		$senha = md5(addslashes($_POST['password']));

		$query = mysql_query("select * from usuarios where email like '".$email."'  and senha like '".$senha."' ");

		$user = mysql_fetch_array($query);

		if($user){
			#do ....
			$_SESSION['logado'] = true;
			$_SESSION['usuario'] = $user;

			if(isset($_POST['redirect'])  && !$_POST['redirect'] )
				echo "<script> window.location.href = '".$_POST['redirect']."'; </script>";
			else
				echo " <script> window.location.href = 'index.php'; </script>";
			
		}else{
			$_SESSION['error'] = 1;
		}
	}

?>

<?php if ( isset($_SESSION['error']) && (!empty($_SESSION['error']) ) ){
	unset($_SESSION['error']);
	?>
	<div class="alert alert-error">
		<a class="close" data-dismiss="alert">×</a>
		Houve um erro ao processar login. Por favor verifique e tente novamente.
	</div>

<?php } ?>

<div class="row" style="margin-top:50px;">
	<div class="span6 offset3">
		<div class="page-header">
			<h1>Acesse sua conta</h1>
		</div>
			
			<form action="" method="post" class="form-horizontal">
				<fieldset>
				
					<div class="control-group">
						<label class="control-label" for="email">Email:</label>
						<div class="controls">
							<input type="text" name="email" class="span3"/>
						</div>
					</div>
				
					<div class="control-group">
						<label class="control-label" for="password">Senha:</label>
						<div class="controls">
							<input type="password" name="password" class="span3"/>
						</div>
					</div>
				
					<div class="control-group">
						<label class="control-label"></label>
						<div class="controls">
							<label class="checkbox">
								<input name="remember" value="true" type="checkbox" />
								 Mantenha-me logado
							</label>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="password"></label>
						<div class="controls">
							<input type="submit" value="Login" name="submit" class="btn btn-primary"/>
						</div>
					</div>
				</fieldset>
				
				<input type="hidden" value="<?php echo isset($_POST['redirect']) ? $_POST['redirect'] : ''; ?>" name="redirect"/>
				<input type="hidden" value="submitted" name="submitted"/>
				
			</form>

			<div style="text-align:center;">
				<a href="cadastro.php">Cadastrar</a>
			</div>
		
			
	</div>
</div>


<?php include('include/footer.php'); ?>