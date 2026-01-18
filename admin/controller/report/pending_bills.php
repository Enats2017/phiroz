<?php
class ControllerReportPendingBills extends Controller { 
	public function index() {  
		$this->language->load('report/pending_bills');

		$this->document->setTitle($this->language->get('heading_title'));

		if (isset($this->request->get['filter_month'])) {
			$filter_month = $this->request->get['filter_month'];
		} else {
			$filter_month = date('m');
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

		if (isset($this->request->get['filter_transaction_type'])) {
			$filter_transaction_type = $this->request->get['filter_transaction_type'];
		} else {
			$filter_transaction_type = '1';
		}

		if (isset($this->request->get['filter_doctor'])) {
			$filter_doctor = $this->request->get['filter_doctor'];
		} else {
			$filter_doctor = '1';
		}

		if (isset($this->request->get['filter_type'])) {
			$filter_type = $this->request->get['filter_type'];
		} else {
			$filter_type = '1';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

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
			'href'      => $this->url->link('report/pending_bills', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

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

		$current_year = date("Y");
		$years = range(intval($current_year), 2015);
		$this->data['years'] = $years;

		$this->load->model('report/common_report');

		$this->data['pending_bills'] = array();

		$data = array(
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

		$order_total = $this->model_report_common_report->gettotal_pending_bills($data);
		
		$results = $this->model_report_common_report->getpending_bills($data);
		$raw_total = 0.00;
		$raw_total_received = 0.00;
		$raw_total_pending = 0.00;
		foreach ($results as $rkey => $result) {
			$horse_id = $this->model_report_common_report->get_horseid_by_bill($result['bill_id']);
			$horse_data = $this->model_report_common_report->get_horse_data($horse_id);
			$trainer_name = $this->model_report_common_report->get_trainer_name($horse_data['trainer']);
			$horse_name = $this->model_report_common_report->get_horse_name($horse_data['horse_id']);
			$owner_name = $this->model_report_common_report->get_owner_name($result['owner_id']);
			$pending_amt = $result['owner_amt'] - $result['owner_amt_rec'];
			
			if($result['payment_type'] == 1){
				$payment_type = 'Cash';
			} elseif ($result['payment_type'] == 2) {
				$payment_type = 'Cheque';
			} else {
				$payment_type = '';
			}

			$raw_total = $raw_total + $result['owner_amt'];
			$raw_total_received = $raw_total_received + $result['owner_amt_rec'];
			$raw_total_pending = $raw_total_pending + $pending_amt;

			$this->data['pending_bills'][] = array(
				'bill_id'       => $result['bill_id'],
				'cheque_no'       => $result['cheque_no'],
				'total_amount'       => $result['total_amount'],
				'payment_type'       => $payment_type,
				'horse_name'     => $horse_name,
				'trainer_name'      => $trainer_name,
				'owner_name'  => $owner_name,
				'total'      => $this->currency->format($result['owner_amt'], $this->config->get('config_currency')),
				'total_received'      => $this->currency->format($result['owner_amt_rec'], $this->config->get('config_currency')),
				'total_pending'      => $this->currency->format($pending_amt, $this->config->get('config_currency'))
			);
		}

		$this->data['raw_total'] = $this->currency->format($raw_total, $this->config->get('config_currency'));
		$this->data['raw_total_received'] = $this->currency->format($raw_total_received, $this->config->get('config_currency'));
		$this->data['raw_total_pending'] = $this->currency->format($raw_total_pending, $this->config->get('config_currency'));

		// echo '<pre>';
		// print_r($this->data['pending_bills']);
		// exit;

		if(isset($this->session->data['warning'])){
			$this->data['error_warning'] = $this->session->data['warning'];
			unset($this->session->data['warning']);
		} else {
			$this->data['error_warning'] = '';
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_all_status'] = $this->language->get('text_all_status');

		$this->data['column_bill_id'] = $this->language->get('column_bill_id');
		$this->data['column_owner'] = $this->language->get('column_owner');
		$this->data['column_trainer'] = $this->language->get('column_trainer');
		$this->data['column_horse_name'] = $this->language->get('column_horse_name');
		$this->data['column_total'] = $this->language->get('column_total');
		$this->data['column_pending'] = $this->language->get('column_pending');
		$this->data['column_received'] = $this->language->get('column_received');

		$this->data['entry_name'] = $this->language->get('entry_name');	
		$this->data['entry_payment_mode'] = $this->language->get('entry_payment_mode');	
		$this->data['entry_month'] = $this->language->get('entry_month');
		$this->data['entry_year'] = $this->language->get('entry_year');
		$this->data['entry_transaction_type'] = $this->language->get('entry_transaction_type');	
		$this->data['entry_doctor'] = $this->language->get('entry_doctor');	

		$this->data['button_filter'] = $this->language->get('button_filter');
		$this->data['button_export'] = $this->language->get('button_export');

		$this->data['token'] = $this->session->data['token'];

		$this->load->model('bill/print_invoice');
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

		$this->data['types'] = array(
			'1' => 'Pending',
			'2' => 'Hold',
			'3' => 'Paid'
		);

		$url = '';

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

		$pagination = new Pagination();
		$pagination->total = $order_total;
		$pagination->page = $page;
		$pagination->limit = 7000;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('report/pending_bills', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();		

		$this->data['filter_month'] = $filter_month;
		$this->data['filter_year'] = $filter_year;		
		$this->data['filter_name'] = $filter_name;
		$this->data['filter_name_id'] = $filter_name_id;
		$this->data['filter_transaction_type'] = $filter_transaction_type;
		$this->data['filter_doctor'] = $filter_doctor;
		$this->data['filter_type'] = $filter_type;

		$this->template = 'report/pending_bills.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function export(){
		$this->language->load('report/pending_bills');
		$this->load->model('report/common_report');

		$this->document->setTitle($this->language->get('heading_title'));

		if (isset($this->request->get['filter_month'])) {
			$filter_month = $this->request->get['filter_month'];
		} else {
			$filter_month = date('m');
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

		if (isset($this->request->get['filter_transaction_type'])) {
			$filter_transaction_type = $this->request->get['filter_transaction_type'];
		} else {
			$filter_transaction_type = '';
		}

		if (isset($this->request->get['filter_type'])) {
			$filter_type = $this->request->get['filter_type'];
		} else {
			$filter_type = '1';
		}

		if (isset($this->request->get['filter_doctor'])) {
			$filter_doctor = $this->request->get['filter_doctor'];
		} else {
			$filter_doctor = '1';
		}

		$data = array(
			'filter_month'	     	 => $filter_month, 
			'filter_year'	     	 => $filter_year, 
			'filter_name'            => $filter_name,
			'filter_name_id'         => $filter_name_id,
			'filter_transaction_type' => $filter_transaction_type,
			'filter_doctor' => $filter_doctor,
			'filter_type' => $filter_type
		);
		
		$pending_bills = array();
		$results = $this->model_report_common_report->getpending_bills($data);
		$raw_total = 0.00;
		$raw_total_received = 0.00;
		$raw_total_pending = 0.00;
		foreach ($results as $rkey => $result) {
			$horse_id = $this->model_report_common_report->get_horseid_by_bill($result['bill_id']);
			$horse_data = $this->model_report_common_report->get_horse_data($horse_id);
			$trainer_name = $this->model_report_common_report->get_trainer_name($horse_data['trainer']);
			$horse_name = $this->model_report_common_report->get_horse_name($horse_data['horse_id']);
			$owner_name = $this->model_report_common_report->get_owner_name($result['owner_id']);
			$pending_amt = $result['owner_amt'] - $result['owner_amt_rec'];
				
			if($result['payment_type'] == 1){
				$payment_type = 'Cash';
			} elseif ($result['payment_type'] == 2) {
				$payment_type = 'Cheque';
			} else {
				$payment_type = '';
			}
			
			$raw_total = $raw_total + $result['owner_amt'];
			$raw_total_received = $raw_total_received + $result['owner_amt_rec'];
			$raw_total_pending = $raw_total_pending + $pending_amt;
			$pending_bills[] = array(
				'bill_id'       => $result['bill_id'],
				'cheque_no'       => $result['cheque_no'],
				'total_amount'       => $result['total_amount'],
				'payment_type'       => $payment_type,
				'horse_name'     => $horse_name,
				'trainer_name'      => $trainer_name,
				'owner_name'  => $owner_name,
				'total'      => $this->currency->format($result['owner_amt'], $this->config->get('config_currency')),
				'total_received'      => $this->currency->format($result['owner_amt_rec'], $this->config->get('config_currency')),
				'total_pending'      => $this->currency->format($pending_amt, $this->config->get('config_currency'))
			);
		}

		$raw_total = $this->currency->format($raw_total, $this->config->get('config_currency'));
		$raw_total_received = $this->currency->format($raw_total_received, $this->config->get('config_currency'));
		$raw_total_pending = $this->currency->format($raw_total_pending, $this->config->get('config_currency'));

		$url = '';
		
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

		if($filter_type == 1){
			$report_name = 'PENDING';
		} elseif ($filter_type == 2) {
			$report_name = 'HOLD';
		} elseif($filter_type == 3){
			$report_name = 'PAID';
		} else {
			$report_name = 'PENDING';
		}

		
		if($pending_bills){
			$month = date("F", mktime(0, 0, 0, $filter_month, 10));
			$template = new Template();		
			$template->data['final_datas'] = $pending_bills;
			$template->data['raw_total'] = $raw_total;
			$template->data['raw_total_received'] = $raw_total_received;
			$template->data['raw_total_pending'] = $raw_total_pending;
			$template->data['month'] = $month;
			$template->data['year'] = $filter_year;
			$template->data['title'] = $report_name . ' Bills Report';
			if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
				$template->data['base'] = HTTPS_SERVER;
			} else {
				$template->data['base'] = HTTP_SERVER;
			}
			$html = $template->fetch('report/pending_bills_html.tpl');
			//echo $html;exit;
			$filename = "Pending_bills.html";
			header('Content-type: text/html');
			header('Content-Disposition: attachment; filename='.$filename);
			echo $html;
			exit;		
		} else {
			$this->session->data['warning'] = 'No Data Found';
			$this->redirect($this->url->link('report/pending_bills', 'token=' . $this->session->data['token'].$url, 'SSL'));
		}
	}
}
?>
