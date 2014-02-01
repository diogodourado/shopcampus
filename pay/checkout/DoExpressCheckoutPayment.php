<?php 

    $itemsCurl['USER'] = PAYPAL_USER;
    $itemsCurl['PWD'] = PAYPAL_PWD;
    $itemsCurl['SIGNATURE'] = PAYPAL_SIGNATURE;
    $itemsCurl['METHOD'] = 'DoExpressCheckoutPayment';
    $itemsCurl['VERSION'] = '108.0';
    $itemsCurl['LOCALECODE'] = 'pt_BR';

    $itemsCurl['TOKEN'] = $nvp['TOKEN'];
    $itemsCurl['PAYERID'] = $nvp['PAYERID'];

    $itemsCurl['PAYMENTREQUEST_0_SHIPTONAME'] = $nvp['SHIPTONAME'];
    $itemsCurl['PAYMENTREQUEST_0_SHIPTOSTREET'] = $nvp['SHIPTOSTREET'];
    $itemsCurl['PAYMENTREQUEST_0_SHIPTOSTREET2'] = $nvp['SHIPTOSTREET2'];
    $itemsCurl['PAYMENTREQUEST_0_SHIPTOCITY'] = $nvp['SHIPTOCITY'];
    $itemsCurl['PAYMENTREQUEST_0_SHIPTOSTATE'] = $nvp['SHIPTOSTATE'];
    $itemsCurl['PAYMENTREQUEST_0_SHIPTOZIP'] = $nvp['SHIPTOZIP'];
    $itemsCurl['PAYMENTREQUEST_0_SHIPTOCOUNTRYCODE'] = $nvp['SHIPTOCOUNTRYCODE'];

$i=0; 
foreach ($itens as $item) {

    if ($item['tipo']=='produto') {
    $itemPrecoTotal = $item[preco] * $item[quantidade];
    $PrecoTotal += $itemPrecoTotal;
    $itemsCurl["L_PAYMENTREQUEST_0_NAME{$i}"] = $item[nome];
    $itemsCurl["L_PAYMENTREQUEST_0_DESC{$i}"] = $item[nome];
    $itemsCurl["L_PAYMENTREQUEST_0_QTY{$i}"] = $item[quantidade];
    $itemsCurl["L_PAYMENTREQUEST_0_ITEMAMT{$i}"] = $itemPrecoTotal;
    $itemsCurl["L_PAYMENTREQUEST_0_AMT{$i}"] = (float) $item[preco];
    }
    $i++;
}

$itemsCurl['PAYMENTREQUEST_0_ITEMAMT'] = $PrecoTotal;
$itemsCurl['PAYMENTREQUEST_0_AMT'] = $PrecoTotal;
$itemsCurl['PAYMENTREQUEST_0_CURRENCYCODE'] = 'BRL';
$itemsCurl['PAYMENTREQUEST_0_PAYMENTACTION'] = 'Sale';

$curl = curl_init();
 
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_URL, 'https://api-3t.sandbox.paypal.com/nvp');
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($itemsCurl));
 
$response = curl_exec($curl);
 
curl_close($curl);
 
$nvpDo = array();
 
if (preg_match_all('/(?<name>[^\=]+)\=(?<value>[^&]+)&?/', $response, $matches)) {
    foreach ($matches['name'] as $offset => $name) {
        $nvpDo[$name] = urldecode($matches['value'][$offset]);
    }
}

if ($nvpDo[ 'ACK' ] != 'Success' && $nvpDo[ 'ACK' ] != 'SuccessWithWarning') {
    var_dump($nvpDo);
    $erro = 2;
} else {

    ob_start();
    var_dump($nvpDo);
    $resultado = "\n--- DoExpressCheckoutPayment ---\n\n executado em: " . date("d-m-Y H:i:s") . "\n\n" . ob_get_clean();

    $fp = fopen("../../log.txt", "a");
    $resultado = fwrite($fp, $resultado);
    fclose($fp);

    $transacao['transaction'] = $nvpDo[ 'PAYMENTINFO_0_TRANSACTIONID' ];
    $transacao['pedidos_id'] = $invoice;
    // $transacao['status'] = $nvpDo[ 'PAYMENTINFO_0_PAYMENTSTATUS' ];
    $transacao['status'] = 'SUCESSO';
    $transacao['data'] = date("Y-m-d H:i:s");

    include_once '../../include/funcoes.php';
    salvaTransacao($transacao);
}