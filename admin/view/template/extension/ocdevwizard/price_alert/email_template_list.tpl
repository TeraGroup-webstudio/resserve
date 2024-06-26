<?php
##=================================================##
## @author    : OCdevWizard                        ##
## @contact   : ocdevwizard@gmail.com              ##
## @support   : http://help.ocdevwizard.com        ##
## @copyright : (c) OCdevWizard. Price Alert, 2018 ##
##=================================================##
?>
<?php if ($histories) { ?>
  <button type="button" onclick="$('#email-template-constructor-block tr.filter-tr').toggle();" class="btn btn-default pull-right" data-toggle="tooltip" title="<?php echo $button_filter; ?>"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button>
  <div class="btn-group pull-right mr-3">
    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-arrows-v"></i> <?php echo $button_limit; ?>&nbsp;&nbsp;&nbsp;<span class="caret"></span></button>
    <ul class="dropdown-menu special-dropdown">
      <li class="active"><a href="javascript:void(0)" onclick="email_template_limit({a:this});"><input type="radio" name="limit" value="10" class="hide" checked="checked"/>10</a></li>
      <li><a href="javascript:void(0)" onclick="email_template_limit({a:this});"><input type="radio" name="limit" value="25" class="hide"/>25</a></li>
      <li><a href="javascript:void(0)" onclick="email_template_limit({a:this});"><input type="radio" name="limit" value="50" class="hide"/>50</a></li>
      <li><a href="javascript:void(0)" onclick="email_template_limit({a:this});"><input type="radio" name="limit" value="100" class="hide"/>100</a></li>
    </ul>
  </div>
  <button type="button" onclick="make_full_width_action({a:this});" class="btn btn-default pull-right mr-3" data-toggle="tooltip" title="<?php echo $button_full_width; ?>"><i class="fa fa-arrows-h"></i> <?php echo $button_full_width; ?></button>
  <div class="btn-group">
    <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-trash-o"></i> <?php echo $button_delete_menu; ?>&nbsp;&nbsp;&nbsp;<span class="caret"></span></button>
    <ul class="dropdown-menu special-dropdown">
      <li><a onclick="confirm('<?php echo $text_are_you_sure; ?>') ? make_delete_action({a:this,b:'email_template',c:'all'}) : false;"><i class="fa fa-trash-o"></i> <?php echo $button_delete_all; ?></a></li>
      <li><a onclick="confirm('<?php echo $text_are_you_sure; ?>') ? make_delete_action({a:this,b:'email_template',c:'all_selected'}) : false;"><i class="fa fa-trash-o"></i> <?php echo $button_delete_selected; ?></a></li>
    </ul>
  </div>
	<div class="btn-group">
    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-copy"></i> <?php echo $button_copy_menu; ?>&nbsp;&nbsp;&nbsp;<span class="caret"></span></button>
    <ul class="dropdown-menu special-dropdown">
      <li><a onclick="confirm('<?php echo $text_are_you_sure; ?>') ? make_copy_action({a:this,b:'email_template',c:'all'}) : false;"><i class="fa fa-copy"></i> <?php echo $button_copy_all; ?></a></li>
      <li><a onclick="confirm('<?php echo $text_are_you_sure; ?>') ? make_copy_action({a:this,b:'email_template',c:'all_selected'}) : false;"><i class="fa fa-copy"></i> <?php echo $button_copy_selected; ?></a></li>
    </ul>
  </div>
<?php } ?>
<button type="button" onclick="$('a[href=#email-template-constructor-block]').click();$(this).html('<div class=\'spinner\'><div class=\'bounce1\'></div><div class=\'bounce2\'></div><div class=\'bounce3\'></div></div>');" class="btn btn-primary button-loading-white"><i class="fa fa-refresh"></i> <?php echo $button_update; ?></button>
<button type="button" onclick="open_email_template(0);" class="btn btn-primary"><i class="fa fa-plus-circle"></i> <?php echo $button_add_email_template; ?></button>
<div class="special-margin"></div>
<div class="table-responsive">
  <table class="table table-bordered main-table-data">
    <thead>
      <tr>
        <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('#history-email-template input[name*=\'selected\']').attr('checked', this.checked);" /></td>
        <td class="text-left" width="15%"><a href="javascript:void(0)" onclick="email_template_sort({a:this,b:'et.system_name'});"><?php echo $column_heading; ?></a></td>
        <td class="text-left"><a href="javascript:void(0)" onclick="email_template_sort({a:this,b:'et.date_added'});"><?php echo $column_date_added; ?></a></td>
        <td class="text-left"><a href="javascript:void(0)" onclick="email_template_sort({a:this,b:'et.date_modified'});"><?php echo $column_date_modified; ?></a></td>
        <td class="text-left"><a href="javascript:void(0)" onclick="email_template_sort({a:this,b:'et.status'});"><?php echo $column_status; ?></a></td>
        <td class="text-center"><?php echo $column_action; ?></td>
      </tr>
      <tr class="filter-tr">
        <td class="text-center fixed-thead"></td>
        <td class="text-center fixed-thead input-group-sm"><input type="text" name="filter_name" value="" class="form-control"/></td>
        <td class="text-center fixed-thead input-group-sm"><input type="text" name="filter_date_added" value="" class="form-control datetime"/></td>
        <td class="text-center fixed-thead input-group-sm"><input type="text" name="filter_date_modified" value="" class="form-control datetime"/></td>
        <td class="text-center fixed-thead input-group-sm">
          <select name="filter_status" class="form-control">
            <option value="*"></option>
            <option value="1"><?php echo $text_enabled; ?></option>
            <option value="0"><?php echo $text_disabled; ?></option>
          </select>
        </td>
        <td class="text-center fixed-thead">
          <button class="btn btn-default btn-sm button-loading" type="button" data-toggle="tooltip" title="<?php echo $button_filter; ?>" id="submit-filter-email-template-form"><span class="h-btn-i"><i class="fa fa-search"></i> </span><span class="h-btn-t"><?php echo $button_filter; ?></span</button>
          <button class="btn btn-default btn-sm button-loading" type="button" data-toggle="tooltip" title="<?php echo $button_clear_filter; ?>" id="clear-filter-email-template-form"><span class="h-btn-i"><i class="fa fa-eraser"></i> </span><span class="h-btn-t"><?php echo $button_clear_filter; ?></span></button>
        </td>
      </tr>
    </thead>
    <tbody>
      <?php if ($histories) { ?>
      <?php foreach ($histories as $history) { ?>
      <tr>
        <td style="text-align: center;"><input type="checkbox" name="selected[]" value="<?php echo $history['template_id']; ?>" /></td>
        <td class="text-left"><?php echo $history['name']; ?></td>
        <td class="text-left"><?php echo $history['date_added']; ?></td>
        <td class="text-left"><?php echo $history['date_modified']; ?></td>
        <td class="text-left"><?php echo $history['status']; ?></td>
        <td class="text-center">
          <button type="button" class="btn btn-primary" onclick="open_email_template({a:'<?php echo $history['template_id']; ?>'});" data-toggle="tooltip" title="" data-original-title="<?php echo $button_edit; ?>"><i class="fa fa-pencil"></i></button>
          <button type="button" class="btn btn-warning button-loading-white" onclick="confirm('<?php echo $text_are_you_sure; ?>') ? make_delete_action({a:this,b:'email_template',c:'selected',d:'<?php echo $history['template_id']; ?>'}) : false;" data-toggle="tooltip" title="" data-original-title="<?php echo $button_delete; ?>"><i class="fa fa-trash-o"></i></button>
          <button type="button" class="btn btn-default button-loading-white" onclick="confirm('<?php echo $text_are_you_sure; ?>') ? make_copy_action({a:this,b:'email_template',c:'selected',d:'<?php echo $history['template_id']; ?>'}) : false;" data-toggle="tooltip" title="" data-original-title="<?php echo $button_copy; ?>"><i class="fa fa-copy"></i></button>
        </td>
      </tr>
      <?php } ?>
      <?php } else { ?>
        <tr>
          <td class="text-center" colspan="6"><?php echo $text_no_results; ?></td>
        </tr>
      <?php } ?>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="6">
          <div class="row">
            <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
            <div class="col-sm-6 text-right fixed-pagination-results"><?php echo $results; ?></div>
          </div>
        </td>
      </tr>
    </tfoot>
  </table>
</div>
<script type="text/javascript">
  $('#history-email-template input[name=\'filter_name\']').autocomplete({
    'source': function(request, response) {
      $.ajax({
        url: 'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/autocomplete_email_template&<?php echo $token; ?>&filter_name='+encodeURIComponent(request),
        dataType: 'json',
        success: function(json) {
          response($.map(json, function(item) {
            return {
              label: item['name'],
              value: item['template_id']
            }
          }));
        }
      });
    },
    'select': function(item) {
      $('#history-email-template input[name=\'filter_name\']').val(item['label']);
    }
  });

  $('#history-email-template .datetime').datetimepicker({
    format:     'YYYY-MM-DD',
    formatDate: 'YYYY-MM-DD',
  });
</script>