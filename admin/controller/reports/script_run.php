 <?php
class Controllerreportsscriptrun extends Controller { 
	public function index() {  
		$query = $this->db->query("SELECT bill_id FROM oc_bill_owner WHERE 1=1 GROUP BY bill_id")->rows;
		foreach ($query as $value) {
			$q = $this->db->query("SELECT `id`,`bill_id` FROM oc_bill_owner WHERE bill_id = '".$value['bill_id']."' ")->rows;
			$update = 1;
			foreach ($q  as $svalue) {
				$this->db->query("UPDATE oc_bill_owner SET ref_id = '".$update."' WHERE  bill_id = '".$svalue['bill_id']."' AND id = '".$svalue['id']."'");
				// echo "<pre>";
				// print_r($update);
					$update++;
			}
		 }
				// exit;
			$this->redirect($this->url->link('bill/print_invoice', 'token=' . $this->session->data['token'], 'SSL'));
	}

}
?>
