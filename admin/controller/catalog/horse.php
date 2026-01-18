<?php    
class ControllerCatalogHorse extends Controller { 
	private $error = array();

	public function index() {
		$this->language->load('catalog/horse');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/horse');

		$this->getList();
	}

	public function insert() {
		$this->language->load('catalog/horse');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/horse');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			if($this->request->post['trainer_id'] == ''){
				$trainer_id = $this->model_catalog_horse->gettrainerexist($this->request->post['trainer']);				
				$this->request->post['trainer_id'] = $trainer_id;
			}

			if(isset($this->request->post['owners'])){
				foreach ($this->request->post['owners'] as $okey => $ovalue) {
					if($ovalue['o_name'] == ''){
						$owner_id = $this->model_catalog_horse->gettrainerexist($ovalue['o_name']);				
						$this->request->post['owners'][$okey]['o_name_id'] = $owner_id;
					}	
				}
			}

			$this->model_catalog_horse->addhorse($this->request->post);

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

			$this->redirect($this->url->link('catalog/horse', 'token=' . $this->session->data['token'] . $url . '&filter_name=' . $this->request->post['name'], 'SSL'));
		}

		$this->getForm();
	}

	public function update() {
		$this->language->load('catalog/horse');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/horse');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			if($this->request->post['trainer_id'] == ''){
				$trainer_id = $this->model_catalog_horse->gettrainerexist($this->request->post['trainer']);				
				$this->request->post['trainer_id'] = $trainer_id;
			}

			if(isset($this->request->post['owners'])){
				foreach ($this->request->post['owners'] as $okey => $ovalue) {
					if($ovalue['o_name'] == ''){
						$owner_id = $this->model_catalog_horse->gettrainerexist($ovalue['o_name']);				
						$this->request->post['owners'][$okey]['o_name_id'] = $owner_id;
					}	
				}
			}

			$this->model_catalog_horse->edithorse($this->request->get['horse_id'], $this->request->post);

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
			if(isset($this->request->get['return'])){
				$this->redirect($this->url->link('report/horse_data', 'token=' . $this->session->data['token'].'&h_name='.$this->request->post['name'].'&h_name_id='.$this->request->get['horse_id'], 'SSL'));
			} else {
				$this->redirect($this->url->link('catalog/horse', 'token=' . $this->session->data['token'] . $url . '&filter_name=' . $this->request->post['name'] , 'SSL'));
			}
		}

		$this->getForm();
	}

	public function delete() {
		$this->language->load('catalog/horse');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/horse');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $horse_id) {
				$this->model_catalog_horse->deletehorse($horse_id);
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

			$this->redirect($this->url->link('catalog/horse', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		} elseif(isset($this->request->get['horse_id']) && $this->validateDelete()){
			$this->model_catalog_horse->deletehorse($this->request->get['horse_id']);

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

			$this->redirect($this->url->link('catalog/horse', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = '';
		}

		if (isset($this->request->get['filter_trainer'])) {
			$filter_trainer = $this->request->get['filter_trainer'];
		} else {
			$filter_trainer = '';
		}

		if (isset($this->request->get['filter_trainer_id'])) {
			$filter_trainer_id = $this->request->get['filter_trainer_id'];
		} else {
			$filter_trainer_id = '';
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

		if (isset($this->request->get['filter_trainer'])) {
			$url .= '&filter_trainer=' . $this->request->get['filter_trainer'];
		}

		if (isset($this->request->get['filter_trainer_id'])) {
			$url .= '&filter_trainer_id=' . $this->request->get['filter_trainer_id'];
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
			'href'      => $this->url->link('catalog/horse', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$this->data['insert'] = $this->url->link('catalog/horse/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('catalog/horse/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');	

		$this->data['horses'] = array();

		$data = array(
			'filter_name' => $filter_name,
			'filter_trainer' => $filter_trainer,
			'filter_trainer_id' => $filter_trainer_id,
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);

		$horse_total = $this->model_catalog_horse->getTotalhorses($data);

		$results = $this->model_catalog_horse->gethorses($data);

		foreach ($results as $result) {
			$action = array();

			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('catalog/horse/update', 'token=' . $this->session->data['token'] . '&horse_id=' . $result['horse_id'] . $url, 'SSL')
			);

			$action[] = array(
				'text' => $this->language->get('text_delete'),
				'href' => $this->url->link('catalog/horse/delete', 'token=' . $this->session->data['token'] . '&horse_id=' . $result['horse_id'] . $url, 'SSL')
			);

			$trainer_name = $this->model_catalog_horse->gettrainername($result['trainer']);

			$this->data['horses'][] = array(
				'horse_id' => $result['horse_id'],
				'name'            => $result['name'],
				'trainer_name'     => $trainer_name,
				'selected'        => isset($this->request->post['selected']) && in_array($result['horse_id'], $this->request->post['selected']),
				'action'          => $action
			);
		}

		$this->data['token'] = $this->session->data['token'];	

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_delete'] = $this->language->get('text_delete');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_trainer'] = $this->language->get('column_trainer');
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

		if (isset($this->request->get['filter_trainer'])) {
			$url .= '&filter_trainer=' . $this->request->get['filter_trainer'];
		}

		if (isset($this->request->get['filter_trainer_id'])) {
			$url .= '&filter_trainer_id=' . $this->request->get['filter_trainer_id'];
		}

		$this->data['sort_name'] = $this->url->link('catalog/horse', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
		$this->data['sort_trainer'] = $this->url->link('catalog/horse', 'token=' . $this->session->data['token'] . '&sort=trainer' . $url, 'SSL');

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

		if (isset($this->request->get['filter_trainer'])) {
			$url .= '&filter_trainer=' . $this->request->get['filter_trainer'];
		}

		if (isset($this->request->get['filter_trainer_id'])) {
			$url .= '&filter_trainer_id=' . $this->request->get['filter_trainer_id'];
		}

		$pagination = new Pagination();
		$pagination->total = $horse_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('catalog/horse', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;
		$this->data['filter_name'] = $filter_name;
		$this->data['filter_trainer'] = $filter_trainer;
		$this->data['filter_trainer_id'] = $filter_trainer_id;

		$this->template = 'catalog/horse_list.tpl';
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
		$this->data['entry_trainer'] = $this->language->get('entry_trainer');
		$this->data['entry_dob'] = $this->language->get('entry_dob');
		$this->data['entry_doj'] = $this->language->get('entry_doj');
		$this->data['entry_owner'] = $this->language->get('entry_owner');
		$this->data['entry_share'] = $this->language->get('entry_share');
		$this->data['entry_action'] = $this->language->get('entry_action');
		$this->data['entry_assign'] = $this->language->get('entry_assign');
		$this->data['entry_remove'] = $this->language->get('entry_remove');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['text_no_results'] = $this->language->get('text_no_results');

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

		if (isset($this->error['trainer'])) {
			$this->data['error_trainer'] = $this->error['trainer'];
		} else {
			$this->data['error_trainer'] = '';
		}

		if (isset($this->error['owner'])) {
			$this->data['error_owner'] = $this->error['owner'];
		} else {
			$this->data['error_owner'] = '';
		}

		if (isset($this->error['dob'])) {
			$this->data['error_dob'] = $this->error['dob'];
		} else {
			$this->data['error_dob'] = '';
		}

		if (isset($this->error['doj'])) {
			$this->data['error_doj'] = $this->error['doj'];
		} else {
			$this->data['error_doj'] = '';
		}

		if (isset($this->error['share_less'])) {
			$this->data['error_share_less'] = $this->error['share_less'];
		} else {
			$this->data['error_share_less'] = '';
		}

		if (isset($this->error['owners'])) {
			$this->data['error_owners'] = $this->error['owners'];
		} else {
			$this->data['error_owners'] = array();
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

		if (isset($this->request->get['filter_trainer'])) {
			$url .= '&filter_trainer=' . $this->request->get['filter_trainer'];
		}

		if (isset($this->request->get['filter_trainer_id'])) {
			$url .= '&filter_trainer_id=' . $this->request->get['filter_trainer_id'];
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('catalog/horse', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		if (isset($this->request->get['horse_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$horse_info = $this->model_catalog_horse->gethorse($this->request->get['horse_id']);
		}

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->request->post['name'])) {
			$this->data['name'] = $this->request->post['name'];
		} elseif (!empty($horse_info)) {
			$this->data['name'] = $horse_info['name'];
		} else {	
			$this->data['name'] = '';
		}

		if (!isset($this->request->get['horse_id'])) {
			$this->data['action'] = $this->url->link('catalog/horse/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			if(isset($this->request->get['return'])){
				$this->data['action'] = $this->url->link('catalog/horse/update', 'token=' . $this->session->data['token'] . '&horse_id=' . $this->request->get['horse_id'] . '&return=1', 'SSL');
			} else {
				$this->data['action'] = $this->url->link('catalog/horse/update', 'token=' . $this->session->data['token'] . '&horse_id=' . $this->request->get['horse_id'] . $url, 'SSL');
			}
		}

		if(isset($this->request->get['return'])){
			$this->data['cancel'] = $this->url->link('report/horse_data', 'token=' . $this->session->data['token'] . '&h_name=' . $this->data['name'] . '&h_name_id=' . $this->request->get['horse_id'], 'SSL');
		} else {
			$this->data['cancel'] = $this->url->link('catalog/horse', 'token=' . $this->session->data['token'] . $url, 'SSL');
		}
		
		$this->load->model('catalog/trainer');
		$this->data['trainers'] = $this->model_catalog_trainer->gettrainers();

		if (isset($this->request->post['trainer'])) {
			$this->data['trainer'] = $this->request->post['trainer'];
		} elseif (!empty($horse_info)) {
			$trainer_name = $this->model_catalog_horse->gettrainername($horse_info['trainer']);
			$this->data['trainer'] = $trainer_name;
		} else {	
			$this->data['trainer'] = '';
		}

		if (isset($this->request->post['trainer_id'])) {
			$this->data['trainer_id'] = $this->request->post['trainer_id'];
		} elseif (!empty($horse_info)) {
			$this->data['trainer_id'] = $horse_info['trainer'];
		} else {	
			$this->data['trainer_id'] = '';
		}

		if (isset($this->request->post['dob'])) {
			$this->data['dob'] = $this->request->post['dob'];
		} elseif (!empty($horse_info)) {
			$this->data['dob'] = $horse_info['dob'];
		} else {	
			$this->data['dob'] = '';
		}

		if (isset($this->request->post['doj'])) {
			$this->data['doj'] = $this->request->post['doj'];
		} elseif (!empty($horse_info)) {
			$this->data['doj'] = $horse_info['doj'];
		} else {	
			$this->data['doj'] = '';
		}

		$owners_assigned = array();
		if (isset($this->request->get['horse_id'])){
			$owners_assigned = $this->model_catalog_horse->getowners_assigned($this->request->get['horse_id']);
			foreach ($owners_assigned as $okey => $ovalue) {
				$owner_name = $this->model_catalog_horse->getownername($ovalue['owner']);
				$owners_assigned[$okey]['o_name'] = $owner_name;
				$owners_assigned[$okey]['o_name_id'] = $ovalue['owner'];
				$owners_assigned[$okey]['o_share'] = $ovalue['share'];
				unset($owners_assigned[$okey]['owner']);
				unset($owners_assigned[$okey]['share']);
			}
		}

		if (isset($this->request->post['owners'])) {
			$this->data['owners'] = $this->request->post['owners'];
		} elseif (!empty($owners_assigned)) {
			$this->data['owners'] = $owners_assigned;
		} else {	
			$this->data['owners'] = array();
		}		

		$this->template = 'catalog/horse_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}  

	protected function validateForm() {
		$this->load->model('catalog/horse');

		if (!$this->user->hasPermission('modify', 'catalog/horse')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if(strlen(utf8_decode(trim($this->request->post['name']))) < 1 || strlen(utf8_decode(trim($this->request->post['name']))) > 255){
			$this->error['name'] = $this->language->get('error_name');
		}

		if(strlen(utf8_decode(trim($this->request->post['trainer']))) < 1 || strlen(utf8_decode(trim($this->request->post['trainer']))) > 255){
			$this->error['trainer'] = $this->language->get('error_trainer');
		} else {
			$is_exist = $this->model_catalog_horse->gettrainerexist($this->request->post['trainer_id']);
			if($is_exist == 0){
				$this->error['trainer'] = $this->language->get('error_trainer_exist');
			}
		}

		if(isset($this->request->post['owners'])){
			$total_share = '';
			$i = 0;
			foreach ($this->request->post['owners'] as $okey => $ovalue) {
				if(strlen(utf8_decode(trim($ovalue['o_name']))) < 1 || strlen(utf8_decode(trim($ovalue['o_name']))) > 255){
					$this->error['owners'][$ovalue['o_field_row']]['owner_name'] = $this->language->get('error_owner_name'); 
				} else {
					$is_exist = $this->model_catalog_horse->getownerexist($ovalue['o_name_id']);
					if($is_exist == 0){
						$this->error['owners'][$ovalue['o_field_row']]['owner_name'] = $this->language->get('error_owner_exist');
					}
				}
				if(strlen(utf8_decode(trim($ovalue['o_share']))) < 1 || strlen(utf8_decode(trim($ovalue['o_share']))) > 255 || trim($ovalue['o_share']) == '0'){
					$this->error['owners'][$ovalue['o_field_row']]['owner_share'] =  $this->language->get('error_share_name');
				} 
				$total_share = $total_share + $ovalue['o_share'];
				$i++;
			}
			if($total_share < 100 || $total_share > 100){
				$this->error['share_less'] = $this->language->get('error_share');	
			}
		} else {
			$this->error['trainer'] = $this->language->get('error_owner');
		}

		//echo '<pre>';
		//print_r($this->error);
		//exit;

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/horse')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		$this->load->model('catalog/horse');

		// if(isset($this->request->post['selected'])){
		// 	foreach ($this->request->post['selected'] as $horse_id) {
		// 		$horse_total = $this->model_catalog_horse->getTotaltreatmentByhorseId($horse_id);

		// 		if ($horse_total) {
		// 			$this->error['warning'] = sprintf($this->language->get('error_horse'), $horse_total);
		// 		}	
		// 	}
		// } elseif(isset($this->request->get['horse_id'])){
		// 	$horse_total = $this->model_catalog_horse->getTotaltreatmentByhorseId($this->request->get['horse_id']);

		// 	if ($horse_total) {
		// 		$this->error['warning'] = sprintf($this->language->get('error_horse'), $horse_total);
		// 	}
		// }

		if (!$this->error) {
			return true;
		} else {
			return false;
		}  
	}

	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name'])) {
			$this->load->model('catalog/horse');

			$data = array(
				'filter_name' => $this->request->get['filter_name'],
				'start'       => 0,
				'limit'       => 20
			);

			$results = $this->model_catalog_horse->gethorses($data);

			foreach ($results as $result) {
				$json[] = array(
					'horse_id' => $result['horse_id'], 
					'name'            => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
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

	public function autocomplete_trainer() {
		$json = array();

		if (isset($this->request->get['filter_name'])) {
			$this->load->model('catalog/trainer');

			$data = array(
				'filter_name' => $this->request->get['filter_name'],
				'start'       => 0,
				'limit'       => 20
			);

			$results = $this->model_catalog_trainer->gettrainers($data);

			foreach ($results as $result) {
				$json[] = array(
					'trainer_id' => $result['trainer_id'], 
					'name'            => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
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

	public function autocomplete_owner() {
		$json = array();

		if (isset($this->request->get['filter_name'])) {
			$this->load->model('catalog/owner');

			$data = array(
				'filter_name' => $this->request->get['filter_name'],
				'start'       => 0,
				'limit'       => 20
			);

			$results = $this->model_catalog_owner->getowners($data);

			foreach ($results as $result) {
				$json[] = array(
					'owner_id' => $result['owner_id'], 
					'transaction_type' => $result['transaction_type'], 
					'owner_code' => '',//$result['owner_code'], 
					'name'            => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
				);
			}		
		}

		//$this->log->write(print_r($json,true));

		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->setOutput(json_encode($json));
	}	
}
?>
