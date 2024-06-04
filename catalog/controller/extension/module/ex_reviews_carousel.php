<?php
class ControllerExtensionModuleExReviewsCarousel extends Controller
{
	public function index($settings)
	{

		static $module = 0;

		$plagin = $settings['plagin'];

		$this->load->language('extension/module/ex_reviews_carousel');
		if (isset($plagin['ex_css'])) {
			$this->document->addStyle('catalog/view/javascript/ex-reviews/ex_carousel.css');
		}
		if (isset($plagin['ex_js'])) {
			$this->document->addScript('catalog/view/javascript/ex-reviews/ex_carousel.js');
		}
		if (isset($plagin['magnific'])) {
			$this->document->addStyle('catalog/view/javascript/ex-reviews/magnific/magnific-popup.css');
			$this->document->addScript('catalog/view/javascript/ex-reviews/magnific/jquery.magnific-popup.min.js');
		}
		if (isset($plagin['fancybox'])) {
			$this->document->addStyle('catalog/view/javascript/ex-reviews/fancybox/jquery.fancybox.min.css');
			$this->document->addScript('catalog/view/javascript/ex-reviews/fancybox/jquery.fancybox.min.js');
		}
		if (isset($plagin['carousel'])) {
			$this->document->addStyle('catalog/view/javascript/ex-reviews/owl-carousel/owl.carousel.css');
			$this->document->addScript('catalog/view/javascript/ex-reviews/owl-carousel/owl.carousel.min.js');
		}
		if (isset($plagin['carousel2'])) {
			$this->document->addStyle('catalog/view/javascript/ex-reviews/owl-carousel-2/owl.carousel.css');
			$this->document->addStyle('catalog/view/javascript/ex-reviews/owl-carousel-2/owl.theme.default.min.css');
			$this->document->addScript('catalog/view/javascript/ex-reviews/owl-carousel-2/owl.carousel.min.js');
		}
		if (isset($plagin['slick'])) {
			$this->document->addStyle('catalog/view/javascript/ex-reviews/slick/slick.css');
			$this->document->addStyle('catalog/view/javascript/ex-reviews/slick/slick-theme.css');
			$this->document->addScript('catalog/view/javascript/ex-reviews/slick/slick.min.js');
		}
		if (isset($plagin['swiper'])) {
			$this->document->addStyle('catalog/view/javascript/ex-reviews/swiper/css/swiper.min.css');
			$this->document->addStyle('catalog/view/javascript/ex-reviews/swiper/css/opencart.css');
			$this->document->addScript('catalog/view/javascript/ex-reviews/swiper/js/swiper.jquery.js');
		}
		$data['heading_title'] = $settings['title'][$this->config->get('config_language_id')] ? $settings['title'][$this->config->get('config_language_id')] : $this->language->get('heading_title');
		$data['text_all'] = $this->language->get('text_all');
		$data['text_more'] = $this->language->get('text_more');
		$data['text_buy'] = $this->language->get('text_buy');
		$data['already_rating'] = $this->language->get('already_rating');
		$data['settings'] = $settings;
		$thumb_settings = $settings['thumb_settings'];
		$data['thumb_settings'] = $thumb_settings;
		$data['style'] = $settings['style'];
		$data['carousel'] = $settings['carousel'];
		$data['all_reviews_link'] = $this->url->link('product/ex_reviews_page');

		$this->load->model('catalog/ex_reviews_page');
		$this->load->model('tool/image');

		if (isset($this->request->get['path'])) {

			$path = '';

			$parts = explode('_', (string)$this->request->get['path']);

			$category_id = (int)array_pop($parts);
		} else {
			$category_id = 0;
		}

		$limit = isset($settings['limit']) ? $settings['limit'] : 6;

		$filter_data = array(
			'order'              	=> $settings['type'],
			'media'					=> $settings['media'],
			'filter_category_id'    => $settings['carousel'] ? $category_id : 0,
			'filter_sub_category'   => false,
			'start'              	=> 0,
			'limit'              	=> $limit
		);

		if ($this->config->get('theme_technics_subcategory')) {
			$filter_data['filter_sub_category'] = true;
		}

		$data['reviews'] = array();

		$results = $this->model_catalog_ex_reviews_page->getReviews($filter_data);

		foreach ($results as $result) {

			$product_id = false;
			$prod_thumb = false;
			$prod_name = false;
			$prod_href = false;

			if ($result['product_id']) {

				if ($result['image']) {
					$prod_thumb = $this->model_tool_image->resize($result['image'], $thumb_settings['product_thumb_width'], $thumb_settings['product_thumb_height']);
				}

				$product_id = $result['product_id'];
				$prod_name = $result['name'];
				$prod_href = $this->url->link('product/product', 'product_id=' . $result['product_id']);
			}

			$review_images = $this->model_catalog_ex_reviews_page->getImagesByReviewId($result['review_id']);

			$images = array();

			$count_images = 0;

			foreach ($review_images as $image) {
				$type = '0';
				if ($image['image'] != null) {
					$popup = 'image/' . $image['image'];
					$thumb = $this->model_tool_image->resize($image['image'], $thumb_settings['thumb_width'] * 2, $thumb_settings['thumb_height'] * 2);
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

				$count_images++;

				if ($count_images >= $thumb_settings['thumb_limit'])
					break;
			}

			$videos = array();

			$count_videos = 0;

			if (!empty($result['videos'])) {

				$str = explode(' ', $result['videos']);

				foreach ($str as $video) {

					$videos[] = $video;

					$count_videos++;

					if ($count_videos >= $thumb_settings['video_thumb_limit'])
						break;
				}
			}

			$text = isset($this->config->get("extended_reviews_settings")['html']) ? html_entity_decode($result['text'], ENT_QUOTES, 'UTF-8') : $result['text'];

			$data['reviews'][] = array(
				'review_id'        => $result['review_id'],
				'rating'           => $result['rating'],
				'text'             => strlen($text) < 100 ? $text : utf8_substr($text, 0, 100) . '..',
				'date_added'       => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'author'           => $result['author'],
				'purchased'        => $result['purchased'],
				'plus'             => $result['plus'],
				'minus'            => $result['minus'],
				'likes'            => $result['likes'],
				'dislikes'         => $result['dislikes'],
				'review_href'	   => $prod_href . '#tab-review',
				'images'           => $images,
				'videos'           => $videos,
				'product_id'       => $product_id,
				'prod_thumb'       => $prod_thumb,
				'prod_name'        => $prod_name,
				'prod_href'        => $prod_href
			);
		}

		$data['module'] = $module++;

			if ($settings['carousel_type'] == 1) {
				return $this->load->view('extension/module/ex_reviews/ex_reviews_carousel_swiper', $data);
			} elseif ($settings['carousel_type'] == 2 || $settings['carousel_type'] == 3) {
				return $this->load->view('extension/module/ex_reviews/ex_reviews_carousel_owl', $data);
			} elseif ($settings['carousel_type'] == 4) {
				return $this->load->view('extension/module/ex_reviews/ex_reviews_carousel_slick', $data);
			} else {
				return $this->load->view('extension/module/ex_reviews/ex_reviews_carousel', $data);
			}
		
	}
}
