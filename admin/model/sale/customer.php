<?php
class ModelSaleCustomer extends Model {
	public function addCustomer($data) {
		
	}

	public function editCustomer($customer_id, $data) {
		
	}

	public function editToken($customer_id, $token) {
		
	}

	public function deleteCustomer($customer_id) {
		
	}

	public function getCustomer($customer_id) {
		return array();
	}

	public function getCustomerByEmail($email) {
		return array();
	}

	public function getCustomers($data = array()) {
		return array();	
	}

	public function approve($customer_id) {
				
	}

	public function getAddress($address_id) {
		return array();
	}

	public function getAddresses($customer_id) {
		return array();
	}	

	public function getTotalCustomers($data = array()) {
		return 0;
	}

	public function getTotalCustomersAwaitingApproval() {
		return 0;
	}

	public function getTotalAddressesByCustomerId($customer_id) {
		return 0;
	}

	public function getTotalAddressesByCountryId($country_id) {
		return 0;
	}	

	public function getTotalAddressesByZoneId($zone_id) {
		return 0;
	}

	public function getTotalCustomersByCustomerGroupId($customer_group_id) {
		return 0;
	}

	public function addHistory($customer_id, $comment) {
		
	}	

	public function getHistories($customer_id, $start = 0, $limit = 10) { 
		return array();
	}	

	public function getTotalHistories($customer_id) {
		return 0;
	}	

	public function addTransaction($customer_id, $description = '', $amount = '', $order_id = 0) {
		
	}

	public function deleteTransaction($order_id) {
		
	}

	public function getTransactions($customer_id, $start = 0, $limit = 10) {
		return array();
	}

	public function getTotalTransactions($customer_id) {
		return 0;
	}

	public function getTransactionTotal($customer_id) {
		return 0;
	}

	public function getTotalTransactionsByOrderId($order_id) {
		return 0;
	}	

	public function addReward($customer_id, $description = '', $points = '', $order_id = 0) {
		
	}

	public function deleteReward($order_id) {
		
	}

	public function getRewards($customer_id, $start = 0, $limit = 10) {
		return array();
	}

	public function getTotalRewards($customer_id) {
		return 0;
	}

	public function getRewardTotal($customer_id) {
		return 0;
	}		

	public function getTotalCustomerRewardsByOrderId($order_id) {
		return 0;
	}

	public function getIpsByCustomerId($customer_id) {
		return array();
	}	

	public function getTotalCustomersByIp($ip) {
		return 0;
	}

	public function addBanIp($ip) {
		
	}

	public function removeBanIp($ip) {
		
	}

	public function getTotalBanIpsByIp($ip) {
		return 0;
	}	
}
?>
