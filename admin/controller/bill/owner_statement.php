<?php
class ControllerBillOwnerStatement extends Controller { 
	public function index() {  
		$this->language->load('bill/owner_statement');

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
			$filter_owner = rtrim($this->request->get['filter_owner'], ',');
		} else {
			$filter_owner = '';
		}

		if (isset($this->request->get['filter_owner_id'])) {
			$filter_owner_id = rtrim($this->request->get['filter_owner_id'], ',');
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
			'href'      => $this->url->link('bill/owner_statement', 'token=' . $this->session->data['token'] . $url, 'SSL'),
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
			$bill_ids = $this->model_bill_print_invoice->getbillids_groups_owner($data);
			//$bill_owner_groups = $this->model_bill_print_invoice->getbillowner_groups($data);
			foreach ($bill_ids as $bill_id) {
				$data['filter_bill_id'] = $bill_id['bill_id'];
				$owner_datas = $this->model_bill_print_invoice->getbillowners_owner($data);
				$i = 1;				
				foreach($owner_datas as $okey => $result){
					$balance = $result['owner_amt']	- $result['owner_amt_rec'];
					$action = array();
					$action[] = array(
						'text' => $this->language->get('text_print'),
						'href' => $this->url->link('bill/bill_history/printinvoiceone', 'token=' . $this->session->data['token'] . '&filter_horse_id=' . $result['horse_id'] . '&filter_bill_id=' . $result['bill_id'] . '&filter_owner=' . $result['owner_id'].'&filter_i='.$i, 'SSL')
					);
					$horse_name = $this->model_bill_print_invoice->get_horse_name($result['horse_id']);
					$owner_name = $this->model_bill_print_invoice->get_owner_name($result['owner_id']);
					$trainer_name = $this->model_bill_print_invoice->get_trainer_name($result['trainer_id']);
					$this->data['bill_checklist'][] = array(
						'bill_id' 	 => $result['bill_id'].'-'.$i,
						'horse_name' => $horse_name,
						'owner_name' => $owner_name,
						'share'    => $result['owner_share']. "% ",
						'trainer_name' => $trainer_name,
						'month' => date('F', strtotime($result['year'].'-'.$result['month'].'-'.'01')),
						'total'      => $this->currency->format($result['owner_amt'], $this->config->get('config_currency')),
						'raw_total'    => $result['owner_amt'],
						'balance'     	=> $balance,
						'payment_status'=> $result['payment_status'],
						'payment_type' 	=> $result['payment_type'],
						'action'    => $action
					);
				$i ++;
				}
			/*	echo'<pre>';print_r($this->data['bill_checklist']);exit;*/
			}
		}
		
		// echo '<pre>';
		// print_r($this->data['bill_checklist']);
		// exit;

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
		$pagination->url = $this->url->link('bill/owner_statement', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['filter_date_start'] = $filter_date_start;
		$this->data['filter_date_end'] = $filter_date_end;
		$this->data['filter_name'] = $filter_name;
		$this->data['filter_name_id'] = $filter_name_id;
		
		$this->data['filter_owner'] = array();
		if($filter_owner){
			$owner_name_exp = explode(',', $filter_owner);
			$owner_id_exp = explode(',', $filter_owner_id);
			$filter_owner_data = array();
			foreach($owner_name_exp as $okey => $ovalue){
				$filter_owner_data[$owner_id_exp[$okey]] = $ovalue;
			}
			$this->data['filter_owner'] = $filter_owner_data;
		}

		$this->data['filter_trainer'] = $filter_trainer;
		$this->data['filter_trainer_id'] = $filter_trainer_id;
		$this->data['filter_doctor'] = $filter_doctor;
		$this->data['filter_bill_id'] = $filter_bill_id;
		$this->data['filter_transaction_type'] = $filter_transaction_type;

		$this->template = 'bill/owner_statement.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function export(){
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
			$filter_owner = rtrim($this->request->get['filter_owner'], ',');
		} else {
			$filter_owner = '';
		}

		if (isset($this->request->get['filter_owner_id'])) {
			$filter_owner_id = rtrim($this->request->get['filter_owner_id'], ',');
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

		
		$bill_ids = $this->model_bill_print_invoice->getbillids_groups_owner($data);
		//$bill_owner_groups = $this->model_bill_print_invoice->getbillowner_groups($data);
		$owner_name = '';
		foreach ($bill_ids as $bill_id) {
			$data['filter_bill_id'] = $bill_id['bill_id'];
			$owner_datas = $this->model_bill_print_invoice->getbillowners_owner($data);
			$i = 1;				
			// echo '<pre>';
			// print_r($owner_datas);
			// exit;
			foreach($owner_datas as $okey => $result){
				$balance = $result['owner_amt']	- $result['owner_amt_rec'];
				$horse_name = $this->model_bill_print_invoice->get_horse_name($result['horse_id']);
				$owner_name = $this->model_bill_print_invoice->get_owner_name($result['owner_id']);
				$trainer_name = $this->model_bill_print_invoice->get_trainer_name($result['trainer_id']);
				$final_data[] = array(
					'bill_id' 	 => $result['bill_id'].'-'.$i.'.',
					'horse_name' => $horse_name,
					'owner_name' => $owner_name,
					'share'    => $result['owner_share']. "% ",
					'trainer_name' => $trainer_name,
					'month' => date('F Y', strtotime($result['year'].'-'.$result['month'].'-'.'01')),
					'total'      => $this->currency->format($result['owner_amt'], $this->config->get('config_currency')),
					'raw_total'    => $result['owner_amt'],
					'balance'     	=> $balance,
					'payment_status'=> $result['payment_status'],
					'payment_type' 	=> $result['payment_type'],
				);
			$i ++;
			}
		}
		
		// echo '<pre>';
		// print_r($final_data);
		// exit;

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
			$template = new Template();
			if($filter_doctor == 1){
				$doctor_name = 'Dr. Phiroz Khambatta';			
			} elseif($filter_doctor == 2){
				$doctor_name = 'Dr. Leila Fernandes';
			}			
			$template->data['doctor_name'] = $doctor_name;
			$template->data['final_datas'] = $final_data;
			if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
				$template->data['base'] = HTTPS_SERVER;
			} else {
				$template->data['base'] = HTTP_SERVER;
			}
			$html = $template->fetch('bill/owner_statement_html.tpl');
			//echo $html;exit;			
			if($owner_name != ''){
				$owner_name = str_replace(array(' ', ',', '&', '.'), '_', $owner_name);
				//echo $owner_name;exit;
				$filename = "Statement";
			} else {
				$filename = "Statement";
			}
			//header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
			//header("Content-Disposition: attachment; filename=".$filename.".xls");//File name extension was wrong
			//header("Expires: 0");
			//header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			//header("Cache-Control: private",false);
			header('Content-type: text/html');
			//header('Set-Cookie: fileLoading=true');
			header('Content-Disposition: attachment; filename='.$filename.'.html');			
			print $html;			
			exit;
		} else {
			$this->session->data['warning'] = 'No Data Found';
			$this->redirect($this->url->link('bill/owner_statement', 'token=' . $this->session->data['token'].$url, 'SSL'));
		}
	}
	public function csv_export(){
		$this->language->load('bill/print_invoice');
		$this->load->model('bill/print_invoice');

		$this->document->setTitle($this->language->get('heading_title'));
		function my_money_format($number) 
		{ 
			//$number = '2953154.83';

			$negative = '';
			if(strstr($number,"-")) 
			{ 
				$number = str_replace("-","",$number); 
				$negative = "-"; 
			} 
			
			$split_number = @explode(".",$number); 
			$rupee = $split_number[0]; 
			if(isset($split_number[1])){
			$paise = @$split_number[1]; 
			} else {
			$paise = '00';
			}
			
			if(@strlen($rupee)>3) 
			{ 
				$hundreds = substr($rupee,strlen($rupee)-3); 
				$thousands_in_reverse = strrev(substr($rupee,0,strlen($rupee)-3)); 
				$thousands = '';
				
				for($i=0; $i<(strlen($thousands_in_reverse)); $i=$i+2) 
				{
					if(isset($thousands_in_reverse[$i+1])){
					$thousands .= $thousands_in_reverse[$i].$thousands_in_reverse[$i+1].","; 
					} else {
					$thousands .= $thousands_in_reverse[$i].","; 
					}
				} 
				$thousands = strrev(trim($thousands,",")); 
				$formatted_rupee = $thousands.",".$hundreds; 
			} else { 
				$formatted_rupee = $rupee; 
			} 
			
			$formatted_paise = '.00';
			if((int)$paise>0) 
			{ 
				$formatted_paise = ".".substr($paise,0,2); 
			} 
			
			return $negative.$formatted_rupee.$formatted_paise; 

		}

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
			$filter_owner = rtrim($this->request->get['filter_owner'], ',');
		} else {
			$filter_owner = '';
		}

		if (isset($this->request->get['filter_owner_id'])) {
			$filter_owner_id = rtrim($this->request->get['filter_owner_id'], ',');
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

		
		$bill_ids = $this->model_bill_print_invoice->getbillids_groups_owner($data);
		//$bill_owner_groups = $this->model_bill_print_invoice->getbillowner_groups($data);
		$owner_name = '';
		foreach ($bill_ids as $bill_id) {
			$data['filter_bill_id'] = $bill_id['bill_id'];
			$owner_datas = $this->model_bill_print_invoice->getbillowners_owner($data);
			$i = 1;				
			// echo '<pre>';
			// print_r($owner_datas);
			// exit;
			foreach($owner_datas as $okey => $result){
				$balance = $result['owner_amt']	- $result['owner_amt_rec'];
				$horse_name = $this->model_bill_print_invoice->get_horse_name($result['horse_id']);
				$owner_name = $this->model_bill_print_invoice->get_owner_name($result['owner_id']);
				$trainer_name = $this->model_bill_print_invoice->get_trainer_name($result['trainer_id']);
				$final_data[] = array(
					'bill_id' 	 => $result['bill_id'].'-'.$i.'.',
					'horse_name' => $horse_name,
					'owner_name' => $owner_name,
					'share'    => $result['owner_share']. "% ",
					'trainer_name' => $trainer_name,
					'month' => date('F Y', strtotime($result['year'].'-'.$result['month'].'-'.'01')),
					'total'      => $this->currency->format($result['owner_amt'], $this->config->get('config_currency')),
					'raw_total'    => $result['owner_amt'],
					'balance'     	=> $balance,
					'payment_status'=> $result['payment_status'],
					'payment_type' 	=> $result['payment_type'],
				);
			$i ++;
			}
		}
		
		// echo '<pre>';
		// print_r($final_data);
		// exit;

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
		if($filter_doctor == 1){
			$doctor_name = 'Dr. Phiroz Khambatta_';			
		} elseif($filter_doctor == 2){
			$doctor_name = 'Dr. Leila Fernandes_';
		} else {
			$doctor_name = '';
		}
		if($final_data){
			$filename = $doctor_name . "Statement.csv";
			$fp = fopen('php://output', 'w');
			// if (ob_get_level()) {
			// 	ob_end_clean();
			// }
			header('Content-type: application/csv');
			header('Content-Disposition: attachment; filename='.$filename);
	
			$header = array("Bill Id", "Horse Name", "Trainer Name", "Owner Name", "Share", "Month", "Total", "Balance", "Status");
			fputcsv($fp, $header);
			$i = 1; 
			$total = 0;
			$balance_total = 0;
			foreach ($final_data as $fkey => $value) {
				$payment_status = ($value['payment_status'] == 1) ? 'Paid' : 'Unpaid';
                $content = array($value['bill_id'], $value['horse_name'], $value['trainer_name'], $value['owner_name'], $value['share'], $value['month'], $value['total'], 'Rs.'. $value['balance'], $payment_status);
                fputcsv($fp, $content);
				$i++; 
				$total += $value['raw_total'];
				$balance_total += $value['balance'];
            }
			$total_format = "Rs. ".my_money_format($total);
			$balance_total_format = "Rs. ".my_money_format($balance_total);
			$footer = array("", "", "", "", "", "", $total_format, $balance_total_format, "");
			fputcsv($fp, $footer);
            fclose($fp);
            exit;
			// $template = new Template();
			// if($filter_doctor == 1){
			// 	$doctor_name = 'Dr. Phiroz Khambatta';			
			// } elseif($filter_doctor == 2){
			// 	$doctor_name = 'Dr. Leila Fernandes';
			// }			
			// $template->data['doctor_name'] = $doctor_name;
			// $template->data['final_datas'] = $final_data;
			// if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			// 	$template->data['base'] = HTTPS_SERVER;
			// } else {
			// 	$template->data['base'] = HTTP_SERVER;
			// }
			// $html = $template->fetch('bill/owner_statement_html.tpl');
			// //echo $html;exit;			
			// if($owner_name != ''){
			// 	$owner_name = str_replace(array(' ', ',', '&', '.'), '_', $owner_name);
			// 	//echo $owner_name;exit;
			// 	$filename = "Statement";
			// } else {
			// 	$filename = "Statement";
			// }
			//header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
			//header("Content-Disposition: attachment; filename=".$filename.".xls");//File name extension was wrong
			//header("Expires: 0");
			//header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			//header("Cache-Control: private",false);
			// header('Content-type: text/html');
			//header('Set-Cookie: fileLoading=true');
			// header('Content-Disposition: attachment; filename='.$filename.'.html');			
			// print $html;			
			// exit;
		} else {
			$this->session->data['warning'] = 'No Data Found';
			$this->redirect($this->url->link('bill/owner_statement', 'token=' . $this->session->data['token'].$url, 'SSL'));
		}
	}
}
?>
