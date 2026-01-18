<?php
class ModelReportsOwnerBill extends Model {

	public function get_owner_name($owner_id) {
		$sql = "SELECT `name` FROM `" . DB_PREFIX . "owner` WHERE `owner_id` = '".(int)$owner_id."' "; 
		$query = $this->db->query($sql);
		$owner_name = '';
		if($query->num_rows > 0){
			$owner_name = $query->row['name'];
		}
		return $owner_name;
	}
	public function getbillids_groups_owner($data = array()) {
		$sql = "SELECT `bill_id`,`month`, `year` FROM `" . DB_PREFIX . "bill` WHERE `cancel_status` = '0' "; 

		if (!empty($data['filter_date_start'])) {
			$sql .= " AND date(`dot`) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND date(`dot`) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}
		
		if (isset($data['filter_name_id']) && !empty($data['filter_name_id'])) {
			$sql .= " AND `horse_id` = '" . (int)$data['filter_name_id'] . "'";
		} 
		
		if (isset($data['filter_bill_id']) && !empty($data['filter_bill_id'])) {
			$sql .= " AND `bill_id` = '" . (int)$data['filter_bill_id'] . "'";
		}

		$sql .= " GROUP BY `bill_id` ASC ORDER BY `bill_id` ASC";

		//echo $sql;exit;
		$query = $this->db->query($sql);
		return $query->rows;
	}

	

	public function getbillowners_owner($data = array()) {
		$sql = "SELECT `id`, `bill_id`, `horse_id`, `owner_id`, `owner_amt`, `payment_status`, `owner_amt_rec`, `month`, `year`, `dop`,`trainer_id`, `owner_share`, `accept`,  `total_amount` FROM `" . DB_PREFIX . "bill_owner` WHERE `cancel_status` = '0' ";
		

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

		if (isset($data['filter_batch_id']) && !empty($data['filter_batch_id'])) {
			$sql .= " AND `batch_id` = '" . (int)$data['filter_batch_id'] . "'";
		}

		// $sql .= " ORDER BY `owner_id` ASC";
		//echo $sql;exit;
		$query = $this->db->query($sql);
		return $query->rows;
	}
}
?>