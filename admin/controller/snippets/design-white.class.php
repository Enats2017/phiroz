<?php
class Design{
    var $jqueryJs,$js,$css,$bodyAttr;
    function startPage($pageTitle,$articleData=array()) {
        $metaOGAddl = '';
        $metaOGTitle = 'Royal Western India Turf Club (RWITC)';
        if (count($articleData) > 0) {
            $metaOGTitle = $articleData['title'];
            $metaOGAddl = '<meta property="og:url" content="http://www.rwitc.com/viewArticles.php?id='.getParameterNumber('id').'" />';
            $metaOGAddl = '<meta property="og:description" content="RWITC" />';
        }
        echo <<< PAGESTART
<!DOCTYPE html>
<html>

    <head>
        <title>Home - RWITC</title>
	<base href="http://www.rwitc.com" />
     <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
    <meta name="google-site-verification" content="NmaRSR1lflAt0uctM01UOUmyghX9SWYL7bPsu_1b78Q" />
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="content-language" content="en">
    <meta name="author" content="RWITC">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Royal Western India Turf Club">
    <meta name="keywords" content="Royal Western India Turf Club, RWITC">
    <meta name="revisit-after" content="4 days">
    <meta property="og:title" content="{$metaOGTitle}" />
    <meta name="google-site-verification" content="40YqU8CUU2lplCO_m0t500_1r2UDSmkQIeXtJCfQQGw" />
    <meta property="og:image" content="http://www.rwitc.com/images/newdesign/rwitcLogo.png" />
    {$metaOGAddl}
    <title>RWITC</title>

   
    <!-- <script type="text/javascript" src="/assets/gz_files/rwitc.min.js"></script>
      <link rel="stylesheet" href="/assets/gz_files/rwitc.min.css">
      <link href='https://fonts.googleapis.com/css?family=Roboto+Condensed' rel='stylesheet' type='text/css'>
      <link rel="stylesheet" href="/assets/css/main.min.css"> -->
    <link rel="stylesheet" href="/assets/css/owl.carousel.css">

      <script type="text/javascript" src="//code.jquery.com/jquery-1.10.2.js"></script>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    
    <script type="text/javascript" src="/js/superfish.js"></script>
    <script type="text/javascript" src="/js/supersubs.js"></script>
    <script type="text/javascript" src="/js/jquery.vticker-min.js"></script>
    <script type="text/javascript" src="/js/jquery.marquee.js"></script>
    <script type="text/javascript" src="/assets/js/owl.carousel.min.js"></script>
    <script type="text/javascript" src="/assets/js/flipclock.min.js"></script>
    <script type="text/javascript" src="/assets/js/count-down.js"></script>
    <script type="text/javascript" src="/assets/min_js/enhance.min.js"></script>
    <!-- Why is this jquery included, when it is not used -->
    <!-- <script language="javascript" type="text/javascript" src="/js/jquery.cycle.all.js"></script> -->



    <script type="text/javascript" src="/assets/js/bootstrap.min.js"></script>

       <link rel="stylesheet" href="/assets/css/bootstrap.min.css">

           <link rel="stylesheet" href="/assets/css/flipclock.css">


    <link rel="stylesheet" type="text/css" href="/assets/css/superfish.css" media="screen">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Custom styles for our template -->
    <link rel="stylesheet" href="/assets/css/bootstrap-theme.css" media="screen" >
    <link href='https://fonts.googleapis.com/css?family=Roboto+Condensed' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="/assets/css/main.css">
      {$this->js}
      {$this->css}
   <script type="text/javascript">
   /*HCTObj = new jQuery.noConflict();
   HCTObj(function(){


});
    */
    $(function(){
       $(".dropdown-menu > li > a.trigger").on("click",function(e){
        var current=$(this).next();
        var grandparent=$(this).parent().parent();
        if($(this).hasClass('left-caret')||$(this).hasClass('right-caret'))
            $(this).toggleClass('right-caret left-caret');
        grandparent.find('.left-caret').not(this).toggleClass('right-caret left-caret');
        grandparent.find(".sub-menu:visible").not(current).hide();
        current.toggle();
        e.stopPropagation();
    });
    $(".dropdown-menu > li > a:not(.trigger)").on("click",function(){
        var root=$(this).closest('.dropdown');
        root.find('.left-caret').toggleClass('right-caret left-caret');
        root.find('.sub-menu:visible').hide();
    });
           /* $('#ticker').cycle({
                fx:      'scrollLeft',
                speed : 2000,
                timeout:  6000
            });*/
            /*$('#banner').cycle({
                fx:      'fade',
                speed : 1000 ,
                width: 700,
                height: 250
            });*/
       $('marquee#sponsorBlock').marquee('pointer').mouseover(function () {
            $(this).trigger('stop');
        }).mouseout(function () {
            $(this).trigger('start');
        }).mousemove(function (event) {
            if ($(this).data('drag') == true) {
                this.scrollLeft = $(this).data('scrollX') + ($(this).data('x') - event.clientX);
            }
        }).mousedown(function (event) {
           $(this).data('drag', true).data('x', event.clientX).data('scrollX', this.scrollLeft);
        }).mouseup(function () {
            $(this).data('drag', false);
        });
       /* $('.daySponsor').cycle({
                    fx: 'fade',
                    speed : 1000 ,
                    width: '125px',
                    height: '125px'
        });*/
        {$this->jqueryJs}
        $('#username').focus(function(){
            if ($(this).val() == "Email") {
                $(this).val('');
            }
        });
        $('#username').focusout(function(){
            if ($.trim($(this).val()) == '') {
                $(this).val('Email');
            }
        });

        $('#password').focus(function(){
            if ($(this).val() == "Password") {
                $(this).val('');
            }
        });
        $('#password').focusout(function(){
            if ($.trim($(this).val()) == '') {
                $(this).val('Password');
            }
        });

        });
    </script>
    <script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-28228814-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<meta name="google-site-verification" content="ENeGh2_Z_Q82czmvYSwqrfw3hrhJS1GFORSYktDgCXs" />
</head>
<body>
PAGESTART;
    }


    function liveBoxes(){

        if (LINKSBOX) {
            echo <<< MEDIA_TIPS

<ul id="rightLinkslive" class="clearfix rightLinkslive">
    <li>
        <a href="/liveresults.php" class="colour1">
            <img src="/images/newdesign/live.png" alt="">
            <span class="rightTitle">LIVE RESULTS</span>
        </a>
    </li>

    <li>
        <a href="/rwitc_upload/static/live/MEDIATIPS.HTM" class="colour2">
            <img src="/images/newdesign/media.png" alt="">
            <span class="rightTitle">MEDIA TIPS</span>
        </a>
    </li>
    <li>
        <a href="/rwitc_upload/static/live/UPDATES.HTM" class="colour3">
            <img src="/images/newdesign/updates.png" alt="">
            <span class="rightTitle">UPDATES</span>
        </a>
    </li>
    <li>
        <a href="/rwitc_upload/static/live/ODDS.HTM" class="colour4">
            <img src="/images/newdesign/odds.png" alt="">
            <span class="rightTitle">CHANGING ODDS</span>
        </a>
    </li>
</ul>

MEDIA_TIPS;
        }
    }

    function liveBox() {



        if (ODDSBOX) {
            echo <<< ODDS_CONTENT
                <!--<div class="square">
                         <div class="squareHeader">
                            <img src='/images/tv.gif' alt='Race Telecast' />
                            <span style="padding-top: 8px;font-size:12px;"><a href="http://www.mumbairaces.com/live.php">Race Telecast</a></span>
                        </div>
                 </div>-->
                 <br />

                <script type='text/javascript'>
                function updateOdds() {
                      //$(".odds").html('Updating...');
                      $.ajax({
                        type: 'GET',
                        url: '/live.php?mode=odds',
                        timeout: 2000,
                        //beforeSend: function() {
                        //  $(".odds").html('Updating...');
                        //},
                        success: function(data) {
                                //console.log(data);
                        //alert(data);
                            if (data!=0) {
                                //alert(data);
                                $(".odds").html(data);

                            } else {
                               // $(".odds").html('Updating...');
                            }
                          window.setTimeout(updateOdds, 10000);
                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                          $(".odds").html('Retrying server...');
                          window.setTimeout(updateOdds, 10000);
                        }
                      });
                }
                 updateOdds();

                 </script>
ODDS_CONTENT;
        }
        if (FINALRESBOX) {
            echo <<< FINAL_CONTENT

                <script type='text/javascript'>
                function updateFinal() {
                  $(".final_div").html('Updating...');
                  $.ajax({
                    type: 'GET',
                    url: '/live.php?mode=final',
                    timeout: 2000,
                    success: function(data) {
                    	console.log(data);
                      //$(".final_div").html('');
			
                      $(".final_div").html(data);
                      //$(".final_div").html('');
                      window.setTimeout(updateFinal, 120000);
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                      $(".final_div").html('Retrying server...');
                      window.setTimeout(updateFinal, 10000);
                    }
                  })
                }
               /*$('#final_div').vTicker( {
                showItems: 1,
                height: 170,
                animation: 'fade',
                mousePause: true,
                pause: 5000
                });
*/
                 updateFinal();
                 </script>
FINAL_CONTENT;
        }


    }
    function writeLogoTickerMenuHome() {
        require_once('race.class.php');

        echo <<<TICKER
   <!-- Fixed navbar -->
    <div id="header">

            <!-- <div class="container"> -->
                <div class="navbar-header logo">

                    <a class="navbar-brand" href="/"><img src="assets/images/logo.png"></a>
                </div>
                <div class="navbar-collapse collapse ">
                    <ul class="nav navbar-nav" style="margin: 10px 0 0 350px;">
                        <li><img src="/assets/images/36th_asian.png" /></li>
                    </ul>
                    <div class="rightlogo">
                        <a href="/feedback.php">
                            <img src="assets/images/rightlogo.png">
                        </a>
                    </div>
                    <div class="socialmedia">
                        <a href="https://www.facebook.com/rwitcmumbai/" target="_blank"><img src="assets/images/fb.png"></a>
                        <a href="https://twitter.com/rwitcmumbai" target="_blank"><img src="assets/images/twit.png"></a>
                        <a href="https://www.instagram.com/rwitc/" target="_blank"><img src="assets/images/insta.png"></a>
                    </div>

                <!-- </div> -->

            </div>


    </div>

TICKER;
        self::siteMenu();
    }

    function writeLogoTickerMenu() {
        require_once('race.class.php');
        $dbObj = new dbTool();
        $raceObj = new Racedata($dbObj);
        $galleryDate = $raceObj->getMaxDate('racedate','gallery');
        echo <<<TICKER
   <!-- Fixed navbar -->
     <div id="header">

                <div class="navbar-header logo">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/index.php"><img src="../../assets/images/logo.png"></a>
                </div>
                <div class="navbar-collapse collapse ">
                    <ul class="nav navbar-nav">
                        <!-- <li><p id="title">ROYAL WESTERN INDIA TURF CLUB</p></li> -->
                        <li><img src="/assets/images/36th_asian.png" /></li>
                    </ul>
                    <div class="rightlogo">
                        <a href="/club/contactus.php"><img src="../../assets/images/rightlogo.png"></a>
                    </div>
                    <div class="socialmedia">
                        <a href="https://www.facebook.com/rwitcmumbai/" target="_blank"><img src="../../assets/images/fb.png"></a>
                        <a href="https://twitter.com/rwitcmumbai" target="_blank"><img src="../../assets/images/twit.png"></a>
                        <a href="https://www.instagram.com/rwitc/" target="_blank"><img src="../../assets/images/insta.png"></a>
                    </div>

                </div>



    </div>
TICKER;
        self::siteMenu();
    }

    function siteMenu() {
        echo <<<MENU
     <!-- Fixed navbar -->
    <div class="navbar navbar-inverse" style="background: #fc0606;" >
            <div class="navbar-header">
                <!-- Button for smallest screens -->
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="dropdown">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">THE CLUB<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="/club/aboutus.php"  >About RWITC</a>
                                </li>
                                <li>
                                    <a href="/club/vision-mission.php">Vision &amp; Mission</a>
                                </li>
                                <li>
                                    <a href="#" class="trigger right-caret">Organisation &amp; Management</a>
                                    <ul class="dropdown-menu sub-menu">
                                        <li><a href="/club/structure.php">Structure</a></li>
                                        <li><a href="/club/managingCommittee.php">Managing Committee</a></li>
                                        <li><a href="/club/stewardsOfclub.php">Stewards of the Club</a></li>
                                        <li><a href="/club/boardofAppeal.php">Board of Appeal</a></li>
                                        <li><a href="/club/working_group.php">Working Group</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a class="trigger right-caret" href="#">History</a>
                                    <ul class="dropdown-menu sub-menu">
                                        <li><a href="/club/timeline.php">Timeline / Major Events</a></li>
                                         <li><a href="/club/bequeathingLegacy.php">Bequeathing a Colonial Legacy</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a class="trigger right-caret" href="#">Charities</a>
                                    <ul class="dropdown-menu sub-menu">
                                        <li><a href="/club/charity.php">Charity Race Days</a></li>
                                    </ul>
                                </li>
                                <li><a href="/club/contributing.php">Contributing to the Community</a></li>
                                <li><a href="/club/responsible.php">Responsible Gambling</a></li>
                                <li><a href="/club/careers.php">Careers</a></li>
                                <li><a href="/club/contactus.php">Contact Us</a></li>
                            </ul>

                    </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Horse Racing</a>
                          <ul class="dropdown-menu">
                                    <li><a href="/horseracing/Medication Rules.pdf">Medication Rules 2015</a></li>
                                    <li><a href="/sweepstakes.php">Sweepstake Entries</a></li>
                                    <li><a href="/horseracing/beginnersGuide.php">Beginners Guide</a></li>
                                    <li><a href="/horseracing/rulesOfRacing.pdf">Rules of Racing</a></li>
                                    <li><a href="/horseracing/racingCalendar.pdf">Racing Calendar</a></li>
                                    <li><a href="/stewardsReport.php">Notice From Stewards</a></li>
                                    <li><a href="/horseracing/readyreckoner.php">Ready Reckoner</a></li>
                                    <li><a href="/trainerStatistics.php">Trainer's Statistics</a></li>
                                    <li><a href="/jockeyStatistics.php">Jockey's Statistics</a></li>
                                    <li><a href="/horseracing/jockey_weights.php">Jockey's Riding Weight</a></li>
                                    <li><a href="/horseracing/horsebodyWeight.php">Body Weight of Horses</a></li>
                                    <li><a href="/horseracing/record_timings.php">Record Timings</a></li>
                                    <li><a href="/horseracing/standard_timings.pdf">Standard Timings</a></li>
                                    <li><a href="/raceHistory.php">History of Graded Races</a></li>
                                    <li><a href="/horseracing/saddleCloth.php">Saddle Cloth Numbers</a></li>
                                   <!-- <li><a href="/horseracing/incomefromHeads.php">Income from Various Heads</a></li>-->
                         </ul>
                     </li>
                        <!--<li>
                        <a href="/rwitc-tv" class="rwitctvmenu">RWITC-TV</a>    
                     </li>-->
                     <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Betting &amp; Entertainment</a>
                            <ul class="dropdown-menu">
                                     <li><a href="/bettingentertainment/overview.php">Overview</a></li>
                                    <li><a href="/bettingentertainment/beginnersGuide.php">Beginners Guide</a></li>
                                    <li><a href="/bettingentertainment/waggeringTerms.php">Wagering Terms</a></li>
                                    <li><a href="/bettingentertainment/bettingPools.php">Betting Pools</a></li>
                                    <li><a href="/bettingentertainment/bettingChannels.php">Betting Channels</a></li>
                                    <li><a href="/bettingentertainment/deductionNorms.php">Deduction Norms</a></li>
                                    <li><a href="/bettingentertainment/offcourseBettingCentres.php">Off-Course Betting Centres</a></li>
                            </ul>
                     </li>
                   <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Membership</a>
                          <ul class="dropdown-menu">
                            <li><a href="/membership/overview.php">Overview</a></li>
                            <li><a href="/membership/privileges.php">Membership Privileges</a></li>
                            <!--<li><a href="/membership/olives.php">Olive</a></li>-->
                            <li><a href="/membership/categories.php">Categories</a></li>
                            <li><a href="/membership/rulesAndRegulations.php">Rules &amp; Regulations</a></li>
                            <li><a href="/membership/lawnFacilities.php">Lawn &amp; Facilities Booking Forms</a></li>
                          </ul>
                     </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Come Racing</a>
                          <ul class="dropdown-menu">
                             <li><a href="/comeracing/overview.php">Overview</a></li>
                            <li><a href="/comeracing/mumbairacecourse.php">Mumbai Race Course</a></li>
                            <li><a href="/comeracing/puneracecourse.php">Pune Race Course</a></li>
                            <li><a href="/comeracing/howToGetThere.php">How to get there</a></li>
                            <li><a href="/comeracing/services.php">Race Course Services &amp; Others</a></li>      </ul>
                     </li>

              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Advertising &amp; Sponsorship</a>
                  <ul class="dropdown-menu">
                       <li><a href="/sponsorships/overview.php">Overview</a></li>
                       <li><a href="/sponsorships/privileges.php">Sponsor's Privileges</a></li>
                       <li><a href="/sponsorships/opportunities.php">Advertising &amp; Sponsorship Opportunities</a></li>
                       <li><a href="/sponsorships/contactus.php">Contact Us</a></li>
                    <!--<li><a href="/sponsorships/sponsors.php">Our Sponsors</a></li>-->
                 </ul>
                </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Downloads</a>
                  <ul class="dropdown-menu">
                       <li><a href="/downloads/forms.php">Forms</a></li>
                       <li><a href="/downloads/Pune prospectus chart.pdf">Chart</a></li>
                       <li><a href="/downloads/Pune Prospectus Sheets 2016.pdf">Prospectus</a></li>
                 </ul>
                </li> 

                </ul>

            </div><!--/.nav-collapse -->
        </div>

    <!-- /.navbar -->
MENU;
    }

    function openDiv($id="",$class="") {
        echo "<div id='$id' class='$class'>";
    }

    function closeDiv() {
        echo "</div>";
    }


    function rightArea() {
        echo '<div id="rightArea" class="col-lg-3">';

        if (LINKSBOX) {
            echo <<< MEDIA_TIPS

MEDIA_TIPS;
        }
        if (ODDSBOX) {
            echo <<< ODDS_CONTENT

ODDS_CONTENT;
        }
        if (FINALRESBOX) {
            echo <<< FINAL_CONTENT

FINAL_CONTENT;
        }


        self::rightSponsor();
        ECHO <<< BOXES
            <div class="col-lg-12">
            <ul id="rightLinks" class="rightLinkstag clearfix">
                <!--<li>
                <div class="col-lg-12 rightspo1 ">
                    <a class="colour3" href="https://www.youtube.com/watch?v=j-AfMbVAwBc">
                    <div class="scolor s1">
                        <span class="rightTitle">Watch the Seminar held on Friday, 27th Feb 2015</span>
                     </div>
                    </a>
                    </div>
                </li>-->
               <li>
                    <div class="col-lg-12 rightspo2">
                    <a class="colour2" href="/availibilityCalendar.php">
                     <div class="scolor s2">
                        <span class="rightTitle">Grounds available for Schools & Colleges</span>
                    </div>
                    </a>
                   </div>
                </li>
                <li>
                 <div class="col-lg-12 rightspo3">
                    <a href="https://play.google.com/store/apps/details?id=com.rwitc.mobileweb" class="colour1">
                    <div class="scolor s3">
                        <span class="rightTitle">RWITC App on Google Play Store</span>
                    </div>
                    </a>
                 </div>
                </li>
                <li>       <div class="col-lg-12 rightspo4">
                    <a href="https://itunes.apple.com/us/app/rwitc/id619375717?ls=1&mt=8" class="colour2">
                <div class="scolor s4">
                        <span class="rightTitle">RWITC App on Apple Itunes</span>
                        </div>
                    </a>
                    </div>
                </li>
                <li>       <div class="col-lg-12 rightspo5">
                                <a href="http://appworld.blackberry.com/webstore/content/26326879/" class="colour4">
                            <div class="scolor s5">
                                    <span class="rightTitle">RWITC App on Blackberry Appworld</span>
                                    </div>
                                </a>
                              </div>
                            </li>
                <li>       <div class="col-lg-12 rightspo6">
                    <a href="/app-qr.php" class="colour3">
                <div class="scolor s6">
                        <span class="rightTitle">QR Code for RWITC App</span>
                        </div>
                    </a>
                    </div>
                </li>
                <li>       <div class="col-lg-12 rightspo7">
                    <a href="/performanceProfile.php" class="colour1">
                <div class="scolor s7">
                        <span class="rightTitle">Performance Profile of Horses</span>
                        </div>
                    </a>
                    </div>
                </li>
                <li>       <div class="col-lg-12 rightspo8">
                    <a href="http://www.horsein.com/" class="colour2">
                <div class="scolor s8">
                        <span class="rightTitle">Webportal for Owners/Trainers</span>
                    </div>
                    </a>
                    </div>
                </li>
                <li>       <div class="col-lg-12 rightspo9">
                    <a href="/calendar.php" class="colour3">
                <div class="scolor s9">
                        <span class="rightTitle">Racing Fixtures</span>
                        </div>
                    </a>
                    </div>
                </li>
                <li>
                    <div class="col-lg-12 rightspo10">
                    <a href="/horseRatings.php" class="colour4">
                    <div class="scolor s10">
                        <span class="rightTitle">Ratings of all Horses</span>
                        </div>
                    </a>
                    </div>
                </li>
                <li>
                       <div class="col-lg-12 rightspo11">
                    <a href="/horsesInTraining.php" class="colour1">
                <div class="scolor s11">
                        <span class="rightTitle">Horses in Training</span>
                        </div>
                    </a>
                    </div>
                </li>
                <li>
                       <div class="col-lg-12 rightspo12">
                    <a href="/dividends.php" class="colour2">
                <div class="scolor s12">
                        <span class="rightTitle">Tote Dividends</span>
                        </div>
                    </a>
                    </div>
                </li>
                <li>
                       <div class="col-lg-12 rightspo13">
                    <a href="http://www.indianstudbook.com/" class="colour3">
                <div class="scolor s13">
                        <span class="rightTitle">Indian Stud Book</span>
                        </div>
                    </a>
                    </div>
                </li>
                <!--<li>
                       <div class="col-lg-12 rightspo14">
                    <a href="/viewPgArticles.php" class="colour4">
                        <span class="rightTitle">PRAKASH GOSAVI COLUMN</span>
                    </a>
                </div>
                </li>-->
                <li>
                       <div class="col-lg-12 rightspo15">
                    <a href="/moneyLeaders.php" class="colour1">
                        <div class="scolor s14">
                        <span class="rightTitle">Money Leaders</span>
                        </div>
                    </a>
                    </div>
                </li>
                <li>
                       <div class="col-lg-12 rightspo16">
                    <a href="/downloads/Prospectus.pdf" class="colour2">
                       <div class="scolor s15">
                        <span class="rightTitle">Prospectus</span>
                        </div>
                    </a>
                    </div>
                </li>
                <li>
                       <div class="col-lg-12 rightspo17">
                    <a href="http://rwitclive.com/RaceArchives.aspx" class="colour3">
                        <div class="scolor s16">
                        <span class="rightTitle">Video Archives</span>
                        </div>
                    </a>
                    </div>
                </li>
                <li>
                  <div class="col-lg-12 rightspo18">
                    <a href="/feedback.php" class="colour2">
                        <div class="scolor s17">
                            <span class="rightTitle">Feedback</span>
                        </div>
                    </a>
                    </div>
                </li>
            </ul>
       </div>
BOXES;
    }


    function rightSponsor()
    {
        echo <<< RIGHT_FOOTER
    <div class="col-xs-12 col-sm-6 col-lg-12">
        <div class="row">
            <div class="sponserborder" id="sponsorside">
                <div class="sponsorLabel">
                 <img src="../../assets/images/sponserheader.png">
               </div>
                <div class="daySponsor">
                    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                                  <!-- Indicators -->


                      <!-- Wrapper for slides -->
                      <div class="carousel-inner" role="listbox">
                        <div class="item active">
                    <img width="150" height="150" src="/rwitc_upload/sponsor/PRA-Realty.jpg" alt='Sponsor of the day' />
					</div>
					<div class="item">
					<img width="150" height="150" src="/rwitc_upload/sponsor/Blue-Frog.jpg" alt='Sponsor of the day' />
					</div>
															
					<!-- Controls -->


                            </div>

                </div>
          </div>
        </div>
    </div>
RIGHT_FOOTER;
    }


    function endPage() {
        $sponsorList = $_SERVER['DOCUMENT_ROOT'] ."/rwitc_upload/sponsor_scroll.inc";
        $sponsors = file_get_contents($sponsorList);
        echo <<< FOOTER
<div class="col-xs-12 col-lg-12" id="sponsorBlockWrapper">
<div class="row">
    <h3 id="sponsorsTitle">SPONSORS</h3>
	<div id="sponsorBlock" style="background: #FFFFFF;">
        <marquee style="border: none; margin: 0; top: 0;" id="sponsorBlock" behavior="scroll" direction="left" scrollamount="2"  width="100%">
          $sponsors
        </marquee>
    </div>
</div>
</div>
</div>
</div>
</div>
</body>
</html>
FOOTER;
    }
}// class end ?>
