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
			<div id="modal-email-template-constructor-content">
				<div id="content" class="row pb-0">
					<div class="panel-body pt-0 pb-0">
						<ul class="nav nav-tabs" id="modal-setting-tabs">
							<li class="active"><a href="#modal-general-block" data-toggle="tab"><i class="fa fa-cogs"></i> <?php echo $tab_general_setting; ?></a></li>
							<li><a href="#modal-email-template-block" data-toggle="tab"><i class="fa fa-cogs"></i> <?php echo $tab_email_template_setting; ?></a></li>
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
										<label class="col-sm-12 control-label"><?php echo $text_assignment_email_template; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
										<div class="col-sm-12">
											<select name="assignment" class="form-control" id="modal-error-assignment">
												<option value="0" <?php echo $assignment == 0 ? 'selected="selected"' : ''; ?>><?php echo $text_make_a_choice; ?></option>
												<option value="1" <?php echo $assignment == 1 ? 'selected="selected"' : ''; ?>><?php echo $text_assignment_email_template_1; ?></option>
												<option value="2" <?php echo $assignment == 2 ? 'selected="selected"' : ''; ?>><?php echo $text_assignment_email_template_2; ?></option>
												<option value="3" <?php echo $assignment == 3 ? 'selected="selected"' : ''; ?>><?php echo $text_assignment_email_template_3; ?></option>
												<option value="4" <?php echo $assignment == 4 ? 'selected="selected"' : ''; ?>><?php echo $text_assignment_email_template_4; ?></option>
												<option value="5" <?php echo $assignment == 5 ? 'selected="selected"' : ''; ?>><?php echo $text_assignment_email_template_5; ?></option>
												<option value="6" <?php echo $assignment == 6 ? 'selected="selected"' : ''; ?>><?php echo $text_assignment_email_template_6; ?></option>
											</select>
											<div class="alert alert-info" role="alert"><?php echo $text_assignment_email_template_faq; ?></div>
										</div>
									</div>
									<div class="form-group template-related-product-status-instruction">
										<label class="col-sm-12 control-label"><?php echo $text_template_related_product_status; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
										<div class="col-sm-12">
											<select name="related_product_status" class="form-control">
												<option value=""  <?php echo $related_product_status == '' ? 'selected="selected"' : ''; ?>><?php echo $text_make_a_choice; ?></option>
												<option value="1" <?php echo $related_product_status == 1 ? 'selected="selected"' : ''; ?>><?php echo $text_template_related_product_status_1; ?></option>
												<option value="2" <?php echo $related_product_status == 2 ? 'selected="selected"' : ''; ?>><?php echo $text_template_related_product_status_2; ?></option>
												<option value="3" <?php echo $related_product_status == 3 ? 'selected="selected"' : ''; ?>><?php echo $text_template_related_product_status_3; ?></option>
												<option value="4" <?php echo $related_product_status == 4 ? 'selected="selected"' : ''; ?>><?php echo $text_template_related_product_status_4; ?></option>
												<option value="5" <?php echo $related_product_status == 5 ? 'selected="selected"' : ''; ?>><?php echo $text_template_related_product_status_5; ?></option>
												<option value="6" <?php echo $related_product_status == 6 ? 'selected="selected"' : ''; ?>><?php echo $text_template_related_product_status_6; ?></option>
												<option value="7" <?php echo $related_product_status == 7 ? 'selected="selected"' : ''; ?>><?php echo $text_template_related_product_status_7; ?></option>
												<option value="8" <?php echo $related_product_status == 8 ? 'selected="selected"' : ''; ?>><?php echo $text_template_related_product_status_8; ?></option>
												<option value="9" <?php echo $related_product_status == 9 ? 'selected="selected"' : ''; ?>><?php echo $text_template_related_product_status_9; ?></option>
												<option value="10" <?php echo $related_product_status == 10 ? 'selected="selected"' : ''; ?>><?php echo $text_template_related_product_status_10; ?></option>
												<option value="11" <?php echo $related_product_status == 11 ? 'selected="selected"' : ''; ?>><?php echo $text_template_related_product_status_11; ?></option>
												<option value="12" <?php echo $related_product_status == 12 ? 'selected="selected"' : ''; ?>><?php echo $text_template_related_product_status_12; ?></option>
												<option value="13" <?php echo $related_product_status == 13 ? 'selected="selected"' : ''; ?>><?php echo $text_template_related_product_status_13; ?></option>
											</select>
											<div class="alert alert-info" role="alert"><?php echo $text_template_related_product_status_faq; ?></div>
										</div>
									</div>
									<div class="col-sm-12">
										<fieldset>
											<legend class="open collapse-trigger" id="template_main" onclick="collapse_blocks({a:this,b:'template_main_related'})"><?php echo $text_legend_main_product; ?> <span><i class="fa fa-minus-square"></i><i class="fa fa-plus-square"></i></span></legend>
											<div class="row collapse-block">
												<div class="form-group">
													<label class="col-sm-12 control-label"><?php echo $text_related_show_image; ?></label>
													<div class="col-sm-12">
														<select name="main_show_image" class="form-control">
															<option value="1" <?php echo $main_show_image == 1 ? 'selected="selected"' : ''; ?>><?php echo $text_yes; ?></option>
															<option value="0" <?php echo $main_show_image == 0 ? 'selected="selected"' : ''; ?>><?php echo $text_no; ?></option>
														</select>
													</div>
												</div>
												<div class="form-group required template-main-image-width-and-height-instruction">
													<label class="col-sm-12 control-label"><?php echo $text_related_dementions_of_image; ?></label>
													<div class="col-sm-12">
														<div class="input-group">
															<span class="input-group-addon"><?php echo $text_width_indicator; ?></span>
															<input value="<?php echo $main_image_width; ?>" type="text" name="main_image_width" class="form-control" placeholder="<?php echo $text_image_width_ph; ?>" id="modal-error-main-image-width"/>
															<span class="input-group-addon"><?php echo $text_px; ?></span>
														</div>
														<div class="special-margin"></div>
														<div class="input-group">
															<span class="input-group-addon"><?php echo $text_height_indicator; ?></span>
															<input value="<?php echo $main_image_height; ?>" type="text" name="main_image_height" class="form-control" placeholder="<?php echo $text_image_height_ph; ?>" id="modal-error-main-image-height"/>
															<span class="input-group-addon"><?php echo $text_px; ?></span>
														</div>
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-12 control-label"><?php echo $text_related_show_price; ?></label>
													<div class="col-sm-12">
														<select name="main_show_price" class="form-control">
															<option value="1" <?php echo $main_show_price == 1 ? 'selected="selected"' : ''; ?>><?php echo $text_yes; ?></option>
															<option value="0" <?php echo $main_show_price == 0 ? 'selected="selected"' : ''; ?>><?php echo $text_no; ?></option>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-12 control-label"><?php echo $text_related_show_name; ?></label>
													<div class="col-sm-12">
														<select name="main_show_name" class="form-control">
															<option value="1" <?php echo $main_show_name == 1 ? 'selected="selected"' : ''; ?>><?php echo $text_yes; ?></option>
															<option value="0" <?php echo $main_show_name == 0 ? 'selected="selected"' : ''; ?>><?php echo $text_no; ?></option>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-12 control-label"><?php echo $text_related_show_description; ?></label>
													<div class="col-sm-12">
														<select name="main_show_description" class="form-control">
															<option value="1" <?php echo $main_show_description == 1 ? 'selected="selected"' : ''; ?>><?php echo $text_yes; ?></option>
															<option value="0" <?php echo $main_show_description == 0 ? 'selected="selected"' : ''; ?>><?php echo $text_no; ?></option>
														</select>
													</div>
												</div>
												<div class="form-group required template-main-description-limit-instruction">
													<label class="col-sm-12 control-label"><?php echo $text_related_description_limit; ?></label>
													<div class="col-sm-12">
														<input value="<?php echo $main_description_limit; ?>" type="text" name="main_description_limit" class="form-control" id="modal-error-main-description-limit"/>
													</div>
												</div>
											</div>
										</fieldset>
									</div>
									<div class="col-sm-12 template-related-product-block-instruction">
										<fieldset>
	                    <legend class="open collapse-trigger template-related-product-legend-instruction" id="template_related" onclick="collapse_blocks({a:this,b:'template_main_related'})"><?php echo $text_legend_related_product; ?> <span><i class="fa fa-minus-square"></i><i class="fa fa-plus-square"></i></span></legend>
											<div class="row collapse-block">
												<div class="form-group template-product-related-instruction">
													<label class="col-sm-12 control-label"><?php echo $entry_product_related; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
													<div class="col-sm-12">
														<input type="text" name="related_product" value="" placeholder="<?php echo $placeholder_product; ?>" class="form-control" id="modal-error-product-related"/>
														<div class="well well-sm" id="product-related">
															<?php foreach ($product_relateds as $product_related) { ?>
																<div class="well-custom-item" id="product-related<?php echo $product_related['product_id']; ?>"><i class="fa fa-check-square-o"></i> <?php echo $product_related['name']; ?>
																	<input type="hidden" name="product_related[]" value="<?php echo $product_related['product_id']; ?>"/>
																</div>
															<?php } ?>
														</div>
														<div class="alert alert-info" role="alert"><?php echo $text_autocomplete_faq; ?></div>
													</div>
												</div>
												<div class="form-group template-category-related-instruction">
													<label class="col-sm-12 control-label"><?php echo $entry_category_related; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
													<div class="col-sm-12">
														<input type="text" name="related_category" value="" placeholder="<?php echo $placeholder_category; ?>" class="form-control" id="modal-error-category-related"/>
														<div class="well well-sm" id="category-related">
															<?php foreach ($category_relateds as $category_related) { ?>
																<div class="well-custom-item" id="category-related<?php echo $category_related['category_id']; ?>"><i class="fa fa-check-square-o"></i> <?php echo $category_related['name']; ?>
																	<input type="hidden" name="category_related[]" value="<?php echo $category_related['category_id']; ?>"/>
																</div>
															<?php } ?>
														</div>
														<div class="alert alert-info" role="alert"><?php echo $text_autocomplete_faq; ?></div>
													</div>
												</div>
												<div class="form-group template-manufacturer-related-instruction">
													<label class="col-sm-12 control-label"><?php echo $entry_manufacturer_related; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
													<div class="col-sm-12">
														<input type="text" name="related_manufacturer" value="" placeholder="<?php echo $placeholder_manufacturer; ?>" class="form-control" id="modal-error-manufacturer-related"/>
														<div class="well well-sm" id="manufacturer-related">
															<?php foreach ($manufacturer_relateds as $manufacturer_related) { ?>
																<div class="well-custom-item" id="manufacturer-related<?php echo $manufacturer_related['manufacturer_id']; ?>"><i class="fa fa-check-square-o"></i> <?php echo $manufacturer_related['name']; ?>
																	<input type="hidden" name="manufacturer_related[]" value="<?php echo $manufacturer_related['manufacturer_id']; ?>"/>
																</div>
															<?php } ?>
														</div>
														<div class="alert alert-info" role="alert"><?php echo $text_autocomplete_faq; ?></div>
													</div>
												</div>
												<div class="form-group required">
													<label class="col-sm-12 control-label"><?php echo $text_related_limit; ?></label>
													<div class="col-sm-12">
														<input value="<?php echo $related_limit; ?>" type="text" name="related_limit" class="form-control" id="modal-error-related-limit"/>
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-12 control-label"><?php echo $text_related_show_image; ?></label>
													<div class="col-sm-12">
														<select name="related_show_image" class="form-control">
															<option value="1" <?php echo $related_show_image == 1 ? 'selected="selected"' : ''; ?>><?php echo $text_yes; ?></option>
															<option value="0" <?php echo $related_show_image == 0 ? 'selected="selected"' : ''; ?>><?php echo $text_no; ?></option>
														</select>
													</div>
												</div>
												<div class="form-group required template-related-image-width-and-height-instruction">
													<label class="col-sm-12 control-label"><?php echo $text_related_dementions_of_image; ?></label>
													<div class="col-sm-12">
														<div class="input-group">
															<span class="input-group-addon"><?php echo $text_width_indicator; ?></span>
															<input value="<?php echo $related_image_width; ?>" type="text" name="related_image_width" class="form-control" placeholder="<?php echo $text_image_width_ph; ?>" id="modal-error-related-image-width"/>
															<span class="input-group-addon"><?php echo $text_px; ?></span>
														</div>
														<div class="special-margin"></div>
														<div class="input-group">
															<span class="input-group-addon"><?php echo $text_height_indicator; ?></span>
															<input value="<?php echo $related_image_height; ?>" type="text" name="related_image_height" class="form-control" placeholder="<?php echo $text_image_height_ph; ?>" id="modal-error-related-image-height"/>
															<span class="input-group-addon"><?php echo $text_px; ?></span>
														</div>
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-12 control-label"><?php echo $text_related_show_price; ?></label>
													<div class="col-sm-12">
														<select name="related_show_price" class="form-control">
															<option value="1" <?php echo $related_show_price == 1 ? 'selected="selected"' : ''; ?>><?php echo $text_yes; ?></option>
															<option value="0" <?php echo $related_show_price == 0 ? 'selected="selected"' : ''; ?>><?php echo $text_no; ?></option>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-12 control-label"><?php echo $text_related_show_name; ?></label>
													<div class="col-sm-12">
														<select name="related_show_name" class="form-control">
															<option value="1" <?php echo $related_show_name == 1 ? 'selected="selected"' : ''; ?>><?php echo $text_yes; ?></option>
															<option value="0" <?php echo $related_show_name == 0 ? 'selected="selected"' : ''; ?>><?php echo $text_no; ?></option>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-12 control-label"><?php echo $text_related_show_description; ?></label>
													<div class="col-sm-12">
														<select name="related_show_description" class="form-control">
															<option value="1" <?php echo $related_show_description == 1 ? 'selected="selected"' : ''; ?>><?php echo $text_yes; ?></option>
															<option value="0" <?php echo $related_show_description == 0 ? 'selected="selected"' : ''; ?>><?php echo $text_no; ?></option>
														</select>
													</div>
												</div>
												<div class="form-group required template-related-description-limit-instruction">
													<label class="col-sm-12 control-label"><?php echo $text_related_description_limit; ?></label>
													<div class="col-sm-12">
														<input value="<?php echo $related_description_limit; ?>" type="text" name="related_description_limit" class="form-control" id="modal-error-related-description-limit"/>
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-12 control-label"><?php echo $text_related_randomize; ?></label>
													<div class="col-sm-12">
														<select name="related_randomize" class="form-control">
															<option value="1" <?php echo $related_randomize == 1 ? 'selected="selected"' : ''; ?>><?php echo $text_yes; ?></option>
															<option value="0" <?php echo $related_randomize == 0 ? 'selected="selected"' : ''; ?>><?php echo $text_no; ?></option>
														</select>
													</div>
												</div>
											</div>
										</fieldset>
									</div>
								</div>
								<!-- TAB Email template block -->
								<div class="tab-pane fade" role="tabpanel" id="modal-email-template-block">
									<div class="form-group required">
										<label class="col-sm-12 control-label"><?php echo $text_email_template_subject; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
										<div class="col-sm-12">
											<?php foreach ($languages as $language) { ?>
											<div class="input-group mb-5">
												<span class="input-group-addon"><img src="<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span>
												<input type="text" name="template_description[<?php echo $language['language_id']; ?>][subject]" value="<?php echo isset($template_description[$language['language_id']]) ? $template_description[$language['language_id']]['subject'] : ''; ?>" class="form-control" id="modal-error-template-description-language-subject-<?php echo $language['language_id']; ?>"/>
											</div>
											<?php } ?>
											<div class="assignment-email-template-1-instruction">
												<div class="alert alert-info short-codes" role="alert"><?php echo $text_assignment_email_template_1_subject; ?></div>
											</div>
											<div class="assignment-email-template-2-instruction">
												<div class="alert alert-info short-codes" role="alert"><?php echo $text_assignment_email_template_2_subject; ?></div>
											</div>
											<div class="assignment-email-template-3-instruction">
												<div class="alert alert-info short-codes" role="alert"><?php echo $text_assignment_email_template_3_subject; ?></div>
											</div>
											<div class="assignment-email-template-4-instruction">
												<div class="alert alert-info short-codes" role="alert"><?php echo $text_assignment_email_template_4_subject; ?></div>
											</div>
											<div class="assignment-email-template-5-instruction">
												<div class="alert alert-info short-codes" role="alert"><?php echo $text_assignment_email_template_5_subject; ?></div>
											</div>
											<div class="assignment-email-template-6-instruction">
												<div class="alert alert-info short-codes" role="alert"><?php echo $text_assignment_email_template_6_subject; ?></div>
											</div>
										</div>
									</div>
									<div class="form-group required">
										<label class="col-sm-12 control-label"><?php echo $text_email_template_html; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
										<div class="col-sm-12">
											<?php foreach ($languages as $language) { ?>
											<div class="input-group mb-5">
												<span class="input-group-addon"><img src="<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span>
												<textarea name="template_description[<?php echo $language['language_id']; ?>][template]" id="modal-error-template-description-language-template-<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($template_description[$language['language_id']]) ? $template_description[$language['language_id']]['template'] : ''; ?></textarea>
												<?php if ($template_id) { ?>
												<span class="input-group-addon"><button type="button" data-toggle="tooltip" class="btn btn-primary btn-xs" title="<?php echo $button_preview_result; ?>" onclick="preview_email_template({a:this,b:'<?php echo $template_id; ?>',c:'<?php echo $language['language_id']; ?>'});"><i class="fa fa-eye"></i></button></span>
												<?php } ?>
											</div>
											<div class="btn-group mb-5">
												<button type="button" class="btn btn-default btn-xs" onclick="texteditor_action({a:'#modal-error-template-description-language-template-<?php echo $language['language_id']; ?>'});"><?php echo $text_open_texteditor; ?></button>
												<button type="button" class="btn btn-default btn-xs" onclick="texteditor_action({a:'#modal-error-template-description-language-template-<?php echo $language['language_id']; ?>',b:true,c:false});" style="display: none;"><?php echo $text_save_texteditor; ?></button>
											</div>
											<?php } ?>
											<div class="assignment-email-template-1-instruction">
												<div class="alert alert-info short-codes" role="alert"><?php echo $text_assignment_email_template_1_template; ?></div>
											</div>
											<div class="assignment-email-template-2-instruction">
												<div class="alert alert-info short-codes" role="alert"><?php echo $text_assignment_email_template_2_template; ?></div>
											</div>
											<div class="assignment-email-template-3-instruction">
												<div class="alert alert-info short-codes" role="alert"><?php echo $text_assignment_email_template_3_template; ?></div>
											</div>
											<div class="assignment-email-template-4-instruction">
												<div class="alert alert-info short-codes" role="alert"><?php echo $text_assignment_email_template_4_template; ?></div>
											</div>
											<div class="assignment-email-template-5-instruction">
												<div class="alert alert-info short-codes" role="alert"><?php echo $text_assignment_email_template_5_template; ?></div>
											</div>
											<div class="assignment-email-template-6-instruction">
												<div class="alert alert-info short-codes" role="alert"><?php echo $text_assignment_email_template_6_template; ?></div>
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
		<button class="btn btn-success button-loading" onclick="submit_email_template({a:this,b:'close'});"><span class="hidden-lg hidden-md hidden-sm"><i class="fa fa-save"></i> </span><span class="hidden-xs"><?php echo $button_save; ?></span></button>
		<?php if ($template_id) { ?>
		<button class="btn btn-success button-loading" onclick="submit_email_template({a:this});"><span class="hidden-lg hidden-md hidden-sm"><i class="fa fa-save"></i> + <i class="fa fa-refresh"></i> </span><span class="hidden-xs"><?php echo $button_save_and_stay; ?></span></button>
		<?php } ?>
	</div>
	<script>
		$('input[name=\'related_product\']').autocomplete({
			'source': function(request, response) {
				$.ajax({
					url: 'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/autocomplete_product&<?php echo $token; ?>&filter_name='+encodeURIComponent(request),
					dataType: 'json',
					success: function(json) {
						json.unshift({
							product_id: 0,
							name: '<?php echo $text_none; ?>'
						});

						response($.map(json, function(item) {
							return {
								label: item['name'],
								value: item['product_id']
							}
						}));
					}
				});
			},
			'select': function(item) {
				$('input[name=\'related_product\']').val('');
				$('#product-related'+item['value']).remove();
				$('#product-related').append('<div class="well-custom-item" id="product-related'+item['value']+'"><i class="fa fa-check-square-o"></i> '+item['label']+'<input type="hidden" name="product_related[]" value="'+item['value']+'" /></div>&nbsp;');
			}
		});

		$('#product-related').delegate('.well-custom-item', 'click', function() {
			$(this).remove();
		});

		$('input[name=\'related_category\']').autocomplete({
			'source': function(request, response) {
				$.ajax({
					url: 'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/autocomplete_category&<?php echo $token; ?>&filter_name='+encodeURIComponent(request),
					dataType: 'json',
					success: function(json) {
						json.unshift({
							category_id: 0,
							name: '<?php echo $text_none; ?>'
						});

						response($.map(json, function(item) {
							return {
								label: item['name'],
								value: item['category_id']
							}
						}));
					}
				});
			},
			'select': function(item) {
				$('input[name=\'related_category\']').val('');
				$('#category-related'+item['value']).remove();
				$('#category-related').append('<div class="well-custom-item" id="category-related'+item['value']+'"><i class="fa fa-check-square-o"></i> '+item['label']+'<input type="hidden" name="category_related[]" value="'+item['value']+'" /></div>&nbsp;');
			}
		});

		$('#category-related').delegate('.well-custom-item', 'click', function() {
			$(this).remove();
		});

		$('input[name=\'related_manufacturer\']').autocomplete({
			'source': function(request, response) {
				$.ajax({
					url: 'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/autocomplete_manufacturer&<?php echo $token; ?>&filter_name='+encodeURIComponent(request),
					dataType: 'json',
					success: function(json) {
						json.unshift({
							manufacturer_id: 0,
							name: '<?php echo $text_none; ?>'
						});

						response($.map(json, function(item) {
							return {
								label: item['name'],
								value: item['manufacturer_id']
							}
						}));
					}
				});
			},
			'select': function(item) {
				$('input[name=\'related_manufacturer\']').val('');
				$('#manufacturer-related'+item['value']).remove();
				$('#manufacturer-related').append('<div class="well-custom-item" id="manufacturer-related'+item['value']+'"><i class="fa fa-check-square-o"></i> '+item['label']+'<input type="hidden" name="manufacturer_related[]" value="'+item['value']+'" /></div>&nbsp;');
			}
		});

		$('#manufacturer-related').delegate('.well-custom-item', 'click', function() {
			$(this).remove();
		});

		function block_visibility_instructions(options) {
			var tab = options.a || '';

			if (tab == 'modal-email-template-constructor-content') {
			  $('.button-view-shortcodes-instruction').hide();
			  $('.template-related-product-block-instruction').hide();
			  $('.template-related-product-status-instruction').hide();
				$('.assignment-email-template-1-instruction').hide();
				$('.assignment-email-template-2-instruction').hide();
				$('.assignment-email-template-3-instruction').hide();
				$('.assignment-email-template-4-instruction').hide();
				$('.assignment-email-template-5-instruction').hide();
				$('.assignment-email-template-6-instruction').hide();
				$('.template-product-related-instruction').hide();
				$('.template-category-related-instruction').hide();
				$('.template-manufacturer-related-instruction').hide();
				$('.template-related-image-width-and-height-instruction').hide();
				$('.template-related-description-limit-instruction').hide();
				$('.template-main-image-width-and-height-instruction').hide();
				$('.template-main-description-limit-instruction').hide();
				$('.template-related-product-legend-instruction').hide();
				$('select[name=related_product_status] option[value=11]').attr('disabled',true);
				$('select[name=related_product_status] option[value=12]').attr('disabled',true);
				$('select[name=related_product_status] option[value=13]').attr('disabled',true);

				if ($('select[name=assignment]').val() == 1) {
					$('.button-view-shortcodes-instruction').show();
					$('.assignment-email-template-1-instruction').show();

					if ($('select[name=main_show_image]').val() == 1) {
						$('.template-main-image-width-and-height-instruction').show();
					}

					if ($('select[name=main_show_description]').val() == 1) {
						$('.template-main-description-limit-instruction').show();
					}
				} else if ($('select[name=assignment]').val() == 2) {
					$('.button-view-shortcodes-instruction').show();
					$('.assignment-email-template-2-instruction').show();

					$('.template-related-product-status-instruction').show();

					if ($('select[name=related_product_status]').val() > 0) {
						$('.template-related-product-block-instruction').show();
					}

					$('.template-related-product-legend-instruction').show();

					if ($('select[name=related_product_status]').val() == 1) {
          	$('.template-category-related-instruction').show();
          } else if ($('select[name=related_product_status]').val() == 2) {
					  $('.template-manufacturer-related-instruction').show();
          } else if ($('select[name=related_product_status]').val() == 3) {
					  $('.template-product-related-instruction').show();
          }

					if ($('select[name=related_show_image]').val() == 1) {
						$('.template-related-image-width-and-height-instruction').show();
					}

					if ($('select[name=related_show_description]').val() == 1) {
						$('.template-related-description-limit-instruction').show();
					}

					if ($('select[name=main_show_image]').val() == 1) {
						$('.template-main-image-width-and-height-instruction').show();
					}

					if ($('select[name=main_show_description]').val() == 1) {
						$('.template-main-description-limit-instruction').show();
					}
				} else if ($('select[name=assignment]').val() == 3) {
					$('.button-view-shortcodes-instruction').show();
					$('.assignment-email-template-3-instruction').show();
					$('.template-related-product-status-instruction').show();

					if ($('select[name=related_product_status]').val() > 0) {
						$('.template-related-product-block-instruction').show();
					}

					$('.template-related-product-legend-instruction').show();

					if ($('select[name=related_product_status]').val() == 1) {
          	$('.template-category-related-instruction').show();
          } else if ($('select[name=related_product_status]').val() == 2) {
					  $('.template-manufacturer-related-instruction').show();
          } else if ($('select[name=related_product_status]').val() == 3) {
					  $('.template-product-related-instruction').show();
          }

					if ($('select[name=related_show_image]').val() == 1) {
						$('.template-related-image-width-and-height-instruction').show();
					}

					if ($('select[name=related_show_description]').val() == 1) {
						$('.template-related-description-limit-instruction').show();
					}

					if ($('select[name=main_show_image]').val() == 1) {
						$('.template-main-image-width-and-height-instruction').show();
					}

					if ($('select[name=main_show_description]').val() == 1) {
						$('.template-main-description-limit-instruction').show();
					}
				} else if ($('select[name=assignment]').val() == 4) {
					$('select[name=related_product_status] option[value=11]').attr('disabled',false);
					$('select[name=related_product_status] option[value=12]').attr('disabled',false);
					$('select[name=related_product_status] option[value=13]').attr('disabled',false);

					$('.button-view-shortcodes-instruction').show();
					$('.assignment-email-template-4-instruction').show();
					$('.template-related-product-status-instruction').show();

					if ($('select[name=related_product_status]').val() > 0) {
						$('.template-related-product-block-instruction').show();
					}

					$('.template-related-product-legend-instruction').show();

					if ($('select[name=related_product_status]').val() == 1) {
          	$('.template-category-related-instruction').show();
          } else if ($('select[name=related_product_status]').val() == 2) {
					  $('.template-manufacturer-related-instruction').show();
          } else if ($('select[name=related_product_status]').val() == 3) {
					  $('.template-product-related-instruction').show();
          }

					if ($('select[name=related_show_image]').val() == 1) {
						$('.template-related-image-width-and-height-instruction').show();
					}

					if ($('select[name=related_show_description]').val() == 1) {
						$('.template-related-description-limit-instruction').show();
					}

					if ($('select[name=main_show_image]').val() == 1) {
						$('.template-main-image-width-and-height-instruction').show();
					}

					if ($('select[name=main_show_description]').val() == 1) {
						$('.template-main-description-limit-instruction').show();
					}
				} else if ($('select[name=assignment]').val() == 5) {
				  $('.button-view-shortcodes-instruction').show();
					$('.assignment-email-template-5-instruction').show();

					if ($('select[name=main_show_image]').val() == 1) {
						$('.template-main-image-width-and-height-instruction').show();
					}

					if ($('select[name=main_show_description]').val() == 1) {
						$('.template-main-description-limit-instruction').show();
					}
				} else if ($('select[name=assignment]').val() == 6) {
					$('select[name=related_product_status] option[value=11]').attr('disabled',false);
					$('select[name=related_product_status] option[value=12]').attr('disabled',false);
					$('select[name=related_product_status] option[value=13]').attr('disabled',false);

				  $('.button-view-shortcodes-instruction').show();
					$('.assignment-email-template-6-instruction').show();
					$('.template-related-product-status-instruction').show();

					if ($('select[name=related_product_status]').val() > 0) {
						$('.template-related-product-block-instruction').show();
					}

					$('.template-related-product-legend-instruction').show();

					if ($('select[name=related_product_status]').val() == 1) {
          	$('.template-category-related-instruction').show();
          } else if ($('select[name=related_product_status]').val() == 2) {
					  $('.template-manufacturer-related-instruction').show();
          } else if ($('select[name=related_product_status]').val() == 3) {
					  $('.template-product-related-instruction').show();
          }

					if ($('select[name=related_show_image]').val() == 1) {
						$('.template-related-image-width-and-height-instruction').show();
					}

					if ($('select[name=related_show_description]').val() == 1) {
						$('.template-related-description-limit-instruction').show();
					}

					if ($('select[name=main_show_image]').val() == 1) {
						$('.template-main-image-width-and-height-instruction').show();
					}

					if ($('select[name=main_show_description]').val() == 1) {
						$('.template-main-description-limit-instruction').show();
					}
				}
			}
		}

		$('select[name=assignment],select[name=related_product_status],select[name=related_show_image],select[name=related_show_description],select[name=main_show_image],select[name=main_show_description]').change(function() {
			block_visibility_instructions({a:'modal-email-template-constructor-content'});
		});

		block_visibility_instructions({a:'modal-email-template-constructor-content'});
	</script>
</div>