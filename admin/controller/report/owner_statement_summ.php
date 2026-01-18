<?php
require '../mailin-api-php-master/src/Sendinblue/Mailin.php';
class ControllerReportOwnerStatementSumm extends Controller { 
	public function index() {  
		$this->language->load('report/owner_statement_summ');

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

		$url = '';

		if (isset($this->request->get['filter_month'])) {
			$url .= '&filter_month=' . $this->request->get['filter_month'];
		}

		if (isset($this->request->get['filter_year'])) {
			$url .= '&filter_year=' . $this->request->get['filter_year'];
		}

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
			'filter_date_start'	     	 => $filter_date_start, 
			'filter_date_end'	     	 => $filter_date_end, 
			//'filter_month'	     	 => $filter_month, 
			//'filter_year'	     	 => $filter_year, 
			'filter_name'            => $filter_name,
			'filter_name_id'         => $filter_name_id,
			'filter_doctor'          => $filter_doctor,
			'filter_email'          => $filter_email,
		);

		$order_total = 0;
		$final_data = array();
		if(isset($this->request->get['once'])){		
			$month = array();
	        $months = $this->GetMOnth($filter_date_start, $filter_date_end);
	        
	        $sql = "SELECT `owner_id`, `outstandingamount_ptk`, `outstandingamount_lmf`, `name` FROM `oc_owner` WHERE 1=1 ";
			if (!empty($data['filter_name_id'])) {
				$sql .= " AND `responsible_person_id` = '" . $this->db->escape($data['filter_name_id']) . "'";
		    }
		    $owner_datass = $this->db->query($sql);
			$owner_datas = $owner_datass->row;

			if($filter_doctor == 1){
		        $month[0] = array(
		        	'year_name' => '',
		        	'month_name' => 'Pre July 2017',
		        	'amount' => $owner_datas['outstandingamount_ptk'], 
		        );
		    } elseif($filter_doctor == 2) {
		    	$month[0] = array(
		        	'year_name' => '',
		        	'month_name' => 'Pre July 2017',
		        	'amount' => $owner_datas['outstandingamount_lmf'], 
		        );
		    }

	        foreach ($months as $mkey => $mvalue) {
	        	$dates = explode('-', $mvalue);
	        	$month_day = ltrim($dates[1], '0');
	        	$month[$month_day]['month'] = $month_day;
	        	$month[$month_day]['month_name'] = date('F', strtotime($mvalue));
	        	$month[$month_day]['year_name'] = date('Y', strtotime($mvalue));
	        	$month[$month_day]['date'] = $mvalue;
	        	$month[$month_day]['amount'] = 0;
	        }
	        //$resultss = $this->model_report_common_report->getbill_owner_summ_group_statement($data);
			//foreach($resultss as $rkeys => $rvalues){
				//$data['filter_responsible_person'] = $rvalues['responsible_person_id'];
				$data['filter_responsible_person'] = $filter_name_id;
				$results = $this->model_report_common_report->getbill_owner_statement_summ($data);
				foreach ($months as $mkey => $mvalue) {
		        	$dates = explode('-', $mvalue);
		        	$month_day = ltrim($dates[1], '0');
		        	$month[$month_day]['amount'] = 0;
		        }
				foreach ($results as $rkeys => $rvalue) {
					$dot = $rvalue['dot'];
					$dates = explode('-', $dot);
        			$month_day = ltrim($dates[1], '0');
					if(!isset($month[$month_day])){
						$month[$month_day]['amount'] = $rvalue['owner_amt'];
					} else {
						$month[$month_day]['amount'] += $rvalue['owner_amt'];
					}
				}
				$final_data[$filter_name_id] = $month;
			//}
		}
		$this->data['owner_datas'] = $final_data;
		

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

		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . $this->request->get['filter_email'];
		}		

		$pagination = new Pagination();
		$pagination->total = $order_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('report/owner_statement_summ', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();		

		$this->data['filter_month'] = $filter_month;
		$this->data['filter_year'] = $filter_year;		
		$this->data['filter_date_start'] = $filter_date_start;		
		$this->data['filter_date_end'] = $filter_date_end;		
		$this->data['filter_name'] = $filter_name;
		$this->data['filter_name_id'] = $filter_name_id;
		$this->data['filter_doctor'] = $filter_doctor;
		$this->data['filter_email'] = $filter_email;
		
		$this->template = 'report/owner_statement_summ.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function GetMOnth($sStartDate, $sEndDate){  
		// Firstly, format the provided dates.  
		// This function works best with YYYY-MM-DD  
		// but other date formats will work thanks  
		// to strtotime().  
		$sStartDate = date("Y-m-d", strtotime($sStartDate));  
		$sEndDate = date("Y-m-d", strtotime($sEndDate));  

		$sStartMonth = date("m", strtotime($sStartDate));  
		$sEndMonth = date("m", strtotime($sEndDate));  

		// Start the variable off with the start date  
		$aDays[] = $sStartDate;  
		// Set a 'temp' variable, sCurrentDate, with  
		// the start date - before beginning the loop  
		$sCurrentDate = $sStartDate;  
		// While the current date is less than the end date  
		
		while($sCurrentDate < $sEndDate){  
			// Add a day to the current date  
			$sCurrentDate = date("Y-m-d", strtotime("+1 month", strtotime($sCurrentDate)));  
			// Add this new day to the aDays array  
			if($sCurrentDate < $sEndDate){
				$aDays[] = $sCurrentDate;  
			}
		}
		// Once the loop has finished, return the  
		// array of days.  
		return $aDays;  
	}

	public function sendMailSumm(){
		date_default_timezone_set('Asia/Kolkata');
		$this->language->load('report/owner_statement_summ');
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

		if (isset($this->request->get['filter_email'])) {
			$filter_email = $this->request->get['filter_email'];
		} else {
			$filter_email = '';
		}

		$data = array(
			'filter_date_start'	     => $filter_date_start, 
			'filter_date_end'	     => $filter_date_end, 
			//'filter_month'	     	 => $filter_month, 
			//'filter_year'	     	 => $filter_year, 
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

		$final_data = array();
		$month = array();
        
        $sql = "SELECT `owner_id`, `outstandingamount_ptk`, `outstandingamount_lmf`, `name` FROM `oc_owner` WHERE 1=1 ";
		if (!empty($data['filter_name_id'])) {
			$sql .= " AND `responsible_person_id` = '" . $this->db->escape($data['filter_name_id']) . "'";
	    }
	    $owner_datass = $this->db->query($sql);
		$owner_datas = $owner_datass->row;

		if($filter_doctor == 1){
	        $month[0] = array(
	        	'year_name' => '',
	        	'month_name' => 'Pre July 2017',
	        	'amount' => $owner_datas['outstandingamount_ptk'], 
	        );
	    } elseif($filter_doctor == 2) {
	    	$month[0] = array(
	        	'year_name' => '',
	        	'month_name' => 'Pre July 2017',
	        	'amount' => $owner_datas['outstandingamount_lmf'], 
	        );
	    }

        $months = $this->GetMOnth($filter_date_start, $filter_date_end);
        foreach ($months as $mkey => $mvalue) {
        	$dates = explode('-', $mvalue);
        	$month_day = ltrim($dates[1], '0');
        	$month[$month_day]['month'] = $month_day;
        	$month[$month_day]['month_name'] = date('F', strtotime($mvalue));
        	$month[$month_day]['year_name'] = date('Y', strtotime($mvalue));
        	$month[$month_day]['date'] = $mvalue;
        	$month[$month_day]['amount'] = 0;
        }
		$month_start = date('F Y', strtotime($filter_date_start));
		$month_end = date('F Y', strtotime($filter_date_end));
        //$resultss = $this->model_report_common_report->getbill_owner_summ_group_statement($data);
		//foreach($resultss as $rkeys => $rvalues){
			//$data['filter_responsible_person'] = $rvalues['responsible_person_id'];
			$data['filter_responsible_person'] = $filter_name_id;
			$results = $this->model_report_common_report->getbill_owner_statement_summ($data);
			foreach ($months as $mkey => $mvalue) {
	        	$dates = explode('-', $mvalue);
	        	$month_day = ltrim($dates[1], '0');
	        	$month[$month_day]['amount'] = 0;
	        }
			$balance = $this->model_report_common_report->get_owner_balance($filter_name_id);
			$responsible_person_email = $this->model_report_common_report->get_owner_email($filter_name_id);
			$responsible_person_name = $this->model_report_common_report->get_owner_name($filter_name_id);
			foreach ($results as $rkeys => $rvalue) {
				$dot = $rvalue['dot'];
				$dates = explode('-', $dot);
    			$month_day = ltrim($dates[1], '0');
				if(!isset($month[$month_day])){
					$month[$month_day]['amount'] = $rvalue['owner_amt'];
				} else {
					$month[$month_day]['amount'] += $rvalue['owner_amt'];
				}
			}
			$final_data[0]['month'] = $month;
			$final_data[0]['responsible_person'] = $rvalue['responsible_person'];
			$doctor_names = $this->model_report_common_report->get_doctor_name($rvalue['doctor_id']);
			$final_data[0]['doctor_name'] = $doctor_names;
			$final_data[0]['month_start'] = $month_start;
			$final_data[0]['month_end'] = $month_end;
			$final_data[0]['balance'] = $balance;
			$final_data[0]['previous_month_year'] = '';//$previous_month_year;
		//}
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

		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . $this->request->get['filter_email'];
		}
		$url .= "&once=1";
		//echo $filter_email;exit;
		if($final_data){
			$template = new Template();		
			$template->data['final_datas'] = $final_data;
			$template->data['tdate'] = date('d M, Y');
			//$template->data['doctor_name'] = $doctor_name;
			//$template->data['owner_name'] = $owner_name;
			$template->data['email'] = $this->config->get('config_email');
			$template->data['telephone'] = $this->config->get('config_telephone');
			$template->data['titleshead'] = 'Owner_Wise_Summary_Statement';
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
			$invoice_mail_html = $this->sendMail();
			//echo $statement_mail_html;exit;
			$filename = "Owner_Wise_Summary_Statement.html";
			if($filter_name != ''){
				$filter_name = str_replace(array(' ', ',', '&', '.', 'nbsp;'), '_', $filter_name);
				$filename = HTTP_CATALOG."download/"."Owner_Summary_Statement_".$filter_name.".html";
				$filename1 = DIR_DOWNLOAD."Owner_Summary_Statement_".$filter_name.".html";
				$bfilename = "Owner_Summary_Statement_".$filter_name.".html";
			} else {
				$filename = HTTP_CATALOG."download/"."Owner_Summary_Statement_.html";
				$filename1 = DIR_DOWNLOAD."Owner_Summary_Statement_.html";
				$bfilename = "Owner_Summary_Statement_.html";
			}
			//echo $filename1;exit;
			/*
			header('Content-type: text/html');
			header('Content-Disposition: attachment; filename='.$filename);
			echo $html;
			exit;		
			*/
			if(file_exists($filename1)){
				unlink($filename1);
			}
			// Write the contents back to the file
			file_put_contents($filename1, $invoice_mail_html);

			//$responsible_person_email = 'fargose.aaron@gmail.com';
			//echo $responsible_person_email;exit;

			$statement_mail_html = $template->fetch('report/owner_statement_summ_html.tpl');
			$subject = 'Invoice Statement Summary of Dr Phiroz Khambatta';
			// $data['from_email'] = 'phiroz2017@gmail.com';//$this->config->get('config_email');
			// $data['to_email'] = $responsible_person_email;
			// $data['subject'] = $subject;
			// $data['sendmail'] = 2;
			// $data['to_name'] = $responsible_person_name;
			// $data['statement_mail_html'] = $statement_mail_html;
			// $data['invoice_mail_html'] = $invoice_mail_html;
			// echo '<pre>';
			// print_r($data);
			// exit;

			$filter_name = str_replace('_',' ',$filter_name);

			$mailin = new Sendinblue\Mailin("https://api.sendinblue.com/v2.0",'bVN07jDRW85tLAJH');
			  $data = array( "to" => array($responsible_person_email=>$responsible_person_name),
		        "from" => array("phiroz2017@gmail.com", "Phiroz Khambatta"),
		        "subject" => $subject,
		        "html" => $statement_mail_html,
		        "attachment" => array(HTTP_CATALOG."download/".$bfilename)
			);
			$res = $mailin->send_email($data);
			if($res['code'] == 'success'){
				$this->db->query("INSERT INTO oc_email_info SET
									owner_id = '".$filter_name_id."',
									owner_name = '".$this->db->escape($filter_name)."',
									owner_email = '".$responsible_person_email."',
									report_type = '3',
									report_name = 'Owner Cumulative Statment',
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
									report_type = '3',
									report_name = 'Owner Cumulative Statment',
									doctor_id = '".$filter_doctor."',
									send_status = '0',
									date = '".date('Y-m-d')."',
									time = '".date('h:i:s')."'
								");
				$this->session->data['warning'] = 'Mail Cannot be Send';	
			}
			$this->redirect($this->url->link('report/owner_statement_summ', 'token=' . $this->session->data['token'].$url, 'SSL'));

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
			// if($data['success'] == 1){
			// 	$this->session->data['success'] = 'Mail Send';
			// 	$this->redirect($this->url->link('report/owner_wise_email', 'token=' . $this->session->data['token'].$url, 'SSL'));	
			// 	//echo 'Mail Send, Please Close This Window';			
			// } else {
			// 	$this->session->data['warning'] = 'Mail Not Sent Please try again';
			// 	$this->redirect($this->url->link('report/owner_wise_email', 'token=' . $this->session->data['token'].$url, 'SSL'));
			// 	//echo 'Mail Not Sent Please try again, Please Close This Window';		
			// }
			//exit;
		} else {
			$this->session->data['warning'] = 'No Data Found';
			$this->redirect($this->url->link('report/owner_statement_summ', 'token=' . $this->session->data['token'].$url, 'SSL'));
		}
	}

	public function sendMail(){
		$this->language->load('bill/print_invoice');
		$this->load->model('bill/print_invoice');
		$this->load->model('report/common_report');

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

		if (isset($this->request->get['filter_transaction_type'])) {
			$filter_transaction_type = $this->request->get['filter_transaction_type'];
		} else {
			$filter_transaction_type = '';
		}

		//echo 'out';exit;

		$data = array(
			'filter_date_start'	     => $filter_date_start, 
			'filter_date_end'	     => $filter_date_end, 
			'filter_name'            => $filter_name,
			'filter_name_id'         => $filter_name_id,
			'filter_owner'           => $filter_owner,
			'filter_owner_id'        => $filter_owner_id,
			'filter_trainer'         => $filter_trainer,
			'filter_trainer_id'      => $filter_trainer_id,
			'filter_doctor'          => $filter_doctor,
			'filter_transaction_type' => $filter_transaction_type,
			'filter_bill_id' 		 => $filter_bill_id
		);

		$final_owner = array();
		$final_transaction = array();
		$final_data = array();
		$bill_groups = $this->model_report_common_report->getbillids_groups($data);
		// echo '<pre>';
		// print_r($bill_groups);
		// exit;
		foreach ($bill_groups as $bkey => $bvalue) {
			$responsible_person_email = $this->model_report_common_report->get_owner_email($filter_name_id);
			$responsible_person_name = $this->model_report_common_report->get_owner_name($filter_name_id);

			$final_owner = array();
			$final_transaction = array();
			$transaction_ids = $this->model_bill_print_invoice->get_transaction_ids($bvalue['bill_id']);
			foreach ($transaction_ids as $tkey => $tvalue) {
				$transaction_data = $this->model_bill_print_invoice->get_transaction_data($tvalue['transaction_id']);
				
				$final_transaction[$tkey]['bill_id'] = $bvalue['bill_id'];
				$final_transaction[$tkey]['transaction_id'] = $transaction_data['transaction_id'];
				$final_transaction[$tkey]['medicine_name'] = $transaction_data['medicine_name'];
				$final_transaction[$tkey]['medicine_id'] = $transaction_data['medicine_id'];
				$final_transaction[$tkey]['medicine_quantity'] = $transaction_data['medicine_quantity'];
				$final_transaction[$tkey]['medicine_total'] = $transaction_data['medicine_total'];
				$final_transaction[$tkey]['dot'] = date('M d, Y', strtotime($transaction_data['dot']));
				$final_transaction[$tkey]['month'] = $transaction_data['month'];
				$final_transaction[$tkey]['year'] = $transaction_data['year'];
			}
			$horse_data = $this->model_bill_print_invoice->get_horse_data($bvalue['horse_id']);
			if(isset($horse_data['horse_id']) && $horse_data['horse_id'] != '0' && $horse_data['horse_id'] != ''){
				$trainer_data = $this->model_bill_print_invoice->get_trainer_data($horse_data['trainer']);
				$owner_data = $this->model_bill_print_invoice->get_owner_data($bvalue['bill_id'], $horse_data['horse_id'], $bvalue['owner_id']);
				// echo '<pre>';
				// print_r($owner_data);
				// exit;
				if($owner_data){
					$i = 1;
					foreach ($owner_data as $okey => $ovalue) {
						if(($ovalue['transaction_type'] == 1 && $filter_transaction_type == 1) || ($ovalue['transaction_type'] == 2 && $filter_transaction_type == 2) || ($filter_transaction_type == '') ){
							if($filter_owner_id != ''){ 
								if($ovalue['owner'] == $filter_owner_id){
									if($ovalue['share']) {
										$final_owner[$okey]['bill_id'] = $bvalue['bill_id'].'-'.$i;
										$final_owner[$okey]['doctor_id'] = $bvalue['doctor_id'];
										$owner_transactiontype = $this->model_bill_print_invoice->get_owner_transactiontype($ovalue['owner']);
										$owner_share_amount = $this->model_bill_print_invoice->get_owner_share($bvalue['bill_id'], $ovalue['owner']);
										$final_owner[$okey]['owner_share_amount'] = $owner_share_amount;
										
										$doctor_names = $this->db->query("SELECT * FROM `oc_transaction_type` WHERE `doctor_id` = '".$bvalue['doctor_id']."' AND `id` = '".$owner_transactiontype."' ");
										$doctor_name = '';
										if($doctor_names->num_rows > 0){
											$doctor_name = $doctor_names->row['transaction_type'];
										}
										$final_owner[$okey]['doctor_name'] = $doctor_name;
										$final_owner[$okey]['trainer_id'] = $bvalue['trainer_id'];
										$final_owner[$okey]['horse_id'] = $bvalue['horse_id'];
										$final_owner[$okey]['horse_name'] = $horse_data['name'];
										$final_owner[$okey]['trainer_name'] = $trainer_data['name'];
										$owner_name = $this->model_bill_print_invoice->get_owner_name($ovalue['owner']); 
										$final_owner[$okey]['owner_name'] = $owner_name;
										$final_owner[$okey]['transaction_type'] = $owner_transactiontype;
										$final_owner[$okey]['owner_id'] = $ovalue['owner'];
										$final_owner[$okey]['owner_share'] = $ovalue['share'];
										
										$month = date("F", mktime(0, 0, 0, $bvalue['month'], 10));
										$final_owner[$okey]['month'] = $month;
										$final_owner[$okey]['year'] = $bvalue['year'];

										$final_owner[$okey]['transaction_data'] = $final_transaction;
									}	
								}
							} else {
								if($filter_transaction_type != ''){ 
									$owner_transaction_type = $this->model_bill_print_invoice->get_owner_transactiontype($ovalue['owner']);							
									if($owner_transaction_type == $filter_transaction_type){	
										if($ovalue['share']) {
									
											$final_owner[$okey]['bill_id'] = $bvalue['bill_id'].'-'.$i;
											$final_owner[$okey]['doctor_id'] = $bvalue['doctor_id'];
											$owner_transactiontype = $this->model_bill_print_invoice->get_owner_transactiontype($ovalue['owner']);
											$owner_share_amount = $this->model_bill_print_invoice->get_owner_share($bvalue['bill_id'], $ovalue['owner']);
											$final_owner[$okey]['owner_share_amount'] = $owner_share_amount;

											$doctor_names = $this->db->query("SELECT * FROM `oc_transaction_type` WHERE `doctor_id` = '".$bvalue['doctor_id']."' AND `id` = '".$owner_transactiontype."' ");
											$doctor_name = '';
											if($doctor_names->num_rows > 0){
												$doctor_name = $doctor_names->row['transaction_type'];
											}
											$final_owner[$okey]['doctor_name'] = $doctor_name;
											$final_owner[$okey]['trainer_id'] = $bvalue['trainer_id'];
											$final_owner[$okey]['horse_id'] = $bvalue['horse_id'];
											$final_owner[$okey]['horse_name'] = $horse_data['name'];
											$final_owner[$okey]['trainer_name'] = $trainer_data['name'];
											$owner_name = $this->model_bill_print_invoice->get_owner_name($ovalue['owner']); 
											$final_owner[$okey]['owner_name'] = $owner_name;
											$final_owner[$okey]['transaction_type'] = $owner_transactiontype;
											$final_owner[$okey]['owner_id'] = $ovalue['owner'];
											$final_owner[$okey]['owner_share'] = $ovalue['share'];
									
											$month = date("F", mktime(0, 0, 0, $bvalue['month'], 10));
											$final_owner[$okey]['month'] = $month;
											$final_owner[$okey]['year'] = $bvalue['year'];

											$final_owner[$okey]['transaction_data'] = $final_transaction;
										}
									}
								} else {
									if($ovalue['share']) {
										$final_owner[$okey]['bill_id'] = $bvalue['bill_id'].'-'.$i;
										$final_owner[$okey]['doctor_id'] = $bvalue['doctor_id'];
										$owner_transactiontype = $this->model_bill_print_invoice->get_owner_transactiontype($ovalue['owner']);
										$owner_share_amount = $this->model_bill_print_invoice->get_owner_share($bvalue['bill_id'], $ovalue['owner']);
										$final_owner[$okey]['owner_share_amount'] = $owner_share_amount;
										
										$doctor_names = $this->db->query("SELECT * FROM `oc_transaction_type` WHERE `doctor_id` = '".$bvalue['doctor_id']."' AND `id` = '".$owner_transactiontype."' ");
										$doctor_name = '';
										if($doctor_names->num_rows > 0){
											$doctor_name = $doctor_names->row['transaction_type'];
										}
										$final_owner[$okey]['doctor_name'] = $doctor_name;
										$final_owner[$okey]['trainer_id'] = $bvalue['trainer_id'];
										$final_owner[$okey]['horse_id'] = $bvalue['horse_id'];
										$final_owner[$okey]['horse_name'] = $horse_data['name'];
										$final_owner[$okey]['trainer_name'] = $trainer_data['name'];
										$owner_name = $this->model_bill_print_invoice->get_owner_name($ovalue['owner']); 
										$final_owner[$okey]['owner_name'] = $owner_name;
										$final_owner[$okey]['transaction_type'] = $owner_transactiontype;
										$final_owner[$okey]['owner_id'] = $ovalue['owner'];
										$final_owner[$okey]['owner_share'] = $ovalue['share'];
									
										$month = date("F", mktime(0, 0, 0, $bvalue['month'], 10));
										$final_owner[$okey]['month'] = $month;
										$final_owner[$okey]['year'] = $bvalue['year'];

										$final_owner[$okey]['transaction_data'] = $final_transaction;
									}							
								}
							}
						}
						//echo 'out';exit;
						$i ++;
					}
					if($final_owner) {
						$final_data[$bkey] = $final_owner;
					}
				}
			}
			// echo '<pre>';
			// print_r($final_data);
			// exit;	
		}
		
		// echo '<pre>';
		// print_r($final_data);
		// exit;

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

		if (isset($this->request->get['filter_transaction_type'])) {
			$url .= '&filter_transaction_type=' . $this->request->get['filter_transaction_type'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		$url .= '&first=0';

		if($final_data){
			//$month = date('m', strtotime($filter_date_start));
			//$year = date('Y', strtotime($filter_date_start));
			//$month = date("F", mktime(0, 0, 0, $month, 10));
			$template = new Template();		
			$template->data['final_datas'] = $final_data;
			//$template->data['month'] = $month;
			//$template->data['year'] = $year;
			$template->data['title'] = 'Invoice';
			$template->data['text_invoice'] = 'Invoice';

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
				$template->data['base'] = "http://64.79.95.89/phiroz/admin/";
			} else {
				$template->data['base'] = "http://64.79.95.89/phiroz/admin/";
			}
			$html = $template->fetch('bill/invoice_html.tpl');
			//echo $html;exit;
			$filename = "Invoice.html";
			if(isset($this->request->get['export'])){
				header('Content-type: text/html');
				header('Set-Cookie: fileLoading=true');
				header('Content-Disposition: attachment; filename='.$filename);
				echo $html;
				exit;
			} else {
				return $html;
			}
			/*
			if(file_exists($filename)){
				unlink($filename);
			}
			// Write the contents back to the file
			file_put_contents($filename, $html);
			$responsible_person_email = 'fargose.aaron@gmail.com';
			
			if($filter_doctor != '*'){
				$doctor_names = $this->model_report_common_report->get_doctor_name($filter_doctor);
				$doctor_name = 'Dr. ' . $doctor_names;
			} else {
				$doctor_name = 'All Clinic';
			}

			$invoice_mail_text = $this->invoice_mail_text($responsible_person_name, $doctor_name, $filter_doctor);

			$subject = 'Invoices by Dr Phiroz Khambatta';
			$data['from_email'] = 'phiroz2017@gmail.com';//$this->config->get('config_email');
			$data['to_email'] = $responsible_person_email;
			$data['subject'] = $subject;
			$data['senmail'] = 4;
			$data['to_name'] = $responsible_person_name;
			$data['statement_mail_html'] = $html;
			$data['invoice_mail_text'] = $invoice_mail_text;
			// echo '<pre>';
			// print_r($data);
			// exit;
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
				echo "Mail Sent to  : " . $responsible_person_email;
				//$this->session->data['success'] = 'Mail Send';
				//$this->redirect($this->url->link('report/owner_wise_email', 'token=' . $this->session->data['token'].$url, 'SSL'));	
				//echo 'Mail Send, Please Close This Window';			
			} else {
				echo "Mail not sent";
				//$this->session->data['warning'] = 'Mail Not Sent Please try again';
				//$this->redirect($this->url->link('report/owner_wise_email', 'token=' . $this->session->data['token'].$url, 'SSL'));
				//echo 'Mail Not Sent Please try again, Please Close This Window';		
			}
			exit;
			*/
		} else {
			$this->session->data['warning'] = 'No Data Found';
			$this->redirect($this->url->link('report/owner_statement_summ', 'token=' . $this->session->data['token'].$url, 'SSL'));
		}
	}

	public function invoice_mail_text($responsible_person, $doctor_name, $doctor_id){
		$this->language->load('bill/print_invoice');
		$this->load->model('bill/print_invoice');

		$this->document->setTitle($this->language->get('heading_title'));

		$template = new Template();		
		$template->data['title'] = 'Invoice';
		$template->data['doctor_name'] = $doctor_name;
		$template->data['owner_name'] = $responsible_person;

		$doctor_datas = $this->model_bill_print_invoice->get_doctor_data($doctor_id);
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
			$template->data['base'] = "http://64.79.95.89/phiroz/admin/";
		} else {
			$template->data['base'] = "http://64.79.95.89/phiroz/admin/";
		}
		$html = $template->fetch('bill/invoice_text.tpl');
		return $html;
	}
}
?>
