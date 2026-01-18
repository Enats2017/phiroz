<?php

 	//require_once('PHPMailer/PHPMailerAutoload.php');
	// require_once('PHPMailer/class.phpmailer.php');
	// require_once('PHPMailer/class.smtp.php');

	require '../mailin-api-php-master/src/Sendinblue/Mailin.php';

$EmailClass = new EmailClass();
$old_currency_data = $EmailClass->sendemail();
echo 'out';exit;

Class EmailClass {
	public $conn;
	
	public function __construct() {
		$servername = "127.0.0.1";
		$username = "root";
		$password = "";
		$dbname = "db_horse_phiroz";
		$this->conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($this->conn->connect_error) {
			die("Connection failed: " . $this->conn->connect_error);
		}
	}

	public function db_query($sql, $conn) {
		$query = $conn->query($sql);

		if (!$conn->errno){
			if (isset($query->num_rows)) {
				$data = array();

				while ($row = $query->fetch_assoc()) {
					$data[] = $row;
				}

				$result = new stdClass();
				$result->num_rows = $query->num_rows;
				$result->row = isset($data[0]) ? $data[0] : array();
				$result->rows = $data;

				unset($data);

				$query->close();

				return $result;
			} else{
				return true;
			}
		} else {
			throw new ErrorException('Error: ' . $conn->error . '<br />Error No: ' . $conn->errno . '<br />' . $sql);
			exit();
		}
	}

	public function sendemail(){
		date_default_timezone_set('Asia/Kolkata');
		$sql = "SELECT * FROM `oc_owner` WHERE 1=1 AND total > '0'";
		$owner_datas = $this->db_query($sql, $this->conn);
		$owner_datas = $owner_datas->rows;

		$owneramount = 0;
		$billamount = 0;
		$amount = 0;

		foreach($owner_datas as $key){
			$datas = $this->db_query("SELECT * FROM `oc_bill_owner` WHERE owner_id = '".$key['owner_id']."' AND doctor_id = '2' AND ((month > 7 AND year = '2017') OR (year >= '2018'))", $this->conn);
			if($datas->num_rows > 0){
				$billamount = 0;
				$amount = 0;
				$owneramount = $key['outstandingamount_lmf'];
				foreach ($datas->rows as $data => $value) {
					$billamount = $billamount + $value['owner_amt'] - $value['owner_amt_rec'];
				}
				$amount = $amount + $owneramount + $billamount;
				$message = "<p style='margin-left:200px;'>Outstanding Statement</p><p style='margin-left:50px;'>This a reminder email that your account balance of Rs.".$amount."&nbsp;was overdue as of&nbsp;".date('d-m-Y').".<br>Enclosed is a statement of account for your reference.<br><br>Please arrange  payment of this account as soon as possible.<br><br>Your prompt attention to this matter would be greatly appreciated. If you have any queries <br>regarding this account, please contact Vaibhavi Telang on 9637445879 or Anil Pawar on <br>7718024903 as soon as possible.<br><br>if payment has recently been made, please let us know the mode and date of payment so<br>we can trace the payment and rectify our accounts accordingly.<br><br>Regards,<br>Phiroz</p>";

				if($amount > '0'){
				  	$mailin = new Sendinblue\Mailin("https://api.sendinblue.com/v2.0",'bVN07jDRW85tLAJH');
					$data = array( "to" => array($key['email']=>''),
				        "from" => array("phiroz2017@gmail.com", "Phiroz Khambatta"),
				        "subject" => 'test',
				        "text" => $message,
					);
					$res = $mailin->send_email($data);
					if($res['code'] == 'success'){
						$this->db_query("INSERT INTO oc_email_info SET
											owner_id = '".$key['owner_id']."',
											owner_name = '".$this->db->escape($key['name'])."',
											owner_email = '".$key['email']."',
											report_type = '4',
											report_name = 'Owner Weekly',
											doctor_id = '".$datas->row['doctor_id']."',
											send_status = '1',
											date = '".date('Y-m-d')."',
											time = '".date('h:i:s')."'
										",$this->conn);
						echo 'Mail Send';
					}else{
						$this->db_query("INSERT INTO oc_email_info SET
											owner_id = '".$key['owner_id']."',
											owner_name = '".$this->db->escape($key['name'])."',
											owner_email = '".$key['email']."',
											report_type = '4',
											report_name = 'Owner Weekly',
											doctor_id = '".$datas->row['doctor_id']."',
											send_status = '0',
											date = '".date('Y-m-d')."',
											time = '".date('h:i:s')."'
										",$this->conn);
						echo 'Mail Cannot be Send';	
					}
				}
			}
		}
	}
}
?>