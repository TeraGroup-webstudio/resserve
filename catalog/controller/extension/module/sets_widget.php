<?php

require_once DIR_SYSTEM . 'library/kjhelper.php';

class ControllerExtensionModuleSetsWidget extends Controller
{
    public function index($setting)
    {
        if (!$setting['status']) 
        {
            return;
        }

        $this->load->controller('extension/module/sets/load_css_js');
        $this->load->controller('extension/module/sets/load_model_and_lang');

        $data['text_sets']     = $this->language->get('text_sets');
        $data['text_buy_sets'] = $this->language->get('text_buy_sets');
        $data['text_economy']  = $this->language->get('text_economy');

        $all_sets = [];
        $result = [];

        if ($setting['cart']) 
        {
            foreach($this->cart->getProducts() as $product)
            {
                $sets = $this->model_extension_module_sets->getSets($product['product_id'], 0, 10, true);

                if($sets)
                {
                    foreach($sets as $set)
                        $result[$set['id']] = $set;
                }

            }

        }

        if (!empty($setting['product'])) 
        {
            foreach ($setting['product'] as $product) 
            {
                $sets = $this->model_extension_module_sets->getSets($product['id'], 0, 10, false);

                if($sets)
                {
                    foreach($sets as $set)
                        $result[$set['id']] = $set;
                }
            }
        }

        if (empty($result))
        {
            return;
        }

        $data['sets'] = $this->load->controller('extension/module/sets/prepareSets', $result);

        $fields = [
            'sets_show_qty',
            'sets_show_disc_prec',
            //'sets_selector',
            //'sets_position',
            //'sets_orientation',
            'sets_custom_css',
            'sets_slider',
            'sets_js_cart_add',
            'sets_product_link_newtab'
        ];

        foreach($fields as $field)
        {
            $data[$field]       = $this->config->get(kjhelper::$key_prefix . $field);
        }

        $data['sets_js_cart_add'] = html_entity_decode($data['sets_js_cart_add']);

        $data['decimal_place']    = $this->currency->getDecimalPlace($this->session->data['currency']);
        $data['sets_orientation'] = $setting['orientation'];

        $res = $this->load->view('extension/module/sets/sets', $data);
        return $res;
    }
}