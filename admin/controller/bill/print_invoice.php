<?php
class ControllerBillPrintInvoice extends Controller { 
	public function index() {  
		$this->language->load('bill/print_invoice');

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

		if (isset($this->request->get['filter_doctor'])) {
			$url .= '&filter_doctor=' . $this->request->get['filter_doctor'];
		}

		if (isset($this->request->get['filter_trainer'])) {
			$url .= '&filter_trainer=' . $this->request->get['filter_trainer'];
		}

		if (isset($this->request->get['filter_trainer_id'])) {
			$url .= '&filter_trainer_id=' . $this->request->get['filter_trainer_id'];
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
			'href'      => $this->url->link('bill/print_invoice', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$this->load->model('bill/print_invoice');

		$this->data['bill_checklist'] = array();

		$data = array(
			'filter_date_start'	     => $filter_date_start, 
			'filter_date_end'	     => $filter_date_end, 
			'filter_name'            => $filter_name,
			'filter_name_id'         => $filter_name_id,
			'filter_doctor'			 => $filter_doctor,
			'filter_trainer' 		 => $filter_trainer,
			'filter_trainer_id' 	 => $filter_trainer_id,
			'start'                  => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'                  => $this->config->get('config_admin_limit')
		);

		$order_total = 0;
		$this->data['update_ref_id'] = $this->url->link('reports/script_run', 'token=' . $this->session->data['token'], 'SSL');
		if(isset($this->request->get['bill']) && $this->request->get['bill'] == 1){
			//$order_total = $this->model_bill_print_invoice->getbillowner_groups_total($data);;
			//$bill_owner_groups = $this->model_bill_print_invoice->getbillowner_groups($data);
			if(isset($this->session->data['bill_id_array']) && $this->session->data['bill_id_array']){
				$bill_ids = $this->session->data['bill_id_array'];
				foreach ($bill_ids as $bill_id) {
					$data['filter_bill_id'] = $bill_id['bill_id'];
					$owner_datas = $this->model_bill_print_invoice->getbillowners($data);
					$i = 1;	
					foreach($owner_datas as $okey => $result){
						$action = array();
						$action[] = array(
							'text' => $this->language->get('text_print'),
							'href' => $this->url->link('bill/print_invoice/printinvoiceone', 'token=' . $this->session->data['token'] . '&filter_horse_id=' . $result['horse_id'] . '&filter_bill_id=' . $result['bill_id'] . '&filter_owner=' . $result['owner_id'].'&filter_i='.$i, 'SSL')
						);
						$owner_transactiontype = $this->model_bill_print_invoice->get_owner_transactiontype($result['owner_id']);
						if($owner_transactiontype == 1){
							$action[] = array(
								'text' => $this->language->get('text_print_receipt'),
								'href' => $this->url->link('bill/print_receipt/printreceiptone', 'token=' . $this->session->data['token'] . '&filter_horse_id=' . $result['horse_id'] . '&filter_bill_id=' . $result['bill_id'] . '&filter_owner=' . $result['owner_id'].'&filter_i='.$i, 'SSL')
							);
						}

						$action[] = array(
							'text' => $this->language->get('text_mail'),
							'href' => $this->url->link('bill/bill_history/configuremail', 'token=' . $this->session->data['token'] . '&filter_horse_id=' . $result['horse_id'] . '&filter_bill_id=' . $result['bill_id'] . '&filter_owner=' . $result['owner_id'].'&filter_i='.$i, 'SSL')
						);

						$horse_name = $this->model_bill_print_invoice->get_horse_name($result['horse_id']);
						$owner_name = $this->model_bill_print_invoice->get_owner_name($result['owner_id']);
						$trainer_name = $this->model_bill_print_invoice->get_trainer_name($result['trainer_id']);
						$this->data['bill_checklist'][] = array(
							'bill_id' 	 => $result['bill_id'].'-'.$i,
							'horse_name' => $horse_name,
							'owner_name' => $owner_name,
							'trainer_name' => $trainer_name,
							'total'      => $this->currency->format($result['owner_amt'], $this->config->get('config_currency')),
							'action'    => $action
						);
					$i ++;
					}
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
		$this->data['entry_trainer'] = $this->language->get('entry_trainer');
		$this->data['entry_transaction_type'] = $this->language->get('entry_transaction_type');	
		
		$this->data['button_filter'] = $this->language->get('button_filter');
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

		if (isset($this->request->get['filter_trainer'])) {
			$url .= '&filter_trainer=' . $this->request->get['filter_trainer'];
		}

		if (isset($this->request->get['filter_trainer_id'])) {
			$url .= '&filter_trainer_id=' . $this->request->get['filter_trainer_id'];
		}

		$pagination = new Pagination();
		$pagination->total = $order_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('bill/print_invoice', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['filter_name'] = $filter_name;
		$this->data['filter_name_id'] = $filter_name_id;
		$this->data['filter_date_start'] = $filter_date_start;
		$this->data['filter_date_end'] = $filter_date_end;
		$this->data['filter_doctor'] = $filter_doctor;
		$this->data['filter_trainer'] = $filter_trainer;
		$this->data['filter_trainer_id'] = $filter_trainer_id;

		$this->template = 'bill/print_invoice.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function generateinvoice(){
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

		$data = array(
			'filter_date_start'	    	 => $filter_date_start, 
			'filter_date_end'	     	 => $filter_date_end, 
			'filter_name'            	 => $filter_name,
			'filter_name_id'         	 => $filter_name_id,
			'filter_doctor'          	 => $filter_doctor,
			'filter_trainer' 			 => $filter_trainer,
			'filter_trainer_id' 		 => $filter_trainer_id
		);

		$all_transactions = array();
		$bill_id_array = array();
		if($filter_name_id == ''){
			$all_transactions_group = $this->model_bill_print_invoice->getall_transaction_group($data);		
			foreach ($all_transactions_group as $akey => $avalue) {
				$data['filter_name_id'] = $avalue['horse_id'];

				$horse_transactions = $this->model_bill_print_invoice->getall_transaction($data);
				foreach ($horse_transactions as $hhkey => $hhvalue) {
					$horse_data = $this->model_bill_print_invoice->get_horse_data($hhvalue['horse_id']);
					if(isset($horse_data['horse_id']) && $horse_data['horse_id'] != '0' && $horse_data['horse_id'] != ''){
						$trainer_id = $horse_data['trainer'];
						$this->model_bill_print_invoice->update_trainer_transaction($trainer_id, $hhvalue['transaction_id']);
					}
				}

				$horse_transactions = $this->model_bill_print_invoice->getall_transaction($data);
				$bill_id = 0;
				foreach ($horse_transactions as $hkey => $hvalue) {
					//$is_exist = $this->model_bill_print_invoice->getexist_status($hvalue['transaction_id']);
					//if($is_exist){
						//$bill_id = $is_exist;
						//unset($horse_transactions[$hkey]);
					//} else {
						if($bill_id){
							$horse_transactions[$hkey]['bill_id'] = $bill_id;
						} else {
							$bill_id = $this->model_bill_print_invoice->getbill_id();
							$horse_transactions[$hkey]['bill_id'] = $bill_id;
							$bill_id_array[$akey]['bill_id'] = $bill_id;
							$bill_id_array[$akey]['horse_id'] = $avalue['horse_id'];
							$bill_id_array[$akey]['doctor_id'] = $hvalue['medicine_doctor_id'];
							$bill_id_array[$akey]['trainer_id'] = $hvalue['trainer_id'];
							$bill_id_array[$akey]['month'] = $horse_transactions[0]['month'];
							$bill_id_array[$akey]['year'] = $horse_transactions[0]['year'];
						}
					//}
				}
				if($horse_transactions){
					$this->model_bill_print_invoice->insert_bill($horse_transactions);
				}
			}
		} else {

			$horse_transactions = $this->model_bill_print_invoice->getall_transaction($data);
			foreach ($horse_transactions as $hhkey => $hhvalue) {
				$horse_data = $this->model_bill_print_invoice->get_horse_data($hhvalue['horse_id']);
				if(isset($horse_data['horse_id']) && $horse_data['horse_id'] != '0' && $horse_data['horse_id'] != ''){
					$trainer_id = $horse_data['trainer'];
					$this->model_bill_print_invoice->update_trainer_transaction($trainer_id, $hhvalue['transaction_id']);
				}
			}

			$all_transactions = $this->model_bill_print_invoice->getall_transaction($data);		
			$bill_id = 0;
			foreach ($all_transactions as $akey => $avalue) {
				//$is_exist = $this->model_bill_print_invoice->getexist_status($avalue['transaction_id']);
				//if($is_exist == 1){
					//$bill_id = $is_exist;
					//unset($all_transactions[$akey]);
				//} else {
					if($bill_id){
						$all_transactions[$akey]['bill_id'] = $bill_id;
					} else {
						$bill_id = $this->model_bill_print_invoice->getbill_id();
						$all_transactions[$akey]['bill_id'] = $bill_id;
						$bill_id_array[0]['bill_id'] = $bill_id;
						$bill_id_array[0]['horse_id'] = $avalue['horse_id'];
						$bill_id_array[0]['doctor_id'] = $avalue['medicine_doctor_id'];
						$bill_id_array[0]['trainer_id'] = $avalue['trainer_id'];
						$bill_id_array[0]['month'] = $all_transactions[0]['month'];
						$bill_id_array[0]['year'] = $all_transactions[0]['year'];
					}
				//}
			}
			if($all_transactions){
				$this->model_bill_print_invoice->insert_bill($all_transactions);	
			}
		}
		$this->session->data['bill_id_array'] = array();
		$this->session->data['bill_id_array'] = $bill_id_array;

		//$this->log->write(print_r($this->session->data['bill_id_array'],true));
		
		//echo 'out';exit;

		// $data = array(
		// 	'filter_month'	    	 => $filter_month, 
		// 	'filter_year'	     	 => $filter_year, 
		// 	'filter_name'            => $filter_name,
		// 	'filter_name_id'         => $filter_name_id,
		// 	'filter_doctor'          => $filter_doctor,
		// 	'filter_trainer' => $filter_trainer,
		// 	'filter_trainer_id' => $filter_trainer_id
		// );

		//$bill_groups = $this->model_bill_print_invoice->getbill_groups($data);
		$final_owner = array();
		$final_transaction = array();
		$final_data = array();
		foreach ($bill_id_array as $bkey => $bvalue) {
			$final_owner = array();
			$final_transaction = array();
			$transaction_ids = $this->model_bill_print_invoice->get_transaction_ids($bvalue['bill_id']);
			foreach ($transaction_ids as $tkey => $tvalue) {
				$transaction_data = $this->model_bill_print_invoice->get_transaction_datass($tvalue['transaction_id']);
				
				$final_transaction[$tkey]['bill_id'] = $bvalue['bill_id'];
				$final_transaction[$tkey]['transaction_id'] = $transaction_data['transaction_id'];
				$final_transaction[$tkey]['medicine_name'] = $transaction_data['medicine_name'];
				$final_transaction[$tkey]['medicine_quantity'] = $transaction_data['medicine_quantity'];
				$final_transaction[$tkey]['medicine_total'] = $transaction_data['medicine_total'];
				$final_transaction[$tkey]['dot'] = $transaction_data['dot'];
				$final_transaction[$tkey]['month'] = $transaction_data['month'];
				$final_transaction[$tkey]['year'] = $transaction_data['year'];
			}
			$horse_data = $this->model_bill_print_invoice->get_horse_data($bvalue['horse_id']);
			if(isset($horse_data['horse_id']) && $horse_data['horse_id'] != '0' && $horse_data['horse_id'] != ''){
				$trainer_data = $this->model_bill_print_invoice->get_trainer_data($horse_data['trainer']);
				$owner_data = $this->model_bill_print_invoice->get_owner_data_generate($horse_data['horse_id']);
				if($owner_data){
					foreach ($owner_data as $okey => $ovalue) {
						if($ovalue['share']) {
							$final_owner[$okey]['bill_id'] = $bvalue['bill_id'];
							$final_owner[$okey]['doctor_id'] = $bvalue['doctor_id'];
							$final_owner[$okey]['trainer_id'] = $bvalue['trainer_id'];
							$final_owner[$okey]['horse_id'] = $bvalue['horse_id'];
							$final_owner[$okey]['horse_name'] = $horse_data['name'];
							$final_owner[$okey]['trainer_name'] = $trainer_data['name'];
							$owner_name = $this->model_bill_print_invoice->get_owner_name($ovalue['owner']); 
							$final_owner[$okey]['owner_name'] = $owner_name;
							$owner_transactiontype = $this->model_bill_print_invoice->get_owner_transactiontype($ovalue['owner']); 
							$final_owner[$okey]['transaction_type'] = $owner_transactiontype;
							$responsible_person = $this->model_bill_print_invoice->get_owner_responsible_person($ovalue['owner']);
							$final_owner[$okey]['responsible_person'] = $responsible_person;
							$responsible_person_id = $this->model_bill_print_invoice->get_owner_responsible_person_id($ovalue['owner']);
							$final_owner[$okey]['responsible_person_id'] = $responsible_person_id;
							$final_owner[$okey]['owner_id'] = $ovalue['owner'];
							$final_owner[$okey]['owner_share'] = $ovalue['share'];
							$final_owner[$okey]['transaction_data'] = $final_transaction;
						}
					}
				}
			}

			if($final_owner){
				$final_data[$bkey] = $final_owner;
			}
		}

		$bill_owner = array();
		$i = 0;
		foreach ($final_data as $fkeys => $fvalues) {
			foreach ($fvalues as $fkey => $fvalue) {
				$owner_share = $fvalue['owner_share'];
				$owner_total_amt = 0;
				foreach ($fvalue['transaction_data'] as $key => $value) {
					$medicine_total = $value['medicine_total'];
					$cal = $medicine_total / 100;
					$amount_share_amts = $cal * $owner_share;  
					$amount_share_amt = $amount_share_amts;
					$owner_total_amt = $owner_total_amt + $amount_share_amt;
					$month = $value['month'];
					$year = $value['year'];
				}
				$bill_owner[$i]['bill_id'] = $fvalue['bill_id'];
				$bill_owner[$i]['doctor_id'] = $fvalue['doctor_id'];
				$bill_owner[$i]['transaction_type'] = $fvalue['transaction_type'];
				$bill_owner[$i]['trainer_id'] = $fvalue['trainer_id'];
				$bill_owner[$i]['horse_id'] = $fvalue['horse_id'];
				$bill_owner[$i]['owner_id'] = $fvalue['owner_id'];
				$bill_owner[$i]['owner_share'] = $fvalue['owner_share'];
				$bill_owner[$i]['responsible_person'] = $fvalue['responsible_person'];
				$bill_owner[$i]['responsible_person_id'] = $fvalue['responsible_person_id'];
				$bill_owner[$i]['owner_amt'] = $owner_total_amt;
				$bill_owner[$i]['owner_amt_rec'] = 0;
				$bill_owner[$i]['month'] = $month;
				$bill_owner[$i]['year'] = $year;
				$i++;
			}
		}

		if($bill_owner){
			$this->model_bill_print_invoice->insert_bill_owner($bill_owner);	
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

		if (isset($this->request->get['filter_trainer'])) {
			$url .= '&filter_trainer=' . $this->request->get['filter_trainer'];
		}

		if (isset($this->request->get['filter_trainer_id'])) {
			$url .= '&filter_trainer_id=' . $this->request->get['filter_trainer_id'];
		}

		if($final_data){
			$this->session->data['success'] = 'Bills Generated Sucessfully';
			$this->redirect($this->url->link('bill/print_invoice', 'token=' . $this->session->data['token'].'&bill=1'.$url, 'SSL'));
		} else {
			$this->session->data['warning'] = 'No Data Found';
			$this->redirect($this->url->link('bill/print_invoice', 'token=' . $this->session->data['token'].$url, 'SSL'));
		}
	}

	public function printinvoice(){
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

		//echo 'out';exit;

		$data = array(
			'filter_date_start'	     => $filter_date_start, 
			'filter_date_end'	     => $filter_date_end, 
			'filter_name'            => $filter_name,
			'filter_name_id'         => $filter_name_id,
			'filter_doctor'          => $filter_doctor,
			'filter_trainer' 		 => $filter_trainer,
			'filter_trainer_id' 	 => $filter_trainer_id
		);

		$final_owner = array();
		$final_transaction = array();
		$final_data = array();

		if(isset($this->session->data['bill_id_array']) && $this->session->data['bill_id_array']){
			$bill_id_array = $this->session->data['bill_id_array'];
			//$bill_groups = $this->model_bill_print_invoice->getbill_groups($data);
			foreach ($bill_id_array as $bkey => $bvalue) {
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
					$final_transaction[$tkey]['dot'] = date('M d, Y', strtotime($transaction_data['dot']));
					$final_transaction[$tkey]['month'] = $transaction_data['month'];
					$final_transaction[$tkey]['year'] = $transaction_data['year'];
				}
				$horse_data = $this->model_bill_print_invoice->get_horse_data($bvalue['horse_id']);
				if(isset($horse_data['horse_id']) && $horse_data['horse_id'] != '0' && $horse_data['horse_id'] != ''){
					$trainer_data = $this->model_bill_print_invoice->get_trainer_data($horse_data['trainer']);
					$owner_data = $this->model_bill_print_invoice->get_owner_data($bvalue['bill_id'], $horse_data['horse_id']);
					if($owner_data){
						$i=1;
						foreach ($owner_data as $okey => $ovalue) {
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

								// if($bvalue['doctor_id'] == 1){
								// 	if($owner_transactiontype == 1){
								// 		$doctor_name = DOCTORNAME1;
								// 	} elseif($owner_transactiontype == 2) {
								// 		$doctor_name = DOCTORNAME11;
								// 	} else {
								// 		$doctor_name = DOCTORNAME1;
								// 	}
								// } elseif($bvalue['doctor_id'] == 2) {
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
							$i ++;
							}
						}

						if($final_owner) {
							$final_data[$bkey] = $final_owner;
						}
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

		if (isset($this->request->get['filter_trainer'])) {
			$url .= '&filter_trainer=' . $this->request->get['filter_trainer'];
		}

		if (isset($this->request->get['filter_trainer_id'])) {
			$url .= '&filter_trainer_id=' . $this->request->get['filter_trainer_id'];
		}

		// echo '<pre>';
		// print_r($final_data);
		// exit;

		if($final_data){
			$month = date('m', strtotime($filter_date_start));
			$year = date('Y', strtotime($filter_date_start));
			$month = date("F", mktime(0, 0, 0, $month, 10));
			$template = new Template();		
			$template->data['final_datas'] = $final_data;
			$template->data['month'] = $month;
			$template->data['year'] = $year;
			$template->data['title'] = 'Invoice';
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
			$template->data['text_invoice'] = 'Invoice';
			if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
				$template->data['base'] = HTTPS_SERVER;
			} else {
				$template->data['base'] = HTTP_SERVER;
			}
			$html = $template->fetch('bill/invoice_html.tpl');
			$filename = "Invoice.html";
			header('Content-type: text/html');
			//header('Set-Cookie: fileLoading=true');
			header('Content-Disposition: attachment; filename='.$filename);
			echo $html;
		} else {
			$this->session->data['warning'] = 'No Data Found';
			$this->redirect($this->url->link('bill/print_invoice', 'token=' . $this->session->data['token'].$url, 'SSL'));
		}
	}

	public function printinvoiceone(){
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
		//echo "<pre>";print_r($transaction_ids);exit;
		$medicine_doctor_id = 0;
		foreach ($transaction_ids as $tkey => $tvalue) {
			$transaction_data = $this->model_bill_print_invoice->get_transaction_datass($tvalue['transaction_id']);
			
			$final_transaction[$tkey]['bill_id'] = $filter_bill_id;
			$final_transaction[$tkey]['transaction_id'] = $transaction_data['transaction_id'];
			$final_transaction[$tkey]['medicine_name'] = $transaction_data['medicine_name'];
			$final_transaction[$tkey]['medicine_id'] = $transaction_data['medicine_id'];
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
				
				$month = date("F", mktime(0, 0, 0, $filter_month, 10));
				$final_owner[$okey]['month'] = $month;
				$final_owner[$okey]['year'] = $filter_year;
				$final_owner[$okey]['doctor_name'] = $doctor_name;
				$final_owner[$okey]['transaction_data'] = $final_transaction;
			}
			$final_data[] = $final_owner;
			//echo "<pre>";print_r($final_data);exit;
		}

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
				$template->data['base'] = HTTPS_SERVER;
			} else {
				$template->data['base'] = HTTP_SERVER;
			}
			$html = $template->fetch('bill/invoice_html.tpl');
			if($owner_name != ''){
				$owner_name = str_replace(array(' ', ',', '&', '.'), '_', $owner_name);
				$filename = "Invoice_".$owner_name.".html";
			} else {
				$filename = "Invoice.html";
			}
			header('Content-type: text/html');
			//header('Set-Cookie: fileLoading=true');
			header('Content-Disposition: attachment; filename='.$filename);
			echo $html;
		} else {
			$this->session->data['warning'] = 'No Data Found';
			$this->redirect($this->url->link('bill/print_invoice', 'token=' . $this->session->data['token'], 'SSL'));
		}
	}
}
?>
