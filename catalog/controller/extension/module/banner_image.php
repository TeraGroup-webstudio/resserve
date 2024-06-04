<?php
class ControllerExtensionModuleBannerImage extends Controller {
	public function index($setting) {
		$this->load->language('extension/module/banner_image');

		if (isset($setting['module_description'][$this->config->get('config_language_id')])) {
			$data['heading_title'] = html_entity_decode($setting['module_description'][$this->config->get('config_language_id')]['title'], ENT_QUOTES, 'UTF-8');
			$data['link'] = html_entity_decode($setting['module_description'][$this->config->get('config_language_id')]['link'], ENT_QUOTES, 'UTF-8');
			$data['html'] = html_entity_decode($setting['module_description'][$this->config->get('config_language_id')]['description'], ENT_QUOTES, 'UTF-8');
		}

		if ($setting['image']) {
			$data['image'] = 'image/' . $setting['image'];
		} else {
			$data['image'] = '';
		}

		if ($setting['logo']) {
			$data['logo'] = 'image/' . $setting['logo'];
		} else {
			$data['logo'] = '';
		}

		return $this->load->view('extension/module/banner_image', $data);
	}
}