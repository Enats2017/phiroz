<?php
class ModelReportCommonReport extends Model {
	public function getTransaction($data = array()) {
		$sql = "SELECT *, (SELECT name FROM `" . DB_PREFIX . "horse` h WHERE h.horse_id = t.horse_id) AS horse_name FROM `" . DB_PREFIX . "transaction` t WHERE t.`cancel_status` = '0' "; 

		if (!empty($data['filter_name_id'])) {
			$sql .= " AND `horse_id` = '" . (int)$data['filter_name_id'] . "'";
		} 
		
		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(`dot`) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(`dot`) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		if (!empty($data['filter_doctor']) && $data['filter_doctor'] != '0') {
			$sql .= " AND `medicine_doctor_id` = '" . (int)$data['filter_doctor'] . "'";
		}

		// if (!empty($data['filter_transaction_type'])) {
		// 	$sql .= " AND `transaction_type` = '" . (int)$data['filter_transaction_type'] . "'";
		// }

		$sql .= " ORDER BY `transaction_id` ASC";

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

	public function getTransaction_trainer($data = array()) {
		$sql = "SELECT t.*, h1.trainer, (SELECT name FROM `" . DB_PREFIX . "trainer` tr WHERE tr.trainer_id = (SELECT trainer FROM `" . DB_PREFIX . "horse` h WHERE h.horse_id = t.horse_id) ) AS trainer_name FROM `" . DB_PREFIX . "transaction` t LEFT JOIN `oc_horse` h1 ON (h1.horse_id = t.horse_id) WHERE t.`cancel_status` = '0' "; 

		if (!empty($data['filter_name_id'])) {
			$sql .= " AND `trainer` = '" . (int)$data['filter_name_id'] . "'";
		} 
		
		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(`dot`) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(`dot`) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		if (!empty($data['filter_doctor']) && $data['filter_doctor'] != '0') {
			$sql .= " AND `medicine_doctor_id` = '" . (int)$data['filter_doctor'] . "'";
		}

		// if (!empty($data['filter_transaction_type'])) {
		// 	$sql .= " AND `transaction_type` = '" . (int)$data['filter_transaction_type'] . "'";
		// }

		$sql .= " ORDER BY `trainer_name` ASC, h1.`name` ASC, `dot` DESC";

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

	public function getTotalTransaction($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "transaction` WHERE `cancel_status` = '0' "; 

		if (!empty($data['filter_name_id'])) {
			$sql .= " AND `horse_id` = '" . (int)$data['filter_name_id'] . "'";
		} 
		
		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(`dot`) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(`dot`) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		if (!empty($data['filter_doctor']) && $data['filter_doctor'] != '0') {
			$sql .= " AND `medicine_doctor_id` = '" . (int)$data['filter_doctor'] . "'";
		}

		// if (!empty($data['filter_transaction_type'])) {
		// 	$sql .= " AND `transaction_type` = '" . (int)$data['filter_transaction_type'] . "'";
		// }

		$query = $this->db->query($sql);
		return $query->row['total'];
	}

	public function getTotalTransaction_owner($data = array()) {
		$sql = "SELECT COUNT(*) AS total, h.owner FROM `" . DB_PREFIX . "transaction` t LEFT JOIN `" . DB_PREFIX . "horse_owner` h ON (h.horse_id = t.horse_id) WHERE t.`cancel_status` = '0' "; 

		if (!empty($data['filter_name_id'])) {
			$sql .= " AND h.owner = '" . (int)$data['filter_name_id'] . "'";
		} 
		
		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(`dot`) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(`dot`) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		if (!empty($data['filter_doctor']) && $data['filter_doctor'] != '0') {
			$sql .= " AND `medicine_doctor_id` = '" . (int)$data['filter_doctor'] . "'";
		}

		// if (!empty($data['filter_transaction_type'])) {
		// 	$sql .= " AND `transaction_type` = '" . (int)$data['filter_transaction_type'] . "'";
		// }

		$query = $this->db->query($sql);
		//echo $query->row['total'];exit;
		return $query->row['total'];
	}

	public function getTransaction_owner_eric_1($data) {
		$sql = "SELECT * FROM `".DB_PREFIX."transaction` t WHERE `cancel_status` = '0'";	
		
		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(`dot`) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(`dot`) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		if (!empty($data['filter_doctor']) && $data['filter_doctor'] != '0') {
			$sql .= " AND `medicine_doctor_id` = '" . (int)$data['filter_doctor'] . "'";
		}
		$sql .= " GROUP BY `horse_id` ORDER BY `trainer_id` DESC";
		//echo $sql;exit;
		$query = $this->db->query($sql);
		return $query->rows;
	}

	public function getTransaction_owner_eric_group($data) {
		$sql = "SELECT * FROM `".DB_PREFIX."transaction` t WHERE `cancel_status` = '0'";	
		
		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(`dot`) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(`dot`) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		if (!empty($data['filter_doctor']) && $data['filter_doctor'] != '0') {
			$sql .= " AND `medicine_doctor_id` = '" . (int)$data['filter_doctor'] . "'";
		}

		$sql .= " GROUP BY `trainer_id` ORDER BY `trainer_id` DESC";
		
		//echo $sql;exit;
		$query = $this->db->query($sql);
		return $query->rows;
	}

	public function getTransaction_owner_eric($data) {
		$sql = "SELECT * FROM `".DB_PREFIX."transaction` t WHERE `cancel_status` = '0'";	
		
		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(`dot`) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(`dot`) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		if (!empty($data['filter_doctor']) && $data['filter_doctor'] != '0') {
			$sql .= " AND `medicine_doctor_id` = '" . (int)$data['filter_doctor'] . "'";
		}

		$sql .= " AND `trainer_id` = '".$data['trainer_id']."' ";

		$sql .= " GROUP BY `horse_id` ";
		
		
		//echo $sql;exit;
		$query = $this->db->query($sql);
		return $query->rows;
	}	

	public function getTransaction_owner($data = array()) {
		$sql = "SELECT t.*, h.owner, h.share, (SELECT `name` FROM `" . DB_PREFIX . "owner` o WHERE o.owner_id = (SELECT `owner` FROM `" . DB_PREFIX . "horse_owner` hr WHERE hr.horse_id = t.horse_id AND hr.owner = h.owner LIMIT 1) LIMIT 1) AS owner_name, (SELECT `name` FROM `" . DB_PREFIX . "horse` h1 WHERE h1.horse_id = t.horse_id LIMIT 1) AS horse_name FROM `" . DB_PREFIX . "transaction` t LEFT JOIN `" . DB_PREFIX . "horse_owner` h ON (h.horse_id = t.horse_id) WHERE t.`cancel_status` = '0' ";

		if (!empty($data['filter_name_id'])) {
			$sql .= " AND h.owner = '" . (int)$data['filter_name_id'] . "'";
		} 
		
		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(`dot`) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(`dot`) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		if (!empty($data['filter_doctor']) && $data['filter_doctor'] != '0') {
			$sql .= " AND `medicine_doctor_id` = '" . (int)$data['filter_doctor'] . "'";
		}

		// if (!empty($data['filter_transaction_type'])) {
		// 	$sql .= " AND `transaction_type` = '" . (int)$data['filter_transaction_type'] . "'";
		// }

		$sql .= " ORDER BY `owner_name` ASC, `horse_name` ASC, `dot` DESC";
		//$sql .= " ORDER BY owner_name ASC";

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

	public function getpending_bills($data) {
		$sql = "SELECT * FROM `" . DB_PREFIX . "bill_owner` WHERE `cancel_status` = '0' ";
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

		if ($data['filter_type'] == 1) {
			$sql .= " AND `payment_status` = '0' ";
			//$sql .= " AND `payment_status` = '0' AND `accept` = '1' ";
		} else if($data['filter_type'] == 2) {
			$sql .= " AND `payment_status` = '2' ";
		} else if($data['filter_type'] == 3) {
			$sql .= " AND `payment_status` = '1' ";
		}

		$sql .= " ORDER BY `bill_id`, `owner_id` ASC";
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

	public function gettotal_pending_bills($data) {
		$sql = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "bill_owner` WHERE `cancel_status` = '0' ";
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

		if ($data['filter_type'] == 1) {
			$sql .= " AND `payment_status` = '0' AND `accept` = '1' ";
		} else if($data['filter_type'] == 2) {
			$sql .= " AND `payment_status` = '2' ";
		} else if($data['filter_type'] == 3) {
			$sql .= " AND `payment_status` = '1' ";
		}

		$sql .= " ORDER BY `bill_id`, `owner_id` ASC";
		//echo $sql;exit;
		$query = $this->db->query($sql);
		return $query->row['total'];
	}

	public function getpaid_bills($data) {
		$sql = "SELECT * FROM `" . DB_PREFIX . "bill_owner` WHERE `payment_status` = '1' AND `cancel_status` = '0' ";
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
		$sql .= " ORDER BY `bill_id`, `owner_id` ASC";
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

	public function gettotal_paid_bills($data) {
		$sql = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "bill_owner` WHERE `payment_status` = '1' AND `cancel_status` = '0' ";
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
		$sql .= " ORDER BY `bill_id`, `owner_id` ASC";
		//echo $sql;exit;
		$query = $this->db->query($sql);
		return $query->row['total'];
	}

	public function get_horseid_by_bill($bill_id) {
		$sql = "SELECT `horse_id` FROM `" . DB_PREFIX . "bill` WHERE `bill_id` = '".(int)$bill_id."' "; 
		$query = $this->db->query($sql);
		return $query->row['horse_id'];
	}

	public function get_horse_data($horse_id) {
		$sql = "SELECT * FROM `" . DB_PREFIX . "horse` WHERE `horse_id` = '".(int)$horse_id."' "; 
		$query = $this->db->query($sql);
		return $query->row;
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

	public function get_trainer_data($trainer_id) {
		$sql = "SELECT * FROM `" . DB_PREFIX . "trainer` WHERE `trainer_id` = '".(int)$trainer_id."' "; 
		$query = $this->db->query($sql);
		return $query->row;
	}

	public function get_trainer_name($trainer_id) {
		$sql = "SELECT `name` FROM `" . DB_PREFIX . "trainer` WHERE `trainer_id` = '".(int)$trainer_id."' "; 
		$query = $this->db->query($sql);
		$trainer_name = '';
		if($query->num_rows > 0){
			$trainer_name = $query->row['name'];
		}
		return $trainer_name;
	}

	public function get_owner_data($horse_id) {
		$sql = "SELECT * FROM `" . DB_PREFIX . "horse_owner` WHERE `horse_id` = '".(int)$horse_id."' GROUP BY `owner`"; 
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

	public function get_owner_email($owner_id) {
		$sql = "SELECT `email` FROM `" . DB_PREFIX . "owner` WHERE `owner_id` = '".(int)$owner_id."' "; 
		$query = $this->db->query($sql);
		$owner_email = '';
		if($query->num_rows > 0){
			$owner_email = $query->row['email'];
		}
		return $owner_email;
	}

	public function get_owner_balance($owner_id) {
		$sql = "SELECT `balance` FROM `" . DB_PREFIX . "owner` WHERE `owner_id` = '".(int)$owner_id."' "; 
		$query = $this->db->query($sql);
		$balance = '';
		if($query->num_rows > 0){
			$balance = $query->row['balance'];
		}
		return $balance;
	}

	public function get_doctor_name($doctor_id) {
		$sql = "SELECT `name` FROM `" . DB_PREFIX . "doctor` WHERE `doctor_id` = '".(int)$doctor_id."' "; 
		$query = $this->db->query($sql);
		$doctor_name = '';
		if($query->num_rows > 0){
			$doctor_name = $query->row['name'];
		}
		return $doctor_name;
	}

	public function getTreatedhorsewithoutowner($data = array()) {
		$sql = "SELECT *, (SELECT name FROM `" . DB_PREFIX . "horse` h WHERE h.horse_id = t.horse_id) AS horse_name FROM `" . DB_PREFIX . "transaction` t WHERE t.`cancel_status` = '0' "; 

		if (!empty($data['filter_date'])) {
			$sql .= " AND DATE(`dot`) = '" . $this->db->escape($data['filter_date']) . "'";
		}
		$sql .= " GROUP BY `horse_name` ";
		$sql .= " ORDER BY `horse_name` ASC";
		//echo $sql;exit;
		$query = $this->db->query($sql);
		return $query->rows;
	}

	public function getTotalTreatedhorsewithoutowner($data = array()) {
		$sql = "SELECT COUNT(*) AS total, (SELECT name FROM `" . DB_PREFIX . "horse` h WHERE h.horse_id = t.horse_id) AS horse_name FROM `" . DB_PREFIX . "transaction` t WHERE t.`cancel_status` = '0' "; 
		if (!empty($data['filter_date'])) {
			$sql .= " AND DATE(`dot`) = '" . $this->db->escape($data['filter_date']) . "'";
		} 
		$sql .= " GROUP BY `horse_name` ";
		$sql .= " ORDER BY `horse_name` ASC";
		$query = $this->db->query($sql);
		return $query->row['total'];
	}

	public function getTotalHorsedata($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "transaction` t WHERE t.`cancel_status` = '0' "; 
		if (!empty($data['h_name_id'])) {
			$sql .= " AND `horse_id` = '" . (int)$data['h_name_id'] . "'";
		} 
		//echo $sql;exit;
		$query = $this->db->query($sql);
		return $query->row['total'];
	}

	public function gettransactionbydate($dot, $horse_id){
		$sql = "SELECT * FROM `" . DB_PREFIX . "transaction` t WHERE `dot` = '".$dot."' AND `horse_id` = '".(int)$horse_id."' AND t.`cancel_status` = '0' "; 
		//echo $sql;exit;
		$query = $this->db->query($sql);
		return $query->rows;	
	}

	public function getHorseTransactiondata($data = array()) {
		$sql = "SELECT * FROM `" . DB_PREFIX . "transaction` t WHERE t.`cancel_status` = '0' "; 

		if (!empty($data['h_name_id'])) {
			$sql .= " AND `horse_id` = '" . (int)$data['h_name_id'] . "'";
		} 
		
		$sql .= " GROUP BY `dot` ORDER BY `dot` DESC ";

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

	public function get_bill_status($transaction_id) {
		$sql = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "bill` WHERE `transaction_id` = '".(int)$transaction_id."' AND `cancel_status` = '0' "; 
		//echo $sql;exit;
		$query = $this->db->query($sql);
		return $query->row['total'];
	}

	public function gethorsetreated_group($data = array()) {
		$sql = "SELECT horse_id, (SELECT name FROM `" . DB_PREFIX . "horse` h WHERE h.horse_id = t.horse_id) AS horse_name FROM `" . DB_PREFIX . "transaction` t "; 

		if(isset($data['filter_surgery']) && !empty($data['filter_surgery'])){
			$sql .= " LEFT JOIN `oc_medicine` m ON (t.medicine_id = m.medicine_id) WHERE t.`cancel_status` = '0' AND m.`is_surgery` = '1' ";
		} else {
			$sql .= " WHERE t.`cancel_status` = '0' ";
		}

		if (!empty($data['filter_name_id'])) {
			$sql .= " AND t.`horse_id` = '" . (int)$data['filter_name_id'] . "'";
		} 
		
		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(`dot`) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(`dot`) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		if (!empty($data['filter_doctor']) && $data['filter_doctor'] != '0') {
			$sql .= " AND t.`medicine_doctor_id` = '" . (int)$data['filter_doctor'] . "'";
		}

		if(isset($data['filter_medicine']) && !empty($data['filter_medicine'])){
			$sql .= " AND LOWER(t.medicine_name) LIKE '" . $this->db->escape(strtolower($data['filter_medicine'])) . "%' ";	
		}

		if(isset($data['filter_medicine_id']) && !empty($data['filter_medicine_id'])){
			$sql .= " AND t.medicine_id IN " . $this->db->escape($data['filter_medicine_id']) . " ";	
		}

		$sql .= " GROUP BY `horse_name` ORDER BY `horse_name` ASC, `trainer_id` ASC";

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

	public function gethorsetreated_group_endos($data = array()) {
		$sql = "SELECT horse_id, (SELECT name FROM `" . DB_PREFIX . "horse` h WHERE h.horse_id = t.horse_id) AS horse_name FROM `" . DB_PREFIX . "transaction` t "; 

		if(isset($data['filter_surgery']) && !empty($data['filter_surgery'])){
			$sql .= " LEFT JOIN `oc_medicine` m ON (t.medicine_id = m.medicine_id) WHERE t.`cancel_status` = '0' AND m.`is_surgery` = '1' ";
		} else {
			$sql .= " WHERE t.`cancel_status` = '0' ";
		}

		if (!empty($data['filter_name_id'])) {
			$sql .= " AND t.`horse_id` = '" . (int)$data['filter_name_id'] . "'";
		} 
		
		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(`dot`) = '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_doctor']) && $data['filter_doctor'] != '0') {
			$sql .= " AND t.`medicine_doctor_id` = '" . (int)$data['filter_doctor'] . "'";
		}

		if(isset($data['filter_medicine']) && !empty($data['filter_medicine'])){
			$sql .= " AND LOWER(t.medicine_name) LIKE '" . $this->db->escape(strtolower($data['filter_medicine'])) . "%' ";	
		}

		if(isset($data['filter_medicine_id']) && !empty($data['filter_medicine_id'])){
			$sql .= " AND t.medicine_id IN " . $this->db->escape($data['filter_medicine_id']) . " ";	
		}

		$sql .= " GROUP BY `horse_name` ORDER BY `horse_name` ASC, `trainer_id` ASC";

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

	public function getTotalhorsetreated($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "transaction` t "; 

		if(isset($data['filter_surgery']) && !empty($data['filter_surgery'])){
			$sql .= " LEFT JOIN `oc_medicine` m ON (t.medicine_id = m.medicine_id) WHERE t.`cancel_status` = '0' AND m.`is_surgery` = '1' ";
		} else {
			$sql .= " WHERE t.`cancel_status` = '0' ";
		}

		if (!empty($data['filter_name_id'])) {
			$sql .= " AND t.`horse_id` = '" . (int)$data['filter_name_id'] . "'";
		} 
		
		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(`dot`) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(`dot`) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		if (!empty($data['filter_doctor']) && $data['filter_doctor'] != '0') {
			$sql .= " AND t.`medicine_doctor_id` = '" . (int)$data['filter_doctor'] . "'";
		}

		if(isset($data['filter_medicine']) && !empty($data['filter_medicine'])){
			$sql .= " AND LOWER(t.medicine_name) LIKE '" . $this->db->escape(strtolower($data['filter_medicine'])) . "%' ";	
		}

		if(isset($data['filter_medicine_id']) && !empty($data['filter_medicine_id'])){
			$sql .= " AND t.medicine_id IN " . $this->db->escape($data['filter_medicine_id']) . " ";	
		}

		$sql .= " GROUP BY `horse_id` ";
		$sql .= " ORDER BY `horse_id` ASC";
		//echo $sql;exit;
		$query = $this->db->query($sql);
		return $query->num_rows;
	}

	public function getTotalhorsetreated_endos($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "transaction` t "; 

		if(isset($data['filter_surgery']) && !empty($data['filter_surgery'])){
			$sql .= " LEFT JOIN `oc_medicine` m ON (t.medicine_id = m.medicine_id) WHERE t.`cancel_status` = '0' AND m.`is_surgery` = '1' ";
		} else {
			$sql .= " WHERE t.`cancel_status` = '0' ";
		}

		if (!empty($data['filter_name_id'])) {
			$sql .= " AND t.`horse_id` = '" . (int)$data['filter_name_id'] . "'";
		} 
		
		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(`dot`) = '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_doctor']) && $data['filter_doctor'] != '0') {
			$sql .= " AND t.`medicine_doctor_id` = '" . (int)$data['filter_doctor'] . "'";
		}

		if(isset($data['filter_medicine']) && !empty($data['filter_medicine'])){
			$sql .= " AND LOWER(t.medicine_name) LIKE '" . $this->db->escape(strtolower($data['filter_medicine'])) . "%' ";	
		}

		if(isset($data['filter_medicine_id']) && !empty($data['filter_medicine_id'])){
			$sql .= " AND t.medicine_id IN " . $this->db->escape($data['filter_medicine_id']) . " ";	
		}

		$sql .= " GROUP BY `horse_id` ";
		$sql .= " ORDER BY `horse_id` ASC";
		//echo $sql;exit;
		$query = $this->db->query($sql);
		return $query->num_rows;
	}
	
	public function gethorsetreated_endos($data) {
		$sql = "SELECT `dot`, `medicine_name`, `medicine_id`, `trainer_id` FROM `" . DB_PREFIX . "transaction` t "; 

		if(isset($data['filter_surgery']) && !empty($data['filter_surgery'])){
			$sql .= " LEFT JOIN `oc_medicine` m ON (t.medicine_id = m.medicine_id) WHERE t.`cancel_status` = '0' AND m.`is_surgery` = '1' ";
		} else {
			$sql .= " WHERE t.`cancel_status` = '0' ";
		}

		if (!empty($data['filter_name_id'])) {
			$sql .= " AND t.`horse_id` = '" . (int)$data['filter_name_id'] . "'";
		} 
		
		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(`dot`) = '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(`dot`) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		if (!empty($data['filter_doctor']) && $data['filter_doctor'] != '0') {
			$sql .= " AND t.`medicine_doctor_id` = '" . (int)$data['filter_doctor'] . "'";
		}

		if(isset($data['filter_medicine']) && !empty($data['filter_medicine'])){
			$sql .= " AND LOWER(t.medicine_name) LIKE '" . $this->db->escape(strtolower($data['filter_medicine'])) . "%' ";	
		}

		if(isset($data['filter_medicine_id']) && !empty($data['filter_medicine_id'])){
			$sql .= " AND t.medicine_id IN " . $this->db->escape($data['filter_medicine_id']) . " ";	
		}

		$sql .= " ORDER BY `dot` ASC";

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

	public function gethorsetreated($data) {
		$sql = "SELECT `dot`, `medicine_name`, `medicine_id`, `trainer_id` FROM `" . DB_PREFIX . "transaction` t "; 

		if(isset($data['filter_surgery']) && !empty($data['filter_surgery'])){
			$sql .= " LEFT JOIN `oc_medicine` m ON (t.medicine_id = m.medicine_id) WHERE t.`cancel_status` = '0' AND m.`is_surgery` = '1' ";
		} else {
			$sql .= " WHERE t.`cancel_status` = '0' ";
		}

		if (!empty($data['filter_name_id'])) {
			$sql .= " AND t.`horse_id` = '" . (int)$data['filter_name_id'] . "'";
		} 
		
		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(`dot`) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(`dot`) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		if (!empty($data['filter_doctor']) && $data['filter_doctor'] != '0') {
			$sql .= " AND t.`medicine_doctor_id` = '" . (int)$data['filter_doctor'] . "'";
		}

		if(isset($data['filter_medicine']) && !empty($data['filter_medicine'])){
			$sql .= " AND LOWER(t.medicine_name) LIKE '" . $this->db->escape(strtolower($data['filter_medicine'])) . "%' ";	
		}

		if(isset($data['filter_medicine_id']) && !empty($data['filter_medicine_id'])){
			$sql .= " AND t.medicine_id IN " . $this->db->escape($data['filter_medicine_id']) . " ";	
		}

		$sql .= " ORDER BY `dot` ASC";

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

	public function getall_transaction_group($data = array()) {
		$sql = "SELECT `transaction_id`, `horse_id` FROM `" . DB_PREFIX . "transaction` WHERE `cancel_status` = '0' "; 

		if (!empty($data['filter_name_id'])) {
			$sql .= " AND `horse_id` = '" . (int)$data['filter_name_id'] . "'";
		} 
		
		if (!empty($data['filter_date_start'])) {
			$sql .= " AND date(`dot`) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND date(`dot`) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		if (!empty($data['filter_doctor']) && $data['filter_doctor'] != '0') {
			$sql .= " AND `medicine_doctor_id` = '" . (int)$data['filter_doctor'] . "'";
		}
		
		$sql .= " AND `bill_status` = '1' ";
		$sql .= " GROUP BY `horse_id` ";
		$sql .= " ORDER BY `horse_id` ASC";
		//echo $sql;exit;
		$query = $this->db->query($sql);
		return $query->rows;
	}	
	
	public function getall_transaction($data = array()) {
		$sql = "SELECT `transaction_id`, `month`, `year`, `horse_id`, `medicine_doctor_id`, `trainer_id`, `dot` FROM `" . DB_PREFIX . "transaction` WHERE `cancel_status` = '0' "; 

		if (!empty($data['filter_name_id'])) {
			$sql .= " AND `horse_id` = '" . (int)$data['filter_name_id'] . "'";
		} 
		
		if (!empty($data['filter_date_start'])) {
			$sql .= " AND date(`dot`) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND date(`dot`) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		if (!empty($data['filter_doctor']) && $data['filter_doctor'] != '0') {
			$sql .= " AND `medicine_doctor_id` = '" . (int)$data['filter_doctor'] . "'";
		}

		$sql .= " AND `bill_status` = '1' ";

		$sql .= " ORDER BY `transaction_id` ASC";
		//echo $sql;
		//echo '<br />';
		//exit;
		$query = $this->db->query($sql);
		return $query->rows;
	}

	public function getbill_ids($transaction_id) {
		$sql = "SELECT `bill_id` FROM `" . DB_PREFIX . "bill` WHERE `transaction_id` = '".(int)$transaction_id."' AND `cancel_status` = '0' "; 
		//echo $sql;exit;
		$query = $this->db->query($sql);
		if($query->num_rows > 0){
			return $query->row['bill_id'];	
		} else {
			return 0;
		}
	}

	public function getbill_owner_group_by_trainer($bill_id_array) {
		$bill_ids = implode(',', $bill_id_array);
		$sql = "SELECT * FROM `" . DB_PREFIX . "bill_owner` bo LEFT JOIN `oc_trainer` t ON (bo.trainer_id = t.trainer_id) WHERE bo.`bill_id` IN (".$bill_ids.") AND bo.`cancel_status` = '0' "; 
		$sql .= " GROUP BY bo.`trainer_id` ORDER BY t.`name` ASC";
		//echo $sql;exit;
		$query = $this->db->query($sql);
		return $query->rows;	
		
	}

	public function getbill_owner_by_trainer($data = array()) {
		$sql = "SELECT bo.* FROM `oc_bill_owner` bo LEFT JOIN `oc_transaction` t ON (t.horse_id = bo.horse_id AND t.month = bo.month AND t.year = bo.year) WHERE bo.`cancel_status` = '0' AND t.`cancel_status` = '0' "; 
		
		if (!empty($data['filter_date_start'])) {
			$sql .= " AND date(t.`dot`) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND date(t.`dot`) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		if (!empty($data['filter_doctor']) && $data['filter_doctor'] != '0') {
			$sql .= " AND t.`medicine_doctor_id` = '" . (int)$data['filter_doctor'] . "' AND bo.`doctor_id` = '" . (int)$data['filter_doctor'] . "'";
		}

		if (!empty($data['filter_trainer_id'])) {
			$sql .= " AND bo.`trainer_id` = '" . (int)$data['filter_trainer_id'] . "'";
		}
		
		// if (!empty($data['filter_transaction_type'])) {
		// 	$sql .= " AND bo.`transaction_type` = '" . (int)$data['filter_transaction_type'] . "'";
		// }

		$sql .= " GROUP BY bo.`horse_id`,  bo.owner_id ORDER BY `bill_id`, `transaction_type`, `owner_id` ASC ";
		//echo $sql;exit;
		$query = $this->db->query($sql);
		return $query->rows;	
		
	}

	public function getbill_owner_group_by_owner($bill_id_array) {
		$bill_ids = implode(',', $bill_id_array);
		$sql = "SELECT * FROM `" . DB_PREFIX . "bill_owner` bo LEFT JOIN `oc_owner` o ON (bo.owner_id = o.owner_id) WHERE `bill_id` IN (".$bill_ids.") AND `cancel_status` = '0' "; 
		$sql .= " GROUP BY bo.`owner_id` ORDER BY o.`name` ASC";
		//echo $sql;exit;
		$query = $this->db->query($sql);
		return $query->rows;	
		
	}

	public function getbill_owner_by_owner($data = array()) {
		$sql = "SELECT bo.* FROM `oc_bill_owner` bo LEFT JOIN `oc_transaction` t ON (t.horse_id = bo.horse_id AND t.month = bo.month AND t.year = bo.year) WHERE t.`cancel_status` = '0' AND bo.`cancel_status` = '0' "; 
		
		if (!empty($data['filter_date_start'])) {
			$sql .= " AND date(t.`dot`) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND date(t.`dot`) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		if (!empty($data['filter_doctor']) && $data['filter_doctor'] != '0') {
			$sql .= " AND t.`medicine_doctor_id` = '" . (int)$data['filter_doctor'] . "'";
		}

		if (!empty($data['filter_trainer_id'])) {
			$sql .= " AND bo.`trainer_id` = '" . (int)$data['filter_trainer_id'] . "'";
		}

		if (!empty($data['filter_owner_id'])) {
			$sql .= " AND bo.`owner_id` = '" . (int)$data['filter_owner_id'] . "'";
		}

		$sql .= " GROUP BY bo.`horse_id` ";
		//echo $sql;exit;
		$query = $this->db->query($sql);
		return $query->rows;	
	}

	public function get_log_trainer_group($data = array()) {
		$sql = "SELECT `trainer_id` FROM `" . DB_PREFIX . "transaction` WHERE `cancel_status` = '0' "; 

		if (!empty($data['filter_date_start'])) {
			$sql .= " AND date(`dot`) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND date(`dot`) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		if (!empty($data['filter_trainer_id']) && $data['filter_trainer_id'] != '0') {
			$sql .= " AND `trainer_id` = '" . (int)$data['filter_trainer_id'] . "'";
		}

		if (!empty($data['filter_doctor']) && $data['filter_doctor'] != '0') {
			$sql .= " AND `medicine_doctor_id` = '" . (int)$data['filter_doctor'] . "'";
		}

		$sql .= " GROUP BY `trainer_id` ";
		$sql .= " ORDER BY `trainer_id` DESC";
		// echo $sql;
		// echo '<br />';
		// exit;
		$query = $this->db->query($sql);
		return $query->rows;
	}

	public function get_log_trainer_wise_horse_group($data = array()) {
		$sql = "SELECT `horse_id` FROM `" . DB_PREFIX . "transaction` WHERE `cancel_status` = '0' "; 

		if (!empty($data['filter_date_start'])) {
			$sql .= " AND date(`dot`) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND date(`dot`) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		if (!empty($data['filter_doctor']) && $data['filter_doctor'] != '0') {
			$sql .= " AND `medicine_doctor_id` = '" . (int)$data['filter_doctor'] . "'";
		}

		if (!empty($data['filter_trainer_id'])) {
			$sql .= " AND `trainer_id` = '" . (int)$data['filter_trainer_id'] . "'";
		}

		$sql .= " GROUP BY `horse_id` ";
		$sql .= " ORDER BY `horse_id` ASC";
		//echo $sql;
		//echo '<br />';
		//exit;
		$query = $this->db->query($sql);
		return $query->rows;
	}

	public function get_log_trainer_wise_medicine_wise($data = array()) {
		$sql = "SELECT `medicine_name`, `medicine_price` AS `medicine_price` , `medicine_quantity` AS `medicine_quantity`, `dot` FROM `" . DB_PREFIX . "transaction` WHERE `cancel_status` = '0' "; 

		if (!empty($data['filter_date_start'])) {
			$sql .= " AND date(`dot`) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND date(`dot`) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		if (!empty($data['filter_doctor']) && $data['filter_doctor'] != '0') {
			$sql .= " AND `medicine_doctor_id` = '" . (int)$data['filter_doctor'] . "'";
		}

		if (!empty($data['filter_trainer_id'])) {
			$sql .= " AND `trainer_id` = '" . (int)$data['filter_trainer_id'] . "'";
		}

		if (!empty($data['filter_horse_id'])) {
			$sql .= " AND `horse_id` = '" . (int)$data['filter_horse_id'] . "'";
		}

		$sql .= " ORDER BY `dot`, `medicine_id` ASC";
		//echo $sql;
		//echo '<br />';
		//exit;
		$query = $this->db->query($sql);
		return $query->rows;
	}

	public function snippetdata(){
		$data[1] = array(
		 	'month' => '01',
		 	'year' => '2020'
		 );
		
		// echo '<pre>';
		// print_r($data);
		// exit;
		foreach($data as $dkey => $dvalue){
			$bill_owners_sql = "SELECT `bill_id`, `owner_id`, `owner_share` FROM `" . DB_PREFIX . "bill_owner` WHERE `owner_id` <> '0' AND `month` = '".$dvalue['month']."' AND `year` = '".$dvalue['year']."' ORDER BY `owner_id` ";
			//echo $bill_owners_sql;exit;
			$bill_owners = $this->db->query($bill_owners_sql)->rows;
			foreach ($bill_owners as $bokey => $bovalue) {
				$bill_data_sql = "SELECT `transaction_id` FROM `" . DB_PREFIX . "bill` WHERE `bill_id` = '".$bovalue['bill_id']."' ";
				$bill_datas = $this->db->query($bill_data_sql)->rows;
				foreach ($bill_datas as $bkey => $bvalue) {
					$transaction_data_sql = "SELECT `medicine_id`, `medicine_name`, `medicine_quantity`, `dot` FROM `" . DB_PREFIX . "transaction` WHERE `transaction_id` = '".$bvalue['transaction_id']."' ";
					$transaction_datas = $this->db->query($transaction_data_sql)->rows;
					foreach ($transaction_datas as $tkey => $tvalue) {
						$share_quantity = $tvalue['medicine_quantity'] * $bovalue['owner_share'] / 100;
						$owner_name = $this->get_owner_name($bovalue['owner_id']);
						$owner_medicine_sql = "INSERT INTO `" . DB_PREFIX . "owner_medicine` SET `owner_id` = '".$bovalue['owner_id']."', `owner_name` = '".$this->db->escape($owner_name)."', `medicine_id` = '".$tvalue['medicine_id']."', `medicine_name` = '".$this->db->escape($tvalue['medicine_name'])."', `quantity` = '".$share_quantity."', `dot` = '".$tvalue['dot']."' ";
						$this->db->query($owner_medicine_sql);
						// echo '<pre>';
						// print_r($bovalue);
						// echo '<pre>';
						// print_r($bvalue);
						// echo '<pre>';
						// print_r($tvalue);
						// echo $owner_medicine_sql;
						// exit;
					}		
				}
			}
		}
		echo 'Done';exit;
	}

	public function getownerbymedicne($data){
		$sql = "SELECT `owner_name`, `owner_id`, `medicine_name`, SUM(quantity) AS quantity_share FROM `" . DB_PREFIX . "owner_medicine` WHERE 1=1 ";
		if (!empty($data['filter_date_start'])) {
			$sql .= " AND date(`dot`) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND date(`dot`) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		if (!empty($data['filter_name_id'])) {
			$sql .= " AND `owner_id` = '" . (int)$data['filter_name_id'] . "'";
		}

		$sql .= " GROUP BY owner_id, medicine_id ORDER BY owner_id ";
		//echo $sql;exit;
		$query = $this->db->query($sql);
		return $query->rows;
	}

	public function getbill_owner_group_statement($data = array()) {
		$sql = "SELECT bo.`owner_id`, bo.`responsible_person`, bo.`responsible_person_id` FROM `oc_bill_owner` bo WHERE bo.`cancel_status` = '0' "; 
		
		if (!empty($data['filter_month'])) {
			$sql .= " AND bo.`month` = '" . $this->db->escape($data['filter_month']) . "'";
		}

		if (!empty($data['filter_year'])) {
			$sql .= " AND bo.`year` = '" . $this->db->escape($data['filter_year']) . "'";
		}

		if (!empty($data['filter_doctor']) && $data['filter_doctor'] != '0') {
			$sql .= " AND bo.`doctor_id` = '" . (int)$data['filter_doctor'] . "'";
		}

		if (!empty($data['filter_name_id'])) {
			$sql .= " AND bo.`responsible_person_id` = '" . $this->db->escape($data['filter_name_id']) . "'";
		}

		//$sql .= " GROUP BY bo.`responsible_person_id` ";
		// echo "<pre>";
		// print_r($this->db->query($sql)->rows);
		// exit();
		$query = $this->db->query($sql);
		return $query->rows;	
	}

	public function getbill_owner_statement($data = array()) {
		$sql = "SELECT bo.* FROM `oc_bill_owner` bo WHERE bo.`cancel_status` = '0' "; 
		
		if (!empty($data['filter_month'])) {
			$sql .= " AND bo.`month` = '" . $this->db->escape($data['filter_month']) . "'";
		}

		if (!empty($data['filter_year'])) {
			$sql .= " AND bo.`year` = '" . $this->db->escape($data['filter_year']) . "'";
		}

		if (!empty($data['filter_doctor']) && $data['filter_doctor'] != '0') {
			$sql .= " AND bo.`doctor_id` = '" . (int)$data['filter_doctor'] . "'";
		}

		if (!empty($data['filter_name_id'])) {
			$sql .= " AND bo.`responsible_person_id` = '" . $this->db->escape($data['filter_name_id']) . "'";
		}

		if (!empty($data['filter_responsible_person'])) {
			$sql .= " AND bo.`responsible_person_id` = '" . $this->db->escape($data['filter_responsible_person']) . "' ";
		}

		$sql .= " ORDER BY bo.`bill_id` ";
		// echo $sql;exit;
		$query = $this->db->query($sql);
		return $query->rows;	
	}

	public function getbill_owner_email($data = array()) {
		$sql = "SELECT bo.* FROM `oc_bill_owner` bo WHERE bo.`cancel_status` = '0' "; 
		
		if (!empty($data['filter_month'])) {
			$sql .= " AND bo.`month` = '" . $this->db->escape($data['filter_month']) . "'";
		}

		if (!empty($data['filter_year'])) {
			$sql .= " AND bo.`year` = '" . $this->db->escape($data['filter_year']) . "'";
		}

		if (!empty($data['filter_doctor']) && $data['filter_doctor'] != '0') {
			$sql .= " AND bo.`doctor_id` = '" . (int)$data['filter_doctor'] . "'";
		}

		if (!empty($data['filter_name_id'])) {
			$sql .= " AND bo.`owner_id` = '" . (int)$data['filter_name_id'] . "'";
		}

		$sql .= " ORDER BY bo.`bill_id` ";
		//echo $sql;exit;
		$query = $this->db->query($sql);
		return $query->rows;	
	}

	public function getbill_owner_by_owner_email($data = array()) {
		$sql = "SELECT bo.* FROM `oc_bill_owner` bo LEFT JOIN `oc_transaction` t ON (t.horse_id = bo.horse_id AND t.month = bo.month AND t.year = bo.year) WHERE t.`cancel_status` = '0' AND bo.`cancel_status` = '0' "; 
		
		if (!empty($data['filter_month'])) {
			$sql .= " AND bo.`month` = '" . $this->db->escape($data['filter_month']) . "'";
		}

		if (!empty($data['filter_year'])) {
			$sql .= " AND bo.`year` = '" . $this->db->escape($data['filter_year']) . "'";
		}

		if (!empty($data['filter_doctor']) && $data['filter_doctor'] != '0') {
			$sql .= " AND t.`medicine_doctor_id` = '" . (int)$data['filter_doctor'] . "'";
		}

		if (!empty($data['filter_name_id'])) {
			$sql .= " AND bo.`owner_id` = '" . (int)$data['filter_name_id'] . "'";
		}

		$sql .= " GROUP BY bo.`horse_id` ";
		//echo $sql;exit;
		$query = $this->db->query($sql);
		return $query->rows;	
	}

	public function getbill_owner_summ_group_statement($data = array()) {
		$sql = "SELECT bo.`owner_id`, bo.`responsible_person`, bo.`responsible_person_id` FROM `oc_bill_owner` bo LEFT JOIN `oc_bill` b ON(b.`bill_id` = bo.`bill_id`) WHERE bo.`cancel_status` = '0' "; 
		
		if (!empty($data['filter_date_start'])) {
			$sql .= " AND b.`dot` >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND b.`dot` <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		if (!empty($data['filter_doctor']) && $data['filter_doctor'] != '0') {
			$sql .= " AND bo.`doctor_id` = '" . (int)$data['filter_doctor'] . "'";
		}

		if (!empty($data['filter_name_id'])) {
			$sql .= " AND bo.`responsible_person_id` = '" . $this->db->escape($data['filter_name_id']) . "'";
		}

		$sql .= " GROUP BY bo.`responsible_person_id` ";
		//echo $sql;exit;
		$query = $this->db->query($sql);
		return $query->rows;	
	}

	public function getbill_owner_statement_summ($data = array()) {
		$sql = "SELECT bo.`bill_id`, bo.`owner_amt`, bo.`owner_amt_rec`, b.`dot`, bo.`responsible_person`, bo.`doctor_id` FROM `oc_bill_owner` bo LEFT JOIN `oc_bill` b ON(b.`bill_id` = bo.`bill_id`) WHERE bo.`cancel_status` = '0' "; 
		
		if (!empty($data['filter_date_start'])) {
			$sql .= " AND b.`dot` >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND b.`dot` <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		if (!empty($data['filter_doctor']) && $data['filter_doctor'] != '0') {
			$sql .= " AND bo.`doctor_id` = '" . (int)$data['filter_doctor'] . "'";
		}

		// if (!empty($data['filter_name_id'])) {
		// 	$sql .= " AND bo.`responsible_person_id` = '" . $this->db->escape($data['filter_name_id']) . "'";
		// }

		if (!empty($data['filter_responsible_person'])) {
			$sql .= " AND bo.`responsible_person_id` = '" . $this->db->escape($data['filter_responsible_person']) . "' ";
		}

		$sql .= " GROUP BY bo.`bill_id` ORDER BY bo.`bill_id` ";
		//echo $sql;exit;
		$query = $this->db->query($sql);
		return $query->rows;	
	}

	public function get_owner_email_status($data = array()) {
		$sql = "SELECT * FROM oc_email_info WHERE 1=1"; 
		
		if (!empty($data['filter_date_start'])) {
			$sql .= " AND date >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND date <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		if (!empty($data['filter_type']) && $data['filter_type'] != '0') {
			$sql .= " AND report_type = '" . (int)$data['filter_type'] . "'";
		}

		if (!empty($data['filter_name_id'])) {
			$sql .= " AND owner_id = '" . $this->db->escape($data['filter_name_id']) . "'";
		}

		if (!empty($data['filter_doctor']) && $data['filter_doctor'] != '0') {
			$sql .= " AND doctor_id = '" . (int)$data['filter_doctor'] . "'";
		}

		$sort_data = array(
			'owner_name',
			'email',
			'report_name',
			'send_status',
			'date',
			'id',
			'time'
		);	

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY owner_name";	
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}					

			if ($data['limit'] < 1) {
				$data['limit'] = 50;
			}	

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}	
		//echo $sql;exit;
		$query = $this->db->query($sql);
		return $query->rows;	
	}

	public function get_owner_email_total($data = array()) {
		$sql = "SELECT COUNT(*) as total FROM oc_email_info WHERE 1=1"; 
		
		if (!empty($data['filter_date_start'])) {
			$sql .= " AND date >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND date <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		if (!empty($data['filter_type']) && $data['filter_type'] != '0') {
			$sql .= " AND report_type = '" . (int)$data['filter_type'] . "'";
		}

		if (!empty($data['filter_name_id'])) {
			$sql .= " AND owner_id = '" . $this->db->escape($data['filter_name_id']) . "'";
		}

		if (!empty($data['filter_doctor']) && $data['filter_doctor'] != '0') {
			$sql .= " AND doctor_id = '" . (int)$data['filter_doctor'] . "'";
		}

		$sql .= " ORDER BY owner_id";
		//echo $sql;exit;
		$query = $this->db->query($sql);
		return $query->row['total'];	
	}

	public function getbillids_groups($data = array()) {
		$sql = "SELECT b.`bill_id`, b.`horse_id`, b.`doctor_id`, b.`trainer_id`, b.`month`, b.`year`, bo.`responsible_person_id`, bo.`responsible_person`, bo.`owner_id` FROM `" . DB_PREFIX . "bill` b LEFT JOIN `oc_bill_owner` bo ON(bo.`bill_id` = b.`bill_id`) WHERE b.`cancel_status` = '0' "; 

		if (!empty($data['filter_date_start'])) {
			$sql .= " AND b.`dot` >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND b.`dot` <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}
		
		if (isset($data['filter_name_id']) && !empty($data['filter_name_id'])) {
			$sql .= " AND bo.`responsible_person_id` = '" . (int)$data['filter_name_id'] . "'";
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

		$sql .= " GROUP BY b.`bill_id` ";
		$sql .= " ORDER BY b.`bill_id` ASC";

		//echo $sql;exit;
		$query = $this->db->query($sql);
		return $query->rows;
	}

	public function getTransactionbyCategory_group($data) {
		$sql = "SELECT SUM(t.`medicine_total`) as `medicine_total`, SUM(t.`medicine_quantity`) as `medicine_quantity`, t.`trainer_id`, m.`category` FROM `oc_transaction` t LEFT JOIN `oc_medicine` m ON (m.`medicine_id` = t.`medicine_id`) WHERE t.`cancel_status` = '0' AND m.`category` <> '' ";
		if (!empty($data['filter_date_start'])) {
			$sql .= " AND t.`dot` >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}
		if (!empty($data['filter_date_end'])) {
			$sql .= " AND t.`dot` <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}
		if (!empty($data['filter_category'])) {
			$sql .= " AND m.`category` = '" . $this->db->escape($data['filter_category']) . "'";
		}
		if (!empty($data['filter_trainer_id'])) {
			$sql .= " AND t.`trainer_id` = '" . $this->db->escape($data['filter_trainer_id']) . "'";
		}
		if (!empty($data['filter_doctor'])) {
			$sql .= " AND t.`medicine_doctor_id` = '" . $this->db->escape($data['filter_doctor']) . "'";
		}
		$sql .= " GROUP BY `trainer_id`, `category` ";		
		//echo $sql;exit;
		$query = $this->db->query($sql);
		// echo '<pre>';
		// print_r($query->rows);
		// exit;
		return $query->rows;
	}
}
?>
