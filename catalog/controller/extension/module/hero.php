<?php
class ControllerExtensionModuleHero extends Controller {
	public function index($setting) {
        $this->load->model('tool/image');

        $this->document->addStyle('catalog/view/javascript/jquery/swiper-bundle/swiper-bundle.min.css');
        $this->document->addScript('catalog/view/javascript/jquery/swiper-bundle/swiper-bundle.min.js');

        $data['width'] = $setting['width'];

        $results = $setting['banner_image'];

        $data['banners'] = array();

		foreach ($results[(int)$this->config->get('config_language_id')] as $result) {
			if (is_file(DIR_IMAGE . $result['image'])) {
				$data['banners'][] = array(
					'title' => html_entity_decode($result['title'], ENT_QUOTES, 'UTF-8'),
					'link'  => $result['link'],
                    'link_text'  => $result['link_text'],
					'image' => $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height'])
				);
			}
		}

        $data['manufacturers'] = array();

        $this->load->model('catalog/manufacturer');
        $this->load->language('extension/module/hero');
        $data['text_all_manufacturer'] = $this->language->get('text_all_manufacturer');
        $data['text_manufacturer'] = $this->language->get('text_manufacturer');
        $data['link_manufacturer'] = $this->url->link('product/manufacturer', '', true);

        $results = $this->model_catalog_manufacturer->getManufacturers();

        foreach ($results as $result) {
            if ($result['image'] && is_file(DIR_IMAGE . $result['image'])) {
                $image = $this->model_tool_image->resize($result['image'], 140,120);
                //$image = 'image/'.$result['image'];
            } else {
                $image = $this->model_tool_image->resize('no_image.png', 140, 120);
            }

            $data['manufacturers'][] = array(
                'name' => $result['name'],
                'href' => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $result['manufacturer_id']),
                'image' =>$image
            );
        }

        return $this->load->view('extension/module/hero', $data);
	}
}