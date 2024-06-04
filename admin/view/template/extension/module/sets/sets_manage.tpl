<?php echo $header; ?>
<?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <!--<button type="submit" form="form-sets_manage" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>-->
                <a class="btn btn-default" data-toggle="tooltip" href="<?php echo $cancel; ?>" title="<?php echo $button_cancel; ?>">
                    <i class="fa fa-reply">
                    </i>
                </a>
            </div>
            <h1>
                <?php echo $heading_title; ?>
            </h1>
            <ul class="breadcrumb">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <li>
                    <a href="<?php echo $breadcrumb['href']; ?>">
                        <?php echo $breadcrumb['text']; ?>
                    </a>
                </li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="container-fluid">
        <?php if ($error_warning) { ?>
        <div class="alert alert-danger">
            <i class="fa fa-exclamation-circle">
            </i>
            <?php echo $error_warning; ?>
            <button class="close" data-dismiss="alert" type="button">
                ×
            </button>
        </div>
        <?php } ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-pencil">
                    </i>
                    <?php echo $text_edit; ?>
                </h3>
            </div>
            <div class="panel-body">
                <ul class="nav nav-tabs">
                    <li class="<?php if($tab=='sets_generate') { ?> active <?php } ?>">
                        <a data-toggle="tab" href="#sets_generate">
                            <?php echo $tab_sets_generate;?>
                        </a>
                    </li>
                    <li class="<?php if($tab=='sets_generate2') { ?> active <?php } ?>">
                        <a data-toggle="tab" href="#sets_generate2">
                            <?php echo $tab_sets_generate2;?>
                        </a>
                    </li>
                    <li class="<?php if($tab=='all_sets') { ?> active <?php } ?>">
                        <a data-toggle="tab" href="#all_sets">
                            <?php echo $tab_all_sets;?>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade <?php if($tab=='sets_generate') { ?> in active <?php } ?>" id="sets_generate">
                        <form action="" class="form-horizontal" enctype="multipart/form-data" id="form-sets-manage" method="post">

                            <div class="">
                                <div class="col-md-4">
                                    <button class="btn btn-success" id="add">
                                        <?php echo $btn_add_set;?>
                                    </button>
                                </div>
                                <div class="col-md-4">
                                    <button class="btn btn-default" id="check">
                                        <?php echo $btn_show_count_products; ?>
                                    </button>
                                </div>
                                <div class="col-md-4">
                                    <button class="btn btn-danger" id="clear">
                                        <?php echo $btn_del_set;?>
                                    </button>
                                </div>
                            </div>
                            <div class="clearfix">
                            </div>
                            <div class="result">
                            </div>
                            </hr>
                                <div class="row">
                                   <!--  <div class="text-center">
                                        <h4>
                                            <i class="fa fa-cog fa-2x">
                                            </i>
                                            <?php echo $block_main_setting;?>
                                        </h4>
                                    </div> -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="col-md-5 control-label" for="name">
                                                <?php echo $entry_name; ?>
                                            </label>
                                            <div class="col-md-7">
                                                <?php foreach ($languages as $language) { ?>
                                                <input class="form-control" name="setname[<?php echo $language['language_id'];?>]" placeholder="<?php echo $language['name'];?>" type="text" value="">
                                                    <?php } ?>
                                                </input>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="col-md-5 control-label" for="customer_group">
                                                <?php echo $entry_customer_group; ?>
                                            </label>
                                            <div class="col-md-7">
                                                <select class="form-control" name="customer_group_id">
                                                    <option value='0'>ALL</option>
                                                <?php foreach ($customer_groups as $group) { ?>
                                                <option value="<?php echo $group['customer_group_id'];?>"><?php echo $group['name'];?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="col-md-6 control-label" for="sort">
                                                <?php echo $entry_sort; ?>
                                            </label>
                                            <div class="col-md-6">
                                                <input class="form-control" min="1" name="sort" type="number" value="1"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="col-md-6 control-label" for="status">
                                                <?php echo $entry_status; ?>
                                            </label>
                                            <div class="col-md-6">
                                                <input checked="" class="form-control" name="status" type="checkbox"/>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                </hr>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="text-center">
                                                <h4>
                                                    <i class="fa fa-search fa-2x">
                                                    </i>
                                                    <?php echo $block_search;?>
                                                </h4>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-5 control-label" for="model">
                                                    <?php echo $entry_model; ?>
                                                </label>
                                                <div class="col-md-7">
                                                    <input class="form-control" type="text" id="model" name="model">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-5 control-label" for="cat">
                                                    <?php echo $entry_category; ?>
                                                </label>
                                                <div class="col-md-7">
                                                    <select class="form-control" id="cat" name="cat">
                                                        <option selected="selected" value="">
                                                        </option>
                                                        <?php foreach($cats as $cat) { ?>
                                                        <option value="<?php echo $cat['category_id'];?>">
                                                            <?php echo $cat['name'];?>
                                                        </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-5 control-label" for="manuf">
                                                    <?php echo $entry_manufacturer; ?>
                                                </label>
                                                <div class="col-md-7">
                                                    <select class="form-control" id="manuf" name="manuf">
                                                        <option selected="selected" value="">
                                                        </option>
                                                        <?php foreach($manufs as $man) { ?>
                                                        <option value="<?php echo $man['manufacturer_id'];?>">
                                                            <?php echo $man['name'];?>
                                                        </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-5 control-label" for="name">
                                                    <?php echo $entry_name; ?>
                                                </label>
                                                <div class="col-md-7">
                                                    <input class="form-control" id="name" name="name" type="text">
                                                    </input>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-5 control-label" for="tag">
                                                    <?php echo $entry_tag; ?>
                                                </label>
                                                <div class="col-md-7">
                                                    <input class="form-control" id="tag" name="tag" type="text">
                                                    </input>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-5 control-label" for="descr">
                                                    <?php echo $entry_description; ?>
                                                </label>
                                                <div class="col-md-7">
                                                    <input class="form-control" id="descr" name="descr" type="text">
                                                    </input>
                                                </div>
                                            </div>

                                            <table class="table table-bordered">
                                                <tr>
                                                    <td><?php echo $entry_qunatity; ?></td>
                                                    <td><?php echo $entry_discount; ?></td>
                                                   
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input class="form-control" min="1" name="quantity" type="number" value="1">
                                                        </input>
                                                    </td>
                                                    <td>
                                                        <input class="form-control" name="discount" type="text" value="0">
                                                        </input>
                                                    </td>
                                                 </tr>
                                            </table>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="text-center">
                                                <h4>
                                                    <i class="fa fa-list fa-2x">
                                                    </i>
                                                    <?php echo $block_products;?>
                                                </h4>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-2 control-label" for="input-status">
                                                    <?php echo $entry_products; ?>
                                                </label>
                                                <div class="col-md-10">
                                                    <input class="product_name form-control" name="product_name">
                                                    </input>
                                                </div>
                                            </div>
                                            <table class="table products table-bordered">
                                                <thead>
                                                    <tr>
                                                        <td><?php echo $entry_name;?></td>
                                                        <td><?php echo $entry_qunatity;?></td>
                                                        <td><?php echo $entry_discount;?></td>
                                                        
                                                        <td><?php echo $entry_delete;?></td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                            
                        </form>
                    </div>

                    <div class="tab-pane fade <?php if($tab=='sets_generate2') { ?> in active <?php } ?>" id="sets_generate2">

                     <form action="" class="form-horizontal" enctype="multipart/form-data" id="form-sets-manage2" method="post">
                        <div class="">
                                <div class="">
                                    <button class="btn btn-success" id="add">
                                        <?php echo $btn_add_set;?>
                                    </button>
                                </div>
                            </div>
                            <div class="clearfix">
                            </div>
                            <div class="result">
                            </div>
                            
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="col-md-5 control-label" for="name">
                                                <?php echo $entry_name; ?>
                                            </label>
                                            <div class="col-md-7">
                                                <?php foreach ($languages as $language) { ?>
                                                <input class="form-control" name="setname[<?php echo $language['language_id'];?>]" placeholder="<?php echo $language['name'];?>" type="text" value="">
                                                    <?php } ?>
                                                </input>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="col-md-5 control-label" for="customer_group">
                                                <?php echo $entry_customer_group; ?>
                                            </label>
                                            <div class="col-md-7">
                                                <select class="form-control" name="customer_group_id">
                                                    <option value='0'>ALL</option>
                                                <?php foreach ($customer_groups as $group) { ?>
                                                <option value="<?php echo $group['customer_group_id'];?>"><?php echo $group['name'];?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="col-md-6 control-label" for="sort">
                                                <?php echo $entry_sort; ?>
                                            </label>
                                            <div class="col-md-6">
                                                <input class="form-control" min="1" name="sort" type="number" value="1"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="col-md-6 control-label" for="status">
                                                <?php echo $entry_status; ?>
                                            </label>
                                            <div class="col-md-6">
                                                <input checked="" class="form-control" name="status" type="checkbox"/>
                                            </div>
                                        </div>
                                    </div>

                                     <div class='clearfix'></div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="col-md-9 control-label" for="manuf_conformity">
                                                <?php echo $entry_manuf_conformity;?>
                                            </label>
                                            <div class="col-md-3">
                                                <input class="form-control" name="manuf_conformity" type="checkbox"/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="col-md-6 control-label" for="attr">
                                                <?php echo $entry_attribute;?>
                                            </label>
                                            <div class="col-md-6">
                                                <select name="attr" class="form-control" >
                                                    <option></option>
                                                    <?php foreach($attrs as $attr) { ?>
                                                        <option value="<?php echo $attr['attribute_id'];?>">
                                                        <b><?php echo $attr['attribute_group'];?></b> => <?php echo $attr['name'];?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="col-md-7 control-label" for="abs_limit">
                                                <?php echo $entry_absolute_limit;?>
                                            </label>
                                            <div class="col-md-5">
                                                <input  class="form-control" name="abs_limit" type="number"/>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <hr>
                                    
                                    <div class="row">
                                        <button class="btn btn-primary" type="button" id="addFilter">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        <div class="col-md-6" id='filter_for_products'>

                                            <div class="form-group">
                                                <label class="col-md-5 control-label" for="model">
                                                    <?php echo $entry_model; ?>
                                                </label>
                                                <div class="col-md-7">
                                                    <input class="form-control" type="text" id="model" name="model[]">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-5 control-label" for="cat">
                                                    <?php echo $entry_category; ?>
                                                </label>
                                                <div class="col-md-7">
                                                    <select class="form-control" id="cat" name="cat[]">
                                                        <option selected="selected" value="">
                                                        </option>
                                                        <?php foreach($cats as $cat) { ?>
                                                        <option value="<?php echo $cat['category_id'];?>">
                                                            <?php echo $cat['name'];?>
                                                        </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-5 control-label" for="manuf">
                                                    <?php echo $entry_manufacturer; ?>
                                                </label>
                                                <div class="col-md-7">
                                                    <select class="form-control" id="manuf" name="manuf[]">
                                                        <option selected="selected" value="">
                                                        </option>
                                                        <?php foreach($manufs as $man) { ?>
                                                        <option value="<?php echo $man['manufacturer_id'];?>">
                                                            <?php echo $man['name'];?>
                                                        </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-5 control-label" for="name">
                                                    <?php echo $entry_name; ?>
                                                </label>
                                                <div class="col-md-7">
                                                    <input class="form-control" id="name" name="name[]" type="text">
                                                    </input>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-5 control-label" for="tag">
                                                    <?php echo $entry_tag; ?>
                                                </label>
                                                <div class="col-md-7">
                                                    <input class="form-control" id="tag" name="tag[]" type="text">
                                                    </input>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-5 control-label" for="descr">
                                                    <?php echo $entry_description; ?>
                                                </label>
                                                <div class="col-md-7">
                                                    <input class="form-control" id="descr" name="descr[]" type="text">
                                                    </input>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-5 control-label" for="start">
                                                    START
                                                </label>
                                                <div class="col-md-7">
                                                    <input class='form-control' type='number' name='start[]' value='0'>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-5 control-label" for="limit">
                                                    LIMIT
                                                </label>
                                                <div class="col-md-7">
                                                    <input class='form-control' type='number' name='limit[]' value='5'>
                                                </div>
                                            </div>

                                            <table class="table table-bordered">
                                                <tr>
                                                    <td><?php echo $entry_qunatity; ?></td>
                                                    <td><?php echo $entry_discount; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input class="form-control" min="1" name="quantity[]" type="number" value="1">
                                                        </input>
                                                    </td>
                                                     <td>
                                                        <input class="form-control" name="discount[]" type="text" value="0">
                                                        </input>
                                                    </td>
       
                                                </tr>
                                            </table>
                                        </div>
                                        
                                </div>
                        </form>
                    </div>

                    <div class="tab-pane fade <?php if($tab=='all_sets') { ?> in active <?php } ?>" id="all_sets">
                        <form action="" id="form-sets-clear">
                            <button class="btn btn-danger" id="remove">
                                <?php echo $btn_del_set;?>
                            </button>
                            <div class="result">
                            </div>
                            <?php echo $pagination;?>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <td>
                                            <input id="select_all" type="checkbox"/>
                                        </td>
                                        <td>
                                            <?php echo $column_set_parent;?>
                                        </td>
                                        <td>
                                            <?php echo $column_set_sort;?>
                                        </td>
                                        <td>
                                            <?php echo $column_set_status;?>
                                        </td>
                                        <td>
                                            <?php echo $column_set_name;?>
                                        </td>
                                        <td>
                                            <?php echo $column_set_products;?>
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if($sets) foreach($sets as $key=>
                                    $set) { ?>
                                    <tr>
                                        <td>
                                            <input name="sets[]" type="checkbox" value="<?php echo $key;?>"/>
                                        </td>
                                        <td>
                                            <a href="index.php?route=catalog/product/edit&token=<?php echo $user_token;?>&product_id=<?php echo $set['parent']['product_id'];?>">
                                            <?php echo $set['parent']['name'];?>
                                            </a>
                                        </td>
                                        <td>
                                            <?php echo $set['sort'];?>
                                        </td>
                                        <td>
                                            <?php if($set['status']==1) { ?>
                                            <i class="fa fa-check-circle-o fa-2x">
                                            </i>
                                            <?php } else { ?>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <?php echo $set['name'];?>
                                        </td>
                                        <td>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <?php foreach($set['products'] as $prd) { ?>
                                                    <td class="text-center">
                                                        <?php echo $prd['product_name'];?>
                                                        <br>
                                                            <img src="<?php echo $prd['image'];?>">
                                                                <br>
                                                                    <?php echo $prd['discount'];?>
                                                                </br>
                                                            </img>
                                                        </br>
                                                    </td>
                                                    <?php } ?>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <?php echo $pagination;?>
                        </form>
                    </div>
                    <style>
                        .btn
{
    margin: 0 auto;
    display:table;
}
.result
{
    margin:15px 0;
}
                    </style>
                    <script>
                        function clearAlert()
    {
        $(".alert").remove();
    }
    $( document ).ready(function() {
    $('#select_all').change(function() {
    var checkboxes = $(this).closest('form').find(':checkbox');
    checkboxes.prop('checked', $(this).is(':checked'));
});
});

    $('.products').on('click', '.del_product', function () {
        $(this).parents('tr').remove();
        return false;
    });
    $('#form-sets-manage').on('click', '#check', function () {
        var data = $('#form-sets-manage input,#form-sets-manage select,#form-sets-manage checkbox').serialize();

        $.ajax({
            url: 'index.php?route=extension/module/sets_manage/check&token=<?php echo $user_token; ?>',
            method: 'POST',
            data: data,
            success: function (json) {

                if (json['error']) {
                    $("#form-sets-manage .result").html('<div class=\'alert alert-danger\'>' + json['error'] + '</div>')
                }
                if(json['success']) {
                    $("#kjmodal").remove();
                    html='<div class="modal fade" id="kjmodal">';
                    html+='<div class="modal-dialog">';
                        html+='<div class="modal-content">';
                         html+='<div class="modal-header">';
                            html+='<button type="button" class="close" data-dismiss="modal">&times;</button>';
                          html+='</div>';

                          
                          html+='<div class="modal-body">';
                            html+=json['success'];
                          html+='</div>';

                          
                          html+='<div class="modal-footer">';
                            html+='<button type="button" class="btn btn-danger" data-dismiss="modal">X</button>';
                          html+='</div>';

                        html+='</div>';
                      html+='</div>';
                    html+='</div>';
                    $("body").append(html);
                    $("#kjmodal").modal()
                }

                setTimeout(clearAlert,2000);
            }
        });

        return false;
    });


    $('#form-sets-manage').on('click', '#add', function () {
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

                setTimeout(clearAlert,2000);
            }
        });

        return false;
    });

    $('#form-sets-clear').on('click', '#remove', function () {
       var data = $('#form-sets-clear').serialize();
        $.ajax({
            url: 'index.php?route=extension/module/sets_manage/removeSets&token=<?php echo $user_token; ?>',
            method: 'POST',
            data: data,
            success: function (json) {

                if (json['error']) {
                    $("#form-sets-clear .result").html('<div class=\'alert alert-danger\'>' + json['error'] + '</div>')
                }

                if (json['success']) {
                    $("#form-sets-clear .result").html('<div class=\'alert alert-success\'>' + json['success'] + '</div>');
                    $("#form-sets-clear tbody input:checked").parents("tr").remove();
                }

                setTimeout(clearAlert,3000);
            }
        });
        return false;
    });

    

    $('#form-sets-manage').on('click', '#clear', function () {
        var data = $('#form-sets-manage input,#form-sets-manage select,#form-sets-manage checkbox').serialize();
        $.ajax({
            url: 'index.php?route=extension/module/sets_manage/clear&token=<?php echo $user_token; ?>',
            method: 'POST',
            data: data,
            success: function (json) {

                if (json['error']) {
                    $("#form-sets-manage .result").html('<div class=\'alert alert-danger\'>' + json['error'] + '</div>')
                }

                if (json['success']) {
                    $("#form-sets-manage .result").html('<div class=\'alert alert-success\'>' + json['success'] + '</div>')
                }

                setTimeout(clearAlert,3000);
            }
        });
        return false;
    });

    $('#form-sets-manage2').on('click', '#addFilter', function () {
        $("#filter_for_products").parent().append("<div class='col-md-6'>"+$("#filter_for_products").html()+"</div>");
    });


    $('#form-sets-manage2').on('click', '#add', function () {
        var data = $('#form-sets-manage2 input,#form-sets-manage2 select,#form-sets-manage2 checkbox').serialize();

        $.ajax({
            url: 'index.php?route=extension/module/sets_manage/add2&token=<?php echo $user_token; ?>',
            method: 'POST',
            data: data,
            success: function (json) {

                if (json['error']) {
                    $("#form-sets-manage2 .result").html('<div class=\'alert alert-danger\'>' + json['error'] + '</div>')
                }

                if (json['success']) {
                    $("#form-sets-manage2 .result").html('<div class=\'alert alert-success\'>' + json['success'] + '</div>')
                }

                setTimeout(clearAlert,2000);
            }
        });

        return false;
    });




    function autocomplete_select(item) {
        var new_row = "<?php echo $row;?>";
        var i = $('.products tbody tr:last').index() + 1 + 1;

        new_row = new_row.replace(/{pi}/g, i);

        new_row = $(new_row);


        $(new_row).find('.product_name input[type="text"]').val(item['label']);
        $(new_row).find('.product_name input[type="hidden"]').val(item['value']);
        $(new_row).find('.old_price input').val(item['price']);
        $(new_row).find('.new_price input').val(item['price']);


        $('.products tbody').append(new_row);

        if (item['option'].length)
            $.ajax({
                method: 'POST',
                url: 'index.php?route=extension/module/sets/optionsForms&token=<?php echo $user_token; ?>',
                data: {options: item['option']},
                success: function (data) {
                    data = data.replace(/set\[{si}\]\[products\]\[{pi}\]/g, 'products[' + i + ']');

                    $(new_row).find('.option .modal-body').html(data);


                }
            });


    }

    function autocomplete_source(request, response) {


        $.ajax({
            url: 'index.php?route=extension/module/sets/autocomplete&token=<?php echo $user_token; ?>&filter_name=' + encodeURIComponent(request),
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

    $(document).ready(function () {
        $('.product_name').autocomplete({'source': autocomplete_source,'select': autocomplete_select});
    });
                    </script>
                    <?php echo $footer; ?>
                </div>
            </div>
        </div>
    </div>
</div>