<?php
class ControllerBillPrintReceipt extends Controller { 
	public function index() {  
		$this->language->load('bill/print_receipt');

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
			'href'      => $this->url->link('bill/print_receipt', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$this->load->model('bill/print_invoice');

		$this->data['bill_checklist'] = array();

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

		$this->data['column_sr_no'] = $this->language->get('column_sr_no');
		$this->data['column_bill_no'] = $this->language->get('column_bill_no');
		$this->data['column_horse_name'] = $this->language->get('column_horse_name');
		$this->data['column_owner_name'] = $this->language->get('column_owner_name');
		$this->data['column_trainer_name'] = $this->language->get('column_trainer_name');
		$this->data['column_total'] = $this->language->get('column_total');
		$this->data['column_action'] = $this->language->get('column_action');

		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_month'] = $this->language->get('entry_month');
		$this->data['entry_year'] = $this->language->get('entry_year');

		$this->data['entry_doctor'] = $this->language->get('entry_doctor');
		$this->data['entry_trainer'] = $this->language->get('entry_trainer');
		$this->data['entry_transaction_type'] = $this->language->get('entry_transaction_type');	
		
		$this->data['button_filter'] = $this->language->get('button_filter');
		$this->data['button_list'] = $this->language->get('button_list');

		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['token'] = $this->session->data['token'];

		if(isset($this->session->data['warning'])){
			$this->data['error_warning'] = $this->session->data['warning'];
			unset($this->session->data['warning']);
		} else {
			$this->data['error_warning'] = '';
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

		if (isset($this->request->get['filter_doctor'])) {
			$url .= '&filter_doctor=' . $this->request->get['filter_doctor'];
		}

		if (isset($this->request->get['filter_trainer'])) {
			$url .= '&filter_trainer=' . $this->request->get['filter_trainer'];
		}

		if (isset($this->request->get['filter_trainer_id'])) {
			$url .= '&filter_trainer_id=' . $this->request->get['filter_trainer_id'];
		}

		$order_total = 0;
		$pagination = new Pagination();
		$pagination->total = $order_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('bill/print_receipt', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['filter_name'] = $filter_name;
		$this->data['filter_name_id'] = $filter_name_id;
		$this->data['filter_month'] = $filter_month;		
		$this->data['filter_year'] = $filter_year;
		$this->data['filter_doctor'] = $filter_doctor;
		$this->data['filter_trainer'] = $filter_trainer;
		$this->data['filter_trainer_id'] = $filter_trainer_id;

		$this->template = 'bill/print_receipt.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function printreceipt(){
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
			'filter_date_start'      => $filter_date_start,
			'filter_date_end'        => $filter_date_end,
			'filter_name'            => $filter_name,
			'filter_name_id'         => $filter_name_id,
			'filter_doctor'          => $filter_doctor,
			'filter_trainer' 		 => $filter_trainer,
			'filter_trainer_id' 	 => $filter_trainer_id
		);

		$final_data = array();
		if(isset($this->session->data['bill_id_array']) && $this->session->data['bill_id_array']){
			$bill_id_array = $this->session->data['bill_id_array'];
			//$bill_groups = $this->model_bill_print_invoice->getbill_groups($data);
			foreach ($bill_id_array as $bkey => $bvalue) {
				$data['filter_bill_id'] = $bvalue['bill_id'];
				$bill_owner_groups = $this->model_bill_print_invoice->getbillowners($data);
				$i=1;
				foreach ($bill_owner_groups as $result) {
					$horse_name = $this->model_bill_print_invoice->get_horse_name($result['horse_id']);
					$owner_name = $this->model_bill_print_invoice->get_owner_name($result['owner_id']);
					$trainer_name = $this->model_bill_print_invoice->get_trainer_name($result['trainer_id']);
					$doctor_name = $this->model_bill_print_invoice->get_doctor_name($result['doctor_id']);
					$owner_transactiontype = $this->model_bill_print_invoice->get_owner_transactiontype($result['owner_id']);
					$month = date("F", mktime(0, 0, 0, $bvalue['month'], 10));
					$year = $bvalue['year'];
					if($owner_transactiontype == 1){
						$final_data[] = array(
							'bill_id' 	 => $result['bill_id'].'-'.$i,
							'horse_name' => $horse_name,
							'owner_name' => $owner_name,
							'owner_share' => $result['owner_share'],
							'owner_amt' => $result['owner_amt'],
							'trainer_name' => $trainer_name,
							'doctor_name' => $doctor_name,
							'month' => $month,
							'year'  => $year,
							'total'      => $this->currency->format($result['owner_amt'], $this->config->get('config_currency'))
						);
						$i++;
					}
				}
			}
		}
		
		// echo '<pre>';
		// print_r($final_data);
		// exit;

		if($final_data){
			$month = date('m', strtotime($filter_date_start));
			$year = date('Y', strtotime($filter_date_start));
			$month = date("F", mktime(0, 0, 0, $month, 10));
			$template = new Template();		
			$template->data['final_data'] = $final_data;
			$template->data['month'] = $month;
			$template->data['year'] = $year;
			$template->data['tdate'] = date('d, M Y');
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
				$template->data['base'] = HTTPS_SERVER;
			} else {
				$template->data['base'] = HTTP_SERVER;
			}
			$html = $template->fetch('bill/receipt_html.tpl');
			$filename = "Owner_Receipt.html";
			header('Content-type: text/html');
			header('Set-Cookie: fileLoading=true');
			header('Content-Disposition: attachment; filename='.$filename);
			echo $html;
		} else {
			$this->session->data['warning'] = 'No Data Found';
			$this->redirect($this->url->link('bill/print_invoice', 'token=' . $this->session->data['token'], 'SSL'));
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
			$doctor_name = $this->model_bill_print_invoice->get_doctor_name($result['doctor_id']);
			$owner_transactiontype = $this->model_bill_print_invoice->get_owner_transactiontype($result['owner_id']);
			$medicine_doctor_id = $result['doctor_id'];
				
			$bill_datas = $this->model_bill_print_invoice->getbillmonyear($result['bill_id']);
			$month = date("F", mktime(0, 0, 0, $result['month'], 10));
			$year = $result['year'];

			if($owner_transactiontype == 1){
				$final_data[] = array(
					'bill_id' 	 => $result['bill_id'].'-'.$filter_i,
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
			$template->data['tdate'] = date('d, M Y');
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
				$template->data['base'] = HTTPS_SERVER;
			} else {
				$template->data['base'] = HTTP_SERVER;
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
			$this->redirect($this->url->link('bill/print_invoice', 'token=' . $this->session->data['token'], 'SSL'));
		}
	}
}
?>
