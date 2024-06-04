<?php
##========================================================##
## @author    : OCdevWizard                               ##
## @contact   : ocdevwizard@gmail.com                     ##
## @support   : http://help.ocdevwizard.com               ##
## @license   : Distributed on an "AS IS" basis           ##
## @copyright : (c) OCdevWizard. OCdevWizard Helper, 2014 ##
##========================================================##
class ControllerExtensionOcdevwizardHelper extends Controller {
  private $_name = 'helper';
  private $_version_engine;
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
      $this->_session_token = 'user_token='.$this->session->data['user_token'];
    } else {
      $this->_session_token = 'token='.$this->session->data['token'];
    }
  }

  public function index() {
    $data = [];

    $models = [
      'extension/ocdevwizard/'.$this->_name
    ];

    foreach ($models as $model) {
      $this->load->model($model);
    }

    $data = array_merge($data,$this->language->load('extension/ocdevwizard/'.$this->_name));
    $this->document->setTitle($this->language->get('heading_title'));

    $scripts = [
      '//ocdevwizard.com/helper/magnific-popup/jquery.magnific-popup.min.js',
      '//ocdevwizard.com/helper/growl-notifications/growl-notification.min.js'
    ];

    foreach ($scripts as $script) {
      if ($script) {
        $this->document->addScript($script);
      }
    }

    $styles = [
      '//ocdevwizard.com/helper/main/helper.min.css',
      '//ocdevwizard.com/helper/magnific-popup/magnific-popup.min.css',
      '//ocdevwizard.com/helper/growl-notifications/colored-theme.min.css'
    ];

    foreach ($styles as $style) {
      if ($style) {
        $this->document->addStyle($style);
      }
    }

    $links = [
      ($this->config->get('config_secure') ? HTTPS_CATALOG : HTTP_CATALOG).'/image/catalog/ocdevwizard/helper/favicon.ico'
    ];

    foreach ($links as $link) {
      if ($link) {
        $this->document->addLink($link,'icon');
      }
    }

    if (version_compare(VERSION,'2.2.0.0','<=')) {
      $data['cancel'] = $this->url->link('extension/module',$this->_session_token,$this->_ssl_code);
    } else if (version_compare(VERSION,'3.0.0.0','>=')) {
      $data['cancel'] = $this->url->link('marketplace/extension',$this->_session_token.'&type=module',$this->_ssl_code);
    } else {
      $data['cancel'] = $this->url->link('extension/extension',$this->_session_token.'&type=module',$this->_ssl_code);
    }

    $data['_name']            = $this->_name;
    $data['_code']            = $this->_code;
    $data['_version']         = $this->_version;
    $data['opencart_version'] = VERSION;
    $data['token']            = $this->_session_token;
    $data['accessibility']    = $this->check_remote_file();

    // ocdev products
    $data['installed_products']               = $this->{'model_extension_ocdevwizard_'.$this->_name}->getOCdevCatalog('installed');
    $data['text_in_your_store']               = sprintf($this->language->get('text_in_your_store'),$this->make_declension(count($data['installed_products'])));
    $data['available_update_products']        = $this->{'model_extension_ocdevwizard_'.$this->_name}->getOCdevCatalog('available_update');
    $data['text_available_new_version']       = sprintf($this->language->get('text_available_new_version'),$this->make_declension(count($data['available_update_products'])));
    $data['available_upgrade_products']       = $this->{'model_extension_ocdevwizard_'.$this->_name}->getOCdevCatalog('available_upgrade');
    $data['text_improve_to_pro_plus_version'] = sprintf($this->language->get('text_improve_to_pro_plus_version'),$this->make_declension(count($data['available_upgrade_products'])));
    $data['available_products']               = $this->{'model_extension_ocdevwizard_'.$this->_name}->getOCdevCatalog('available');
    $data['text_you_also_may_like']           = sprintf($this->language->get('text_you_also_may_like'),$this->make_declension(count($data['available_products'])));

    $data['column_left'] = '';

    if (version_compare(VERSION,'2.0.0.0','>=')) {
      $data['header']      = $this->load->controller('common/header');
      $data['column_left'] = $this->load->controller('common/column_left');
      $data['footer']      = $this->load->controller('common/footer');
    }

    if (version_compare(VERSION,'3.0.0.0','>=')) {
      $this->response->setOutput($this->load->view('extension/ocdevwizard/'.$this->_name.'/index',$data));
    } else if (version_compare(VERSION,'2.0.0.0','<')) {
      $this->data = $data;

      $this->template = 'extension/ocdevwizard/'.$this->_name.'/index.tpl';

      $this->children = [
        'extension/ocdevwizard/'.$this->_name.'/header',
        'extension/ocdevwizard/'.$this->_name.'/footer'
      ];

      $this->response->setOutput($this->render());
    } else {
      $this->response->setOutput($this->load->view('extension/ocdevwizard/'.$this->_name.'/index.tpl',$data));
    }
  }

  public function get_promo_products() {
    $data = [];

    $models = [
      'extension/ocdevwizard/'.$this->_name
    ];

    foreach ($models as $model) {
      $this->load->model($model);
    }

    $data = array_merge($data,$this->language->load('extension/ocdevwizard/'.$this->_name));

    $data['product']                     = [];
    $data['opencart_marketplaces_array'] = [];

    if (isset($this->request->get['extension_id']) && !empty($this->request->get['extension_id'])) {
      $products = $this->{'model_extension_ocdevwizard_'.$this->_name}->getOCdevCatalog('get_info');

      if ($products) {
        foreach ($products as $product) {
          if ($product['extension_id'] == $this->request->get['extension_id']) {
            $data['product'] = $product;
          }
        }
      }

      if ($data['product']) {
        if (isset($data['product']['marketplaces']) && $data['product']['marketplaces']) {
          foreach ($data['product']['marketplaces'] as $marketplace) {
            $item_info = explode('|',$marketplace);

            $data['opencart_marketplaces_array'][] = [
              'name'    => $item_info[0],
              'href'    => $item_info[1],
              'special' => $item_info[2],
              'price'   => $item_info[3],
            ];
          }
        }
      }
    }

    if (version_compare(VERSION,'3.0.0.0','>=')) {
      $this->response->setOutput($this->load->view('extension/ocdevwizard/'.$this->_name.'/info',$data));
    } else if (version_compare(VERSION,'2.0.0.0','<')) {
      $this->data = $data;

      $this->template = 'extension/ocdevwizard/'.$this->_name.'/info.tpl';

      $this->response->setOutput($this->render());
    } else {
      $this->response->setOutput($this->load->view('extension/ocdevwizard/'.$this->_name.'/info.tpl',$data));
    }
  }

  public function need_help() {
    $data = [];

    $data = array_merge($data,$this->language->load('extension/ocdevwizard/'.$this->_name));

    $data['token'] = $this->_session_token;
    $data['_name'] = $this->_name;

    if (version_compare(VERSION,'3.0.0.0','>=')) {
      $this->response->setOutput($this->load->view('extension/ocdevwizard/'.$this->_name.'/need_help',$data));
    } else if (version_compare(VERSION,'2.0.0.0','<')) {
      $this->data = $data;

      $this->template = 'extension/ocdevwizard/'.$this->_name.'/need_help.tpl';

      $this->response->setOutput($this->render());
    } else {
      $this->response->setOutput($this->load->view('extension/ocdevwizard/'.$this->_name.'/need_help.tpl',$data));
    }
  }

  public function need_help_action() {
    $json = [];

    $models = ['extension/ocdevwizard/'.$this->_name];

    foreach ($models as $model) {
      $this->load->model($model);
    }

    $this->language->load('extension/ocdevwizard/'.$this->_name);

    if (!isset($this->request->post['email']) || empty($this->request->post['email'])) {
      $json['error']['email'] = $this->language->get('error_email');
    }

    if (!isset($this->request->post['order_id']) || empty($this->request->post['order_id'])) {
      $json['error']['order_id'] = $this->language->get('error_order_id');
    }

    if (!isset($this->request->post['marketplace']) || empty($this->request->post['marketplace'])) {
      $json['error']['marketplace'] = $this->language->get('error_marketplace');
    }

    if (!isset($this->request->post['message']) || empty($this->request->post['message'])) {
      $json['error']['message'] = $this->language->get('error_message');
    }

    if (!isset($json['error'])) {
      $filter_data = [
        'email'       => $this->request->post['email'],
        'order_id'    => $this->request->post['order_id'],
        'marketplace' => $this->request->post['marketplace'],
        'message'     => $this->request->post['message'],
        'module_name' => (isset($this->request->post['module_name'])) ? $this->request->post['module_name'] : ''
      ];

      $this->{'model_extension_ocdevwizard_'.$this->_name}->sendNeedHelpRequest($filter_data);

      $json['success'] = $this->language->get('text_success_send_request');
    }

    $this->response->addHeader('Content-Type: application/json');
    $this->response->setOutput(json_encode($json));
  }

  public function license_code_request() {
    $data = [];

    $data = array_merge($data,$this->language->load('extension/ocdevwizard/'.$this->_name));

    $data['token'] = $this->_session_token;
    $data['_name'] = $this->_name;

    if (version_compare(VERSION,'3.0.0.0','>=')) {
      $this->response->setOutput($this->load->view('extension/ocdevwizard/'.$this->_name.'/license_code_request',$data));
    } else if (version_compare(VERSION,'2.0.0.0','<')) {
      $this->data = $data;

      $this->template = 'extension/ocdevwizard/'.$this->_name.'/license_code_request.tpl';

      $this->response->setOutput($this->render());
    } else {
      $this->response->setOutput($this->load->view('extension/ocdevwizard/'.$this->_name.'/license_code_request.tpl',$data));
    }
  }

  public function license_code_request_action() {
    $json = [];

    $models = ['extension/ocdevwizard/'.$this->_name];

    foreach ($models as $model) {
      $this->load->model($model);
    }

    $this->language->load('extension/ocdevwizard/'.$this->_name);

    if (!isset($this->request->post['email']) || empty($this->request->post['email'])) {
      $json['error']['email'] = $this->language->get('error_email');
    }

    if (!isset($this->request->post['order_id']) || empty($this->request->post['order_id'])) {
      $json['error']['order_id'] = $this->language->get('error_order_id');
    }

    if (!isset($this->request->post['marketplace']) || empty($this->request->post['marketplace'])) {
      $json['error']['marketplace'] = $this->language->get('error_marketplace');
    }

    if (!isset($this->request->post['domain']) || empty($this->request->post['domain'])) {
      $json['error']['domain'] = $this->language->get('error_domain');
    }

    if (!isset($json['error'])) {
      $filter_data = [
        'email'              => $this->request->post['email'],
        'order_id'           => $this->request->post['order_id'],
        'marketplace'        => $this->request->post['marketplace'],
        'domain'             => $this->request->post['domain'],
        'test_domain_status' => (isset($this->request->post['test_domain_status'])) ? 1 : 0,
        'test_domain'        => $this->request->post['test_domain'],
        'module_name'        => (isset($this->request->post['module_name'])) ? $this->request->post['module_name'] : ''
      ];

      $this->{'model_extension_ocdevwizard_'.$this->_name}->sendLicenseRequest($filter_data);

      $json['success'] = $this->language->get('text_success_send_request');
    }

    $this->response->addHeader('Content-Type: application/json');
    $this->response->setOutput(json_encode($json));
  }

  public function preview_faq() {
    $data = [];

    $data = array_merge($data,$this->language->load('extension/ocdevwizard/'.$this->_name));

    $data['module_name'] = (isset($this->request->get['module_name']) && $this->request->get['module_name']) ? $this->request->get['module_name'] : '';
    $data['img_name']    = (isset($this->request->get['img_name']) && $this->request->get['img_name']) ? $this->request->get['img_name'] : '';

    if (version_compare(VERSION,'3.0.0.0','>=')) {
      $this->response->setOutput($this->load->view('extension/ocdevwizard/'.$this->_name.'/preview_faq',$data));
    } else if (version_compare(VERSION,'2.0.0.0','<')) {
      $this->data = $data;

      $this->template = 'extension/ocdevwizard/'.$this->_name.'/preview_faq.tpl';

      $this->response->setOutput($this->render());
    } else {
      $this->response->setOutput($this->load->view('extension/ocdevwizard/'.$this->_name.'/preview_faq.tpl',$data));
    }
  }

  public function preview_background_image() {
    $data = [];

    $data = array_merge($data,$this->language->load('extension/ocdevwizard/'.$this->_name));

    $data['img_src'] = (isset($this->request->get['img_src']) && $this->request->get['img_src']) ? $this->request->get['img_src'] : '';
    $data['img_id']  = (isset($this->request->get['img_id']) && $this->request->get['img_id']) ? $this->request->get['img_id'] : '';

    if (version_compare(VERSION,'3.0.0.0','>=')) {
      $this->response->setOutput($this->load->view('extension/ocdevwizard/'.$this->_name.'/preview_background_image',$data));
    } else if (version_compare(VERSION,'2.0.0.0','<')) {
      $this->data = $data;

      $this->template = 'extension/ocdevwizard/'.$this->_name.'/preview_background_image.tpl';

      $this->response->setOutput($this->render());
    } else {
      $this->response->setOutput($this->load->view('extension/ocdevwizard/'.$this->_name.'/preview_background_image.tpl',$data));
    }
  }

  private function make_declension($total) {
    $this->language->load('extension/ocdevwizard/'.$this->_name);

    $tag_codes = [
      '{count}',
    ];

    $tag_codes_replace = [
      $total
    ];

    $text_items = '{count} '.$this->language->get('text_declension');

    preg_match_all('/{declension}(.*?){\/declension}/',$text_items,$text_items_matches,PREG_SET_ORDER);

    if ($text_items_matches) {
      foreach ($text_items_matches as $text_items_match) {
        preg_match('/{declension}(.*?){\/declension}/',$text_items_match[0],$text_items_match_item);

        if ((isset($text_items_match_item[0]) && $text_items_match_item[0]) && (isset($text_items_match_item[1]) && $text_items_match_item[1])) {
          $declension_words = explode("|",$text_items_match_item[1]);

          $declension_data = [
            'number' => $total,
            'words'  => $declension_words
          ];

          $indexes = [2,0,1,1,1,2];

          $text_items = str_replace($text_items_match_item[0],($declension_data['words'][($declension_data['number'] % 100 > 4 && $declension_data['number'] % 100 < 20) ? 2 : $indexes[min($declension_data['number'] % 10,5)]]),$text_items);
        }
      }
    }

    return html_entity_decode(str_replace($tag_codes,$tag_codes_replace,$text_items),ENT_QUOTES,'UTF-8');
  }

  private function check_remote_file() {
    $file         = 'http://ocdevwizard.com/products/share/share.xml';
    $file_headers = @get_headers($file);

    if (isset($file_headers[0]) && strpos($file_headers[0],'200 OK')) {
      return true;
    } else {
      return false;
    }
  }

  // start: for OpenCart 1.5.5.1 > 1.5.6.4
  protected function header() {
    $this->language->load('common/header');

    $this->data['base']           = (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) ? HTTPS_SERVER : HTTP_SERVER;
    $this->data['title']          = $this->document->getTitle();
    $this->data['description']    = $this->document->getDescription();
    $this->data['keywords']       = $this->document->getKeywords();
    $this->data['links']          = $this->document->getLinks();
    $this->data['styles']         = $this->document->getStyles();
    $this->data['scripts']        = $this->document->getScripts();
    $this->data['lang']           = $this->language->get('code');
    $this->data['direction']      = $this->language->get('direction');
    $this->data['heading_title']  = $this->language->get('heading_title');
    $this->data['is_helper_page'] = (isset($this->request->get['route']) && $this->request->get['route'] == 'extension/ocdevwizard/helper') ? 1 : 0;

    $this->template = 'extension/ocdevwizard/'.$this->_name.'/header_for_oc1.tpl';

    $this->render();
  }

  protected function footer() {
    $this->language->load('common/footer');

    $this->data['text_footer'] = sprintf($this->language->get('text_footer'),VERSION);

    if (file_exists(DIR_SYSTEM.'config/svn/svn.ver')) {
      $this->data['text_footer'] .= '.r'.trim(file_get_contents(DIR_SYSTEM.'config/svn/svn.ver'));
    }

    $this->template = 'extension/ocdevwizard/'.$this->_name.'/footer_for_oc1.tpl';

    $this->render();
  }
  // end: for OpenCart 1.5.5.1 > 1.5.6.4
}

?>
