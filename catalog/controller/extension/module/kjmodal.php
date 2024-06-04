<?php
class ControllerExtensionModuleKjmodal extends Controller   
{
    public $ptm = 'extension/module/kjmodal';
    
    public function echo_decimal_place()
    {
        echo $this->currency->getDecimalPlace($this->session->data['currency']);
    }


    public function getModal()
    {
        if (empty($this->request->get['pid'])) 
            return;


        $id = (int) $this->request->get['pid'];
        $this->load->model('catalog/product');
        $this->load->language('product/product');
        $this->load->model('extension/module/kjmodal');
        $this->load->model('tool/image');

        $p = $this->model_catalog_product->getProduct($id);

        $data = [];
        $data['options'] = $this->getProductOptions($id, $p);

        $data['text_select'] = $this->language->get('text_select');
        $data['text_discount'] = $this->language->get('text_discount');
        $data['text_stock'] = $this->language->get('text_stock');
        $data['id'] = $id;

        $data['price'] =  $this->currency->format($this->tax->calculate($p['price'], $p['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);

        $data['cprice'] =  $this->currency->format($this->tax->calculate($p['price'], $p['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency'], '', false);
        $data['echodiscounts'] = [];
        $data['discounts_json'] = false;
        
        $data['quantity'] = $p['quantity'];

        if ($p['quantity'] <= 0) {
            $data['stock'] = $p['stock_status'];
        } elseif ($this->config->get('config_stock_display')) {
            $data['stock'] = $p['quantity'];
        } else {
            $data['stock'] = $this->language->get('text_instock');
        }

        if ($p['minimum']) {
            $minimum = (int) $p['minimum'];
        } else {
            $minimum = 1;
        }

        $data['qty'] = $minimum;

        $data['price'] = $this->currency->format($this->tax->calculate($minimum * $p['price'], $p['tax_class_id'], $this->config->get('config_tax') ? 'P' : false), $this->session->data['currency']);

        if((float)$p['special'])
        {
            $data['special'] = $this->currency->format($this->tax->calculate($minimum * $p['special'], $p['tax_class_id'], $this->config->get('config_tax') ? 'P' : false), $this->session->data['currency']);
        }
        else
        {
            $dprice = $this->model_extension_module_kjmodal->get_disc_price($id, $data['qty']);
            if($dprice)
            {
                $data['special'] = $this->currency->format($this->tax->calculate($minimum * $dprice, $p['tax_class_id'], $this->config->get('config_tax') ? 'P' : false), $this->session->data['currency']);
            }
        }

        
        $data['name'] = $p['name'];
        $data['product_thumb'] = $this->model_tool_image->resize($p['image'], 300, 300);
        //$data['config_theme'] = $this->config->get('config_theme');
        $data['config_theme'] = 'default/template/extension/module/kjmodal/';
        
        echo $this->load->view($this->ptm . "/kjseries_popup_options", $data);
    }

    public function getProductOptions($id, $p)
    {
        $this->load->model('catalog/product');
        $this->load->model('tool/image');

        $my_pr_options = [];

        foreach ($this->model_catalog_product->getProductOptions($id) as $option)
        {
            $product_option_value_data = [];

            foreach ($option['product_option_value'] as $option_value)
            {
                if (!$option_value['subtract'] || ($option_value['quantity'] > 0))
                {
                    if ((($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) && (float)$option_value['price'])
                    {   

                        $price = $this->currency->format($this->tax->calculate($option_value['price'], $p['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                        $cprice = $this->currency->format($this->tax->calculate($option_value['price'], $p['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency'], '', false);
                    }
                    else
                    {
                        $price = false;
                        $cprice = 0;
                    }

                    $product_option_value_data[$option_value['product_option_value_id']] = [
                        'product_option_value_id' => $option_value['product_option_value_id'],
                        'option_value_id' => $option_value['option_value_id'],
                        'name' => $option_value['name'],
                        'image' => $this->model_tool_image->resize($option_value['image'], 50, 50) ,
                        'price' => $price,
                        'cprice' => $cprice,
                        'price_prefix' => $option_value['price_prefix'],
                    ];
                }
            }

            $my_pr_options[$option['product_option_id']] = [
                'product_option_value' => $product_option_value_data,
                'option_id' => $option['option_id'],
                'product_option_id' => $option['product_option_id'],
                'name' => $option['name'],
                'type' => $option['type'],
                'value' => $option['value'],
                'required' => $option['required'],
            ];
        }

        return $my_pr_options;
    }

    public function checkProductOption()
    {

        if (empty($this->request->post['product_id']))
        {
            return;
        }

        $this->load->model('catalog/product');
        $this->load->language('checkout/cart');

        $product_id = (int)$this->request->post['product_id'];
        $option = [];

        if (!empty($this->request->post['option'])) $option = array_filter($this->request->post['option']);

        $json = [];

        $product_info = $this->model_catalog_product->getProduct($product_id);

        if ($product_info)
        {

            $product_options = $this->model_catalog_product->getProductOptions($product_id);

            if ($product_options)
            {

                foreach ($product_options as $product_option)
                {
                    if ($product_option['required'] && empty($option[$product_option['product_option_id']]))
                    {
                        $json['error']['option'][$product_option['product_option_id']] = sprintf($this->language->get('error_required') , $product_option['name']);
                    }
                }

                if (!empty($this->request->post['recurring_id']))
                {
                    $recurring_id = $this->request->post['recurring_id'];
                }
                else
                {
                    $recurring_id = 0;
                }

                $recurrings = $this->model_catalog_product->getProfiles($product_info['product_id']);

                if ($recurrings)
                {
                    $recurring_ids = [];

                    foreach ($recurrings as $recurring)
                    {
                        $recurring_ids[] = $recurring['recurring_id'];
                    }

                    if (!in_array($recurring_id, $recurring_ids))
                    {
                        $json['error']['recurring'] = $this->language->get('error_recurring_required');
                    }
                }
            }
            if (!$json)
            {
                $json['success'] = true;
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function get_price()
    {
        $json = [];
        $this->load->model('extension/module/kjmodal');

        $product_id = $this->request->post['product_id'];
        $quantity = $this->request->post['quantity'];
        $option_price = 0;
        $old_price = false;

        if(!empty($this->request->post['option']))
        {
            $option = $this->request->post['option'];
        }
        else
        {
            $option = [];
        }

        $pinfo = $this->model_extension_module_kjmodal->get_product_query($product_id);

        if ($pinfo) 
        {
            $option_price = $this->model_extension_module_kjmodal->get_option_price($product_id, $option);

            $price = $pinfo['price'];

            $special = $this->model_extension_module_kjmodal->get_special_price($product_id);

            if ($special) 
            {
                $old_price = $price;
                $price = $special;
            }
            else
            {
                $dprice = $this->model_extension_module_kjmodal->get_disc_price($product_id, $quantity);                
                if ($dprice) 
                {
                    $old_price = $price;
                    $price = $dprice;
                }
            }

            if($old_price)
            {
                $old_price = $old_price + $option_price;
                $old_total = $old_price * $quantity;

                $old_price_tax = $this->tax->calculate($old_price, $pinfo['tax_class_id'], $this->config->get('config_tax'));
                $old_total_tax = $this->tax->calculate($old_total, $pinfo['tax_class_id'], $this->config->get('config_tax'));

                $json['no_format']['old_price'] = $this->currency->format($old_price_tax, $this->session->data['currency'], '', false);
                $json['format']['old_price'] = $this->currency->format($old_price_tax, $this->session->data['currency']);

                $json['no_format']['old_total'] = $this->currency->format($old_total_tax, $this->session->data['currency'], '', false);
                $json['format']['old_total'] = $this->currency->format($old_total_tax, $this->session->data['currency']);
            }

            $option_price = $option_price;
            $price = $price + $option_price;
            $total = $price * $quantity;

            $price_tax = $this->tax->calculate($price, $pinfo['tax_class_id'], $this->config->get('config_tax'));
            $total_tax = $this->tax->calculate($total, $pinfo['tax_class_id'], $this->config->get('config_tax'));

            $json['no_format']['price'] = $this->currency->format($price_tax, $this->session->data['currency'], '', false);
            $json['format']['price'] = $this->currency->format($price_tax, $this->session->data['currency']);

            $json['no_format']['total'] = $this->currency->format($total_tax, $this->session->data['currency'], '', false);
            $json['format']['total'] = $this->currency->format($total_tax, $this->session->data['currency']);
        }


        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
}