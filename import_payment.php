<?php 
ini_set('memory_limit', '-1');
$connect = mysql_connect('localhost','root',"");
mysql_select_db("db_horse_phiroz",$connect);

mysql_query("SET NAMES 'utf8'", $connect);
mysql_query("SET CHARACTER SET utf8", $connect);
mysql_query("SET CHARACTER_SET_CONNECTION=utf8", $connect);
mysql_query("SET SQL_MODE = ''", $connect);

//echo 'aaaa';exit;


$t = "download/phiroz_all.csv";
$file=fopen($t,"r");
$t1 = "download/phiroz_pending.csv";
$file1=fopen($t1,"r");
$i=0;
$pending = 0;
$bill_ids_array = array();
$pending_bill_ids_array = array();
while(($var=fgetcsv($file,1000,","))!==FALSE){
	$pending = 0;
	$var111=addslashes($var[0]);//bill_id
	$var11 = explode('/', $var111);
	$bill_id = $var11[0];
	//echo $bill_id;exit;
	$bill_ids_array[] = $bill_id;
}
while(($var1=fgetcsv($file1,1000,","))!==FALSE){
	$bill_id_raw=addslashes($var1[6]);//bill_id
	$bill_id_raw_exp = explode('#', $bill_id_raw);
	$bill_id_raw = explode('/', $bill_id_raw_exp[1]);
	$bill_id_pending = $bill_id_raw[0];
	$pending_bill_ids_array[] = $bill_id_pending;
}
$bill_ids_array = array_unique($bill_ids_array);
$pending_bill_ids_array = array_unique($pending_bill_ids_array);
$paid_bill_id_array = array();
foreach($bill_ids_array as $bkey => $bvalue){
	foreach($pending_bill_ids_array as $pkey => $pvalue){
		if($bvalue == $pvalue){
			$pending = 1;
			//echo 'Pending Bill Id : ' . $bvalue;
			//echo '<br />';
		} else{
			$bvalue_exp = explode('-', $bvalue);
			$paid_bill_id_array[] = $bvalue_exp[0];
			// echo 'Paid Bill Id : ' . $bvalue;
			// echo '<br />';
		}
	}
}
$paid_bill_id_array = array_unique($paid_bill_id_array);
$i=0;
foreach ($paid_bill_id_array as $pkey => $pvalue) {
	$bill_ids = query("SELECT `bill_id` FROM `oc_bill` WHERE `bill_id` = '".$pvalue."' ", $connect);
	if($bill_ids->num_rows > 0){			
		$bill_id = $bill_ids->row['bill_id'];
		$bill_owner_ids = query("SELECT * FROM `oc_bill_owner` WHERE `bill_id` = '".$bill_id."' ", $connect);
		foreach ($bill_owner_ids->rows as $bokey => $bovalue) {
			if($bovalue['owner_amt_rec'] == '0.00'){
				$update = "UPDATE `oc_bill_owner` SET `owner_amt_rec` = '".$bovalue['owner_amt']."', `payment_status` = '1' WHERE `bill_id` = '".$bovalue['bill_id']."' AND `owner_id` = '".$bovalue['owner_id']."' ";
				//echo $update;
				//echo '<br />';
				$i++;
				query($update, $connect);
			} 
		}
	} else {
		echo 'Bill Id Not Found : ' . $pvalue;
		echo '<br />';
	}
}
echo $i;
echo '<br />';
echo 'Done';exit;



function query($sql, $link) {
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
