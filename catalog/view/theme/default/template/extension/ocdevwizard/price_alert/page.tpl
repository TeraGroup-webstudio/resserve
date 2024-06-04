<?php
##=================================================##
## @author    : OCdevWizard                        ##
## @contact   : ocdevwizard@gmail.com              ##
## @support   : http://help.ocdevwizard.com        ##
## @copyright : (c) OCdevWizard. Price Alert, 2018 ##
##=================================================##
?>
<?php echo $header; ?>
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
			<div class="table-responsive" style="overflow-x:unset;" id="history-record">
				<table class="table table-bordered">
					<thead>
					<tr>
						<td class="text-center" width="10%"><?php echo $column_product_image; ?></td>
						<td class="text-left" width="25%"><?php echo $column_product_name; ?></td>
						<td class="text-left"><?php echo $column_date_added; ?></td>
						<td class="text-left"><?php echo $column_processed; ?></td>
						<td class="text-center"><?php echo $column_action; ?></td>
					</tr>
					</thead>
					<tbody>
					<?php if ($records) { ?>
					<?php foreach ($records as $record) { ?>
					<tr>
						<td class="text-center" style="vertical-align:middle">
							<a href="<?php echo $record['product_href']; ?>" target="_blank">
								<img src="<?php echo $record['product_image']; ?>" alt="<?php echo $record['product_name']; ?>" class="img-thumbnail"/>
							</a>
						</td>
						<td class="text-left" style="vertical-align:middle">
							<a href="<?php echo $record['product_href']; ?>"><?php echo $record['product_name']; ?></a>
							<?php if ($record['option_name'] && $record['option_value']) { ?>
								<br><?php echo $record['option_name']; ?>: <?php echo $record['option_value']; ?>
							<?php } ?>
						</td>
						<td class="text-left" style="vertical-align:middle"><?php echo $record['date_added']; ?></td>
						<td class="text-left" style="vertical-align:middle"><?php echo $record['status']; ?></td>
						<td class="text-center" style="vertical-align:middle">
							<button type="button" class="btn btn-danger button-loading-white" onclick="confirm('<?php echo $text_are_you_sure; ?>') ? make_delete_action({a:this,b:'<?php echo $record['record_id']; ?>'}) : false;" data-toggle="tooltip" title="" data-original-title="<?php echo $button_delete; ?>"><i class="fa fa-trash-o"></i></button>
						</td>
					</tr>
					<?php } ?>
					<?php } else { ?>
					<tr>
						<td class="text-center" colspan="5"><?php echo $text_no_results; ?></td>
					</tr>
					<?php } ?>
					</tbody>
					<tfoot>
					<tr>
						<td colspan="5">
							<div class="row">
								<div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
								<div class="col-sm-6 text-right fixed-pagination-results"><?php echo $results; ?></div>
							</div>
						</td>
					</tr>
					</tfoot>
				</table>
			</div>
			<?php echo $content_bottom; ?>
		</div>
		<?php echo $column_right; ?>
	</div>
</div>
<?php if ($records) { ?>
<script>
  function make_delete_action(options) {
    var element = options.a || '',
        id = options.b || '';

    $.ajax({
      type: 'post',
      url: 'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/delete_record',
      data: 'delete=' + id,
      dataType: 'json',
      beforeSend: function () {
        $(element).html('<div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>');
        $('[data-toggle=\'tooltip\']').tooltip('destroy');
      },
      complete: function () {
        $(element).html('<i class="fa fa-trash-o"></i>');
        $('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
      },
      success: function (json) {
        location = 'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/page';
      },
      error: function (xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
      }
    });
  }
</script>
<?php } ?>
<?php echo $footer; ?>