<?php
class ControllerReportTrainerWiseLog extends Controller { 
	public function index() {  
		$this->language->load('report/trainer_wise_log');

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

		if (isset($this->request->get['filter_trainer'])) {
			$url .= '&filter_trainer=' . $this->request->get['filter_trainer'];
		}

		if (isset($this->request->get['filter_trainer_id'])) {
			$url .= '&filter_trainer_id=' . $this->request->get['filter_trainer_id'];
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
			'href'      => $this->url->link('report/trainer_wise_log', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$this->load->model('report/common_report');

		$this->data['trainer_datas'] = array();

		$data = array(
			'filter_date_start'	     => $filter_date_start, 
			'filter_date_end'	     => $filter_date_end, 
			'filter_trainer'	     => $filter_trainer, 
			'filter_trainer_id'	     => $filter_trainer_id, 
			'filter_doctor' 		 => $filter_doctor,
			'start'                  => ($page - 1) * 7000,
			'limit'                  => 7000
		);

		$order_total = 0;
		$datas = array();
		if($filter_trainer != ''){
			//$order_total = $this->model_report_common_report->getTotalTransaction($data);
			$resultss = $this->model_report_common_report->get_log_trainer_group($data);
			// echo '<pre>';
			// print_r($resultss);
			// exit;
			$horse_data = array();
			$datas = array();
			foreach ($resultss as $keyss => $results) {
				//$horse_data = array();
				//$final_data = array();
				//$datass = array();
				//unset($this->session->data['count']);
				//$this->data['final_data'] = array();
				$data['filter_trainer_id'] = $results['trainer_id'];
				$trainer_name = $this->model_report_common_report->get_trainer_name($results['trainer_id']);
				$datas[$keyss]['trainer_name'] = $trainer_name;
				$result = $this->model_report_common_report->get_log_trainer_wise_horse_group($data);
				foreach ($result as $hkey => $hvalue) {
					$horse_name = $this->model_report_common_report->get_horse_name($hvalue['horse_id']);
					$datas[$keyss]['horse_data'][$hkey]['horse_name'] = $horse_name;
					$data['filter_horse_id'] = $hvalue['horse_id'];
					$medicine_datas = $this->model_report_common_report->get_log_trainer_wise_medicine_wise($data);
					foreach ($medicine_datas as $mkey => $mvalue) {
						$medicine_name = $mvalue['medicine_name'];
						$datas[$keyss]['horse_data'][$hkey]['medicine_data'][$mkey]['medicine_name'] = $medicine_name;					
						$datas[$keyss]['horse_data'][$hkey]['medicine_data'][$mkey]['medicine_amount'] = $mvalue['medicine_price'];					
						$datas[$keyss]['horse_data'][$hkey]['medicine_data'][$mkey]['medicine_quantity'] = $mvalue['medicine_quantity'];					
						$datas[$keyss]['horse_data'][$hkey]['medicine_data'][$mkey]['dot'] = substr($mvalue['dot'], 0, 11);						
					}
				}
				
				// foreach ($result as $key => $value) {
				// 	$horse_data[$horse_name][$key] = $value['medicine_name'];
				// }

				// if(count($horse_data) == 1){
				// 	foreach ($horse_data as $hkeys => $hvalues) {
				// 		foreach ($hvalues as $hkey => $hvalue) {
				// 			$final_data[0]['horse_name'][$hkeys] = $hkeys;
				// 			$final_data[0]['medicine_name'][$hvalue] = $hvalue;
				// 		}
				// 	}
				// 	$final_trainer_log = $final_data;
				// } else {
				// 	$final_trainer_log = $this->compute_data($horse_data, $final_data);
				// 	$final_trainer_log = $this->data['final_data'];
				// }

				// foreach ($final_trainer_log as $tkey => $tvalue) {
				// 	$horse_string = implode(', ', $tvalue['horse_name']);
				// 	$medicine_string = implode(', ', $tvalue['medicine_name']);
				// 	$datass[$tkey]['horse_name'] = $horse_string;
				// 	$datass[$tkey]['medicine_name'] = $medicine_string;
				// }
				//$datas[$keyss]['log_record'] = $datass;
			}
		}
		// echo '<pre>';
		// print_r($datas);
		// exit;

		$this->data['trainer_datas'] = $datas;

		if(isset($this->session->data['warning'])){
			$this->data['error_warning'] = $this->session->data['warning'];
			unset($this->session->data['warning']);
		} else {
			$this->data['error_warning'] = '';
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_all_status'] = $this->language->get('text_all_status');

		$this->data['column_date'] = $this->language->get('column_date');
		$this->data['column_horse_name'] = $this->language->get('column_horse_name');
		$this->data['column_medicine_name'] = $this->language->get('column_medicine_name');
		$this->data['column_trainer'] = $this->language->get('column_trainer');
		$this->data['text_all'] = $this->language->get('text_all');

		$this->data['entry_date_start'] = $this->language->get('entry_date_start');
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

		$url = '';

		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}

		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}

		if (isset($this->request->get['filter_trainer'])) {
			$url .= '&filter_trainer=' . $this->request->get['filter_trainer'];
		}

		if (isset($this->request->get['filter_trainer_id'])) {
			$url .= '&filter_trainer_id=' . $this->request->get['filter_trainer_id'];
		}

		if (isset($this->request->get['filter_doctor'])) {
			$url .= '&filter_doctor=' . $this->request->get['filter_doctor'];
		}		

		$pagination = new Pagination();
		$pagination->total = $order_total;
		$pagination->page = $page;
		$pagination->limit = 7000;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('report/trainer_wise_log', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();		

		$this->data['filter_date_start'] = $filter_date_start;
		$this->data['filter_date_end'] = $filter_date_end;
		$this->data['filter_trainer'] = $filter_trainer;
		$this->data['filter_trainer_id'] = $filter_trainer_id;
		$this->data['filter_doctor'] = $filter_doctor;

		$this->template = 'report/trainer_wise_log.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function export(){
		$this->language->load('report/trainer_wise_log');
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

		if (isset($this->request->get['filter_doctor'])) {
			$filter_doctor = $this->request->get['filter_doctor'];
		} else {
			$filter_doctor = '1';
		}

		$data = array(
			'filter_date_start'	     => $filter_date_start, 
			'filter_date_end'	     => $filter_date_end, 
			'filter_trainer'	     => $filter_trainer, 
			'filter_trainer_id'	     => $filter_trainer_id, 
			'filter_doctor' 		 => $filter_doctor,
		);

		$order_total = 0;
		//$order_total = $this->model_report_common_report->getTotalTransaction($data);
		$resultss = $this->model_report_common_report->get_log_trainer_group($data);
		// echo '<pre>';
		// print_r($resultss);
		// exit;
		$horse_data = array();
		$datas = array();
		foreach ($resultss as $keyss => $results) {
			//$horse_data = array();
			//$final_data = array();
			//$datass = array();
			//unset($this->session->data['count']);
			//$this->data['final_data'] = array();
			$data['filter_trainer_id'] = $results['trainer_id'];
			$trainer_name = $this->model_report_common_report->get_trainer_name($results['trainer_id']);
			$datas[$keyss]['trainer_name'] = $trainer_name;
			$result = $this->model_report_common_report->get_log_trainer_wise_horse_group($data);
			foreach ($result as $hkey => $hvalue) {
				$horse_name = $this->model_report_common_report->get_horse_name($hvalue['horse_id']);
				$datas[$keyss]['horse_data'][$hkey]['horse_name'] = $horse_name;
				$data['filter_horse_id'] = $hvalue['horse_id'];
				$medicine_datas = $this->model_report_common_report->get_log_trainer_wise_medicine_wise($data);
				foreach ($medicine_datas as $mkey => $mvalue) {
					$medicine_name = $mvalue['medicine_name'];
					$datas[$keyss]['horse_data'][$hkey]['medicine_data'][$mkey]['medicine_name'] = $medicine_name;					
					$datas[$keyss]['horse_data'][$hkey]['medicine_data'][$mkey]['medicine_amount'] = $mvalue['medicine_price'];					
					$datas[$keyss]['horse_data'][$hkey]['medicine_data'][$mkey]['medicine_quantity'] = $mvalue['medicine_quantity'];					
					$datas[$keyss]['horse_data'][$hkey]['medicine_data'][$mkey]['dot'] = substr($mvalue['dot'], 0, 11);					
				}
			}
			
			// foreach ($result as $key => $value) {
			// 	$horse_data[$horse_name][$key] = $value['medicine_name'];
			// }

			// if(count($horse_data) == 1){
			// 	foreach ($horse_data as $hkeys => $hvalues) {
			// 		foreach ($hvalues as $hkey => $hvalue) {
			// 			$final_data[0]['horse_name'][$hkeys] = $hkeys;
			// 			$final_data[0]['medicine_name'][$hvalue] = $hvalue;
			// 		}
			// 	}
			// 	$final_trainer_log = $final_data;
			// } else {
			// 	$final_trainer_log = $this->compute_data($horse_data, $final_data);
			// 	$final_trainer_log = $this->data['final_data'];
			// }

			// foreach ($final_trainer_log as $tkey => $tvalue) {
			// 	$horse_string = implode(', ', $tvalue['horse_name']);
			// 	$medicine_string = implode(', ', $tvalue['medicine_name']);
			// 	$datass[$tkey]['horse_name'] = $horse_string;
			// 	$datass[$tkey]['medicine_name'] = $medicine_string;
			// }
			//$datas[$keyss]['log_record'] = $datass;
		}
		// echo '<pre>';
		// print_r($datas);
		// exit;

		$url = '';
		
		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}

		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}

		if (isset($this->request->get['filter_trainer'])) {
			$url .= '&filter_trainer=' . $this->request->get['filter_trainer'];
		}

		if (isset($this->request->get['filter_trainer_id'])) {
			$url .= '&filter_trainer_id=' . $this->request->get['filter_trainer_id'];
		}

		if (isset($this->request->get['filter_doctor'])) {
			$url .= '&filter_doctor=' . $this->request->get['filter_doctor'];
		}

		
		if($datas){
			//$month = date("F", mktime(0, 0, 0, $filter_month, 10));
			$template = new Template();		
			$template->data['final_datas'] = $datas;
			$template->data['column_horse_name'] = $this->language->get('column_horse_name');
			$template->data['column_trainer'] = $this->language->get('column_trainer');
			$template->data['column_medicine_name'] = $this->language->get('column_medicine_name');
			$template->data['date_start'] = date('d-m-Y', strtotime($filter_date_start));
			$template->data['date_end'] = date('d-m-Y', strtotime($filter_date_end));
			$template->data['trainer_name'] = $filter_trainer;
			$template->data['title'] = 'Trainer Wise Log Report';
			if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
				$template->data['base'] = HTTPS_SERVER;
			} else {
				$template->data['base'] = HTTP_SERVER;
			}
			$html = $template->fetch('report/trainer_wise_log_html.tpl');
			//echo $html;exit;
			$filename = "Trainer_Wise_Log.html";
			header('Content-type: text/html');
			header('Content-Disposition: attachment; filename='.$filename);
			echo $html;
			exit;		
		} else {
			$this->session->data['warning'] = 'No Data Found';
			$this->redirect($this->url->link('report/trainer_wise_log', 'token=' . $this->session->data['token'].$url, 'SSL'));
		}
	}

	public function compute_data($horse_data, $final_data = array()){
		$intersect = call_user_func_array('array_intersect', $horse_data);
		// echo '<pre>';
		// print_r($horse_data);
		// echo '<pre>';
		// print_r($intersect);
		
		//unset($this->session->data['count']);
		if(isset($this->session->data['count'])){
			$this->session->data['count'] = $this->session->data['count'] + 1;
			$cnt = $this->session->data['count'];
		} else {
			$this->session->data['count'] = 0;
			$cnt = 0;
		}
		$in = 0;
		if($intersect){
			foreach ($horse_data as $hkeys => $hvalues) {
				if($hvalues){
					foreach ($hvalues as $hkey => $hvalue) {
						foreach ($intersect as $ikey => $ivalue) {
							if($ivalue == $hvalue){
								$final_data[$cnt]['horse_name'][$hkeys] = $hkeys;
								$final_data[$cnt]['medicine_name'][$hvalue] = $hvalue;
								unset($horse_data[$hkeys][$hkey]);
							}
						}
					}
				}
			}
		} else {
			$in = 1;
			$ccnt = 0;
			foreach ($horse_data as $hkeys => $hvalues) {
				if($hvalues){
					foreach ($hvalues as $hkey => $hvalue) {
						$final_data[$ccnt]['horse_name'][$hkeys] = $hkeys;
						$final_data[$ccnt]['medicine_name'][$hvalue] = $hvalue;
						unset($horse_data[$hkeys][$hkey]);
					}
				}
			$ccnt ++;
			}
		}

		foreach ($horse_data as $hkey => $hvalue) {
			if($hvalue){
			} else {
				unset($horse_data[$hkey]);
			}
		}

		// echo '<pre>';
		// print_r($final_data);
		// echo '<pre>';
		// print_r($horse_data);
				

		if(count($horse_data) > 1){
			$this->compute_data($horse_data, $final_data);
			return;
		} else {
			// echo $in;
			// echo '<br />';

			if($in == 0){
				$cnt ++;
				foreach ($horse_data as $hkeys => $hvalues) {
					foreach ($hvalues as $hkey => $hvalue) {
						$final_data[$cnt]['horse_name'][$hkeys] = $hkeys; 
						$final_data[$cnt]['medicine_name'][$hvalue] = $hvalue; 
					}
				}
			}
		}
		$this->data['final_data'] = $final_data;
		return $final_data;
	}
}
?>
