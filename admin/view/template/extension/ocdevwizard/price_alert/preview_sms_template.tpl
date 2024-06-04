<?php
##=================================================##
## @author    : OCdevWizard                        ##
## @contact   : ocdevwizard@gmail.com              ##
## @support   : http://help.ocdevwizard.com        ##
## @copyright : (c) OCdevWizard. Price Alert, 2018 ##
##=================================================##
?>
<div id="service-modal-body" class="service-modal-body">
	<div class="modal-heading">
		<?php echo $name; ?> <span class="modal-close" onclick="$.magnificPopup.close();"><i class="fa fa-times" aria-hidden="true"></i></span>
	</div>
	<div class="modal-body">
		<div id="service-modal-data">
			<div class="row pb-0">
				<div class="panel-body pt-0"><?php echo $template; ?></div>
			</div>
		</div>
	</div>
	<div class="modal-footer" id="service-modal-footer">
		<button class="btn btn-default" onclick="$.magnificPopup.close();"><span class="hidden-md hidden-lg"><i class="fa fa-times" aria-hidden="true"></i> </span><span class="hidden-xs hidden-sm"><?php echo $button_close; ?></span></button>
	</div>
</div>