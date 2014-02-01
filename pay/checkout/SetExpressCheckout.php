<?php
$itemsCurl['USER'] = PAYPAL_USER;
$itemsCurl['PWD'] = PAYPAL_PWD;
$itemsCurl['SIGNATURE'] = PAYPAL_SIGNATURE;
$itemsCurl['METHOD'] = 'SetExpressCheckout';
$itemsCurl['VERSION'] = '91';
$itemsCurl['LOCALECODE'] = 'pt_BR';
$itemsCurl['CANCELURL'] = 'http://paypal.sitesdiversos.com/pay/checkout/checkoutErro.php';
$itemsCurl['RETURNURL'] = 'http://paypal.sitesdiversos.com/pay/checkout/checkoutSucesso.php';

$i=0; 

$_SESSION['carrinho']['transacaoProduto'] = 0;
$_SESSION['carrinho']['transacaoServico'] = 0;

foreach ($itens as $item) {

    $itemPrecoTotal = $item[preco] * $item[quantidade];
    $PrecoTotal += $itemPrecoTotal;
    $PrecoTotalItem += $item[preco];

    $itemsCurl["L_PAYMENTREQUEST_0_NAME{$i}"] = $item[nome];
    $itemsCurl["L_PAYMENTREQUEST_0_DESC{$i}"] = $item[nome];
    $itemsCurl["L_PAYMENTREQUEST_0_QTY{$i}"] = $item[quantidade];
    $itemsCurl["L_PAYMENTREQUEST_0_ITEMAMT{$i}"] = $itemPrecoTotal;
    $itemsCurl["L_PAYMENTREQUEST_0_AMT{$i}"] = (float) $item[preco];

    if ($item['tipo']=='servico') {
    $itemsCurl["L_PAYMENTREQUEST_0_ITEMCATEGORY{$i}"] = 'Digital';
    $transacaoServico = 1;
    } else {
    $transacaoProduto = 1;
    }

    if ($transacaoServico) {
        $itemsCurl["L_BILLINGTYPE0"] = 'RecurringPayments';
        $itemsCurl["L_BILLINGAGREEMENTDESCRIPTION0"] = 'Assinatura';
        $_SESSION['carrinho']['transacaoServico'] = 1;
    } 

    if ($transacaoProduto) {
        $_SESSION['carrinho']['transacaoProduto'] = 1;
    } 

    $i++;
}

$itemsCurl['PAYMENTREQUEST_0_ITEMAMT'] = $PrecoTotal;
$itemsCurl['PAYMENTREQUEST_0_AMT'] = $PrecoTotal;
$itemsCurl['PAYMENTREQUEST_0_CURRENCYCODE'] = 'BRL';
$itemsCurl['PAYMENTREQUEST_0_PAYMENTACTION'] = 'Sale';


include_once '../../include/funcoes.php';
$invoice = salvaPedido();

$itemsCurl['PAYMENTREQUEST_0_INVNUM'] = $invoice;

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
    $paypalURL = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
    $query = array(
        'cmd'   => '_express-checkout',
        'token' => $nvp[ 'TOKEN' ]
    );

    $redirectURL = $paypalURL . '?' . http_build_query($query);
    require 'redirect.php';
} else {
    var_dump($nvp);
    header( 'Location: ' . $itemsCurl['CANCELURL']);
}