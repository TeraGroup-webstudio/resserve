<div class='set' key='<?php echo $key;?>'>
    <table class='table table-bordered'>
        <tr>
           <td>
            <?php echo $entry_set_name;?>
        </td>
        <td >
            <?php echo $entry_customer_group;?>
        </td>
        <td>
            DATE
        </td>

            <td>
                <?php echo $entry_sort;?>
            </td>
        </tr>
        <tr>
           <td>
            <?php foreach ($languages as $language) { ?>
            <div class='input-group pull-left'>
                <input type='text' value="<?php echo $name[$language['language_id']];?>" name="set[<?php echo $key;?>][name][<?php echo $language['language_id'];?>]" placeholder="<?php echo $language['name'];?>" class="form-control"/>
            </div>
            <?php } ?>
        </td>
            </td>
         <td >
            <select class='form-control'  name='set[<?php echo $key;?>][customer_group_id]'>
                 <option value='0' <?php if($customer_group_id==0) {?> selected <?php } ?>>ALL</option>
            <?php foreach ($customer_groups as $gr) { ?>
             <option <?php if($customer_group_id==$gr['customer_group_id']) {?> selected <?php } ?> value='<?php echo $gr['customer_group_id'];?>'><?php echo $gr['name'];?></option>
            <?php } ?>
        </select>
        </td>
         <td >
            <input type='datetime-local' value='<?php if($enddate) echo date("Y-m-d\TH:i:s",$enddate); ?>' class='form-control' name='set[<?php echo $key;?>][enddate]'>
         </td>
        <td>
            <input type='number' min='0' value='<?php echo $sort;?>' class='form-control' name='set[<?php echo $key;?>][sort]'>
            status: <input type='checkbox' <?php if($status) { ?> checked <?php } ?> name='set[<?php echo $key;?>][status]'>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $entry_name;?>
        </td>
        <td>
            <?php echo  $entry_quantity;?>
        </td>

        <td>
            <?php echo $entry_discount;?>
        </td>
        <td>
            <button class='btn btn-danger del_set' class=''><i class='fa fa-close'></i></button>
        </td>
    </tr>
    <?php

    $i=1;

    foreach($products as $product) { 
    ?>
    <tr class='product_row'>
        <td class='product_name'>
            <input type='text' class='form-control' readonly name='set[<?php echo $key;?>][products][<?php echo $i;?>][product_name]' value='<?php echo $product["product_name"];?>'>
            <input type='hidden' name='set[<?php echo $key;?>][products][<?php echo $i;?>][product_id]' value='<?php echo $product["product_id"];?>'>
        </td>

        <td class='quantity'>
            <input type='number' name='set[<?php echo $key;?>][products][<?php echo $i;?>][quantity]' min='1' value='<?php echo $product["quantity"];?>' class='form-control'>
        </td>

   
        <td>
            <input type='text' value='<?php echo $product["discount"];?>' class='form-control' name='set[<?php echo $key;?>][products][<?php echo $i;?>][discount]'>
        </td>
        <td class='delete'>
            <button class='btn btn-warning del_product'><i class='fa fa-minus'></i></button>
        </td>
    </tr>
    <?php 
    $i++;
} ?>

<tr class='search_row'>
    <td class='search_product_name' colspan='7'>
        <input type='text' name='product_name' class='form-control'>
    </td>
</tr>
</table>
</div>