<?php
$url = filemtime("/var/www/html/arcindia2016_web/wp-content/themes/point/js/js-image-slider.css");
echo $url;exit;
//$dbhost = 'localhost';
//$dbuser = 'root';
//$dbpass = '';
//$dbname = 'db_horse_phiroz';

exec('mysqldump --user=root --password="" --host=localhost db_horse_phiroz > "/usr/share/nginx/html/phiroz/download/db_horse_phiroz_bk.sql" ');
//$cmd  = 'C: & cd "C:\xampp\mysql\bin" & mysqldump.exe --user=root --password="" --host=localhost db_horse_phiroz > "C:\xampp\htdocs\phiroz\download\db_horse_phiroz_bk.sql" ';
//exec($cmd);
echo 'Done';
?>
<?php
	/*
   $dbname = 'db_horse_phiroz';	
   $dbhost = 'localhost';
   $dbuser = 'root';
   $dbpass = '';
   $backup_file = $dbname . date("Y-m-d-H-i-s") . '.gz';
   $command = "mysqldump --opt -h $dbhost -u $dbuser -p $dbpass ". "db_horse_phiroz | gzip > $backup_file";
   
   system($command);
   */
?>


ob_start();
?>
