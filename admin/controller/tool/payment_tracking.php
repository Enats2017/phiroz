<?php
class ControllerToolPaymentTracking extends Controller { 
	public function index() { 
		// echo '<pre>';
		// print_r($this->request->get);
		// exit;

		$this->language->load('tool/payment_tracking');

		$this->document->setTitle($this->language->get('heading_title'));

		if (isset($this->request->get['filter_from_month'])) {
			$filter_from_month = $this->request->get['filter_from_month'];
		} else {
			$filter_from_month = date('m');
		}

		if (isset($this->request->get['filter_to_month'])) {
			$filter_to_month = $this->request->get['filter_to_month'];
		} else {
			$filter_to_month = date('m');
		}

		if (isset($this->request->get['filter_year'])) {
			$filter_year = $this->request->get['filter_year'];
		} else {
			$filter_year = date('Y');
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

		if (isset($this->request->get['filter_cheque_no'])) {
			$filter_cheque_no = $this->request->get['filter_cheque_no'];
		} else {
			$filter_cheque_no = '';
		}

		if (isset($this->request->get['filter_amount'])) {
			$filter_amount = $this->request->get['filter_amount'];
		} else {
			$filter_amount = '';
		}

		if (isset($this->request->get['filter_payment_type'])) {
			$filter_payment_type = $this->request->get['filter_payment_type'];
		} else {
			$filter_payment_type = '2';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['filter_from_month'])) {
			$url .= '&filter_from_month=' . $this->request->get['filter_from_month'];
		}

		if (isset($this->request->get['filter_to_month'])) {
			$url .= '&filter_to_month=' . $this->request->get['filter_to_month'];
		}

		if (isset($this->request->get['filter_year'])) {
			$url .= '&filter_year=' . $this->request->get['filter_year'];
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

		if (isset($this->request->get['filter_cheque_no'])) {
			$url .= '&filter_cheque_no=' . $this->request->get['filter_cheque_no'];
		}

		if (isset($this->request->get['filter_amount'])) {
			$url .= '&filter_amount=' . $this->request->get['filter_amount'];
		}

		if (isset($this->request->get['filter_payment_type'])) {
			$url .= '&filter_payment_type=' . $this->request->get['filter_payment_type'];
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
			'href'      => $this->url->link('tool/payment_tracking', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$this->data['bulk_track'] = $this->url->link('tool/payment_tracking_owners', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['action'] = $this->url->link('tool/payment_tracking/makebulkpayment', 'token=' . $this->session->data['token'].$url, 'SSL');

		$this->load->model('bill/print_invoice');

		$this->data['bill_checklist'] = array();

		$data = array(
			'filter_from_month'      => $filter_from_month,
			'filter_to_month'        => $filter_to_month,
			'filter_year'            => $filter_year,
			'filter_name'            => $filter_name,
			'filter_name_id'         => $filter_name_id,
			'filter_doctor'			 => $filter_doctor,
			'filter_bill_id' 		 => $filter_bill_id,
			'filter_owner'           => $filter_owner_id,
			'filter_owner_name'      => $filter_owner,
			'filter_trainer'         => $filter_trainer,
			'filter_trainer_id'      => $filter_trainer_id,
			'start'                  => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'                  => $this->config->get('config_admin_limit')
		);

			
		$order_total = 0;
		if(isset($this->request->get['first']) && $this->request->get['first'] == 0){
			$bill_ids = $this->model_bill_print_invoice->getbillids_groups($data);
			//$bill_owner_groups = $this->model_bill_print_invoice->getbillowner_groups($data);
			foreach ($bill_ids as $bill_id) {
				$data['filter_bill_id'] = $bill_id['bill_id'];
				$owner_datas = $this->model_bill_print_invoice->getbillowners($data);
				foreach($owner_datas as $okey => $result){
				// echo"<pre>";print_r($result);
				// echo"<pre>";
				// print_r($result);
					$horse_name = $this->model_bill_print_invoice->get_horse_name($result['horse_id']);
					$action = array();
					$action[] = array(
						'text' => $this->language->get('text_edit'),
						'href' => $this->url->link('tool/payment_tracking/getform', 'token=' . $this->session->data['token'] .'&horse_id=' . $result['horse_id'] . '&bill_id=' . $result['bill_id'] . '&owner_id=' . $result['owner_id'] . '&doctor_id=' . $result['doctor_id'].$url, 'SSL')
					);
					
					$owner_name = $this->model_bill_print_invoice->get_owner_name($result['owner_id']);
					$trainer_name = $this->model_bill_print_invoice->get_trainer_name($result['trainer_id']);
					$this->data['bill_checklist'][] = array(
						'id' 	 	 => $result['id'],
						'bill_id' 	 => $result['bill_id'],
						'bill_href' 	=> $this->url->link('bill/bill_history/printinvoiceone', 'token=' . $this->session->data['token'] .'&filter_bill_id=' . $result['bill_id'] . '&filter_horse_id=' . $result['horse_id'] . '&filter_owner=' . $result['owner_id']. 'SSL'),
						'month' 	 => $result['month'],
						'month' 	 => $result['month'],
						'horse_name' => $horse_name,
						'owner_name' => $owner_name,
						'trainer_name' => $trainer_name,
						'total'      => $this->currency->format($result['owner_amt'], $this->config->get('config_currency')),
						'balance'      => $this->currency->format($result['owner_amt']-$result['owner_amt_rec'], $this->config->get('config_currency')),
						'total_raw'      => $result['owner_amt'],
						'balance_raw'      => $result['owner_amt']-$result['owner_amt_rec'],
						'action'    => $action
					);
				}
			

			}
				// exit;
		}
		

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

		$monthss = array(
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

		$this->data['monthss'] = $monthss;

		// $years = array(
		// 	'2015' => '2015',
		// 	'2016' => '2016',
		// 	'2017' => '2017',
		// 	'2018' => '2018',
		// 	'2019' => '2019',
		// 	'2020' => '2020',
		// 	'2021' => '2021',
		// 	'2022' => '2022',
		// 	'202' => '202',
		// );

		$current_year = date("Y");
		$years = range(intval($current_year), 2015);
		$this->data['years'] = $years;

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

		$this->data['payment_types'] = array(
			'1' => 'Cash',
			'2' => 'Cheque',
			'3' => 'Online payment'
		);
		// echo "<pre>";
		// print_r($this->data['payment_types']);
		// exit;

		

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
		$this->data['column_balance'] = $this->language->get('column_balance');

		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_owner'] = $this->language->get('entry_owner');
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
		$this->data['button_bulk_track'] = $this->language->get('button_bulk_track');

		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['token'] = $this->session->data['token'];

		if(isset($this->session->data['warning'])){
			$this->data['error_warning'] = $this->session->data['warning'];
			unset($this->session->data['warning']);
		} else {
			$this->data['error_warning'] = '';
		}

		$url = '';

		if (isset($this->request->get['filter_from_month'])) {
			$url .= '&filter_from_month=' . $this->request->get['filter_from_month'];
		}

		if (isset($this->request->get['filter_to_month'])) {
			$url .= '&filter_to_month=' . $this->request->get['filter_to_month'];
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

		if (isset($this->request->get['filter_doctor'])) {
			$url .= '&filter_doctor=' . $this->request->get['filter_doctor'];
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

		if (isset($this->request->get['filter_trainer'])) {
			$url .= '&filter_trainer=' . $this->request->get['filter_trainer'];
		}

		if (isset($this->request->get['filter_trainer_id'])) {
			$url .= '&filter_trainer_id=' . $this->request->get['filter_trainer_id'];
		}

		if (isset($this->request->get['filter_cheque_no'])) {
			$url .= '&filter_cheque_no=' . $this->request->get['filter_cheque_no'];
		}

		if (isset($this->request->get['filter_amount'])) {
			$url .= '&filter_amount=' . $this->request->get['filter_amount'];
		}

		if (isset($this->request->get['filter_payment_type'])) {
			$url .= '&filter_payment_type=' . $this->request->get['filter_payment_type'];
		}

		$pagination = new Pagination();
		$pagination->total = $order_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('tool/payment_tracking', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['filter_from_month'] = $filter_from_month;
		$this->data['filter_to_month'] = $filter_to_month;
		$this->data['filter_year'] = $filter_year;
		$this->data['filter_name'] = $filter_name;
		$this->data['filter_name_id'] = $filter_name_id;
		$this->data['filter_owner'] = $filter_owner;
		$this->data['filter_owner_id'] = $filter_owner_id;
		$this->data['filter_trainer'] = $filter_trainer;
		$this->data['filter_trainer_id'] = $filter_trainer_id;
		$this->data['filter_doctor'] = $filter_doctor;
		$this->data['filter_bill_id'] = $filter_bill_id;
		$this->data['filter_cheque_no'] = $filter_cheque_no;
		$this->data['filter_amount'] = $filter_amount;
		$this->data['filter_payment_type'] = $filter_payment_type;

		$this->template = 'tool/payment_tracking.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function getform(){
		
		$this->language->load('tool/payment_tracking');
		$this->load->model('bill/print_invoice');

		$this->document->setTitle($this->language->get('heading_title'));
		$this->data['heading_title'] = $this->language->get('heading_title');

		if (isset($this->request->get['filter_from_month'])) {
			$filter_from_month = $this->request->get['filter_from_month'];
		} else {
			$filter_from_month = date('n');
		}

		if (isset($this->request->get['filter_to_month'])) {
			$filter_to_month = $this->request->get['filter_to_month'];
		} else {
			$filter_to_month = date('n');
		}

		if (isset($this->request->get['filter_year'])) {
			$filter_year = $this->request->get['filter_year'];
		} else {
			$filter_year = date('Y');
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
			$filter_doctor = '';
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

		if (isset($this->request->get['filter_bill_id'])) {
			$filter_bill_id = $this->request->get['filter_bill_id'];
		} else {
			$filter_bill_id = '';
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

		if (isset($this->request->get['bill_id'])) {
			$bill_id = $this->request->get['bill_id'];
		} else {
			$bill_id = '';
		}

		if (isset($this->request->get['horse_id'])) {
			$horse_id = $this->request->get['horse_id'];
		} else {
			$horse_id = '';
		}

		if (isset($this->request->get['owner_id'])) {
			$owner_id = $this->request->get['owner_id'];
		} else {
			$owner_id = '';
		}

		if (isset($this->request->get['doctor_id'])) {
			$doctor_id = $this->request->get['doctor_id'];
		} else {
			$doctor_id = '';
		}

		if(isset($this->session->data['warning'])){
			$this->data['error_warning'] = $this->session->data['warning'];
			unset($this->session->data['warning']);
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->request->get['filter_payment_type'])) {
			$filter_payment_type = $this->request->get['filter_payment_type'];
		} else {
			$filter_payment_type = '';
		}
		

		$data = array(
			'filter_name_id'         => $horse_id,
			'filter_owner'         	 => $owner_id,
			'filter_doctor'			 => $doctor_id,
			'filter_bill_id' 		 => $bill_id
		);
		
		$owner_datas = array();
		if (($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$owner_datass = $this->model_bill_print_invoice->getbillowners($data);
			if(isset($owner_datass[0])){
				$owner_datas = $owner_datass[0];
			}
		}

		
		if(isset($this->request->post['bill_id'])){
			$this->data['bill_id'] = $this->request->post['bill_id'];
		} elseif(isset($owner_datas['bill_id'])){
			$this->data['bill_id'] = $owner_datas['bill_id'];
		} else {
			$this->data['bill_id'] = 0;
		}

		if(isset($this->request->post['horse_id'])){
			$this->data['horse_id'] = $this->request->post['horse_id'];
			$this->data['horse_name'] = $this->model_bill_print_invoice->get_horse_name($this->request->post['horse_id']);
		} elseif(isset($owner_datas['horse_id'])){
			$this->data['horse_id'] = $owner_datas['horse_id'];
			$this->data['horse_name'] = $this->model_bill_print_invoice->get_horse_name($owner_datas['horse_id']);
		} else {
			$this->data['horse_id'] = 0;
			$this->data['horse_name'] = '';
		}

		if(isset($this->request->post['owner_id'])){
			$this->data['owner_id'] = $this->request->post['owner_id'];
			$this->data['owner_name'] = $this->model_bill_print_invoice->get_owner_name($this->request->post['owner_id']);
		} elseif(isset($owner_datas['owner_id'])){
			$this->data['owner_id'] = $owner_datas['owner_id'];
			$this->data['owner_name'] = $this->model_bill_print_invoice->get_owner_name($owner_datas['owner_id']);
		} else {
			$this->data['owner_id'] = 0;
			$this->data['owner_name'] = '';
		}

		if(isset($this->request->post['owner_amt'])){
			$this->data['owner_amt'] = $this->request->post['owner_amt'];
		} elseif(isset($owner_datas['owner_amt'])){
			$this->data['owner_amt'] = $owner_datas['owner_amt'];
		} else {
			$this->data['owner_amt'] = 0;
		}

		if(isset($this->request->post['owner_amt_paid'])){
			$this->data['owner_amt_rec'] = $this->request->post['owner_amt_paid'];
		} elseif(isset($owner_datas['owner_amt_rec'])){
			$this->data['owner_amt_rec'] = $owner_datas['owner_amt_rec'];
		} else {
			$this->data['owner_amt_rec'] = 0;
		}

		if(isset($this->request->post['owner_amt_balance'])){
			$this->data['owner_amt_balance'] = $this->request->post['owner_amt_balance'];
		} elseif(isset($owner_datas['owner_amt_rec'])){
			$this->data['owner_amt_balance'] = $owner_datas['owner_amt'] - $owner_datas['owner_amt_rec'];
		} else {
			$this->data['owner_amt_balance'] = 0;
		}

		if(isset($this->request->post['owner_amt_paying'])){
			$this->data['owner_amt_paying'] = $this->request->post['owner_amt_paying'];
		} else {
			$this->data['owner_amt_paying'] = 0;
		}

		if(isset($this->request->post['owner_discount'])){
			$this->data['owner_discount'] = $this->request->post['owner_discount'];
		} else {
			$this->data['owner_discount'] = 0;
		}

		if(isset($this->request->post['total_owner_discount'])){
			$this->data['total_owner_discount'] = $this->request->post['total_owner_discount'];
		} else {
			$this->data['total_owner_discount'] = 0;
		}

		if(isset($this->request->post['t_owner_discount'])){
			$this->data['t_owner_discount'] = $this->request->post['t_owner_discount'];
		} else {
			$this->data['t_owner_discount'] = 0;
		}

		if(isset($this->request->post['owner_amt_paying'])){
			$this->data['owner_amt_paying'] = $this->request->post['owner_amt_paying'];
		} else {
			$this->data['owner_amt_paying'] = 0;
		}

		if(isset($this->request->post['bill_owner_id'])){
			$this->data['bill_owner_id'] = $this->request->post['bill_owner_id'];
		} elseif(isset($owner_datas['id'])){
			$this->data['bill_owner_id'] = $owner_datas['id'];
		} else {
			$this->data['bill_owner_id'] = 0;
		}

		if(isset($this->request->post['dop'])){
			$this->data['dop'] = $this->request->post['dop'];
		} elseif(isset($owner_datas['dop'])){
			$this->data['dop'] = date('Y-m-d');
		} else {
			$this->data['dop'] = date('Y-m-d');
		}

		if(isset($owner_datas['dop'])){
			$this->data['last_payment_date'] = $owner_datas['dop'];
		} else {
			$this->data['last_payment_date'] = '';
		}

		if($this->data['owner_amt_balance'] == 0){
			$this->data['hide_paying'] = 1;
		} else {
			$this->data['hide_paying'] = 0;
		}

		$url = '';

		if (isset($this->request->get['filter_from_month'])) {
			$url .= '&filter_from_month=' . $this->request->get['filter_from_month'];
		}

		if (isset($this->request->get['filter_to_month'])) {
			$url .= '&filter_to_month=' . $this->request->get['filter_to_month'];
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

		if (isset($this->request->get['filter_cheque_no'])) {
			$url .= '&filter_cheque_no=' . $this->request->get['filter_cheque_no'];
		}

		if (isset($this->request->get['filter_amount'])) {
			$url .= '&filter_amount=' . $this->request->get['filter_amount'];
		}

		if (isset($this->request->get['filter_payment_type'])) {
			$url .= '&filter_payment_type=' . $this->request->get['filter_payment_type'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		$url .= '&first=0';
		

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),       		
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('tool/payment_tracking', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);


		$this->data['entry_bill_id'] = $this->language->get('entry_bill_id');
		$this->data['entry_horse_name'] = $this->language->get('entry_horse_name');
		$this->data['entry_owner_name'] = $this->language->get('entry_owner_name');
		$this->data['entry_total'] = $this->language->get('entry_total');
		$this->data['entry_paid'] = $this->language->get('entry_paid');
		$this->data['entry_balance'] = $this->language->get('entry_balance');
		$this->data['entry_paying'] = $this->language->get('entry_paying');
		$this->data['entry_dop'] = $this->language->get('entry_dop');
		$this->data['entry_last_payment_date'] = $this->language->get('entry_last_payment_date');


		$this->data['tab_general'] = $this->language->get('tab_general');
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		
		$this->data['action'] = $this->url->link('tool/payment_tracking/payment', 'token=' . $this->session->data['token'] . $url, 'SSL');
	
		$this->data['cancel'] = $this->url->link('tool/payment_tracking', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$this->template = 'tool/payment_tracking_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function makebulkpayment(){
		$this->load->model('bill/print_invoice');
		$filter_amt = str_replace(',', '', $this->request->get['filter_amount']);
		$remaining =  $filter_amt;
		if(isset($this->request->post['selected'])){
		 $status = 0;
			foreach ($this->request->post['selected'] as $skey => $svalue) {
				if ($remaining != 0)  {
					$remainings = $this->model_bill_print_invoice->updatepaymentstatus_ids($svalue,  $this->request->get['filter_payment_type'], $filter_amt,$remaining);
					$remaining  =	$remainings['remaining'];
					$status  =	$remainings['status'];
					if ($status == 1) {
						break;
					}
				}
			}
		}
		$url = '';
		if (isset($this->request->get['filter_from_month'])) {
			$url .= '&filter_from_month=' . $this->request->get['filter_from_month'];
		}

		if (isset($this->request->get['filter_to_month'])) {
			$url .= '&filter_to_month=' . $this->request->get['filter_to_month'];
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

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if (isset($this->request->get['filter_cheque_no'])) {
			$url .= '&filter_cheque_no=' . $this->request->get['filter_cheque_no'];
		}

		if (isset($this->request->get['filter_amount'])) {
			$url .= '&filter_amount=' . $this->request->get['filter_amount'];
		}

		if (isset($this->request->get['filter_payment_type'])) {
			$url .= '&filter_payment_type=' . $this->request->get['filter_payment_type'];
		}
		$url .= '&first=0';
		$this->redirect($this->url->link('tool/payment_tracking', 'token=' . $this->session->data['token'] . $url, 'SSL'));
	}

	public function payment(){
		// echo"ouut";
		// exit;
		$this->language->load('tool/payment_tracking');
		$this->load->model('bill/print_invoice');

		$this->document->setTitle($this->language->get('heading_title'));

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
			$filter_doctor = '';
		}

		if (isset($this->request->get['filter_bill_id'])) {
			$filter_bill_id = $this->request->get['filter_bill_id'];
		} else {
			$filter_bill_id = '';
		}

		if (isset($this->request->get['filter_cheque_no'])) {
			$this->request->post['cheque_no'] = $this->request->get['filter_cheque_no'];
		} else {
			$this->request->post['cheque_no'] = '';
		}

		if (isset($this->request->get['filter_amount'])) {
			$this->request->post['amount'] = $this->request->get['filter_amount'];
		} else {
			$this->request->post['amount'] = '';
		}

		if (isset($this->request->get['filter_payment_type'])) {
			$this->request->post['payment_type'] = $this->request->get['filter_payment_type'];
		} else {
			$this->request->post['payment_type'] = '';
		}

		$this->model_bill_print_invoice->updatepaymentstatus($this->request->post);

		$url = '';

		if (isset($this->request->get['filter_from_month'])) {
			$url .= '&filter_from_month=' . $this->request->get['filter_from_month'];
		}

		if (isset($this->request->get['filter_to_month'])) {
			$url .= '&filter_to_month=' . $this->request->get['filter_to_month'];
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

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if (isset($this->request->get['filter_cheque_no'])) {
			$url .= '&filter_cheque_no=' . $this->request->get['filter_cheque_no'];
		}

		if (isset($this->request->get['filter_amount'])) {
			$url .= '&filter_amount=' . $this->request->get['filter_amount'];
		}

		if (isset($this->request->get['filter_payment_type'])) {
			$url .= '&filter_payment_type=' . $this->request->get['filter_payment_type'];
		}

		$url .= '&first=0';


		$this->redirect($this->url->link('tool/payment_tracking', 'token=' . $this->session->data['token'] . $url, 'SSL'));
	}
}
?>
