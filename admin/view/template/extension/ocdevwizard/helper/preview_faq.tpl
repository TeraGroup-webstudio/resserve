<div id="service-modal-body" class="mw500">
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
		<?php echo $text_preview_image; ?> <span class="modal-close" onclick="$.magnificPopup.close();"><i class="fa fa-times" aria-hidden="true"></i></span>
	</div>
	<div class="modal-body">
		<div id="service-modal-data">
			<div class="row" style="padding-bottom: 0;">
				<div class="panel-body" style="padding-top: 0;">
					<div class="col-sm-12">
						<img src="http://images.ocdevwizard.com/<?php echo $module_name; ?>/<?php echo $img_name; ?>.gif" width="100%" />
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal-footer" id="service-modal-footer">
		<button class="btn btn-default" onclick="$.magnificPopup.close();"><?php echo $button_close; ?></button>
		<a href="http://images.ocdevwizard.com/<?php echo $module_name; ?>/<?php echo $img_name; ?>.gif" class="btn btn-info" target="_blank"><?php echo $button_open_image_in_original_size; ?></a>
	</div>
</div>
