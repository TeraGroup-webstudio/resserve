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
			<div id="modal-banned-content">
				<div id="content" class="row pb-0">
					<div class="panel-body pt-0 pb-0">
						<ul class="nav nav-tabs" id="modal-setting-tabs">
							<li class="active dropdown">
								<a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-cog"></i> <?php echo $tab_control_panel; ?></a>
							</li>
						</ul>
						<form method="post" enctype="multipart/form-data" id="modal-form" class="form-horizontal">
							<input type="hidden" style="display:none;" name="banned_id" value="<?php echo $banned_id; ?>"/>
							<div class="tab-content row">
								<!-- TAB General block -->
								<div class="tab-pane fade active in" role="tabpanel" id="modal-banneds-general-block">
									<div class="form-group">
										<label class="col-sm-12 control-label"><?php echo $entry_status; ?></label>
										<div class="col-sm-12">
											<select name="status" id="input-status" class="form-control">
												<option value="1" <?php echo $status == 1 ? 'selected="selected"' : ''; ?>><?php echo $text_enabled; ?></option>
												<option value="0" <?php echo $status == 0 ? 'selected="selected"' : ''; ?>><?php echo $text_disabled; ?></option>
											</select>
										</div>
									</div>
									<div class="form-group required">
										<label class="col-sm-12 control-label"><?php echo $entry_ip; ?></label>
										<div class="col-sm-12">
											<input value="<?php echo $ip; ?>" type="text" name="ip" placeholder="<?php echo $placeholder_ip; ?>" class="form-control" id="modal-error-ip"/>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-12 control-label"><?php echo $entry_email; ?></label>
										<div class="col-sm-12">
											<input value="<?php echo $email; ?>" type="text" name="email" placeholder="<?php echo $placeholder_email; ?>" class="form-control" id="modal-error-email"/>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-12 control-label"><?php echo $entry_telephone; ?></label>
										<div class="col-sm-12">
											<input value="<?php echo $telephone; ?>" type="text" name="telephone" placeholder="<?php echo $placeholder_telephone; ?>" class="form-control" id="modal-error-telephone"/>
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
		<button class="btn btn-success button-loading" onclick="submit_banned({a:this,b:'close'});"><span class="hidden-lg hidden-md hidden-sm"><i class="fa fa-save"></i> </span><span class="hidden-xs"><?php echo $button_save; ?></span></button>
		<?php if ($banned_id) { ?>
		<button class="btn btn-success button-loading" onclick="submit_banned({a:this});"><span class="hidden-lg hidden-md hidden-sm"><i class="fa fa-save"></i> + <i class="fa fa-refresh"></i> </span><span class="hidden-xs"><?php echo $button_save_and_stay; ?></span></button>
		<?php } ?>
	</div>
</div>