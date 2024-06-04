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
      <div class="pull-right">
        <button type="button" onclick="submit_base({a:this});" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-success button-loading-white"><i class="fa fa-save"></i></button>
        <div class="btn-group">
          <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-trash-o"></i>&nbsp;&nbsp;&nbsp;<span class="caret"></span></button>
          <ul class="dropdown-menu dropdown-menu-right special-dropdown">
            <li><a onclick="confirm('<?php echo $text_are_you_sure; ?>') ? make_uninstall_action({a:this}) : false;"><i class="fa fa-trash-o"></i> <?php echo $button_uninstall; ?></a></li>
            <li><a onclick="confirm('<?php echo $text_are_you_sure; ?>') ? make_uninstall_action({a:this,b:'remove_files'}) : false;"><i class="fa fa-trash-o"></i> <?php echo $button_uninstall_and_remove; ?></a></li>
            <li role="separator" class="divider"></li>
            <li><a onclick="confirm('<?php echo $text_are_you_sure; ?>') ? make_cache_action({a:this}) : false;"><i class="fa fa-trash-o"></i> <?php echo $button_cache; ?></a></li>
            <li><a onclick="confirm('<?php echo $text_are_you_sure; ?>') ? make_cache_action({a:this,b:'cache_backup'}) : false;"><i class="fa fa-trash-o"></i> <?php echo $button_cache_backup; ?></a></li>
            <li role="separator" class="divider"></li>
            <li><a onclick="confirm('<?php echo $text_are_you_sure; ?>') ? make_restore_action({a:this}) : false;"><i class="fa fa-repeat"></i> <?php echo $button_restore; ?></a></li>
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
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-3 col-md-3 col-lg-3" id="main-column-left">
        <div class="btn-group mb-10 w-100">
          <button type="button" class="btn btn-default dropdown-toggle btn-block" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog"></i> <?php echo $text_select_store; ?> <span class="caret"></span></button>
          <ul class="dropdown-menu">
            <?php foreach ($all_stores as $store) { ?>
              <li><a href="<?php echo $store['href']; ?>"><?php if ($store_id == $store['store_id']) { ?><i class="fa fa-check-square-o"></i><?php } else { ?><i class="fa fa-square-o"></i><?php } ?> <?php echo $store['name']; ?></a></li>
            <?php } ?>
          </ul>
        </div>
        <!-- Nav tabs -->
        <div class="btn-group visible-xs mb-10 w-100">
          <div class="navbar-header" id="mobile-menu-column">
            <button type="button" class="btn btn-primary btn-block" data-toggle="collapse" data-target="#setting-tabs"><i class="fa fa-bars"></i> <?php echo $text_menu_button; ?></button>
          </div>
        </div>
        <div class="list-group list-group-root well collapse navbar-collapse" id="setting-tabs">
          <a class="list-group-item list-group-item-info open" id="collaps-menu-1" onclick="collapse_blocks({a:this,b:'menu_items'})"><i class="fa fa-cog"></i><?php echo $tab_control_panel; ?> <span><i class="fa fa-minus-square"></i><i class="fa fa-plus-square"></i></span></a>
          <div class="list-group">
            <a class="list-group-item" data-toggle="tab" href="#general-block" role="tab"><i class="fa fa-cogs"></i> <?php echo $tab_general_setting; ?></a>
            <a class="list-group-item" data-toggle="tab" href="#basic-block" role="tab"><i class="fa fa-cogs"></i> <?php echo $tab_basic_setting; ?></a>
            <a class="list-group-item" data-toggle="tab" href="#layout-block" role="tab"><i class="fa fa-eye"></i> <?php echo $tab_layout_setting; ?></a>
            <a class="list-group-item" data-toggle="tab" href="#popup-block" role="tab"><i class="fa fa-clone"></i> <?php echo $tab_popup_setting; ?></a>
            <a class="list-group-item" data-toggle="tab" href="#css-block" role="tab"><i class="fa fa-css3"></i> <?php echo $tab_css_setting; ?></a>
            <a class="list-group-item" data-toggle="tab" href="#cron-block" role="tab"><i class="fa fa-tasks"></i> <?php echo $tab_cron_setting; ?></a>
            <a class="list-group-item" data-toggle="tab" href="#config-import-export-block" role="tab"><i class="fa fa-file-archive-o"></i> <?php echo $tab_config_import_export_setting; ?></a>
          </div>
          <a class="list-group-item list-group-item-info open" id="collaps-menu-2" onclick="collapse_blocks({a:this,b:'menu_items'})"><i class="fa fa-list-alt"></i><?php echo $tab_field_setting; ?> <span><i class="fa fa-minus-square"></i><i class="fa fa-plus-square"></i></span></a>
          <div class="list-group">
            <a class="list-group-item" data-toggle="tab" href="#field-constructor-block" role="tab"><i class="fa fa-cogs"></i> <?php echo $tab_field_constructor_setting; ?></a>
            <a class="list-group-item" data-toggle="tab" href="#field-import-export-block" role="tab"><i class="fa fa-file-archive-o"></i> <?php echo $tab_field_import_export_setting; ?></a>
          </div>
          <a class="list-group-item list-group-item-info open" id="collaps-menu-3" onclick="collapse_blocks({a:this,b:'menu_items'})"><i class="fa fa-list-alt"></i><?php echo $tab_record_setting; ?> <span><i class="fa fa-minus-square"></i><i class="fa fa-plus-square"></i></span></a>
          <div class="list-group">
            <a class="list-group-item" data-toggle="tab" href="#record-constructor-block" role="tab"><i class="fa fa-cogs"></i> <?php echo $tab_record_constructor_setting; ?></a>
            <a class="list-group-item" data-toggle="tab" href="#record-import-export-block" role="tab"><i class="fa fa-file-archive-o"></i> <?php echo $tab_record_import_export_setting; ?></a>
          </div>
          <a class="list-group-item list-group-item-info open" id="collaps-menu-4" onclick="collapse_blocks({a:this,b:'menu_items'})"><i class="fa fa-bars"></i><?php echo $tab_banned_setting; ?> <span><i class="fa fa-minus-square"></i><i class="fa fa-plus-square"></i></span></a>
          <div class="list-group">
            <a class="list-group-item" data-toggle="tab" href="#banned-constructor-block" role="tab"><i class="fa fa-ban"></i> <?php echo $tab_banned_constructor_setting; ?></a>
            <a class="list-group-item" data-toggle="tab" href="#banned-import-export-block" role="tab"><i class="fa fa-file-archive-o"></i> <?php echo $tab_banned_import_export_setting; ?></a>
          </div>
          <a class="list-group-item list-group-item-info open" id="collaps-menu-5" onclick="collapse_blocks({a:this,b:'menu_items'})"><i class="fa fa-list-alt"></i><?php echo $tab_language_setting; ?> <span><i class="fa fa-minus-square"></i><i class="fa fa-plus-square"></i></span></a>
          <div class="list-group">
            <a class="list-group-item" data-toggle="tab" href="#language-block" role="tab"><i class="fa fa-flag-o"></i> <?php echo $tab_basic_language_setting; ?></a>
          </div>
          <a class="list-group-item list-group-item-info open" id="collaps-menu-6" onclick="collapse_blocks({a:this,b:'menu_items'})"><i class="fa fa-bars"></i><?php echo $tab_email_template_setting; ?> <span><i class="fa fa-minus-square"></i><i class="fa fa-plus-square"></i></span></a>
          <div class="list-group">
            <a class="list-group-item" data-toggle="tab" href="#email-template-constructor-block" role="tab"><i class="fa fa-cogs"></i> <?php echo $tab_email_template_constructor_setting; ?></a>
            <a class="list-group-item" data-toggle="tab" href="#email-template-import-export-block" role="tab"><i class="fa fa-file-archive-o"></i> <?php echo $tab_email_template_import_export_setting; ?></a>
          </div>
          <a class="list-group-item list-group-item-info open" id="collaps-menu-7" onclick="collapse_blocks({a:this,b:'menu_items'})"><i class="fa fa-bars"></i><?php echo $tab_sms_template_setting; ?> <span><i class="fa fa-minus-square"></i><i class="fa fa-plus-square"></i></span></a>
          <div class="list-group">
            <a class="list-group-item" data-toggle="tab" href="#sms-template-constructor-block" role="tab"><i class="fa fa-cogs"></i> <?php echo $tab_sms_template_constructor_setting; ?></a>
            <a class="list-group-item" data-toggle="tab" href="#sms-template-import-export-block" role="tab"><i class="fa fa-file-archive-o"></i> <?php echo $tab_sms_template_import_export_setting; ?></a>
          </div>
          <a class="list-group-item list-group-item-info open" id="collaps-menu-8" onclick="collapse_blocks({a:this,b:'menu_items'})"><i class="fa fa-bars"></i><?php echo $tab_marketing_tools_setting; ?> <span><i class="fa fa-minus-square"></i><i class="fa fa-plus-square"></i></span></a>
          <div class="list-group">
            <a class="list-group-item" data-toggle="tab" href="#marketing-tools-block" role="tab"><i class="fa fa-cogs"></i> <?php echo $tab_marketing_tools_main_setting; ?></a>
          </div>
          <a class="list-group-item list-group-item-info open" id="collaps-menu-9" onclick="collapse_blocks({a:this,b:'menu_items'})"><i class="fa fa-life-ring"></i><?php echo $tab_license_setting; ?> <span><i class="fa fa-minus-square"></i><i class="fa fa-plus-square"></i></span></a>
          <div class="list-group">
            <a class="list-group-item" data-toggle="tab" href="#license-extension-block" role="tab"><i class="fa fa-id-card-o"></i> <?php echo $tab_license_extension_setting; ?></a>
          </div>
        </div>
      </div>
      <div class="col-sm-9 col-md-9 col-lg-9" id="main-content">
        <div class="panel panel-default">
          <div class="panel-body">
            <form method="post" enctype="multipart/form-data" id="form" class="form-horizontal">
              <div class="tab-content">
                <!-- TAB General block -->
                <div class="tab-pane fade active in" role="tabpanel" id="general-block">
                  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_activate_module; ?></label>
                    <div class="col-sm-12">
                      <div class="btn-group btn-toggle" data-toggle="buttons">
                        <label class="btn <?php echo $form_data['activate'] == 1 ? 'active btn-success' : 'btn-default'; ?>">
                          <input type="radio"
                            name="form_data[activate]"
                            value="1"
                            autocomplete="off"
                            <?php echo $form_data['activate'] == 1 ? 'checked="checked"' : ''; ?>
                          /><?php echo $text_yes; ?>
                        </label>
                        <label class="btn <?php echo $form_data['activate'] == 0 ? 'active btn-success' : 'btn-default'; ?>">
                          <input type="radio"
                            name="form_data[activate]"
                            value="0"
                            autocomplete="off"
                            <?php echo $form_data['activate'] == 0 ? 'checked="checked"' : ''; ?>
                          /><?php echo $text_no; ?>
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_notification_event; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
                    <div class="col-sm-12">
                      <select name="form_data[notification_event]" class="form-control">
                        <option value="1" <?php echo $form_data['notification_event'] == 1 ? 'selected="selected"' : ''; ?>><?php echo $text_notification_event_1; ?></option>
                        <option value="2" <?php echo $form_data['notification_event'] == 2 ? 'selected="selected"' : ''; ?>><?php echo $text_notification_event_2; ?></option>
                        <option value="3" <?php echo $form_data['notification_event'] == 3 ? 'selected="selected"' : ''; ?>><?php echo $text_notification_event_3; ?></option>
                      </select>
                      <div class="alert alert-info" role="alert"><?php echo $text_notification_event_faq; ?></div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_notification_type; ?></label>
                    <div class="col-sm-12">
                      <select name="form_data[notification_type]" class="form-control">
                        <option value="1" <?php echo $form_data['notification_type'] == 1 ? 'selected="selected"' : ''; ?>><?php echo $text_notification_type_1; ?></option>
                        <option value="2" <?php echo $form_data['notification_type'] == 2 ? 'selected="selected"' : ''; ?>><?php echo $text_notification_type_2; ?></option>
                        <option value="3" <?php echo $form_data['notification_type'] == 3 ? 'selected="selected"' : ''; ?>><?php echo $text_notification_type_3; ?></option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group required sms-gate-instruction">
                    <label class="col-sm-12 control-label"><?php echo $text_sms_gate; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
                    <div class="col-sm-12">
                      <select name="form_data[sms_gate]" class="form-control" id="input-sms-gate">
                        <option value=""><?php echo $text_make_a_choice; ?></option>
                        <option value="1" <?php echo $form_data['sms_gate'] == 1 ? 'selected="selected"' : ''; ?>><?php echo $text_sms_gate_1; ?></option>
                        <option value="2" <?php echo $form_data['sms_gate'] == 2 ? 'selected="selected"' : ''; ?>><?php echo $text_sms_gate_2; ?></option>
                        <option value="3" <?php echo $form_data['sms_gate'] == 3 ? 'selected="selected"' : ''; ?>><?php echo $text_sms_gate_3; ?></option>
                        <option value="4" <?php echo $form_data['sms_gate'] == 4 ? 'selected="selected"' : ''; ?>><?php echo $text_sms_gate_4; ?></option>
                      </select>
                      <div class="alert alert-info" role="alert"><?php echo $text_sms_gate_faq; ?></div>
                    </div>
                  </div>
                  <div class="form-group required sms-gate-1-instruction">
                    <label class="col-sm-12 control-label"><?php echo $text_smsru_api; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
                    <div class="col-sm-12">
                      <input value="<?php echo $form_data['smsru_api']; ?>" type="text" name="form_data[smsru_api]" class="form-control" id="input-smsru-api" />
                      <div class="alert alert-info" role="alert"><?php echo $text_smsru_api_faq; ?></div>
                    </div>
                  </div>
                  <div class="form-group sms-gate-1-instruction">
                    <label class="col-sm-12 control-label"><?php echo $text_smsru_from; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
                    <div class="col-sm-12">
                      <input value="<?php echo $form_data['smsru_from']; ?>" type="text" name="form_data[smsru_from]" class="form-control" id="input-smsru-from" />
                      <div class="alert alert-info" role="alert"><?php echo $text_smsru_from_faq; ?></div>
                    </div>
                  </div>
                  <div class="form-group required sms-gate-2-instruction">
                    <label class="col-sm-12 control-label"><?php echo $text_smscabru_login; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
                    <div class="col-sm-12">
                      <input value="<?php echo $form_data['smscabru_login']; ?>" type="text" name="form_data[smscabru_login]" class="form-control" id="input-smscabru-login" />
                      <div class="alert alert-info" role="alert"><?php echo $text_smscabru_login_faq; ?></div>
                    </div>
                  </div>
                  <div class="form-group required sms-gate-2-instruction">
                    <label class="col-sm-12 control-label"><?php echo $text_smscabru_password; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
                    <div class="col-sm-12">
                      <input value="<?php echo $form_data['smscabru_password']; ?>" type="text" name="form_data[smscabru_password]" class="form-control" id="input-smscabru-password" />
                      <div class="alert alert-info" role="alert"><?php echo $text_smscabru_password_faq; ?></div>
                    </div>
                  </div>
                  <div class="form-group sms-gate-2-instruction">
                    <label class="col-sm-12 control-label"><?php echo $text_smscabru_from; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
                    <div class="col-sm-12">
                      <input value="<?php echo $form_data['smscabru_from']; ?>" type="text" name="form_data[smscabru_from]" class="form-control" id="input-smscabru-from" />
                      <div class="alert alert-info" role="alert"><?php echo $text_smscabru_from_faq; ?></div>
                    </div>
                  </div>
                  <div class="form-group required sms-gate-3-instruction">
                    <label class="col-sm-12 control-label"><?php echo $text_smscua_login; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
                    <div class="col-sm-12">
                      <input value="<?php echo $form_data['smscua_login']; ?>" type="text" name="form_data[smscua_login]" class="form-control" id="input-smscua-login" />
                      <div class="alert alert-info" role="alert"><?php echo $text_smscua_login_faq; ?></div>
                    </div>
                  </div>
                  <div class="form-group required sms-gate-3-instruction">
                    <label class="col-sm-12 control-label"><?php echo $text_smscua_password; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
                    <div class="col-sm-12">
                      <input value="<?php echo $form_data['smscua_password']; ?>" type="text" name="form_data[smscua_password]" class="form-control" id="input-smscua-password" />
                      <div class="alert alert-info" role="alert"><?php echo $text_smscua_password_faq; ?></div>
                    </div>
                  </div>
                  <div class="form-group sms-gate-3-instruction">
                    <label class="col-sm-12 control-label"><?php echo $text_smscua_from; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
                    <div class="col-sm-12">
                      <input value="<?php echo $form_data['smscua_from']; ?>" type="text" name="form_data[smscua_from]" class="form-control" id="input-smscua-from" />
                      <div class="alert alert-info" role="alert"><?php echo $text_smscua_from_faq; ?></div>
                    </div>
                  </div>
                  <div class="form-group required sms-gate-4-instruction">
                    <label class="col-sm-12 control-label"><?php echo $text_turbosmsua_login; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
                    <div class="col-sm-12">
                      <input value="<?php echo $form_data['turbosmsua_login']; ?>" type="text" name="form_data[turbosmsua_login]" class="form-control" id="input-turbosmsua-login" />
                      <div class="alert alert-info" role="alert"><?php echo $text_turbosmsua_login_faq; ?></div>
                    </div>
                  </div>
                  <div class="form-group required sms-gate-4-instruction">
                    <label class="col-sm-12 control-label"><?php echo $text_turbosmsua_password; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
                    <div class="col-sm-12">
                      <input value="<?php echo $form_data['turbosmsua_password']; ?>" type="text" name="form_data[turbosmsua_password]" class="form-control" id="input-turbosmsua-password" />
                      <div class="alert alert-info" role="alert"><?php echo $text_turbosmsua_password_faq; ?></div>
                    </div>
                  </div>
                  <div class="form-group required sms-gate-4-instruction">
                    <label class="col-sm-12 control-label"><?php echo $text_turbosmsua_from; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
                    <div class="col-sm-12">
                      <input value="<?php echo $form_data['turbosmsua_from']; ?>" type="text" name="form_data[turbosmsua_from]" class="form-control" id="input-turbosmsua-from" />
                      <div class="alert alert-info" role="alert"><?php echo $text_turbosmsua_from_faq; ?></div>
                    </div>
                  </div>
                  <div class="form-group required">
										<label class="col-sm-12 control-label"><?php echo $entry_field_related; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
										<div class="col-sm-12">
											<input type="text" name="field_related" value="" placeholder="<?php echo $placeholder_field; ?>" class="form-control" />
											<div class="well well-sm" id="input-fields">
                        <?php foreach ($fields as $field) { ?>
                          <div class="well-custom-item" id="field-related-<?php echo $field['field_id']; ?>"><i class="fa fa-check-square-o"></i> <?php echo $field['name']; ?>
														<input type="hidden" name="form_data[fields][]" value="<?php echo $field['field_id']; ?>"/>
													</div>
                        <?php } ?>
											</div>
											<div class="alert alert-info" role="alert"><?php echo $entry_field_related_faq; ?> <?php echo $text_autocomplete_faq; ?></div>
										</div>
									</div>
                  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_price_type; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
                    <div class="col-sm-12">
                      <select name="form_data[price_type]" class="form-control">
                        <option value="1" <?php echo $form_data['price_type'] == 1 ? 'selected="selected"' : ''; ?>><?php echo $text_price_type_1; ?></option>
                        <option value="2" <?php echo $form_data['price_type'] == 2 ? 'selected="selected"' : ''; ?>><?php echo $text_price_type_2; ?></option>
                        <option value="3" <?php echo $form_data['price_type'] == 3 ? 'selected="selected"' : ''; ?>><?php echo $text_price_type_3; ?></option>
                      </select>
                      <div class="alert alert-info" role="alert"><?php echo $text_price_type_faq; ?></div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_related_product_status; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
                    <div class="col-sm-12">
                      <select name="form_data[related_product_status]" class="form-control">
												<option value="1" <?php echo $form_data['related_product_status'] == 1 ? 'selected="selected"' : ''; ?>><?php echo $text_related_product_status_1; ?></option>
												<option value="2" <?php echo $form_data['related_product_status'] == 2 ? 'selected="selected"' : ''; ?>><?php echo $text_related_product_status_2; ?></option>
												<option value="3" <?php echo $form_data['related_product_status'] == 3 ? 'selected="selected"' : ''; ?>><?php echo $text_related_product_status_3; ?></option>
                        <option value="4" <?php echo $form_data['related_product_status'] == 4 ? 'selected="selected"' : ''; ?>><?php echo $text_related_product_status_4; ?></option>
											</select>
                      <div class="alert alert-info" role="alert"><?php echo $text_related_product_status_faq; ?></div>
                    </div>
                  </div>
                  <div class="form-group required product-related-instruction">
                    <label class="col-sm-12 control-label"><?php echo $entry_product_related; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
                    <div class="col-sm-12">
                      <input type="text" name="related_product" value="" placeholder="<?php echo $placeholder_product; ?>" class="form-control" id="input-product-related"/>
                      <div class="well well-sm" id="product-related">
                        <?php foreach ($product_relateds as $product_related) { ?>
                          <div class="well-custom-item" id="product-related<?php echo $product_related['product_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $product_related['name']; ?>
                            <input type="hidden" name="form_data[product_related][]" value="<?php echo $product_related['product_id']; ?>"/>
                          </div>
                        <?php } ?>
                      </div>
                      <div class="alert alert-info" role="alert"><?php echo $text_autocomplete_faq; ?></div>
                    </div>
                  </div>
                  <div class="form-group required category-related-instruction">
                    <label class="col-sm-12 control-label"><?php echo $entry_category_related; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
                    <div class="col-sm-12">
                      <input type="text" name="related_category" value="" placeholder="<?php echo $placeholder_category; ?>" class="form-control" id="input-category-related"/>
                      <div class="well well-sm" id="category-related">
                        <?php foreach ($category_relateds as $category_related) { ?>
                          <div class="well-custom-item" id="category-related<?php echo $category_related['category_id']; ?>"><i class="fa fa-check-square-o"></i> <?php echo $category_related['name']; ?>
														<input type="hidden" name="form_data[category_related][]" value="<?php echo $category_related['category_id']; ?>"/>
													</div>
                        <?php } ?>
                      </div>
                      <div class="alert alert-info" role="alert"><?php echo $text_autocomplete_faq; ?></div>
                    </div>
                  </div>
                  <div class="form-group required manufacturer-related-instruction">
                    <label class="col-sm-12 control-label"><?php echo $entry_manufacturer_related; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
                    <div class="col-sm-12">
                      <input type="text" name="related_manufacturer" value="" placeholder="<?php echo $placeholder_manufacturer; ?>" class="form-control" id="input-manufacturer-related"/>
                      <div class="well well-sm" id="manufacturer-related">
                        <?php foreach ($manufacturer_relateds as $manufacturer_related) { ?>
                          <div class="well-custom-item" id="manufacturer-related<?php echo $manufacturer_related['manufacturer_id']; ?>"><i class="fa fa-check-square-o"></i> <?php echo $manufacturer_related['name']; ?>
														<input type="hidden" name="form_data[manufacturer_related][]" value="<?php echo $manufacturer_related['manufacturer_id']; ?>"/>
													</div>
                        <?php } ?>
                      </div>
                      <div class="alert alert-info" role="alert"><?php echo $text_autocomplete_faq; ?></div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_related_option_status; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
                    <div class="col-sm-12">
                      <select name="form_data[related_option_status]" class="form-control">
												<option value="0" <?php echo $form_data['related_option_status'] == 0 ? 'selected="selected"' : ''; ?>><?php echo $text_no; ?></option>
												<option value="1" <?php echo $form_data['related_option_status'] == 1 ? 'selected="selected"' : ''; ?>><?php echo $text_related_option_status_1; ?></option>
                        <option value="2" <?php echo $form_data['related_option_status'] == 2 ? 'selected="selected"' : ''; ?>><?php echo $text_related_option_status_2; ?></option>
											</select>
                      <div class="alert alert-info" role="alert"><?php echo $text_related_option_status_faq; ?></div>
                    </div>
                  </div>
                  <div class="form-group required option-related-instruction">
                    <label class="col-sm-12 control-label"><?php echo $entry_option_related; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
                    <div class="col-sm-12">
                      <input type="text" name="option_related" value="" placeholder="<?php echo $placeholder_option; ?>" class="form-control" id="input-option-related"/>
                      <div class="well well-sm" id="option-related">
                        <?php foreach ($option_relateds as $option_related) { ?>
                          <div class="well-custom-item" id="option-related<?php echo $option_related['option_id']; ?>"><i class="fa fa-check-square-o"></i> <?php echo $option_related['name']; ?>
														<input type="hidden" name="form_data[option_related][]" value="<?php echo $option_related['option_id']; ?>"/>
													</div>
                        <?php } ?>
                      </div>
                      <div class="alert alert-info" role="alert"><?php echo $entry_option_related_faq; ?> <?php echo $text_autocomplete_faq; ?></div>
                    </div>
                  </div>
                  <div class="form-group required">
                    <label class="col-sm-12 control-label"><?php echo $text_add_function_selector; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
                    <div class="col-sm-12">
                      <div class="input-group">
                        <span class="input-group-addon"><?php echo $text_onclick_indicator; ?></span>
                        <input value="<?php echo $form_data['add_function_selector']; ?>" type="text" name="form_data[add_function_selector]" class="form-control" id="input-add-function-selector" />
                        <span class="input-group-btn">
                          <button class="btn btn-default" type="button" data-faq-target="faq_1" data-toggle="tooltip" title="<?php echo $text_open_example; ?>"><i class="fa fa-info-circle"></i></button>
                        </span>
                      </div>
                      <div class="alert alert-info" role="alert"><?php echo $text_add_function_selector_faq; ?></div>
                    </div>
                  </div>
                  <div class="form-group required">
                    <label class="col-sm-12 control-label"><?php echo $text_add_id_selector; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
                    <div class="col-sm-12">
                      <div class="input-group">
                        <span class="input-group-addon"><?php echo $text_css_id_indicator; ?></span>
                        <input value="<?php echo $form_data['add_id_selector']; ?>" type="text" name="form_data[add_id_selector]" class="form-control" id="input-add-id-selector" />
                        <span class="input-group-btn">
                          <button class="btn btn-default" type="button" data-faq-target="faq_2" data-toggle="tooltip" title="<?php echo $text_open_example; ?>"><i class="fa fa-info-circle"></i></button>
                        </span>
                      </div>
                      <div class="alert alert-info" role="alert"><?php echo $text_add_id_selector_faq; ?></div>
                    </div>
                  </div>
                  <div class="form-group required">
                    <label class="col-sm-12 control-label"><?php echo $text_main_product_id_selector; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
                    <div class="col-sm-12">
                      <div class="input-group">
                        <span class="input-group-addon"><?php echo $text_mixed_indicator_id_class; ?></span>
                        <input value="<?php echo $form_data['main_product_id_selector']; ?>" type="text" name="form_data[main_product_id_selector]" class="form-control" id="input-main-product-id-selector" />
                        <span class="input-group-btn">
                          <button class="btn btn-default" type="button" data-faq-target="faq_3" data-toggle="tooltip" title="<?php echo $text_open_example; ?>"><i class="fa fa-info-circle"></i></button>
                        </span>
                      </div>
                      <div class="alert alert-info" role="alert"><?php echo $text_main_product_id_selector_faq; ?></div>
                    </div>
                  </div>
                  <div class="form-group required">
                    <label class="col-sm-12 control-label"><?php echo $entry_customer_groups; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
                    <div class="col-sm-12">
                      <div class="well well-sm" id="input-customer-groups">
                        <?php foreach ($all_customer_groups as $customer_group) { ?>
                          <input style="display:none;visibility:hidden" type="checkbox" name="form_data[customer_groups][]" value="<?php echo $customer_group['customer_group_id']; ?>" <?php echo ((isset($form_data['customer_groups']) && !empty($form_data['customer_groups'])) && in_array($customer_group['customer_group_id'], $form_data['customer_groups'])) ? 'checked' : ''; ?> id="customer-groups-label-<?php echo $customer_group['customer_group_id']; ?>"/>
													<label class="well-custom-checkbox" for="customer-groups-label-<?php echo $customer_group['customer_group_id']; ?>"><i class="fa fa-square-o"></i> <?php echo $customer_group['name']; ?></label>
                        <?php } ?>
                      </div>
                      <div class="btn-group">
                        <button type="button" class="btn btn-default btn-xs" onclick="$(this).parent().parent().find(':checkbox').trigger('click').attr('checked', true);"><?php echo $text_select_all; ?></button>
                        <button type="button" class="btn btn-default btn-xs" onclick="$(this).parent().parent().find(':checkbox').attr('checked', false);"><?php echo $text_unselect_all; ?></button>
                      </div>
                      <div class="alert alert-info" role="alert"><?php echo $text_customer_groups_faq; ?></div>
                    </div>
                  </div>
                </div>
                <!-- TAB Basic block -->
                <div class="tab-pane fade" role="tabpanel" id="basic-block">
                  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_captcha_status; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
                    <div class="col-sm-12">
                      <select name="form_data[captcha_status]" class="form-control">
												<option value="1" <?php echo $form_data['captcha_status'] == 1 ? 'selected="selected"' : ''; ?>><?php echo $text_enabled; ?></option>
												<option value="0" <?php echo $form_data['captcha_status'] == 0 ? 'selected="selected"' : ''; ?>><?php echo $text_disabled; ?></option>
											</select>
                      <div class="alert alert-info" role="alert"><?php echo $text_captcha_status_faq; ?></div>
                    </div>
                  </div>
                  <div class="form-group required captcha-site-key-instruction">
                    <label class="col-sm-12 control-label"><?php echo $text_captcha_site_key; ?></label>
                    <div class="col-sm-12">
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-key"></i></span>
                        <input value="<?php echo $form_data['captcha_site_key']; ?>" type="text" name="form_data[captcha_site_key]" class="form-control" id="input-captcha-site-key" />
                      </div>
                    </div>
                  </div>
                  <div class="form-group required captcha-secret-key-instruction">
                    <label class="col-sm-12 control-label"><?php echo $text_captcha_secret_key; ?></label>
                    <div class="col-sm-12">
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-key"></i></span>
                        <input value="<?php echo $form_data['captcha_secret_key']; ?>" type="text" name="form_data[captcha_secret_key]" class="form-control" id="input-captcha-secret-key" />
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_select_terms; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
                    <div class="col-sm-12">
                      <select name="form_data[require_information]" class="form-control">
                        <option value=""><?php echo $text_no; ?></option>
                        <?php foreach ($all_informations as $information) { ?>
                          <option value="<?php echo $information['information_id']; ?>" <?php echo (isset($form_data['require_information']) && !empty($form_data['require_information']) && $form_data['require_information'] == $information['information_id']) ? 'selected' : ''; ?>><?php echo $information['title']; ?></option>
                        <?php } ?>
                      </select>
                      <div class="alert alert-info" role="alert"><?php echo $text_select_terms_faq; ?></div>
                    </div>
                  </div>
                  <div class="form-group required user-email-template-product-price-was-changed-instruction">
                    <label class="col-sm-12 control-label"><?php echo $text_user_email_template_product_price_was_changed; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
                    <div class="col-sm-12">
                      <?php if ($email_templates_3) { ?>
                      <div class="well well-sm" id="input-user-email-template-product-price-was-changed">
                        <?php foreach ($email_templates_3 as $template) { ?>
                          <input style="display:none;visibility:hidden" type="radio" name="form_data[user_email_template_product_price_was_changed]" value="<?php echo $template['template_id']; ?>" <?php echo (isset($form_data['user_email_template_product_price_was_changed']) && $form_data['user_email_template_product_price_was_changed'] == $template['template_id']) ? 'checked' : ''; ?> id="user-email-template-product-price-was-changed-label-<?php echo $template['template_id']; ?>"/>
													<label class="well-custom-radio" for="user-email-template-product-price-was-changed-label-<?php echo $template['template_id']; ?>"><i class="fa fa-circle-o"></i> <?php echo $template['system_name']; ?> <a style="cursor:pointer;" onclick="open_email_template({a: '<?php echo $template['template_id']; ?>'});">[<?php echo $text_edit_template; ?>]</a></label>
                        <?php } ?>
                      </div>
                      <div class="btn-group">
                        <button type="button" class="btn btn-default btn-xs" onclick="$(this).parent().parent().find(':radio').attr('checked', false);"><?php echo $text_unselect_all; ?></button>
                      </div>
                      <?php } else { ?>
                        <div class="well well-sm" style="height: 69.3px; overflow: auto;" id="input-user-email-template-product-price-was-changed">
                        <?php echo $text_no_email_templates; ?>
                        </div>
                      <?php } ?>
                      <div class="alert alert-info" role="alert"><?php echo $text_user_email_template_product_price_was_changed_faq; ?></div>
                    </div>
                  </div>
                  <div class="form-group required user-email-template-product-option-in-stock-instruction">
                    <label class="col-sm-12 control-label"><?php echo $text_user_email_template_product_option_price_was_changed; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
                    <div class="col-sm-12">
                      <?php if ($email_templates_4) { ?>
                      <div class="well well-sm" id="input-user-email-template-product-option-in-stock">
                        <?php foreach ($email_templates_4 as $template) { ?>
                          <input style="display:none;visibility:hidden" type="radio" name="form_data[user_email_template_product_option_price_was_changed]" value="<?php echo $template['template_id']; ?>" <?php echo (isset($form_data['user_email_template_product_option_price_was_changed']) && $form_data['user_email_template_product_option_price_was_changed'] == $template['template_id']) ? 'checked' : ''; ?> id="user-email-template-product-option-price-was-changed-label-<?php echo $template['template_id']; ?>"/>
													<label class="well-custom-radio" for="user-email-template-product-option-price-was-changed-label-<?php echo $template['template_id']; ?>"><i class="fa fa-circle-o"></i> <?php echo $template['system_name']; ?> <a style="cursor:pointer;" onclick="open_email_template({a: '<?php echo $template['template_id']; ?>'});">[<?php echo $text_edit_template; ?>]</a></label>
                        <?php } ?>
                      </div>
                      <div class="btn-group">
                        <button type="button" class="btn btn-default btn-xs" onclick="$(this).parent().parent().find(':radio').attr('checked', false);"><?php echo $text_unselect_all; ?></button>
                      </div>
                      <?php } else { ?>
                        <div class="well well-sm" style="height: 69.3px; overflow: auto;" id="input-user-email-template-product-option-in-stock">
                        <?php echo $text_no_email_templates; ?>
                        </div>
                      <?php } ?>
                      <div class="alert alert-info" role="alert"><?php echo $text_user_email_template_product_option_price_was_changed_faq; ?></div>
                    </div>
                  </div>
                  <div class="form-group required user_sms-template-product-price-was-changed-instruction">
                    <label class="col-sm-12 control-label"><?php echo $text_user_sms_template_product_price_was_changed; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
                    <div class="col-sm-12">
                      <?php if ($sms_templates_1) { ?>
                      <div class="well well-sm" id="input-user_sms-template-product-price-was-changed">
                        <?php foreach ($sms_templates_1 as $template) { ?>
                          <input style="display:none;visibility:hidden" type="radio" name="form_data[user_sms_template_product_price_was_changed]" value="<?php echo $template['template_id']; ?>" <?php echo (isset($form_data['user_sms_template_product_price_was_changed']) && $form_data['user_sms_template_product_price_was_changed'] == $template['template_id']) ? 'checked' : ''; ?> id="user-sms-template-product-price-was-changed-label-<?php echo $template['template_id']; ?>"/>
													<label class="well-custom-radio" for="user-sms-template-product-price-was-changed-label-<?php echo $template['template_id']; ?>"><i class="fa fa-circle-o"></i> <?php echo $template['system_name']; ?> <a style="cursor:pointer;" onclick="open_sms_template({a: '<?php echo $template['template_id']; ?>'});">[<?php echo $text_edit_template; ?>]</a></label>
                        <?php } ?>
                      </div>
                      <div class="btn-group">
                        <button type="button" class="btn btn-default btn-xs" onclick="$(this).parent().parent().find(':radio').attr('checked', false);"><?php echo $text_unselect_all; ?></button>
                      </div>
                      <?php } else { ?>
                        <div class="well well-sm" style="height: 69.3px; overflow: auto;" id="input-user_sms-template-product-price-was-changed">
                        <?php echo $text_no_sms_templates; ?>
                        </div>
                      <?php } ?>
                      <div class="alert alert-info" role="alert"><?php echo $text_user_sms_template_product_price_was_changed_faq; ?></div>
                    </div>
                  </div>
                  <div class="form-group required user-sms-template-product-option-in-stock-instruction">
                    <label class="col-sm-12 control-label"><?php echo $text_user_sms_template_product_option_price_was_changed; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
                    <div class="col-sm-12">
                      <?php if ($sms_templates_2) { ?>
                      <div class="well well-sm" id="input-user-sms-template-product-option-in-stock">
                        <?php foreach ($sms_templates_2 as $template) { ?>
                          <input style="display:none;visibility:hidden" type="radio" name="form_data[user_sms_template_product_option_price_was_changed]" value="<?php echo $template['template_id']; ?>" <?php echo (isset($form_data['user_sms_template_product_option_price_was_changed']) && $form_data['user_sms_template_product_option_price_was_changed'] == $template['template_id']) ? 'checked' : ''; ?> id="user-sms-template-product-option-price-was-changed-label-<?php echo $template['template_id']; ?>"/>
													<label class="well-custom-radio" for="user-sms-template-product-option-price-was-changed-label-<?php echo $template['template_id']; ?>"><i class="fa fa-circle-o"></i> <?php echo $template['system_name']; ?> <a style="cursor:pointer;" onclick="open_sms_template({a: '<?php echo $template['template_id']; ?>'});">[<?php echo $text_edit_template; ?>]</a></label>
                        <?php } ?>
                      </div>
                      <div class="btn-group">
                        <button type="button" class="btn btn-default btn-xs" onclick="$(this).parent().parent().find(':radio').attr('checked', false);"><?php echo $text_unselect_all; ?></button>
                      </div>
                      <?php } else { ?>
                        <div class="well well-sm" style="height: 69.3px; overflow: auto;" id="input-user-sms-template-product-option-in-stock">
                        <?php echo $text_no_sms_templates; ?>
                        </div>
                      <?php } ?>
                      <div class="alert alert-info" role="alert"><?php echo $text_user_sms_template_product_option_price_was_changed_faq; ?></div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_admin_alert_status; ?></label>
                    <div class="col-sm-12">
                      <select name="form_data[admin_alert_status]" class="form-control">
												<option value="1" <?php echo $form_data['admin_alert_status'] == 1 ? 'selected="selected"' : ''; ?>><?php echo $text_enabled; ?></option>
												<option value="0" <?php echo $form_data['admin_alert_status'] == 0 ? 'selected="selected"' : ''; ?>><?php echo $text_disabled; ?></option>
											</select>
                    </div>
                  </div>
									<div class="form-group required admin-email-for-notification-instruction">
                    <label class="col-sm-12 control-label"><?php echo $text_admin_email; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
                    <div class="col-sm-12">
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
                        <input value="<?php echo $form_data['admin_email_for_notification']; ?>" type="text" name="form_data[admin_email_for_notification]" class="form-control" id="input-admin-email-for-notification" />
                      </div>
											<div class="alert alert-info" role="alert"><?php echo $text_admin_email_faq; ?></div>
                    </div>
                  </div>
									<div class="form-group required admin-email-template-product-instruction">
                    <label class="col-sm-12 control-label"><?php echo $text_admin_email_template_product; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
                    <div class="col-sm-12">
                      <?php if ($email_templates_1) { ?>
                      <div class="well well-sm" id="input-admin-email-template-product">
                        <?php foreach ($email_templates_1 as $template) { ?>
                          <input style="display:none;visibility:hidden" type="radio" name="form_data[admin_email_template_product]" value="<?php echo $template['template_id']; ?>" <?php echo (isset($form_data['admin_email_template_product']) && $form_data['admin_email_template_product'] == $template['template_id']) ? 'checked' : ''; ?> id="admin-email-template-product-label-<?php echo $template['template_id']; ?>"/>
													<label class="well-custom-radio" for="admin-email-template-product-label-<?php echo $template['template_id']; ?>"><i class="fa fa-circle-o"></i> <?php echo $template['system_name']; ?> <a style="cursor:pointer;" onclick="open_email_template({a: '<?php echo $template['template_id']; ?>'});">[<?php echo $text_edit_template; ?>]</a></label>
                        <?php } ?>
                      </div>
                      <div class="btn-group">
                        <button type="button" class="btn btn-default btn-xs" onclick="$(this).parent().parent().find(':radio').attr('checked', false);"><?php echo $text_unselect_all; ?></button>
                      </div>
                      <?php } else { ?>
                        <div class="well well-sm" style="height: 69.3px; overflow: auto;" id="input-admin-email-template-product">
                        <?php echo $text_no_email_templates; ?>
                        </div>
                      <?php } ?>
                      <div class="alert alert-info" role="alert"><?php echo $text_admin_email_template_product_faq; ?></div>
                    </div>
                  </div>
                  <div class="form-group required admin-email-template-product-option-instruction">
                    <label class="col-sm-12 control-label"><?php echo $text_admin_email_template_product_option; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
                    <div class="col-sm-12">
                      <?php if ($email_templates_5) { ?>
                      <div class="well well-sm" id="input-admin-email-template-product-option">
                        <?php foreach ($email_templates_5 as $template) { ?>
                          <input style="display:none;visibility:hidden" type="radio" name="form_data[admin_email_template_product_option]" value="<?php echo $template['template_id']; ?>" <?php echo (isset($form_data['admin_email_template_product_option']) && $form_data['admin_email_template_product_option'] == $template['template_id']) ? 'checked' : ''; ?> id="admin-email-template-product-option-label-<?php echo $template['template_id']; ?>"/>
													<label class="well-custom-radio" for="admin-email-template-product-option-label-<?php echo $template['template_id']; ?>"><i class="fa fa-circle-o"></i> <?php echo $template['system_name']; ?> <a style="cursor:pointer;" onclick="open_email_template({a: '<?php echo $template['template_id']; ?>'});">[<?php echo $text_edit_template; ?>]</a></label>
                        <?php } ?>
                      </div>
                      <div class="btn-group">
                        <button type="button" class="btn btn-default btn-xs" onclick="$(this).parent().parent().find(':radio').attr('checked', false);"><?php echo $text_unselect_all; ?></button>
                      </div>
                      <?php } else { ?>
                        <div class="well well-sm" style="height: 69.3px; overflow: auto;" id="input-admin-email-template-product-option">
                        <?php echo $text_no_email_templates; ?>
                        </div>
                      <?php } ?>
                      <div class="alert alert-info" role="alert"><?php echo $text_admin_email_template_product_option_faq; ?></div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_user_alert_status; ?></label>
                    <div class="col-sm-12">
                      <select name="form_data[user_alert_status]" class="form-control">
												<option value="1" <?php echo $form_data['user_alert_status'] == 1 ? 'selected="selected"' : ''; ?>><?php echo $text_enabled; ?></option>
												<option value="0" <?php echo $form_data['user_alert_status'] == 0 ? 'selected="selected"' : ''; ?>><?php echo $text_disabled; ?></option>
											</select>
                    </div>
                  </div>
                  <div class="form-group required user-email-template-product-instruction">
                    <label class="col-sm-12 control-label"><?php echo $text_user_email_template_product; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
                    <div class="col-sm-12">
                      <?php if ($email_templates_2) { ?>
                      <div class="well well-sm" id="input-user-email-template-product">
                        <?php foreach ($email_templates_2 as $template) { ?>
                          <input style="display:none;visibility:hidden" type="radio" name="form_data[user_email_template_product]" value="<?php echo $template['template_id']; ?>" <?php echo (isset($form_data['user_email_template_product']) && $form_data['user_email_template_product'] == $template['template_id']) ? 'checked' : ''; ?> id="user-email-template-product-label-<?php echo $template['template_id']; ?>"/>
													<label class="well-custom-radio" for="user-email-template-product-label-<?php echo $template['template_id']; ?>"><i class="fa fa-circle-o"></i> <?php echo $template['system_name']; ?> <a style="cursor:pointer;" onclick="open_email_template({a: '<?php echo $template['template_id']; ?>'});">[<?php echo $text_edit_template; ?>]</a></label>
                        <?php } ?>
                      </div>
                      <div class="btn-group">
                        <button type="button" class="btn btn-default btn-xs" onclick="$(this).parent().parent().find(':radio').attr('checked', false);"><?php echo $text_unselect_all; ?></button>
                      </div>
                      <?php } else { ?>
                        <div class="well well-sm" style="height: 69.3px; overflow: auto;" id="input-user-email-template-product">
                        <?php echo $text_no_email_templates; ?>
                        </div>
                      <?php } ?>
                      <div class="alert alert-info" role="alert"><?php echo $text_user_email_template_product_faq; ?></div>
                    </div>
                  </div>
                  <div class="form-group required user-email-template-product-option-instruction">
                    <label class="col-sm-12 control-label"><?php echo $text_user_email_template_product_option; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
                    <div class="col-sm-12">
                      <?php if ($email_templates_6) { ?>
                      <div class="well well-sm" id="input-user-email-template-product-option">
                        <?php foreach ($email_templates_6 as $template) { ?>
                          <input style="display:none;visibility:hidden" type="radio" name="form_data[user_email_template_product_option]" value="<?php echo $template['template_id']; ?>" <?php echo (isset($form_data['user_email_template_product_option']) && $form_data['user_email_template_product_option'] == $template['template_id']) ? 'checked' : ''; ?> id="user-email-template-product-option-label-<?php echo $template['template_id']; ?>"/>
													<label class="well-custom-radio" for="user-email-template-product-option-label-<?php echo $template['template_id']; ?>"><i class="fa fa-circle-o"></i> <?php echo $template['system_name']; ?> <a style="cursor:pointer;" onclick="open_email_template({a: '<?php echo $template['template_id']; ?>'});">[<?php echo $text_edit_template; ?>]</a></label>
                        <?php } ?>
                      </div>
                      <div class="btn-group">
                        <button type="button" class="btn btn-default btn-xs" onclick="$(this).parent().parent().find(':radio').attr('checked', false);"><?php echo $text_unselect_all; ?></button>
                      </div>
                      <?php } else { ?>
                        <div class="well well-sm" style="height: 69.3px; overflow: auto;" id="input-user-email-template-product-option">
                        <?php echo $text_no_email_templates; ?>
                        </div>
                      <?php } ?>
                      <div class="alert alert-info" role="alert"><?php echo $text_user_email_template_product_option_faq; ?></div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_direction_type; ?></label>
                    <div class="col-sm-12">
                      <?php foreach ($languages as $language) { ?>
                      <div class="btn-group-vertical btn-toggle" data-toggle="buttons">
                        <label class="btn <?php echo (isset($form_data['direction_type'][$language['language_id']]) && $form_data['direction_type'][$language['language_id']] == 1) ? 'active btn-success' : 'btn-default'; ?>">
                          <input type="radio"
                            name="form_data[direction_type][<?php echo $language['language_id']; ?>]"
                            value="1"
                            autocomplete="off"
                            <?php echo (isset($form_data['direction_type'][$language['language_id']]) && $form_data['direction_type'][$language['language_id']] == 1) ? 'checked="checked"' : ''; ?>
                          /><img src="<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $text_direction_type_1; ?>
                        </label>
                        <label class="btn <?php echo (isset($form_data['direction_type'][$language['language_id']]) && $form_data['direction_type'][$language['language_id']] == 2) ? 'active btn-success' : 'btn-default'; ?>">
                          <input type="radio"
                            name="form_data[direction_type][<?php echo $language['language_id']; ?>]"
                            value="2"
                            autocomplete="off"
                            <?php echo (isset($form_data['direction_type'][$language['language_id']]) && $form_data['direction_type'][$language['language_id']] == 2) ? 'checked="checked"' : ''; ?>
                          /><img src="<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $text_direction_type_2; ?>
                        </label>
                      </div>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_repeat_notification; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
                    <div class="col-sm-12">
                      <div class="btn-group btn-toggle" data-toggle="buttons">
                        <label class="btn <?php echo $form_data['repeat_notification'] == 1 ? 'active btn-success' : 'btn-default'; ?>">
                          <input type="radio"
                            name="form_data[repeat_notification]"
                            value="1"
                            autocomplete="off"
                            <?php echo $form_data['repeat_notification'] == 1 ? 'checked="checked"' : ''; ?>
                          /><?php echo $text_yes; ?>
                        </label>
                        <label class="btn <?php echo $form_data['repeat_notification'] == 0 ? 'active btn-success' : 'btn-default'; ?>">
                          <input type="radio"
                            name="form_data[repeat_notification]"
                            value="0"
                            autocomplete="off"
                            <?php echo $form_data['repeat_notification'] == 0 ? 'checked="checked"' : ''; ?>
                          /><?php echo $text_no; ?>
                        </label>
                      </div>
                      <div class="alert alert-info" role="alert"><?php echo $text_repeat_notification_faq; ?></div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_analytic_code_status; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
                    <div class="col-sm-12">
                      <select name="form_data[analytic_code_status]" class="form-control">
												<option value="1" <?php echo $form_data['analytic_code_status'] == 1 ? 'selected="selected"' : ''; ?>><?php echo $text_enabled; ?></option>
												<option value="0" <?php echo $form_data['analytic_code_status'] == 0 ? 'selected="selected"' : ''; ?>><?php echo $text_disabled; ?></option>
											</select>
                      <div class="alert alert-info" role="alert"><?php echo $text_analytic_code_status_faq; ?></div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_minify_main_js; ?></label>
                    <div class="col-sm-12">
                      <select name="form_data[minify_main_js]" class="form-control">
                        <option value="0" <?php echo $form_data['minify_main_js'] == 0 ? 'selected="selected"' : ''; ?>><?php echo $text_no; ?></option>
                        <option value="1" <?php echo $form_data['minify_main_js'] == 1 ? 'selected="selected"' : ''; ?>><?php echo $text_minify_main_js_1; ?></option>
                        <option value="2" <?php echo $form_data['minify_main_js'] == 2 ? 'selected="selected"' : ''; ?>><?php echo $text_minify_main_js_2; ?></option>
                      </select>
                    </div>
                  </div>
                </div>
                <!-- TAB Layout block -->
                <div class="tab-pane fade" role="tabpanel" id="layout-block">
                  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_show_on_dashboard; ?></label>
                    <div class="col-sm-12">
                      <div class="btn-group btn-toggle" data-toggle="buttons">
                        <label class="btn <?php echo $form_data['show_on_dashboard'] == 1 ? 'active btn-success' : 'btn-default'; ?>">
                          <input type="radio"
                            name="form_data[show_on_dashboard]"
                            value="1"
                            autocomplete="off"
                            <?php echo $form_data['show_on_dashboard'] == 1 ? 'checked="checked"' : ''; ?>
                          /><?php echo $text_yes; ?>
                        </label>
                        <label class="btn <?php echo $form_data['show_on_dashboard'] == 0 ? 'active btn-success' : 'btn-default'; ?>">
                          <input type="radio"
                            name="form_data[show_on_dashboard]"
                            value="0"
                            autocomplete="off"
                            <?php echo $form_data['show_on_dashboard'] == 0 ? 'checked="checked"' : ''; ?>
                          /><?php echo $text_no; ?>
                        </label>
                      </div>
                      <button class="btn btn-default" type="button" data-faq-target="faq_1" data-toggle="tooltip" title="<?php echo $text_open_example; ?>"><i class="fa fa-info-circle"></i></button>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_show_on_top_notification; ?></label>
                    <div class="col-sm-12">
                      <div class="btn-group btn-toggle" data-toggle="buttons">
                        <label class="btn <?php echo $form_data['show_on_top_notification'] == 1 ? 'active btn-success' : 'btn-default'; ?>">
                          <input type="radio"
                            name="form_data[show_on_top_notification]"
                            value="1"
                            autocomplete="off"
                            <?php echo $form_data['show_on_top_notification'] == 1 ? 'checked="checked"' : ''; ?>
                          /><?php echo $text_yes; ?>
                        </label>
                        <label class="btn <?php echo $form_data['show_on_top_notification'] == 0 ? 'active btn-success' : 'btn-default'; ?>">
                          <input type="radio"
                            name="form_data[show_on_top_notification]"
                            value="0"
                            autocomplete="off"
                            <?php echo $form_data['show_on_top_notification'] == 0 ? 'checked="checked"' : ''; ?>
                          /><?php echo $text_no; ?>
                        </label>
                      </div>
                      <button class="btn btn-default" type="button" data-faq-target="faq_2" data-toggle="tooltip" title="<?php echo $text_open_example; ?>"><i class="fa fa-info-circle"></i></button>
                    </div>
                  </div>
                  <div class="form-group">
										<label class="col-sm-12 control-label"><?php echo $entry_show_description; ?></label>
										<div class="col-sm-12">
											<select name="form_data[show_description]" class="form-control">
												<option value="0" <?php echo $form_data['show_description'] == 0 ? 'selected="selected"' : ''; ?>><?php echo $text_disabled; ?></option>
												<option value="1" <?php echo $form_data['show_description'] == 1 ? 'selected="selected"' : ''; ?>><?php echo $entry_show_description_1; ?></option>
												<option value="2" <?php echo $form_data['show_description'] == 2 ? 'selected="selected"' : ''; ?>><?php echo $entry_show_description_2; ?></option>
											</select>
										</div>
									</div>
                  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_display_type; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
                    <div class="col-sm-12">
                      <select name="form_data[display_type]" class="form-control">
                        <option value="1" <?php echo $form_data['display_type'] == 1 ? 'selected="selected"' : ''; ?>><?php echo $text_display_type_1; ?></option>
                        <option value="2" <?php echo $form_data['display_type'] == 2 ? 'selected="selected"' : ''; ?>><?php echo $text_display_type_2; ?></option>
                      </select>
                      <div class="alert alert-info" role="alert"><?php echo $text_display_type_faq; ?></div>
                    </div>
                  </div>
                  <div class="form-group sidebar-type-instruction">
										<label class="col-sm-12 control-label"><?php echo $text_sidebar_type; ?></label>
										<div class="col-sm-12">
											<select name="form_data[sidebar_type]" class="form-control">
												<option value="1" <?php echo $form_data['sidebar_type'] == 1 ? 'selected="selected"' : ''; ?>><?php echo $text_sidebar_left_side; ?></option>
												<option value="2" <?php echo $form_data['sidebar_type'] == 2 ? 'selected="selected"' : ''; ?>><?php echo $text_sidebar_right_side; ?></option>
											</select>
										</div>
									</div>
                  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_button_location; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
                    <div class="col-sm-12">
                      <select name="form_data[button_location]" class="form-control">
                        <option value="1" <?php echo $form_data['button_location'] == 1 ? 'selected="selected"' : ''; ?>><?php echo $text_button_location_1; ?></option>
                        <option value="2" <?php echo $form_data['button_location'] == 2 ? 'selected="selected"' : ''; ?>><?php echo $text_button_location_2; ?></option>
                      </select>
                      <div class="alert alert-info" role="alert"><?php echo $text_button_location_faq; ?></div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_button_class_global; ?></label>
                    <div class="col-sm-12">
                      <div class="input-group">
                        <span class="input-group-addon"><?php echo $text_css_class_indicator; ?></span>
                        <input value="<?php echo $form_data['button_class_global']; ?>" type="text" name="form_data[button_class_global]" class="form-control" id="input-button-class-global" />
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_button_location_product_page; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
                    <div class="col-sm-12">
                      <select name="form_data[button_location_product_page]" class="form-control">
                        <option value="1" <?php echo $form_data['button_location_product_page'] == 1 ? 'selected="selected"' : ''; ?>><?php echo $text_button_location_product_page_1; ?></option>
                        <option value="2" <?php echo $form_data['button_location_product_page'] == 2 ? 'selected="selected"' : ''; ?>><?php echo $text_button_location_product_page_2; ?></option>
                      </select>
                      <div class="alert alert-info" role="alert"><?php echo $text_button_location_product_page_faq; ?></div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_button_class_product_page; ?></label>
                    <div class="col-sm-12">
                      <div class="input-group">
                        <span class="input-group-addon"><?php echo $text_css_class_indicator; ?></span>
                        <input value="<?php echo $form_data['button_class_product_page']; ?>" type="text" name="form_data[button_class_product_page]" class="form-control" id="input-button-class-product-page" />
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
										<label class="col-sm-12 control-label"><?php echo $entry_call_button_view_status; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
										<div class="col-sm-12">
											<select name="form_data[call_button_view_status]" class="form-control">
												<option value="1" <?php echo $form_data['call_button_view_status'] == 1 ? 'selected="selected"' : ''; ?>><?php echo $entry_call_button_view_status_1; ?></option>
												<option value="2" <?php echo $form_data['call_button_view_status'] == 2 ? 'selected="selected"' : ''; ?>><?php echo $entry_call_button_view_status_2; ?></option>
											</select>
											<div class="alert alert-info" role="alert"><?php echo $entry_call_button_view_status_faq; ?></div>
										</div>
									</div>
									<div class="form-group required call-button-icon-instruction">
										<label class="col-sm-12 control-label"><?php echo $entry_call_button_icon; ?></label>
										<div class="col-sm-12">
											<a href="" id="thumb-call-button-icon" data-toggle="image" class="img-thumbnail"><img src="<?php echo $call_button_icon_thumb; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>"/></a>
											<input type="hidden" name="form_data[call_button_icon]" value="<?php echo $form_data['call_button_icon']; ?>" id="input-call-button-icon"/>
										</div>
									</div>
									<div class="form-group required call-button-icon-width-and-height-instruction">
										<label class="col-sm-12 control-label"><?php echo $text_dementions_of_call_button_icon; ?></label>
										<div class="col-sm-12">
											<div class="input-group">
												<span class="input-group-addon"><?php echo $text_width_indicator; ?></span>
												<input value="<?php echo $form_data['call_button_icon_width']; ?>" type="text" name="form_data[call_button_icon_width]" class="form-control" placeholder="<?php echo $text_image_width_ph; ?>" id="input-call-button-icon-width"/>
												<span class="input-group-addon"><?php echo $text_px; ?></span>
											</div>
											<div class="special-margin"></div>
											<div class="input-group">
												<span class="input-group-addon"><?php echo $text_height_indicator; ?></span>
												<input value="<?php echo $form_data['call_button_icon_height']; ?>" type="text" name="form_data[call_button_icon_height]" class="form-control" placeholder="<?php echo $text_image_height_ph; ?>" id="input-call-button-icon-height"/>
												<span class="input-group-addon"><?php echo $text_px; ?></span>
											</div>
										</div>
									</div>
                  <div class="form-group option-button-class-product-page-instruction">
                    <label class="col-sm-12 control-label"><?php echo $text_option_button_class_product_page; ?></label>
                    <div class="col-sm-12">
                      <div class="input-group">
                        <span class="input-group-addon"><?php echo $text_css_class_indicator; ?></span>
                        <input value="<?php echo $form_data['option_button_class_product_page']; ?>" type="text" name="form_data[option_button_class_product_page]" class="form-control" id="input-option-button-class-product-page" />
                      </div>
                    </div>
                  </div>
                </div>
                <!-- TAB CSS block -->
                <div class="tab-pane fade" role="tabpanel" id="css-block">
                  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_edit_css; ?></label>
                    <div class="col-sm-12">
                      <textarea id="edit-css-block-0"><?php echo $stylesheet_code; ?></textarea>
                      <br/>
                      <button type="button" class="btn btn-primary button-loading-white" data-toggle="tooltip" title="<?php echo $button_save_css; ?>" onclick="make_save_css_action({a:this,b:'0',c:'stylesheet'});"><i class="fa fa-save"></i></button>
                      <button type="button" class="btn btn-default" data-toggle="tooltip" title="<?php echo $button_restore_css; ?>" onclick="confirm('<?php echo $text_are_you_sure; ?>') ? make_restore_css_action({a:this,b:'0',c:'stylesheet',d:'stylesheet_default'}) : false;"><i class="fa fa-refresh"></i></button>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_edit_css_rtl; ?></label>
                    <div class="col-sm-12">
                      <textarea id="edit-css-block-1"><?php echo $stylesheet_code_rtl; ?></textarea>
                      <br/>
                      <button type="button" class="btn btn-primary button-loading-white" data-toggle="tooltip" title="<?php echo $button_save_css; ?>" onclick="make_save_css_action({a:this,b:'1',c:'stylesheet_rtl'});"><i class="fa fa-save"></i></button>
                      <button type="button" class="btn btn-default" data-toggle="tooltip" title="<?php echo $button_restore_css; ?>" onclick="confirm('<?php echo $text_are_you_sure; ?>') ? make_restore_css_action({a:this,b:'1',c:'stylesheet_rtl',d:'stylesheet_rtl_default'}) : false;"><i class="fa fa-refresh"></i></button>
                    </div>
                  </div>
                </div>
                <!-- TAB Cron block -->
                <div class="tab-pane fade" role="tabpanel" id="cron-block">
                  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_cron_task; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
                    <div class="col-sm-12">
                      <div class="well well-sm">
                        <input style="display:none;visibility:hidden" type="checkbox" name="form_data[cron_task][]" value="1" <?php echo (isset($form_data['cron_task']) && !empty($form_data['cron_task']) && in_array(1, $form_data['cron_task'])) ? 'checked' : ''; ?> id="cron-task-label-1"/>
												<label class="well-custom-checkbox" for="cron-task-label-1"><i class="fa fa-square-o"></i> <?php echo $text_cron_task_1; ?></label>
                        <input style="display:none;visibility:hidden" type="checkbox" name="form_data[cron_task][]" value="2" <?php echo (isset($form_data['cron_task']) && !empty($form_data['cron_task']) && in_array(2, $form_data['cron_task'])) ? 'checked' : ''; ?> id="cron-task-label-2"/>
												<label class="well-custom-checkbox" for="cron-task-label-2"><i class="fa fa-square-o"></i> <?php echo $text_cron_task_2; ?></label>
                      </div>
                      <div class="btn-group">
                        <button type="button" class="btn btn-default btn-xs" onclick="$(this).parent().parent().find(':checkbox').trigger('click').attr('checked', true);"><?php echo $text_select_all; ?></button>
                        <button type="button" class="btn btn-default btn-xs" onclick="$(this).parent().parent().find(':checkbox').attr('checked', false);"><?php echo $text_unselect_all; ?></button>
                      </div>
                      <div class="alert alert-info" role="alert"><?php echo $text_cron_info_faq; ?></div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $entry_technical_url_for_cron; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
                    <div class="col-sm-12">
                      <input value="<?php echo $technical_url_for_cron; ?>" type="text" name="tech_url_for_cron" class="form-control" readonly id="input-tech-url-for-cron" />
                      <div class="alert alert-info" role="alert"><?php echo $entry_technical_url_for_cron_faq; ?></div>
                    </div>
                  </div>
                  <div class="form-group required">
                    <label class="col-sm-12 control-label"><?php echo $entry_cron_token; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
                    <div class="col-sm-12">
                      <div class="input-group">
												<input value="<?php echo $form_data['cron_token']; ?>" type="text" name="form_data[cron_token]" class="form-control" id="input-cron-token"/>
												<span class="input-group-btn"><button type="button" class="btn btn-primary button-loading" onclick="generate_cron_token(this)"><?php echo $button_generate; ?></button></span>
											</div>
                      <div class="alert alert-info" role="alert"><?php echo $entry_cron_token_faq; ?></div>
                    </div>
                  </div>
                </div>
                <!-- TAB Popup block -->
                <div class="tab-pane fade" role="tabpanel" id="popup-block">
                  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_popup_animation_type; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
                    <div class="col-sm-12">
                      <select name="form_data[popup_animation_type]" class="form-control">
                        <option value="0" <?php echo $form_data['popup_animation_type'] == 0 ? 'selected="selected"' : ''; ?>><?php echo $text_popup_animation_type_1; ?></option>
                        <option value="mfp-zoom-in" <?php echo $form_data['popup_animation_type'] == 'mfp-zoom-in' ? 'selected="selected"' : ''; ?>><?php echo $text_popup_animation_type_2; ?></option>
                        <option value="mfp-zoom-out" <?php echo $form_data['popup_animation_type'] == 'mfp-zoom-out' ? 'selected="selected"' : ''; ?>><?php echo $text_popup_animation_type_3; ?></option>
                        <option value="mfp-move-from-left" <?php echo $form_data['popup_animation_type'] == 'mfp-move-from-left' ? 'selected="selected"' : ''; ?>><?php echo $text_popup_animation_type_4; ?></option>
                        <option value="mfp-move-from-top" <?php echo $form_data['popup_animation_type'] == 'mfp-move-from-top' ? 'selected="selected"' : ''; ?>><?php echo $text_popup_animation_type_5; ?></option>
                        <option value="mfp-3d-flip" <?php echo $form_data['popup_animation_type'] == 'mfp-3d-flip' ? 'selected="selected"' : ''; ?>><?php echo $text_popup_animation_type_6; ?></option>
                        <option value="mfp-newspaper" <?php echo $form_data['popup_animation_type'] == 'mfp-newspaper' ? 'selected="selected"' : ''; ?>><?php echo $text_popup_animation_type_7; ?></option>
                      </select>
                      <div class="alert alert-info" role="alert"><?php echo $text_popup_animation_type_faq; ?></div>
                    </div>
                  </div>
									<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_popup_close_on_content_click; ?></label>
                    <div class="col-sm-12">
                      <div class="btn-group btn-toggle" data-toggle="buttons">
                        <label class="btn <?php echo $form_data['popup_close_on_content_click'] == 1 ? 'active btn-success' : 'btn-default'; ?>">
                          <input type="radio"
                            name="form_data[popup_close_on_content_click]"
                            value="1"
                            autocomplete="off"
                            <?php echo $form_data['popup_close_on_content_click'] == 1 ? 'checked="checked"' : ''; ?>
                          /><?php echo $text_yes; ?>
                        </label>
                        <label class="btn <?php echo $form_data['popup_close_on_content_click'] == 0 ? 'active btn-success' : 'btn-default'; ?>">
                          <input type="radio"
                            name="form_data[popup_close_on_content_click]"
                            value="0"
                            autocomplete="off"
                            <?php echo $form_data['popup_close_on_content_click'] == 0 ? 'checked="checked"' : ''; ?>
                          /><?php echo $text_no; ?>
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_popup_close_on_bg_click; ?></label>
                    <div class="col-sm-12">
                      <div class="btn-group btn-toggle" data-toggle="buttons">
                        <label class="btn <?php echo $form_data['popup_close_on_bg_click'] == 1 ? 'active btn-success' : 'btn-default'; ?>">
                          <input type="radio"
                            name="form_data[popup_close_on_bg_click]"
                            value="1"
                            autocomplete="off"
                            <?php echo $form_data['popup_close_on_bg_click'] == 1 ? 'checked="checked"' : ''; ?>
                          /><?php echo $text_yes; ?>
                        </label>
                        <label class="btn <?php echo $form_data['popup_close_on_bg_click'] == 0 ? 'active btn-success' : 'btn-default'; ?>">
                          <input type="radio"
                            name="form_data[popup_close_on_bg_click]"
                            value="0"
                            autocomplete="off"
                            <?php echo $form_data['popup_close_on_bg_click'] == 0 ? 'checked="checked"' : ''; ?>
                          /><?php echo $text_no; ?>
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_popup_close_btn_inside; ?></label>
                    <div class="col-sm-12">
                      <div class="btn-group btn-toggle" data-toggle="buttons">
                        <label class="btn <?php echo $form_data['popup_close_btn_inside'] == 1 ? 'active btn-success' : 'btn-default'; ?>">
                          <input type="radio"
                            name="form_data[popup_close_btn_inside]"
                            value="1"
                            autocomplete="off"
                            <?php echo $form_data['popup_close_btn_inside'] == 1 ? 'checked="checked"' : ''; ?>
                          /><?php echo $text_yes; ?>
                        </label>
                        <label class="btn <?php echo $form_data['popup_close_btn_inside'] == 0 ? 'active btn-success' : 'btn-default'; ?>">
                          <input type="radio"
                            name="form_data[popup_close_btn_inside]"
                            value="0"
                            autocomplete="off"
                            <?php echo $form_data['popup_close_btn_inside'] == 0 ? 'checked="checked"' : ''; ?>
                          /><?php echo $text_no; ?>
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_popup_close_on_escape_key; ?></label>
                    <div class="col-sm-12">
                      <div class="btn-group btn-toggle" data-toggle="buttons">
                        <label class="btn <?php echo $form_data['popup_close_on_escape_key'] == 1 ? 'active btn-success' : 'btn-default'; ?>">
                          <input type="radio"
                            name="form_data[popup_close_on_escape_key]"
                            value="1"
                            autocomplete="off"
                            <?php echo $form_data['popup_close_on_escape_key'] == 1 ? 'checked="checked"' : ''; ?>
                          /><?php echo $text_yes; ?>
                        </label>
                        <label class="btn <?php echo $form_data['popup_close_on_escape_key'] == 0 ? 'active btn-success' : 'btn-default'; ?>">
                          <input type="radio"
                            name="form_data[popup_close_on_escape_key]"
                            value="0"
                            autocomplete="off"
                            <?php echo $form_data['popup_close_on_escape_key'] == 0 ? 'checked="checked"' : ''; ?>
                          /><?php echo $text_no; ?>
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_popup_align_top; ?></label>
                    <div class="col-sm-12">
                      <div class="btn-group btn-toggle" data-toggle="buttons">
                        <label class="btn <?php echo $form_data['popup_align_top'] == 1 ? 'active btn-success' : 'btn-default'; ?>">
                          <input type="radio"
                            name="form_data[popup_align_top]"
                            value="1"
                            autocomplete="off"
                            <?php echo $form_data['popup_align_top'] == 1 ? 'checked="checked"' : ''; ?>
                          /><?php echo $text_yes; ?>
                        </label>
                        <label class="btn <?php echo $form_data['popup_align_top'] == 0 ? 'active btn-success' : 'btn-default'; ?>">
                          <input type="radio"
                            name="form_data[popup_align_top]"
                            value="0"
                            autocomplete="off"
                            <?php echo $form_data['popup_align_top'] == 0 ? 'checked="checked"' : ''; ?>
                          /><?php echo $text_no; ?>
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_popup_background_type; ?></label>
                    <div class="col-sm-12">
                      <select name="form_data[popup_background_type]" class="form-control" id="popup-background-type">
                        <option value="1" <?php echo $form_data['popup_background_type'] == 1 ? 'selected="selected"' : ''; ?>><?php echo $text_popup_background_type_1; ?></option>
                        <option value="2" <?php echo $form_data['popup_background_type'] == 2 ? 'selected="selected"' : ''; ?>><?php echo $text_popup_background_type_2; ?></option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group required popup-background-type-1">
                    <label class="col-sm-12 control-label"><?php echo $text_background_images; ?></label>
                    <div class="col-sm-12">
                      <div class="input-group div-background-images" id="input-style-background">
                        <?php if ($backgrounds) { ?>
                          <?php $key = 1; foreach ($backgrounds as $background) { ?>
                          <input type="radio" name="form_data[style_background]" id="label-img-<?php echo $key; ?>" value="<?php echo $background['name']; ?>" <?php echo $form_data['style_background'] && $form_data['style_background'] == $background['name'] ? 'checked' : ''; ?>/>
                              <button type="button" class="background-for-label" data-background-image-id="<?php echo $key; ?>" data-background-image-src="<?php echo $background['src']; ?>" style="background:url('<?php echo $background['src']; ?>');"></button>
                          <?php $key++; } ?>
                        <?php } ?>
                      </div>
                    </div>
                  </div>
									<div class="form-group required popup-background-type-2">
                    <label class="col-sm-12 control-label"><?php echo $text_background_color; ?></label>
                    <div class="col-sm-12">
                      <div class="input-group">
                        <input value="<?php echo $form_data['style_color']; ?>" type="text" name="form_data[style_color]" class="form-control" id="input-style-color" />
                        <span class="input-group-btn">
                          <button type="button" class="btn btn-default color-picker-block"><span style="background:<?php echo $form_data['style_color']; ?>">&nbsp;</span></button>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group required">
                    <label class="col-sm-12 control-label"><?php echo $text_loader_color; ?></label>
                    <div class="col-sm-12">
                      <div class="input-group">
                        <input value="<?php echo $form_data['loader_color']; ?>" type="text" name="form_data[loader_color]" class="form-control" id="input-loader-color" />
                        <span class="input-group-btn">
                          <button type="button" class="btn btn-default color-picker-block"><span style="background:<?php echo $form_data['loader_color']; ?>">&nbsp;</span></button>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_background_opacity; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
                    <div class="col-sm-12">
                      <select name="form_data[background_opacity]" class="form-control">
                        <option value="0" <?php echo $form_data['background_opacity'] == 0 ? 'selected="selected"' : ''; ?>>0</option>
                        <option value="0.1" <?php echo $form_data['background_opacity'] == '0.1' ? 'selected="selected"' : ''; ?>>0.1</option>
                        <option value="0.2" <?php echo $form_data['background_opacity'] == '0.2' ? 'selected="selected"' : ''; ?>>0.2</option>
                        <option value="0.3" <?php echo $form_data['background_opacity'] == '0.3' ? 'selected="selected"' : ''; ?>>0.3</option>
                        <option value="0.4" <?php echo $form_data['background_opacity'] == '0.4' ? 'selected="selected"' : ''; ?>>0.4</option>
                        <option value="0.5" <?php echo $form_data['background_opacity'] == '0.5' ? 'selected="selected"' : ''; ?>>0.5</option>
                        <option value="0.6" <?php echo $form_data['background_opacity'] == '0.6' ? 'selected="selected"' : ''; ?>>0.6</option>
                        <option value="0.7" <?php echo $form_data['background_opacity'] == '0.7' ? 'selected="selected"' : ''; ?>>0.7</option>
                        <option value="0.8" <?php echo $form_data['background_opacity'] == '0.8' ? 'selected="selected"' : ''; ?>>0.8</option>
                        <option value="0.9" <?php echo $form_data['background_opacity'] == '0.9' ? 'selected="selected"' : ''; ?>>0.9</option>
                        <option value="1" <?php echo $form_data['background_opacity'] == 1 ? 'selected="selected"' : ''; ?>>1</option>
                      </select>
                      <div class="alert alert-info" role="alert"><?php echo $text_background_opacity_faq; ?></div>
                    </div>
                  </div>
                </div>
                <!-- TAB Import/Export config block -->
                <div class="tab-pane fade" role="tabpanel" id="config-import-export-block">
                  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_restore_from_external_file; ?></label>
                    <div class="col-sm-12">
                      <input type="file" name="config_import" style="display:none;" id="config-load-file" />
                      <div class="input-group">
                        <span class="input-group-btn">
                          <button class="btn btn-primary" type="button" onclick="$('#config-load-file').click();"><?php echo $text_select_file; ?></button>
                        </span>
                        <input type="text" name="config_load_file_mask" id="config-load-file-mask" class="form-control">
                        <span class="input-group-btn">
                          <button id="config-button-import-file-1" type="button" onclick="make_import_action({a:this,b:'config',c:'from_user'});" class="btn btn-primary button-loading-white" disabled="disabled"><i class="fa fa-download"></i> <?php echo $button_import; ?></button>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_restore_from_local_file; ?></label>
                    <div class="col-sm-12">
                      <div class="input-group">
                        <select name="config_backup_file_name" class="form-control">
                          <option value=""><?php echo $text_make_a_choice; ?></option>
                          <?php if ($config_backup_files) { ?>
                            <?php foreach ($config_backup_files as $config_backup_file) { ?>
                              <option value="<?php echo $config_backup_file['name']; ?>"><?php echo $config_backup_file['name']; ?></option>
                            <?php } ?>
                          <?php } ?>
                        </select>
                        <span class="input-group-btn">
                          <button id="config-button-import-file-2" type="button" onclick="make_import_action({a:this,b:'config'});" class="btn btn-primary button-loading-white"  disabled="disabled"><i class="fa fa-download"></i> <?php echo $button_import; ?></button>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_export; ?></label>
                    <div class="col-sm-12">
                      <a onclick="make_export_action({a:this,b:'config'});" class="btn btn-primary button-loading-white"><i class="fa fa-upload"></i> <?php echo $button_export; ?></a>
                    </div>
                  </div>
                </div>
                <!-- TAB Field constructor block -->
                <div class="tab-pane fade" role="tabpanel" id="field-constructor-block">
                  <div id="history-field" class="history-loading"><div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div></div>
                </div>
                <!-- TAB Import/Export field block -->
                <div class="tab-pane fade" role="tabpanel" id="field-import-export-block">
                  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_restore_from_external_file; ?></label>
                    <div class="col-sm-12">
                      <input type="file" name="field_import" style="display:none;" id="field-load-file" />
                      <div class="input-group">
                        <span class="input-group-btn">
                          <button class="btn btn-primary" type="button" onclick="$('#field-load-file').click();"><?php echo $text_select_file; ?></button>
                        </span>
                        <input type="text" name="field_load_file_mask" id="field-load-file-mask" class="form-control">
                        <span class="input-group-btn">
                          <button id="field-button-import-file-1" type="button" onclick="make_import_action({a:this,b:'field',c:'from_user'});" class="btn btn-primary button-loading-white" disabled="disabled"><i class="fa fa-download"></i> <?php echo $button_import; ?></button>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_restore_from_local_file; ?></label>
                    <div class="col-sm-12">
                      <div class="input-group">
                        <select name="field_backup_file_name" class="form-control">
                          <option value=""><?php echo $text_make_a_choice; ?></option>
                          <?php if ($field_backup_files) { ?>
                            <?php foreach ($field_backup_files as $field_backup_file) { ?>
                              <option value="<?php echo $field_backup_file['name']; ?>"><?php echo $field_backup_file['name']; ?></option>
                            <?php } ?>
                          <?php } ?>
                        </select>
                        <span class="input-group-btn">
                          <button id="field-button-import-file-2" type="button" onclick="make_import_action({a:this,b:'field'});" class="btn btn-primary button-loading-white" disabled="disabled"><i class="fa fa-download"></i> <?php echo $button_import; ?></button>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_export; ?></label>
                    <div class="col-sm-12">
                      <a onclick="make_export_action({a:this,b:'field'});" class="btn btn-primary button-loading-white"><i class="fa fa-upload"></i> <?php echo $button_export; ?></a>
                    </div>
                  </div>
                </div>
                <!-- TAB Record constructor block -->
                <div class="tab-pane fade" role="tabpanel" id="record-constructor-block">
                  <div id="history-record" class="history-loading"><div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div></div>
                </div>
                <!-- TAB Import/Export record block -->
                <div class="tab-pane fade" role="tabpanel" id="record-import-export-block">
                  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_restore_from_external_file; ?></label>
                    <div class="col-sm-12">
                      <input type="file" name="record_import" style="display:none;" id="record-load-file" />
                      <div class="input-group">
                        <span class="input-group-btn">
                          <button class="btn btn-primary" type="button" onclick="$('#record-load-file').click();"><?php echo $text_select_file; ?></button>
                        </span>
                        <input type="text" name="record_load_file_mask" id="record-load-file-mask" class="form-control">
                        <span class="input-group-btn">
                          <button id="record-button-import-file-1" type="button" onclick="make_import_action({a:this,b:'record',c:'from_user'});" class="btn btn-primary button-loading-white" disabled="disabled"><i class="fa fa-download"></i> <?php echo $button_import; ?></button>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_restore_from_local_file; ?></label>
                    <div class="col-sm-12">
                      <div class="input-group">
                        <select name="record_backup_file_name" class="form-control">
                          <option value=""><?php echo $text_make_a_choice; ?></option>
                          <?php if ($record_backup_files) { ?>
                            <?php foreach ($record_backup_files as $record_backup_file) { ?>
                              <option value="<?php echo $record_backup_file['name']; ?>"><?php echo $record_backup_file['name']; ?></option>
                            <?php } ?>
                          <?php } ?>
                        </select>
                        <span class="input-group-btn">
                          <button id="record-button-import-file-2" type="button" onclick="make_import_action({a:this,b:'record'});" class="btn btn-primary button-loading-white" disabled="disabled"><i class="fa fa-download"></i> <?php echo $button_import; ?></button>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_export; ?></label>
                    <div class="col-sm-12">
                      <a onclick="make_export_action({a:this,b:'record'});" class="btn btn-primary button-loading-white"><i class="fa fa-upload"></i> <?php echo $button_export; ?></a>
                    </div>
                  </div>
                </div>
                <!-- TAB Banned list setting -->
                <div class="tab-pane fade" role="tabpanel" id="banned-constructor-block">
                  <div id="history-banned" class="history-loading"><div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div></div>
                </div>
                <!-- TAB Import/Export banned block -->
                <div class="tab-pane fade" role="tabpanel" id="banned-import-export-block">
                  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_restore_from_external_file; ?></label>
                    <div class="col-sm-12">
                      <input type="file" name="banned_import" style="display:none;" id="banned-load-file" />
                      <div class="input-group">
                        <span class="input-group-btn">
                          <button class="btn btn-primary" type="button" onclick="$('#banned-load-file').click();"><?php echo $text_select_file; ?></button>
                        </span>
                        <input type="text" name="banned_load_file_mask" id="banned-load-file-mask" class="form-control">
                        <span class="input-group-btn">
                          <button id="banned-button-import-file-1" type="button" onclick="make_import_action({a:this,b:'banned',c:'from_user'});" class="btn btn-primary button-loading-white" disabled="disabled"><i class="fa fa-download"></i> <?php echo $button_import; ?></button>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_restore_from_local_file; ?></label>
                    <div class="col-sm-12">
                      <div class="input-group">
                        <select name="banned_backup_file_name" class="form-control">
                          <option value=""><?php echo $text_make_a_choice; ?></option>
                          <?php if ($banned_backup_files) { ?>
                            <?php foreach ($banned_backup_files as $banned_backup_file) { ?>
                              <option value="<?php echo $banned_backup_file['name']; ?>"><?php echo $banned_backup_file['name']; ?></option>
                            <?php } ?>
                          <?php } ?>
                        </select>
                        <span class="input-group-btn">
                          <button id="banned-button-import-file-2" type="button" onclick="make_import_action({a:this,b:'banned'});" class="btn btn-primary button-loading-white" disabled="disabled"><i class="fa fa-download"></i> <?php echo $button_import; ?></button>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_export; ?></label>
                    <div class="col-sm-12">
                      <a onclick="make_export_action({a:this,b:'banned'});" class="btn btn-primary button-loading-white"><i class="fa fa-upload"></i> <?php echo $button_export; ?></a>
                    </div>
                  </div>
                </div>
                <!-- TAB Language block -->
                <div class="tab-pane fade" role="tabpanel" id="language-block">
                  <div class="form-group required">
										<label class="col-sm-12 control-label"><?php echo $entry_name; ?></label>
										<div class="col-sm-12">
											<?php foreach ($languages as $language) { ?>
											<div class="input-group mb-5">
												<span class="input-group-addon"><img src="<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span>
												<input type="text" name="text_data[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($text_data[$language['language_id']]) ? $text_data[$language['language_id']]['name'] : ''; ?>" class="form-control" id="input-text-data-language-name-<?php echo $language['language_id']; ?>"/>
											</div>
											<?php } ?>
										</div>
									</div>
									<div class="form-group required call-button-instruction">
										<label class="col-sm-12 control-label"><?php echo $entry_call_button; ?></label>
										<div class="col-sm-12">
											<?php foreach ($languages as $language) { ?>
											<div class="input-group mb-5">
												<span class="input-group-addon"><img src="<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span>
												<input type="text" name="text_data[<?php echo $language['language_id']; ?>][call_button]" value="<?php echo isset($text_data[$language['language_id']]) ? $text_data[$language['language_id']]['call_button'] : ''; ?>" class="form-control" id="input-text-data-language-call-button-<?php echo $language['language_id']; ?>"/>
											</div>
											<?php } ?>
										</div>
									</div>
                  <div class="form-group required call-button-product-page-instruction">
										<label class="col-sm-12 control-label"><?php echo $entry_call_button_product_page; ?></label>
										<div class="col-sm-12">
											<?php foreach ($languages as $language) { ?>
											<div class="input-group mb-5">
												<span class="input-group-addon"><img src="<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span>
												<input type="text" name="text_data[<?php echo $language['language_id']; ?>][call_button_product_page]" value="<?php echo isset($text_data[$language['language_id']]) ? $text_data[$language['language_id']]['call_button_product_page'] : ''; ?>" class="form-control" id="input-text-data-language-call-button-product-page-<?php echo $language['language_id']; ?>"/>
											</div>
											<?php } ?>
										</div>
									</div>
                  <div class="form-group required option-call-button-product-page-instruction">
										<label class="col-sm-12 control-label"><?php echo $entry_option_call_button_product_page; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
										<div class="col-sm-12">
											<?php foreach ($languages as $language) { ?>
											<div class="input-group mb-5">
												<span class="input-group-addon"><img src="<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span>
												<input type="text" name="text_data[<?php echo $language['language_id']; ?>][option_call_button_product_page]" value="<?php echo isset($text_data[$language['language_id']]) ? $text_data[$language['language_id']]['option_call_button_product_page'] : ''; ?>" class="form-control" id="input-text-data-language-option-call-button-product-page-<?php echo $language['language_id']; ?>"/>
											</div>
											<?php } ?>
                      <div class="alert alert-info" role="alert"><?php echo $entry_option_call_button_product_page_faq; ?></div>
										</div>
									</div>
									<div class="form-group required close-button-instruction">
										<label class="col-sm-12 control-label"><?php echo $entry_close_button; ?></label>
										<div class="col-sm-12">
											<?php foreach ($languages as $language) { ?>
											<div class="input-group mb-5">
												<span class="input-group-addon"><img src="<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span>
												<input type="text" name="text_data[<?php echo $language['language_id']; ?>][close_button]" value="<?php echo isset($text_data[$language['language_id']]) ? $text_data[$language['language_id']]['close_button'] : ''; ?>" class="form-control" id="input-text-data-language-close-button-<?php echo $language['language_id']; ?>"/>
											</div>
											<?php } ?>
										</div>
									</div>
									<div class="form-group required">
										<label class="col-sm-12 control-label"><?php echo $entry_save_button; ?></label>
										<div class="col-sm-12">
											<?php foreach ($languages as $language) { ?>
											<div class="input-group mb-5">
												<span class="input-group-addon"><img src="<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span>
												<input type="text" name="text_data[<?php echo $language['language_id']; ?>][save_button]" value="<?php echo isset($text_data[$language['language_id']]) ? $text_data[$language['language_id']]['save_button'] : ''; ?>" class="form-control" id="input-text-data-language-save-button-<?php echo $language['language_id']; ?>"/>
											</div>
											<?php } ?>
										</div>
									</div>
									<div class="form-group required">
										<label class="col-sm-12 control-label"><?php echo $entry_success_message; ?></label>
										<div class="col-sm-12">
											<?php foreach ($languages as $language) { ?>
											<div class="input-group mb-5">
												<span class="input-group-addon"><img src="<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span>
												<textarea name="text_data[<?php echo $language['language_id']; ?>][success_message]" id="input-text-data-language-success-message-<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($text_data[$language['language_id']]) ? $text_data[$language['language_id']]['success_message'] : ''; ?></textarea>
											</div>
											<div class="btn-group mb-5">
												<button type="button" class="btn btn-default btn-xs" onclick="texteditor_action({a:'#input-text-data-language-success-message-<?php echo $language['language_id']; ?>'});"><?php echo $text_open_texteditor; ?></button>
												<button type="button" class="btn btn-default btn-xs" onclick="texteditor_action({a:'#input-text-data-language-success-message-<?php echo $language['language_id']; ?>',b:true,c:false});" style="display: none;"><?php echo $text_save_texteditor; ?></button>
											</div>
											<?php } ?>
										</div>
									</div>
									<div class="form-group description-instruction">
										<label class="col-sm-12 control-label"><?php echo $entry_description; ?></label>
										<div class="col-sm-12">
											<?php foreach ($languages as $language) { ?>
											<div class="input-group mb-5">
												<span class="input-group-addon"><img src="<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span>
												<textarea name="text_data[<?php echo $language['language_id']; ?>][description]" id="input-text-data-language-description-<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($text_data[$language['language_id']]) ? $text_data[$language['language_id']]['description'] : ''; ?></textarea>
											</div>
											<div class="btn-group mb-5">
												<button type="button" class="btn btn-default btn-xs" onclick="texteditor_action({a:'#input-text-data-language-description-<?php echo $language['language_id']; ?>'});"><?php echo $text_open_texteditor; ?></button>
												<button type="button" class="btn btn-default btn-xs" onclick="texteditor_action({a:'#input-text-data-language-description-<?php echo $language['language_id']; ?>',b:true,c:false});" style="display: none;"><?php echo $text_save_texteditor; ?></button>
											</div>
											<?php } ?>
										</div>
									</div>
                  <div class="form-group required analytic-code-instruction">
										<label class="col-sm-12 control-label"><?php echo $entry_analytic_code; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
										<div class="col-sm-12">
											<?php foreach ($languages as $language) { ?>
											<div class="input-group mb-5">
												<span class="input-group-addon"><img src="<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span>
												<textarea name="text_data[<?php echo $language['language_id']; ?>][analytic_code]" id="input-text-data-language-analytic-code-<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($text_data[$language['language_id']]) ? $text_data[$language['language_id']]['analytic_code'] : ''; ?></textarea>
											</div>
											<?php } ?>
                      <div class="alert alert-info" role="alert"><?php echo $entry_analytic_code_faq; ?></div>
										</div>
									</div>
                </div>
                <!-- TAB Email template constructor block -->
                <div class="tab-pane fade" role="tabpanel" id="email-template-constructor-block">
                  <div id="history-email-template" class="history-loading"><div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div></div>
                </div>
                <!-- TAB Import/Export email template block -->
                <div class="tab-pane fade" role="tabpanel" id="email-template-import-export-block">
                  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_restore_from_external_file; ?></label>
                    <div class="col-sm-12">
                      <input type="file" name="email_template_import" style="display:none;" id="email-template-load-file" />
                      <div class="input-group">
                        <span class="input-group-btn">
                          <button class="btn btn-primary" type="button" onclick="$('#email-template-load-file').click();"><?php echo $text_select_file; ?></button>
                        </span>
                        <input type="text" name="email_template_load_file_mask" id="email-template-load-file-mask" class="form-control">
                        <span class="input-group-btn">
                          <button id="email-template-button-import-file-1" type="button" onclick="make_import_action({a:this,b:'email_template',c:'from_user'});" class="btn btn-primary button-loading-white" disabled="disabled"><i class="fa fa-download"></i> <?php echo $button_import; ?></button>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_restore_from_local_file; ?></label>
                    <div class="col-sm-12">
                      <div class="input-group">
                        <select name="email_template_backup_file_name" class="form-control">
                          <option value=""><?php echo $text_make_a_choice; ?></option>
                          <?php if ($email_template_backup_files) { ?>
                            <?php foreach ($email_template_backup_files as $email_template_backup_file) { ?>
                              <option value="<?php echo $email_template_backup_file['name']; ?>"><?php echo $email_template_backup_file['name']; ?></option>
                            <?php } ?>
                          <?php } ?>
                        </select>
                        <span class="input-group-btn">
                          <button id="email-template-button-import-file-2" type="button" onclick="make_import_action({a:this,b:'email_template'});" class="btn btn-primary button-loading-white" disabled="disabled"><i class="fa fa-download"></i> <?php echo $button_import; ?></button>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_export; ?></label>
                    <div class="col-sm-12">
                      <a onclick="make_export_action({a:this,b:'email_template'});" class="btn btn-primary button-loading-white"><i class="fa fa-upload"></i> <?php echo $button_export; ?></a>
                    </div>
                  </div>
                </div>
                <!-- TAB Sms template constructor block -->
                <div class="tab-pane fade" role="tabpanel" id="sms-template-constructor-block">
                  <div id="history-sms-template" class="history-loading"><div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div></div>
                </div>
                <!-- TAB Import/Export sms template block -->
                <div class="tab-pane fade" role="tabpanel" id="sms-template-import-export-block">
                  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_restore_from_external_file; ?></label>
                    <div class="col-sm-12">
                      <input type="file" name="sms_template_import" style="display:none;" id="sms-template-load-file" />
                      <div class="input-group">
                        <span class="input-group-btn">
                          <button class="btn btn-primary" type="button" onclick="$('#sms-template-load-file').click();"><?php echo $text_select_file; ?></button>
                        </span>
                        <input type="text" name="sms_template_load_file_mask" id="sms-template-load-file-mask" class="form-control">
                        <span class="input-group-btn">
                          <button id="sms-template-button-import-file-1" type="button" onclick="make_import_action({a:this,b:'sms_template',c:'from_user'});" class="btn btn-primary button-loading-white" disabled="disabled"><i class="fa fa-download"></i> <?php echo $button_import; ?></button>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_restore_from_local_file; ?></label>
                    <div class="col-sm-12">
                      <div class="input-group">
                        <select name="sms_template_backup_file_name" class="form-control">
                          <option value=""><?php echo $text_make_a_choice; ?></option>
                          <?php if ($sms_template_backup_files) { ?>
                            <?php foreach ($sms_template_backup_files as $sms_template_backup_file) { ?>
                              <option value="<?php echo $sms_template_backup_file['name']; ?>"><?php echo $sms_template_backup_file['name']; ?></option>
                            <?php } ?>
                          <?php } ?>
                        </select>
                        <span class="input-group-btn">
                          <button id="sms-template-button-import-file-2" type="button" onclick="make_import_action({a:this,b:'sms_template'});" class="btn btn-primary button-loading-white" disabled="disabled"><i class="fa fa-download"></i> <?php echo $button_import; ?></button>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_export; ?></label>
                    <div class="col-sm-12">
                      <a onclick="make_export_action({a:this,b:'sms_template'});" class="btn btn-primary button-loading-white"><i class="fa fa-upload"></i> <?php echo $button_export; ?></a>
                    </div>
                  </div>
                </div>
                <!-- TAB Marketing Tools block -->
                <div class="tab-pane fade" role="tabpanel" id="marketing-tools-block">
                  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_choose_gift_coupon; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
                    <div class="col-sm-12">
                      <select name="form_data[gift_coupon]" class="form-control">
                        <option value=""><?php echo $text_make_a_choice; ?></option>
                        <?php foreach ($all_coupons as $coupon) { ?>
                          <option value="<?php echo $coupon['coupon_id']; ?>" <?php if (isset($form_data['gift_coupon']) && $coupon['coupon_id'] == $form_data['gift_coupon']) { ?>selected="selected"<?php } ?>><?php echo $coupon['name']; ?></option>
                        <?php } ?>
                      </select>
                      <div class="alert alert-info" role="alert"><?php echo $text_choose_gift_coupon_faq; ?></div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_choose_gift_voucher; ?><i class="fa fa-question-circle show-explanation" data-toggle="tooltip" title="<?php echo $text_open_explanation; ?>"onclick="show_explanation({a:this})"></i></label>
                    <div class="col-sm-12">
                      <select name="form_data[gift_voucher]" class="form-control">
                        <option value=""><?php echo $text_make_a_choice; ?></option>
                        <?php foreach ($all_vouchers as $voucher) { ?>
                          <option value="<?php echo $voucher['voucher_id']; ?>" <?php if (isset($form_data['gift_voucher']) && $voucher['voucher_id'] == $form_data['gift_voucher']) { ?>selected="selected"<?php } ?>><?php echo $voucher['code']; ?></option>
                        <?php } ?>
                      </select>
                      <div class="alert alert-info" role="alert"><?php echo $text_choose_gift_voucher_faq; ?></div>
                    </div>
                  </div>
                </div>
                <!-- TAB License Extension block -->
                <div class="tab-pane fade" role="tabpanel" id="license-extension-block">
                  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_license_key; ?></label>
                    <div class="col-sm-12">
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-key" aria-hidden="true"></i></span>
                        <input type="text" name="<?php echo $_name; ?>_license" value="<?php echo $license_key; ?>" class="form-control" id="input-license_key" placeholder="XXXXXXXX-XXXXXXXX-XXXXXXXX-XXXXXXXX" readonly/>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_license_text; ?></label>
                    <div class="col-sm-12">
                      <?php echo $license_type; ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_license_holder; ?></label>
                    <div class="col-sm-12">
                      <?php echo $license_holder; ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_license_expires; ?></label>
                    <div class="col-sm-12">
                      <?php echo $license_expire; ?>
                    </div>
                  </div>
                </div>
              </div>
              <div>
                <input type="hidden" style="display:none;" name="form_data[front_module_name]" value="<?php echo $heading_title; ?>" />
                <input type="hidden" style="display:none;" name="form_data[front_module_version]" value="<?php echo $_version; ?>" />
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- start: code for tab CSS setting -->
<script>
var codemirror = CodeMirror.fromTextArea(document.querySelector('#edit-css-block-0'), {
  mode : "css",
  height: '700px',
  lineNumbers: true,
  autofocus: true,
  theme: 'monokai',
  lineWrapping: true
});

var codemirror2 = CodeMirror.fromTextArea(document.querySelector('#edit-css-block-1'), {
  mode : "css",
  height: '700px',
  lineNumbers: true,
  autofocus: true,
  theme: 'monokai',
  lineWrapping: true
});

$('a[href=\'#css-block\']').on('click', function() {
  setTimeout(function() {
    $(this).click();
    codemirror.refresh();
    codemirror2.refresh();
  }, 500);
});

function make_save_css_action(options) {
  var element = options.a || '',
      id = options.b || '',
      stylesheet = options.c || '',
      codemirror_code = (id == '0') ? codemirror : codemirror2;

  $.ajax({
    type: 'post',
    url:  'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/save_css_action&<?php echo $token; ?>',
    data: 'code='+encodeURIComponent(codemirror_code.getValue())+'&stylesheet='+stylesheet,
    dataType: 'json',
    beforeSend: function() {
			$(element).prop('disabled', true);
			$(element).html('<div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>');
			$('[data-toggle=\'tooltip\']').tooltip('destroy');
		},
		complete: function() {
			$(element).prop('disabled', false);
      $(element).html('<i class="fa fa-save"></i>');
      $('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
		},
    success: function(json) {
      notify_close();

      if (json['error']) {
        for (i in json['error']) {
          if (i.replace(/_/g, '-') == 'warning') {
					  for (b in json['error'][i]) {
					    notify({b:'<?php echo $text_alert_error_heading; ?>',c:json['error'][i][b],d:'static-error'});
					  }
					}
        }
      }

      if (json['success']) {
        notify({b:'<?php echo $text_alert_success_heading; ?>',c:json['success'],d:'success'});
      }
    },
    error: function(xhr, ajaxOptions, thrownError) {
      alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
  });
}

function make_restore_css_action(options) {
  var element = options.a || '',
    id = options.b || '',
    stylesheet = options.c || '',
    stylesheet_default = options.d || '';

  $.ajax({
    type: 'post',
    url:  'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/restore_css_action&<?php echo $token; ?>',
    data: 'stylesheet='+stylesheet+'&stylesheet_default='+stylesheet_default,
    dataType: 'json',
    beforeSend: function() {
      $(element).prop('disabled', true);
			$(element).html('<div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>');
			$('[data-toggle=\'tooltip\']').tooltip('destroy');
		},
		complete: function() {
			$(element).prop('disabled', false);
      $(element).html('<i class="fa fa-refresh"></i>');
      $('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
		},
    success: function(json) {
      notify_close();

      if (json['error']) {
        for (i in json['error']) {
          if (i.replace(/_/g, '-') == 'warning') {
					  for (b in json['error'][i]) {
					    notify({b:'<?php echo $text_alert_error_heading; ?>',c:json['error'][i][b],d:'static-error'});
					  }
					}
        }
      }

      if (json['success']) {
        notify({b:'<?php echo $text_alert_success_heading; ?>',c:json['success'],d:'success'});
        setTimeout(function() {
          location.reload();
        }, 2000);
      }
    },
    error: function(xhr, ajaxOptions, thrownError) {
      alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
  });
}
</script>
<!-- end: code for tab CSS setting -->
<!-- start: code for tab Popup setting -->
<script type="text/javascript">
$(document).delegate('button[data-background-image-id]', 'click', function(e) {
  var element = this;
  open_popup('index.php?route=extension/ocdevwizard/helper/preview_background_image&<?php echo $token; ?>&img_src='+$(element).attr('data-background-image-src')+'&img_id='+$(element).attr('data-background-image-id'));
});

function button_apply_image(id) {
  $('.div-background-images input[type=\'checkbox\']').attr('checked', false);
  $('#label-img-'+id).attr('checked', true);
  $.magnificPopup.close();
}

$('select#popup-background-type').change(function () {
  var val = $(this).val();

  if (val == 1) {
    $('.popup-background-type-1').show();
    $('.popup-background-type-2').hide();
  } else {
    $('.popup-background-type-1').hide();
    $('.popup-background-type-2').show();
  }
});

$('select#popup-background-type').trigger('change');

$('.color-picker-block').each(function(i,val){
  const pickr = new Pickr({
    el: val,
    theme: 'monolith',
    useAsButton: true,
    components: {
      preview: true,
      opacity: false,
      hue: true,
      interaction: {
        input: true,
        clear: true,
        save: true
      }
    }
  }).on('save', (color, instance) => {
    $(instance.options.el).parent().prev().val(color.toHEXA().toString());
    $(instance.options.el).find('span').css('background', color.toHEXA().toString());
  });
});
</script>
<!-- end: code for tab Popup setting -->
<!-- start: code for tab Language setting -->
<script>
function texteditor_action(options) {
  var id = options.a || '',
      destroy = options.b || false,
      start = options.c || true;

  if (start) {
    $(id).summernote({
      focus: true,
      disableDragAndDrop: true,
      height: 300,
      lang: 'en-US',
      emptyPara: '',
      toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'underline', 'clear']],
        ['fontname', ['fontname']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['table', ['table']],
        ['insert', ['link', 'image', 'video']],
        ['view', ['fullscreen', 'codeview', 'help']]
      ],
      buttons: {
        image: function () {
          let ui = $.summernote.ui,
            button = ui.button({
              contents: '<i class="note-icon-picture" />',
              tooltip: $.summernote.lang[$.summernote.options.lang].image.image,
              click: function () {
                $('#modal-image').remove();

                $.ajax({
                  url: 'index.php?route=common/filemanager&<?php echo $token; ?>',
                  dataType: 'html',
                  beforeSend: function () {
                    $('#button-image i').replaceWith('<i class="fa fa-circle-o-notch fa-spin"></i>');
                    $('#button-image').prop('disabled', true);
                  },
                  complete: function () {
                    $('#button-image i').replaceWith('<i class="fa fa-upload"></i>');
                    $('#button-image').prop('disabled', false);
                  },
                  success: function (html) {
                    $('body').append('<div id="modal-image" class="modal">' + html + '</div>');

                    $('#modal-image').modal('show');

                    $('#modal-image').delegate('a.thumbnail', 'click', function (e) {
                      e.preventDefault();

                      $(id).summernote('insertImage', $(this).attr('href'));

                      $('#modal-image').modal('hide');
                    });
                  }
                });
              }
            });

          return button.render();
        }
      }
    });

    $(id).parent().next().find('button:eq(1)').show();

    if ($(id).summernote('isEmpty')) {
      $(id).val('');
    }
  }

  if (destroy) {
    $(id).summernote('destroy');
    $(id).parent().next().find('button:eq(1)').hide();
  }
}
</script>
<!-- end: code for tab Language setting -->
<!-- start: code for tab Field list -->
<script>
function submit_field(options) {
  var element = options.a || '',
      after_action = options.b || '';

  $.ajax({
    url:  'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/field_action&<?php echo $token; ?>',
    type: 'post',
    data: $('#modal-field-content form input[type=\'text\'], #modal-field-content form input[type=\'hidden\'], #modal-field-content form input[type=\'radio\']:checked, #modal-field-content form input[type=\'checkbox\']:checked, #modal-field-content form select, #modal-field-content form textarea'),
    dataType: 'json',
    beforeSend: function() {
			$(element).prop('disabled', true);
			$(element).html('<div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>');
			$('[data-toggle=\'tooltip\']').tooltip('destroy');
		},
		complete: function() {
			$(element).prop('disabled', false);
			if (after_action == 'close') {
        $(element).html('<?php echo $button_save; ?>');
      } else {
			  $(element).html('<?php echo $button_save_and_stay; ?>');
      }
			$('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
		},
    success: function(json) {
      notify_close();

      if (json['error']) {
        for (i in json['error']) {
          if (i.replace(/_/g, '-') == 'field-description-language') {
            for (b in json['error'][i]) {
              for (c in json['error'][i][b]) {
                notify({a:'modal-error-field-description-language-'+b.replace(/_/g, '-')+'-'+c,b:'<?php echo $text_alert_error_heading; ?>',c:json['error'][i][b][c],e:'<?php echo $button_fix; ?>',f:'<?php echo $button_cancel; ?>'});
              }
            }
          } else if (i.replace(/_/g, '-') == 'warning') {
						for (b in json['error'][i]) {
							notify({b:'<?php echo $text_alert_error_heading; ?>',c:json['error'][i][b],d:'static-error'});
						}
					} else {
            notify({a:'modal-error-'+i.replace(/_/g, '-'),b:'<?php echo $text_alert_error_heading; ?>',c:json['error'][i],e:'<?php echo $button_fix; ?>',f:'<?php echo $button_cancel; ?>'});
          }
        }
      }

      if (json['success']) {
        if (after_action == 'close') {
          $.magnificPopup.close();
        }
        notify({b:'<?php echo $text_alert_success_heading; ?>',c:json['success'],d:'success'});
        $('a[href=#field-constructor-block]').click();
      }
    },
    error: function(xhr, ajaxOptions, thrownError) {
      alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
  });
}

function field_filter(element, type) {
  filter_data = 'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/field_list&<?php echo $token; ?>';
  filter_data += '&filter_name=' + encodeURIComponent($('#history-field input[name=\'filter_name\']').val());
  filter_data += '&filter_date_added=' + encodeURIComponent($('#history-field input[name=\'filter_date_added\']').val());
  filter_data += '&filter_date_modified=' + encodeURIComponent($('#history-field input[name=\'filter_date_modified\']').val());
  filter_data += '&filter_status=' + encodeURIComponent($('#history-field select[name=\'filter_status\']').val());
  filter_data += '&limit=' + encodeURIComponent($('#history-field input[name=\'limit\']:checked').val());

  $.ajax({
    url: filter_data,
    type: 'get',
    dataType: 'html',
    beforeSend: function() {
			$(element).html('<div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>');
			$('[data-toggle=\'tooltip\']').tooltip('destroy');
		},
		complete: function() {
      if (type == 'clear') {
        $(element).html('<i class="fa fa-eraser"></i> <?php echo $button_clear_filter; ?>');
      } else {
        $(element).html('<i class="fa fa-search"></i> <?php echo $button_filter; ?>');
      }
      $('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
		},
    success: function(data) {
      $('#history-field table.main-table-data > tbody').html($(data).find('table.main-table-data > tbody > *'));
      $('#history-field table.main-table-data > tfoot').html($(data).find('table.main-table-data > tfoot > *'));
    }
  });
}

function field_sort(options) {
  var element = options.a || '',
		  type = options.b || '';

  $(element).parent().parent().find('a').not($(element)[0]).removeAttr('class');
  $(element).attr('class', ($(element).attr('class') == 'asc' ? 'desc' : 'asc'));

  filter_data = 'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/field_list&<?php echo $token; ?>';
  filter_data += '&filter_name=' + encodeURIComponent($('#history-field input[name=\'filter_name\']').val());
  filter_data += '&filter_date_added=' + encodeURIComponent($('#history-field input[name=\'filter_date_added\']').val());
  filter_data += '&filter_date_modified=' + encodeURIComponent($('#history-field input[name=\'filter_date_modified\']').val());
  filter_data += '&filter_status=' + encodeURIComponent($('#history-field select[name=\'filter_status\']').val());
  filter_data += '&sort=' + encodeURIComponent(type);
  filter_data += '&order=' + encodeURIComponent($(element).attr('class').toUpperCase());
  filter_data += '&limit=' + encodeURIComponent($('#history-field input[name=\'limit\']:checked').val());

  $.ajax({
    url: filter_data,
    type: 'get',
    dataType: 'html',
    beforeSend: function() {
      $(element).append(' <i class="fa fa-refresh fa-spin"></i>');
			$('[data-toggle=\'tooltip\']').tooltip('destroy');
		},
		complete: function() {
      $(element).find('.fa.fa-refresh.fa-spin').remove();
      $('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
		},
    success: function(data) {
      $('#history-field table.main-table-data > tbody').html($(data).find('table.main-table-data > tbody > *'));
      $('#history-field table.main-table-data > tfoot').html($(data).find('table.main-table-data > tfoot > *'));
    }
  });
}

function field_limit(options) {
  var element = options.a || '';

  $(element).find('input').attr('checked', true);
  $(element).parent().parent().find('li').not($(element)[0]).removeAttr('class');
  $(element).parent().attr('class', ($(element).parent().attr('class') == 'active' ? '' : 'active'));

  filter_data = 'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/field_list&<?php echo $token; ?>';
  filter_data += '&filter_name=' + encodeURIComponent($('#history-field input[name=\'filter_name\']').val());
  filter_data += '&filter_date_added=' + encodeURIComponent($('#history-field input[name=\'filter_date_added\']').val());
  filter_data += '&filter_date_modified=' + encodeURIComponent($('#history-field input[name=\'filter_date_modified\']').val());
  filter_data += '&filter_status=' + encodeURIComponent($('#history-field select[name=\'filter_status\']').val());
  filter_data += '&limit=' + encodeURIComponent($('#history-field input[name=\'limit\']:checked').val());

  $.ajax({
    url: filter_data,
    type: 'get',
    dataType: 'html',
    beforeSend: function() {
      $(element).append(' <i class="fa fa-refresh fa-spin"></i>');
			$('[data-toggle=\'tooltip\']').tooltip('destroy');
		},
		complete: function() {
      $(element).find('.fa.fa-refresh.fa-spin').remove();
      $('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
		},
    success: function(data) {
      $('#history-field table.main-table-data > tbody').html($(data).find('table.main-table-data > tbody > *'));
      $('#history-field table.main-table-data > tfoot').html($(data).find('table.main-table-data > tfoot > *'));
    }
  });
}

$(document).on('click', '#submit-filter-field-form', function() {
  field_filter(this, 'filter');
});

$(document).on('click', '#clear-filter-field-form', function() {
  $('#history-field input[name=\'filter_name\']').val('');
  $('#history-field input[name=\'filter_date_added\']').val('');
  $('#history-field input[name=\'filter_date_modified\']').val('');
  $('#history-field select[name=\'filter_status\']').val('*');

  field_filter(this, 'clear');
});

$('#history-field').delegate('.pagination a', 'click', function(e) {
  e.preventDefault();
  filter_data = this.href;
  filter_data += '&filter_name=' + encodeURIComponent($('#history-field input[name=\'filter_name\']').val());
  filter_data += '&filter_date_added=' + encodeURIComponent($('#history-field input[name=\'filter_date_added\']').val());
  filter_data += '&filter_date_modified=' + encodeURIComponent($('#history-field input[name=\'filter_date_modified\']').val());
  filter_data += '&filter_status=' + encodeURIComponent($('#history-field select[name=\'filter_status\']').val());
  filter_data += '&limit=' + encodeURIComponent($('#history-field input[name=\'limit\']:checked').val());

  $.ajax({
    url: filter_data,
    type: 'get',
    dataType: 'html',
    success: function(data) {
      $('#history-field table.main-table-data > tbody').html($(data).find('table.main-table-data > tbody > *'));
      $('#history-field table.main-table-data > tfoot').html($(data).find('table.main-table-data > tfoot > *'));
    }
  });
});

$('a[href=#field-constructor-block]').on('click', function() {
  $('.bootstrap-datetimepicker-widget').remove();
  var page = '&page='+($('#field-constructor-block').find('li.active span').length ? $('#field-constructor-block').find('li.active span').html() : '1');
  $('#history-field').load('index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/field_list&<?php echo $token; ?>'+page);
});

function open_field(options) {
  var id = options.a || '';

  if (id > 0) {
    var url = 'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/field_index&<?php echo $token; ?>&field_id='+id;
  } else {
    var url = 'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/field_index&<?php echo $token; ?>';
  }

  open_popup(url);
}
</script>
<!-- end: code for tab Field list -->
<!-- start: code for tab Record list -->
<script>
function submit_record(options) {
  var element = options.a || '',
      after_action = options.b || '';

  $.ajax({
    url:  'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/record_action&<?php echo $token; ?>',
    type: 'post',
    data: $('#modal-record-content form input[type=\'text\'], #modal-record-content form input[type=\'hidden\'], #modal-record-content form input[type=\'radio\']:checked, #modal-record-content form input[type=\'checkbox\']:checked, #modal-record-content form select, #modal-record-content form textarea'),
    dataType: 'json',
    beforeSend: function() {
			$(element).prop('disabled', true);
			$(element).html('<div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>');
			$('[data-toggle=\'tooltip\']').tooltip('destroy');
		},
		complete: function() {
			$(element).prop('disabled', false);
			if (after_action == 'close') {
        $(element).html('<?php echo $button_save; ?>');
      } else {
			  $(element).html('<?php echo $button_save_and_stay; ?>');
      }
			$('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
		},
    success: function(json) {
      notify_close();

      if (json['error']) {
        for (i in json['error']) {
          if (i.replace(/_/g, '-') == 'warning') {
						for (b in json['error'][i]) {
							notify({b:'<?php echo $text_alert_error_heading; ?>',c:json['error'][i][b],d:'static-error'});
						}
					} else {
            notify({a:'modal-error-'+i.replace(/_/g, '-'),b:'<?php echo $text_alert_error_heading; ?>',c:json['error'][i],e:'<?php echo $button_fix; ?>',f:'<?php echo $button_cancel; ?>'});
          }
        }
      }

      if (json['success']) {
        if (after_action == 'close') {
          $.magnificPopup.close();
        }
        $('#modal-error-description').val('');
        $('#modal-record-content .note-editable').html('');
        notify({b:'<?php echo $text_alert_success_heading; ?>',c:json['success'],d:'success'});
        $('a[href=#record-constructor-block]').click();
      }
    },
    error: function(xhr, ajaxOptions, thrownError) {
      alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
  });
}

function record_filter(element, type) {
  filter_data = 'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/record_list&<?php echo $token; ?>';
  filter_data += '&filter_email=' + encodeURIComponent($('#history-record input[name=\'filter_email\']').val());
  filter_data += '&filter_telephone=' + encodeURIComponent($('#history-record input[name=\'filter_telephone\']').val());
  filter_data += '&filter_product_name=' + encodeURIComponent($('#history-record input[name=\'filter_product_name\']').val());
  filter_data += '&filter_date_added=' + encodeURIComponent($('#history-record input[name=\'filter_date_added\']').val());
  filter_data += '&filter_status=' + encodeURIComponent($('#history-record select[name=\'filter_status\']').val());
  filter_data += '&limit=' + encodeURIComponent($('#history-record input[name=\'limit\']:checked').val());

  $.ajax({
    url: filter_data,
    type: 'get',
    dataType: 'html',
    beforeSend: function() {
			$(element).html('<div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>');
			$('[data-toggle=\'tooltip\']').tooltip('destroy');
		},
		complete: function() {
      if (type == 'clear') {
        $(element).html('<i class="fa fa-eraser"></i> <?php echo $button_clear_filter; ?>');
      } else {
        $(element).html('<i class="fa fa-search"></i> <?php echo $button_filter; ?>');
      }
      $('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
		},
    success: function(data) {
      $('#history-record table.main-table-data > tbody').html($(data).find('table.main-table-data > tbody > *'));
      $('#history-record table.main-table-data > tfoot').html($(data).find('table.main-table-data > tfoot > *'));
    }
  });
}

function record_sort(options) {
  var element = options.a || '',
		  type = options.b || '';

  $(element).parent().parent().find('a').not($(element)[0]).removeAttr('class');
  $(element).attr('class', ($(element).attr('class') == 'asc' ? 'desc' : 'asc'));

  filter_data = 'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/record_list&<?php echo $token; ?>';
  filter_data += '&filter_email=' + encodeURIComponent($('#history-record input[name=\'filter_email\']').val());
  filter_data += '&filter_telephone=' + encodeURIComponent($('#history-record input[name=\'filter_telephone\']').val());
  filter_data += '&filter_product_name=' + encodeURIComponent($('#history-record input[name=\'filter_product_name\']').val());
  filter_data += '&filter_date_added=' + encodeURIComponent($('#history-record input[name=\'filter_date_added\']').val());
  filter_data += '&filter_status=' + encodeURIComponent($('#history-record select[name=\'filter_status\']').val());
  filter_data += '&sort=' + encodeURIComponent(type);
  filter_data += '&order=' + encodeURIComponent($(element).attr('class').toUpperCase());
  filter_data += '&limit=' + encodeURIComponent($('#history-record input[name=\'limit\']:checked').val());

  $.ajax({
    url: filter_data,
    type: 'get',
    dataType: 'html',
    beforeSend: function() {
      $(element).append(' <i class="fa fa-refresh fa-spin"></i>');
			$('[data-toggle=\'tooltip\']').tooltip('destroy');
		},
		complete: function() {
      $(element).find('.fa.fa-refresh.fa-spin').remove();
      $('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
		},
    success: function(data) {
      $('#history-record table.main-table-data > tbody').html($(data).find('table.main-table-data > tbody > *'));
      $('#history-record table.main-table-data > tfoot').html($(data).find('table.main-table-data > tfoot > *'));
    }
  });
}

function record_limit(options) {
  var element = options.a || '';

  $(element).find('input').attr('checked', true);
  $(element).parent().parent().find('li').not($(element)[0]).removeAttr('class');
  $(element).parent().attr('class', ($(element).parent().attr('class') == 'active' ? '' : 'active'));

  filter_data = 'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/record_list&<?php echo $token; ?>';
  filter_data += '&filter_email=' + encodeURIComponent($('#history-record input[name=\'filter_email\']').val());
  filter_data += '&filter_telephone=' + encodeURIComponent($('#history-record input[name=\'filter_telephone\']').val());
  filter_data += '&filter_product_name=' + encodeURIComponent($('#history-record input[name=\'filter_product_name\']').val());
  filter_data += '&filter_date_added=' + encodeURIComponent($('#history-record input[name=\'filter_date_added\']').val());
  filter_data += '&filter_status=' + encodeURIComponent($('#history-record select[name=\'filter_status\']').val());
  filter_data += '&limit=' + encodeURIComponent($('#history-record input[name=\'limit\']:checked').val());

  $.ajax({
    url: filter_data,
    type: 'get',
    dataType: 'html',
    beforeSend: function() {
      $(element).append(' <i class="fa fa-refresh fa-spin"></i>');
			$('[data-toggle=\'tooltip\']').tooltip('destroy');
		},
		complete: function() {
      $(element).find('.fa.fa-refresh.fa-spin').remove();
      $('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
		},
    success: function(data) {
      $('#history-record table.main-table-data > tbody').html($(data).find('table.main-table-data > tbody > *'));
      $('#history-record table.main-table-data > tfoot').html($(data).find('table.main-table-data > tfoot > *'));
    }
  });
}

$(document).on('click', '#submit-filter-record-form', function() {
  record_filter(this, 'filter');
});

$(document).on('click', '#clear-filter-record-form', function() {
  $('#history-record input[name=\'filter_email\']').val('');
  $('#history-record input[name=\'filter_telephone\']').val('');
  $('#history-record input[name=\'filter_product_name\']').val('');
  $('#history-record input[name=\'filter_date_added\']').val('');
  $('#history-record select[name=\'filter_status\']').val('*');

  record_filter(this, 'clear');
});

$('#history-record').delegate('.pagination a', 'click', function(e) {
  e.preventDefault();
  filter_data = this.href;
  filter_data += '&filter_email=' + encodeURIComponent($('#history-record input[name=\'filter_email\']').val());
  filter_data += '&filter_telephone=' + encodeURIComponent($('#history-record input[name=\'filter_telephone\']').val());
  filter_data += '&filter_product_name=' + encodeURIComponent($('#history-record input[name=\'filter_product_name\']').val());
  filter_data += '&filter_date_added=' + encodeURIComponent($('#history-record input[name=\'filter_date_added\']').val());
  filter_data += '&filter_status=' + encodeURIComponent($('#history-record select[name=\'filter_status\']').val());
  filter_data += '&limit=' + encodeURIComponent($('#history-record input[name=\'limit\']:checked').val());

  $.ajax({
    url: filter_data,
    type: 'get',
    dataType: 'html',
    success: function(data) {
      $('#history-record table.main-table-data > tbody').html($(data).find('table.main-table-data > tbody > *'));
      $('#history-record table.main-table-data > tfoot').html($(data).find('table.main-table-data > tfoot > *'));
    }
  });
});

$('a[href=#record-constructor-block]').on('click', function() {
  $('.bootstrap-datetimepicker-widget').remove();
  var page = '&page='+($('#record-constructor-block').find('li.active span').length ? $('#record-constructor-block').find('li.active span').html() : '1');
  $('#history-record').load('index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/record_list&<?php echo $token; ?>'+page);
});

function open_record(options) {
  var id = options.a || '';

  if (id > 0) {
    var url = 'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/record_index&<?php echo $token; ?>&record_id='+id;
  } else {
    var url = 'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/record_index&<?php echo $token; ?>';
  }

  open_popup(url);
}
</script>
<!-- end: code for tab Record list -->
<!-- start: code for tab Banned list -->
<script>
function submit_banned(options) {
  var element = options.a || '',
      after_action = options.b || '';

  $.ajax({
    url:  'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/banned_action&<?php echo $token; ?>',
    type: 'post',
    data: $('#modal-banned-content form input[type=\'text\'], #modal-banned-content form input[type=\'hidden\'], #modal-banned-content form input[type=\'radio\']:checked, #modal-banned-content form input[type=\'checkbox\']:checked, #modal-banned-content form select, #modal-banned-content form textarea'),
    dataType: 'json',
    beforeSend: function() {
			$(element).prop('disabled', true);
			$(element).html('<div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>');
			$('[data-toggle=\'tooltip\']').tooltip('destroy');
		},
		complete: function() {
			$(element).prop('disabled', false);
			if (after_action == 'close') {
        $(element).html('<?php echo $button_save; ?>');
      } else {
			  $(element).html('<?php echo $button_save_and_stay; ?>');
      }
			$('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
		},
    success: function(json) {
      notify_close();

      if (json['error']) {
        for (i in json['error']) {
          if (i.replace(/_/g, '-') == 'warning') {
						for (b in json['error'][i]) {
							notify({b:'<?php echo $text_alert_error_heading; ?>',c:json['error'][i][b],d:'static-error'});
						}
					} else {
            notify({a:'modal-error-'+i.replace(/_/g, '-'),b:'<?php echo $text_alert_error_heading; ?>',c:json['error'][i],e:'<?php echo $button_fix; ?>',f:'<?php echo $button_cancel; ?>'});
          }
        }
      }

      if (json['success']) {
        if (after_action == 'close') {
          $.magnificPopup.close();
        }
        notify({b:'<?php echo $text_alert_success_heading; ?>',c:json['success'],d:'success'});
        $('a[href=#banned-constructor-block]').click();
      }
    },
    error: function(xhr, ajaxOptions, thrownError) {
      alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
  });
}

function banned_filter(element, type) {
  filter_data = 'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/banned_list&<?php echo $token; ?>';
  filter_data += '&filter_ip=' + encodeURIComponent($('#history-banned input[name=\'filter_ip\']').val());
  filter_data += '&filter_email=' + encodeURIComponent($('#history-banned input[name=\'filter_email\']').val());
  filter_data += '&filter_telephone=' + encodeURIComponent($('#history-banned input[name=\'filter_telephone\']').val());
  filter_data += '&filter_date_added=' + encodeURIComponent($('#history-banned input[name=\'filter_date_added\']').val());
  filter_data += '&filter_date_modified=' + encodeURIComponent($('#history-banned input[name=\'filter_date_modified\']').val());
  filter_data += '&filter_status=' + encodeURIComponent($('#history-banned select[name=\'filter_status\']').val());
  filter_data += '&limit=' + encodeURIComponent($('#history-banned input[name=\'limit\']:checked').val());

  $.ajax({
    url: filter_data,
    type: 'get',
    dataType: 'html',
    beforeSend: function() {
			$(element).html('<div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>');
			$('[data-toggle=\'tooltip\']').tooltip('destroy');
		},
		complete: function() {
      if (type == 'clear') {
        $(element).html('<i class="fa fa-eraser"></i> <?php echo $button_clear_filter; ?>');
      } else {
        $(element).html('<i class="fa fa-search"></i> <?php echo $button_filter; ?>');
      }
      $('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
		},
    success: function(data) {
      $('#history-banned table.main-table-data > tbody').html($(data).find('table.main-table-data > tbody > *'));
      $('#history-banned table.main-table-data > tfoot').html($(data).find('table.main-table-data > tfoot > *'));
    }
  });
}

function banned_sort(options) {
  var element = options.a || '',
		  type = options.b || '';

  $(element).parent().parent().find('a').not($(element)[0]).removeAttr('class');
  $(element).attr('class', ($(element).attr('class') == 'asc' ? 'desc' : 'asc'));

  filter_data = 'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/banned_list&<?php echo $token; ?>';
  filter_data += '&filter_ip=' + encodeURIComponent($('#history-banned input[name=\'filter_ip\']').val());
  filter_data += '&filter_email=' + encodeURIComponent($('#history-banned input[name=\'filter_email\']').val());
  filter_data += '&filter_telephone=' + encodeURIComponent($('#history-banned input[name=\'filter_telephone\']').val());
  filter_data += '&filter_date_added=' + encodeURIComponent($('#history-banned input[name=\'filter_date_added\']').val());
  filter_data += '&filter_date_modified=' + encodeURIComponent($('#history-banned input[name=\'filter_date_modified\']').val());
  filter_data += '&filter_status=' + encodeURIComponent($('#history-banned select[name=\'filter_status\']').val());
  filter_data += '&sort=' + encodeURIComponent(type);
  filter_data += '&order=' + encodeURIComponent($(element).attr('class').toUpperCase());
  filter_data += '&limit=' + encodeURIComponent($('#history-banned input[name=\'limit\']:checked').val());

  $.ajax({
    url: filter_data,
    type: 'get',
    dataType: 'html',
    beforeSend: function() {
      $(element).append(' <i class="fa fa-refresh fa-spin"></i>');
			$('[data-toggle=\'tooltip\']').tooltip('destroy');
		},
		complete: function() {
      $(element).find('.fa.fa-refresh.fa-spin').remove();
      $('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
		},
    success: function(data) {
      $('#history-banned table.main-table-data > tbody').html($(data).find('table.main-table-data > tbody > *'));
      $('#history-banned table.main-table-data > tfoot').html($(data).find('table.main-table-data > tfoot > *'));
    }
  });
}

function banned_limit(options) {
  var element = options.a || '';

  $(element).find('input').attr('checked', true);
  $(element).parent().parent().find('li').not($(element)[0]).removeAttr('class');
  $(element).parent().attr('class', ($(element).parent().attr('class') == 'active' ? '' : 'active'));

  filter_data = 'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/banned_list&<?php echo $token; ?>';
  filter_data += '&filter_ip=' + encodeURIComponent($('#history-banned input[name=\'filter_ip\']').val());
  filter_data += '&filter_email=' + encodeURIComponent($('#history-banned input[name=\'filter_email\']').val());
  filter_data += '&filter_telephone=' + encodeURIComponent($('#history-banned input[name=\'filter_telephone\']').val());
  filter_data += '&filter_date_added=' + encodeURIComponent($('#history-banned input[name=\'filter_date_added\']').val());
  filter_data += '&filter_date_modified=' + encodeURIComponent($('#history-banned input[name=\'filter_date_modified\']').val());
  filter_data += '&filter_status=' + encodeURIComponent($('#history-banned select[name=\'filter_status\']').val());
  filter_data += '&limit=' + encodeURIComponent($('#history-banned input[name=\'limit\']:checked').val());

  $.ajax({
    url: filter_data,
    type: 'get',
    dataType: 'html',
    beforeSend: function() {
      $(element).append(' <i class="fa fa-refresh fa-spin"></i>');
			$('[data-toggle=\'tooltip\']').tooltip('destroy');
		},
		complete: function() {
      $(element).find('.fa.fa-refresh.fa-spin').remove();
      $('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
		},
    success: function(data) {
      $('#history-banned table.main-table-data > tbody').html($(data).find('table.main-table-data > tbody > *'));
      $('#history-banned table.main-table-data > tfoot').html($(data).find('table.main-table-data > tfoot > *'));
    }
  });
}

$(document).on('click', '#submit-filter-banned-form', function() {
  banned_filter(this, 'filter');
});

$(document).on('click', '#clear-filter-banned-form', function() {
  $('#history-banned input[name=\'filter_ip\']').val('');
  $('#history-banned input[name=\'filter_email\']').val('');
  $('#history-banned input[name=\'filter_telephone\']').val('');
  $('#history-banned input[name=\'filter_date_added\']').val('');
  $('#history-banned input[name=\'filter_date_modified\']').val('');
  $('#history-banned select[name=\'filter_status\']').val('*');

  banned_filter(this, 'clear');
});

$('#history-banned').delegate('.pagination a', 'click', function(e) {
  e.preventDefault();
  filter_data = this.href;
  filter_data += '&filter_ip=' + encodeURIComponent($('#history-banned input[name=\'filter_ip\']').val());
  filter_data += '&filter_email=' + encodeURIComponent($('#history-banned input[name=\'filter_email\']').val());
  filter_data += '&filter_telephone=' + encodeURIComponent($('#history-banned input[name=\'filter_telephone\']').val());
  filter_data += '&filter_date_added=' + encodeURIComponent($('#history-banned input[name=\'filter_date_added\']').val());
  filter_data += '&filter_date_modified=' + encodeURIComponent($('#history-banned input[name=\'filter_date_modified\']').val());
  filter_data += '&filter_status=' + encodeURIComponent($('#history-banned select[name=\'filter_status\']').val());
  filter_data += '&limit=' + encodeURIComponent($('#history-banned input[name=\'limit\']:checked').val());

  $.ajax({
    url: filter_data,
    type: 'get',
    dataType: 'html',
    success: function(data) {
      $('#history-banned table.main-table-data > tbody').html($(data).find('table.main-table-data > tbody > *'));
      $('#history-banned table.main-table-data > tfoot').html($(data).find('table.main-table-data > tfoot > *'));
    }
  });
});

$('a[href=#banned-constructor-block]').on('click', function() {
  $('.bootstrap-datetimepicker-widget').remove();
  var page = '&page='+($('#banned-constructor-block').find('li.active span').length ? $('#banned-constructor-block').find('li.active span').html() : '1');
  $('#history-banned').load('index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/banned_list&<?php echo $token; ?>'+page);
});

function open_banned(options) {
  var id = options.a || '';

  if (id > 0) {
    var url = 'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/banned_index&<?php echo $token; ?>&banned_id='+id;
  } else {
    var url = 'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/banned_index&<?php echo $token; ?>';
  }

  open_popup(url);
}
</script>
<!-- end: code for tab Banned list -->
<!-- start: code for tab Email template constructor setting -->
<script>
function submit_email_template(options) {
  var element = options.a || '',
      after_action = options.b || '';

  $.ajax({
    url:  'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/email_template_action&<?php echo $token; ?>',
    type: 'post',
    data: $('#modal-email-template-constructor-content form input[type=\'text\'], #modal-email-template-constructor-content form input[type=\'hidden\'], #modal-email-template-constructor-content form input[type=\'radio\']:checked, #modal-email-template-constructor-content form input[type=\'checkbox\']:checked, #modal-email-template-constructor-content form select, #modal-email-template-constructor-content form textarea'),
    dataType: 'json',
    beforeSend: function() {
			$(element).prop('disabled', true);
			$(element).html('<div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>');
			$('[data-toggle=\'tooltip\']').tooltip('destroy');
		},
		complete: function() {
			$(element).prop('disabled', false);
			if (after_action == 'close') {
        $(element).html('<?php echo $button_save; ?>');
      } else {
			  $(element).html('<?php echo $button_save_and_stay; ?>');
      }
			$('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
		},
    success: function(json) {
      notify_close();

      if (json['error']) {
        for (i in json['error']) {
          if (i.replace(/_/g, '-') == 'template-description-language') {
            for (b in json['error'][i]) {
              for (c in json['error'][i][b]) {
                notify({a:'modal-error-template-description-language-'+b.replace(/_/g, '-')+'-'+c,b:'<?php echo $text_alert_error_heading; ?>',c:json['error'][i][b][c],e:'<?php echo $button_fix; ?>',f:'<?php echo $button_cancel; ?>'});
              }
            }
          } else if (i.replace(/_/g, '-') == 'warning') {
						for (b in json['error'][i]) {
							notify({b:'<?php echo $text_alert_error_heading; ?>',c:json['error'][i][b],d:'static-error'});
						}
					} else {
            notify({a:'modal-error-'+i.replace(/_/g, '-'),b:'<?php echo $text_alert_error_heading; ?>',c:json['error'][i],e:'<?php echo $button_fix; ?>',f:'<?php echo $button_cancel; ?>'});
          }
        }
      }

      if (json['success']) {
        if (after_action == 'close') {
          $.magnificPopup.close();
        }
        notify({b:'<?php echo $text_alert_success_heading; ?>',c:json['success'],d:'success'});
        $('a[href=#email-template-constructor-block]').click();
      }
    },
    error: function(xhr, ajaxOptions, thrownError) {
      alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
  });
}

function preview_email_template(options) {
  var element = options.a || '',
		  template_id = options.b || '',
      language_id = options.c || '';

  open_popup('index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/preview_email_template&<?php echo $token; ?>&template_id='+template_id+'&language_id='+language_id)
}

function email_template_filter(element, type) {
  filter_data = 'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/email_template_list&<?php echo $token; ?>';
  filter_data += '&filter_name=' + encodeURIComponent($('#history-email-template input[name=\'filter_name\']').val());
  filter_data += '&filter_date_added=' + encodeURIComponent($('#history-email-template input[name=\'filter_date_added\']').val());
  filter_data += '&filter_date_modified=' + encodeURIComponent($('#history-email-template input[name=\'filter_date_modified\']').val());
  filter_data += '&filter_status=' + encodeURIComponent($('#history-email-template select[name=\'filter_status\']').val());
  filter_data += '&limit=' + encodeURIComponent($('#history-email-template input[name=\'limit\']:checked').val());

  $.ajax({
    url: filter_data,
    type: 'get',
    dataType: 'html',
    beforeSend: function() {
			$(element).html('<div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>');
			$('[data-toggle=\'tooltip\']').tooltip('destroy');
		},
		complete: function() {
      if (type == 'clear') {
        $(element).html('<i class="fa fa-eraser"></i> <?php echo $button_clear_filter; ?>');
      } else {
        $(element).html('<i class="fa fa-search"></i> <?php echo $button_filter; ?>');
      }
      $('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
		},
    success: function(data) {
      $('#history-email-template table.main-table-data > tbody').html($(data).find('table.main-table-data > tbody > *'));
      $('#history-email-template table.main-table-data > tfoot').html($(data).find('table.main-table-data > tfoot > *'));
    }
  });
}

function email_template_sort(options) {
  var element = options.a || '',
		  type = options.b || '';

  $(element).parent().parent().find('a').not($(element)[0]).removeAttr('class');
  $(element).attr('class', ($(element).attr('class') == 'asc' ? 'desc' : 'asc'));

  filter_data = 'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/email_template_list&<?php echo $token; ?>';
  filter_data += '&filter_name=' + encodeURIComponent($('#history-email-template input[name=\'filter_name\']').val());
  filter_data += '&filter_date_added=' + encodeURIComponent($('#history-email-template input[name=\'filter_date_added\']').val());
  filter_data += '&filter_date_modified=' + encodeURIComponent($('#history-email-template input[name=\'filter_date_modified\']').val());
  filter_data += '&filter_status=' + encodeURIComponent($('#history-email-template select[name=\'filter_status\']').val());
  filter_data += '&sort=' + encodeURIComponent(type);
  filter_data += '&order=' + encodeURIComponent($(element).attr('class').toUpperCase());
  filter_data += '&limit=' + encodeURIComponent($('#history-email-template input[name=\'limit\']:checked').val());

  $.ajax({
    url: filter_data,
    type: 'get',
    dataType: 'html',
    beforeSend: function() {
      $(element).append(' <i class="fa fa-refresh fa-spin"></i>');
			$('[data-toggle=\'tooltip\']').tooltip('destroy');
		},
		complete: function() {
      $(element).find('.fa.fa-refresh.fa-spin').remove();
      $('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
		},
    success: function(data) {
      $('#history-email-template table.main-table-data > tbody').html($(data).find('table.main-table-data > tbody > *'));
      $('#history-email-template table.main-table-data > tfoot').html($(data).find('table.main-table-data > tfoot > *'));
    }
  });
}

function email_template_limit(options) {
  var element = options.a || '';

  $(element).find('input').attr('checked', true);
  $(element).parent().parent().find('li').not($(element)[0]).removeAttr('class');
  $(element).parent().attr('class', ($(element).parent().attr('class') == 'active' ? '' : 'active'));

  filter_data = 'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/email_template_list&<?php echo $token; ?>';
  filter_data += '&filter_name=' + encodeURIComponent($('#history-email-template input[name=\'filter_name\']').val());
  filter_data += '&filter_date_added=' + encodeURIComponent($('#history-email-template input[name=\'filter_date_added\']').val());
  filter_data += '&filter_date_modified=' + encodeURIComponent($('#history-email-template input[name=\'filter_date_modified\']').val());
  filter_data += '&filter_status=' + encodeURIComponent($('#history-email-template select[name=\'filter_status\']').val());
  filter_data += '&limit=' + encodeURIComponent($('#history-email-template input[name=\'limit\']:checked').val());

  $.ajax({
    url: filter_data,
    type: 'get',
    dataType: 'html',
    beforeSend: function() {
      $(element).append(' <i class="fa fa-refresh fa-spin"></i>');
			$('[data-toggle=\'tooltip\']').tooltip('destroy');
		},
		complete: function() {
      $(element).find('.fa.fa-refresh.fa-spin').remove();
      $('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
		},
    success: function(data) {
      $('#history-email-template table.main-table-data > tbody').html($(data).find('table.main-table-data > tbody > *'));
      $('#history-email-template table.main-table-data > tfoot').html($(data).find('table.main-table-data > tfoot > *'));
    }
  });
}

$(document).on('click', '#submit-filter-email-template-form', function() {
  email_template_filter(this, 'filter');
});

$(document).on('click', '#clear-filter-email-template-form', function() {
  $('#history-email-template input[name=\'filter_name\']').val('');
  $('#history-email-template input[name=\'filter_date_added\']').val('');
  $('#history-email-template input[name=\'filter_date_modified\']').val('');
  $('#history-email-template select[name=\'filter_status\']').val('*');

  email_template_filter(this, 'clear');
});

$('#history-email-template').delegate('.pagination a', 'click', function(e) {
  e.preventDefault();
  filter_data = this.href;
  filter_data += '&filter_name=' + encodeURIComponent($('#history-email-template input[name=\'filter_name\']').val());
  filter_data += '&filter_date_added=' + encodeURIComponent($('#history-email-template input[name=\'filter_date_added\']').val());
  filter_data += '&filter_date_modified=' + encodeURIComponent($('#history-email-template input[name=\'filter_date_modified\']').val());
  filter_data += '&filter_status=' + encodeURIComponent($('#history-email-template select[name=\'filter_status\']').val());
  filter_data += '&limit=' + encodeURIComponent($('#history-email-template input[name=\'limit\']:checked').val());

  $.ajax({
    url: filter_data,
    type: 'get',
    dataType: 'html',
    success: function(data) {
      $('#history-email-template table.main-table-data > tbody').html($(data).find('table.main-table-data > tbody > *'));
      $('#history-email-template table.main-table-data > tfoot').html($(data).find('table.main-table-data > tfoot > *'));
    }
  });
});

$('a[href=#email-template-constructor-block]').on('click', function() {
  var page = '&page='+($('#email-template-constructor-block').find('li.active span').length ? $('#email-template-constructor-block').find('li.active span').html() : '1');
  $('#history-email-template').load('index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/email_template_list&<?php echo $token; ?>'+page);
});

function open_email_template(options) {
  var id = options.a || '';

  if (id > 0) {
    var url = 'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/email_template_index&<?php echo $token; ?>&template_id='+id;
  } else {
    var url = 'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/email_template_index&<?php echo $token; ?>';
  }

  open_popup(url);
}
</script>
<!-- end: code for tab Email template constructor setting -->
<!-- start: code for tab Sms template constructor setting -->
<script>
function submit_sms_template(options) {
  var element = options.a || '',
      after_action = options.b || '';

  $.ajax({
    url:  'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/sms_template_action&<?php echo $token; ?>',
    type: 'post',
    data: $('#modal-sms-template-constructor-content form input[type=\'text\'], #modal-sms-template-constructor-content form input[type=\'hidden\'], #modal-sms-template-constructor-content form input[type=\'radio\']:checked, #modal-sms-template-constructor-content form input[type=\'checkbox\']:checked, #modal-sms-template-constructor-content form select, #modal-sms-template-constructor-content form textarea'),
    dataType: 'json',
    beforeSend: function() {
			$(element).prop('disabled', true);
			$(element).html('<div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>');
			$('[data-toggle=\'tooltip\']').tooltip('destroy');
		},
		complete: function() {
			$(element).prop('disabled', false);
			if (after_action == 'close') {
        $(element).html('<?php echo $button_save; ?>');
      } else {
			  $(element).html('<?php echo $button_save_and_stay; ?>');
      }
			$('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
		},
    success: function(json) {
      notify_close();

      if (json['error']) {
        for (i in json['error']) {
          if (i.replace(/_/g, '-') == 'template-description-language') {
            for (b in json['error'][i]) {
              for (c in json['error'][i][b]) {
                notify({a:'modal-error-template-description-language-'+b.replace(/_/g, '-')+'-'+c,b:'<?php echo $text_alert_error_heading; ?>',c:json['error'][i][b][c],e:'<?php echo $button_fix; ?>',f:'<?php echo $button_cancel; ?>'});
              }
            }
          } else if (i.replace(/_/g, '-') == 'warning') {
						for (b in json['error'][i]) {
							notify({b:'<?php echo $text_alert_error_heading; ?>',c:json['error'][i][b],d:'static-error'});
						}
					} else {
            notify({a:'modal-error-'+i.replace(/_/g, '-'),b:'<?php echo $text_alert_error_heading; ?>',c:json['error'][i],e:'<?php echo $button_fix; ?>',f:'<?php echo $button_cancel; ?>'});
          }
        }
      }

      if (json['success']) {
        if (after_action == 'close') {
          $.magnificPopup.close();
        }
        notify({b:'<?php echo $text_alert_success_heading; ?>',c:json['success'],d:'success'});
        $('a[href=#sms-template-constructor-block]').click();
      }
    },
    error: function(xhr, ajaxOptions, thrownError) {
      alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
  });
}

function preview_sms_template(template_id, language_id) {
  open_popup('index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/preview_sms_template&<?php echo $token; ?>&template_id='+template_id+'&language_id='+language_id)
}

function sms_template_filter(element, type) {
  filter_data = 'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/sms_template_list&<?php echo $token; ?>';
  filter_data += '&filter_name=' + encodeURIComponent($('#history-sms-template input[name=\'filter_name\']').val());
  filter_data += '&filter_date_added=' + encodeURIComponent($('#history-sms-template input[name=\'filter_date_added\']').val());
  filter_data += '&filter_date_modified=' + encodeURIComponent($('#history-sms-template input[name=\'filter_date_modified\']').val());
  filter_data += '&filter_status=' + encodeURIComponent($('#history-sms-template select[name=\'filter_status\']').val());
  filter_data += '&limit=' + encodeURIComponent($('#history-sms-template input[name=\'limit\']:checked').val());

  $.ajax({
    url: filter_data,
    type: 'get',
    dataType: 'html',
    beforeSend: function() {
			$(element).html('<div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>');
			$('[data-toggle=\'tooltip\']').tooltip('destroy');
		},
		complete: function() {
      if (type == 'clear') {
        $(element).html('<i class="fa fa-eraser"></i> <?php echo $button_clear_filter; ?>');
      } else {
        $(element).html('<i class="fa fa-search"></i> <?php echo $button_filter; ?>');
      }
      $('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
		},
    success: function(data) {
      $('#history-sms-template table.main-table-data > tbody').html($(data).find('table.main-table-data > tbody > *'));
      $('#history-sms-template table.main-table-data > tfoot').html($(data).find('table.main-table-data > tfoot > *'));
    }
  });
}

function sms_template_sort(options) {
  var element = options.a || '',
		  type = options.b || '';

  $(element).parent().parent().find('a').not($(element)[0]).removeAttr('class');
  $(element).attr('class', ($(element).attr('class') == 'asc' ? 'desc' : 'asc'));

  filter_data = 'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/sms_template_list&<?php echo $token; ?>';
  filter_data += '&filter_name=' + encodeURIComponent($('#history-sms-template input[name=\'filter_name\']').val());
  filter_data += '&filter_date_added=' + encodeURIComponent($('#history-sms-template input[name=\'filter_date_added\']').val());
  filter_data += '&filter_date_modified=' + encodeURIComponent($('#history-sms-template input[name=\'filter_date_modified\']').val());
  filter_data += '&filter_status=' + encodeURIComponent($('#history-sms-template select[name=\'filter_status\']').val());
  filter_data += '&sort=' + encodeURIComponent(type);
  filter_data += '&order=' + encodeURIComponent($(element).attr('class').toUpperCase());
  filter_data += '&limit=' + encodeURIComponent($('#history-sms-template input[name=\'limit\']:checked').val());

  $.ajax({
    url: filter_data,
    type: 'get',
    dataType: 'html',
    beforeSend: function() {
      $(element).append(' <i class="fa fa-refresh fa-spin"></i>');
			$('[data-toggle=\'tooltip\']').tooltip('destroy');
		},
		complete: function() {
      $(element).find('.fa.fa-refresh.fa-spin').remove();
      $('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
		},
    success: function(data) {
      $('#history-sms-template table.main-table-data > tbody').html($(data).find('table.main-table-data > tbody > *'));
      $('#history-sms-template table.main-table-data > tfoot').html($(data).find('table.main-table-data > tfoot > *'));
    }
  });
}

function sms_template_limit(options) {
  var element = options.a || '';

  $(element).find('input').attr('checked', true);
  $(element).parent().parent().find('li').not($(element)[0]).removeAttr('class');
  $(element).parent().attr('class', ($(element).parent().attr('class') == 'active' ? '' : 'active'));

  filter_data = 'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/sms_template_list&<?php echo $token; ?>';
  filter_data += '&filter_name=' + encodeURIComponent($('#history-sms-template input[name=\'filter_name\']').val());
  filter_data += '&filter_date_added=' + encodeURIComponent($('#history-sms-template input[name=\'filter_date_added\']').val());
  filter_data += '&filter_date_modified=' + encodeURIComponent($('#history-sms-template input[name=\'filter_date_modified\']').val());
  filter_data += '&filter_status=' + encodeURIComponent($('#history-sms-template select[name=\'filter_status\']').val());
  filter_data += '&limit=' + encodeURIComponent($('#history-sms-template input[name=\'limit\']:checked').val());

  $.ajax({
    url: filter_data,
    type: 'get',
    dataType: 'html',
    beforeSend: function() {
      $(element).append(' <i class="fa fa-refresh fa-spin"></i>');
			$('[data-toggle=\'tooltip\']').tooltip('destroy');
		},
		complete: function() {
      $(element).find('.fa.fa-refresh.fa-spin').remove();
      $('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
		},
    success: function(data) {
      $('#history-sms-template table.main-table-data > tbody').html($(data).find('table.main-table-data > tbody > *'));
      $('#history-sms-template table.main-table-data > tfoot').html($(data).find('table.main-table-data > tfoot > *'));
    }
  });
}

$(document).on('click', '#submit-filter-sms-template-form', function() {
  sms_template_filter(this, 'filter');
});

$(document).on('click', '#clear-filter-sms-template-form', function() {
  $('#history-sms-template input[name=\'filter_name\']').val('');
  $('#history-sms-template input[name=\'filter_date_added\']').val('');
  $('#history-sms-template input[name=\'filter_date_modified\']').val('');
  $('#history-sms-template select[name=\'filter_status\']').val('*');

  sms_template_filter(this, 'clear');
});

$('#history-sms-template').delegate('.pagination a', 'click', function(e) {
  e.preventDefault();
  filter_data = this.href;
  filter_data += '&filter_name=' + encodeURIComponent($('#history-sms-template input[name=\'filter_name\']').val());
  filter_data += '&filter_date_added=' + encodeURIComponent($('#history-sms-template input[name=\'filter_date_added\']').val());
  filter_data += '&filter_date_modified=' + encodeURIComponent($('#history-sms-template input[name=\'filter_date_modified\']').val());
  filter_data += '&filter_status=' + encodeURIComponent($('#history-sms-template select[name=\'filter_status\']').val());
  filter_data += '&limit=' + encodeURIComponent($('#history-sms-template input[name=\'limit\']:checked').val());

  $.ajax({
    url: filter_data,
    type: 'get',
    dataType: 'html',
    success: function(data) {
      $('#history-sms-template table.main-table-data > tbody').html($(data).find('table.main-table-data > tbody > *'));
      $('#history-sms-template table.main-table-data > tfoot').html($(data).find('table.main-table-data > tfoot > *'));
    }
  });
});

$('a[href=#sms-template-constructor-block]').on('click', function() {
  var page = '&page='+($('#sms-template-constructor-block').find('li.active span').length ? $('#sms-template-constructor-block').find('li.active span').html() : '1');
  $('#history-sms-template').load('index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/sms_template_list&<?php echo $token; ?>'+page);
});

function open_sms_template(options) {
  var id = options.a || '';

  if (id > 0) {
    var url = 'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/sms_template_index&<?php echo $token; ?>&template_id='+id;
  } else {
    var url = 'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/sms_template_index&<?php echo $token; ?>';
  }

  open_popup(url);
}
</script>
<!-- end: code for tab Sms template constructor setting -->
<script>
function make_delete_action(options) {
  var element = options.a || '',
			type = options.b || '',
	    group = options.c || '',
      id = options.d || '',
      checkbox_data = '';

  if (group == 'all') {
	  var url = 'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/delete_action&<?php echo $token; ?>&type='+type+'&group='+group;
	} else if (group == 'all_selected') {
    var url = 'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/delete_action&<?php echo $token; ?>&type='+type+'&group='+group;
    var checkbox_data = $('#history-'+type.replace(/_/g, '-')+' input[type=\'checkbox\']:checked');
  } else {
	  var url = 'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/delete_action&<?php echo $token; ?>&type='+type+'&group='+group+'&delete='+id;
	}

  $.ajax({
    type: 'post',
    url:  url,
	  data: checkbox_data,
    dataType: 'json',
    beforeSend: function() {
      if (group == 'all') {
			  $(element).html('<i class="fa fa-refresh fa-spin"></i> <?php echo $button_delete_all; ?>');
      } else if (group == 'all_selected') {
        $(element).html('<i class="fa fa-refresh fa-spin"></i> <?php echo $button_delete_selected; ?>');
      } else {
        $(element).html('<div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>');
			}
			$('[data-toggle=\'tooltip\']').tooltip('destroy');
		},
		complete: function() {
      if (group == 'all') {
			  $(element).html('<i class="fa fa-trash-o"></i> <?php echo $button_delete_all; ?>');
			} else if (group == 'all_selected') {
        $(element).html('<i class="fa fa-trash-o"></i> <?php echo $button_delete_selected; ?>');
      } else {
        $(element).html('<i class="fa fa-trash-o"></i>');
			}
      $('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
		},
	  success: function(json) {
      notify_close();

      if (json['error']) {
        for (i in json['error']) {
          if (i.replace(/_/g, '-') == 'warning') {
            for (b in json['error'][i]) {
              notify({b:'<?php echo $text_alert_error_heading; ?>',c:json['error'][i][b],d:'static-error'});
            }
	        } else {
	          notify({b:'<?php echo $text_alert_error_heading; ?>',c:json['error'][i],d:'static-error'});
          }
        }
      }

      if (json['success']) {
        $('#history-'+type.replace(/_/g, '-')).load('index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/'+type+'_list&<?php echo $token; ?>');

        notify({b:'<?php echo $text_alert_success_heading; ?>',c:json['success'],d:'success'});
      }
    },
    error: function(xhr, ajaxOptions, thrownError) {
      alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
  });
}

function make_copy_action(options) {
  var element = options.a || '',
			type = options.b || '',
	    group = options.c || '',
      id = options.d || '',
      checkbox_data = '';

  if (group == 'all') {
	  var url = 'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/copy_action&<?php echo $token; ?>&type='+type+'&group='+group;
	} else if (group == 'all_selected') {
    var url = 'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/copy_action&<?php echo $token; ?>&type='+type+'&group='+group;
    var checkbox_data = $('#history-'+type.replace(/_/g, '-')+' input[type=\'checkbox\']:checked');
  } else {
	  var url = 'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/copy_action&<?php echo $token; ?>&type='+type+'&group='+group+'&copy='+id;
	}

  $.ajax({
    type: 'post',
    url:  url,
	  data: checkbox_data,
    dataType: 'json',
    beforeSend: function() {
      if (group == 'all') {
			  $(element).html('<i class="fa fa-refresh fa-spin"></i> <?php echo $button_copy_all; ?>');
      } else if (group == 'all_selected') {
        $(element).html('<i class="fa fa-refresh fa-spin"></i> <?php echo $button_copy_selected; ?>');
      } else {
			  $(element).html('<div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>');
			}
			$('[data-toggle=\'tooltip\']').tooltip('destroy');
		},
		complete: function() {
      if (group == 'all') {
			  $(element).html('<i class="fa fa-copy"></i> <?php echo $button_copy_all; ?>');
			} else if (group == 'all_selected') {
        $(element).html('<i class="fa fa-copy"></i> <?php echo $button_copy_selected; ?>');
      } else {
			  $(element).html('<i class="fa fa-copy"></i>');
			}
      $('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
		},
	  success: function(json) {
      notify_close();

      if (json['error']) {
        for (i in json['error']) {
          if (i.replace(/_/g, '-') == 'warning') {
            for (b in json['error'][i]) {
              notify({b:'<?php echo $text_alert_error_heading; ?>',c:json['error'][i][b],d:'static-error'});
            }
	        } else {
	          notify({b:'<?php echo $text_alert_error_heading; ?>',c:json['error'][i],d:'static-error'});
          }
        }
      }

      if (json['success']) {
	      $('#history-'+type.replace(/_/g, '-')).load('index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/'+type+'_list&<?php echo $token; ?>');

        notify({b:'<?php echo $text_alert_success_heading; ?>',c:json['success'],d:'success'});
      }
    },
    error: function(xhr, ajaxOptions, thrownError) {
      alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
  });
}
</script>
<!-- start: code for module usability -->
<script>
if (window.localStorage && window.localStorage['last_active_tab']) {
  $('#setting-tabs a[href='+window.localStorage['last_active_tab']+']').trigger('click').addClass('list-group-item-warning');
}

$('#setting-tabs a[data-toggle="tab"]').click(function() {
  if (window.localStorage) {
    window.localStorage['last_active_tab'] = $(this).attr('href');
  }
  $('#setting-tabs a[data-toggle="tab"]').removeClass('list-group-item-warning');
  $(this).addClass('list-group-item-warning');
});

$(function() {
  var collapse_blocks = JSON.parse(localStorage.getItem('menu_items'));

  if (collapse_blocks) {
    $.each(collapse_blocks, function(i,val){
      if ($('a#'+val).length) {
        $('a#'+val).removeClass('open');
      }
    });
  }
});

function collapse_blocks(options) {
  var element = options.a || '',
      id = $(element).attr('id'),
      type = options.b || '';

  $(element).toggleClass('open');

  var collapse_blocks = JSON.parse(localStorage.getItem(type));

  if (collapse_blocks) {
    var a = JSON.parse(localStorage.getItem(type));

    if (a.indexOf(id) === -1) {
      a.push(id);
      localStorage.setItem(type, JSON.stringify(a));
    } else {
      for (var i = collapse_blocks.length; i--;) {
        if (collapse_blocks[i] === id) {
          collapse_blocks.splice(i, 1);
        }
      }

      localStorage.setItem(type, JSON.stringify(collapse_blocks));
    }
  } else {
    var a = [];
    a.push(id);
    localStorage.setItem(type, JSON.stringify(a));
  }
}

$(window).scroll(function () {
  if ($(window).scrollTop() >= $('#header').height()) {
    $('#content .page-header').addClass('fixed-page-header');
  } else {
    $('#content .page-header').removeClass('fixed-page-header');
    $('#main-content').css('paddingTop', '0');
  }

  if (window.innerWidth > 768) {
	  var h = -30,
	      scroll_top = $(window).scrollTop();

	  if ($('#main-column-left').height() > $('#main-content').height()) {
	    if (scroll_top < ($('#main-column-left').height() - $('#main-content').height()) && scroll_top > $('#content .page-header').height()) {
	      $('#main-content').css({'paddingTop': scroll_top - h});
	    }
	    if (scroll_top == 0) {
	      $('#main-content').css({'paddingTop': '0px'});
	    }
	  } else {
	    $('#main-content').css({'paddingTop': '0px'});
    }
	} else {
    $('#main-content').css({'paddingTop': '0px'});
  }
});

if ($(window).scrollTop() >= $('#header').height()) {
  $('#content .page-header').addClass('fixed-page-header');
} else {
  $('#content .page-header').removeClass('fixed-page-header');
  $('#main-content').css('paddingTop', '0');
}

if (window.innerWidth > 768) {
  var h = -30,
      scroll_top = $(window).scrollTop();

  if ($('#main-column-left').height() > $('#main-content').height()) {
    if (scroll_top < ($('#main-column-left').height() - $('#main-content').height()) && scroll_top > $('#content .page-header').height()) {
      $('#main-content').css({'paddingTop': scroll_top - h});
    }
    if (scroll_top == 0) {
      $('#main-content').css({'paddingTop': '0px'});
    }
  } else {
    $('#main-content').css({'paddingTop': '0px'});
  }
} else {
  $('#main-content').css({'paddingTop': '0px'});
}

$('.btn-toggle').on('click', '.btn', function() {
  if(!$(this).hasClass('disabled')){
    $(this).addClass('btn-success').siblings().removeClass('btn-success').addClass('btn-default');
  }
});

$('.btn-toggle').on('click', '.disabled', function() {
  return false;
});

$('body').on('hidden.bs.modal', function () {
  if ($('.modal.in').length > 0) {
    $('body').addClass('modal-open');
  }
});

$(document).on('hidden.bs.modal', '#modal-form-constructor', function () {
  $('.modal.fade, .modal-backdrop.fade').remove();
});

$(document).on('hidden.bs.modal', function () {
  $('.mfp-wrap').css('overflow', 'hidden auto');
});

$(document).on('shown.bs.modal', function () {
  $('.mfp-wrap').css('overflow', 'hidden');
});

$('body').on('click', '.dropdown-menu.special-dropdown', function(e) {
	$(this).parent().is('.open') && e.stopPropagation();
});

$(document).delegate('button[data-faq-target]', 'click', function(e) {
  var element = this;
  open_popup('index.php?route=extension/ocdevwizard/helper/preview_faq&<?php echo $token; ?>&module_name=<?php echo $_name; ?>&img_name='+$(element).attr('data-faq-target'))
});

$(function() {
  var blocks = ['record','field','banned','email-template','sms-template'];

  $.each(blocks, function (i,block) {
    if ($('#'+block+'-constructor-block').hasClass('active')) {
      $('.bootstrap-datetimepicker-widget').remove();
      $('#history-'+block).load('index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/'+block.replace(/-/g, '_')+'_list&<?php echo $token; ?>');
    }
  });
});

var backup_files = ['config','field','record','banned','email_template','sms_template'];

$.each(backup_files, function (i,file) {
  $('#'+file.replace(/_/g, '-')+'-load-file').change(function() {
    $('#'+file.replace(/_/g, '-')+'-load-file-mask').val($(this).val());
    $('#'+file.replace(/_/g, '-')+'-button-import-file-1').attr('disabled', false);
  });

  $('select[name=\''+file+'_backup_file_name\']').change(function(){
    if ($(this).val()) {
      $('#'+file.replace(/_/g, '-')+'-button-import-file-2').attr('disabled', false);
    } else {
      $('#'+file.replace(/_/g, '-')+'-button-import-file-2').attr('disabled', true);
    }
  });
});

function make_full_width_action(options) {
  var element = options.a || '';
  $('[data-toggle=\'tooltip\']').tooltip('destroy');
  $('#main-column-left').toggle();
  $('#main-content').toggleClass('col-sm-12 col-md-12 col-lg-12');
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
              notify({b:'<?php echo $text_alert_error_heading; ?>',c:json['error'][i][b],d:'static-error'});
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
    },
    error: function(xhr, ajaxOptions, thrownError) {
      alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
	});
}

function make_banned_action(options) {
  var element = options.a || '',
		  record_id = options.b || '',
      type = options.c || '';

  $.ajax({
		url: 'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/record_banned_action&<?php echo $token; ?>&store_id=<?php echo $store_id; ?>&record_id='+record_id+'&type='+type,
		type: 'post',
		dataType: 'json',
		beforeSend: function() {
			$(element).prop('disabled', true);
			$(element).html('<div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>');
			$('[data-toggle=\'tooltip\']').tooltip('destroy');
		},
		complete: function() {
			$(element).prop('disabled', false);
			if (type == 'add') {
			  $(element).html('<i class="fa fa-unlock-alt"></i>');
      } else if (type == 'remove') {
        $(element).html('<i class="fa fa-lock"></i>');
      }
      $('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
		},
    success: function(json) {
      notify_close();

      if (json['error']) {
        for (i in json['error']) {
	        if (i.replace(/_/g, '-') == 'warning') {
            for (b in json['error'][i]) {
              notify({b:'<?php echo $text_alert_error_heading; ?>',c:json['error'][i][b],d:'static-error'});
            }
	        }
        }
      }

		  if (json['success']) {
        notify({b:'<?php echo $text_alert_success_heading; ?>',c:json['success'],d:'success'});
        $('a[href=#record-constructor-block]').click();
      }
    },
    error: function(xhr, ajaxOptions, thrownError) {
      alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
	});
}

function make_cache_action(options) {
  var element = options.a || '',
		type = options.b || '';

  $.ajax({
		url: 'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/cache&<?php echo $token; ?>&store_id=<?php echo $store_id; ?>&type='+type,
		type: 'post',
		dataType: 'json',
		beforeSend: function() {
			if (type == 'cache_backup') {
			  $(element).html('<i class="fa fa-refresh fa-spin"></i> <?php echo $button_cache_backup; ?>');
      } else {
			  $(element).html('<i class="fa fa-refresh fa-spin"></i> <?php echo $button_cache; ?>');
			}
			$('[data-toggle=\'tooltip\']').tooltip('destroy');
		},
		complete: function() {
			if (type == 'cache_backup') {
			  $(element).html('<i class="fa fa-trash-o"></i> <?php echo $button_cache_backup; ?>');
			} else {
			  $(element).html('<i class="fa fa-trash-o"></i> <?php echo $button_cache; ?>');
			}
      $('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
		},
    success: function(json) {
      notify_close();

      if (json['error']) {
        for (i in json['error']) {
	        if (i.replace(/_/g, '-') == 'warning') {
            for (b in json['error'][i]) {
              notify({b:'<?php echo $text_alert_error_heading; ?>',c:json['error'][i][b],d:'static-error'});
            }
	        }
        }
      }

		  if (json['success']) {
        notify({b:'<?php echo $text_alert_success_heading; ?>',c:json['success'],d:'success'});

		    if (type == 'cache_backup') {
		      setTimeout(function() {
	          location.reload();
	        }, 2000);
		    }
      }
    },
    error: function(xhr, ajaxOptions, thrownError) {
      alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
	});
}

function make_restore_action(options) {
  var element = options.a || '';

  $.ajax({
		url: 'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/restore&<?php echo $token; ?>&store_id=<?php echo $store_id; ?>',
		type: 'post',
		dataType: 'json',
		beforeSend: function() {
			$(element).html('<i class="fa fa-refresh fa-spin"></i> <?php echo $button_restore; ?>');
			$('[data-toggle=\'tooltip\']').tooltip('destroy');
		},
		complete: function() {
      $(element).html('<i class="fa fa-repeat"></i> <?php echo $button_restore; ?>');
      $('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
		},
    success: function(json) {
      notify_close();

      if (json['error']) {
        for (i in json['error']) {
	        if (i.replace(/_/g, '-') == 'warning') {
            for (b in json['error'][i]) {
              notify({b:'<?php echo $text_alert_error_heading; ?>',c:json['error'][i][b],d:'static-error'});
            }
	        }
        }
      }

		  if (json['success']) {
        notify({b:'<?php echo $text_alert_success_heading; ?>',c:json['success'],d:'success'});

        setTimeout(function() {
          location.reload();
        }, 2000);
      }
    },
    error: function(xhr, ajaxOptions, thrownError) {
      alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
	});
}

function make_export_action(options) {
  var element = options.a || '',
		type = options.b || '';

  $.ajax({
		url: 'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/export_settings&<?php echo $token; ?>&store_id=<?php echo $store_id; ?>&type='+type,
		type: 'post',
		dataType: 'json',
		beforeSend: function() {
			$(element).prop('disabled', true);
			$(element).html('<div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>');
			$('[data-toggle=\'tooltip\']').tooltip('destroy');
		},
		complete: function() {
			$(element).prop('disabled', false);
      $(element).html('<i class="fa fa-upload"></i> <?php echo $button_export; ?>');
      $('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
		},
    success: function(json) {
      notify_close();

      if (json['error']) {
        for (i in json['error']) {
	        if (i.replace(/_/g, '-') == 'warning') {
            for (b in json['error'][i]) {
              notify({b:'<?php echo $text_alert_error_heading; ?>',c:json['error'][i][b],d:'static-error'});
            }
	        }
        }
      }

		  if (json['redirect']) {
        location = json['redirect'];

        $.ajax({
			    url: 'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>&<?php echo $token; ?>&store_id=<?php echo $store_id; ?>',
			    type: 'get',
			    dataType: 'html',
			    success: function(data) {
			      $('#'+type.replace(/_/g, '-')+'-import-export-block select').html($(data).find('#'+type.replace(/_/g, '-')+'-import-export-block select option'));
			      $('#'+type.replace(/_/g, '-')+'-import-export-block select').next().find('button').removeAttr('disabled');
			    }
			  });
      }
    },
    error: function(xhr, ajaxOptions, thrownError) {
      alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
	});
}

function make_import_action(options) {
	var element = options.a || '',
			type = options.b || '',
			source = options.c || '';

	if (source == 'from_user' && $('#form input[name=\''+type+'_import\']').val() != '') {
	  $.ajax({
			url: 'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/import_settings&<?php echo $token; ?>&store_id=<?php echo $store_id; ?>&source='+source+'&type='+type,
			type: 'post',
			dataType: 'json',
			data: new FormData($('#form')[0]),
			cache: false,
			contentType: false,
			processData: false,
			beforeSend: function() {
				$(element).prop('disabled', true);
				$(element).html('<div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>');
				$('[data-toggle=\'tooltip\']').tooltip('destroy');
				$('a[href="#'+type.replace(/_/g, '-')+'-constructor-block"]').append('<i class="fa fa-refresh fa-spin f1"></i>');
			},
			complete: function() {
				$(element).prop('disabled', false);
	      $(element).removeClass('btn-primary').addClass('btn-success').html('<i class="fa fa-check"></i> <?php echo $text_success_processing; ?>');
	      $('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
	      $('a[href="#'+type.replace(/_/g, '-')+'-constructor-block"] i.fa-spin').remove();
			},
	    success: function(json) {
	      notify_close();

	      if (json['error']) {
	        for (i in json['error']) {
		        if (i.replace(/_/g, '-') == 'warning') {
              for (b in json['error'][i]) {
                notify({b:'<?php echo $text_alert_error_heading; ?>',c:json['error'][i][b],d:'static-error'});
              }
            } else {
		          notify({b:'<?php echo $text_alert_error_heading; ?>',c:json['error'][i],d:'static-error'});
            }
	        }
	      }

			  if (json['success']) {
	        notify({b:'<?php echo $text_alert_success_heading; ?>',c:json['success'],d:'success'});

	        $('#history-'+type.replace(/_/g, '-')).load('index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/'+type+'_list&<?php echo $token; ?>&page=1');
	      }
	    },
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	} else {
	  $.ajax({
			url: 'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/import_settings&<?php echo $token; ?>&store_id=<?php echo $store_id; ?>&source='+source+'&type='+type,
			type: 'post',
			dataType: 'json',
			data: 'file_name='+$('select[name=\''+type+'_backup_file_name\']').val(),
			beforeSend: function() {
				$(element).prop('disabled', true);
				$(element).html('<div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>');
				$('[data-toggle=\'tooltip\']').tooltip('destroy');
				$('a[href="#'+type.replace(/_/g, '-')+'-constructor-block"]').append('<i class="fa fa-refresh fa-spin f1"></i>');
			},
			complete: function() {
				$(element).prop('disabled', false);
	      $(element).removeClass('btn-primary').addClass('btn-success').html('<i class="fa fa-check"></i> <?php echo $text_success_processing; ?>');
	      $('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
	      $('a[href="#'+type.replace(/_/g, '-')+'-constructor-block"] i.fa-spin').remove();
			},
	    success: function(json) {
	      notify_close();

	      if (json['error']) {
	        for (i in json['error']) {
		        notify({b:'<?php echo $text_alert_error_heading; ?>',c:json['error'][i],d:'static-error'});
	        }
	      }

			  if (json['success']) {
	        notify({b:'<?php echo $text_alert_success_heading; ?>',c:json['success'],d:'success'});

	        $('#history-'+type.replace(/_/g, '-')).load('index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/'+type+'_list&<?php echo $token; ?>&page=1');
	      }
	    },
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	}
}

function generate_sort_order(element, type, id) {
  var sort_order = $('#modal-error-sort-order').val();

  $.ajax({
    type: 'post',
    url:  'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/generate_sort_order&<?php echo $token; ?>&sort_order='+sort_order+'&type='+type+'&id='+id,
    dataType: 'json',
    beforeSend: function() {
			$(element).prop('disabled', true);
			$(element).html('<div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>');
			$('[data-toggle=\'tooltip\']').tooltip('destroy');
		},
		complete: function() {
			$(element).prop('disabled', false);
      $(element).html('<?php echo $button_generate; ?>');
      $('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
		},
    success: function(json) {
      notify_close();

      if (json['error']) {
        for (i in json['error']) {
          if (i.replace(/_/g, '-') == 'warning') {
            for (b in json['error'][i]) {
              notify({b:'<?php echo $text_alert_error_heading; ?>',c:json['error'][i][b],e:'<?php echo $button_fix; ?>',f:'<?php echo $button_cancel; ?>'});
            }
          } else {
            notify({a:'input-'+i.replace(/_/g, '-'),b:'<?php echo $text_alert_error_heading; ?>',c:json['error'][i],e:'<?php echo $button_fix; ?>',f:'<?php echo $button_cancel; ?>'});
          }
        }
      }

      if (json['sort_order']) {
        $(element).parent().prev().val(json['sort_order']);
        notify({b:'<?php echo $text_alert_success_heading; ?>',c:json['success'],d:'success'});
      }
    },
    error: function(xhr, ajaxOptions, thrownError) {
      alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
  });
}

function generate_cron_token(element) {
  $.ajax({
    type: 'post',
    url:  'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/generate_cron_token&<?php echo $token; ?>',
    dataType: 'json',
    beforeSend: function() {
			$(element).prop('disabled', true);
			$(element).html('<div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>');
			$('[data-toggle=\'tooltip\']').tooltip('destroy');
		},
		complete: function() {
			$(element).prop('disabled', false);
      $(element).html('<?php echo $button_generate; ?>');
      $('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
		},
    success: function(json) {
      notify_close();

      if (json['error']) {
        for (i in json['error']) {
          if (i.replace(/_/g, '-') == 'warning') {
            for (b in json['error'][i]) {
              notify({b:'<?php echo $text_alert_error_heading; ?>',c:json['error'][i][b],e:'<?php echo $button_fix; ?>',f:'<?php echo $button_cancel; ?>'});
            }
          } else {
            notify({a:'input-'+i.replace(/_/g, '-'),b:'<?php echo $text_alert_error_heading; ?>',c:json['error'][i],e:'<?php echo $button_fix; ?>',f:'<?php echo $button_cancel; ?>'});
          }
        }
      }

      if (json['cron_token']) {
        $(element).parent().prev().val(json['cron_token']);
        $('#input-tech-url-for-cron').val(json['technical_url_for_cron']);
        notify({b:'<?php echo $text_alert_success_heading; ?>',c:json['success'],d:'success'});
      }
    },
    error: function(xhr, ajaxOptions, thrownError) {
      alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
  });
}

function open_popup(url) {
  notify_close();
	
  setTimeout(function(){
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
        },
        updateStatus: function(data) {
          if (data.status === 'ready') {
            var collapse_blocks = JSON.parse(localStorage.getItem('template_main_related'));
            if (collapse_blocks) {
              $.each(collapse_blocks, function(i,val){
                if ($('legend#'+val).length) {
                  $('legend#'+val).removeClass('open');
                }
              });
            }
          }
        }
      },
      removalDelay: 500
    });
  }, 1);
	}
	
function open_support() {
  open_popup('index.php?route=extension/ocdevwizard/helper/need_help&<?php echo $token; ?>');
}

function submit_base(options) {
  var element = options.a || '';

  $.ajax({
    url:  'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/base_action&<?php echo $token; ?>&store_id=<?php echo $store_id; ?>',
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
      $(element).html('<i class="fa fa-save"></i>');
      $('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
		},
    success: function(json) {
      notify_close();

      if (json['error']) {
        for (i in json['error']) {
          if (i.replace(/_/g, '-') == 'text-data-language') {
            for (b in json['error'][i]) {
              for (c in json['error'][i][b]) {
                notify({a:'input-text-data-language-'+b.replace(/_/g, '-')+'-'+c,b:'<?php echo $text_alert_error_heading; ?>',c:json['error'][i][b][c],e:'<?php echo $button_fix; ?>',f:'<?php echo $button_cancel; ?>'});
              }
            }
          } else if (i.replace(/_/g, '-') == 'warning') {
            for (b in json['error'][i]) {
              notify({b:'<?php echo $text_alert_error_heading; ?>',c:json['error'][i][b],d:'static-error'});
            }
          } else {
            notify({a:'input-'+i.replace(/_/g, '-'),b:'<?php echo $text_alert_error_heading; ?>',c:json['error'][i],e:'<?php echo $button_fix; ?>',f:'<?php echo $button_cancel; ?>'});
          }
        }
      }

      if (json['success']) {
        notify({b:'<?php echo $text_alert_success_heading; ?>',c:json['success'],d:'success'});
      }
    },
    error: function(xhr, ajaxOptions, thrownError) {
      alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
  });
}

function show_explanation(options) {
  var element = options.a || '';
  $(element).parent().next().find('div.alert.alert-info').slideToggle();
}

function block_visibility_instructions(options) {
  var tab = options.a || '';

  if (tab == 'general-block') {
    $('.sms-gate-instruction').hide();
    $('.sms-gate-1-instruction').hide();
    $('.sms-gate-2-instruction').hide();
    $('.sms-gate-3-instruction').hide();
    $('.sms-gate-4-instruction').hide();
    $('.captcha-site-key-instruction').hide();
    $('.captcha-secret-key-instruction').hide();
    $('.user-email-template-product-price-was-changed-instruction').hide();
    $('.user-email-template-product-option-in-stock-instruction').hide();
    $('.user_sms-template-product-price-was-changed-instruction').hide();
    $('.user-sms-template-product-option-in-stock-instruction').hide();
    $('.admin-email-for-notification-instruction').hide();
    $('.admin-email-template-product-instruction').hide();
    $('.admin-email-template-product-option-instruction').hide();
    $('.user-email-template-product-instruction').hide();
    $('.user-email-template-product-option-instruction').hide();
    $('.call-button-icon-instruction').hide();
    $('.call-button-icon-width-and-height-instruction').hide();
    $('.product-related-instruction').hide();
    $('.category-related-instruction').hide();
    $('.manufacturer-related-instruction').hide();
    $('.description-instruction').hide();
    $('.sidebar-type-instruction').hide();
    $('.option-related-instruction').hide();
    $('.option-button-class-product-page-instruction').hide();
    $('.option-call-button-product-page-instruction').hide();
    $('.analytic-code-instruction').hide();

    if ($('select[name=\'form_data[notification_type]\']').val() == '1') {
      $('.user-email-template-product-price-was-changed-instruction').show();

      if ($('select[name=\'form_data[related_option_status]\']').val() > 0) {
        $('.user-email-template-product-option-in-stock-instruction').show();
      }
    } else if ($('select[name=\'form_data[notification_type]\']').val() == '2') {
      $('.sms-gate-instruction').show();
      $('.user_sms-template-product-price-was-changed-instruction').show();

      if ($('select[name=\'form_data[related_option_status]\']').val() > 0) {
        $('.user-sms-template-product-option-in-stock-instruction').show();
      }

      if ($('select[name=\'form_data[sms_gate]\']').val() == '1') {
        $('.sms-gate-1-instruction').show();
      } else if ($('select[name=\'form_data[sms_gate]\']').val() == '2') {
        $('.sms-gate-2-instruction').show();
      } else if ($('select[name=\'form_data[sms_gate]\']').val() == '3') {
        $('.sms-gate-3-instruction').show();
      } else if ($('select[name=\'form_data[sms_gate]\']').val() == '4') {
        $('.sms-gate-4-instruction').show();
      }
    } else if ($('select[name=\'form_data[notification_type]\']').val() == '3') {
      $('.sms-gate-instruction').show();
      $('.user-email-template-product-price-was-changed-instruction').show();
      $('.user_sms-template-product-price-was-changed-instruction').show();

      if ($('select[name=\'form_data[related_option_status]\']').val() > 0) {
        $('.user-email-template-product-option-in-stock-instruction').show();
        $('.user-sms-template-product-option-in-stock-instruction').show();
      }

      if ($('select[name=\'form_data[sms_gate]\']').val() == '1') {
        $('.sms-gate-1-instruction').show();
      } else if ($('select[name=\'form_data[sms_gate]\']').val() == '2') {
        $('.sms-gate-2-instruction').show();
      } else if ($('select[name=\'form_data[sms_gate]\']').val() == '3') {
        $('.sms-gate-3-instruction').show();
      } else if ($('select[name=\'form_data[sms_gate]\']').val() == '4') {
        $('.sms-gate-4-instruction').show();
      }
    }

    if ($('select[name=\'form_data[captcha_status]\']').val() == '1') {
      $('.captcha-site-key-instruction').show();
      $('.captcha-secret-key-instruction').show();
    }

    if ($('select[name=\'form_data[admin_alert_status]\']').val() == '1') {
      $('.admin-email-for-notification-instruction').show();
      $('.admin-email-template-product-instruction').show();
      if ($('select[name=\'form_data[related_option_status]\']').val() > 0) {
        $('.admin-email-template-product-option-instruction').show();
      }
    }

    if ($('select[name=\'form_data[user_alert_status]\']').val() == '1') {
      $('.user-email-template-product-instruction').show();
      if ($('select[name=\'form_data[related_option_status]\']').val() > 0) {
        $('.user-email-template-product-option-instruction').show();
      }
    }

    if ($('select[name=\'form_data[call_button_view_status]\']').val() == '2') {
      $('.call-button-icon-instruction').show();
      $('.call-button-icon-width-and-height-instruction').show();
    }

    if ($('select[name=\'form_data[related_product_status]\']').val() == '1') {
      $('.category-related-instruction').show();
    } else if ($('select[name=\'form_data[related_product_status]\']').val() == '2') {
      $('.manufacturer-related-instruction').show();
    } else if ($('select[name=\'form_data[related_product_status]\']').val() == '3') {
      $('.product-related-instruction').show();
    }

    if ($('select[name=\'form_data[show_description]\']').val() > 0) {
      $('.description-instruction').show();
    }

    if ($('select[name=\'form_data[display_type]\']').val() == '2') {
      $('.sidebar-type-instruction').show();
    }

    if ($('select[name=\'form_data[related_option_status]\']').val() == '1') {
      $('.option-related-instruction').show();
    }

    if ($('select[name=\'form_data[related_option_status]\']').val() > 0) {
      $('.option-button-class-product-page-instruction').show();
      $('.option-call-button-product-page-instruction').show();
    }

    if ($('select[name=\'form_data[analytic_code_status]\']').val() == '1') {
      $('.analytic-code-instruction').show();
    }
  }
}

$('select[name=\'form_data[notification_type]\'],select[name=\'form_data[captcha_status]\'],select[name=\'form_data[admin_alert_status]\'],select[name=\'form_data[call_button_view_status]\'],select[name=\'form_data[related_product_status]\'],select[name=\'form_data[show_description]\'],select[name=\'form_data[user_alert_status]\'],select[name=\'form_data[display_type]\'],select[name=\'form_data[sms_gate]\'],select[name=\'form_data[related_option_status]\'],select[name=\'form_data[analytic_code_status]\']').change(function() {
  block_visibility_instructions({a:'general-block'});
});

block_visibility_instructions({a:'general-block'});

$('input[name=\'field_related\']').autocomplete({
  'source': function(request, response) {
    $.ajax({
      url: 'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/autocomplete_field&<?php echo $token; ?>&filter_name='+encodeURIComponent(request),
      dataType: 'json',
      success: function(json) {
        response($.map(json, function (item) {
          if (item['field_id']) {
            return {
              value: item['field_id'],
              label: item['name']
            }
          } else {
            return {
              label: '<?php echo $text_none; ?>',
              value: 0
            }
          }
        }));
      }
    });
  },
  'select': function (item) {
    if (item['value'] > 0) {
      $('input[name=field_related]').val('');
      $('#field-related-'+item['value']).remove();
      $('#input-fields').append('<div class="well-custom-item" id="field-related-'+item['value']+'"><i class="fa fa-check-square-o"></i> '+item['label']+'<input type="hidden" name="form_data[fields][]" value="'+item['value']+'" /></div>&nbsp;');
    }
  }
});

$('#input-fields').delegate('.well-custom-item', 'click', function() {
  $(this).remove();
});

$('input[name=\'related_product\']').autocomplete({
  'source': function(request, response) {
    $.ajax({
      url: 'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/autocomplete_product&<?php echo $token; ?>&filter_name='+encodeURIComponent(request),
      dataType: 'json',
      success: function(json) {
        response($.map(json, function (item) {
          if (item['product_id']) {
            return {
              value: item['product_id'],
              label: item['name']
            }
          } else {
            return {
              label: '<?php echo $text_none; ?>',
              value: 0
            }
          }
        }));
      }
    });
  },
  'select': function(item) {
    $('input[name=\'related_product\']').val('');
    $('#product-related'+item['value']).remove();
    $('#product-related').append('<div class="well-custom-item" id="product-related'+item['value']+'"><i class="fa fa-check-square-o"></i> '+item['label']+'<input type="hidden" name="form_data[product_related][]" value="'+item['value']+'" /></div>&nbsp;');
  }
});

$('#product-related').delegate('.well-custom-item', 'click', function() {
  $(this).remove();
});

$('input[name=\'related_category\']').autocomplete({
  'source': function(request, response) {
    $.ajax({
      url: 'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/autocomplete_category&<?php echo $token; ?>&filter_name='+encodeURIComponent(request),
      dataType: 'json',
      success: function(json) {
        response($.map(json, function (item) {
          if (item['category_id']) {
            return {
              value: item['category_id'],
              label: item['name']
            }
          } else {
            return {
              label: '<?php echo $text_none; ?>',
              value: 0
            }
          }
        }));
      }
    });
  },
  'select': function(item) {
    $('input[name=\'related_category\']').val('');
    $('#category-related'+item['value']).remove();
    $('#category-related').append('<div class="well-custom-item" id="category-related'+item['value']+'"><i class="fa fa-check-square-o"></i> '+item['label']+'<input type="hidden" name="form_data[category_related][]" value="'+item['value']+'" /></div>&nbsp;');
  }
});

$('#category-related').delegate('.well-custom-item', 'click', function() {
  $(this).remove();
});

$('input[name=\'related_manufacturer\']').autocomplete({
  'source': function(request, response) {
    $.ajax({
      url: 'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/autocomplete_manufacturer&<?php echo $token; ?>&filter_name='+encodeURIComponent(request),
      dataType: 'json',
      success: function(json) {
        response($.map(json, function (item) {
          if (item['manufacturer_id']) {
            return {
              value: item['manufacturer_id'],
              label: item['name']
            }
          } else {
            return {
              label: '<?php echo $text_none; ?>',
              value: 0
            }
          }
        }));
      }
    });
  },
  'select': function(item) {
    $('input[name=\'related_manufacturer\']').val('');
    $('#manufacturer-related'+item['value']).remove();
    $('#manufacturer-related').append('<div class="well-custom-item" id="manufacturer-related'+item['value']+'"><i class="fa fa-check-square-o"></i> '+item['label']+'<input type="hidden" name="form_data[manufacturer_related][]" value="'+item['value']+'" /></div>&nbsp;');
  }
});

$('#manufacturer-related').delegate('.well-custom-item', 'click', function() {
  $(this).remove();
});

$('input[name=\'option_related\']').autocomplete({
  'source': function(request, response) {
    $.ajax({
      url: 'index.php?route=extension/ocdevwizard/<?php echo $_name; ?>/autocomplete_option&<?php echo $token; ?>&filter_name='+encodeURIComponent(request),
      dataType: 'json',
      success: function(json) {
        response($.map(json, function (item) {
          if (item['option_id']) {
            return {
              value: item['option_id'],
              label: item['name']
            }
          } else {
            return {
              label: '<?php echo $text_none; ?>',
              value: 0
            }
          }
        }));
      }
    });
  },
  'select': function(item) {
    $('input[name=\'option_related\']').val('');
    $('#option-related'+item['value']).remove();
    $('#option-related').append('<div class="well-custom-item" id="option-related'+item['value']+'"><i class="fa fa-check-square-o"></i> '+item['label']+'<input type="hidden" name="form_data[option_related][]" value="'+item['value']+'" /></div>&nbsp;');
  }
});

$('#option-related').delegate('.well-custom-item', 'click', function() {
  $(this).remove();
});

</script>
<!-- end: code for module usability -->
<?php echo $footer; ?>