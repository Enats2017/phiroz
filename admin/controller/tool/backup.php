<?php 
class ControllerToolBackup extends Controller { 
	private $error = array();

	public function index() {		
		$this->language->load('tool/backup');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('tool/backup');

		if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->user->hasPermission('modify', 'tool/backup')) {
			if (is_uploaded_file($this->request->files['import']['tmp_name'])) {
				$content = file_get_contents($this->request->files['import']['tmp_name']);
			} else {
				$content = false;
			}

			if ($content) {
				$this->model_tool_backup->restore($content);

				$this->session->data['success'] = $this->language->get('text_success');

				$this->redirect($this->url->link('tool/backup', 'token=' . $this->session->data['token'], 'SSL'));
			} else {
				$this->error['warning'] = $this->language->get('error_empty');
			}
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_select_all'] = $this->language->get('text_select_all');
		$this->data['text_unselect_all'] = $this->language->get('text_unselect_all');

		$this->data['entry_restore'] = $this->language->get('entry_restore');
		$this->data['entry_backup'] = $this->language->get('entry_backup');

		$this->data['button_backup'] = $this->language->get('button_backup');
		$this->data['button_restore'] = $this->language->get('button_restore');
		$this->data['button_revert'] = $this->language->get('button_revert');

		if (isset($this->session->data['error'])) {
			$this->data['error_warning'] = $this->session->data['error'];

			unset($this->session->data['error']);
		} elseif (isset($this->error['warning'])) {
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

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),     		
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('tool/backup', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['restore'] = $this->url->link('tool/backup', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['backup'] = $this->url->link('tool/backup/backup', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['revert'] = $this->url->link('tool/backup/revert', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['tables'] = $this->model_tool_backup->getTables();

		$this->template = 'tool/backup.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function backup() {
		$this->language->load('tool/backup');

		if (!isset($this->request->post['backup'])) {
			$this->session->data['error'] = $this->language->get('error_backup');

			$this->redirect($this->url->link('tool/backup', 'token=' . $this->session->data['token'], 'SSL'));
		} elseif ($this->user->hasPermission('modify', 'tool/backup')) {
			// $this->response->addheader('Pragma: public');
			// $this->response->addheader('Expires: 0');
			// $this->response->addheader('Content-Description: File Transfer');
			// $this->response->addheader('Content-Type: application/octet-stream');
			// $this->response->addheader('Content-Disposition: attachment; filename=' . date('Y-m-d_H-i-s', time()).'_db_phiroz_backup.sql');
			// $this->response->addheader('Content-Transfer-Encoding: binary');

			//$this->load->model('tool/backup');
			exec('mysqldump --user=root --password="" --host=localhost db_horse_phiroz > "/var/www/html/phiroz/download/db_horse_phiroz_bk.sql" ');
			//sleep for 5 seconds			
			sleep(5);

			//start again
			//echo date('h:i:s');			
			//exit;
			
			$file = DIR_DOWNLOAD . '/db_horse_phiroz_bk.sql';
			$mask = '';//'db_attendance_bk.sql';

			if (!headers_sent()) {
				if (file_exists($file)) {
					header('Content-Type: application/octet-stream');
					header('Content-Description: File Transfer');
					header('Content-Disposition: attachment; filename="' . ($mask ? $mask : basename($file)) . '"');
					header('Content-Transfer-Encoding: binary');
					header('Expires: 0');
					header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
					header('Pragma: public');
					header('Content-Length: ' . filesize($file));

					readfile($file, 'rb');
					exit;
				} else {
					exit('Error: Could not find file ' . $file . '!');
				}
			} else {
				exit('Error: Headers already sent out!');
			}		
			//$this->response->setOutput($this->model_tool_backup->backup($this->request->post['backup']));
			//$this->redirect($this->url->link('tool/backup', 'token=' . $this->session->data['token'], 'SSL'));
		} else {
			$this->session->data['error'] = $this->language->get('error_permission');

			$this->redirect($this->url->link('tool/backup', 'token=' . $this->session->data['token'], 'SSL'));			
		}
	}

	public function revert() {
		$this->language->load('tool/backup');
		$this->load->model('tool/backup');

		if ($this->user->hasPermission('modify', 'tool/backup')) {
			/*
			$bill_owner_ids = $this->model_tool_backup->getbillowner_ids();
			foreach ($bill_owner_ids as $bokey => $bovalue) {
				$transaction_ids = $this->model_tool_backup->getbill_ids($bovalue['bill_id']);
				foreach ($transaction_ids as $tkey => $tvalue) {
					$this->model_tool_backup->delete_transaction($tvalue['transaction_id']);
				}
				$this->model_tool_backup->delete_bill($bovalue['bill_id']);
				$this->model_tool_backup->delete_bill_owner($bovalue['bill_id']);
				
			}
			$horse_owner_ids = $this->model_tool_backup->gethorseowner_ids();
			foreach ($horse_owner_ids as $hokey => $hovalue) {
				if($hovalue['horse_id'] != 0){
					$this->model_tool_backup->delete_horse($hovalue['horse_id']);
				}
				$this->model_tool_backup->delete_owner($hovalue['owner_id']);
			}
			$this->session->data['success'] = 'You are done with process';
			*/
			$this->redirect($this->url->link('tool/backup', 'token=' . $this->session->data['token'], 'SSL'));
			//echo 'out';exit;
		} else {
			$this->session->data['error'] = $this->language->get('error_permission');

			$this->redirect($this->url->link('tool/backup', 'token=' . $this->session->data['token'], 'SSL'));			
		}
	}
}
?>
