<?php
##=================================================##
## @author    : OCdevWizard                        ##
## @contact   : ocdevwizard@gmail.com              ##
## @support   : http://help.ocdevwizard.com        ##
## @copyright : (c) OCdevWizard. Price Alert, 2018 ##
##=================================================##
class ControllerExtensionOcdevwizardPriceAlert extends Controller {
  private $_name = 'price_alert';
  private $_code = 'ocdw_price_alert';
  private $_session_currency;
  private $_currency_code;

  public function __construct($registry) {
    parent::__construct($registry);

    if (version_compare(VERSION,'2.1.0.2.1','<=')) {
      $this->_session_currency = '';
      $this->_currency_code    = $this->currency->getCode();
    } else {
      $this->_session_currency = $this->_currency_code = $this->session->data['currency'];
    }
  }

  public function index() {
    $data = [];

    $models = [
      'catalog/information',
      'tool/image',
      'extension/ocdevwizard/'.$this->_name,
      'extension/ocdevwizard/helper'
    ];

    foreach ($models as $model) {
      $this->load->model($model);
    }

    $display_type                    = (isset($this->request->post['display_type'])) ? (int)$this->request->post['display_type'] : die();
    $data['record_type']             = $record_type = (isset($this->request->post['record_type'])) ? $this->request->post['record_type'] : die();
    $data['product_id']              = (isset($this->request->post['product_id'])) ? (int)$this->request->post['product_id'] : die();
    $data['product_option_id']       = ($record_type == '2' && isset($this->request->post['product_option_id'])) ? (int)$this->request->post['product_option_id'] : 0;
    $data['product_option_value_id'] = ($record_type == '2' && isset($this->request->post['product_option_value_id'])) ? (int)$this->request->post['product_option_value_id'] : 0;

    $form_data = $this->model_extension_ocdevwizard_helper->getSettingData($this->_name.'_form_data',(int)$this->config->get('config_store_id'));
    $text_data = $this->model_extension_ocdevwizard_helper->getSettingData($this->_name.'_text_data',(int)$this->config->get('config_store_id'));

    $data = array_merge($data,$this->language->load('extension/ocdevwizard/'.$this->_name),$text_data,$form_data);

    if (!$form_data) {
      die();
    }

    $language_id = $this->{'model_extension_ocdevwizard_'.$this->_name}->getLanguageIdByCode($this->session->data['language']);

    $data['heading_title']  = (isset($text_data[$language_id])) ? html_entity_decode($text_data[$language_id]['name'],ENT_QUOTES,'UTF-8') : '';
    $data['button_save']    = (isset($text_data[$language_id])) ? html_entity_decode($text_data[$language_id]['save_button'],ENT_QUOTES,'UTF-8') : '';
    $data['button_go_back'] = (isset($text_data[$language_id])) ? html_entity_decode($text_data[$language_id]['close_button'],ENT_QUOTES,'UTF-8') : '';
    $data['description']    = (isset($text_data[$language_id])) ? html_entity_decode($text_data[$language_id]['description'],ENT_QUOTES,'UTF-8') : '';
    $data['analytic_code']  = (isset($text_data[$language_id]) && $form_data['analytic_code_status'] == 1) ? html_entity_decode($text_data[$language_id]['analytic_code'],ENT_QUOTES,'UTF-8') : '';

    $data['_name']          = $this->_name;
    $data['_code']          = $this->_code;
    $data['_language_code'] = substr($this->session->data['language'],0,2);
    $data['field_row']      = mt_rand(1000,10000);

    $data['fields_data'] = [];

    if (isset($form_data['fields']) && $form_data['fields']) {
      foreach ($form_data['fields'] as $field_id) {
        $field_info = $this->{'model_extension_ocdevwizard_'.$this->_name}->getField($field_id);

        if ($field_info) {
          $icon = ($field_info['icon']) ? $this->model_tool_image->resize($field_info['icon'],25,25) : '';

          if ($field_info['field_type'] == 'firstname') {
            $value = $this->customer->getFirstname();
          } else if ($field_info['field_type'] == 'lastname') {
            $value = $this->customer->getLastname();
          } else if ($field_info['field_type'] == 'email') {
            $value = $this->customer->getEmail();
          } else if ($field_info['field_type'] == 'telephone') {
            $value = $this->customer->getTelephone();
          } else {
            $value = '';
          }

          $data['fields_data'][] = [
            'field_id'     => $field_info['field_id'],
            'name'         => html_entity_decode($field_info['name'],ENT_QUOTES,'UTF-8'),
            'placeholder'  => ($field_info['placeholder_status']) ? $field_info['placeholder'] : '',
            'field_type'   => $field_info['field_type'],
            'required'     => ($field_info['validation_type'] > 0) ? 1 : 0,
            'field_mask'   => $field_info['field_mask'],
            'icon'         => $icon,
            'value'        => $value,
            'error_text'   => html_entity_decode($field_info['error_text'],ENT_QUOTES,'UTF-8'),
            'description'  => ($field_info['description_status']) ? html_entity_decode($field_info['description'],ENT_QUOTES,'UTF-8') : '',
            'css_id'       => $field_info['css_id'],
            'css_class'    => $field_info['css_class'],
            'title_status' => $field_info['title_status'],
            'sort_order'   => $field_info['sort_order']
          ];
        }
      }

      if ($data['fields_data']) {
        $sort_order = [];

        foreach ($data['fields_data'] as $key => $value) {
          $sort_order[$key] = $value['sort_order'];
        }

        array_multisort($sort_order,SORT_ASC,$data['fields_data']);
      }
    }

    $data['informations'] = [];

    if (isset($form_data['require_information']) && $form_data['require_information']) {
      $informations         = $this->model_catalog_information->getInformation((int)$form_data['require_information']);
      $data['informations'] = sprintf($this->language->get('text_require_information'),$this->url->link('information/information','information_id='.$form_data['require_information']),$informations['title']);
    }

    if (version_compare(VERSION,'2.1.0.2','<=')) {
      if ($display_type == 1) {
        if (file_exists(DIR_TEMPLATE.$this->config->get('config_template').'/template/extension/ocdevwizard/'.$this->_name.'/popup.tpl')) {
          $view = $this->load->view($this->config->get('config_template').'/template/extension/ocdevwizard/'.$this->_name.'/popup.tpl',$data);
        } else {
          $view = $this->load->view('default/template/extension/ocdevwizard/'.$this->_name.'/popup.tpl',$data);
        }
      } else {
        if (file_exists(DIR_TEMPLATE.$this->config->get('config_template').'/template/extension/ocdevwizard/'.$this->_name.'/sidebar.tpl')) {
          $view = $this->load->view($this->config->get('config_template').'/template/extension/ocdevwizard/'.$this->_name.'/sidebar.tpl',$data);
        } else {
          $view = $this->load->view('default/template/extension/ocdevwizard/'.$this->_name.'/sidebar.tpl',$data);
        }
      }

      $this->response->setOutput($view);
    } else if (version_compare(VERSION,'3.0.0.0','>=')) {
      if ($display_type == 1) {
        $this->response->setOutput($this->load->view('extension/ocdevwizard/'.$this->_name.'/popup',$data));
      } else {
        $this->response->setOutput($this->load->view('extension/ocdevwizard/'.$this->_name.'/sidebar',$data));
      }
    } else {
      if ($display_type == 1) {
        $this->response->setOutput($this->load->view('extension/ocdevwizard/'.$this->_name.'/popup.tpl',$data));
      } else {
        $this->response->setOutput($this->load->view('extension/ocdevwizard/'.$this->_name.'/sidebar.tpl',$data));
      }
    }
  }

  public function record_action() {
    if (isset($this->request->server['HTTP_X_REQUESTED_WITH']) && !empty($this->request->server['HTTP_X_REQUESTED_WITH']) && strtolower($this->request->server['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
      $json = [];

      $this->language->load('extension/ocdevwizard/'.$this->_name);

      $models = [
        'catalog/information',
        'extension/ocdevwizard/'.$this->_name,
        'extension/ocdevwizard/helper'
      ];

      foreach ($models as $model) {
        $this->load->model($model);
      }

      $product_id              = (isset($this->request->post['product_id'])) ? (int)$this->request->post['product_id'] : die();
      $record_type             = (isset($this->request->post['record_type'])) ? (int)$this->request->post['record_type'] : die();
      $product_option_id       = (isset($this->request->post['product_option_id'])) ? (int)$this->request->post['product_option_id'] : 0;
      $product_option_value_id = (isset($this->request->post['product_option_value_id'])) ? (int)$this->request->post['product_option_value_id'] : 0;
      $field_data              = (isset($this->request->post['field'])) ? $this->request->post['field'] : die();

      $form_data = $this->model_extension_ocdevwizard_helper->getSettingData($this->_name.'_form_data',(int)$this->config->get('config_store_id'));
      $text_data = $this->model_extension_ocdevwizard_helper->getSettingData($this->_name.'_text_data',(int)$this->config->get('config_store_id'));

      if (!$form_data) {
        die();
      }

      $language_id = $this->{'model_extension_ocdevwizard_'.$this->_name}->getLanguageIdByCode($this->session->data['language']);
      $customer_id = $this->customer->getId();

      if (isset($text_data[$language_id])) {
        $json['button_save'] = html_entity_decode($text_data[$language_id]['save_button'],ENT_QUOTES,'UTF-8');
      }

      foreach ($field_data as $field_row => $field) {
        foreach ($field as $field_id => $value) {
          $field_info = $this->{'model_extension_ocdevwizard_'.$this->_name}->getField($field_id);

          if ($field_info) {
            if ($field_info['validation_type'] == 1) {
              if (empty($value)) {
                $json['error']['field'][$field_row] = $field_info['error_text'];
              }
            } else if ($field_info['validation_type'] == 2 && !preg_match($field_info['regex_rule'],$value)) {
              $json['error']['field'][$field_row] = $field_info['error_text'];
            } else if ($field_info['validation_type'] == 3 && (utf8_strlen(str_replace(['_','-','+','(',')'],'',$value)) < $field_info['min_length_rule'] || utf8_strlen(str_replace(['_','-','+','(',')'],'',$value)) > $field_info['max_length_rule'])) {
              $json['error']['field'][$field_row] = $field_info['error_text'];
            } else {
              unset($json['error']['field'][$field_row]);
            }

            if ($field_info['field_type'] == 'email') {
              $filter_data = [
                'email'                   => $value,
                'product_id'              => $product_id,
                'record_type'             => $record_type,
                'product_option_id'       => $product_option_id,
                'product_option_value_id' => $product_option_value_id,
                'customer_id'             => $customer_id
              ];

              if ($this->{'model_extension_ocdevwizard_'.$this->_name}->checkNotifyByEmail($filter_data)) {
                $json['error']['field'][$field_row] = $this->language->get('error_request_already_exists');
              }

              if ($this->{'model_extension_ocdevwizard_'.$this->_name}->checkBannedByEmail($value,$this->request->server['REMOTE_ADDR'])) {
                $json['error']['field'][$field_row] = $this->language->get('error_banned_record_by_email');
              }
            }

            if ($field_info['field_type'] == 'telephone') {
              $filter_data = [
                'telephone'               => $value,
                'product_id'              => $product_id,
                'record_type'             => $record_type,
                'product_option_id'       => $product_option_id,
                'product_option_value_id' => $product_option_value_id,
                'customer_id'             => $customer_id
              ];

              if ($this->{'model_extension_ocdevwizard_'.$this->_name}->checkNotifyByTelephone($filter_data)) {
                $json['error']['field'][$field_row] = $this->language->get('error_request_already_exists');
              }

              if ($this->{'model_extension_ocdevwizard_'.$this->_name}->checkBannedByTelephone($value,$this->request->server['REMOTE_ADDR'])) {
                $json['error']['field'][$field_row] = $this->language->get('error_banned_record_by_telephone');
              }
            }
          }
        }
      }

      if (!isset($this->request->post['require_information']) || empty($this->request->post['require_information'])) {
        if (isset($form_data['require_information']) && $form_data['require_information']) {
          $information_info = $this->model_catalog_information->getInformation((int)$form_data['require_information']);

          if ($information_info) {
            $json['error']['field']['require_information'] = sprintf($this->language->get('error_require_information'),$information_info['title']);
          }
        }
      }

      if ($form_data['captcha_status'] && (!isset($this->session->data[$this->_code.'_gcapcha']) || empty($this->session->data[$this->_code.'_gcapcha']))) {
        $recaptcha = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.urlencode($form_data['captcha_secret_key']).'&response='.$this->request->request['g-recaptcha-response'].'&remoteip='.$this->request->server['REMOTE_ADDR']);

        $recaptcha = json_decode($recaptcha,true);

        if ($recaptcha['success']) {
          $this->session->data[$this->_code.'_gcapcha'] = true;
        } else {
          $json['error']['field']['recaptcha'] = $this->language->get('error_recaptcha');
        }
      }

      if (!isset($json['error'])) {
        $ip                = (!empty($this->request->server['REMOTE_ADDR'])) ? $this->request->server['REMOTE_ADDR'] : '';
        $referer           = (!empty($this->request->server['HTTP_REFERER'])) ? $this->request->server['HTTP_REFERER'] : '';
        $user_agent        = (isset($this->request->server['HTTP_USER_AGENT'])) ? $this->request->server['HTTP_USER_AGENT'] : '';
        $accept_language   = (isset($this->request->server['HTTP_ACCEPT_LANGUAGE'])) ? $this->request->server['HTTP_ACCEPT_LANGUAGE'] : '';
        $customer_group_id = $this->customer->isLogged() ? (int)$this->customer->getGroupId() : (int)$this->config->get('config_customer_group_id');

        $store_id   = $this->config->get('config_store_id');
        $store_name = $this->config->get('config_name');
        $store_url  = (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) ? $this->config->get('config_ssl') : $this->config->get('config_url');

        if ($store_id != 0) {
          $store_info = $this->{'model_extension_ocdevwizard_'.$this->_name}->getStore($store_id);

          if ($store_info) {
            $store_name = $store_info['name'];
            $store_url  = (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) ? $store_info['ssl'] : $store_info['url'];
          }
        }

        $language_id = $this->{'model_extension_ocdevwizard_'.$this->_name}->getLanguageIdByCode($this->session->data['language']);
        $currency_id = $this->{'model_extension_ocdevwizard_'.$this->_name}->getCurrencyIdByCode($this->session->data['currency']);

        $field_data_result = [];

        foreach ($field_data as $field_row => $field) {
          foreach ($field as $field_id => $value) {
            $field_info = $this->{'model_extension_ocdevwizard_'.$this->_name}->getField($field_id);

            if ($field_info) {
              $field_data_result[] = [
                'name'  => $field_info['name'],
                'type'  => $field_info['field_type'],
                'value' => $value
              ];
            }
          }
        }

        if (version_compare(VERSION,'2.0.3.1','<=')) {
          $salt = substr(md5(uniqid(rand(),true)),0,9);
        } else {
          $salt = token(9);
        }

        $token = md5(sha1($salt.sha1($salt.sha1($product_id))));

        if ($record_type == 2) {
          $option_filter_data = [
            'product_id'              => $product_id,
            'product_option_id'       => $product_option_id,
            'product_option_value_id' => $product_option_value_id
          ];

          $product_option_info = $this->{'model_extension_ocdevwizard_'.$this->_name}->getProductOptionInfo($option_filter_data);
        } else {
          $product_option_info = 0;
        }

        $product_info = $this->{'model_extension_ocdevwizard_'.$this->_name}->getProduct($product_id,$language_id,$store_id,$customer_group_id);

        $current_price = 0;

        if ($product_info) {
          if ($product_info['price']) {
            $current_price = $this->tax->calculate($product_info['price'],$product_info['tax_class_id'],$this->config->get('config_tax'));
          }

          if ($product_info['special']) {
            $current_price = $this->tax->calculate($product_info['special'],$product_info['tax_class_id'],$this->config->get('config_tax'));
          }
        }

        if ($product_option_info) {
          $current_price = $this->tax->calculate($product_option_info['price'],$product_info['tax_class_id'],$this->config->get('config_tax') ? 'P' : false);
        }

        $shipping_country_id = (isset($this->session->data['shipping_address']['country_id'])) ? $this->session->data['shipping_address']['country_id'] : 0;
        $shipping_zone_id    = (isset($this->session->data['shipping_address']['zone_id'])) ? $this->session->data['shipping_address']['zone_id'] : 0;
        $payment_country_id  = (isset($this->session->data['payment_address']['country_id'])) ? $this->session->data['payment_address']['country_id'] : 0;
        $payment_zone_id     = (isset($this->session->data['payment_address']['zone_id'])) ? $this->session->data['payment_address']['zone_id'] : 0;
        $default_country_id  = $this->config->get('config_country_id');
        $default_zone_id     = $this->config->get('config_zone_id');
        $tax_default         = $this->config->get('config_tax_default');

        $filter_data = [
          'product_id'              => $product_id,
          'customer_id'             => $customer_id,
          'product_option_id'       => $product_option_id,
          'product_option_value_id' => $product_option_value_id,
          'option_id'               => ($product_option_info) ? $product_option_info['option_id'] : 0,
          'option_value_id'         => ($product_option_info) ? $product_option_info['option_value_id'] : 0,
          'price'                   => $current_price,
          'shipping_country_id'     => $shipping_country_id,
          'shipping_zone_id'        => $shipping_zone_id,
          'payment_country_id'      => $payment_country_id,
          'payment_zone_id'         => $payment_zone_id,
          'default_country_id'      => $default_country_id,
          'default_zone_id'         => $default_zone_id,
          'tax_default'             => $tax_default,
          'currency_code'           => $this->_session_currency,
          'currency_value'          => $this->currency->getValue($this->_session_currency),
          'field_data'              => $field_data_result,
          'token'                   => $token,
          'record_type'             => $record_type,
          'ip'                      => $ip,
          'referer'                 => $referer,
          'user_agent'              => $user_agent,
          'accept_language'         => $accept_language,
          'user_language_id'        => $language_id,
          'user_currency_id'        => $currency_id,
          'user_customer_group_id'  => $customer_group_id,
          'store_name'              => $store_name,
          'store_url'               => $store_url,
          'store_id'                => $store_id,
          'form_data'               => $form_data
        ];

        $this->{'model_extension_ocdevwizard_'.$this->_name}->addRecord($filter_data);

        if (isset($text_data[$language_id])) {
          $json['output'] = html_entity_decode($text_data[$language_id]['success_message'],ENT_QUOTES,'UTF-8');
        }

        $this->session->data[$this->_code.'_gcapcha'] = false;
      }

      $this->response->addHeader('Content-Type: application/json');
      $this->response->setOutput(json_encode($json));
    }
  }

  public function get_products() {
    if (isset($this->request->server['HTTP_X_REQUESTED_WITH']) && !empty($this->request->server['HTTP_X_REQUESTED_WITH']) && strtolower($this->request->server['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
      $json = [];

      $json['products'] = [];

      $products = (isset($this->request->post['products']) && $this->request->post['products']) ? $this->request->post['products'] : [];

      if ($products) {
        $models = [
          'tool/image',
          'extension/ocdevwizard/'.$this->_name,
          'extension/ocdevwizard/helper'
        ];

        foreach ($models as $model) {
          $this->load->model($model);
        }

        $text_data = $this->model_extension_ocdevwizard_helper->getSettingData($this->_name.'_text_data',(int)$this->config->get('config_store_id'));
        $form_data = $this->model_extension_ocdevwizard_helper->getSettingData($this->_name.'_form_data',(int)$this->config->get('config_store_id'));

        $language_id = $this->{'model_extension_ocdevwizard_'.$this->_name}->getLanguageIdByCode($this->session->data['language']);
        $store_id    = $this->config->get('config_store_id');

        if (isset($text_data[$language_id])) {
          $json['call_button']              = html_entity_decode($text_data[$language_id]['call_button'],ENT_QUOTES,'UTF-8');
          $json['call_button_product_page'] = html_entity_decode($text_data[$language_id]['call_button_product_page'],ENT_QUOTES,'UTF-8');
        }

        $products_results = [];

        foreach ($products as $product_id) {
          $products_results[] = $product_id;
        }

        $products = array_unique($products_results);

        if ($form_data['related_product_status'] == 1) {
          $results = $this->{'model_extension_ocdevwizard_'.$this->_name}->getConfigRelatedCategory($store_id);

          $filter_data = [
            'filter_product_id'   => $products,
            'filter_category_id'  => ($results) ? $results : false,
            'filter_sub_category' => true
          ];

          $products_array = $this->{'model_extension_ocdevwizard_'.$this->_name}->getProductId($filter_data);

          foreach ($products_array as $product) {
            $json['products'][] = $product['product_id'];
          }
        }

        if ($form_data['related_product_status'] == 2) {
          $results = $this->{'model_extension_ocdevwizard_'.$this->_name}->getConfigRelatedManufacturer($store_id);

          $filter_data = [
            'filter_product_id'      => $products,
            'filter_manufacturer_id' => ($results) ? $results : false
          ];

          $products_array = $this->{'model_extension_ocdevwizard_'.$this->_name}->getProductId($filter_data);

          foreach ($products_array as $product) {
            $json['products'][] = $product['product_id'];
          }
        }

        if ($form_data['related_product_status'] == 3) {
          $results = $this->{'model_extension_ocdevwizard_'.$this->_name}->getConfigRelatedProduct($store_id);

          $filter_data = [
            'filter_product_id' => ($results) ? $results : false
          ];

          $products_array = $this->{'model_extension_ocdevwizard_'.$this->_name}->getProductId($filter_data);

          foreach ($products_array as $product) {
            $json['products'][] = $product['product_id'];
          }
        }

        if ($form_data['related_product_status'] == 4) {
          $filter_data = [
            'filter_product_id' => $products,
          ];

          $products_array = $this->{'model_extension_ocdevwizard_'.$this->_name}->getProductId($filter_data);

          foreach ($products_array as $product) {
            $json['products'][] = $product['product_id'];
          }
        }
      }

      $this->response->addHeader('Content-Type: application/json');
      $this->response->setOutput(json_encode($json));
    }
  }

  public function cron() {
    $access_key = (isset($this->request->get['access_key']) && $this->request->get['access_key']) ? $this->request->get['access_key'] : '';

    if ($access_key) {
      $models = [
        'extension/ocdevwizard/'.$this->_name,
        'extension/ocdevwizard/helper'
      ];

      foreach ($models as $model) {
        $this->load->model($model);
      }

      $form_data = $this->model_extension_ocdevwizard_helper->getSettingData($this->_name.'_form_data',(int)$this->config->get('config_store_id'));

      if (isset($form_data['activate']) && $form_data['activate']) {
        if ($form_data['cron_token'] == $access_key && isset($form_data['cron_task']) && in_array($form_data['notification_event'],[2,3])) {
          foreach ($form_data['cron_task'] as $cron_task) {
            if ($cron_task == 1) {
              $results = $this->{'model_extension_ocdevwizard_'.$this->_name}->getRecordForCron(1);

              if ($results) {
                foreach ($results as $row) {
                  $current_price = $row['product_price'];

                  if ($row['product_special']) {
                    $current_price = $row['product_special'];
                  }

                  $tax_filter_data = [
                    'record_info'  => $row,
                    'value'        => $current_price,
                    'tax_class_id' => $row['tax_class_id'],
                    'calculate'    => $this->config->get('config_tax')
                  ];

                  $current_price = $this->{'model_extension_ocdevwizard_'.$this->_name}->calculate_tax($tax_filter_data);

                  if ($form_data['price_type'] == 1) {
                    if ((intval($row['price']) > intval($current_price)) && $row['status'] == 1 && !$row['banned_status'] && $row['record_type'] == 1 && $form_data['repeat_notification']) {
                      $this->db->query("UPDATE ".DB_PREFIX.$this->_code."_record SET status = '0', date_notified = '0000-00-00 00:00:00' WHERE record_id = '".(int)$row['record_id']."'");
                    }

                    if ((intval($row['price']) > intval($current_price)) && $row['status'] == 0 && !$row['banned_status'] && $row['record_type'] == 1) {
                      $this->db->query("UPDATE ".DB_PREFIX.$this->_code."_record SET status = '1', price = '".(float)$current_price."', date_notified = NOW() WHERE record_id = '".(int)$row['record_id']."'");

                      $filter_data = [
                        'product_id' => $row['product_id'],
                        'record_id'  => $row['record_id'],
                        'form_data'  => $form_data
                      ];

                      $this->{'model_extension_ocdevwizard_'.$this->_name}->mailing($filter_data,['to_user_when_product_price_was_changed']);
                    }
                  } else if ($form_data['price_type'] == 2) {
                    if ((intval($row['price']) < intval($current_price)) && $row['status'] == 1 && !$row['banned_status'] && $row['record_type'] == 1 && $form_data['repeat_notification']) {
                      $this->db->query("UPDATE ".DB_PREFIX.$this->_code."_record SET status = '0', date_notified = '0000-00-00 00:00:00' WHERE record_id = '".(int)$row['record_id']."'");
                    }

                    if ((intval($row['price']) < intval($current_price)) && $row['status'] == 0 && !$row['banned_status'] && $row['record_type'] == 1) {
                      $this->db->query("UPDATE ".DB_PREFIX.$this->_code."_record SET status = '1', price = '".(float)$current_price."', date_notified = NOW() WHERE record_id = '".(int)$row['record_id']."'");

                      $filter_data = [
                        'product_id' => $row['product_id'],
                        'record_id'  => $row['record_id'],
                        'form_data'  => $form_data
                      ];

                      $this->{'model_extension_ocdevwizard_'.$this->_name}->mailing($filter_data,['to_user_when_product_price_was_changed']);
                    }
                  } else if ($form_data['price_type'] == 3) {
                    if ((intval($row['price']) != intval($current_price)) && $row['status'] == 1 && !$row['banned_status'] && $row['record_type'] == 1 && $form_data['repeat_notification']) {
                      $this->db->query("UPDATE ".DB_PREFIX.$this->_code."_record SET status = '0', date_notified = '0000-00-00 00:00:00' WHERE record_id = '".(int)$row['record_id']."'");
                    }

                    if ((intval($row['price']) != intval($current_price)) && $row['status'] == 0 && !$row['banned_status'] && $row['record_type'] == 1) {
                      $this->db->query("UPDATE ".DB_PREFIX.$this->_code."_record SET status = '1', price = '".(float)$current_price."', date_notified = NOW() WHERE record_id = '".(int)$row['record_id']."'");

                      $filter_data = [
                        'product_id' => $row['product_id'],
                        'record_id'  => $row['record_id'],
                        'form_data'  => $form_data
                      ];

                      $this->{'model_extension_ocdevwizard_'.$this->_name}->mailing($filter_data,['to_user_when_product_price_was_changed']);
                    }
                  }
                }
              }

              $results = $this->{'model_extension_ocdevwizard_'.$this->_name}->getRecordForCron(2);

              if ($results) {
                foreach ($results as $row) {
                  $current_price = $row['option_price'];

                  $tax_filter_data = [
                    'record_info'  => $row,
                    'value'        => $current_price,
                    'tax_class_id' => $row['tax_class_id'],
                    'calculate'    => $this->config->get('config_tax') ? 'P' : false
                  ];

                  $current_price = $this->{'model_extension_ocdevwizard_'.$this->_name}->calculate_tax($tax_filter_data);

                  if ($form_data['price_type'] == 1) {
                    if ((intval($row['price']) > intval($current_price)) && $row['status'] == 1 && !$row['banned_status'] && $row['record_type'] == 2 && $form_data['repeat_notification']) {
                      $this->db->query("UPDATE ".DB_PREFIX.$this->_code."_record SET status = '0', date_notified = '0000-00-00 00:00:00' WHERE record_id = '".(int)$row['record_id']."'");
                    }

                    if ((intval($row['price']) > intval($current_price)) && $row['status'] == 0 && !$row['banned_status'] && $row['record_type'] == 2) {
                      $this->db->query("UPDATE ".DB_PREFIX.$this->_code."_record SET status = '1', price = '".(float)$current_price."', date_notified = NOW() WHERE record_id = '".(int)$row['record_id']."'");

                      $filter_data = [
                        'product_id' => $row['product_id'],
                        'record_id'  => $row['record_id'],
                        'form_data'  => $form_data
                      ];

                      $this->{'model_extension_ocdevwizard_'.$this->_name}->mailing($filter_data,['to_user_when_product_option_price_was_changed']);
                    }
                  } else if ($form_data['price_type'] == 2) {
                    if ((intval($row['price']) < intval($current_price)) && $row['status'] == 1 && !$row['banned_status'] && $row['record_type'] == 2 && $form_data['repeat_notification']) {
                      $this->db->query("UPDATE ".DB_PREFIX.$this->_code."_record SET status = '0', date_notified = '0000-00-00 00:00:00' WHERE record_id = '".(int)$row['record_id']."'");
                    }

                    if ((intval($row['price']) < intval($current_price)) && $row['status'] == 0 && !$row['banned_status'] && $row['record_type'] == 2) {
                      $this->db->query("UPDATE ".DB_PREFIX.$this->_code."_record SET status = '1', price = '".(float)$current_price."', date_notified = NOW() WHERE record_id = '".(int)$row['record_id']."'");

                      $filter_data = [
                        'product_id' => $row['product_id'],
                        'record_id'  => $row['record_id'],
                        'form_data'  => $form_data
                      ];

                      $this->{'model_extension_ocdevwizard_'.$this->_name}->mailing($filter_data,['to_user_when_product_option_price_was_changed']);
                    }
                  } else if ($form_data['price_type'] == 3) {
                    if ((intval($row['price']) != intval($current_price)) && $row['status'] == 1 && !$row['banned_status'] && $row['record_type'] == 2 && $form_data['repeat_notification']) {
                      $this->db->query("UPDATE ".DB_PREFIX.$this->_code."_record SET status = '0', date_notified = '0000-00-00 00:00:00' WHERE record_id = '".(int)$row['record_id']."'");
                    }

                    if ((intval($row['price']) != intval($current_price)) && $row['status'] == 0 && !$row['banned_status'] && $row['record_type'] == 2) {
                      $this->db->query("UPDATE ".DB_PREFIX.$this->_code."_record SET status = '1', price = '".(float)$current_price."', date_notified = NOW() WHERE record_id = '".(int)$row['record_id']."'");

                      $filter_data = [
                        'product_id' => $row['product_id'],
                        'record_id'  => $row['record_id'],
                        'form_data'  => $form_data
                      ];

                      $this->{'model_extension_ocdevwizard_'.$this->_name}->mailing($filter_data,['to_user_when_product_option_price_was_changed']);
                    }
                  }
                }
              }
            }

            if ($cron_task == 2) {
              $results = $this->{'model_extension_ocdevwizard_'.$this->_name}->getRecordForCron(3);

              if ($results) {
                foreach ($results as $record_id) {
                  $this->{'model_extension_ocdevwizard_'.$this->_name}->deleteRecord($record_id);
                }
              }
            }
          }
        }
      }
    } else {
      header('HTTP/1.0 403 Forbidden');
      die();
    }
  }

  public function actions() {
    $data = [];

    $models = [
      'extension/ocdevwizard/'.$this->_name,
      'extension/ocdevwizard/helper'
    ];

    foreach ($models as $model) {
      $this->load->model($model);
    }

    $data = array_merge($data,$this->language->load('extension/ocdevwizard/'.$this->_name));

    $data['breadcrumbs'] = [];

    $data['breadcrumbs'][] = [
      'text' => $this->language->get('text_home'),
      'href' => $this->url->link('common/home')
    ];

    $form_data = $this->model_extension_ocdevwizard_helper->getSettingData($this->_name.'_form_data',(int)$this->config->get('config_store_id'));

    $token = (isset($this->request->get['token']) && $this->request->get['token']) ? $this->request->get['token'] : '';

    $record_status = $this->{'model_extension_ocdevwizard_'.$this->_name}->getRecordByToken($token);

    if (isset($form_data['activate']) && $form_data['activate'] && $record_status) {
      $this->document->setTitle($this->language->get('heading_title_actions'));

      $data['breadcrumbs'][] = [
        'text' => $this->language->get('heading_title_actions'),
        'href' => $this->url->link('extension/ocdevwizard/'.$this->_name.'/actions')
      ];

      $data['heading_title'] = $this->language->get('heading_title_actions');

      $data['_name'] = $this->_name;
      $data['_code'] = $this->_code;

      $data['text_result_message'] = $this->language->get('text_record_unsubscribe_success');

      $this->{'model_extension_ocdevwizard_'.$this->_name}->unSubscribe($token);

      $data['column_left']    = $this->load->controller('common/column_left');
      $data['column_right']   = $this->load->controller('common/column_right');
      $data['content_top']    = $this->load->controller('common/content_top');
      $data['content_bottom'] = $this->load->controller('common/content_bottom');
      $data['footer']         = $this->load->controller('common/footer');
      $data['header']         = $this->load->controller('common/header');

      if (version_compare(VERSION,'2.1.0.2','<=')) {
        if (file_exists(DIR_TEMPLATE.$this->config->get('config_template').'/template/extension/ocdevwizard/'.$this->_name.'/actions.tpl')) {
          $view = $this->load->view($this->config->get('config_template').'/template/extension/ocdevwizard/'.$this->_name.'/actions.tpl',$data);
        } else {
          $view = $this->load->view('default/template/extension/ocdevwizard/'.$this->_name.'/actions.tpl',$data);
        }

        $this->response->setOutput($view);
      } else if (version_compare(VERSION,'3.0.0.0','>=')) {
        $this->response->setOutput($this->load->view('extension/ocdevwizard/'.$this->_name.'/actions',$data));
      } else {
        $this->response->setOutput($this->load->view('extension/ocdevwizard/'.$this->_name.'/actions.tpl',$data));
      }
    } else {
      $data['breadcrumbs'][] = [
        'text' => $this->language->get('error_actions'),
        'href' => $this->url->link('extension/ocdevwizard/'.$this->_name.'/actions')
      ];

      $this->document->setTitle($this->language->get('error_actions'));

      $data['heading_title'] = $this->language->get('error_actions');

      $data['text_error'] = $this->language->get('error_actions');

      $data['button_continue'] = $this->language->get('button_continue');

      $data['continue'] = $this->url->link('common/home');

      $data['column_left']    = $this->load->controller('common/column_left');
      $data['column_right']   = $this->load->controller('common/column_right');
      $data['content_top']    = $this->load->controller('common/content_top');
      $data['content_bottom'] = $this->load->controller('common/content_bottom');
      $data['footer']         = $this->load->controller('common/footer');
      $data['header']         = $this->load->controller('common/header');

      if (version_compare(VERSION,'2.1.0.2','<=')) {
        if (file_exists(DIR_TEMPLATE.$this->config->get('config_template').'/template/error/not_found.tpl')) {
          $view = $this->load->view($this->config->get('config_template').'/template/error/not_found.tpl',$data);
        } else {
          $view = $this->load->view('default/template/error/not_found.tpl',$data);
        }

        $this->response->setOutput($view);
      } else if (version_compare(VERSION,'3.0.0.0','>=')) {
        $this->response->setOutput($this->load->view('error/not_found',$data));
      } else {
        $this->response->setOutput($this->load->view('error/not_found.tpl',$data));
      }
    }
  }

  public function page() {
    if (!$this->customer->isLogged()) {
      $this->session->data['redirect'] = $this->url->link('extension/ocdevwizard/'.$this->_name.'/page','','SSL');

      $this->response->redirect($this->url->link('account/login','','SSL'));
    }

    $data = [];

    $models = [
      'tool/image',
      'extension/ocdevwizard/'.$this->_name,
      'extension/ocdevwizard/helper'
    ];

    foreach ($models as $model) {
      $this->load->model($model);
    }

    $data = array_merge($data,$this->language->load('extension/ocdevwizard/'.$this->_name));

    $data['breadcrumbs'] = [];

    $data['breadcrumbs'][] = [
      'text' => $this->language->get('text_home'),
      'href' => $this->url->link('common/home')
    ];

    $data['breadcrumbs'][] = [
      'text' => $this->language->get('text_account'),
      'href' => $this->url->link('account/account','','SSL')
    ];

    $form_data = $this->model_extension_ocdevwizard_helper->getSettingData($this->_name.'_form_data',(int)$this->config->get('config_store_id'));

    if (isset($form_data['activate']) && $form_data['activate']) {
      $this->document->setTitle($this->language->get('heading_title_page'));

      $data['breadcrumbs'][] = [
        'text' => $this->language->get('heading_title_page'),
        'href' => $this->url->link('extension/ocdevwizard/'.$this->_name.'/page','','SSL')
      ];

      $data['heading_title'] = $this->language->get('heading_title_page');

      $data['_name'] = $this->_name;
      $data['_code'] = $this->_code;

      if (isset($this->request->get['page'])) {
        $page = $this->request->get['page'];
      } else {
        $page = 1;
      }

      $data['records'] = [];

      $filter_data = [
        'customer_id' => $this->customer->getId(),
        'sort'        => 'date_added',
        'order'       => 'DESC',
        'start'       => ($page - 1) * 10,
        'limit'       => 10
      ];

      $record_total = $this->{'model_extension_ocdevwizard_'.$this->_name}->getTotalRecords($filter_data);

      $results = $this->{'model_extension_ocdevwizard_'.$this->_name}->getRecords($filter_data);

      foreach ($results as $result) {
        $product_info = $this->{'model_extension_ocdevwizard_'.$this->_name}->getProductForPage($result['product_id']);

        $option_filter_data = [
          'product_id'              => $result['product_id'],
          'user_language_id'        => $result['user_language_id'],
          'product_option_id'       => $result['product_option_id'],
          'product_option_value_id' => $result['product_option_value_id']
        ];

        $option_info = ($result['product_option_id'] && $result['product_option_value_id']) ? $this->{'model_extension_ocdevwizard_'.$this->_name}->getOptionForNotification($option_filter_data) : [];

        if ($product_info) {
          if ($product_info && is_file(DIR_IMAGE.$product_info['image'])) {
            $image = $this->model_tool_image->resize($product_info['image'],40,40);
          } else {
            $image = $this->model_tool_image->resize('no_image.png',40,40);
          }

          $data['records'][] = [
            'record_id'     => $result['record_id'],
            'product_id'    => $result['product_id'],
            'date_added'    => $result['date_added'],
            'product_image' => $image,
            'product_name'  => $product_info['name'],
            'product_href'  => $this->url->link('product/product','product_id='.$product_info['product_id']),
            'option_name'   => ($option_info) ? $option_info['option_name'] : '',
            'option_value'  => ($option_info) ? $option_info['option_value'] : '',
            'status'        => $result['status'] ? sprintf($this->language->get('text_processed_yes'),(($result['date_notified'] != '0000-00-00 00:00:00') ? (', '.$result['date_notified']) : '')) : $this->language->get('text_processed_no')
          ];
        }
      }

      $pagination        = new Pagination();
      $pagination->total = $record_total;
      $pagination->page  = $page;
      $pagination->limit = 10;
      $pagination->url   = $this->url->link('extension/ocdevwizard/'.$this->_name.'/page','page={page}','SSL');

      $data['pagination'] = $pagination->render();

      $data['results'] = sprintf($this->language->get('text_pagination'),($record_total) ? (($page - 1) * 10) + 1 : 0,((($page - 1) * 10) > ($record_total - 10)) ? $record_total : ((($page - 1) * 10) + 10),$record_total,ceil($record_total / 10));

      $data['column_left']    = $this->load->controller('common/column_left');
      $data['column_right']   = $this->load->controller('common/column_right');
      $data['content_top']    = $this->load->controller('common/content_top');
      $data['content_bottom'] = $this->load->controller('common/content_bottom');
      $data['footer']         = $this->load->controller('common/footer');
      $data['header']         = $this->load->controller('common/header');

      if (version_compare(VERSION,'2.1.0.2','<=')) {
        if (file_exists(DIR_TEMPLATE.$this->config->get('config_template').'/template/extension/ocdevwizard/'.$this->_name.'/page.tpl')) {
          $view = $this->load->view($this->config->get('config_template').'/template/extension/ocdevwizard/'.$this->_name.'/page.tpl',$data);
        } else {
          $view = $this->load->view('default/template/extension/ocdevwizard/'.$this->_name.'/page.tpl',$data);
        }

        $this->response->setOutput($view);
      } else if (version_compare(VERSION,'3.0.0.0','>=')) {
        $this->response->setOutput($this->load->view('extension/ocdevwizard/'.$this->_name.'/page',$data));
      } else {
        $this->response->setOutput($this->load->view('extension/ocdevwizard/'.$this->_name.'/page.tpl',$data));
      }
    } else {
      $data['breadcrumbs'][] = [
        'text' => $this->language->get('error_page'),
        'href' => $this->url->link('extension/ocdevwizard/'.$this->_name.'/page','','SSL')
      ];

      $this->document->setTitle($this->language->get('error_page'));

      $data['heading_title'] = $this->language->get('error_page');

      $data['text_error'] = $this->language->get('error_page');

      $data['button_continue'] = $this->language->get('button_continue');

      $data['continue'] = $this->url->link('common/home');

      $data['column_left']    = $this->load->controller('common/column_left');
      $data['column_right']   = $this->load->controller('common/column_right');
      $data['content_top']    = $this->load->controller('common/content_top');
      $data['content_bottom'] = $this->load->controller('common/content_bottom');
      $data['footer']         = $this->load->controller('common/footer');
      $data['header']         = $this->load->controller('common/header');

      if (version_compare(VERSION,'2.1.0.2','<=')) {
        if (file_exists(DIR_TEMPLATE.$this->config->get('config_template').'/template/error/not_found.tpl')) {
          $view = $this->load->view($this->config->get('config_template').'/template/error/not_found.tpl',$data);
        } else {
          $view = $this->load->view('default/template/error/not_found.tpl',$data);
        }

        $this->response->setOutput($view);
      } else if (version_compare(VERSION,'3.0.0.0','>=')) {
        $this->response->setOutput($this->load->view('error/not_found',$data));
      } else {
        $this->response->setOutput($this->load->view('error/not_found.tpl',$data));
      }
    }
  }

  public function delete_record() {
    if (isset($this->request->server['HTTP_X_REQUESTED_WITH']) && !empty($this->request->server['HTTP_X_REQUESTED_WITH']) && strtolower($this->request->server['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
      $json = [];

      if ($this->customer->isLogged()) {
        $this->language->load('extension/ocdevwizard/'.$this->_name);

        $record_id = (isset($this->request->post['delete']) && $this->request->post['delete']) ? $this->request->post['delete'] : 0;

        if ($record_id) {
          $models = [
            'extension/ocdevwizard/'.$this->_name
          ];

          foreach ($models as $model) {
            $this->load->model($model);
          }

          $this->{'model_extension_ocdevwizard_'.$this->_name}->deleteRecord($record_id);
        }
      }

      $this->response->addHeader('Content-Type: application/json');
      $this->response->setOutput(json_encode($json));
    }
  }
}

?>