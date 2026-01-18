<?php    
class ControllerTransactionMedicineWise extends Controller { 
	private $error = array();

	public function index() {
		$this->language->load('transaction/medicine_wise');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('transaction/transaction');

		$this->getForm();
	}

	public function insert() {
		$this->language->load('transaction/medicine_wise');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('transaction/transaction');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

			// echo '<pre>';
			// print_r($this->request->post);
			// exit;

			// if($this->request->post['medicine_name_id'] == ''){
			// 	$medicine_id = $this->model_transaction_transaction->getmedicineexist($this->request->post['medicine_name']);				
			// 	$this->request->post['medicine_name_id'] = $medicine_id;
			// }
			
			if(isset($this->request->post['horses'])){
				foreach ($this->request->post['horses'] as $okey => $ovalue) {
					if($ovalue['h_name_id'] == ''){
						$horse_id = $this->model_transaction_transaction->gethorseexist($ovalue['h_name']);				
						$this->request->post['horses'][$okey]['h_name_id'] = $horse_id;
					}

					$this->request->post['horses'][$okey]['h_trainer_id'] = '';
					if($ovalue['h_name_id'] != ''){
						$trainer_id = $this->model_transaction_transaction->gettrainerid($ovalue['h_name_id']);
						$this->request->post['horses'][$okey]['h_trainer_id'] = $trainer_id;	
					}
				}
				if($this->request->post['search_date_treatment'] != ''){
					$this->request->post['search_date_treatment'] = date('Y-m-d', strtotime($this->request->post['search_date_treatment']));
					$this->request->post['month'] = date('m', strtotime($this->request->post['search_date_treatment']));
					$this->request->post['year'] = date('Y', strtotime($this->request->post['search_date_treatment']));
				} else {
					$this->request->post['search_date_treatment'] = date('Y-m-d');
					$this->request->post['month'] = date('m-');
					$this->request->post['year'] = date('Y');
				}
			}
			
			if(isset($this->request->post['medicines'])){
				foreach ($this->request->post['medicines'] as $okey => $ovalue) {
					if($ovalue['m_name_id'] == ''){
						$medicine_id = $this->model_transaction_transaction->getmedicineexist($ovalue['m_name']);				
						$this->request->post['medicines'][$okey]['m_name_id'] = $medicine_id;
					}	
				}
			}

			// echo '<pre>';
			// print_r($this->request->post);
			// exit;

			$this->model_transaction_transaction->addmedicine_wise($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('transaction/medicine_wise', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->getForm();
	}

	protected function getForm() {
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['entry_select_medicine_wise'] = $this->language->get('entry_select_medicine_wise');
		$this->data['entry_dot'] = $this->language->get('entry_dot');
		$this->data['entry_add_horse'] = $this->language->get('entry_add_horse');
		$this->data['entry_remove'] = $this->language->get('entry_remove');
		

		$this->data['entry_treatment'] = $this->language->get('entry_treatment');
		$this->data['entry_price'] = $this->language->get('entry_price');
		$this->data['entry_total'] = $this->language->get('entry_total');
		$this->data['entry_quantity'] = $this->language->get('entry_quantity');
		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_date'] = $this->language->get('entry_date');
		$this->data['entry_trainer'] = $this->language->get('entry_trainer');
		$this->data['entry_action'] = $this->language->get('entry_action');
		$this->data['entry_doctor'] = $this->language->get('entry_doctor');
		$this->data['entry_transaction_type'] = $this->language->get('entry_transaction_type');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['tab_general'] = $this->language->get('tab_general');

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['error_medicine'])) {
			$this->data['error_medicine'] = $this->error['error_medicine'];
		} else {
			$this->data['error_medicine'] = '';
		}

		if (isset($this->error['medicine_name'])) {
			$this->data['error_medicine_name'] = $this->error['medicine_name'];
		} else {
			$this->data['error_medicine_name'] = '';
		}

		// if (isset($this->error['m_quantity'])) {
		// 	$this->data['error_medicine_quantity'] = $this->error['m_quantity'];
		// } else {
		// 	$this->data['error_medicine_quantity'] = '';
		// }

		if (isset($this->error['dot'])) {
			$this->data['error_dot'] = $this->error['dot'];
		} else {
			$this->data['error_dot'] = '';
		}

		if (isset($this->error['horses'])) {
			$this->data['error_horses'] = $this->error['horses'];
		} else {
			$this->data['error_horses'] = array();
		}

		if (isset($this->error['medicines'])) {
			$this->data['error_medicines'] = $this->error['medicines'];
		} else {
			$this->data['error_medicines'] = array();
		}

		if (isset($this->error['horses_empty'])) {
			$this->data['error_horse'] = $this->error['horses_empty'];
		} else {
			$this->data['error_horse'] = '';
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('transaction/horse_wise', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['action'] = $this->url->link('transaction/medicine_wise/insert', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel'] = $this->url->link('transaction/medicine_wise', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->request->post['transaction_type'])) {
			$this->data['transaction_type'] = $this->request->post['transaction_type'];
		} else {	
			$this->data['transaction_type'] = '1';
		}

		if (isset($this->request->post['medicine_name'])) {
			$this->data['medicine_name'] = $this->request->post['medicine_name'];
		} else {	
			$this->data['medicine_name'] = '';
		}

		if (isset($this->request->post['medicine_name_id'])) {
			$this->data['medicine_name_id'] = $this->request->post['medicine_name_id'];
		} else {	
			$this->data['medicine_name_id'] = '';
		}

		if (isset($this->request->post['horse_name'])) {
			$this->data['horse_name'] = $this->request->post['horse_name'];
		} else {	
			$this->data['horse_name'] = '';
		}

		if (isset($this->request->post['horse_name_id'])) {
			$this->data['horse_name_id'] = $this->request->post['horse_name_id'];
		} else {	
			$this->data['horse_name_id'] = '';
		}

		// if (isset($this->request->post['m_quantity'])) {
		// 	$this->data['m_quantity'] = $this->request->post['m_quantity'];
		// } else {	
		// 	$this->data['m_quantity'] = '';
		// }

		// if (isset($this->request->post['m_name'])) {
		// 	$this->data['m_name'] = $this->request->post['m_name'];
		// } else {	
		// 	$this->data['m_name'] = '';
		// }

		// if (isset($this->request->post['m_price'])) {
		// 	$this->data['m_price'] = $this->request->post['m_price'];
		// } else {	
		// 	$this->data['m_price'] = '';
		// }

		// if (isset($this->request->post['m_total'])) {
		// 	$this->data['m_total'] = $this->request->post['m_total'];
		// } else {	
		// 	$this->data['m_total'] = '';
		// }

		//$this->session->data['s_date'] = '23-02-2016';

		if (isset($this->request->post['dot'])) {
			$this->data['dot'] = $this->request->post['dot'];
		} else {	
			$this->data['dot'] = date('d-m-Y');
		}

		// if (isset($this->request->post['m_doctor_name'])) {
		// 	$this->data['m_doctor_name'] = $this->request->post['m_doctor_name'];
		// } else {	
		// 	$this->data['m_doctor_name'] = '';
		// }

		// if (isset($this->request->post['m_doctor_id'])) {
		// 	$this->data['m_doctor_id'] = $this->request->post['m_doctor_id'];
		// } else {	
		// 	$this->data['m_doctor_id'] = '';
		// }

		if (isset($this->request->post['horses'])) {
			$this->data['horses'] = $this->request->post['horses'];
		} else {	
			$this->data['horses'] = array();
		}

		if (isset($this->request->post['medicines'])) {
			$this->data['medicines'] = $this->request->post['medicines'];
		} else {	
			$this->data['medicines'] = array();
		}

		if (isset($this->request->post['search_date_treatment'])) {
			$this->data['search_date_treatment'] = $this->request->post['search_date_treatment'];
		} else {	
			$this->data['search_date_treatment'] = date('d-m-Y');
		}	

		$data['volumes']=array();

		$data['volumes']=array(
			'0' => '0',
			'10'=>'10',
			'20'=>'20',
			'30'=>'30',
			'40'=>'40',
			'50'=>'50',
			'60'=>'60',
			'70'=>'70',
			'80'=>'80',
			'90'=>'90',
			'100'=>'100'
			);	

		$this->template = 'transaction/medicine_wise.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}  

	protected function validateForm() {
		$this->load->model('transaction/transaction');

		if (!$this->user->hasPermission('modify', 'transaction/horse_wise')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		// if(strlen(utf8_decode(trim($this->request->post['medicine_name']))) < 1 || strlen(utf8_decode(trim($this->request->post['medicine_name']))) > 255){
		// 	$this->error['medicine_name'] = $this->language->get('error_name');
		// } else {
		// 	if($this->request->post['medicine_name_id'] == ''){
		// 		$medicine_id = $this->model_transaction_transaction->getmedicineexist($this->request->post['medicine_name']);				
		// 		if($medicine_id == 0){
		// 			$this->error['medicine_name'] = $this->language->get('error_name_valid');
		// 		}
		// 	}
		// }

		// if(isset($this->request->post['m_quantity'])){
		// 	if(strlen(utf8_decode(trim($this->request->post['m_quantity']))) < 1 || strlen(utf8_decode(trim($this->request->post['m_quantity']))) > 255 || trim($this->request->post['m_quantity']) == '0'){
		// 		$this->error['m_quantity'] =  $this->language->get('error_medicine_quantity');
		// 	}
		// } else {
		// 	$this->error['error_medicine'] = $this->language->get('error_select_medicine');
		// }

		// if(strlen(utf8_decode(trim($this->request->post['dot']))) < 1 || strlen(utf8_decode(trim($this->request->post['dot']))) > 255){
		// 	$this->error['dot'] = $this->language->get('error_dot');
		// }

		if(isset($this->request->post['medicines'])){
			$total_share = '';
			$i = 0;
			foreach ($this->request->post['medicines'] as $okey => $ovalue) {
				if(strlen(utf8_decode(trim($ovalue['m_name']))) < 1 || strlen(utf8_decode(trim($ovalue['m_name']))) > 255){
					$this->error['medicines'][$ovalue['m_field_row']]['medicine_name'] = $this->language->get('error_medicine_name'); 
				} else {
					if($ovalue['m_name_id'] == ''){
						$is_exist = $this->model_transaction_transaction->getmedicineexist($ovalue['m_name']);
						if($is_exist == 0){
							$this->error['medicines'][$ovalue['m_field_row']]['medicine_name'] = $this->language->get('error_medicine_exist');
						}
					}
				}

				if(strlen(utf8_decode(trim($ovalue['m_price']))) < 1 || strlen(utf8_decode(trim($ovalue['m_price']))) > 255){
					$this->error['medicines'][$ovalue['m_field_row']]['medicine_price'] =  $this->language->get('error_price');
				}

				if(strlen(utf8_decode(trim($ovalue['m_total']))) < 1 || strlen(utf8_decode(trim($ovalue['m_total']))) > 255){
					$this->error['medicines'][$ovalue['m_field_row']]['medicine_total'] =  $this->language->get('error_total');
				}

				if(strlen(utf8_decode(trim($ovalue['m_quantity']))) < 1 || strlen(utf8_decode(trim($ovalue['m_quantity']))) > 255 || trim($ovalue['m_quantity']) == '0'){
					$this->error['medicines'][$ovalue['m_field_row']]['medicine_quantity'] =  $this->language->get('error_medicine_quantity');
				} 
			}
			
		} else {
			$this->error['medicine'] = $this->language->get('error_medicine_name');
		}

		if(isset($this->request->post['horses'])){
			foreach ($this->request->post['horses'] as $okey => $ovalue) {
				if(strlen(utf8_decode(trim($ovalue['h_name']))) < 1 || strlen(utf8_decode(trim($ovalue['h_name']))) > 255){
					$this->error['horses'][$ovalue['h_field_row']]['horse_name'] = $this->language->get('error_horse_name'); 
				} else {
					$is_exist = $this->model_transaction_transaction->gethorseexist($ovalue['h_name']);
					if($is_exist == 0){
						$this->error['horses'][$ovalue['h_field_row']]['horse_name'] = $this->language->get('error_horse_exist');
					}
				}
			}
		} else {
			$this->error['horses_empty'] = $this->language->get('error_horse_empty');
		}

		// echo '<pre>';
		// print_r($this->error);
		// exit;

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
			$this->load->model('transaction/transaction');

			$data = array(
				'filter_name' => $this->request->get['filter_name'],
				'start'       => 0,
				'limit'       => 20
			);

			$results = $this->model_catalog_horse->gethorses($data);

			foreach ($results as $result) {
				$trainer_name = $this->model_transaction_transaction->gettrainername($result['trainer']);
				$json[] = array(
					'horse_id' => $result['horse_id'], 
					'name'            => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
					'trainer_name'    => strip_tags(html_entity_decode($trainer_name, ENT_QUOTES, 'UTF-8')),
					'date' => date('d-m-Y')
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

	public function autocomplete_medicine() {
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
				if($this->user->getId() == '2'){
					$result['doctor'] = '3';
					$doctor_name = $this->model_catalog_medicine->getdoctorname($result['doctor']);
				} else {
					$doctor_name = $this->model_catalog_medicine->getdoctorname($result['doctor']);
				}
				$json[] = array(
					'medicine_id' => $result['medicine_id'],
					'rate' => ($result['rate'] + $result['service'] + $result['sirin']),
					'quantity' => 1,
					'doctor_id' => $result['doctor'],
					'volume' => $result['volume'],
					'doctor_name' => $doctor_name, 
					'name' => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
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
