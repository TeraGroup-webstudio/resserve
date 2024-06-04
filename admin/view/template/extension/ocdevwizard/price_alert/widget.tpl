<?php
##=================================================##
## @author    : OCdevWizard                        ##
## @contact   : ocdevwizard@gmail.com              ##
## @support   : http://help.ocdevwizard.com        ##
## @copyright : (c) OCdevWizard. Price Alert, 2018 ##
##=================================================##
?>
<div class="tile tile-primary">
  <div class="tile-heading">
    <?php echo $heading_title; ?>
  </div>
  <div class="tile-body">
  	<i class="fa fa-envelope-o" aria-hidden="true"></i>
  	<h2 class="pull-right"><?php echo $total; ?></h2>
		<div class="table-responsive" style="border:0;">
			<table class="table" style="margin-bottom:0;">
				<?php if ($results) { ?>
					<?php foreach ($results as $result) { ?>
			    	<tr>
			    		<td style="padding-left:0;padding-right:0;"><?php echo $result['name']; ?></td>
			    		<td style="padding-left:0;padding-right:0;" class="text-right"><?php echo $result['total_0']; ?> / <?php echo $result['total_1']; ?></td>
			    	</tr>
		    	<?php } ?>
	    	<?php } ?>
  		</table>
  	</div>
  </div>
  <div class="tile-footer"><a href="<?php echo $link; ?>"><?php echo $button_view_more; ?></a></div>
</div>