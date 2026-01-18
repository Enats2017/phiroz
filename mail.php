<section id="contact">
          <div class="container">
               <div class="row">

                    <div class="col-md-6 col-sm-12">
                         <form id="contact-form" role="form" action="" method="post">
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
      
      require_once(DIR_SYSTEM . 'library/PHPMailer/PHPMailerAutoload.php');
      require_once(DIR_SYSTEM . 'library/PHPMailer/class.phpmailer.php');
      require_once(DIR_SYSTEM . 'library/PHPMailer/class.smtp.php');

       $subject = $_POST['name'];
        $from = $_POST['email'];
        $message = $_POST['message'];

      $mail = new PHPMailer();
      $message = "Dear ".$subject.". Thank you for your order. ";
      $subject = 'Your Piharaa order #'.$this->session->data['order_id'];
      $from_email =  'saurabhshirke21@gmail.com';
      $to_email = $from;
      $to_name = $subject;
      $mail->IsSMTP();
      $mail->SMTPAuth = true;
      $mail->Host = 'smtp.gmail.com';//$this->config->get('config_smtp_host');
      $mail->Port = '587';//$this->config->get('config_smtp_port');
      $mail->Username = 'swdsm100060@gmail.com';//$this->config->get('config_smtp_username');
      $mail->Password = 'Saurabh143@';//$this->config->get('config_smtp_password');
      $mail->SMTPOptions = array(
         'ssl' => array(
             'verify_peer' => false,
             'verify_peer_name' => false,
             'allow_self_signed' => true
         )
      );
      $mail->SMTPSecure = 'tls';
      $mail->SetFrom($from_email, 'Piharaa');
      $mail->Subject = $subject;
      //$mail->isHTML(true);
      //$mail->MsgHTML($invoice_mail_text);
      $mail->Body = html_entity_decode($message);
      //$mail->addAttachment($filename, $bfilename);
      $mail->AddAddress($to_email, $to_name);
      if($mail->Send()) {

      } else {
        echo "email send error";exit;
      }
          
?>


ob_start();
?>
