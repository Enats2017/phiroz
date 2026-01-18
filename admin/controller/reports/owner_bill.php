<?php
require '../mailin-api-php-master/src/Sendinblue/Mailin.php';
class Controllerreportsownerbill extends Controller { 
	public function index() {  
		$this->language->load('reports/owner_bill');

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

		if (isset($this->request->get['filter_owner'])) {
			$filter_owner = rtrim($this->request->get['filter_owner'], ',');
		} else {
			$filter_owner = '';
		}

		if (isset($this->request->get['filter_owner_id'])) {
			$filter_owner_id = rtrim($this->request->get['filter_owner_id'], ',');
		} else {
			$filter_owner_id = '';
		}

		if (isset($this->request->get['filter_email'])) {
			$filter_email = $this->request->get['filter_email'];
		} else {
			$filter_email = '';
		}

		if (isset($this->request->get['filter_bill_id'])) {
			$filter_bill_id = $this->request->get['filter_bill_id'];
		} else {
			$filter_bill_id = '';
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

		
		if (isset($this->request->get['filter_owner'])) {
			$url .= '&filter_owner=' . $this->request->get['filter_owner'];
		}

		if (isset($this->request->get['filter_owner_id'])) {
			$url .= '&filter_owner_id=' . $this->request->get['filter_owner_id'];
		}

		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . $this->request->get['filter_email'];
		}

		if (isset($this->request->get['filter_bill_id'])) {
			$url .= '&filter_bill_id=' . $this->request->get['filter_bill_id'];
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
			'href'      => $this->url->link('reports/owner_bill', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$this->load->model('bill/print_invoice');

		$this->data['bill_checklist'] = array();

		$data = array(
			'filter_date_start'	     => $filter_date_start, 
			'filter_date_end'	     => $filter_date_end, 
			'filter_owner'           => $filter_owner_id,
			'filter_owner_name'      => $filter_owner,
			'filter_bill_id' 		 => $filter_bill_id,
			'filter_email'         	 => $filter_email,
			'start'                  => ($page - 1) * 7000,
			'limit'                  => 7000
		);
		$this->data['bill_debits'] = array();
		$this->data['bill_credits'] = array();
		$order_total = 0;
		if ($filter_owner) {
			if(isset($this->request->get['first']) && $this->request->get['first'] == 0){
				$bill_ids = $this->model_bill_print_invoice->getbillids_groups_owner($data);
				foreach ($bill_ids as $bill_id) {
					$data['filter_bill_id'] = $bill_id['bill_id'];
					$owner_datas = $this->model_bill_print_invoice->getbillowners_owner($data);
					// $i = 1;				
					foreach($owner_datas as $okey => $result){
						$balance = $result['owner_amt']	- $result['owner_amt_rec'];
						$owner_name = $this->model_bill_print_invoice->get_owner_name($result['owner_id']);
						$this->data['bill_checklist'][] = array(
							'bill_id' 	 	=> $result['bill_id'].'-'.$result['ref_id'],
							'bill_href' 	=> $this->url->link('bill/bill_history/printinvoiceone', 'token=' . $this->session->data['token'] .'&filter_bill_id=' . $result['bill_id'] . '&filter_horse_id=' . $result['horse_id'] . '&filter_owner=' . $result['owner_id']. 'SSL'),
							'owner_name' 	=> $owner_name,
							'payment_type' 	=> $result['payment_type'],
							'payment_date' 	=> $result['dop'],
							'month' 		=> date('F', strtotime($result['year'].'-'.$result['month'].'-'.'01')),
							'total'     	=> $result['owner_amt'],
							'balance'     	=> $balance,
							'raw_total'    	=> $result['owner_amt'],
							'payment_status'=> $result['payment_status']
						);
					// $i ++;
					}
				}
			}

			$debit = ("SELECT * FROM `" . DB_PREFIX . "debit` WHERE 1=1  ");
			if (isset($filter_owner_id)) {
				$debit .= "AND owner_name LIKE '%".$this->db->escape($filter_owner)."%' ";
			}
			$sql = $this->db->query($debit)->rows;
			foreach($sql as $keys => $values){
				$owner_name = $this->model_bill_print_invoice->get_owner_name($filter_owner_id);
				$this->data['bill_debits'][] = array(
					'owner_name' 	=> $values['owner_name'],
					'debit_amount'  => $values['debit_amount'],
					'comment'   	=> $values['comment'],		
				);
			}
					
			$credit = ("SELECT * FROM `" . DB_PREFIX . "credit` WHERE 1=1  ");
			if (isset($filter_owner_id)) {
				$credit .= "AND owner_name LIKE '%".$this->db->escape($filter_owner)."%' ";
			}
			$sqlquery = $this->db->query($credit)->rows;
			foreach($sqlquery as $key1 => $values1){
				$owner_name = $this->model_bill_print_invoice->get_owner_name($filter_owner_id);
				$this->data['bill_credits'][] = array(
					'owner_name' 	=> $values1['owner_name'],
					'credit_amount' => $values1['credit_amount'],
					'comment'    	=> $values1['comment'],		
				);
			}

		}
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
		$this->data['column_owner_name'] = $this->language->get('column_owner_name');
		$this->data['column_total'] = $this->language->get('column_total');

		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_month'] = $this->language->get('entry_month');
		$this->data['entry_year'] = $this->language->get('entry_year');

		$this->data['entry_date_start'] = $this->language->get('entry_date_start');
		$this->data['entry_date_end'] = $this->language->get('entry_date_end');

		$this->data['entry_doctor'] = $this->language->get('entry_doctor');
		$this->data['entry_bill_id'] = $this->language->get('entry_bill_id');
		
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

		if (isset($this->request->get['filter_owner'])) {
			$url .= '&filter_owner=' . $this->request->get['filter_owner'];
		}

		if (isset($this->request->get['filter_owner_id'])) {
			$url .= '&filter_owner_id=' . $this->request->get['filter_owner_id'];
		}

		if (isset($this->request->get['filter_bill_id'])) {
			$url .= '&filter_bill_id=' . $this->request->get['filter_bill_id'];
		}

		$pagination = new Pagination();
		$pagination->total = $order_total;
		$pagination->page = $page;
		$pagination->limit = 7000;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('reports/owner_bill', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['filter_date_start'] = $filter_date_start;
		$this->data['filter_date_end'] = $filter_date_end;
		
		
		if(isset($this->request->get['filter_owner'])){
			$this->data['owner_name'] = $this->request->get['filter_owner'];
		} else {
			$this->data['owner_name'] = '';
		}

		if(isset($this->request->get['filter_owner_id'])){
			$this->data['owner_id'] = $this->request->get['filter_owner_id'];
		} else {
			$this->data['owner_id'] = '';
		}

		if (isset($this->request->get['filter_email'])) {
			$this->data['email'] = $this->request->get['filter_email'];
		}else {
			$this->data['email'] = '';
		}
		
		$this->data['filter_bill_id'] = $filter_bill_id;

		$this->template = 'reports/owner_bill.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function export(){
		$this->language->load('reports/owner_bill');
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

		if (isset($this->request->get['filter_owner'])) {
			$filter_owner = rtrim($this->request->get['filter_owner'], ',');
		} else {
			$filter_owner = '';
		}

		if (isset($this->request->get['filter_owner_id'])) {
			$filter_owner_id = rtrim($this->request->get['filter_owner_id'], ',');
		} else {
			$filter_owner_id = '';
		}

		if (isset($this->request->get['filter_email'])) {
			$filter_email = $this->request->get['filter_email'];
		} else {
			$filter_email = '';
		}

		if (isset($this->request->get['filter_bill_id'])) {
			$filter_bill_id = $this->request->get['filter_bill_id'];
		} else {
			$filter_bill_id = '';
		}
		//echo 'out';exit;
		$data = array(
			'filter_date_start'	     => $filter_date_start, 
			'filter_date_end'	     => $filter_date_end, 
			'filter_owner'           => $filter_owner_id,
			'filter_owner_id'        => $filter_owner_id,
			'filter_bill_id' 		 => $filter_bill_id
		);
		


		$final_data = array();
		$bill_ids = $this->model_bill_print_invoice->getbillids_groups_owner($data);
		$owner_name = '';
		foreach ($bill_ids as $bill_id) {
			$data['filter_bill_id'] = $bill_id['bill_id'];
			$owner_datas = $this->model_bill_print_invoice->getbillowners_owner($data);
			// echo "<pre>";
			// print_r($owner_datas);
			// $i = 1;
			foreach($owner_datas as $okey => $result){
				$balance = $result['owner_amt']	- $result['owner_amt_rec'];
				$owner_name = $this->model_bill_print_invoice->get_owner_name($result['owner_id']);
				$final_data[] = array(
					'bill_id' 	 	=> $result['bill_id'].'-'.$result['ref_id'].'.',
					'owner_name' 	=> $owner_name,
					'month' 		=> date('F Y', strtotime($result['year'].'-'.$result['month'].'-'.'01')),
					'total'     	=> $result['owner_amt'],
					'balance'     	=> $balance,
					'raw_total'    	=> $result['owner_amt'],
					'payment_status'=> $result['payment_status'],
					'owner_share'	=> $result['owner_share'].'%'
				);
			// $i ++;
			}
		}
			// exit;

		$debit = ("SELECT * FROM `" . DB_PREFIX . "debit` WHERE 1=1  ");
		if (isset($filter_owner_id)) {
			$debit .= "AND owner_name LIKE '%".$this->db->escape($filter_owner)."%' ";
		}
		$sql = $this->db->query($debit)->rows;
		$bill_debit = array();
		foreach($sql as $keys => $values){
			$owner_name = $this->model_bill_print_invoice->get_owner_name($filter_owner_id);
			$bill_debit[] = array(
				'owner_name' 		=> $values['owner_name'],
				'comment'    		=> $values['comment'],		
				'debit_amount'   	=> $values['debit_amount'],
			);
		}
		
		$credit = ("SELECT * FROM `" . DB_PREFIX . "credit` WHERE 1=1  ");
		if (isset($filter_owner_id)) {
			$credit .= "AND owner_name LIKE '%".$this->db->escape($filter_owner)."%' ";
		}
		$sql = $this->db->query($credit)->rows;
		$bill_credit = array();
		foreach($sql as $keys => $values){
			$owner_name = $this->model_bill_print_invoice->get_owner_name($filter_owner_id);
			$bill_credit[] = array(
				'owner_name' 		=> $values['owner_name'],
				'comment'   		=> $values['comment'],		
				'credit_amount'   	=> $values['credit_amount'],
			);
		}

		$url = '';

		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}

		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
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

		if (isset($this->request->get['filter_email'])) {
			$filter_email = $this->request->get['filter_email'];
		} else {
			$filter_email = '';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$url .= '&first=0';
		if($final_data || $bill_debit || $bill_credit){
			$template = new Template();
			$template->data['final_datas'] = $final_data;
			$template->data['bill_debits'] = $bill_debit;
			$template->data['bill_credits'] = $bill_credit;
			if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
				$template->data['base'] = HTTPS_SERVER;
			} else {
				$template->data['base'] = HTTP_SERVER;
			}
			$html = $template->fetch('reports/owner_bill_html.tpl');
			
			$filename = "Owner_bill_Statement.html";			
			if($owner_name != ''){
				$owner_name = str_replace(array(' ', ',', '&', '.'), '_', $owner_name);
				$filename = HTTP_CATALOG."download/"."Owner_Bill_".$owner_name.".html";
				 // $filenamess = DIR_DOWNLOAD."Owner_Bill_".$owner_name.".html";
				// $bfilename = "Owner_Bill_".$owner_name.".html";
			} else {
				$filename = HTTP_CATALOG."download/"."Owner_Bill.html";
				// $filenamess = DIR_DOWNLOAD."Owner_Bill.html";
				// $bfilename = "Owner_Bill.html";
			}
			
			// $this->redirect($this->url->link('reports/owner_bill', 'token=' . $this->session->data['token'].$url, 'SSL'));
			header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
			header("Content-Disposition: attachment; filename=".$filename.".xls");//File name extension was wrong
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Cache-Control: private",false);
			header('Content-type: text/html');
			// print $html;			
			// exit;
			// header('Set-Cookie: fileLoading=true');
			// header('Content-Disposition: attachment; filename='.$filename.'.html');			
			print $html;			
			exit;
		} else {
			$this->session->data['warning'] = 'No Data Found';
			$this->redirect($this->url->link('reports/owner_bill', 'token=' . $this->session->data['token'].$url, 'SSL'));
		}
	}


	public function printinvoice(){
		// echo "<pre>";
		// print_r($this->request->get);
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

		if (isset($this->request->get['filter_email'])) {
			$filter_email = $this->request->get['filter_email'];
		} else {
			$filter_email = '';
		}

		//echo 'out';exit;

		$data = array(
			'filter_date_start'	     => $filter_date_start, 
			'filter_date_end'	     => $filter_date_end, 
			'filter_name'            => $filter_name,
			'filter_name_id'         => $filter_name_id,
			'filter_owner'           => $filter_owner_id,
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

		$final_datass = array();
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
				$final_transaction[$tkey]['dot'] = date('M d, Y', strtotime($transaction_data['dot']));
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
			$owner_name = '';
			$data['filter_bill_id'] = $bvalue['bill_id'];
			$owner_datas = $this->model_bill_print_invoice->getbillowners_owner($data);
			// $i = 1;
			foreach($owner_datas as $okey => $result){
				$trainer_name =$this->db->query("SELECT * FROM oc_trainer  WHERE trainer_id ='".(int)$result['trainer_id']."'");
				if ($trainer_name->num_rows > 0) {
					$trainer_name = $trainer_name->row['name'];
				}else{
					$trainer_name = '';
				}
				$balance = $result['owner_amt']	- $result['owner_amt_rec'];
				$owner_name = $this->model_bill_print_invoice->get_owner_name($result['owner_id']);
				$final_datass[] = array(
					'bill_id' 	 	=> $result['bill_id'].'-'.$result['ref_id'].'.',
					'owner_name' 	=> $owner_name,
					'trainer_name' 	=> $trainer_name,
					'month' 		=> date('F Y', strtotime($result['year'].'-'.$result['month'].'-'.'01')),
					'total'     	=> $result['owner_amt'],
					'balance'     	=> $balance,
					'raw_total'    	=> $result['owner_amt'],
					'payment_status'=> $result['payment_status'],
					'owner_share'	=> $result['owner_share'].'%'
				);
				// $i ++;
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

		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . $this->request->get['filter_email'];
		}


		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		$url .= '&first=0';

		if($final_data || $final_datass){
			$template = new Template();		
			$template->data['final_datas'] = $final_data;
			 $template->data['final_datass'] = $final_datass;
			$template->data['title'] = 'Invoice';
			$template->data['text_invoice'] = 'Invoice';

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
			
			
			$html = $template->fetch('reports/invoice_html2.tpl');
			$filename = "Invoice.html";
			if($owner_name != ''){
				$owner_name = str_replace(array(' ', ',', '&', '.'), '_', $owner_name);
				$filename = HTTP_CATALOG."download/"."invoice_".$owner_name.".html";
				 $filenamess = DIR_DOWNLOAD."invoice_".$owner_name.".html";
				$bfilename = "invoice_".$owner_name.".html";
			} else {
				$filename = HTTP_CATALOG."download/"."invoice.html";
				$filenamess = DIR_DOWNLOAD."invoice.html";
				$bfilename = "invoice.html";
			}
			if(file_exists($filenamess)){
				unlink($filenamess);
			}
			file_put_contents($filenamess, $html);

			$subject ='Mr .'. $owner_name .' '.date('d-M-Y',strtotime($filter_date_start)) . ' To ' . date('d-M-Y',strtotime($filter_date_end)) .' Vet Bills from Dr.Khambatta';
			$path = HTTP_CATALOG."download/".$bfilename;
			$statement_mail_text = $this->statement_mail_text($owner_name, $final_datass, $path, $filter_date_start, $filter_date_end);
			$statement_mail_text = str_replace(array("\r", "\n"), '', $statement_mail_text);

			$mailin = new Sendinblue\Mailin("https://api.sendinblue.com/v2.0",'bVN07jDRW85tLAJH');
			  $data = array( "to" => array($filter_email=>$owner_name),
		        "from" 		=> array("info@enats.co.in", "Accounts Equivets"),//phiroz2017@gmail.com,info@enats.co.in
		        // "cc" 		=> array("saurabhshirke21@gmail.com"),
		        "subject" 	=> $subject,
		        "html"		=> $statement_mail_text,
		    );

			$res = $mailin->send_email($data);
			if($res['code'] == 'success'){
				$this->db->query("INSERT INTO oc_email_info SET
								owner_id = '".$filter_owner_id."',
								owner_name = '".$this->db->escape($filter_owner)."',
								owner_email = '".$filter_email."',
							 	report_type = '1',
								report_name = 'Owner Wise Statement Email',
								send_status = '1',
								date = '".date('Y-m-d')."',
								time = '".date('h:i:s')."'
							");
				$this->session->data['success'] = 'Mail Send';
			}
			else{
				$this->session->data['warning'] = 'Mail Cannot be Send';
				$this->db->query("INSERT INTO oc_email_info SET
								owner_id = '".$filter_owner_id."',
								owner_name = '".$this->db->escape($filter_owner)."',
								owner_email = '".$filter_email."',
								report_type = '1',
								report_name = 'Owner Bill Statement Email',
								send_status = '0',
								date = '".date('Y-m-d')."',
								time = '".date('h:i:s')."'
							");
			}
			// $this->redirect($this->url->link('reports/owner_bill', 'token=' . $this->session->data['token'].$url, 'SSL'));
			header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
			header("Content-Disposition: attachment; filename=".$filename.".xls");//File name extension was wrong
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Cache-Control: private",false);
			header('Content-type: text/html');
			// print $html;	// exit;
			header('Set-Cookie: fileLoading=true');
			header('Content-Disposition: attachment; filename='.$filename.'.html');			
			echo $html;
			exit;
		} else {
			$this->session->data['warning'] = 'No Data Found';
			$this->redirect($this->url->link('reports/owner_bill', 'token=' . $this->session->data['token'].$url, 'SSL'));
		}
	}

	public function statement_mail_text($owner_name, $final_datass,$path, $filter_date_start, $filter_date_end){
			$this->language->load('reports/owner_bill');
			$this->load->model('bill/print_invoice');
			$this->document->setTitle($this->language->get('heading_title'));

			if (isset($this->request->get['filter_owner_id'])) {
				$filter_owner = $this->request->get['filter_owner_id'];
			} else {
				$filter_owner = '';
			}
			$owner_name = $this->model_bill_print_invoice->get_owner_name($filter_owner); 

			$template = new Template();		
			$template->data['title'] = 'Invoice';
			$template->data['owner_name'] = $owner_name;
			$template->data['final_datas'] = $final_datass;
			$template->data['filter_date_start'] = $filter_date_start;
			$template->data['filter_date_end'] = $filter_date_end;
			$template->data['path'] = $path;
			$template->data['email'] = $this->config->get('config_email');
			$template->data['telephone'] = $this->config->get('config_telephone');
			if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
				$template->data['base'] = "http://5.189.160.61/phiroz_2020/admin/";
			} else {
				$template->data['base'] = "http://5.189.160.61/phiroz_2020/admin/";
			}
			$html = $template->fetch('report/bill_text.tpl');
			// echo "<pre>";
			// print_r($html);
			// exit;
			return $html;
		}

}
?>
