<?php
class ControllerProductCategory extends Controller {
	public function index() {
		$this->load->language('extension/module/list_product');
		$this->load->language('product/category');

		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');

		/* setting template*/
			$data['lazy_load_status'] = $this->config->get('theme_default_image_lazy_load_status');
			$data['category_shot_description_status'] = $this->config->get('theme_default_category_shot_description_status');
			$data['category_shot_description_length'] = $this->config->get('theme_default_category_shot_description_length');
		/* setting template*/

		if (isset($this->request->get['filter'])) {
			$filter = $this->request->get['filter'];
		} else {
			$filter = '';
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			//$sort = 'p.sort_order';
			$sort = 'p.viewed';
		}


		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			//$order = 'ASC';
			$order = 'DESC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		if (isset($this->request->get['limit'])) {
			$limit = (int)$this->request->get['limit'];
		} else {
			$limit = $this->config->get('theme_' . $this->config->get('config_theme') . '_product_limit');
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		if (isset($this->request->get['path'])) {
			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$path = '';

			$parts = explode('_', (string)$this->request->get['path']);

			$category_id = (int)array_pop($parts);

			foreach ($parts as $path_id) {
				if (!$path) {
					$path = (int)$path_id;
				} else {
					$path .= '_' . (int)$path_id;
				}

				$category_info = $this->model_catalog_category->getCategory($path_id);

				if ($category_info) {
					$data['breadcrumbs'][] = array(
						'text' => $category_info['name'],
						'href' => $this->url->link('product/category', 'path=' . $path . $url)
					);
				}
			}
		} else {
			$category_id = 0;
		}

		$category_info = $this->model_catalog_category->getCategory($category_id);

		if ($category_info) {
			$this->document->setTitle($category_info['meta_title']);
			$this->document->setDescription($category_info['meta_description']);
			$this->document->setKeywords($category_info['meta_keyword']);

			$data['heading_title'] = $category_info['name'];

			$data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));

			// Set the last category breadcrumb
			$data['breadcrumbs'][] = array(
				'text' => $category_info['name'],
				'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'])
			);

            if ( ($this->config->get('theme_' . $this->config->get('config_theme') . '_image_category_width') < 300) || ($this->config->get('theme_' . $this->config->get('config_theme') . '_image_category_height') < 300) ) {
                $this->document->addOGMeta( 'property="og:image"', str_replace(' ', '%20', $this->model_tool_image->resize($category_info['image'], 300, 300)) );
                $this->document->addOGMeta('property="og:image:width"', '300');
                $this->document->addOGMeta('property="og:image:height"', '300');
            } else {
                $this->document->addOGMeta( 'property="og:image"', str_replace(' ', '%20', $this->model_tool_image->resize($category_info['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_category_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_category_height'), 'category_image')) );
                $this->document->addOGMeta('property="og:image:width"', $this->config->get('theme_' . $this->config->get('config_theme') . '_image_category_width'));
                $this->document->addOGMeta('property="og:image:height"', $this->config->get('theme_' . $this->config->get('config_theme') . '_image_category_height'));
            }

			if ($category_info['image']) {
				$data['thumb'] = $this->model_tool_image->resize($category_info['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_category_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_category_height'), 'category_image');
			} else {
                $this->document->addOGMeta( 'property="og:image"', str_replace(' ', '%20', $this->model_tool_image->resize($this->config->get('config_logo'), 300, 300)) );
                $this->document->addOGMeta('property="og:image:width"', '300');
                $this->document->addOGMeta('property="og:image:height"', '300');
				$data['thumb'] = '';
			}

			$data['description'] = html_entity_decode($category_info['description'], ENT_QUOTES, 'UTF-8');
			$data['compare'] = $this->url->link('product/compare');

			$descr_lenght = mb_strlen($data['description'],'UTF-8');


			if($descr_lenght > $data['category_shot_description_length'] && $descr_lenght != ''){
				$data['long_description'] = true;
			} else {
				$data['long_description'] = false;
			}
			// if ($descr_lenght > $data['category_shot_description_length'] && $descr_lenght != '') {
			// 	$data['hidden'] = '';
			// 	$data['read_more_text_after_visibility'] = 'visible';
			// } else {
			// 	$data['hidden'] = ' hidden';
			// 	$data['read_more_text_after_visibility'] = 'hidden';
			// }

			$url = '';

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['categories'] = array();

			$results = $this->model_catalog_category->getCategories($category_id);

			foreach ($results as $result) {
				$filter_data = array(
					'filter_category_id'  => $result['category_id'],
					'filter_sub_category' => true
				);
                if ($result['image']) {
                    $image = $this->model_tool_image->resize($result['image'], 275, 200);
                } else {
                    $image = $this->model_tool_image->resize('placeholder.png', 275, 200);
                }

				$data['categories'][] = array(
					'name' => $result['name'],
					'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '_' . $result['category_id'] . $url),
					'image' => $image
				);
			}

			$data['products'] = array();

			$filter_data = array(
				'filter_category_id' => $category_id,
				'filter_filter'      => $filter,
				'filter_sub_category' => true,
				'sort'               => $sort,
				'order'              => $order,
				'start'              => ($page - 1) * $limit,
				'limit'              => $limit
			);


			$product_total = $this->model_catalog_product->getTotalProducts($filter_data);

			$results = $this->model_catalog_product->getProducts($filter_data);

			foreach ($results as $result) {

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


                if ($result['manufacturer'] && $result['manufacturer'] != '') {
                    $manufacturer_url = $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $result['manufacturer_id'] . $url);
			    } else {
                    $manufacturer_url = '';
                }

				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_height'), 'product_list');
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_height'));
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
					$rating = (int)$result['rating'];
				} else {
					$rating = false;
				}
				if ($result['quantity'] <= 0) {
					$stock = $result['stock_status'];
					$class_stock = 'red';
				} elseif ($this->config->get('config_stock_display')) {
					$stock = $result['quantity'];
					$class_stock = 'green';
				} else {
					$stock = $this->language->get('text_instock');
					$class_stock = 'green';
				}
				$model = $result['model'];

				$isNew = $this->model_catalog_product->isProductNew($result['date_added']);
				$isHit = $this->model_catalog_product->isProductHit($result['product_id']);

				$product_data = [
					'product_id'  => $result['product_id'],
					'thumb'       => $image,
					'quantity'    => $result['quantity'],
					'viewed'    => $result['viewed'],
                    'manufacturer_name' =>  $result['manufacturer'],
                    'manufacturer_url' =>  $manufacturer_url,
					'stock'     => $stock,
					'class_stock'     => $class_stock,
					'stock_status_id'     => $result['stock_status_id'],
                    'stickers'    => $stickers,
					'name'        => $result['name'],
					'description' => utf8_substr(trim(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'))), 0, $this->config->get('theme_' . $this->config->get('config_theme') . '_product_description_length')) . '..',
					'price'       => $price,
					'special'     => $special,
					'tax'         => $tax,
					'model'     => $model,
					'label_new'     => $isNew,
					'label_hit'     => $isHit,
					'reviews'     => $result['reviews'],
					'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,
					'rating'      => $rating,
					'href'        => $this->url->link('product/product', 'path=' . $this->request->get['path'] . '&product_id=' . $result['product_id'] . $url),
					 'remove'     => $this->url->link('account/wishlist', 'remove=' . $result['product_id'])
                    ];

				$data['products'][] = $this->load->controller('product/mini_product', $product_data);
			}

			$url = '';

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['sorts'] = array();

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_default'),
				'value' => 'p.sort_order-ASC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.viewed&order=DESC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_price_asc'),
				'value' => 'p.price-ASC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.price&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_price_desc'),
				'value' => 'p.price-DESC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.price&order=DESC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_popular_desc'),
				'value' => 'p.viewed-DESC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.viewed&order=DESC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_popular_asc'),
				'value' => 'p.viewed-ASC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.viewed&order=ASC' . $url)
			);


			$url = '';

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			$data['limits'] = array();

			$limits = array_unique(array($this->config->get('theme_' . $this->config->get('config_theme') . '_product_limit'), 25, 50, 75, 100));

			sort($limits);

			foreach($limits as $value) {
				$data['limits'][] = array(
					'text'  => $value,
					'value' => $value,
					'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url . '&limit=' . $value)
				);
			}

			$url = '';

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

            $this->document->addOGMeta('property="og:url"', $this->url->link('product/category', 'path=' . $category_info['category_id'] . ( ($page != 1) ? '&page='. $page : '' ), true) );

			$pagination = new Pagination();
			$pagination->total = $product_total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->url = $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url . '&page={page}');

			$data['pagination'] = $pagination->render();

			$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($product_total - $limit)) ? $product_total : ((($page - 1) * $limit) + $limit), $product_total, ceil($product_total / $limit));

			// http://googlewebmastercentral.blogspot.com/2011/09/pagination-with-relnext-and-relprev.html
			if ($page == 1) {
			    $this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id']), 'canonical');
			} else {
				$this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id'] . '&page='. $page), 'canonical');
			}
			
			if ($page > 1) {
			    $this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id'] . (($page - 2) ? '&page='. ($page - 1) : '')), 'prev');
			}

			if ($limit && ceil($product_total / $limit) > $page) {
			    $this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id'] . '&page='. ($page + 1)), 'next');
			}

			$data['sort'] = $sort;
			$data['order'] = $order;
			$data['limit'] = $limit;

			$data['continue'] = $this->url->link('common/home');


			/* Популярні товари */
            $product_popular_data = array();
            if($this->config->get('theme_default_product_popular_category_status')){
                $data['title_popular'] = $this->language->get('text_title_popular').' '.$category_info['name'];
                $filter_data_popular = array(
                    'sort'  => 'p.viewed',
                    'order' => 'DESC',
                    'start' => 0,
                    'limit' => $this->config->get('theme_default_product_popular_category_count')
                );

                $results_popular = $this->model_catalog_product->getProducts($filter_data_popular);

                foreach ($results_popular as $result) {

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


                    if ($result['manufacturer'] && $result['manufacturer'] != '') {
                        $manufacturer_url = $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $result['manufacturer_id'] . $url);
                    } else {
                        $manufacturer_url = '';
                    }

                    if ($result['image']) {
                        $image = $this->model_tool_image->resize($result['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_height'), 'product_list');
                    } else {
                        $image = $this->model_tool_image->resize('placeholder.png', $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_height'));
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
                        $rating = (int)$result['rating'];
                    } else {
                        $rating = false;
                    }
                    if ($result['quantity'] <= 0) {
                        $stock = $result['stock_status'];
                        $class_stock = 'red';
                    } elseif ($this->config->get('config_stock_display')) {
                        $stock = $result['quantity'];
                        $class_stock = 'green';
                    } else {
                        $stock = $this->language->get('text_instock');
                        $class_stock = 'green';
                    }
                    $model = $result['model'];

                    $isNew = $this->model_catalog_product->isProductNew($result['date_added']);
                    $isHit = $this->model_catalog_product->isProductHit($result['product_id']);

                    $product_popular_data = [
                        'product_id'  => $result['product_id'],
                        'thumb'       => $image,
                        'quantity'    => $result['quantity'],
                        'viewed'    => $result['viewed'],
                        'manufacturer_name' =>  $result['manufacturer'],
                        'manufacturer_url' =>  $manufacturer_url,
                        'stock'     => $stock,
                        'class_stock'     => $class_stock,
                        'stock_status_id'     => $result['stock_status_id'],
                        'stickers'    => $stickers,
                        'name'        => $result['name'],
                        'description' => utf8_substr(trim(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'))), 0, $this->config->get('theme_' . $this->config->get('config_theme') . '_product_description_length')) . '..',
                        'price'       => $price,
                        'special'     => $special,
                        'tax'         => $tax,
                        'model'     => $model,
                        'label_new'     => $isNew,
                        'label_hit'     => $isHit,
                        'reviews'     => $result['reviews'],
                        'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,
                        'rating'      => $rating,
                        'href'        => $this->url->link('product/product', 'path=' . $this->request->get['path'] . '&product_id=' . $result['product_id'] . $url),
                        'remove'     => $this->url->link('account/wishlist', 'remove=' . $result['product_id'])
                    ];

                    $data['popular_products'][] = $this->load->controller('product/mini_product', $product_popular_data);
                }
            }


			/* Популярні товари */

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('product/category', $data));
		} else {
			$url = '';

			if (isset($this->request->get['path'])) {
				$url .= '&path=' . $this->request->get['path'];
			}

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_error'),
				'href' => $this->url->link('product/category', $url)
			);

			$this->document->setTitle($this->language->get('text_error'));

			$data['continue'] = $this->url->link('common/home');

			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('error/not_found', $data));
		}
	}
}
