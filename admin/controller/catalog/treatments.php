<?php    
class ControllercatalogTreatments extends Controller { 
	private $error = array();

	public function index() {
		$this->language->load('catalog/treatments');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/treatments');

		$this->getList();
	}

	public function insert() {
		$this->language->load('catalog/treatments');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/treatments');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_treatments->addtreatments($this->request->post);

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

			$this->redirect($this->url->link('catalog/treatments', 'token=' . $this->session->data['token'] . $url , 'SSL'));
		}

		$this->getForm();
	}

	public function update() {
		$this->language->load('catalog/treatments');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/treatments');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			//echo "<pre>";print_r($this->request->post);exit;
			$this->model_catalog_treatments->edittreatments($this->request->get['treatment_id'], $this->request->post);

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

			$this->redirect($this->url->link('catalog/treatments', 'token=' . $this->session->data['token'] . $url , 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->language->load('catalog/treatments');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/treatments');

		if(isset($this->request->get['treatment_id']) ){
			$this->model_catalog_treatments->deletetreatments($this->request->get['treatment_id']);

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

			$this->redirect($this->url->link('catalog/treatments', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = '';
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'name';
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

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('catalog/treatments', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$this->data['insert'] = $this->url->link('catalog/treatments/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('catalog/treatments/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');	

		$this->data['treatments'] = array();

		$data = array(
			'filter_name' => $filter_name,
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);

		$treatment_total = $this->model_catalog_treatments->getTotaltreatments($data);

		$results = $this->model_catalog_treatments->gettreatmentsdata($data);

		foreach ($results as $result) {
			$action = array();

			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('catalog/treatments/update', 'token=' . $this->session->data['token'] . '&treatment_id=' . $result['treatment_id'] . $url, 'SSL')
			);

			$action[] = array(
				'text' => $this->language->get('text_delete'),
				'href' => $this->url->link('catalog/treatments/delete', 'token=' . $this->session->data['token'] . '&treatment_id=' . $result['treatment_id'] . $url, 'SSL')
			);

			$this->data['treatments'][] = array(
				'treatment_id' => $result['treatment_id'],
				'name'            => $result['treatment_name'],
				'selected'        => isset($this->request->post['selected']) && in_array($result['treatment_id'], $this->request->post['selected']),
				'action'          => $action
			);
		}

		$this->data['token'] = $this->session->data['token'];	

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_delete'] = $this->language->get('text_delete');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_action'] = $this->language->get('column_action');		

		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');

		$this->data['button_filter'] = $this->language->get('button_filter');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
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

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}

		$this->data['sort_name'] = $this->url->link('catalog/treatments', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}

		$pagination = new Pagination();
		$pagination->total = $treatment_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('catalog/treatments', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		// $this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;
		$this->data['filter_name'] = $filter_name;

		$this->template = 'catalog/treatments_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function getForm() {
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_default'] = $this->language->get('text_default');
		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['tab_general'] = $this->language->get('tab_general');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$this->data['error_name'] = $this->error['name'];
		} else {
			$this->data['error_name'] = '';
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

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('catalog/treatments', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		if (!isset($this->request->get['treatment_id'])) {
			$this->data['action'] = $this->url->link('catalog/treatments/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('catalog/treatments/update', 'token=' . $this->session->data['token'] . '&treatment_id=' . $this->request->get['treatment_id'] . $url, 'SSL');
		}

		$this->data['cancel'] = $this->url->link('catalog/treatments', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['treatment_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$treatment_info = $this->model_catalog_treatments->gettreatments($this->request->get['treatment_id']);
		}

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->request->post['name'])) {
			$this->data['name'] = $this->request->post['name'];
		} elseif (!empty($treatment_info)) {
			$this->data['name'] = $treatment_info['treatment_name'];
		} else {	
			$this->data['name'] = '';
		}


		$this->template = 'catalog/treatments_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}  

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/treatments')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	// protected function validateDelete() {
	// 	//if (!$this->user->hasPermission('modify', 'catalog/trainer')) {
	// 		$this->error['warning'] = $this->language->get('error_permission');
	// 	//}

	// 	$this->load->model('catalog/treatments');

	// 	if(isset($this->request->post['selected'])){
	// 		foreach ($this->request->post['selected'] as $treatment_id) {
	// 			$horse_total = $this->model_catalog_treatments->gettreatments($treatment_id);

	// 			if ($horse_total) {
	// 				$this->error['warning'] = sprintf($this->language->get('error_treatments'), $horse_total);
	// 			}	
	// 		} 
	// 	} elseif(isset($this->request->get['treatment_id'])){
	// 		$horse_total = $this->model_catalog_treatments->gettreatments($this->request->get['treatment_id']);

	// 		if ($horse_total) {
	// 			$this->error['warning'] = sprintf($this->language->get('error_treatments'), $horse_total);
	// 		}
	// 	}

	// 	if (!$this->error) {
	// 		return true;
	// 	} else {
	// 		return false;
	// 	}  
	// }

	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name'])) {
			$this->load->model('catalog/treatments');

			$data = array(
				'filter_name' => $this->request->get['filter_name'],
				'start'       => 0,
				'limit'       => 20
			);

			$results = $this->model_catalog_treatments->gettreatmentsdata($data);
			// echo "<pre>";print_r($results);exit;
			foreach ($results as $result) {
				$json[] = array(
					'treatment_id' => $result['treatment_id'], 
					'name'            => strip_tags(html_entity_decode($result['treatment_name'], ENT_QUOTES, 'UTF-8'))
				);
			}		
		}

		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->setOutput(json_encode($json));
	}	
}
?>
