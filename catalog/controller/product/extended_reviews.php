<?php
class ControllerProductExtendedReviews extends Controller
{
	public function index()
	{
		$settings = $this->config->get("extended_reviews_settings");
		$data['settings'] = $settings;

		if (isset($settings['dropzone'])) {
			$this->document->addStyle('catalog/view/javascript/ex-reviews/dropzone-5.7.0/dist/min/dropzone.min.css');
			$this->document->addScript('catalog/view/javascript/ex-reviews/dropzone-5.7.0/dist/min/dropzone.min.js');
			$this->document->addScript('catalog/view/javascript/ex-reviews/exif.min.js');
		}
		if (isset($settings['magnific'])) {
			$this->document->addStyle('catalog/view/javascript/ex-reviews/magnific/magnific-popup.css');
			$this->document->addScript('catalog/view/javascript/ex-reviews/magnific/jquery.magnific-popup.min.js');
		}
		if (isset($settings['fancybox'])) {
			$this->document->addStyle('catalog/view/javascript/ex-reviews/fancybox/jquery.fancybox.min.css');
			$this->document->addScript('catalog/view/javascript/ex-reviews/fancybox/jquery.fancybox.min.js');
		}
		if (isset($settings['bootstrap_css'])) {
			$this->document->addStyle('catalog/view/javascript/ex-reviews/bootstrap/css/bootstrap.min.css');
		}
		if (isset($settings['bootstrap_js'])) {
			$this->document->addScript('catalog/view/javascript/ex-reviews/bootstrap/js/bootstrap.min.js');
		}
		if (isset($settings['ex_css'])) {
			$this->document->addStyle('catalog/view/javascript/ex-reviews/ex_reviews.css');
		}
		if (isset($settings['ex_js'])) {
			$this->document->addScript('catalog/view/javascript/ex-reviews/ex_reviews.js');
		}
		return $data;
	}

	public function review()
	{

		$settings = $this->config->get("extended_reviews_settings");

		$this->load->language('product/extended_reviews');
		$data = $this->language->all();
		$this->load->model('catalog/extended_reviews');
		$data['settings'] = $settings;

		$url = '';

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = $settings['sort_order'];
		}

		$url .= '&sort=' . $sort;
		$data['sort'] = $sort;
		$data['sorts'] = array();

		$data['sorts'][] = array(
			'text'  => $this->language->get('sort_date'),
			'value' => 'r.date_added',
			'href'  => $this->url->link('product/extended_reviews/review', 'product-id=' . $this->request->get['product-id'] . '&sort=r.date_added')
		);

		$data['sorts'][] = array(
			'text'  => $this->language->get('sort_most_useful'),
			'value' => 'r.likes',
			'href'  => $this->url->link('product/extended_reviews/review', 'product-id=' . $this->request->get['product-id'] . '&sort=r.likes')
		);

		$data['sorts'][] = array(
			'text'  => $this->language->get('sort_rating'),
			'value' => 'r.rating',
			'href'  => $this->url->link('product/extended_reviews/review', 'product-id=' . $this->request->get['product-id'] . '&sort=r.rating')
		);

		$data['sorts'][] = array(
			'text'  => $this->language->get('sort_with_media'),
			'value' => 'media',
			'href'  => $this->url->link('product/extended_reviews/review', 'product-id=' . $this->request->get['product-id'] . '&sort=media')
		);

		if ($this->customer->isLogged()) {
			$data['customer_name'] = $this->customer->getLastName() . '&nbsp;' . $this->customer->getFirstName();
		} else {
			$data['customer_name'] = '';
		}

		if ($this->customer->isLogged()) {
			$data['customer_email'] = $this->customer->getEmail();
		} else {
			$data['customer_email'] = '';
		}

		$data['reviews'] = array();

		$data['product_id'] = $this->request->get['product-id'];

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

		$data['dropzone_default_message'] = sprintf($this->language->get('dropzone_default_message'), $settings['image_max_count'], $settings['image_max_size']);

		$data['error_too_big'] = sprintf($this->language->get('error_too_big'), $settings['image_max_size']);

		$data['error_max_files'] = sprintf($this->language->get('error_max_files'), $settings['image_max_count']);

		$limit = isset($settings['limit']) ? $settings['limit'] : 10;

		$review_total = $this->model_catalog_extended_reviews->getTotalReviewsByProductId($this->request->get['product-id']);

		$results = $this->model_catalog_extended_reviews->getReviewsByProductId($this->request->get['product-id'], ($page - 1) * $limit, $limit, $sort);

		$total_videos = $this->model_catalog_extended_reviews->getAllProductVideos($this->request->get['product-id']);

		$review_images_total = $this->model_catalog_extended_reviews->getImagesByProductId($this->request->get['product-id']);

		$data['total_videos'] = $total_videos;

		$data['total_images'] = $review_images_total;

		$data['total_reviews'] = (int)$review_total;

		$data['tab_review'] = sprintf($this->language->get('tab_review'), $review_total);

		$ex_review = $this->model_catalog_extended_reviews->getRatingByProductId($this->request->get['product-id']);

		$data['ex_rating'] = isset($ex_review['sum']) ? round((float)$ex_review['sum'] / $data['total_reviews'], 1) : 0;

		$data['avg_star_rating'] = $data['ex_rating'] / 5 * 100;

		$data['ex_raiting_stats'][5] = [
			'raiting' => isset($ex_review['rating'][5]) ? round(count($ex_review['rating'][5]) / $data['total_reviews'] * 100) : 0,
			'sum' => isset($ex_review['rating'][5]) ? (int)count($ex_review['rating'][5]) : 0
		];

		$data['ex_raiting_stats'][4] = [
			'raiting' => isset($ex_review['rating'][4]) ? round(count($ex_review['rating'][4]) / $data['total_reviews'] * 100) : 0,
			'sum' => isset($ex_review['rating'][4]) ? (int)count($ex_review['rating'][4]) : 0
		];

		$data['ex_raiting_stats'][3] = [
			'raiting' => isset($ex_review['rating'][3]) ? round(count($ex_review['rating'][3]) / $data['total_reviews'] * 100) : 0,
			'sum' => isset($ex_review['rating'][3]) ? (int)count($ex_review['rating'][3]) : 0
		];

		$data['ex_raiting_stats'][2] = [
			'raiting' => isset($ex_review['rating'][2]) ? round(count($ex_review['rating'][2]) / $data['total_reviews'] * 100) : 0,
			'sum' => isset($ex_review['rating'][2]) ? (int)count($ex_review['rating'][2]) : 0
		];

		$data['ex_raiting_stats'][1] = [
			'raiting' => isset($ex_review['rating'][1]) ? round(count($ex_review['rating'][1]) / $data['total_reviews'] * 100) : 0,
			'sum' => isset($ex_review['rating'][1]) ? (int)count($ex_review['rating'][1]) : 0
		];

		foreach ($results as $key => $result) {

			if (!empty($review_images_total[$result['review_id']])) {
				$images = $review_images_total[$result['review_id']];
			} else {
				$images = null;
			}

			$results[$key]['images'] = $images;
		}

		$data['reviews'] = $results;

		// Captcha
		if (isset($settings['captcha'])) {
			$data['captcha'] = $this->load->controller('extension/captcha/google');
		} else {
			$data['captcha'] = '';
		}

		$data['page'] = $page;

		$data['num_pages'] = ceil($review_total / $limit);

		$data['review_total'] = $review_total;


		if (isset($settings['pagination']) || !isset($settings['show_more'])) {
			$pagination = new Pagination();
			$pagination->total = $review_total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->url = $this->url->link('product/extended_reviews/review', 'product-id=' . $this->request->get['product-id'] . '&page={page}' . $url);

			$data['pagination'] = $pagination->render();
		}
		if (isset($settings['show_more']) && $page < $data['num_pages']) {
			$rev_total = $review_total - $limit * $page;
			$true_word = $this->true_wordform($rev_total, $data['text_review1'], $data['text_review2'], $data['text_review3']);
			// if ($limit < $rev_total) {
			// 	$data['more_text'] = sprintf($data['text_more_reviews_limit'], $limit, $rev_total, $true_word);
			// } else {
			// 	$data['more_text'] = sprintf($data['text_more_reviews'], $rev_total, $true_word);
			// }
			$data['more_text'] = $data['text_more_reviews'];
			$page++;
			$data['more'] = $this->url->link('product/extended_reviews/review', 'product-id=' . $this->request->get['product-id'] . '&page=' . $page . $url);
		}

		$this->response->setOutput($this->load->view('product/extended_reviews', $data));
	}

	public function write()
	{

		$this->load->language('product/extended_reviews');

		$settings = $this->config->get("extended_reviews_settings");

		$json = array();

		$settings = $this->config->get("extended_reviews_settings");

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {

			if (empty($this->request->post['rating']) || $this->request->post['rating'] < 0 || $this->request->post['rating'] > 5) {

				$json['error'] = $this->language->get('error_rating');
			}

			if ((utf8_strlen($this->request->post['name']) < $settings['name_min']) || (utf8_strlen($this->request->post['name']) > $settings['name_max'])) {

				$json['error'] = sprintf($this->language->get('error_name'), $settings['name_min'], $settings['name_max']);
			}
			if ((utf8_strlen($this->request->post['text']) < $settings['text_min']) || (utf8_strlen($this->request->post['text']) > $settings['text_max'])) {

				$json['error'] = sprintf($this->language->get('error_text'), $settings['text_min'], $settings['text_max']);
			}
			if (isset($settings['limitations'])) {
				if ((utf8_strlen($this->request->post['plus']) > $settings['limitations_max']) || (utf8_strlen($this->request->post['minus']) > $settings['limitations_max'])) {

					$json['error'] = sprintf($this->language->get('error_limitations'), $settings['limitations_max']);
				}
			}

			// Captcha
			if (isset($settings['captcha'])) {

				$captcha = $this->load->controller('extension/captcha/google/validate');

				if ($captcha) {

					$json['error'] = $captcha;
				}
			}

			if (!isset($json['error'])) {

				$this->load->model('catalog/extended_reviews');

				$review_id = $this->model_catalog_extended_reviews->addReview($this->request->get['product_id'], $this->request->post);

				$json['success'] = $this->language->get('text_success');
			}
		} else {
			$json['error'] = $this->language->get('error_post');
		}

		$this->response->addHeader('Content-Type: application/json');

		$this->response->setOutput(json_encode($json));
	}

	public function writeAnswer()
	{

		$this->load->language('product/extended_reviews');

		$settings = $this->config->get("extended_reviews_settings");

		$json = array();

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {

			if ((utf8_strlen($this->request->post['name']) < $settings['name_min']) || (utf8_strlen($this->request->post['name']) > $settings['name_max'])) {

				$json['error'] = sprintf($this->language->get('error_name'), $settings['name_min'], $settings['name_max']);
			}
			if ((utf8_strlen($this->request->post['text']) < $settings['text_min']) || (utf8_strlen($this->request->post['text']) > $settings['text_max'])) {

				$json['error'] = sprintf($this->language->get('error_text'), $settings['text_min'], $settings['text_max']);
			}

			// Captcha

			if (isset($settings['captcha'])) {

				$captcha = $this->load->controller('extension/captcha/google/validate');

				if ($captcha) {

					$json['error'] = $captcha;
				}
			}

			if (!isset($json['error'])) {

				$this->load->model('catalog/extended_reviews');

				$this->model_catalog_extended_reviews->addReviewAnswer($this->request->get['product_id'], $this->request->get['parent_id'], $this->request->post);

				$json['success'] = $this->language->get('text_success');
			}
		} else {
			$json['error'] = $this->language->get('error_post');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function plusReviewRating()
	{

		$this->load->language('product/extended_reviews');

		$this->load->model('catalog/extended_reviews');

		$json = array();

		if (isset($this->config->get("extended_reviews_settings")['likes_access']) && !$this->customer->isLogged()) {
			$json['login'] = sprintf($this->language->get('text_login'), $this->url->link('account/login', '', true), $this->url->link('account/register', '', true));
		} else {
			$this->model_catalog_extended_reviews->ratingPlus($this->request->post['review_id'], $this->request->post['review_type']);

			$json['success'] = $this->language->get('thank_for_rating');
		}

		$this->response->addHeader('Content-Type: application/json');

		$this->response->setOutput(json_encode($json));
	}

	public function minusReviewRating()
	{

		$this->load->language('product/extended_reviews');

		$this->load->model('catalog/extended_reviews');

		$json = array();

		$this->model_catalog_extended_reviews->ratingMinus($this->request->post['review_id'], $this->request->post['review_type']);

		$json['success'] = $this->language->get('text_success');

		$this->response->addHeader('Content-Type: application/json');

		$this->response->setOutput(json_encode($json));
	}

	public function deleteImage()
	{

		$this->load->model('catalog/extended_reviews');

		$this->model_catalog_extended_reviews->deleteImageById($this->request->post['image_id']);

		$json['success'] = $this->language->get('text_success');

		$this->response->addHeader('Content-Type: application/json');

		$this->response->setOutput(json_encode($json));
	}

	public function check()
	{

		$this->load->model('catalog/extended_reviews');

		$data = $this->model_catalog_extended_reviews->uploadImage($this->request->post['product-id'], $this->request->files['file']['name'], $this->request->files['file']['tmp_name']);

		$this->response->addHeader('Content-Type: application/json');

		$this->response->setOutput(json_encode($data));
	}

	public function getReviewInfo()
	{

		$this->load->language('product/extended_reviews');

		$this->load->model('catalog/extended_reviews');

		$review_id = (int)$this->request->get['review_id'];

		$data = array();

		$data = $this->language->all();

		$data['settings'] = $this->config->get("extended_reviews_settings");

		$review_info = $this->model_catalog_extended_reviews->getReviewData($review_id);

		$review_info['date_added'] = date($this->language->get('date_format_short'), strtotime($review_info['date_added']));

		$comments = $this->model_catalog_extended_reviews->getChildrenReviews($review_id);

		$data['review'] = $review_info;

		$data['comments'] = $comments;

		foreach ($comments as $key => $comment) {
			$data['comments'][$key]['date_added'] = date($this->language->get('date_format_short'), strtotime($comment['date_added']));
		}

		$this->response->setOutput($this->load->view('product/ex_reviews_modal', $data));
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
