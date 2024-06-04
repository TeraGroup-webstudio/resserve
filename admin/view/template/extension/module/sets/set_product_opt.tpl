<?php if($options) { ?>
<div class='col-sm-12'>
    <?php foreach ($options as $option) { ?>

    <?php if($option['type'] == 'select') { ?>
    <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
        <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
        <select name="set[{si}][products][{pi}][option][<?php echo $option['product_option_id']; ?>]" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control">
            <?php foreach ($option['product_option_value'] as $option_value) { ?>
            <option value="<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
                <?php if((int)$option_value['price']) { ?>
                (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                <?php } ?>
            </option>
            <?php } ?>
        </select>
    </div>
    <?php } ?>

    <?php if($option['type'] == 'radio') { ?>
    <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
        <label class="control-label"><?php echo $option['name']; ?></label>
        <div id="input-option<?php echo $option['product_option_id']; ?>">
            <?php foreach ($option['product_option_value'] as $option_value) { ?>
            <div class="radio">
                <label>
                    <input type="radio" name="set[{si}][products][{pi}][option][<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" />
                    <?php echo $option_value['name']; ?>
                    <?php if((int)$option_value['price']) { ?>
                    (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                    <?php } ?>
                </label>
            </div>
            <?php } ?>
        </div>
    </div>
    <?php } ?>

    <?php if($option['type'] == 'checkbox') { ?>
    <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
        <label class="control-label"><?php echo $option['name']; ?></label>
        <div id="input-option<?php echo $option['product_option_id']; ?>">
            <?php foreach ($option['product_option_value'] as $option_value) { ?>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="set[{si}][products][{pi}][option][<?php echo $option['product_option_id']; ?>][]" value="<?php echo $option_value['product_option_value_id']; ?>" />
                     <?php if(isset($option_value['image']) && !empty($option_value['image'])) { ?>
                    <img src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" class="img-thumbnail" /> 
                    <?php } ?>
                    <?php echo $option_value['name']; ?>
                    <?php if((int)$option_value['price']) { ?>
                    (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                    <?php } ?>
                </label>
            </div>
            <?php } ?>
        </div>
    </div>
    <?php } ?>

    <?php if($option['type'] == 'image') { ?>
    <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
        <label class="control-label"><?php echo $option['name']; ?></label>
        <div id="input-option<?php echo $option['product_option_id']; ?>">
            <?php foreach ($option['product_option_value'] as $option_value) { ?>
            <div class="radio">
                <label>
                    <input type="radio" name="set[{si}][products][{pi}][option][<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" />
                    <?php if(isset($option_value['image']) && !empty($option_value['image'])) { ?>
                    <img src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" class="img-thumbnail" /> <?php echo $option_value['name']; ?>
                    <?php } ?>
                    <?php if((int)$option_value['price']) { ?>
                    (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                    <?php } ?>
                </label>
            </div>
            <?php } ?>
        </div>
    </div>
    <?php } ?>

    <?php if($option['type'] == 'text' || $option['type'] == 'file') { ?>
    <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
        <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
        <input type="text" name="set[{si}][products][{pi}][option][<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" placeholder="<?php echo $option['name']; ?>" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
    </div>
    <?php } ?>

    <?php if($option['type'] == 'textarea') { ?>
    <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
        <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
        <textarea name="set[{si}][products][{pi}][option][<?php echo $option['product_option_id']; ?>]" rows="5" placeholder="<?php echo $option['name']; ?>" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control"><?php echo $option['value']; ?></textarea>
    </div>
    <?php } ?>

    <?php if($option['type'] == 'date') { ?>
    <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
        <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
        
            <input type="date" name="set[{si}][products][{pi}][option][<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
       
    </div>
    <?php } ?>

    <?php if($option['type'] == 'datetime') { ?>
    <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
        <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
        
            <input type="datetime" name="set[{si}][products][{pi}][option][<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
        
    </div>
    <?php } ?>

    <?php if($option['type'] == 'time') { ?>
    <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
        <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
      
            <input type="time" name="set[{si}][products][{pi}][option][<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
       
    </div>
    <?php } ?>
    <?php } ?>
</div>
<div class='clearfix'></div>
<?php } ?>