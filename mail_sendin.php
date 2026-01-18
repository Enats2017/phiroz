<section id="contact">
          <div class="container">
               <div class="row">

                    <div class="col-md-6 col-sm-12">
                         <form id="contact-form" role="form" action="mail_sendin.php" method="post">
                              <div class="col-md-12 col-sm-12">
                                   <input type="text" class="form-control" placeholder="Enter full name" name="name" required>
                    
                                   <input type="email" class="form-control" placeholder="Enter email address" name="email" required>

                                   <textarea class="form-control" rows="6" placeholder="Tell us about your message" name="message" required></textarea>
                              </div>

                              <div class="col-md-4 col-sm-12">
                                   <input type="submit" class="form-control" name="esubmit" value="Send Message">
                              </div>

                         </form>
                    </div>

               </div>
          </div>
     </section>       


<?php
require 'mailin-api-php-master/src/Sendinblue/Mailin.php';

  $subject = $_POST['name'];
  $filter_email = $_POST['email'];
  $message = $_POST['message'];

  $mailin = new Sendinblue\Mailin("https://api.sendinblue.com/v2.0",'bVN07jDRW85tLAJH');
 
    $data = array( "to" => array($filter_email=>$subject),
      // "cc" => array("saurabhshirke21@gmail.com"=>"saurabh shirke!"),
      "from" => array("info@enats.co.in", "demo demo"),
      "subject" => $subject,
      "text" => "This is the text",
      "html" => $message,
  );

   $res = $mailin->send_email($data);
   
   // var_dump($mailin->send_email($data));

  // echo "<pre>";
  // print_r($res);
  // exit;


?>


ob_start();
?>
