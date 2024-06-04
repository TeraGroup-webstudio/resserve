<?php
// *	@copyright	OPENCART.PRO 2011 - 2016.
// *	@forum	http://forum.opencart.pro
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerExtensionModuleStepSelect extends Controller {
	public function index($setting) {
        $this->load->language('extension/module/step_select');

        $data['heading_title'] = $this->language->get('heading_title');
        $data['heading_note'] = $this->language->get('heading_note');
        $data['text_step1'] = $this->language->get('text_step1');
        $data['text_step2'] = $this->language->get('text_step2');
        $data['text_step3'] = $this->language->get('text_step3');
        $this->document->addStyle('catalog/view/javascript/jquery/swiper-bundle/swiper-bundle.min.css');
        $this->document->addScript('catalog/view/javascript/jquery/swiper-bundle/swiper-bundle.min.js');
        // list step 1
        $data['list_step_1'] = array();

        if($this->getStep1()){
            foreach ($this->getStep1() as $step1){
                if (is_file(DIR_IMAGE . $step1['image'])) {
                    $image = $this->model_tool_image->cropsize($step1['image'], 320, 320);
                } else {
                    $image = $this->model_tool_image->cropsize('no_image.png', 320, 320);
                }
                $data['list_step_1'][] = array(
                    'step1_id' => $step1['step1_id'],
                    'title' => $step1['title'],
                    'image' => $image
                );
            }
        }



        //$data['html'] = html_entity_decode($setting['module_description'][$this->config->get('config_language_id')]['description'], ENT_QUOTES, 'UTF-8');
        $data['class'] = $setting['class'];


        return $this->load->view('extension/module/step_select', $data);

	}

	public function step2(){
        $data['list_step_2'] = array();
	    if($this->request->get['article_step_1']){
	        $list = $this->listStep2($this->request->get['article_step_1']);
            if($list){
                foreach ($list as $step1){
                    if (is_file(DIR_IMAGE . $step1['image'])) {
                        $image = $this->model_tool_image->cropsize($step1['image'], 320, 320);
                    } else {
                        $image = $this->model_tool_image->cropsize('no_image.png', 320, 320);
                    }
                    $data['list_step_2'][] = array(
                        'step2_id' => $step1['step2_id'],
                        'title' => $step1['title'],
                        'image' => $image
                    );
                }

            }

            //return $this->load->view('extension/module/step_select_step2', $data);
            return $this->response->setOutput($this->load->view('extension/module/step_select_step2', $data));
        }
    }

    public function step3(){
        $data['list_step_3'] = array();
        if($this->request->get['article_step_2']){
            $list = $this->listStep3($this->request->get['article_step_2']);
            if($list){

                foreach ($list as $step2){
                    if (is_file(DIR_IMAGE . $step2['image'])) {
                        $image = $this->model_tool_image->cropsize($step2['image'], 320, 320);
                    } else {
                        $image = $this->model_tool_image->cropsize('no_image.png', 320, 320);
                    }
                    $data['list_step_3'][] = array(
                        'step2_id' => $step2['step2_id'],
                        'title' => $step2['title'],
                        'url' => $step2['url'],
                        'image' => $image
                    );
                }

            }

            //return $this->load->view('extension/module/step_select_step2', $data);
            return $this->response->setOutput($this->load->view('extension/module/step_select_step3', $data));
        }
    }


    public function getStep1() {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "step1 s LEFT JOIN " . DB_PREFIX . "step1_description sd ON (s.step1_id = sd.step1_id) WHERE sd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

        return $query->rows;
    }

    private function listStep2($step1_id){
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "step2 s LEFT JOIN " . DB_PREFIX . "step2_description sd ON (s.step2_id = sd.step2_id) WHERE s.step1_id = '".(int)$step1_id."' AND sd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

        return $query->rows;
    }

    private function listStep3($step2_id){
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "step3 s LEFT JOIN " . DB_PREFIX . "step3_description sd ON (s.step3_id = sd.step3_id) WHERE s.step2_id = '".(int)$step2_id."' AND sd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

        return $query->rows;
    }

}