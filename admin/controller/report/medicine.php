<?php
class ControllerReportMedicine extends Controller { 
	public function index() {  
		$this->language->load('report/medicine');

		$this->document->setTitle($this->language->get('heading_title'));

		if (isset($this->request->get['filter_date_start'])) {
			$filter_date_start = $this->request->get['filter_date_start'];
		} else {
			$filter_date_start = '2015-04-01';
		}

		if (isset($this->request->get['filter_date_end'])) {
			$filter_date_end = $this->request->get['filter_date_end'];
		} else {
			$filter_date_end = '2016-11-31';
		}

		if (isset($this->request->get['filter_surgery'])) {
			$filter_surgery = $this->request->get['filter_surgery'];
		} else {
			$filter_surgery = '1';
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

		if (isset($this->request->get['filter_surgery'])) {
			$url .= '&filter_surgery=' . $this->request->get['filter_surgery'];
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
			'href'      => $this->url->link('report/medicine', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$this->load->model('report/medicine');

		$this->data['medicine'] = array();

		$data = array(
			'filter_date_start'	     => $filter_date_start, 
			'filter_date_end'	     => $filter_date_end, 
			'filter_surgery'	     => $filter_surgery, 
			'start'                  => ($page - 1) * 7000,
			'limit'                  => 7000
		);

		$medicine_total = $this->model_report_medicine->getTotalMedicine($data);
		$results = $this->model_report_medicine->getMedicine($data);
		// echo '<pre>';
		// print_r($results);
		// exit;
		foreach($results as $rkey => $rvalue){
			//$is_surgery_sql = $this->db->query("SELECT `is_surgery` FROM `oc_medicine` WHERE `medicine_id` = '".$rvalue['medicine_id']."' ")->row['is_surgery'];
			//echo $is_surgery_sql;exit;
			//if($is_surgery_sql == '1'){
			$results[$rkey]['horse_name'] = $this->db->query("SELECT `name` FROM `oc_horse` WHERE `horse_id` = '".$rvalue['horse_id']."' ")->row['name'];
			//} else {
				//unset($results[$rkey]);
				//$medicine_total = $medicine_total - 1;
			//}
		}


		$this->data['results'] = $results;

		$this->data['is_surgerys'] = array(
			//'0' => 'All',
			'1' => 'Yes',
		);

		if(isset($this->session->data['warning'])){
			$this->data['error_warning'] = $this->session->data['warning'];
			unset($this->session->data['warning']);
		} else {
			$this->data['error_warning'] = '';
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_all_status'] = $this->language->get('text_all_status');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_price'] = $this->language->get('column_price');
		$this->data['column_quantity'] = $this->language->get('column_quantity');
		$this->data['column_total'] = $this->language->get('column_total');
			
		$this->data['entry_date_start'] = $this->language->get('entry_date_start');
		$this->data['entry_date_end'] = $this->language->get('entry_date_end');
		
		$this->data['button_filter'] = $this->language->get('button_filter');

		$this->data['token'] = $this->session->data['token'];
		
		$url = '';

		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}

		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}

		if (isset($this->request->get['filter_surgery'])) {
			$url .= '&filter_surgery=' . $this->request->get['filter_surgery'];
		}

		$pagination = new Pagination();
		$pagination->total = $medicine_total;
		$pagination->page = $page;
		$pagination->limit = 7000;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('report/medicine', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();		

		$this->data['filter_date_start'] = $filter_date_start;
		$this->data['filter_date_end'] = $filter_date_end;		
		$this->data['filter_surgery'] = $filter_surgery;		
		
		$this->template = 'report/medicine.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function export() {  
		$this->language->load('report/medicine');

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

		if (isset($this->request->get['filter_surgery'])) {
			$filter_surgery = $this->request->get['filter_surgery'];
		} else {
			$filter_surgery = '';
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

		if (isset($this->request->get['filter_surgery'])) {
			$url .= '&filter_surgery=' . $this->request->get['filter_surgery'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->load->model('report/medicine');

		$this->data['medicine'] = array();

		$data = array(
			'filter_date_start'	     => $filter_date_start, 
			'filter_date_end'	     => $filter_date_end, 
			'filter_surgery'	     => $filter_surgery, 
			'start'                  => ($page - 1) * 7000,
			'limit'                  => 7000
		);

		$medicine_total = $this->model_report_medicine->getTotalMedicine($data);
		$results = $this->model_report_medicine->getMedicine($data);
		// echo '<pre>';
		// print_r($results);
		// exit;
		foreach($results as $rkey => $rvalue){
			$results[$rkey]['horse_name'] = $this->db->query("SELECT `name` FROM `oc_horse` WHERE `horse_id` = '".$rvalue['horse_id']."' ")->row['name'];
		}
		$this->data['results'] = $results;

		$this->data['is_surgerys'] = array(
			//'0' => 'All',
			'1' => 'Yes',
		);

		if($results){
			//$month = date("F", mktime(0, 0, 0, $filter_month, 10));
			$template = new Template();		
			$template->data['results'] = $results;
			$template->data['date_start'] = $filter_date_start;
			$template->data['date_end'] = $filter_date_end;
			$template->data['title'] = 'Medicine Report';
			if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
				$template->data['base'] = HTTPS_SERVER;
			} else {
				$template->data['base'] = HTTP_SERVER;
			}
			$html = $template->fetch('report/medicine_html.tpl');
			//echo $html;exit;
			$filename = "Medicine_Report.html";
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
			$this->redirect($this->url->link('report/medicine', 'token=' . $this->session->data['token'].$url, 'SSL'));
		}
	}
	
}
?>
