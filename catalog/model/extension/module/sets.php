<?php

class ModelExtensionModuleSets extends Model
{
    public function productHaveOption($product_id)
    {
        $query = $this->db->query("SELECT * 
            FROM " . DB_PREFIX . "product_option_value 
            WHERE product_id = '" . (int) $product_id . "' 
            AND quantity > 0
            LIMIT 1");

         return $query->num_rows;
    }

    public function getDiscountPrice($id, $qty)
    {
        $product_discount_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int) $id . "' AND customer_group_id = '" . (int) $this->config->get('config_customer_group_id') . "' AND quantity <= '" . (int) $qty . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY quantity DESC, priority ASC, price ASC LIMIT 1");

        if ($product_discount_query->num_rows) 
        {
            return $product_discount_query->row['price'];
        } 
        else 
        {
            return false;
        }
    }

    public function one_disc_prod()
    {
        return true;
    }

    public function getSetsProducts(array $set_ids)
    {
        $set_ids_str = implode(',', $set_ids);
        
        $products = $this->db->query("SELECT * FROM `" . DB_PREFIX . "kjset_product`  WHERE " . DB_PREFIX . "kjset_product.set_id IN(" . $set_ids_str . ");");

        return $products->rows;
    }

    public function required_cond()
    {
        if ($this->customer->isLogged())
            $customer_group_id = $this->customer->getGroupId();
        else 
            $customer_group_id = $this->config->get('config_customer_group_id');

        return " `status` = '1' AND 
            (enddate > UNIX_TIMESTAMP(NOW()) || enddate IS NULL || enddate = '') AND
            (`customer_group_id` = '0' OR `customer_group_id` = '" . $customer_group_id . "') ";
    }

    public function getAllSets(int $start, int $limit)
    {
        $sets = [];

        $sql = "SELECT DISTINCT(product_id), id, name, enddate, sort 
        FROM `" . DB_PREFIX . "kjset`  WHERE 
            " . $this->required_cond() . " 
            ORDER BY sort
            LIMIT $start, $limit";
    
        $set_info = $this->db->query($sql);
    
        if($set_info->num_rows)
        {
            $set_ids = [];
            foreach($set_info->rows as $set)
            {
                $sets[$set['id']] = $set;
                $set_ids[] = $set['id'];
            }

            $products = $this->getSetsProducts($set_ids);

            foreach ($products as $product) 
            {
                if (isset($sets[$product['set_id']])) 
                {
                    $sets[$product['set_id']]['products'][(int) $product['sort']] = $product;
                }
            }

            foreach ($set_info->rows as $set) 
            {
                ksort($sets[$set['id']]['products']);
            }
        }

        return $sets;
    }

    public function getAllSetsTotal()
    {
         $sql = "SELECT id FROM `" . DB_PREFIX . "kjset`  WHERE 
            " . $this->required_cond() ;
        

       $set_info = $this->db->query($sql);
       
       return $set_info->num_rows;     
    }

    public function getSets($product_id, $start = 0, $limit = 10, $links = false)
    {
       $sets = [];

       $required_sql_part = $this->required_cond();

       $sql = "SELECT DISTINCT(id), name, enddate, sort 
            FROM `" . DB_PREFIX . "kjset`
            WHERE " . $required_sql_part;


        if($links) 
        {

            $sql2 = "SELECT DISTINCT(set_id)
            FROM `" . DB_PREFIX . "kjset_product` 
            WHERE product_id = '" . (int) $product_id . "'";

            $sql .= " AND id IN (" . $sql2 . ") ";

        }
        else
        {
            $sql .= " AND product_id = '" . (int) $product_id . "' ";
        }

        $sql .= "ORDER BY sort LIMIT " . (int) $start . ", " . (int) $limit;

        $set_info = $this->db->query($sql);

        if($set_info->num_rows)
        {
            $set_ids = [];
            foreach($set_info->rows as $set)
            {
                $sets[$set['id']] = $set;
                $set_ids[] = $set['id'];
            }

            $products = $this->getSetsProducts($set_ids);

            foreach ($products as $product) 
            {
                if (isset($sets[$product['set_id']])) 
                {
                    $sets[$product['set_id']]['products'][(int) $product['sort']] = $product;
                }
            }

            foreach ($set_info->rows as $set) 
            {
                ksort($sets[$set['id']]['products']);
            }
        }

        return $sets;
    }

    public function get_cond_string(array $pr_pid_qty)
    {
        $parts = [];
        foreach($pr_pid_qty as $pid => $qty)
        {
            $parts[] = "(product_id = '" . (int) $pid . "' AND quantity <= '" . (int) $qty . "')";
        }

        return implode(" OR ", $parts);
    }

    public function set_product_gr_by()
    {
        return "SELECT set_id, product_id, SUM(quantity) as quantity FROM `" . DB_PREFIX . "kjset_product` GROUP BY set_id, product_id";
    }

    public function get_group_product($set_id)
    {
        $sql = "SELECT set_id, product_id, SUM(quantity) as quantity FROM `" . DB_PREFIX . "kjset_product` WHERE set_id = '" . (int) $set_id . "' GROUP BY set_id, product_id";
        $res = $this->db->query($sql);
        return $res->rows;
    }

    public function get_count_product_by_setid(array $pr_pid_qty)
    {
        //для подсчета уникальных товаров в корзине с комплектов
        $pod_sql1 = "SELECT set_id, COUNT(*) as total_prd
        FROM (" . $this->set_product_gr_by() . ") t1 
        WHERE " . $this->get_cond_string($pr_pid_qty) . " 
        GROUP BY set_id";

        //для подсчета уникальных товаров в комплекте, а так же скидки от комплекта
        $formula = "kjp.quantity * IF(RIGHT(discount,1) = '%',  (price/100) * LEFT(discount, char_length(discount) - 1) , discount)";
        $pod_sql2 = "SELECT set_id, COUNT(DISTINCT kjp.product_id) as total_prd, SUM($formula) as total_disc
        FROM `" . DB_PREFIX . "kjset_product` kjp
        LEFT JOIN " . DB_PREFIX . "product p
        ON p.product_id = kjp.product_id
        GROUP BY set_id";


        //собираем монстра, который крашнет ваш магазин
        $sql = "SELECT t1.set_id
        FROM ($pod_sql1) t1
        LEFT JOIN `" . DB_PREFIX . "kjset` as kjs
        ON kjs.id = t1.set_id
        LEFT JOIN ($pod_sql2) t2
        ON t2.set_id = t1.set_id
        WHERE " . $this->required_cond() . "
        AND t1.total_prd = t2.total_prd
        ORDER BY t2.total_disc DESC";
        //ORDER BY t2.total_qty DESC";

        //echo "<PRE>";echo $sql;exit();

        $query = $this->db->query($sql);

        $arr = [];

        if($query->num_rows)
        {
            foreach($query->rows as $row)
            {
               $arr[] = (int) $row['set_id'];
            }
        }

        return $arr;
    }

    public function get_set_products(int $set_id)
    {
        $res = $this->db->query("SELECT * FROM `" . DB_PREFIX . "kjset_product` 
            WHERE set_id = '".(int) $set_id."'");

        return $res->rows;
    }

}