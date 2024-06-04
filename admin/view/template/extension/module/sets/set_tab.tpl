<div class="tab-pane" id="tab-set">

    <input type='hidden' name='set_product_id' value='<?php echo $product_id;?>'>
    <div class='save_result'></div>
    <button id='add_set' type='button' class='btn btn-complete'><?php echo $entry_add_set;?></button>
    <button id='save_sets' type='button' class='btn btn-success'><?php echo $entry_save_sets;?></button>


    <div class='clearfix'></div>
    <?php if(isset($sets)) { ?>
    <?php echo $sets;?>
    <script>
        $(document).ready(function () {

            $('.set').find('.search_product_name input[name="product_name"]').autocomplete({'source': autocomplete_source,'select': autocomplete_select});
        });
    </script>
    <?php } ?>

</div>
<script>
    var c;
    var focused;
    
    $(document).ready(function () {
        $(document).on('focusin', "input[name='product_name']", function () {
           focused = $(this);
       });
    });
    function clearAlert()
    {
        $(".alert").remove();
    }

    $("#tab-set").on('click', '#save_sets', function () {
        var data = $("#tab-set").find('select, textarea, input').serialize();
        $.ajax({
            url: 'index.php?route=extension/module/sets/saveSets&token=<?php echo $user_token; ?>',
            method: 'POST',
            data: data,
            success: function (json) {

                if (json['error']) {
                    $("#tab-set .save_result").html('<div class=\'alert alert-danger\'>' + json['error'] + '</div>')
                }

                if (json['success']) {
                    $("#tab-set .save_result").html('<div class=\'alert alert-success\'>' + json['success'] + '</div>')
                }
                setTimeout(clearAlert,3000);
            }
        });
        return false;
    });

    function getKey()
    {
        if ($('.set').length > 0)
        {
            maximum = 0;
            $('.set').each(function () {
                var value = parseFloat($(this).attr('key'));
                maximum = (value > maximum) ? value : maximum;
            });

            ++maximum;
            return maximum;
        } else
        return 1;
    }

    $("#tab-set").on('click', '#add_set', function () {
        var set_table = `<?php echo $set_clear_form;?>`;
        var key = getKey();
        set_table = set_table.replace(/{si}/g, key);
        set_table = $(set_table).attr('key', key);

        $(set_table).find('.search_product_name input[name="product_name"]').autocomplete({'source': autocomplete_source,'select': autocomplete_select});
        $("#tab-set").append(set_table);
        return false;
    });

    $('#tab-set').on('click', '.set .del_product', function () {
        $(this).parents('tr').remove();
        return false;
    });

    $('#tab-set').on('click', '.set .del_set', function () {
        $(this).parents('.set').remove();
        return false;
    });

    $('#tab-set').on('change', '.set .quantity input', function () {
        c = $(this).parents('.set');

    });



    function get_new_row(key, numrow)
    {
        var row = "<?php echo $set_row;?>";
        row = row.replace(/{si}/g, key);
        row = row.replace(/{pi}/g, numrow);
        return row;
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
                        option: item['option']
                    }
                }));
            }
        });
    }

    function autocomplete_select(item) {
        c = $(focused).parents('.set');
        numrow = $(c).find('.product_row').length + 1;
        key = $(c).attr('key');
        var new_row = $(get_new_row(key, numrow));
        $(new_row).find('.product_name input[type="text"]').val(item['label']);
        $(new_row).find('.product_name input[type="hidden"]').val(item['value']);

        if (item['option'].length)
        {
            /*
            $.ajax({
                method: 'POST',
                url: 'index.php?route=extension/module/sets/optionsForms&token=<?php echo $user_token; ?>',
                data: {options: item['option']},
                success: function (data) {
                    data = data.replace(/{si}/g, key);
                    data = data.replace(/{pi}/g, numrow);
                    $(new_row).find('.options .modal .modal-body').html(data);
                }
            });
            $(new_row).find('.options select option').prop('disabled', false);
            */
        } else
        {
            $(new_row).find('.options button').remove();
            $(new_row).find('.options select option[disabled="disabled"]').remove();
        }


        $(c).find('.search_row').before(new_row);
    }
</script>
<style>
.set
{
    max-width: 700px;
    margin:10px auto;
}
.set .table
{
    background-color: #F5F5F5;
}
.set input[type=number]
{
    width:75px;
}
.set .total input
{
    font-size: 16px;
    font-weight: bold;
}

.set .product_name
{
    font-weight: bold;
}

</style>