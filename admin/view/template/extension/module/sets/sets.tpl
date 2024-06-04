<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">

    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <button type="submit" form="form-sets" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
                <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
            <h1><?php echo $heading_title; ?></h1>
            <ul class="breadcrumb">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>

    <div class="container-fluid">
        <?php if ($error_warning) { ?>
        <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
            </div>
            <div class="panel-body">
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-sets" class="form-horizontal">
                    
                    <div class="form-group <?php if($show_lic) { ?> alert-success <?php } else { ?> alert-danger <?php } ?>">
                        <label class="col-sm-2 control-label" for="input-key"><?php echo $entry_key; ?></label>
                        <div class="col-sm-10">
                            <textarea id="input-key" name="sets_key" class="form-control"><?php echo $sets_key;?></textarea>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                        <div class="col-sm-10">
                            <select name="sets_status" id="input-status" class="form-control">
                                <?php if ($sets_status) { ?>
                                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                <option value="0"><?php echo $text_disabled; ?></option>
                                <?php } else { ?>
                                <option value="1"><?php echo $text_enabled; ?></option>
                                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class='row'>
                    <div class='col-sm-4'>
                    <div class='text-center'>
                        <i class='fa fa-eye fa-2x'></i>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-6 control-label" for="input-product_link_newtab"><?php echo $entry_sets_product_link_newtab; ?></label>
                        <div class="col-sm-6">
                            <select name="sets_product_link_newtab" id="input-product_link_newtab" class="form-control">
                                <?php if ($sets_product_link_newtab) { ?>
                                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                <option value="0"><?php echo $text_disabled; ?></option>
                                <?php } else { ?>
                                <option value="1"><?php echo $text_enabled; ?></option>
                                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    
                   <div class="form-group">
                        <label class="col-sm-6 control-label" for="input-show-qty"><?php echo $entry_show_qty; ?></label>
                        <div class="col-sm-6">
                            <select name="sets_show_qty" id="input-show-qty" class="form-control">
                                <?php if ($sets_show_qty) { ?>
                                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                <option value="0"><?php echo $text_disabled; ?></option>
                                <?php } else { ?>
                                <option value="1"><?php echo $text_enabled; ?></option>
                                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-6 control-label" for="input-show-discount"><?php echo $entry_show_discount; ?></label>
                        <div class="col-sm-6">
                            <select name="sets_show_disc_prec" id="input-show-discount" class="form-control">
                                <?php if ($sets_show_disc_prec) { ?>
                                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                <option value="0"><?php echo $text_disabled; ?></option>
                                <?php } else { ?>
                                <option value="1"><?php echo $text_enabled; ?></option>
                                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    
                    
                     <div class="form-group">
                        <label class="col-sm-6 control-label" for="input-orientation"><?php echo $entry_orientation; ?></label>
                        <div class="col-sm-6">
                            <select name="sets_orientation" id="input-orientation" class="form-control">
                                    <option <?php if($sets_orientation=="hor") { ?> selected="selected" <?php } ?> value="hor"><?php echo $text_orientation_horizontal; ?></option>
                                <option <?php if($sets_orientation=="ver") { ?> selected="selected" <?php } ?> value="ver"><?php echo $text_orientation_vertical; ?></option>
                            </select>
                        </div>
                    </div>

                   
                </div>
                <div class='col-sm-8'>
                    <div class='text-center'>
                        <i class='fa fa-cog fa-2x'></i>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="input-slider">slider</label>
                        <div class="col-sm-8">
                            <?php $sliders = array('swiper', 'owl');?>
                            <select name="sets_slider" id="input-slider" class="form-control">
                                <?php foreach($sliders as $slider) { ?>
                                    <option <?php if($sets_slider == $slider) { ?> selected="selected" <?php } ?> value="<?php echo $slider; ?>"><?php echo $slider; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="input-links"><?php echo $entry_sets_links; ?></label>
                        <div class="col-sm-8">
                            <select name="sets_links" id="input-links" class="form-control">
                                <?php if ($sets_links) { ?>
                                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                <option value="0"><?php echo $text_disabled; ?></option>
                                <?php } else { ?>
                                <option value="1"><?php echo $text_enabled; ?></option>
                                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="input-show-if-empty"><?php echo $entry_show_if_empty;?></label>
                        <div class="col-sm-8">
                            <select name="sets_show_if_empty" id="input-show-if-empty" class="form-control">
                                <?php if ($sets_show_if_empty) { ?>
                                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                <option value="0"><?php echo $text_disabled; ?></option>
                                <?php } else { ?>
                                <option value="1"><?php echo $text_enabled; ?></option>
                                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="input-js-cart-add"><?php echo $entry_js_for_cart_add;?></label>
                        <div class="col-sm-8">
                            <textarea id="js-cart-add" name="sets_js_cart_add" class="form-control"><?php echo $sets_js_cart_add;?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">custom css</label>
                        <div class="col-sm-8">
                            <textarea name="sets_custom_css" class="form-control"><?php echo $sets_custom_css;?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="input-js-cart-add"><?php echo $entry_media_path;?></label>
                        <div class="col-sm-8">
                            <textarea placeholder="catalog/view/javascript/font-awesome/css/font-awesome.min.css" id="js-cart-add" name="sets_include_media" class="form-control"><?php echo $sets_include_media;?></textarea>
                            oc 3.x<br/>
                            catalog/view/javascript/jquery/swiper/js/swiper.jquery.js<br/>
                            catalog/view/javascript/jquery/swiper/css/swiper.min.css<br/>
                            catalog/view/javascript/jquery/swiper/css/opencart.css<br/>
                            oc 2.3.x<br/>
                            catalog/view/javascript/jquery/owl-carousel/owl.carousel.css<br/>
                            catalog/view/javascript/jquery/owl-carousel/owl.carousel.min.js<br/>
                        </div>
                        
                    </div>

                     <div class="form-group">
                        <label class="col-sm-4 control-label" for="input-position"><?php echo $entry_position; ?></label>
                        <div class="col-sm-8">
                            <?php $poss = array('insertBefore', 'insertAfter', 'prepend', 'append');?>
                            <select name="sets_position" id="input-position" class="form-control">
                                <?php foreach($poss as $jq_pos) { ?>
                                    <option <?php if($sets_position == $jq_pos) { ?> selected="selected" <?php } ?> value="<?php echo $jq_pos; ?>"><?php echo $jq_pos; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="input-selector"><?php echo $entry_selector; ?></label>
                        <div class="col-sm-8">
                            <input id="input-selector" name="sets_selector" value="<?php echo $sets_selector;?>" class="form-control">
                        </div>
                    </div>
                    
                    </div>
                    </div>
                </form>
                <a style='color:red;' href='<?php echo $uninstall;?>'>Delete module tables</a>
            </div>
        </div>
    </div>

</div>
<?php echo $footer; ?>