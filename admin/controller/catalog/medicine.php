<?php    
class ControllerCatalogMedicine extends Controller { 
	private $error = array();

	public function index() {
		$this->language->load('catalog/medicine');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/medicine');

		$this->getList();
	}

	public function insert() {
		$this->language->load('catalog/medicine');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/medicine');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_medicine->addmedicine($this->request->post);

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

			$this->redirect($this->url->link('catalog/medicine', 'token=' . $this->session->data['token'] . $url . '&filter_name=' . $this->request->post['name'], 'SSL'));
		}

		$this->getForm();
	}

	public function update() {
		$this->language->load('catalog/medicine');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/medicine');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_medicine->editmedicine($this->request->get['medicine_id'], $this->request->post);

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

			$this->redirect($this->url->link('catalog/medicine', 'token=' . $this->session->data['token'] . $url . '&filter_name=' . $this->request->post['name'], 'SSL'));
		}

		$this->getForm();
	}


	public function save(){

// 		$this->document->setTitle($this->language->get('heading_title'));

// 		$this->load->model('catalog/medicine');
// 		// print_r($this->request->get);
// 		// exit();
// 		// $this->language->load('catalog/medicine');

// 		// echo "<pre>";
// 		// print_r($this->request->get['medicine_id']);
// 		// exit();

// 		// $this->document->setTitle($this->language->get('heading_title'));

// 		// $this->load->model('catalog/medicine');

// 		//  echo $this->request->post['rate'];
// 		//  exit();

// 		// if (isset($this->request->get['medicine_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
// 		// 	//$medicine_info = $this->model_catalog_medicine->getmedicine($this->request->get['medicine_id']);
// 		// 	$this->data['rate'] = $this->request->post['rate'];
// 		// 	print_r($this->data['rate']);
// 		// 	exit();
// 		// 	// $this->log->write($this->db->query("UPDATE oc_medicine SET rate = '".$this->data['rate']."' WHERE medicine_id = '".$this->request->get['medicine_id']."'"));
// 		// 	// $s = $this->db->query("UPDATE oc_medicine SET rate = '".$this->data['rate']."' WHERE medicine_id = '".$this->request->get['medicine_id']."'");
// 		// }

// 		// // $this->data['token'] = $this->session->data['token'];

// 		// // if (isset($this->request->post['volume'])) {
// 		// // 	$this->data['volume'] = $this->request->post['volume'];
// 		// // } elseif (!empty($medicine_info)) {
// 		// // 	$this->data['volume'] = $medicine_info['volume'];
// 		// // } else {	
// 		// // 	$this->data['volume'] = '';
// 		// // }

// 		// // $this->redirect($this->url->link('catalog/medicine', 'token=' . $this->session->data['token'] . $url, 'SSL'));

// 		$this->language->load('catalog/medicine');

// 		$this->document->setTitle($this->language->get('heading_title'));

// 		$this->load->model('catalog/medicine');

// 		if (isset($this->request->post['selected'])) {
// 			echo "in";
// 			exit();
// }
// 		// 	foreach ($this->request->post['selected'] as $medicine_id) {
// 		// 		$this->model_catalog_medicine->deletemedicine($medicine_id);
// 		// 	}

// 		// 	$this->session->data['success'] = $this->language->get('text_success');

// 		// 	$url = '';

// 		// 	if (isset($this->request->get['sort'])) {
// 		// 		$url .= '&sort=' . $this->request->get['sort'];
// 		// 	}

// 		// 	if (isset($this->request->get['order'])) {
// 		// 		$url .= '&order=' . $this->request->get['order'];
// 		// 	}

// 		// 	if (isset($this->request->get['page'])) {
// 		// 		$url .= '&page=' . $this->request->get['page'];
// 		// 	}

// 		// 	$this->redirect($this->url->link('catalog/medicine', 'token=' . $this->session->data['token'] . $url, 'SSL'));
// 		// } elseif(isset($this->request->get['medicine_id']) && $this->validateDelete()){
// 		// 	$this->model_catalog_medicine->deletemedicine($this->request->get['medicine_id']);

// 		// 	$this->session->data['success'] = $this->language->get('text_success');

// 		// 	$url = '';

// 		// 	if (isset($this->request->get['sort'])) {
// 		// 		$url .= '&sort=' . $this->request->get['sort'];
// 		// 	}

// 		// 	if (isset($this->request->get['order'])) {
// 		// 		$url .= '&order=' . $this->request->get['order'];
// 		// 	}

// 		// 	if (isset($this->request->get['page'])) {
// 		// 		$url .= '&page=' . $this->request->get['page'];
// 		// 	}

// 		// 	$this->redirect($this->url->link('catalog/medicine', 'token=' . $this->session->data['token'] . $url, 'SSL'));
// 		// }

// 		// $this->getList();

		$this->language->load('catalog/medicine');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/medicine');

		print_r($this->request->post);
		exit();

		if (isset($this->request->post['selected'])) {
			foreach ($this->request->post['selected'] as $medicine_id) {
				$this->model_catalog_medicine->deletemedicine($medicine_id);
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

			$this->redirect($this->url->link('catalog/medicine', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		} elseif(isset($this->request->get['medicine_id']) && $this->validateDelete()){
			$this->model_catalog_medicine->deletemedicine($this->request->get['medicine_id']);

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

			$this->redirect($this->url->link('catalog/medicine', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();

	}

	public function insert_update() {
		$this->language->load('catalog/medicine');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/medicine');

		// echo '<pre>';
		// 	print_r($this->request->post);
		// 	exit;

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $medicine_id) {
				$this->model_catalog_medicine->deletemedicine($medicine_id);
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

			$this->redirect($this->url->link('catalog/medicine', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		} elseif(isset($this->request->get['medicine_id']) && $this->validateDelete()){
			$this->model_catalog_medicine->deletemedicine($this->request->get['medicine_id']);

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

			$this->redirect($this->url->link('catalog/medicine', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		} else {
			// echo '<pre>';
			// print_r($this->request->post);
			// exit;
			if(isset($this->request->post['medicine_datas'])){
				foreach($this->request->post['medicine_datas'] as $mkey => $mvalue){
					//echo "UPDATE oc_medicine SET `rate` = '".$mvalue['rate']."', `cost` = '".$mvalue['cost']."', `volume` = '".$mvalue['volume']."', `category` = '".$mvalue['category']."' WHERE medicine_id = '".$mvalue['medicine_id']."'";exit;
					$this->db->query("UPDATE oc_medicine SET `rate` = '".$mvalue['rate']."', `cost` = '".$mvalue['cost']."', `volume` = '".$mvalue['volume']."', `category` = '".$mvalue['category']."' WHERE medicine_id = '".$mvalue['medicine_id']."'");
				}
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

			$this->session->data['success'] = 'Data Updated Successfully';
			$this->redirect($this->url->link('catalog/medicine', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		echo 'out';exit;

		//$this->getList();
	}

	protected function getList() {

		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = '';
		}

		if (isset($this->request->get['filter_doctor'])) {
			$filter_doctor = $this->request->get['filter_doctor'];
		} else {
			$filter_doctor = '';
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

		if (isset($this->request->get['filter_doctor'])) {
			$url .= '&filter_doctor=' . $this->request->get['filter_doctor'];
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
			'href'      => $this->url->link('catalog/medicine', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$this->data['insert'] = $this->url->link('catalog/medicine/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['insert_update'] = $this->url->link('catalog/medicine/insert_update', 'token=' . $this->session->data['token'] . $url, 'SSL');	
		$this->data['export'] = $this->url->link('catalog/medicine/export', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$this->data['medicines'] = array();

		$data = array(
			'filter_name' => $filter_name,
			'filter_doctor' => $filter_doctor,
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);

		$medicine_total = $this->model_catalog_medicine->getTotalmedicines($data);

		$results = $this->model_catalog_medicine->getmedicines($data);

		foreach ($results as $result) {
			$action = array();

			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('catalog/medicine/update', 'token=' . $this->session->data['token'] . '&medicine_id=' . $result['medicine_id'] . $url, 'SSL')
			);

			$action[] = array(
				'text' => $this->language->get('text_delete'),
				'href' => $this->url->link('catalog/medicine/delete', 'token=' . $this->session->data['token'] . '&medicine_id=' . $result['medicine_id'] . $url, 'SSL')
			);

			$action[] = array(
				'text' => $this->language->get('Save'),
				'href' => $this->url->link('catalog/medicine/save', 'token=' . $this->session->data['token'] . '&medicine_id=' . $result['medicine_id'] . $url, 'SSL')
			);

			$doctor_name = $this->model_catalog_medicine->getdoctorname($result['doctor']);

			$this->data['medicines'][] = array(
				'medicine_id'     => $result['medicine_id'],
				'name'            => $result['name'],
				'rate'			  => $result['rate'],
				'service'			  => $result['service'],
				'cost'			  => $result['cost'],
				'category'		  => $result['category'],
				'volume'		  => $result['volume'],
				'doctor_name'     => $doctor_name,
				'selected'        => isset($this->request->post['selected']) && in_array($result['medicine_id'], $this->request->post['selected']),
				'action'          => $action
			);
		}


		$this->data['doctors'] = $this->model_catalog_medicine->getdoctors();

		$this->data['token'] = $this->session->data['token'];	

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_delete'] = $this->language->get('text_delete');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_doctor'] = $this->language->get('column_doctor');
		$this->data['column_action'] = $this->language->get('column_action');		

		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');

		$this->data['button_filter'] = $this->language->get('button_filter');

		$this->data['categories'] = array(
			'RL' => 'RL',
			'Antibiotics' => 'Antibiotics',
			'Pentosan' => 'Pentosan',
			'Surgery' => 'Surgery',
			'Pickups' => 'Pickups',
			'Amino' => 'Amino',
			'Dentistry' => 'Dentistry',
			'Physiotheraphy' => 'Physiotheraphy',
			'Ultrasound' => 'Ultrasound',
			'Diagnostics' => 'Diagnostics',
			'Acupuncture' => 'Acupuncture',
			'Treadmill' => 'Treadmill',
			'Nebulizer' => 'Nebulizer',
			'Shockwave' => 'Shockwave',
		);

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

		if (isset($this->request->get['filter_doctor'])) {
			$url .= '&filter_doctor=' . $this->request->get['filter_doctor'];
		}

		$this->data['sort_name'] = $this->url->link('catalog/medicine', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
		$this->data['sort_doctor'] = $this->url->link('catalog/medicine', 'token=' . $this->session->data['token'] . '&sort=doctor' . $url, 'SSL');

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

		if (isset($this->request->get['filter_doctor'])) {
			$url .= '&filter_doctor=' . $this->request->get['filter_doctor'];
		}

		$pagination = new Pagination();
		$pagination->total = $medicine_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('catalog/medicine', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;
		$this->data['filter_name'] = $filter_name;
		$this->data['filter_doctor'] = $filter_doctor;

		$this->template = 'catalog/medicine_list.tpl';
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
		$this->data['entry_doctor'] = $this->language->get('entry_doctor');
		$this->data['entry_rate'] = $this->language->get('entry_rate');
		$this->data['entry_quantity'] = $this->language->get('entry_quantity');
		$this->data['entry_travel_sheet'] = $this->language->get('entry_travel_sheet');
		$this->data['entry_service'] = $this->language->get('entry_service');
		$this->data['entry_sirin'] = $this->language->get('entry_sirin');

		
		
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

		if (isset($this->error['doctor'])) {
			$this->data['error_doctor'] = $this->error['doctor'];
		} else {
			$this->data['error_doctor'] = '';
		}

		if (isset($this->error['rate'])) {
			$this->data['error_rate'] = $this->error['rate'];
		} else {
			$this->data['error_rate'] = '';
		}

		if (isset($this->error['service'])) {
			$this->data['error_service'] = $this->error['service'];
		} else {
			$this->data['error_service'] = '';
		}

		if (isset($this->error['quantity'])) {
			$this->data['error_quantity'] = $this->error['quantity'];
		} else {
			$this->data['error_quantity'] = '';
		}

		if (isset($this->error['sirin'])) {
			$this->data['error_sirin'] = $this->error['sirin'];
		} else {
			$this->data['error_sirin'] = '';
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

		if (isset($this->request->get['filter_doctor'])) {
			$url .= '&filter_doctor=' . $this->request->get['filter_doctor'];
		}		

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('catalog/medicine', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		if (!isset($this->request->get['medicine_id'])) {
			$this->data['action'] = $this->url->link('catalog/medicine/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('catalog/medicine/update', 'token=' . $this->session->data['token'] . '&medicine_id=' . $this->request->get['medicine_id'] . $url, 'SSL');
		}

		$this->data['cancel'] = $this->url->link('catalog/medicine', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['medicine_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$medicine_info = $this->model_catalog_medicine->getmedicine($this->request->get['medicine_id']);
		}

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->request->post['name'])) {
			$this->data['name'] = $this->request->post['name'];
		} elseif (!empty($medicine_info)) {
			$this->data['name'] = $medicine_info['name'];
		} else {	
			$this->data['name'] = '';
		}
		
		$this->data['doctors'] = $this->model_catalog_medicine->getdoctors();

		if (isset($this->request->post['doctor'])) {
			$this->data['doctor'] = $this->request->post['doctor'];
		} elseif (!empty($medicine_info)) {
			$this->data['doctor'] = $medicine_info['doctor'];
		} else {	
			$this->data['doctor'] = '1';
		}

		if (isset($this->request->post['rate'])) {
			$this->data['rate'] = $this->request->post['rate'];
		} elseif (!empty($medicine_info)) {
			$this->data['rate'] = $medicine_info['rate'];
		} else {	
			$this->data['rate'] = '';
		}

		if (isset($this->request->post['service'])) {
			$this->data['service'] = $this->request->post['service'];
		} elseif (!empty($medicine_info)) {
			$this->data['service'] = $medicine_info['service'];
		} else {	
			$this->data['service'] = '';
		}

		if (isset($this->request->post['quantity'])) {
			$this->data['quantity'] = $this->request->post['quantity'];
		} elseif (!empty($medicine_info)) {
			$this->data['quantity'] = $medicine_info['quantity'];
		} else {	
			$this->data['quantity'] = '';
		}

		if (isset($this->request->post['travel_sheet'])) {
			$this->data['travel_sheet'] = $this->request->post['travel_sheet'];
		} elseif (!empty($medicine_info)) {
			$this->data['travel_sheet'] = $medicine_info['travel_sheet'];
		} else {	
			$this->data['travel_sheet'] = '';
		}

		if (isset($this->request->post['is_surgery'])) {
			$this->data['is_surgery'] = $this->request->post['is_surgery'];
		} elseif (!empty($medicine_info)) {
			$this->data['is_surgery'] = $medicine_info['is_surgery'];
		} else {	
			$this->data['is_surgery'] = '';
		}

		if (isset($this->request->post['volume'])) {
			$this->data['volume'] = $this->request->post['volume'];
		} elseif (!empty($medicine_info)) {
			$this->data['volume'] = $medicine_info['volume'];
		} else {	
			$this->data['volume'] = '';
		}

		if (isset($this->request->post['sirin'])) {
			$this->data['sirin'] = $this->request->post['sirin'];
		} elseif (!empty($medicine_info)) {
			$this->data['sirin'] = $medicine_info['sirin'];
		} else {	
			$this->data['sirin'] = '';
		}

		$this->template = 'catalog/medicine_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}  

	public function export(){
		$this->language->load('catalog/medicine');
		$this->load->model('catalog/medicine');
		$this->load->model('report/common_report');

		$this->document->setTitle('Medicine List');

		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = '';
		}

		if (isset($this->request->get['filter_doctor'])) {
			$filter_doctor = $this->request->get['filter_doctor'];
		} else {
			$filter_doctor = '';
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

		$data = array(
			'filter_name' => $filter_name,
			'filter_doctor' => $filter_doctor,
			'sort'  => $sort,
			'order' => $order,
			// 'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			// 'limit' => $this->config->get('config_admin_limit')
		);
		$medicines = array();
		$medicine_total = $this->model_catalog_medicine->getTotalmedicines($data);
		$results = $this->model_catalog_medicine->getmedicines($data);
		foreach ($results as $result) {
			$doctor_name = $this->model_catalog_medicine->getdoctorname($result['doctor']);

			$medicines[] = array(
				'medicine_id' 	  => $result['medicine_id'],
				'name'            => $result['name'],
				'service'            => $result['service'],
				'price'			  => $result['rate'],
				'is_surgery'	  => $result['is_surgery'],
				'doctor_name'     => $doctor_name,
			);
		} 
		
		if($filter_doctor != '*'){
			if($filter_doctor == 1){
				$doctor_name = 'Dr. Phiroz Khambatta';
			} else {
				$doctor_name = 'Dr. Leila Fernandes';
			}
			//$doctor_name = 'Dr. '.$this->model_report_common_report->get_doctor_name($filter_doctor);
		} else {
			$doctor_name = 'Me';
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}

		if (isset($this->request->get['filter_doctor'])) {
			$url .= '&filter_doctor=' . $this->request->get['filter_doctor'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if($medicines){
			$template = new Template();		
			$template->data['final_datas'] = $medicines;
			$template->data['doctor_name'] = $doctor_name;
			$template->data['title'] = 'Medicine List';
			if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
				$template->data['base'] = 'http://64.79.95.89/phiroz/admin/';
			} else {
				$template->data['base'] = 'http://64.79.95.89/phiroz/admin/';
			}
			$html = $template->fetch('catalog/medicine_list_html.tpl');
			//echo $html;exit;
			$doctor_name = str_replace(array(' ', ',', '&', '.'), '_', $doctor_name);
			$filename = "Medicine_List_".$doctor_name.".html";
			header('Content-type: text/html');
			header('Content-Disposition: attachment; filename='.$filename);
			echo $html;
			exit;		
		} else {
			$this->session->data['warning'] = 'No Data Found';
			$this->redirect($this->url->link('catalog/medicine', 'token=' . $this->session->data['token'].$url, 'SSL'));
		}
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/medicine')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 255)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	protected function validateDelete() {
		//if (!$this->user->hasPermission('modify', 'catalog/medicine')) {
			$this->error['warning'] = $this->language->get('error_permission');
		//}

		// $this->load->model('catalog/horse');

		// if(isset($this->request->post['selected'])){
		// 	foreach ($this->request->post['selected'] as $medicine_id) {
		// 		$horse_total = $this->model_catalog_horse->getTotalhorsesBymedicineId($medicine_id);

		// 		if ($horse_total) {
		// 			$this->error['warning'] = sprintf($this->language->get('error_horse'), $horse_total);
		// 		}	
		// 	}
		// } elseif(isset($this->request->get['medicine_id'])){
		// 	$horse_total = $this->model_catalog_horse->getTotalhorsesBymedicineId($this->request->get['medicine_id']);

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
			$this->load->model('catalog/medicine');

			$data = array(
				'filter_name' => $this->request->get['filter_name'],
				'start'       => 0,
				'limit'       => 20
			);

			$results = $this->model_catalog_medicine->getmedicines($data);

			foreach ($results as $result) {
				$json[] = array(
					'medicine_id' => $result['medicine_id'], 
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
}
?>
