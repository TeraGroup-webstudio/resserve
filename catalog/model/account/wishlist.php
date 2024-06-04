<?php
class ModelAccountWishlist extends Model {
	public function addWishlist($product_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "customer_wishlist WHERE customer_id = '" . (int)$this->customer->getId() . "' AND product_id = '" . (int)$product_id . "'");

		$this->db->query("INSERT INTO " . DB_PREFIX . "customer_wishlist SET customer_id = '" . (int)$this->customer->getId() . "', product_id = '" . (int)$product_id . "', date_added = NOW()");
	}

	public function deleteWishlist($product_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "customer_wishlist WHERE customer_id = '" . (int)$this->customer->getId() . "' AND product_id = '" . (int)$product_id . "'");
	}

	public function getWishlist($data) {
        $sql = "SELECT * FROM " . DB_PREFIX . "customer_wishlist cw";

        $sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON (cw.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product p ON (p.product_id = cw.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND cw.customer_id = '" . (int)$this->customer->getId() . "'";


        $sort_data = array(
            'pd.name',
            'p.model',
            'p.quantity',
            'p.price',
            'p.viewed',
            'rating',
            'p.sort_order',
            'p.date_added'
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            if ($data['sort'] == 'pd.name' || $data['sort'] == 'p.model') {
                if($this->config->get('theme_default_product_empty_end')){
                    $sql .= " ORDER BY (p.quantity>0) DESC, LCASE(" . $data['sort'] . ")";
                } else {
                    $sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
                }
            } elseif ($data['sort'] == 'p.price') {
                    $sql .= " ORDER BY (p.price)";
            } else {
                if($this->config->get('theme_default_product_empty_end')){
                    $sql .= " ORDER BY (p.quantity>0) DESC," . $data['sort'];
                } else {
                    $sql .= " ORDER BY " . $data['sort'];
                }
            }
        } else {
            if($this->config->get('theme_default_product_empty_end')){
                $sql .= " ORDER BY (p.quantity>0) DESC, p.sort_order";
            } else {
                $sql .= " ORDER BY p.sort_order";
            }
        }

        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC, LCASE(pd.name) DESC";
        } else {
            $sql .= " ASC, LCASE(pd.name) ASC";
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }

        $query = $this->db->query($sql);
		return $query->rows;
	}

    public function getWishlistProduct($product_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_wishlist WHERE customer_id = '" . (int)$this->customer->getId() . "' AND product_id='".(int)$product_id."'");

        return $query->row;
    }

	public function getTotalWishlist($data=array()) {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer_wishlist WHERE customer_id = '" . (int)$this->customer->getId() . "'");

        return $query->row['total'];
    }
	public function getTotalWishlistProduct($data=array()) {
        $sql = "SELECT COUNT(DISTINCT cw.product_id) AS total";
		//$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer_wishlist WHERE customer_id = '" . (int)$this->customer->getId() . "'");
        $sql .= " FROM " . DB_PREFIX . "customer_wishlist cw";

        $sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON (cw.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product p ON (p.product_id = cw.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND cw.customer_id = '" . (int)$this->customer->getId() . "'";


        $sort_data = array(
            'pd.name',
            'p.model',
            'p.quantity',
            'p.price',
            'p.viewed',
            'rating',
            'p.sort_order',
            'p.date_added'
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            if ($data['sort'] == 'pd.name' || $data['sort'] == 'p.model') {
                if($this->config->get('theme_default_product_empty_end')){
                    $sql .= " ORDER BY (p.quantity>0) DESC, LCASE(" . $data['sort'] . ")";
                } else {
                    $sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
                }
            } elseif ($data['sort'] == 'p.price') {
                $sql .= " ORDER BY (p.price)";
            } else {
                if($this->config->get('theme_default_product_empty_end')){
                    $sql .= " ORDER BY (p.quantity>0) DESC," . $data['sort'];
                } else {
                    $sql .= " ORDER BY " . $data['sort'];
                }
            }
        } else {
            if($this->config->get('theme_default_product_empty_end')){
                $sql .= " ORDER BY (p.quantity>0) DESC, p.sort_order";
            } else {
                $sql .= " ORDER BY p.sort_order";
            }
        }

        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC, LCASE(pd.name) DESC";
        } else {
            $sql .= " ASC, LCASE(pd.name) ASC";
        }


        $query = $this->db->query($sql);

        return $query->row['total'];

	}
}
