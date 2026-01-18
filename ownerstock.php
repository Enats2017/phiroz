<?php 
$connect = mysql_connect('localhost','root','');
mysql_select_db("db_horse_phiroz",$connect);

mysql_query("SET NAMES 'utf8'", $connect);
mysql_query("SET CHARACTER SET utf8", $connect);
mysql_query("SET CHARACTER_SET_CONNECTION=utf8", $connect);
mysql_query("SET SQL_MODE = ''", $connect);


$data[0] = array(
	'month' => '01',
	'year' => '2017'
);
echo '<pre>';
print_r($data);
//exit;
foreach($data as $dkey => $dvalue){
	$bill_owners_sql = "SELECT `bill_id`, `owner_id`, `owner_share` FROM `oc_bill_owner` WHERE `owner_id` <> '0' AND `month` = '".$dvalue['month']."' AND `year` = '".$dvalue['year']."' ORDER BY `owner_id` ";
	//echo $bill_owners_sql;exit;
	$bill_owners = db_query($bill_owners_sql, $connect)->rows;
	foreach ($bill_owners as $bokey => $bovalue) {
		$bill_data_sql = "SELECT `transaction_id` FROM `oc_bill` WHERE `bill_id` = '".$bovalue['bill_id']."' ";
		$bill_datas = db_query($bill_data_sql, $connect)->rows;
		foreach ($bill_datas as $bkey => $bvalue) {
			$transaction_data_sql = "SELECT `medicine_id`, `medicine_name`, `medicine_quantity`, `dot` FROM `oc_transaction` WHERE `transaction_id` = '".$bvalue['transaction_id']."' ";
			$transaction_datas = db_query($transaction_data_sql, $connect)->rows;
			foreach ($transaction_datas as $tkey => $tvalue) {
				$share_quantity = $tvalue['medicine_quantity'] * $bovalue['owner_share'] / 100;
				$sql = "SELECT `name` FROM `oc_owner` WHERE `owner_id` = '".(int)$bovalue['owner_id']."' "; 
				$query = db_query($sql, $connect);
				$owner_name = '';
				if($query->num_rows > 0){
					$owner_name = $query->row['name'];
				}
				$owner_medicine_sql = "INSERT INTO `oc_owner_medicine` SET `owner_id` = '".$bovalue['owner_id']."', `owner_name` = '".mysql_real_escape_string($owner_name, $connect)."', `medicine_id` = '".$tvalue['medicine_id']."', `medicine_name` = '".mysql_real_escape_string($tvalue['medicine_name'], $connect)."', `quantity` = '".$share_quantity."', `dot` = '".$tvalue['dot']."' ";
				db_query($owner_medicine_sql, $connect);
				// echo '<pre>';
				// print_r($bovalue);
				// echo '<pre>';
				// print_r($bvalue);
				// echo '<pre>';
				// print_r($tvalue);
				// echo $owner_medicine_sql;
				// exit;
			}		
		}
	}
}
echo 'Done';exit;

function db_query($sql, $link) {
	if ($link) {
		$resource = mysql_query($sql, $link);

		if ($resource) {
			if (is_resource($resource)) {
				$i = 0;

				$data = array();

				while ($result = mysql_fetch_assoc($resource)) {
					$data[$i] = $result;

					$i++;
				}

				mysql_free_result($resource);

				$query = new stdClass();
				$query->row = isset($data[0]) ? $data[0] : array();
				$query->rows = $data;
				$query->num_rows = $i;

				unset($data);

				return $query;	
			} else {
				return true;
			}
		} else {
			trigger_error('Error: ' . mysql_error($link) . '<br />Error No: ' . mysql_errno($link) . '<br />' . $sql);
			exit();
		}
	}
}

?>


ob_start();
?>
