<?php
class ControllerExtensionModulePopupOrder extends Controller {
    public function index() {
        $data = array();

        $this->load->language('extension/module/popup_order');

        $popup_order_data         = (array) $this->config->get('popup_order_data');
        $data['popup_order_data'] = $popup_order_data;

        if(isset($this->request->get['product_id'])){
            $data['product_id'] = $this->request->get['product_id'];
        } else {
            $data['product_id'] = '';
        }

        $this->load->model('catalog/product');
        $product_info = $this->model_catalog_product->getProduct($data['product_id']);

        $data['store'] = $this->config->get('config_name');
        $data['storeset_whatsapp_id'] = $this->config->get('storeset_whatsapp_id');
        $data['storeset_telegram_id'] = $this->config->get('storeset_telegram_id');
        $data['storeset_viber_id']    = $this->config->get('storeset_viber_id');

        if(isset($product_info['name'])){
            $data['heading_title']    = $product_info['name'];
        } else {
            $data['heading_title']    = $this->language->get('heading_title');
        }

        $data['button_close']     = $this->language->get('button_close');
        $data['button_send']      = $this->language->get('button_send');
        $data['enter_first_name'] = $this->language->get('enter_first_name');
        $data['enter_last_name']  = $this->language->get('enter_last_name');
        $data['enter_email']      = $this->language->get('enter_email');
        $data['enter_telephone']  = $this->language->get('enter_telephone');
        $data['enter_comment']    = $this->language->get('enter_comment');
        $data['enter_time']       = $this->language->get('enter_time');
        $data['text_select']      = $this->language->get('text_select');
        $data['text_loading']     = $this->language->get('text_loading');
        $data['text_extra']       = $this->language->get('text_extra');
        $data['text_agree']       = $this->language->get('text_agree');

        $data['first_name'] = ($this->customer->isLogged()) ? $this->customer->getFirstName() : '';
        $data['last_name']  = ($this->customer->isLogged()) ? $this->customer->getLastName() : '';
        $data['email']      = ($this->customer->isLogged()) ? $this->customer->getEmail() : '';
        $data['telephone']  = ($this->customer->isLogged()) ? $this->customer->getTelephone() : '';
        $data['comment']    = '';
        $data['time']       = '';


         $data['mask'] = ($popup_order_data['mask']) ? $popup_order_data['mask'] : '';

        if ($this->request->server['HTTPS']) {
            $server = $this->config->get('config_ssl');
          } else {
            $server = $this->config->get('config_url');
          }

        if (is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
            $data['logo'] = $server . 'image/' . $this->config->get('config_logo');
        } else {
            $data['logo'] = '';
        }

        if ($this->config->get('config_account_id')) {
            $this->load->model('catalog/information');

            $information_info = $this->model_catalog_information->getInformation($this->config->get('config_account_id'));

            if ($information_info) {
                // $data['text_terms'] = sprintf($this->language->get('text_terms'), $this->url->link('information/information', 'information_id=' . $this->config->get('storeset_terms'), 'SSL'), $information_info['title'], $information_info['title']);
                $data['text_agree'] = sprintf($this->language->get('text_agree'), $this->url->link('information/information', 'information_id=' . $this->config->get('config_account_id'), 'SSL'), $information_info['title'], $information_info['title']);
            } else {
                $data['text_terms'] = '';
            }
        } else {
            $data['text_terms'] = '';
        }

        $this->response->setOutput($this->load->view('extension/module/popup_order', $data));
    }

    public function send() {
        $json = array();

        $this->language->load('extension/module/popup_order');

        $this->load->model('extension/module/popup_order');

        $popup_order_data = (array) $this->config->get('popup_order_data');

        if (isset($this->request->post['first_name'])) {
            if ((utf8_strlen($this->request->post['first_name']) < 3) || (utf8_strlen($this->request->post['first_name']) > 32)) {
                $json['error']['field']['first_name'] = $this->language->get('error_first_name');
              }
        }

        if (isset($this->request->post['last_name'])) {
            if ((utf8_strlen($this->request->post['last_name']) < 3) || (utf8_strlen($this->request->post['last_name']) > 32)) {
                $json['error']['field']['last_name'] = $this->language->get('error_last_name');
              }
        }

        if (isset($this->request->post['time'])) {
            if (isset($popup_order_data['time']) && $popup_order_data['time'] == 2) {
                if (empty($this->request->post['time'])) {
                    $json['error']['field']['time'] = $this->language->get('error_time');
                }
            }
        }

        if (isset($this->request->post['email'])) {
            if ((utf8_strlen($this->request->post['email']) < 3) || (utf8_strlen($this->request->post['email']) > 32)) {
              $json['error']['field']['email'] = $this->language->get('error_email');
            }
          }

        if (isset($this->request->post['telephone'])) {
            if ((isset($popup_order_data['telephone']) && $popup_order_data['telephone'] == 2) && (utf8_strlen($this->request->post['telephone']) < 3) || (utf8_strlen($this->request->post['telephone']) > 32)) {
                $json['error']['field']['telephone'] = $this->language->get('error_telephone');
            }
        }

        if (isset($this->request->post['comment'])) {
            if ((isset($popup_order_data['comment']) && $popup_order_data['comment'] == 2) && (utf8_strlen($this->request->post['comment']) < 3) || (utf8_strlen($this->request->post['comment']) > 500)) {
                $json['error']['field']['comment'] = $this->language->get('error_comment');
            }
        }

        // if ($this->config->get('config_account_id')) {
        //     if (!isset($this->request->post['agree'])) {
        //         $this->load->model('catalog/information');

        //         $information_info = $this->model_catalog_information->getInformation($this->config->get('config_account_id'));

        //         $json['error']['field']['agree'] = sprintf($this->language->get('error_agree'), $information_info['title']);
        //     }
        // }

        if (!isset($json['error'])) {

            $post_data = $this->request->post;

            if (isset($post_data['first_name'])) {
                $data[] = array(
                    'name' => $this->language->get('enter_first_name'),
                    'value' => $post_data['first_name']
                );
            }

            if (isset($post_data['last_name'])) {
                $data[] = array(
                    'name' => $this->language->get('enter_last_name'),
                    'value' => $post_data['last_name']
                );
            }

            if (isset($post_data['email'])) {
                $data[] = array(
                  'name' => $this->language->get('enter_email'),
                  'value' => $post_data['email']
                );
              }

            if (isset($post_data['telephone'])) {
                $data[] = array(
                    'name' => $this->language->get('enter_telephone'),
                    'value' => $post_data['telephone']
                );
            }

            if (isset($post_data['comment'])) {
                $data[] = array(
                    'name' => $this->language->get('enter_comment'),
                    'value' => $post_data['comment']
                );
            }

            if (isset($post_data['time'])) {
                $data[] = array(
                    'name' => $this->language->get('enter_time'),
                    'value' => $post_data['time']
                );
            }
            $url = '';
            if(isset($post_data['product_id'])){
                $this->load->model('catalog/product');
                $product_info = $this->model_catalog_product->getProduct($post_data['product_id']);
                $link = $this->url->link('product/product', '&product_id=' . $product_info['product_id'] . $url);
                $data['product']['name'] = '<a href="'.$link.'">'.$product_info['name'].' ('.$product_info['model'].')</a>';
               /* $data['product']['link_site'] = $this->url->link('product/product', '&product_id=' . $product_info['product_id'] . $url);*/
               // $json['product'] = $product_info;
            }


            $data_send = array(
                'info' => serialize($data)
            );

            $this->model_extension_module_popup_order->addRequest($data_send);

            $json['output'] = $this->language->get('text_success_send');

            if ($popup_order_data['notify_status']) {

                $html_data['date_added'] = date('d.m.Y H:i:s', time());
                $html_data['logo']       = $this->config->get('config_url') . 'image/' . $this->config->get('config_logo');
                $html_data['store_name'] = $this->config->get('config_name');
                $html_data['store_url']  = $this->config->get('config_url');

                $html_data['text_info']       = $this->language->get('text_info');
                $html_data['text_date_added'] = $this->language->get('text_date_added');
                $html_data['data_info']       = $data;

                $html = $this->load->view('mail/popup_order_mail', $html_data);

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
                $mail->setSubject($this->language->get('heading_title') . " -- " . $html_data['date_added']);
                $mail->setHtml($html);

                $emails = explode(',', $popup_order_data['notify_email']);

                foreach ($emails as $email) {
                    if ($email && preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $email)) {
                        $mail->setTo($email);
                        $mail->send();
                    }
                }
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
}