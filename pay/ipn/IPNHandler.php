<?php
include '../../include/paypal2.php';
include 'InstantPaymentNotification.php';

// http://paypal.sitesdiversos.com/pay/ipn/IPNHandler.php

class SampleIPNHandler implements IPNHandler {
    public function handle( $isVerified , array $message ) {

        ob_start();
        var_dump($message);
        $resultado = "\n------\n\n executado em: " . date("d-m-Y H:i:s") . "\n\n" . ob_get_clean();
        /*
        $fp = fopen("log.txt", "a");
        $resultado = fwrite($fp, $resultado);
        fclose($fp);
        */

        if ( $isVerified ) {
            if ( $message[ 'receiver_email' ] == PAYPAL_ACCOUNT ) {
                $transacao['transaction'] = $message['txn_id'];
                $transacao['pedidos_id'] = $message['invoice'];
                $transacao['status'] = $message['payment_status'];
                $transacao['data'] = date("Y-m-d H:i:s");

                include_once '../../include/funcoes.php';
                salvaTransacao($transacao);  
            }
        }
    }
}

$ipn = new InstantPaymentNotification( true );
$ipn->setIPNHandler( new SampleIPNHandler() );
$ipn->listen();
