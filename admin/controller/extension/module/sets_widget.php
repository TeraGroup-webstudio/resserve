<?php 

require_once DIR_SYSTEM . 'library/kjhelper.php';

class ControllerExtensionModuleSetsWidget extends Controller
{

    private $error = array();

    public function index()
    {
        if((floatval(VERSION) < 3))
            $this->load->model('extension/module');
        else
            $this->load->model('setting/module');
        
        $this->load->language('extension/module/sets_widget');
        $this->load->model('catalog/category');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) 
        {

            if((floatval(VERSION) < 3))
            {
                if (!isset($this->request->get['module_id'])) 
                {
                    $this->model_extension_module->addModule('sets_widget', $this->request->post);
                }
                else 
                {
                    $this->model_extension_module->editModule($this->request->get['module_id'], $this->request->post);
                }
            }
            else
            {
                if (!isset($this->request->get['module_id'])) 
                {
                    $this->model_setting_module->addModule('sets_widget', $this->request->post);

                } 
                else 
                {
                    $this->model_setting_module->editModule($this->request->get['module_id'], $this->request->post);
                }
            }

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link(kjhelper::$marketplace_link, kjhelper::$user_token . '=' . $this->session->data[kjhelper::$user_token].'&type=module', true));
        }

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_info']                   = $this->language->get('text_info');
        $data['text_before']                 = $this->language->get('text_before');
        $data['text_after']                  = $this->language->get('text_after');
        $data['text_edit']                   = $this->language->get('text_edit');
        $data['text_orientation_vertical']   = $this->language->get('text_orientation_vertical');
        $data['text_orientation_horizontal'] = $this->language->get('text_orientation_horizontal');
        $data['text_orientation_series']     = $this->language->get('text_orientation_series');

        $data['text_enabled']  = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');

        $data['entry_orientation'] = $this->language->get('entry_orientation');
        $data['entry_name']        = $this->language->get('entry_name');
        $data['entry_status']      = $this->language->get('entry_status');
        $data['entry_products']    = $this->language->get('entry_products');
        $data['user_token']             = $this->session->data[kjhelper::$user_token];

        $data['button_save']   = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {

            if((floatval(VERSION) < 3))
                $extension_module_info = $this->model_extension_module->getModule($this->request->get['module_id']);
            else
                $extension_module_info = $this->model_setting_module->getModule($this->request->get['module_id']);

        }

        if (isset($this->request->post['name'])) {
            $data['name'] = $this->request->post['name'];
        } elseif (!empty($extension_module_info)) {
            $data['name'] = $extension_module_info['name'];
        } else {
            $data['name'] = '';
        }

        if (isset($this->request->post['product'])) {
            $data['product'] = $this->request->post['product'];
        } elseif (!empty($extension_module_info) && isset($extension_module_info['product'])) {
            $data['product'] = $extension_module_info['product'];
        } else {
            $data['product'] = '';
        }

        if (isset($this->request->post['status'])) {
            $data['status'] = $this->request->post['status'];
        } elseif (!empty($extension_module_info)) {
            $data['status'] = $extension_module_info['status'];
        } else {
            $data['status'] = '';
        }

        if (isset($this->request->post['orientation'])) {
            $data['orientation'] = $this->request->post['orientation'];
        } elseif (!empty($extension_module_info)) {
            $data['orientation'] = $extension_module_info['orientation'];
        } else {
            $data['orientation'] = '';
        }

        if (isset($this->request->post['one_slider'])) {
            $data['one_slider'] = $this->request->post['one_slider'];
        } elseif (!empty($extension_module_info)) {
            $data['one_slider'] = $extension_module_info['one_slider'];
        } else {
            $data['one_slider'] = '';
        }

        if (isset($this->request->post['cart'])) {
            $data['cart'] = $this->request->post['cart'];
        } elseif (!empty($extension_module_info)) {
            $data['cart'] = $extension_module_info['cart'];
        } else {
            $data['cart'] = '';
        }

        if (!isset($this->request->get['module_id'])) {
            $data['action'] = $this->url->link('extension/module/sets_widget', kjhelper::$user_token . '=' . $this->session->data[kjhelper::$user_token], true);
        } else {
            $data['action'] = $this->url->link('extension/module/sets_widget', kjhelper::$user_token . '=' . $this->session->data[kjhelper::$user_token] . '&module_id=' . $this->request->get['module_id'], true);
        }

        $data['cancel'] = $this->url->link(kjhelper::$marketplace_link, kjhelper::$user_token . '=' . $this->session->data[kjhelper::$user_token] . '&type=module', true);

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', kjhelper::$user_token . '=' . $this->session->data[kjhelper::$user_token], true),
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_module'),
            'href' => $this->url->link(kjhelper::$marketplace_link, kjhelper::$user_token . '=' . $this->session->data[kjhelper::$user_token].'&type=module', true),
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/module/sets_widget', kjhelper::$user_token . '=' . $this->session->data[kjhelper::$user_token], true),
        );

        $data['header']      = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer']      = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/module/sets/sets_widget', $data));

    }

    protected function validate()
    {
        if (!$this->user->hasPermission('modify', 'extension/module/sets_widget')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }

}
