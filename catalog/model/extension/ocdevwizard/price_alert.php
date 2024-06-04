<?php
##=================================================##
## @author    : OCdevWizard                        ##
## @contact   : ocdevwizard@gmail.com              ##
## @support   : http://help.ocdevwizard.com        ##
## @copyright : (c) OCdevWizard. Price Alert, 2018 ##
##=================================================##
class ModelExtensionOcdevwizardPriceAlert extends Model {
  private $_name      = 'price_alert';
  private $_code      = 'ocdw_price_alert';
  private $_while_max = 100;

  public function addRecord($data) {
    $email = $telephone = '';

    if (isset($data['field_data']) && $data['field_data']) {
      foreach ($data['field_data'] as $field) {
        if ($field['type'] == 'email') {
          $email = $field['value'];
        }

        if ($field['type'] == 'telephone') {
          $telephone = $field['value'];
        }
      }
    }

    $this->db->query("
      INSERT INTO ".DB_PREFIX.$this->_code."_record
      SET
        product_id = '".(int)$data['product_id']."',
        customer_id = '".(int)$data['customer_id']."',
        product_option_id = '".(int)$data['product_option_id']."',
        product_option_value_id = '".(int)$data['product_option_value_id']."',
        option_id = '".(int)$data['option_id']."',
        option_value_id = '".(int)$data['option_value_id']."',
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
        record_type = '".(int)$data['record_type']."',
        field_data = '".$this->db->escape(serialize($data['field_data']))."',
        email = '".$this->db->escape(($email) ? $email : '')."',
        telephone = '".$this->db->escape(($telephone) ? $telephone : '')."',
        token = '".$this->db->escape($data['token'])."',
        ip = '".$this->db->escape($data['ip'])."',
        referer = '".$this->db->escape($data['referer'])."',
        user_agent = '".$this->db->escape($data['user_agent'])."',
        accept_language = '".$this->db->escape($data['accept_language'])."',
        user_language_id = '".(int)$data['user_language_id']."',
        user_currency_id = '".(int)$data['user_currency_id']."',
        user_customer_group_id = '".(int)$data['user_customer_group_id']."',
        store_name = '".$this->db->escape($data['store_name'])."',
        store_url = '".$this->db->escape($data['store_url'])."',
        store_id = '".(int)$data['store_id']."',
        date_added = NOW()
    ");

    $record_id = $this->db->getLastId();

    $data['record_id'] = $record_id;

    if ($data['record_type'] == 1) {
      $this->mailing($data,['to_admin_on_new_record_product','to_user_on_new_record_product']);
    } else if ($data['record_type'] == 2) {
      $this->mailing($data,['to_admin_on_new_record_product_option','to_user_on_new_record_product_option']);
    }
  }

  public function getField($field_id) {
    $query = $this->db->query("SELECT * FROM ".DB_PREFIX.$this->_code."_field f LEFT JOIN ".DB_PREFIX.$this->_code."_field_description fd ON (f.field_id = fd.field_id) WHERE f.field_id = '".(int)$field_id."' AND f.status = '1' AND fd.language_id = '".(int)$this->config->get('config_language_id')."'");

    if ($query->num_rows) {
      return [
        'field_id'           => $query->row['field_id'],
        'name'               => $query->row['name'],
        'description'        => $query->row['description'],
        'placeholder'        => $query->row['placeholder'],
        'error_text'         => $query->row['error_text'],
        'field_type'         => $query->row['field_type'],
        'validation_type'    => $query->row['validation_type'],
        'min_length_rule'    => $query->row['min_length_rule'],
        'max_length_rule'    => $query->row['max_length_rule'],
        'regex_rule'         => $query->row['regex_rule'],
        'field_mask'         => $query->row['field_mask'],
        'icon'               => $query->row['icon'],
        'css_id'             => $query->row['css_id'],
        'css_class'          => $query->row['css_class'],
        'title_status'       => $query->row['title_status'],
        'placeholder_status' => $query->row['placeholder_status'],
        'description_status' => $query->row['description_status'],
        'sort_order'         => $query->row['sort_order']
      ];
    } else {
      return false;
    }
  }

  public function getProductId($data = []) {
    $sql = "SELECT DISTINCT p.product_id";

    if (isset($data['filter_sub_category']) && !empty($data['filter_sub_category'])) {
      $sql .= " FROM ".DB_PREFIX."category_path cp LEFT JOIN ".DB_PREFIX."product_to_category p2c ON (cp.category_id = p2c.category_id)";
    } else {
      $sql .= " FROM ".DB_PREFIX."product_to_category p2c";
    }

    $sql .= " LEFT JOIN ".DB_PREFIX."product p ON (p2c.product_id = p.product_id)";

    $sql .= " LEFT JOIN ".DB_PREFIX."product_description pd ON (p.product_id = pd.product_id) LEFT JOIN ".DB_PREFIX."product_to_store p2s ON (p.product_id = p2s.product_id) WHERE pd.language_id = '".(int)$this->config->get('config_language_id')."' AND p.status = '1' AND p.quantity > '0' AND p.date_available <= NOW() AND p2s.store_id = '".(int)$this->config->get('config_store_id')."'";

    if (isset($data['filter_category_id']) && !empty($data['filter_category_id'])) {
      if (isset($data['filter_sub_category']) && !empty($data['filter_sub_category'])) {
        $sql .= " AND cp.path_id IN (".implode(',',$data['filter_category_id']).")";
      } else {
        $sql .= " AND p2c.category_id IN (".implode(',',$data['filter_category_id']).")";
      }
    }

    if (isset($data['filter_manufacturer_id']) && !empty($data['filter_manufacturer_id'])) {
      $sql .= " AND p.manufacturer_id IN (".implode(',',$data['filter_manufacturer_id']).")";
    }

    if (isset($data['filter_product_id']) && !empty($data['filter_product_id'])) {
      $sql .= " AND p.product_id IN (".implode(',',$data['filter_product_id']).")";
    }

    $query = $this->db->query($sql);

    return $query->rows;
  }

  public function getEmailTemplate($template_id,$language_id = 0) {
    $sql = "SELECT DISTINCT * FROM ".DB_PREFIX.$this->_code."_email_template et";

    if ($language_id) {
      $sql .= " LEFT JOIN ".DB_PREFIX.$this->_code."_email_template_description etd ON (et.template_id = etd.template_id)";
    }

    $sql .= " WHERE et.template_id = '".(int)$template_id."'";

    if ($language_id) {
      $sql .= " AND etd.language_id = '".(int)$language_id."'";
    }

    return $this->db->query($sql)->row;
  }

  public function getEmailTemplateDescription($template_id) {
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

  public function getSmsTemplateDescription($template_id) {
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

  public function getRecordFieldData($record_id) {
    $results = '';

    $query = $this->db->query("SELECT field_data FROM ".DB_PREFIX.$this->_code."_record WHERE record_id = '".(int)$record_id."'");

    if ($query->num_rows) {
      if ($query->row['field_data']) {
        $results = unserialize($query->row['field_data']);
      }
    }

    return $results;
  }

  public function checkBannedByEmail($email,$ip) {
    $sql = "SELECT DISTINCT * FROM ".DB_PREFIX.$this->_code."_banned WHERE (";

    if ($email) {
      $sql .= "LCASE(email) = '".$this->db->escape(utf8_strtolower($email))."' OR ";
    }

    $sql .= "ip = '".$this->db->escape($ip)."') AND status = '1'";

    $query = $this->db->query($sql)->row;

    if ($query) {
      return true;
    } else {
      return false;
    }
  }

  public function checkBannedByTelephone($telephone,$ip) {
    $sql = "SELECT DISTINCT * FROM ".DB_PREFIX.$this->_code."_banned WHERE (";

    if ($telephone) {
      $sql .= "LCASE(telephone) = '".$this->db->escape(utf8_strtolower($telephone))."' OR ";
    }

    $sql .= "ip = '".$this->db->escape($ip)."') AND status = '1'";

    $query = $this->db->query($sql)->row;

    if ($query) {
      return true;
    } else {
      return false;
    }
  }

  public function checkNotifyByEmail($data) {
    if ($data['record_type'] == 1) {
      $query = $this->db->query("SELECT * FROM ".DB_PREFIX.$this->_code."_record WHERE product_id = '".(int)$data['product_id']."' AND LCASE(email) = '".$this->db->escape(utf8_strtolower($data['email']))."' AND customer_id = '".(int)$data['customer_id']."' AND record_type = '".(int)$data['record_type']."'")->row;
    } else if ($data['record_type'] == 2) {
      $query = $this->db->query("SELECT * FROM ".DB_PREFIX.$this->_code."_record WHERE product_id = '".(int)$data['product_id']."' AND LCASE(email) = '".$this->db->escape(utf8_strtolower($data['email']))."' AND customer_id = '".(int)$data['customer_id']."' AND record_type = '".(int)$data['record_type']."' AND product_option_id = '".(int)$data['product_option_id']."' AND product_option_value_id  = '".(int)$data['product_option_value_id']."'")->row;
    }

    if ($query) {
      return true;
    } else {
      return false;
    }
  }

  public function checkNotifyByTelephone($data) {
    if ($data['record_type'] == 1) {
      $query = $this->db->query("SELECT * FROM ".DB_PREFIX.$this->_code."_record WHERE product_id = '".(int)$data['product_id']."' AND telephone = '".$this->db->escape($data['telephone'])."' AND customer_id = '".(int)$data['customer_id']."' AND record_type = '".(int)$data['record_type']."'")->row;
    } else if ($data['record_type'] == 2) {
      $query = $this->db->query("SELECT * FROM ".DB_PREFIX.$this->_code."_record WHERE product_id = '".(int)$data['product_id']."' AND telephone = '".$this->db->escape($data['telephone'])."' AND customer_id = '".(int)$data['customer_id']."' AND record_type = '".(int)$data['record_type']."' AND product_option_id = '".(int)$data['product_option_id']."' AND product_option_value_id  = '".(int)$data['product_option_value_id']."'")->row;
    }

    if ($query) {
      return true;
    } else {
      return false;
    }
  }

  public function getLanguageIdByCode($code) {
    return $this->db->query("SELECT language_id FROM ".DB_PREFIX."language WHERE code = '".$this->db->escape($code)."'")->row['language_id'];
  }

  public function getCurrencyIdByCode($code) {
    return $this->db->query("SELECT currency_id FROM ".DB_PREFIX."currency WHERE code = '".$this->db->escape($code)."'")->row['currency_id'];
  }

  public function getCurrencyById($currency_id) {
    return $this->db->query("SELECT * FROM ".DB_PREFIX."currency WHERE currency_id = '".(int)$currency_id."'")->row;
  }

  public function getStore($store_id) {
    return $this->db->query("SELECT DISTINCT * FROM ".DB_PREFIX."store WHERE store_id = '".(int)$store_id."'")->row;
  }

  public function getConfigRelatedProduct($store_id) {
    $results = [];

    $query = $this->db->query("SELECT * FROM ".DB_PREFIX.$this->_code."_config_related_product WHERE store_id = '".(int)$store_id."'")->rows;

    if ($query) {
      foreach ($query as $row) {
        $results[] = $row['product_id'];
      }
    }

    return $results;
  }

  public function getConfigRelatedCategory($store_id) {
    $results = [];

    $query = $this->db->query("SELECT * FROM ".DB_PREFIX.$this->_code."_config_related_category WHERE store_id = '".(int)$store_id."'")->rows;

    if ($query) {
      foreach ($query as $row) {
        $results[] = $row['category_id'];
      }
    }

    return $results;
  }

  public function getConfigRelatedManufacturer($store_id) {
    $results = [];

    $query = $this->db->query("SELECT * FROM ".DB_PREFIX.$this->_code."_config_related_manufacturer WHERE store_id = '".(int)$store_id."'")->rows;

    if ($query) {
      foreach ($query as $row) {
        $results[] = $row['manufacturer_id'];
      }
    }

    return $results;
  }

  public function getConfigRelatedOption($store_id) {
    $results = [];

    $query = $this->db->query("SELECT * FROM ".DB_PREFIX.$this->_code."_config_related_option WHERE store_id = '".(int)$store_id."'")->rows;

    if ($query) {
      foreach ($query as $row) {
        $results[] = $row['option_id'];
      }
    }

    return $results;
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

  public function getRecordByToken($token) {
    $query = $this->db->query("SELECT DISTINCT token FROM  ".DB_PREFIX.$this->_code."_record WHERE token = '".$this->db->escape($token)."'");

    if ($query->num_rows) {
      return $query->row['token'];
    } else {
      return false;
    }
  }

  public function getRecordForCron($type) {
    if ($type == 1) {
      $query = $this->db->query("
        SELECT 
          r.record_id, 
          r.product_id, 
          r.email,
          r.telephone,
          r.ip,
          r.record_type,
          r.status,
          r.price,
          r.shipping_country_id,
          r.shipping_zone_id,
          r.payment_country_id,
          r.payment_zone_id,
          r.default_country_id,
          r.default_zone_id,
          r.tax_default,
          r.user_customer_group_id,
          p.price as product_price,
          p.tax_class_id,
          (SELECT price FROM ".DB_PREFIX."product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = r.user_customer_group_id AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS product_discount,
          (SELECT price FROM ".DB_PREFIX."product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = r.user_customer_group_id AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS product_special
        FROM ".DB_PREFIX.$this->_code."_record r 
        LEFT JOIN ".DB_PREFIX."product p ON (r.product_id = p.product_id) 
        WHERE p.status = '1'
      ");

      $results = [];

      if ($query->num_rows) {
        foreach ($query->rows as $row) {
          $results[] = [
            'record_id'              => $row['record_id'],
            'product_id'             => $row['product_id'],
            'shipping_country_id'    => $row['shipping_country_id'],
            'shipping_zone_id'       => $row['shipping_zone_id'],
            'payment_country_id'     => $row['payment_country_id'],
            'payment_zone_id'        => $row['payment_zone_id'],
            'default_country_id'     => $row['default_country_id'],
            'default_zone_id'        => $row['default_zone_id'],
            'tax_default'            => $row['tax_default'],
            'user_customer_group_id' => $row['user_customer_group_id'],
            'price'                  => $row['price'],
            'product_price'          => ($row['product_discount'] ? $row['product_discount'] : $row['product_price']),
            'product_special'        => $row['product_special'],
            'status'                 => $row['status'],
            'record_type'            => $row['record_type'],
            'tax_class_id'           => $row['tax_class_id'],
            'banned_status'          => $this->checkBanned($row['email'],$row['telephone'],$row['ip'])
          ];
        }
      }

      return $results;
    } else if ($type == 2) {
      $query = $this->db->query("
        SELECT DISTINCT
          r.record_id, 
          r.product_id, 
          r.email,
          r.telephone,
          r.ip,
          r.record_type,
          r.status,
          r.price,
          r.shipping_country_id,
          r.shipping_zone_id,
          r.payment_country_id,
          r.payment_zone_id,
          r.default_country_id,
          r.default_zone_id,
          r.tax_default,
          r.user_customer_group_id,
          p.tax_class_id,
          pov.price as option_price
        FROM ".DB_PREFIX."option o 
        LEFT JOIN ".DB_PREFIX."product_option_value pov ON (o.option_id = pov.option_id) 
        LEFT JOIN ".DB_PREFIX.$this->_code."_record r ON (pov.product_option_id = r.product_option_id) 
        LEFT JOIN ".DB_PREFIX."product p ON (r.product_id = p.product_id) 
        WHERE p.status = '1'
          AND pov.product_option_id = r.product_option_id 
          AND pov.product_option_value_id = r.product_option_value_id
      ");

      $results = [];

      if ($query->num_rows) {
        foreach ($query->rows as $row) {
          $results[] = [
            'record_id'              => $row['record_id'],
            'product_id'             => $row['product_id'],
            'shipping_country_id'    => $row['shipping_country_id'],
            'shipping_zone_id'       => $row['shipping_zone_id'],
            'payment_country_id'     => $row['payment_country_id'],
            'payment_zone_id'        => $row['payment_zone_id'],
            'default_country_id'     => $row['default_country_id'],
            'default_zone_id'        => $row['default_zone_id'],
            'tax_default'            => $row['tax_default'],
            'user_customer_group_id' => $row['user_customer_group_id'],
            'price'                  => $row['price'],
            'option_price'           => $row['option_price'],
            'status'                 => $row['status'],
            'record_type'            => $row['record_type'],
            'tax_class_id'           => $row['tax_class_id'],
            'banned_status'          => $this->checkBanned($row['email'],$row['telephone'],$row['ip'])
          ];
        }
      }

      return $results;
    } else if ($type == 3) {
      $query = $this->db->query("
        SELECT DISTINCT 
          r.record_id 
        FROM ".DB_PREFIX.$this->_code."_record r 
        LEFT JOIN ".DB_PREFIX."product p ON (p.product_id = r.product_id) 
        WHERE p.product_id IS NULL
      ");

      $results = [];

      if ($query->num_rows) {
        foreach ($query->rows as $row) {
          $results[] = $row['record_id'];
        }
      }

      $query = $this->db->query("
        SELECT 
          r.product_id,
          r.product_option_id,
          r.product_option_value_id
        FROM ".DB_PREFIX.$this->_code."_record r 
        LEFT JOIN ".DB_PREFIX."product_option_value pov ON (pov.product_id = r.product_id)
        WHERE r.record_type = '2'
      ");

      if ($query->num_rows) {
        foreach ($query->rows as $row) {
          $query_inner = $this->db->query("
            SELECT 
              r.record_id
            FROM ".DB_PREFIX.$this->_code."_record r
            WHERE r.product_id = '".(int)$row['product_id']."'
              AND NOT EXISTS (
                SELECT 
                  *
                FROM ".DB_PREFIX."product_option_value
                WHERE product_id = '".(int)$row['product_id']."'
                  AND product_option_id = '".(int)$row['product_option_id']."' 
                  AND product_option_value_id = '".(int)$row['product_option_value_id']."'
              )
            GROUP BY r.product_id
          ");

          if ($query_inner->num_rows) {
            foreach ($query_inner->rows as $row_inner) {
              $results[] = $row_inner['record_id'];
            }
          }
        }
      }

      return $results;
    } else {
      return false;
    }
  }

  public function calculate_tax($data) {
    if ($data['tax_class_id'] && $data['calculate']) {
      $amount = 0;

      $tax_rates = $this->getTaxRates($data['record_info'],$data['value'],$data['tax_class_id']);

      foreach ($tax_rates as $tax_rate) {
        if ($data['calculate'] != 'P' && $data['calculate'] != 'F') {
          $amount += $tax_rate['amount'];
        } else if ($tax_rate['type'] == $data['calculate']) {
          $amount += $tax_rate['amount'];
        }
      }

      return $data['value'] + $amount;
    } else {
      return $data['value'];
    }
  }

  private function getTaxRates($record_info,$value,$tax_class_id) {
    $tax_rates = [];

    if ($record_info['shipping_country_id']) {
      $tax_query = $this->db->query("SELECT tr1.tax_class_id, tr2.tax_rate_id, tr2.rate, tr2.type FROM ".DB_PREFIX."tax_rule tr1 LEFT JOIN ".DB_PREFIX."tax_rate tr2 ON (tr1.tax_rate_id = tr2.tax_rate_id) INNER JOIN ".DB_PREFIX."tax_rate_to_customer_group tr2cg ON (tr2.tax_rate_id = tr2cg.tax_rate_id) LEFT JOIN ".DB_PREFIX."zone_to_geo_zone z2gz ON (tr2.geo_zone_id = z2gz.geo_zone_id) LEFT JOIN ".DB_PREFIX."geo_zone gz ON (tr2.geo_zone_id = gz.geo_zone_id) WHERE tr1.based = 'shipping' AND tr2cg.customer_group_id = '".(int)$record_info['user_customer_group_id']."' AND z2gz.country_id = '".(int)$record_info['shipping_country_id']."' AND (z2gz.zone_id = '0' OR z2gz.zone_id = '".(int)$record_info['shipping_zone_id']."') ORDER BY tr1.priority ASC");

      foreach ($tax_query->rows as $result) {
        $tax_rates[$result['tax_class_id']][$result['tax_rate_id']] = [
          'tax_rate_id' => $result['tax_rate_id'],
          'rate'        => $result['rate'],
          'type'        => $result['type']
        ];
      }
    } else if ($record_info['tax_default'] == 'shipping') {
      $tax_query = $this->db->query("SELECT tr1.tax_class_id, tr2.tax_rate_id, tr2.rate, tr2.type FROM ".DB_PREFIX."tax_rule tr1 LEFT JOIN ".DB_PREFIX."tax_rate tr2 ON (tr1.tax_rate_id = tr2.tax_rate_id) INNER JOIN ".DB_PREFIX."tax_rate_to_customer_group tr2cg ON (tr2.tax_rate_id = tr2cg.tax_rate_id) LEFT JOIN ".DB_PREFIX."zone_to_geo_zone z2gz ON (tr2.geo_zone_id = z2gz.geo_zone_id) LEFT JOIN ".DB_PREFIX."geo_zone gz ON (tr2.geo_zone_id = gz.geo_zone_id) WHERE tr1.based = 'shipping' AND tr2cg.customer_group_id = '".(int)$record_info['user_customer_group_id']."' AND z2gz.country_id = '".(int)$record_info['default_country_id']."' AND (z2gz.zone_id = '0' OR z2gz.zone_id = '".(int)$record_info['default_zone_id']."') ORDER BY tr1.priority ASC");

      foreach ($tax_query->rows as $result) {
        $tax_rates[$result['tax_class_id']][$result['tax_rate_id']] = [
          'tax_rate_id' => $result['tax_rate_id'],
          'rate'        => $result['rate'],
          'type'        => $result['type']
        ];
      }
    }

    if ($record_info['payment_country_id']) {
      $tax_query = $this->db->query("SELECT tr1.tax_class_id, tr2.tax_rate_id, tr2.rate, tr2.type FROM ".DB_PREFIX."tax_rule tr1 LEFT JOIN ".DB_PREFIX."tax_rate tr2 ON (tr1.tax_rate_id = tr2.tax_rate_id) INNER JOIN ".DB_PREFIX."tax_rate_to_customer_group tr2cg ON (tr2.tax_rate_id = tr2cg.tax_rate_id) LEFT JOIN ".DB_PREFIX."zone_to_geo_zone z2gz ON (tr2.geo_zone_id = z2gz.geo_zone_id) LEFT JOIN ".DB_PREFIX."geo_zone gz ON (tr2.geo_zone_id = gz.geo_zone_id) WHERE tr1.based = 'payment' AND tr2cg.customer_group_id = '".(int)$record_info['user_customer_group_id']."' AND z2gz.country_id = '".(int)$record_info['payment_country_id']."' AND (z2gz.zone_id = '0' OR z2gz.zone_id = '".(int)$record_info['payment_zone_id']."') ORDER BY tr1.priority ASC");

      foreach ($tax_query->rows as $result) {
        $tax_rates[$result['tax_class_id']][$result['tax_rate_id']] = [
          'tax_rate_id' => $result['tax_rate_id'],
          'rate'        => $result['rate'],
          'type'        => $result['type']
        ];
      }
    } else if ($record_info['tax_default'] == 'payment') {
      $tax_query = $this->db->query("SELECT tr1.tax_class_id, tr2.tax_rate_id, tr2.rate, tr2.type FROM ".DB_PREFIX."tax_rule tr1 LEFT JOIN ".DB_PREFIX."tax_rate tr2 ON (tr1.tax_rate_id = tr2.tax_rate_id) INNER JOIN ".DB_PREFIX."tax_rate_to_customer_group tr2cg ON (tr2.tax_rate_id = tr2cg.tax_rate_id) LEFT JOIN ".DB_PREFIX."zone_to_geo_zone z2gz ON (tr2.geo_zone_id = z2gz.geo_zone_id) LEFT JOIN ".DB_PREFIX."geo_zone gz ON (tr2.geo_zone_id = gz.geo_zone_id) WHERE tr1.based = 'payment' AND tr2cg.customer_group_id = '".(int)$record_info['user_customer_group_id']."' AND z2gz.country_id = '".(int)$record_info['default_country_id']."' AND (z2gz.zone_id = '0' OR z2gz.zone_id = '".(int)$record_info['default_zone_id']."') ORDER BY tr1.priority ASC");

      foreach ($tax_query->rows as $result) {
        $tax_rates[$result['tax_class_id']][$result['tax_rate_id']] = [
          'tax_rate_id' => $result['tax_rate_id'],
          'rate'        => $result['rate'],
          'type'        => $result['type']
        ];
      }
    }

    $tax_query = $this->db->query("SELECT tr1.tax_class_id, tr2.tax_rate_id, tr2.rate, tr2.type FROM ".DB_PREFIX."tax_rule tr1 LEFT JOIN ".DB_PREFIX."tax_rate tr2 ON (tr1.tax_rate_id = tr2.tax_rate_id) INNER JOIN ".DB_PREFIX."tax_rate_to_customer_group tr2cg ON (tr2.tax_rate_id = tr2cg.tax_rate_id) LEFT JOIN ".DB_PREFIX."zone_to_geo_zone z2gz ON (tr2.geo_zone_id = z2gz.geo_zone_id) LEFT JOIN ".DB_PREFIX."geo_zone gz ON (tr2.geo_zone_id = gz.geo_zone_id) WHERE tr1.based = 'store' AND tr2cg.customer_group_id = '".(int)$record_info['user_customer_group_id']."' AND z2gz.country_id = '".(int)$record_info['default_country_id']."' AND (z2gz.zone_id = '0' OR z2gz.zone_id = '".(int)$record_info['default_zone_id']."') ORDER BY tr1.priority ASC");

    foreach ($tax_query->rows as $result) {
      $tax_rates[$result['tax_class_id']][$result['tax_rate_id']] = [
        'tax_rate_id' => $result['tax_rate_id'],
        'rate'        => $result['rate'],
        'type'        => $result['type']
      ];
    }

    $tax_rate_data = [];

    if (isset($tax_rates[$tax_class_id])) {
      foreach ($tax_rates[$tax_class_id] as $tax_rate) {
        if (isset($tax_rate_data[$tax_rate['tax_rate_id']])) {
          $amount = $tax_rate_data[$tax_rate['tax_rate_id']]['amount'];
        } else {
          $amount = 0;
        }

        if ($tax_rate['type'] == 'F') {
          $amount += $tax_rate['rate'];
        } else if ($tax_rate['type'] == 'P') {
          $amount += ($value / 100 * $tax_rate['rate']);
        }

        $tax_rate_data[$tax_rate['tax_rate_id']] = [
          'tax_rate_id' => $tax_rate['tax_rate_id'],
          'rate'        => $tax_rate['rate'],
          'type'        => $tax_rate['type'],
          'amount'      => $amount
        ];
      }
    }

    return $tax_rate_data;
  }

  public function getRecords($data = []) {
    $sql = "SELECT DISTINCT * FROM ".DB_PREFIX.$this->_code."_record WHERE record_id IS NOT NULL AND customer_id = '".(int)$data['customer_id']."'";

    $sort_data = [
      'date_added'
    ];

    if (isset($data['sort']) && in_array($data['sort'],$sort_data)) {
      if ($data['sort'] == 'pd.name') {
        $sql .= " ORDER BY LCASE(".$data['sort'].")";
      } else {
        $sql .= " ORDER BY ".$data['sort'];
      }
    } else {
      $sql .= " ORDER BY date_added";
    }

    if (isset($data['order']) && ($data['order'] == 'DESC')) {
      $sql .= " DESC";
    } else {
      $sql .= " ASC";
    }

    if (isset($data['start']) || isset($data['limit'])) {
      if ($data['start'] < 0) {
        $data['start'] = 0;
      }

      if ($data['limit'] < 1) {
        $data['limit'] = 20;
      }

      $sql .= " LIMIT ".(int)$data['start'].",".(int)$data['limit'];
    }

    $query = $this->db->query($sql)->rows;

    $records = [];

    if ($query) {
      foreach ($query as $row) {
        $records[$row['record_id']] = $this->getRecord($row['record_id']);
      }
    }

    return $records;
  }

  public function getTotalRecords($data = []) {
    $sql = "SELECT COUNT(DISTINCT record_id) AS total FROM ".DB_PREFIX.$this->_code."_record WHERE record_id IS NOT NULL AND customer_id = '".(int)$data['customer_id']."'";

    return $this->db->query($sql)->row['total'];
  }

  public function unSubscribe($token) {
    $this->db->query("DELETE FROM ".DB_PREFIX.$this->_code."_record WHERE token = '".$this->db->escape($token)."'");
  }

  public function getProductForPage($product_id) {
    return $this->db->query("SELECT DISTINCT * FROM ".DB_PREFIX."product p LEFT JOIN ".DB_PREFIX."product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id = '".(int)$product_id."' AND pd.language_id = '".(int)$this->config->get('config_language_id')."' AND p.status = '1'")->row;
  }

  private function getRecord($record_id) {
    $query = $this->db->query("
      SELECT DISTINCT 
        *
      FROM ".DB_PREFIX.$this->_code."_record r 
      WHERE r.record_id = '".(int)$record_id."'
    ");

    if ($query->num_rows) {
      return [
        'record_id'               => $query->row['record_id'],
        'product_id'              => $query->row['product_id'],
        'email'                   => $query->row['email'],
        'telephone'               => $query->row['telephone'],
        'field_data'              => $query->row['field_data'],
        'price'                   => $query->row['price'],
        'product_option_id'       => $query->row['product_option_id'],
        'product_option_value_id' => $query->row['product_option_value_id'],
        'currency_code'           => $query->row['currency_code'],
        'currency_value'          => $query->row['currency_value'],
        'ip'                      => $query->row['ip'],
        'referer'                 => $query->row['referer'],
        'user_agent'              => $query->row['user_agent'],
        'accept_language'         => $query->row['accept_language'],
        'user_language_id'        => $query->row['user_language_id'],
        'user_currency_id'        => $query->row['user_currency_id'],
        'user_customer_group_id'  => $query->row['user_customer_group_id'],
        'store_url'               => $query->row['store_url'],
        'store_name'              => $query->row['store_name'],
        'store_id'                => $query->row['store_id'],
        'status'                  => $query->row['status'],
        'record_type'             => $query->row['record_type'],
        'token'                   => $query->row['token'],
        'date_added'              => $query->row['date_added'],
        'date_notified'           => $query->row['date_notified'],
        'banned_status'           => $this->checkBanned($query->row['email'],$query->row['telephone'],$query->row['ip'])
      ];
    } else {
      return false;
    }
  }

  private function checkBanned($email,$telephone,$ip) {
    $sql = "SELECT DISTINCT * FROM ".DB_PREFIX.$this->_code."_banned WHERE (";

    if ($email) {
      $sql .= "LCASE(email) = '".$this->db->escape(utf8_strtolower($email))."' OR ";
    }

    if ($telephone) {
      $sql .= "LCASE(telephone) = '".$this->db->escape(utf8_strtolower($telephone))."' OR ";
    }

    $sql .= "ip = '".$this->db->escape($ip)."') AND status = '1'";

    $query = $this->db->query($sql)->row;

    if ($query) {
      return true;
    } else {
      return false;
    }
  }

  private function getCouponById($coupon_id) {
    return $this->db->query("SELECT DISTINCT * FROM ".DB_PREFIX."coupon WHERE coupon_id = '".(int)$coupon_id."'")->row;
  }

  private function getVoucherById($voucher_id) {
    return $this->db->query("SELECT DISTINCT * FROM ".DB_PREFIX."voucher WHERE voucher_id = '".(int)$voucher_id."'")->row;
  }

  public function getProduct($product_id,$language_id,$store_id,$customer_group_id) {
    $query = $this->db->query("
      SELECT DISTINCT 
        p.product_id,
        p.quantity,
        p.stock_status_id,
        pd.name,
        p.image,
        pd.description,
        p.price,
        p.tax_class_id,
        (SELECT price FROM ".DB_PREFIX."product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '".(int)$customer_group_id."' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount,
        (SELECT price FROM ".DB_PREFIX."product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '".(int)$customer_group_id."' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special
      FROM ".DB_PREFIX."product p
      LEFT JOIN ".DB_PREFIX."product_description pd ON (p.product_id = pd.product_id)
      LEFT JOIN ".DB_PREFIX."product_to_store p2s ON (p.product_id = p2s.product_id)
      WHERE p.product_id = '".(int)$product_id."'
        AND pd.language_id = '".(int)$language_id."'
        AND p.status = '1'
        AND p.date_available <= NOW()
        AND p2s.store_id = '".(int)$store_id."'
    ");

    if ($query->num_rows) {
      return [
        'product_id'      => $query->row['product_id'],
        'name'            => $query->row['name'],
        'quantity'        => $query->row['quantity'],
        'stock_status_id' => $query->row['stock_status_id'],
        'description'     => $query->row['description'],
        'image'           => $query->row['image'],
        'price'           => ($query->row['discount'] ? $query->row['discount'] : $query->row['price']),
        'special'         => $query->row['special'],
        'tax_class_id'    => $query->row['tax_class_id']
      ];
    } else {
      return false;
    }
  }

  private function getRecordProduct($data) {
    $query = $this->db->query("
      SELECT DISTINCT
        p.product_id,
        p.quantity,
        p.stock_status_id,
        pd.name,
        p.image,
        pd.description,
        p.price,
        p.tax_class_id,
        (SELECT price FROM ".DB_PREFIX."product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '".(int)$data['user_customer_group_id']."' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount,
        (SELECT price FROM ".DB_PREFIX."product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '".(int)$data['user_customer_group_id']."' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special
      FROM ".DB_PREFIX."product p
      LEFT JOIN ".DB_PREFIX."product_description pd ON (p.product_id = pd.product_id)
      WHERE p.product_id = '".(int)$data['product_id']."'
        AND pd.language_id = '".(int)$data['user_language_id']."'
        AND p.status = '1'
        AND p.date_available <= NOW()
    ");

    if ($query->num_rows) {
      return [
        'product_id'      => $query->row['product_id'],
        'name'            => $query->row['name'],
        'quantity'        => $query->row['quantity'],
        'stock_status_id' => $query->row['stock_status_id'],
        'description'     => $query->row['description'],
        'image'           => $query->row['image'],
        'price'           => ($query->row['discount'] ? $query->row['discount'] : $query->row['price']),
        'special'         => $query->row['special'],
        'tax_class_id'    => $query->row['tax_class_id']
      ];
    } else {
      return false;
    }
  }

  private function getProductMarkup($product_info,$template_info,$record_info,$type = 'related') {
    if ($template_info && $product_info && $record_info) {
      $html_data = [];

      $models = ['tool/image'];

      foreach ($models as $model) {
        $this->load->model($model);
      }

      $html_data['products'] = [];

      $currency_info = $this->getCurrencyById($record_info['user_currency_id']);

      if ($currency_info) {
        $image = ($template_info[$type.'_show_image'] && $product_info['image']) ? $this->model_tool_image->resize($product_info['image'],$template_info[$type.'_image_width'],$template_info[$type.'_image_height']) : '';

        if ($template_info[$type.'_show_description']) {
          if (utf8_strlen($product_info['description']) > $template_info[$type.'_description_limit']) {
            $description = utf8_substr(strip_tags(html_entity_decode($product_info['description'],ENT_QUOTES,'UTF-8')),0,$template_info[$type.'_description_limit']).'...';
          } else {
            $description = strip_tags(html_entity_decode($product_info['description'],ENT_QUOTES,'UTF-8'));
          }
        } else {
          $description = '';
        }

        $special = false;
        $price   = false;

        if ($template_info[$type.'_show_price']) {
          $price = $this->currency->format($product_info['price'] + ($this->config->get('config_tax') ? $this->tax->getTax($product_info['price'],$product_info['tax_class_id']) : 0),$currency_info['code'],$currency_info['value']);

          if ((float)$product_info['special']) {
            $special = $this->currency->format($product_info['special'] + ($this->config->get('config_tax') ? $this->tax->getTax($product_info['special'],$product_info['tax_class_id']) : 0),$currency_info['code'],$currency_info['value']);
          } else {
            $special = false;
          }
        }

        if ($record_info['record_type'] == '2' && in_array($template_info['related_product_status'],[11,12,13])) {
          $option_filter_data = [
            'product_id'              => $product_info['product_id'],
            'user_language_id'        => $record_info['user_language_id'],
            'product_option_id'       => $record_info['product_option_id'],
            'product_option_value_id' => $record_info['product_option_value_id']
          ];

          $option_info = $this->getOptionForNotification($option_filter_data);
        } else {
          $option_info = '';
        }

        $name = ($template_info[$type.'_show_name']) ? $product_info['name'] : '';

        $html_data['products'][] = [
          'product_id'   => $product_info['product_id'],
          'name'         => $name,
          'description'  => $description,
          'option_name'  => ($option_info) ? $option_info['option_name'] : '',
          'option_value' => ($option_info) ? $option_info['option_value'] : '',
          'price'        => $price,
          'special'      => $special,
          'thumb'        => $image,
          'href'         => $record_info['store_url'].'index.php?route=product/product&product_id='.$product_info['product_id']
        ];
      }

      if (version_compare(VERSION,'2.1.0.2.1','<=')) {
        if (file_exists(DIR_TEMPLATE.$this->config->get('config_template').'/template/extension/ocdevwizard/'.$this->_name.'/product_markup.tpl')) {
          return $this->load->view($this->config->get('config_template').'/template/extension/ocdevwizard/'.$this->_name.'/product_markup.tpl',$html_data);
        } else {
          return $this->load->view('default/template/extension/ocdevwizard/'.$this->_name.'/product_markup.tpl',$html_data);
        }
      } else if (version_compare(VERSION,'3.0.0.0','>=')) {
        return $this->load->view('extension/ocdevwizard/'.$this->_name.'/product_markup',$html_data);
      } else {
        return $this->load->view('extension/ocdevwizard/'.$this->_name.'/product_markup.tpl',$html_data);
      }
    }
  }

  private function getProductMarkups($index,$template_info,$record_info,$product_info) {
    $product_data = [];

    // main_product
    if ($index == 0) {
      $main_product = '<div style="width: 100%;text-align: center;">';
      $main_product .= $this->getProductMarkup($product_info,$template_info,$record_info,'main');
      $main_product .= '</div>';

      $product_data[0] = $main_product;
    }

    // products_from_category
    if ($index == 1) {
      $filter_data = [
        'product_id'          => $product_info['product_id'],
        'filter_category_id'  => $this->getEmailTemplateRelatedCategory($template_info['template_id']),
        'filter_sub_category' => '1',
        'start'               => '0',
        'limit'               => $template_info['related_limit'],
        'language_id'         => $record_info['user_language_id'],
        'store_id'            => $record_info['store_id'],
        'customer_group_id'   => $record_info['user_customer_group_id'],
        'randomize'           => $template_info['related_randomize']
      ];

      $products = $this->getProductsFromCategories($filter_data);

      $products_from_category = '';

      if ($products) {
        $products_from_category .= '<div style="width: 100%;text-align: center;">';
        foreach ($products as $product) {
          $products_from_category .= $this->getProductMarkup($product,$template_info,$record_info);
        }
        $products_from_category .= '</div>';
      }

      $product_data[1] = $products_from_category;
    }

    // products_from_brand
    if ($index == 2) {
      $filter_data = [
        'product_id'             => $product_info['product_id'],
        'filter_manufacturer_id' => $this->getEmailTemplateRelatedManufacturer($template_info['template_id']),
        'start'                  => '0',
        'limit'                  => $template_info['related_limit'],
        'language_id'            => $record_info['user_language_id'],
        'store_id'               => $record_info['store_id'],
        'customer_group_id'      => $record_info['user_customer_group_id'],
        'randomize'              => $template_info['related_randomize']
      ];

      $products = $this->getProductsByMixedFilters($filter_data);

      $products_from_brand = '';

      if ($products) {
        $products_from_brand .= '<div style="width: 100%;text-align: center;">';
        foreach ($products as $product) {
          $products_from_brand .= $this->getProductMarkup($product,$template_info,$record_info);
        }
        $products_from_brand .= '</div>';
      }

      $product_data[2] = $products_from_brand;
    }

    // selected_products
    if ($index == 3) {
      $filter_data = [
        'product_id'        => $product_info['product_id'],
        'filter_product_id' => $this->getEmailTemplateRelatedProduct($template_info['template_id']),
        'start'             => '0',
        'limit'             => $template_info['related_limit'],
        'language_id'       => $record_info['user_language_id'],
        'store_id'          => $record_info['store_id'],
        'customer_group_id' => $record_info['user_customer_group_id'],
        'randomize'         => $template_info['related_randomize'],
        'sort'              => 'p.sort_order',
        'order'             => 'DESC'
      ];

      $products = $this->getProductsByMixedFilters($filter_data);

      $selected_products = '';

      if ($products) {
        $selected_products .= '<div style="width: 100%;text-align: center;">';
        foreach ($products as $product) {
          $selected_products .= $this->getProductMarkup($product,$template_info,$record_info);
        }
        $selected_products .= '</div>';
      }

      $product_data[3] = $selected_products;
    }

    // latest_products
    if ($index == 4) {
      $filter_data = [
        'product_id'        => $product_info['product_id'],
        'start'             => '0',
        'limit'             => $template_info['related_limit'],
        'language_id'       => $record_info['user_language_id'],
        'store_id'          => $record_info['store_id'],
        'customer_group_id' => $record_info['user_customer_group_id'],
        'randomize'         => $template_info['related_randomize'],
        'sort'              => 'p.date_added',
        'order'             => 'DESC'
      ];

      $products = $this->getProductsByMixedFilters($filter_data);

      $latest_products = '';

      if ($products) {
        $latest_products .= '<div style="width: 100%;text-align: center;">';
        foreach ($products as $product) {
          $latest_products .= $this->getProductMarkup($product,$template_info,$record_info);
        }
        $latest_products .= '</div>';
      }

      $product_data[4] = $latest_products;
    }

    // bestseller_products
    if ($index == 5) {
      $filter_data = [
        'product_id'        => $product_info['product_id'],
        'filter_bestseller' => '1',
        'start'             => '0',
        'limit'             => $template_info['related_limit'],
        'language_id'       => $record_info['user_language_id'],
        'store_id'          => $record_info['store_id'],
        'customer_group_id' => $record_info['user_customer_group_id'],
        'randomize'         => $template_info['related_randomize'],
        'sort'              => 'total',
        'order'             => 'DESC'
      ];

      $products = $this->getProductsByMixedFilters($filter_data);

      $bestseller_products = '';

      if ($products) {
        $bestseller_products .= '<div style="width: 100%;text-align: center;">';
        foreach ($products as $product) {
          $bestseller_products .= $this->getProductMarkup($product,$template_info,$record_info);
        }
        $bestseller_products .= '</div>';
      }

      $product_data[5] = $bestseller_products;
    }

    // special_products
    if ($index == 6) {
      $filter_data = [
        'product_id'        => $product_info['product_id'],
        'start'             => '0',
        'limit'             => $template_info['related_limit'],
        'language_id'       => $record_info['user_language_id'],
        'store_id'          => $record_info['store_id'],
        'customer_group_id' => $record_info['user_customer_group_id'],
        'randomize'         => $template_info['related_randomize']
      ];

      $products = $this->getSpecialProducts($filter_data);

      $special_products = '';

      if ($products) {
        $special_products .= '<div style="width: 100%;text-align: center;">';
        foreach ($products as $product) {
          $special_products .= $this->getProductMarkup($product,$template_info,$record_info);
        }
        $special_products .= '</div>';
      }

      $product_data[6] = $special_products;
    }

    // popular_products
    if ($index == 7) {
      $filter_data = [
        'product_id'        => $product_info['product_id'],
        'start'             => '0',
        'limit'             => $template_info['related_limit'],
        'language_id'       => $record_info['user_language_id'],
        'store_id'          => $record_info['store_id'],
        'customer_group_id' => $record_info['user_customer_group_id'],
        'randomize'         => $template_info['related_randomize'],
        'sort'              => 'p.viewed',
        'order'             => 'DESC'
      ];

      $products = $this->getProductsByMixedFilters($filter_data);

      $popular_products = '';

      if ($products) {
        $popular_products .= '<div style="width: 100%;text-align: center;">';
        foreach ($products as $product) {
          $popular_products .= $this->getProductMarkup($product,$template_info,$record_info);
        }
        $popular_products .= '</div>';
      }

      $product_data[7] = $popular_products;
    }

    // products_from_same_brand
    if ($index == 8) {
      $filter_data = [
        'product_id'        => $product_info['product_id'],
        'start'             => '0',
        'limit'             => $template_info['related_limit'],
        'language_id'       => $record_info['user_language_id'],
        'store_id'          => $record_info['store_id'],
        'customer_group_id' => $record_info['user_customer_group_id'],
        'randomize'         => $template_info['related_randomize']
      ];

      $products = $this->getSameBrandProducts($filter_data);

      $products_from_same_brand = '';

      if ($products) {
        $products_from_same_brand .= '<div style="width: 100%;text-align: center;">';
        foreach ($products as $product) {
          $products_from_same_brand .= $this->getProductMarkup($product,$template_info,$record_info);
        }
        $products_from_same_brand .= '</div>';

        $product_data[8] = $products_from_same_brand;
      }
    }

    // related_products
    if ($index == 9) {
      $filter_data = [
        'product_id'        => $product_info['product_id'],
        'start'             => '0',
        'limit'             => $template_info['related_limit'],
        'language_id'       => $record_info['user_language_id'],
        'store_id'          => $record_info['store_id'],
        'customer_group_id' => $record_info['user_customer_group_id'],
        'randomize'         => $template_info['related_randomize']
      ];

      $products = $this->getRelatedProducts($filter_data);

      $related_products = '';

      if ($products) {
        $related_products .= '<div style="width: 100%;text-align: center;">';
        foreach ($products as $product) {
          $related_products .= $this->getProductMarkup($product,$template_info,$record_info);
        }
        $related_products .= '</div>';

        $product_data[9] = $related_products;
      }
    }

    // products_from_same_category
    if ($index == 10) {
      $filter_data = [
        'product_id'        => $product_info['product_id'],
        'start'             => '0',
        'limit'             => $template_info['related_limit'],
        'language_id'       => $record_info['user_language_id'],
        'store_id'          => $record_info['store_id'],
        'customer_group_id' => $record_info['user_customer_group_id'],
        'randomize'         => $template_info['related_randomize']
      ];

      $products = $this->getSameCategoryProducts($filter_data);

      $products_from_same_category = '';

      if ($products) {
        $products_from_same_category .= '<div style="width: 100%;text-align: center;">';
        foreach ($products as $product) {
          $products_from_same_category .= $this->getProductMarkup($product,$template_info,$record_info);
        }
        $products_from_same_category .= '</div>';

        $product_data[10] = $products_from_same_category;
      }
    }

    // products_from_same_brand_based_on_same_option
    if ($index == 11) {
      $filter_data = [
        'product_id'              => $product_info['product_id'],
        'product_option_id'       => $record_info['product_option_id'],
        'product_option_value_id' => $record_info['product_option_value_id'],
        'start'                   => '0',
        'limit'                   => $template_info['related_limit'],
        'language_id'             => $record_info['user_language_id'],
        'store_id'                => $record_info['store_id'],
        'customer_group_id'       => $record_info['user_customer_group_id'],
        'randomize'               => $template_info['related_randomize']
      ];

      $products = $this->getSameBrandProductsBasedOnSameOption($filter_data);

      $products_from_same_brand_based_on_same_option = '';

      if ($products) {
        $products_from_same_brand_based_on_same_option .= '<div style="width: 100%;text-align: center;">';
        foreach ($products as $product) {
          $products_from_same_brand_based_on_same_option .= $this->getProductMarkup($product,$template_info,$record_info);
        }
        $products_from_same_brand_based_on_same_option .= '</div>';

        $product_data[11] = $products_from_same_brand_based_on_same_option;
      }
    }

    // related_products_based_on_same_option
    if ($index == 12) {
      $filter_data = [
        'product_id'              => $product_info['product_id'],
        'product_option_id'       => $record_info['product_option_id'],
        'product_option_value_id' => $record_info['product_option_value_id'],
        'start'                   => '0',
        'limit'                   => $template_info['related_limit'],
        'language_id'             => $record_info['user_language_id'],
        'store_id'                => $record_info['store_id'],
        'customer_group_id'       => $record_info['user_customer_group_id'],
        'randomize'               => $template_info['related_randomize']
      ];

      $products = $this->getRelatedProductsBasedOnSameOption($filter_data);

      $related_products_based_on_same_option = '';

      if ($products) {
        $related_products_based_on_same_option .= '<div style="width: 100%;text-align: center;">';
        foreach ($products as $product) {
          $related_products_based_on_same_option .= $this->getProductMarkup($product,$template_info,$record_info);
        }
        $related_products_based_on_same_option .= '</div>';

        $product_data[12] = $related_products_based_on_same_option;
      }
    }

    // products_from_same_category_based_on_same_option
    if ($index == 13) {
      $filter_data = [
        'product_id'              => $product_info['product_id'],
        'product_option_id'       => $record_info['product_option_id'],
        'product_option_value_id' => $record_info['product_option_value_id'],
        'start'                   => '0',
        'limit'                   => $template_info['related_limit'],
        'language_id'             => $record_info['user_language_id'],
        'store_id'                => $record_info['store_id'],
        'customer_group_id'       => $record_info['user_customer_group_id'],
        'randomize'               => $template_info['related_randomize']
      ];

      $products = $this->getSameCategoryProductsBasedOnSameOption($filter_data);

      $products_from_same_category_based_on_same_option = '';

      if ($products) {
        $products_from_same_category_based_on_same_option .= '<div style="width: 100%;text-align: center;">';
        foreach ($products as $product) {
          $products_from_same_category_based_on_same_option .= $this->getProductMarkup($product,$template_info,$record_info);
        }
        $products_from_same_category_based_on_same_option .= '</div>';

        $product_data[13] = $products_from_same_category_based_on_same_option;
      }
    }

    if (isset($product_data[$index]) && $product_data[$index]) {
      return $product_data[$index];
    } else {
      return '';
    }
  }

  private function getProductsByMixedFilters($data = []) {
    if (isset($data['filter_bestseller']) && !empty($data['filter_bestseller'])) {
      $sql = "SELECT op.product_id, SUM(op.quantity) AS total";
    } else {
      $sql = "SELECT DISTINCT p.product_id";
    }

    if (isset($data['filter_bestseller']) && !empty($data['filter_bestseller'])) {
      $sql .= " FROM ".DB_PREFIX."order_product op";
      $sql .= " LEFT JOIN ".DB_PREFIX."order o ON (op.order_id = o.order_id)";
      $sql .= " LEFT JOIN ".DB_PREFIX."product p ON (op.product_id = p.product_id)";
    } else {
      $sql .= " FROM ".DB_PREFIX."product p";
    }

    $sql .= " LEFT JOIN ".DB_PREFIX."product_description pd ON (p.product_id = pd.product_id) LEFT JOIN ".DB_PREFIX."product_to_store p2s ON (p.product_id = p2s.product_id) WHERE pd.language_id = '".(int)$data['language_id']."' AND p.status = '1' AND p.quantity IS NOT NULL AND p.date_available <= NOW() AND p2s.store_id = '".(int)$data['store_id']."'";

    if (isset($data['filter_bestseller']) && !empty($data['filter_bestseller'])) {
      $sql .= " AND o.order_status_id IS NOT NULL";
    } else if (isset($data['filter_product_id']) && !empty($data['filter_product_id'])) {
      $sql .= " AND p.product_id IN (".implode(',',$data['filter_product_id']).")";
    } else if (isset($data['filter_manufacturer_id']) && !empty($data['filter_manufacturer_id'])) {
      $sql .= " AND p.manufacturer_id IN (".implode(',',$data['filter_manufacturer_id']).")";
    }

    if (isset($data['filter_bestseller']) && !empty($data['filter_bestseller'])) {
      if (isset($data['product_id']) && !empty($data['product_id'])) {
        $sql .= " AND op.product_id != '".(int)$data['product_id']."' GROUP BY op.product_id";
      } else {
        $sql .= " GROUP BY op.product_id";
      }
    } else {
      if (isset($data['product_id']) && !empty($data['product_id'])) {
        $sql .= " AND p.product_id != '".(int)$data['product_id']."'";
      }
    }

    $sort_data = [
      'pd.name',
      'p.date_added',
      'p.sort_order',
      'total',
      'p.viewed'
    ];

    if (isset($data['sort']) && in_array($data['sort'],$sort_data)) {
      $sql .= " ORDER BY ".$data['sort'];

      if (isset($data['order']) && ($data['order'] == 'DESC')) {
        $sql .= " DESC, LCASE(pd.name) DESC";
      } else {
        $sql .= " ASC, LCASE(pd.name) ASC";
      }
    }

    if (isset($data['start']) || isset($data['limit'])) {
      if ($data['start'] < 0) {
        $data['start'] = 0;
      }

      if ($data['limit'] < 1) {
        $data['limit'] = 20;
      }

      $sql .= " LIMIT ".(int)$data['start'].",".(int)$data['limit'];
    }

    $product_data = [];

    $query = $this->db->query($sql);

    if ($query->num_rows) {
      foreach ($query->rows as $row) {
        $product_data[] = $row['product_id'];
      }
    }

    if ($data['randomize']) {
      shuffle($product_data);
    }

    $products = [];

    foreach ($product_data as $product_id) {
      $products[] = $this->getProduct($product_id,$data['language_id'],$data['store_id'],$data['customer_group_id']);
    }

    return $products;
  }

  private function getProductsFromCategories($data) {
    $product_data = [];

    if ($data['randomize']) {
      $sql = "SELECT MIN(p.product_id) as min_id, MAX(p.product_id) as max_id";

      if (!empty($data['filter_sub_category'])) {
        $sql .= " FROM ".DB_PREFIX."category_path cp LEFT JOIN ".DB_PREFIX."product_to_category p2c ON (cp.category_id = p2c.category_id)";
      } else {
        $sql .= " FROM ".DB_PREFIX."product_to_category p2c";
      }

      $sql .= " LEFT JOIN ".DB_PREFIX."product p ON (p2c.product_id = p.product_id) LEFT JOIN ".DB_PREFIX."product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.quantity IS NOT NULL AND p.date_available <= NOW() AND p2s.store_id = '".(int)$data['store_id']."'";

      if (!empty($data['filter_sub_category'])) {
        $sql .= " AND cp.path_id IN (".implode(',',$data['filter_category_id']).")";
      } else {
        $sql .= " AND p2c.category_id IN (".implode(',',$data['filter_category_id']).")";
      }

      $min_max_id = $this->db->query($sql);

      $while_counter = 0;
      $while_max     = $this->_while_max; // safety catch, so that help the server does not go down

      while ((count($product_data) < $data['limit']) && ($while_counter < $while_max)) {
        $result_product_id = mt_rand($min_max_id->row['min_id'],$min_max_id->row['max_id']);

        $sql = "SELECT DISTINCT p.product_id";

        if (!empty($data['filter_sub_category'])) {
          $sql .= " FROM ".DB_PREFIX."category_path cp LEFT JOIN ".DB_PREFIX."product_to_category p2c ON (cp.category_id = p2c.category_id)";
        } else {
          $sql .= " FROM ".DB_PREFIX."product_to_category p2c";
        }

        $sql .= " LEFT JOIN ".DB_PREFIX."product p ON (p2c.product_id = p.product_id) LEFT JOIN ".DB_PREFIX."product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.quantity IS NOT NULL AND p.date_available <= NOW() AND p2s.store_id = '".(int)$data['store_id']."' AND p.product_id = '".(int)$result_product_id."'";

        if (!empty($data['filter_sub_category'])) {
          $sql .= " AND cp.path_id IN (".implode(',',$data['filter_category_id']).")";
        } else {
          $sql .= " AND p2c.category_id IN (".implode(',',$data['filter_category_id']).")";
        }

        $query = $this->db->query($sql)->num_rows;

        if ($query) {
          $product_data[] = $result_product_id;
        }

        $product_data = array_unique($product_data);

        $while_counter++;
      }
    } else {
      $sql = "SELECT DISTINCT p.product_id";

      if (!empty($data['filter_sub_category'])) {
        $sql .= " FROM ".DB_PREFIX."category_path cp LEFT JOIN ".DB_PREFIX."product_to_category p2c ON (cp.category_id = p2c.category_id)";
      } else {
        $sql .= " FROM ".DB_PREFIX."product_to_category p2c";
      }

      $sql .= " LEFT JOIN ".DB_PREFIX."product p ON (p2c.product_id = p.product_id) LEFT JOIN ".DB_PREFIX."product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.quantity IS NOT NULL AND p.date_available <= NOW() AND p2s.store_id = '".(int)$data['store_id']."'";

      if (!empty($data['filter_sub_category'])) {
        $sql .= " AND cp.path_id IN (".implode(',',$data['filter_category_id']).")";
      } else {
        $sql .= " AND p2c.category_id IN (".implode(',',$data['filter_category_id']).")";
      }

      $sql .= " ORDER BY p.sort_order ASC";

      if (isset($data['start']) || isset($data['limit'])) {
        if ($data['start'] < 0) {
          $data['start'] = 0;
        }

        if ($data['limit'] < 1) {
          $data['limit'] = 20;
        }

        $sql .= " LIMIT ".(int)$data['start'].",".(int)$data['limit'];
      }

      $query = $this->db->query($sql);

      if ($query->num_rows) {
        foreach ($query->rows as $row) {
          $product_data[] = $row['product_id'];
        }
      }

      $product_data = array_unique($product_data);
    }

    $products = [];

    foreach ($product_data as $product_id) {
      $products[] = $this->getProduct($product_id,$data['language_id'],$data['store_id'],$data['customer_group_id']);
    }

    return $products;
  }

  private function getSpecialProducts($data) {
    $product_data = [];

    if ($data['randomize']) {
      $min_max_id = $this->db->query("
        SELECT 
          MIN(ps.product_id) as min_id, 
          MAX(ps.product_id) as max_id 
        FROM ".DB_PREFIX."product_special ps 
        LEFT JOIN ".DB_PREFIX."product p ON (ps.product_id = p.product_id) 
        LEFT JOIN ".DB_PREFIX."product_to_store p2s ON (p.product_id = p2s.product_id) 
        WHERE p.status = '1' 
          AND p.quantity IS NOT NULL 
          AND p.date_available <= NOW() 
          AND ps.customer_group_id = '".(int)$data['customer_group_id']."' 
          AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) 
          AND p2s.store_id = '".(int)$data['store_id']."'
      ");

      $while_counter = 0;
      $while_max     = $this->_while_max; // safety catch, so that help the server does not go down

      while ((count($product_data) < $data['limit']) && ($while_counter < $while_max)) {
        $result_product_id = mt_rand($min_max_id->row['min_id'],$min_max_id->row['max_id']);

        $query = $this->db->query("
          SELECT DISTINCT 
            ps.product_id 
          FROM ".DB_PREFIX."product_special ps 
          LEFT JOIN ".DB_PREFIX."product p ON (ps.product_id = p.product_id) 
          LEFT JOIN ".DB_PREFIX."product_to_store p2s ON (p.product_id = p2s.product_id) 
          WHERE p.product_id = '".(int)$result_product_id."' 
            AND ps.product_id != '".(int)$data['product_id']."' 
            AND p.status = '1' 
            AND p.quantity IS NOT NULL 
            AND p.date_available <= NOW() 
            AND ps.customer_group_id = '".(int)$data['customer_group_id']."' 
            AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) 
            AND p2s.store_id = '".(int)$data['store_id']."'
        ")->num_rows;

        if ($query) {
          $product_data[] = $result_product_id;
        }

        $product_data = array_unique($product_data);

        $while_counter++;
      }
    } else {
      $sql = "
        SELECT DISTINCT 
          ps.product_id 
        FROM ".DB_PREFIX."product_special ps 
        LEFT JOIN ".DB_PREFIX."product p ON (ps.product_id = p.product_id) 
        LEFT JOIN ".DB_PREFIX."product_to_store p2s ON (p.product_id = p2s.product_id) 
        WHERE p.status = '1' 
          AND ps.product_id != '".(int)$data['product_id']."' 
          AND p.quantity IS NOT NULL 
          AND p.date_available <= NOW() 
          AND ps.customer_group_id = '".(int)$data['customer_group_id']."' 
          AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) 
          AND p2s.store_id = '".(int)$data['store_id']."' 
        ORDER BY p.sort_order ASC
      ";

      if (isset($data['start']) || isset($data['limit'])) {
        if ($data['start'] < 0) {
          $data['start'] = 0;
        }

        if ($data['limit'] < 1) {
          $data['limit'] = 20;
        }

        $sql .= " LIMIT ".(int)$data['start'].",".(int)$data['limit'];
      }

      $query = $this->db->query($sql);

      if ($query->num_rows) {
        foreach ($query->rows as $row) {
          $product_data[] = $row['product_id'];
        }
      }

      $product_data = array_unique($product_data);
    }

    $products = [];

    foreach ($product_data as $product_id) {
      $products[] = $this->getProduct($product_id,$data['language_id'],$data['store_id'],$data['customer_group_id']);
    }

    return $products;
  }

  private function getSameBrandProducts($data) {
    $product_data = [];

    $manufacturer_id = $this->db->query("
      SELECT 
        p.manufacturer_id 
      FROM ".DB_PREFIX."product p 
      LEFT JOIN ".DB_PREFIX."product_to_store p2s ON (p.product_id = p2s.product_id) 
      LEFT JOIN ".DB_PREFIX."manufacturer m ON (p.manufacturer_id = m.manufacturer_id) 
      WHERE p.product_id = '".(int)$data['product_id']."' 
        AND p.status = '1' 
        AND p.date_available <= NOW() 
        AND p2s.store_id = '".(int)$data['store_id']."'
    ")->row['manufacturer_id'];

    if ($manufacturer_id) {
      if ($data['randomize']) {
        $min_max_id = $this->db->query("
          SELECT 
            MIN(p.product_id) as min_id, 
            MAX(p.product_id) as max_id 
          FROM ".DB_PREFIX."product p 
          LEFT JOIN ".DB_PREFIX."product_to_store p2s ON (p.product_id = p2s.product_id) 
          WHERE p.status = '1' 
            AND p.quantity IS NOT NULL 
            AND p.date_available <= NOW() 
            AND p2s.store_id = '".(int)$data['store_id']."' 
            AND p.manufacturer_id = '".(int)$manufacturer_id."'
        ");

        $while_counter = 0;
        $while_max     = $this->_while_max; // safety catch, so that help the server does not go down

        while ((count($product_data) < $data['limit']) && ($while_counter < $while_max)) {
          $result_product_id = mt_rand($min_max_id->row['min_id'],$min_max_id->row['max_id']);

          $query = $this->db->query("
            SELECT 
              p.product_id 
            FROM ".DB_PREFIX."product p 
            LEFT JOIN ".DB_PREFIX."product_to_store p2s ON (p.product_id = p2s.product_id) 
            WHERE p.product_id = '".(int)$result_product_id."' 
              AND p.product_id != '".(int)$data['product_id']."'
              AND p.status = '1' 
              AND p.quantity IS NOT NULL 
              AND p.date_available <= NOW() 
              AND p2s.store_id = '".(int)$data['store_id']."' 
              AND p.manufacturer_id = '".(int)$manufacturer_id."'
          ")->num_rows;

          if ($query) {
            $product_data[] = $result_product_id;
          }

          $product_data = array_unique($product_data);

          $while_counter++;
        }
      } else {
        $sql = "
          SELECT DISTINCT 
            p.product_id 
          FROM ".DB_PREFIX."product p 
          LEFT JOIN ".DB_PREFIX."product_to_store p2s ON (p.product_id = p2s.product_id) 
          WHERE p.status = '1' 
            AND p.product_id != '".(int)$data['product_id']."'
            AND p.quantity IS NOT NULL 
            AND p.date_available <= NOW() 
            AND p2s.store_id = '".(int)$data['store_id']."' 
            AND p.manufacturer_id = '".(int)$manufacturer_id."' 
          ORDER BY p.sort_order ASC
        ";

        if (isset($data['start']) || isset($data['limit'])) {
          if ($data['start'] < 0) {
            $data['start'] = 0;
          }

          if ($data['limit'] < 1) {
            $data['limit'] = 20;
          }

          $sql .= " LIMIT ".(int)$data['start'].",".(int)$data['limit'];
        }

        $query = $this->db->query($sql);

        if ($query->num_rows) {
          foreach ($query->rows as $row) {
            $product_data[] = $row['product_id'];
          }
        }

        $product_data = array_unique($product_data);
      }
    }

    $products = [];

    foreach ($product_data as $product_id) {
      $products[] = $this->getProduct($product_id,$data['language_id'],$data['store_id'],$data['customer_group_id']);
    }

    return $products;
  }

  private function getSameBrandProductsBasedOnSameOption($data) {
    $product_data = [];

    $manufacturer_query = $this->db->query("
      SELECT DISTINCT
        p.manufacturer_id,
        pov.option_id,
        pov.option_value_id
      FROM ".DB_PREFIX."product p
      LEFT JOIN ".DB_PREFIX."product_to_store p2s ON (p.product_id = p2s.product_id)
      LEFT JOIN ".DB_PREFIX."manufacturer m ON (p.manufacturer_id = m.manufacturer_id)
      LEFT JOIN ".DB_PREFIX."product_option_value pov ON (p.product_id = pov.product_id) 
      WHERE p.product_id = '".(int)$data['product_id']."' 
        AND p.status = '1'
        AND pov.quantity IS NOT NULL
        AND p.quantity IS NOT NULL
        AND p.date_available <= NOW()
        AND p2s.store_id = '".(int)$data['store_id']."'
        AND pov.product_option_id = '".(int)$data['product_option_id']."'
        AND pov.product_option_value_id = '".(int)$data['product_option_value_id']."'
    ");

    if ($manufacturer_query->num_rows) {
      if ($data['randomize']) {
        $min_max_id = $this->db->query("
          SELECT 
            MIN(p.product_id) AS min_id,
            MAX(p.product_id) AS max_id
          FROM ".DB_PREFIX."product p
          LEFT JOIN ".DB_PREFIX."product_to_store p2s ON (p.product_id = p2s.product_id)
          LEFT JOIN ".DB_PREFIX."manufacturer m ON (p.manufacturer_id = m.manufacturer_id)
          LEFT JOIN ".DB_PREFIX."product_option_value pov ON (p.product_id = pov.product_id)
          WHERE p.status = '1' 
            AND pov.quantity IS NOT NULL 
            AND p.quantity IS NOT NULL 
            AND p.manufacturer_id = '".(int)$manufacturer_query->row['manufacturer_id']."' 
            AND p.date_available <= NOW() 
            AND p2s.store_id = '".(int)$data['store_id']."' 
            AND pov.option_id = '".(int)$manufacturer_query->row['option_id']."' 
            AND pov.option_value_id = '".(int)$manufacturer_query->row['option_value_id']."'
        ");

        $while_counter = 0;
        $while_max     = $this->_while_max; // safety catch, so that help the server does not go down

        while ((count($product_data) < $data['limit']) && ($while_counter < $while_max)) {
          $result_product_id = mt_rand($min_max_id->row['min_id'],$min_max_id->row['max_id']);

          $query = $this->db->query("
            SELECT 
              p.product_id
            FROM ".DB_PREFIX."product p
            LEFT JOIN ".DB_PREFIX."product_to_store p2s ON (p.product_id = p2s.product_id)
            LEFT JOIN ".DB_PREFIX."manufacturer m ON (p.manufacturer_id = m.manufacturer_id)
            LEFT JOIN ".DB_PREFIX."product_option_value pov ON (p.product_id = pov.product_id)
            WHERE p.product_id = '".(int)$result_product_id."'
              AND p.product_id != '".(int)$data['product_id']."'
              AND p.status = '1' 
              AND pov.quantity IS NOT NULL 
              AND p.quantity IS NOT NULL 
              AND p.manufacturer_id = '".(int)$manufacturer_query->row['manufacturer_id']."' 
              AND p.date_available <= NOW() 
              AND p2s.store_id = '".(int)$data['store_id']."' 
              AND pov.option_id = '".(int)$manufacturer_query->row['option_id']."' 
              AND pov.option_value_id = '".(int)$manufacturer_query->row['option_value_id']."'
          ")->num_rows;

          if ($query) {
            $product_data[] = $result_product_id;
          }

          $product_data = array_unique($product_data);

          $while_counter++;
        }
      } else {
        $sql = "
          SELECT 
            p.product_id
          FROM ".DB_PREFIX."product p
          LEFT JOIN ".DB_PREFIX."product_to_store p2s ON (p.product_id = p2s.product_id)
          LEFT JOIN ".DB_PREFIX."manufacturer m ON (p.manufacturer_id = m.manufacturer_id)
          LEFT JOIN ".DB_PREFIX."product_option_value pov ON (p.product_id = pov.product_id)
          WHERE p.status = '1' 
            AND p.product_id != '".(int)$data['product_id']."'
            AND pov.quantity IS NOT NULL 
            AND p.quantity IS NOT NULL 
            AND p.manufacturer_id = '".(int)$manufacturer_query->row['manufacturer_id']."' 
            AND p.date_available <= NOW() 
            AND p2s.store_id = '".(int)$data['store_id']."' 
            AND pov.option_id = '".(int)$manufacturer_query->row['option_id']."' 
            AND pov.option_value_id = '".(int)$manufacturer_query->row['option_value_id']."'
          ORDER BY p.sort_order ASC  
        ";

        if (isset($data['start']) || isset($data['limit'])) {
          if ($data['start'] < 0) {
            $data['start'] = 0;
          }

          if ($data['limit'] < 1) {
            $data['limit'] = 20;
          }

          $sql .= " LIMIT ".(int)$data['start'].",".(int)$data['limit'];
        }

        $query = $this->db->query($sql);

        if ($query->num_rows) {
          foreach ($query->rows as $row) {
            $product_data[] = $row['product_id'];
          }
        }

        $product_data = array_unique($product_data);
      }
    }

    $products = [];

    foreach ($product_data as $product_id) {
      $products[] = $this->getProduct($product_id,$data['language_id'],$data['store_id'],$data['customer_group_id']);
    }

    return $products;
  }

  private function getSameCategoryProducts($data) {
    $product_data = [];

    $category_query = $this->db->query("
      SELECT DISTINCT 
        p2c.category_id 
      FROM ".DB_PREFIX."product p 
      LEFT JOIN ".DB_PREFIX."product_to_store p2s ON (p.product_id = p2s.product_id) 
      LEFT JOIN ".DB_PREFIX."product_to_category p2c ON (p.product_id = p2c.product_id) 
      WHERE p.product_id = '".(int)$data['product_id']."' 
        AND p.status = '1' 
        AND p.date_available <= NOW() 
        AND p2s.store_id = '".(int)$data['store_id']."'
    ")->rows;

    $categories = [];

    if ($category_query) {
      foreach ($category_query as $category) {
        $categories[] = $category['category_id'];
      }
    }

    if ($categories) {
      if ($data['randomize']) {
        $min_max_id = $this->db->query("
          SELECT 
            MIN(p.product_id) as min_id, 
            MAX(p.product_id) as max_id 
          FROM ".DB_PREFIX."product_to_category p2c 
          LEFT JOIN ".DB_PREFIX."product p ON (p2c.product_id = p.product_id) 
          LEFT JOIN ".DB_PREFIX."product_to_store p2s ON (p.product_id = p2s.product_id) 
          WHERE p.status = '1' 
            AND p.quantity IS NOT NULL 
            AND p.date_available <= NOW() 
            AND p2s.store_id = '".(int)$data['store_id']."' 
            AND p2c.category_id IN (".implode(',',$categories).")
        ");

        $while_counter = 0;
        $while_max     = $this->_while_max; // safety catch, so that help the server does not go down

        while ((count($product_data) < $data['limit']) && ($while_counter < $while_max)) {
          $result_product_id = mt_rand($min_max_id->row['min_id'],$min_max_id->row['max_id']);

          $query = $this->db->query("SELECT DISTINCT p.product_id FROM ".DB_PREFIX."product_to_category p2c LEFT JOIN ".DB_PREFIX."product p ON (p2c.product_id = p.product_id) LEFT JOIN ".DB_PREFIX."product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.quantity IS NOT NULL AND p.date_available <= NOW() AND p2s.store_id = '".(int)$data['store_id']."' AND p.product_id = '".(int)$result_product_id."' AND p2c.category_id IN (".implode(',',$categories).")")->num_rows;

          if ($query) {
            $product_data[] = $result_product_id;
          }

          $product_data = array_unique($product_data);

          $while_counter++;
        }
      } else {
        $sql = "
          SELECT DISTINCT 
            p.product_id 
          FROM ".DB_PREFIX."product_to_category p2c 
          LEFT JOIN ".DB_PREFIX."product p ON (p2c.product_id = p.product_id) 
          LEFT JOIN ".DB_PREFIX."product_to_store p2s ON (p.product_id = p2s.product_id) 
          WHERE p.status = '1' 
            AND p.product_id != '".(int)$data['product_id']."'
            AND p.quantity IS NOT NULL 
            AND p.date_available <= NOW() 
            AND p2s.store_id = '".(int)$data['store_id']."' 
            AND p2c.category_id IN (".implode(',',$categories).") 
          ORDER BY p.sort_order ASC
        ";

        if (isset($data['start']) || isset($data['limit'])) {
          if ($data['start'] < 0) {
            $data['start'] = 0;
          }

          if ($data['limit'] < 1) {
            $data['limit'] = 20;
          }

          $sql .= " LIMIT ".(int)$data['start'].",".(int)$data['limit'];
        }

        $query = $this->db->query($sql);

        if ($query->num_rows) {
          foreach ($query->rows as $row) {
            $product_data[] = $row['product_id'];
          }
        }

        $product_data = array_unique($product_data);
      }
    }

    $products = [];

    foreach ($product_data as $product_id) {
      $products[] = $this->getProduct($product_id,$data['language_id'],$data['store_id'],$data['customer_group_id']);
    }

    return $products;
  }

  private function getSameCategoryProductsBasedOnSameOption($data) {
    $product_data = [];

    $category_query = $this->db->query("
      SELECT DISTINCT
        p2c.category_id,
        pov.option_id,
        pov.option_value_id
      FROM ".DB_PREFIX."product p
      LEFT JOIN ".DB_PREFIX."product_to_store p2s ON (p.product_id = p2s.product_id)
      LEFT JOIN ".DB_PREFIX."product_to_category p2c ON (p.product_id = p2c.product_id)
      LEFT JOIN ".DB_PREFIX."product_option_value pov ON (p.product_id = pov.product_id)
      WHERE p.product_id = '".(int)$data['product_id']."' 
        AND p.status = '1' 
        AND p.date_available <= NOW() 
        AND p2s.store_id = '".(int)$data['store_id']."' 
        AND pov.product_option_id = '".(int)$data['product_option_id']."'
        AND pov.product_option_value_id = '".(int)$data['product_option_value_id']."'
    ")->rows;

    $categories = [];

    if ($category_query) {
      foreach ($category_query as $category) {
        $categories[] = [
          'category_id'     => $category['category_id'],
          'option_id'       => $category['option_id'],
          'option_value_id' => $category['option_value_id']
        ];
      }
    }

    if ($categories) {
      foreach ($categories as $category) {
        if ($data['randomize']) {
          $min_max_id = $this->db->query("
            SELECT 
              MIN(p.product_id) AS min_id,
              MAX(p.product_id) AS max_id
            FROM ".DB_PREFIX."product_to_category p2c 
            LEFT JOIN ".DB_PREFIX."product p ON (p2c.product_id = p.product_id)
            LEFT JOIN ".DB_PREFIX."product_to_store p2s ON (p.product_id = p2s.product_id)
            LEFT JOIN ".DB_PREFIX."product_option_value pov ON (p.product_id = pov.product_id)
            WHERE p.status = '1' 
              AND pov.quantity IS NOT NULL 
              AND p.quantity IS NOT NULL 
              AND p.date_available <= NOW() 
              AND p2s.store_id = '".(int)$data['store_id']."' 
              AND pov.option_id = '".(int)$category['option_id']."' 
              AND pov.option_value_id = '".(int)$category['option_value_id']."'
              AND p2c.category_id = '".(int)$category['category_id']."'
          ");

          $while_counter = 0;
          $while_max     = $this->_while_max; // safety catch, so that help the server does not go down

          while ((count($product_data) < $data['limit']) && ($while_counter < $while_max)) {
            $result_product_id = mt_rand($min_max_id->row['min_id'],$min_max_id->row['max_id']);

            $query = $this->db->query("
              SELECT 
                p.product_id
              FROM ".DB_PREFIX."product_to_category p2c
              LEFT JOIN ".DB_PREFIX."product p ON (p2c.product_id = p.product_id)
              LEFT JOIN ".DB_PREFIX."product_to_store p2s ON (p.product_id = p2s.product_id)
              LEFT JOIN ".DB_PREFIX."product_option_value pov ON (p.product_id = pov.product_id)
              WHERE p.product_id = '".(int)$result_product_id."'
                AND p.product_id != '".(int)$data['product_id']."'
                AND p.status = '1' 
                AND pov.quantity IS NOT NULL 
                AND p.quantity IS NOT NULL 
                AND p.date_available <= NOW() 
                AND p2s.store_id = '".(int)$data['store_id']."' 
                AND pov.option_id = '".(int)$category['option_id']."' 
                AND pov.option_value_id = '".(int)$category['option_value_id']."'
                AND p2c.category_id = '".(int)$category['category_id']."'
            ")->num_rows;

            if ($query) {
              $product_data[] = $result_product_id;
            }

            $product_data = array_unique($product_data);

            $while_counter++;
          }
        } else {
          $sql = "
            SELECT 
              p.product_id
            FROM ".DB_PREFIX."product_to_category p2c
            LEFT JOIN ".DB_PREFIX."product p ON (p2c.product_id = p.product_id)
            LEFT JOIN ".DB_PREFIX."product_to_store p2s ON (p.product_id = p2s.product_id)
            LEFT JOIN ".DB_PREFIX."product_option_value pov ON (p.product_id = pov.product_id)
            WHERE p.status = '1' 
              AND p.product_id != '".(int)$data['product_id']."'
              AND pov.quantity IS NOT NULL 
              AND p.quantity IS NOT NULL 
              AND p.date_available <= NOW() 
              AND p2s.store_id = '".(int)$data['store_id']."' 
              AND pov.option_id = '".(int)$category['option_id']."' 
              AND pov.option_value_id = '".(int)$category['option_value_id']."'
              AND p2c.category_id = '".(int)$category['category_id']."'
            ORDER BY p.sort_order ASC  
          ";

          if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
              $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
              $data['limit'] = 20;
            }

            $sql .= " LIMIT ".(int)$data['start'].",".(int)$data['limit'];
          }

          $query = $this->db->query($sql);

          if ($query->num_rows) {
            foreach ($query->rows as $row) {
              $product_data[] = $row['product_id'];
            }
          }

          $product_data = array_unique($product_data);
        }
      }
    }

    $products = [];

    foreach ($product_data as $product_id) {
      $products[] = $this->getProduct($product_id,$data['language_id'],$data['store_id'],$data['customer_group_id']);
    }

    return $products;
  }

  private function getRelatedProducts($data) {
    $product_data = [];

    if ($data['randomize']) {
      $min_max_id = $this->db->query("
        SELECT 
          MIN(pr.product_id) as min_id, 
          MAX(pr.product_id) as max_id 
        FROM ".DB_PREFIX."product_related pr 
        LEFT JOIN ".DB_PREFIX."product p ON (pr.related_id = p.product_id) 
        LEFT JOIN ".DB_PREFIX."product_to_store p2s ON (p.product_id = p2s.product_id) 
        WHERE p.product_id = '".(int)$data['product_id']."'
          AND p.status = '1' 
          AND p.date_available <= NOW() 
          AND p2s.store_id = '".(int)$data['store_id']."' 
      ");

      $while_counter = 0;
      $while_max     = $this->_while_max; // safety catch, so that help the server does not go down

      while ((count($product_data) < $data['limit']) && ($while_counter < $while_max)) {
        $result_product_id = mt_rand($min_max_id->row['min_id'],$min_max_id->row['max_id']);

        $query = $this->db->query("
          SELECT DISTINCT 
            pr.product_id 
          FROM ".DB_PREFIX."product_related pr 
          LEFT JOIN ".DB_PREFIX."product p ON (pr.related_id = p.product_id) 
          LEFT JOIN ".DB_PREFIX."product_to_store p2s ON (p.product_id = p2s.product_id) 
          WHERE p.product_id = '".(int)$result_product_id."'
            AND p.product_id != '".(int)$data['product_id']."' 
            AND p.status = '1' 
            AND p.quantity IS NOT NULL 
            AND p.date_available <= NOW() 
            AND p2s.store_id = '".(int)$data['store_id']."' 
        ")->num_rows;

        if ($query) {
          $product_data[] = $result_product_id;
        }

        $product_data = array_unique($product_data);

        $while_counter++;
      }
    } else {
      $sql = "
        SELECT DISTINCT 
          pr.product_id 
        FROM ".DB_PREFIX."product_related pr 
        LEFT JOIN ".DB_PREFIX."product p ON (pr.related_id = p.product_id) 
        LEFT JOIN ".DB_PREFIX."product_to_store p2s ON (p.product_id = p2s.product_id) 
        WHERE p.product_id = '".(int)$data['product_id']."' 
          AND pr.product_id != '".(int)$data['product_id']."' 
          AND p.status = '1' 
          AND p.date_available <= NOW() 
          AND p2s.store_id = '".(int)$data['store_id']."' 
        ORDER BY p.sort_order ASC
      ";

      if (isset($data['start']) || isset($data['limit'])) {
        if ($data['start'] < 0) {
          $data['start'] = 0;
        }

        if ($data['limit'] < 1) {
          $data['limit'] = 20;
        }

        $sql .= " LIMIT ".(int)$data['start'].",".(int)$data['limit'];
      }

      $query = $this->db->query($sql);

      if ($query->num_rows) {
        foreach ($query->rows as $row) {
          $product_data[] = $row['product_id'];
        }
      }

      $product_data = array_unique($product_data);
    }

    $products = [];

    foreach ($product_data as $product_id) {
      $products[] = $this->getProduct($product_id,$data['language_id'],$data['store_id'],$data['customer_group_id']);
    }

    return $products;
  }

  public function getProductOptionInfo($data) {
    return $query = $this->db->query("
      SELECT 
        p.product_id,
        pov.option_id,
        pov.option_value_id,
        pov.price
      FROM ".DB_PREFIX."product p
      LEFT JOIN ".DB_PREFIX."product_option_value pov ON (p.product_id = pov.product_id)
      WHERE p.product_id = '".(int)$data['product_id']."' 
        AND pov.product_option_id = '".(int)$data['product_option_id']."'
        AND pov.product_option_value_id = '".(int)$data['product_option_value_id']."'
    ")->row;
  }

  private function getRelatedProductsBasedOnSameOption($data) {
    $product_data = [];

    $related_query = $this->db->query("
      SELECT 
        p.product_id,
        pov.option_id,
        pov.option_value_id
      FROM ".DB_PREFIX."product p
      LEFT JOIN ".DB_PREFIX."product_option_value pov ON (p.product_id = pov.product_id)
      LEFT JOIN ".DB_PREFIX."product_to_store p2s ON (p.product_id = p2s.product_id)
      WHERE p.product_id = '".(int)$data['product_id']."' 
        AND p.status = '1' 
        AND p.quantity IS NOT NULL 
        AND p.date_available <= NOW() 
        AND p2s.store_id = '".(int)$data['store_id']."'
        AND pov.product_option_id = '".(int)$data['product_option_id']."'
        AND pov.product_option_value_id = '".(int)$data['product_option_value_id']."'
    ");

    if ($related_query->num_rows) {
      if ($data['randomize']) {
        $min_max_id = $this->db->query("
          SELECT 
            MIN(pr.related_id) AS min_id,
            MAX(pr.related_id) AS max_id
          FROM ".DB_PREFIX."product p
          LEFT JOIN ".DB_PREFIX."product_to_store p2s ON (p.product_id = p2s.product_id)
          LEFT JOIN ".DB_PREFIX."product_related pr ON (pr.related_id = p.product_id)
          LEFT JOIN ".DB_PREFIX."product_option_value pov ON (p.product_id = pov.product_id)
          WHERE pr.product_id = '".(int)$related_query->row['product_id']."' 
            AND p.status = '1' 
            AND pov.quantity IS NOT NULL 
            AND p.quantity IS NOT NULL 
            AND p.date_available <= NOW() 
            AND p2s.store_id = '".(int)$data['store_id']."' 
            AND pov.option_id = '".(int)$related_query->row['option_id']."' 
            AND pov.option_value_id = '".(int)$related_query->row['option_value_id']."'
        ");

        $while_counter = 0;
        $while_max     = $this->_while_max; // safety catch, so that help the server does not go down

        while ((count($product_data) < $data['limit']) && ($while_counter < $while_max)) {
          $result_product_id = mt_rand($min_max_id->row['min_id'],$min_max_id->row['max_id']);

          $query = $this->db->query("
            SELECT DISTINCT
              p.product_id
            FROM ".DB_PREFIX."product p
            LEFT JOIN ".DB_PREFIX."product_to_store p2s ON (p.product_id = p2s.product_id)
            LEFT JOIN ".DB_PREFIX."product_related pr ON (pr.related_id = p.product_id)
            LEFT JOIN ".DB_PREFIX."product_option_value pov ON (p.product_id = pov.product_id)
            WHERE p.product_id = '".(int)$result_product_id."' 
              AND p.product_id != '".(int)$data['product_id']."' 
              AND p.status = '1' 
              AND pov.quantity IS NOT NULL 
              AND p.quantity IS NOT NULL 
              AND p.date_available <= NOW() 
              AND p2s.store_id = '".(int)$data['store_id']."' 
              AND pov.option_id = '".(int)$related_query->row['option_id']."' 
              AND pov.option_value_id = '".(int)$related_query->row['option_value_id']."'
          ")->num_rows;

          if ($query) {
            $product_data[] = $result_product_id;
          }

          $product_data = array_unique($product_data);

          $while_counter++;
        }
      } else {
        $sql = "
          SELECT DISTINCT
            p.product_id
          FROM ".DB_PREFIX."product p
          LEFT JOIN ".DB_PREFIX."product_to_store p2s ON (p.product_id = p2s.product_id)
          LEFT JOIN ".DB_PREFIX."product_related pr ON (pr.related_id = p.product_id)
          LEFT JOIN ".DB_PREFIX."product_option_value pov ON (p.product_id = pov.product_id)
          WHERE pr.product_id = '".(int)$data['product_id']."'
            AND p.status = '1' 
            AND pov.quantity IS NOT NULL 
            AND p.quantity IS NOT NULL 
            AND p.date_available <= NOW() 
            AND p2s.store_id = '".(int)$data['store_id']."' 
            AND pov.option_id = '".(int)$related_query->row['option_id']."' 
            AND pov.option_value_id = '".(int)$related_query->row['option_value_id']."'
          ORDER BY p.sort_order ASC
        ";

        if (isset($data['start']) || isset($data['limit'])) {
          if ($data['start'] < 0) {
            $data['start'] = 0;
          }

          if ($data['limit'] < 1) {
            $data['limit'] = 20;
          }

          $sql .= " LIMIT ".(int)$data['start'].",".(int)$data['limit'];
        }

        $query = $this->db->query($sql);

        if ($query->num_rows) {
          foreach ($query->rows as $row) {
            $product_data[] = $row['product_id'];
          }
        }

        $product_data = array_unique($product_data);
      }
    }

    $products = [];

    foreach ($product_data as $product_id) {
      $products[] = $this->getProduct($product_id,$data['language_id'],$data['store_id'],$data['customer_group_id']);
    }

    return $products;
  }

  public function getOptionForNotification($data) {
    $option_query = $this->db->query("
      SELECT DISTINCT
        pov.option_id,
        pov.option_value_id
      FROM ".DB_PREFIX."product_option_value pov 
      WHERE pov.product_id = '".(int)$data['product_id']."' 
        AND pov.product_option_id = '".(int)$data['product_option_id']."'
        AND pov.product_option_value_id = '".(int)$data['product_option_value_id']."'
    ");

    if ($option_query->num_rows) {
      return $this->db->query("
        SELECT DISTINCT
          od.name AS option_name,
          ovd.name AS option_value,
          (SELECT price FROM ".DB_PREFIX."product_option_value WHERE product_id = '".(int)$data['product_id']."' AND option_value_id = '".(int)$option_query->row['option_value_id']."' AND option_id = '".(int)$option_query->row['option_id']."') as price
        FROM ".DB_PREFIX."option o
        LEFT JOIN ".DB_PREFIX."option_description od ON (o.option_id = od.option_id)
        LEFT JOIN ".DB_PREFIX."option_value_description ovd ON (o.option_id = ovd.option_id)
        LEFT JOIN ".DB_PREFIX."product_option_value pov ON (o.option_id = pov.option_id)
        WHERE pov.product_id = '".(int)$data['product_id']."'
          AND ovd.option_value_id = '".(int)$option_query->row['option_value_id']."'
          AND ovd.option_id = '".(int)$option_query->row['option_id']."'
          AND od.language_id = '".(int)$data['user_language_id']."' 
        GROUP BY o.option_id
      ")->row;
    } else {
      return false;
    }
  }

  public function deleteRecord($record_id) {
    $this->db->query("DELETE FROM ".DB_PREFIX.$this->_code."_record WHERE record_id = '".(int)$record_id."'");
  }

  public function mailing($data,$types) {
    if ($data && $types) {
      $record_info = $this->getRecord($data['record_id']);

      if ($record_info && !$record_info['banned_status']) {
        $form_data = $data['form_data'];

        $filter_data = [
          'product_id'             => $data['product_id'],
          'user_language_id'       => $record_info['user_language_id'],
          'user_customer_group_id' => $record_info['user_customer_group_id']
        ];

        $product_info = $this->getRecordProduct($filter_data);

        if ($product_info && $form_data) {
          $fields_all                                       = '';
          $main_product                                     = '';
          $selected_products                                = '';
          $products_from_category                           = '';
          $latest_products                                  = '';
          $bestseller_products                              = '';
          $special_products                                 = '';
          $popular_products                                 = '';
          $products_from_brand                              = '';
          $products_from_same_brand                         = '';
          $related_products                                 = '';
          $products_from_same_category                      = '';
          $products_from_same_brand_based_on_same_option    = '';
          $related_products_based_on_same_option            = '';
          $products_from_same_category_based_on_same_option = '';
          $filter_data                                      = $fields = [];
          $field_data                                       = $this->getRecordFieldData($record_info['record_id']);
          $filter_data['user_language_id']                  = $record_info['user_language_id'];
          $filter_data['store_name']                        = $record_info['store_name'];

          if ($record_info['record_type'] == 2) {
            $option_filter_data = [
              'product_id'              => $data['product_id'],
              'user_language_id'        => $record_info['user_language_id'],
              'product_option_id'       => $record_info['product_option_id'],
              'product_option_value_id' => $record_info['product_option_value_id']
            ];

            $option_info = $this->getOptionForNotification($option_filter_data);
          }

          if ($field_data) {
            foreach ($field_data as $field) {
              if ($field['value']) {
                $fields[$field['type']][] = $field['value'];
                $fields_all               .= '<b>'.$field['name'].':</b> '.$field['value'].'<br/>';
              }
            }
          }

          $current_price = $record_info['price'];

          foreach ($types as $type) {
            if ($form_data['admin_alert_status']) {
              if ($type == 'to_admin_on_new_record_product') {
                $filter_data['set_to']       = $form_data['admin_email_for_notification'];
                $filter_data['template_id']  = $template_id = $form_data['admin_email_template_product'];
                $template_info               = $this->getEmailTemplate($template_id);
                $filter_data['set_to_multi'] = 1;

                $main_product = $this->getProductMarkups(0,$template_info,$record_info,$product_info);

                $filter_data['tag_codes_subject'] = [
                  '{email}',
                  '{firstname}',
                  '{lastname}',
                  '{telephone}',
                  '{record_id}',
                  '{date_added}',
                  '{store_name}'
                ];

                $filter_data['tag_codes_replace_subject'] = [
                  $record_info['email'],
                  (isset($fields['firstname'][0])) ? $fields['firstname'][0] : '',
                  (isset($fields['lastname'][0])) ? $fields['lastname'][0] : '',
                  $record_info['telephone'],
                  $record_info['record_id'],
                  date("Y-m-d H:i:s",strtotime($record_info['date_added'])),
                  $record_info['store_name']
                ];

                $filter_data['tag_codes_template'] = [
                  '{email}',
                  '{firstname}',
                  '{lastname}',
                  '{telephone}',
                  '{ip}',
                  '{record_id}',
                  '{fields}',
                  '{date_added}',
                  '{main_product_block}',
                  '{main_product_url}',
                  '{main_product_name}',
                  '{product_price}',
                  '{referer}',
                  '{user_agent}',
                  '{accept_language}',
                  '{store_name}',
                  '{store_address}',
                  '{store_email}',
                  '{store_telephone}',
                  '{store_fax}',
                  '{store_url}'
                ];

                $filter_data['tag_codes_replace_template'] = [
                  $record_info['email'],
                  (isset($fields['firstname'][0])) ? $fields['firstname'][0] : '',
                  (isset($fields['lastname'][0])) ? $fields['lastname'][0] : '',
                  $record_info['telephone'],
                  $record_info['ip'],
                  $record_info['record_id'],
                  $fields_all,
                  date("Y-m-d H:i:s",strtotime($record_info['date_added'])),
                  $main_product,
                  $record_info['store_url'].'index.php?route=product/product&product_id='.$record_info['product_id'],
                  $product_info['name'],
                  $this->currency->format($current_price,$record_info['currency_code'],$record_info['currency_value']),
                  $record_info['referer'],
                  $record_info['user_agent'],
                  $record_info['accept_language'],
                  $record_info['store_name'],
                  $this->config->get('config_address'),
                  $this->config->get('config_email'),
                  $this->config->get('config_telephone'),
                  ($this->config->get('config_fax') != '') ? $this->config->get('config_fax') : '',
                  $record_info['store_url']
                ];

                $this->mailing_send($filter_data);
              }

              if ($type == 'to_admin_on_new_record_product_option') {
                $filter_data['set_to']       = $form_data['admin_email_for_notification'];
                $filter_data['template_id']  = $template_id = $form_data['admin_email_template_product_option'];
                $template_info               = $this->getEmailTemplate($template_id);
                $filter_data['set_to_multi'] = 1;

                $main_product = $this->getProductMarkups(0,$template_info,$record_info,$product_info);

                $filter_data['tag_codes_subject'] = [
                  '{email}',
                  '{firstname}',
                  '{lastname}',
                  '{telephone}',
                  '{record_id}',
                  '{date_added}',
                  '{store_name}'
                ];

                $filter_data['tag_codes_replace_subject'] = [
                  $record_info['email'],
                  (isset($fields['firstname'][0])) ? $fields['firstname'][0] : '',
                  (isset($fields['lastname'][0])) ? $fields['lastname'][0] : '',
                  $record_info['telephone'],
                  $record_info['record_id'],
                  date("Y-m-d H:i:s",strtotime($record_info['date_added'])),
                  $record_info['store_name']
                ];

                $filter_data['tag_codes_template'] = [
                  '{email}',
                  '{firstname}',
                  '{lastname}',
                  '{telephone}',
                  '{ip}',
                  '{record_id}',
                  '{fields}',
                  '{date_added}',
                  '{main_product_block}',
                  '{main_product_url}',
                  '{main_product_name}',
                  '{option_name}',
                  '{option_value}',
                  '{product_option_price}',
                  '{referer}',
                  '{user_agent}',
                  '{accept_language}',
                  '{store_name}',
                  '{store_address}',
                  '{store_email}',
                  '{store_telephone}',
                  '{store_fax}',
                  '{store_url}'
                ];

                $filter_data['tag_codes_replace_template'] = [
                  $record_info['email'],
                  (isset($fields['firstname'][0])) ? $fields['firstname'][0] : '',
                  (isset($fields['lastname'][0])) ? $fields['lastname'][0] : '',
                  $record_info['telephone'],
                  $record_info['ip'],
                  $record_info['record_id'],
                  $fields_all,
                  date("Y-m-d H:i:s",strtotime($record_info['date_added'])),
                  $main_product,
                  $record_info['store_url'].'index.php?route=product/product&product_id='.$record_info['product_id'],
                  $product_info['name'],
                  ($option_info) ? $option_info['option_name'] : '',
                  ($option_info) ? $option_info['option_value'] : '',
                  $this->currency->format($current_price,$record_info['currency_code'],$record_info['currency_value']),
                  $record_info['referer'],
                  $record_info['user_agent'],
                  $record_info['accept_language'],
                  $record_info['store_name'],
                  $this->config->get('config_address'),
                  $this->config->get('config_email'),
                  $this->config->get('config_telephone'),
                  ($this->config->get('config_fax') != '') ? $this->config->get('config_fax') : '',
                  $record_info['store_url']
                ];

                $this->mailing_send($filter_data);
              }
            }

            if ($form_data['user_alert_status']) {
              if ($type == 'to_user_on_new_record_product') {
                $filter_data['set_to']      = $record_info['email'];
                $filter_data['template_id'] = $template_id = $form_data['user_email_template_product'];
                $template_info              = $this->getEmailTemplate($template_id);

                $main_product = $this->getProductMarkups(0,$template_info,$record_info,$product_info);

                // products_from_category
                if ($template_info['related_product_status'] == 1) {
                  $products_from_category = $this->getProductMarkups(1,$template_info,$record_info,$product_info);
                }

                // products_from_brand
                if ($template_info['related_product_status'] == 2) {
                  $products_from_brand = $this->getProductMarkups(2,$template_info,$record_info,$product_info);
                }

                // selected_products
                if ($template_info['related_product_status'] == 3) {
                  $selected_products = $this->getProductMarkups(3,$template_info,$record_info,$product_info);
                }

                // latest_products
                if ($template_info['related_product_status'] == 4) {
                  $latest_products = $this->getProductMarkups(4,$template_info,$record_info,$product_info);
                }

                // bestseller_products
                if ($template_info['related_product_status'] == 5) {
                  $bestseller_products = $this->getProductMarkups(5,$template_info,$record_info,$product_info);
                }

                // special_products
                if ($template_info['related_product_status'] == 6) {
                  $special_products = $this->getProductMarkups(6,$template_info,$record_info,$product_info);
                }

                // popular_products
                if ($template_info['related_product_status'] == 7) {
                  $popular_products = $this->getProductMarkups(7,$template_info,$record_info,$product_info);
                }

                // products_from_same_brand
                if ($template_info['related_product_status'] == 8) {
                  $products_from_same_brand = $this->getProductMarkups(8,$template_info,$record_info,$product_info);
                }

                // related_products
                if ($template_info['related_product_status'] == 9) {
                  $related_products = $this->getProductMarkups(9,$template_info,$record_info,$product_info);
                }

                // products_from_same_category
                if ($template_info['related_product_status'] == 10) {
                  $products_from_same_category = $this->getProductMarkups(10,$template_info,$record_info,$product_info);
                }

                $filter_data['tag_codes_subject'] = [
                  '{email}',
                  '{firstname}',
                  '{lastname}',
                  '{telephone}',
                  '{record_id}',
                  '{date_added}',
                  '{store_name}'
                ];

                $filter_data['tag_codes_replace_subject'] = [
                  $record_info['email'],
                  (isset($fields['firstname'][0])) ? $fields['firstname'][0] : '',
                  (isset($fields['lastname'][0])) ? $fields['lastname'][0] : '',
                  $record_info['telephone'],
                  $record_info['record_id'],
                  date("Y-m-d H:i:s",strtotime($record_info['date_added'])),
                  $record_info['store_name']
                ];

                $filter_data['tag_codes_template'] = [
                  '{email}',
                  '{firstname}',
                  '{lastname}',
                  '{telephone}',
                  '{record_id}',
                  '{fields}',
                  '{date_added}',
                  '{main_product_block}',
                  '{main_product_url}',
                  '{main_product_name}',
                  '{product_price}',
                  '{selected_products}',
                  '{products_from_category}',
                  '{latest_products}',
                  '{bestseller_products}',
                  '{special_products}',
                  '{popular_products}',
                  '{products_from_brand}',
                  '{products_from_same_brand}',
                  '{related_products}',
                  '{products_from_same_category}',
                  '{store_name}',
                  '{store_address}',
                  '{store_email}',
                  '{store_telephone}',
                  '{store_fax}',
                  '{store_url}'
                ];

                $filter_data['tag_codes_replace_template'] = [
                  $record_info['email'],
                  (isset($fields['firstname'][0])) ? $fields['firstname'][0] : '',
                  (isset($fields['lastname'][0])) ? $fields['lastname'][0] : '',
                  $record_info['telephone'],
                  $record_info['record_id'],
                  $fields_all,
                  date("Y-m-d H:i:s",strtotime($record_info['date_added'])),
                  $main_product,
                  $record_info['store_url'].'index.php?route=product/product&product_id='.$record_info['product_id'],
                  $product_info['name'],
                  $this->currency->format($current_price,$record_info['currency_code'],$record_info['currency_value']),
                  $selected_products,
                  $products_from_category,
                  $latest_products,
                  $bestseller_products,
                  $special_products,
                  $popular_products,
                  $products_from_brand,
                  $products_from_same_brand,
                  $related_products,
                  $products_from_same_category,
                  $record_info['store_name'],
                  $this->config->get('config_address'),
                  $this->config->get('config_email'),
                  $this->config->get('config_telephone'),
                  ($this->config->get('config_fax') != '') ? $this->config->get('config_fax') : '',
                  $record_info['store_url']
                ];

                $this->mailing_send($filter_data);
              }

              if ($type == 'to_user_on_new_record_product_option') {
                $filter_data['set_to']      = $record_info['email'];
                $filter_data['template_id'] = $template_id = $form_data['user_email_template_product_option'];
                $template_info              = $this->getEmailTemplate($template_id);

                $main_product = $this->getProductMarkups(0,$template_info,$record_info,$product_info);

                // products_from_category
                if ($template_info['related_product_status'] == 1) {
                  $products_from_category = $this->getProductMarkups(1,$template_info,$record_info,$product_info);
                }

                // products_from_brand
                if ($template_info['related_product_status'] == 2) {
                  $products_from_brand = $this->getProductMarkups(2,$template_info,$record_info,$product_info);
                }

                // selected_products
                if ($template_info['related_product_status'] == 3) {
                  $selected_products = $this->getProductMarkups(3,$template_info,$record_info,$product_info);
                }

                // latest_products
                if ($template_info['related_product_status'] == 4) {
                  $latest_products = $this->getProductMarkups(4,$template_info,$record_info,$product_info);
                }

                // bestseller_products
                if ($template_info['related_product_status'] == 5) {
                  $bestseller_products = $this->getProductMarkups(5,$template_info,$record_info,$product_info);
                }

                // special_products
                if ($template_info['related_product_status'] == 6) {
                  $special_products = $this->getProductMarkups(6,$template_info,$record_info,$product_info);
                }

                // popular_products
                if ($template_info['related_product_status'] == 7) {
                  $popular_products = $this->getProductMarkups(7,$template_info,$record_info,$product_info);
                }

                // products_from_same_brand
                if ($template_info['related_product_status'] == 8) {
                  $products_from_same_brand = $this->getProductMarkups(8,$template_info,$record_info,$product_info);
                }

                // related_products
                if ($template_info['related_product_status'] == 9) {
                  $related_products = $this->getProductMarkups(9,$template_info,$record_info,$product_info);
                }

                // products_from_same_category
                if ($template_info['related_product_status'] == 10) {
                  $products_from_same_category = $this->getProductMarkups(10,$template_info,$record_info,$product_info);
                }

                // products_from_same_brand_based_on_same_option
                if ($template_info['related_product_status'] == 11) {
                  $products_from_same_brand_based_on_same_option = $this->getProductMarkups(11,$template_info,$record_info,$product_info);
                }

                // related_products_based_on_same_option
                if ($template_info['related_product_status'] == 12) {
                  $related_products_based_on_same_option = $this->getProductMarkups(12,$template_info,$record_info,$product_info);
                }

                // products_from_same_category_based_on_same_option
                if ($template_info['related_product_status'] == 13) {
                  $products_from_same_category_based_on_same_option = $this->getProductMarkups(13,$template_info,$record_info,$product_info);
                }

                $filter_data['tag_codes_subject'] = [
                  '{email}',
                  '{firstname}',
                  '{lastname}',
                  '{telephone}',
                  '{record_id}',
                  '{date_added}',
                  '{store_name}'
                ];

                $filter_data['tag_codes_replace_subject'] = [
                  $record_info['email'],
                  (isset($fields['firstname'][0])) ? $fields['firstname'][0] : '',
                  (isset($fields['lastname'][0])) ? $fields['lastname'][0] : '',
                  $record_info['telephone'],
                  $record_info['record_id'],
                  date("Y-m-d H:i:s",strtotime($record_info['date_added'])),
                  $record_info['store_name']
                ];

                $filter_data['tag_codes_template'] = [
                  '{email}',
                  '{firstname}',
                  '{lastname}',
                  '{telephone}',
                  '{record_id}',
                  '{fields}',
                  '{date_added}',
                  '{main_product_block}',
                  '{main_product_url}',
                  '{main_product_name}',
                  '{option_name}',
                  '{option_value}',
                  '{product_option_price}',
                  '{selected_products}',
                  '{products_from_category}',
                  '{latest_products}',
                  '{bestseller_products}',
                  '{special_products}',
                  '{popular_products}',
                  '{products_from_brand}',
                  '{products_from_same_brand}',
                  '{related_products}',
                  '{products_from_same_category}',
                  '{products_from_same_brand_based_on_same_option}',
                  '{related_products_based_on_same_option}',
                  '{products_from_same_category_based_on_same_option}',
                  '{store_name}',
                  '{store_address}',
                  '{store_email}',
                  '{store_telephone}',
                  '{store_fax}',
                  '{store_url}'
                ];

                $filter_data['tag_codes_replace_template'] = [
                  $record_info['email'],
                  (isset($fields['firstname'][0])) ? $fields['firstname'][0] : '',
                  (isset($fields['lastname'][0])) ? $fields['lastname'][0] : '',
                  $record_info['telephone'],
                  $record_info['record_id'],
                  $fields_all,
                  date("Y-m-d H:i:s",strtotime($record_info['date_added'])),
                  $main_product,
                  $record_info['store_url'].'index.php?route=product/product&product_id='.$record_info['product_id'],
                  $product_info['name'],
                  ($option_info) ? $option_info['option_name'] : '',
                  ($option_info) ? $option_info['option_value'] : '',
                  $this->currency->format($current_price,$record_info['currency_code'],$record_info['currency_value']),
                  $selected_products,
                  $products_from_category,
                  $latest_products,
                  $bestseller_products,
                  $special_products,
                  $popular_products,
                  $products_from_brand,
                  $products_from_same_brand,
                  $related_products,
                  $products_from_same_category,
                  $products_from_same_brand_based_on_same_option,
                  $related_products_based_on_same_option,
                  $products_from_same_category_based_on_same_option,
                  $record_info['store_name'],
                  $this->config->get('config_address'),
                  $this->config->get('config_email'),
                  $this->config->get('config_telephone'),
                  ($this->config->get('config_fax') != '') ? $this->config->get('config_fax') : '',
                  $record_info['store_url']
                ];

                $this->mailing_send($filter_data);
              }
            }

            if ($type == 'to_user_when_product_price_was_changed' && in_array($form_data['notification_type'],[1,3])) {
              $filter_data['set_to']      = $record_info['email'];
              $filter_data['template_id'] = $template_id = $form_data['user_email_template_product_price_was_changed'];
              $template_info              = $this->getEmailTemplate($template_id);
              $coupon_info                = $this->getCouponById($form_data['gift_coupon']);
              $voucher_info               = $this->getVoucherById($form_data['gift_voucher']);

              $main_product = $this->getProductMarkups(0,$template_info,$record_info,$product_info);

              // products_from_category
              if ($template_info['related_product_status'] == 1) {
                $products_from_category = $this->getProductMarkups(1,$template_info,$record_info,$product_info);
              }

              // products_from_brand
              if ($template_info['related_product_status'] == 2) {
                $products_from_brand = $this->getProductMarkups(2,$template_info,$record_info,$product_info);
              }

              // selected_products
              if ($template_info['related_product_status'] == 3) {
                $selected_products = $this->getProductMarkups(3,$template_info,$record_info,$product_info);
              }

              // latest_products
              if ($template_info['related_product_status'] == 4) {
                $latest_products = $this->getProductMarkups(4,$template_info,$record_info,$product_info);
              }

              // bestseller_products
              if ($template_info['related_product_status'] == 5) {
                $bestseller_products = $this->getProductMarkups(5,$template_info,$record_info,$product_info);
              }

              // special_products
              if ($template_info['related_product_status'] == 6) {
                $special_products = $this->getProductMarkups(6,$template_info,$record_info,$product_info);
              }

              // popular_products
              if ($template_info['related_product_status'] == 7) {
                $popular_products = $this->getProductMarkups(7,$template_info,$record_info,$product_info);
              }

              // products_from_same_brand
              if ($template_info['related_product_status'] == 8) {
                $products_from_same_brand = $this->getProductMarkups(8,$template_info,$record_info,$product_info);
              }

              // related_products
              if ($template_info['related_product_status'] == 9) {
                $related_products = $this->getProductMarkups(9,$template_info,$record_info,$product_info);
              }

              // products_from_same_category
              if ($template_info['related_product_status'] == 10) {
                $products_from_same_category = $this->getProductMarkups(10,$template_info,$record_info,$product_info);
              }

              $filter_data['tag_codes_subject'] = [
                '{email}',
                '{firstname}',
                '{lastname}',
                '{telephone}',
                '{record_id}',
                '{date_added}',
                '{store_name}'
              ];

              $filter_data['tag_codes_replace_subject'] = [
                $record_info['email'],
                (isset($fields['firstname'][0])) ? $fields['firstname'][0] : '',
                (isset($fields['lastname'][0])) ? $fields['lastname'][0] : '',
                $record_info['telephone'],
                $record_info['record_id'],
                date("Y-m-d H:i:s",strtotime($record_info['date_added'])),
                $record_info['store_name']
              ];

              $filter_data['tag_codes_template'] = [
                '{email}',
                '{firstname}',
                '{lastname}',
                '{telephone}',
                '{record_id}',
                '{date_added}',
                '{main_product_block}',
                '{main_product_url}',
                '{main_product_name}',
                '{product_price}',
                '{unsubscribe_url}',
                '{selected_products}',
                '{products_from_category}',
                '{latest_products}',
                '{bestseller_products}',
                '{special_products}',
                '{popular_products}',
                '{products_from_brand}',
                '{products_from_same_brand}',
                '{related_products}',
                '{products_from_same_category}',
                '{gift_coupon_code}',
                '{gift_voucher_code}',
                '{store_name}',
                '{store_address}',
                '{store_email}',
                '{store_telephone}',
                '{store_fax}',
                '{store_url}'
              ];

              $filter_data['tag_codes_replace_template'] = [
                $record_info['email'],
                (isset($fields['firstname'][0])) ? $fields['firstname'][0] : '',
                (isset($fields['lastname'][0])) ? $fields['lastname'][0] : '',
                $record_info['telephone'],
                $record_info['record_id'],
                date("Y-m-d H:i:s",strtotime($record_info['date_added'])),
                $main_product,
                $record_info['store_url'].'index.php?route=product/product&product_id='.$record_info['product_id'],
                $product_info['name'],
                $this->currency->format($current_price,$record_info['currency_code'],$record_info['currency_value']),
                $record_info['store_url'].'index.php?route=extension/ocdevwizard/'.$this->_name.'/actions&token='.$record_info['token'],
                $selected_products,
                $products_from_category,
                $latest_products,
                $bestseller_products,
                $special_products,
                $popular_products,
                $products_from_brand,
                $products_from_same_brand,
                $related_products,
                $products_from_same_category,
                ($coupon_info) ? $coupon_info['code'] : '',
                ($voucher_info) ? $voucher_info['code'] : '',
                $record_info['store_name'],
                $this->config->get('config_address'),
                $this->config->get('config_email'),
                $this->config->get('config_telephone'),
                ($this->config->get('config_fax') != '') ? $this->config->get('config_fax') : '',
                $record_info['store_url']
              ];

              $this->mailing_send($filter_data);
            }

            if ($type == 'to_user_when_product_price_was_changed' && in_array($form_data['notification_type'],[2,3])) {
              $filter_data['set_to']      = preg_replace("/[^0-9]/","",$record_info['telephone']);
              $filter_data['template_id'] = $form_data['user_sms_template_product_price_was_changed'];
              $filter_data['sms_gate']    = $form_data['sms_gate'];

              if ($form_data['sms_gate'] == 1) {
                $filter_data['api_key'] = $form_data['smsru_api'];
                $filter_data['from']    = $form_data['smsru_from'];
              } else if ($form_data['sms_gate'] == 2) {
                $filter_data['login'] = $form_data['smscabru_login'];
                $filter_data['psw']   = $form_data['smscabru_password'];
                $filter_data['from']  = $form_data['smscabru_from'];
              } else if ($form_data['sms_gate'] == 3) {
                $filter_data['login'] = $form_data['smscua_login'];
                $filter_data['psw']   = $form_data['smscua_password'];
                $filter_data['from']  = $form_data['smscua_from'];
              } else if ($form_data['sms_gate'] == 4) {
                $filter_data['login'] = $form_data['turbosmsua_login'];
                $filter_data['psw']   = $form_data['turbosmsua_password'];
                $filter_data['from']  = $form_data['turbosmsua_from'];
              }

              $filter_data['tag_codes_subject']         = [];
              $filter_data['tag_codes_replace_subject'] = [];

              $filter_data['tag_codes_template'] = [
                '{email}',
                '{firstname}',
                '{lastname}',
                '{telephone}',
                '{record_id}',
                '{date_added}',
                '{main_product_url}',
                '{main_product_name}',
                '{product_price}',
                '{unsubscribe_url}',
                '{store_name}',
                '{store_address}',
                '{store_email}',
                '{store_telephone}',
                '{store_fax}',
                '{store_url}'
              ];

              $filter_data['tag_codes_replace_template'] = [
                $record_info['email'],
                (isset($fields['firstname'][0])) ? $fields['firstname'][0] : '',
                (isset($fields['lastname'][0])) ? $fields['lastname'][0] : '',
                $record_info['telephone'],
                $record_info['record_id'],
                date("Y-m-d H:i:s",strtotime($record_info['date_added'])),
                $record_info['store_url'].'index.php?route=product/product&product_id='.$record_info['product_id'],
                ($product_info) ? $product_info['name'] : '',
                $this->currency->format($current_price,$record_info['currency_code'],$record_info['currency_value']),
                $record_info['store_url'].'index.php?route=extension/ocdevwizard/'.$this->_name.'/actions&token='.$record_info['token'],
                $record_info['store_name'],
                $this->config->get('config_address'),
                $this->config->get('config_email'),
                $this->config->get('config_telephone'),
                ($this->config->get('config_fax') != '') ? $this->config->get('config_fax') : '',
                $record_info['store_url']
              ];

              $this->sms_send($filter_data);
            }

            if ($type == 'to_user_when_product_option_price_was_changed' && in_array($form_data['notification_type'],[1,3])) {
              $filter_data['set_to']      = $record_info['email'];
              $filter_data['template_id'] = $template_id = $form_data['user_email_template_product_option_price_was_changed'];
              $template_info              = $this->getEmailTemplate($template_id);
              $coupon_info                = $this->getCouponById($form_data['gift_coupon']);
              $voucher_info               = $this->getVoucherById($form_data['gift_voucher']);

              $main_product = $this->getProductMarkups(0,$template_info,$record_info,$product_info);

              // products_from_category
              if ($template_info['related_product_status'] == 1) {
                $products_from_category = $this->getProductMarkups(1,$template_info,$record_info,$product_info);
              }

              // products_from_brand
              if ($template_info['related_product_status'] == 2) {
                $products_from_brand = $this->getProductMarkups(2,$template_info,$record_info,$product_info);
              }

              // selected_products
              if ($template_info['related_product_status'] == 3) {
                $selected_products = $this->getProductMarkups(3,$template_info,$record_info,$product_info);
              }

              // latest_products
              if ($template_info['related_product_status'] == 4) {
                $latest_products = $this->getProductMarkups(4,$template_info,$record_info,$product_info);
              }

              // bestseller_products
              if ($template_info['related_product_status'] == 5) {
                $bestseller_products = $this->getProductMarkups(5,$template_info,$record_info,$product_info);
              }

              // special_products
              if ($template_info['related_product_status'] == 6) {
                $special_products = $this->getProductMarkups(6,$template_info,$record_info,$product_info);
              }

              // popular_products
              if ($template_info['related_product_status'] == 7) {
                $popular_products = $this->getProductMarkups(7,$template_info,$record_info,$product_info);
              }

              // products_from_same_brand
              if ($template_info['related_product_status'] == 8) {
                $products_from_same_brand = $this->getProductMarkups(8,$template_info,$record_info,$product_info);
              }

              // related_products
              if ($template_info['related_product_status'] == 9) {
                $related_products = $this->getProductMarkups(9,$template_info,$record_info,$product_info);
              }

              // products_from_same_category
              if ($template_info['related_product_status'] == 10) {
                $products_from_same_category = $this->getProductMarkups(10,$template_info,$record_info,$product_info);
              }

              // products_from_same_brand_based_on_same_option
              if ($template_info['related_product_status'] == 11) {
                $products_from_same_brand_based_on_same_option = $this->getProductMarkups(11,$template_info,$record_info,$product_info);
              }

              // related_products_based_on_same_option
              if ($template_info['related_product_status'] == 12) {
                $related_products_based_on_same_option = $this->getProductMarkups(12,$template_info,$record_info,$product_info);
              }

              // products_from_same_category_based_on_same_option
              if ($template_info['related_product_status'] == 13) {
                $products_from_same_category_based_on_same_option = $this->getProductMarkups(13,$template_info,$record_info,$product_info);
              }

              $filter_data['tag_codes_subject'] = [
                '{email}',
                '{firstname}',
                '{lastname}',
                '{telephone}',
                '{record_id}',
                '{date_added}',
                '{store_name}'
              ];

              $filter_data['tag_codes_replace_subject'] = [
                $record_info['email'],
                (isset($fields['firstname'][0])) ? $fields['firstname'][0] : '',
                (isset($fields['lastname'][0])) ? $fields['lastname'][0] : '',
                $record_info['telephone'],
                $record_info['record_id'],
                date("Y-m-d H:i:s",strtotime($record_info['date_added'])),
                $record_info['store_name']
              ];

              $filter_data['tag_codes_template'] = [
                '{email}',
                '{firstname}',
                '{lastname}',
                '{telephone}',
                '{record_id}',
                '{date_added}',
                '{main_product_block}',
                '{main_product_url}',
                '{main_product_name}',
                '{option_name}',
                '{option_value}',
                '{product_option_price}',
                '{unsubscribe_url}',
                '{selected_products}',
                '{products_from_category}',
                '{latest_products}',
                '{bestseller_products}',
                '{special_products}',
                '{popular_products}',
                '{products_from_brand}',
                '{products_from_same_brand}',
                '{related_products}',
                '{products_from_same_category}',
                '{products_from_same_brand_based_on_same_option}',
                '{related_products_based_on_same_option}',
                '{products_from_same_category_based_on_same_option}',
                '{gift_coupon_code}',
                '{gift_voucher_code}',
                '{store_name}',
                '{store_address}',
                '{store_email}',
                '{store_telephone}',
                '{store_fax}',
                '{store_url}'
              ];

              $filter_data['tag_codes_replace_template'] = [
                $record_info['email'],
                (isset($fields['firstname'][0])) ? $fields['firstname'][0] : '',
                (isset($fields['lastname'][0])) ? $fields['lastname'][0] : '',
                $record_info['telephone'],
                $record_info['record_id'],
                date("Y-m-d H:i:s",strtotime($record_info['date_added'])),
                $main_product,
                $record_info['store_url'].'index.php?route=product/product&product_id='.$record_info['product_id'],
                $product_info['name'],
                ($option_info) ? $option_info['option_name'] : '',
                ($option_info) ? $option_info['option_value'] : '',
                $this->currency->format($current_price,$record_info['currency_code'],$record_info['currency_value']),
                $record_info['store_url'].'index.php?route=extension/ocdevwizard/'.$this->_name.'/actions&token='.$record_info['token'],
                $selected_products,
                $products_from_category,
                $latest_products,
                $bestseller_products,
                $special_products,
                $popular_products,
                $products_from_brand,
                $products_from_same_brand,
                $related_products,
                $products_from_same_category,
                $products_from_same_brand_based_on_same_option,
                $related_products_based_on_same_option,
                $products_from_same_category_based_on_same_option,
                ($coupon_info) ? $coupon_info['code'] : '',
                ($voucher_info) ? $voucher_info['code'] : '',
                $record_info['store_name'],
                $this->config->get('config_address'),
                $this->config->get('config_email'),
                $this->config->get('config_telephone'),
                ($this->config->get('config_fax') != '') ? $this->config->get('config_fax') : '',
                $record_info['store_url']
              ];

              $this->mailing_send($filter_data);
            }

            if ($type == 'to_user_when_product_option_price_was_changed' && in_array($form_data['notification_type'],[2,3])) {
              $filter_data['set_to']      = preg_replace("/[^0-9]/","",$record_info['telephone']);
              $filter_data['template_id'] = $form_data['user_sms_template_product_option_price_was_changed'];
              $filter_data['sms_gate']    = $form_data['sms_gate'];

              if ($form_data['sms_gate'] == 1) {
                $filter_data['api_key'] = $form_data['smsru_api'];
                $filter_data['from']    = $form_data['smsru_from'];
              } else if ($form_data['sms_gate'] == 2) {
                $filter_data['login'] = $form_data['smscabru_login'];
                $filter_data['psw']   = $form_data['smscabru_password'];
                $filter_data['from']  = $form_data['smscabru_from'];
              } else if ($form_data['sms_gate'] == 3) {
                $filter_data['login'] = $form_data['smscua_login'];
                $filter_data['psw']   = $form_data['smscua_password'];
                $filter_data['from']  = $form_data['smscua_from'];
              } else if ($form_data['sms_gate'] == 4) {
                $filter_data['login'] = $form_data['turbosmsua_login'];
                $filter_data['psw']   = $form_data['turbosmsua_password'];
                $filter_data['from']  = $form_data['turbosmsua_from'];
              }

              $filter_data['tag_codes_subject']         = [];
              $filter_data['tag_codes_replace_subject'] = [];

              $filter_data['tag_codes_template'] = [
                '{email}',
                '{firstname}',
                '{lastname}',
                '{telephone}',
                '{record_id}',
                '{date_added}',
                '{main_product_url}',
                '{main_product_name}',
                '{option_name}',
                '{option_value}',
                '{product_option_price}',
                '{unsubscribe_url}',
                '{store_name}',
                '{store_address}',
                '{store_email}',
                '{store_telephone}',
                '{store_fax}',
                '{store_url}'
              ];

              $filter_data['tag_codes_replace_template'] = [
                $record_info['email'],
                (isset($fields['firstname'][0])) ? $fields['firstname'][0] : '',
                (isset($fields['lastname'][0])) ? $fields['lastname'][0] : '',
                $record_info['telephone'],
                $record_info['record_id'],
                date("Y-m-d H:i:s",strtotime($record_info['date_added'])),
                $record_info['store_url'].'index.php?route=product/product&product_id='.$record_info['product_id'],
                ($product_info) ? $product_info['name'] : '',
                ($option_info) ? $option_info['option_name'] : '',
                ($option_info) ? $option_info['option_value'] : '',
                $this->currency->format($current_price,$record_info['currency_code'],$record_info['currency_value']),
                $record_info['store_url'].'index.php?route=extension/ocdevwizard/'.$this->_name.'/actions&token='.$record_info['token'],
                $record_info['store_name'],
                $this->config->get('config_address'),
                $this->config->get('config_email'),
                $this->config->get('config_telephone'),
                ($this->config->get('config_fax') != '') ? $this->config->get('config_fax') : '',
                $record_info['store_url']
              ];

              $this->sms_send($filter_data);
            }
          }
        }
      }
    }
  }

  private function mailing_send($data) {
    if ($data) {
      $html_data = [];

      $template_description = $this->getEmailTemplateDescription($data['template_id']);

      if ($template_description) {
        $html_data['title']         = $setSubject = html_entity_decode(str_replace($data['tag_codes_subject'],$data['tag_codes_replace_subject'],$template_description[$data['user_language_id']]['subject']),ENT_QUOTES,'UTF-8');
        $html_data['html_template'] = html_entity_decode(str_replace($data['tag_codes_template'],$data['tag_codes_replace_template'],$template_description[$data['user_language_id']]['template']),ENT_QUOTES,'UTF-8');

        if (version_compare(VERSION,'2.1.0.2.1','<=')) {
          if (file_exists(DIR_TEMPLATE.$this->config->get('config_template').'/template/extension/ocdevwizard/'.$this->_name.'/email_template.tpl')) {
            $setHtml = $this->load->view($this->config->get('config_template').'/template/extension/ocdevwizard/'.$this->_name.'/email_template.tpl',$html_data);
          } else {
            $setHtml = $this->load->view('default/template/extension/ocdevwizard/'.$this->_name.'/email_template.tpl',$html_data);
          }
        } else if (version_compare(VERSION,'3.0.0.0','>=')) {
          $setHtml = $this->load->view('extension/ocdevwizard/'.$this->_name.'/email_template',$html_data);
        } else {
          $setHtml = $this->load->view('extension/ocdevwizard/'.$this->_name.'/email_template.tpl',$html_data);
        }

        // email notification
        if (version_compare(VERSION,'2.0.1.1','<=')) {
          $mail = new Mail($this->config->get('config_mail'));
        } else if (version_compare(VERSION,'2.0.2.0','>=') && version_compare(VERSION,'2.0.3.1','<')) {
          $mail                = new Mail();
          $mail->protocol      = $this->config->get('config_mail_protocol');
          $mail->parameter     = $this->config->get('config_mail_parameter');
          $mail->smtp_hostname = $this->config->get('config_mail_smtp_host');
          $mail->smtp_username = $this->config->get('config_mail_smtp_username');
          $mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'),ENT_QUOTES,'UTF-8');
          $mail->smtp_port     = $this->config->get('config_mail_smtp_port');
          $mail->smtp_timeout  = $this->config->get('config_mail_smtp_timeout');
        } else if (version_compare(VERSION,'3.0.0.0','>=')) {
          $mail                = new Mail($this->config->get('config_mail_engine'));
          $mail->parameter     = $this->config->get('config_mail_parameter');
          $mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
          $mail->smtp_username = $this->config->get('config_mail_smtp_username');
          $mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'),ENT_QUOTES,'UTF-8');
          $mail->smtp_port     = $this->config->get('config_mail_smtp_port');
          $mail->smtp_timeout  = $this->config->get('config_mail_smtp_timeout');
        } else {
          $mail                = new Mail();
          $mail->protocol      = $this->config->get('config_mail_protocol');
          $mail->parameter     = $this->config->get('config_mail_parameter');
          $mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
          $mail->smtp_username = $this->config->get('config_mail_smtp_username');
          $mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'),ENT_QUOTES,'UTF-8');
          $mail->smtp_port     = $this->config->get('config_mail_smtp_port');
          $mail->smtp_timeout  = $this->config->get('config_mail_smtp_timeout');
        }

        $mail->setFrom($this->config->get('config_email'));
        $mail->setSender($data['store_name']);
        $mail->setSubject($setSubject);
        $mail->setHtml($setHtml);

        if (isset($data['set_to_multi']) && $data['set_to_multi']) {
          if ($data['set_to']) {
            $emails = explode(',',$data['set_to']);

            foreach ($emails as $email) {
              $mail->setTo($email);
              $mail->send();
            }
          }
        } else {
          $mail->setTo($data['set_to']);
          $mail->send();
        }
      }
    }
  }

  private function sms_send($data) {
    if ($data) {
      $template_description = $this->getSmsTemplateDescription($data['template_id']);

      if ($template_description) {
        $sms_template = html_entity_decode(str_replace($data['tag_codes_template'],$data['tag_codes_replace_template'],$template_description[$data['user_language_id']]['template']),ENT_QUOTES,'UTF-8');

        if ($data['sms_gate'] == 1) {
          $curl = curl_init();

          curl_setopt($curl,CURLOPT_URL,'https://sms.ru/sms/send');
          curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
          curl_setopt($curl,CURLOPT_TIMEOUT,30);
          curl_setopt($curl,CURLOPT_POSTFIELDS,http_build_query([
            'api_id'     => $data['api_key'],
            'to'         => $data['set_to'],
            'msg'        => $sms_template,
            'from'       => $data['from'],
            'partner_id' => '281833'
          ]));

          curl_exec($curl);
          curl_close($curl);
        }

        if ($data['sms_gate'] == 2) {
          $curl = curl_init();

          curl_setopt($curl,CURLOPT_URL,'http://my.smscab.ru/sys/send.php');
          curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
          curl_setopt($curl,CURLOPT_TIMEOUT,30);
          curl_setopt($curl,CURLOPT_POSTFIELDS,http_build_query([
            'login'  => $data['login'],
            'psw'    => $data['psw'],
            'phones' => $data['set_to'],
            'mes'    => $sms_template,
            'sender' => $data['from']
          ]));

          curl_exec($curl);
          curl_close($curl);
        }

        if ($data['sms_gate'] == 3) {
          $curl = curl_init();

          curl_setopt($curl,CURLOPT_URL,'https://smsc.ua/sys/send.php');
          curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
          curl_setopt($curl,CURLOPT_TIMEOUT,30);
          curl_setopt($curl,CURLOPT_POSTFIELDS,http_build_query([
            'login'  => $data['login'],
            'psw'    => $data['psw'],
            'phones' => $data['set_to'],
            'mes'    => $sms_template,
            'sender' => $data['from']
          ]));

          curl_exec($curl);
          curl_close($curl);
        }

        if ($data['sms_gate'] == 4) {
          $client = new SoapClient('http://turbosms.in.ua/api/wsdl.html');

          $auth = [
            'login'    => $data['login'],
            'password' => $data['psw']
          ];

          $client->Auth($auth);

          $sms = [
            'sender'      => $data['from'],
            'destination' => $data['set_to'],
            'text'        => $sms_template
          ];

          $client->SendSMS($sms);
        }
      }
    }
  }
}

?>