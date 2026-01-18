<?php
class ControllerReportHorseWiseTread extends Controller { 
	public function index() {  
		$this->language->load('report/horse_wise');

		$this->document->setTitle('Treadmill Exercise');

		if (isset($this->request->get['filter_date_start'])) {
			$filter_date_start = $this->request->get['filter_date_start'];
		} else {
			$from = date('Y-m-d');
			$filter_date_start = $from;
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
			$filter_doctor = '2';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		if (isset($this->request->get['out_status'])) {
			$this->data['out_status'] = $this->request->get['out_status'];
		} else {
			$this->data['out_status'] = 0;
		}

		$url = '';

		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
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
			'href'      => $this->url->link('report/horse_wise_shock', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$this->load->model('report/common_report');

		$this->data['horse_wise'] = array();

		$med_ids = "(1368, 1369, 1370, 1371, 1372, 1373, 1374, 1375, 1376, 1377, 1378, 1379, 1380, 1381, 1382, 1383, 1384, 1385, 1386, 1387, 1388, 1389, 1390, 1391)";

		$data = array(
			'filter_date_start'	     => $filter_date_start, 
			'filter_name'            => $filter_name,
			'filter_name_id'         => $filter_name_id,
			'filter_doctor'          => $filter_doctor,
			'filter_medicine_id' 	 => $med_ids,
			'start'                  => ($page - 1) * 7000,
			'limit'                  => 7000
		);

		$order_total = $this->model_report_common_report->getTotalhorsetreated_endos($data);
		$results = $this->model_report_common_report->gethorsetreated_group_endos($data);

		foreach ($results as $result) {
			$this->data['horse_wise'][] = array(
				'horse_id'     	 => $result['horse_id'],
				'horse_name'     => $result['horse_name'],
				'selected'       => isset($this->request->post['selected']) && in_array($result['horse_id'], $this->request->post['selected'])
			);
		}

		$this->data['action'] = $this->url->link('report/horse_wise_tread/export', 'token=' . $this->session->data['token'] . $url, 'SSL');

		// echo '<pre>';
		// print_r($this->data['horse_wise']);
		// exit;

		if(isset($this->session->data['warning'])){
			$this->data['error_warning'] = $this->session->data['warning'];
			unset($this->session->data['warning']);
		} else {
			$this->data['error_warning'] = '';
		}

		$this->data['heading_title'] = 'Treadmill Exercise';

		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_all_status'] = $this->language->get('text_all_status');

		$this->data['column_horse_name'] = $this->language->get('column_horse_name');
		

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
		$pagination->limit = 7000;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('report/horse_wise_tread', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();		

		$this->data['filter_date_start'] = $filter_date_start;
		$this->data['filter_date_end'] = $filter_date_end;		
		$this->data['filter_name'] = $filter_name;
		$this->data['filter_name_id'] = $filter_name_id;
		$this->data['filter_doctor'] = $filter_doctor;

		$this->template = 'report/horse_wise_tread.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function export(){
		$this->language->load('report/horse_wise');
		$this->load->model('report/common_report');

		$this->document->setTitle('Treadmill Exercise');

		if (isset($this->request->post['filter_date_start'])) {
			$filter_date_start = $this->request->post['filter_date_start'];
		} else {
			$from = date('Y-m-d');
			$filter_date_start = $from;
		}

		if (isset($this->request->post['filter_name'])) {
			$filter_name = $this->request->post['filter_name'];
		} else {
			$filter_name = '';
		}

		if (isset($this->request->post['filter_name_id'])) {
			$filter_name_id = $this->request->post['filter_name_id'];
		} else {
			$filter_name_id = '';
		}

		if (isset($this->request->post['filter_doctor'])) {
			$filter_doctor = $this->request->post['filter_doctor'];
		} else {
			$filter_doctor = '2';
		}

		$med_ids = "(1368, 1369, 1370, 1371, 1372, 1373, 1374, 1375, 1376, 1377, 1378, 1379, 1380, 1381, 1382, 1383, 1384, 1385, 1386, 1387, 1388, 1389, 1390, 1391)";

		$data = array(
			'filter_date_start'	     => $filter_date_start, 
			'filter_date_end'	     => $filter_date_end, 
			'filter_name'            => $filter_name,
			'filter_name_id'         => $filter_name_id,
			'filter_doctor' 		 => $filter_doctor,
			'filter_medicine_id' 	 => $med_ids
		);
		$horse_wise = array();
		if($filter_doctor == 2){
			if(isset($this->request->post['selected'])){
				foreach ($this->request->post['selected'] as $results) {
					$data['filter_name_id'] = $results;
					$horse_name = $this->model_report_common_report->get_horse_name($results);
					
					$result = $this->model_report_common_report->gethorsetreated($data);

					$transaction_data = array();
					foreach ($result as $rkey => $rvalue) {
						$trainer_name = $this->model_report_common_report->get_trainer_name($rvalue['trainer_id']);
					
						$horse_wise[] = array(
							'horse_name'     => $horse_name,
							'date_treatment' => date('d-m-Y', strtotime($rvalue['dot'])),
							'medicine_name'   => $rvalue['medicine_name'],
							'medicine_id'    => $rvalue['medicine_id'],
							'trainer_name'   => $trainer_name
						);	
					}
					// if($transaction_data){
					// 	$horse_wise[] = array(
					// 		'horse_name'     => $horse_name,
					// 		'transaction_data' => $transaction_data
					// 	);
					// }
				}
			} else {
				$resultss = $this->model_report_common_report->gethorsetreated_group($data);
				$horse_wise = array();
				foreach ($resultss as $results) {
					$data['filter_name_id'] = $results['horse_id'];
					$result = $this->model_report_common_report->gethorsetreated($data);
					$transaction_data = array();
					foreach ($result as $rkey => $rvalue) {
						$transaction_data[] = array(
							'date_treatment' => date('d, M Y', strtotime($rvalue['dot'])),
							'medicine_name'   => strtoupper($rvalue['medicine_name']),
						);	
					}
					if($transaction_data){
						$horse_wise[] = array(
							'horse_name'     => $results['horse_name'],
							'transaction_data' => $transaction_data
						);
					}	
				}
			}
		} 
		
		if($filter_doctor != '*'){
			$doctor_name = 'Dr. '.$this->model_report_common_report->get_doctor_name($filter_doctor);
		} else {
			$doctor_name = 'Me';
		}

		$url = '';

		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
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

		
		if($horse_wise){
			//$month = date("F", mktime(0, 0, 0, $filter_month, 10));
			$template = new Template();	
				
			$template->data['final_datas'] = $horse_wise;
			$template->data['tdate'] = date('d M, Y');

			$template->data['from_date'] = date('d M, Y', strtotime($filter_date_start));
			$template->data['to_date'] = date('d M, Y', strtotime($filter_date_end));
			//$template->data['tdate_1'] = date('d M, Y');
			$template->data['doctor_name'] = $doctor_name;
			$template->data['title'] = 'Treadmill Excersise Report';
			if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
				$template->data['base'] = 'http://64.79.95.89/phiroz/admin/';
			} else {
				$template->data['base'] = 'http://64.79.95.89/phiroz/admin/';
			}
			$html = $template->fetch('report/horse_wise_tread_html.tpl');
			//echo $html;exit;
			$filename = "TreadMill_Excersise_Report.html";
			header('Content-type: text/html');
			header('Content-Disposition: attachment; filename='.$filename);
			echo $html;
			exit;		
		} else {
			$this->session->data['warning'] = 'No Data Found';
			$this->redirect($this->url->link('report/horse_wise_tread', 'token=' . $this->session->data['token'].$url, 'SSL'));
		}
	}

	function GetDays($sStartDate, $sEndDate){  
		// Firstly, format the provided dates.  
		// This function works best with YYYY-MM-DD  
		// but other date formats will work thanks  
		// to strtotime().  
		$sStartDate = date("Y-m-d", strtotime($sStartDate));  
		$sEndDate = date("Y-m-d", strtotime($sEndDate));  
		// Start the variable off with the start date  
		$aDays[] = $sStartDate;  
		// Set a 'temp' variable, sCurrentDate, with  
		// the start date - before beginning the loop  
		$sCurrentDate = $sStartDate;  
		// While the current date is less than the end date  
		while($sCurrentDate < $sEndDate){  
		// Add a day to the current date  
		$sCurrentDate = date("Y-m-d", strtotime("+1 day", strtotime($sCurrentDate)));  
			// Add this new day to the aDays array  
		$aDays[] = $sCurrentDate;  
		}
		// Once the loop has finished, return the  
		// array of days.  
		return $aDays;  
	}
}
?>
