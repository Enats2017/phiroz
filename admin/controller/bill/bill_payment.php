<?php
class ControllerBillBillPayment extends Controller { 
	public function index() {  
		$this->language->load('bill/bill_payment');

		$this->document->setTitle($this->language->get('heading_title'));

		if (isset($this->request->get['filter_bill_id'])) {
			$filter_bill_id = $this->request->get['filter_bill_id'];
		} else {
			$filter_bill_id = '';
		}

		if (isset($this->request->get['filter_month'])) {
			$filter_month = $this->request->get['filter_month'];
		} else {
			$filter_month = '';
		}

		if (isset($this->request->get['filter_year'])) {
			$filter_year = $this->request->get['filter_year'];
		} else {
			$filter_year = '';
		}

		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = '';
		}

		if (isset($this->request->get['filter_name_id'])) {
			$filter_name_id = $this->request->get['filter_name_id'];
		} else {
			$filter_name_id = '';
		}

		if (isset($this->request->get['filter_transaction_type'])) {
			$filter_transaction_type = $this->request->get['filter_transaction_type'];
		} else {
			$filter_transaction_type = '';
		}

		if (isset($this->request->get['filter_doctor'])) {
			$filter_doctor = $this->request->get['filter_doctor'];
		} else {
			$filter_doctor = '';
		}

		if (isset($this->request->get['filter_batch_id'])) {
			$filter_batch_id = $this->request->get['filter_batch_id'];
		} else {
			$filter_batch_id = '';
		}

		if (isset($this->request->get['filter_type'])) {
			$filter_type = $this->request->get['filter_type'];
		} else {
			$filter_type = '';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['filter_batch_id'])) {
			$url .= '&filter_batch_id=' . $this->request->get['filter_batch_id'];
		}

		if (isset($this->request->get['filter_bill_id'])) {
			$url .= '&filter_bill_id=' . $this->request->get['filter_bill_id'];
		}

		if (isset($this->request->get['filter_month'])) {
			$url .= '&filter_month=' . $this->request->get['filter_month'];
		}

		if (isset($this->request->get['filter_year'])) {
			$url .= '&filter_year=' . $this->request->get['filter_year'];
		}

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}

		if (isset($this->request->get['filter_name_id'])) {
			$url .= '&filter_name_id=' . $this->request->get['filter_name_id'];
		}

		if (isset($this->request->get['filter_transaction_type'])) {
			$url .= '&filter_transaction_type=' . $this->request->get['filter_transaction_type'];
		}

		if (isset($this->request->get['filter_doctor'])) {
			$url .= '&filter_doctor=' . $this->request->get['filter_doctor'];
		}

		if (isset($this->request->get['filter_type'])) {
			$url .= '&filter_type=' . $this->request->get['filter_type'];
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
			'href'      => $this->url->link('bill/bill_payment', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$this->load->model('bill/print_invoice');

		$this->data['bill_checklist'] = array();

		
		$data = array(
			'filter_bill_id'	     => $filter_bill_id, 
			'filter_batch_id'	     => $filter_batch_id, 
			'filter_month'	     => $filter_month, 
			'filter_year'	     => $filter_year, 
			'filter_name'            => $filter_name,
			'filter_name_id'         => $filter_name_id,
			'filter_transaction_type' => $filter_transaction_type,
			'filter_doctor' => $filter_doctor,
			'filter_type' => $filter_type,
			'start'                  => ($page - 1) * 7000,
			'limit'                  => 7000
		);

		// echo '<pre>';
		// print_r($data);
		// exit;
		$order_total = 0;
		if(isset($this->request->get['first']) && $this->request->get['first'] == 0){
			$results = $this->model_bill_print_invoice->getbills_rwitc($data);
			//$bill_ids = $this->model_bill_print_invoice->getbillids_groups($data);
			//$bill_owner_groups = $this->model_bill_print_invoice->getbillowner_groups($data);
			$old_bill_id = 0;
			$i = 0;
			foreach ($results as $result) {
				if($old_bill_id != $result['bill_id']){
					$i = 1;
				}
				$old_bill_id = $result['bill_id'];
				$action = array();
				if($result['accept'] == '0'){
					$action[] = array(
						'text' => 'Accept',
						'href' => $this->url->link('bill/bill_payment/accept', 'token=' . $this->session->data['token'] . '&filter_horse_id=' . $result['horse_id'] . '&filter_bill_id=' . $result['bill_id'] . '&filter_owner=' . $result['owner_id'].'&filter_i='.$i, 'SSL')
					);
					$action[] = array(
						'text' => 'Defaulter',
						'href' => $this->url->link('bill/bill_payment/defaulter', 'token=' . $this->session->data['token'] . '&filter_horse_id=' . $result['horse_id'] . '&filter_bill_id=' . $result['bill_id'] . '&filter_owner=' . $result['owner_id'].'&filter_i='.$i, 'SSL')
					);
				} elseif($result['accept'] == '1') {
					$action[] = array(
						'text' => 'Reject',
						'href' => $this->url->link('bill/bill_payment/reject', 'token=' . $this->session->data['token'] . '&filter_horse_id=' . $result['horse_id'] . '&filter_bill_id=' . $result['bill_id'] . '&filter_owner=' . $result['owner_id'].'&filter_i='.$i, 'SSL')
					);
					$action[] = array(
						'text' => 'Defaulter',
						'href' => $this->url->link('bill/bill_payment/defaulter', 'token=' . $this->session->data['token'] . '&filter_horse_id=' . $result['horse_id'] . '&filter_bill_id=' . $result['bill_id'] . '&filter_owner=' . $result['owner_id'].'&filter_i='.$i, 'SSL')
					);
				} elseif($result['accept'] == '2'){
					$action[] = array(
						'text' => 'Accept',
						'href' => $this->url->link('bill/bill_payment/accept', 'token=' . $this->session->data['token'] . '&filter_horse_id=' . $result['horse_id'] . '&filter_bill_id=' . $result['bill_id'] . '&filter_owner=' . $result['owner_id'].'&filter_i='.$i, 'SSL')
					);
				}
				
				$horse_name = $this->model_bill_print_invoice->get_horse_name($result['horse_id']);
				$owner_name = $this->model_bill_print_invoice->get_owner_name($result['owner_id']);
				$trainer_name = $this->model_bill_print_invoice->get_trainer_name($result['trainer_id']);
				
				$this->data['bill_checklist'][] = array(
					'bill_id' 	 => $result['bill_id'].'-'.$i,
					'id' 	 => $result['id'],
					'horse_name' => $horse_name,
					'owner_name' => $owner_name,
					'trainer_name' => $trainer_name,
					'total'      => $this->currency->format($result['owner_amt'], $this->config->get('config_currency')),
					'action'    => $action
				);
				$i ++;
			}
		}

		// echo '<pre>';
		// print_r($this->data['bill_checklist']);
		// exit;

		$this->data['action'] = $this->url->link('bill/bill_payment/accept', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['generate_csv'] = $this->url->link('bill/bill_payment/generate_csv', 'token=' . $this->session->data['token'].$url, 'SSL');
		$this->data['generate_payment'] = $this->url->link('bill/bill_payment/generate_payment_csv', 'token=' . $this->session->data['token'].$url, 'SSL');

		if(isset($this->session->data['success'])){
			$this->data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		//$this->data['action'] = $this->url->link('bill/bill_payment/import_data', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['column_bill_no'] = $this->language->get('column_bill_no');
		$this->data['entry_bill_id'] = $this->language->get('entry_bill_id');

		$this->data['column_sr_no'] = $this->language->get('column_sr_no');
		$this->data['column_bill_no'] = $this->language->get('column_bill_no');
		$this->data['column_horse_name'] = $this->language->get('column_horse_name');
		$this->data['column_owner_name'] = $this->language->get('column_owner_name');
		$this->data['column_trainer_name'] = $this->language->get('column_trainer_name');
		$this->data['column_total'] = $this->language->get('column_total');
		$this->data['column_action'] = $this->language->get('column_action');
			
		$this->data['button_filter'] = $this->language->get('button_filter');
		$this->data['button_filter_accept'] = $this->language->get('button_filter_accept');
		
		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['token'] = $this->session->data['token'];

		if(isset($this->session->data['warning'])){
			$this->data['error_warning'] = $this->session->data['warning'];
			unset($this->session->data['warning']);
		} else {
			$this->data['error_warning'] = '';
		}

		$url = '';

		if (isset($this->request->get['filter_batch_id'])) {
			$url .= '&filter_batch_id=' . $this->request->get['filter_batch_id'];
		}

		if (isset($this->request->get['filter_bill_id'])) {
			$url .= '&filter_bill_id=' . $this->request->get['filter_bill_id'];
		}

		if (isset($this->request->get['filter_month'])) {
			$url .= '&filter_month=' . $this->request->get['filter_month'];
		}

		if (isset($this->request->get['filter_year'])) {
			$url .= '&filter_year=' . $this->request->get['filter_year'];
		}

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}

		if (isset($this->request->get['filter_name_id'])) {
			$url .= '&filter_name_id=' . $this->request->get['filter_name_id'];
		}

		if (isset($this->request->get['filter_transaction_type'])) {
			$url .= '&filter_transaction_type=' . $this->request->get['filter_transaction_type'];
		}

		if (isset($this->request->get['filter_doctor'])) {
			$url .= '&filter_doctor=' . $this->request->get['filter_doctor'];
		}

		if (isset($this->request->get['filter_type'])) {
			$url .= '&filter_type=' . $this->request->get['filter_type'];
		}

		$this->load->model('bill/print_invoice');
		$doctors = $this->model_bill_print_invoice->getdoctors();
		$this->data['doctors'] = $doctors;

		$transaction_typess = $this->db->query("SELECT * FROM `oc_transaction_type` WHERE `doctor_id` = '1' ")->rows;
		foreach ($transaction_typess as $tkey => $tvalue) {
			$this->data['transaction_types'][$tvalue['id']] = $tvalue['transaction_type'];
		}

		// $this->data['transaction_types'] = array(
		// 	'0' => 'All',
		// 	'1' => 'Phiroz Khambatta',
		// 	'2' => 'P.T Khambatta',
		// 	'3' => 'P.T Mumbai',
		// 	'4' => 'P.T Pune'
		// );

		$this->data['types'] = array(
			'0' => 'None',
			'1' => 'All',
			'2' => 'Accept',
			'3' => 'Defaulter',
			'4' => 'Unprocessed',
		);

		$months = array(
			'0' => 'Please Select',
			'01' => 'January',
			'02' => 'Feburary',
			'03' => 'March',
			'04' => 'April',
			'05' => 'May',
			'06' => 'June',
			'07' => 'July',
			'08' => 'August',
			'09' => 'September',
			'10' => 'October',
			'11' => 'November',
			'12' => 'December'
		);

		$this->data['months'] = $months;
		
		$current_year = date("Y");
		$years = range(intval($current_year), 2015);
		$this->data['years'] = $years;

		$pagination = new Pagination();
		$pagination->total = $order_total;
		$pagination->page = $page;
		$pagination->limit = 7000;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('bill/bill_payment', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();
		$this->data['filter_month'] = $filter_month;
		$this->data['filter_year'] = $filter_year;		
		$this->data['filter_name'] = $filter_name;
		$this->data['filter_name_id'] = $filter_name_id;
		$this->data['filter_transaction_type'] = $filter_transaction_type;
		$this->data['filter_doctor'] = $filter_doctor;
		$this->data['filter_bill_id'] = $filter_bill_id;
		$this->data['filter_batch_id'] = $filter_batch_id;
		$this->data['filter_type'] = $filter_type;

		$this->template = 'bill/bill_payment.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function accept(){
		$this->load->model('bill/print_invoice');

		if (isset($this->request->get['filter_bill_id'])) {
			$filter_bill_id = $this->request->get['filter_bill_id'];
		} else {
			$filter_bill_id = '';
		}

		if (isset($this->request->get['filter_horse_id'])) {
			$filter_horse_id = $this->request->get['filter_horse_id'];
		} else {
			$filter_horse_id = '';
		}

		if (isset($this->request->get['filter_owner'])) {
			$filter_owner = $this->request->get['filter_owner'];
		} else {
			$filter_owner = '';
		}

		if (isset($this->request->get['filter_i'])) {
			$filter_i = $this->request->get['filter_i'];
		} else {
			$filter_i = '1';
		}
		
		$anil_id = $this->model_bill_print_invoice->getLastAnilId();
		$anil_id = intval($anil_id)+1;
		if(isset($this->request->post['selected'])){
			foreach ($this->request->post['selected'] as $skey => $svalue) {
				$this->model_bill_print_invoice->updatebill_accept_sel($svalue, $anil_id);		
				$anil_id ++;
			}
			$filter_bill_id = $this->model_bill_print_invoice->getbillid($svalue);
		} else {
			$this->model_bill_print_invoice->updatebill_accept($filter_bill_id, $filter_owner, $anil_id);
		}

		$url = '';

		if (isset($this->request->get['filter_batch_id'])) {
			$url .= '&filter_batch_id=' . $this->request->get['filter_batch_id'];
		}

		if (isset($this->request->get['filter_bill_id'])) {
			$url .= '&filter_bill_id=' . $this->request->get['filter_bill_id'];
			$url .= "&first=0";
		} elseif ($filter_bill_id != '') {
			$url .= '&filter_bill_id=' . $filter_bill_id;
			$url .= "&first=0";
		}

		if (isset($this->request->get['filter_month'])) {
			$url .= '&filter_month=' . $this->request->get['filter_month'];
		}

		if (isset($this->request->get['filter_year'])) {
			$url .= '&filter_year=' . $this->request->get['filter_year'];
		}

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}

		if (isset($this->request->get['filter_name_id'])) {
			$url .= '&filter_name_id=' . $this->request->get['filter_name_id'];
		}

		if (isset($this->request->get['filter_transaction_type'])) {
			$url .= '&filter_transaction_type=' . $this->request->get['filter_transaction_type'];
		}

		if (isset($this->request->get['filter_doctor'])) {
			$url .= '&filter_doctor=' . $this->request->get['filter_doctor'];
		}

		if (isset($this->request->get['filter_type'])) {
			$url .= '&filter_type=' . $this->request->get['filter_type'];
		}

		$this->redirect($this->url->link('bill/bill_payment', 'token=' . $this->session->data['token'].$url, 'SSL'));
	}

	public function reject(){
		$this->load->model('bill/print_invoice');

		if (isset($this->request->get['filter_bill_id'])) {
			$filter_bill_id = $this->request->get['filter_bill_id'];
		} else {
			$filter_bill_id = '';
		}

		if (isset($this->request->get['filter_horse_id'])) {
			$filter_horse_id = $this->request->get['filter_horse_id'];
		} else {
			$filter_horse_id = '';
		}

		if (isset($this->request->get['filter_owner'])) {
			$filter_owner = $this->request->get['filter_owner'];
		} else {
			$filter_owner = '';
		}

		if (isset($this->request->get['filter_i'])) {
			$filter_i = $this->request->get['filter_i'];
		} else {
			$filter_i = '1';
		}

		$this->model_bill_print_invoice->updatebill_reject($filter_bill_id, $filter_owner);
		
		$url = '';

		if (isset($this->request->get['filter_batch_id'])) {
			$url .= '&filter_batch_id=' . $this->request->get['filter_batch_id'];
		}

		if (isset($this->request->get['filter_bill_id'])) {
			$url .= '&filter_bill_id=' . $this->request->get['filter_bill_id'];
		}

		if (isset($this->request->get['filter_month'])) {
			$url .= '&filter_month=' . $this->request->get['filter_month'];
		}

		if (isset($this->request->get['filter_year'])) {
			$url .= '&filter_year=' . $this->request->get['filter_year'];
		}

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}

		if (isset($this->request->get['filter_name_id'])) {
			$url .= '&filter_name_id=' . $this->request->get['filter_name_id'];
		}

		if (isset($this->request->get['filter_transaction_type'])) {
			$url .= '&filter_transaction_type=' . $this->request->get['filter_transaction_type'];
		}

		if (isset($this->request->get['filter_doctor'])) {
			$url .= '&filter_doctor=' . $this->request->get['filter_doctor'];
		}

		if (isset($this->request->get['filter_type'])) {
			$url .= '&filter_type=' . $this->request->get['filter_type'];
		}

		$url .= "&first=0";
		
		$this->redirect($this->url->link('bill/bill_payment', 'token=' . $this->session->data['token'].$url, 'SSL'));
	}

	public function defaulter(){
		$this->load->model('bill/print_invoice');

		if (isset($this->request->get['filter_bill_id'])) {
			$filter_bill_id = $this->request->get['filter_bill_id'];
		} else {
			$filter_bill_id = '';
		}

		if (isset($this->request->get['filter_horse_id'])) {
			$filter_horse_id = $this->request->get['filter_horse_id'];
		} else {
			$filter_horse_id = '';
		}

		if (isset($this->request->get['filter_owner'])) {
			$filter_owner = $this->request->get['filter_owner'];
		} else {
			$filter_owner = '';
		}

		if (isset($this->request->get['filter_i'])) {
			$filter_i = $this->request->get['filter_i'];
		} else {
			$filter_i = '1';
		}

		$this->model_bill_print_invoice->updatebill_defaulter($filter_bill_id, $filter_owner);
		
		$url = '';

		if (isset($this->request->get['filter_batch_id'])) {
			$url .= '&filter_batch_id=' . $this->request->get['filter_batch_id'];
		}

		if (isset($this->request->get['filter_bill_id'])) {
			$url .= '&filter_bill_id=' . $this->request->get['filter_bill_id'];
		}

		if (isset($this->request->get['filter_month'])) {
			$url .= '&filter_month=' . $this->request->get['filter_month'];
		}

		if (isset($this->request->get['filter_year'])) {
			$url .= '&filter_year=' . $this->request->get['filter_year'];
		}

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}

		if (isset($this->request->get['filter_name_id'])) {
			$url .= '&filter_name_id=' . $this->request->get['filter_name_id'];
		}

		if (isset($this->request->get['filter_transaction_type'])) {
			$url .= '&filter_transaction_type=' . $this->request->get['filter_transaction_type'];
		}

		if (isset($this->request->get['filter_doctor'])) {
			$url .= '&filter_doctor=' . $this->request->get['filter_doctor'];
		}

		if (isset($this->request->get['filter_type'])) {
			$url .= '&filter_type=' . $this->request->get['filter_type'];
		}

		$url .= "&first=0";
		
		$this->redirect($this->url->link('bill/bill_payment', 'token=' . $this->session->data['token'].$url, 'SSL'));
	}

	public function generate_csv(){
		if (isset($this->request->get['filter_bill_id'])) {
			$filter_bill_id = $this->request->get['filter_bill_id'];
		} else {
			$filter_bill_id = '';
		}

		if (isset($this->request->get['filter_batch_id'])) {
			$filter_batch_id = $this->request->get['filter_batch_id'];
		} else {
			$filter_batch_id = '';
		}

		if (isset($this->request->get['filter_doctor'])) {
			$filter_doctor = $this->request->get['filter_doctor'];
		} else {
			$filter_doctor = 1;
		}

		$data = array(
			'filter_bill_id' 		 => $filter_bill_id,
			'filter_batch_id' 		 => $filter_batch_id,
			'filter_doctor' 		 => $filter_doctor
		);


		$this->load->model('bill/print_invoice');		
		$resultss = $this->model_bill_print_invoice->getbillpayment($data);

		$batch_id = $this->model_bill_print_invoice->getlastbatchid();	
		
		//echo '<pre>';
		//print_r($resultss);
		//echo '<pre>';
		//print_r($batch_id);
		//exit;		

		$data = array();
		foreach ($resultss as $rkey => $result) {
			if($filter_batch_id == ''){	
				$bill_owners = $this->model_bill_print_invoice->getbillowners_accept($result['bill_id']);
				foreach ($bill_owners as $bkey => $bvalue) {
					$this->model_bill_print_invoice->updatebatchid($bvalue['id'], $batch_id);
				}
			}
			
			$horse_name = $this->model_bill_print_invoice->get_horse_name($result['horse_id']);
			$trainer_name = $this->model_bill_print_invoice->get_trainer_name($result['trainer_id']);
			
			if($result['doctor_id'] == 1){
				$doctor_name = DOCTORNAME1;	
			} elseif ($result['doctor_id'] == 2) {
				$doctor_name = DOCTORNAME2;
			}
			//$doctor_name = $this->model_bill_print_invoice->get_doctor_name($result['doctor_id']);
			//echo $doctor_name;exit;
			$date = '01-'.$result['month'].'-'.$result['year'];
			$month_str = date('M-y', strtotime($date));
			$bill_seq = '';
			for ($i=1; $i <= $result['b_id']; $i++) { 
				if($i == $result['b_id']){
					$bill_seq .= $i; 
				} else {
					$bill_seq .= $i.'/'; 
				}
			}
			$bill_no = $result['bill_id'].'/'.$bill_seq.'.';
			$vet_bill_sql = 'vet bl#'.$bill_no.','.$month_str.','.$doctor_name;
			$data[] = array(
				'BILLNO' => ''.$bill_no.'',
				'TRAINER' => $trainer_name,
				'HORSE' => $horse_name,
				'AMOUNT' => $result['o_amt'],
				'MONTH/YR' => $month_str,
				'VETBILL' => $vet_bill_sql
			);
		}

		// echo '<pre>';
		// print_r($data);
		// exit;
		
		if($data){
			$template = new Template();		
			$template->data['final_datas'] = $data;
			$template->data['dop'] = date('d/m/Y');
			$template->data['title'] = 'BILLPAYMENT';
			if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
				$template->data['base'] = HTTPS_SERVER;
			} else {
				$template->data['base'] = HTTP_SERVER;
			}
			$html = $template->fetch('bill/bill_payment_html.tpl');
			//echo $html;exit;
			$filename = 'BILL_PAYMENT';
			header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
			header("Content-Disposition: attachment; filename=".$filename.".xls");//File name extension was wrong
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Cache-Control: private",false);
			print $html;			
			exit;
		} else {
			$this->session->data['warning'] = 'No Data Available';
			$this->redirect($this->url->link('bill/bill_payment', 'token=' . $this->session->data['token'], 'SSL'));		
		}
		
	}

	public function generate_payment_csv(){
		if (isset($this->request->get['filter_bill_id'])) {
			$filter_bill_id = $this->request->get['filter_bill_id'];
		} else {
			$filter_bill_id = '';
		}

		if (isset($this->request->get['filter_batch_id'])) {
			$filter_batch_id = $this->request->get['filter_batch_id'];
		} else {
			$filter_batch_id = '';
		}

		if (isset($this->request->get['filter_month'])) {
			$filter_month = $this->request->get['filter_month'];
		} else {
			$filter_month = '';
		}

		if (isset($this->request->get['filter_year'])) {
			$filter_year = $this->request->get['filter_year'];
		} else {
			$filter_year = '';
		}

		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = '';
		}

		if (isset($this->request->get['filter_name_id'])) {
			$filter_name_id = $this->request->get['filter_name_id'];
		} else {
			$filter_name_id = '';
		}

		if (isset($this->request->get['filter_transaction_type'])) {
			$filter_transaction_type = $this->request->get['filter_transaction_type'];
		} else {
			$filter_transaction_type = '';
		}

		if (isset($this->request->get['filter_doctor'])) {
			$filter_doctor = $this->request->get['filter_doctor'];
		} else {
			$filter_doctor = '';
		}

		if (isset($this->request->get['filter_type'])) {
			$filter_type = $this->request->get['filter_type'];
		} else {
			$filter_type = '';
		}

		$data = array(
			'filter_bill_id'	     => $filter_bill_id, 
			'filter_batch_id'	     => $filter_batch_id, 
			'filter_month'	     => $filter_month, 
			'filter_year'	     => $filter_year, 
			'filter_name'            => $filter_name,
			'filter_name_id'         => $filter_name_id,
			'filter_transaction_type' => $filter_transaction_type,
			'filter_doctor' => $filter_doctor,
			'filter_type' => $filter_type,
			//'start'                  => ($page - 1) * 7000,
			//'limit'                  => 7000
		);


		$this->load->model('bill/print_invoice');		
		$results = $this->model_bill_print_invoice->getbills_rwitc($data);
		//$bill_ids = $this->model_bill_print_invoice->getbillids_groups($data);
		//$bill_owner_groups = $this->model_bill_print_invoice->getbillowner_groups($data);
		$bill_checklist = array();
		$old_bill_id = 0;
		$i = 0;
		foreach ($results as $result) {
			if($old_bill_id != $result['bill_id']){
				$i = 1;
			}
			$old_bill_id = $result['bill_id'];
			$horse_name = $this->model_bill_print_invoice->get_horse_name($result['horse_id']);
			$owner_name = $this->model_bill_print_invoice->get_owner_name($result['owner_id']);
			$trainer_name = $this->model_bill_print_invoice->get_trainer_name($result['trainer_id']);
			$bill_checklist[] = array(
				'bill_id' 	 => $result['bill_id'].'-'.$i.'.',
				'id' 	 => $result['id'],
				'horse_name' => $horse_name,
				'owner_name' => $owner_name,
				'trainer_name' => $trainer_name,
				'total'      => $result['owner_amt'],
			);
			$i ++;
		}

		// echo '<pre>';
		// print_r($data);
		// exit;
		
		if($bill_checklist){
			$template = new Template();		
			$template->data['final_datas'] = $bill_checklist;
			$template->data['dop'] = date('d/m/Y');
			$template->data['title'] = 'PAYMENT STATUS';
			if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
				$template->data['base'] = HTTPS_SERVER;
			} else {
				$template->data['base'] = HTTP_SERVER;
			}
			$html = $template->fetch('bill/bill_payment_status_html.tpl');
			//echo $html;exit;
			if($filter_type == '1'){
				$type = 'All';
			} elseif($filter_type == '2'){
				$type = 'ACCEPTED';	
			} elseif($filter_type == '3'){
				$type = 'DEFAULTER';	
			} elseif($filter_type == '4'){
				$type = 'UNPROCESSED';
			}
			$filename = 'PAYMENT_STATUS_'.$type;	
			header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
			header("Content-Disposition: attachment; filename=".$filename.".xls");//File name extension was wrong
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Cache-Control: private",false);
			print $html;			
			exit;
		} else {
			$this->session->data['warning'] = 'No Data Available';
			$this->redirect($this->url->link('bill/bill_payment', 'token=' . $this->session->data['token'], 'SSL'));		
		}
		
	}

	public function import_data(){
		//$this->log->write(print_r($_FILES,true));
		$uploaddir = DIR_DOWNLOAD;
		if(isset($_FILES['afile'])){
			$uploadfile = $uploaddir . basename($_FILES['afile']['name']);
			if(basename($_FILES['afile']['name']) == 'VETHOLD.csv') {
				if (move_uploaded_file($_FILES['afile']['tmp_name'], $uploadfile)) {
					//$destFile = DIR_DOWNLOAD.basename($_FILES['afile']['name']);
					//chmod($destFile, 0777);
					$t = DIR_DOWNLOAD."VETHOLD.csv";
					$file=fopen($t,"r");
					$i=1;
					while(($var=fgetcsv($file,1000,","))!==FALSE){
						if($i != 1) {
							$owner_code=addslashes($var[0]);//owner_code
							$owner_string=addslashes($var[4]);//string
							$jv_no = '';
							if(isset($var[6])){
								$jv_no = $var[6];
							}
							$jv_no=addslashes($jv_no);//jv_no
							$dr_no = '';
							if(isset($var[5])){
								$dr_no = $var[5];
							}
							$dr_no=addslashes($jv_no);//jv_no
							$owner_string_explode = explode(',', $owner_string);
							if(isset($owner_string_explode[2])){
								//if(strtolower($owner_string_explode[2]) == strtolower('DR.KHAMBATTA') || strtolower($owner_string_explode[2]) == strtolower('Dr.P.T.Khambatta')  || strtolower($owner_string_explode[2]) == strtolower('DR.LEILA F.')){
								if($var[5] == 'GZP132' || $var[5] == 'GZL026'){
									$month_year = str_replace("\'", "", $owner_string_explode[1]);
									if(strtolower($month_year) == strtolower('APR15') || strtolower($month_year) == strtolower('MAY15') || strtolower($month_year) == strtolower('JUN15')  || strtolower($month_year[1]) == strtolower('JUL15') ){
									//if(strtolower($month_year) == strtolower("APR15")){
										$bill_id_explodes = explode('VET#', $owner_string_explode[0]);
										if(!isset($bill_id_explodes[1])){
											$bill_id_explodes = explode('VET BL#', $owner_string_explode[0]);	
										}
										$bill_id_explode = explode('/', $bill_id_explodes[1]);
										$bill_id = $bill_id_explode[0];

										if($jv_no != ''){
											$this->log->write('---start---');
											$bill_amount_sql = "SELECT `owner_amt` FROM `oc_bill_owner` WHERE `bill_id` = '".$bill_id."' AND `owner_code` = '".$owner_code."' ";
											$this->log->write($bill_amount_sql);
											$bill_amount_results = $this->db->query($bill_amount_sql);
											$bill_amount = 0;
											$var_stat = 1;
											if($bill_amount_results->num_rows > 0){
												$var_stat = 2;
												$bill_amount = $bill_amount_results->row['owner_amt'];
											}
											$dop = date('Y-m-d');
											$update = "UPDATE `oc_bill_owner` SET `payment_status` = '1', `accept` = '2', `owner_amt_rec` = '".(float)$bill_amount."', `var_stat` = '".$var_stat."', `dop` = '".$dop."' WHERE `bill_id` = '".$bill_id."' AND `owner_code` = '".$owner_code."' ";
											$this->log->write($update);
											$this->log->write('---end---');
											//echo $update;
											//echo '<br />';
											$this->db->query($update); 
										} else {
											$this->log->write('---start---');
											$bill_amount_sql = "SELECT `owner_amt` FROM `oc_bill_owner` WHERE `bill_id` = '".$bill_id."' AND `owner_code` = '".$owner_code."' ";
											$this->log->write($bill_amount_sql);
											$bill_amount_results = $this->db->query($bill_amount_sql);
											$bill_amount = 0;
											if($bill_amount_results->num_rows > 0){
												$var_stat = 2;
												$this->log->write('owner code exist: '. $owner_code);
											} else {
												$var_stat = 1;
												$this->log->write('owner code does not exist: '. $owner_code);
											}

											$update = "UPDATE `oc_bill_owner` SET `payment_status` = '2', `accept` = '2', `var_stat` = '".$var_stat."' WHERE `bill_id` = '".$bill_id."' AND `owner_code` = '".$owner_code."' ";
											$this->log->write($update);
											$this->log->write('---end---');
											//echo $update;
											//echo '<br />';
											$this->db->query($update);
										}
									}
								}
							}
						}
						$i++;
					}
					echo '1';		
				}
			} else {
				echo '0';
			}
		} else {
			echo '0';
		} 
	}
}
?>