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
			<div id="modal-field-content">
				<div id="content" class="row pb-0">
					<div class="panel-body pt-0 pb-0">
						<ul class="nav nav-tabs" id="modal-setting-tabs">
							<li class="active dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-cog"></i> <?php echo $tab_control_panel; ?> <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="#modal-field-general-block" data-toggle="tab"><i class="fa fa-cogs"></i> <?php echo $tab_general_setting; ?></a></li>
									<li><a href="#modal-field-basic-block" data-toggle="tab"><i class="fa fa-cogs"></i> <?php echo $tab_basic_setting; ?></a></li>
                </ul>
              </li>
              <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-language"></i> <?php echo $tab_language_setting; ?> <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="#modal-field-language-block" data-toggle="tab"><i class="fa fa-flag-o"></i> <?php echo $tab_basic_language_setting; ?></a></li>
                </ul>
              </li>
						</ul>
						<form method="post" enctype="multipart/form-data" id="modal-form" class="form-horizontal">
							<input type="hidden" style="display:none;" name="field_id" value="<?php echo $field_id; ?>"/>
							<div class="tab-content row">
								<!-- TAB General block -->
								<div class="tab-pane fade active in" role="tabpanel" id="modal-field-general-block">
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
									<div class="form-group">
										<label class="col-sm-12 control-label" for="input-type"><?php echo $text_field_type; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
										<div class="col-sm-12">
											<select name="field_type" class="form-control">
												<optgroup label="<?php echo $text_field_type_group_2; ?>">
													<option value="email" <?php echo $field_type == 'email' ? 'selected="selected"' : ''; ?>><?php echo $text_field_type_group_2_t_3; ?></option>
													<option value="telephone" <?php echo $field_type == 'telephone' ? 'selected="selected"' : ''; ?>><?php echo $text_field_type_group_2_t_4; ?></option>
													<option value="firstname" <?php echo $field_type == 'firstname' ? 'selected="selected"' : ''; ?>><?php echo $text_field_type_group_2_t_5; ?></option>
													<option value="lastname" <?php echo $field_type == 'lastname' ? 'selected="selected"' : ''; ?>><?php echo $text_field_type_group_2_t_6; ?></option>
												</optgroup>
												<optgroup label="<?php echo $text_field_type_group_5; ?>">
													<option value="title" <?php echo $field_type == 'title' ? 'selected="selected"' : ''; ?>><?php echo $text_field_type_group_5_t_1; ?></option>
												</optgroup>
											</select>
											<div class="alert alert-info" role="alert"><?php echo $text_field_type_faq; ?></div>
										</div>
									</div>
									<div class="form-group field-mask-instruction">
                    <label class="col-sm-12 control-label"><?php echo $entry_field_mask; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
                    <div class="col-sm-12">
                      <input value="<?php echo $field_mask; ?>" type="text" name="field_mask" class="form-control" />
                      <div class="alert alert-info" role="alert"><i class="fa fa-info-circle" aria-hidden="true"></i> <?php echo $text_field_mask_faq; ?></div>
                    </div>
                  </div>
									<div class="form-group validation-type-instruction">
										<label class="col-sm-12 control-label"><?php echo $entry_validation_type; ?></label>
										<div class="col-sm-12">
											<select name="validation_type" class="form-control">
												<option value="0" <?php echo $validation_type == 0 ? 'selected="selected"' : ''; ?>><?php echo $entry_validation_type_1; ?></option>
												<option value="1" <?php echo $validation_type == 1 ? 'selected="selected"' : ''; ?>><?php echo $entry_validation_type_2; ?></option>
												<option value="2" <?php echo $validation_type == 2 ? 'selected="selected"' : ''; ?> class="option-regex-rule-instruction"><?php echo $entry_validation_type_3; ?></option>
												<option value="3" <?php echo $validation_type == 3 ? 'selected="selected"' : ''; ?> class="option-min-max-length-rule-instruction"><?php echo $entry_validation_type_4; ?></option>
											</select>
										</div>
									</div>
									<div class="form-group required regex-rule-instruction">
                    <label class="col-sm-12 control-label"><?php echo $entry_validation_type_3; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
                    <div class="col-sm-12">
											<div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-filter"></i></span>
                        <input value="<?php echo $regex_rule; ?>" type="text" name="regex_rule" class="form-control" id="modal-error-regex-rule"/>
                      </div>
                      <div class="alert alert-info" role="alert"><i class="fa fa-info-circle" aria-hidden="true"></i> <?php echo $text_regex_rule_faq; ?></div>
                    </div>
                  </div>
									<div class="form-group required min-max-length-rule-instruction">
                    <label class="col-sm-12 control-label"><?php echo $entry_validation_type_4; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
                    <div class="col-sm-12">
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-chevron-right"></i></span>
                        <input value="<?php echo $min_length_rule; ?>" type="text" name="min_length_rule" class="form-control" id="modal-error-min-length-rule"/>
											</div>
                			<div class="special-margin"></div>
                			<div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-chevron-left"></i></span>
                      	<input value="<?php echo $max_length_rule; ?>" type="text" name="max_length_rule" class="form-control" id="modal-error-max-length-rule"/>
                      </div>
                      <div class="alert alert-info" role="alert"><i class="fa fa-info-circle" aria-hidden="true"></i> <?php echo $text_min_max_length_rule_faq; ?></div>
                    </div>
                  </div>
									<div class="form-group required">
										<label class="col-sm-12 control-label"><?php echo $entry_sort_order; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
										<div class="col-sm-12">
											<div class="input-group">
												<input value="<?php echo $sort_order; ?>" type="text" name="sort_order" class="form-control" id="modal-error-sort-order"/>
												<span class="input-group-btn"><button type="button" class="btn btn-primary button-loading" onclick="generate_sort_order(this, 'field', '<?php echo $field_id; ?>')"><?php echo $button_generate; ?></button></span>
											</div>
											<div class="alert alert-info" role="alert"><i class="fa fa-info-circle" aria-hidden="true"></i> <?php echo $entry_sort_order_faq; ?></div>
										</div>
									</div>
								</div>
								<!-- TAB Basic block -->
								<div class="tab-pane fade" role="tabpanel" id="modal-field-basic-block">
									<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $entry_css_id; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
                    <div class="col-sm-12">
                      <input value="<?php echo $css_id; ?>" type="text" name="css_id" class="form-control" />
                      <div class="alert alert-info" role="alert"><i class="fa fa-info-circle" aria-hidden="true"></i> <?php echo $text_css_id_faq; ?></div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $entry_css_class; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
                    <div class="col-sm-12">
                      <input value="<?php echo $css_class; ?>" type="text" name="css_class" class="form-control" />
                      <div class="alert alert-info" role="alert"><i class="fa fa-info-circle" aria-hidden="true"></i> <?php echo $text_css_class_faq; ?></div>
                    </div>
                  </div>
                  <div class="form-group description-status-instruction">
										<label class="col-sm-12 control-label"><?php echo $entry_description_status; ?></label>
										<div class="col-sm-12">
											<select name="description_status" class="form-control">
												<option value="1" <?php echo $description_status == 1 ? 'selected="selected"' : ''; ?>><?php echo $text_yes; ?></option>
												<option value="0" <?php echo $description_status == 0 ? 'selected="selected"' : ''; ?>><?php echo $text_no; ?></option>
											</select>
										</div>
									</div>
									<div class="form-group title-status-instruction">
										<label class="col-sm-12 control-label"><?php echo $entry_title_status; ?></label>
										<div class="col-sm-12">
											<select name="title_status" class="form-control">
												<option value="1" <?php echo $title_status == 1 ? 'selected="selected"' : ''; ?>><?php echo $text_yes; ?></option>
												<option value="0" <?php echo $title_status == 0 ? 'selected="selected"' : ''; ?>><?php echo $text_no; ?></option>
											</select>
										</div>
									</div>
									<div class="form-group placeholder-status-instruction">
										<label class="col-sm-12 control-label"><?php echo $entry_placeholder_status; ?></label>
										<div class="col-sm-12">
											<select name="placeholder_status" class="form-control">
												<option value="1" <?php echo $placeholder_status == 1 ? 'selected="selected"' : ''; ?>><?php echo $text_yes; ?></option>
												<option value="0" <?php echo $placeholder_status == 0 ? 'selected="selected"' : ''; ?>><?php echo $text_no; ?></option>
											</select>
										</div>
									</div>
									<div class="form-group icon-status-instruction">
										<label class="col-sm-12 control-label"><?php echo $entry_icon_status; ?></label>
										<div class="col-sm-12">
											<select name="icon_status" class="form-control">
												<option value="1" <?php echo $icon_status == 1 ? 'selected="selected"' : ''; ?>><?php echo $text_yes; ?></option>
												<option value="0" <?php echo $icon_status == 0 ? 'selected="selected"' : ''; ?>><?php echo $text_no; ?></option>
											</select>
										</div>
									</div>
									<div class="form-group icon-instruction">
										<label class="col-sm-12 control-label"><?php echo $entry_icon; ?></label>
										<div class="col-sm-12">
											<a href="" id="thumb-icon" data-toggle="image" class="img-thumbnail"><img src="<?php echo $icon_thumb; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>"/></a>
											<input type="hidden" name="icon" value="<?php echo $icon; ?>" id="input-icon"/>
										</div>
									</div>
								</div>
								<!-- TAB Language block -->
								<div class="tab-pane fade" role="tabpanel" id="modal-field-language-block">
									<div class="form-group required">
										<label class="col-sm-12 control-label"><?php echo $entry_field_name; ?></label>
										<div class="col-sm-12">
											<?php foreach ($languages as $language) { ?>
											<div class="input-group" style="margin-bottom: 5px;">
												<span class="input-group-addon"><img src="<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span>
												<input type="text" name="field_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($field_description[$language['language_id']]) ? $field_description[$language['language_id']]['name'] : ''; ?>" class="form-control" id="modal-error-field-description-language-name-<?php echo $language['language_id']; ?>"/>
											</div>
											<?php } ?>
										</div>
									</div>
									<div class="form-group required error-text-instruction">
										<label class="col-sm-12 control-label"><?php echo $entry_field_error_text; ?></label>
										<div class="col-sm-12">
											<?php foreach ($languages as $language) { ?>
											<div class="input-group" style="margin-bottom: 5px;">
												<span class="input-group-addon"><img src="<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span>
												<input type="text" name="field_description[<?php echo $language['language_id']; ?>][error_text]" value="<?php echo isset($field_description[$language['language_id']]) ? $field_description[$language['language_id']]['error_text'] : ''; ?>" class="form-control" id="modal-error-field-description-language-error-text-<?php echo $language['language_id']; ?>"/>
											</div>
											<?php } ?>
										</div>
									</div>
									<div class="form-group placeholder-instruction">
										<label class="col-sm-12 control-label"><?php echo $entry_field_placeholder; ?></label>
										<div class="col-sm-12">
											<?php foreach ($languages as $language) { ?>
											<div class="input-group" style="margin-bottom: 5px;">
												<span class="input-group-addon"><img src="<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span>
												<input type="text" name="field_description[<?php echo $language['language_id']; ?>][placeholder]" value="<?php echo isset($field_description[$language['language_id']]) ? $field_description[$language['language_id']]['placeholder'] : ''; ?>" class="form-control" id="modal-error-field-description-language-placeholder-<?php echo $language['language_id']; ?>"/>
											</div>
											<?php } ?>
										</div>
									</div>
									<div class="form-group description-instruction">
										<label class="col-sm-12 control-label"><?php echo $entry_description; ?></label>
										<div class="col-sm-12">
											<?php foreach ($languages as $language) { ?>
											<div class="input-group" style="margin-bottom: 5px;">
												<span class="input-group-addon"><img src="<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span>
												<textarea name="field_description[<?php echo $language['language_id']; ?>][description]" id="modal-error-field-description-language-description-<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($field_description[$language['language_id']]) ? $field_description[$language['language_id']]['description'] : ''; ?></textarea>
											</div>
											<div class="btn-group" style="margin-bottom: 5px;">
												<button type="button" class="btn btn-default btn-xs" onclick="texteditor_action({a:'#modal-error-field-description-language-description-<?php echo $language['language_id']; ?>'});"><?php echo $text_open_texteditor; ?></button>
												<button type="button" class="btn btn-default btn-xs" onclick="texteditor_action({a:'#modal-error-field-description-language-description-<?php echo $language['language_id']; ?>',b:true,c:false});" style="display: none;"><?php echo $text_save_texteditor; ?></button>
											</div>
											<?php } ?>
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
		<button class="btn btn-success button-loading" onclick="submit_field({a:this,b:'close'});"><span class="hidden-lg hidden-md hidden-sm"><i class="fa fa-save"></i> </span><span class="hidden-xs"><?php echo $button_save; ?></span></button>
		<?php if ($field_id) { ?>
		<button class="btn btn-success button-loading" onclick="submit_field({a:this});"><span class="hidden-lg hidden-md hidden-sm"><i class="fa fa-save"></i> + <i class="fa fa-refresh"></i> </span><span class="hidden-xs"><?php echo $button_save_and_stay; ?></span></button>
		<?php } ?>
	</div>
	<script>
		function block_visibility_instructions(options) {
			var tab = options.a || '';

			if (tab == 'field-value-block') {
				$('.field-value-instruction').hide();

				$('.regex-rule-instruction').hide();
				$('.min-max-length-rule-instruction').hide();
				$('.placeholder-status-instruction').hide();
				$('.icon-instruction').hide();
				$('.placeholder-instruction').hide();
				$('.option-regex-rule-instruction').attr('disabled',false);
				$('.option-min-max-length-rule-instruction').attr('disabled',false);
				$('.file-ext-allowed-attachment-instruction').hide();
				$('.file-mime-allowed-attachment-instruction').hide();
				$('.field-mask-instruction').hide();
				$('.validation-type-instruction').hide();
				$('.icon-status-instruction').hide();
				$('.title-status-instruction').hide();
				$('.description-status-instruction').hide();
				$('.description-instruction').hide();
				$('.error-text-instruction').hide();

				if ($('select[name=field_type]').val() == 'title') {

				} else {
					$('.field-value-instruction > div').html('<input type="text" name="value" value="' + $('.field-value-instruction input').val() + '" class="form-control" />');
					$('.placeholder-status-instruction').show();
					$('.placeholder-instruction').show();
					$('.field-mask-instruction').show();
					$('.validation-type-instruction').show();
					$('.icon-status-instruction').show();
					$('.title-status-instruction').show();
					$('.description-status-instruction').show();
					$('.description-instruction').show();
					$('.error-text-instruction').show();
				}

				if ($('select[name=validation_type]').val() == '2') {
					$('.regex-rule-instruction').show();
				} else if ($('select[name=validation_type]').val() == '3') {
					$('.min-max-length-rule-instruction').show();
				}

				if ($('select[name=icon_status]').val() == '1') {
					$('.icon-instruction').show();
				}
			}
		}

		$('select[name=field_type],select[name=validation_type],select[name=icon_status]').change(function() {
			block_visibility_instructions({a:'field-value-block'});
		});

		block_visibility_instructions({a:'field-value-block'});
	</script>
</div>
