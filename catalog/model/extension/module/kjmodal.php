<?php
class ModelExtensionModuleKjmodal extends Model
{

    public function get_product_query($product_id)
    {
        $product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_store p2s LEFT JOIN " . DB_PREFIX . "product p ON (p2s.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND p2s.product_id = '" . (int)$product_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.date_available <= NOW() AND p.status = '1'");

        if ($product_query->num_rows)
        {
            return $product_query->row;
        }
        else
        {
            return false;
        }

    }

    public function get_disc_price($pid, $qty)
    {

        $product_discount_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$pid . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND quantity <= '" . (int)$qty . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY quantity DESC, priority ASC, price ASC LIMIT 1");

        if ($product_discount_query->num_rows) 
        {
            return $product_discount_query->row['price'];
        }
        else
        {
            return false;
        }
    }

    public function get_special_price($product_id)
    {

        $product_special_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY priority ASC, price ASC LIMIT 1");

        if ($product_special_query->num_rows) 
        {
            return $product_special_query->row['price'];
        }
        else
        {
            return false;
        }
    }

    public function get_option_price($product_id, $option)
    {
        $option_price = 0;

        foreach ($option as $product_option_id => $value) 
        {
            $oq = $this->db->query("SELECT po.product_option_id, po.option_id, od.name, o.type FROM " . DB_PREFIX . "product_option po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE po.product_option_id = '" . (int)$product_option_id . "' AND po.product_id = '" . (int)$product_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'");

            if ($oq->num_rows) 
            {
                if ($oq->row['type'] == 'select' || $oq->row['type'] == 'radio')
                {
                    $ovq = $this->db->query("SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_option_value_id = '" . (int)$value . "' AND pov.product_option_id = '" . (int)$product_option_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

                    if ($ovq->num_rows) 
                    {
                        if ($ovq->row['price_prefix'] == '+')
                        {                                        
                            $option_price += $ovq->row['price'];
                        } 
                        elseif ($ovq->row['price_prefix'] == '-')
                        {
                            $option_price -= $ovq->row['price'];
                        }
                    }
                } 
                elseif ($oq->row['type'] == 'checkbox' && is_array($value)) 
                {
                    foreach ($value as $product_option_value_id) 
                    {
                        $ovq = $this->db->query("SELECT pov.option_value_id, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix, ovd.name FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (pov.option_value_id = ovd.option_value_id) WHERE pov.product_option_value_id = '" . (int)$product_option_value_id . "' AND pov.product_option_id = '" . (int)$product_option_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

                        if ($ovq->num_rows) 
                        {
                            if ($ovq->row['price_prefix'] == '+') 
                            {
                                $option_price += $ovq->row['price'];
                            } 
                            elseif ($ovq->row['price_prefix'] == '-') 
                            {
                                $option_price -= $ovq->row['price'];
                            }
                        }
                    }
                } 
            }
        }

        return $option_price;
    }
}