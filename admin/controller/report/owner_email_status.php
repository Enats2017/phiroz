<?php    
class Controllerreportowneremailstatus extends Controller { 
	private $error = array();

	public function index() {
		$this->language->load('catalog/horse');

		$this->document->setTitle('Owner Email Status');

		$this->getList();
	}

	protected function getList() {

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

		if (isset($this->request->get['filter_type'])) {
			$filter_type = $this->request->get['filter_type'];
		} else {
			$filter_type = '';
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
			$filter_doctor = '';
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'id';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
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

		if (isset($this->request->get['filter_type'])) {
			$url .= '&filter_type=' . $this->request->get['filter_type'];
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

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
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
			'text'      => 'Owner Email Status',
			'href'      => $this->url->link('report/owner_email_status', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$type = array(
			'1' => 'Owner wise statement email',
			'2' => 'Owner statement',
			'3' => 'Owner cumulative statement',
			'4' => 'Owner weekly'
		);

		$this->data['types'] = $type;

		$data = array(
			'filter_date_start'	     	=> $filter_date_start, 
			'filter_date_end'	     	=> $filter_date_end, 
			'filter_name'            	=> $filter_name,
			'filter_name_id'         	=> $filter_name_id,
			'filter_type'          		=> $filter_type,
			'filter_doctor'          	=> $filter_doctor,
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * 50,
			'limit' => 50
		);

		$results = array();

		$this->load->model('report/common_report');
		$results = $this->model_report_common_report->get_owner_email_status($data);

		$email_total = $this->model_report_common_report->get_owner_email_total($data);

		$this->data['results'] = $results; 

		$this->data['token'] = $this->session->data['token'];	

		$this->data['heading_title'] = 'Owner Email Status';

		$this->data['text_no_results'] = $this->language->get('text_no_results');	

		$this->data['button_filter'] = $this->language->get('button_filter');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$this->load->model('bill/print_invoice');
		$doctors = $this->model_bill_print_invoice->getdoctors();
		$this->data['doctors'] = $doctors;

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
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

		if (isset($this->request->get['filter_type'])) {
			$url .= '&filter_type=' . $this->request->get['filter_type'];
		}

		if (isset($this->request->get['filter_name_id'])) {
			$url .= '&filter_name_id=' . $this->request->get['filter_name_id'];
		}

		if (isset($this->request->get['filter_doctor'])) {
			$url .= '&filter_doctor=' . $this->request->get['filter_doctor'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		$this->data['sort_name'] = $this->url->link('report/owner_email_status', 'token=' . $this->session->data['token'] . '&sort=owner_name' . $url, 'SSL');
		$this->data['sort_email'] = $this->url->link('report/owner_email_status', 'token=' . $this->session->data['token'] . '&sort=email' . $url, 'SSL');
		$this->data['sort_type'] = $this->url->link('report/owner_email_status', 'token=' . $this->session->data['token'] . '&sort=report_name' . $url, 'SSL');
		$this->data['sort_status'] = $this->url->link('report/owner_email_status', 'token=' . $this->session->data['token'] . '&sort=send_status' . $url, 'SSL');
		$this->data['sort_date'] = $this->url->link('report/owner_email_status', 'token=' . $this->session->data['token'] . '&sort=date' . $url, 'SSL');
		$this->data['sort_time'] = $this->url->link('report/owner_email_status', 'token=' . $this->session->data['token'] . '&sort=time' . $url, 'SSL');


		$pagination = new Pagination();
		$pagination->total = $email_total;
		$pagination->page = $page;
		$pagination->limit =  50;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('report/owner_email_status', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;
		$this->data['filter_date_start'] = $filter_date_start;		
		$this->data['filter_date_end'] = $filter_date_end;		
		$this->data['filter_name'] = $filter_name;
		$this->data['filter_type'] = $filter_type;
		$this->data['filter_name_id'] = $filter_name_id;
		$this->data['filter_doctor'] = $filter_doctor;

		$this->template = 'report/owner_email_status.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}
}
?>
