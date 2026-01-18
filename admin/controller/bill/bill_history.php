<?php
class ControllerBillBillHistory extends Controller { 
	public function getDuplicate() {
		$this->load->model('bill/print_invoice');
		$this->model_bill_print_invoice->getallRl(01, 2015);
		
	}

	public function index() {  
		$this->language->load('bill/bill_history');

		$this->document->setTitle($this->language->get('heading_title'));

		if (isset($this->request->get['filter_date_start'])) {
			$filter_date_start = $this->request->get['filter_date_start'];
		} else {
			$filter_date_start = '';
		}

		if (isset($this->request->get['filter_date_end'])) {
			$filter_date_end = $this->request->get['filter_date_end'];
		} else {
			$filter_date_end = '';
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

		if (isset($this->request->get['filter_owner'])) {
			$filter_owner = $this->request->get['filter_owner'];
		} else {
			$filter_owner = '';
		}

		if (isset($this->request->get['filter_owner_id'])) {
			$filter_owner_id = $this->request->get['filter_owner_id'];
		} else {
			$filter_owner_id = '';
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

		if (isset($this->request->get['filter_doctor'])) {
			$filter_doctor = $this->request->get['filter_doctor'];
		} else {
			$filter_doctor = '1';
		}

		if (isset($this->request->get['filter_bill_id'])) {
			$filter_bill_id = $this->request->get['filter_bill_id'];
		} else {
			$filter_bill_id = '';
		}

		if (isset($this->request->get['filter_transaction_type'])) {
			$filter_transaction_type = $this->request->get['filter_transaction_type'];
		} else {
			$filter_transaction_type = '';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}

		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}

		if (isset($this->request->get['filter_name_id'])) {
			$url .= '&filter_name_id=' . $this->request->get['filter_name_id'];
		}

		if (isset($this->request->get['filter_owner'])) {
			$url .= '&filter_owner=' . $this->request->get['filter_owner'];
		}

		if (isset($this->request->get['filter_owner_id'])) {
			$url .= '&filter_owner_id=' . $this->request->get['filter_owner_id'];
		}

		if (isset($this->request->get['filter_trainer'])) {
			$url .= '&filter_trainer=' . $this->request->get['filter_trainer'];
		}

		if (isset($this->request->get['filter_trainer_id'])) {
			$url .= '&filter_trainer_id=' . $this->request->get['filter_trainer_id'];
		}

		if (isset($this->request->get['filter_doctor'])) {
			$url .= '&filter_doctor=' . $this->request->get['filter_doctor'];
		}

		if (isset($this->request->get['filter_bill_id'])) {
			$url .= '&filter_bill_id=' . $this->request->get['filter_bill_id'];
		}

		if (isset($this->request->get['filter_transaction_type'])) {
			$url .= '&filter_transaction_type=' . $this->request->get['filter_transaction_type'];
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
			'href'      => $this->url->link('bill/bill_history', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$this->load->model('bill/print_invoice');

		$this->data['bill_checklist'] = array();

		$data = array(
			'filter_date_start'	     => $filter_date_start, 
			'filter_date_end'	     => $filter_date_end, 
			'filter_name'            => $filter_name,
			'filter_name_id'         => $filter_name_id,
			'filter_owner'           => $filter_owner_id,
			'filter_owner_name'      => $filter_owner,
			'filter_trainer'         => $filter_trainer,
			'filter_trainer_id'      => $filter_trainer_id,
			'filter_doctor'			 => $filter_doctor,
			'filter_transaction_type' => $filter_transaction_type,
			'filter_bill_id' 		 => $filter_bill_id,
			'start'                  => ($page - 1) * 7000,
			'limit'                  => 7000
		);

		$order_total = 0;
		if(isset($this->request->get['first']) && $this->request->get['first'] == 0){
			$bill_ids = $this->model_bill_print_invoice->getbillids_groups($data);
			//$bill_owner_groups = $this->model_bill_print_invoice->getbillowner_groups($data);
			foreach ($bill_ids as $bill_id) {
				$data['filter_bill_id'] = $bill_id['bill_id'];
				$owner_datas = $this->model_bill_print_invoice->getbillowners($data);
				// echo '<pre>';
				// print_r($bill_ids);
				// exit;
				$i = 1;				
				foreach($owner_datas as $okey => $result){
					$action = array();
					$action[] = array(
						'text' => $this->language->get('text_print'),
						'href' => $this->url->link('bill/bill_history/printinvoiceone', 'token=' . $this->session->data['token'] . '&filter_horse_id=' . $result['horse_id'] . '&filter_bill_id=' . $result['bill_id'] . '&filter_owner=' . $result['owner_id'].'&filter_i='.$i, 'SSL')
					);
					$owner_transactiontype = $this->model_bill_print_invoice->get_owner_transactiontype($result['owner_id']);
					if($owner_transactiontype == 1){
						$action[] = array(
							'text' => $this->language->get('text_print_receipt'),
							'href' => $this->url->link('bill/bill_history/printreceiptone', 'token=' . $this->session->data['token'] . '&filter_horse_id=' . $result['horse_id'] . '&filter_bill_id=' . $result['bill_id'] . '&filter_owner=' . $result['owner_id'].'&filter_i='.$i, 'SSL')
						);
					}

					$action[] = array(
						'text' => $this->language->get('text_mail'),
						'href' => $this->url->link('bill/bill_history/configuremail', 'token=' . $this->session->data['token'] . '&filter_horse_id=' . $result['horse_id'] . '&filter_bill_id=' . $result['bill_id'] . '&filter_owner=' . $result['owner_id'].'&filter_i='.$i, 'SSL')
					);

					$horse_name = $this->model_bill_print_invoice->get_horse_name($result['horse_id']);
					$owner_name = $this->model_bill_print_invoice->get_owner_name($result['owner_id']);
					$trainer_name = $this->model_bill_print_invoice->get_trainer_name($result['trainer_id']);
					// $horse_data = $this->model_bill_print_invoice->get_horse_data($result['horse_id']);
					// if(isset($horse_data['horse_id']) && $horse_data['horse_id'] != '0' && $horse_data['horse_id'] != ''){
					// 	$trainer_data = $this->model_bill_print_invoice->get_trainer_data($horse_data['trainer']);
					// 	$trainer_name = $trainer_data['name'];
					// } else {
					// 	$trainer_name = '';
					// }
					if(($result['transaction_type'] == 1 && $filter_transaction_type == 1) || ($result['transaction_type'] == 2 && $filter_transaction_type == 2) || ($filter_transaction_type == '') ){
						$this->data['bill_checklist'][] = array(
							'bill_id' 	 => $result['bill_id'].'-'.$result['ref_id'],
							'horse_name' => $horse_name,
							'owner_name' => $owner_name.' - '.$result['owner_id'],
							'trainer_name' => $trainer_name,
							'total'      => $this->currency->format($result['owner_amt'], $this->config->get('config_currency')),
							'raw_total' => $result['owner_amt'],
							'action'    => $action
						);
					}
					// $i ++;
				}
			}
		}
		
		// echo '<pre>';
		// print_r($this->data['bill_checklist']);
		// exit;

		$months = array(
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

		$doctors = $this->model_bill_print_invoice->getdoctors();

		$this->data['doctors'] = $doctors;

		$transaction_typess = $this->db->query("SELECT * FROM `oc_transaction_type` WHERE `doctor_id` = '1' ")->rows;
		foreach ($transaction_typess as $tkey => $tvalue) {
			$this->data['transaction_types'][$tvalue['id']] = $tvalue['transaction_type'];
		}
		
		// $this->data['transaction_types'] = array(
		// 	'1' => 'Phiroz Khambatta',
		// 	'2' => 'P.T Khambatta',
		// 	'3' => 'P.T Mumbai',
		// 	'4' => 'P.T Pune'
		// );

		if(isset($this->session->data['success'])){
			$this->data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['entry_owner'] = $this->language->get('entry_owner');
		$this->data['column_month'] = $this->language->get('column_month');
		$this->data['column_year'] = $this->language->get('column_year');
		$this->data['column_action'] = $this->language->get('column_action');

		$this->data['column_sr_no'] = $this->language->get('column_sr_no');
		$this->data['column_bill_no'] = $this->language->get('column_bill_no');
		$this->data['column_horse_name'] = $this->language->get('column_horse_name');
		$this->data['column_owner_name'] = $this->language->get('column_owner_name');
		$this->data['column_trainer_name'] = $this->language->get('column_trainer_name');
		$this->data['column_total'] = $this->language->get('column_total');

		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_month'] = $this->language->get('entry_month');
		$this->data['entry_year'] = $this->language->get('entry_year');

		$this->data['entry_date_start'] = $this->language->get('entry_date_start');
		$this->data['entry_date_end'] = $this->language->get('entry_date_end');

		$this->data['entry_doctor'] = $this->language->get('entry_doctor');
		$this->data['entry_bill_id'] = $this->language->get('entry_bill_id');
		$this->data['entry_trainer'] = $this->language->get('entry_trainer');
		$this->data['entry_transaction_type'] = $this->language->get('entry_transaction_type');	
		
		$this->data['button_filter'] = $this->language->get('button_filter');
		$this->data['button_filter_normal'] = $this->language->get('button_filter_normal');
		$this->data['button_filter_receipt'] = $this->language->get('button_filter_receipt');
		$this->data['button_generate'] = $this->language->get('button_generate');

		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['token'] = $this->session->data['token'];

		if(isset($this->session->data['warning'])){
			$this->data['error_warning'] = $this->session->data['warning'];
			unset($this->session->data['warning']);
		} else {
			$this->data['error_warning'] = '';
		}

		$url = '';

		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}

		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}

		if (isset($this->request->get['filter_name_id'])) {
			$url .= '&filter_name_id=' . $this->request->get['filter_name_id'];
		}

		if (isset($this->request->get['filter_doctor'])) {
			$url .= '&filter_doctor=' . $this->request->get['filter_doctor'];
		}

		if (isset($this->request->get['filter_owner'])) {
			$url .= '&filter_owner=' . $this->request->get['filter_owner'];
		}

		if (isset($this->request->get['filter_owner_id'])) {
			$url .= '&filter_owner_id=' . $this->request->get['filter_owner_id'];
		}

		if (isset($this->request->get['filter_trainer'])) {
			$url .= '&filter_trainer=' . $this->request->get['filter_trainer'];
		}

		if (isset($this->request->get['filter_trainer_id'])) {
			$url .= '&filter_trainer_id=' . $this->request->get['filter_trainer_id'];
		}

		if (isset($this->request->get['filter_bill_id'])) {
			$url .= '&filter_bill_id=' . $this->request->get['filter_bill_id'];
		}

		if (isset($this->request->get['filter_transaction_type'])) {
			$url .= '&filter_transaction_type=' . $this->request->get['filter_transaction_type'];
		}

		$pagination = new Pagination();
		$pagination->total = $order_total;
		$pagination->page = $page;
		$pagination->limit = 7000;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('bill/bill_history', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['filter_date_start'] = $filter_date_start;
		$this->data['filter_date_end'] = $filter_date_end;
		$this->data['filter_name'] = $filter_name;
		$this->data['filter_name_id'] = $filter_name_id;
		$this->data['filter_owner'] = $filter_owner;
		$this->data['filter_owner_id'] = $filter_owner_id;
		$this->data['filter_trainer'] = $filter_trainer;
		$this->data['filter_trainer_id'] = $filter_trainer_id;
		$this->data['filter_doctor'] = $filter_doctor;
		$this->data['filter_bill_id'] = $filter_bill_id;
		$this->data['filter_transaction_type'] = $filter_transaction_type;

		$this->template = 'bill/bill_history.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function printinvoice(){
		// echo "inn";
		// exit;
		$this->language->load('bill/print_invoice');
		$this->load->model('bill/print_invoice');

		$this->document->setTitle($this->language->get('heading_title'));

		if (isset($this->request->get['filter_date_start'])) {
			$filter_date_start = $this->request->get['filter_date_start'];
		} else {
			$filter_date_start = '';
		}

		if (isset($this->request->get['filter_date_end'])) {
			$filter_date_end = $this->request->get['filter_date_end'];
		} else {
			$filter_date_end = '';
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

		if (isset($this->request->get['filter_doctor'])) {
			$filter_doctor = $this->request->get['filter_doctor'];
		} else {
			$filter_doctor = '1';
		}

		if (isset($this->request->get['filter_owner'])) {
			$filter_owner = $this->request->get['filter_owner'];
		} else {
			$filter_owner = '';
		}

		if (isset($this->request->get['filter_owner_id'])) {
			$filter_owner_id = $this->request->get['filter_owner_id'];
		} else {
			$filter_owner_id = '';
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

		if (isset($this->request->get['filter_bill_id'])) {
			$filter_bill_id = $this->request->get['filter_bill_id'];
		} else {
			$filter_bill_id = '';
		}

		if (isset($this->request->get['filter_transaction_type'])) {
			$filter_transaction_type = $this->request->get['filter_transaction_type'];
		} else {
			$filter_transaction_type = '';
		}

		//echo 'out';exit;

		$data = array(
			'filter_date_start'	     => $filter_date_start, 
			'filter_date_end'	     => $filter_date_end, 
			'filter_name'            => $filter_name,
			'filter_name_id'         => $filter_name_id,
			//'filter_owner'           => $filter_owner,
			'filter_owner_id'        => $filter_owner_id,
			'filter_trainer'         => $filter_trainer,
			'filter_trainer_id'      => $filter_trainer_id,
			'filter_doctor'          => $filter_doctor,
			'filter_transaction_type' => $filter_transaction_type,
			'filter_bill_id' 		 => $filter_bill_id
		);

		$final_owner = array();
		$final_transaction = array();
		$final_data = array();

		
		$bill_groups = $this->model_bill_print_invoice->getbillids_groups($data);
		foreach ($bill_groups as $bkey => $bvalue) {
			$final_owner = array();
			$final_transaction = array();
			$transaction_ids = $this->model_bill_print_invoice->get_transaction_ids($bvalue['bill_id']);
			foreach ($transaction_ids as $tkey => $tvalue) {
				$transaction_data = $this->model_bill_print_invoice->get_transaction_datass($tvalue['transaction_id']);
				
				$final_transaction[$tkey]['bill_id'] = $bvalue['bill_id'];
				$final_transaction[$tkey]['transaction_id'] = $transaction_data['transaction_id'];
				$final_transaction[$tkey]['medicine_name'] = $transaction_data['medicine_name'];
				$final_transaction[$tkey]['medicine_id'] = $transaction_data['medicine_id'];
				$final_transaction[$tkey]['medicine_quantity'] = $transaction_data['medicine_quantity'];
				$final_transaction[$tkey]['medicine_total'] = $transaction_data['medicine_total'];
				$final_transaction[$tkey]['dot'] = date('d, M Y', strtotime($transaction_data['dot']));
				$final_transaction[$tkey]['month'] = $transaction_data['month'];
				$final_transaction[$tkey]['year'] = $transaction_data['year'];
			}

			$horse_data = $this->model_bill_print_invoice->get_horse_data($bvalue['horse_id']);
			if(isset($horse_data['horse_id']) && $horse_data['horse_id'] != '0' && $horse_data['horse_id'] != ''){
				$trainer_data = $this->model_bill_print_invoice->get_trainer_data($horse_data['trainer']);
				$owner_data = $this->model_bill_print_invoice->get_owner_data($bvalue['bill_id'], $horse_data['horse_id']);
				if($owner_data){
					$i = 1;
					foreach ($owner_data as $okey => $ovalue) {
						if(($ovalue['transaction_type'] == 1 && $filter_transaction_type == 1) || ($ovalue['transaction_type'] == 2 && $filter_transaction_type == 2) || ($filter_transaction_type == '') ){
							if($filter_owner_id != ''){ 
								if($ovalue['owner'] == $filter_owner_id){
									if($ovalue['share']) {
										$final_owner[$okey]['bill_id'] = $bvalue['bill_id'].'-'.$i;
										$final_owner[$okey]['doctor_id'] = $bvalue['doctor_id'];
										$owner_transactiontype = $this->model_bill_print_invoice->get_owner_transactiontype($ovalue['owner']);
										$owner_share_amount = $this->model_bill_print_invoice->get_owner_share($bvalue['bill_id'], $ovalue['owner']);
										$final_owner[$okey]['owner_share_amount'] = $owner_share_amount;
										
										$doctor_names = $this->db->query("SELECT * FROM `oc_transaction_type` WHERE `doctor_id` = '".$bvalue['doctor_id']."' AND `id` = '".$owner_transactiontype."' ");
										$doctor_name = '';
										if($doctor_names->num_rows > 0){
											$doctor_name = $doctor_names->row['transaction_type'];
										}

										$final_owner[$okey]['doctor_name'] = $doctor_name;
										$final_owner[$okey]['trainer_id'] = $bvalue['trainer_id'];
										$final_owner[$okey]['horse_id'] = $bvalue['horse_id'];
										$final_owner[$okey]['horse_name'] = $horse_data['name'];
										$final_owner[$okey]['trainer_name'] = $trainer_data['name'];
										$owner_name = $this->model_bill_print_invoice->get_owner_name($ovalue['owner']); 
										$final_owner[$okey]['owner_name'] = $owner_name;
										$final_owner[$okey]['transaction_type'] = $owner_transactiontype;
										$final_owner[$okey]['owner_id'] = $ovalue['owner'];
										$final_owner[$okey]['owner_share'] = $ovalue['share'];
										
										$month = date("F", mktime(0, 0, 0, $bvalue['month'], 10));
										$final_owner[$okey]['month'] = $month;
										$final_owner[$okey]['year'] = $bvalue['year'];

										$final_owner[$okey]['transaction_data'] = $final_transaction;
									}	
								}
							} else {
								if($filter_transaction_type != ''){ 
									$owner_transaction_type = $this->model_bill_print_invoice->get_owner_transactiontype($ovalue['owner']);							
									if($owner_transaction_type == $filter_transaction_type){	
										if($ovalue['share']) {
									
											$final_owner[$okey]['bill_id'] = $bvalue['bill_id'].'-'.$i;
											$final_owner[$okey]['doctor_id'] = $bvalue['doctor_id'];
											$owner_transactiontype = $this->model_bill_print_invoice->get_owner_transactiontype($ovalue['owner']);
											$owner_share_amount = $this->model_bill_print_invoice->get_owner_share($bvalue['bill_id'], $ovalue['owner']);
											$final_owner[$okey]['owner_share_amount'] = $owner_share_amount;

											$doctor_names = $this->db->query("SELECT * FROM `oc_transaction_type` WHERE `doctor_id` = '".$bvalue['doctor_id']."' AND `id` = '".$owner_transactiontype."' ");
											$doctor_name = '';
											if($doctor_names->num_rows > 0){
												$doctor_name = $doctor_names->row['transaction_type'];
											}

											$final_owner[$okey]['doctor_name'] = $doctor_name;
											$final_owner[$okey]['trainer_id'] = $bvalue['trainer_id'];
											$final_owner[$okey]['horse_id'] = $bvalue['horse_id'];
											$final_owner[$okey]['horse_name'] = $horse_data['name'];
											$final_owner[$okey]['trainer_name'] = $trainer_data['name'];
											$owner_name = $this->model_bill_print_invoice->get_owner_name($ovalue['owner']); 
											$final_owner[$okey]['owner_name'] = $owner_name;
											$final_owner[$okey]['transaction_type'] = $owner_transactiontype;
											$final_owner[$okey]['owner_id'] = $ovalue['owner'];
											$final_owner[$okey]['owner_share'] = $ovalue['share'];
									
											$month = date("F", mktime(0, 0, 0, $bvalue['month'], 10));
											$final_owner[$okey]['month'] = $month;
											$final_owner[$okey]['year'] = $bvalue['year'];

											$final_owner[$okey]['transaction_data'] = $final_transaction;
										}
									}
								} else {
									if($ovalue['share']) {
										$final_owner[$okey]['bill_id'] = $bvalue['bill_id'].'-'.$i;
										$final_owner[$okey]['doctor_id'] = $bvalue['doctor_id'];
										$owner_transactiontype = $this->model_bill_print_invoice->get_owner_transactiontype($ovalue['owner']);
										$owner_share_amount = $this->model_bill_print_invoice->get_owner_share($bvalue['bill_id'], $ovalue['owner']);
										$final_owner[$okey]['owner_share_amount'] = $owner_share_amount;
										
										$doctor_names = $this->db->query("SELECT * FROM `oc_transaction_type` WHERE `doctor_id` = '".$bvalue['doctor_id']."' AND `id` = '".$owner_transactiontype."' ");
										$doctor_name = '';
										if($doctor_names->num_rows > 0){
											$doctor_name = $doctor_names->row['transaction_type'];
										}

										$final_owner[$okey]['doctor_name'] = $doctor_name;
										$final_owner[$okey]['trainer_id'] = $bvalue['trainer_id'];
										$final_owner[$okey]['horse_id'] = $bvalue['horse_id'];
										$final_owner[$okey]['horse_name'] = $horse_data['name'];
										$final_owner[$okey]['trainer_name'] = $trainer_data['name'];
										$owner_name = $this->model_bill_print_invoice->get_owner_name($ovalue['owner']); 
										$final_owner[$okey]['owner_name'] = $owner_name;
										$final_owner[$okey]['transaction_type'] = $owner_transactiontype;
										$final_owner[$okey]['owner_id'] = $ovalue['owner'];
										$final_owner[$okey]['owner_share'] = $ovalue['share'];
									
										$month = date("F", mktime(0, 0, 0, $bvalue['month'], 10));
										$final_owner[$okey]['month'] = $month;
										$final_owner[$okey]['year'] = $bvalue['year'];

										$final_owner[$okey]['transaction_data'] = $final_transaction;
									}							
								}
							}
						}
						$i ++;
					}
					if($final_owner) {
						$final_data[$bkey] = $final_owner;
					}
				}
			}
		}
		
		

		$url = '';

		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}

		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}

		if (isset($this->request->get['filter_name_id'])) {
			$url .= '&filter_name_id=' . $this->request->get['filter_name_id'];
		}

		if (isset($this->request->get['filter_doctor'])) {
			$url .= '&filter_doctor=' . $this->request->get['filter_doctor'];
		}

		if (isset($this->request->get['filter_bill_id'])) {
			$url .= '&filter_bill_id=' . $this->request->get['filter_bill_id'];
		}

		if (isset($this->request->get['filter_owner'])) {
			$url .= '&filter_owner=' . $this->request->get['filter_owner'];
		}

		if (isset($this->request->get['filter_owner_id'])) {
			$url .= '&filter_owner_id=' . $this->request->get['filter_owner_id'];
		}

		if (isset($this->request->get['filter_trainer'])) {
			$url .= '&filter_trainer=' . $this->request->get['filter_trainer'];
		}

		if (isset($this->request->get['filter_trainer_id'])) {
			$url .= '&filter_trainer_id=' . $this->request->get['filter_trainer_id'];
		}

		if (isset($this->request->get['filter_transaction_type'])) {
			$url .= '&filter_transaction_type=' . $this->request->get['filter_transaction_type'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		$url .= '&first=0';

		if($final_data){
			//$month = date('m', strtotime($filter_date_start));
			//$year = date('Y', strtotime($filter_date_start));
			//$month = date("F", mktime(0, 0, 0, $month, 10));
			$template = new Template();		
			$template->data['final_datas'] = $final_data;
			//$template->data['month'] = $month;
			//$template->data['year'] = $year;
			$template->data['title'] = 'Invoice';
			$template->data['text_invoice'] = 'Invoice';

			$doctor_datas = $this->model_bill_print_invoice->get_doctor_data($filter_doctor);
			if(isset($doctor_datas['doctor_id'])){
				$template->data['email'] = $doctor_datas['email'];
				$template->data['telephone'] = $doctor_datas['mobile'];
				$template->data['address_1'] = $doctor_datas['address_1'];
				$template->data['address_3'] = $doctor_datas['address_3'];
				$template->data['address_2'] = $doctor_datas['address_2'];
			} else {
				$template->data['email'] = $this->config->get('config_email');
				$template->data['telephone'] = $this->config->get('config_telephone');
				$template->data['address_1'] = 'Raintree Veterinary Clinic and Rehabilitation Centre';
				$template->data['address_3'] = 'Plot No 33, Row House No 1, ';
				$template->data['address_2'] = 'Uday Baug, Ghorpadi, Pune, Maharashtra 411013';
			}
			
			if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
				$template->data['base'] = "http://65.21.158.15/phiroz_2020/admin/";
			} else {
				$template->data['base'] = "http://65.21.158.15/phiroz_2020/admin/";
			}
			// echo $html;
			// exit;
			$html = $template->fetch('bill/invoice_html.tpl');
			$filename = "Invoice.html";
			header('Content-type: text/html');
			//header('Set-Cookie: fileLoading=true');
			header('Content-Disposition: attachment; filename='.$filename);
			echo $html;
			exit;
		} else {
			$this->session->data['warning'] = 'No Data Found';
			$this->redirect($this->url->link('bill/bill_history', 'token=' . $this->session->data['token'].$url, 'SSL'));
		}
	}

	public function printinvoiceone(){
		// echo "outtt";
		// exit;
		$this->language->load('bill/print_invoice');
		$this->load->model('bill/print_invoice');

		$this->document->setTitle($this->language->get('heading_title'));

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

		//start--------------------------

		//end--------------------------

		$filter_month = '';
		$filter_year = '';
		//echo 'out';exit;
		$owner_name = '';
		$final_owner = array();
		$final_transaction = array();
		$transaction_ids = $this->model_bill_print_invoice->get_transaction_ids($filter_bill_id);
		$medicine_doctor_id = 0;
		foreach ($transaction_ids as $tkey => $tvalue) {
			$transaction_data = $this->model_bill_print_invoice->get_transaction_datass($tvalue['transaction_id']);
			//echo "<pre>";print_r($transaction_data);exit;
			$final_transaction[$tkey]['bill_id'] = $filter_bill_id;
			$final_transaction[$tkey]['transaction_id'] = $transaction_data['transaction_id'];
			$final_transaction[$tkey]['medicine_id'] = $transaction_data['medicine_id'];
			$final_transaction[$tkey]['medicine_name'] = $transaction_data['medicine_name'];
			$final_transaction[$tkey]['medicine_quantity'] = $transaction_data['medicine_quantity'];
			$final_transaction[$tkey]['medicine_total'] = $transaction_data['medicine_total'];
			$final_transaction[$tkey]['dot'] = date('d, M Y', strtotime($transaction_data['dot']));
			$final_transaction[$tkey]['month'] = $transaction_data['month'];
			$final_transaction[$tkey]['year'] = $transaction_data['year'];

			$filter_month = $transaction_ids[0]['month'];
			$filter_year = $transaction_ids[0]['year'];
			$medicine_doctor_id = $transaction_data['medicine_doctor_id'];
		}
		$horse_data = $this->model_bill_print_invoice->get_horse_data($filter_horse_id);
		if(isset($horse_data['horse_id']) && $horse_data['horse_id'] != '0' && $horse_data['horse_id'] != ''){
			$trainer_data = $this->model_bill_print_invoice->get_trainer_data($horse_data['trainer']);
			$owner_data = $this->model_bill_print_invoice->get_owner_data($filter_bill_id, $horse_data['horse_id'], $filter_owner);
			foreach ($owner_data as $okey => $ovalue) {
				$final_owner[$okey]['bill_id'] = $filter_bill_id.'-'.$filter_i;
				$final_owner[$okey]['horse_name'] = $horse_data['name'];
				$final_owner[$okey]['trainer_name'] = $trainer_data['name'];
				$owner_name = $this->model_bill_print_invoice->get_owner_name($ovalue['owner']); 
				$final_owner[$okey]['owner_name'] = $owner_name;
				$owner_transactiontype = $this->model_bill_print_invoice->get_owner_transactiontype($ovalue['owner']); 
				$final_owner[$okey]['transaction_type'] = $owner_transactiontype;
				$final_owner[$okey]['owner_id'] = $ovalue['owner'];
				$final_owner[$okey]['owner_share'] = $ovalue['share'];

				$month = date("F", mktime(0, 0, 0, $filter_month, 10));
				$final_owner[$okey]['month'] = $month;
				$final_owner[$okey]['year'] = $filter_year;
				
				$owner_share_amount = $this->model_bill_print_invoice->get_owner_share($filter_bill_id, $ovalue['owner']);
				$final_owner[$okey]['owner_share_amount'] = $owner_share_amount;
				
				$doctor_names = $this->db->query("SELECT * FROM `oc_transaction_type` WHERE `doctor_id` = '".$medicine_doctor_id."' AND `id` = '".$owner_transactiontype."' ");
				$doctor_name = '';
				if($doctor_names->num_rows > 0){
					$doctor_name = $doctor_names->row['transaction_type'];
				}

				$final_owner[$okey]['doctor_name'] = $doctor_name;
				$final_owner[$okey]['transaction_data'] = $final_transaction;
			}
		}
		$final_data[] = $final_owner;
		
		if($final_data){
			$month = date("F", mktime(0, 0, 0, $filter_month, 10));
			$template = new Template();		
			$template->data['final_datas'] = $final_data;
			$template->data['month'] = $month;
			$template->data['year'] = $filter_year;
			$template->data['title'] = 'Invoice';
			$template->data['text_invoice'] = 'Invoice';
			
			$doctor_datas = $this->model_bill_print_invoice->get_doctor_data($medicine_doctor_id);
			if(isset($doctor_datas['doctor_id'])){
				$template->data['email'] = $doctor_datas['email'];
				$template->data['telephone'] = $doctor_datas['mobile'];
				$template->data['address_1'] = $doctor_datas['address_1'];
				$template->data['address_3'] = $doctor_datas['address_3'];
				$template->data['address_2'] = $doctor_datas['address_2'];
			} else {
				$template->data['email'] = $this->config->get('config_email');
				$template->data['telephone'] = $this->config->get('config_telephone');
				$template->data['address_1'] = 'Raintree Veterinary Clinic and Rehabilitation Centre';
				$template->data['address_3'] = 'Plot No 33, Row House No 1, ';
				$template->data['address_2'] = 'Uday Baug, Ghorpadi, Pune, Maharashtra 411013';
			}
			
			if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
				$template->data['base'] = "http://65.21.158.15/phiroz_2020/admin/";
			} else {
				$template->data['base'] = "http://65.21.158.15/phiroz_2020/admin/";
			}
			$html = $template->fetch('bill/invoice_html.tpl');
			//echo $html;exit;
			if($owner_name != ''){
				$owner_name = str_replace(array(' ', ',', '&', '.'), '_', $owner_name);
				//echo $owner_name;exit;
				$filename = "Invoice_".$owner_name.".html";
			} else {
				$filename = "Invoice.html";
			}
			// echo $html;
			// exit;
			header('Content-type: text/html');
			header('Content-Disposition: attachment; filename='.$filename);
			echo $html;
			exit;
		} else {
			$this->session->data['warning'] = 'No Data Found';
			$this->redirect($this->url->link('bill/bill_history', 'token=' . $this->session->data['token'], 'SSL'));
		}
	}

	public function printreceipt(){
		// echo "<pre>";print_r($this->request->get);
		// exit;
		$this->language->load('bill/print_receipt');
		$this->load->model('bill/print_invoice');

		$this->document->setTitle($this->language->get('heading_title'));

		if (isset($this->request->get['filter_date_start'])) {
			$filter_date_start = $this->request->get['filter_date_start'];
		} else {
			$filter_date_start = '';
		}

		if (isset($this->request->get['filter_date_end'])) {
			$filter_date_end = $this->request->get['filter_date_end'];
		} else {
			$filter_date_end = '';
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

		if (isset($this->request->get['filter_doctor'])) {
			$filter_doctor = $this->request->get['filter_doctor'];
		} else {
			$filter_doctor = '1';
		}

		if (isset($this->request->get['filter_owner'])) {
			$filter_owner = $this->request->get['filter_owner'];
		} else {
			$filter_owner = '';
		}

		if (isset($this->request->get['filter_owner_id'])) {
			$filter_owner_id = $this->request->get['filter_owner_id'];
		} else {
			$filter_owner_id = '';
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

		if (isset($this->request->get['filter_bill_id'])) {
			$filter_bill_id = $this->request->get['filter_bill_id'];
		} else {
			$filter_bill_id = '';
		}

		if (isset($this->request->get['filter_transaction_type'])) {
			$filter_transaction_type = $this->request->get['filter_transaction_type'];
		} else {
			$filter_transaction_type = '';
		}

		$data = array(
			'filter_date_start'	     => $filter_date_start, 
			'filter_date_end'	     => $filter_date_end, 
			'filter_name'            => $filter_name,
			'filter_name_id'         => $filter_name_id,
			'filter_doctor'			 => $filter_doctor,
			'filter_bill_id' 		 => $filter_bill_id,
			'filter_owner'           => $filter_owner_id,
			'filter_owner_name'      => $filter_owner,
			'filter_trainer'         => $filter_trainer,
			'filter_transaction_type' => $filter_transaction_type,
			'filter_trainer_id'      => $filter_trainer_id
		);

		$final_data = array();
		
			
		$bill_ids = $this->model_bill_print_invoice->getbillids_groups($data);

		foreach ($bill_ids as $bkey => $bvalue) {
			$data['filter_bill_id'] = $bvalue['bill_id'];
			$bill_owner_groups = $this->model_bill_print_invoice->getbillowners($data);
			$i=1;
			foreach ($bill_owner_groups as $result) {
				$horse_name = $this->model_bill_print_invoice->get_horse_name($result['horse_id']);
				$owner_name = $this->model_bill_print_invoice->get_owner_name($result['owner_id']);
				//$trainer_name = $this->model_bill_print_invoice->get_trainer_name($result['trainer_id']);
				
				$horse_data = $this->model_bill_print_invoice->get_horse_data($result['horse_id']);
				if(isset($horse_data['horse_id']) && $horse_data['horse_id'] != '0' && $horse_data['horse_id'] != ''){
					$trainer_data = $this->model_bill_print_invoice->get_trainer_data($horse_data['trainer']);
					$trainer_name = $trainer_data['name'];
				} else {
					$trainer_name = '';
				}

				$doctor_name = $this->model_bill_print_invoice->get_doctor_name($result['doctor_id']);
				$owner_transactiontype = $this->model_bill_print_invoice->get_owner_transactiontype($result['owner_id']);
				$month = date("F", mktime(0, 0, 0, $bvalue['month'], 10));
				$year = $bvalue['year'];

				$discount = $result['owner_amt'] - $result['discount'];
				
					if($owner_transactiontype == 1){
						$final_data[] = array(
							'bill_id' 	 => $result['bill_id'].'-'.$i,
							'invoice_date' 	 => $result['dop'],
							'horse_name' => $horse_name,
							'owner_name' => $owner_name,
							'owner_share' => $result['owner_share'],
							'owner_amt' => $result['owner_amt'],
							'trainer_name' => $trainer_name,
							'doctor_name' => $doctor_name,
							'month' => $month,
							'year'  => $year,
							'discount'  => $result['discount'],
							'total'      => 'Rs.'.' '.$discount,
						);
					}
				$i ++;
			}
		}

		$url = '';

		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}

		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}

		if (isset($this->request->get['filter_name_id'])) {
			$url .= '&filter_name_id=' . $this->request->get['filter_name_id'];
		}

		if (isset($this->request->get['filter_doctor'])) {
			$url .= '&filter_doctor=' . $this->request->get['filter_doctor'];
		}

		if (isset($this->request->get['filter_bill_id'])) {
			$url .= '&filter_bill_id=' . $this->request->get['filter_bill_id'];
		}

		if (isset($this->request->get['filter_owner'])) {
			$url .= '&filter_owner=' . $this->request->get['filter_owner'];
		}

		if (isset($this->request->get['filter_owner_id'])) {
			$url .= '&filter_owner_id=' . $this->request->get['filter_owner_id'];
		}

		if (isset($this->request->get['filter_trainer'])) {
			$url .= '&filter_trainer=' . $this->request->get['filter_trainer'];
		}

		if (isset($this->request->get['filter_trainer_id'])) {
			$url .= '&filter_trainer_id=' . $this->request->get['filter_trainer_id'];
		}

		if (isset($this->request->get['filter_transaction_type'])) {
			$url .= '&filter_transaction_type=' . $this->request->get['filter_transaction_type'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		$url .= '&first=0';
		
		// echo '<pre>';
		// print_r($final_data);
		// exit;

		if($final_data){
			//$month = date('m', strtotime($filter_date_start));
			//$year = date('Y', strtotime($filter_date_start));
			//$month = date("F", mktime(0, 0, 0, $month, 10));
			$template = new Template();		
			$template->data['final_data'] = $final_data;
			//$template->data['month'] = $month;
			//$template->data['year'] = $year;
			$template->data['tdate'] = '06, '.date('M Y');
			$template->data['title'] = 'Receipt';
			$template->data['text_invoice'] = 'Receipt';
			$doctor_datas = $this->model_bill_print_invoice->get_doctor_data($filter_doctor);
			if(isset($doctor_datas['doctor_id'])){
				$template->data['email'] = $doctor_datas['email'];
				$template->data['telephone'] = $doctor_datas['mobile'];
				$template->data['address_1'] = $doctor_datas['address_1'];
				$template->data['address_2'] = $doctor_datas['address_2'];
			} else {
				$template->data['email'] = $this->config->get('config_email');
				$template->data['telephone'] = $this->config->get('config_telephone');
				$template->data['address_1'] = '1202 Forum, Uday Baug';
				$template->data['address_2'] = 'Pune, Maharashtra 4110313';
			}
			if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
				$template->data['base'] = "http://65.21.158.15/phiroz_2020/admin/";
			} else {
				$template->data['base'] = "http://65.21.158.15/phiroz_2020/admin/";
			}
			$html = $template->fetch('bill/receipt_html.tpl');
			$filename = "Owner_Receipt.html";
			header('Content-type: text/html');
			header('Set-Cookie: fileLoading=true');
			header('Content-Disposition: attachment; filename='.$filename);
			echo $html;
		} else {
			$this->session->data['warning'] = 'No Data Found';
			$this->redirect($this->url->link('bill/bill_history', 'token=' . $this->session->data['token'].$url, 'SSL'));
		}
	}

	public function printreceiptone(){
		$this->language->load('bill/print_receipt');
		$this->load->model('bill/print_invoice');

		$this->document->setTitle($this->language->get('heading_title'));

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

		$filter_month = '';
		$filter_year = '';

		$data = array(
			'filter_bill_id'         => $filter_bill_id,
			'filter_horse_id'        => $filter_horse_id,
			'filter_owner'           => $filter_owner
		);

		$final_data = array();
		$bill_owner_groups = $this->model_bill_print_invoice->getbillowners($data);
		foreach ($bill_owner_groups as $result) {
			$horse_name = $this->model_bill_print_invoice->get_horse_name($result['horse_id']);
			$owner_name = $this->model_bill_print_invoice->get_owner_name($result['owner_id']);
			$trainer_name = $this->model_bill_print_invoice->get_trainer_name($result['trainer_id']);
			
			// $horse_data = $this->model_bill_print_invoice->get_horse_data($result['horse_id']);
			// if(isset($horse_data['horse_id']) && $horse_data['horse_id'] != '0' && $horse_data['horse_id'] != ''){
			// 	$trainer_data = $this->model_bill_print_invoice->get_trainer_data($horse_data['trainer']);
			// 	$trainer_name = $trainer_data['name'];
			// } else {
			// 	$trainer_name = '';
			// }
			$medicine_doctor_id = $result['doctor_id'];
			$doctor_name = $this->model_bill_print_invoice->get_doctor_name($result['doctor_id']);
			$owner_transactiontype = $this->model_bill_print_invoice->get_owner_transactiontype($result['owner_id']);
			
			$bill_datas = $this->model_bill_print_invoice->getbillmonyear($result['bill_id']);
			$month = date("F", mktime(0, 0, 0, $bill_datas['month'], 10));
			$year = $bill_datas['year'];

			if($owner_transactiontype == 1){
				$final_data[] = array(
					'bill_id' 	 => $result['bill_id'].'-'.$filter_i,
					'invoice_date' 	 => $result['dop'],
					'horse_name' => $horse_name,
					'owner_name' => $owner_name,
					'owner_share' => $result['owner_share'],
					'owner_amt' => $result['owner_amt'],
					'trainer_name' => $trainer_name,
					'doctor_name' => $doctor_name,
					'month'   => $month,
					'year'   => $year,
					'total'      => $this->currency->format($result['owner_amt'], $this->config->get('config_currency'))
				);
			}

			$filter_month = $result['month'];
			$filter_year = $result['year'];
		}

		if($final_data){
			$month = date("F", mktime(0, 0, 0, $filter_month, 10));
			$template = new Template();		
			$template->data['final_data'] = $final_data;
			$template->data['month'] = $month;
			$template->data['year'] = $filter_year;
			$template->data['tdate'] = '06, '.date('M Y');
			$template->data['title'] = 'Receipt';
			$template->data['text_invoice'] = 'Receipt';
			$doctor_datas = $this->model_bill_print_invoice->get_doctor_data($medicine_doctor_id);
			if(isset($doctor_datas['doctor_id'])){
				$template->data['email'] = $doctor_datas['email'];
				$template->data['telephone'] = $doctor_datas['mobile'];
				$template->data['address_1'] = $doctor_datas['address_1'];
				$template->data['address_2'] = $doctor_datas['address_2'];
			} else {
				$template->data['email'] = $this->config->get('config_email');
				$template->data['telephone'] = $this->config->get('config_telephone');
				$template->data['address_1'] = '1202 Forum, Uday Baug';
				$template->data['address_2'] = 'Pune, Maharashtra 4110313';
			}
			if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
				$template->data['base'] = "http://65.21.158.15/phiroz_2020/admin/";
			} else {
				$template->data['base'] = "http://65.21.158.15/phiroz_2020/admin/";
			}
			$html = $template->fetch('bill/receipt_html.tpl');
			if($owner_name != ''){
				$owner_name = str_replace(array(' ', ',', '&', '.'), '_', $owner_name);
				$filename = "Owner_Receipt_".$owner_name.".html";
			} else {
				$filename = "Owner_Receipt.html";
			}
			header('Content-type: text/html');
			//header('Set-Cookie: fileLoading=true');
			header('Content-Disposition: attachment; filename='.$filename);
			echo $html;
		} else {
			$this->session->data['warning'] = 'No Data Found';
			$this->redirect($this->url->link('bill/bill_history', 'token=' . $this->session->data['token'], 'SSL'));
		}
	}

	public function configuremail(){

		$this->language->load('bill/bill_history');
		$this->load->model('bill/print_invoice');

		$this->document->setTitle($this->language->get('heading_title_mail'));
		
		$this->data['heading_title'] = $this->language->get('heading_title_mail');

		$this->data['button_mail'] = $this->language->get('button_mail');
		$this->data['entry_email'] = $this->language->get('entry_email');
		$this->data['filter_mail'] = '';
		$this->data['token'] = $this->session->data['token'];

		$show_html = 0;
		$invoice_mail_html = $this->invoice_mail_html($show_html);
		$this->data['invoice_mail_html'] = str_replace(array("\r", "\n"), '', $invoice_mail_html);

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
		
		$this->load->model('bill/print_invoice');
		$owner_email = $this->model_bill_print_invoice->get_owner_email($filter_owner);	

		$this->data['filter_bill_id'] = $filter_bill_id;
		$this->data['filter_horse_id'] = $filter_horse_id;
		$this->data['filter_owner'] = $filter_owner;
		$this->data['filter_i'] = $filter_i;
		$this->data['filter_mail'] = $owner_email;//'fargose.aaron@gmail.com';


		$this->template = 'bill/configure_mail.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function send_mail(){
		$this->language->load('bill/bill_history');
		$this->load->model('bill/print_invoice');
		$this->document->setTitle($this->language->get('heading_title_mail'));
		$this->data['heading_title'] = $this->language->get('heading_title_mail');

		//$show_html = 1;
		$invoice_mail_html = $this->invoice_mail_html_server();
		$invoice_mail_html = str_replace(array("\r", "\n"), '', $invoice_mail_html);
		
		if (isset($this->request->get['filter_mail'])) {
			$filter_mail = $this->request->get['filter_mail'];
		} else {
			$filter_mail = '';
		}

		if (isset($this->request->get['filter_bill_id'])) {
			$filter_bill_id = $this->request->get['filter_bill_id'];
		} else {
			$filter_bill_id = '';
		}

		if (isset($this->request->get['filter_owner'])) {
			$filter_owner = $this->request->get['filter_owner'];
		} else {
			$filter_owner = '';
		}

		if (isset($this->request->get['filter_horse_id'])) {
			$filter_horse_id = $this->request->get['filter_horse_id'];
		} else {
			$filter_horse_id = '';
		}

		$medicine_doctor_id = $this->model_bill_print_invoice->getbilldoctorid($filter_bill_id);
		$owner_transactiontype = $this->model_bill_print_invoice->get_owner_transactiontype($filter_owner);
		$owner_name = $this->model_bill_print_invoice->get_owner_name($filter_owner); 
		
		$doctor_names = $this->db->query("SELECT * FROM `oc_transaction_type` WHERE `doctor_id` = '".$medicine_doctor_id['doctor_id']."' AND `id` = '".$owner_transactiontype."' ");
		//echo "SELECT * FROM `oc_transaction_type` WHERE `doctor_id` = '".$medicine_doctor_id."' AND `id` = '".$owner_transactiontype."' ";exit;
		$doctor_name = '';
		if($doctor_names->num_rows > 0){
			$doctor_name = $doctor_names->row['transaction_type'];
		}

		// if($medicine_doctor_id == 1){
		// 	if($owner_transactiontype == 1){
		// 		$doctor_name = DOCTORNAME1;
		// 	} elseif($owner_transactiontype == 2) {
		// 		$doctor_name = DOCTORNAME11;
		// 	} else {
		// 		$doctor_name = DOCTORNAME1;
		// 	}
		// } elseif($medicine_doctor_id == 2) {
		// 	if($owner_transactiontype == 1){
		// 		$doctor_name = DOCTORNAME2;
		// 	} elseif($owner_transactiontype == 2) {
		// 		$doctor_name = DOCTORNAME21;
		// 	} else {
		// 		$doctor_name = DOCTORNAME2;
		// 	}
		// } else {
		// 	if($owner_transactiontype == 1){
		// 		$doctor_name = DOCTORNAME1;
		// 	} elseif($owner_transactiontype == 2) {
		// 		$doctor_name = DOCTORNAME11;
		// 	} else {
		// 		$doctor_name = DOCTORNAME1;
		// 	}
		// }

		$subject = 'Invoice Details';

		$invoice_mail_text = $this->invoice_mail_text($doctor_name, $medicine_doctor_id);
		$invoice_mail_text = str_replace(array("\r", "\n"), '', $invoice_mail_text);
		
		$owner_name = $this->model_bill_print_invoice->get_owner_name($filter_owner); 
		if($owner_name != ''){
			$owner_name = str_replace(array(' ', ',', '&', '.'), '_', $owner_name);
			$path = DIR_DOWNLOAD."Invoice_".$owner_name.".html";
		} else {
			$path = DIR_DOWNLOAD."Invoice.html";
		}

		$data['sendmail'] = 1;
		$data['from_email'] = 'phiroz2017@gmail.com';//$this->config->get('config_email');
		$data['to_email'] = $filter_mail;
		$data['subject'] = $subject;
		$data['invoice_mail_text'] = $invoice_mail_text;
		$data['doctor_name'] = $doctor_name;
		$data['to_name'] = $owner_name;
		$data['invoice_mail_html'] = $invoice_mail_html;
		
		$url = 'http://125.99.122.186/openchr/';
		$data = json_encode($data);
		$ch = curl_init($url);
		//set the url, number of POST vars, POST data
		//curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
			'Content-Type: application/json',                                                                                
			'Content-Length: ' . strlen($data))                                                                       
		); 
		curl_setopt($ch,CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		//execute post
		$result = curl_exec($ch);
		//close connection
		curl_close($ch);
		//decode the result
		$data = json_decode($result, true);
		if($data['success'] == 1){
			echo 'Mail Send, Please Close This Window';			
		} else {
			echo 'Mail Not Sent Please try again, Please Close This Window';		
		}
		exit;		

		/*
		$mail = new Mail();
		$mail->protocol = $this->config->get('config_mail_protocol');
		$mail->parameter = $this->config->get('config_mail_parameter');
		$mail->hostname = $this->config->get('config_smtp_host');
		$mail->username = $this->config->get('config_smtp_username');
		$mail->password = $this->config->get('config_smtp_password');
		$mail->port = $this->config->get('config_smtp_port');
		$mail->timeout = $this->config->get('config_smtp_timeout');
		$mail->setTo($filter_mail);
		$mail->setFrom($this->config->get('config_email'));
		$mail->setSender($doctor_name);
		$mail->setSubject($subject);
		//$mail->setHtml($invoice_mail_html);
		$mail->setText($invoice_mail_text);
		$mail->addAttachment($path);
		$mail->send();
		$this->log->write('mail send');
		*/
		echo 'Mail Send, Please Close This Window';
	}

	public function invoice_mail_text($doctor_name, $doctor_id){
		$this->language->load('bill/print_invoice');
		$this->load->model('bill/print_invoice');

		$this->document->setTitle($this->language->get('heading_title'));

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

		$owner_name = $this->model_bill_print_invoice->get_owner_name($filter_owner); 

		$template = new Template();		
		$template->data['title'] = 'Invoice';
		$template->data['doctor_name'] = $doctor_name;
		$template->data['owner_name'] = $owner_name;
		//$template->data['email'] = $this->config->get('config_email');
		//$template->data['telephone'] = $this->config->get('config_telephone');

		$doctor_datas = $this->model_bill_print_invoice->get_doctor_data($doctor_id);
		if(isset($doctor_datas['doctor_id'])){
			$template->data['email'] = $doctor_datas['email'];
			$template->data['telephone'] = $doctor_datas['mobile'];
			$template->data['address_1'] = $doctor_datas['address_1'];
			$template->data['address_2'] = $doctor_datas['address_2'];
		} else {
			$template->data['email'] = $this->config->get('config_email');
			$template->data['telephone'] = $this->config->get('config_telephone');
			$template->data['address_1'] = '1202 Forum, Uday Baug';
			$template->data['address_2'] = 'Pune, Maharashtra 4110313';
		}

		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$template->data['base'] = "http://65.21.158.15/phiroz_2020/admin/";
		} else {
			$template->data['base'] = "http://65.21.158.15/phiroz_2020/admin/";
		}
		$html = $template->fetch('bill/invoice_text.tpl');
		return $html;

	}

	public function invoice_mail_html($show_html = 1){
		$this->language->load('bill/print_invoice');
		$this->load->model('bill/print_invoice');

		$this->document->setTitle($this->language->get('heading_title'));

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

		$filter_month = '';
		$filter_year = '';
		//echo 'out';exit;
		$owner_name = '';
		$final_owner = array();
		$final_transaction = array();
		$transaction_ids = $this->model_bill_print_invoice->get_transaction_ids($filter_bill_id);
		$medicine_doctor_id = 0;
		foreach ($transaction_ids as $tkey => $tvalue) {
			$transaction_data = $this->model_bill_print_invoice->get_transaction_data($tvalue['transaction_id']);
			
			$final_transaction[$tkey]['bill_id'] = $filter_bill_id;
			$final_transaction[$tkey]['transaction_id'] = $transaction_data['transaction_id'];
			$final_transaction[$tkey]['medicine_name'] = $transaction_data['medicine_name'];
			$final_transaction[$tkey]['medicine_quantity'] = $transaction_data['medicine_quantity'];
			$final_transaction[$tkey]['medicine_total'] = $transaction_data['medicine_total'];
			$final_transaction[$tkey]['dot'] = date('M d, Y', strtotime($transaction_data['dot']));
			$final_transaction[$tkey]['month'] = $transaction_data['month'];
			$final_transaction[$tkey]['year'] = $transaction_data['year'];

			$filter_month = $transaction_ids[0]['month'];
			$filter_year = $transaction_ids[0]['year'];
			$medicine_doctor_id = $transaction_data['medicine_doctor_id'];
		}
		$horse_data = $this->model_bill_print_invoice->get_horse_data($filter_horse_id);
		if(isset($horse_data['horse_id']) && $horse_data['horse_id'] != '0' && $horse_data['horse_id'] != ''){
			$trainer_data = $this->model_bill_print_invoice->get_trainer_data($horse_data['trainer']);
			$owner_data = $this->model_bill_print_invoice->get_owner_data($filter_bill_id, $horse_data['horse_id'], $filter_owner);
			foreach ($owner_data as $okey => $ovalue) {
				$final_owner[$okey]['bill_id'] = $filter_bill_id.'-'.$filter_i;
				$final_owner[$okey]['horse_name'] = $horse_data['name'];
				$final_owner[$okey]['trainer_name'] = $trainer_data['name'];
				$owner_name = $this->model_bill_print_invoice->get_owner_name($ovalue['owner']); 
				$final_owner[$okey]['owner_name'] = $owner_name;
				$owner_transactiontype = $this->model_bill_print_invoice->get_owner_transactiontype($ovalue['owner']); 
				$final_owner[$okey]['transaction_type'] = $owner_transactiontype;
				$final_owner[$okey]['owner_id'] = $ovalue['owner'];
				$final_owner[$okey]['owner_share'] = $ovalue['share'];

				$month = date("F", mktime(0, 0, 0, $filter_month, 10));
				$final_owner[$okey]['month'] = $month;
				$final_owner[$okey]['year'] = $filter_year;
				
				$owner_share_amount = $this->model_bill_print_invoice->get_owner_share($filter_bill_id, $ovalue['owner']);
				$final_owner[$okey]['owner_share_amount'] = $owner_share_amount;				

				$doctor_names = $this->db->query("SELECT * FROM `oc_transaction_type` WHERE `doctor_id` = '".$medicine_doctor_id."' AND `id` = '".$owner_transactiontype."' ");
				$doctor_name = '';
				if($doctor_names->num_rows > 0){
					$doctor_name = $doctor_names->row['transaction_type'];
				}
				
				// if($medicine_doctor_id == 1){
				// 	if($owner_transactiontype == 1){
				// 		$doctor_name = DOCTORNAME1;
				// 	} elseif($owner_transactiontype == 2) {
				// 		$doctor_name = DOCTORNAME11;
				// 	} else {
				// 		$doctor_name = DOCTORNAME1;
				// 	}
				// } elseif($medicine_doctor_id == 2) {
				// 	if($owner_transactiontype == 1){
				// 		$doctor_name = DOCTORNAME2;
				// 	} elseif($owner_transactiontype == 2) {
				// 		$doctor_name = DOCTORNAME21;
				// 	} else {
				// 		$doctor_name = DOCTORNAME2;
				// 	}
				// } else {
				// 	if($owner_transactiontype == 1){
				// 		$doctor_name = DOCTORNAME1;
				// 	} elseif($owner_transactiontype == 2) {
				// 		$doctor_name = DOCTORNAME11;
				// 	} else {
				// 		$doctor_name = DOCTORNAME1;
				// 	}
				// }

				$final_owner[$okey]['doctor_name'] = $doctor_name;
				$final_owner[$okey]['transaction_data'] = $final_transaction;
			}
		}
		$final_data[] = $final_owner;
		if($final_data){
			$month = date("F", mktime(0, 0, 0, $filter_month, 10));
			$template = new Template();		
			$template->data['final_datas'] = $final_data;
			$template->data['month'] = $month;
			$template->data['year'] = $filter_year;
			$template->data['title'] = 'Invoice';
			$template->data['text_invoice'] = 'Invoice';
			
			$doctor_datas = $this->model_bill_print_invoice->get_doctor_data($medicine_doctor_id);
			if(isset($doctor_datas['doctor_id'])){
				$template->data['email'] = $doctor_datas['email'];
				$template->data['telephone'] = $doctor_datas['mobile'];
				$template->data['address_1'] = $doctor_datas['address_1'];
				$template->data['address_2'] = $doctor_datas['address_2'];
			} else {
				$template->data['email'] = $this->config->get('config_email');
				$template->data['telephone'] = $this->config->get('config_telephone');
				$template->data['address_1'] = '1202 Forum, Uday Baug';
				$template->data['address_2'] = 'Pune, Maharashtra 4110313';
			}

			if($show_html == 0){
				$template->data['html_show'] = 0;
			}
			if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
				$template->data['base'] = "http://65.21.158.15/phiroz_2020/admin/";
			} else {
				$template->data['base'] = "http://65.21.158.15/phiroz_2020/admin/";
			}
			$html = $template->fetch('bill/invoice_html.tpl');
			
			if($show_html == 0){
				$month = date("F", mktime(0, 0, 0, $filter_month, 10));
				$template = new Template();		
				$template->data['final_datas'] = $final_data;
				$template->data['month'] = $month;
				$template->data['year'] = $filter_year;
				$template->data['title'] = 'Invoice';
				$template->data['text_invoice'] = 'Invoice';
				
				$doctor_datas = $this->model_bill_print_invoice->get_doctor_data($medicine_doctor_id);
				if(isset($doctor_datas['doctor_id'])){
					$template->data['email'] = $doctor_datas['email'];
					$template->data['telephone'] = $doctor_datas['mobile'];
					$template->data['address_1'] = $doctor_datas['address_1'];
					$template->data['address_2'] = $doctor_datas['address_2'];
				} else {
					$template->data['email'] = $this->config->get('config_email');
					$template->data['telephone'] = $this->config->get('config_telephone');
					$template->data['address_1'] = '1202 Forum, Uday Baug';
					$template->data['address_2'] = 'Pune, Maharashtra 4110313';
				}

				if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
					$template->data['base'] = "http://65.21.158.15/phiroz_2020/admin/";
				} else {
					$template->data['base'] = "http://65.21.158.15/phiroz_2020/admin/";
				}
				$html1 = $template->fetch('bill/invoice_html_1.tpl');
				if($owner_name != ''){
					$owner_name = str_replace(array(' ', ',', '&', '.'), '_', $owner_name);
					$filename = DIR_DOWNLOAD."Invoice_".$owner_name.".html";
				} else {
					$filename = DIR_DOWNLOAD."Invoice.html";
				}
				if(file_exists($filename)){
					unlink($filename);
				}
				// Write the contents back to the file
				file_put_contents($filename, $html1);
				//sleep(5);
				//exec('scp root@5.189.160.61:/var/www/html/phiroz/download/Invoice_Mr_Haresh_N__Mehta_rep__Rohan_Bloodstock_Pvt__Ltd.html root@125.99.122.186:/usr/share/nginx/html/openchr/download');
			}
			return $html;
		} 
	}

	public function invoice_mail_html_server(){
		$this->language->load('bill/print_invoice');
		$this->load->model('bill/print_invoice');

		$this->document->setTitle($this->language->get('heading_title'));

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

		$filter_month = '';
		$filter_year = '';
		//echo 'out';exit;
		$owner_name = '';
		$final_owner = array();
		$final_transaction = array();
		$transaction_ids = $this->model_bill_print_invoice->get_transaction_ids($filter_bill_id);
		$medicine_doctor_id = 0;
		foreach ($transaction_ids as $tkey => $tvalue) {
			$transaction_data = $this->model_bill_print_invoice->get_transaction_data($tvalue['transaction_id']);
			
			$final_transaction[$tkey]['bill_id'] = $filter_bill_id;
			$final_transaction[$tkey]['transaction_id'] = $transaction_data['transaction_id'];
			$final_transaction[$tkey]['medicine_name'] = $transaction_data['medicine_name'];
			$final_transaction[$tkey]['medicine_quantity'] = $transaction_data['medicine_quantity'];
			$final_transaction[$tkey]['medicine_total'] = $transaction_data['medicine_total'];
			$final_transaction[$tkey]['dot'] = date('M d, Y', strtotime($transaction_data['dot']));
			$final_transaction[$tkey]['month'] = $transaction_data['month'];
			$final_transaction[$tkey]['year'] = $transaction_data['year'];

			$filter_month = $transaction_ids[0]['month'];
			$filter_year = $transaction_ids[0]['year'];
			$medicine_doctor_id = $transaction_data['medicine_doctor_id'];
		}
		$horse_data = $this->model_bill_print_invoice->get_horse_data($filter_horse_id);
		if(isset($horse_data['horse_id']) && $horse_data['horse_id'] != '0' && $horse_data['horse_id'] != ''){
			$trainer_data = $this->model_bill_print_invoice->get_trainer_data($horse_data['trainer']);
			$owner_data = $this->model_bill_print_invoice->get_owner_data($filter_bill_id, $horse_data['horse_id'], $filter_owner);
			foreach ($owner_data as $okey => $ovalue) {
				$final_owner[$okey]['bill_id'] = $filter_bill_id.'-'.$filter_i;
				$final_owner[$okey]['horse_name'] = $horse_data['name'];
				$final_owner[$okey]['trainer_name'] = $trainer_data['name'];
				$owner_name = $this->model_bill_print_invoice->get_owner_name($ovalue['owner']); 
				$final_owner[$okey]['owner_name'] = $owner_name;
				$owner_transactiontype = $this->model_bill_print_invoice->get_owner_transactiontype($ovalue['owner']); 
				$final_owner[$okey]['transaction_type'] = $owner_transactiontype;
				$final_owner[$okey]['owner_id'] = $ovalue['owner'];
				$final_owner[$okey]['owner_share'] = $ovalue['share'];

				$month = date("F", mktime(0, 0, 0, $filter_month, 10));
				$final_owner[$okey]['month'] = $month;
				$final_owner[$okey]['year'] = $filter_year;
				
				$owner_share_amount = $this->model_bill_print_invoice->get_owner_share($filter_bill_id, $ovalue['owner']);
				$final_owner[$okey]['owner_share_amount'] = $owner_share_amount;				

				$doctor_names = $this->db->query("SELECT * FROM `oc_transaction_type` WHERE `doctor_id` = '".$medicine_doctor_id."' AND `id` = '".$owner_transactiontype."' ");
				$doctor_name = '';
				if($doctor_names->num_rows > 0){
					$doctor_name = $doctor_names->row['transaction_type'];
				}

				// if($medicine_doctor_id == 1){
				// 	if($owner_transactiontype == 1){
				// 		$doctor_name = DOCTORNAME1;
				// 	} elseif($owner_transactiontype == 2) {
				// 		$doctor_name = DOCTORNAME11;
				// 	} else {
				// 		$doctor_name = DOCTORNAME1;
				// 	}
				// } elseif($medicine_doctor_id == 2) {
				// 	if($owner_transactiontype == 1){
				// 		$doctor_name = DOCTORNAME2;
				// 	} elseif($owner_transactiontype == 2) {
				// 		$doctor_name = DOCTORNAME21;
				// 	} else {
				// 		$doctor_name = DOCTORNAME2;
				// 	}
				// } else {
				// 	if($owner_transactiontype == 1){
				// 		$doctor_name = DOCTORNAME1;
				// 	} elseif($owner_transactiontype == 2) {
				// 		$doctor_name = DOCTORNAME11;
				// 	} else {
				// 		$doctor_name = DOCTORNAME1;
				// 	}
				// }
				
				$final_owner[$okey]['doctor_name'] = $doctor_name;
				$final_owner[$okey]['transaction_data'] = $final_transaction;
			}
		}
		$final_data[] = $final_owner;
		if($final_data){
			$month = date("F", mktime(0, 0, 0, $filter_month, 10));
			$template = new Template();		
			$template->data['final_datas'] = $final_data;
			$template->data['month'] = $month;
			$template->data['year'] = $filter_year;
			$template->data['title'] = 'Invoice';
			$template->data['text_invoice'] = 'Invoice';
			
			$doctor_datas = $this->model_bill_print_invoice->get_doctor_data($medicine_doctor_id);
			if(isset($doctor_datas['doctor_id'])){
				$template->data['email'] = $doctor_datas['email'];
				$template->data['telephone'] = $doctor_datas['mobile'];
				$template->data['address_1'] = $doctor_datas['address_1'];
				$template->data['address_2'] = $doctor_datas['address_2'];
			} else {
				$template->data['email'] = $this->config->get('config_email');
				$template->data['telephone'] = $this->config->get('config_telephone');
				$template->data['address_1'] = '1202 Forum, Uday Baug';
				$template->data['address_2'] = 'Pune, Maharashtra 4110313';
			}

			if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
				$template->data['base'] = "http://65.21.158.15/phiroz_2020/admin/";
			} else {
				$template->data['base'] = "http://65.21.158.15/phiroz_2020/admin/";
			}
			$html1 = $template->fetch('bill/invoice_html_1.tpl');
			
			return $html1;
		} 
	}
}
?>
