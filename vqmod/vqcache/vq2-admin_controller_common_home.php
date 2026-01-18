<?php   
class ControllerCommonHome extends Controller {   
	public function index() {

		if(isset($this->session->data['is_dept']) && $this->session->data['is_dept'] == '1'){
			$this->redirect($this->url->link('transaction/leave_ess_dept', 'token=' . $this->session->data['token'], 'SSL'));
		} elseif(isset($this->session->data['is_user'])){
			$this->redirect($this->url->link('catalog/employee', 'token=' . $this->session->data['token'], 'SSL'));
			//$this->redirect($this->url->link('transaction/leave_ess', 'token=' . $this->session->data['token'], 'SSL'));
		} elseif(isset($this->session->data['is_super']) || isset($this->session->data['is_super1'])){
			$this->redirect($this->url->link('transaction/leave_ess_dept', 'token=' . $this->session->data['token'], 'SSL'));
		}

		
			$this->language->load('common/header');
			$this->language->load('common/home');
			$this->data['text_front'] = $this->language->get('text_front');
			$this->data['text_logout'] = $this->language->get('text_logout');
			$this->data['text_total_sales_previous_years'] = $this->language->get('text_total_sales_previous_years');
			$this->data['text_other_stats'] = $this->language->get('text_other_stats');
			
			$this->data['text_total_review'] = $this->language->get('text_total_review');

			$this->data['stores'] = array();
			
			$this->load->model('setting/store');
			
			$results = $this->model_setting_store->getStores();
			
			foreach ($results as $result) {
				$this->data['stores'][] = array(
					'name' => $result['name'],
					'href' => $result['url']
				);
			}

			$this->data['store'] = HTTP_CATALOG;
			

		$this->document->setTitle($this->language->get('heading_title'));

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_overview'] = $this->language->get('text_overview');
		$this->data['text_statistics'] = $this->language->get('text_statistics');
		$this->data['text_latest_10_orders'] = $this->language->get('text_latest_10_orders');
		$this->data['text_total_sale'] = $this->language->get('text_total_sale');
		$this->data['text_total_sale_year'] = $this->language->get('text_total_sale_year');
		$this->data['text_total_order'] = $this->language->get('text_total_order');
		$this->data['text_total_customer'] = $this->language->get('text_total_customer');
		$this->data['text_total_customer_approval'] = $this->language->get('text_total_customer_approval');
		$this->data['text_total_review_approval'] = $this->language->get('text_total_review_approval');
		$this->data['text_total_affiliate'] = $this->language->get('text_total_affiliate');
		$this->data['text_total_affiliate_approval'] = $this->language->get('text_total_affiliate_approval');
		$this->data['text_day'] = $this->language->get('text_day');
		$this->data['text_week'] = $this->language->get('text_week');
		$this->data['text_month'] = $this->language->get('text_month');
		$this->data['text_year'] = $this->language->get('text_year');
		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['text_total_horses'] = $this->language->get('text_total_horses');
		$this->data['text_total_trainer'] = $this->language->get('text_total_trainer');
		$this->data['text_total_owner'] = $this->language->get('text_total_owner');
		$this->data['text_total_medicine'] = $this->language->get('text_total_medicine');

		$this->data['button_search'] = $this->language->get('button_search');


		$this->data['column_sr_no'] = $this->language->get('column_sr_no');
		$this->data['column_horse_name'] = $this->language->get('column_horse_name');
		$this->data['column_trainer'] = $this->language->get('column_trainer');
		$this->data['column_date'] = $this->language->get('column_date');
		$this->data['column_medicine'] = $this->language->get('column_medicine');
		$this->data['column_total'] = $this->language->get('column_total');

		$this->data['column_order'] = $this->language->get('column_order');
		$this->data['column_customer'] = $this->language->get('column_customer');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_date_added'] = $this->language->get('column_date_added');
		$this->data['column_total'] = $this->language->get('column_total');
		$this->data['column_firstname'] = $this->language->get('column_firstname');
		$this->data['column_lastname'] = $this->language->get('column_lastname');
		$this->data['column_action'] = $this->language->get('column_action');

		$this->data['entry_range'] = $this->language->get('entry_range');

		// Check install directory exists
		if (is_dir(dirname(DIR_APPLICATION) . '/install')) {
			$this->data['error_install'] = $this->language->get('error_install');
		} else {
			$this->data['error_install'] = '';
		}

		// Check image directory is writable
		$file = DIR_IMAGE . 'test';

		$handle = fopen($file, 'a+'); 

		fwrite($handle, '');

		fclose($handle); 		

		if (!file_exists($file)) {
			$this->data['error_image'] = sprintf($this->language->get('error_image'), DIR_IMAGE);
		} else {
			$this->data['error_image'] = '';

			unlink($file);
		}

		// Check image cache directory is writable
		$file = DIR_IMAGE . 'cache/test';

		$handle = fopen($file, 'a+'); 

		fwrite($handle, '');

		fclose($handle); 		

		if (!file_exists($file)) {
			$this->data['error_image_cache'] = sprintf($this->language->get('error_image_cache'), DIR_IMAGE . 'cache/');
		} else {
			$this->data['error_image_cache'] = '';

			unlink($file);
		}

		// Check cache directory is writable
		$file = DIR_CACHE . 'test';

		$handle = fopen($file, 'a+'); 

		fwrite($handle, '');

		fclose($handle); 		

		if (!file_exists($file)) {
			$this->data['error_cache'] = sprintf($this->language->get('error_image_cache'), DIR_CACHE);
		} else {
			$this->data['error_cache'] = '';

			unlink($file);
		}

		// Check download directory is writable
		$file = DIR_DOWNLOAD . 'test';

		$handle = fopen($file, 'a+'); 

		fwrite($handle, '');

		fclose($handle); 		

		if (!file_exists($file)) {
			$this->data['error_download'] = sprintf($this->language->get('error_download'), DIR_DOWNLOAD);
		} else {
			$this->data['error_download'] = '';

			unlink($file);
		}

		// Check logs directory is writable
		$file = DIR_LOGS . 'test';

		$handle = fopen($file, 'a+'); 

		fwrite($handle, '');

		fclose($handle); 		

		if (!file_exists($file)) {
			$this->data['error_logs'] = sprintf($this->language->get('error_logs'), DIR_LOGS);
		} else {
			$this->data['error_logs'] = '';

			unlink($file);
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['token'] = $this->session->data['token'];

		$this->load->model('sale/order');
		$this->data['total_sale'] = 0;//$this->currency->format($this->model_sale_order->getTotalSales(), $this->config->get('config_currency'));
		$this->data['total_sale_year'] = 0;//$this->currency->format($this->model_sale_order->getTotalSalesByYear(date('Y')), $this->config->get('config_currency'));
		$this->data['total_order'] = 0;//$this->model_sale_order->getTotalOrders();

			$this->data['total_sale_raw'] = 0;//$this->model_sale_order->getTotalSales();
			$this->data['total_sale_year_raw'] = 0;//$this->model_sale_order->getTotalSalesByYear(date('Y'));
			$this->data['total_sales_previous_years_raw'] = 0;//$this->data['total_sale_raw'] - $this->data['total_sale_year_raw'];
			$this->data['total_sales_previous_years'] = 0;//$this->currency->format($this->data['total_sale_raw'] - $this->data['total_sale_year_raw'], $this->config->get('config_currency'));
			

		$this->data['total_horses'] = 0;//$this->model_sale_order->getTotalHorses();
		$this->data['total_trainer'] = 0;//$this->model_sale_order->gettotalTrainer();
		$this->data['total_owner'] = 0;//$this->model_sale_order->getTotalOwner();
		$this->data['total_medicine'] = 0;//$this->model_sale_order->getTotalMedicine();
		
		$total_treatment = 0;//$this->model_sale_order->getTotalSales();
		$total_amount_recovered = 0;//$this->model_sale_order->getTotalSales_received();
		$total_amount_balance = 0;//$total_treatment - $total_amount_recovered;
		
		$this->data['total_treatment'] = 0;//$this->currency->format($total_treatment, $this->config->get('config_currency'));
		$this->data['total_amount_recovered'] = 0;//$this->currency->format($total_amount_recovered, $this->config->get('config_currency'));
		$this->data['total_amount_balance'] = 0;//$this->currency->format($total_amount_balance, $this->config->get('config_currency'));

		$this->data['total_treatment_raw'] = 0;//$total_treatment;
		$this->data['total_amount_recovered_raw'] = 0;//$total_amount_recovered;
		$this->data['total_amount_balance_raw'] = 0;//$total_amount_balance;

		$this->load->model('sale/customer');

		$this->data['total_customer'] = 0;//$this->model_sale_customer->getTotalCustomers();
		$this->data['total_customer_approval'] = 0;//$this->model_sale_customer->getTotalCustomersAwaitingApproval();

		$this->load->model('catalog/review');

		$this->data['total_review'] = 0;//$this->model_catalog_review->getTotalReviews();
		$this->data['total_review_approval'] = 0;//$this->model_catalog_review->getTotalReviewsAwaitingApproval();

		$this->load->model('sale/affiliate');
		$this->load->model('report/common_report');
		$this->load->model('report/attendance');
		$this->data['total_affiliate'] = 0;//$this->model_sale_affiliate->getTotalAffiliates();
		$this->data['total_affiliate_approval'] = 0;//$this->model_sale_affiliate->getTotalAffiliatesAwaitingApproval();

		$this->data['orders'] = array(); 

		$data = array(
			'start' => 0,
			'limit' => 10
		);

		if(isset($this->session->data['warning'])){
			$this->data['error_warning'] = $this->session->data['warning'];
			unset($this->session->data['warning']);
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$results = $this->model_report_attendance->getTodaysAttendance_new($data);
		$this->data['results'] = $results;

		//$results = $this->model_sale_order->getTransaction($data);
		// foreach ($results as $result) {
		// 	$horse_data = $this->model_report_common_report->get_horse_data($result['horse_id']);
		// 	if(isset($horse_data['horse_id'])){
		// 		$trainer_name = $this->model_report_common_report->get_trainer_name($horse_data['trainer']);
		// 		$horse_name = $this->model_report_common_report->get_horse_name($result['horse_id']);
		// 		$action = array();

		// 		$action[] = array(
		// 			'text' => $this->language->get('text_view'),
		// 			'href' => $this->url->link('transaction/horse_wise/info', 'token=' . $this->session->data['token'] . '&transaction_id=' . $result['transaction_id'], 'SSL')
		// 		);

		// 		$this->data['orders'][] = array(
		// 			'transaction_id'   => $result['transaction_id'],
		// 			'horse_name'   => $horse_name,
		// 			'trainer_name'     => $trainer_name,
		// 			'dot' => $result['dot'],
		// 			'medicine_name'   => $result['medicine_name'],
		// 			'medicine_total'      => $this->currency->format($result['medicine_total'], 'INR', 1.00000),
		// 			'action'     => $action
		// 		);
		// 	}
		// }
		$this->data['refresh'] = $this->url->link('transaction/transaction/generate_today', 'token=' . $this->session->data['token'].'&home=1', 'SSL');
		
		// $this->data['total_employees_mumbai'] = $this->model_sale_order->getTotalemployees('Unit 31');
		// $this->data['total_employees_pune'] = $this->model_sale_order->getTotalemployees('Unit 64');
		// $this->data['total_employees_delhi'] = $this->model_sale_order->getTotalemployees('Delhi');
		// $this->data['total_employees_chennai'] = $this->model_sale_order->getTotalemployees('Chennai');
		// $this->data['total_employees_bangalore'] = $this->model_sale_order->getTotalemployees('Bangalore');
		// $this->data['total_employees_ahmedabad'] = $this->model_sale_order->getTotalemployees('Ahmedabad');


		// $this->data['total_employees_present_mumbai'] = $this->model_sale_order->getTotalemployeespresent_new('Unit 31');
		// $this->data['total_employees_present_pune'] = $this->model_sale_order->getTotalemployeespresent_new('Unit 64');
		// $this->data['total_employees_present_delhi'] = $this->model_sale_order->getTotalemployeespresent_new('Delhi');
		// $this->data['total_employees_present_chennai'] = $this->model_sale_order->getTotalemployeespresent_new('Chennai');
		// $this->data['total_employees_present_bangalore'] = $this->model_sale_order->getTotalemployeespresent_new('Bangalore');
		// $this->data['total_employees_present_ahmedabad'] = $this->model_sale_order->getTotalemployeespresent_new('Ahmedabad');

		// $this->data['total_employees_absent_mumbai'] = $this->data['total_employees_mumbai'] - $this->data['total_employees_present_mumbai']; 
		// $this->data['total_employees_absent_pune'] = $this->data['total_employees_pune'] - $this->data['total_employees_present_pune']; 
		// $this->data['total_employees_absent_delhi'] = $this->data['total_employees_delhi'] - $this->data['total_employees_present_delhi']; 
		// $this->data['total_employees_absent_chennai'] = $this->data['total_employees_chennai'] - $this->data['total_employees_present_chennai']; 
		// $this->data['total_employees_absent_bangalore'] = $this->data['total_employees_bangalore'] - $this->data['total_employees_present_bangalore']; 
		// $this->data['total_employees_absent_ahmedabad'] = $this->data['total_employees_ahmedabad'] - $this->data['total_employees_present_ahmedabad']; 

		
		// $this->data['day_close_mumbai'] = $this->model_sale_order->getclosedate('Mumbai');
		// $this->data['day_close_pune'] = $this->model_sale_order->getclosedate('Pune');
		// $this->data['day_close_delhi'] = $this->model_sale_order->getclosedate('Delhi');
		// $this->data['day_close_chennai'] = $this->model_sale_order->getclosedate('Chennai');
		// $this->data['day_close_bangalore'] = $this->model_sale_order->getclosedate('Bangalore');
		// $this->data['day_close_ahmedabad'] = $this->model_sale_order->getclosedate('Ahmedabad');

		// $this->data['month_close_mumbai'] = $this->model_sale_order->getmonthclosedate('Mumbai');
		// $this->data['month_close_pune'] = $this->model_sale_order->getmonthclosedate('Pune');
		// $this->data['month_close_delhi'] = $this->model_sale_order->getmonthclosedate('Delhi');
		// $this->data['month_close_chennai'] = $this->model_sale_order->getmonthclosedate('Chennai');
		// $this->data['month_close_bangalore'] = $this->model_sale_order->getmonthclosedate('Bangalore');
		// $this->data['month_close_ahmedabad'] = $this->model_sale_order->getmonthclosedate('Ahmedabad');
	
		$sql = "SELECT * FROM `oc_unit` WHERE 1=1";
		if($this->user->getUserGroupId() != 1 && $this->user->getUnitId() != '0'){
			$sql .= " AND `unit_id` = '".$this->user->getUnitId()."' ";
		}
		$locations = $this->db->query($sql)->rows;
		$total_employees = 0;
		$total_employees_present = 0;
		$total_employees_absent = 0;
		foreach($locations as $lkey => $lvalue){
			$locations[$lkey]['total_employees'] = $this->model_sale_order->getTotalemployees($lvalue['unit_id']);
			$locations[$lkey]['total_employees_present'] = $this->model_sale_order->getTotalemployeespresent_new($lvalue['unit_id']);
			$locations[$lkey]['total_employees_absent'] = $locations[$lkey]['total_employees'] - $locations[$lkey]['total_employees_present']; 
			$locations[$lkey]['day_close'] = '';//$this->model_sale_order->getclosedate($lvalue['unit']);
			$locations[$lkey]['month_close'] = '';//$this->model_sale_order->getmonthclosedate($lvalue['unit']);
			
			$total_employees = $total_employees + $locations[$lkey]['total_employees'];
			$total_employees_present = $total_employees_present + $locations[$lkey]['total_employees_present'];
			$total_employees_absent = $total_employees_absent + $locations[$lkey]['total_employees_absent'];
		}
		// echo '<pre>';
		// print_r($locations);
		// exit;
		$this->data['locations'] = $locations;
		$this->data['total_employees'] = $total_employees;
		$this->data['total_employees_present'] = $total_employees_present;
		$this->data['total_employees_absent'] = $total_employees_absent;
		

		if ($this->config->get('config_currency_auto')) {
			$this->load->model('localisation/currency');

			//$this->model_localisation_currency->updateCurrencies();
		}

		
			$this->template = 'admin_theme/base5builder_impulsepro/common/home.tpl';
			
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function chart() {
		
			$this->language->load('common/header');
			$this->language->load('common/home');
			$this->data['text_front'] = $this->language->get('text_front');
			$this->data['text_logout'] = $this->language->get('text_logout');
			$this->data['text_total_sales_previous_years'] = $this->language->get('text_total_sales_previous_years');
			$this->data['text_other_stats'] = $this->language->get('text_other_stats');
			
			$this->data['text_total_review'] = $this->language->get('text_total_review');

			$this->data['stores'] = array();
			
			$this->load->model('setting/store');
			
			$results = $this->model_setting_store->getStores();
			
			foreach ($results as $result) {
				$this->data['stores'][] = array(
					'name' => $result['name'],
					'href' => $result['url']
				);
			}

			$this->data['store'] = HTTP_CATALOG;
			

		$data = array();

		$data['order'] = array();
		$data['customer'] = array();
		$data['xaxis'] = array();

		$data['order']['label'] = 'Total Horses';
		$data['customer']['label'] = 'Total Treatment';

		if (isset($this->request->get['range'])) {
			$range = $this->request->get['range'];
		} else {
			$range = 'month';
		}

		switch ($range) {
			case 'day':
				for ($i = 0; $i < 24; $i++) {
					$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "transaction` WHERE (DATE(dot) = DATE(NOW()) AND HOUR(dot) = '" . (int)$i . "') GROUP BY HOUR(dot) ORDER BY dot ASC");
					if ($query->num_rows) {
						$data['order']['data'][]  = array($i, (int)$query->row['total']);
					} else {
						$data['order']['data'][]  = array($i, 0);
					}

					$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "transaction WHERE DATE(dot) = DATE(NOW()) AND HOUR(dot) = '" . (int)$i . "' GROUP BY HOUR(dot) ORDER BY dot ASC");
					if ($query->num_rows) {
						$data['customer']['data'][] = array($i, (int)$query->row['total']);
					} else {
						$data['customer']['data'][] = array($i, 0);
					}

					$data['xaxis'][] = array($i, date('H', mktime($i, 0, 0, date('n'), date('j'), date('Y'))));
				}
				break;
			case 'week':
				$date_start = strtotime('-' . date('w') . ' days'); 

				for ($i = 0; $i < 7; $i++) {
					$date = date('Y-m-d', $date_start + ($i * 86400));

					$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "transaction` WHERE DATE(dot) = '" . $this->db->escape($date) . "' GROUP BY DATE(dot)");

					if ($query->num_rows) {
						$data['order']['data'][] = array($i, (int)$query->row['total']);
					} else {
						$data['order']['data'][] = array($i, 0);
					}

					$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "transaction` WHERE DATE(dot) = '" . $this->db->escape($date) . "' GROUP BY DATE(dot)");

					if ($query->num_rows) {
						$data['customer']['data'][] = array($i, (int)$query->row['total']);
					} else {
						$data['customer']['data'][] = array($i, 0);
					}

					$data['xaxis'][] = array($i, date('D', strtotime($date)));
				}

				break;
			default:
			case 'month':
				for ($i = 1; $i <= date('t'); $i++) {
					$date = date('Y') . '-' . date('m') . '-' . $i;

					$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "transaction` WHERE (DATE(dot) = '" . $this->db->escape($date) . "') GROUP BY DAY(dot)");

					if ($query->num_rows) {
						$data['order']['data'][] = array($i, (int)$query->row['total']);
					} else {
						$data['order']['data'][] = array($i, 0);
					}	

					$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "transaction WHERE DATE(dot) = '" . $this->db->escape($date) . "' GROUP BY DAY(dot)");

					if ($query->num_rows) {
						$data['customer']['data'][] = array($i, (int)$query->row['total']);
					} else {
						$data['customer']['data'][] = array($i, 0);
					}	

					$data['xaxis'][] = array($i, date('j', strtotime($date)));
				}
				break;
			case 'year':
				for ($i = 1; $i <= 12; $i++) {
					$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "transaction` WHERE YEAR(dot) = '" . date('Y') . "' AND MONTH(dot) = '" . $i . "' GROUP BY MONTH(dot)");

					if ($query->num_rows) {
						$data['order']['data'][] = array($i, (int)$query->row['total']);
					} else {
						$data['order']['data'][] = array($i, 0);
					}

					$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "transaction` WHERE YEAR(dot) = '" . date('Y') . "' AND MONTH(dot) = '" . $i . "' GROUP BY MONTH(dot)");

					if ($query->num_rows) { 
						$data['customer']['data'][] = array($i, (int)$query->row['total']);
					} else {
						$data['customer']['data'][] = array($i, 0);
					}

					$data['xaxis'][] = array($i, date('M', mktime(0, 0, 0, $i, 1, date('Y'))));
				}			
				break;	
		} 

		$this->response->setOutput(json_encode($data));
	}

	public function login() {
		$route = '';

		if (isset($this->request->get['route'])) {
			$part = explode('/', $this->request->get['route']);

			if (isset($part[0])) {
				$route .= $part[0];
			}

			if (isset($part[1])) {
				$route .= '/' . $part[1];
			}
		}

		$ignore = array(
			'common/login',
			'common/forgotten',
			'snippets/dataprocess',
			'transaction/transaction',
			'common/reset'
		);	

		if (!$this->user->isLogged() && !in_array($route, $ignore)) {
			return $this->forward('common/login');
		}

		if (isset($this->request->get['route'])) {
			$ignore = array(
				'common/login',
				'common/logout',
				'common/forgotten',
				'common/reset',
				'error/not_found',
				'tool/backup',
				'snippets/dataprocess',
				'transaction/transaction',
				'error/permission'
			);

			$config_ignore = array();

			if ($this->config->get('config_token_ignore')) {
				$config_ignore = unserialize($this->config->get('config_token_ignore'));
			}

			$ignore = array_merge($ignore, $config_ignore);

			if (!in_array($route, $ignore) && (!isset($this->request->get['token']) || !isset($this->session->data['token']) || ($this->request->get['token'] != $this->session->data['token']))) {
				return $this->forward('common/login');
			}
		} else {
			if (!isset($this->request->get['token']) || !isset($this->session->data['token']) || ($this->request->get['token'] != $this->session->data['token'])) {
				return $this->forward('common/login');
			}
		}
	}

	public function permission() {
		if (isset($this->request->get['route'])) {
			$route = '';

			$part = explode('/', $this->request->get['route']);

			if (isset($part[0])) {
				$route .= $part[0];
			}

			if (isset($part[1])) {
				$route .= '/' . $part[1];
			}

			$ignore = array(
				'common/home',
				'common/login',
				'common/logout',
				'common/forgotten',
				'common/reset',
				'error/not_found',
				'tool/backup',
				'error/permission',
				'snippets/dataprocess',	
				'transaction/transaction',
			);			

			if (!in_array($route, $ignore) && !$this->user->hasPermission('access', $route)) {
				return $this->forward('error/permission');
			}
		}
	}	
}
?>