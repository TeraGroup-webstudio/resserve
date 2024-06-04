<?php
##=================================================##
## @author    : OCdevWizard                        ##
## @contact   : ocdevwizard@gmail.com              ##
## @support   : http://help.ocdevwizard.com        ##
## @copyright : (c) OCdevWizard. Price Alert, 2018 ##
##=================================================##
?>
<div id="service-modal-body">
	<div class="modal-heading">
		<?php echo $text_modal_heading; ?> <span class="modal-close" onclick="$.magnificPopup.close();"><i class="fa fa-times" aria-hidden="true"></i></span>
	</div>
	<div class="modal-body">
		<div id="service-modal-data">
			<div id="modal-sms-template-constructor-content">
				<div id="content" class="row pb-0">
					<div class="panel-body pt-0 pb-0">
						<ul class="nav nav-tabs" id="modal-setting-tabs">
							<li class="active"><a href="#modal-general-block" data-toggle="tab"><i class="fa fa-cogs"></i> <?php echo $tab_general_setting; ?></a></li>
							<li><a href="#modal-sms-template-block" data-toggle="tab"><i class="fa fa-cogs"></i> <?php echo $tab_sms_template_setting; ?></a></li>
						</ul>
						<form method="post" enctype="multipart/form-data" id="modal-form" class="form-horizontal">
							<input type="hidden" style="display:none;" name="template_id" value="<?php echo $template_id; ?>"/>
							<div class="tab-content row">
								<!-- TAB Modal general block -->
								<div class="tab-pane fade active in" role="tabpanel" id="modal-general-block">
									<div class="form-group">
										<label class="col-sm-12 control-label"><?php echo $entry_status; ?></label>
										<div class="col-sm-12">
											<select name="status" class="form-control">
												<option value="1" <?php echo $status == 1 ? 'selected="selected"' : ''; ?>><?php echo $text_enabled; ?></option>
												<option value="0" <?php echo $status == 0 ? 'selected="selected"' : ''; ?>><?php echo $text_disabled; ?></option>
											</select>
										</div>
									</div>
									<div class="form-group required">
										<label class="col-sm-12 control-label"><?php echo $entry_system_name; ?></label>
										<div class="col-sm-12">
											<input value="<?php echo $system_name; ?>" type="text" name="system_name" class="form-control" id="modal-error-system-name"/>
										</div>
									</div>
									<div class="form-group required">
										<label class="col-sm-12 control-label"><?php echo $text_assignment_sms_template; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
										<div class="col-sm-12">
											<select name="assignment" class="form-control" id="modal-error-assignment">
												<option value="0" <?php echo $assignment == 0 ? 'selected="selected"' : ''; ?>><?php echo $text_make_a_choice; ?></option>
												<option value="1" <?php echo $assignment == 1 ? 'selected="selected"' : ''; ?>><?php echo $text_assignment_sms_template_1; ?></option>
												<option value="2" <?php echo $assignment == 2 ? 'selected="selected"' : ''; ?>><?php echo $text_assignment_sms_template_2; ?></option>
											</select>
											<div class="alert alert-info" role="alert"><?php echo $text_assignment_sms_template_faq; ?></div>
										</div>
									</div>
								</div>
								<!-- TAB Email template block -->
								<div class="tab-pane fade" role="tabpanel" id="modal-sms-template-block">
									<div class="form-group required">
										<label class="col-sm-12 control-label"><?php echo $text_sms_template_html; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
										<div class="col-sm-12">
											<?php foreach ($languages as $language) { ?>
											<div class="input-group mb-5">
												<span class="input-group-addon"><img src="<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span>
												<textarea name="template_description[<?php echo $language['language_id']; ?>][template]" id="modal-error-template-description-language-template-<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($template_description[$language['language_id']]) ? $template_description[$language['language_id']]['template'] : ''; ?></textarea>
											</div>
											<?php } ?>
											<div class="assignment-sms-template-1-instruction">
												<div class="alert alert-info short-codes" role="alert"><?php echo $text_assignment_sms_template_1_template; ?></div>
											</div>
											<div class="assignment-sms-template-2-instruction">
												<div class="alert alert-info short-codes" role="alert"><?php echo $text_assignment_sms_template_2_template; ?></div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal-footer" id="service-modal-footer">
		<button class="btn btn-default" onclick="$.magnificPopup.close();"><span class="hidden-lg hidden-md hidden-sm"><i class="fa fa-times" aria-hidden="true"></i> </span><span class="hidden-xs"><?php echo $button_close; ?></span></button>
		<button class="btn btn-success button-loading" onclick="submit_sms_template({a:this,b:'close'});"><span class="hidden-lg hidden-md hidden-sm"><i class="fa fa-save"></i> </span><span class="hidden-xs"><?php echo $button_save; ?></span></button>
		<?php if ($template_id) { ?>
		<button class="btn btn-success button-loading" onclick="submit_sms_template({a:this});"><span class="hidden-lg hidden-md hidden-sm"><i class="fa fa-save"></i> + <i class="fa fa-refresh"></i> </span><span class="hidden-xs"><?php echo $button_save_and_stay; ?></span></button>
		<?php } ?>
	</div>
	<script>
		function block_visibility_instructions(options) {
			var tab = options.a || '';

			if (tab == 'modal-sms-template-constructor-content') {
			  $('.button-view-shortcodes-instruction').hide();
				$('.assignment-sms-template-1-instruction').hide();
				$('.assignment-sms-template-2-instruction').hide();

				if ($('select[name=assignment]').val() == '1') {
					$('.button-view-shortcodes-instruction').show();
					$('.assignment-sms-template-1-instruction').show();
				} else if ($('select[name=assignment]').val() == '2') {
					$('.button-view-shortcodes-instruction').show();
					$('.assignment-sms-template-2-instruction').show();
				}
			}
		}

		$('select[name=assignment]').change(function() {
			block_visibility_instructions({a:'modal-sms-template-constructor-content'});
		});

		block_visibility_instructions({a:'modal-sms-template-constructor-content'});
	</script>
</div>