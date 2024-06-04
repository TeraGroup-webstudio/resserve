<?php

require_once DIR_SYSTEM . 'library/kjhelper.php';
 
class ControllerExtensionModuleSetsManage extends Controller
{
 
    private $error = array();

    public function index()
    {
        $newline_symbols = array("\r", "\n");

        $this->load->language('extension/module/sets_manage');
        $this->load->model('catalog/category');
        $this->load->model('catalog/product');
        $this->load->model('catalog/manufacturer');
        $this->load->model('tool/image');
        $this->load->model('extension/module/sets');
        $this->load->model('customer/customer_group');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');
        $data['user_token'] = $this->session->data[kjhelper::$user_token];

        $data['heading_title'] = $this->language->get('heading_title');
        $data['entry_products_qty'] = $this->language->get('entry_products_qty');
        
        
        $data['text_info']     = $this->language->get('text_info');
        $data['text_before']   = $this->language->get('text_before');
        $data['text_after']    = $this->language->get('text_after');
        $data['text_edit']     = $this->language->get('text_edit');
        $data['text_enabled']  = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');

        $data['entry_category'] = $this->language->get('entry_category');
        $data['entry_model'] = $this->language->get('entry_model');
        $data['entry_product_name'] = $this->language->get('entry_product_name');

        $data['entry_products'] = $this->language->get('entry_products');

        $data['entry_name']           = $this->language->get('entry_name');
        $data['entry_customer_group'] = $this->language->get('entry_customer_group');
        $data['entry_discount']       = $this->language->get('entry_discount');
        $data['entry_required']       = $this->language->get('entry_required');
        $data['entry_qunatity']       = $this->language->get('entry_qunatity');
        $data['entry_sort']           = $this->language->get('entry_sort');
        $data['entry_status']         = $this->language->get('entry_status');

        $data['entry_option'] = $this->language->get('entry_option');
        $data['entry_delete'] = $this->language->get('entry_delete');

        $data['entry_category']     = $this->language->get('entry_category');
        $data['entry_tag']          = $this->language->get('entry_tag');
        $data['entry_manufacturer'] = $this->language->get('entry_manufacturer');
        $data['entry_description']  = $this->language->get('entry_description');

        $data['entry_manuf_conformity'] = $this->language->get('entry_manuf_conformity');
        $data['entry_attribute'] = $this->language->get('entry_attribute');
        $data['entry_absolute_limit'] = $this->language->get('entry_absolute_limit');

        $data['btn_add_set'] = $this->language->get('btn_add_set');
        $data['btn_del_set'] = $this->language->get('btn_del_set');

        $data['btn_show_count_products'] = $this->language->get('btn_show_count_products');

        $data['tab_sets_generate']   = $this->language->get('tab_sets_generate');
        $data['tab_sets_generate2']   = $this->language->get('tab_sets_generate2');

        $data['tab_all_sets']        = $this->language->get('tab_all_sets');
        $data['column_set_name']     = $this->language->get('column_set_name');
        $data['column_set_products'] = $this->language->get('column_set_products');
        $data['column_set_sort']     = $this->language->get('column_set_sort');
        $data['column_set_parent']   = $this->language->get('column_set_parent');
        $data['column_set_status']   = $this->language->get('column_set_status');
        $data['button_save']         = $this->language->get('button_save');
        $data['button_cancel']       = $this->language->get('button_cancel');

        $data['block_search']       = $this->language->get('block_search');
        $data['block_products']     = $this->language->get('block_products');
        $data['block_main_setting'] = $this->language->get('block_main_setting');

        $this->load->model('localisation/language');

        $data['languages'] = $this->model_localisation_language->getLanguages();

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', kjhelper::$user_token . '=' . $this->session->data[kjhelper::$user_token], true),
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_module'),
            'href' => $this->url->link(kjhelper::$marketplace_link, 'type=module&' . kjhelper::$user_token . '=' . $this->session->data[kjhelper::$user_token], true),
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/module/sets', kjhelper::$user_token . '=' . $this->session->data[kjhelper::$user_token], true),
        );

        $data['action']  = $this->url->link('extension/module/sets', kjhelper::$user_token . '=' . $this->session->data[kjhelper::$user_token], true);
        $data['action2'] = $this->url->link('extension/module/sets/removeSets', kjhelper::$user_token . '=' . $this->session->data[kjhelper::$user_token], true);

        $data['cancel'] = $this->url->link(kjhelper::$marketplace_link, 'type=module&' . kjhelper::$user_token . '=' . $this->session->data[kjhelper::$user_token], true);

        $data['cats'] = $this->model_catalog_category->getCategories();

        $sbn = array();
        foreach ($data['cats'] as $key => $row)
        {
            $sbn[$key] = $row['name'];
        }
        array_multisort($sbn, SORT_DESC, $data['cats']);

        $data['manufs'] = $this->model_catalog_manufacturer->getManufacturers();

        $this->load->model('catalog/attribute');
        $data['attrs'] = $this->model_catalog_attribute->getAttributes();

        $names = array();
        foreach ($data['attrs'] as $key => $row)
        {
            $names[$key] = $row['name'];
        }
        array_multisort($names, SORT_ASC, $data['attrs']);
        
        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        if (isset($this->request->get['tab'])) {
            $tab = $this->request->get['tab'];
        } else {
            $tab = 'sets_generate';
        }

        $limit = 50;

        $start = ($page - 1) * $limit;

        $data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();

        $lang_id = (int) $this->config->get('config_language_id');

        $sets = $this->model_extension_module_sets->getAllSets($start, $limit);

        $total = $this->model_extension_module_sets->getTotalSets();

        $pagination        = new Pagination();
        $pagination->total = $total;
        $pagination->page  = $page;
        $pagination->limit = $limit;
        $pagination->url   = $this->url->link('extension/module/sets_manage&tab=all_sets&' . kjhelper::$user_token . '=' . $this->session->data[kjhelper::$user_token], 'page={page}');

        $data['tab']        =
        $data['pagination'] = $pagination->render();

        $product_ids = array();


        if ($sets) {
            $sets_html = '';

            foreach ($sets as $key => &$set) {
                $name = json_decode($set['name'], true);

                $set['name'] = '';
                if (isset($name[$lang_id])) {
                    $set['name'] = $name[$lang_id];
                }

                $prinfo = $this->model_catalog_product->getProduct($set['product_id']);
                if (!empty($prinfo)) {
                    $set['parent'] = $prinfo;
                } else {
                    $set['parent'] = array('name' => '');
                }

                foreach ($set['products'] as $pri => &$pr) {
                   
                    $prinfo = $this->model_catalog_product->getProduct($pr['product_id']);

                    if (!empty($prinfo)) {
                        $pr['product_name'] = $prinfo['name'];
                        $pr['image']        = $image        = $this->model_tool_image->resize($prinfo['image'], 50, 50);
                    } else {

                        $pr['product_name'] = '';
                        $pr['image']        = '';
                    }

                }
                $set['key'] = $key;
            }
        }

        $data['sets'] = $sets;
        $data['tab']  = $tab;

        $data['row'] = str_replace($newline_symbols, "", $this->load->view('extension/module/sets/sets_manage_row'));

        $data['header']      = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer']      = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/module/sets/sets_manage', $data));

    }
    public function removeSets()
    {
        $this->load->language('extension/module/sets_manage');
        $json = array();

        if(!$this->validate())
        {
            $json['error'] = $this->language->get('error_permission');
            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($json));
            return;
        }

        if (!(isset($this->request->post['sets']) && $this->request->post['sets'])) 
        {
            $json['error'] = $this->language->get('error_empty_sets');
        } 
        else 
        {
            $this->load->model('extension/module/sets');
           
            $this->model_extension_module_sets->removeSets($this->request->post['sets']);
            $json['success'] = $this->language->get('entry_success');
        }
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));

    }

    public function add()
    {
        $json = array();
        $this->load->language('extension/module/sets_manage');


        if(!$this->validate())
        {
            $json['error'] = $this->language->get('error_permission');
            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($json));
            return;
        }

        $this->load->model('catalog/product');

        $this->load->model('extension/module/sets');
        $this->load->model('localisation/language');

        if (isset($this->request->post['products']) && count($this->request->post['products'])) 
        {
            $cat         = $this->request->post['cat'];
            $manuf       = $this->request->post['manuf'];
            $name        = $this->request->post['name'];
            $model        = $this->request->post['model'];
            $tag         = $this->request->post['tag'];
            $descr       = $this->request->post['descr'];
            $quantity    = $this->request->post['quantity'];
            $discount    = $this->request->post['discount'];


            $setname           = $this->request->post['setname'];
            $customer_group_id = $this->request->post['customer_group_id'];
            $status            = isset($this->request->post['status']) ? 1 : 0;
            $sort              = (int) $this->request->post['sort'];

            $filter_data = array(
                'filter_name'            => $name,
                'filter_model'           => $model,
                'filter_tag'             => $tag,
                'filter_description'     => $descr,
                'filter_category_id'     => $cat,
                'filter_manufacturer_id' => $manuf,

            );
            $products = $this->model_extension_module_sets->getProducts($filter_data);
            $ids = $this->model_extension_module_sets->getIdsHaveSets();
            $x = 0;

            foreach ($products as $product) {

                $current_prd               = array();
                $current_prd["product_id"] = $product['product_id'];
                $current_prd["quantity"]   = $quantity;
                $current_prd["discount"]   = $discount;

                $set['products'] = $this->request->post['products'];
                
                foreach ($set['products'] as $k => $v) {
                    $set['products'][$k]['discount'] = $set['products'][$k]['discount'];
                }
               
                array_unshift($set['products'], $current_prd);
                $set['name']              = $setname;
                $set['customer_group_id'] = $customer_group_id;
                $set['status']            = $status;
                $set['sort']              = $sort;
                $x++;

                $this->model_extension_module_sets->saveSets($product['product_id'], $set);
            }


            $json['success'] = sprintf($this->language->get('entry_ajax_generate_sets_success'), $x);
        } 
        else 
        {
            $json['error'] = $this->language->get('error_empty_products');
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function check()
    {
        $json = array();
        $this->load->language('extension/module/sets_manage');

        if(!$this->validate())
        {
            $json['error'] = $this->language->get('error_permission');
            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($json));
            return;
        }

        $this->load->model('catalog/product');

        $this->load->model('extension/module/sets');
        $this->load->model('localisation/language');

        $langs = $this->model_localisation_language->getLanguages();
        $names = array();
        foreach ($langs as $l) {
            $names[$l['language_id']] = '';
        }

        $cat   = $this->request->post['cat'];
        $model   = $this->request->post['model'];
        $manuf = $this->request->post['manuf'];
        $name  = $this->request->post['name'];
        $tag   = $this->request->post['tag'];
        $descr = $this->request->post['descr'];

        $filter_data = array(
            'filter_name'            => $name,
            'filter_model'           => $model,
            'filter_tag'             => $tag,
            'filter_description'     => $descr,
            'filter_category_id'     => $cat,
            'filter_manufacturer_id' => $manuf,

        );
        $json['fd']= $filter_data;
        $products = $this->model_extension_module_sets->getProducts($filter_data);

        $json['success'] = count($products) . $this->language->get('check_products');
        $json['success'] .= "<table class='table table-bordered'><tbody>";
        $this->load->model('tool/image');

        $l = 100;
        if ($products && count($products) > $l) 
        {
            array_splice($products, $l);
        }

        foreach ($products as $product) 
        {
            $json['success'] .= "<tr>";
            $json['success'] .= "<td>";
            if ($product['image']) {
                $json['success'] .= "<img src='" . $this->model_tool_image->resize($product['image'], 50, 50) . "'' class='pull-left img-responsive'>";
            }
            $json['success'] .= "</td>";
            $json['success'] .= "<td>" . $product['name'] . "</td>";
            $json['success'] .= "</tr>";
        }
        $json['success'] .= "</tbody></table>";

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function clear()
    {
        $json = array();
        $this->load->language('extension/module/sets_manage');

        if(!$this->validate())
        {
            $json['error'] = $this->language->get('error_permission');
            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($json));
            return;
        }

        $this->load->model('catalog/product');
        $this->load->model('extension/module/sets');

        $cat   = $this->request->post['cat'];
        $manuf = $this->request->post['manuf'];
        $name  = $this->request->post['name'];
        $tag   = $this->request->post['tag'];
        $descr = $this->request->post['descr'];
        $model = $this->request->post['model'];

        $filter_data = array(
            'filter_name'            => $name,
            'filter_model'           => $model,
            'filter_tag'             => $tag,
            'filter_description'     => $descr,
            'filter_category_id'     => $cat,
            'filter_manufacturer_id' => $manuf,

        );
        
        if(empty($cat) && empty($cat) && empty($cat) && empty($cat) && empty($cat))
        {
            $this->model_extension_module_sets->clearSets();
        }
        else
        {
            $products = $this->model_extension_module_sets->getProducts($filter_data);

            foreach ($products as $product) {
                $this->model_extension_module_sets->clearSets($product['product_id']);
            }
        }


        $json['success'] = $this->language->get('entry_success');

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function add2()
    {
        $json = array();
        $this->load->language('extension/module/sets_manage');

        if(!$this->validate())
        {
            $json['error'] = $this->language->get('error_permission');
            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($json));
            return;
        }
        
        $this->load->model('catalog/product');

        $this->load->model('extension/module/sets');
        $this->load->model('localisation/language');

        $cat         = $this->request->post['cat'];
        $manuf       = $this->request->post['manuf'];
        $name        = $this->request->post['name'];
        $tag         = $this->request->post['tag'];
        $descr       = $this->request->post['descr'];
        //$qty         = $this->request->post['products_qty'];
        $quantity    = $this->request->post['quantity'];
        $start       = $this->request->post['start'];
        $limit       = $this->request->post['limit'];
        $discount    = $this->request->post['discount'];
        $model       = $this->request->post['model'];

        $setname           = $this->request->post['setname'];
        $customer_group_id = $this->request->post['customer_group_id'];
        $status            = isset($this->request->post['status']) ? 1 : 0;
        $sort              = (int) $this->request->post['sort'];

        $manuf_conformity            = isset($this->request->post['manuf_conformity']) ? 1 : 0;
        $attr            = isset($this->request->post['attr']) ? (int)$this->request->post['attr'] : 0;
        $abs_limit            = isset($this->request->post['abs_limit']) ? (int)$this->request->post['abs_limit'] : 10000;


        $c = count($cat);
        if ($c < 2 || $c > 3) 
        {
            $json['error'] = "Только 2 или 3 блока. Иначе базу данных может раздуть до космических размеров";
            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($json));
            return;
        }

        $products      = array();
        $products_keys = array();
        $ids = $this->model_extension_module_sets->getIdsHaveSets();
        $x = 0;

        for ($i = 0; $i < $c; $i++) {
            $filter_data = array(
                'filter_name'            => $name[$i],
                'filter_model'           => $model[$i],
                'filter_tag'             => $tag[$i],
                'filter_description'     => $descr[$i],
                'filter_category_id'     => $cat[$i],
                'filter_manufacturer_id' => $manuf[$i],
                'start'                  => $start[$i],
                'limit'                  => $limit[$i]
            );

            $ps = $this->model_extension_module_sets->getProducts($filter_data);

            if(!$ps)
                continue;

            $keys = array_keys($ps);
            $products_keys[] = $keys;
            $products = array_merge($products, $ps);

        }

        if(count($products_keys) > 1)
        {
            $res = [];
             
            if(count($products_keys) == 2)
                foreach($products_keys[0] as $pid1)
                    foreach($products_keys[1] as $pid2)
                        if($pid1 != $pid2)
                            $res[] = [$pid1, $pid2];
                    

            if(count($products_keys) == 3)
                foreach($products_keys[0] as $pid1)
                    foreach($products_keys[1] as $pid2)
                        foreach($products_keys[2] as $pid3)
                            if($pid1 != $pid2 && $pid1 != $pid3 && $pid2 != $pid3)
                                $res[] = [$pid1, $pid2, $pid3];

                      
            $json['res'] = $res;

            foreach ($res as $key => $myproducts)
            {
                $ids = array();
                foreach ($myproducts as $pid) 
                    $ids[] = $pid;

                if($manuf_conformity && !$this->model_extension_module_sets->boolOneManuf($ids))
                {
                    unset($res[$key]);
                    continue;
                }

                if($attr && !$this->model_extension_module_sets->boolOneAttr($ids, $attr))
                {
                    unset($res[$key]);
                    continue;
                }
            }   
        
            if($abs_limit && count($res) > $abs_limit)
                $res = array_slice($res, 0, $abs_limit);

            $sets = array();

            foreach ($res as $myproducts) 
            {

                $pid             = $myproducts[0];
                $set             = array();
                $set['products'] = array();

                foreach ($myproducts as $key => $pid) 
                {
                    $key                       = $key;
                    $current_prd               = array();
                    $current_prd["product_id"] = $pid;
                    $current_prd["quantity"]   = $quantity[$key];
                    $current_prd["discount"]   = $discount[$key];
                    $set['products'][]          = $current_prd;
                }

                $set['name']              = $setname;
                $set['customer_group_id'] = $customer_group_id;
                $set['status']            = $status;
                $set['sort']              = $sort;
                $x++;

                $this->model_extension_module_sets->saveSets($pid, $set);
            }
        }

        $json['success'] = sprintf($this->language->get('entry_ajax_generate_sets_success'), $x);

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function validate()
    {
        if (!$this->user->hasPermission('modify', 'extension/module/sets_manage')) 
        {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }

}