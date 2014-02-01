<?php 
session_start();
require '../../include/paypal2.php';

$transacao = $_GET['t'];
$pedido = $_GET['p'];

if (isset($transacao) && isset($pedido))
	include 'DoRefound.php';
?>