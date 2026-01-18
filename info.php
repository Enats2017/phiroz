<?php
require 'mailin-api-php-master/src/Sendinblue/Mailin.php';
$subject ='Equivets Vet Bills from Dr.Khambatta';
$statement_mail_text = 'Bills for the month of Jan 2021';
$statement_mail_text = str_replace(array("\r", "\n"), '', $statement_mail_text);

$mailin = new Sendinblue\Mailin("https://api.sendinblue.com/v2.0",'bVN07jDRW85tLAJH');
$data = array( "to" => array('pradnil99@gmail.com'=>'Pradnil'),
			  	// "cc" 		=> array("info@enats.co.in"=>"cc whom!")
		        "from" 		=> array("info@enats.co.in", "Accounts Equivets"),//phiroz2017@gmail.com,info@enats.co.in
		        "subject" 	=> $subject,
		        "html"		=> $statement_mail_text,
		        //"attachment"=> array(HTTP_CATALOG."download/".$bfilename)
		    );

$res = $mailin->send_email($data);
echo "<pre>"; 
print_r($res);
exit;
			
?>


ob_start();
?>
