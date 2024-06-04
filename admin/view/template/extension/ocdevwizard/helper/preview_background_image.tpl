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
			<div class="row" style="padding-bottom: 15px;">
				<div class="panel-body" style="padding-top: 0;">
					<div style="background:url('<?php echo $img_src; ?>');width:100%;height:500px"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal-footer" id="service-modal-footer">
		<button class="btn btn-default" onclick="$.magnificPopup.close();"><?php echo $button_close; ?></button>
		<button class="btn btn-info" onclick="button_apply_image('<?php echo $img_id; ?>');"><?php echo $button_select_image; ?></button>
	</div>
</div>