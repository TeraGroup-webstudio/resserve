<?php echo $header; ?>
<?php
##=================================================##
## @author    : OCdevWizard                        ##
## @contact   : ocdevwizard@gmail.com              ##
## @support   : http://help.ocdevwizard.com        ##
## @copyright : (c) OCdevWizard. Price Alert, 2018 ##
##=================================================##
?>
<div class="container">
	<ul class="breadcrumb">
    <?php $b_i = 1; ?>
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
      <li>
        <?php if ($b_i < (count($breadcrumbs))) { ?>
          <a href="<?php echo $breadcrumb['href']; ?>"><span><?php echo $breadcrumb['text']; ?></span></a>
        <?php } else { ?>
          <span><?php echo $breadcrumb['text']; ?></span>
        <?php } ?>
      </li>
      <?php $b_i++; ?>
    <?php } ?>
  </ul>
	<div class="row">
		<?php echo $column_left; ?>
		<?php if ($column_left && $column_right) { ?>
		<?php $class = 'col-sm-6'; ?>
		<?php } elseif ($column_left || $column_right) { ?>
		<?php $class = 'col-sm-9'; ?>
		<?php } else { ?>
		<?php $class = 'col-sm-12'; ?>
		<?php } ?>
		<div id="content" class="<?php echo $class; ?> <?php echo $_code; ?>-content">
			<?php echo $content_top; ?>
			<h1><?php echo $heading_title; ?></h1>
			<p><?php echo $text_result_message; ?></p>
			<?php echo $content_bottom; ?>
		</div>
		<?php echo $column_right; ?>
	</div>
</div>
<?php echo $footer; ?>
