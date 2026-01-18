<?php
class ModelCatalogTrainer extends Model {
	public function addtrainer($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "trainer SET name = '" . $this->db->escape($data['name']) . "'");
		$trainer_id = $this->db->getLastId();
	}

	public function edittrainer($trainer_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "trainer SET name = '" . $this->db->escape($data['name']) . "' WHERE trainer_id = '" . (int)$trainer_id . "'");
	}

	public function deletetrainer($trainer_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "trainer WHERE trainer_id = '" . (int)$trainer_id . "'");
	}	

	public function gettrainer($trainer_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "trainer WHERE trainer_id = '" . (int)$trainer_id . "'");
		return $query->row;
	}

	public function gettrainers($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "trainer WHERE 1=1 ";

		if (!empty($data['filter_name'])) {
			$data['filter_name'] = html_entity_decode($data['filter_name']);
			$sql .= " AND LOWER(name) LIKE '%" . $this->db->escape(strtolower($data['filter_name'])) . "%'";
			//$sql .= " AND LOWER(name) REGEXP '^" . $this->db->escape(strtolower($data['filter_name'])) . "'";
		}

		$sort_data = array(
			'name'
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

	public function getTotaltrainers($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "trainer WHERE 1=1 ";
		
		if (!empty($data['filter_name'])) {
			$sql .= " AND LOWER(name) LIKE '%" . $this->db->escape(strtolower($data['filter_name'])) . "%'";
		}
		$query = $this->db->query($sql);
		return $query->row['total'];
	}	
}
?>
