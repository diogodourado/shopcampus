<?php

 session_start();

 include_once 'include/db.php';



 ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>SHOP Online</title>


<meta name="Keywords" content="SHOP Shopping Cart, eCommerce">
<meta name="Description" content="SHOP Online... era tudo que os mineiros precisavam!">

<link href="assets/css/bootstrap.min.css" type="text/css" rel="stylesheet" />
<link href="assets/css/bootstrap-responsive.min.css" type="text/css" rel="stylesheet" />
<link href="assets/css/styles.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="assets/js/jquery.js"></script>
<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/js/squard.js"></script>
<script type="text/javascript" src="assets/js/equal_heights.js"></script>

<script type="text/javascript">
        
        $(document).ready(function(){
            $('.product').equalHeights();

            //$('.responsiveImage').squard('300', $('#primary-img'));

        });

        
    </script>

</head>

<body>
	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">

				<!-- .btn-navbar is used as the toggle for collapsed navbar content -->
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
			
				<a class="brand" href="./">Open Shop Campus</a>
				
				<div class="nav-collapse">
					<ul class="nav">
						
						<!-- <li>
							<a href="fale-conosco.php">Fale Conosco</a>
						</li> -->
								
					</ul>
					
					<ul class="nav pull-right">
							<?php if(isset($_SESSION['logado']) && $_SESSION['logado']){ ?>
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $_SESSION['usuario']['nome'] ?> <b class="caret"></b></a>
									<ul class="dropdown-menu">
										<li><a href="conta.php">Meus Pedidos</a></li>
										<li class="divider"></li>
										<li><a href="login.php?p=sair">Sair</a></li>
									</ul>
								</li>
							<?php }else{ ?>
								<li><a href="login.php">Login</a></li>
							<?php } ?>
							<li>
								<a href="carrinho.php">
									<?php 

										if (!isset($_SESSION['carrinho'])  || (count($_SESSION['carrinho']['itens']) == 0) ) {
											echo 'Seu carrinho está vazio!';
										}else {
											echo count($_SESSION['carrinho']['itens']).' iten(s) no seu carrinho!';
										}

									?>
									
								</a>
							</li>
					</ul>
					
					<form action="search.php" class="navbar-search pull-right" method="post" accept-charset="utf-8">						<input type="text" name="term" class="search-query span2" placeholder="Pesquisar"/>
					</form>
				</div>
			</div>
		</div>
	</div>
	
	<div class="container">
			<!-- <div class="row">
				<div class="span12">
					<ul class="breadcrumb">
						<li>Início</li>
 					</ul>
				</div>
			</div> -->
		
		<?php if (isset($_SESSION['message'])){?>
			<div class="alert alert-info">
				<a class="close" data-dismiss="alert">×</a>
				<?php echo $_SESSION['message']; $_SESSION['message'] = NULL; ?>
			</div>
		<?php } ?>
		
		<?php if (isset($_SESSION['messerrorage'])){?>
			<div class="alert alert-error">
				<a class="close" data-dismiss="alert">×</a>
				<?php echo $_SESSION['error']; $_SESSION['error'] = NULL; ?>
			</div>
		<?php } ?>
		
		

<?php
/*
End header.php file
*/