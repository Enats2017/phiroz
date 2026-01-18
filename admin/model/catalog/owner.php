<?php
class ModelCatalogOwner extends Model {
	public function addOwner($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "owner SET name = '" . $this->db->escape(html_entity_decode($data['name'])) . "', transaction_type = '" . (int)$data['transaction_type'] . "', email = '" . $this->db->escape($data['email']) . "', responsible_person = '" . $this->db->escape($data['responsible_person']) . "', responsible_person_id = '" . $this->db->escape($data['responsible_person_id']) . "', balance = '" . $this->db->escape($data['balance']) . "', outstandingamount_ptk = '" . $this->db->escape($data['outstandingamount_ptk']) . "', outstandingamount_lmf = '" . $this->db->escape($data['outstandingamount_lmf']) . "', total = '" . $this->db->escape($data['total']) . "', opening_balance = '" . $this->db->escape($data['opening_balance']) . "', status = '" . $this->db->escape($data['status']) . "', phone = '" . $this->db->escape($data['phone']) . "' ");
		$owner_id = $this->db->getLastId();
	}

	public function editowner($owner_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "owner SET name = '" . $this->db->escape(html_entity_decode($data['name'])) . "', transaction_type = '" . (int)$data['transaction_type'] . "', email = '" . $this->db->escape($data['email']) . "', responsible_person = '" . $this->db->escape($data['responsible_person']) . "', responsible_person_id = '" . $this->db->escape($data['responsible_person_id']) . "', balance = '" . $this->db->escape($data['balance']) . "', outstandingamount_ptk = '" . $this->db->escape($data['outstandingamount_ptk']) . "', outstandingamount_lmf = '" . $this->db->escape($data['outstandingamount_lmf']) . "', total = '" . $this->db->escape($data['total']) . "', opening_balance = '" . $this->db->escape($data['opening_balance']) . "', status = '" . $this->db->escape($data['status']) . "', phone = '" . $this->db->escape($data['phone']) . "' WHERE owner_id = '" . (int)$owner_id . "'");
		$update = "UPDATE `oc_bill_owner` SET `responsible_person` = '".$this->db->escape(html_entity_decode($data['responsible_person']))."', `responsible_person_id` = '".$this->db->escape(html_entity_decode($data['responsible_person_id']))."' WHERE `owner_id` = '".$owner_id."' ";
		// echo $update;
		// echo '<br />';
		// exit;
		$this->db->query($update);
	}

	public function deleteowner($owner_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "owner WHERE owner_id = '" . (int)$owner_id . "'");
	}	

	public function getowner($owner_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "owner WHERE owner_id = '" . (int)$owner_id . "'");
		return $query->row;
	}

	public function getowners($data = array()) {


		$sql = "SELECT * FROM " . DB_PREFIX . "owner WHERE 1=1 ";

		if (!empty($data['filter_name'])) {
			$data['filter_name'] = html_entity_decode($data['filter_name']);
			$sql .= " AND LOWER(name) LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
			//$sql .= " AND LOWER(name) REGEXP '^" . $this->db->escape(strtolower($data['filter_name'])) . "'";
		}

		if (!isset($data['filter_status_all'])) {
			$sql .= " AND status = '1' ";
		}

		$in = 0;
		if (isset($data['filter_responsible_person']) && !empty($data['filter_responsible_person'])) {
			$in = 1;
			$data['filter_responsible_person'] = html_entity_decode($data['filter_responsible_person']);
			$sql .= " AND LOWER(responsible_person) LIKE '%" . $this->db->escape($data['filter_responsible_person']) . "%'";
		}

		$sort_data = array(
			'name'
		);	

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			if($in == 1){
				$sql .= " GROUP BY `responsible_person` ORDER BY name";
				//$sql .= " ORDER BY name";	
			} else {
				$sql .= " ORDER BY name";	
			}
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
		//$this->log->write($sql);
		$query = $this->db->query($sql);
		// echo '<pre>';
		// print_r($query);
		// exit;
		
		return $query->rows;
	}

	public function getTotalowners($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "owner WHERE 1=1 ";
		
		if (!empty($data['filter_name'])) {
			$sql .= " AND LOWER(name) LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!isset($data['filter_status_all'])) {
			$sql .= " AND status = '1' ";
		}

		$query = $this->db->query($sql);
		return $query->row['total'];
	}	
}
?>
