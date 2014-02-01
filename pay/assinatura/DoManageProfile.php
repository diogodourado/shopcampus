<?php

session_start();

$itemsCurl['USER'] = PAYPAL_USER;
$itemsCurl['PWD'] = PAYPAL_PWD;
$itemsCurl['SIGNATURE'] = PAYPAL_SIGNATURE;
$itemsCurl['METHOD'] = 'ManageRecurringPaymentsProfileStatus';
$itemsCurl['PROFILEID'] = $perfil;
$itemsCurl['ACTION'] = 'Cancel';
$itemsCurl['VERSION'] = '91';
$itemsCurl['LOCALECODE'] = 'pt_BR';
$itemsCurl['RETURNURL'] = 'http://paypal.sitesdiversos.com/pedido.php?p='.$pedido;


$curl = curl_init();
 
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_URL, 'https://api-3t.sandbox.paypal.com/nvp');
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($itemsCurl));
 
$response = curl_exec($curl); 
curl_close($curl);
 

$nvp = array();
 
if (preg_match_all('/(?<name>[^\=]+)\=(?<value>[^&]+)&?/', $response, $matches)) {
    foreach ($matches['name'] as $offset => $name) {
        $nvp[$name] = urldecode($matches['value'][$offset]);
    }
}

if ($nvp[ 'ACK' ] == 'Success') {
	// salva a transacao

	$t['transaction'] = 'CANCELAMENTO DE ASSINATURA';
    $t['pedidos_id'] = $pedido;
    $t['status'] = 'CANCELADO';
    $t['data'] = date("Y-m-d H:i:s");
    $t['assinatura'] = $nvp['PROFILEID'];

	include_once '../../include/funcoes.php';
    salvaTransacao($t);

    header( 'Location: ' .$itemsCurl['RETURNURL']);
} else {
	$_SESSION['carrinho']['error'] = 'Houve um error ao efetuar o cancelamento da transação.';
    header( 'Location: ' . $itemsCurl['RETURNURL']);
}
