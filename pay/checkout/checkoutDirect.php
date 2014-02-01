<?php 
session_start();
require '../../include/paypal2.php';
include_once '../../include/db.php';

unset($_SESSION['carrinho']);


    $produtoId = (int) $_GET['id'];
    $quantidade = (int) $_GET['q'];
    if ($quantidade==0) $quantidade = 1;

    $processo = mysql_query("SELECT nome, preco, descricao, tipo FROM produtos WHERE id='$produtoId' LIMIT 1");
  	$dados = mysql_fetch_array($processo);

 	$itemValores = array(
		'id' 					=> (int) $produtoId,
		'nome' 					=> $dados['nome'],
		'preco' 				=> number_format($dados['preco'], 2),
		'descricao' 			=> $dados['descricao'],
		'quantidade' 			=> $quantidade,
		'tipo' 					=> $dados['tipo']
	);

	$_SESSION['carrinho']['itens'][$produtoId] = $itemValores;
	$itens = $_SESSION['carrinho']['itens'];

if (is_array($itens))
	include 'SetExpressCheckout.php';
?>