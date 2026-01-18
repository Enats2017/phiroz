<?php    
class ControllerTransactionDebit extends Controller { 
	private $error = array();

	public function index() {
		$this->language->load('transaction/debit');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('transaction/debit');

		$this->getList();
	}

	public function insert() {
		$this->language->load('transaction/debit');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('transaction/debit');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_transaction_debit->addowner($this->request->post);

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

			$this->redirect($this->url->link('transaction/debit', 'token=' . $this->session->data['token'] . $url . '&filter_name=' . $this->request->post['name'], 'SSL'));
		}

		$this->getForm();
	}

	public function update() {
		$this->language->load('transaction/debit');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('transaction/debit');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_transaction_debit->editowner($this->request->get['owner_id'], $this->request->post);

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

			$this->redirect($this->url->link('transaction/debit', 'token=' . $this->session->data['token'] . $url . '&filter_name=' . $this->request->post['name'], 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->language->load('transaction/debit');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('transaction/debit');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $owner_id) {
				$this->model_transaction_debit->deleteowner($owner_id);
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

			$this->redirect($this->url->link('transaction/debit', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		} elseif(isset($this->request->get['owner_id']) && $this->validateDelete()){
			$this->model_transaction_trainer->deleteowner($this->request->get['owner_id']);

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

			$this->redirect($this->url->link('transaction/debit', 'token=' . $this->session->data['token'] . $url, 'SSL'));
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
			'href'      => $this->url->link('transaction/debit', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$this->data['insert'] = $this->url->link('transaction/debit/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('transaction/debit/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');	

		$this->data['owners'] = array();

		$data = array(
			'filter_responsible_person' => $filter_name,
			'filter_status_all' => 1,
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);

		$owner_total = $this->model_transaction_debit->getTotalowners($data);

		$results = $this->model_transaction_debit->getowners($data);


		foreach ($results as $result) {
			$action = array();

			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('transaction/debit/update', 'token=' . $this->session->data['token'] . '&owner_id=' . $result['owner_id'] . $url, 'SSL')
			);

			$action[] = array(
				'text' => $this->language->get('text_delete'),
				'href' => $this->url->link('transaction/debit/delete', 'token=' . $this->session->data['token'] . '&owner_id=' . $result['owner_id'] . $url, 'SSL')
			);

			$this->data['owners'][] = array(
				'owner_id' => $result['owner_id'],
				'responsible_person' => $result['owner_name'],
				'amount'          => $result['debit_amount'],
				'comment'         => $result['comment'],
				'selected'        => isset($this->request->post['selected']) && in_array($result['owner_id'], $this->request->post['selected']),
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

		$this->data['sort_name'] = $this->url->link('transaction/debit', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');

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
		$pagination->total = $owner_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('transaction/debit', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;
		$this->data['filter_name'] = $filter_name;

		$this->template = 'transaction/debit_list.tpl';
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
		$this->data['entry_transaction_type'] = $this->language->get('entry_transaction_type');
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

		if (isset($this->error['responsible_person'])) {
			$this->data['error_responsible_person'] = $this->error['responsible_person'];
		} else {
			$this->data['error_responsible_person'] = '';
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
			'href'      => $this->url->link('transaction/debit', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		if (!isset($this->request->get['owner_id'])) {
			$this->data['action'] = $this->url->link('transaction/debit/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('transaction/debit/update', 'token=' . $this->session->data['token'] . '&owner_id=' . $this->request->get['owner_id'] . $url, 'SSL');
		}

		$this->data['cancel'] = $this->url->link('transaction/debit', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['owner_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$owner_info = $this->model_transaction_debit->getowner($this->request->get['owner_id']);
		}

		$this->data['token'] = $this->session->data['token'];

		
		if (isset($this->request->post['responsible_person'])) {
			$this->data['responsible_person'] = $this->request->post['responsible_person'];
		} elseif (!empty($owner_info)) {
			$this->data['responsible_person'] = $owner_info['responsible_person'];
		} else {	
			$this->data['responsible_person'] = '';
		}

		if (isset($this->request->post['responsible_person_id'])) {
			$this->data['responsible_person_id'] = $this->request->post['responsible_person_id'];
		} elseif (!empty($owner_info)) {
			$this->data['responsible_person_id'] = $owner_info['responsible_person_id'];
		} else {	
			$this->data['responsible_person_id'] = '';
		}


		if (isset($this->request->post['amount'])) {
			$this->data['amount'] = $this->request->post['amount'];
		} elseif (!empty($owner_info)) {
			$this->data['amount'] = $owner_info['amount'];
		} else {	
			$this->data['amount'] = '';
		}
		if (isset($this->request->post['comment'])) {
			$this->data['comment'] = $this->request->post['comment'];
		} elseif (!empty($owner_info)) {
			$this->data['comment'] = $owner_info['comment'];
		} else {	
			$this->data['comment'] = '';
		}


		if (isset($this->request->post['opening_balance'])) {
			$this->data['opening_balance'] = $this->request->post['opening_balance'];
		} elseif (!empty($owner_info)) {
			$this->data['opening_balance'] = $owner_info['opening_balance'];
		} else {	
			$this->data['opening_balance'] = '';
		}

		
		// $this->data['transaction_types'] = array(
		// 	'1' => 'Phiroz Khambatta',
		// 	'2' => 'P.T Khambatta',
		// 	'3' => 'P.T Mumbai',
		// 	'4' => 'P.T Pune'
		// );

		$this->template = 'transaction/debit_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}  

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'transaction/debit')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		// if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 512)) {
		// 	$this->error['name'] = $this->language->get('error_name');
		// }

		// if(isset($this->request->post['name'])){
		// $is_exist = $this->db->query("SELECT *  FROM " . DB_PREFIX . "owner WHERE LOWER(name) = '" . $this->db->escape(strtolower($this->request->post['name'])) . "'")->rows;
		// 	if($is_exist){
		// 		$this->error['name'] = 'Employee Name Exists';	
		//  	}
		// }
		// if(isset($this->request->post['name'])){
		// $is_exist = $this->db->query("SELECT *  FROM " . DB_PREFIX . "debit WHERE LOWER(name) = '" . $this->db->escape(strtolower($this->request->post['name'])) . "'")->rows;
		// 	if($is_exist){
		// 		$this->error['name'] = 'Employee Name Exists';	
		//  	}
		// }

		

		if ((utf8_strlen($this->request->post['responsible_person']) < 3) || (utf8_strlen($this->request->post['responsible_person']) > 512)) {
			$this->error['responsible_person'] = 'Please Enter Responsible Person Name';
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	protected function validateDelete() {
		//if (!$this->user->hasPermission('modify', 'catalog/owner')) {
			$this->error['warning'] = $this->language->get('error_permission');
		//}

		$this->load->model('catalog/horse');
		if(isset($this->request->post['selected'])){
			foreach ($this->request->post['selected'] as $owner_id) {
				$horse_total = $this->model_catalog_horse->getTotalhorsesByownerId($owner_id);

				if ($horse_total) {
					$this->error['warning'] = sprintf($this->language->get('error_horse'), $horse_total);
				}
			}	
		} elseif(isset($this->request->get['owner_id'])){
			$horse_total = $this->model_catalog_horse->getTotalhorsesByownerId($this->request->get['owner_id']);

			if ($horse_total) {
				$this->error['warning'] = sprintf($this->language->get('error_horse'), $horse_total);
			}
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}  
	}

	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name_1'])) {
			$this->load->model('transaction/debit');

			$data = array(
				'filter_responsible_person' => $this->request->get['filter_name_1'],
				'start'       => 0,
				'limit'       => 20,
			);

			$results = $this->model_transaction_debit->getowners($data);

			foreach ($results as $result) {
				$json[] = array(
					'owner_id' => $result['owner_id'], 
					'name'            => strip_tags(html_entity_decode($result['owner_name'], ENT_QUOTES, 'UTF-8')),
					
				);
			}		
			$sort_order = array();

			foreach ($json as $key => $value) {
				$sort_order[$key] = $value['name'];
			}
		} 

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->setOutput(json_encode($json));
	}

	public function autocomplete_responsible() {
		$json = array();

		if (isset($this->request->get['filter_name_1'])) {
			$this->load->model('transaction/debit');

			$data = array(
				'filter_responsible_person' => $this->request->get['filter_name_1'],
				'start'       => 0,
				'limit'       => 20
			);
			$results = $this->model_transaction_debit->getowners($data);
		// 	echo '<pre>';
		// print_r($results);
		// exit;
			foreach ($results as $result) {
				$json[] = array(
					'responsible_person_id' => $result['responsible_person_id'], 
					'responsible_person'            => strip_tags(html_entity_decode($result['responsible_person'], ENT_QUOTES, 'UTF-8')),
				);
			}		
			$sort_order = array();
			foreach ($json as $key => $value) {
				$sort_order[$key] = $value['responsible_person'];
			}
		}
		array_multisort($sort_order, SORT_ASC, $json);
		$this->response->setOutput(json_encode($json));
	}	
}
?>
