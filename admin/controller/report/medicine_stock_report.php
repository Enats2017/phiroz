<?php
class ControllerReportMedicineStockReport extends Controller { 
	public function index() {  
		$this->language->load('report/medicine_stock_report');

		$this->document->setTitle($this->language->get('heading_title'));

		//$this->snippetdata();
		//echo 'out';exit;

		if (isset($this->request->get['filter_date_start'])) {
			$filter_date_start = $this->request->get['filter_date_start'];
		} else {
			$filter_date_start = date('Y-m-d');//'2015-05-01';
		}

		if (isset($this->request->get['filter_date_end'])) {
			$filter_date_end = $this->request->get['filter_date_end'];
		} else {
			$filter_date_end = date('Y-m-d');//'2015-05-31';
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
			'href'      => $this->url->link('report/medicine_stock_report', 'token=' . $this->session->data['token'] . $url, 'SSL'),
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

		
		$final_data = array();
		$order_total = 0;
		if(isset($this->request->get['once']) && $this->request->get['once'] == '1'){
			$resultss = $this->model_report_common_report->getownerbymedicne($data);
			foreach ($resultss as $keyss => $results) {
				$owner_medicine = array(
					'medicine_name' => $results['medicine_name'],
					'quantity_share' => $results['quantity_share']
				);
				$final_data[$results['owner_id']]['owner_name'] = $results['owner_name'];
				$final_data[$results['owner_id']]['owner_data'][] = $owner_medicine;
			}
		}
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

		$this->data['column_owner_name'] = $this->language->get('column_owner_name');
		$this->data['column_medicine_name'] = $this->language->get('column_medicine_name');
		$this->data['column_quantity_share'] = $this->language->get('column_quantity_share');
		$this->data['column_total'] = $this->language->get('column_total');
		
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
		$pagination->url = $this->url->link('report/medicine_stock_report', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();		

		$this->data['filter_date_start'] = $filter_date_start;
		$this->data['filter_date_end'] = $filter_date_end;		
		$this->data['filter_name'] = $filter_name;
		$this->data['filter_name_id'] = $filter_name_id;
		$this->data['filter_doctor'] = $filter_doctor;

		$this->template = 'report/medicine_stock_report.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function export() {  
		$this->language->load('report/medicine_stock_report');

		$this->document->setTitle($this->language->get('heading_title'));

		//$this->snippetdata();
		//echo 'out';exit;

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

		$this->load->model('report/common_report');

		$data = array(
			'filter_date_start'	     => $filter_date_start, 
			'filter_date_end'	     => $filter_date_end, 
			'filter_name'            => $filter_name,
			'filter_name_id'         => $filter_name_id,
			'filter_doctor'          => $filter_doctor,
		);

		
		$final_data = array();
		$order_total = 0;
		
		$resultss = $this->model_report_common_report->getownerbymedicne($data);
		foreach ($resultss as $keyss => $results) {
			$owner_medicine = array(
				'medicine_name' => $results['medicine_name'],
				'quantity_share' => $results['quantity_share']
			);
			$final_data[$results['owner_id']]['owner_name'] = $results['owner_name'];
			$final_data[$results['owner_id']]['owner_data'][] = $owner_medicine;
		}

		if($final_data){
			$date_from = date('d M, Y', strtotime($filter_date_start));
			$date_to = date('d M, Y', strtotime($filter_date_end));
			//$month = date("F", mktime(0, 0, 0, $filter_month, 10));
			$template = new Template();		
			$template->data['final_datas'] = $final_data;
			$template->data['tdate'] = date('d M, Y');
			$template->data['date_start'] = $date_from;
			$template->data['date_end'] = $date_to;
			$template->data['title'] = 'Owner Medicine Stock Report';
			$template->data['titleshead'] = 'Owner Medicine Stock Report';
			if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
				$template->data['base'] = HTTPS_SERVER;
			} else {
				$template->data['base'] = HTTP_SERVER;
			}
			$html = $template->fetch('report/medicine_stock_report_html.tpl');
			//echo $html;exit;
			$filename = "Owner_medicine_stock_report.html";
			header('Content-type: text/html');
			header('Content-Disposition: attachment; filename='.$filename);
			echo $html;
			exit;		
		} else {
			$this->session->data['warning'] = 'No Data Found';
			$this->redirect($this->url->link('report/medicine_stock_report', 'token=' . $this->session->data['token'].$url, 'SSL'));
		}
		
	}

	public function snippetdata(){
		$this->load->model('report/common_report');
		$this->model_report_common_report->snippetdata();
	}
}
?>
