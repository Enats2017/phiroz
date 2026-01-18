<?php    
class ControllerCatalogTravelsheet extends Controller { 
	private $error = array();

	public function index() {
		$this->language->load('catalog/medicine');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/medicine');

		$this->getList();
	}

	public function assign() {
		$this->language->load('catalog/medicine');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/medicine');

		if (isset($this->request->post) && $this->validateDelete()) {
			$this->model_catalog_medicine->delete_travelsheet();			
			if(isset($this->request->post['selected'])) {			
				foreach ($this->request->post['selected'] as $medicine_id) {
					$this->model_catalog_medicine->insert_travelsheet($medicine_id);
				}
			}

			//$this->session->data['success'] = $this->language->get('text_success');

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
			
			if (isset($this->request->get['h_name_id'])) {
				$url .= '&h_name_id=' . $this->request->get['h_name_id'];
			}
			if (isset($this->request->get['h_name'])) {
				$url .= '&h_name=' . $this->request->get['h_name'];
			}
			if (isset($this->request->get['return'])) {
				$url .= '&return=' . $this->request->get['return'];
			}
			
			if (isset($this->request->get['from'])) {
				if($this->request->get['from'] == 1) {
					$this->redirect($this->url->link('transaction/horse_wise', 'token=' . $this->session->data['token'] . $url, 'SSL'));					
				} else {
					$this->redirect($this->url->link('transaction/medicine_wise', 'token=' . $this->session->data['token'] . $url, 'SSL'));					
				}
			} else {
				$this->redirect($this->url->link('catalog/travelsheet', 'token=' . $this->session->data['token'] . $url, 'SSL'));						
			}

			
		} elseif(isset($this->request->get['medicine_id']) && $this->validateDelete()){
			$this->model_catalog_medicine->delete_travelsheet();
			$this->model_catalog_medicine->insert_travelsheet($this->request->get['medicine_id']);

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

			$this->redirect($this->url->link('catalog/travelsheet', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
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
		
		if (isset($this->request->get['from'])) {
			$url .= '&from=' . $this->request->get['from'];
		}
		
		if (isset($this->request->get['h_name_id'])) {
			$url .= '&h_name_id=' . $this->request->get['h_name_id'];
		}
		if (isset($this->request->get['h_name'])) {
			$url .= '&h_name=' . $this->request->get['h_name'];
		}
		if (isset($this->request->get['return'])) {
			$url .= '&return=' . $this->request->get['return'];
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
		
		$this->data['breadcrumbs'][] = array(
			'text'      => 'Travelsheet',
			'href'      => $this->url->link('catalog/travelsheet', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$this->data['delete'] = $this->url->link('catalog/travelsheet/assign', 'token=' . $this->session->data['token'] . $url, 'SSL');	

		$this->data['medicines'] = array();

		$data = array(
			'filter_name' => $filter_name,
			'filter_doctor' => $filter_doctor,
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);

		$medicine_total = $this->model_catalog_medicine->getTotalmedicinests($data);

		$results = $this->model_catalog_medicine->getmedicinests($data);
		
		$selected = $this->model_catalog_medicine->get_travelsheet();
		$travelsheet = array();		

		if($selected){
			foreach($selected as $select) {
				$travelsheet[] = $select['medicine_id'];	
			}
		}
	
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

			$doctor_name = $this->model_catalog_medicine->getdoctorname($result['doctor']);

			$this->data['medicines'][] = array(
				'medicine_id' => $result['medicine_id'],
				'name'            => $result['name'],
				'doctor_name'     => $doctor_name,
				'selected'        => isset($travelsheet) && in_array($result['medicine_id'], $travelsheet),
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

		$this->template = 'catalog/travelsheet_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/travelsheet')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

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

			$results = $this->model_catalog_medicine->getmedicinests($data);

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
