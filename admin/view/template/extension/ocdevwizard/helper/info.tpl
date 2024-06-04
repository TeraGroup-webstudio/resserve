<div id="service-modal-body" class="mw500 info">
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
		<?php echo $product['title']; ?> <span class="modal-close" onclick="$.magnificPopup.close();"><i class="fa fa-times" aria-hidden="true"></i></span>
	</div>
	<div class="modal-body">
		<div id="service-modal-data">
			<div class="row" style="padding-bottom: 0;">
				<div class="panel-body" style="padding: 0;">
					<div class="col-sm-12">
						<fieldset>
							<legend style="margin-bottom: 10px;"><?php echo $text_marketplaces; ?></legend>
							<ul type="square" style="padding: 0 0 0 15px;">
								<?php foreach ($opencart_marketplaces_array as $value) { ?>
									<li>
										<a href="<?php echo $value['href']; ?>" target="_blank"><?php echo $value['name']; ?></a>
										<span class="pull-right"><?php if ($value['price'] != 0) { ?><s><?php echo $value['price']; ?></s><?php } ?> <b style="color: red"><?php echo $value['special']; ?></b></span>
									</li>
								<?php } ?>
							</ul>
						</fieldset>
						<fieldset>
							<legend style="margin-bottom: 10px;"><?php echo $text_information; ?></legend>
							<ul type="square" style="padding: 0 0 0 15px;">
								<li><?php echo $text_modal_date_added; ?> <b class="pull-right"><?php echo $product['date_added']; ?></b></li>
								<li><?php echo $text_modal_latest_version; ?> <b class="pull-right"><?php echo $product['latest_version']; ?></b></li>
							</ul>
						</fieldset>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal-footer" id="service-modal-footer">
		<button class="btn btn-default" onclick="$.magnificPopup.close();"><?php echo $button_close; ?></button>
	</div>
</div>
