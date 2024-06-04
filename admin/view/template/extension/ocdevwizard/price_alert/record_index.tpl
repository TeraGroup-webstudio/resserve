<?php
##=================================================##
## @author    : OCdevWizard                        ##
## @contact   : ocdevwizard@gmail.com              ##
## @support   : http://help.ocdevwizard.com        ##
## @copyright : (c) OCdevWizard. Price Alert, 2018 ##
##=================================================##
?>
<div id="service-modal-body" class="mw500 service-modal-body">
	<div class="modal-heading">
		<?php echo $text_modal_heading; ?> <span class="modal-close" onclick="$.magnificPopup.close();"><i class="fa fa-times" aria-hidden="true"></i></span>
	</div>
	<div class="modal-body">
		<div id="service-modal-data">
			<div id="modal-record-content">
				<div id="content" class="row pb-0">
					<div class="panel-body pt-0 pb-0">
						<form method="post" enctype="multipart/form-data" id="modal-form" class="form-horizontal">
							<input type="hidden" style="display:none;" name="record_id" value="<?php echo $record_id; ?>"/>
							<input type="hidden" style="display:none;" name="email" value="<?php echo $email; ?>"/>
							<?php if ($fields) { ?>
								<div class="row">
									<div class="col-sm-6">
										<div class="row">
											<?php foreach ($fields as $field) { ?>
												<label class="col-sm-12 control-label mb-0"><?php echo $field['name']; ?></label>
												<?php if ($field['type'] == 'telephone') { ?>
													<div class="col-sm-12 mb-10 wbr-all"><a href="tel:<?php echo $field['value']; ?>"><?php echo $field['value']; ?></a></div>
												<?php } else if ($field['type'] == 'email') { ?>
													<div class="col-sm-12 mb-10 wbr-all"><a href="mailto:<?php echo $field['value']; ?>"><?php echo $field['value']; ?></a></div>
												<?php } else { ?>
													<div class="col-sm-12 mb-10 wbr-all"><?php echo $field['value']; ?></div>
												<?php } ?>
											<?php } ?>
											<?php if ($product_edit && $product_name) { ?>
												<label class="col-sm-12 control-label mb-0"><?php echo $column_product_name; ?></label>
												<div class="col-sm-12 mb-10 wbr-all"><a href="<?php echo $product_edit; ?>" target="_blank"><?php echo $product_name; ?></a></div>
											<?php } ?>
											<?php if ($option_name) { ?>
												<label class="col-sm-12 control-label mb-0"><?php echo $text_option_name; ?></label>
												<div class="col-sm-12 mb-10 wbr-all"><?php echo $option_name; ?></div>
											<?php } ?>
											<?php if ($option_value) { ?>
												<label class="col-sm-12 control-label mb-0"><?php echo $text_option_value; ?></label>
												<div class="col-sm-12 mb-10 wbr-all"><?php echo $option_value; ?></div>
											<?php } ?>
											<?php if ($old_product_price) { ?>
												<label class="col-sm-12 control-label mb-0"><?php echo $text_old_product_price; ?></label>
												<div class="col-sm-12 mb-10 wbr-all"><?php echo $old_product_price; ?></div>
											<?php } ?>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="row">
											<?php if ($record_id) { ?>
												<label class="col-sm-12 control-label mb-0">ID</label>
												<div class="col-sm-12 mb-10 wbr-all"><?php echo $record_id; ?></div>
											<?php } ?>
											<?php if ($store_url && $store_name) { ?>
												<label class="col-sm-12 control-label mb-0"><?php echo $text_store; ?></label>
												<div class="col-sm-12 mb-10 wbr-all"><a href="<?php echo $store_url; ?>" target="_blank"><?php echo $store_name; ?></a></div>
											<?php } ?>
											<?php if ($ip) { ?>
												<label class="col-sm-12 control-label mb-0"><?php echo $column_ip; ?></label>
												<div class="col-sm-12 mb-10 wbr-all"><?php echo $ip; ?></div>
											<?php } ?>
											<?php if ($referer) { ?>
												<label class="col-sm-12 control-label mb-0"><?php echo $text_referer; ?></label>
												<div class="col-sm-12 mb-10 wbr-all"><a href="<?php echo $referer; ?>" target="_blank"><?php echo $referer; ?></a></div>
											<?php } ?>
											<?php if ($user_agent) { ?>
												<label class="col-sm-12 control-label mb-0"><?php echo $text_user_agent; ?></label>
												<div class="col-sm-12 mb-10 wbr-all"><?php echo $user_agent; ?></div>
											<?php } ?>
											<?php if ($accept_language) { ?>
												<label class="col-sm-12 control-label mb-0"><?php echo $text_accept_language; ?></label>
												<div class="col-sm-12 mb-10 wbr-all"><?php echo $accept_language; ?></div>
											<?php } ?>
										</div>
									</div>
								</div>
							<?php } ?>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal-footer" id="service-modal-footer">
		<button class="btn btn-default" onclick="$.magnificPopup.close();"><span class="hidden-lg hidden-md hidden-sm"><i class="fa fa-times" aria-hidden="true"></i> </span><span class="hidden-xs"><?php echo $button_close; ?></span></button>
	</div>
</div>
