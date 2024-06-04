<?php
class ControllerProductExReviewsPage extends Controller
{
  public function index()
  {
    $settings = $this->config->get("extended_reviews_settings");

    if (isset($settings['all_status'])) {

			if (isset($settings['magnific_page'])) {
				$this->document->addStyle('catalog/view/javascript/ex-reviews/magnific/magnific-popup.css');
				$this->document->addScript('catalog/view/javascript/ex-reviews/magnific/jquery.magnific-popup.min.js');
			}
			if (isset($settings['fancybox_page'])) {
				$this->document->addStyle('catalog/view/javascript/ex-reviews/fancybox/jquery.fancybox.min.css');
				$this->document->addScript('catalog/view/javascript/ex-reviews/fancybox/jquery.fancybox.min.js');
			}
			if (isset($settings['bootstrap_css_page'])) {
				$this->document->addStyle('catalog/view/javascript/ex-reviews/bootstrap/css/bootstrap.min.css');
			}
			if (isset($settings['bootstrap_js_page'])) {
				$this->document->addScript('catalog/view/javascript/ex-reviews/bootstrap/js/bootstrap.min.js');
			}
			if (isset($settings['ex_css_page'])) {
				$this->document->addStyle('catalog/view/javascript/ex-reviews/ex_reviews.css');
			}
			if (isset($settings['ex_js_page'])) {
				$this->document->addScript('catalog/view/javascript/ex-reviews/ex_reviews.js');
			}

      $this->language->load('product/extended_reviews');

      $this->load->model('catalog/ex_reviews_page');

      $this->load->model('tool/image');

      $data = $this->language->all();

      $data['settings'] = $settings;

      if (isset($this->request->get['page'])) {
        $page = $this->request->get['page'];
      } else {
        $page = 1;
      }
      if ($this->customer->isLogged()) {
        $data['customer_name'] = $this->customer->getFirstName() . '&nbsp;' . $this->customer->getLastName();
      } else {
        $data['customer_name'] = '';
      }

      $data['show_review_plus'] = $this->config->get('config_show_review_plus');
      $data['show_review_minus'] = $this->config->get('config_show_review_minus');
      $data['text_login'] = sprintf($this->language->get('text_login'), $this->url->link('account/login', '', true), $this->url->link('account/register', '', true));

      if (isset($settings['review_access']) && !$this->customer->isLogged()) {
        $data['review_guest'] = false;
      } else {
        $data['review_guest'] = true;
      }
      if (isset($settings['likes_access']) && !$this->customer->isLogged()) {
        $data['likes_guest'] = false;
      } else {
        $data['likes_guest'] = true;
      }
      if (isset($settings['answer_access']) && !$this->customer->isLogged()) {
        $data['answer_guest'] = false;
      } else {
        $data['answer_guest'] = true;
      }

      $limit = $settings['all_limit'];

      $data['reviews'] = array();

      $filter_data = array(
				'filter_category_id'   => 0,
				'filter_sub_category'  => false,
				'start'                => ($page - 1) * $limit,
				'limit'                => $limit
			);

      $review_total = $this->model_catalog_ex_reviews_page->getTotalReviews($filter_data);

      $results = $this->model_catalog_ex_reviews_page->getReviews($filter_data);

      if($results){

      foreach ($results as $result) {

        $product_id = false;
        $prod_thumb = false;
        $prod_name = false;
        $prod_href = false;

        if ($result['product_id']) {

          if ($result['image']) {
            $prod_thumb = $this->model_tool_image->resize($result['image'], $settings['product_thumb_width'], $settings['product_thumb_height']);
          }

          $product_id = $result['product_id'];
          $prod_name = $result['name'];
          $prod_href = $this->url->link('product/product', 'product_id=' . $result['product_id']);
        }

        $review_images = $this->model_catalog_ex_reviews_page->getImagesByReviewId($result['review_id']);
        $children_reviews = $this->model_catalog_ex_reviews_page->getChildrenReviews($result['review_id']);

        foreach ($children_reviews as $key => $children) {
          $children_reviews[$key]['date_added'] = date($this->language->get('date_format_short'), strtotime($children['date_added']));
        }

        $images = array();
        foreach ($review_images as $image) {
          $type = '0';
          if ($image['image'] != null) {
            $popup = 'image/' . $image['image'];
            $thumb = $this->model_tool_image->resize($image['image'], $settings['all_thumb_width'] * 2, $settings['all_thumb_height'] * 2);
          } else if ($image['image_href'] != null) {
            $popup = $image['image_href'];
            $thumb = $image['image_href_t'];
            $type = '1';
          }
          $images[] = array(
            'thumb' => $thumb,
            'popup' => $popup,
            'type'  => $type
          );
        }
        $videos = array();
        if (!empty($result['videos'])) {
          $str = explode(' ', $result['videos']);
          foreach ($str as $video) {
            $videos[] = $video;
          }
        }
        $data['reviews'][] = array(
          'review_id'        => $result['review_id'],
          'rating'           => $result['rating'],
          'text'             => isset($settings['html']) ? html_entity_decode($result['text'], ENT_QUOTES, 'UTF-8') : $result['text'],
          'date_added'       => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
          'author'           => $result['author'],
          'purchased'        => $result['purchased'],
          'plus'             => $result['plus'],
          'minus'            => $result['minus'],
          'likes'            => $result['likes'],
          'dislikes'         => $result['dislikes'],
          'admin_name'       => nl2br($result['admin_name']),
          'admin_reply'      => html_entity_decode($result['admin_reply'], ENT_QUOTES, 'UTF-8'),
          'children_reviews' => $children_reviews,
          'images'           => $images,
          'videos'           => $videos,
          'product_id'       => $product_id,
          'prod_thumb'       => $prod_thumb,
          'prod_name'        => $prod_name,
          'prod_href'        => $prod_href
        );

      }
    }

      // Captcha
      if (isset($settings['captcha'])) {
        $data['captcha'] = $this->load->controller('extension/captcha/google_captcha');
      } else {
        $data['captcha'] = '';
      }

      $data['breadcrumbs'] = array();

      $data['breadcrumbs'][] = array(
        'text'      => $this->language->get('text_home'),
        'href'      => $this->url->link('common/home'),
        'separator' => false
      );

      $heading_title = $settings['module_h1'][$this->config->get('config_language_id')] != '' ? $settings['module_h1'][$this->config->get('config_language_id')] : $data['heading_title'];

      $data['page'] = $page;

      $data['num_pages'] = ceil($review_total / $limit);

      $data['review_total'] = $review_total;

      $page_from =  $page > 1 ? sprintf($this->language->get('text_page_from'), $page, $data['num_pages']) : '';

      $data['heading_title'] = $heading_title . $page_from;

      if (isset($settings['module_title'])) {
				$this->document->setTitle($settings['module_title'][$this->config->get('config_language_id')] . $page_from);
			} else {
				$this->document->setTitle($data['heading_title']);
			}

			if (isset($settings['module_description'])) {
			$this->document->setDescription($settings['module_description'][$this->config->get('config_language_id')] . $page_from);
      } else {
        $this->document->setDescription($data['heading_title']);
      }

      if (isset($settings['module_keywords'])) {
			$this->document->setKeywords($settings['module_keywords'][$this->config->get('config_language_id')]);
      }

      $data['breadcrumbs'][] = array(
        'text'      => $heading_title,
        'href'      => $this->url->link('product/ex_reviews_page'),
        'separator' => $this->language->get('text_separator')
      );

      if($page > 1){
        $data['breadcrumbs'][] = array(
          'text'      => $data['heading_title'],
          'href'      => $this->url->link('product/ex_reviews_page'),
          'separator' => $this->language->get('text_separator')
        );
      }

      if (isset($settings['all_pagination']) || !isset($settings['all_show_more'])) {
        $pagination = new Pagination();
        $pagination->total = $review_total;
        $pagination->page = $page;
        $pagination->limit = $limit;
        $pagination->url = $this->url->link('product/ex_reviews_page', '&page={page}');
        $data['pagination'] = $pagination->render();
      }

      if (isset($settings['all_show_more']) && $page < $data['num_pages']) {
        $rev_total = $review_total - $limit * $page;
        $true_word = $this->true_wordform($rev_total, $data['text_review1'], $data['text_review2'], $data['text_review3']);
        if ($limit < $rev_total) {
          $data['more_text'] = sprintf($data['text_more_reviews_limit'], $limit, $rev_total, $true_word);
        } else {
          $data['more_text'] = sprintf($data['text_more_reviews'], $rev_total, $true_word);
        }
        $page++;
        $data['more'] = $this->url->link('product/ex_reviews_page', 'page=' . $page);
      }

      $data['column_left'] = $this->load->controller('common/column_left');
      $data['column_right'] = $this->load->controller('common/column_right');
      $data['content_top'] = $this->load->controller('common/content_top');
      $data['content_bottom'] = $this->load->controller('common/content_bottom');
      $data['footer'] = $this->load->controller('common/footer');
      $data['header'] = $this->load->controller('common/header');

      $this->response->setOutput($this->load->view('product/ex_reviews_page', $data));
    } else {

      $this->language->load('product/extended_reviews');

      $data = $this->language->all();

      $data['breadcrumbs'][] = array(
        'text' => $this->language->get('text_error'),
        'href' => $this->url->link('common/home')
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
  public function true_wordform($num, $form_for_1, $form_for_2, $form_for_5)
  {
    $num = abs($num) % 100;
    $num_x = $num % 10;
    if ($num > 10 && $num < 20)
      return $form_for_5;
    if ($num_x > 1 && $num_x < 5)
      return $form_for_2;
    if ($num_x == 1)
      return $form_for_1;
    return $form_for_5;
  }
}
