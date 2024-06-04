<?php
// *	@copyright	OPENCART.PRO 2011 - 2016.
// *	@forum	http://forum.opencart.pro
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerStepStep3 extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('step/step3');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('step/step3');

		$this->getList();
	}

	public function add() {
		$this->load->language('step/step3');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('step/step3');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_step_step3->addStep($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('step/step3', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('step/step3');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('step/step3');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_step_step3->editStep($this->request->get['step3_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('step/step3', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('step/step3');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('step/step3');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $step_id) {
				$this->model_step_step3->deleteStep($step_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('step/step3', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'title';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('step/step3', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);

		$data['add'] = $this->url->link('step/step3/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		$data['delete'] = $this->url->link('step/step3/delete', 'user_token=' . $this->session->data['user_token'] . $url, true);
        $this->load->model('tool/image');
		$data['steps'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$step_total = $this->model_step_step3->getTotalStep();

		$results = $this->model_step_step3->getSteps($filter_data);

		foreach ($results as $result) {
            if (is_file(DIR_IMAGE . $result['image'])) {
                $image = $this->model_tool_image->resize($result['image'], 40, 40);
            } else {
                $image = $this->model_tool_image->resize('no_image.png', 40, 40);
            }
			$data['steps'][] = array(
				'step3_id' => $result['step3_id'],
				'title'           => $result['title'],
				'image'            => $image,
				'edit'            => $this->url->link('step/step3/edit', 'user_token=' . $this->session->data['user_token'] . '&step3_id=' . $result['step3_id'] . $url, true)
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_title'] = $this->language->get('column_title');
		$data['column_image'] = $this->language->get('column_image');
		$data['column_action'] = $this->language->get('column_action');

		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_title'] = $this->url->link('step/step3', 'user_token=' . $this->session->data['user_token'] . '&sort=title' . $url, true);


		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $step_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('step/step3', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($step_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($step_total - $this->config->get('config_limit_admin'))) ? $step_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $step_total, ceil($step_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('step/step3_list', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['step3_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

		$data['text_none'] = $this->language->get('text_none');
		$data['entry_title'] = $this->language->get('entry_title');
		$data['entry_image'] = $this->language->get('entry_image');
		$data['entry_list_step2'] = $this->language->get('entry_list_step2');
		$data['entry_url'] = $this->language->get('entry_url');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['title'])) {
			$data['error_title'] = $this->error['title'];
		} else {
			$data['error_title'] = array();
		}

		if (isset($this->error['unit'])) {
			$data['error_unit'] = $this->error['unit'];
		} else {
			$data['error_unit'] = array();
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('step/step3', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);

		if (!isset($this->request->get['step3_id'])) {
			$data['action'] = $this->url->link('step/step3/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('step/step3/edit', 'user_token=' . $this->session->data['user_token'] . '&step3_id=' . $this->request->get['step3_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('step/step3', 'user_token=' . $this->session->data['user_token'] . $url, true);

		if (isset($this->request->get['step3_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$step_info = $this->model_step_step3->getStep($this->request->get['step3_id']);
		}

		$data['list_step2'] = array();

        $data['list_step2'] = $this->model_step_step3->getStep2();

		$this->load->model('localisation/language');

        if (isset($this->request->post['step2_id'])) {
            $data['step2_id'] = $this->request->post['step2_id'];
        } elseif (!empty($step_info)) {
            $data['step2_id'] = $step_info['step2_id'];
        } else {
            $data['step2_id'] = 0;
        }

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['step_description'])) {
			$data['step_description'] = $this->request->post['step_description'];
		} elseif (isset($this->request->get['step3_id'])) {
			$data['step_description'] = $this->model_step_step3->getStepDescriptions($this->request->get['step3_id']);
		} else {
			$data['step_description'] = array();
		}

        if (isset($this->request->post['image'])) {
            $data['image'] = $this->request->post['image'];
        } elseif (!empty($step_info)) {
            $data['image'] = $step_info['image'];
        } else {
            $data['image'] = '';
        }

        $this->load->model('tool/image');

        if (isset($this->request->post['image']) && is_file(DIR_IMAGE . $this->request->post['image'])) {
            $data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
        } elseif (!empty($step_info) && is_file(DIR_IMAGE . $step_info['image'])) {
            $data['thumb'] = $this->model_tool_image->resize($step_info['image'], 100, 100);
        } else {
            $data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
        }

        $data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('step/step3_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'step/step3')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['step_description'] as $language_id => $value) {
			if ((utf8_strlen($value['title']) < 3) || (utf8_strlen($value['title']) > 32)) {
				$this->error['title'][$language_id] = $this->language->get('error_title');
			}
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'step/step3')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}


		foreach ($this->request->post['selected'] as $step_id) {
			if ($this->config->get('step3_id') == $step_id) {
				$this->error['warning'] = $this->language->get('error_default');
			}


		}

		return !$this->error;
	}
}