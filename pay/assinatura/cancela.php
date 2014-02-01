<?php 
session_start();
require '../../include/paypal2.php';

$perfil = $_GET['t'];
$pedido = $_GET['p'];

if (isset($perfil) && isset($pedido))
	include 'DoManageProfile.php';
?>