	<table class="table table-striped table-bordered">
		<thead>
			<thead>
				<tr>
					<th style="width:10%;">Código</th>
					<th style="width:20%;">Nome</th>
					<th style="width:10%;">Valor</th>
					<th>Descricao</th>
					<th style="width:10%;">Quantidade</th>
					<th style="width:8%;">Total</th>
				</tr>
			</thead>
		</thead>
		
		<tfoot>
			
			<tr>
				<td colspan="5"><strong>Total</strong></td>
				<td>
					<?php 
						$total = 0;
						foreach ($_SESSION['carrinho']['itens'] as $produto){
							$total += $produto['preco'] * $produto['quantidade'];
						}
						echo 'R$ '.$total;
				 	?>

				</td>
			</tr>
		</tfoot>
		
		<tbody>
			<?php
			
			foreach ($_SESSION['carrinho']['itens'] as $produto){?>
				<tr>
					<td><?php echo $produto['id']; ?></td>
					<td><?php echo $produto['nome']; ?></td>
					<td><?php echo 'R$ '.$produto['preco'];?></td>
					<td>
						<?php echo $produto['descricao'];	?>
					</td>
					
					<td style="white-space:nowrap">
						
						<div class="control-group">
							<div class="controls">
								<div class="input-append">
									<input class="span1" style="margin:0px;" name="quantidade"  value="<?php echo $produto['quantidade'] ?>" size="3" type="text">
									<button class="btn btn-danger" type="button" onclick="if(confirm('Deseja realmente remover este produto?')){window.location='carrinho.php?r=<?php echo $produto['id']; ?>';}">
										<i class="icon-remove icon-white"></i></button>
								</div>
							</div>
						</div>
				
					</td>
					<td><?php echo 'R$ '.($produto['preco'] * $produto['quantidade']); ?></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>