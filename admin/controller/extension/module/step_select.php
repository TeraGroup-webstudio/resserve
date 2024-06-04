<?php
// *	@copyright	OPENCART.PRO 2011 - 2016.
// *	@forum	http://forum.opencart.pro
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerExtensionModuleStepSelect extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/step_select');

		$this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('tool/image');
        $this->load->model('setting/module');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if (!isset($this->request->get['module_id'])) {
				$this->model_setting_module->addModule('step_select', $this->request->post);
			} else {
				$this->model_setting_module->editModule($this->request->get['module_id'], $this->request->post);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['entry_text'] = $this->language->get('entry_text');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_title'] = $this->language->get('entry_title');
		$data['entry_description'] = $this->language->get('entry_description');
		$data['entry_status'] = $this->language->get('entry_status');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['tab_step1'] = $this->language->get('tab_step1');
		$data['tab_step2'] = $this->language->get('tab_step2');
		$data['tab_step3'] = $this->language->get('tab_step3');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		);

		if (!isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/step_select', 'user_token=' . $this->session->data['user_token'], true)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/step_select', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true)
			);
		}

		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('extension/module/step_select', 'user_token=' . $this->session->data['user_token'], true);
		} else {
			$data['action'] = $this->url->link('extension/module/step_select', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true);
		}

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

        $data['url_step1'] = $this->url->link('step/step1', 'user_token=' . $this->session->data['user_token'], true);
        $data['url_step2'] = $this->url->link('step/step2', 'user_token=' . $this->session->data['user_token'], true);
        $data['url_step3'] = $this->url->link('step/step3', 'user_token=' . $this->session->data['user_token'], true);

        $data['module_list_step1'] = array();
        $data['module_list_step2'] = array();
        $data['module_list_step3'] = array();
		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_setting_module->getModule($this->request->get['module_id']);
		}
        $data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($module_info)) {
			$data['name'] = $module_info['name'];
		} else {
			$data['name'] = '';
		}
//print_r($module_info['module_list_step1']);
        if (isset($this->request->post['module_list_step1'])) {
			$data['module_list_step1'] = $this->request->post['module_list_step1'];
		} elseif (isset($module_info['module_list_step1'])) {
			//$data['module_list_step1'] = $module_info['module_list_step1'];
            foreach ($module_info['module_list_step1'] as $item){
                //print_r($item['info']);
                foreach($item['info'] as $k=>$i){
                    //print_r($i);
                    $module_step1['info'][$k] = $i;
                }

                if($item['image']){
                    $thumb = $this->model_tool_image->resize($item['image'], 100, 100);
                } else {
                    $thumb = $this->model_tool_image->resize('no_image.png', 100, 100);;
                }


                $data['module_list_step1'][] = array(
                    $module_step1,
                    'image' => $item['image'],
                    'thumb' =>$thumb
                );

            }
		} else {
			$data['module_list_step1'] = array();
		}
        //print_r($data['module_list_step1']);
        if (isset($this->request->post['class'])) {
            $data['class'] = $this->request->post['class'];
        } elseif (!empty($module_info)) {
            $data['class'] = $module_info['class'];
        } else {
            $data['class'] = '';
        }


		if (isset($this->request->post['module_description'])) {
			$data['module_description'] = $this->request->post['module_description'];
		} elseif (!empty($module_info)) {
			$data['module_description'] = $module_info['module_description'];
		} else {
			$data['module_description'] = array();
		}

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($module_info)) {
			$data['status'] = $module_info['status'];
		} else {
			$data['status'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/step_select', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/step_select')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		return !$this->error;
	}
}