<?php
class ControllerToolRevertTool extends Controller { 
	public function index() {  
		$this->language->load('tool/revert_tool');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),       		
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('tool/revert_tool', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$this->load->model('bill/print_invoice');

		if(isset($this->session->data['success'])){
			$this->data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$this->data['heading_title'] = $this->language->get('heading_title');
		
		
		$this->data['entry_delete'] = $this->language->get('entry_delete');
		$this->data['button_delete'] = $this->language->get('button_delete');
		

		$this->data['token'] = $this->session->data['token'];

		if(isset($this->session->data['warning'])){
			$this->data['error_warning'] = $this->session->data['warning'];
			unset($this->session->data['warning']);
		} else {
			$this->data['error_warning'] = '';
		}

		$this->template = 'tool/revert_tool.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function cancel(){
		$this->language->load('tool/cancel_bill');
		$this->load->model('bill/print_invoice');

		$this->document->setTitle($this->language->get('heading_title'));
		$this->model_bill_print_invoice->updatebillstatus($filter_bill_id);

		
		$this->session->data['success'] = 'Success: You are Done with the process!';
		$this->redirect($this->url->link('tool/revert_tool', 'token=' . $this->session->data['token'] . $url, 'SSL'));
	}
}
?>
