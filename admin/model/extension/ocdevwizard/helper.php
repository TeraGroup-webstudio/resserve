<?php
##========================================================##
## @author    : OCdevWizard                               ##
## @contact   : ocdevwizard@gmail.com                     ##
## @support   : http://help.ocdevwizard.com               ##
## @license   : Distributed on an "AS IS" basis           ##
## @copyright : (c) OCdevWizard. OCdevWizard Helper, 2014 ##
##========================================================##
libxml_use_internal_errors(true);

class ModelExtensionOcdevwizardHelper extends Model {
  private $_name = 'helper';
  private $_version;
  private $_session_token;
  private $_ssl_code;

  public function __construct($registry) {
    parent::__construct($registry);

    if (version_compare(VERSION,'2.2.0.0','>=')) {
      $this->_ssl_code = true;
    } else {
      $this->_ssl_code = 'SSL';
    }

    if (version_compare(VERSION,'3.0.0.0','>=')) {
      $this->_session_token = 'user_token='.((isset($this->session->data['user_token']) && $this->session->data['user_token']) ? $this->session->data['user_token'] : '');
    } else {
      $this->_session_token = 'token='.((isset($this->session->data['token']) && $this->session->data['token']) ? $this->session->data['token'] : '');
    }
  }

  public function getOCdevCatalog($type = '') {
    $catalog = [];

    $module_files = [];

    $files = glob(DIR_APPLICATION.'controller/extension/ocdevwizard/*.php',GLOB_BRACE);

    foreach ($files as $file) {
      $module_files[] = basename($file,'.php');
    }

    $curl = curl_init();

    curl_setopt($curl,CURLOPT_URL,'http://ocdevwizard.com/products/share/share.xml');
    curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($curl,CURLOPT_HEADER,0);

    $response_data = curl_exec($curl);
    $httpcode_data = curl_getinfo($curl,CURLINFO_HTTP_CODE);

    curl_close($curl);

    $results = simplexml_load_string($response_data);

    if ($httpcode_data == 200 && !empty($response_data) && $results !== false) {
      $i = 0;
      foreach ($results->product as $product) {
        $language = substr($this->request->server['HTTP_ACCEPT_LANGUAGE'],0,2);

        if ($type == 'installed') {
          if (in_array($product->long_name,$module_files)) {
            $catalog[] = [
              'extension_id' => (int)$product->extension_id,
              'title'        => (string)$product->title,
              'img'          => (string)$product->img,
              'date_added'   => (string)$product->date_added,
              'href'         => $this->url->link('extension/ocdevwizard/'.(string)$product->long_name,$this->_session_token,$this->_ssl_code),
              'compatible'   => (in_array(VERSION,explode(',',str_replace(' ','',(string)$product->opencart_version)))) ? 1 : 0
            ];
          }
        }

        if ($type == 'available_update') {
          $version = '';

          if (file_exists(DIR_SYSTEM.'library/ocdevwizard/'.(string)$product->long_name) && is_dir(DIR_SYSTEM.'library/ocdevwizard/'.(string)$product->long_name)) {
            if (file_exists(DIR_SYSTEM.'library/ocdevwizard/'.(string)$product->long_name.'/'.(string)$product->short_name.'.version')) {
              $version_array = json_decode(file_get_contents(DIR_SYSTEM.'library/ocdevwizard/'.(string)$product->long_name.'/'.(string)$product->short_name.'.version'),true);

              if ($version_array) {
                $version = $version_array['module'];
              }
            }
          }

          if (in_array($product->long_name,$module_files) && $version && version_compare((string)$product->latest_version,$version,'>')) {
            $catalog[] = [
              'extension_id'     => (int)$product->extension_id,
              'title'            => (string)$product->title,
              'img'              => (string)$product->img,
              'price'            => (string)$product->price,
              'url'              => (string)str_replace("&amp;","&",$product->url),
              'date_added'       => (string)$product->date_added,
              'opencart_version' => (string)$product->opencart_version,
              'latest_version'   => (string)$product->latest_version,
              'version_compare'  => version_compare($this->_version,(string)$product->latest_version),
              'features'         => (in_array($language,[
                  'ru',
                  'uk'
                ]) && $product->{'features_'.$language}) ? (string)$product->{'features_'.$language} : (string)$product->features,
              'short_name'       => (string)$product->short_name,
              'long_name'        => (string)$product->long_name,
              'href'             => $this->url->link('extension/ocdevwizard/'.(string)$product->long_name,$this->_session_token,$this->_ssl_code),
              'compatible'       => (in_array(VERSION,explode(',',str_replace(' ','',(string)$product->opencart_version)))) ? 1 : 0
            ];
          }
        }

        if ($type == 'available_upgrade') {
          $catalog[] = [
            'extension_id'     => (int)$product->extension_id,
            'title'            => (string)$product->title,
            'img'              => (string)$product->img,
            'price'            => (string)$product->price,
            'url'              => (string)str_replace("&amp;","&",$product->url),
            'date_added'       => (string)$product->date_added,
            'opencart_version' => (string)$product->opencart_version,
            'latest_version'   => (string)$product->latest_version,
            'version_compare'  => version_compare($this->_version,(string)$product->latest_version),
            'features'         => (in_array($language,[
                'ru',
                'uk'
              ]) && $product->{'features_'.$language}) ? (string)$product->{'features_'.$language} : (string)$product->features,
            'short_name'       => (string)$product->short_name,
            'long_name'        => (string)$product->long_name,
            'href'             => $this->url->link('extension/ocdevwizard/'.(string)$product->long_name,$this->_session_token,$this->_ssl_code),
            'compatible'       => (in_array(VERSION,explode(',',str_replace(' ','',(string)$product->opencart_version)))) ? 1 : 0
          ];
        }

        if ($type == 'available') {
          if (!in_array($product->long_name,$module_files)) {
            $catalog[] = [
              'extension_id' => (int)$product->extension_id,
              'title'        => (string)$product->title,
              'img'          => (string)$product->img,
              'date_added'   => (string)$product->date_added,
              'compatible'   => (in_array(VERSION,explode(',',str_replace(' ','',(string)$product->opencart_version)))) ? 1 : 0
            ];
          }
        }

        if ($type == 'get_info') {
          $marketplaces = [];

          if ($product->marketplace) {
            foreach ($product->marketplace as $marketplace) {
              if ($marketplace->item) {
                foreach ($marketplace->item as $item) {
                  $marketplaces[] = $item;
                }
              }
            }
          }

          $catalog[] = [
            'extension_id'     => (int)$product->extension_id,
            'title'            => (string)$product->title,
            'img'              => (string)$product->img,
            'price'            => (string)$product->price,
            'url'              => (string)str_replace("&amp;","&",$product->url),
            'date_added'       => (string)$product->date_added,
            'opencart_version' => (string)$product->opencart_version,
            'latest_version'   => (string)$product->latest_version,
            'version_compare'  => version_compare($this->_version,(string)$product->latest_version),
            'features'         => (in_array($language,[
                'ru',
                'uk'
              ]) && $product->{'features_'.$language}) ? (string)$product->{'features_'.$language} : (string)$product->features,
            'short_name'       => (string)$product->short_name,
            'long_name'        => (string)$product->long_name,
            'href'             => $this->url->link('extension/ocdevwizard/'.(string)$product->long_name,$this->_session_token,$this->_ssl_code),
            'compatible'       => (in_array(VERSION,explode(',',str_replace(' ','',(string)$product->opencart_version)))) ? 1 : 0,
            'marketplaces'     => $marketplaces
          ];
        }
      }

      if ($type == 'available_upgrade') {
        $catalog2 = [];

        foreach ($catalog as $key => $cat) {
          foreach ($module_files as $module_file) {
            if (!preg_match('/_plus$/',$module_file)) {
              $id = array_search($module_file.'_plus',array_column($catalog,'long_name'));

              if ($id && $id == $key) {
                $catalog2[] = $cat;
              }
            }
          }
        }

        $catalog = $catalog2;
      }

      $sort_order = [];

      foreach ($catalog as $key => $value) {
        $sort_order[$key] = strtotime($value['date_added']);
      }

      array_multisort($sort_order,SORT_DESC,$catalog);

      $i++;
    }

    return $catalog;
  }

  public function sendNeedHelpRequest($data = []) {
    $this->language->load('extension/ocdevwizard/'.$this->_name);

    if (version_compare(VERSION,'1.5.5.1','>=') && version_compare(VERSION,'2.0.0.0','<')) {
      $mail            = new Mail();
      $mail->protocol  = $this->config->get('config_mail_protocol');
      $mail->parameter = $this->config->get('config_mail_parameter');
      $mail->hostname  = $this->config->get('config_smtp_host');
      $mail->username  = $this->config->get('config_smtp_username');
      $mail->password  = $this->config->get('config_smtp_password');
      $mail->port      = $this->config->get('config_smtp_port');
      $mail->timeout   = $this->config->get('config_smtp_timeout');
    } else if (version_compare(VERSION,'2.0.0.0','>=') && version_compare(VERSION,'2.0.1.1','<=')) {
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

    $html = $this->language->get('entry_email').': '.$data['email']."<br/>";
    $html .= $this->language->get('entry_order_id').': '.$data['order_id']."<br/>";
    $html .= $this->language->get('entry_marketplace').': '.$data['marketplace']."<br/>";
    $html .= $this->language->get('entry_message').': '.$data['message'];

    $mail->setTo('ocdevwizard@gmail.com');
    $mail->setFrom($data['email']);
    $mail->setSender($this->config->get('config_name'));
    $mail->setSubject(sprintf($this->language->get('text_need_help_subject'),$data['module_name']));
    $mail->setHtml(html_entity_decode($html,ENT_QUOTES,'UTF-8'));
    $mail->send();
  }

  public function sendLicenseRequest($data = []) {
    $this->language->load('extension/ocdevwizard/'.$this->_name);

    if (version_compare(VERSION,'1.5.5.1','>=') && version_compare(VERSION,'2.0.0.0','<')) {
      $mail            = new Mail();
      $mail->protocol  = $this->config->get('config_mail_protocol');
      $mail->parameter = $this->config->get('config_mail_parameter');
      $mail->hostname  = $this->config->get('config_smtp_host');
      $mail->username  = $this->config->get('config_smtp_username');
      $mail->password  = $this->config->get('config_smtp_password');
      $mail->port      = $this->config->get('config_smtp_port');
      $mail->timeout   = $this->config->get('config_smtp_timeout');
    } else if (version_compare(VERSION,'2.0.0.0','>=') && version_compare(VERSION,'2.0.1.1','<=')) {
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

    $html = $this->language->get('entry_module').': '.$this->language->get('heading_title')."<br/>";
    $html .= $this->language->get('entry_email').': '.$data['email']."<br/>";
    $html .= $this->language->get('entry_order_id').': '.$data['order_id']."<br/>";
    $html .= $this->language->get('entry_marketplace').': '.$data['marketplace']."<br/>";
    $html .= $this->language->get('entry_domain').': '.$data['domain']."<br/>";

    if ($data['test_domain_status']) {
      $html .= $this->language->get('entry_test_domain').': '.$data['test_domain'];
    }

    $mail->setTo('ocdevwizard@gmail.com');
    $mail->setFrom($data['email']);
    $mail->setSender($this->config->get('config_name'));
    $mail->setSubject(sprintf($this->language->get('text_license_subject'),$data['module_name']));
    $mail->setHtml(html_entity_decode($html,ENT_QUOTES,'UTF-8'));
    $mail->send();
  }

  public function getSetting($code,$store_id = 0) {
    $setting_data = [];

    if ($this->checkTableExist(DB_PREFIX."ocdevwizard_setting")) {
      $query = $this->db->query("SELECT * FROM ".DB_PREFIX."ocdevwizard_setting WHERE store_id = '".(int)$store_id."' AND `code` = '".$this->db->escape($code)."'")->rows;

      foreach ($query as $result) {
        $setting_data[$result['key']] = (!$result['serialized']) ? $result['value'] : json_decode($result['value'],true);
      }
    }

    return $setting_data;
  }

  public function getSettingData($key,$store_id = 0) {
    $setting_data = [];

    if ($this->checkTableExist(DB_PREFIX."ocdevwizard_setting")) {
      $query = $this->db->query("SELECT * FROM ".DB_PREFIX."ocdevwizard_setting WHERE store_id = '".(int)$store_id."' AND `key` = '".$this->db->escape($key)."'")->rows;

      foreach ($query as $result) {
        $setting_data = (!$result['serialized']) ? $result['value'] : json_decode($result['value'],true);
      }
    }

    return $setting_data;
  }

  public function checkTableExist($table_name) {
    return $this->db->query("SELECT COUNT(*) as total FROM information_schema.TABLES WHERE TABLE_SCHEMA = '".$this->db->escape(DB_DATABASE)."' AND TABLE_NAME = '".$this->db->escape($table_name)."'")->row['total'];
  }
}