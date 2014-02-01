<?php include('include/header.php'); ?>

<div class="row">
	<div class="span12">
		<div class="carousel slide" id="myCarousel">
			<!-- Carousel items -->
			<div class="carousel-inner">
				<div class="item active">
					<img src="uploads/banner1.jpg">					
				</div>
				<div class="item">
					<img src="uploads/banner2.jpg">					
				</div>
			</div>
			<!-- Carousel nav -->
			<a data-slide="prev" href="#myCarousel" class="carousel-control left">‹</a>
			<a data-slide="next" href="#myCarousel" class="carousel-control right">›</a>
		</div>
	</div>
</div>

<script type="text/javascript">
$('.carousel').carousel({
  interval: 5000
});
</script>


<div class="row">

    <div class="span12">
        
        <ul class="thumbnails category_container">

<?php 

    $query = mysql_query("select * from produtos");
    //$produtos = mysql_fetch_array($query);

    if($query)
    {
        while($produto = mysql_fetch_array($query))
            $produtos[]= $produto;
       
     
        foreach ($produtos as $produto) {
    
        ?>
         
            <li class="span3 product">
                <a href="detalhe.php?id=<?php echo $produto['id'] ?> " class="thumbnail">
                <img alt="" src="uploads/images/thumbnails/<?php echo $produto['id'] ?>.jpg">                        </a>
                <h3 style="margin-top:5px;">
                	<a href="detalhe.php?id=<?php echo $produto['id'] ?> "><?php echo $produto['nome'] ?></a>
            	</h3>
                <div class="excerpt"><?php echo $produto['descricao'] ?></div>
                <div>
                    <div>
                        <span class="price-slash">de: R$ <?php echo ($produto['preco'] + ($produto['preco']/10)) ?></span>
                        <span class="price-sale">POR: R$ <?php echo ($produto['preco'] ) ?></span>
                    </div>
                </div>
            </li>

<?php } 
        } ?>
           
        </ul>


    </div>
    
</div>

<!-- <div class="row">
	<div class="span3">
		<img src="uploads/brand1.jpg" class="responsiveImage">	
	</div>
	<div class="span3">
		<img src="uploads/brand2.jpg" class="responsiveImage">	
	</div>
	<div class="span3">
		<img src="uploads/brand3.jpg" class="responsiveImage">	
	</div>
	<div class="span3">
		<img src="uploads/brand2.jpg" class="responsiveImage">	
	</div>
</div> -->

<?php include('include/footer.php'); ?>