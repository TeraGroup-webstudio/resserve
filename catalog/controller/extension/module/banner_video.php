<?php
class ControllerExtensionModuleBannerVideo extends Controller {
	public function index($setting) {
		$this->load->language('extension/module/banner_video');
		
		if (isset($setting['module_description'][$this->config->get('config_language_id')])) {
			$data['subtitle'] = html_entity_decode($setting['module_description'][$this->config->get('config_language_id')]['subtitle'], ENT_QUOTES, 'UTF-8');
			$data['heading_title'] = html_entity_decode($setting['module_description'][$this->config->get('config_language_id')]['title'], ENT_QUOTES, 'UTF-8');
			$data['html'] = html_entity_decode($setting['module_description'][$this->config->get('config_language_id')]['description'], ENT_QUOTES, 'UTF-8');
		}
		if ($setting['image']) {
			$data['image'] = 'image/' . $setting['image'];
		} else {
			$data['image'] = '';
		}

		if ($setting['link']) {
			$data['link'] = $setting['link'];
		} else {
			$data['link'] = '';
		}

		if ($setting['link_video']) {
			$url = $setting['link_video'];
			if ( preg_match( "/(http|https):\/\/(www.youtube|youtube|youtu)\.(be|com)\/([^<\s]*)/", $url, $match ) ) {
			if ( preg_match( '/youtube\.com\/watch\?v=([^\&\?\/]+)/', $url, $id ) ) {
				$values = $id[1];
			} else if ( preg_match( '/youtube\.com\/embed\/([^\&\?\/]+)/', $url, $id ) ) {
				$values = $id[1];
			} else if ( preg_match( '/youtube\.com\/v\/([^\&\?\/]+)/', $url, $id ) ) {
				$values = $id[1];
			} else if ( preg_match( '/youtu\.be\/([^\&\?\/]+)/', $url, $id ) ) {
				$values = $id[1];
			} else if ( preg_match( '/youtube\.com\/verify_age\?next_url=\/watch%3Fv%3D([^\&\?\/]+)/', $url, $id ) ) {
				$values = $id[1]; 
			}
			}
			$data['link_video'] = $values;
		} else {
			$data['link_video'] = '';
		}

		return $this->load->view('extension/module/banner_video', $data);
	}
}