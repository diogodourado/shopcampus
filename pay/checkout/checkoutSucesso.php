<?php 
session_start();
require '../../include/paypal2.php';
include_once '../../include/db.php';

$itens = $_SESSION['carrinho']['itens'];
$nvp['TOKEN'] = $_GET['token'];
$nvp['PAYERID'] = $_GET['PayerID'];

$compraPeriodo = 'Day';
$compraFrequencia = 1;

$erro = 0;
include 'GetExpressCheckoutDetails.php';

if ($erro == 0 && $_SESSION['carrinho']['transacaoProduto'] == 1) include 'DoExpressCheckoutPayment.php';
if ($erro == 0 && $_SESSION['carrinho']['transacaoServico'] == 1) include 'CreateRecurringPaymentsProfile.php';

if ($erro==0) {
	unset($_SESSION['carrinho']);
	mysql_query("UPDATE pedidos SET status='FINALIZADO' WHERE id=$invoice");
	header("Location: http://paypal.sitesdiversos.com/pedido.php?p={$invoice}");
} else {
	echo $erro;
	// header("Location: http://paypal.sitesdiversos.com/pay/checkout/checkoutErro.php");
}