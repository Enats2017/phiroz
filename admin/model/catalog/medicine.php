<?php
class ModelCatalogMedicine extends Model {
	public function addmedicine($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "medicine SET name = '" . $this->db->escape($data['name']) . "', doctor = '" . (int)$data['doctor'] . "', rate = '" . (float)$data['rate'] . "', service = '" . (float)$data['service'] . "', quantity = '" . (int)$data['quantity'] . "', travel_sheet = '" . (int)$data['travel_sheet'] . "', is_surgery = '" . (int)$data['is_surgery'] . "', volume = '" . $data['volume'] . "' , sirin = '" . $data['sirin'] . "' ");
		$medicine_id = $this->db->getLastId();
	}

	public function editmedicine($medicine_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "medicine SET name = '" . $this->db->escape($data['name']) . "', doctor = '" . (int)$data['doctor'] . "', rate = '" . (float)$data['rate'] . "', service = '" . (float)$data['service'] . "', quantity = '" . (int)$data['quantity'] . "', travel_sheet = '" . (int)$data['travel_sheet'] . "', is_surgery = '" . (int)$data['is_surgery'] . "', volume = '" . $data['volume'] . "' , sirin = '" . $data['sirin'] . "' WHERE medicine_id = '" . (int)$medicine_id . "'");
	}

	public function deletemedicine($medicine_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "medicine WHERE medicine_id = '" . (int)$medicine_id . "'");
	}	

	public function getmedicine($medicine_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "medicine WHERE medicine_id = '" . (int)$medicine_id . "'");
		return $query->row;
	}

	public function getmedicines($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "medicine WHERE 1=1 ";

		if (!empty($data['filter_name'])) {
			$data['filter_name'] = html_entity_decode($data['filter_name']);
			$sql .= " AND LOWER(name) LIKE '%" . $this->db->escape(strtolower($data['filter_name'])) . "%'";
			//$sql .= " AND LOWER(name) REGEXP '^" . $this->db->escape(strtolower($data['filter_name'])) . "'";
		}

		if (!empty($data['filter_doctor'])) {
			$sql .= " AND doctor = '" . (int)$data['filter_doctor'] . "'";
		}

		$sort_data = array(
			'name',
			'doctor'
		);	

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY name";	
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
				$data['limit'] = 20;
			}	

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}				

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getTotalmedicines($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "medicine WHERE 1=1 ";
		
		if (!empty($data['filter_name'])) {
			$sql .= " AND LOWER(name) LIKE '%" . $this->db->escape(strtolower($data['filter_name'])) . "%'";
		}

		if (!empty($data['filter_doctor'])) {
			$sql .= " AND doctor = '" . (int)$data['filter_doctor'] . "'";
		}

		$query = $this->db->query($sql);
		return $query->row['total'];
	}

	public function getdoctors() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "doctor");
		return $query->rows;
	}

	public function getdoctorname($doctor_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "doctor WHERE doctor_id = '".$doctor_id."'");
		$doctor_name = '';
		if($query->num_rows > 0){
			$doctor_name = $query->row['name'];
		}
		return $doctor_name;
	}

	public function getmedicinests($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "medicine WHERE `travel_sheet`= '1' ";

		if (!empty($data['filter_name'])) {
			$sql .= " AND LOWER(name) LIKE '%" . $this->db->escape(strtolower($data['filter_name'])) . "%'";
		}

		if (!empty($data['filter_doctor'])) {
			$sql .= " AND doctor = '" . (int)$data['filter_doctor'] . "'";
		}

		$sort_data = array(
			'name',
			'doctor'
		);	

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY name";	
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
				$data['limit'] = 20;
			}	

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}				

		$query = $this->db->query($sql);

		return $query->rows;
	}	
	
	public function getTotalmedicinests($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "medicine WHERE `travel_sheet`= '1' ";
		
		if (!empty($data['filter_name'])) {
			$sql .= " AND LOWER(name) LIKE '%" . $this->db->escape(strtolower($data['filter_name'])) . "%'";
		}

		if (!empty($data['filter_doctor'])) {
			$sql .= " AND doctor = '" . (int)$data['filter_doctor'] . "'";
		}

		$query = $this->db->query($sql);
		return $query->row['total'];
	}

	public function delete_travelsheet() {
		$this->db->query("DELETE FROM " . DB_PREFIX . "travel_sheet");		
	}

	public function insert_travelsheet($med_id) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "travel_sheet SET MEDICINE_ID = '" . $med_id . "'");		
	}

	public function get_travelsheet() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "travel_sheet");
		if($query->num_rows > 0){
			return $query->rows;
		} else {
			return '';
		}
				
	}

		
}
?>

