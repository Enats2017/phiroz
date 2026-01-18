<?php
class ControllerToolCancelBill extends Controller { 
	public function index() {  
		$this->language->load('tool/cancel_bill');

		$this->document->setTitle($this->language->get('heading_title'));

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
			'href'      => $this->url->link('tool/cancel_bill', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$this->load->model('bill/print_invoice');

		$this->data['bill_checklist'] = array();

		$data = array(
			'filter_bill_id' 		 => $filter_bill_id,
			'start'                  => ($page - 1) * 7000,
			'limit'                  => 7000
		);

		$order_total = 0;
		if(isset($this->request->get['first']) && $this->request->get['first'] == 0){
			$bill_datas = $this->model_bill_print_invoice->getbillids_bill($data);
			if($bill_datas){
				foreach ($bill_datas as $bill_data) {
					$bill_total = $this->model_bill_print_invoice->get_bill_data($bill_data['bill_id']);
					$bill_id = $bill_data['bill_id'];
					$cancel_status = $bill_data['cancel_status'];
				}
				$horse_name = $this->model_bill_print_invoice->get_horse_name($bill_datas[0]['horse_id']);
				$trainer_name = $this->model_bill_print_invoice->get_trainer_name($bill_datas[0]['trainer_id']);
				$action = array();
				if($cancel_status == 0){
					$action[] = array(
						'text' => $this->language->get('text_cancel'),
						'href' => $this->url->link('tool/cancel_bill/cancel', 'token=' . $this->session->data['token'] .'&horse_id=' . $bill_datas[0]['horse_id'] . '&filter_bill_id=' . $bill_id, 'SSL')
					);
				} else {
					$action[] = array(
						'text' => $this->language->get('text_active'),
						'href' => $this->url->link('tool/cancel_bill/active', 'token=' . $this->session->data['token'] .'&horse_id=' . $bill_datas[0]['horse_id'] . '&filter_bill_id=' . $bill_id, 'SSL')
					);
				}
				$this->data['bill_checklist'][] = array(
					'bill_id' 	 => $bill_id,
					'horse_name' => $horse_name,
					'trainer_name' => $trainer_name,
					'total'      => $this->currency->format($bill_total, $this->config->get('config_currency')),
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
		
		
		$this->data['column_action'] = $this->language->get('column_action');
		$this->data['column_sr_no'] = $this->language->get('column_sr_no');
		$this->data['column_bill_no'] = $this->language->get('column_bill_no');
		$this->data['column_horse_name'] = $this->language->get('column_horse_name');
		$this->data['column_owner_name'] = $this->language->get('column_owner_name');
		$this->data['column_trainer_name'] = $this->language->get('column_trainer_name');
		$this->data['column_total'] = $this->language->get('column_total');
		$this->data['column_balance'] = $this->language->get('column_balance');

		$this->data['entry_bill_id'] = $this->language->get('entry_bill_id');
		$this->data['button_filter'] = $this->language->get('button_filter');
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
		$pagination->limit = 7000;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('tool/payment_tracking', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['filter_bill_id'] = $filter_bill_id;

		$this->template = 'tool/cancel_bill.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function cancel(){
		$this->language->load('tool/cancel_bill');
		$this->load->model('bill/print_invoice');

		$this->document->setTitle($this->language->get('heading_title'));

		if (isset($this->request->get['filter_bill_id'])) {
			$filter_bill_id = $this->request->get['filter_bill_id'];
		} else {
			$filter_bill_id = '';
		}

		$this->model_bill_print_invoice->updatebillstatus($filter_bill_id, '0', '1');

		$url = '';

		if (isset($this->request->get['filter_bill_id'])) {
			$url .= '&filter_bill_id=' . $this->request->get['filter_bill_id'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		$url .= '&first=0';

		$this->session->data['success'] = 'Success: You have modified the bill!';
		$this->redirect($this->url->link('tool/cancel_bill', 'token=' . $this->session->data['token'] . $url, 'SSL'));
	}

	public function active(){
		$this->language->load('tool/cancel_bill');
		$this->load->model('bill/print_invoice');

		$this->document->setTitle($this->language->get('heading_title'));

		if (isset($this->request->get['filter_bill_id'])) {
			$filter_bill_id = $this->request->get['filter_bill_id'];
		} else {
			$filter_bill_id = '';
		}

		$this->model_bill_print_invoice->updatebillstatus($filter_bill_id, '1', '0');

		$url = '';

		if (isset($this->request->get['filter_bill_id'])) {
			$url .= '&filter_bill_id=' . $this->request->get['filter_bill_id'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		$url .= '&first=0';

		$this->session->data['success'] = 'Success: You have modified the bill!';
		$this->redirect($this->url->link('tool/cancel_bill', 'token=' . $this->session->data['token'] . $url, 'SSL'));
	}
}
?>
