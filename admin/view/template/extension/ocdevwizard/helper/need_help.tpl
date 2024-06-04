<div id="service-modal-body" class="mw500 service-modal-body">
	<!--
	##========================================================##
	## @author    : OCdevWizard                               ##
	## @contact   : ocdevwizard@gmail.com                     ##
	## @support   : http://help.ocdevwizard.com               ##
	## @license   : Distributed on an "AS IS" basis           ##
	## @copyright : (c) OCdevWizard. OCdevWizard Helper, 2014 ##
	##========================================================##
	-->
	<div class="modal-heading">
		<?php echo $button_need_help; ?> <span class="modal-close" onclick="$.magnificPopup.close();"><i class="fa fa-times" aria-hidden="true"></i></span>
	</div>
	<div class="modal-body">
		<div id="service-modal-data">
			<div class="row" style="padding-bottom: 0;">
				<div class="panel-body" style="padding-top: 0;">
					<form method="post" enctype="multipart/form-data" class="form-horizontal">
						<div class="row">
							<input type="hidden" name="module_name" value="" />
							<div class="form-group required">
								<label class="col-sm-12 control-label"><?php echo $entry_email; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
								<div class="col-sm-12">
									<input type="text" name="email" value="" class="form-control" id="modal-email" autocomplete="off"/>
									<div class="alert alert-info" style="display: none;"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> <?php echo $entry_email_faq; ?></div>
								</div>
							</div>
							<div class="form-group required">
								<label class="col-sm-12 control-label"><?php echo $entry_order_id; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
								<div class="col-sm-12">
									<input type="text" name="order_id" value="" class="form-control" id="modal-order-id" autocomplete="off"/>
									<div class="alert alert-info" style="display: none;"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> <?php echo $entry_order_id_faq; ?></div>
								</div>
							</div>
							<div class="form-group required">
								<label class="col-sm-12 control-label"><?php echo $entry_marketplace; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
								<div class="col-sm-12">
									<select name="marketplace" class="form-control" id="modal-marketplace">
										<option value=""><?php echo $text_make_a_choice; ?></option>
										<option value="Opencart.com">Opencart.com</option>
										<option value="Opencartforum.com">Opencartforum.com</option>
										<option value="Liveopencart.ru">Liveopencart.ru</option>
										<option value="Opencart-russia.ru">Opencart-russia.ru</option>
										<option value="Prodelo.biz">Prodelo.biz</option>
									</select>
									<div class="alert alert-info" style="display: none;"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> <?php echo $entry_marketplace_faq; ?></div>
								</div>
							</div>
							<div class="form-group required">
								<label class="col-sm-12 control-label"><?php echo $entry_message; ?></label>
								<div class="col-sm-12">
									<textarea name="message" class="form-control" id="modal-message" autocomplete="off"></textarea>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="modal-footer" id="service-modal-footer">
		<button class="btn btn-default" onclick="$.magnificPopup.close();"><span class="hidden-md hidden-lg"><i class="fa fa-times" aria-hidden="true"></i> </span><span class="hidden-xs hidden-sm"><?php echo $button_close; ?></span></button>
		<button class="btn btn-success button-loading" onclick="submit_need_help(this, 'close');"><span class="hidden-md hidden-lg"><i class="fa fa-save"></i> </span><span class="hidden-xs hidden-sm"><?php echo $button_send; ?></span></button>
	</div>
</div>
<script>
	$('#service-modal-data input[name=\'module_name\']').val($('#content h1').html());

	function submit_need_help(element, after_action = '') {
    $.ajax({
      type: 'post',
      url: 'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/need_help_action&<?php echo $token; ?>',
      data: $('#service-modal-body form').serialize(),
      dataType: 'json',
      beforeSend: function () {
        $(element).prop('disabled', true);
        $(element).html('<div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>');
      },
      complete: function () {
        $(element).prop('disabled', false);
        $(element).html('<span class="hidden-md hidden-lg"><i class="fa fa-save"></i> </span><span class="hidden-xs hidden-sm"><?php echo $button_send; ?></span>');
      },
      success: function (json) {
        notify_close();
        
        if (json['error']) {
          for (i in json['error']) {
            notify({a:'modal-' + i.replace(/_/g, '-'),b:'<?php echo $text_alert_error_heading; ?>',c:json['error'][i],e:'<?php echo $button_fix; ?>',f:'<?php echo $button_cancel; ?>'});
          }
        }
        
        if (json['success']) {
          if (after_action == 'close') {
            $.magnificPopup.close();
          }
          notify({b:'<?php echo $text_alert_success_heading; ?>',c:json['success'],d:'success'});
        }
      }
    });
  }
</script>