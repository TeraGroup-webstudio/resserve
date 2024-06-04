<?php echo $header; ?>
<?php echo $column_left; ?>
<?php
##=================================================##
## @author    : OCdevWizard                        ##
## @contact   : ocdevwizard@gmail.com              ##
## @support   : http://help.ocdevwizard.com        ##
## @copyright : (c) OCdevWizard. Price Alert, 2018 ##
##=================================================##
?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right" id="top-nav-line">
        <div class="btn-group">
          <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-trash-o"></i>&nbsp;&nbsp;&nbsp;<span class="caret"></span></button>
          <ul class="dropdown-menu dropdown-menu-right special-dropdown">
            <li><a onclick="confirm('<?php echo $text_are_you_sure; ?>') ? make_uninstall_action({a:this}) : false;"><i class="fa fa-trash-o"></i> <?php echo $button_uninstall; ?></a></li>
            <li><a onclick="confirm('<?php echo $text_are_you_sure; ?>') ? make_uninstall_action({a:this,b:'remove_files'}) : false;"><i class="fa fa-trash-o"></i> <?php echo $button_uninstall_and_remove; ?></a></li>
          </ul>
        </div>
				<div class="btn-group">
          <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-life-ring"></i>&nbsp;&nbsp;<?php echo $button_need_help; ?>&nbsp;&nbsp;&nbsp;<span class="caret"></span></button>
          <ul class="dropdown-menu dropdown-menu-right special-dropdown">
            <li><a onclick="open_support();"><i class="fa fa-envelope-o"></i> <?php echo $button_need_help_email; ?></a></li>
            <li><a href="http://help.ocdevwizard.com/" target="_blank"><i class="fa fa-ticket"></i> <?php echo $button_need_help_ticket; ?></li>
          </ul>
        </div>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
      </div>
      <h1><?php echo $heading_title; ?> <?php echo $_version; ?></h1>
      <ul class="breadcrumb-module">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
          <?php if ($breadcrumb['href']) { ?>
            <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
          <?php } else { ?>
            <li><a><?php echo $breadcrumb['text']; ?></a></li>
          <?php } ?>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid" id="top-alerts">
    <div class="row">
      <div class="col-sm-3 col-md-3 col-lg-3">
        <!-- Nav tabs -->
        <div class="list-group list-group-root well" id="setting-tabs">
          <a class="list-group-item list-group-item-info open"><i class="fa fa-life-ring" aria-hidden="true"></i><?php echo $tab_license_setting; ?></a>
          <div class="list-group">
            <a class="list-group-item" data-toggle="tab" href="#license-extension-block" role="tab"><i class="fa fa-id-card-o"></i> <?php echo $tab_license_extension_setting; ?></a>
          </div>
        </div>
      </div>
      <div class="col-sm-9 col-md-9 col-lg-9">
        <div class="panel panel-default">
          <div class="panel-body">
            <form method="post" enctype="multipart/form-data" id="form" class="form-horizontal">
              <div class="tab-content">
                <!-- TAB License Extension block -->
                <div class="tab-pane fade active in" role="tabpanel" id="license-extension-block">
                  <div class="form-group required">
                    <label class="col-sm-12 control-label"><?php echo $text_license_key; ?></label>
                    <div class="col-sm-12">
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-key" aria-hidden="true"></i></span>
                        <input type="text" name="<?php echo $_name; ?>_license" value="<?php echo $license_key; ?>" class="form-control" id="input-license-key" placeholder="XXXXXXXX-XXXXXXXX-XXXXXXXX-XXXXXXXX" />
                        <div class="input-group-btn">
                          <button type="button" onclick="submit_index({a:this});" class="btn btn-success button-loading-white"><?php echo $button_apply_license_code; ?></button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_request_license_code; ?>:</label>
                    <div class="col-sm-12">
                      <div class="row">
                        <div class="col-sm-6">
                          <div class="input-group warning-style-license">
                            <span class="input-group-addon alert-warning"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></span>
                            <div class="alert alert-warning">
                              <?php echo $text_request_license_code_left_side; ?>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="input-group default-style-license">
                            <span class="input-group-addon alert-default"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></span>
                            <div class="alert alert-default">
                              <?php echo $text_request_license_code_right_side_1; ?>
                              <p>
                                <div class="two-sites-block">
                                  <div>
                                    ❏ <a href="https://www.opencart.com/index.php?route=marketplace/extension&filter_member=OCdevWizard" target="_blank">Opencart.com</a><br/>
                                    ❏ <a href="https://opencartforum.com/profile/794219-ocdevwizard/content/?type=downloads_file" target="_blank">Opencartforum.com</a><br/>
                                    ❏ <a href="https://liveopencart.ru/ocdevwizard" target="_blank">Liveopencart.ru</a><br/>
                                  </div>
                                  <div>
                                    ❏ <a href="https://shop.opencart-russia.ru/ocdevwizard" target="_blank">Opencart-russia.ru</a><br/>
                                    ❏ <a href="https://prodelo.biz/ocdevwizard" target="_blank">Prodelo.biz</a>
                                  </div>
                                </div>
                              </p>
                              <hr>
                              <?php echo $text_request_license_code_right_side_2; ?>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- start: code for module usability -->
<script>
$(function(){
  $('#setting-tabs a[href=\'#license-extension-block\']').trigger('click').addClass('list-group-item-warning').prepend('<i class="fa fa-chevron-right"></i>');
});

function open_license_code_request() {
  open_popup('index.php?route=extension/ocdevwizard/helper/license_code_request&<?php echo $token; ?>');
}

function open_support() {
  open_popup('index.php?route=extension/ocdevwizard/helper/need_help&<?php echo $token; ?>');
}

function show_explanation(options) {
  var element = options.a || '';
  $(element).parent().next().find('div.alert.alert-info').slideToggle();
}

function open_popup(url) {
  notify_close();

  $.magnificPopup.open({
    tLoading: '<div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>',
    items: {
      src: url,
      type: 'ajax'
    },
    showCloseBtn: false,
	  closeOnBgClick: false,
    mainClass: 'mfp-move-from-left',
    callbacks: {
      beforeOpen: function() {
        this.wrap.removeAttr('tabindex');
        $('[data-toggle=\'tooltip\']').tooltip('destroy');
        $('.tooltip.fade.top.in').remove();
      },
      open: function() {
        $('.mfp-content').addClass('mfp-with-anim');
      },
      close: function() {
        $('[data-toggle=\'tooltip\']').tooltip('destroy');
        $('.tooltip.fade.top.in').remove();
        setTimeout(function(){
          $('.mfp-move-from-left.mfp-removing.mfp-bg').css('opacity', '0')
        },500);
        $('.mfp-content').addClass('mfp-with-anim');
        $('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
        setTimeout(function(){
          notify_close();
        }, 3000);
      }
    },
    removalDelay: 500
  });
}

function submit_index(options) {
  var element = options.a || '';

  $.ajax({
    url:  'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/index_action&<?php echo $token; ?>&store_id=<?php echo $store_id; ?>',
    type: 'post',
    data: $('#form').serialize(),
    dataType: 'json',
    beforeSend: function() {
			$(element).prop('disabled', true);
			$(element).html('<div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>');
			$('[data-toggle=\'tooltip\']').tooltip('destroy');
		},
		complete: function() {
			$(element).prop('disabled', false);
      $(element).html('<?php echo $button_apply_license_code; ?>');
      $('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
		},
    success: function(json) {
      notify_close();

      if (json['error']) {
        for (i in json['error']) {
          if (i.replace(/_/g, '-') == 'warning') {
            for (b in json['error'][i]) {
              notify({b:'<?php echo $text_alert_error_heading; ?>',c:json['error'][i][b]});
            }
          } else {
            notify({a:'input-'+i.replace(/_/g, '-'),b:'<?php echo $text_alert_error_heading; ?>',c:json['error'][i],e:'<?php echo $button_fix; ?>',f:'<?php echo $button_cancel; ?>'});
          }
        }
      }

      if (json['redirect']) {
        location = json['redirect'];
      }
    }
  });
}

function make_uninstall_action(options) {
  var element = options.a || '',
		type = options.b || '';

  $.ajax({
		url: 'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/uninstall&<?php echo $token; ?>&store_id=<?php echo $store_id; ?>&type='+type,
		type: 'post',
		dataType: 'json',
		beforeSend: function() {
			if (type == 'remove_files') {
			  $(element).html('<i class="fa fa-refresh fa-spin"></i> <?php echo $button_uninstall_and_remove; ?>');
      } else {
			  $(element).html('<i class="fa fa-refresh fa-spin"></i> <?php echo $button_uninstall; ?>');
			}
			$('[data-toggle=\'tooltip\']').tooltip('destroy');
		},
		complete: function() {
			if (type == 'remove_files') {
			  $(element).html('<i class="fa fa-trash-o"></i> <?php echo $button_uninstall_and_remove; ?>');
			} else {
			  $(element).html('<i class="fa fa-trash-o"></i> <?php echo $button_uninstall; ?>');
			}
      $('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
		},
    success: function(json) {
      notify_close();

      if (json['error']) {
        for (i in json['error']) {
          if (i.replace(/_/g, '-') == 'warning') {
            for (b in json['error'][i]) {
              notify({b:'<?php echo $text_alert_error_heading; ?>',c:json['error'][i][b]});
            }
	        }
        }
      }

      if (json['success']) {
        notify({b:'<?php echo $text_alert_success_heading; ?>',c:json['success'],d:'success'});

        if (json['redirect']) {
          setTimeout(function () {
            location = json['redirect'];
          }, 2000);
        }
      }
    }
	});
}
</script>
<!-- end: code for module usability -->
<?php echo $footer; ?>
