<?php include('include/header.php'); ?>

<?php 

	if(isset($_GET['p']) && !empty($_GET['p'])){

		$id = (int) $_GET['p'];

		$query = mysql_query("select * from pedidos where id = ". $id);
		$pedido = mysql_fetch_array($query);

 ?>

<?php if(isset($_SESSION['carrinho']['error'])){ ?>
	
	<div class="alert alert-warning">
		<a class="close" data-dismiss="alert">×</a>
		<?php echo $_SESSION['carrinho']['error'];  unset($_SESSION['carrinho']['error']); ?>
	</div>

<?php } ?>

<div class="row">
	<div class="span12">

		<div class="page-header">
			<h2>Pedido nº: <?php echo $pedido['numero'];?></h2>
		</div>

		<table class="table table-bordered table-striped" style="margin-top:20px;">
			<thead>
				<tr>
					<th style="width:20%;">Nome</th>
					<th style="width:10%;">Preço</th>
					<th>Descrição</th>
					<th style="width:10%;">Quantidade</th>
					<th style="width:8%;">Total</th>
				</tr>
			</thead>
			
			<tfoot>
				<tr>
					<td colspan="4"><strong>Total</strong></td>
					<td><?php echo 'R$ '.$pedido['total'] ?></td>
				</tr>
			</tfoot>

			<tbody>
			<?php
			
			$query = mysql_query("select * from pedidos_produtos inner join produtos on 
					pedidos_produtos.produtos_id = produtos.id where pedidos_id = ". $pedido['id']);

			if($query)
		    {
			
				while($produto = mysql_fetch_array($query))
			        $produtos[]= $produto;
		       
				foreach ($produtos as $produto){?>
					<tr>
						<td><?php echo $produto['nome']; ?></td>
						<td><?php echo $produto['preco'];   ?></td>
						<td><?php echo $produto['descricao']; ?> </td>
						<td><?php echo $produto['quantidade'];?></td>
						<td><?php echo 'R$ '.($produto['preco']*$produto['quantidade']); ?></td>
					</tr>
					
				<?php } ?>
			<?php } ?>
			</tbody>
		</table>
	</div>
</div>

<div class="row">
	<div class="span12">

		<div class="page-header">
			<h2>Histórico de transações</h2>
		</div>

		<table class="table table-bordered table-striped" style="margin-top:20px;">
			<thead>
				<tr>
					<th style="width:20%;">Transação</th>
					<th style="width:20%;">Código</th>
					<th style="width:30%;">Data</th>
					<th>Status</th>
					<th>Ações</th>
				</tr>
			</thead>
			
			<tbody>
			<?php

			$query = mysql_query("select * from transacoes where pedidos_id = ". $pedido['id']);

			if($query)
		    {
			
				while($transacao = mysql_fetch_array($query))
			        $transacoes[]= $transacao;
		       
				foreach ($transacoes as $transacao){?>
					<tr>
						<?php
						if ($transacao['assinatura']==NULL) {
						?>
							<td>PAGAMENTO</td>
							<td><?php echo $transacao['transaction']; ?></td>
						<?php
						} else {
						?>
							<td>ASSINATURA</td>
							<td><?php echo $transacao['assinatura']; ?></td>
						<?php
						}
						?>


						<td><?php echo $transacao['data'];   ?></td>
						<td><?php echo $transacao['status']; ?> </td>
						<td>
						<?php 

							if (!empty($transacao['assinatura']) && $transacao['status'] != 'CANCELADO') 
							{
								echo "<a href='pay/assinatura/cancela.php?t={$transacao['assinatura']}&p={$pedido['id']}'>Cancelar Assinatura</a>";
							}elseif($transacao['status'] == 'SUCESSO'){
								echo "<a href='pay/extorno/extorno.php?t={$transacao['transaction']}&p={$pedido['id']}'>Solicitar Extorno</a>";
							}


						 ?>
						</td>
					</tr>
					
				<?php } ?>
			<?php } ?>
			</tbody>
		</table>
	</div>
</div>

<?php } ?>

<?php include('include/footer.php'); ?>