<?php
class ControllerReportHorseData extends Controller { 
	public function index() {  
		$this->language->load('report/horse_data');

		$this->document->setTitle($this->language->get('heading_title'));

		if (isset($this->request->get['h_name'])) {
			$h_name = $this->request->get['h_name'];
		} else {
			$h_name = '';
		}

		if (isset($this->request->get['h_name_id'])) {
			$h_name_id = $this->request->get['h_name_id'];
		} else {
			$h_name_id = '';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['h_name'])) {
			$url .= '&h_name=' . $this->request->get['h_name'];
		}

		if (isset($this->request->get['h_name_id'])) {
			$url .= '&h_name_id=' . $this->request->get['h_name_id'];
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
			'href'      => $this->url->link('report/horse_data', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$this->load->model('report/common_report');
		$data = array(
			'h_name'            	 => $h_name,
			'h_name_id'         	 => $h_name_id,
			'start'                  => ($page - 1) * 5000,
			'limit'                  => 5000
		);

		$order_total = 0;
		$horse_datas = array();
		$this->data['horse_data'] = array();
		$this->data['horse_treatment'] = array();
		if($data['h_name_id'] != ''){
			$horse_data['horse_link'] = $this->url->link('catalog/horse/update', 'token=' . $this->session->data['token'].'&horse_id='.$data['h_name_id'].'&return=1', 'SSL');
			$order_total = $this->model_report_common_report->getTotalHorsedata($data);
			$horse_datas = $this->model_report_common_report->get_horse_data($data['h_name_id']);
			$trainer_name = $this->model_report_common_report->get_trainer_name($horse_datas['trainer']);
			$owner_datas = $this->model_report_common_report->get_owner_data($data['h_name_id']);
			$owner_name_link = '';
			foreach ($owner_datas as $okey => $ovalue) {
				$owner_name = $this->model_report_common_report->get_owner_name($ovalue['owner']);
				$owner_name_link .= "<a href=".$horse_data['horse_link'].">".$owner_name.' - '.$ovalue['share']." %	</a>, ";
			}
			$owner_name_link = rtrim($owner_name_link, ", ");
			$horse_data['name'] = $horse_datas['name'];
			$horse_data['trainer_name'] = $trainer_name;
			$horse_data['owner_datas'] = $owner_name_link;
			$horse_data['horse_wise_entry'] = $this->url->link('transaction/horse_wise', 'token=' . $this->session->data['token'].'&h_name_id='.$data['h_name_id'].'&h_name='.$horse_data['name'].'&return=1', 'SSL');
			$this->data['horse_data'] = $horse_data;
			
			$resultss = $this->model_report_common_report->getHorseTransactiondata($data);
			foreach ($resultss as $results) {
				$is_existbill = $this->model_report_common_report->get_bill_status($results['transaction_id']);
				if($is_existbill){
					$bill_exist = 1;
					$transaction_edit_link = '';
				} else {
					$bill_exist = 0;
					$transaction_edit_link = $this->url->link('transaction/horse_wise', 'token=' . $this->session->data['token'].'&dot='.$results['dot'].'&h_name_id='.$results['horse_id'].'&return=1', 'SSL');
				}
				$result = $this->model_report_common_report->gettransactionbydate($results['dot'], $results['horse_id']);
				foreach ($result as $key => $value) {
					$horse_data = $this->model_report_common_report->get_horse_data($value['horse_id']);
					$trainer_name = $this->model_report_common_report->get_trainer_name($horse_data['trainer']);
					$horse_name = $this->model_report_common_report->get_horse_name($value['horse_id']);
					
					$this->data['horse_treatment'][date('M d, Y', strtotime($value['dot']))][] = array(
						'date_treatment' => date('M d, Y', strtotime($value['dot'])),
						'medicine_name'   => $value['medicine_name'],
						'medicine_quantity' => $value['medicine_quantity'],
						'transaction_edit_link' => $transaction_edit_link,
						'bill_exist' => $bill_exist
					);
				}
			}

			// echo '<pre>';
			// print_r($this->data['horse_treatment']);
			// exit;
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		if(isset($this->session->data['warning'])){
			$this->data['error_warning'] = $this->session->data['warning'];
			unset($this->session->data['warning']);
		} else {
			$this->data['error_warning'] = '';
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_all_status'] = $this->language->get('text_all_status');

		$this->data['column_dot'] = $this->language->get('column_dot');
		$this->data['column_horse_name'] = $this->language->get('column_horse_name');
		$this->data['column_medicine_name'] = $this->language->get('column_medicine_name');
		$this->data['column_medicine_quantity'] = $this->language->get('column_medicine_quantity');
		$this->data['column_total'] = $this->language->get('column_total');
		$this->data['column_trainer'] = $this->language->get('column_trainer');

		$this->data['entry_date_start'] = $this->language->get('entry_date_start');
		$this->data['entry_date_end'] = $this->language->get('entry_date_end');
		$this->data['entry_name'] = $this->language->get('entry_name');	
		$this->data['entry_payment_mode'] = $this->language->get('entry_payment_mode');	
		$this->data['entry_transaction_type'] = $this->language->get('entry_transaction_type');	
		$this->data['entry_doctor'] = $this->language->get('entry_doctor');	

		$this->data['button_filter'] = $this->language->get('button_filter');
		$this->data['button_export'] = $this->language->get('button_export');

		$this->data['token'] = $this->session->data['token'];

		$this->load->model('bill/print_invoice');
		$doctors = $this->model_bill_print_invoice->getdoctors();
		$this->data['doctors'] = $doctors;

		$url = '';

		if (isset($this->request->get['h_name'])) {
			$url .= '&h_name=' . $this->request->get['h_name'];
		}

		if (isset($this->request->get['h_name_id'])) {
			$url .= '&h_name_id=' . $this->request->get['h_name_id'];
		}

		if (isset($this->request->get['filter_doctor'])) {
			$url .= '&filter_doctor=' . $this->request->get['filter_doctor'];
		}		

		$pagination = new Pagination();
		$pagination->total = $order_total;
		$pagination->page = $page;
		$pagination->limit = 50;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('report/horse_data', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();		

		$this->data['h_name'] = $h_name;
		$this->data['h_name_id'] = $h_name_id;

		$this->template = 'report/horse_data.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}
}
?>
