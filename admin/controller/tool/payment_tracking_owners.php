<?php
class ControllerToolPaymentTrackingOwners extends Controller { 
	public function index() {  
		$this->language->load('tool/payment_tracking_owners');

		$this->document->setTitle($this->language->get('heading_title'));

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

		if (isset($this->request->get['filter_amount'])) {
			$filter_amount = $this->request->get['filter_amount'];
		} else {
			$filter_amount = '';
		}

		if (isset($this->request->get['filter_doctor'])) {
			$filter_doctor = $this->request->get['filter_doctor'];
		} else {
			$filter_doctor = '1';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['filter_owner'])) {
			$url .= '&filter_owner=' . $this->request->get['filter_owner'];
		}

		if (isset($this->request->get['filter_owner_id'])) {
			$url .= '&filter_owner_id=' . $this->request->get['filter_owner_id'];
		}

		if (isset($this->request->get['filter_amount'])) {
			$url .= '&filter_amount=' . $this->request->get['filter_amount'];
		}

		if (isset($this->request->get['filter_doctor'])) {
			$url .= '&filter_doctor=' . $this->request->get['filter_doctor'];
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

		$this->load->model('bill/print_invoice');

		$this->data['bill_checklist'] = array();

		$data = array(
			'filter_doctor'			 => $filter_doctor,
			'filter_owner'           => $filter_owner_id,
			'filter_owner_name'      => $filter_owner,
			//'filter_unpaid'          => '1',
			'start'                  => ($page - 1) * 7000,
			'limit'                  => 7000
		);

		$order_total = 0;
		if(isset($this->request->get['first']) && $this->request->get['first'] == 0){
			//$bill_ids = $this->model_bill_print_invoice->getbillids_groups($data);
			//$bill_owner_groups = $this->model_bill_print_invoice->getbillowner_groups($data);
			//foreach ($bill_ids as $bill_id) {
				//$data['filter_bill_id'] = $bill_id['bill_id'];
				$owner_datas = $this->model_bill_print_invoice->getbillowners($data);
				foreach($owner_datas as $okey => $result){
					$horse_name = $this->model_bill_print_invoice->get_horse_name($result['horse_id']);
					$action = array();
					$action[] = array(
						'text' => $this->language->get('text_edit'),
						'href' => $this->url->link('tool/payment_tracking/getform', 'token=' . $this->session->data['token'] .'&horse_id=' . $result['horse_id'] . '&bill_id=' . $result['bill_id'] . '&owner_id=' . $result['owner_id'] . '&doctor_id=' . $result['doctor_id'].$url, 'SSL')
					);
					
					
					$owner_name = $this->model_bill_print_invoice->get_owner_name($result['owner_id']);
					$trainer_name = $this->model_bill_print_invoice->get_trainer_name($result['trainer_id']);
					$this->data['bill_checklist'][] = array(
						'bill_id' 	 => $result['bill_id'],
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
			//}
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
		$this->data['column_balance'] = $this->language->get('column_balance');

		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_owner'] = $this->language->get('entry_owner');
		$this->data['entry_month'] = $this->language->get('entry_month');
		$this->data['entry_year'] = $this->language->get('entry_year');

		$this->data['entry_date_start'] = $this->language->get('entry_date_start');
		$this->data['entry_date_end'] = $this->language->get('entry_date_end');
		$this->data['entry_amount'] = $this->language->get('entry_amount');
		$this->data['entry_dop'] = $this->language->get('entry_dop');

		$this->data['entry_doctor'] = $this->language->get('entry_doctor');
		$this->data['entry_bill_id'] = $this->language->get('entry_bill_id');
		$this->data['entry_trainer'] = $this->language->get('entry_trainer');
		$this->data['entry_transaction_type'] = $this->language->get('entry_transaction_type');	
		
		$this->data['button_filter'] = $this->language->get('button_filter');
		$this->data['button_filter_normal'] = $this->language->get('button_filter_normal');
		$this->data['button_filter_receipt'] = $this->language->get('button_filter_receipt');
		$this->data['button_generate'] = $this->language->get('button_generate');
		$this->data['button_payment'] = $this->language->get('button_payment');

		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['token'] = $this->session->data['token'];

		if(isset($this->session->data['warning'])){
			$this->data['error_warning'] = $this->session->data['warning'];
			unset($this->session->data['warning']);
		} else {
			$this->data['error_warning'] = '';
		}

		$url = '';

		if (isset($this->request->get['filter_owner'])) {
			$url .= '&filter_owner=' . $this->request->get['filter_owner'];
		}

		if (isset($this->request->get['filter_owner_id'])) {
			$url .= '&filter_owner_id=' . $this->request->get['filter_owner_id'];
		}

		if (isset($this->request->get['filter_amount'])) {
			$url .= '&filter_amount=' . $this->request->get['filter_amount'];
		}

		if (isset($this->request->get['filter_doctor'])) {
			$url .= '&filter_doctor=' . $this->request->get['filter_doctor'];
		}

		$pagination = new Pagination();
		$pagination->total = $order_total;
		$pagination->page = $page;
		$pagination->limit = 7000;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('tool/payment_tracking_owners', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['filter_owner'] = $filter_owner;
		$this->data['filter_owner_id'] = $filter_owner_id;
		$this->data['filter_doctor'] = $filter_doctor;
		$this->data['filter_amount'] = $filter_amount;
		$this->data['filter_dop'] = '';

		$this->template = 'tool/payment_tracking_owners.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function payment(){
		$this->language->load('tool/payment_tracking_owners');
		$this->load->model('bill/print_invoice');

		$this->document->setTitle($this->language->get('heading_title'));

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

		if (isset($this->request->get['filter_doctor'])) {
			$filter_doctor = $this->request->get['filter_doctor'];
		} else {
			$filter_doctor = '';
		}

		if (isset($this->request->get['filter_amount'])) {
			$filter_amount = $this->request->get['filter_amount'];
		} else {
			$filter_amount = '';
		}

		if (isset($this->request->get['filter_dop'])) {
			$filter_dop = $this->request->get['filter_dop'];
		} else {
			$filter_dop = date('Y-m-d');
		}

		$data = array(
			'filter_doctor'			 => $filter_doctor,
			'filter_owner'           => $filter_owner_id,
			'filter_owner_name'      => $filter_owner,
			'filter_amount'          => $filter_amount,
			'filter_unpaid'          => '1'
		);
		// echo '<pre>';
		// print_r($data);
		// exit;
		$owner_datas = $this->model_bill_print_invoice->getbillowners_payment($data);
		// echo '<pre>';
		// print_r($owner_datas);
		// exit;
		$datas = array();
		foreach($owner_datas as $okey => $result){
			if($filter_amount > $result['owner_amt']){
				$amt_paying = $result['owner_amt'] - $result['owner_amt_rec'];
				$filter_amount = $filter_amount - $amt_paying;
				$datas[$okey]['bill_owner_id'] = $result['id'];
				$datas[$okey]['owner_amt_paying'] = $amt_paying;
				$datas[$okey]['owner_amt_rec'] = $result['owner_amt_rec'];
				$datas[$okey]['dop'] = $filter_dop;
				$datas[$okey]['owner_amt'] = $result['owner_amt'];
			} elseif($filter_amount > 0){
				$amt_paying = $result['owner_amt'] - $result['owner_amt_rec'];
				$amt_paying = $amt_paying - $filter_amount;
				$datas[$okey]['bill_owner_id'] = $result['id'];
				$datas[$okey]['owner_amt_paying'] = $filter_amount;
				$datas[$okey]['owner_amt_rec'] = $result['owner_amt_rec'];
				$datas[$okey]['owner_amt'] = $result['owner_amt'];
				$datas[$okey]['dop'] = $filter_dop;
				$filter_amount = 0;
			} else{
				break;
			}
		}
		// echo '<pre>';
		// print_r($datas);
		// exit;
		foreach ($datas as $dkey => $dvalue) {
			$this->model_bill_print_invoice->updatepaymentstatus($dvalue);
		}
		

		$url = '';

		if (isset($this->request->get['filter_owner'])) {
			$url .= '&filter_owner=' . $this->request->get['filter_owner'];
		}

		if (isset($this->request->get['filter_owner_id'])) {
			$url .= '&filter_owner_id=' . $this->request->get['filter_owner_id'];
		}

		if (isset($this->request->get['filter_doctor'])) {
			$url .= '&filter_doctor=' . $this->request->get['filter_doctor'];
		}

		// if (isset($this->request->get['filter_amount'])) {
		// 	$url .= '&filter_amount=' . $this->request->get['filter_amount'];
		// }

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		$url .= '&first=0';
		$this->session->data['success'] = 'Payment updated successfully';
		$this->redirect($this->url->link('tool/payment_tracking_owners', 'token=' . $this->session->data['token'] . $url, 'SSL'));
	}
}
?>
