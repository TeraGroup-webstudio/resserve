<?php
class ControllerCommonFooter extends Controller {
    public function index() {
        require_once('system/library/Mobile_Detect.php');
        $detect = new Mobile_Detect;

        if(isset($this->session->data['language'])) {
            $data['code'] = substr($this->session->data['language'],0,-3);
        } else {
            $data['code'] = substr($this->config->get('config_language'),0,-3);
        }

        $this->load->language('common/footer');
        $language_id = $this->config->get('config_language_id');
        $this->load->model('catalog/information');
        $this->load->model('tool/image');
        $data['name'] = $this->config->get('config_name');
        $data['config_email'] = $this->config->get('config_email');
        //theme_default_product_refresh_price_status
        if($this->config->get('theme_default_product_refresh_price_status') == 1){
            $currency_code = $this->session->data['currency'];
            $data['autocalc_currency'] = array(
                'value'           => (float)$this->currency->getValue($currency_code),
                'symbol_left'     => str_replace("'", "\'", $this->currency->getSymbolLeft($currency_code)),
                'symbol_right'    => str_replace("'", "\'", $this->currency->getSymbolRight($currency_code)),
                'decimals'        => (int)$this->currency->getDecimalPlace($currency_code),
                'decimal_point'   => $this->language->get('decimal_point'),
                'thousand_point'  => $this->language->get('thousand_point'),
            );

            $data['autocalc_option_special'] = $this->config->get('theme_default_product_refresh_price_option_special');
            $data['autocalc_option_discount'] = $this->config->get('theme_default_product_refresh_price_option_discount');
            $data['autocalc_not_mul_qty'] = $this->config->get('theme_default_product_refresh_price_not_mul_qty');
            $data['autocalc_select_first'] = $this->config->get('theme_default_product_refresh_price_select_first');

        }

        /* соціальні мережі */
        $data['links_seti'] = array();
        $data['links_icons'] = array();
        if($this->config->get('theme_default_footer_seti_status') == 1){
            if ($this->config->get('theme_default_footer_seti')){
                $links_seti = $this->config->get('theme_default_footer_seti');
            } else {
                $links_seti = array();
            }

            foreach ($links_seti as $result) {

                if (is_file(DIR_IMAGE . $result['image_peace'])) {
                    $image_peace = $result['image_peace'];
                } else {
                    $image_peace = '';
                }
                $data['links_seti'][] = array(
                    'image_peace' => 'image/' . $image_peace,
                    'link'  			=> $result['link'][$language_id],
                    'sort'  			=> $result['sort']
                );

            }

            if (!empty($data['links_seti'])){
                foreach ($data['links_seti'] as $key => $value) {
                    $sort_add_category_menu[$key] = $value['sort'];
                }
                array_multisort($sort_add_category_menu, SORT_ASC, $data['links_seti']);
            }
        }
        if($this->config->get('theme_default_footer_icons_status') == 1){
            if ($this->config->get('theme_default_footer_icons')){
                $links_icons = $this->config->get('theme_default_footer_icons');
            } else {
                $links_icons = array();
            }

            foreach ($links_icons as $result) {

                if (is_file(DIR_IMAGE . $result['image_peace'])) {
                    $image_peace = $result['image_peace'];
                } else {
                    $image_peace = '';
                }
                $data['links_icons'][] = array(
                    'image_peace' => 'image/' . $image_peace,
                    'sort'  			=> $result['sort']
                );

            }

            usort($data['links_icons'], function ($a, $b) {
			return $a['sort'] - $b['sort'];
		});
        }

        if($this->config->get('theme_default_footer_newsletter_status') == 1){
            $data['show_form'] = 1;
        } else {
            $data['show_form'] = 0;
        }


        if ($this->request->server['HTTPS']) {
            $server = $this->config->get('config_ssl');
        } else {
            $server = $this->config->get('config_url');
        }

        if (is_file(DIR_IMAGE . $this->config->get('config_logo1'))) {
            $data['logo'] = $server . 'image/' . $this->config->get('config_logo1');
        } else {
            $data['logo'] = '';
        }
        $data['informations'] = array();

        foreach ($this->model_catalog_information->getInformations() as $result) {
            if ($result['bottom']) {
                $data['informations'][] = array(
                    'title' => $result['title'],
                    'href'  => $this->url->link('information/information', 'information_id=' . $result['information_id'])
                );
            }
        }


        /* catalog */
        $this->load->model('catalog/category');

        $data['categories'] = array();

        $categories = $this->model_catalog_category->getCategories(0);

        foreach ($categories as $category) {
            $children_data = array();

            $data['categories'][] = array(
                'category_id' => $category['category_id'],
                'name'        => $category['name'],
                'children'    => $children_data,
                'href'        => $this->url->link('product/category', 'path=' . $category['category_id'])
            );
        }

        $data['contact'] = $this->url->link('information/contact');
        $data['home'] = $this->url->link('common/home');
        $data['news'] = $this->url->link('blog/latest');
        $data['reviews'] = $this->url->link('product/reviews');
        $data['manufacturers'] = $this->url->link('product/manufacturer');
        $data['colections'] = $this->url->link('product/colections');
        $data['return'] = $this->url->link('account/return/add', '', true);
        $data['sitemap'] = $this->url->link('information/sitemap');
        $data['tracking'] = $this->url->link('information/tracking');
        $data['manufacturer'] = $this->url->link('product/manufacturer');
        $data['voucher'] = $this->url->link('account/voucher', '', true);
        $data['affiliate'] = $this->url->link('affiliate/login', '', true);
        $data['special'] = $this->url->link('product/special');
        $data['account'] = $this->url->link('account/account', '', true);
        $data['order'] = $this->url->link('account/order', '', true);
        $data['wishlist'] = $this->url->link('account/wishlist', '', true);
        $data['newsletter'] = $this->url->link('account/newsletter', '', true);
        $data['open'] = nl2br($this->config->get('config_open')[$this->config->get('config_language_id')]);
        $data['address'] = nl2br($this->config->get('config_address')[$this->config->get('config_language_id')]);
        $data['telephone'] = $this->config->get('config_telephone');

        $data['list_phones'] = array();
        if ($this->config->get('config_number')) {
            $additional_phones = $this->config->get('config_number');
        } else {
            $additional_phones = array();
        }

        if ($additional_phones){
            foreach ($additional_phones as $key => $value) {
                $additional_phones_sorted[$key] = $value['sort'];
            }
            array_multisort($additional_phones_sorted, SORT_ASC, $additional_phones);
        }

        foreach ($additional_phones as $phone) {
            $data['list_phones'][] = array(
                'title'        => $phone['title'][$language_id],
                'href'         => $phone['link'][$language_id],
                'hint_text'    => $phone['hint'][$language_id],
                'hint_show'    => false,
                'image' 		   => ($phone['image'] != '') ? 'image/' . $phone['image'] : '',
                'sort'         => $phone['sort'],
            );

        }
        /* messenger */
        $data['list_messenger'] = array();
        if ($this->config->get('config_messager')) {
            $messengers = $this->config->get('config_messager');
        } else {
            $messengers = array();
        }

        if ($messengers){
            foreach ($messengers as $key => $value) {
                $messengers_sorted[$key] = $value['sort'];
            }
            array_multisort($messengers_sorted, SORT_ASC, $messengers);
        }

        foreach ($messengers as $messenger) {

            $data['list_messenger'][] = array(
                'href'         => $messenger['link'][$language_id],
                'hint_text'    => $messenger['hint'][$language_id],
                'hint_show'    => false,
                'image' 		   => 'image/' . $messenger['image'],
                'sort'         => $messenger['sort'],
            );

        }

        $data['powered'] = sprintf($this->language->get('text_powered'), $this->config->get('config_name'), date('Y', time()));
        $data['status_one_click'] = $this->config->get('theme_default_product_one_click_status');

        // Whos Online
        if ($this->config->get('config_customer_online')) {
            $this->load->model('tool/online');

            if (isset($this->request->server['REMOTE_ADDR'])) {
                $ip = $this->request->server['REMOTE_ADDR'];
            } else {
                $ip = '';
            }

            if (isset($this->request->server['HTTP_HOST']) && isset($this->request->server['REQUEST_URI'])) {
                $url = ($this->request->server['HTTPS'] ? 'https://' : 'http://') . $this->request->server['HTTP_HOST'] . $this->request->server['REQUEST_URI'];
            } else {
                $url = '';
            }

            if (isset($this->request->server['HTTP_REFERER'])) {
                $referer = $this->request->server['HTTP_REFERER'];
            } else {
                $referer = '';
            }

            $this->model_tool_online->addOnline($ip, $this->customer->getId(), $url, $referer);
        }

        $data['scripts'] = $this->document->getScripts('footer');

        // if ($detect->isMobile() ) {
        //     return $this->load->view('common/footer_mobile', $data);
        // } else {
        //     return $this->load->view('common/footer', $data);
        // }
        return $this->load->view('common/footer', $data);

    }
    public function send() {
        $json = array();

        $this->load->language('common/footer');
        
        if (isset($this->request->post['newsletter'])) {
        $mail = $this->request->post['newsletter'];
        $patternMail = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
        if (!preg_match($patternMail, $mail)) {
            $json['error']['field']['newsletter'] = $this->language->get('error_text');
        }
        }
        
        if (!isset($json['error'])) {
            
            $post_data = $this->request->post;
            
            if (isset($post_data['newsletter'])) {
                $data[] = array(
                    'name' => $this->language->get('enter_mail'),
                    'value' => $post_data['newsletter']
                );
            }

            $data_send = array(
                'info' => serialize($data)
            );

            $json['output'] = $this->language->get('text_success');
                
            $html_data['date_added'] = date('d.m.Y H:i:s', time());
            $html_data['logo']       = $this->config->get('config_url') . 'image/' . $this->config->get('config_logo');
            $html_data['store_name'] = $this->config->get('config_name');
            $html_data['store_url']  = $this->config->get('config_url');
                
            $html_data['text_info']       = $this->language->get('mail_subject');
            $html_data['text_date_added'] = $this->language->get('text_date_added');
            $html_data['data_info']       = $data;
            
            $html = $this->load->view('mail/popup_call_phone_mail', $html_data);
                
            $mail                = new Mail();
            $mail->protocol      = $this->config->get('config_mail_protocol');
            $mail->parameter     = $this->config->get('config_mail_parameter');
            $mail->smtp_hostname = (version_compare(VERSION, '2.0.3', '<')) ? $this->config->get('config_mail_smtp_host') : $this->config->get('config_mail_smtp_hostname');
            $mail->smtp_username = $this->config->get('config_mail_smtp_username');
            $mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
            $mail->smtp_port     = $this->config->get('config_mail_smtp_port');
            $mail->smtp_timeout  = $this->config->get('config_mail_smtp_timeout');
                
            $mail->setFrom($this->config->get('config_email'));
            $mail->setSender($this->config->get('config_name'));
            $mail->setSubject($this->language->get('mail_subject') . " -- " . $html_data['date_added']);
            $mail->setHtml($html);
            
            $mail->setTo($this->config->get('config_email'));
            $mail->send();
        }
        
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
}
