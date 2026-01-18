<?php
class ModelReportMedicinevol extends Model {
	public function getTotalMedicine($data) {
		$sql = "SELECT t.horse_id, t.medicine_name, t.medicine_price, t.dot, t.medicine_quantity, t.medicine_id FROM `oc_transaction` t LEFT JOIN `oc_medicine` m ON (m.medicine_id = t.medicine_id) WHERE 1=1 AND t.cancel_status = '0' ";
		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(t.dot) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(t.dot) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

	if (!empty($data['filter_name'])) {
			$sql .= " AND t.medicine_name = '" . $this->db->escape($data['filter_name']) . "'";
		}
		//$sql .= ' GROUP BY horse_id, medicine_name ORDER BY med_qty DESC';		
		$sql .= ' ORDER BY medicine_name ASC';
		$query = $this->db->query($sql);
		return $query->num_rows;
	}

	// public function getMedicine($data) {
	// 	$sql = "SELECT transaction_id, horse_id, medicine_name, medicine_price, dot, medicine_quantity, `medicine_id` FROM `oc_transaction` WHERE 1=1 AND cancel_status = '0' ";
	// 	if (!empty($data['filter_date_start'])) {
	// 		$sql .= " AND DATE(`dot`) >= '" . $this->db->escape($data['filter_date_start']) . "'";
	// 	}

	// 	if (!empty($data['filter_date_end'])) {
	// 		$sql .= " AND DATE(`dot`) <= '" . $this->db->escape($data['filter_date_end']) . "'";
	// 	}
	// 	//$sql .= ' GROUP BY horse_id, medicine_name ORDER BY med_qty DESC';		
	// 	$sql .= ' ORDER BY medicine_name ASC';		
	// 	//echo $sql;exit;
	// 	$query = $this->db->query($sql);
	// 	return $query->rows;
	// }

	public function getMedicine($data) { //print_r($data);//exit;

		$sql = "SELECT t.horse_id, t.medicine_name,t.dot, t.medicine_id, t.volume FROM `oc_transaction` t LEFT JOIN `oc_medicine` m ON (m.medicine_id = t.medicine_id) WHERE 1=1 AND t.cancel_status = '0' ";
		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(t.dot) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(t.dot) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		if (!empty($data['filter_name'])) {
			$sql .= " AND t.medicine_name = '" . $this->db->escape($data['filter_name']) . "'";
		}
		//$sql .= ' GROUP BY horse_id, medicine_name ORDER BY med_qty DESC';		
		$sql .= ' ORDER BY medicine_name ASC';		
		//echo $sql;exit;
		$query = $this->db->query($sql);
		// echo '<pre>';
		// print_r($query->rows);
		// exit;
		return $query->rows;
	}
}
?>
