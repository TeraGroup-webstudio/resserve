<?php
##=================================================##
## @author    : OCdevWizard                        ##
## @contact   : ocdevwizard@gmail.com              ##
## @support   : http://help.ocdevwizard.com        ##
## @copyright : (c) OCdevWizard. Price Alert, 2018 ##
##=================================================##
?>
<?php if ($histories) { ?>
  <button type="button" onclick="$('#record-constructor-block tr.filter-tr').toggle();" class="btn btn-default pull-right" data-toggle="tooltip" title="<?php echo $button_filter; ?>"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button>
  <div class="btn-group pull-right mr-3">
    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-arrows-v"></i> <?php echo $button_limit; ?>&nbsp;&nbsp;&nbsp;<span class="caret"></span></button>
    <ul class="dropdown-menu special-dropdown">
      <li class="active"><a href="javascript:void(0)" onclick="record_limit({a:this});"><input type="radio" name="limit" value="10" class="hide" checked="checked"/>10</a></li>
      <li><a href="javascript:void(0)" onclick="record_limit({a:this});"><input type="radio" name="limit" value="25" class="hide"/>25</a></li>
      <li><a href="javascript:void(0)" onclick="record_limit({a:this});"><input type="radio" name="limit" value="50" class="hide"/>50</a></li>
      <li><a href="javascript:void(0)" onclick="record_limit({a:this});"><input type="radio" name="limit" value="100" class="hide"/>100</a></li>
    </ul>
  </div>
  <button type="button" onclick="make_full_width_action({a:this});" class="btn btn-default pull-right mr-3" data-toggle="tooltip" title="<?php echo $button_full_width; ?>"><i class="fa fa-arrows-h"></i> <?php echo $button_full_width; ?></button>
  <div class="btn-group">
    <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-trash-o"></i> <?php echo $button_delete_menu; ?>&nbsp;&nbsp;&nbsp;<span class="caret"></span></button>
    <ul class="dropdown-menu special-dropdown">
      <li><a onclick="confirm('<?php echo $text_are_you_sure; ?>') ? make_delete_action({a:this,b:'record',c:'all'}) : false;"><?php echo $button_delete_all; ?></a></li>
      <li><a onclick="confirm('<?php echo $text_are_you_sure; ?>') ? make_delete_action({a:this,b:'record',c:'all_selected'}) : false;"><?php echo $button_delete_selected; ?></a></li>
    </ul>
  </div>
<?php } ?>
<button type="button" onclick="$('a[href=#record-constructor-block]').click();$(this).html('<div class=\'spinner\'><div class=\'bounce1\'></div><div class=\'bounce2\'></div><div class=\'bounce3\'></div></div>');" class="btn btn-primary button-loading-white"><i class="fa fa-refresh"></i> <?php echo $button_update; ?></button>
<div class="special-margin"></div>
<div class="table-responsive">
  <table class="table table-bordered main-table-data">
    <thead>
      <tr>
        <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('#history-record input[name*=\'selected\']').attr('checked', this.checked);" /></td>
        <td class="text-left" width="15%"><?php echo $column_product_image; ?></td>
        <td class="text-left" width="15%"><a href="javascript:void(0)" onclick="record_sort({a:this,b:'pd.name'});"><?php echo $column_product_name; ?></a></td>
        <td class="text-left" width="15%"><a href="javascript:void(0)" onclick="record_sort({a:this,b:'r.email'});"><?php echo $column_email; ?></a></td>
        <td class="text-left" width="15%"><a href="javascript:void(0)" onclick="record_sort({a:this,b:'r.telephone'});"><?php echo $column_telephone; ?></a></td>
        <td class="text-left"><a href="javascript:void(0)" onclick="record_sort({a:this,b:'r.date_added'});"><?php echo $column_date_added; ?></a></td>
        <td class="text-left"><a href="javascript:void(0)" onclick="record_sort({a:this,b:'r.status'});"><?php echo $column_processed; ?></a></td>
        <td class="text-center"><?php echo $column_action; ?></td>
      </tr>
      <tr class="filter-tr">
        <td class="text-center fixed-thead"></td>
        <td class="text-center fixed-thead"></td>
        <td class="text-center fixed-thead input-group-sm"><input type="text" name="filter_product_name" value="" class="form-control"/></td>
        <td class="text-center fixed-thead input-group-sm"><input type="text" name="filter_email" value="" class="form-control"/></td>
        <td class="text-center fixed-thead input-group-sm"><input type="text" name="filter_telephone" value="" class="form-control"/></td>
        <td class="text-center fixed-thead input-group-sm"><input type="text" name="filter_date_added" value="" class="form-control datetime"/></td>
        <td class="text-center fixed-thead input-group-sm">
          <select name="filter_status" class="form-control">
            <option value="*"></option>
            <option value="1"><?php echo $text_yes; ?></option>
            <option value="0"><?php echo $text_no; ?></option>
          </select>
        </td>
        <td class="text-center fixed-thead">
          <button class="btn btn-default btn-sm button-loading" type="button" data-toggle="tooltip" title="<?php echo $button_filter; ?>" id="submit-filter-record-form"><span class="h-btn-i"><i class="fa fa-search"></i> </span><span class="h-btn-t"><?php echo $button_filter; ?></span</button>
          <button class="btn btn-default btn-sm button-loading" type="button" data-toggle="tooltip" title="<?php echo $button_clear_filter; ?>" id="clear-filter-record-form"><span class="h-btn-i"><i class="fa fa-eraser"></i> </span><span class="h-btn-t"><?php echo $button_clear_filter; ?></span></button>
        </td>
      </tr>
    </thead>
    <tbody>
    <?php if ($histories) { ?>
      <?php foreach ($histories as $history) { ?>
      <tr>
        <td style="text-align: center;"><input type="checkbox" name="selected[]" value="<?php echo $history['record_id']; ?>" /></td>
        <td class="text-center">
          <a href="<?php echo $history['product_edit']; ?>" target="_blank">
            <img src="<?php echo $history['product_image']; ?>" alt="<?php echo $history['product_name']; ?>" class="img-thumbnail" />
          </a>
        </td>
        <td class="text-left">
					<a href="<?php echo $history['product_edit']; ?>" target="_blank"><?php echo $history['product_name']; ?></a>
					<?php if ($history['option_name'] && $history['option_value']) { ?>
						<br><?php echo $history['option_name']; ?>: <?php echo $history['option_value']; ?>
					<?php } ?>
				</td>
        <td class="text-left">
          <?php if ($history['email']) { ?>
            <?php echo $history['email']; ?>
          <?php } else { ?>
            <?php echo $text_email_not_provided; ?>
          <?php } ?>
        </td>
        <td class="text-left">
          <?php if ($history['telephone']) { ?>
            <?php echo $history['telephone']; ?>
          <?php } else { ?>
            <?php echo $text_telephone_not_provided; ?>
          <?php } ?>
        </td>
        <td class="text-left"><?php echo $history['date_added']; ?></td>
        <td class="text-left"><?php echo $history['status']; ?></td>
        <td class="text-center">
          <button type="button" class="btn btn-primary button-loading-white" onclick="open_record({a:'<?php echo $history['record_id']; ?>'});" data-toggle="tooltip" title="" data-original-title="<?php echo $button_open; ?>"><i class="fa fa-eye"></i></button>
          <?php if ($history['banned_status']) { ?>
          <button type="button" class="btn btn-default button-loading" onclick="make_banned_action({a:this,b:'<?php echo $history['record_id']; ?>',c:'remove'});" data-toggle="tooltip" title="" data-original-title="<?php echo $button_remove_banned; ?>"><i class="fa fa-unlock-alt"></i></button>
          <?php } else { ?>
          <button type="button" class="btn btn-warning button-loading-white" onclick="make_banned_action({a:this,b:'<?php echo $history['record_id']; ?>',c:'add'});" data-toggle="tooltip" title="" data-original-title="<?php echo $button_add_banned; ?>"><i class="fa fa-lock"></i></button>
          <?php } ?>
          <button type="button" class="btn btn-warning button-loading-white" onclick="confirm('<?php echo $text_are_you_sure; ?>') ? make_delete_action({a:this,b:'record',c:'selected',d:'<?php echo $history['record_id']; ?>'}) : false;" data-toggle="tooltip" title="" data-original-title="<?php echo $button_delete; ?>"><i class="fa fa-trash-o"></i></button>
        </td>
      </tr>
      <?php } ?>
      <?php } else { ?>
        <tr>
          <td class="text-center" colspan="8"><?php echo $text_no_results; ?></td>
        </tr>
      <?php } ?>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="8">
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
  $('#history-record input[name=\'filter_email\']').autocomplete({
    'source': function (request, response) {
      $.ajax({
        url: 'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/autocomplete_record&<?php echo $token; ?>&filter_email=' + encodeURIComponent(request),
        dataType: 'json',
        success: function (json) {
          response($.map(json, function (item) {
            if (item['record_id']) {
              return {
                value: item['record_id'],
                label: item['email']
              }
            }
          }));
        }
      });
    },
    'select': function (item) {
      $('#history-record input[name=\'filter_email\']').val(item['label']);
    }
  });

  $('#history-record input[name=\'filter_telephone\']').autocomplete({
    'source': function (request, response) {
      $.ajax({
        url: 'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/autocomplete_record&<?php echo $token; ?>&filter_telephone=' + encodeURIComponent(request),
        dataType: 'json',
        success: function (json) {
          response($.map(json, function (item) {
            if (item['record_id']) {
              return {
                value: item['record_id'],
                label: item['telephone']
              }
            }
          }));
        }
      });
    },
    'select': function (item) {
      $('#history-record input[name=\'filter_telephone\']').val(item['label']);
    }
  });

  $('#history-record input[name=\'filter_product_name\']').autocomplete({
    'source': function (request, response) {
      $.ajax({
        url: 'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/autocomplete_record&<?php echo $token; ?>&filter_product_name=' + encodeURIComponent(request),
        dataType: 'json',
        success: function (json) {
          response($.map(json, function (item) {
            if (item['product_id']) {
              return {
                value: item['product_id'],
                label: item['product_name']
              }
            }
          }));
        }
      });
    },
    'select': function (item) {
      $('#history-record input[name=\'filter_product_name\']').val(item['label']);
    }
  });

  $(document).on("focus", '#history-record .datetime', function() {
    $(document).not('.bootstrap-datetimepicker-widget:first').remove();
    
    $('.datetime').datetimepicker({
      format:     'YYYY-MM-DD',
      formatDate: 'YYYY-MM-DD',
    });
  });
</script>