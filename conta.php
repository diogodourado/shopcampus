<?php include('include/header.php'); ?>

<?php 
	
	$query = mysql_query("select * from pedidos where usuarios_id = ". (int) $_SESSION['usuario']['id']);

	if($query)
    {
		while($pedido = mysql_fetch_array($query))
	        $pedidos[]= $pedido;
?>

<div class="row">
	<div class="span12">
		<div class="page-header">
			<h2>Meus pedidos</h2>
		</div>
		
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th width="20%">Data</th>
					<th>Número</th>
					<th>Total</th>
					<th>Status</th>
					<th ></th>
				</tr>
			</thead>

			<tbody>
			<?php
			foreach($pedidos as $pedido){
				$id = $pedido['id'];
			 ?>
				
				<tr>
					<td><?php echo $pedido['data']; ?> </td>
					<td><?php echo $pedido['numero']; ?></td>
					<td><?php echo 'R$ '.$pedido['total']; ?></td>
					<td><?php echo $pedido['status']; ?> </td>
					<td style="text-align:center"> <a class="detalhes" href="pedido.php?p=<?php echo $pedido['id'] ?>">DETALHES</a> </td>
				</tr>
		
			<?php }?>
			</tbody>
		</table>
		
	</div>
</div>

<?php }else{
		echo '<h3>Você ainda não tem pedidos! :\</h3>';
} ?>

<?php include('include/footer.php'); ?>