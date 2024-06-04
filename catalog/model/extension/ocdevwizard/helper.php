<?php
##========================================================##
## @author    : OCdevWizard                               ##
## @contact   : ocdevwizard@gmail.com                     ##
## @support   : http://help.ocdevwizard.com               ##
## @license   : Distributed on an "AS IS" basis           ##
## @copyright : (c) OCdevWizard. OCdevWizard Helper, 2014 ##
##========================================================##
class ModelExtensionOcdevwizardHelper extends Model {
  public function getSettingData($key,$store_id = 0) {
    $setting_data = $this->registry->get('ocdw_'.$key.'_'.$store_id);

    if (!$setting_data) {
      if ($this->checkTableExist(DB_PREFIX."ocdevwizard_setting")) {
        $query = $this->db->query("SELECT * FROM ".DB_PREFIX."ocdevwizard_setting WHERE store_id = '".(int)$store_id."' AND `key` = '".$this->db->escape($key)."'")->rows;

        foreach ($query as $result) {
          $setting_data = (!$result['serialized']) ? $result['value'] : json_decode($result['value'],true);
        }

        $this->registry->set('ocdw_'.$key.'_'.$store_id,$setting_data);
      }
    }

    return $setting_data;
  }

  public function editSetting($code,$data,$store_id = 0) {
    $this->db->query("DELETE FROM ".DB_PREFIX."ocdevwizard_setting WHERE store_id = '".(int)$store_id."' AND `code` = '".$this->db->escape($code)."'");

    foreach ($data as $key => $value) {
      if (substr($key,0,strlen($code)) == $code) {
        if (!is_array($value)) {
          $this->db->query("INSERT INTO ".DB_PREFIX."ocdevwizard_setting SET store_id = '".(int)$store_id."', `code` = '".$this->db->escape($code)."', `key` = '".$this->db->escape($key)."', `value` = '".$this->db->escape($value)."'");
        } else {
          $this->db->query("INSERT INTO ".DB_PREFIX."ocdevwizard_setting SET store_id = '".(int)$store_id."', `code` = '".$this->db->escape($code)."', `key` = '".$this->db->escape($key)."', `value` = '".$this->db->escape(json_encode($value))."', serialized = '1'");
        }
      }
    }
  }

  public function deleteSetting($code,$store_id = 0) {
    $this->db->query("DELETE FROM ".DB_PREFIX."ocdevwizard_setting WHERE store_id = '".(int)$store_id."' AND `code` = '".$this->db->escape($code)."'");
  }

  public function editSettingValue($code = '',$key = '',$value = '',$store_id = 0) {
    if (!is_array($value)) {
      $this->db->query("UPDATE ".DB_PREFIX."ocdevwizard_setting SET `value` = '".$this->db->escape($value)."', serialized = '0'  WHERE `code` = '".$this->db->escape($code)."' AND `key` = '".$this->db->escape($key)."' AND store_id = '".(int)$store_id."'");
    } else {
      $this->db->query("UPDATE ".DB_PREFIX."ocdevwizard_setting SET `value` = '".$this->db->escape(json_encode($value))."', serialized = '1' WHERE `code` = '".$this->db->escape($code)."' AND `key` = '".$this->db->escape($key)."' AND store_id = '".(int)$store_id."'");
    }
  }

  public function checkTableExist($table_name) {
    return $this->db->query("SELECT COUNT(*) as total FROM information_schema.TABLES WHERE TABLE_SCHEMA = '".$this->db->escape(DB_DATABASE)."' AND TABLE_NAME = '".$this->db->escape($table_name)."'")->row['total'];
  }
}
