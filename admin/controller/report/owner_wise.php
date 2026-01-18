<?php
class ControllerReportOwnerWise extends Controller { 
	public function index() { 

		//$tran_datas = $this->db->query("SELECT * FROM `oc_transaction` WHERE `month` = '12' AND `year` = '2015'")->rows;
		//foreach ($tran_datas as $key => $value) {
			
			//echo '<pre>';
			//print_r($value);

			//$horse_data = $this->db->query("SELECT * FROM `oc_horse` WHERE `horse_id` = '".$value['horse_id']."' ")->row;
			
			//echo '<pre>';
			//print_r($horse_data);

			//echo "UPDATE `oc_transaction` SET `trainer_id` = '".$horse_data['trainer']."' WHERE `transaction_id` = '".$value['transaction_id']."' ";
			//exit;
			//if(isset($horse_data['trainer'])){
				//$this->db->query("UPDATE `oc_transaction` SET `trainer_id` = '".$horse_data['trainer']."' WHERE `transaction_id` = '".$value['transaction_id']."' ");				
			//}
		//}
		//echo 'Done';exit;
		
		$this->language->load('report/owner_wise');

		$this->document->setTitle($this->language->get('heading_title'));

		if (isset($this->request->get['filter_date_start'])) {
			$filter_date_start = $this->request->get['filter_date_start'];
		} else {
			$filter_date_start = date('Y-m-d', strtotime(date('Y') . '-' . date('m') . '-01'));
			//$filter_date_start = '2015-06-01';
		}

		if (isset($this->request->get['filter_date_end'])) {
			$filter_date_end = $this->request->get['filter_date_end'];
		} else {
			$filter_date_end = date('Y-m-d', strtotime(date('Y') . '-' . date('m') . '-01'));
			//$filter_date_end = '2015-06-01';
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

		if (isset($this->request->get['filter_transaction_type'])) {
			$filter_transaction_type = $this->request->get['filter_transaction_type'];
		} else {
			$filter_transaction_type = '1';
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

		if (isset($this->request->get['filter_transaction_type'])) {
			$url .= '&filter_transaction_type=' . $this->request->get['filter_transaction_type'];
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
			'href'      => $this->url->link('report/owner_wise', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$this->load->model('report/common_report');

		$this->data['owner_wise'] = array();

		$data = array(
			'filter_date_start'	     => $filter_date_start, 
			'filter_date_end'	     => $filter_date_end, 
			'filter_name'            => $filter_name,
			'filter_name_id'         => $filter_name_id,
			'filter_transaction_type' => $filter_transaction_type,
			'filter_doctor' => $filter_doctor,
			'start'                  => ($page - 1) * 7000,
			'limit'                  => 7000
		);
		
		$data_lmf = array(
			'filter_date_start'	     => $filter_date_start, 
			'filter_date_end'	     => $filter_date_end, 
			'filter_name'            => $filter_name,
			'filter_name_id'         => $filter_name_id,
			'filter_transaction_type' => $filter_transaction_type,
			'filter_doctor' => 2,
			'start'                  => ($page - 1) * 7000,
			'limit'                  => 7000
		);

		$order_total = $this->model_report_common_report->getTotalTransaction_owner($data);
		//echo '<pre>';
		//print_r($data);
		
		//$results = $this->model_report_common_report->getTransaction_owner($data);
		$results = $this->model_report_common_report->getTransaction_owner_eric_1($data);
		$results_lmf = $this->model_report_common_report->getTransaction_owner_eric_1($data_lmf);
		
		$lmf_array = array();
		foreach($results_lmf as $lmf) {
			$lmf_array[] = $lmf['horse_id'];
		}

		//echo '<pre>';
		//print_r($results);
		//exit;
		foreach ($results as $result) {
			//$horse_data = $this->model_report_common_report->get_horse_data($result['horse_id']);
			if(in_array($result['horse_id'], $lmf_array)) {
				$trainer_name = '<span style="color:red;">'.$this->model_report_common_report->get_trainer_name($result['trainer_id']).'</span>';
				$horse_name = '<span style="color:red;">'.$this->model_report_common_report->get_horse_name($result['horse_id']).'</span>';
				$horse_owner = $this->model_report_common_report->get_owner_data($result['horse_id']);			
			} else {
				$trainer_name = $this->model_report_common_report->get_trainer_name($result['trainer_id']);
				$horse_name = $this->model_report_common_report->get_horse_name($result['horse_id']);
				$horse_owner = $this->model_report_common_report->get_owner_data($result['horse_id']);			
			}
			$owner_string = '';			
			foreach($horse_owner as $owner) {
				$owner_string = $owner_string . $this->model_report_common_report->get_owner_name($owner['owner'])."->". $owner['share'] . "%, ";			
			}
			
			$this->data['owner_wise'][] = array(
				'date_treatment' => date('d-m-Y', strtotime($result['dot'])),
				'horse_name'     => $horse_name,
				//'medicine_name'   => $result['medicine_name'],
				//'medicine_quantity' => $result['medicine_quantity'],
				//'total'      => $this->currency->format($result['medicine_total'], $this->config->get('config_currency')),
				'trainer_name'      => $trainer_name,
				//'raw_total'      => $result['medicine_total'],
				'owner_name'  => $owner_string,
				//'owner_share'  => $result['share']
			);
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
		$this->data['column_owner'] = $this->language->get('column_owner');

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

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}

		if (isset($this->request->get['filter_name_id'])) {
			$url .= '&filter_name_id=' . $this->request->get['filter_name_id'];
		}	

		if (isset($this->request->get['filter_transaction_type'])) {
			$url .= '&filter_transaction_type=' . $this->request->get['filter_transaction_type'];
		}

		if (isset($this->request->get['filter_doctor'])) {
			$url .= '&filter_doctor=' . $this->request->get['filter_doctor'];
		}	

		$pagination = new Pagination();
		$pagination->total = $order_total;
		$pagination->page = $page;
		$pagination->limit = 7000;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('report/owner_wise', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();		

		$this->data['filter_date_start'] = $filter_date_start;
		$this->data['filter_date_end'] = $filter_date_end;		
		$this->data['filter_name'] = $filter_name;
		$this->data['filter_name_id'] = $filter_name_id;
		$this->data['filter_transaction_type'] = $filter_transaction_type;
		$this->data['filter_doctor'] = $filter_doctor;

		$this->template = 'report/owner_wise.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function export(){
		$this->language->load('report/owner_wise');
		$this->load->model('report/common_report');

		$this->document->setTitle($this->language->get('heading_title'));

		if (isset($this->request->get['filter_date_start'])) {
			$filter_date_start = $this->request->get['filter_date_start'];
		} else {
			$filter_date_start = date('Y-m-d', strtotime(date('Y') . '-' . date('m') . '-01'));
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

		if (isset($this->request->get['filter_transaction_type'])) {
			$filter_transaction_type = $this->request->get['filter_transaction_type'];
		} else {
			$filter_transaction_type = '1';
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
			'filter_transaction_type' => $filter_transaction_type,
			'filter_doctor' => $filter_doctor
		);

		//$sql = "UPDATE `oc_transaction` SET `trainer_id` = '4' WHERE `transaction_id` = '61535' ";
		//$this->db->query($sql);


		//$results = $this->model_report_common_report->getTransaction_owner($data);
		$resultsss = $this->model_report_common_report->getTransaction_owner_eric_group($data);
		foreach ($resultsss as $resultss) {
			$data['trainer_id'] = $resultss['trainer_id'];
			//$horse_data = $this->model_report_common_report->get_horse_data($result['horse_id']);
			$results = $this->model_report_common_report->getTransaction_owner_eric($data);
			foreach($results as $rkey => $result){
				$trainer_name = $this->model_report_common_report->get_trainer_name($result['trainer_id']);
				$horse_name = $this->model_report_common_report->get_horse_name($result['horse_id']);
				$horse_owner = $this->model_report_common_report->get_owner_data($result['horse_id']);			
				$owner_string = '';			
				foreach($horse_owner as $owner) {
					if($owner['owner'] != '2741'){
						$owner_string = $owner_string . $this->model_report_common_report->get_owner_name($owner['owner'])."->". $owner['share'] . "% <br/ >";			
					}
					//$in = 0;
					//if($owner['owner'] == '2741' || $owner['owner'] == '2273'){
					//	$in = 1;
						//$owner_string = $owner_string . $this->model_report_common_report->get_owner_name($owner['owner'])."->". $owner['share'] . "% <br/ >";			
					//}
				}
				//if($in == 1){
					$owner_wise[$resultss['trainer_id']][] = array(
						'date_treatment' => date('d-m-Y', strtotime($result['dot'])),
						'transaction_id'     => $result['transaction_id'],
						'horse_name'     => $horse_name,
						//'medicine_name'   => $result['medicine_name'],
						//'medicine_quantity' => $result['medicine_quantity'],
						//'total'      => $this->currency->format($result['medicine_total'], $this->config->get('config_currency')),
						'trainer_name'      => $trainer_name,
						//'raw_total'      => $result['medicine_total'],
						'owner_name'  => $owner_string,
						'owner_share'  => $result['share']
					);
				//}
			}
		}

		// echo '<pre>';
		// print_r($owner_wise);
		// exit;


		// $results = $this->model_report_common_report->getTransaction_owner($data);

		// $owner_wise = array();
		// foreach ($results as $result) {
		// 	$horse_data = $this->model_report_common_report->get_horse_data($result['horse_id']);
		// 	$trainer_name = $this->model_report_common_report->get_trainer_name($horse_data['trainer']);
		// 	$horse_name = $this->model_report_common_report->get_horse_name($result['horse_id']);
		// 	$owner_wise[] = array(
		// 		'date_treatment' => date('d-m-Y', strtotime($result['dot'])),
		// 		'horse_name'     => $horse_name,
		// 		'medicine_name'   => $result['medicine_name'],
		// 		'medicine_quantity' => $result['medicine_quantity'],
		// 		'total'      => $this->currency->format($result['medicine_total'], $this->config->get('config_currency')),
		// 		'trainer_name'      => $trainer_name,
		// 		'raw_total'      => $result['medicine_total'],
		// 		'owner_name'  => $result['owner_name'],
		// 		'owner_share'  => $result['share']
		// 	);
		// }

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

		if (isset($this->request->get['filter_transaction_type'])) {
			$url .= '&filter_transaction_type=' . $this->request->get['filter_transaction_type'];
		}

		if (isset($this->request->get['filter_doctor'])) {
			$url .= '&filter_doctor=' . $this->request->get['filter_doctor'];
		}

		
		if($owner_wise){
			//$month = date("F", mktime(0, 0, 0, $filter_month, 10));
			$template = new Template();		
			$template->data['final_datass'] = $owner_wise;
			$template->data['date_start'] = $filter_date_start;
			$template->data['date_end'] = $filter_date_end;
			$template->data['title'] = 'Owner Wise Report';
			if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
				$template->data['base'] = HTTPS_SERVER;
			} else {
				$template->data['base'] = HTTP_SERVER;
			}
			$html = $template->fetch('report/owner_wise_html.tpl');
			//echo $html;exit;
			$filename = "Owner_Wise.html";
			header('Content-type: text/html');
			header('Content-Disposition: attachment; filename='.$filename);
			// $filename = "Owner_Wise.xls";
			//header("Content-Type: application/vnd.ms-excel; charset=utf-8");
			// header("Content-Disposition: attachment; filename=".$filename);//File name extension was wrong
			// header("Expires: 0");
			// header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			// header("Cache-Control: private",false);
			echo $html;
			exit;		
		} else {
			$this->session->data['warning'] = 'No Data Found';
			$this->redirect($this->url->link('report/owner_wise', 'token=' . $this->session->data['token'].$url, 'SSL'));
		}
	}
}
?>
