<?php
class ControllerSnippetsSnippets extends Controller { 
	public function index() { 

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
					$insert = "INSERT INTO `oc_medicine` SET `medicine_id` = '".$var0."', `name` = '".$var1."',`rate` = '".$var2."' ";	
					//echo "INSERT INTO  `oc_medicine` SET `medicine_id` = '".$var0."', `name` = '".$var1."', `rate` = '".$var2."'";echo "<br>";
					$this->db->query($insert);	
				}

			}
			$i++;
			// echo "<pre>";print_r($var);
			// 	exit;
		}
		echo 'Done';exit;		
	}
}
?>
