<!DOCTYPE html>
<html lang="en">
<head>

     <title>Greenopulence</title>

     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=Edge">
     <meta name="description" content="">
     <meta name="keywords" content="">
     <meta name="author" content="">
     <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

     <link rel="stylesheet" href="css/bootstrap.min.css">
     <link rel="stylesheet" href="css/font-awesome.min.css">
     <link rel="stylesheet" href="css/owl.carousel.css">
     <link rel="stylesheet" href="css/owl.theme.default.min.css">

     <!-- MAIN CSS -->
     <link rel="stylesheet" href="css/style.css">

</head>
<body id="top" data-spy="scroll" data-target=".navbar-collapse" data-offset="50">

     <!-- PRE LOADER -->
     <section class="preloader">
          <div class="spinner">

               <span class="spinner-rotate"></span>
               
          </div>
     </section>


     <!-- MENU -->
     <section class="navbar custom-navbar navbar-fixed-top" role="navigation">
          <div class="container">

               <div class="navbar-header">
                    <button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                         <span class="icon icon-bar"></span>
                         <span class="icon icon-bar"></span>
                         <span class="icon icon-bar"></span>
                    </button>

                    <!-- lOGO TEXT HERE -->
                    <a href="#" class="navbar-brand">Greenopulence</a>
               </div>

               <!-- MENU LINKS -->
               <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-nav-first">
                         <li><a href="index.html">Home</a></li>
                         <li style="display: none;"><a href="fleet.html">Fleet</a></li>
                         <li><a href="offers.html">Gallery</a></li>
                          <li><a href="about-us.html">About Us</a></li>
                         <li class="active"><a href="contact.html">Contact Us</a></li>
                    </ul>
               </div>

          </div>
     </section>

     <section>
          <div class="container">
               <div class="text-center">
                    <h1>Contact Us</h1>
                    <br>
                   <!--  <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illo, alias.</p> -->
               </div>
          </div>
     </section>


     <!-- CONTACT -->
     <section id="contact">
          <div class="container">
               <div class="row">

                    <div class="col-md-6 col-sm-12">
                         <form id="contact-form" role="form" action="contact.php" method="post">
                              <div class="col-md-12 col-sm-12">
                                   <input type="text" class="form-control" placeholder="Enter full name" name="name" required>
                    
                                   <input type="email" class="form-control" placeholder="Enter email address" name="email" required>

                                   <textarea class="form-control" rows="6" placeholder="Tell us about your message" name="message" required></textarea>
                              </div>

                              <div class="col-md-4 col-sm-12">
                                   <button class="form-control esubmit" >send message</button>
                              </div>

                         </form>
                    </div>

                    <div class="col-md-6 col-sm-12">
                         <div class="contact-image">
                              <img src="images/contact-1-600x400.jpg" class="img-responsive" alt="">
                         </div>
                    </div>

               </div>
          </div>
     </section>       


     <!-- FOOTER -->
     <footer id="footer">
          <div class="container">
               <div class="row">

                    <div class="col-md-4 col-sm-6">
                         <div class="footer-info">
                              <div class="section-title">
                                   <h2>Contact Info</h2>
                              </div>
                              <address>
                                   <p>+91 932-0218-272</p>
                                   <!-- <p><a href="mailto:contact@company.com">contact@company.com</a></p> -->
                              </address>
                         </div>
                    </div>
                     <div class="col-md-4 col-sm-6">
                        <div class="footer-info">
                          <div class="section-title">
                             <h2>Quick Links</h2>
                             <ul>
                                  <li><a href="index.html">Home</a></li>
                                  <li><a href="about-us.html">About Us</a></li>
                                  <li><a href="terms.html">Terms & Conditions</a></li>
                                  <li><a href="contact.html">Contact Us</a></li>
                             </ul>
                          </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                         <div class="footer-info newsletter-form">
                              <div class="section-title">
                                   <h2>Newsletter Signup</h2>
                              </div>
                              <div>
                                   <div class="form-group">
                                        <form action="#" method="get">
                                             <input type="email" class="form-control" placeholder="Enter your email" name="email" id="email" required>
                                             <input type="submit" class="form-control" name="submit" id="form-submit" value="Send me">
                                        </form>
                                        <span><sup>*</sup> Please note - we do not spam your email.</span>
                                   </div>
                              </div>
                         </div>
                    </div>
                    
               </div>
          </div>
     </footer>


     <!-- SCRIPTS -->
     <script src="js/jquery.js"></script>
     <script src="js/bootstrap.min.js"></script>
     <script src="js/owl.carousel.min.js"></script>
     <script src="js/smoothscroll.js"></script>
     <script src="js/custom.js"></script>

</body>
</html>

<?php
require 'mailin-api-php-master/src/Sendinblue/Mailin.php';

  $name = $_POST['name'];
  $filter_email = $_POST['email'];
  $message = $_POST['message'];

  $mailin = new Sendinblue\Mailin("https://api.sendinblue.com/v2.0",'bVN07jDRW85tLAJH');
 
    $data = array( "to" => array($filter_email=>$name),
      "from" => array("info@enats.co.in", "demo demo"),
      "subject" => $name,
      "text" => "This is the text",
      "html" => $message,
  );

   $res = $mailin->send_email($data);
   
   if($res['code'] == 'success'){
   
  }

    $json['status'] = 1;
    exit(json_encode($json));
?>


ob_start();
?>
