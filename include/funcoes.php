<?php

session_start();

include_once 'db.php';


/**
 * Salva os dados do pedido no banco.
 */
function salvaPedido() 
{
	$data = date('Y-m-d H:m:s');
	$numero = geraHash(15);
	$status = 'Aguardando Pagamento';
	$usuarios_id = $_SESSION['usuario']['id'];

	$total = 0;
	foreach ($_SESSION['carrinho']['itens'] as $produto){
		$total += $produto['preco'] * $produto['quantidade'];
	}
	
	// salva o pedido 
	$query = mysql_query(" insert into pedidos (numero, data, total, status, usuarios_id) 
				values ('".$numero."', '".$data."', '".$total."', '".$status."', '".$usuarios_id."') ");
	$id = mysql_insert_id();
 	
 	// salva os itens de pedido
 	foreach ($_SESSION['carrinho']['itens'] as $produto){
		$query = mysql_query(" insert into pedidos_produtos (pedidos_id, produtos_id, quantidade, total) 
				values ('".$id."', '".$produto['id']."', '".$produto['quantidade']."', '".($produto['preco']*$produto['quantidade'])."') ");
	}

	return $id;
}

function atualizaStatusPedido($status)
{
	$query = mysql_query(" update pedidos set status = ". $status);
	return $query;
}

/**
 * Salva os detalhes da transacao - pagamentos recorrentes
 * @param $transacao array()
 */
function salvaTransacao($transacao)
{
	// id, transacao_id, status
	$query = mysql_query(" insert into transacoes ( transaction, pedidos_id, status, data, assinatura) 
				values ('".$transacao['transaction']."', '".$transacao['pedidos_id']."', '".$transacao['status']."', '".$transacao['data']."', '".$transacao['assinatura']."') ");
	return mysql_insert_id();
}

function geraHash($n){
		
	$str = "0123456789";
	$hash = "";
	for($a = 0;$a < $n;$a++){
		$rand = rand(0,strlen($str));
		$hash .= substr($str,$rand,1);
	}
	return $hash;
}