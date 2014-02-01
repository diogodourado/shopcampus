<?php include('include/header.php'); ?>


<?php if($_POST){

	/*

	);
	 */
	 
 	$item = array(
		'id' 					=> (int) $_POST['id'],
		'nome' 					=> $_POST['nome'],
		'preco' 				=> number_format($_POST['preco'], 2),
		'descricao' 			=> $_POST['descricao'],
		'quantidade' 			=> (int) $_POST['quantidade'],
		'tipo' 					=> $_POST['tipo']
	);
	
	if(isset($_SESSION['carrinho']['itens'][$_POST['id']]) && $_POST['tipo'] == 'produto')
		$_SESSION['carrinho']['itens'][$_POST['id']]['quantidade'] = $_SESSION['carrinho']['itens'][$_POST['id']]['quantidade'] + $_POST['quantidade'];
	else
		$_SESSION['carrinho']['itens'][$_POST['id']] = $item;


}elseif (isset($_GET['r'])) {
	$id = $_GET['r'];

	// remover do carrinho
	unset($_SESSION['carrinho']['itens'][$id]);

	echo " <script>	window.location.href = 'carrinho.php';	</script>";

}

?>

<?php if ( !isset($_SESSION['carrinho']) || (count($_SESSION['carrinho']['itens']) == 0 ) ){?>
	<div class="alert alert-warning">
		<a class="close" data-dismiss="alert">×</a>
		<?php echo 'Seu carrinho está vazio'; ?>
	</div>

	<div style="max-width: 400px; margin: 0 auto 10px;">
		<a href="./" class="btn btn-primary btn-lg">Continuar Comprando</a>
	</div>

<?php }else{ ?>
	

	<?php if ( isset($_SESSION['carrinho']['error']) && (!empty($_SESSION['carrinho']['error']) ) ){
		unset($_SESSION['carrinho']['error']);
		?>
		<div class="alert alert-error">
			<a class="close" data-dismiss="alert">×</a>
			Houve um erro ao processar seu pagamento. Por favor tente mais novamente.
		</div>

	<?php } ?>

	<div class="page-header">
		<h2>Seu carrinho de compras</h2>
	</div>

	<form method="post" action="" id="update_cart_form">
	
		<?php include('carrinho_detalhe.php');?>
		
		
		<div class="row">

			<div class="span3" style="text-align:left;">
				<a class="btn btn-large btn-primary" href="./" >Continuar Comprando </a>
			</div>
					
			<div class="span9" style="text-align:right;">
					
		
					<?php if(!isset( $_SESSION['logado'] ) || !$_SESSION['logado'] ) { ?>
						<form id="form-login" action="login.php">
							<input type="hidden" name="redirect" value="carrinho.php"/>
						</form>
						
				<div class="DireitaBox">
				<form id="form-cadastro" method="post" action="login.php">
					<input type="hidden" name="redirect" value="carrinho.php"/>
					<input class="btn" type="submit"  value="Login"/>
				</form>
				</div>
				<div class="DireitaBox">
				<form id="form-cadastro" method="post" action="cadastro.php">
					<input type="hidden" name="redirect" value="carrinho.php"/>
					<input class="btn" type="submit"  value="Cadastro"/>
				</form>
				</div>

				<style>
				.DireitaBox {
					width: 100px;
					text-align: center;
					float: right;
				}
				</style>
				

						
					<?php } ?>
						
				<?php if (isset($_SESSION['logado']) && $_SESSION['logado']){ ?>
					
					<a href="pay/checkout/checkout.php" style="text-decoration: none;" >
						<img  src="https://www.paypal-brasil.com.br/logocenter/util/img/botao-checkout_horizontal_finalizecom_ap.png" border="0" alt="Finalizar com PayPal" />
					</a>
					<span class="or">ou</span>
					<a class="btn btn-large btn-primary btn-checkout" href="pay/checkout/checkout.php" >FINALIZAR COMPRA </a>

				<?php } ?>
				
			</div>
		</div>

	</form>

<?php } ?>

<?php include('include/footer.php'); ?>