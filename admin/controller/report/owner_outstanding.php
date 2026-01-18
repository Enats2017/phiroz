<?php
include '../mailin/Mailin.php';
class ControllerReportOwneroutstanding extends Controller { 
	public function index() {  
		$this->language->load('report/owner_outstanding');

		$this->document->setTitle($this->language->get('heading_title'));

		

		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = '';
		}

		if (isset($this->request->get['filter_once'])) {
			$filter_once = $this->request->get['filter_once'];
		} else {
			$filter_once = '' ;
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


		$url = '';

		

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}

		if (isset($this->request->get['filter_once'])) {
			$url .= '&filter_once=' . $this->request->get['filter_once'];
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
			'filter_name'            => $filter_name,
			'filter_name_id'         => $filter_name_id,
			'filter_doctor'          => $filter_doctor,
			'filter_email'          => $filter_email,
			'filter_once'          => $filter_once,
		);

		$order_total = 0;
		//$bill_ids_array = array();
		$final_data = array();

		//echo $this->request->get['filter_once'];exit;
		$this->data['owner_datas'] = array();

		if (isset($this->request->get['filter_once'])) {

			//echo "in";exit;

			$sql = "SELECT `owner_id`, `outstandingamount_ptk`, `outstandingamount_lmf`, `name` FROM `oc_owner` WHERE 1=1 ";

			if (!empty($data['filter_name_id'])) {
			$sql .= " AND `owner_id` = '" . $this->db->escape($data['filter_name_id']) . "'";
		    }
        
		        //echo $sql;exit;
				$owner_datas = $this->db->query($sql);
				$owner_datas = $owner_datas->rows;
		
			foreach($owner_datas as $key){
				$sql = "SELECT * FROM `oc_bill_owner` WHERE owner_id = '".$key['owner_id']."' AND doctor_id = '1' AND ((month > 7 AND year = '2017') OR (year >= '2018'))";
				$datas = $this->db->query($sql); 
				$billamount_ptk = 0;
				if($datas->num_rows > 0){
					foreach ($datas->rows as $data1 => $value) {
						$billamount_ptk = $billamount_ptk + $value['owner_amt'] - $value['owner_amt_rec'];
					}
				}

				$datas1 = $this->db->query("SELECT * FROM `oc_bill_owner` WHERE owner_id = '".$key['owner_id']."' AND doctor_id = '2' AND ((month > 7 AND year = '2017') OR (year >= '2018'))");
				$billamount_lmf = 0;
				if($datas1->num_rows > 0){
					foreach ($datas1->rows as $data2 => $value) {
						$billamount_lmf = $billamount_lmf + $value['owner_amt'] - $value['owner_amt_rec'];
					}
				}
				//echo "in";exit;
				$total = $key['outstandingamount_ptk'] + $key['outstandingamount_lmf'] + $billamount_ptk + $billamount_lmf ;
				// echo $total;
				// exit;
				if ($total>0) {
					$action = array();

					$action[] = array(
						'text' => "Send Mail PTK",
						'href' => $this->url->link('report/owner_outstanding/sendemail', 'token=' . $this->session->data['token'] . '&owner_id=' . $key['owner_id'] . $url.'&doctor_id=1', 'SSL')
					);
					$action[] = array(
						'text' => "Send Mail LMF",
						'href' => $this->url->link('report/owner_outstanding/sendemail', 'token=' . $this->session->data['token'] . '&owner_id=' . $key['owner_id'] . $url.'&doctor_id=2', 'SSL')
					);

					// echo "<pre>";
					// print_r($action);
					// exit;

					$this->data['owner_datas'][] = array(
						'name' => $key['name'],
						'outamutptk' => $key['outstandingamount_ptk'],
						'outamutlmf' => $key['outstandingamount_lmf'],
						'billamount_ptk' => $billamount_ptk,
						'billamount_lmf' => $billamount_lmf,
						'action' => $action,
						'total'      => $total
		             );
				}
			}
	    }
		//$final_data = array();
		//$this->data['owner_datas'] = $owner_data;
		// echo '<pre>';
		// print_r($this->data['owner_datas']);
		// exit;
		

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
		$this->data['doctors'] = $doctors;

		$url = '';

		if (isset($this->request->get['filter_month'])) {
			$url .= '&filter_month=' . $this->request->get['filter_month'];
		}

		if (isset($this->request->get['filter_year'])) {
			$url .= '&filter_year=' . $this->request->get['filter_year'];
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

		if (isset($this->request->get['filter_once'])) {
			$url .= '&filter_once=' . $this->request->get['filter_once'];
		}		

		$pagination = new Pagination();
		$pagination->total = $order_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('report/trainer_wise_statement', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();		

		$this->data['filter_name'] = $filter_name;
		$this->data['filter_name_id'] = $filter_name_id;
		$this->data['filter_doctor'] = $filter_doctor;
		$this->data['filter_email'] = $filter_email;
		$this->data['filter_once'] = $filter_once;
		$this->template = 'report/owner_outstanding.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	

	public function sendemail(){
		date_default_timezone_set('Asia/Kolkata');

		$sql = "SELECT * FROM `oc_owner` WHERE `owner_id`= '".$this->request->get['owner_id']."'";
		$owner_datas = $this->db->query($sql, $this->conn);
		$owner_datas = $owner_datas->rows;

		$owneramount = 0;
		$billamount = 0;
		$amount = 0;
		// echo $amount;exit;
		foreach($owner_datas as $key){
			//$key['email'] = 'piyushpanchal004@gmail.com';
			//echo $this->request->get['doctor_id'];exit;
			$datas = $this->db->query("SELECT * FROM `oc_bill_owner` WHERE owner_id = '".$key['owner_id']."' AND doctor_id = '".$this->request->get['doctor_id']."' AND ((month > 7 AND year = '2017') OR (year >= '2018'))", $this->conn);
			//echo "SELECT * FROM `oc_bill_owner` WHERE owner_id = '".$key['owner_id']."' AND doctor_id ='".$this->request->get['doctor_id']."' AND (month > 7 AND year = '2017') OR (year >= '2018')";
			// echo "<pre>";
			// print_r($datas);
			//echo $key['outstandingamount_ptk'];
			//exit;
			if($datas->num_rows > 0){
				$billamount = 0;
				$amount = 0;

				if ($this->request->get['doctor_id'] == 1) {
					$owneramount = $key['outstandingamount_ptk'];
					//echo $owneramount;exit;
				}else{
					$owneramount = $key['outstandingamount_lmf'];
				}
				
				foreach ($datas->rows as $data => $value) {

					$billamount = $billamount + $value['owner_amt'] - $value['owner_amt_rec'];
				}

				$amount = $amount + $owneramount + $billamount;
				// echo $amount;exit;
				$message = "<p style='margin-left:200px;'>Outstanding Statement</p><p style='margin-left:50px;'>This a reminder email that your account balance of Rs.".$amount."&nbsp;was overdue as of&nbsp;".date('d-m-Y').".<br>Enclosed is a statement of account for your reference.<br><br>Please arrange  payment of this account as soon as possible.<br><br>Your prompt attention to this matter would be greatly appreciated. If you have any queries <br>regarding this account, please contact Vaibhavi Telang on 9637445879 or Anil Pawar on <br>7718024903 as soon as possible.<br><br>if payment has recently been made, please let us know the mode and date of payment so<br>we can trace the payment and rectify our accounts accordingly.<br><br>Regards,<br>Phiroz</p>";

				if($amount > '0'){
					$mailin = new Mailin('phiroz2017@gmail.com', 'bVN07jDRW85tLAJH');
					$mailin->
					addTo($key['email'], '')->
					setFrom('phiroz2017@gmail.com', 'Phiroz Khambatta')->
					setReplyTo('phiroz2017@gmail.com','Phiroz Khambatta')->
					setSubject('Enter the subject here')->
					setText($message);
					$res = $mailin->send();
					$status = json_decode($res,true);
					// echo"<pre>";
					// print_r($status);
					// exit;
					if($status['result'] == '1'){
						$this->db->query("INSERT INTO oc_email_info SET
											owner_id = '".$key['owner_id']."',
											owner_name = '".$this->db->escape($key['name'])."',
											owner_email = '".$key['email']."',
											report_type = '4',
											report_name = 'Manual Owner Email',
											doctor_id = '".$datas->row['doctor_id']."',
											send_status = '1',
											date = '".date('Y-m-d')."',
											time = '".date('h:i:s')."'
										",$this->conn);
						$this->session->data['success'] = 'Mail Send';
						// echo 'Mail Send';
					}else{
						$this->session->data['warning'] = 'Mail Cannot be Send';
						$this->db->query("INSERT INTO oc_email_info SET
											owner_id = '".$key['owner_id']."',
											owner_name = '".$this->db->escape($key['name'])."',
											owner_email = '".$key['email']."',
											report_type = '4',
											report_name = 'Manual Owner Email',
											doctor_id = '".$datas->row['doctor_id']."',
											send_status = '0',
											date = '".date('Y-m-d')."',
											time = '".date('h:i:s')."'
										",$this->conn);
						// echo 'Mail Cannot be Send';	
					}
			$this->redirect($this->url->link('report/owner_outstanding', 'token=' . $this->session->data['token'].$url, 'SSL'));

				}
			}
		}
		$this->template = 'report/owner_outstanding.tpl';
	}

}
?>
