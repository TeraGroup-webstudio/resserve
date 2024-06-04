
    <?php foreach($sets as $iset=>$set) { ?>
        <div class="set setv">
            <?php if(!empty($set['name'])) { ?>
                <h3><?php echo $set['name'];?></h3>
            <?php } ?>

            <?php if(!empty($set['enddate'])) { ?>
                <div class='timer'></div>
                <input type='hidden' name='sp_timer' value="<?php echo $set['enddate'];?>">
            <?php } ?>   

            <div class='set_table'>
                <?php $i = 0; foreach($set['products'] as $key => $product) { ?>
                    <?php if($i++) { ?>
                        <div class='ao plus'><span>+</span></div>
                    <?php } ?>

                    <div class="cell set-product <?php if($product['stock_quantity'] <= 0) { ?> out-stock <?php } ?>" data-discount="<?php echo $product['discount'];?>" data-price="<?php echo $product['cprice'];?>" data-optiontype="<?php echo $product['option_type'];?>" data-productid="<?php echo $product['product_id'];?>">

                        <input type='hidden' name='product_id' value="<?php echo $product['product_id'];?>">
                        <input type='hidden' name='quantity' value="<?php echo $product['quantity'];?>">

                        <?php if($product['discount'] && $sets_show_disc_prec && $product['discount']!=='0%') { ?>
                        <div class='disc'><?php echo $product['discount_currency'];?></div>
                        <?php } ?>
                        
                        <?php if($product['thumb']) { ?>
                            <div class="image">
                                <a href="<?php echo $product['href']; ?>" <?php if($sets_product_link_newtab) { ?> target="_blank" <?php } ?>>
                                    <img width="200" height="200" src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['product_name']; ?>" title="<?php echo $product['product_name']; ?>" class="img-resp"/>
                                </a>
                            </div>
                        <?php } ?>
                        
                        <div class="caption">
                            <h4>
                                <a href="<?php echo $product['href']; ?>" <?php if($sets_product_link_newtab) { ?> target="_blank" <?php } ?>>
                                    <?php echo $product['product_name']; ?>
                                        
                                </a>
                            </h4>
                    
                            <p class="price">
                                <?php if($product['special']) { ?>
                                    <span class='price-old'><?php echo $product['price']; ?></span>
                                    <span class='price-new'><?php echo $product['special']; ?></span>
                                <?php } else { ?>
                                    <?php echo $product['price']; ?>
                                <?php } ?>
                            </p>


                            <?php if($product['quantity']>1 && $sets_show_qty) { ?>
                                <div class='quantity'>x<?php echo $product['quantity']; ?></div>
                            <?php } ?>

                             <?php if($product['option_type'] == 'popup') { ?>
                                <?php echo $product['html_options_button'];?>
                            <?php } ?>
                        </div>
                    </div>
                    <div class='clearfix'></div>
                <?php } ?>
            
                <div class='ao'><span>=</span></div>
                <div class='set-total'>
                    <?php if($set['ceconomy']) { ?>
                    <div class='economy'>
                        <span class='economy_text'><?php echo $text_economy;?></span>
                        <span class='economy_val'><?php echo $set['economy'];?></span>
                    </div>
                    <?php } ?>

                    <div class='new_summ'><?php echo $set['new_total']; ?></div>
                    <div class='clearfix'></div>
                    <input type='hidden' name='sp_set_quantity' class="form-control " value="1">    
                    <button class='add-set-btn btn btn-primary' data-success-text="<i class='fa fa-check'></i>" data-loading-text="<i class='fa fa-spinner fa-spin '></i>"><?php echo $text_buy_sets;?></button>
                </div>
            </div>
        </div>
    <?php } ?>
