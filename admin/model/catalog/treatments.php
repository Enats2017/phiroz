<?php
class ModelCatalogTreatments extends Model {
	public function addtreatments($data) {	//echo"<pre>";print_r($data);exit;
		$this->db->query("INSERT INTO " . DB_PREFIX . "treatment_entry SET treatment_name = '" . $this->db->escape($data['name']) . "'");
		$treatment_id = $this->db->getLastId();
	}

	public function edittreatments($treatment_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "treatment_entry SET treatment_name = '" . $this->db->escape($data['name']) . "' WHERE treatment_id = '" . (int)$treatment_id . "'");
	}

	public function deletetreatments($treatment_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "treatment_entry WHERE treatment_id = '" . (int)$treatment_id . "'");
	}	

	public function gettreatments($treatment_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "treatment_entry WHERE treatment_id = '" . (int)$treatment_id . "'");
		return $query->row;
	}

	public function gettreatmentsdata($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "treatment_entry WHERE 1=1 ";
		// echo "<pre>";print_r($sql);exit;
		if (!empty($data['filter_name'])) {
			$data['filter_name'] = html_entity_decode($data['filter_name']);
			$sql .= " AND LOWER(treatment_name) LIKE '%" . $this->db->escape(strtolower($data['filter_name'])) . "%'";
			//$sql .= " AND LOWER(name) REGEXP '^" . $this->db->escape(strtolower($data['filter_name'])) . "'";
		}

		$sort_data = array(
			'treatment_name'
		);	

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY treatment_name";	
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

	public function getTotaltreatments($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "treatment_entry WHERE 1=1 ";
		
		if (!empty($data['filter_name'])) {
			$sql .= " AND LOWER(treatment_name) LIKE '%" . $this->db->escape(strtolower($data['filter_name'])) . "%'";
		}
		$query = $this->db->query($sql);
		return $query->row['total'];
	}	
}
?>
