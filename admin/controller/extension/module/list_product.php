<?php
class ControllerExtensionModuleListProduct extends Controller {
    private $error = array();

    public function index() {


        $this->load->model('localisation/language');

        $data['languages'] = $languages = $this->model_localisation_language->getLanguages();
        $data['language_id'] = $language_id = $this->config->get('config_language_id');

        $this->load->language('extension/module/list_product');

        $this->document->setTitle(strip_tags($this->language->get('heading_title')));
        $this->document->addStyle('view/stylesheet/frametheme/frametheme.css');

        $this->load->model('setting/module');

        if (!isset($this->request->get['module_id'])) {
            $data['apply_button'] = false;
        } else {
            $data['apply_button'] = true;
        }

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            if (!isset($this->request->get['module_id'])) {
                $this->model_setting_module->addModule('list_product', $this->request->post);
            } else {
                $this->model_setting_module->editModule($this->request->get['module_id'], $this->request->post);
            }

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
        }

        $data['heading_title'] = strip_tags($this->language->get('heading_title'));

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['name'])) {
            $data['error_name'] = $this->error['name'];
        } else {
            $data['error_name'] = '';
        }

        if (isset($this->error['width'])) {
            $data['error_width'] = $this->error['width'];
        } else {
            $data['error_width'] = '';
        }

        if (isset($this->error['height'])) {
            $data['error_height'] = $this->error['height'];
        } else {
            $data['error_height'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
        );

        if (!isset($this->request->get['module_id'])) {
            $data['breadcrumbs'][] = array(
                'text' => strip_tags($this->language->get('heading_title')),
                'href' => $this->url->link('extension/module/list_product', 'user_token=' . $this->session->data['user_token'], true)
            );
        } else {
            $data['breadcrumbs'][] = array(
                'text' => strip_tags($this->language->get('heading_title')),
                'href' => $this->url->link('extension/module/list_product', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true)
            );
        }

        if (!isset($this->request->get['module_id'])) {
            $data['action'] = $this->url->link('extension/module/list_product', 'user_token=' . $this->session->data['user_token'], true);
        } else {
            $data['action'] = $this->url->link('extension/module/list_product', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true);
        }

        $data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

        if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $module_info = $this->model_setting_module->getModule($this->request->get['module_id']);
        }

        $data['user_token'] = $this->session->data['user_token'];

        if (isset($this->request->post['name'])) {
            $data['name'] = $this->request->post['name'];
        } elseif (!empty($module_info)) {
            $data['name'] = $module_info['name'];
        } else {
            $data['name'] = '';
        }

        if (isset($this->request->post['title'])) {
            $data['title'] = $this->request->post['title'];
        } elseif (!empty($module_info)) {
            $data['title'] = $module_info['title'];
        } else {
            $data['title'] = '';
        }

        if (isset($this->request->post['page_status'])) {
            $data['page_status'] = $this->request->post['page_status'];
        } elseif (!empty($module_info)) {
            $data['page_status'] = $module_info['page_status'];
        } else {
            $data['page_status'] = '';
        }

        if (isset($this->request->post['page_title'])) {
            $data['page_title'] = $this->request->post['page_title'];
        } elseif (!empty($module_info)) {
            $data['page_title'] = $module_info['page_title'];
        } else {
            $data['page_title'] = '';
        }

        if (isset($this->request->post['page_url'])) {
            $data['page_url'] = $this->request->post['page_url'];
        } elseif (!empty($module_info)) {
            $data['page_url'] = $module_info['page_url'];
        } else {
            $data['page_url'] = '';
        }

        if (isset($this->request->post['module_type'])) {
            $data['module_type'] = $this->request->post['module_type'];
        } elseif (!empty($module_info)) {
            $data['module_type'] = $module_info['module_type'];
        } else {
            $data['module_type'] = 'latest';
        }

        if (isset($this->request->post['hide_out_of_stock_products'])) {
            $data['hide_out_of_stock_products'] = $this->request->post['hide_out_of_stock_products'];
        } elseif (!empty($module_info)) {
            $data['hide_out_of_stock_products'] = $module_info['hide_out_of_stock_products'];
        } else {
            $data['hide_out_of_stock_products'] = '';
        }

        if (isset($this->request->post['hide_noimage_products'])) {
            $data['hide_noimage_products'] = $this->request->post['hide_noimage_products'];
        } elseif (!empty($module_info)) {
            $data['hide_noimage_products'] = $module_info['hide_noimage_products'];
        } else {
            $data['hide_noimage_products'] = '';
        }

        if (isset($this->request->post['shufle_products'])) {
            $data['shufle_products'] = $this->request->post['shufle_products'];
        } elseif (!empty($module_info)) {
            $data['shufle_products'] = $module_info['shufle_products'];
        } else {
            $data['shufle_products'] = '';
        }


        $this->load->model('catalog/product');

        $data['products'] = array();

        if (!empty($this->request->post['product'])) {
            $products = $this->request->post['product'];
        } elseif (!empty($module_info['product'])) {
            $products = $module_info['product'];
        } else {
            $products = array();
        }

        foreach ($products as $product_id) {
            $product_info = $this->model_catalog_product->getProduct($product_id);

            if ($product_info) {
                $data['products'][] = array(
                    'product_id' => $product_info['product_id'],
                    'name'       => $product_info['name']
                );
            }
        }

        if (isset($this->request->post['limit'])) {
            $data['limit'] = $this->request->post['limit'];
        } elseif (!empty($module_info)) {
            $data['limit'] = $module_info['limit'];
        } else {
            $data['limit'] = 6;
        }

        if (isset($this->request->post['width'])) {
            $data['width'] = $this->request->post['width'];
        } elseif (!empty($module_info)) {
            $data['width'] = $module_info['width'];
        } else {
            $data['width'] = 170;
        }

        if (isset($this->request->post['height'])) {
            $data['height'] = $this->request->post['height'];
        } elseif (!empty($module_info)) {
            $data['height'] = $module_info['height'];
        } else {
            $data['height'] = 170;
        }

        if (isset($this->request->post['status'])) {
            $data['status'] = $this->request->post['status'];
        } elseif (!empty($module_info)) {
            $data['status'] = $module_info['status'];
        } else {
            $data['status'] = '';
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/module/list_product', $data));
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'extension/module/list_product')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
            $this->error['name'] = $this->language->get('error_name');
        }

        if (!$this->request->post['width']) {
            $this->error['width'] = $this->language->get('error_width');
        }

        if (!$this->request->post['height']) {
            $this->error['height'] = $this->language->get('error_height');
        }

        return !$this->error;
    }
}
