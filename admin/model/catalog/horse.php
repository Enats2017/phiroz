<?php
class ModelCatalogHorse extends Model {
	public function addhorse($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "horse SET name = '" . $this->db->escape($data['name']) . "', trainer = '" . $this->db->escape($data['trainer_id']) . "' ");
		$horse_id = $this->db->getLastId();
		if(isset($data['owners'])){
			foreach ($data['owners'] as $okey => $ovalue) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "horse_owner SET  horse_id = '" . (int)$horse_id . "', owner = '" . $this->db->escape($ovalue['o_name_id']) . "', share = '" . (float)$ovalue['o_share'] . "' ");	
			}
		}
	}

	public function edithorse($horse_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "horse SET name = '" . $this->db->escape($data['name']) . "', trainer = '" . $this->db->escape($data['trainer_id']) . "' WHERE horse_id = '" . (int)$horse_id . "'");
		$this->db->query("UPDATE " . DB_PREFIX . "transaction SET `trainer_id` = '".$data['trainer_id']."' WHERE `horse_id` = '".$horse_id."' AND `bill_status` = '0' ");
		//$this->log->write("UPDATE " . DB_PREFIX . "transaction SET `trainer_id` = '".$data['trainer_id']."' WHERE `horse_id` = '".$horse_id."' AND `bill_status` = '0' ");
		$this->db->query("DELETE FROM " . DB_PREFIX . "horse_owner WHERE horse_id = '" . (int)$horse_id . "'");
		if(isset($data['owners'])){
			foreach ($data['owners'] as $okey => $ovalue) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "horse_owner SET  horse_id = '" . (int)$horse_id . "', owner = '" . $this->db->escape($ovalue['o_name_id']) . "', share = '" . (float)$ovalue['o_share'] . "' ");	
			}
		}	
	}

	public function deletehorse($horse_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "horse WHERE horse_id = '" . (int)$horse_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "horse_owner WHERE horse_id = '" . (int)$horse_id . "'");
	}	

	public function gethorse($horse_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "horse WHERE horse_id = '" . (int)$horse_id . "'");
		return $query->row;
	}

	public function gethorses($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "horse WHERE 1=1 ";

		if (!empty($data['filter_name'])) {
			$data['filter_name'] = html_entity_decode($data['filter_name']);
			$sql .= " AND LOWER(name) LIKE '%" . $this->db->escape(strtolower($data['filter_name'])) . "%'";
			//$sql .= " AND LOWER(name) REGEXP '^" . $this->db->escape(strtolower($data['filter_name'])) . "'";
		}

		if (!empty($data['filter_trainer_id'])) {
			$sql .= " AND trainer = '" . (int)$data['filter_trainer_id'] . "'";
		}

		$sort_data = array(
			'name',
			'trainer'
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
		//echo $sql;exit;
		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getTotalhorses($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "horse WHERE 1=1 ";
		
		if (!empty($data['filter_name'])) {
			$sql .= " AND LOWER(name) LIKE '%" . $this->db->escape(strtolower($data['filter_name'])) . "%'";
		}

		if (!empty($data['filter_trainer_id'])) {
			$sql .= " AND trainer = '" . (int)$data['filter_trainer_id'] . "'";
		}

		$query = $this->db->query($sql);
		return $query->row['total'];
	}

	public function getdoctors() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "doctor");
		return $query->rows;
	}

	public function gettrainername($trainer_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "trainer WHERE trainer_id = '".$trainer_id."'");
		$trainer_name = '';
		if($query->num_rows > 0){
			$trainer_name = $query->row['name'];
		}
		return $trainer_name;
	}

	public function getowners_assigned($horse_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "horse_owner WHERE horse_id = '" . (int)$horse_id . "'");
		return $query->rows;
	}

	public function getTotalhorsesBytrainerId($trainer_id){
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "horse WHERE trainer_id = '" . (int)$trainer_id . "'");
		return $query->row['total'];
	}

	public function getTotalhorsesByownerId($owner_id){
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "horse_owner WHERE owner = '" . (int)$owner_id . "'");
		return $query->row['total'];
	}

	public function gettrainerexist($trainer) {
		//$trainer = html_entity_decode($trainer);
		//$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "trainer WHERE LOWER(name) = '".$this->db->escape(strtolower($trainer))."'");
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "trainer WHERE `trainer_id` = '".$this->db->escape($trainer)."'");
		$is_exist = 0;
		if($query->num_rows > 0){
			$is_exist = $query->row['trainer_id'];
		}
		return $is_exist;
	}

	public function getownerexist($owner) {
		$owner = html_entity_decode($owner);
		//$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "owner WHERE LOWER(name) = '".$this->db->escape(strtolower($owner))."'");
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "owner WHERE `owner_id` = '".$this->db->escape($owner)."'");
		$is_exist = 0;
		if($query->num_rows > 0){
			$is_exist = $query->row['owner_id'];
		}
		return $is_exist;
	}
	
	public function getownername($owner_id){
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "owner WHERE `owner_id` = '".$owner_id."'");
		$owner_name = 0;
		if($query->num_rows > 0){
			$owner_name = $query->row['name'];
		}
		return $owner_name;	
	}
		
}
?>
