<?php

require_once DIR_SYSTEM . 'library/kjhelper.php';

class ControllerExtensionModuleSets extends Controller
{

    public $products;
    public $options;

    public function setProductsAndOptions($product_ids)
    {
        $this->load->model('catalog/product');
        array_unique($product_ids);

        foreach($product_ids as $pid)
        {
            if(empty($this->products[$pid]))
            {
                $this->products[$pid] = $this->model_catalog_product->getProduct($pid);
            }
        }
        //$this->options  = $this->model_extension_module_kjseries_adapt->getProductOptions($product_ids);

    }

    public function loadMedia()
    {
        if (!$this->config->get(kjhelper::$key_prefix . 'sets_include_media')) {
            return;
        }

        $media = explode("\r\n", $this->config->get(kjhelper::$key_prefix . 'sets_include_media'));

        if ($media) {
            foreach ($media as $m) {
                if (strstr($m, '.css') !== false) {
                    $this->document->addStyle($m);
                } else if (strstr($m, '.js') !== false) {
                    $this->document->addScript($m);
                }

            }
        }
    }

    public function prepareSets(array $sets)
    {
        $disc_type = $this->model_extension_module_sets->one_disc_prod();
        $dont_show_if_empty = !$this->config->get(kjhelper::$key_prefix . 'sets_show_if_empty');

        $product_ids = array();
        $results = [];
        if ($sets) 
        {
            foreach ($sets as $set) 
            {
                foreach ($set['products'] as $p) 
                    $product_ids[] = $p['product_id'];
            }

            $this->setProductsAndOptions($product_ids);

            $sort = array();

            foreach ($sets as $key => $row) 
            {
                $sort[$key] = $row['sort'];
            }

            array_multisort($sort, SORT_ASC, $sets);
            $lang = (int) $this->config->get('config_language_id');

            foreach ($sets as $s_key => $set) 
            {
                $names  = json_decode($set['name'], true);
                $lang = (int) $this->config->get('config_language_id');
                $discount = 0;
                $total    = 0;
                $tempproducts = [];

                foreach ($set['products'] as $pkey => $product) 
                {
                    $id = $product['product_id'];
                    if (empty($this->products[$id]) || ($dont_show_if_empty && $this->products[$id]['quantity'] <= 0))
                    {
                        continue 2;
                    }
                }

                foreach ($set['products'] as $pkey => $product) 
                {
                    $id = $product['product_id'];
                    $product_info = $this->products[$id];
                    $img = $product_info['image'] ? $product_info['image'] : 'placeholder.png';
                    $thumb = $this->model_tool_image->resize($img, 200, 200);
                    $have_opt = $this->model_extension_module_sets->productHaveOption($id);
                    $dval = 0;
                    $discount_currency = null;
                    
                    $price       = (float) $product_info['price'];
                    $dprice = $this->model_extension_module_sets->getDiscountPrice($id, $product['quantity']);
                    if ((float) $dprice)
                    {
                        $price    = (float) $dprice;
                    }

                    $aprice = (float) $product_info['special'] ? (float) $product_info['special'] : $price;
                    $crpice = $this->currency->format($this->tax->calculate($aprice, $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency'], '', false);

                    if(!empty($product['discount'])) 
                    {
                        if (substr($product['discount'], -1) == "%") 
                        {
                            $pd = floatval(substr($product['discount'], 0, -1));
                            $dval = ($crpice / 100) * $pd;
                            $discount_currency = $product['discount'];
                        } 
                        else 
                        {
                            if($disc_type)
                            {
                                $dval = $this->currency->format($product['discount'], $this->session->data['currency'], '', false);
                            }
                            else 
                            {
                                $dval = $this->currency->format($product['discount']/$product['quantity'], $this->session->data['currency'], '', false);
                            }
                            
                            $discount_currency = $this->currency->format($dval, $this->session->data['currency'], 1);
                        }
                    }
                    
                    $discount += $dval * $product['quantity'];
                    $total += $crpice * $product['quantity'];


                    $tempproducts[] =
                    [
                        'discount_currency' => $discount_currency,
                        'discount' => substr($product['discount'], -1) == "%" ? $product['discount'] : $dval,
                        'thumb' => $thumb,
                        'product_name' => $product_info['name'],
                        'href' => $this->url->link('product/product', 'product_id=' . $id),
                        
                        'price' => $this->currency->format($this->tax->calculate($price, $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']),
                        'special' => (float) $product_info['special'] ? 
                        $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']) : false,
                        'cprice' => $crpice,
                        //'final_cprice' => $this->currency->format($crpice - $dval, $this->session->data['currency'], '', false),

                        'product_id' => $product['product_id'],
                        'quantity' => $product['quantity'],
                        'stock_quantity' => $product_info['quantity'],
                        
                        'option_type' => $have_opt ? 'modal' : 'none',
                        'html_options_button' => $have_opt ? $this->load->view('extension/module/sets/sets_popup_options_button', ['modal_id' => $id]) : null
                    ];
                }

                $total -= $discount;

                $results[] = [ 
                    'enddate' => $set['enddate'],
                    'disc_type' => $disc_type,
                    'name' => $names[$lang],
                    'ceconomy' => $discount,
                    'new_total' => $this->currency->format($total, $this->session->data['currency'], 1),
                    'economy' => $this->currency->format($discount, $this->session->data['currency'], 1),
                    'products' => $tempproducts
                ];
            }
        }

        return $results;
    }
    
    function load_css_js()
    {
        $this->document->addScript('catalog/view/javascript/kjmodal/kjmodal.js');
        $this->document->addScript('catalog/view/javascript/sets/script.js');
        $this->document->addStyle('catalog/view/javascript/sets/style.css');

        $this->loadMedia();
    }

    public function load_model_and_lang()
    {
        $this->load->language('extension/module/set');
        $this->load->model('catalog/product');
        $this->load->model('extension/module/sets');
        $this->load->model('tool/image');
    }

    public function getSets()
    {
        if (!$this->config->get(kjhelper::$key_prefix . 'sets_status')) 
            return;

        $this->load_css_js();
        $this->load_model_and_lang();
        
        $data['text_sets']     = $this->language->get('text_sets');
        $data['text_buy_sets'] = $this->language->get('text_buy_sets');
        $data['text_economy']  = $this->language->get('text_economy');

        if (!empty($this->request->get['product_id'])) 
            $product_id = $this->request->get['product_id'];
        else 
            $product_id = 0;

        $sets = $this->model_extension_module_sets->getSets($product_id, 0, 10, $this->config->get(kjhelper::$key_prefix . 'sets_links'));

        if (empty($sets))
        {
            return;
        }
        
        $fields = [
            'sets_show_qty',
            'sets_show_disc_prec',
            'sets_selector',
            'sets_position',
            'sets_orientation',
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
        
       
        $data['sets'] = $this->prepareSets($sets);
        $data['decimal_place']    = $this->currency->getDecimalPlace($this->session->data['currency']);


        $res = $this->load->view('extension/module/sets/sets', $data);

        return $res;
    }
}