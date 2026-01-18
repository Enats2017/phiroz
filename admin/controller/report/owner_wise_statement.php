<?php
class ControllerReportOwnerWiseStatement extends Controller { 
	public function index() {  
		/*
		$sql = "SELECT * FROM `oc_transaction` WHERE `month` = '02' AND `year` = '2016' AND (`medicine_doctor_id` = '1' OR `medicine_doctor_id` = '2') GROUP BY dot, horse_id, medicine_id having count(`medicine_id`) > 1";
		$datas = $this->db->query($sql);
		$html = '';
		$html = '<table>';
		foreach($datas->rows as $dkey => $dvalue){
			$html .= '<tr>';
				$html .= '<td>';
					$html .= $dvalue['horse_id'];
				$html .= '</td>';
				$html .= '<td>';
					$html .= $dvalue['dot'];
				$html .= '</td>';
				$html .= '<td>';
					$html .= '<a target="_blank" href="http://64.79.95.89/phiroz/admin/index.php?route=transaction/horse_wise&token='.$this->session->data['token'].'&dot='.$dvalue['dot'].'&h_name_id='.$dvalue['horse_id'].'" >Edit</a>';
				$html .= '</td>';
			$html .= '</tr>';
		}
		$html .= '</table>';
		*/		
		//echo $html;exit;
		// echo '<pre>';
		// print_r($datas);
		// exit;

		$this->language->load('report/owner_wise_statement');

		$this->document->setTitle($this->language->get('heading_title'));

		if (isset($this->request->get['filter_date_start'])) {
			$filter_date_start = $this->request->get['filter_date_start'];
		} else {
			$filter_date_start = date('Y-m-d');
		}

		if (isset($this->request->get['filter_date_end'])) {
			$filter_date_end = $this->request->get['filter_date_end'];
		} else {
			$filter_date_end = date('Y-m-d');
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
			'href'      => $this->url->link('report/owner_wise_statement', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$this->load->model('report/common_report');

		$data = array(
			'filter_date_start'	     => $filter_date_start, 
			'filter_date_end'	     => $filter_date_end, 
			'filter_name'            => $filter_name,
			'filter_name_id'         => $filter_name_id,
			'filter_doctor'          => $filter_doctor,
		);

		$order_total = 0;
		//$order_total = $this->model_report_common_report->getTotalhorsetreated($data);
		$resultss = $this->model_report_common_report->getall_transaction_group($data);
		$bill_ids_array = array();
		foreach ($resultss as $results) {
			$data['filter_name_id'] = $results['horse_id'];
			$results = $this->model_report_common_report->getall_transaction($data);
			foreach ($results as $key => $value) {
				$bill_id = $this->model_report_common_report->getbill_ids($value['transaction_id']);
				$bill_ids_array[$bill_id] = $bill_id;
			}
		}

		$data = array();
		$data = array(
			'filter_date_start'	     => $filter_date_start, 
			'filter_date_end'	     => $filter_date_end, 
			'filter_name'            => $filter_name,
			'filter_name_id'         => $filter_name_id,
			'filter_doctor'          => $filter_doctor,
		);

		//$bill_ids_array = array();
		$final_data = array();
		if($bill_ids_array){
			$resultss = $this->model_report_common_report->getbill_owner_group_by_owner($bill_ids_array);
			foreach ($resultss as $keyss => $results) {
				$owner_data = array();
				$owner_name = $this->model_report_common_report->get_owner_name($results['owner_id']);
				$final_data[$keyss]['owner_name'] = $owner_name;
				$data['filter_owner_id'] = $results['owner_id'];
				$results = $this->model_report_common_report->getbill_owner_by_owner($data);
				// echo '<pre>';
				// print_r($results);
				// exit;
				foreach ($results as $keys => $result) {
					$owner_data[$keys]['invoice_id'] = $result['bill_id'];
					$owner_name = $this->model_report_common_report->get_owner_name($result['owner_id']);
					$owner_data[$keys]['owner_name'] = $owner_name;
					$owner_data[$keys]['owner_amount'] = $result['owner_amt'];
					$horse_name = $this->model_report_common_report->get_horse_name($result['horse_id']);
					$owner_data[$keys]['horse_name'] = $horse_name;	
					$trainer_name = $this->model_report_common_report->get_trainer_name($result['trainer_id']);
					$owner_data[$keys]['trainer_name'] = $trainer_name;
					$owner_data[$keys]['invoice_date'] = date('M Y', strtotime($result['invoice_date']));
				}
				$final_data[$keyss]['owner_data'] = $owner_data;
			}
		}
		// echo '<pre>';
		// print_r($final_data);
		// exit;

		//$final_data = array();
		$this->data['owner_datas'] = $final_data;
		// echo '<pre>';
		// print_r($final_data);
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

		$this->data['column_horse_name'] = $this->language->get('column_horse_name');
		$this->data['column_invoice_no'] = $this->language->get('column_invoice_no');
		$this->data['column_owner_name'] = $this->language->get('column_owner_name');
		$this->data['column_amount'] = $this->language->get('column_amount');
		$this->data['column_trainer_name'] = $this->language->get('column_trainer_name');
		$this->data['column_subtotal'] = $this->language->get('column_subtotal');
		$this->data['column_total'] = $this->language->get('column_total');
		$this->data['column_invoice_date'] = $this->language->get('column_invoice_date');
		

		$this->data['entry_date_start'] = $this->language->get('entry_date_start');
		$this->data['entry_date_end'] = $this->language->get('entry_date_end');
		$this->data['entry_name'] = $this->language->get('entry_name');	
		$this->data['entry_doctor'] = $this->language->get('entry_doctor');	
		
		$this->data['text_all'] = $this->language->get('text_all');	

		$this->data['button_filter'] = $this->language->get('button_filter');
		$this->data['button_export'] = $this->language->get('button_export');

		$this->data['token'] = $this->session->data['token'];

		$this->load->model('bill/print_invoice');
		$doctors = $this->model_bill_print_invoice->getdoctors();
		$this->data['doctors'] = $doctors;

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

		$pagination = new Pagination();
		$pagination->total = $order_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('report/trainer_wise_statement', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();		

		$this->data['filter_date_start'] = $filter_date_start;
		$this->data['filter_date_end'] = $filter_date_end;		
		$this->data['filter_name'] = $filter_name;
		$this->data['filter_name_id'] = $filter_name_id;
		$this->data['filter_doctor'] = $filter_doctor;

		$this->template = 'report/owner_wise_statement.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function export(){
		$this->language->load('report/owner_wise_statement');
		$this->load->model('report/common_report');

		$this->document->setTitle($this->language->get('heading_title'));

		if (isset($this->request->get['filter_date_start'])) {
			$filter_date_start = $this->request->get['filter_date_start'];
		} else {
			$filter_date_start = date('Y-m-d');
		}

		if (isset($this->request->get['filter_date_end'])) {
			$filter_date_end = $this->request->get['filter_date_end'];
		} else {
			$filter_date_end = date('Y-m-d');
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

		$data = array(
			'filter_date_start'	     => $filter_date_start, 
			'filter_date_end'	     => $filter_date_end, 
			'filter_name'            => $filter_name,
			'filter_name_id'         => $filter_name_id,
			'filter_doctor'          => $filter_doctor,
		);

		$resultss = $this->model_report_common_report->getall_transaction_group($data);
		$bill_ids_array = array();
		foreach ($resultss as $results) {
			$data['filter_name_id'] = $results['horse_id'];
			$results = $this->model_report_common_report->getall_transaction($data);
			foreach ($results as $key => $value) {
				$bill_id = $this->model_report_common_report->getbill_ids($value['transaction_id']);
				$bill_ids_array[$bill_id] = $bill_id;
			}
		}

		$data = array();
		$data = array(
			'filter_date_start'	     => $filter_date_start, 
			'filter_date_end'	     => $filter_date_end, 
			'filter_name'            => $filter_name,
			'filter_name_id'         => $filter_name_id,
			'filter_doctor'          => $filter_doctor,
		);

		//$bill_ids_array = array();
		$final_data = array();
		if($bill_ids_array){
			$resultss = $this->model_report_common_report->getbill_owner_group_by_owner($bill_ids_array);
			foreach ($resultss as $keyss => $results) {
				$owner_data = array();
				$owner_name = $this->model_report_common_report->get_owner_name($results['owner_id']);
				$final_data[$keyss]['owner_name'] = $owner_name;
				$data['filter_owner_id'] = $results['owner_id'];
				$results = $this->model_report_common_report->getbill_owner_by_owner($data);
				foreach ($results as $keys => $result) {
					$owner_data[$keys]['invoice_id'] = $result['bill_id'];
					$owner_name = $this->model_report_common_report->get_owner_name($result['owner_id']);
					$owner_data[$keys]['owner_name'] = $owner_name;
					$owner_data[$keys]['owner_amount'] = $result['owner_amt'];
					$horse_name = $this->model_report_common_report->get_horse_name($result['horse_id']);
					$owner_data[$keys]['horse_name'] = $horse_name;	
					$trainer_name = $this->model_report_common_report->get_trainer_name($result['trainer_id']);
					$owner_data[$keys]['trainer_name'] = $trainer_name;
					$owner_data[$keys]['invoice_date'] = date('M Y', strtotime($result['invoice_date']));
				}
				$final_data[$keyss]['owner_data'] = $owner_data;
			}
		}
		
		if($filter_doctor != '*'){
			$doctor_names = $this->model_report_common_report->get_doctor_name($filter_doctor);
			$doctor_name = 'Dr. ' . $doctor_names;
		} else {
			$doctor_name = 'All Clinic';
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

		
		if($final_data){
			$date_from = date('d M, Y', strtotime($filter_date_start));
			$date_to = date('d M, Y', strtotime($filter_date_end));
			//$month = date("F", mktime(0, 0, 0, $filter_month, 10));
			$template = new Template();		
			$template->data['final_datas'] = $final_data;
			$template->data['tdate'] = date('d M, Y');
			$template->data['doctor_name'] = $doctor_name;
			$template->data['date_start'] = $date_from;
			$template->data['date_end'] = $date_to;
			$template->data['titleshead'] = 'Owner_Wise_Statement';
			$template->data['title'] = 'Statement For ' . $doctor_name . ' for ' . $date_from . ' to ' . $date_to;
			$template->data['column_horse_name'] = $this->language->get('column_horse_name');
			$template->data['column_owner_name'] = $this->language->get('column_owner_name');
			$template->data['column_invoice_no'] = $this->language->get('column_invoice_no');
			$template->data['column_amount'] = $this->language->get('column_amount');
			$template->data['column_trainer_name'] = $this->language->get('column_trainer_name');
			$template->data['column_invoice_date'] = $this->language->get('column_invoice_date');
			$template->data['column_subtotal'] = $this->language->get('column_subtotal');
			$template->data['column_total'] = $this->language->get('column_total');
			if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
				$template->data['base'] = HTTPS_SERVER;
			} else {
				$template->data['base'] = HTTP_SERVER;
			}
			$html = $template->fetch('report/owner_wise_statement_html.tpl');
			//echo $html;exit;
			$filename = "Owner_Wise_Statement.html";
			header('Content-type: text/html');
			header('Content-Disposition: attachment; filename='.$filename);
			echo $html;
			exit;		
		} else {
			$this->session->data['warning'] = 'No Data Found';
			$this->redirect($this->url->link('report/owner_wise_statement', 'token=' . $this->session->data['token'].$url, 'SSL'));
		}
	}
}
?>
