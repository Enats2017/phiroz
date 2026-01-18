<?php  
class ControllerCommonLogin extends Controller { 
	private $error = array();

	public function index() { 
		$this->language->load('common/login');


			$this->language->load('common/footer');
			$this->data['text_footer'] = sprintf($this->language->get('text_footer'), VERSION);
			
		$this->document->setTitle($this->language->get('heading_title'));

		if ($this->user->isLogged() && isset($this->request->get['token']) && ($this->request->get['token'] == $this->session->data['token'])) {
			$this->redirect($this->url->link('catalog/employee', 'token=' . $this->session->data['token'], 'SSL'));
		}

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) { 
			$this->session->data['token'] = md5(mt_rand());
			if(isset($this->session->data['is_dept']) && $this->session->data['is_dept'] == '1'){
				$emp_code = $this->session->data['d_emp_id'];
				$is_set = $this->db->query("SELECT `is_set` FROM `oc_employee` WHERE `emp_code` = '".$emp_code."' ")->row['is_set'];	
				if($is_set == '1'){
					$this->redirect($this->url->link('transaction/leave_ess_dept', 'token=' . $this->session->data['token'], 'SSL'));
				} else {
					$this->redirect($this->url->link('user/password_change', 'token=' . $this->session->data['token'].'&emp_code='.$emp_code, 'SSL'));
				}
			} elseif(isset($this->session->data['is_user'])){
				$emp_code = $this->session->data['emp_code'];
				$is_set = $this->db->query("SELECT `is_set` FROM `oc_employee` WHERE `emp_code` = '".$emp_code."' ")->row['is_set'];	
				if($is_set == '1'){
					$this->redirect($this->url->link('catalog/employee', 'token=' . $this->session->data['token'], 'SSL'));
					//$this->redirect($this->url->link('transaction/leave_ess', 'token=' . $this->session->data['token'], 'SSL'));
				} else {
					$this->redirect($this->url->link('user/password_change', 'token=' . $this->session->data['token'].'&emp_code='.$emp_code, 'SSL'));
				}
			} elseif(isset($this->session->data['is_super']) || isset($this->session->data['is_super1'])){
				$this->redirect($this->url->link('transaction/leave_ess_dept', 'token=' . $this->session->data['token'], 'SSL'));
			} else {
				if (isset($this->request->post['redirect']) && (strpos($this->request->post['redirect'], HTTP_SERVER) === 0 || strpos($this->request->post['redirect'], HTTPS_SERVER) === 0 )) {
					$this->redirect($this->request->post['redirect'] . '&token=' . $this->session->data['token']);
				} else {
					$this->redirect($this->url->link('catalog/employee', 'token=' . $this->session->data['token'], 'SSL'));
				}
			}
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_login'] = $this->language->get('text_login');
		$this->data['text_forgotten'] = $this->language->get('text_forgotten');

		$this->data['entry_username'] = $this->language->get('entry_username');
		$this->data['entry_password'] = $this->language->get('entry_password');

		$this->data['button_login'] = $this->language->get('button_login');

		if ((isset($this->session->data['token']) && !isset($this->request->get['token'])) || ((isset($this->request->get['token']) && (isset($this->session->data['token']) && ($this->request->get['token'] != $this->session->data['token']))))) {
			$this->error['warning'] = $this->language->get('error_token');
		}

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

		$this->data['action'] = $this->url->link('common/login', '', 'SSL');

		if (isset($this->request->post['username'])) {
			$this->data['username'] = $this->request->post['username'];
		} else {
			$this->data['username'] = '';
		}

		if (isset($this->request->post['password'])) {
			$this->data['password'] = $this->request->post['password'];
		} else {
			$this->data['password'] = '';
		}

		if (isset($this->request->get['route'])) {
			$route = $this->request->get['route'];

			unset($this->request->get['route']);

			if (isset($this->request->get['token'])) {
				unset($this->request->get['token']);
			}

			$url = '';

			if ($this->request->get) {
				$url .= http_build_query($this->request->get);
			}

			$this->data['redirect'] = $this->url->link($route, $url, 'SSL');
		} else {
			$this->data['redirect'] = '';	
		}

		if ($this->config->get('config_password')) {
			$this->data['forgotten'] = $this->url->link('common/forgotten', '', 'SSL');
		} else {
			$this->data['forgotten'] = '';
		}

		
			$this->template = 'admin_theme/base5builder_impulsepro/common/login.tpl';
			
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validate() {
		if (!isset($this->request->post['username']) || !isset($this->request->post['password']) || !$this->user->login($this->request->post['username'], $this->request->post['password'])) {
			$this->error['warning'] = $this->language->get('error_login');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}  
?>