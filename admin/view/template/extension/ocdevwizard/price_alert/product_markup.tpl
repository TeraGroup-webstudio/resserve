<?php
##=================================================##
## @author    : OCdevWizard                        ##
## @contact   : ocdevwizard@gmail.com              ##
## @support   : http://help.ocdevwizard.com        ##
## @copyright : (c) OCdevWizard. Price Alert, 2018 ##
##=================================================##
?>
<?php if ($products) { ?>
	<?php foreach ($products as $product) { ?>
	<div style="border: 1px solid #dadada; border-radius: 5px; margin: 10px 5px; width: 100%; max-width: 180px; vertical-align: text-top; padding: 15px 15px 5px 15px; display: inline-block; text-align: center;">
		<?php if ($product['thumb']) { ?>
		<a href="<?php echo $product['href']; ?>" title="<?php echo $product['name']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" style="width:100%"/></a>
		<?php } ?>
		<?php if ($product['name']) { ?>
		<div style="font-size:16px;margin: 10px 0;min-height: 36px;"><a href="<?php echo $product['href']; ?>" title="<?php echo $product['name']; ?>"><?php echo $product['name']; ?></a></div>
		<?php } ?>
		<?php if ($product['option_name'] && $product['option_value']) { ?>
		<div style="font-size:12px;margin: 10px 0;min-height: 24px;"><?php echo $product['option_name']; ?>: <?php echo $product['option_value']; ?></div>
		<?php } ?>
		<?php if ($product['description']) { ?>
		<div style="font-size:12px; min-height: 54px;"><?php echo $product['description']; ?></div>
		<?php } ?>
	</div>
	<?php } ?>
<?php } ?>