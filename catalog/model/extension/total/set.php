<?php

class ModelExtensionTotalSet extends Model
{
    private $cps = null;
    private $cache_disc = null;
    private $max_n_discount = 10;
    public function getTotal($total)
    {

        $this->load->language('extension/total/set');

        
        if($this->cache_disc === null)
        {
            $this->cache_disc = $discount = $this->calc();
        }
        else
        {
            $discount = $this->cache_disc;
        }
        
        if (!$discount) 
        {
            return false;
        }

        $sort_order_key = floatval(VERSION) >= 3 ? 'total_set_sort_order' : 'set_sort_order';

        $total['totals'][] = array(
            'code'       => 'set',
            'title'      => sprintf($this->language->get('text_set')),
            'value'      => -$discount,
            'sort_order' => $this->config->get($sort_order_key),
        );

        $total['total'] -= $discount;

    }

    public function set_cps()
    {
        if($this->cps !== null)
        {
            return;
        }

        $this->cps = $this->get_cps();
    }

    public function get_cps()
    {
        $cps = [];

        foreach ($this->cart->getProducts() as $product)
        {
            if(!isset($cps[$product["product_id"]]))
            {
                $cps[$product["product_id"]] = [];
                $cps[$product["product_id"]]["total_qty"] = 0;
            }

            $cps[$product["product_id"]]["products"][] = $product;
            $cps[$product["product_id"]]["total_qty"] += $product["quantity"];
        }

        return $cps;
    }

    public function dump($var)
    {
        echo "<PRE>";
        var_dump($var);
        echo "</PRE>";
    }

    public function get_set_in_cart()
    {
        $this->set_cps();
        $this->load->model('extension/module/sets');
        $result = [];

        $pr_pid_qty = [];
        foreach($this->cps as $pid => $info)
        {
            $pr_pid_qty[$pid] = $info["total_qty"];
        }

        return $this->model_extension_module_sets->get_count_product_by_setid($pr_pid_qty);
    }

    public function get_disc($set_id)
    {
        //$this->set_cps();
        $disc_type = $this->model_extension_module_sets->one_disc_prod();
        $set_products_info = $this->model_extension_module_sets->get_set_products($set_id);
        $gr_products = $this->model_extension_module_sets->get_group_product($set_id);
        $total_disc = 0;
        $counts = [];
        foreach($gr_products as $product)
        {
            $counts[] = (int) ($this->cps[$product['product_id']]['total_qty'] / $product['quantity']);
        }

        $min_all_qtys = min($counts);
        if($min_all_qtys <= 0)
        {
            return 0;
        }

        foreach($set_products_info as $p)
        {
            $pid = $p['product_id'];

            $need_qty = $p['quantity'] * $min_all_qtys;

            foreach($this->cps[$pid]['products'] as $pkey => $cart_prd)
            {
                if($cart_prd['quantity'] <= 0)
                {
                    //этот товар использует другой комплект
                    continue;
                }

                if (substr($p['discount'], -1) == "%") 
                {
                    $price = $this->tax->calculate($cart_prd['price'], $cart_prd['tax_class_id'], $this->config->get('config_tax'));

                    $pd = floatval(substr($p['discount'], 0, -1));
                    $product_disc  = ($price / 100) * $pd;
                }
                else if($p['discount'] != "0")
                {
                    if($disc_type)
                    {
                        $product_disc  = floatval($p['discount']);
                    }
                    else
                    {
                        $product_disc  = floatval($p['discount']) / $p['quantity'];
                    }
                }
                else
                {
                    $product_disc = 0;
                }


                if($need_qty > $cart_prd['quantity'])
                {
                    // нужно больше чем в этом товаре
                    $this->cps[$pid]['total_qty'] -= $cart_prd['quantity'];
                    $this->cps[$pid]['products'][$pkey]['quantity'] = 0;

                    $need_qty -= $cart_prd['quantity'];
                    $total_disc += $product_disc * $cart_prd['quantity'];
                }
                else
                {
                    // этого товара достаточно
                    $this->cps[$pid]['total_qty'] -= $need_qty;
                    $this->cps[$pid]['products'][$pkey]['quantity'] -= $need_qty;

                    $total_disc += $product_disc * $need_qty;
                    break;
                }
            }
        }

        return $total_disc;
    }

    public function calc()
    {
        if(!$this->cart->countProducts())
            return false;

        $this->load->model('extension/module/sets');
        $setids = $this->get_set_in_cart();
        $all_discounts = [];
        // echo "<PRE>"; var_dump($setids); echo "</PRE>";
   
        if($setids)
        {
            foreach($setids as $set_id)
            {
                $total_disc = $this->get_disc($set_id);
                if($total_disc)
                {
                    $all_discounts[] = $total_disc;
                }
            }

            if(!empty($all_discounts))
            {
                return array_sum($all_discounts);
            }
        }

        return false;
    }

    public function debug($data)
    {
        echo "<pre>";
        var_dump($data);
        echo "</pre>";
    }
}
