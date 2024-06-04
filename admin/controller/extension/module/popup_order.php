<?php
class ControllerExtensionModulePopupOrder extends Controller {
    private $error = array();
    
    public function index() {
        $this->load->language('extension/module/popup_order');
        
        $this->document->setTitle($this->language->get('heading_title'));
        
        $this->document->addScript('view/javascript/popup_call_phone/jquery.minicolors.min.js');
        $this->document->addStyle('view/javascript/popup_call_phone/jquery.minicolors.css');
        
        $this->load->model('setting/setting');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('popup_order', $this->request->post);
            
            $this->session->data['success'] = $this->language->get('text_success');
            
            $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
        }
        
        $data['heading_title'] = $this->language->get('heading_title');
        
        $data['text_edit']             = $this->language->get('text_edit');
        $data['text_enabled']          = $this->language->get('text_enabled');
        $data['text_disabled']         = $this->language->get('text_disabled');
        $data['text_enabled_required'] = $this->language->get('text_enabled_required');
        $data['text_select_all']       = $this->language->get('text_select_all');
        $data['text_unselect_all']     = $this->language->get('text_unselect_all');
        
        $data['tab_setting'] = $this->language->get('tab_setting');
        $data['tab_list']    = $this->language->get('tab_list');
        $data['tab_display'] = $this->language->get('tab_display');
        
        $data['entry_status']                        = $this->language->get('entry_status');
        $data['entry_notify_status']                 = $this->language->get('entry_notify_status');
        $data['entry_notify_email']                  = $this->language->get('entry_notify_email');
        $data['entry_first_name']                    = $this->language->get('entry_first_name');
        $data['entry_last_name']                     = $this->language->get('entry_last_name');
        $data['entry_email']                         = $this->language->get('entry_email');
        $data['entry_telephone']                     = $this->language->get('entry_telephone');
        $data['entry_comment']                       = $this->language->get('entry_comment');
        $data['entry_time']                          = $this->language->get('entry_time');
        $data['entry_color_send_button']             = $this->language->get('entry_color_send_button');
        $data['entry_color_close_button']            = $this->language->get('entry_color_close_button');
        $data['entry_background_send_button']        = $this->language->get('entry_background_send_button');
        $data['entry_background_close_button']       = $this->language->get('entry_background_close_button');
        $data['entry_background_send_button_hover']  = $this->language->get('entry_background_send_button_hover');
        $data['entry_background_close_button_hover'] = $this->language->get('entry_background_close_button_hover');
        $data['entry_border_send_button']            = $this->language->get('entry_border_send_button');
        $data['entry_border_close_button']           = $this->language->get('entry_border_close_button');
        $data['entry_border_send_button_hover']      = $this->language->get('entry_border_send_button_hover');
        $data['entry_border_close_button_hover']     = $this->language->get('entry_border_close_button_hover');
        $data['entry_mask']                          = $this->language->get('entry_mask');
        $data['entry_mask_info']                     = $this->language->get('entry_mask_info');
        $data['entry_agree_status']                  = $this->language->get('entry_agree_status');
		
        $data['help_email']                     = $this->language->get('help_email');
        
        $data['button_save']   = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');
        
        $data['user_token'] = $this->session->data['user_token'];
        
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        if (isset($this->error['notify_email'])) {
            $data['error_notify_email'] = $this->error['notify_email'];
        } else {
            $data['error_notify_email'] = '';
        }
        
        $data['breadcrumbs'] = array();
        
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
        );
        
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_module'),
            'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
        );
        
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/module/popup_order', 'user_token=' . $this->session->data['user_token'], true)
        );
        
        $data['action'] = $this->url->link('extension/module/popup_order', 'user_token=' . $this->session->data['user_token'], true);
        
        $data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);
        
        if (isset($this->request->post['popup_order_data'])) {
            $data['popup_order_data'] = $this->request->post['popup_order_data'];
        } else {
            $data['popup_order_data'] = $this->config->get('popup_order_data');
        }
        
        $data['header']      = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer']      = $this->load->controller('common/footer');
        
        $this->response->setOutput($this->load->view('extension/module/popup_order', $data));
    }
    
    public function history() {
        $data = array();
        $this->load->model('extension/module/popup_order');
        $this->language->load('extension/module/popup_order');
        
        $data['text_no_results'] = $this->language->get('text_no_results');
        
        $data['button_delete_menu']     = $this->language->get('button_delete_menu');
        $data['button_delete_selected'] = $this->language->get('button_delete_selected');
        $data['button_delete_all']      = $this->language->get('button_delete_all');
        $data['button_delete']          = $this->language->get('button_delete');
        
        $data['column_action']     = $this->language->get('column_action');
        $data['column_info']       = $this->language->get('column_info');
        $data['column_date_added'] = $this->language->get('column_date_added');
        
        $page          = (isset($this->request->get['page'])) ? $this->request->get['page'] : 1;
        $data['user_token'] = $this->session->data['user_token'];
        
        $data['histories'] = array();
        
        $filter_data = array(
            'start' => ($page - 1) * 20,
            'limit' => 20,
            'sort' => 'r.date_added',
            'order' => 'DESC'
        );
        
        $results = $this->model_extension_module_popup_order->getCallArray($filter_data);
        
        foreach ($results as $result) {
            $info = array();
            
            $fields = unserialize($result['info']);
            
            foreach ($fields as $field) {
                $info[] = array(
                    'name' => $field['name'],
                    'value' => isset($field['value']) ? $field['value'] : ''
                );
            }
            
            $data['histories'][] = array(
                'request_id' => $result['request_id'],
                'info' => $info,
                'date_added' => $result['date_added']
            );
        }
        
        $history_total = $this->model_extension_module_popup_order->getTotalCallArray();
        
        $pagination        = new Pagination();
        $pagination->total = $history_total;
        $pagination->page  = $page;
        $pagination->limit = 20;
        $pagination->url   = $this->url->link('extension/module/popup_order/history', 'user_token=' . $this->session->data['user_token'] . '&page={page}', true);
        
        $data['pagination'] = $pagination->render();
        
        $data['results'] = sprintf($this->language->get('text_pagination'), ($history_total) ? (($page - 1) * 20) + 1 : 0, ((($page - 1) * 20) > ($history_total - 20)) ? $history_total : ((($page - 1) * 20) + 20), $history_total, ceil($history_total / 20));
        
        $this->response->setOutput($this->load->view('extension/module/popup_order_history', $data));
    }
    
    public function delete_selected() {
        $json = array();
        $this->load->model('extension/module/popup_order');
        
        $info = $this->model_extension_module_popup_order->getCall((int) $this->request->get['delete']);
        
        if ($info) {
            $this->model_extension_module_popup_order->deleteCall((int) $this->request->get['delete']);
        }
        
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
    
    public function delete_all() {
        $json = array();
        $this->load->model('extension/module/popup_order');
        
        $this->model_extension_module_popup_order->deleteAllCallArray();
        
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
    
    public function delete_all_selected() {
        $json = array();
        $this->load->model('extension/module/popup_order');
        
        if (isset($this->request->request['selected'])) {
            foreach ($this->request->request['selected'] as $request_id) {
                $info = $this->model_extension_module_popup_order->getCall((int) $request_id);
                
                if ($info) {
                    $this->model_extension_module_popup_order->deleteCall((int) $request_id);
                }
            }
        }
        
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
    
    public function install() {
        $this->load->language('extension/module/popup_order');
        $this->load->model('extension/module/popup_order');
        $this->load->model('setting/extension');
        $this->load->model('setting/setting');
        $this->load->model('user/user_group');
        
        $this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/module/popup_order');
        $this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/module/popup_order');
        
        $this->model_extension_module_popup_order->makeDB();
        
        $this->model_setting_setting->editSetting('popup_order', array(
            'popup_order_data' => array(
                'status' => '1',
                'notify_status' => '1',
                'notify_email' => $this->config->get('config_email'),
                'first_name' => '2',
                'last_name' => '2',
                'email' => '2',
                'telephone' => '2',
                'comment' => '2',
                'time' => '2',
                'agree' => '0',
                'color_send_button' => '',
                'color_close_button' => '',
                'background_send_button' => '',
                'background_close_button' => '',
                'background_send_button_hover' => '',
                'background_close_button_hover' => '',
                'border_send_button' => '',
                'border_close_button' => '',
                'border_send_button_hover' => '',
                'border_close_button_hover' => '',
                'mask' => '(999) 999-99-99'
            )
        ));
        
        if (!in_array('popup_order', $this->model_setting_extension->getInstalled('module'))) {
            $this->model_setting_extension->install('module', $this->request->get['extension']);
        }
        
        $this->session->data['success'] = $this->language->get('text_success_install');
    }
    
    public function uninstall() {
        $this->load->model('setting/extension');
        $this->load->model('setting/setting');
        $this->load->model('extension/module/popup_order');
        
        $this->model_extension_module_popup_order->deleteDB();
        $this->model_setting_extension->uninstall('module', $this->request->get['extension']);
        $this->model_setting_setting->deleteSetting('popup_order_data');
    }
    
    protected function validate() {
        if (!$this->user->hasPermission('modify', 'extension/module/popup_order')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        
        foreach ($this->request->post['popup_order_data'] as $key => $field) {
            if (empty($field) && $key == "notify_email") {
                $this->error['notify_email'] = $this->language->get('error_notify_email');
            }
        }
        
        return !$this->error;
    }
}