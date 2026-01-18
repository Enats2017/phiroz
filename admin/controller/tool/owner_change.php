<?php
class ControllerToolOwnerChange extends Controller { 
	public function index() {  
		$this->language->load('tool/owner_change');

		$this->document->setTitle($this->language->get('heading_title'));

		if (isset($this->request->get['filter_bill_id'])) {
			$filter_bill_id = $this->request->get['filter_bill_id'];
		} else {
			$filter_bill_id = '';
		}

		$url = '';

		if (isset($this->request->get['filter_bill_id'])) {
			$url .= '&filter_bill_id=' . $this->request->get['filter_bill_id'];
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),       		
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('tool/owner_change', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$this->load->model('bill/print_invoice');

		$this->data['bill_checklist'] = array();

		$filter_name = '';
		$filter_name_id = '';
		$filter_doctor = '';
		$filter_owner_id = '';
		$filter_owner = '';
		$filter_trainer = '';
		$filter_trainer_id = '';
		$page = 0;

		$data = array(
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
			foreach ($bill_ids as $result) {
				$horse_name = $this->model_bill_print_invoice->get_horse_name($result['horse_id']);
				$action = array();
				$action[] = array(
					'text' => $this->language->get('text_edit'),
					'href' => $this->url->link('tool/owner_change/getform', 'token=' . $this->session->data['token'] .'&horse_id=' . $result['horse_id'] . '&bill_id=' . $result['bill_id'] . '&doctor_id=' . $result['doctor_id'].$url, 'SSL')
				);
				$trainer_name = $this->model_bill_print_invoice->get_trainer_name($result['trainer_id']);
				$this->data['bill_checklist'][] = array(
					'bill_id' 	 => $result['bill_id'],
					'horse_name' => $horse_name,
					'trainer_name' => $trainer_name,
					'action'    => $action
				);
			}
		}
		
		// echo '<pre>';
		// print_r($this->data['bill_checklist']);
		// exit;
		
		if(isset($this->session->data['success'])){
			$this->data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['token'] = $this->session->data['token'];

		if(isset($this->session->data['warning'])){
			$this->data['error_warning'] = $this->session->data['warning'];
			unset($this->session->data['warning']);
		} else {
			$this->data['error_warning'] = '';
		}

		$url = '';

		if (isset($this->request->get['filter_bill_id'])) {
			$url .= '&filter_bill_id=' . $this->request->get['filter_bill_id'];
		}

		$pagination = new Pagination();
		$pagination->total = $order_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('tool/owner_change', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();
		$this->data['filter_bill_id'] = $filter_bill_id;
		
		$this->template = 'tool/owner_change.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function getform(){
		$this->language->load('tool/owner_change');
		$this->load->model('bill/print_invoice');

		$this->document->setTitle($this->language->get('heading_title'));
		$this->data['heading_title'] = $this->language->get('heading_title');

		if(isset($this->request->post['bill_id'])){
			$filter_bill_id = $this->request->post['bill_id'];
		}elseif (isset($this->request->get['filter_bill_id'])) {
			$filter_bill_id = $this->request->get['filter_bill_id'];
		} else {
			$filter_bill_id = '';
		}

		if(isset($this->session->data['warning'])){
			$this->data['error_warning'] = $this->session->data['warning'];
			unset($this->session->data['warning']);
		} else {
			$this->data['error_warning'] = '';
		}

		$this->data['error_owners'] = array();

		if(isset($this->error['share_less'])){
			$this->data['error_share_less'] = $this->error['share_less'];
		} else {
			$this->data['error_share_less'] = '';
		}

		$data = array(
			'filter_transaction_type' => '',
			'filter_bill_id' 		 => $filter_bill_id
		);

		$owner_datas = array();
		if (($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$owner_datas = $this->model_bill_print_invoice->getbillowners($data);
		}

		if(isset($this->request->post['bill_id'])){
			$this->data['bill_id'] = $this->request->post['bill_id'];
		} elseif(isset($owner_datas[0]['bill_id'])){
			$this->data['bill_id'] = $owner_datas[0]['bill_id'];
		} else {
			$this->data['bill_id'] = 0;
		}

		// echo '<pre>';
		// print_r($owner_datas);
		// exit;

		$horse_name = '';
		$trainer_name = '';
		$horse_id = 0;
		$trainer_id = 0;
		$this->data['total_amt'] = 0;
		$this->data['doctor_id'] = 0;
		$this->data['month'] = 0;
		$this->data['year'] = 0;
		$this->data['cheque_no'] = 0;
		$this->data['total_amount'] = 0;
		$this->data['batch_id'] = 0;
		$this->data['invoice_date'] = 0;
		$this->data['accept'] = 0;
		if(isset($owner_datas[0])){
			// foreach ($owner_datas[0] as $okey => $ovalue) {
			// 	$horse_id = $ovalue['horse_id'];
			// 	$trainer_id = $ovalue['trainer_id'];
			// 	$horse_name = $this->model_bill_print_invoice->get_horse_name($ovalue['horse_id']);
			// 	$trainer_name = $this->model_bill_print_invoice->get_trainer_name($ovalue['trainer_id']);
			// }
			foreach ($owner_datas as $okey => $ovalue) {
				$this->data['doctor_id'] = $ovalue['doctor_id'];
				$this->data['month'] = $ovalue['month'];
				$this->data['year'] = $ovalue['year'];
				$this->data['cheque_no'] = $ovalue['cheque_no'];
				$this->data['total_amount'] = $ovalue['total_amount'];
				$this->data['batch_id'] = $ovalue['batch_id'];
				$this->data['invoice_date'] = $ovalue['invoice_date'];
				$this->data['accept'] = $ovalue['accept'];
				break;
			}
			$total_amt = 0;
			foreach ($owner_datas as $okey1 => $ovalue1) {
				$total_amt = $total_amt + $ovalue1['owner_amt'];
			}
			$this->data['total_amt'] = $total_amt;
		}

		$this->data['token'] = $this->session->data['token'];

		// echo '<pre>';
		// print_r($owner_datas);
		// exit;

		if(isset($this->request->post['horse_id'])){
			$this->data['horse_id'] = $this->request->post['horse_id'];
			$this->data['horse_name'] = $this->request->post['horse_name'];
		} elseif(isset($owner_datas[0]['horse_id'])){
			$this->data['horse_id'] = $owner_datas[0]['horse_id'];
			$this->data['horse_name'] = $this->model_bill_print_invoice->get_horse_name($this->data['horse_id']);
		} else {
			$this->data['horse_id'] = 0;
			$this->data['horse_name'] = '';
		}

		if(isset($this->request->post['trainer_id'])){
			$this->data['trainer_id'] = $this->request->post['trainer_id'];
			$this->data['trainer_name'] = $this->request->post['trainer_name'];
		} elseif(isset($owner_datas[0]['trainer_id'])){
			$this->data['trainer_id'] = $owner_datas[0]['trainer_id'];
			$this->data['trainer_name'] = $this->model_bill_print_invoice->get_trainer_name($this->data['trainer_id']);
		} else {
			$this->data['trainer_id'] = 0;
			$this->data['trainer_name'] = '';
		}

		$owners_assigned = array();
		if(isset($this->request->post['owners'])){
			$this->data['owners'] = $this->request->post['owners'];
		} elseif(isset($owner_datas[0])){
			foreach ($owner_datas as $okey => $ovalue) {
				$owner_name = $this->model_bill_print_invoice->get_owner_name($ovalue['owner_id']);
				$owners_assigned[$okey]['o_id'] = $ovalue['id'];
				$owners_assigned[$okey]['o_name'] = $owner_name;
				$owners_assigned[$okey]['o_name_id'] = $ovalue['owner_id'];
				$owners_assigned[$okey]['o_share'] = $ovalue['owner_share'];
				$owners_assigned[$okey]['o_amt'] = $ovalue['owner_amt'];
				$owners_assigned[$okey]['o_dop'] = $ovalue['dop'];
				$owners_assigned[$okey]['o_accept'] = $ovalue['accept'];
				$owners_assigned[$okey]['o_invoice_date'] = $ovalue['invoice_date'];
				$owners_assigned[$okey]['o_transaction_type'] = $ovalue['transaction_type'];
				$owners_assigned[$okey]['o_owner_amt_rec'] = $ovalue['owner_amt_rec'];
				$owners_assigned[$okey]['o_payment_status'] = $ovalue['payment_status'];
				$owners_assigned[$okey]['o_owner_code'] = $ovalue['owner_code'];
				$owners_assigned[$okey]['o_batch_id'] = $ovalue['batch_id'];
				$owners_assigned[$okey]['o_cheque_no'] = $ovalue['cheque_no'];
				$owners_assigned[$okey]['o_total_amount'] = $ovalue['total_amount'];
			}
			$this->data['owners'] = $owners_assigned;
		} else {
			$this->data['owners'] = array();
		}

		// echo '<pre>';
		// print_r($this->data['owners']);
		// exit;


		$url = '';

		if (isset($this->request->get['filter_bill_id'])) {
			$url .= '&filter_bill_id=' . $this->request->get['filter_bill_id'];
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
			'href'      => $this->url->link('tool/owner_change', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$this->data['action'] = $this->url->link('tool/owner_change/payment', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['cancel'] = $this->url->link('tool/owner_change', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$this->template = 'tool/owner_change_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function payment(){
		$this->language->load('tool/owner_change');
		$this->load->model('bill/print_invoice');

		$this->document->setTitle($this->language->get('heading_title'));
		
		if (isset($this->request->get['filter_bill_id'])) {
			$filter_bill_id = $this->request->get['filter_bill_id'];
		} else {
			$filter_bill_id = '';
		}

		$this->model_bill_print_invoice->update_bill_owners($this->request->post);
		// echo '<pre>';
		// print_r($this->request->post);
		// exit;
		$url = '';

		if (isset($this->request->get['filter_bill_id'])) {
			$url .= '&filter_bill_id=' . $this->request->get['filter_bill_id'];
		}
		$url .= '&first=0';
		$this->redirect($this->url->link('tool/owner_change', 'token=' . $this->session->data['token'] . $url, 'SSL'));
	}
}
?>
