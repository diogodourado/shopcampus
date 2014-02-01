<?php include('include/header.php'); ?>

<?php 

if(isset($_GET['id'])){

    $produto_id = (int) $_GET['id'];

    $query = mysql_query("select * from produtos where id = ". $produto_id);
    $produto = mysql_fetch_array($query);

    if(!$produto)
        die('O produto não existe!');

   
    ?>

    

    <div class="row">
        <div class="span4">
            
            <div class="row">
                <div id="primary-img" class="span4">
                    <img alt="" src="uploads/images/medium/<?php echo $produto['id']; ?>_1.jpg" class="responsiveImage">            
                </div>
            </div>
                <div class="row">
                    <div class="span4 product-images">
                        <img src="uploads/images/medium/<?php echo $produto['id']; ?>_1.jpg" onclick="$(this).squard('300', $('#primary-img'));" class="span1">
                        <img src="uploads/images/medium/<?php echo $produto['id']; ?>_2.jpg" onclick="$(this).squard('300', $('#primary-img'));" class="span1">
                        <img src="uploads/images/medium/<?php echo $produto['id']; ?>_3.jpg" onclick="$(this).squard('300', $('#primary-img'));" class="span1">
                    </div>
                </div>
        </div>
        <div class="span8 pull-right">
            
            <div class="row">
                <div class="span8">
                    <div class="page-header">
                        <h2 style="font-weight:normal">
                            <?php echo $produto['nome']; ?>
                            <span class="pull-right">
                                <small>Por:</small>
                                <span class="product_price">R$ <?php echo ($produto['preco'] ); ?></span>
                            </span>
                        </h2>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="span8">
                    <?php echo $produto['descricao']; ?> 
                </div>
            </div>
            
            <div style="margin-top:15px; margin-bottom:15px;" class="row">
                <div class="span4 sku-pricing">
                    <div>CÓDIGO: <?php echo 'PRD'.($produto['id']*732); ?></div>&nbsp;
                </div>
            </div>
            
            <div class="row">
                <div class="span8">
                    <div class="product-cart-form">
                        <form id="checkout" accept-charset="utf-8" method="post" class="form-horizontal" action="carrinho.php">
                            <input type="hidden" name="id" value="<?php echo $produto['id']; ?>"/>
                            <input type="hidden" name="nome" value="<?php echo $produto['nome']; ?>"/>
                            <input type="hidden" name="preco" value="<?php echo $produto['preco']; ?>"/>
                            <input type="hidden" name="descricao" value="<?php echo $produto['descricao']; ?>"/>
                            <input type="hidden" name="preco" value="<?php echo $produto['preco']; ?>"/>
                            <input type="hidden" name="tipo" value="<?php echo $produto['tipo']; ?>"/>

                            <fieldset>
                                                
                            <div class="control-group">
                                <label class="control-label">Quantidade</label>
                                <div class="controls">
                                    
                                    <?php if($produto['tipo'] == 'produto'){ ?>

                                    <select id="quantidade" name="quantidade" class="span1">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>

                                    <?php }else{ ?>
                                        <input type="text" name="quantidade" value="1" readonly="readonly" class="span1"/>

                                    <?php } ?>

                                    <button value="submit" type="submit" class="btn btn-primary btn-large btn-checkout" style="margin-right:10px; padding-top: 4px; padding-bottom: 5px;">
                                        <i class="icon-shopping-cart icon-white"></i> Colocar no carrinho
                                    </button>
                                    <!-- adiciona ao carrinho via ajax -->
                                    
                                    <?php if ($_SESSION['logado']) { ?>
                                    <span class="or">ou</span>

                                    <a class="express-checkout" href="pay/checkout/checkoutDirect.php?id=<?php echo $produto['id']; ?>">
                                        <img class="btn-checkout-paypal"  src="https://www.paypal-brasil.com.br/logocenter/util/img/botao-checkout_horizontal_compraexpresscom_ap.png" border="0" alt="Pagar com PayPal">
                                     </a>
                                    <?php } ?>
                                  
                                  <script>
                                  $(document).ready(function(){

                                        $('#quantidade').on('change', function(){
                                            var url = $('.express-checkout').attr('href') + '&q=' + $(this).val();
                                            $('.express-checkout').attr('href',url) ;


                                        })
                                  });

                                  </script>

                                </div>
                            </div>
                            
                            </fieldset>
                        </form>
                    </div>
        
                </div>
            </div>
            
            <div style="margin-top:15px;" class="row">
                <div class="span8">
                    <?php if($produto['tipo'] == 'servico'){ ?>

                    <p>Atenção! Você está adiquirindo um serviço com pagamento recorrente.<br/>
                    Para efeitos de teste a cobrança será diária.</p>
                    <?php } ?>
                               
                </div>
            </div>
            
        </div>
    
    </div>

    <?php
}

?>

<?php include('include/footer.php'); ?>