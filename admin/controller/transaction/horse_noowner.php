<?php
class ControllerTransactionHorseNoowner extends Controller { 
	public function index() {  
		$this->language->load('transaction/horse_noowner');

		$this->document->setTitle($this->language->get('heading_title'));

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		
		$url = '';

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
			'href'      => $this->url->link('transaction/horse_noowner', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$this->load->model('report/common_report');

		$this->data['treatedhorse'] = array();

		$data = array(
			'filter_date'	     	 => date('Y-m-d'), 
			'start'                  => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'                  => $this->config->get('config_admin_limit')
		);

		//$order_total = $this->model_report_common_report->getTotalTreatedhorsewithoutowner($data);
		$order_total = 0;

		$results = $this->model_report_common_report->getTreatedhorsewithoutowner($data);
		foreach ($results as $result) {
			$owner_data = $this->model_report_common_report->get_owner_data($result['horse_id']);
			$owner_exist = 0;
			foreach ($owner_data as $okey => $ovalue) {
				if($ovalue['share'] > 0){
					$owner_exist = 1;
					break;
				}
			}
			if($owner_exist == 0){
				$action = array();
				$action[] = array(
					'text' => $this->language->get('text_edit'),
					'href' => $this->url->link('catalog/horse/update', 'token=' . $this->session->data['token'] . '&horse_id=' . $result['horse_id'] . $url, 'SSL')
				);
				$horse_data = $this->model_report_common_report->get_horse_data($result['horse_id']);
				$trainer_name = $this->model_report_common_report->get_trainer_name($horse_data['trainer']);
				$horse_name = $this->model_report_common_report->get_horse_name($result['horse_id']);
				$this->data['treatedhorse'][] = array(
					'horse_id' => $result['horse_id'],
					'horse_name'     => $horse_name,
					'trainer_name'      => $trainer_name,
					'action'            => $action
				);
				$order_total ++;
			}
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
		$this->data['column_action'] = $this->language->get('column_action');
		
		$this->data['token'] = $this->session->data['token'];

		$url = '';

		$pagination = new Pagination();
		$pagination->total = $order_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('transaction/horse_noowner', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();		

		$this->template = 'transaction/horse_noowner.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}
}
?>
