<?php
class ModelSaleOrder extends Model {
	public function addOrder($data) {
		
	}

	public function editOrder($order_id, $data) {
		
	}

	public function deleteOrder($order_id) {
		
	}

	public function getOrder($order_id) {
		return array();
	}

	public function getOrders($data = array()) {
		return array();
	}

	public function getOrderProducts($order_id) {
		return array();
	}

	public function getOrderOption($order_id, $order_option_id) {
		return array();
	}

	public function getOrderOptions($order_id, $order_product_id) {
		return array();
	}

	public function getOrderDownloads($order_id, $order_product_id) {
		return array();
	}

	public function getOrderVouchers($order_id) {
		return array();
	}

	public function getOrderVoucherByVoucherId($voucher_id) {
		return array();
	}

	public function getOrderTotals($order_id) {
		return array();
	}

	public function getTotalOrders($data = array()) {
		return 0;
	}

	public function getTotalOrdersByStoreId($store_id) {
		return 0;
	}

	public function getTotalOrdersByOrderStatusId($order_status_id) {
		return 0;
	}

	public function getTotalOrdersByLanguageId($language_id) {
		return 0;
	}

	public function getTotalOrdersByCurrencyId($currency_id) {
		return 0;
	}

	public function getTotalSales() {
		$query = $this->db->query("SELECT SUM(medicine_total) AS total FROM `" . DB_PREFIX . "transaction` WHERE 1=1 ");

		return $query->row['total'];
	}

	public function getTotalSales_received() {
		$query = $this->db->query("SELECT SUM(owner_amt_rec) AS total FROM `" . DB_PREFIX . "bill_owner` WHERE 1=1 ");

		return $query->row['total'];
	}

	public function getTotalSalesByYear($year) {
		return 0;
	}

	public function createInvoiceNo($order_id) {
		return '';
	}

	public function addOrderHistory($order_id, $data) {
		
	}

	public function getOrderHistories($order_id, $start = 0, $limit = 10) {
		return array();
	}

	public function getTotalOrderHistories($order_id) {
		return 0;
	}	

	public function getTotalOrderHistoriesByOrderStatusId($order_status_id) {
		return 0;
	}

	public function getEmailsByProductsOrdered($products, $start, $end) {
		return 0;
	}

	public function getTotalEmailsByProductsOrdered($products) {
		return 0;
	}

	public function getTotalHorses() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "horse`");
		return $query->row['total'];
	}

	public function gettotalTrainer() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "trainer`");
		return $query->row['total'];
	}

	public function getTotalOwner() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "owner`");
		return $query->row['total'];
	}

	public function getTotalMedicine() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "medicine`");
		return $query->row['total'];
	}

	public function getTransaction($data = array()) {
		$sql = "SELECT * FROM `" . DB_PREFIX . "transaction` WHERE 1=1 "; 

		$sort_data = array(
			'transaction_id'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY transaction_id";
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
}
?>
