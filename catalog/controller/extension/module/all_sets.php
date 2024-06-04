<?php

require_once DIR_SYSTEM . 'library/kjhelper.php';

class ControllerExtensionModuleAllSets extends Controller
{
    public function index()
    {       
        $this->load->controller('extension/module/sets/load_css_js');
        $this->load->controller('extension/module/sets/load_model_and_lang');

        if (!empty($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        $allset['breadcrumbs'] = array();

        $allset['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home'),
        );

        $allset['breadcrumbs'][] = array(
            'text' => $this->language->get('text_sets'),
            'href' => $this->url->link('extension/module/all_sets'),
        );

        if (!empty($this->request->get['limit'])) {
            $limit = (int) $this->request->get['limit'];
        } else {
            $limit = 10;
        }

        if ($this->customer->isLogged())
            $customer_group_id = $this->customer->getGroupId();
        else 
            $customer_group_id = $this->config->get('config_customer_group_id');

        $start = ($page - 1) * $limit;

        $data['text_sets']     = $this->language->get('text_sets');
        $data['text_buy_sets'] = $this->language->get('text_buy_sets');
        $data['text_economy']  = $this->language->get('text_economy');

        $result = $this->model_extension_module_sets->getAllSets($start, $limit);
        $query_total = $this->model_extension_module_sets->getAllSetsTotal();
        $data['sets'] = $this->load->controller('extension/module/sets/prepareSets', $result);

        $pagination        = new Pagination();
        $pagination->total = $query_total;
        $pagination->page  = $page;
        $pagination->limit = $limit;
        $pagination->url   = $this->url->link('extension/module/all_sets', 'page={page}');

        $allset['pagination'] = $pagination->render();

        $fields = [
            'sets_show_qty',
            'sets_show_disc_prec',
            //'sets_selector',
            //'sets_position',
            'sets_orientation',
            'sets_custom_css',
            //'sets_slider',
            'sets_js_cart_add',
            'sets_product_link_newtab'
        ];

        foreach($fields as $field)
        {
            $data[$field]       = $this->config->get(kjhelper::$key_prefix . $field);
        }

        $data['sets_slider'] = 'none';
        $data['sets_js_cart_add'] = html_entity_decode($data['sets_js_cart_add']);
        $data['decimal_place']    = $this->currency->getDecimalPlace($this->session->data['currency']);

        $allset['column_left']    = $this->load->controller('common/column_left');
        $allset['column_right']   = $this->load->controller('common/column_right');
        $allset['content_top']    = $this->load->controller('common/content_top');
        $allset['content_bottom'] = $this->load->controller('common/content_bottom');
        $allset['footer']         = $this->load->controller('common/footer');
        $allset['header']         = $this->load->controller('common/header');
        $allset['decimal_place']  = $this->currency->getDecimalPlace($this->session->data['currency']);
        $allset['html'] = $this->load->view('extension/module/sets/sets', $data);
        $this->response->setOutput($this->load->view('extension/module/sets/all_sets', $allset));
    }
}