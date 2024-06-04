<?php
##=================================================##
## @author    : OCdevWizard                        ##
## @contact   : ocdevwizard@gmail.com              ##
## @support   : http://help.ocdevwizard.com        ##
## @copyright : (c) OCdevWizard. Price Alert, 2018 ##
##=================================================##
class ModelApiOcdevwizardPriceAlert extends Model {
  private $_name = 'price_alert';
  private $_code = 'ocdw_price_alert';

  public function addField($data) {
    $this->db->query("
      INSERT INTO ".DB_PREFIX.$this->_code."_field
      SET
        status = '".(int)$data['status']."',
        system_name = '".$this->db->escape($data['system_name'])."',
        field_type = '".$this->db->escape($data['field_type'])."',
        field_mask = '".$this->db->escape($data['field_mask'])."',
        validation_type = '".(int)$data['validation_type']."',
        regex_rule = '".$this->db->escape($data['regex_rule'])."',
        min_length_rule = '".$this->db->escape($data['min_length_rule'])."',
        max_length_rule = '".$this->db->escape($data['max_length_rule'])."',
        sort_order = '".(int)$data['sort_order']."',
        css_id = '".$this->db->escape($data['css_id'])."',
        css_class = '".$this->db->escape($data['css_class'])."',
        description_status = '".(int)$data['description_status']."',
        title_status = '".(int)$data['title_status']."',
        placeholder_status = '".(int)$data['placeholder_status']."',
        icon_status = '".(int)$data['icon_status']."',
        date_added = NOW()
    ");

    $field_id = $this->db->getLastId();

    if (isset($data['icon'])) {
      $this->db->query("UPDATE ".DB_PREFIX.$this->_code."_field SET icon = '".$this->db->escape($data['icon'])."' WHERE field_id = '".(int)$field_id."'");
    }

    if (isset($data['field_description'])) {
      foreach ($data['field_description'] as $language_id => $value) {
        $this->db->query("
          INSERT INTO ".DB_PREFIX.$this->_code."_field_description
          SET
            field_id = '".(int)$field_id."',
            language_id = '".(int)$language_id."',
            `name` = '".$this->db->escape($value['name'])."',
            error_text = '".$this->db->escape($value['error_text'])."',
            description = '".$this->db->escape($value['description'])."',
            placeholder = '".$this->db->escape($value['placeholder'])."'
        ");
      }
    }

    return $field_id;
  }

  public function addBanned($data) {
    $this->db->query("
      INSERT INTO ".DB_PREFIX.$this->_code."_banned
      SET
        status = '".(int)$data['status']."',
        ip = '".$this->db->escape($data['ip'])."',
        email = '".$this->db->escape($data['email'])."',
        telephone = '".$this->db->escape($data['telephone'])."',
        date_added = NOW()
    ");

    $banned_id = $this->db->getLastId();

    return $banned_id;
  }

  public function addEmailTemplate($data) {
    $this->db->query("
      INSERT INTO ".DB_PREFIX.$this->_code."_email_template
      SET
        system_name = '".$this->db->escape($data['system_name'])."',
        assignment = '".(int)$data['assignment']."',
        related_product_status = '".(int)$data['related_product_status']."',
        related_limit = '".(int)$data['related_limit']."',
        related_show_image = '".(int)$data['related_show_image']."',
        related_image_width = '".(int)$data['related_image_width']."',
        related_image_height = '".(int)$data['related_image_height']."',
        related_show_price = '".(int)$data['related_show_price']."',
        related_show_name = '".(int)$data['related_show_name']."',
        related_show_description = '".(int)$data['related_show_description']."',
        related_description_limit = '".(int)$data['related_description_limit']."',
        related_randomize = '".(int)$data['related_randomize']."',
        main_show_image = '".(int)$data['main_show_image']."',
        main_image_width = '".(int)$data['main_image_width']."',
        main_image_height = '".(int)$data['main_image_height']."',
        main_show_price = '".(int)$data['main_show_price']."',
        main_show_name = '".(int)$data['main_show_name']."',
        main_show_description = '".(int)$data['main_show_description']."',
        main_description_limit = '".(int)$data['main_description_limit']."',
        status = '".(int)$data['status']."',
        date_added = NOW()
    ");

    $template_id = $this->db->getLastId();

    foreach ($data['template_description'] as $language_id => $value) {
      $this->db->query("INSERT INTO ".DB_PREFIX.$this->_code."_email_template_description 
        SET 
        template_id = '".(int)$template_id."', 
        language_id = '".(int)$language_id."', 
        subject = '".$this->db->escape($value['subject'])."', 
        template = '".$this->db->escape($value['template'])."'
      ");
    }

    if (isset($data['product_related'])) {
      foreach ($data['product_related'] as $product_id) {
        $this->db->query("DELETE FROM ".DB_PREFIX.$this->_code."_email_template_related_product WHERE template_id = '".(int)$template_id."' AND product_id = '".(int)$product_id."'");
        $this->db->query("INSERT INTO ".DB_PREFIX.$this->_code."_email_template_related_product SET template_id = '".(int)$template_id."', product_id = '".(int)$product_id."'");
      }
    }

    if (isset($data['category_related'])) {
      foreach ($data['category_related'] as $category_id) {
        $this->db->query("DELETE FROM ".DB_PREFIX.$this->_code."_email_template_related_category WHERE template_id = '".(int)$template_id."' AND category_id = '".(int)$category_id."'");
        $this->db->query("INSERT INTO ".DB_PREFIX.$this->_code."_email_template_related_category SET template_id = '".(int)$template_id."', category_id = '".(int)$category_id."'");
      }
    }

    if (isset($data['manufacturer_related'])) {
      foreach ($data['manufacturer_related'] as $manufacturer_id) {
        $this->db->query("DELETE FROM ".DB_PREFIX.$this->_code."_email_template_related_manufacturer WHERE template_id = '".(int)$template_id."' AND manufacturer_id = '".(int)$manufacturer_id."'");
        $this->db->query("INSERT INTO ".DB_PREFIX.$this->_code."_email_template_related_manufacturer SET template_id = '".(int)$template_id."', manufacturer_id = '".(int)$manufacturer_id."'");
      }
    }

    return $template_id;
  }

  public function addSmsTemplate($data) {
    $this->db->query("
      INSERT INTO ".DB_PREFIX.$this->_code."_sms_template
      SET
        system_name = '".$this->db->escape($data['system_name'])."',
        assignment = '".(int)$data['assignment']."',
        status = '".(int)$data['status']."',
        date_added = NOW()
    ");

    $template_id = $this->db->getLastId();

    foreach ($data['template_description'] as $language_id => $value) {
      $this->db->query("INSERT INTO ".DB_PREFIX.$this->_code."_sms_template_description 
        SET 
        template_id = '".(int)$template_id."', 
        language_id = '".(int)$language_id."', 
        template = '".$this->db->escape($value['template'])."'
      ");
    }

    return $template_id;
  }

  public function addConfigRelated($data) {
    $data_inner = (isset($data[$this->_name.'_form_data']) && $data[$this->_name.'_form_data']) ? $data[$this->_name.'_form_data'] : [];

    if (isset($data_inner['related_product_status']) && $data_inner['related_product_status']) {
      if ($data_inner['related_product_status'] == 1) {
        $this->db->query("DELETE FROM ".DB_PREFIX.$this->_code."_config_related_category WHERE store_id = '".(int)$data['store_id']."'");

        if (isset($data_inner['category_related']) && $data_inner['category_related']) {
          foreach ($data_inner['category_related'] as $category_id) {
            $this->db->query("INSERT INTO ".DB_PREFIX.$this->_code."_config_related_category SET store_id = '".(int)$data['store_id']."', category_id = '".(int)$category_id."'");
          }
        }
      }

      if ($data_inner['related_product_status'] == 2) {
        $this->db->query("DELETE FROM ".DB_PREFIX.$this->_code."_config_related_manufacturer WHERE store_id = '".(int)$data['store_id']."'");

        if (isset($data_inner['manufacturer_related']) && $data_inner['manufacturer_related']) {
          foreach ($data_inner['manufacturer_related'] as $manufacturer_id) {
            $this->db->query("INSERT INTO ".DB_PREFIX.$this->_code."_config_related_manufacturer SET store_id = '".(int)$data['store_id']."', manufacturer_id = '".(int)$manufacturer_id."'");
          }
        }
      }

      if ($data_inner['related_product_status'] == 3) {
        $this->db->query("DELETE FROM ".DB_PREFIX.$this->_code."_config_related_product WHERE store_id = '".(int)$data['store_id']."'");

        if (isset($data_inner['product_related']) && $data_inner['product_related']) {
          foreach ($data_inner['product_related'] as $product_id) {
            $this->db->query("INSERT INTO ".DB_PREFIX.$this->_code."_config_related_product SET store_id = '".(int)$data['store_id']."', product_id = '".(int)$product_id."'");
          }
        }
      }

      if ($data_inner['related_option_status'] == 1) {
        $this->db->query("DELETE FROM ".DB_PREFIX.$this->_code."_config_related_option WHERE store_id = '".(int)$data['store_id']."'");

        if (isset($data_inner['option_related']) && $data_inner['option_related']) {
          foreach ($data_inner['option_related'] as $option_id) {
            $this->db->query("INSERT INTO ".DB_PREFIX.$this->_code."_config_related_option SET store_id = '".(int)$data['store_id']."', option_id = '".(int)$option_id."'");
          }
        }
      }
    }
  }

  public function editField($data) {
    $this->db->query("
      UPDATE ".DB_PREFIX.$this->_code."_field
      SET
        status = '".(int)$data['status']."',
        system_name = '".$this->db->escape($data['system_name'])."',
        field_type = '".$this->db->escape($data['field_type'])."',
        field_mask = '".$this->db->escape($data['field_mask'])."',
        validation_type = '".(int)$data['validation_type']."',
        regex_rule = '".$this->db->escape($data['regex_rule'])."',
        min_length_rule = '".$this->db->escape($data['min_length_rule'])."',
        max_length_rule = '".$this->db->escape($data['max_length_rule'])."',
        sort_order = '".(int)$data['sort_order']."',
        css_id = '".$this->db->escape($data['css_id'])."',
        css_class = '".$this->db->escape($data['css_class'])."',
        description_status = '".(int)$data['description_status']."',
        title_status = '".(int)$data['title_status']."',
        placeholder_status = '".(int)$data['placeholder_status']."',
        icon_status = '".(int)$data['icon_status']."',
        icon = '".$this->db->escape($data['icon'])."',
        date_modified = NOW()
      WHERE
        field_id = '".(int)$data['field_id']."'
    ");

    $this->db->query("DELETE FROM ".DB_PREFIX.$this->_code."_field_description WHERE field_id = '".(int)$data['field_id']."'");

    if (isset($data['field_description'])) {
      foreach ($data['field_description'] as $language_id => $value) {
        $this->db->query("
          INSERT INTO ".DB_PREFIX.$this->_code."_field_description
          SET
            field_id = '".(int)$data['field_id']."',
            language_id = '".(int)$language_id."',
            `name` = '".$this->db->escape($value['name'])."',
            error_text = '".$this->db->escape($value['error_text'])."',
            description = '".$this->db->escape($value['description'])."',
            placeholder = '".$this->db->escape($value['placeholder'])."'
        ");
      }
    }
  }

  public function editBanned($data) {
    $this->db->query("
      UPDATE ".DB_PREFIX.$this->_code."_banned
      SET
        status = '".(int)$data['status']."',
        ip = '".$this->db->escape($data['ip'])."',
        email = '".$this->db->escape($data['email'])."',
        telephone = '".$this->db->escape($data['telephone'])."',
        date_modified = NOW()
      WHERE
        banned_id = '".(int)$data['banned_id']."'
    ");
  }

  public function editEmailTemplate($data) {
    $this->db->query("
      UPDATE ".DB_PREFIX.$this->_code."_email_template
      SET
        system_name = '".$this->db->escape($data['system_name'])."',
        assignment = '".(int)$data['assignment']."',
        related_product_status = '".(int)$data['related_product_status']."',
        related_limit = '".(int)$data['related_limit']."',
        related_show_image = '".(int)$data['related_show_image']."',
        related_image_width = '".(int)$data['related_image_width']."',
        related_image_height = '".(int)$data['related_image_height']."',
        related_show_price = '".(int)$data['related_show_price']."',
        related_show_name = '".(int)$data['related_show_name']."',
        related_show_description = '".(int)$data['related_show_description']."',
        related_description_limit = '".(int)$data['related_description_limit']."',
        related_randomize = '".(int)$data['related_randomize']."',
        main_show_image = '".(int)$data['main_show_image']."',
        main_image_width = '".(int)$data['main_image_width']."',
        main_image_height = '".(int)$data['main_image_height']."',
        main_show_price = '".(int)$data['main_show_price']."',
        main_show_name = '".(int)$data['main_show_name']."',
        main_show_description = '".(int)$data['main_show_description']."',
        main_description_limit = '".(int)$data['main_description_limit']."',
        status = '".(int)$data['status']."',
        date_modified = NOW()
      WHERE
        template_id = '".(int)$data['template_id']."'
    ");

    $this->db->query("DELETE FROM ".DB_PREFIX.$this->_code."_email_template_description WHERE template_id = '".(int)$data['template_id']."'");

    foreach ($data['template_description'] as $language_id => $value) {
      $this->db->query("INSERT INTO ".DB_PREFIX.$this->_code."_email_template_description 
        SET 
        template_id = '".(int)$data['template_id']."', 
        language_id = '".(int)$language_id."', 
        subject = '".$this->db->escape($value['subject'])."', 
        template = '".$this->db->escape($value['template'])."'
      ");
    }

    $this->db->query("DELETE FROM ".DB_PREFIX.$this->_code."_email_template_related_product WHERE template_id = '".(int)$data['template_id']."'");

    if (isset($data['product_related'])) {
      foreach ($data['product_related'] as $product_id) {
        $this->db->query("INSERT INTO ".DB_PREFIX.$this->_code."_email_template_related_product SET template_id = '".(int)$data['template_id']."', product_id = '".(int)$product_id."'");
      }
    }

    $this->db->query("DELETE FROM ".DB_PREFIX.$this->_code."_email_template_related_category WHERE template_id = '".(int)$data['template_id']."'");

    if (isset($data['category_related'])) {
      foreach ($data['category_related'] as $category_id) {
        $this->db->query("INSERT INTO ".DB_PREFIX.$this->_code."_email_template_related_category SET template_id = '".(int)$data['template_id']."', category_id = '".(int)$category_id."'");
      }
    }

    $this->db->query("DELETE FROM ".DB_PREFIX.$this->_code."_email_template_related_manufacturer WHERE template_id = '".(int)$data['template_id']."'");

    if (isset($data['manufacturer_related'])) {
      foreach ($data['manufacturer_related'] as $manufacturer_id) {
        $this->db->query("INSERT INTO ".DB_PREFIX.$this->_code."_email_template_related_manufacturer SET template_id = '".(int)$data['template_id']."', manufacturer_id = '".(int)$manufacturer_id."'");
      }
    }
  }

  public function editSmsTemplate($data) {
    $this->db->query("
      UPDATE ".DB_PREFIX.$this->_code."_sms_template
      SET
        system_name = '".$this->db->escape($data['system_name'])."',
        assignment = '".(int)$data['assignment']."',
        status = '".(int)$data['status']."',
        date_modified = NOW()
      WHERE
        template_id = '".(int)$data['template_id']."'
    ");

    $this->db->query("DELETE FROM ".DB_PREFIX.$this->_code."_sms_template_description WHERE template_id = '".(int)$data['template_id']."'");

    foreach ($data['template_description'] as $language_id => $value) {
      $this->db->query("INSERT INTO ".DB_PREFIX.$this->_code."_sms_template_description 
        SET 
        template_id = '".(int)$data['template_id']."', 
        language_id = '".(int)$language_id."', 
        template = '".$this->db->escape($value['template'])."'
      ");
    }
  }

  public function prepareField() {
    $this->db->query("TRUNCATE ".DB_PREFIX.$this->_code."_field");
    $this->db->query("TRUNCATE ".DB_PREFIX.$this->_code."_field_description");
  }

  public function prepareRecord() {
    $this->db->query("TRUNCATE ".DB_PREFIX.$this->_code."_record");
  }

  public function prepareConfigRelated() {
    $this->db->query("TRUNCATE ".DB_PREFIX.$this->_code."_config_related_category");
    $this->db->query("TRUNCATE ".DB_PREFIX.$this->_code."_config_related_manufacturer");
    $this->db->query("TRUNCATE ".DB_PREFIX.$this->_code."_config_related_product");
    $this->db->query("TRUNCATE ".DB_PREFIX.$this->_code."_config_related_option");
  }

  public function prepareBanned() {
    $this->db->query("TRUNCATE ".DB_PREFIX.$this->_code."_banned");
  }

  public function prepareEmailTemplate() {
    $this->db->query("TRUNCATE ".DB_PREFIX.$this->_code."_email_template");
    $this->db->query("TRUNCATE ".DB_PREFIX.$this->_code."_email_template_description");
    $this->db->query("TRUNCATE ".DB_PREFIX.$this->_code."_email_template_related_product");
    $this->db->query("TRUNCATE ".DB_PREFIX.$this->_code."_email_template_related_category");
    $this->db->query("TRUNCATE ".DB_PREFIX.$this->_code."_email_template_related_manufacturer");
  }

  public function prepareSmsTemplate() {
    $this->db->query("TRUNCATE ".DB_PREFIX.$this->_code."_sms_template");
    $this->db->query("TRUNCATE ".DB_PREFIX.$this->_code."_sms_template_description");
  }

  public function importField($data) {
    $this->db->query("
      INSERT INTO ".DB_PREFIX.$this->_code."_field
      SET
        field_id = '".(int)$data['field_id']."',
        status = '".(int)$data['status']."',
        system_name = '".$this->db->escape($data['system_name'])."',
        field_type = '".$this->db->escape($data['field_type'])."',
        field_mask = '".$this->db->escape($data['field_mask'])."',
        validation_type = '".(int)$data['validation_type']."',
        regex_rule = '".$this->db->escape($data['regex_rule'])."',
        min_length_rule = '".$this->db->escape($data['min_length_rule'])."',
        max_length_rule = '".$this->db->escape($data['max_length_rule'])."',
        sort_order = '".(int)$data['sort_order']."',
        css_id = '".$this->db->escape($data['css_id'])."',
        css_class = '".$this->db->escape($data['css_class'])."',
        description_status = '".(int)$data['description_status']."',
        title_status = '".(int)$data['title_status']."',
        placeholder_status = '".(int)$data['placeholder_status']."',
        icon_status = '".(int)$data['icon_status']."',
        date_added = '".$this->db->escape($data['date_added'])."',
        date_modified = '".$this->db->escape($data['date_modified'])."'
    ");

    if (isset($data['icon'])) {
      $this->db->query("UPDATE ".DB_PREFIX.$this->_code."_field SET icon = '".$this->db->escape($data['icon'])."' WHERE field_id = '".(int)$data['field_id']."'");
    }

    if (isset($data['field_description'])) {
      foreach ($data['field_description'] as $language_id => $value) {
        $this->db->query("
          INSERT INTO ".DB_PREFIX.$this->_code."_field_description
          SET
            field_id = '".(int)$data['field_id']."',
            language_id = '".(int)$language_id."',
            `name` = '".$this->db->escape($value['name'])."',
            error_text = '".$this->db->escape($value['error_text'])."',
            description = '".$this->db->escape($value['description'])."',
            placeholder = '".$this->db->escape($value['placeholder'])."'
        ");
      }
    }
  }

  public function importConfigRelated($data) {
    $data_inner = (isset($data[$this->_name.'_form_data']) && $data[$this->_name.'_form_data']) ? $data[$this->_name.'_form_data'] : [];

    if (isset($data_inner['category_related']) && $data_inner['category_related']) {
      foreach ($data_inner['category_related'] as $category_id) {
        $this->db->query("INSERT INTO ".DB_PREFIX.$this->_code."_config_related_category SET store_id = '".(int)$data['store_id']."', category_id = '".(int)$category_id."'");
      }
    }

    if (isset($data_inner['manufacturer_related']) && $data_inner['manufacturer_related']) {
      foreach ($data_inner['manufacturer_related'] as $manufacturer_id) {
        $this->db->query("INSERT INTO ".DB_PREFIX.$this->_code."_config_related_manufacturer SET store_id = '".(int)$data['store_id']."', manufacturer_id = '".(int)$manufacturer_id."'");
      }
    }

    if (isset($data_inner['product_related']) && $data_inner['product_related']) {
      foreach ($data_inner['product_related'] as $product_id) {
        $this->db->query("INSERT INTO ".DB_PREFIX.$this->_code."_config_related_product SET store_id = '".(int)$data['store_id']."', product_id = '".(int)$product_id."'");
      }
    }

    if (isset($data_inner['option_related']) && $data_inner['option_related']) {
      foreach ($data_inner['option_related'] as $option_id) {
        $this->db->query("INSERT INTO ".DB_PREFIX.$this->_code."_config_related_option SET store_id = '".(int)$data['store_id']."', option_id = '".(int)$option_id."'");
      }
    }
  }

  public function importBanned($data) {
    $this->db->query("
      INSERT INTO ".DB_PREFIX.$this->_code."_banned
      SET
        banned_id = '".(int)$data['banned_id']."',
        status = '".(int)$data['status']."',
        ip = '".$this->db->escape($data['ip'])."',
        email = '".$this->db->escape($data['email'])."',
        telephone = '".$this->db->escape($data['telephone'])."',
        date_added = '".$this->db->escape($data['date_added'])."',
        date_modified = '".$this->db->escape($data['date_modified'])."'
    ");
  }

  public function importRecord($data) {
    $this->db->query("
      INSERT INTO ".DB_PREFIX.$this->_code."_record
      SET
        record_id = '".(int)$data['record_id']."',
        product_id = '".(int)$data['product_id']."',
        customer_id = '".(int)$data['customer_id']."',
        product_option_id = '".(int)$data['product_option_id']."',
        product_option_value_id = '".(int)$data['product_option_value_id']."',
        option_id = '".(int)$data['option_id']."',
        option_value_id = '".(int)$data['option_value_id']."',
        field_data = '".$this->db->escape($data['field_data'])."',
        price = '".(float)$data['price']."',
        shipping_country_id = '".(int)$data['shipping_country_id']."',
        shipping_zone_id = '".(int)$data['shipping_zone_id']."',
        payment_country_id = '".(int)$data['payment_country_id']."',
        payment_zone_id = '".(int)$data['payment_zone_id']."',
        default_country_id = '".(int)$data['default_country_id']."',
        default_zone_id = '".(int)$data['default_zone_id']."',
        tax_default = '".$this->db->escape($data['tax_default'])."',
        currency_code = '".$this->db->escape($data['currency_code'])."',
        currency_value = '".(float)$data['currency_value']."',
        ip = '".$this->db->escape($data['ip'])."',
        email = '".$this->db->escape($data['email'])."',
        telephone = '".$this->db->escape($data['telephone'])."',
        token = '".$this->db->escape($data['token'])."',
        referer = '".$this->db->escape($data['referer'])."',
        user_agent = '".$this->db->escape($data['user_agent'])."',
        accept_language = '".$this->db->escape($data['accept_language'])."',
        user_language_id = '".(int)$data['user_language_id']."',
        user_currency_id = '".(int)$data['user_currency_id']."',
        user_customer_group_id = '".(int)$data['user_customer_group_id']."',
        store_name = '".$this->db->escape($data['store_name'])."',
        store_url = '".$this->db->escape($data['store_url'])."',
        store_id = '".(int)$data['store_id']."',
        status = '".(int)$data['status']."',
        record_type = '".(int)$data['record_type']."',
        date_added = '".$this->db->escape($data['date_added'])."',
        date_notified = '".$this->db->escape($data['date_notified'])."'
    ");
  }

  public function importEmailTemplate($data) {
    $this->db->query("
      INSERT INTO ".DB_PREFIX.$this->_code."_email_template
      SET
        template_id = '".(int)$data['template_id']."',
        system_name = '".$this->db->escape($data['system_name'])."',
        assignment = '".(int)$data['assignment']."',
        related_product_status = '".(int)$data['related_product_status']."',
        related_limit = '".(int)$data['related_limit']."',
        related_show_image = '".(int)$data['related_show_image']."',
        related_image_width = '".(int)$data['related_image_width']."',
        related_image_height = '".(int)$data['related_image_height']."',
        related_show_price = '".(int)$data['related_show_price']."',
        related_show_name = '".(int)$data['related_show_name']."',
        related_show_description = '".(int)$data['related_show_description']."',
        related_description_limit = '".(int)$data['related_description_limit']."',
        related_randomize = '".(int)$data['related_randomize']."',
        main_show_image = '".(int)$data['main_show_image']."',
        main_image_width = '".(int)$data['main_image_width']."',
        main_image_height = '".(int)$data['main_image_height']."',
        main_show_price = '".(int)$data['main_show_price']."',
        main_show_name = '".(int)$data['main_show_name']."',
        main_show_description = '".(int)$data['main_show_description']."',
        main_description_limit = '".(int)$data['main_description_limit']."',
        status = '".(int)$data['status']."',
        date_added = '".$this->db->escape($data['date_added'])."',
        date_modified = '".$this->db->escape($data['date_modified'])."'
    ");

    foreach ($data['template_description'] as $language_id => $value) {
      $this->db->query("
        INSERT INTO ".DB_PREFIX.$this->_code."_email_template_description 
        SET 
          template_id = '".(int)$data['template_id']."', 
          language_id = '".(int)$language_id."', 
          subject = '".$this->db->escape($value['subject'])."', 
          template = '".$this->db->escape($value['template'])."'
      ");
    }

    if (isset($data['product_related'])) {
      foreach ($data['product_related'] as $product_id) {
        $this->db->query("DELETE FROM ".DB_PREFIX.$this->_code."_email_template_related_product WHERE template_id = '".(int)$data['template_id']."' AND product_id = '".(int)$product_id."'");
        $this->db->query("INSERT INTO ".DB_PREFIX.$this->_code."_email_template_related_product SET template_id = '".(int)$data['template_id']."', product_id = '".(int)$product_id."'");
      }
    }

    if (isset($data['category_related'])) {
      foreach ($data['category_related'] as $category_id) {
        $this->db->query("DELETE FROM ".DB_PREFIX.$this->_code."_email_template_related_category WHERE template_id = '".(int)$data['template_id']."' AND category_id = '".(int)$category_id."'");
        $this->db->query("INSERT INTO ".DB_PREFIX.$this->_code."_email_template_related_category SET template_id = '".(int)$data['template_id']."', category_id = '".(int)$category_id."'");
      }
    }

    if (isset($data['manufacturer_related'])) {
      foreach ($data['manufacturer_related'] as $manufacturer_id) {
        $this->db->query("DELETE FROM ".DB_PREFIX.$this->_code."_email_template_related_manufacturer WHERE template_id = '".(int)$data['template_id']."' AND manufacturer_id = '".(int)$manufacturer_id."'");
        $this->db->query("INSERT INTO ".DB_PREFIX.$this->_code."_email_template_related_manufacturer SET template_id = '".(int)$data['template_id']."', manufacturer_id = '".(int)$manufacturer_id."'");
      }
    }
  }

  public function importSmsTemplate($data) {
    $this->db->query("
      INSERT INTO ".DB_PREFIX.$this->_code."_sms_template
      SET
        template_id = '".(int)$data['template_id']."',
        system_name = '".$this->db->escape($data['system_name'])."',
        assignment = '".(int)$data['assignment']."',
        status = '".(int)$data['status']."',
        date_added = '".$this->db->escape($data['date_added'])."',
        date_modified = '".$this->db->escape($data['date_modified'])."'
    ");

    foreach ($data['template_description'] as $language_id => $value) {
      $this->db->query("
        INSERT INTO ".DB_PREFIX.$this->_code."_sms_template_description 
        SET 
          template_id = '".(int)$data['template_id']."', 
          language_id = '".(int)$language_id."', 
          template = '".$this->db->escape($value['template'])."'
      ");
    }
  }

  public function deleteField($data) {
    $this->db->query("DELETE FROM ".DB_PREFIX.$this->_code."_field WHERE field_id = '".(int)$data['field_id']."'");
    $this->db->query("DELETE FROM ".DB_PREFIX.$this->_code."_field_description WHERE field_id = '".(int)$data['field_id']."'");

    return true;
  }

  public function deleteFields() {
    $query = $this->db->query("SELECT field_id FROM ".DB_PREFIX.$this->_code."_field")->rows;

    if ($query) {
      foreach ($query as $row) {
        $this->db->query("DELETE FROM ".DB_PREFIX.$this->_code."_field WHERE field_id = '".(int)$row['field_id']."'");
        $this->db->query("DELETE FROM ".DB_PREFIX.$this->_code."_field_description WHERE field_id = '".(int)$row['field_id']."'");
      }

      return true;
    } else {
      return false;
    }
  }

  public function deleteRecord($data) {
    $this->db->query("DELETE FROM ".DB_PREFIX.$this->_code."_record WHERE record_id = '".(int)$data['record_id']."'");

    return true;
  }

  public function deleteRecords() {
    $query = $this->db->query("SELECT record_id FROM ".DB_PREFIX.$this->_code."_record")->rows;

    if ($query) {
      foreach ($query as $row) {
        $this->db->query("DELETE FROM ".DB_PREFIX.$this->_code."_record WHERE record_id = '".(int)$row['record_id']."'");
      }

      return true;
    } else {
      return false;
    }
  }

  public function deleteBanned($data) {
    $this->db->query("DELETE FROM ".DB_PREFIX.$this->_code."_banned WHERE banned_id = '".(int)$data['banned_id']."'");

    return true;
  }

  public function deleteBanneds() {
    $query = $this->db->query("SELECT banned_id FROM ".DB_PREFIX.$this->_code."_banned")->rows;

    if ($query) {
      foreach ($query as $row) {
        $this->db->query("DELETE FROM ".DB_PREFIX.$this->_code."_banned WHERE banned_id = '".(int)$row['banned_id']."'");
      }

      return true;
    } else {
      return false;
    }
  }

  public function deleteEmailTemplate($data) {
    $this->db->query("DELETE FROM ".DB_PREFIX.$this->_code."_email_template WHERE template_id = '".(int)$data['template_id']."'");
    $this->db->query("DELETE FROM ".DB_PREFIX.$this->_code."_email_template_description WHERE template_id = '".(int)$data['template_id']."'");
    $this->db->query("DELETE FROM ".DB_PREFIX.$this->_code."_email_template_related_product WHERE template_id = '".(int)$data['template_id']."'");
    $this->db->query("DELETE FROM ".DB_PREFIX.$this->_code."_email_template_related_category WHERE template_id = '".(int)$data['template_id']."'");
    $this->db->query("DELETE FROM ".DB_PREFIX.$this->_code."_email_template_related_manufacturer WHERE template_id = '".(int)$data['template_id']."'");

    return true;
  }

  public function deleteEmailTemplates() {
    $query = $this->db->query("SELECT template_id FROM ".DB_PREFIX.$this->_code."_email_template")->rows;

    if ($query) {
      foreach ($query as $row) {
        $this->db->query("DELETE FROM ".DB_PREFIX.$this->_code."_email_template WHERE template_id = '".(int)$row['template_id']."'");
        $this->db->query("DELETE FROM ".DB_PREFIX.$this->_code."_email_template_description WHERE template_id = '".(int)$row['template_id']."'");
        $this->db->query("DELETE FROM ".DB_PREFIX.$this->_code."_email_template_related_product WHERE template_id = '".(int)$row['template_id']."'");
        $this->db->query("DELETE FROM ".DB_PREFIX.$this->_code."_email_template_related_category WHERE template_id = '".(int)$row['template_id']."'");
        $this->db->query("DELETE FROM ".DB_PREFIX.$this->_code."_email_template_related_manufacturer WHERE template_id = '".(int)$row['template_id']."'");
      }

      return true;
    } else {
      return false;
    }
  }

  public function deleteSmsTemplate($data) {
    $this->db->query("DELETE FROM ".DB_PREFIX.$this->_code."_sms_template WHERE template_id = '".(int)$data['template_id']."'");
    $this->db->query("DELETE FROM ".DB_PREFIX.$this->_code."_sms_template_description WHERE template_id = '".(int)$data['template_id']."'");

    return true;
  }

  public function deleteSmsTemplates() {
    $query = $this->db->query("SELECT template_id FROM ".DB_PREFIX.$this->_code."_sms_template")->rows;

    if ($query) {
      foreach ($query as $row) {
        $this->db->query("DELETE FROM ".DB_PREFIX.$this->_code."_sms_template WHERE template_id = '".(int)$row['template_id']."'");
        $this->db->query("DELETE FROM ".DB_PREFIX.$this->_code."_sms_template_description WHERE template_id = '".(int)$row['template_id']."'");
      }

      return true;
    } else {
      return false;
    }
  }

  public function copyField($data) {
    $query = $this->db->query("
      SELECT 
        DISTINCT * 
      FROM ".DB_PREFIX.$this->_code."_field f 
      LEFT JOIN ".DB_PREFIX.$this->_code."_field_description fd ON (f.field_id = fd.field_id) 
      WHERE 
        f.field_id = '".(int)$data['field_id']."' 
      AND 
        fd.language_id = '".(int)$this->config->get('config_language_id')."'
    ");

    if ($query->num_rows) {
      $data = [];

      $data = $query->row;

      $data['status'] = '0';

      $data = array_merge($data,['field_description' => $this->getFieldDescription($data['field_id'])]);

      $this->addField($data);

      return true;
    } else {
      return false;
    }
  }

  public function copyFields() {
    $query = $this->db->query("
      SELECT 
        DISTINCT * 
      FROM ".DB_PREFIX.$this->_code."_field
    ")->rows;

    if ($query) {
      foreach ($query as $row) {
        $data = [];

        $data = $row;

        $data['status'] = '0';

        $data = array_merge($data,['field_description' => $this->getFieldDescription($row['field_id'])]);

        $this->addField($data);
      }

      return true;
    } else {
      return false;
    }
  }

  public function copyBanned($data) {
    $query = $this->db->query("
      SELECT DISTINCT *
      FROM ".DB_PREFIX.$this->_code."_banned b
      WHERE
        b.banned_id = '".(int)$data['banned_id']."'
    ");

    if ($query->num_rows) {
      $data = $query->row;

      $data['status'] = '0';

      $this->addBanned($data);

      return true;
    } else {
      return false;
    }
  }

  public function copyBanneds() {
    $query = $this->db->query("
      SELECT 
        DISTINCT *
      FROM ".DB_PREFIX.$this->_code."_banned
    ")->rows;

    if ($query) {
      foreach ($query as $row) {
        $data = $row;

        $data['status'] = '0';

        $this->addBanned($data);
      }

      return true;
    } else {
      return false;
    }
  }

  public function copyEmailTemplate($data) {
    $query = $this->db->query("
      SELECT
        DISTINCT *
      FROM ".DB_PREFIX.$this->_code."_email_template et
      WHERE
        et.template_id = '".(int)$data['template_id']."'
    ");

    if ($query->num_rows) {
      $data = $query->row;

      $data['status'] = '0';

      $data = array_merge($data,['template_description' => $this->getEmailTemplateDescription($data['template_id'])]);
      $data = array_merge($data,['product_related' => $this->getEmailTemplateRelatedProduct($data['template_id'])]);
      $data = array_merge($data,['category_related' => $this->getEmailTemplateRelatedCategory($data['template_id'])]);
      $data = array_merge($data,['manufacturer_related' => $this->getEmailTemplateRelatedManufacturer($data['template_id'])]);

      $this->addEmailTemplate($data);

      return true;
    } else {
      return false;
    }
  }

  public function copyEmailTemplates() {
    $query = $this->db->query("
      SELECT
        DISTINCT *
      FROM ".DB_PREFIX.$this->_code."_email_template
    ")->rows;

    if ($query) {
      foreach ($query as $row) {
        $data = $row;

        $data['status'] = '0';

        $data = array_merge($data,['template_description' => $this->getEmailTemplateDescription($row['template_id'])]);
        $data = array_merge($data,['product_related' => $this->getEmailTemplateRelatedProduct($row['template_id'])]);
        $data = array_merge($data,['category_related' => $this->getEmailTemplateRelatedCategory($row['template_id'])]);
        $data = array_merge($data,['manufacturer_related' => $this->getEmailTemplateRelatedManufacturer($row['template_id'])]);

        $this->addEmailTemplate($data);
      }

      return true;
    } else {
      return false;
    }
  }

  public function copySmsTemplate($data) {
    $query = $this->db->query("
      SELECT
        DISTINCT *
      FROM ".DB_PREFIX.$this->_code."_sms_template et
      WHERE
        et.template_id = '".(int)$data['template_id']."'
    ");

    if ($query->num_rows) {
      $data = $query->row;

      $data['status'] = '0';

      $data['template_description'] = $this->getSmsTemplateDescription($data['template_id']);

      $this->addSmsTemplate($data);

      return true;
    } else {
      return false;
    }
  }

  public function copySmsTemplates() {
    $query = $this->db->query("
      SELECT
        DISTINCT *
      FROM ".DB_PREFIX.$this->_code."_sms_template
    ")->rows;

    if ($query) {
      foreach ($query as $row) {
        $data = $row;

        $data['status'] = '0';

        $data['template_description'] = $this->getSmsTemplateDescription($row['template_id']);

        $this->addSmsTemplate($data);
      }

      return true;
    } else {
      return false;
    }
  }

  public function getEmailTemplateRelatedProduct($template_id) {
    $results = [];

    $query = $this->db->query("SELECT * FROM ".DB_PREFIX.$this->_code."_email_template_related_product WHERE template_id = '".(int)$template_id."'")->rows;

    if ($query) {
      foreach ($query as $row) {
        $results[] = $row['product_id'];
      }
    }

    return $results;
  }

  public function getEmailTemplateRelatedCategory($template_id) {
    $results = [];

    $query = $this->db->query("SELECT * FROM ".DB_PREFIX.$this->_code."_email_template_related_category WHERE template_id = '".(int)$template_id."'")->rows;

    if ($query) {
      foreach ($query as $row) {
        $results[] = $row['category_id'];
      }
    }

    return $results;
  }

  public function getEmailTemplateRelatedManufacturer($template_id) {
    $results = [];

    $query = $this->db->query("SELECT * FROM ".DB_PREFIX.$this->_code."_email_template_related_manufacturer WHERE template_id = '".(int)$template_id."'")->rows;

    if ($query) {
      foreach ($query as $row) {
        $results[] = $row['manufacturer_id'];
      }
    }

    return $results;
  }

  private function getEmailTemplateDescription($template_id) {
    $results = [];

    $query = $this->db->query("SELECT * FROM ".DB_PREFIX.$this->_code."_email_template_description WHERE template_id = '".(int)$template_id."'")->rows;

    if ($query) {
      foreach ($query as $row) {
        $results[$row['language_id']] = [
          'subject'  => $row['subject'],
          'template' => $row['template']
        ];
      }
    }

    return $results;
  }

  private function getSmsTemplateDescription($template_id) {
    $results = [];

    $query = $this->db->query("SELECT * FROM ".DB_PREFIX.$this->_code."_sms_template_description WHERE template_id = '".(int)$template_id."'")->rows;

    if ($query) {
      foreach ($query as $row) {
        $results[$row['language_id']] = [
          'template' => $row['template']
        ];
      }
    }

    return $results;
  }

  private function getFieldDescription($field_id) {
    $results = [];

    $query = $this->db->query("SELECT * FROM ".DB_PREFIX.$this->_code."_field_description WHERE field_id = '".(int)$field_id."'")->rows;

    if ($query) {
      foreach ($query as $row) {
        $results[$row['language_id']] = [
          'name'        => $row['name'],
          'description' => $row['description'],
          'error_text'  => $row['error_text'],
          'placeholder' => $row['placeholder']
        ];
      }
    }

    return $results;
  }
}

?>