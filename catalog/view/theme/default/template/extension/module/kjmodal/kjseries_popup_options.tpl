<?php if ($options) { ?>
<div id="kjmodal<?php echo $id;?>" data-productid="<?php echo $id;?>" data-firstshow="0" class="modal fade series-options-modal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close bs3-close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $name;?></h4>
                <button type="button" class="btn-close bs5-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6">
                        <img width="300" height="300" class="img-resp kj-product-thumb" src="<?php echo $product_thumb;?>" />
                    </div>
                    <div class="col-sm-6">
                        <input type="hidden" name="product_id" value="<?php echo $id;?>">
                        <?php include 'kjseries_options.tpl';?>

                        <?php if($quantity <= 0) { ?> 
                            <div class='alert alert-danger'>
                        <?php } else { ?>
                            <div class='alert alert-success'>
                        <?php } ?>
                            <?php echo $stock;?>
                        </div>

                        <?php if($echodiscounts) { ?>
                            <ul class="list-group discounts">
                                <?php foreach($echodiscounts as $discount) { ?>
                                   <li class='list-group-item'><b><?php echo $discount['quantity'];?></b> <?php echo $text_discount;?> <b><?php echo $discount['price'];?></b></li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                        <ul class="list-group">
                            <li class='list-group-item' style="overflow: hidden;">
                                <p class='price'>
                                    <?php if($special) { ?>
                                        <span class='price-old'><?php echo $price;?></span>
                                        <span class='price-new'><?php echo $special;?></span>
                                    <?php } else { ?>
                                        <?php echo $price;?>
                                    <?php } ?>
                                </p>
                                <input class="form-control" min="<?php echo $qty;?>" type="number" name="quantity" value="<?php echo $qty;?>"/>
                                <button class="btn btn-success apply-options"><i class='fa fa-shopping-cart'></i> <?php echo $button_cart;?></button>
                            </li>
                        </ul>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
<?php } ?>