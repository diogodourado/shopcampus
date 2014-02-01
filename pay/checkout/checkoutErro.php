<?php 
session_start();
$_SESSION['carrinho']['error'] = 1;

 header( 'Location: http://paypal.sitesdiversos.com/carrinho.php');