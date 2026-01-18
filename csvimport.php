<?php

ini_set('memory_limit', '-1');
$connect = mysql_connect('localhost','root',"");
mysql_select_db("db_horse_phiroz",$connect);

mysql_query("SET NAMES 'utf8'", $connect);
mysql_query("SET CHARACTER SET utf8", $connect);
mysql_query("SET CHARACTER_SET_CONNECTION=utf8", $connect);
mysql_query("SET SQL_MODE = ''", $connect);
include "config.php";
ini_set ( 'max_execution_time', 5000); 
			//echo DIR_DOWNLOAD;exit;
		$t = DIR_DOWNLOAD."medicine.csv";
		$file=fopen($t,"r");
		$i=1;
		//echo $t;exit;
		while(($var=fgetcsv($file,10000,","))!== FALSE){
			if($i != 0) {
				
				$var0=addslashes($var[0]);//owner_id
				$var1=addslashes($var[1]);
				$var2=addslashes($var[2]);
				
				//$var9=addslashes($var[9]);
				
				// echo $var0;echo "<br>";
				// echo $var1;echo "<br>";
				// echo $var2;echo "<br>";
				if($var0 != ''){
					$insert = query("INSERT INTO `oc_medicine` SET `medicine_id` = '".$var0."', `name` = '".$var1."',`rate` = '".$var2."' ");	
					//echo "INSERT INTO  `oc_medicine` SET `medicine_id` = '".$var0."', `name` = '".$var1."', `rate` = '".$var2."'";echo "<br>";
					//$this->db->query($insert);	
				}

			}
			$i++;
			// echo "<pre>";print_r($var);
			// 	exit;
		}

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
