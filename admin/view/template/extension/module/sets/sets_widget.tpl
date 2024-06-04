<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">

    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <button type="submit" form="form-sets-widget" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-sets-widget" class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?></label>
                        <div class="col-sm-10">
                            <input type='text' value="<?php echo $name;?>" name="name" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                        <div class="col-sm-10">
                            <select name="status" id="input-status" class="form-control">
                                <?php if ($status) { ?>
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
                        <label class="col-sm-2 control-label" for="input-orientation"><?php echo $entry_orientation; ?></label>
                        <div class="col-sm-10">
                            <select name="orientation" id="input-orientation" class="form-control">
                                    <option <?php if($orientation=="hor") { ?> selected="selected" <?php } ?> value="hor"><?php echo $text_orientation_horizontal; ?></option>
                                <option <?php if($orientation=="ver") { ?> selected="selected" <?php } ?> value="ver"><?php echo $text_orientation_vertical; ?></option>
                                <option <?php if($orientation=="series") { ?> selected="selected" <?php } ?> value="series"><?php echo $text_orientation_series; ?></option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_products; ?></label>
                        <div class="col-sm-10">
                            <input name="product_name" class="product_name form-control">
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-2 control-label" >CART</label>
                        <div class="col-sm-10">
                            
                            <select name="cart" class="form-control">
                                <?php if ($cart) { ?>
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
                        <label class="col-sm-2 control-label" >ONE SLIDER</label>
                        <div class="col-sm-10">
                            <select name="one_slider" class="form-control">
                                <?php if ($one_slider) { ?>
                                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                <option value="0"><?php echo $text_disabled; ?></option>
                                <?php } else { ?>
                                <option value="1"><?php echo $text_enabled; ?></option>
                                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <table class="table products table-bordered">
                        <?php if($product) { ?>
                        <?php foreach($product as $p) { ?>
                        <tr><td><input type="hidden" name="product[<?php echo $p['id'];?>][id]" value="<?php echo $p['id'];?>"><input type="hidden" name="product[<?php echo $p['id'];?>][name]" value="<?php echo $p['name'];?>"><?php echo $p['name'];?></td><td><i class="fa fa-close del_product"></i></td></tr>
                        <?php } ?>
                        <?php } ?>
                    </table>


                </form>
            </div>
        </div>
    </div>

</div>
<script>
    $(document).ready(function () {
        $('.product_name').autocomplete({'source': autocomplete_source,'select': autocomplete_select});
    });

    $('.products').on('click', '.del_product', function () {
        $(this).parents('tr').remove();
        return false;
    });

    function autocomplete_source(request, response) {


        $.ajax({
            url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $user_token; ?>&filter_name=' + encodeURIComponent(request),
            dataType: 'json',
            success: function (json) {
                response($.map(json, function (item) {

                    return {
                        label: item['name'],
                        value: item['product_id'],
                        price: item['price'],
                        option: item['option']
                    }
                }));
            }
        });
    }

    function autocomplete_select(item)
    {
        $(".products").append('<tr><td><input type="hidden" name="product[' + item['value'] + '][id]" value="' + item['value'] + '"><input type="hidden" name="product[' + item['value'] + '][name]" value="' + item['label'] + '">' + item['label'] + '</td><td><i class="fa fa-close del_product"></i></td></tr>')
    }

    $('.products').on('click', '.del_product', function () {
        $(this).parents('tr').remove();
        return false;
    });

    $('#form-sets-widget').on('click', '#add', function () {
        var data = $('#form-sets-manage input,#form-sets-manage select,#form-sets-manage checkbox').serialize();

        $.ajax({
            url: 'index.php?route=extension/module/sets_manage/add&token=<?php echo $user_token; ?>',
            method: 'POST',
            data: data,
            success: function (json) {

                if (json['error']) {
                    $("#form-sets-manage .result").html('<div class=\'alert alert-danger\'>' + json['error'] + '</div>')
                }

                if (json['success']) {
                    $("#form-sets-manage .result").html('<div class=\'alert alert-success\'>' + json['success'] + '</div>')
                }
            }
        });

        return false;
    });
</script>
<?php echo $footer; ?>