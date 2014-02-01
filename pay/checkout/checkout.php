<?php 
session_start();
require '../../include/paypal2.php';

$itens = $_SESSION['carrinho']['itens'];

if (is_array($itens))
	include 'SetExpressCheckout.php';
?>