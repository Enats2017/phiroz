<?php
class ModelTransactionTransaction extends Model {
	
	public function addhorse_wise($data) {
	// echo "<pre>"; print_r($data);exit;
		if(isset($data['medicines'])){
			foreach ($data['medicines'] as $okey => $ovalue) {
				$volume = 0 ;
				if ($ovalue['m_volume'] == 0) {
					$volume = $ovalue['volume'];
				} else {
					$volume = $ovalue['m_volume'];
				} 
				//echo $volume;  //exit;

				$this->db->query("INSERT INTO " . DB_PREFIX . "transaction SET 
								  horse_id = '" . (int)$data['h_name_id'] . "',
								  trainer_id = '" . (int)$data['h_trainer_id'] . "',
								  dot = '" . $this->db->escape($data['dot']) . "',
								  month = '" . $this->db->escape($data['month']) . "',
								  year = '" . $this->db->escape($data['year']) . "',
								  medicine_id = '" . (int)$ovalue['m_name_id'] . "', 
								  medicine_name = '" . $this->db->escape($ovalue['m_name']) . "', 
								  medicine_price = '" . (float)$ovalue['m_price'] . "', 
								  medicine_quantity = '" . (int)$ovalue['m_quantity'] . "', 
								  medicine_total = '" . (float)$ovalue['m_total'] . "', 
								  medicine_doctor_id = '" . (int)$ovalue['m_doctor_id'] . "',
								  treatment_name = '" . $this->db->escape($data['treatment_name']) . "',
								  volume = '".$volume."'  ");
								  //transaction_type = '" . (int)$data['transaction_type'] . "',
			}
		}
	}


	public function addmedicine_wise($data) {
		//$this->log->write(print_r($data,true));
		
		if(isset($data['medicines'])){
			foreach ($data['medicines'] as $mkey => $mvalue) {
				$volume = 0 ;
				if ($mvalue['m_volume'] == 0) {
					$volume = $mvalue['volume'];
				} else {
					$volume = $mvalue['m_volume'];
				} 
				//echo $volume; exit;

				foreach ($data['horses'] as $hkey => $hvalue) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "transaction SET 
				  		horse_id = '" . (int)$hvalue['h_name_id'] . "', 
				  		trainer_id = '" . (int)$hvalue['h_trainer_id'] . "',
				  		dot = '" . $this->db->escape($data['search_date_treatment']) . "',
				  		month = '" . $this->db->escape($data['month']) . "',
				  		year = '" . $this->db->escape($data['year']) . "',
				  		medicine_id = '" . (int)$mvalue['m_name_id'] . "', 
				  		medicine_name = '" . $this->db->escape($mvalue['m_name']) . "', 
				  		medicine_price = '" . (float)$mvalue['m_price'] . "', 
				  		medicine_quantity = '" . (int)$mvalue['m_quantity'] . "', 
				  		medicine_total = '" . (float)$mvalue['m_total'] . "', 
				  		medicine_doctor_id = '" . (int)$mvalue['m_doctor_id'] . "',
						treatment_name = '" . $this->db->escape($data['treatment_name']) . "',
				  		volume = '".$volume."' ");
				  		//transaction_type = '" . (int)$data['transaction_type'] . "',
				}
			}
		}
	}

	public function edithorse_wise($data) {
		//$this->log->write(print_r($data,true));
		if(isset($data['medicines'])){
			foreach ($data['medicines'] as $okey => $ovalue) {
				if($ovalue['transaction_id'] != '' && $ovalue['transaction_id'] != '0'){
					$this->db->query("UPDATE " . DB_PREFIX . "transaction SET 
					  horse_id = '" . (int)$data['h_name_id'] . "',
					  trainer_id = '" . (int)$data['h_trainer_id'] . "',
					  dot = '" . $this->db->escape($data['dot']) . "',
					  month = '" . $this->db->escape($data['month']) . "',
					  year = '" . $this->db->escape($data['year']) . "',
					  medicine_id = '" . (int)$ovalue['m_name_id'] . "', 
					  medicine_name = '" . $this->db->escape($ovalue['m_name']) . "', 
					  medicine_price = '" . (float)$ovalue['m_price'] . "', 
					  medicine_quantity = '" . (float)$ovalue['m_quantity'] . "', 
					  medicine_total = '" . (float)$ovalue['m_total'] . "', 
					  medicine_doctor_id = '" . (int)$ovalue['m_doctor_id'] . "' ,
					  treatment_name = '" . $this->db->escape($data['treatment_name']) . "'
					  WHERE transaction_id = '".(int)$ovalue['transaction_id']."' ");
					  //transaction_type = '" . (int)$data['transaction_type'] . "',
				} else {
					$this->db->query("INSERT INTO " . DB_PREFIX . "transaction SET 
					  horse_id = '" . (int)$data['h_name_id'] . "',
					  trainer_id = '" . (int)$data['h_trainer_id'] . "',
					  dot = '" . $this->db->escape($data['dot']) . "',
					  month = '" . $this->db->escape($data['month']) . "',
					  year = '" . $this->db->escape($data['year']) . "',
					  medicine_id = '" . (int)$ovalue['m_name_id'] . "', 
					  medicine_name = '" . $this->db->escape($ovalue['m_name']) . "', 
					  medicine_price = '" . (float)$ovalue['m_price'] . "', 
					  medicine_quantity = '" . (int)$ovalue['m_quantity'] . "', 
					  medicine_total = '" . (float)$ovalue['m_total'] . "',
					  treatment_name = '" . $this->db->escape($data['treatment_name']) . "', 
					  medicine_doctor_id = '" . (int)$ovalue['m_doctor_id'] . "' ");
				}
			}
		}
	}	

	public function gettrainername($trainer_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "trainer WHERE trainer_id = '".$trainer_id."'");
		$trainer_name = '';
		if($query->num_rows > 0){
			$trainer_name = $query->row['name'];
		}
		return $trainer_name;
	}

	public function gettrainerid($horse_id) {
		$query = $this->db->query("SELECT trainer FROM " . DB_PREFIX . "horse WHERE horse_id = '".$horse_id."'");
		$trainer_id = '';
		if($query->num_rows > 0){
			$trainer_id = $query->row['trainer'];
		}
		return $trainer_id;
	}

	public function getmedicineexist($medicine) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "medicine WHERE LOWER(name) = '".$this->db->escape(strtolower($medicine))."'");
		$is_exist = 0;
		if($query->num_rows > 0){
			$is_exist = $query->row['medicine_id'];
		}
		return $is_exist;
	}

	public function gethorseexist($horse) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "horse WHERE LOWER(name) = '".$this->db->escape(strtolower($horse))."'");
		$is_exist = 0;
		if($query->num_rows > 0){
			$is_exist = $query->row['horse_id'];
		}
		return $is_exist;
	}

	public function gettransactiondata($dot, $horse_id) {
		$sql = "SELECT * FROM `" . DB_PREFIX . "transaction` t WHERE `dot` = '".$dot."' AND `horse_id` = '".(int)$horse_id."' "; 
		//echo $sql;exit;
		$query = $this->db->query($sql);
		return $query->rows;
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

	public function get_doctor_name($doctor_id) {
		$sql = "SELECT `name` FROM `" . DB_PREFIX . "doctor` WHERE `doctor_id` = '".(int)$doctor_id."' "; 
		$query = $this->db->query($sql);
		$doctor_name = '';
		if($query->num_rows > 0){
			$horse_name = $query->row['name'];
		}
		return $horse_name;
	}

	public function get_travelsheet() {
		$sql = "SELECT d.name as m_doctor_name, d.doctor_id as m_doctor_id, m.name as m_name, m.medicine_id as m_name_id, m.rate as m_price, m.service as m_service FROM `" . DB_PREFIX . "travel_sheet` ts LEFT JOIN `" . DB_PREFIX . "medicine` m ON(ts.medicine_id = m.medicine_id) LEFT JOIN `" . DB_PREFIX . "doctor` d ON (m.doctor = d.doctor_id)"; 
		$query = $this->db->query($sql);
		$return_data = array();
		$m_field_row = 0;		
		foreach($query->rows as $data) {
			$return_data[$m_field_row]['m_name'] = $data['m_name'];
			$return_data[$m_field_row]['m_name_id'] = $data['m_name_id'];
			$return_data[$m_field_row]['m_field_row'] = $m_field_row;
			$return_data[$m_field_row]['m_doctor_name'] = $data['m_doctor_name'];
			$return_data[$m_field_row]['m_doctor_id'] = $data['m_doctor_id'];
			$return_data[$m_field_row]['transaction_id'] = '';
			$return_data[$m_field_row]['m_price'] = $data['m_price'] + $data['m_service'];
			$return_data[$m_field_row]['m_quantity'] = '1';
			$return_data[$m_field_row]['m_total'] = $data['m_price'];
			
			$m_field_row++; 						
		}
		return $return_data;
	}

	public function removetransaction($transaction_id){
		$query = $this->db->query("DELETE FROM " . DB_PREFIX . "transaction WHERE transaction_id = '".$transaction_id."'");
		//$this->log->write("DELETE FROM " . DB_PREFIX . "transaction WHERE transaction_id = '".$transaction_id."' ");
	}
}
?>
