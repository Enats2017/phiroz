<?php    
class ControllerTransactionHorseWise extends Controller { 
	private $error = array();

	public function index() {
		$this->language->load('transaction/horse_wise');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('transaction/transaction');
		$this->load->model('catalog/medicine');

		$this->getForm();
	}

	public function insert() {
		$this->language->load('transaction/horse_wise');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('transaction/transaction');
		$this->load->model('catalog/medicine');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			if($this->request->post['h_name_id'] == ''){
				$horse_id = $this->model_transaction_transaction->gethorseexist($this->request->post['h_name']);				
				$this->request->post['h_name_id'] = $horse_id;
			}

			$this->request->post['h_trainer_id'] = '';
			if($this->request->post['h_name_id'] != ''){
				$trainer_id = $this->model_transaction_transaction->gettrainerid($this->request->post['h_name_id']);
				$this->request->post['h_trainer_id'] = $trainer_id;	
			}

			if($this->request->post['dot'] != ''){
				$this->request->post['dot'] = date('Y-m-d', strtotime($this->request->post['dot']));
				$this->request->post['month'] = date('m', strtotime($this->request->post['dot']));
				$this->request->post['year'] = date('Y', strtotime($this->request->post['dot']));
			} else {
				$this->request->post['dot'] = date('Y-m-d');
				$this->request->post['month'] = date('m');
				$this->request->post['year'] = date('Y');
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
			if (isset($this->request->post['h_name'])) {
				$this->data['h_name'] = $this->request->post['h_name'];
			} else {
				$this->data['h_name'] = '';
			}

			$this->model_transaction_transaction->addhorse_wise($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			if(isset($this->request->get['return'])){
				$this->redirect($this->url->link('report/horse_data', 'token=' . $this->session->data['token'].'&h_name='.$this->request->post['h_name'].'&h_name_id='.$this->request->post['h_name_id'], 'SSL'));	
			} else {
				$this->redirect($this->url->link('transaction/horse_wise', 'token=' . $this->session->data['token'].'&h_name='.$this->request->post['h_name'].'&h_name_id=' . $this->session->data['token'], 'SSL'));	
			}
		}

		$this->getForm();
	}

	public function update() {
		$this->language->load('transaction/horse_wise');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('transaction/transaction');
		$this->load->model('catalog/medicine');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			if($this->request->post['h_name_id'] == ''){
				$horse_id = $this->model_transaction_transaction->gethorseexist($this->request->post['h_name']);				
				$this->request->post['h_name_id'] = $horse_id;
			}

			$this->request->post['h_trainer_id'] = '';
			if($this->request->post['h_name_id'] != ''){
				$trainer_id = $this->model_transaction_transaction->gettrainerid($this->request->post['h_name_id']);
				$this->request->post['h_trainer_id'] = $trainer_id;	
			}

			if($this->request->post['dot'] != ''){
				$this->request->post['dot'] = date('Y-m-d', strtotime($this->request->post['dot']));
				$this->request->post['month'] = date('m', strtotime($this->request->post['dot']));
				$this->request->post['year'] = date('Y', strtotime($this->request->post['dot']));
			} else {
				$this->request->post['dot'] = date('Y-m-d');
				$this->request->post['month'] = date('m');
				$this->request->post['year'] = date('Y');
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

			$this->model_transaction_transaction->edithorse_wise($this->request->post);

			$this->session->data['success'] = 'You have updated the Transaction';

			$this->redirect($this->url->link('report/horse_data', 'token=' . $this->session->data['token'].'&h_name='.$this->request->post['h_name'].'&h_name_id='.$this->request->post['h_name_id'], 'SSL'));
		}

		$this->getForm();
	}

	protected function getForm() {
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['entry_select_horse_wise'] = $this->language->get('entry_select_horse_wise');
		$this->data['entry_dot'] = $this->language->get('entry_dot');
		$this->data['entry_add_medicine'] = $this->language->get('entry_add_medicine');
		$this->data['entry_remove'] = $this->language->get('entry_remove');
		

		$this->data['entry_treatment'] = $this->language->get('entry_treatment');
		$this->data['entry_price'] = $this->language->get('entry_price');
		$this->data['entry_total'] = $this->language->get('entry_total');
		$this->data['entry_quantity'] = $this->language->get('entry_quantity');
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

		if (isset($this->error['h_name'])) {
			$this->data['error_horse'] = $this->error['h_name'];
		} else {
			$this->data['error_horse'] = '';
		}

		if (isset($this->error['dot'])) {
			$this->data['error_dot'] = $this->error['dot'];
		} else {
			$this->data['error_dot'] = '';
		}

		if (isset($this->error['medicines'])) {
			$this->data['error_medicines'] = $this->error['medicines'];
		} else {
			$this->data['error_medicines'] = array();
		}

		if (isset($this->error['medicine'])) {
			$this->data['error_medicine'] = $this->error['medicine'];
		} else {
			$this->data['error_medicine'] = '';
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
		
		$this->data['travelsheet'] = $this->url->link('catalog/travelsheet', 'token=' . $this->session->data['token'].'&from=1', 'SSL');

		if (isset($this->request->get['h_name_id']) && isset($this->request->get['dot'])) {
			$this->data['action'] = $this->url->link('transaction/horse_wise/update', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			if(isset($this->request->get['return'])){
				$this->data['action'] = $this->url->link('transaction/horse_wise/insert', 'token=' . $this->session->data['token'].'&return=1', 'SSL');
			} else {
				$this->data['action'] = $this->url->link('transaction/horse_wise/insert', 'token=' . $this->session->data['token'], 'SSL');	
			}
		}

		
		$transaction_data = array();
		if (isset($this->request->get['h_name_id']) && isset($this->request->get['dot']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$transaction_data = $this->model_transaction_transaction->gettransactiondata($this->request->get['dot'], $this->request->get['h_name_id']);
		}

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->request->post['h_name'])) {
			$this->data['h_name'] = $this->request->post['h_name'];
		} elseif (isset($this->request->get['h_name'])) {
			$this->data['h_name'] = $this->request->get['h_name'];
		} elseif (isset($transaction_data[0]['horse_id'])) {
			$h_name = $this->model_transaction_transaction->get_horse_name($transaction_data[0]['horse_id']);
			$this->data['h_name'] = $h_name;
		} else {	
			$this->data['h_name'] = '';
		}

		if (isset($this->request->post['h_name_id'])) {
			$this->data['h_name_id'] = $this->request->post['h_name_id'];
		} elseif (isset($transaction_data[0]['horse_id'])) {
			$this->data['h_name_id'] = $transaction_data[0]['horse_id'];
		} elseif (isset($this->request->get['h_name_id'])) {
			$this->data['h_name_id'] = $this->request->get['h_name_id'];
		} else {	
			$this->data['h_name_id'] = '';
		}

		if(isset($this->request->get['return'])){
			$this->data['cancel'] = $this->url->link('report/horse_data', 'token=' . $this->session->data['token'] . '&h_name=' . $this->data['h_name'] . '&h_name_id=' . $this->data['h_name_id'], 'SSL');
			$this->data['travelsheet'] = $this->url->link('catalog/travelsheet', 'token=' . $this->session->data['token'].'&from=1&h_name=' . $this->data['h_name'] . '&h_name_id=' . $this->data['h_name_id'].'&return=1', 'SSL');
		} else {
			$this->data['travelsheet'] = $this->url->link('catalog/travelsheet', 'token=' . $this->session->data['token'].'&from=1', 'SSL');
			$this->data['cancel'] = $this->url->link('transaction/horse_wise', 'token=' . $this->session->data['token'], 'SSL');
		}
		
		if (isset($this->request->post['dot'])) {
			$this->data['dot'] = $this->request->post['dot'];
		} elseif (isset($transaction_data[0]['dot'])) {
			$this->data['dot'] = date('d-m-Y', strtotime($transaction_data[0]['dot']));
		} else {	
			$this->data['dot'] = date('d-m-Y');//'14-12-2015';//
		}

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
		
		$travel_sheet = $this->model_transaction_transaction->get_travelsheet();
		
		if (isset($this->request->post['medicines'])) {
			$this->data['medicines'] = $this->request->post['medicines'];
		} elseif(isset($transaction_data[0]['horse_id'])){
			foreach ($transaction_data as $tkey => $tvalue) {
				$med_data = $this->model_catalog_medicine->getmedicine($tvalue['medicine_id']);

				$this->data['medicines'][$tkey]['transaction_id'] = $tvalue['transaction_id'];
				$this->data['medicines'][$tkey]['m_name_id'] = $tvalue['medicine_id'];
				$this->data['medicines'][$tkey]['m_name'] = $tvalue['medicine_name'];
				$this->data['medicines'][$tkey]['m_quantity'] = $tvalue['medicine_quantity'];
				$this->data['medicines'][$tkey]['m_total'] = $tvalue['medicine_total'];
				$this->data['medicines'][$tkey]['m_price'] = $tvalue['medicine_price'];
				$this->data['medicines'][$tkey]['m_volume'] = $med_data['volume'];
				$this->data['medicines'][$tkey]['m_doctor_id'] = $tvalue['medicine_doctor_id'];
				$doctor_name = $this->model_transaction_transaction->get_doctor_name($tvalue['medicine_doctor_id']);
				$this->data['medicines'][$tkey]['m_doctor_name'] = $doctor_name; 
			}
		} elseif(isset($travel_sheet)) {
			$this->data['medicines'] = $travel_sheet; 
		} else {	
			$this->data['medicines'] = array();
		}

		// echo '<pre>';
		// print_r($this->data['medicines']);
		// exit;

		$this->template = 'transaction/horse_wise.tpl';
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

		if(strlen(utf8_decode(trim($this->request->post['h_name']))) < 1 || strlen(utf8_decode(trim($this->request->post['h_name']))) > 255){
			$this->error['h_name'] = $this->language->get('error_name');
		} else {
			if($this->request->post['h_name_id'] == ''){
				$horse_id = $this->model_transaction_transaction->gethorseexist($this->request->post['h_name']);				
				if($horse_id == 0){
					$this->error['h_name'] = $this->language->get('error_name_valid');
				}
			}
		}

		if(strlen(utf8_decode(trim($this->request->post['dot']))) < 1 || strlen(utf8_decode(trim($this->request->post['dot']))) > 255){
			$this->error['dot'] = $this->language->get('error_dot');
		}

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

	public function autocomplete_medicine() {
		$json = array();

		if (isset($this->request->get['filter_name'])) {
			$this->load->model('catalog/medicine');

			$data = array(
				'filter_name' => $this->request->get['filter_name'],
				'date' => $this->request->get['date'],
				'start'       => 0,
				'limit'       => 20
			);


			$results = $this->model_catalog_medicine->getmedicines($data);

			// echo "<pre>";
			// print_r($exist_data);
			// exit;
			foreach ($results as $result) {
				$exist_data = $this->db->query("SELECT * FROM " . DB_PREFIX . "transaction WHERE medicine_id = '" . $result['medicine_id'] . "' AND  dot = '" .date('Y-m-d' , strtotime($this->request->get['date']))."'");
				if ($exist_data->num_rows > 0) {
					$exist_alert = 'This medicine is already exist';
				}else{
					$exist_alert = '';
				}

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
					'exist_alert' => $exist_alert, 
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

	public function removetransaction() {
		$jsondata = array();
		$jsondata['status'] = 0;
		//$this->log->write(print_r($this->request->get,true));
		if(isset($this->request->get['transaction_id'])){
			$id = $this->request->get['transaction_id'];
		        $this->load->model('transaction/transaction');
			$doctor_name = $this->model_transaction_transaction->removetransaction($this->request->get['transaction_id']);
			$jsondata['status'] = 1;
			
	       }
	       $this->response->setOutput(Json_encode($jsondata));
	}
}
?>
