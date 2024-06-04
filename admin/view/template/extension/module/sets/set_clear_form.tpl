<div class='set' key=''>
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

            <input type='text' name='set[{si}][name][<?php echo $language['language_id'];?>]' placeholder='<?php echo $language['name'];?>' value='' class='form-control'/>

        </div>
        <?php } ?>
    </td>
         <td >
            <select class='form-control'  name='set[{si}][customer_group_id]'>>
                 <option value='0'>ALL</option>
            <?php foreach ($customer_groups as $gr) { ?>
             <option value='<?php echo $gr['customer_group_id'];?>'><?php echo $gr['name'];?></option>
            <?php } ?>
        </select>
        </td>
                 <td >
            <input type='datetime-local' class='form-control' name='set[{si}][enddate]'>
         </td>
    <td>
        <input type='number' min='0' value='1' class='form-control' name='set[{si}][sort]'>
        status: <input type='checkbox' checked='checked' name='set[{si}][status]'>
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
<tr class='product_row'>
    <td class='product_name'>
        <input type='text' class='form-control' readonly name='set[{si}][products][1][product_name]' value='<?php echo $product_name;?>'> 
        <input type='hidden' name='set[{si}][products][1][product_id]' value='<?php echo $product_id;?>'>
    </td>
    <td class='quantity'>
        <input type='number' name='set[{si}][products][1][quantity]' min='1' value='1' class='form-control'>
    </td>

<td>
    <input type='text' value='0' class='form-control' name='set[{si}][products][1][discount]'>
</td>
<td class='delete'>
    <button class='btn btn-warning del_product'><i class='fa fa-minus'></i></button>
</td>
</tr>

<tr class='search_row'>
    <td class='search_product_name' colspan='6'>
        <input type='text' name='product_name' class='form-control'>
    </td>
</tr>
</table>
</div>