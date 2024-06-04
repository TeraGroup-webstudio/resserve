<?php
class ControllerExtensionModuleLatestBrend extends Controller {
	public function index($setting) {
		$this->load->language('extension/module/latest_brend');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');

		$data['products'] = array();

		$filter_data = array(
			'sort'  => 'p.date_added',
			'order' => 'DESC',
			'start' => 0,
			'limit_day' => $setting['limit_day'],
			'limit' => $setting['limit']
		);
        $url = '';
		$results = $this->model_catalog_product->getProducts($filter_data);

		if ($results) {
			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height']);
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
				}

                if ($result['manufacturer'] && $result['manufacturer'] != '') {
                    $manufacturer_url = $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $result['manufacturer_id'] . $url);
                } else {
                    $manufacturer_url = '';
                }

				if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				} else {
					$price = false;
				}

				if ((float)$result['special']) {
					$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				} else {
					$special = false;
				}

				if ($this->config->get('config_tax')) {
					$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price'], $this->session->data['currency']);
				} else {
					$tax = false;
				}

				if ($this->config->get('config_review_status')) {
					$rating = $result['rating'];
				} else {
					$rating = false;
				}

                $results_sticker = $this->model_catalog_product->getProductStickers($result['product_id']);
                $stickers = array();
                foreach ($results_sticker as $result_sticker) {
                    if ($result_sticker['sticker']) {
                        $sticker_image = $this->model_tool_image->resize($result_sticker['sticker'], 53, 25);
                    } else {
                        $sticker_image = false;
                    }
                    $stickers[] = $sticker_image;
                }
                $isNew = $this->model_catalog_product->isProductNew($result['date_added']);
                $isHit = $this->model_catalog_product->isProductHit($result['product_id']);

                $product_data = [
                    'product_id'  => $result['product_id'],
                    'thumb'       => $image,
                    'stickers'    => $stickers,
                    'name'        => $result['name'],
                    'description' => utf8_substr(trim(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'))), 0, $this->config->get('theme_' . $this->config->get('config_theme') . '_product_description_length')) . '..',
                    'price'       => $price,
                    'special'     => $special,
                    'tax'         => $tax,
                    'manufacturer_name' =>  $result['manufacturer'],
                    'manufacturer_url' =>  $manufacturer_url,
                    'label_new'     => $isNew,
                    'label_hit'     => $isHit,
                    'stock_status_id'     => $result['stock_status_id'],
                    'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,
                    'rating'      => $result['rating'],
                    'href'        => $this->url->link('product/product', '&product_id=' . $result['product_id'] . $url)
                ];
                $data['products'][] = $this->load->controller('product/mini_product', $product_data);
			}

			return $this->load->view('extension/module/latest_brend', $data);
		}
	}
}
