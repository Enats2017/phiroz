<?php
require '../mailin-api-php-master/src/Sendinblue/Mailin.php';
class ControllerReportOwnerStatement extends Controller { 
	public function index() {  
		$this->language->load('report/owner_wise_email');

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

		if (isset($this->request->get['filter_email'])) {
			$filter_email = $this->request->get['filter_email'];
		} else {
			$filter_email = '';
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

		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . $this->request->get['filter_email'];
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
			'filter_month'	     	 => $filter_month, 
			'filter_year'	     	 => $filter_year, 
			'filter_name'            => $filter_name,
			'filter_name_id'         => $filter_name_id,
			'filter_doctor'          => $filter_doctor,
			'filter_email'          => $filter_email,
		);

		$order_total = 0;
		//$bill_ids_array = array();
		$final_data = array();
		//if($filter_name != ''){
		if(isset($this->request->get['once'])){
			$resultss = $this->model_report_common_report->getbill_owner_group_statement($data);
			foreach($resultss as $rkeys => $rvalues){
				//echo '<pre>';
				//print_r($resultss);
				//exit;
				$data['filter_owner'] = $rvalues['owner_id'];
				$results = $this->model_report_common_report->getbill_owner_statement($data);
				$owner_data = array();
				foreach ($results as $rkeys => $rvalue) {
					$owner_name = $this->model_report_common_report->get_owner_name($results['owner_id']);
					$horse_name = $this->model_report_common_report->get_horse_name($results['horse_id']);
					$trainer_name = $this->model_report_common_report->get_trainer_name($results['trainer_id']);
					
					$owner_data[$rkeys]['invoice_id'] = $results['bill_id'];
					$owner_data[$rkeys]['horse_name'] = $horse_name;	
					$owner_data[$rkeys]['trainer_name'] = $trainer_name;
					$owner_data[$rkeys]['invoice_date'] = date('M Y', strtotime($results['invoice_date']));
					$owner_data[$rkeys]['owner_amount'] = $results['owner_amt'];
					$owner_data[$rkeys]['owner_name'] = $owner_name;
				}
				$final_data[$rvalues['owner_id']] = $owner_data;
			}
		}
		//$final_data = array();
		$this->data['owner_datas'] = $final_data;
		//echo '<pre>';
		//print_r($final_data);
		//exit;
		

		if(isset($this->session->data['warning'])){
			$this->data['error_warning'] = $this->session->data['warning'];
			unset($this->session->data['warning']);
		} else {
			$this->data['error_warning'] = '';
		}

		if(isset($this->session->data['success'])){
			$this->data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
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
		$this->data['entry_month'] = $this->language->get('entry_month');
		$this->data['entry_year'] = $this->language->get('entry_year');	
		$this->data['entry_doctor'] = $this->language->get('entry_doctor');	
		
		$this->data['text_all'] = $this->language->get('text_all');	

		$this->data['button_filter'] = $this->language->get('button_filter');
		$this->data['button_export'] = $this->language->get('button_export');

		$this->data['token'] = $this->session->data['token'];

		$this->load->model('bill/print_invoice');
		$doctors = $this->model_bill_print_invoice->getdoctors();
		// echo '<pre>';
		// print_r($doctors);
		// exit;
		$this->data['doctors'] = $doctors;

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

		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . $this->request->get['filter_email'];
		}		

		$pagination = new Pagination();
		$pagination->total = $order_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('report/trainer_wise_statement', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();		

		$this->data['filter_month'] = $filter_month;
		$this->data['filter_year'] = $filter_year;		
		$this->data['filter_name'] = $filter_name;
		$this->data['filter_name_id'] = $filter_name_id;
		$this->data['filter_doctor'] = $filter_doctor;
		$this->data['filter_email'] = $filter_email;
		
		$this->template = 'report/owner_statement.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function export(){
		$this->language->load('report/owner_wise_email');
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

		if (isset($this->request->get['filter_doctor'])) {
			$filter_doctor = $this->request->get['filter_doctor'];
		} else {
			$filter_doctor = '1';
		}

		if (isset($this->request->get['filter_email'])) {
			$filter_email = $this->request->get['filter_email'];
		} else {
			$filter_email = '';
		}

		$data = array(
			'filter_month'	     	 => $filter_month, 
			'filter_year'	     	 => $filter_year, 
			'filter_name'            => $filter_name,
			'filter_name_id'         => $filter_name_id,
			'filter_doctor'          => $filter_doctor,
		);

		$months_array = array(
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

		if($filter_month == '01'){
			$filter_previous_month = '12';
			$filter_previous_year = $filter_year - 1;
		} else {
			$filter_previous_month = $filter_month - 1;
			$filter_previous_year = $filter_year;
		}

		
		//$this->db->query("UPDATE `oc_bill_owner` SET `responsible_person` = 'Mr.Hemant S. Dharnidharka', `responsible_person_id` = '2381' WHERE id = '60669'");

		$tdays = cal_days_in_month(CAL_GREGORIAN, $filter_previous_month, $filter_previous_year);
		$previous_dates = $filter_previous_year.'-'.$filter_previous_month.'-01';
		$previous_month_year = date('M Y', strtotime($previous_dates));

		$final_data = array();
		$resultss = $this->model_report_common_report->getbill_owner_group_statement($data);
		// echo '<pre>';
		// print_r($resultss);
		// exit;
		$owner_name = '';
		$horse_name = '';
		$trainer_name = '';
		foreach($resultss as $rkeys => $rvalues){
			// echo '<pre>';
			// print_r($resultss);
			// exit;
			//$data['filter_owner'] = $rvalues['owner_id'];
			$data['filter_responsible_person'] = $rvalues['responsible_person_id'];
			$results = $this->model_report_common_report->getbill_owner_statement($data);
			// echo '<pre>';
			// print_r($results);
			// exit;
			$balance = $this->model_report_common_report->get_owner_balance($rvalues['responsible_person_id']);
			$owner_data = array();
			foreach ($results as $rkeys => $rvalue) {
				$owner_name = $this->model_report_common_report->get_owner_name($rvalue['owner_id']);
				$horse_name = $this->model_report_common_report->get_horse_name($rvalue['horse_id']);
				$trainer_name = $this->model_report_common_report->get_trainer_name($rvalue['trainer_id']);
				$doctor_name = $this->model_report_common_report->get_doctor_name($rvalue['doctor_id']);

				if($rvalue['doctor_id'] == '1' || $rvalue['doctor_id'] == '0' || $rvalue['doctor_id'] == ''){
					$doctor_name = 'P T Khambatta';
				} else {
					$doctor_name = 'L M Fernandes';
				}

				$owner_data[$rkeys]['invoice_id'] = $rvalue['bill_id'];
				$owner_data[$rkeys]['horse_name'] = $horse_name;	
				$owner_data[$rkeys]['trainer_name'] = $trainer_name;
				$date_c = $rvalue['year'].'-'.$rvalue['month'].'-01';
				$owner_data[$rkeys]['invoice_date'] = date('M Y', strtotime($date_c));
				$owner_data[$rkeys]['owner_amount'] = $rvalue['owner_amt'];
				$owner_data[$rkeys]['owner_name'] = $owner_name;
				$owner_data[$rkeys]['month'] = $months_array[$filter_month];
				$owner_data[$rkeys]['year'] = $filter_year;
				$owner_data[$rkeys]['doctor_name'] = $doctor_name;
				$owner_data[$rkeys]['responsible_person'] = $rvalues['responsible_person'];
				$owner_data[$rkeys]['owner_share'] = $rvalue['owner_share'];
				$owner_data[$rkeys]['balance'] = $balance;
				$owner_data[$rkeys]['previous_month_year'] = $previous_month_year;

			}
			$final_data[$rvalues['responsible_person']] = $owner_data;
		}
		// echo '<pre>';
		// print_r($final_data);
		// exit;
		if($filter_doctor != '*'){
			$doctor_names = $this->model_report_common_report->get_doctor_name($filter_doctor);
			$doctor_name = 'Dr. ' . $doctor_names;
		} else {
			$doctor_name = 'All Clinic';
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

		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . $this->request->get['filter_email'];
		}
		//echo $filter_email;exit;
		if($final_data){
			$tdays = cal_days_in_month(CAL_GREGORIAN, $filter_month, $filter_year);
			$date_from = $filter_year.'-'.$filter_month.'-01';
			$date_to = $filter_year.'-'.$filter_month.'-'.$tdays;

			$date_from = date('d M, Y', strtotime($date_from));
			$date_to = date('d M, Y', strtotime($date_to));

			$filter_month1 = date('M', strtotime($date_from));
			//$month = date("F", mktime(0, 0, 0, $filter_month, 10));
			
			$template = new Template();		
			$template->data['final_datas'] = $final_data;
			$template->data['tdate'] = date('d M, Y');
			//$template->data['doctor_name'] = $doctor_name;
			//$template->data['owner_name'] = $owner_name;
			$template->data['date_start'] = $date_from;
			$template->data['date_end'] = $date_to;
			$template->data['email'] = $this->config->get('config_email');
			$template->data['telephone'] = $this->config->get('config_telephone');
			$template->data['titleshead'] = 'Owner_Wise_Statement';
			$template->data['title'] = 'Statement For ' . $owner_name . ' for ' . $filter_month1 . ', ' . $filter_year;
			if($filter_doctor == '1'){
				$template->data['bank_details'] = 'Phiroz Talib Khambatta';
				$template->data['account_no'] = '000501023668';
				$template->data['bank_name'] = 'ICICI Bank, Bund garden road Branch, <br /> pune';
				$template->data['ifsc_code'] = 'ICIC0000005';
			} else {
				$template->data['bank_details'] = 'Leila Fernandes';
				$template->data['account_no'] = '011296902006';
				$template->data['bank_name'] = 'HSBC Bank, Dr. Ambedkar road, <br /> Bandra(W) Branch, Mumbai';
				$template->data['ifsc_code'] = 'HSBC0400004';
			}
			if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
				$template->data['base'] = HTTPS_SERVER;
			} else {
				$template->data['base'] = HTTP_SERVER;
			}
			$html = $template->fetch('report/owner_statement_html.tpl');
			//echo $html;exit;
			$filename = "Owner_Wise_Statement.html";
			if($filter_name != ''){
				$filter_name = str_replace(array(' ', ',', '&', '.','amp;', 'nbsp;'), '_', $filter_name);
				$filename = "Owner_Statement_".$filter_name.".html";
			} else {
				$filename = "Owner_Statement.html";
			}

			//$filename;exit;
			header('Content-type: text/html');
			header('Content-Disposition: attachment; filename='.$filename);
			echo $html;
			exit;		
			/*
			if(file_exists($filename)){
				unlink($filename);
			}
			// Write the contents back to the file
			file_put_contents($filename, $html);
			
			$subject = $doctor_name.' has sent Statement Details';
			$statement_mail_text = $this->statement_mail_text($doctor_name);
			$statement_mail_text = str_replace(array("\r", "\n"), '', $statement_mail_text);

			$data['sendmail'] = 2;
			$data['from_email'] = 'fargose.aaron@gmail.com';//$this->config->get('config_email');
			$data['to_email'] = $filter_email;
			$data['subject'] = $subject;
			$data['statement_mail_text'] = $statement_mail_text;
			$data['doctor_name'] = $doctor_name;
			$data['to_name'] = $owner_name;
			$data['statement_mail_html'] = $html;
			
			$url1 = 'http://125.99.122.186/openchr/';
			$data = json_encode($data);
			$ch = curl_init($url1);
			//set the url, number of POST vars, POST data
			//curl_setopt($ch,CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
			    'Content-Type: application/json',                                                                                
			    'Content-Length: ' . strlen($data))                                                                       
			); 
			curl_setopt($ch,CURLOPT_POSTFIELDS, $data);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			//execute post
			$result = curl_exec($ch);
			//close connection
			curl_close($ch);
			//decode the result
			$data = json_decode($result, true);
			if($data['success'] == 1){
				$this->session->data['success'] = 'Mail Send';
				$this->redirect($this->url->link('report/owner_wise_email', 'token=' . $this->session->data['token'].$url, 'SSL'));	
				//echo 'Mail Send, Please Close This Window';			
			} else {
				$this->session->data['warning'] = 'Mail Not Sent Please try again';
				$this->redirect($this->url->link('report/owner_wise_email', 'token=' . $this->session->data['token'].$url, 'SSL'));
				//echo 'Mail Not Sent Please try again, Please Close This Window';		
			}
			*/
			//exit;
		} else {
			$this->session->data['warning'] = 'No Data Found';
			$this->redirect($this->url->link('report/owner_statement', 'token=' . $this->session->data['token'].$url, 'SSL'));
		}
	}

	public function sendMail(){
		date_default_timezone_set('Asia/Kolkata');
		$this->language->load('report/owner_wise_email');
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

		if (isset($this->request->get['filter_doctor'])) {
			$filter_doctor = $this->request->get['filter_doctor'];
		} else {
			$filter_doctor = '1';
		}

		if (isset($this->request->get['filter_email'])) {
			$filter_email = $this->request->get['filter_email'];
		} else {
			$filter_email = '';
		}

		$data = array(
			'filter_month'	     	 => $filter_month, 
			'filter_year'	     	 => $filter_year, 
			'filter_name'            => $filter_name,
			'filter_name_id'         => $filter_name_id,
			'filter_doctor'          => $filter_doctor,
		);

		$months_array = array(
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

		if($filter_month == '01'){
			$filter_previous_month = '12';
			$filter_previous_year = $filter_year - 1;
		} else {
			$filter_previous_month = $filter_month - 1;
			$filter_previous_year = $filter_year;
		}

		$tdays = cal_days_in_month(CAL_GREGORIAN, $filter_previous_month, $filter_previous_year);
		$previous_dates = $filter_previous_year.'-'.$filter_previous_month.'-01';
		$previous_month_year = date('M Y', strtotime($previous_dates));

		$final_data = array();
		$resultss = $this->model_report_common_report->getbill_owner_group_statement($data);
		// echo '<pre>';
		// print_r($resultss);
		// exit;
		$owner_name = '';
		$horse_name = '';
		$trainer_name = '';
		$owner_email = '';
		$responsible_person_name = '';
		$responsible_person_email = '';
		foreach($resultss as $rkeys => $rvalues){
			// echo '<pre>';
			// print_r($resultss);
			// exit;
			//$data['filter_owner'] = $rvalues['owner_id'];
			$data['filter_responsible_person'] = $rvalues['responsible_person_id'];
			$results = $this->model_report_common_report->getbill_owner_statement($data);
			$responsible_person_email = $this->model_report_common_report->get_owner_email($rvalues['responsible_person_id']);
			$responsible_person_name = $this->model_report_common_report->get_owner_name($rvalues['responsible_person_id']);
			// echo '<pre>';
			// print_r($results);
			// exit;
			$balance = $this->model_report_common_report->get_owner_balance($rvalues['responsible_person_id']);
			$owner_data = array();
			foreach ($results as $rkeys => $rvalue) {
				$owner_name = $this->model_report_common_report->get_owner_name($rvalue['owner_id']);
				$horse_name = $this->model_report_common_report->get_horse_name($rvalue['horse_id']);
				$trainer_name = $this->model_report_common_report->get_trainer_name($rvalue['trainer_id']);
				$doctor_name = $this->model_report_common_report->get_doctor_name($rvalue['doctor_id']);

				if($rvalue['doctor_id'] == '1' || $rvalue['doctor_id'] == '0' || $rvalue['doctor_id'] == ''){
					$doctor_name = 'P T Khambatta';
				} else {
					$doctor_name = 'L M Fernandes';
				}

				$owner_data[$rkeys]['invoice_id'] = $rvalue['bill_id'];
				$owner_data[$rkeys]['horse_name'] = $horse_name;	
				$owner_data[$rkeys]['trainer_name'] = $trainer_name;
				$date_c = $rvalue['year'].'-'.$rvalue['month'].'-01';
				$owner_data[$rkeys]['invoice_date'] = date('M Y', strtotime($date_c));
				$owner_data[$rkeys]['owner_amount'] = $rvalue['owner_amt'];
				$owner_data[$rkeys]['owner_name'] = $owner_name;
				$owner_data[$rkeys]['month'] = $months_array[$filter_month];
				$owner_data[$rkeys]['year'] = $filter_year;
				$owner_data[$rkeys]['doctor_name'] = $doctor_name;
				$owner_data[$rkeys]['responsible_person'] = $rvalues['responsible_person'];
				$owner_data[$rkeys]['owner_share'] = $rvalue['owner_share'];
				$owner_data[$rkeys]['balance'] = $balance;
				$owner_data[$rkeys]['previous_month_year'] = $previous_month_year;

			}
			$final_data[$rvalues['responsible_person']] = $owner_data;
		}
		// echo '<pre>';
		// print_r($final_data);
		// exit;
		if($filter_doctor != '*'){
			$doctor_names = $this->model_report_common_report->get_doctor_name($filter_doctor);
			$doctor_name = 'Dr. ' . $doctor_names;
		} else {
			$doctor_name = 'All Clinic';
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

		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . $this->request->get['filter_email'];
		}
		//echo $filter_email;exit;
		if($final_data){
			$tdays = cal_days_in_month(CAL_GREGORIAN, $filter_month, $filter_year);
			$date_from = $filter_year.'-'.$filter_month.'-01';
			$date_to = $filter_year.'-'.$filter_month.'-'.$tdays;

			$date_from = date('d M, Y', strtotime($date_from));
			$date_to = date('d M, Y', strtotime($date_to));

			$filter_month1 = date('M', strtotime($date_from));
			//$month = date("F", mktime(0, 0, 0, $filter_month, 10));
			
			$template = new Template();		
			$template->data['final_datas'] = $final_data;
			$template->data['tdate'] = date('d M, Y');
			//$template->data['doctor_name'] = $doctor_name;
			//$template->data['owner_name'] = $owner_name;
			$template->data['date_start'] = $date_from;
			$template->data['date_end'] = $date_to;
			$template->data['email'] = $this->config->get('config_email');
			$template->data['telephone'] = $this->config->get('config_telephone');
			$template->data['titleshead'] = 'Owner_Wise_Statement';
			$template->data['title'] = 'Statement For ' . $owner_name . ' for ' . $filter_month1 . ', ' . $filter_year;
			if($filter_doctor == '1'){
				$template->data['bank_details'] = 'Phiroz Talib Khambatta';
				$template->data['account_no'] = '000501023668';
				$template->data['bank_name'] = 'ICICI Bank, Bund garden road Branch, <br /> pune';
				$template->data['ifsc_code'] = 'ICIC0000005';
			} else {
				$template->data['bank_details'] = 'Leila Fernandes';
				$template->data['account_no'] = '011296902006';
				$template->data['bank_name'] = 'HSBC Bank, Dr. Ambedkar road, <br /> Bandra(W) Branch, Mumbai';
				$template->data['ifsc_code'] = 'HSBC0400004';
			}
			if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
				$template->data['base'] = HTTPS_SERVER;
			} else {
				$template->data['base'] = HTTP_SERVER;
			}
			$html = $template->fetch('report/owner_statement_html.tpl');
			//echo $html;exit;
			$filename = "Owner_Wise_Statement.html";
			if($filter_name != ''){
				$filter_name = str_replace(array(' ', ',', '&', '.', 'nbsp;'), '_', $filter_name);
				$filename = "Owner_Statement_".$filter_name.".html";
			} else {
				$filename = "Owner_Statement.html";
			}
			//$mail_text = header('Content-type: text/html');
			//$mail_text .= header('Content-Disposition: attachment; filename='.$filename);
			$subject = 'Invoice Details of Dr Phiroz Khambatta';
			//$statement_mail_text = $this->statement_mail_text($doctor_name);
			//$statement_mail_text = str_replace(array("\r", "\n"), '', $statement_mail_text);
			//$data['sendmail'] = 1;
			// $data['from_email'] = 'phiroz2017@gmail.com';//$this->config->get('config_email');*******
			// $data['to_email'] = $responsible_person_email; //$filter_email;*******
			// $data['subject'] = $subject;******
			//$data['statement_mail_text'] = $statement_mail_text;
			//$data['doctor_name'] = $doctor_name;
			// $data['to_name'] = $responsible_person_name;**********
			// $data['statement_mail_html'] = $html;********
			
			$filter_name = str_replace('_',' ',$filter_name);

			$mailin = new Sendinblue\Mailin("https://api.sendinblue.com/v2.0",'bVN07jDRW85tLAJH');
			  $data = array( "to" => array($responsible_person_email=>$responsible_person_name),
		        "from" => array("phiroz2017@gmail.com", "Phiroz Khambatta"),
		        "subject" => $subject,
		        "html" => $html
			);
			$res = $mailin->send_email($data);
			if($res['code'] == 'success'){
				$this->db->query("INSERT INTO oc_email_info SET
									owner_id = '".$filter_name_id."',
									owner_name = '".$this->db->escape($filter_name)."',
									owner_email = '".$responsible_person_email."',
									report_type = '2',
									report_name = 'Owner Statement',
									doctor_id = '".$filter_doctor."',
									send_status = '1',
									date = '".date('Y-m-d')."',
									time = '".date('h:i:s')."'
								");
				$this->session->data['success'] = 'Mail Send';
			}else{
				$this->db->query("INSERT INTO oc_email_info SET
									owner_id = '".$filter_name_id."',
									owner_name = '".$this->db->escape($filter_name)."',
									owner_email = '".$responsible_person_email."',
									report_type = '2',
									report_name = 'Owner Statement',
									doctor_id = '".$filter_doctor."',
									send_status = '0',
									date = '".date('Y-m-d')."',
									time = '".date('h:i:s')."'
								");
				$this->session->data['warning'] = 'Mail Cannot be Send';
			}
			$this->redirect($this->url->link('report/owner_statement', 'token=' . $this->session->data['token'].$url, 'SSL'));
			// echo '<pre>';
			// print_r($data);
			//exit;
			// $url1 = 'http://125.99.122.186/openchr/';
			// $data = json_encode($data);
			// $ch = curl_init($url1);
			// //set the url, number of POST vars, POST data
			// //curl_setopt($ch,CURLOPT_URL, $url);
			// curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			// curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
			//     'Content-Type: application/json',                                                                                
			//     'Content-Length: ' . strlen($data))                                                                       
			// ); 
			// curl_setopt($ch,CURLOPT_POSTFIELDS, $data);
			// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			// //execute post
			// $result = curl_exec($ch);
			// //close connection
			// curl_close($ch);
			// //decode the result
			// $data = json_decode($result, true);
			// if($data['success'] == 1){
			// 	echo "Mail Sent to  : " . $responsible_person_email;
			// 	//$this->session->data['success'] = 'Mail Send';
			// 	//$this->redirect($this->url->link('report/owner_wise_email', 'token=' . $this->session->data['token'].$url, 'SSL'));	
			// 	//echo 'Mail Send, Please Close This Window';			
			// } else {
			// 	echo "Mail not sent";
			// 	//$this->session->data['warning'] = 'Mail Not Sent Please try again';
			// 	//$this->redirect($this->url->link('report/owner_wise_email', 'token=' . $this->session->data['token'].$url, 'SSL'));
			// 	//echo 'Mail Not Sent Please try again, Please Close This Window';		
			// }
			// exit;		
			/*
			if(file_exists($filename)){
				unlink($filename);
			}
			// Write the contents back to the file
			file_put_contents($filename, $html);
			
			$subject = $doctor_name.' has sent Statement Details';
			$statement_mail_text = $this->statement_mail_text($doctor_name);
			$statement_mail_text = str_replace(array("\r", "\n"), '', $statement_mail_text);

			$data['sendmail'] = 2;
			$data['from_email'] = 'fargose.aaron@gmail.com';//$this->config->get('config_email');
			$data['to_email'] = $filter_email;
			$data['subject'] = $subject;
			$data['statement_mail_text'] = $statement_mail_text;
			$data['doctor_name'] = $doctor_name;
			$data['to_name'] = $owner_name;
			$data['statement_mail_html'] = $html;
			
			$url1 = 'http://125.99.122.186/openchr/';
			$data = json_encode($data);
			$ch = curl_init($url1);
			//set the url, number of POST vars, POST data
			//curl_setopt($ch,CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
			    'Content-Type: application/json',                                                                                
			    'Content-Length: ' . strlen($data))                                                                       
			); 
			curl_setopt($ch,CURLOPT_POSTFIELDS, $data);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			//execute post
			$result = curl_exec($ch);
			//close connection
			curl_close($ch);
			//decode the result
			$data = json_decode($result, true);
			if($data['success'] == 1){
				$this->session->data['success'] = 'Mail Send';
				$this->redirect($this->url->link('report/owner_wise_email', 'token=' . $this->session->data['token'].$url, 'SSL'));	
				//echo 'Mail Send, Please Close This Window';			
			} else {
				$this->session->data['warning'] = 'Mail Not Sent Please try again';
				$this->redirect($this->url->link('report/owner_wise_email', 'token=' . $this->session->data['token'].$url, 'SSL'));
				//echo 'Mail Not Sent Please try again, Please Close This Window';		
			}
			*/
			//exit;
		} else {
			$this->session->data['warning'] = 'No Data Found';
			$this->redirect($this->url->link('report/owner_statement', 'token=' . $this->session->data['token'].$url, 'SSL'));
		}
	}

	public function statement_mail_text($doctor_name){
		$this->language->load('report/owner_wise_email');
		$this->language->load('bill/print_invoice');
		$this->load->model('bill/print_invoice');

		$this->document->setTitle($this->language->get('heading_title'));

		
		if (isset($this->request->get['filter_name_id'])) {
			$filter_owner = $this->request->get['filter_name_id'];
		} else {
			$filter_owner = '';
		}

		$owner_name = $this->model_bill_print_invoice->get_owner_name($filter_owner); 

		$template = new Template();		
		$template->data['title'] = 'Invoice';
		$template->data['doctor_name'] = $doctor_name;
		$template->data['owner_name'] = $owner_name;
		$template->data['email'] = $this->config->get('config_email');
		$template->data['telephone'] = $this->config->get('config_telephone');
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$template->data['base'] = "http://64.79.95.89/phiroz/admin/";
		} else {
			$template->data['base'] = "http://64.79.95.89/phiroz/admin/";
		}
		$html = $template->fetch('report/statement_text.tpl');
		return $html;

	}
}
?>
