<?php
class ControllerAccountWishList extends Controller {
    public function index() {
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('account/wishlist', '', true);

            $this->response->redirect($this->url->link('account/login', '', true));
        }

        $this->load->language('account/wishlist');

        $this->load->model('account/wishlist');

        $this->load->model('catalog/product');

        $this->load->model('tool/image');

        if (isset($this->request->get['remove'])) {
            // Remove Wishlist
            $this->model_account_wishlist->deleteWishlist($this->request->get['remove']);

            $this->session->data['success'] = $this->language->get('text_remove');

            $this->response->redirect($this->url->link('account/wishlist'));
        }

        $this->document->setTitle($this->language->get('heading_title'));
        $url = '';
        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_account'),
            'href' => $this->url->link('account/account', '', true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('account/wishlist')
        );

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
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

        $data['products'] = array();

        $filter_data = array(
            'sort'               => $sort,
            'order'              => $order,
            'start'              => ($page - 1) * $limit,
            'limit'              => $limit
        );

        $results = $this->model_account_wishlist->getWishlist($filter_data);


        foreach ($results as $result) {
            $product_info = $this->model_catalog_product->getProduct($result['product_id']);

            if ($product_info) {

                $results_sticker = $this->model_catalog_product->getProductStickers($product_info['product_id']);
                $stickers = array();
                foreach ($results_sticker as $result_sticker) {
                    if ($result_sticker['sticker']) {
                        $sticker_image = $this->model_tool_image->resize($result_sticker['sticker'], 53, 25);
                    } else {
                        $sticker_image = false;
                    }
                    $stickers[] = $sticker_image;
                }

                if ($product_info['manufacturer'] && $product_info['manufacturer'] != '') {
                    $manufacturer_url = $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $product_info['manufacturer_id'] . $url);
                } else {
                    $manufacturer_url = '';
                }

                if ($product_info['image']) {
                    $image = $this->model_tool_image->resize($product_info['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_wishlist_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_wishlist_height'));
                } else {
                    $image = false;
                }

                if ($product_info['quantity'] <= 0) {
                    $stock = $product_info['stock_status'];
                } elseif ($this->config->get('config_stock_display')) {
                    $stock = $product_info['quantity'];
                } else {
                    $stock = $this->language->get('text_instock');
                }

                if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
                    $price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                } else {
                    $price = false;
                }

                if ((float)$product_info['special']) {
                    $special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                } else {
                    $special = false;
                }

                if ($this->config->get('config_tax')) {
					$tax = $this->currency->format((float)$product_info['special'] ? $product_info['special'] : $product_info['price'], $this->session->data['currency']);
				} else {
					$tax = false;
				}

				if ($this->config->get('config_review_status')) {
					$rating = (int)$product_info['rating'];
				} else {
					$rating = false;
				}
				if ($product_info['quantity'] <= 0) {
					$stock = $product_info['stock_status'];
					$class_stock = 'red';
				} elseif ($this->config->get('config_stock_display')) {
					$stock = $product_info['quantity'];
					$class_stock = 'green';
				} else {
					$stock = $this->language->get('text_instock');
					$class_stock = 'green';
				}
				$model = $product_info['model'];

                $isNew = $this->model_catalog_product->isProductNew($result['date_added']);
                $isHit = $this->model_catalog_product->isProductHit($result['product_id']);

                $product_data = [
                    'product_id' => $product_info['product_id'],
                    'thumb'      => $image,
                    'stickers'    => $stickers,
                    'quantity'    => $product_info['quantity'],
					'stock'     => $stock,
					'class_stock'     => $class_stock,
                    'manufacturer_name' =>  $product_info['manufacturer'],
                    'manufacturer_url' =>  $manufacturer_url,
                    'name'       => $product_info['name'],
                    'model'      => $product_info['model'],
                    'price'      => $price,
                    'special'    => $special,
                    'href'       => $this->url->link('product/product', 'product_id=' . $product_info['product_id']),
                    'tax'         => $tax,
                    'label_new'     => $isNew,
                    'label_hit'     => $isHit,
                    'stock_status_id'     => $product_info['stock_status_id'],
					'reviews'     => $product_info['reviews'],
					'minimum'     => $product_info['minimum'] > 0 ? $product_info['minimum'] : 1,
					'rating'      => $rating,
                    'remove'     => $this->url->link('account/wishlist', 'remove=' . $product_info['product_id'])
                ];
                $data['products'][] = $this->load->controller('product/mini_product', $product_data);
            } else {
                $this->model_account_wishlist->deleteWishlist($result['product_id']);
            }
        }

        if (isset($this->request->get['limit'])) {
            $url .= '&limit=' . $this->request->get['limit'];
        }

        $data['sorts'] = array();

        $data['sorts'][] = array(
            'text'  => $this->language->get('text_default'),
            'value' => 'p.sort_order-ASC',
            'href'  => $this->url->link('account/wishlist', '&sort=p.viewed&order=DESC' . $url)
        );

        $data['sorts'][] = array(
            'text'  => $this->language->get('text_price_asc'),
            'value' => 'p.price-ASC',
            'href'  => $this->url->link('account/wishlist', '&sort=p.price&order=ASC' . $url)
        );

        $data['sorts'][] = array(
            'text'  => $this->language->get('text_price_desc'),
            'value' => 'p.price-DESC',
            'href'  => $this->url->link('account/wishlist', '&sort=p.price&order=DESC' . $url)
        );

        $data['sorts'][] = array(
            'text'  => $this->language->get('text_popular_desc'),
            'value' => 'p.viewed-DESC',
            'href'  => $this->url->link('account/wishlist', '&sort=p.viewed&order=DESC' . $url)
        );

        $data['sorts'][] = array(
            'text'  => $this->language->get('text_popular_asc'),
            'value' => 'p.viewed-ASC',
            'href'  => $this->url->link('account/wishlist', '&sort=p.viewed&order=ASC' . $url)
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
                'href'  => $this->url->link('account/wishlist', $url . '&limit=' . $value)
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

        //$product_total = count($results);
//print_r($product_total);
        $product_total = $this->model_account_wishlist->getTotalWishlistProduct($filter_data);
        //print_r($filter_data);
        $pagination = new Pagination();
        $pagination->total = $product_total;
        $pagination->page = $page;
        $pagination->limit = $limit;
        $pagination->url = $this->url->link('account/wishlist', $url . '&page={page}');

        $data['pagination'] = $pagination->render();

        $data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($product_total - $limit)) ? $product_total : ((($page - 1) * $limit) + $limit), $product_total, ceil($product_total / $limit));

        $data['sort'] = $sort;
        $data['order'] = $order;
        $data['limit'] = $limit;

        $data['continue'] = $this->url->link('account/account', '', true);

        $data['column_left'] = $this->load->controller('common/column_left');
        $data['column_right'] = $this->load->controller('common/column_right');
        $data['content_top'] = $this->load->controller('common/content_top');
        $data['content_bottom'] = $this->load->controller('common/content_bottom');
        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');

        $this->response->setOutput($this->load->view('account/wishlist', $data));
    }

    public function add() {
        $this->load->language('account/wishlist');

        $json = array();

        if (isset($this->request->post['product_id'])) {
            $product_id = $this->request->post['product_id'];
        } else {
            $product_id = 0;
        }

        $this->load->model('catalog/product');

        $product_info = $this->model_catalog_product->getProduct($product_id);

        if ($product_info) {
            if ($this->customer->isLogged()) {
                // Edit customers cart
                $this->load->model('account/wishlist');

                $this->model_account_wishlist->addWishlist($this->request->post['product_id']);
                $json['text_back'] = $this->language->get('text_back');
                $json['text_go'] = $this->language->get('text_go');
                $json['success'] = sprintf($this->language->get('text_success'), $this->url->link('product/product', 'product_id=' . (int)$this->request->post['product_id']), $product_info['name'], $this->url->link('account/wishlist'));
                $json['basket'] = $this->url->link('account/wishlist');
                $json['total'] = $this->model_account_wishlist->getTotalWishlist();
            } else {
                if (!isset($this->session->data['wishlist'])) {
                    $this->session->data['wishlist'] = array();
                }
                $json['basket'] = $this->url->link('account/wishlist');
                $json['text_back'] = $this->language->get('text_back');
                $json['text_go'] = $this->language->get('text_go');

                $this->session->data['wishlist'][] = $this->request->post['product_id'];

                $this->session->data['wishlist'] = array_unique($this->session->data['wishlist']);

                $json['success'] = sprintf($this->language->get('text_login'), $this->url->link('account/login', '', true), $this->url->link('account/register', '', true), $this->url->link('product/product', 'product_id=' . (int)$this->request->post['product_id']), $product_info['name'], $this->url->link('account/wishlist'));

                $json['total'] = (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0);
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
}
