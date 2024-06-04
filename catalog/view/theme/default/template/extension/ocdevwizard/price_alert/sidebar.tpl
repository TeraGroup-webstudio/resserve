<?php
##=================================================##
## @author    : OCdevWizard                        ##
## @contact   : ocdevwizard@gmail.com              ##
## @support   : http://help.ocdevwizard.com        ##
## @copyright : (c) OCdevWizard. Price Alert, 2018 ##
##=================================================##
?>
<div id="<?php echo $_code; ?>-block">
  <div class="inner-header">
    <?php echo $heading_title; ?>
    <?php if ($popup_close_btn_inside) { ?>
      <span class="modal-close" onclick="<?php echo $_code; ?>_sidebar_close('<?php echo $product_id ?>');"><i class="fa fa-times" aria-hidden="true"></i></span>
    <?php } ?>
  </div>
  <div class="inner-center">
    <?php if ($show_description == 1) { ?>
      <div class="additional-information top"><?php echo $description; ?></div>
    <?php } ?>
    <form id="<?php echo $_code; ?>-form">
      <input name="product_id" type="hidden" value="<?php echo $product_id ?>" />
      <input name="product_option_id" type="hidden" value="<?php echo $product_option_id ?>" />
      <input name="product_option_value_id" type="hidden" value="<?php echo $product_option_value_id ?>" />
      <input name="record_type" type="hidden" value="<?php echo $record_type ?>" />
      <?php if ($fields_data) { ?>
        <div class="inner-fields">
          <?php foreach ($fields_data as $field) { ?>
            <div
              data-error-row="<?php echo $field_row; ?>"
              <?php if ($field['field_mask'] && $field['field_type'] == 'telephone') { ?>data-mask="<?php echo $field['field_mask']; ?>"<?php } ?>
              <?php if ($field['css_id']) { ?>id="<?php echo $field['css_id']; ?>"<?php } ?>
              <?php if ($field['css_class']) { ?>class="<?php echo $field['css_class']; ?>"<?php } ?>
            >
              <?php if ($field['title_status'] && $field['field_type'] != 'title') { ?>
                <label class="field-heading"><?php echo $field['name']; ?><?php if ($field['required'] > '0') { ?> <span class="required-indicator">*</span><?php } ?></label>
              <?php } ?>
              <div class="inner-field<?php if ($field['icon']) { ?> with-icon<?php } ?>">
                <?php if ($field['icon'] && $field['field_type'] != 'title') { ?>
                  <img src="<?php echo $field['icon']; ?>" alt="" />
                <?php } ?>
                <?php if ($field['field_type'] == 'email') { ?>
                  <input name="field[<?php echo $field_row; ?>][<?php echo $field['field_id']; ?>]" type="email" value="<?php echo $field['value']; ?>" <?php echo ($field['placeholder']) ? 'placeholder="'.$field['placeholder'].'"' : "" ; ?>/>
                <?php } else if ($field['field_type'] == 'telephone') { ?>
                  <input name="field[<?php echo $field_row; ?>][<?php echo $field['field_id']; ?>]" type="tel" value="<?php echo $field['value']; ?>" <?php echo ($field['placeholder']) ? 'placeholder="'.$field['placeholder'].'"' : "" ; ?>/>
                <?php } else if ($field['field_type'] == 'firstname') { ?>
                  <input name="field[<?php echo $field_row; ?>][<?php echo $field['field_id']; ?>]" type="text" value="<?php echo $field['value']; ?>" <?php echo ($field['placeholder']) ? 'placeholder="'.$field['placeholder'].'"' : "" ; ?>/>
                <?php } else if ($field['field_type'] == 'lastname') { ?>
                  <input name="field[<?php echo $field_row; ?>][<?php echo $field['field_id']; ?>]" type="text" value="<?php echo $field['value']; ?>" <?php echo ($field['placeholder']) ? 'placeholder="'.$field['placeholder'].'"' : "" ; ?>/>
                <?php } else if ($field['field_type'] == 'title') { ?>
                  <div <?php echo ($field['css_id']) ? 'id="'.$field['css_id'].'"' : "" ; ?> class="block-title <?php echo ($field['css_class']) ? $field['css_class'] : "" ; ?>"><?php echo $field['name']; ?></div>
                <?php } ?>
              </div>
              <?php if ($field['description']) { ?>
                <div class="field-description"><?php echo $field['description']; ?></div>
              <?php } ?>
            </div>
            <?php $field_row++; ?>
          <?php } ?>
          <?php if ($informations) { ?>
            <div data-error-row="require_information" class="require-information">
              <div class="inner-field">
                <div class="field-checkbox">
                  <input type="checkbox" name="require_information" value="<?php echo $require_information ? 1 : 0; ?>" id="require-information-<?php echo $product_id; ?>"/>
                  <label for="require-information-<?php echo $product_id; ?>"><span><?php echo $informations; ?></span></label>
                </div>
              </div>
            </div>
          <?php } ?>
          <?php if ($captcha_status) { ?>
            <div data-error-row="recaptcha">
              <div class="inner-field">
                <script src="https://www.google.com/recaptcha/api.js"></script>
                <div class="g-recaptcha" data-sitekey="<?php echo $captcha_site_key; ?>" data-error-row="recaptcha"></div>
              </div>
            </div>
          <?php } ?>
        </div>
      <?php } ?>
    </form>
    <?php if ($show_description == 2) { ?>
      <div class="info-text-block bottom"><?php echo $description; ?></div>
    <?php } ?>
  </div>
  <div class="inner-footer">
    <button type="button" onclick="<?php echo $_code; ?>_sidebar_close('<?php echo $product_id ?>');" class="close-modal"><?php echo $button_go_back; ?></button>
    <button type="button" onclick="<?php echo $_code; ?>_submit_record({a:this});" class="save-form button-loading"><?php echo $button_save; ?></button>
  </div>
  <script>
    <?php echo $_code; ?>_prepare_form({a:'#<?php echo $_code; ?>-form .inner-fields > div'});

    function <?php echo $_code; ?>_submit_record(options) {
      var element = options.a || '';

      <?php if ($captcha_status) { ?>
      var url = 'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/record_action&recaptcha='+grecaptcha.getResponse();
      <?php } else { ?>
      var url = 'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/record_action';
      <?php } ?>

      $.ajax({
        url: url,
        type: 'post',
        dataType: 'json',
        data: $('#<?php echo $_code; ?>-form').serialize(),
        beforeSend: function() {
          $(element).prop('disabled', true);
          $(element).html('<div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>');
        },
        complete: function() {
          $(element).prop('disabled', false);
        },
        success: function(json) {
          $('#<?php echo $_code; ?>-form .success-text, #<?php echo $_code; ?>-form .error-text').remove();
          $('#<?php echo $_code; ?>-form').find('.error-style').removeClass('error-style');
          $(element).html(json['button_save']);

          if (json['error']) {
            if (json['error']['field']) {
              for (i in json['error']['field']) {
                $('#<?php echo $_code; ?>-form [data-error-row='+i+']').addClass('error-style');

                if ($('#<?php echo $_code; ?>-form [data-error-row='+i+'] .field-description').length) {
                  $('#<?php echo $_code; ?>-form [data-error-row='+i+'] .field-description').after('<div class="error-text">'+json['error']['field'][i]+'</div>');
                } else {
                  $('#<?php echo $_code; ?>-form [data-error-row='+i+'] .inner-field').after('<div class="error-text">'+json['error']['field'][i]+'</div>');
                }
              }
            }
          } else {
            if (json['output']) {
              $(element).remove();
              $('#<?php echo $_code; ?>-block .inner-center').html(json['output']);
              <?php if ($analytic_code) { ?>
                <?php echo $analytic_code; ?>
              <?php } ?>
            }
          }
        }
      });
    }

    $('body').click(function(e) {
      if (!$(e.target).closest('#<?php echo $_code; ?>-sidebar .<?php echo $_code; ?>-sidebar-body').length) {
        <?php echo $_code; ?>_sidebar_close('<?php echo $product_id ?>');
      }
    });

    $(document).on('keydown', function(e) {
      if (e.keyCode === 27) {
        <?php echo $_code; ?>_sidebar_close('<?php echo $product_id ?>');
      }
    });
  </script>
</div>