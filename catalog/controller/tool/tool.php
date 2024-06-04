<?php
class ControllerToolTool extends Controller {

    public function clear(){

        if(isset($this->request->get['del']) && $this->request->get['del'] == 'yes'){
            $this->del_product();
            $this->del_category();
        }

    }

    private function del_product(){
        $this->db->query("DELETE FROM " . DB_PREFIX . "product WHERE 1");
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE 1");
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_description WHERE 1");
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_discount WHERE 1");
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_filter WHERE 1");
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_image WHERE 1");
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_option WHERE 1");
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_option_value WHERE 1");
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE 1");
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE 1");
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_reward WHERE 1");
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE 1");
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE 1");
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_to_download WHERE 1");
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_to_layout WHERE 1");
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_to_store WHERE 1");
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_recurring WHERE 1");
        $this->db->query("DELETE FROM " . DB_PREFIX . "review WHERE 1");
        $this->db->query("DELETE FROM " . DB_PREFIX . "seo_url WHERE query LIKE '%product_id=%'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "coupon_product WHERE 1");
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_sticker WHERE 1");

        $this->cache->delete('product');
    }

    private function del_category(){
        $this->db->query("DELETE FROM " . DB_PREFIX . "category WHERE 1");
        $this->db->query("DELETE FROM " . DB_PREFIX . "category_description WHERE 1");
        $this->db->query("DELETE FROM " . DB_PREFIX . "category_filter WHERE 1");
        $this->db->query("DELETE FROM " . DB_PREFIX . "category_path WHERE 1");
        $this->db->query("DELETE FROM " . DB_PREFIX . "category_to_store WHERE 1");
        $this->db->query("DELETE FROM " . DB_PREFIX . "category_to_layout WHERE 1");
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE 1");
        $this->db->query("DELETE FROM " . DB_PREFIX . "seo_url WHERE query LIKE '%category_id=%'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "coupon_category WHERE 1");

        $this->cache->delete('category');
    }
}
