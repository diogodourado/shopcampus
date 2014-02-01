<?php 
$curl = curl_init();
 
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_URL, 'https://api-3t.sandbox.paypal.com/nvp');
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query(array(
    'USER' => PAYPAL_USER,
    'PWD' => PAYPAL_PWD,
    'SIGNATURE' => PAYPAL_SIGNATURE,
 
    'METHOD' => 'CreateRecurringPaymentsProfile',
    'VERSION' => '91',
    'LOCALECODE' => 'pt_BR',
 
    'TOKEN' => $nvp['TOKEN'],
    'PayerID' => $nvp['PAYERID'],
 
	    'PROFILESTARTDATE' => $nvp['TIMESTAMP'],
	    'DESC' => 'Assinatura',
	    'BILLINGPERIOD' => $compraPeriodo,
	    'BILLINGFREQUENCY' => $compraFrequencia,
	    'AMT' =>  $nvp['AMT'],

    'CURRENCYCODE' => $nvp['CURRENCYCODE'],
    'COUNTRYCODE' => $nvp['COUNTRYCODE'],
    'MAXFAILEDPAYMENTS' => 3
)));
 
$response =    curl_exec($curl);
 
curl_close($curl);
 
$nvpRecurring = array();
 
if (preg_match_all('/(?<name>[^\=]+)\=(?<value>[^&]+)&?/', $response, $matches)) {
    foreach ($matches['name'] as $offset => $name) {
        $nvpRecurring[$name] = urldecode($matches['value'][$offset]);
    }
}

if ($nvpRecurring['ACK'] != 'Success' && $nvpRecurring[ 'ACK' ] != 'SuccessWithWarning') {
    $erro = 3;
    var_dump($nvpRecurring);
} else {
    $transacao['transaction'] = 'INSCRICAO DE ASSINATURA';
    $transacao['assinatura'] = $nvpRecurring['PROFILEID'];
    $transacao['pedidos_id'] = $invoice;
    $transacao['status'] = 'SUCESSO';
    $transacao['data'] = date("Y-m-d H:i:s");

    include_once '../../include/funcoes.php';
    salvaTransacao($transacao);
}