<?php
class ModelBillPrintInvoice extends Model {
	public function getallRl($month, $year) {
		$month = "01";
		$year = "2016";
		$sql = "SELECT * FROM oc_transaction where year = '".$year."' and month = '".$month."' and medicine_name LIKE '%rl%'";
		
		$data = $this->db->query($sql);
		$i = 0;
		foreach($data->rows as $dat) {
			$sql1 = "SELECT count(*) as total from oc_transaction where dot = '".$dat['dot']."' and horse_id = '".$dat['horse_id']."' and medicine_id = '129'";
			$data1 = $this->db->query($sql1);
			if($data1->row['total'] > 0) {
				//echo $dat['dot'] . "---" . $dat['horse_id'];
			} else {
				$i++;
				$sql3 = "INSERT INTO oc_transaction set horse_id = '".$dat['horse_id']."', dot = '".$dat['dot']."', medicine_id = '129', medicine_name = 'CATHETER,DRIPSET ETC.', medicine_price = '210', medicine_quantity = '1', medicine_total = '210', medicine_doctor_id = '1', `month` = '".$dat['month']."', `year` = '".$dat['year']."', transaction_type = '".$dat['transaction_type']."', bill_status = '".$dat['bill_status']."', cancel_status = '".$dat['cancel_status']."'";	
				echo $sql3;
				echo "<br>";
				//$this->db->query($sql3);
			}
			
		}
		echo "done ".$i; 
	}

	public function getall_transaction_group($data = array()) {
		$sql = "SELECT `transaction_id`, `horse_id` FROM `" . DB_PREFIX . "transaction` WHERE 1=1 "; 

		if (!empty($data['filter_name_id'])) {
			$sql .= " AND `horse_id` = '" . (int)$data['filter_name_id'] . "'";
		} 
		
		if (!empty($data['filter_date_start'])) {
			$sql .= " AND date(`dot`) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND date(`dot`) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		if (!empty($data['filter_doctor'])) {
			$sql .= " AND `medicine_doctor_id` = '" . (int)$data['filter_doctor'] . "'";
		}

		if (!empty($data['filter_trainer_id'])) {
			$sql .= " AND `trainer_id` = '" . (int)$data['filter_trainer_id'] . "'";
		}

		$sql .= " AND `bill_status` = '0' ";

		//$sql .= " GROUP BY `horse_id` ASC";
		$sql .= " GROUP BY `horse_id`, `medicine_id`, `dot`";
		$sql .= " ORDER BY `horse_id`, `medicine_id`, `dot` ASC";
		//echo $sql;exit;
		$query = $this->db->query($sql);
		return $query->rows;
	}	
	
	public function getall_transaction($data = array()) {
		$sql = "SELECT `transaction_id`, `month`, `year`, `horse_id`, `medicine_doctor_id`, `trainer_id`, `dot` FROM `" . DB_PREFIX . "transaction` WHERE 1=1 "; 

		if (!empty($data['filter_name_id'])) {
			$sql .= " AND `horse_id` = '" . (int)$data['filter_name_id'] . "'";
		} 
		
		if (!empty($data['filter_date_start'])) {
			$sql .= " AND date(`dot`) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND date(`dot`) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		if (!empty($data['filter_doctor'])) {
			$sql .= " AND `medicine_doctor_id` = '" . (int)$data['filter_doctor'] . "'";
		}

		if (!empty($data['filter_trainer_id'])) {
			$sql .= " AND `trainer_id` = '" . (int)$data['filter_trainer_id'] . "'";
		}

		$sql .= " AND `bill_status` = '0' ";

		$sql .= " ORDER BY `transaction_id` ASC";
		//echo $sql;
		//echo '<br />';
		//exit;
		$query = $this->db->query($sql);
		return $query->rows;
	}

	public function getexist_status($transaction_id){
		$sql = "SELECT `transaction_id`, `bill_id` FROM `" . DB_PREFIX . "bill` WHERE `transaction_id`= '".(int)$transaction_id."' ";		
		//echo $sql;
		//echo '<br />';
		$query = $this->db->query($sql);
		if($query->num_rows > 0){
			$is_exist = $query->row['bill_id'];
		} else {
			$is_exist = 0;
		}
		return $is_exist;
	}

	public function getbill_id(){
		$sql = "SELECT `bill_id` FROM `" . DB_PREFIX . "bill` ORDER BY `bill_id` DESC LIMIT 1 ";		
		$query = $this->db->query($sql);
		if($query->num_rows > 0){
			$p_bill_id = $query->row['bill_id'];
			$bill_id = $p_bill_id + 1;
		} else {
			$bill_id = 1;
		}
		return $bill_id;	
	}

	public function insert_bill($datas){
		foreach ($datas as $key => $value) {
			$this->db->query("INSERT INTO `" . DB_PREFIX . "bill` SET `bill_id` = '" . (int)$value['bill_id'] . "', `transaction_id` = '" . (int)$value['transaction_id'] . "', `month` = '" . $this->db->escape($value['month']) . "', `year` = '" . $this->db->escape($value['year']) . "', `horse_id` = '" . (int)$value['horse_id'] . "', `payment_status` = '0', `doctor_id` = '" . (int)$value['medicine_doctor_id'] . "', `trainer_id` = '" . (int)$value['trainer_id'] . "', `invoice_date` = '" . $this->db->escape(date('Y-m-d')) . "', `dot` = '" . $this->db->escape($value['dot']) . "' ");
			$this->db->query("UPDATE `" . DB_PREFIX . "transaction` SET `bill_status` = '1', `cancel_status` = '0' WHERE `transaction_id` = '" . (int)$value['transaction_id'] . "' ");
		}
	}

	public function insert_bill_owner($datas){
		// echo "<pre>";
		// print_r($datas);
		// exit;
		foreach ($datas as $key => $value) {
			$this->db->query("INSERT INTO `" . DB_PREFIX . "bill_owner` SET `bill_id` = '" . (int)$value['bill_id'] . "', `owner_id` = '" . (int)$value['owner_id'] . "', `owner_share` = '" . (int)$value['owner_share'] . "', `owner_amt` = '" . (float)$value['owner_amt'] . "', `owner_amt_rec` = '" . (float)$value['owner_amt_rec'] . "', `month` = '" . $this->db->escape($value['month']) . "', `year` = '" . $this->db->escape($value['year']) . "', `payment_status` = '0', `doctor_id` = '" . (int)$value['doctor_id'] . "', `transaction_type` = '" . (int)$value['transaction_type'] . "', `horse_id` = '" . (int)$value['horse_id'] . "', `trainer_id` = '" . (int)$value['trainer_id'] . "', `invoice_date` = '" . $this->db->escape(date('Y-m-d')) . "', `responsible_person` = '" . $this->db->escape($value['responsible_person']) . "', `responsible_person_id` = '" . $this->db->escape($value['responsible_person_id']) . "' ");
			//$sql = "SELECT `id`, owner_amt_rec, payment_status FROM `" . DB_PREFIX . "bill_owner` WHERE `bill_id` = '" . (int)$value['bill_id'] . "' AND `owner_id` = '" . (int)$value['owner_id'] . "' ";		
			//$id_query = $this->db->query($sql);
			//if($id_query->num_rows > 0){
				//$id = $id_query->row['id'];
				//$owner_amt_rec = $id_query->row['owner_amt_rec'];				
				//$payment_status = $id_query->row['payment_status'];
				//$invoice_date = $id_query->row['invoice_date'];				
				//$sql_del = "DELETE FROM `" . DB_PREFIX . "bill_owner` WHERE `id` = '" . (int)$id . "' ";		
				//$del_query = $this->db->query($sql_del);
				//$this->db->query("INSERT INTO `" . DB_PREFIX . "bill_owner` SET `id` = '" . (int)$id . "', `bill_id` = '" . (int)$value['bill_id'] . "', `owner_id` = '" . (int)$value['owner_id'] . "', `owner_share` = '" . (int)$value['owner_share'] . "', `owner_amt` = '" . (float)$value['owner_amt'] . "', `owner_amt_rec` = '" . (float)$owner_amt_rec . "', `month` = '" . $this->db->escape($value['month']) . "', `year` = '" . $this->db->escape($value['year']) . "', `payment_status` = '" . (int)$payment_status . "', `doctor_id` = '" . (int)$value['doctor_id'] . "', `transaction_type` = '" . (int)$value['transaction_type'] . "', `horse_id` = '" . (int)$value['horse_id'] . "', `trainer_id` = '" . (int)$value['trainer_id'] . "', `dot` = '" . $this->db->escape($value['dot']) . "', `invoice_date` = '" . $this->db->escape($invoice_date) . "' ");	
			//} else {
				//$this->db->query("INSERT INTO `" . DB_PREFIX . "bill_owner` SET `bill_id` = '" . (int)$value['bill_id'] . "', `owner_id` = '" . (int)$value['owner_id'] . "', `owner_share` = '" . (int)$value['owner_share'] . "', `owner_amt` = '" . (float)$value['owner_amt'] . "', `owner_amt_rec` = '" . (float)$value['owner_amt_rec'] . "', `month` = '" . $this->db->escape($value['month']) . "', `year` = '" . $this->db->escape($value['year']) . "', `payment_status` = '0', `doctor_id` = '" . (int)$value['doctor_id'] . "', `transaction_type` = '" . (int)$value['transaction_type'] . "', `horse_id` = '" . (int)$value['horse_id'] . "', `trainer_id` = '" . (int)$value['trainer_id'] . "', `dot` = '" . $this->db->escape($value['dot']) . "', `invoice_date` = '" . $this->db->escape(date('Y-m-d')) . "' ");
			//}
		}
	}

	public function getbill_groups($data = array()) {
		$sql = "SELECT `bill_id`, `horse_id`, `doctor_id`, `trainer_id` FROM `" . DB_PREFIX . "bill` WHERE `cancel_status` = '0' "; 

		if (!empty($data['filter_name_id'])) {
			$sql .= " AND `horse_id` = '" . (int)$data['filter_name_id'] . "'";
		} 
		
		if (!empty($data['filter_date_start'])) {
			$sql .= " AND date(`dot`) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND date(`dot`) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		if (!empty($data['filter_doctor'])) {
			$sql .= " AND `doctor_id` = '" . (int)$data['filter_doctor'] . "'";
		}

		if (!empty($data['filter_trainer_id'])) {
			$sql .= " AND `trainer_id` = '" . (int)$data['filter_trainer_id'] . "'";
		}

		$sql .= " GROUP BY `bill_id` ";
		$sql .= " ORDER BY `bill_id` ASC";
		//echo $sql;exit;
		$query = $this->db->query($sql);
		return $query->rows;
	}

	public function get_transaction_ids($bill_id) {
		$sql = "SELECT `transaction_id`, `month`, `year` FROM `" . DB_PREFIX . "bill` WHERE `bill_id` = '".(int)$bill_id."' AND `cancel_status` = '0' "; 
		$sql .= " ORDER BY DATE(`dot`) ASC";
		$query = $this->db->query($sql);
		return $query->rows;
	}

	public function get_transaction_data($transaction_id) {
		$sql = "SELECT transaction_id,medicine_id ,treatment_name ,dot,month,year,medicine_doctor_id,medicine_name ,SUM(medicine_quantity) AS med_qty, SUM(medicine_total) AS med_total FROM `" . DB_PREFIX . "transaction` WHERE `transaction_id` IN($transaction_id) AND `cancel_status` = '0' AND treatment_name <> '' "; 
		$sql .= " GROUP BY treatment_name  ";
		$sql .= " ORDER BY treatment_name ASC ";
		$query = $this->db->query($sql);
		return $query->rows;
	}

	public function get_bill_data($bill_id) {
		$sql = "SELECT SUM(owner_amt) AS total FROM `" . DB_PREFIX . "bill_owner` WHERE `bill_id` = '".(int)$bill_id."' "; 
		$query = $this->db->query($sql);
		return $query->row['total'];
	}

	public function get_horse_data($horse_id) {
		$sql = "SELECT * FROM `" . DB_PREFIX . "horse` WHERE `horse_id` = '".(int)$horse_id."' "; 
		$query = $this->db->query($sql);
		return $query->row;
	}

	public function get_trainer_data($trainer_id) {
		$sql = "SELECT * FROM `" . DB_PREFIX . "trainer` WHERE `trainer_id` = '".(int)$trainer_id."' "; 
		$query = $this->db->query($sql);
		return $query->row;
	}

	public function get_owner_data_generate($horse_id, $owner_id = 0) {
		$sql = "SELECT * FROM `" . DB_PREFIX . "horse_owner` WHERE `horse_id` = '".(int)$horse_id."' AND `share` <> '0' "; 
		if($owner_id != 0) {
			$sql .= " AND `owner` = '".(int)$owner_id."' ";
		}
		$sql .= " GROUP BY `owner` ORDER BY `owner` ASC";
		//echo $sql;exit;
		$query = $this->db->query($sql);
		return $query->rows;
	}

	public function get_owner_name($owner_id) {
		$sql = "SELECT `name` FROM `" . DB_PREFIX . "owner` WHERE `owner_id` = '".(int)$owner_id."' "; 
		$query = $this->db->query($sql);
		$owner_name = '';
		if($query->num_rows > 0){
			$owner_name = $query->row['name'];
		}
		return $owner_name;
	}

	public function get_owner_responsible_person($owner_id) {
		$sql = "SELECT `responsible_person` FROM `" . DB_PREFIX . "owner` WHERE `owner_id` = '".(int)$owner_id."' "; 
		$query = $this->db->query($sql);
		$responsible_person = '';
		if($query->num_rows > 0){
			$responsible_person = $query->row['responsible_person'];
		}
		return $responsible_person;
	}

	public function get_owner_responsible_person_id($owner_id) {
		$sql = "SELECT `responsible_person_id` FROM `" . DB_PREFIX . "owner` WHERE `owner_id` = '".(int)$owner_id."' "; 
		$query = $this->db->query($sql);
		$responsible_person_id = '';
		if($query->num_rows > 0){
			$responsible_person_id = $query->row['responsible_person_id'];
		}
		return $responsible_person_id;
	}

	public function get_owner_transactiontype($owner_id) {
		$sql = "SELECT `transaction_type` FROM `" . DB_PREFIX . "owner` WHERE `owner_id` = '".(int)$owner_id."' "; 
		$query = $this->db->query($sql);
		$transaction_type = '';
		if($query->num_rows > 0){
			$transaction_type = $query->row['transaction_type'];
		}
		return $transaction_type;
	}

	public function get_doctor_name($doctor_id) {
		$sql = "SELECT `name` FROM `" . DB_PREFIX . "doctor` WHERE `doctor_id` = '".(int)$doctor_id."' "; 
		$query = $this->db->query($sql);
		$doctor_name = '';
		if($query->num_rows > 0){
			$octor_name = $query->row['name'];
		}
		return $octor_name;
	}

	public function get_doctor_data($doctor_id) {
		$sql = "SELECT * FROM `" . DB_PREFIX . "doctor` WHERE `doctor_id` = '".(int)$doctor_id."' "; 
		$query = $this->db->query($sql);
		$doctor_datas = $query->row;
		return $doctor_datas;
	}

	public function get_owner_email($owner_id) {
		$sql = "SELECT `email` FROM `" . DB_PREFIX . "owner` WHERE `owner_id` = '".(int)$owner_id."' "; 
		$query = $this->db->query($sql);
		$owner_email = '';
		if($query->num_rows > 0){
			$owner_email = $query->row['email'];
		}
		return $owner_email;
	}
	
	public function getdoctors(){
		$sql = "SELECT * FROM `" . DB_PREFIX . "doctor` "; 
		$query = $this->db->query($sql);
		return $query->rows;
	}

	public function getbillowner_groups($data = array()) {
		$sql = "SELECT `bill_id`, `horse_id`, `owner_id`, `owner_amt`, `trainer_id`, `owner_share`, `owner_amt`, `doctor_id`, `month`, `year` FROM `" . DB_PREFIX . "bill_owner` WHERE `cancel_status` = '0' "; 

		if (!empty($data['filter_name_id'])) {
			$sql .= " AND `horse_id` = '" . (int)$data['filter_name_id'] . "'";
		} 
		
		if (!empty($data['filter_date_start'])) {
			$sql .= " AND date(`dot`) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND date(`dot`) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		if (!empty($data['filter_doctor'])) {
			$sql .= " AND `doctor_id` = '" . (int)$data['filter_doctor'] . "'";
		}

		if (!empty($data['filter_trainer_id'])) {
			$sql .= " AND `trainer_id` = '" . (int)$data['filter_trainer_id'] . "'";
		}

		if (!empty($data['filter_owner'])) {
			$sql .= " AND `owner_id` = '" . (int)$data['filter_owner'] . "'";
		}

		if (!empty($data['filter_bill_id'])) {
			$sql .= " AND `bill_id` = '" . (int)$data['filter_bill_id'] . "'";
		}

		$sql .= " ORDER BY `bill_id` ASC";

		// if (isset($data['start']) || isset($data['limit'])) {
		// 	if ($data['start'] < 0) {
		// 		$data['start'] = 0;
		// 	}			

		// 	if ($data['limit'] < 1) {
		// 		$data['limit'] = 20;
		// 	}	
			
		// 	$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		// }
		//echo $sql;exit;
		$query = $this->db->query($sql);
		return $query->rows;
	}

	public function getbillowner_groups_total($data = array()) {
		$sql = "SELECT count(*) AS total FROM `" . DB_PREFIX . "bill_owner` WHERE `cancel_status` = '0' "; 

		if (!empty($data['filter_name_id'])) {
			$sql .= " AND `horse_id` = '" . (int)$data['filter_name_id'] . "'";
		} 
		
		if (!empty($data['filter_date_start'])) {
			$sql .= " AND date(`dot`) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND date(`dot`) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		if (!empty($data['filter_doctor'])) {
			$sql .= " AND `doctor_id` = '" . (int)$data['filter_doctor'] . "'";
		}

		if (!empty($data['filter_trainer_id'])) {
			$sql .= " AND `trainer_id` = '" . (int)$data['filter_trainer_id'] . "'";
		}

		$sql .= " ORDER BY `bill_id` ASC";
		$query = $this->db->query($sql);
		return $query->row['total'];
	}

	public function get_horse_name($horse_id) {
		$sql = "SELECT `name` FROM `" . DB_PREFIX . "horse` WHERE `horse_id` = '".(int)$horse_id."' "; 
		$query = $this->db->query($sql);
		$horse_name = '';
		if($query->num_rows > 0){
			$horse_name = $query->row['name'];
		}
		return $horse_name;
	}

	public function get_trainer_name($trainer_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "trainer WHERE trainer_id = '".$trainer_id."'");
		$trainer_name = '';
		if($query->num_rows > 0){
			$trainer_name = $query->row['name'];
		}
		return $trainer_name;
	}

	public function getbillowner_once($data = array()) {
		$sql = "SELECT `bill_id`, `horse_id`, `owner_id`, `owner_amt`, `trainer_id`, owner_share, owner_amt, doctor_id FROM `" . DB_PREFIX . "bill_owner` WHERE `cancel_status` = '0' "; 

		if (!empty($data['filter_month'])) {
			$sql .= " AND `month` = '" . $this->db->escape($data['filter_month']) . "'";
		}

		if (!empty($data['filter_year'])) {
			$sql .= " AND `year` = '" . $this->db->escape($data['filter_year']) . "'";
		}

		if (!empty($data['filter_bill_id'])) {
			$sql .= " AND `bill_id` = '" . (int)$data['filter_bill_id'] . "'";
		}

		if (!empty($data['filter_horse_id'])) {
			$sql .= " AND `horse_id` = '" . (int)$data['filter_horse_id'] . "'";
		}

		if (!empty($data['filter_owner'])) {
			$sql .= " AND `owner_id` = '" . (int)$data['filter_owner'] . "'";
		}

		$sql .= " ORDER BY `bill_id` ASC";
		
		$query = $this->db->query($sql);
		return $query->rows;
	}
	
	public function getbillowners($data = array()) {
		$sql = "SELECT `id`, `bill_id`, `horse_id`,`ref_id`, `owner_id`, `owner_amt`, `trainer_id`, `owner_share`, `owner_amt`, `owner_amt_rec`, `doctor_id`, `month`, `year`, `dop`, `accept`, `cheque_no`, `total_amount`, `invoice_date`, `transaction_type`, `owner_amt_rec`, `payment_status`, `owner_code`, `batch_id`,`discount` FROM `" . DB_PREFIX . "bill_owner` WHERE `cancel_status` = '0' "; 
		if (isset($data['filter_name_id']) && !empty($data['filter_name_id'])) {
			$sql .= " AND `horse_id` = '" . (int)$data['filter_name_id'] . "'";
		} 
		
		if (isset($data['filter_doctor']) && !empty($data['filter_doctor'])) {
			$sql .= " AND `doctor_id` = '" . (int)$data['filter_doctor'] . "'";
		}

		if (isset($data['filter_trainer_id']) && !empty($data['filter_trainer_id'])) {
			$sql .= " AND `trainer_id` = '" . (int)$data['filter_trainer_id'] . "'";
		}

		if (isset($data['filter_bill_id']) && !empty($data['filter_bill_id'])) {
			$sql .= " AND `bill_id` = '" . (int)$data['filter_bill_id'] . "'";
		}

		if (isset($data['filter_owner']) && !empty($data['filter_owner'])) {
			$sql .= " AND `owner_id` = '" . (int)$data['filter_owner'] . "'";
		}

		if (isset($data['filter_unpaid']) && $data['filter_unpaid'] == '1') {
			$sql .= " AND `payment_status` = '0' ";
		}

		if (isset($data['bill_payment'])) {
			$sql .= " AND (`accept` = '0' OR `accept` = '1')";
		}

		// if (!empty($data['filter_transaction_type'])) {
		// 	$sql .= " AND `transaction_type` = '" . (int)$data['filter_transaction_type'] . "'";
		// }

		if (isset($data['filter_batch_id']) && !empty($data['filter_batch_id'])) {
			$sql .= " AND `batch_id` = '" . (int)$data['filter_batch_id'] . "'";
		}
		if (!isset($data['all'])) {
			$sql .= " AND ((`month` >= 8 AND `year` = '2017') OR (`year` >= '2018'))";
		}

		$sql .= " ORDER BY `bill_id`, `transaction_type`, `owner_id` ASC";
		// echo $sql;exit;
		$query = $this->db->query($sql);
		return $query->rows;
	}

	public function getbillowners_payment($data = array()) {
		$sql = "SELECT `id`, `bill_id`, `horse_id`, `owner_id`, `owner_amt`, `trainer_id`, `owner_share`, `owner_amt`, `owner_amt_rec`, `doctor_id`, `month`, `year`, `dop` FROM `" . DB_PREFIX . "bill_owner` WHERE `cancel_status` = '0' "; 
		if (isset($data['filter_name_id']) && !empty($data['filter_name_id'])) {
			$sql .= " AND `horse_id` = '" . (int)$data['filter_name_id'] . "'";
		} 
		
		if (isset($data['filter_doctor']) && !empty($data['filter_doctor'])) {
			$sql .= " AND `doctor_id` = '" . (int)$data['filter_doctor'] . "'";
		}

		if (isset($data['filter_trainer_id']) && !empty($data['filter_trainer_id'])) {
			$sql .= " AND `trainer_id` = '" . (int)$data['filter_trainer_id'] . "'";
		}

		if (isset($data['filter_bill_id']) && !empty($data['filter_bill_id'])) {
			$sql .= " AND `bill_id` = '" . (int)$data['filter_bill_id'] . "'";
		}

		if (isset($data['filter_owner']) && !empty($data['filter_owner'])) {
			$sql .= " AND `owner_id` = '" . (int)$data['filter_owner'] . "'";
		}

		if (isset($data['filter_unpaid']) && $data['filter_unpaid'] == '1') {
			$sql .= " AND `payment_status` = '0' ";
		}

		$sql .= " AND ((`month` >= 8 AND `year` = '2017') OR (`year` >= '2018'))";

		$sql .= " ORDER BY `owner_amt` DESC";
		//echo $sql;exit;
		$query = $this->db->query($sql);
		return $query->rows;
	}

	public function getbillmonyear($bill_id){
		$sql = "SELECT `month`, `year` FROM `" . DB_PREFIX . "bill` WHERE `bill_id` = '".(int)$bill_id."' AND `cancel_status` = '0' "; 
		$query = $this->db->query($sql);
		return $query->row;
	}

	public function getbillids_groups($data = array()) {
		// echo "<pre>";
		// print_r($data);
		// exit;
		$sql = "SELECT b.`bill_id`, b.`horse_id`, b.`doctor_id`, b.`trainer_id`, b.`month`, b.`year` FROM `" . DB_PREFIX . "bill` b LEFT JOIN `" . DB_PREFIX . "bill_owner` bo ON(bo.`bill_id` = b.`bill_id`) WHERE b.`cancel_status` = '0' "; 

		if (!empty($data['filter_from_month'])) {
			$sql .= " AND MONTH(b.`dot`) >= '" . $this->db->escape($data['filter_from_month']) . "'";
		}

		if (!empty($data['filter_to_month'])) {
			$sql .= " AND MONTH(b.`dot`) <= '" . $this->db->escape($data['filter_to_month']) . "'";
		}

		if (!empty($data['filter_year'])) {
			$sql .= " AND YEAR(b.`dot`) = '" . $this->db->escape($data['filter_year']) . "'";
		}

		if (!empty($data['filter_date_start'])) {
			$sql .= " AND date(b.`dot`) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND date(b.`dot`) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}
		
		if (isset($data['filter_name_id']) && !empty($data['filter_name_id'])) {
			$sql .= " AND b.`horse_id` = '" . (int)$data['filter_name_id'] . "'";
		} 
		
		if (isset($data['filter_trainer_id']) && !empty($data['filter_trainer_id'])) {
			$sql .= " AND b.`trainer_id` = '" . (int)$data['filter_trainer_id'] . "'";
		}

		if (isset($data['filter_doctor']) && !empty($data['filter_doctor'])) {
			$sql .= " AND b.`doctor_id` = '" . (int)$data['filter_doctor'] . "'";
		}

		if (isset($data['filter_bill_id']) && !empty($data['filter_bill_id'])) {
			$sql .= " AND b.`bill_id` = '" . (int)$data['filter_bill_id'] . "'";
		}

		if (isset($data['filter_owner_id']) && !empty($data['filter_owner_id'])) {
			$sql .= " AND bo.`owner_id` = '" . (int)$data['filter_owner_id'] . "'";
		}

		if (isset($data['filter_owner']) && !empty($data['filter_owner'])) {
			$sql .= " AND bo.`owner_id` = '" . (int)$data['filter_owner'] . "'";
		}

		$sql .= " GROUP BY b.`bill_id` ";
		$sql .= " ORDER BY b.`bill_id` ASC";

		$query = $this->db->query($sql);
		// echo "<pre>";
		// print_r($query);
		// exit;
		
		return $query->rows;
	}

	public function getbillids_bill($data = array()) {
		$sql = "SELECT * FROM `" . DB_PREFIX . "bill` WHERE 1=1 "; 
		if (isset($data['filter_bill_id']) && !empty($data['filter_bill_id'])) {
			$sql .= " AND `bill_id` = '" . (int)$data['filter_bill_id'] . "'";
		}
		$sql .= " ORDER BY `bill_id` ASC";
		//echo $sql;exit;
		$query = $this->db->query($sql);
		return $query->rows;
	}

	public function updatepaymentstatus_ids($id, $payment_type, $total_amount, $ramt){
		$owner_amt_rec_sql = "SELECT `owner_amt`,`owner_amt_rec` FROM `" . DB_PREFIX . "bill_owner` WHERE `id` = '".(int)$id."' ";
		$owner_amt_recs = $this->db->query($owner_amt_rec_sql);
		$owner_amt_rec = 0;
		$remaining = 0;
		if($owner_amt_recs->num_rows > 0){
			$owner_amt_rec = $owner_amt_recs->row['owner_amt'];
			$owner_amt_recs = $owner_amt_recs->row['owner_amt_rec'];
		}
		
		$data['status'] = 0;
		
			
		$tot_amt = abs($owner_amt_rec - $owner_amt_recs);
		if (abs($ramt) >= $tot_amt ) {
			$remaining = abs($owner_amt_rec - $owner_amt_recs) - abs($ramt);
			$dop = date('Y-m-d');
			$sql = "UPDATE `" . DB_PREFIX . "bill_owner` SET `owner_amt_rec` = '".(float)$owner_amt_rec."', `dop` = '".$dop."', `payment_status` = '1', `total_amount` = '".(float)$total_amount."', `payment_type` = '".$payment_type."' WHERE `id` = '".(int)$id."' ";
			$query = $this->db->query($sql);
			$data['status'] = 0;
		}else{
			//$remaining = $owner_amt_rec  - abs($ramt);
			$remaining = abs($owner_amt_rec - $owner_amt_recs) - abs($ramt);
			$paied_amt = abs($ramt) + abs($owner_amt_recs);
			$dop = date('Y-m-d');
			$sql = "UPDATE `" . DB_PREFIX . "bill_owner` SET `owner_amt_rec` = '".(float)abs($paied_amt)."', `dop` = '".$dop."', `payment_status` = '1', `total_amount` = '".(float)abs($paied_amt)."', `payment_type` = '".$payment_type."' WHERE `id` = '".(int)$id."' ";
			$query = $this->db->query($sql);
			$data['status'] = 1;
		}
		
		$data['remaining'] = $remaining;
		return $data;
		//$dop = date('Y-m-d', strtotime('2015-10-06'));
	}	

	public function updatepaymentstatus($datas = array()){
		// echo "<pre>";
		// print_r($datas);
		// exit;
		$owner_amt_rec = $datas['owner_amt_paying'] + $datas['owner_amt_rec'];

		$dop = date('Y-m-d', strtotime($datas['dop']));
		$sql = "UPDATE `" . DB_PREFIX . "bill_owner` SET `owner_amt_rec` = '".(float)$owner_amt_rec."', `dop` = '".$dop."', `cheque_no` = '".$datas['cheque_no']."', `total_amount` = '".(float)$datas['amount']."', `payment_type` = '".$datas['payment_type']."' , `discount` = '".$datas['t_owner_discount']."' WHERE `id` = '".(int)$datas['bill_owner_id']."'";
		//$this->log->write($sql);
		$query = $this->db->query($sql);
		if($owner_amt_rec == $datas['owner_amt']){
			$sql = "UPDATE `" . DB_PREFIX . "bill_owner` SET `payment_status` = '1' WHERE `id` = '".(int)$datas['bill_owner_id']."'";
			//$this->log->write($sql);
			$query = $this->db->query($sql);
		}
		
	}

	public function updatebillstatus($bill_id, $bill_status, $cancel_status){
		$sql = "UPDATE `" . DB_PREFIX . "bill` SET `cancel_status` = '".(int)$cancel_status."' WHERE `bill_id` = '".(int)$bill_id."' ";
		$query = $this->db->query($sql);
		
		$sql = "UPDATE `" . DB_PREFIX . "bill_owner` SET `cancel_status` = '".(int)$cancel_status."' WHERE `bill_id` = '".(int)$bill_id."' ";
		$query = $this->db->query($sql);
		
		$sql = "SELECT `transaction_id` FROM `" . DB_PREFIX . "bill` WHERE `bill_id` = '".(int)$bill_id."' ";
		$query = $this->db->query($sql)->rows;
		foreach ($query as $qkey => $qvalue) {
			$sql = "UPDATE `" . DB_PREFIX . "transaction` SET `cancel_status` = '0', `bill_status` = '".(int)$bill_status."' WHERE `transaction_id` = '".(int)$qvalue['transaction_id']."' ";
			$query = $this->db->query($sql);	
		}
	}

	public function getbilldoctorid($bill_id){
		$sql = "SELECT `doctor_id` FROM `" . DB_PREFIX . "bill` WHERE `bill_id` = '".(int)$bill_id."' "; 
		$query = $this->db->query($sql);
		return $query->row;
	}

	public function getLastAnilId() {
		$sql = "SELECT `anil_id` FROM `" . DB_PREFIX . "bill_owner` ORDER BY `anil_id` DESC Limit 1"; 
		$query = $this->db->query($sql);
		return $query->row['anil_id'];
	}

	public function get_owner_share($bill_id, $owner_id){
		$sql = "SELECT owner_amt FROM `" . DB_PREFIX . "bill_owner` WHERE `bill_id` = '".(int)$bill_id."' AND `owner_id` = '".(int)$owner_id."' "; 
		$query = $this->db->query($sql);
		if($query->num_rows > 0){		
			return $query->row['owner_amt'];
		} else {
			return 0;	
		}
	}

	public function get_owner_data($bill_id, $horse_id, $owner_id = 0) {
		$sql = "SELECT owner_id AS owner, owner_share AS share, `transaction_type` FROM `" . DB_PREFIX . "bill_owner` WHERE `bill_id` = '".(int)$bill_id."' ";  
		if($owner_id != 0) {
			$sql .= " AND `owner_id` = '".(int)$owner_id."' ";
		}
		$sql .= " GROUP BY `owner` ORDER BY `transaction_type` ASC";
		//echo $sql;exit;
		$query = $this->db->query($sql);
		return $query->rows;
	}

	public function update_trainer_transaction($trainer_id, $transaction_id){
		$this->db->query("UPDATE `" . DB_PREFIX . "transaction` SET `trainer_id` = '".(int)$trainer_id."' WHERE `transaction_id` = '" . (int)$transaction_id . "' ");
	}

	public function updatebill_accept($bill_id, $owner_id, $anil_id){
		$this->db->query("UPDATE `" . DB_PREFIX . "bill_owner` SET `accept` = '1', `anil_id` = '".$anil_id."' WHERE `owner_id` = '" . (int)$owner_id . "' AND `bill_id` = '".$bill_id."' ");
	}

	public function updatebill_accept_sel($id, $anil_id){
		$this->db->query("UPDATE `" . DB_PREFIX . "bill_owner` SET `accept` = '1', `anil_id` = '".$anil_id."' WHERE `id` = '" . (int)$id . "' ");
	}

	public function updatebill_reject($bill_id, $owner_id){
		$this->db->query("UPDATE `" . DB_PREFIX . "bill_owner` SET `accept` = '0' WHERE `owner_id` = '" . (int)$owner_id . "' AND `bill_id` = '".$bill_id."' ");
	}

	public function updatebill_defaulter($bill_id, $owner_id){
		$this->db->query("UPDATE `" . DB_PREFIX . "bill_owner` SET `accept` = '2' WHERE `owner_id` = '" . (int)$owner_id . "' AND `bill_id` = '".$bill_id."' ");
	}

	public function getlastbatchid(){
		$sql = "SELECT `batch_id` FROM `" . DB_PREFIX . "bill_owner` ORDER BY `batch_id` DESC LIMIT 1";
		$batch_id = $this->db->query($sql)->row['batch_id'];
		$batch_id = $batch_id + 1;
		return $batch_id;
	}	

	public function getbillpayment($data = array()){
		$sql = "SELECT `id`, `bill_id`, `horse_id`, `trainer_id`, SUM(`owner_amt`) AS o_amt, `month`, `year`, `doctor_id`, COUNT(bill_id) AS b_id, `anil_id` FROM `" . DB_PREFIX . "bill_owner` WHERE `accept` = '1' AND `cancel_status` = '0' ";
		if (isset($data['filter_batch_id']) && !empty($data['filter_batch_id'])) {
			$sql .= " AND `batch_id` = '" . (int)$data['filter_batch_id'] . "'";
		} else {
			$sql .= " AND `batch_id` = '0' ";
			if (isset($data['filter_doctor']) && !empty($data['filter_doctor'])) {
				$sql .= " AND `doctor_id` = '" . (int)$data['filter_doctor'] . "'";
			}		
		}

		//$sql .= " AND `doctor_id` = '1' ";
		//$sql .= " GROUP BY `bill_id` ORDER BY `trainer_id`, `bill_id` ";
		$sql .= " GROUP BY `bill_id` ORDER BY `anil_id` ";
		//echo $sql;exit;				
		$query = $this->db->query($sql)->rows;
		return $query;
	}

	public function updatebatchid($id, $batch_id){
		$this->db->query("UPDATE `" . DB_PREFIX . "bill_owner` SET `batch_id` = '".$batch_id."' WHERE `id` = '" . (int)$id . "' ");
	}

	public function getbillowners_accept($bill_id) {
		$sql = "SELECT `id`, `bill_id` FROM `" . DB_PREFIX . "bill_owner` WHERE `cancel_status` = '0' AND `accept` = 1 AND `bill_id` = '".$bill_id."' "; 
		//echo $sql;exit;
		$query = $this->db->query($sql);
		return $query->rows;
	}

	public function getbillid($id) {
		$sql = "SELECT `bill_id` FROM `" . DB_PREFIX . "bill_owner` WHERE `id` = '".$id."' "; 
		//echo $sql;exit;
		$query = $this->db->query($sql);
		return $query->row['bill_id'];
	}		

	public function update_bill_owners($data){
		$this->db->query("DELETE FROM `oc_bill_owner` WHERE `bill_id` = '".$data['bill_id']."' ");
		
		foreach ($data['owners'] as $key => $value) {
			if($value['o_dop'] == ''){
				$value['o_dop'] = date('Y-m-d', strtotime('2015-10-06'));
			}
			if($value['o_id'] != ''){
				$this->db->query("INSERT INTO `" . DB_PREFIX . "bill_owner` SET 
								`id`      = '".$value['o_id']."',							
								`bill_id` = '" . (int)$data['bill_id'] . "', 
								`owner_id` = '" . (int)$value['o_name_id'] . "', 
								`owner_share` = '" . (int)$value['o_share'] . "', 
								`owner_amt` = '" . (float)$value['o_amt'] . "', 
								`owner_amt_rec` = '" . (float)$value['o_owner_amt_rec'] . "', 
								`month` = '" . $this->db->escape($data['month']) . "', 
								`year` = '" . $this->db->escape($data['year']) . "', 
								`payment_status` = '" . $this->db->escape($value['o_payment_status']) . "', 
								`doctor_id` = '" . (int)$data['doctor_id'] . "', 
								`transaction_type` = '" . (int)$value['o_transaction_type'] . "', 
								`horse_id` = '" . (int)$data['horse_id'] . "', 
								`trainer_id` = '" . (int)$data['trainer_id'] . "', 
								`invoice_date` = '" . $this->db->escape($value['o_invoice_date']) . "', 
								`dop` = '" . $this->db->escape($value['o_dop']) . "',
								`accept` = '" . $this->db->escape($value['o_accept']) . "', 
								`owner_code` = '" . $this->db->escape($value['o_owner_code']) . "', 
								`batch_id` = '" . $this->db->escape($value['o_batch_id']) . "', 
								`cheque_no` = '" . $this->db->escape($value['o_cheque_no']) . "', 
								`total_amount` = '" . $this->db->escape($value['o_total_amount']) . "' ");
			} else {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "bill_owner` SET 
								`bill_id` = '" . (int)$data['bill_id'] . "', 
								`owner_id` = '" . (int)$value['o_name_id'] . "', 
								`owner_share` = '" . (int)$value['o_share'] . "', 
								`owner_amt` = '" . (float)$value['o_amt'] . "', 
								`month` = '" . $this->db->escape($data['month']) . "', 
								`year` = '" . $this->db->escape($data['year']) . "', 
								`doctor_id` = '" . (int)$data['doctor_id'] . "', 
								`transaction_type` = '" . (int)$value['o_transaction_type'] . "', 
								`horse_id` = '" . (int)$data['horse_id'] . "', 
								`trainer_id` = '" . (int)$data['trainer_id'] . "', 
								`invoice_date` = '" . $this->db->escape($data['invoice_date']) . "', 
								`accept` = '" . $this->db->escape($data['accept']) . "', 
								`owner_code` = '" . $this->db->escape($value['o_owner_code']) . "', 
								`batch_id` = '" . $this->db->escape($data['batch_id']) . "' ");
			}
		
		}
	}

	public function getbills_rwitc($data) {
		$sql = "SELECT * FROM `" . DB_PREFIX . "bill_owner` WHERE `cancel_status` = '0' ";
		if (!empty($data['filter_bill_id'])) {
			$sql .= " AND `bill_id` = '" . (int)$data['filter_bill_id'] . "'";
		}

		if (!empty($data['filter_name_id'])) {
			$sql .= " AND `owner_id` = '" . (int)$data['filter_name_id'] . "'";
		} 
		
		if (!empty($data['filter_month'])) {
			$sql .= " AND `month` = '" . $this->db->escape($data['filter_month']) . "'";
		}

		if (!empty($data['filter_year'])) {
			$sql .= " AND `year` = '" . $this->db->escape($data['filter_year']) . "'";
		}

		if (!empty($data['filter_doctor']) && $data['filter_doctor'] != '0') {
			$sql .= " AND `doctor_id` = '" . (int)$data['filter_doctor'] . "'";
		}

		if (!empty($data['filter_transaction_type'])) {
			$sql .= " AND `transaction_type` = '" . (int)$data['filter_transaction_type'] . "'";
		}

		if (!empty($data['filter_batch_id'])) {
			$sql .= " AND `batch_id` = '" . (int)$data['filter_batch_id'] . "'";
		}

		if($data['filter_type'] == '1'){
		} elseif($data['filter_type'] == '2'){
			$sql .= " AND `accept` = '1' ";	
		} elseif($data['filter_type'] == '3'){
			$sql .= " AND `accept` = '2' ";	
		} elseif($data['filter_type'] == '4'){
			$sql .= " AND `accept` = '0' ";
		}

		//$sql .= " AND `accept` = '1' ";

		$sql .= " ORDER BY `trainer_id`, `bill_id`, `transaction_type`  ASC";
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}			

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}	
			
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}
		//echo $sql;exit;
		$query = $this->db->query($sql);
		return $query->rows;
	}

	public function getbillids_groups_owner($data = array()) {
		$sql = "SELECT `bill_id`, `horse_id`, `doctor_id`, `trainer_id`, `month`, `year` FROM `" . DB_PREFIX . "bill` WHERE `cancel_status` = '0' "; 

		if (!empty($data['filter_date_start'])) {
			$sql .= " AND date(`dot`) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND date(`dot`) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}
		
		if (isset($data['filter_name_id']) && !empty($data['filter_name_id'])) {
			$sql .= " AND `horse_id` = '" . (int)$data['filter_name_id'] . "'";
		} 
		
		if (isset($data['filter_trainer_id']) && !empty($data['filter_trainer_id'])) {
			$sql .= " AND `trainer_id` = '" . (int)$data['filter_trainer_id'] . "'";
		}

		if (isset($data['filter_doctor']) && !empty($data['filter_doctor'])) {
			$sql .= " AND `doctor_id` = '" . (int)$data['filter_doctor'] . "'";
		}

		if (isset($data['filter_bill_id']) && !empty($data['filter_bill_id'])) {
			$sql .= " AND `bill_id` = '" . (int)$data['filter_bill_id'] . "'";
		}

		$sql .= " GROUP BY `bill_id` ORDER BY `bill_id` ASC";

		// echo $sql;exit;
		$query = $this->db->query($sql);
		return $query->rows;
	}

	public function getbillowners_owner($data = array()) {
		$sql = "SELECT `id`, `bill_id`, `horse_id`,`ref_id`,`payment_type`,`owner_id`, `owner_amt`, `trainer_id`, `owner_share`, `owner_amt`, `owner_amt_rec`, `doctor_id`, `month`, `year`, `dop`, `accept`, `cheque_no`, `total_amount`, `invoice_date`, `transaction_type`, `owner_amt_rec`, `payment_status`, `owner_code`, `batch_id`,`discount` FROM `" . DB_PREFIX . "bill_owner` WHERE `cancel_status` = '0' "; 
		if (isset($data['filter_name_id']) && !empty($data['filter_name_id'])) {
			$sql .= " AND `horse_id` = '" . (int)$data['filter_name_id'] . "'";
		} 
		
		if (isset($data['filter_doctor']) && !empty($data['filter_doctor'])) {
			$sql .= " AND `doctor_id` = '" . (int)$data['filter_doctor'] . "'";
		}

		if (isset($data['filter_trainer_id']) && !empty($data['filter_trainer_id'])) {
			$sql .= " AND `trainer_id` = '" . (int)$data['filter_trainer_id'] . "'";
		}

		if (isset($data['filter_bill_id']) && !empty($data['filter_bill_id'])) {
			$sql .= " AND `bill_id` = '" . (int)$data['filter_bill_id'] . "'";
		}

		if (isset($data['filter_owner']) && !empty($data['filter_owner'])) {
			$sql .= " AND `owner_id` IN (" . $data['filter_owner'] . ")";
		}

		if (isset($data['filter_unpaid']) && $data['filter_unpaid'] == '1') {
			$sql .= " AND `payment_status` = '0' ";
		}

		if (isset($data['bill_payment'])) {
			$sql .= " AND (`accept` = '0' OR `accept` = '1')";
		}

		if (!empty($data['filter_transaction_type'])) {
			$sql .= " AND `transaction_type` = '" . (int)$data['filter_transaction_type'] . "'";
		}

		if (isset($data['filter_batch_id']) && !empty($data['filter_batch_id'])) {
			$sql .= " AND `batch_id` = '" . (int)$data['filter_batch_id'] . "'";
		}

		$sql .= " ORDER BY `trainer_id` ASC";
		//echo $sql;exit;
		$query = $this->db->query($sql);
		return $query->rows;
	}

	public function get_transaction_datass($transaction_id) {
		$sql = "SELECT * FROM `" . DB_PREFIX . "transaction` WHERE `transaction_id` = '".(int)$transaction_id."' AND `cancel_status` = '0' "; 
		$query = $this->db->query($sql);
		return $query->row;
	}

	
}
?>
