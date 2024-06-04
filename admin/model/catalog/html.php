<?php
class ModelCatalogHtml extends Model {
    public function getProductIdsByCategories($category_ids) {
        if (empty($category_ids)) {
            return [];
        }
    
        $query = $this->db->query("
            SELECT DISTINCT p.product_id
            FROM " . DB_PREFIX . "product_to_category p2c
            LEFT JOIN " . DB_PREFIX . "product p ON (p2c.product_id = p.product_id)
            WHERE p2c.category_id IN (" . implode(',', array_map('intval', $category_ids)) . ")
            AND p.status = '1'
        ");
    
        $product_ids = array_column($query->rows, 'product_id');
    
        print_r($product_ids);
        return $product_ids;
    }
}
