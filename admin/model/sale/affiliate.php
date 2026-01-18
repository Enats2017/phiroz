<?php
class ModelSaleAffiliate extends Model {
	public function addAffiliate($data) {
		
	}

	public function editAffiliate($affiliate_id, $data) {
		
	}

	public function deleteAffiliate($affiliate_id) {
		
	}

	public function getAffiliate($affiliate_id) {
		return array();
	}

	public function getAffiliateByEmail($email) {
		return array();
	}

	public function getAffiliates($data = array()) {
		return array();	
	}

	public function approve($affiliate_id) {
		
	}

	public function getAffiliatesByNewsletter() {
		return array();
	}

	public function getTotalAffiliates($data = array()) {
		return 0;
	}

	public function getTotalAffiliatesAwaitingApproval() {
		return 0;
	}

	public function getTotalAffiliatesByCountryId($country_id) {
		return 0;
	}	

	public function getTotalAffiliatesByZoneId($zone_id) {
		return 0;
	}

	public function addTransaction($affiliate_id, $description = '', $amount = '', $order_id = 0) {
		
	}

	public function deleteTransaction($order_id) {
		
	}

	public function getTransactions($affiliate_id, $start = 0, $limit = 10) {
		return array();
	}

	public function getTotalTransactions($affiliate_id) {
		return 0;
	}

	public function getTransactionTotal($affiliate_id) {
		return 0;
	}	

	public function getTotalTransactionsByOrderId($order_id) {
		return 0;
	}		
}
?>
