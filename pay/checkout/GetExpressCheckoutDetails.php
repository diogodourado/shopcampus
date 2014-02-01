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
 
	'METHOD' => 'GetExpressCheckoutDetails',
	'VERSION' => '91',
	 
	'TOKEN' => $nvp['TOKEN']
)));
 
$response =    curl_exec($curl);
 
curl_close($curl);
 
$nvp = array();
 
if (preg_match_all('/(?<name>[^\=]+)\=(?<value>[^&]+)&?/', $response, $matches)) {
    foreach ($matches['name'] as $offset => $name) {
        $nvp[$name] = urldecode($matches['value'][$offset]);
    }
}


if ($nvp[ 'ACK' ] != 'Success') {
    var_dump($nvp);
    $erro = 1;
} else {

    ob_start();
    var_dump($nvp);
    $resultado = "\n--- GetExpressCheckoutDetails ---\n\n executado em: " . date("d-m-Y H:i:s") . "\n\n" . ob_get_clean();

    $fp = fopen("../../log.txt", "a");
    $resultado = fwrite($fp, $resultado);
    fclose($fp);

    $invoice = $nvp['PAYMENTREQUEST_0_INVNUM'];
}