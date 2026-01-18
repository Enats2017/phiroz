<?php

if(isset($this->request->get['route'])){
	$current_location = explode("/", $this->request->get['route']);
	if($current_location[0] == "common"){
		$is_homepage = TRUE;
	}else{
		$is_homepage = FALSE;
	}
}else{
	$is_homepage = FALSE;
}

$get_url = explode("&", $_SERVER['QUERY_STRING']);

$get_route = substr($get_url[0], 6);

$get_route = explode("/", $get_route);

$page_name = array("shoppica2","journal_banner","journal_bgslider","journal_cp","journal_filter","journal_gallery","journal_menu","journal_product_slider","journal_product_tabs","journal_rev_slider","journal_slider");

// array_push($page_name, "EDIT-ME");

if(array_intersect($page_name, $get_route)){
	$is_custom_page = TRUE;
}else{
	$is_custom_page = FALSE;
}

?>
<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" xml:lang="<?php echo $lang; ?>">
<head>
	<meta charset="utf-8" />
	<title><?php echo $title; ?></title>
	<base href="<?php echo $base; ?>" />
	<?php if ($description) { ?>
	<meta name="description" content="<?php echo $description; ?>" />
	<?php } ?>
	<?php if ($keywords) { ?>
	<meta name="keywords" content="<?php echo $keywords; ?>" />
	<?php } ?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="" />
	<meta name="author" content="" />
	<?php foreach ($links as $link) { ?>
	<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
	<?php } ?>

	<!-- Le styles -->
	<?php if(isset($this->request->get['route']) && $this->request->get['route'] == 'bill/bill_history/configuremail') { ?>
		<link rel="stylesheet" type="text/css" href="view/stylesheet/invoice.css" />
	<?php } ?>
	<?php if(!$is_custom_page){ ?>
	<link type="text/css" href="view/stylesheet/admin_theme/base5builder_impulsepro/bootstrap.css" rel="stylesheet" />
	<link type="text/css" href="view/stylesheet/admin_theme/base5builder_impulsepro/style.css" rel="stylesheet" />
	<link type="text/css" href="view/stylesheet/admin_theme/base5builder_impulsepro/bootstrap-responsive.css" rel="stylesheet" />
	<link type="text/css" href="view/stylesheet/admin_theme/base5builder_impulsepro/style-responsive.css" rel="stylesheet" />
	<?php }else{ ?>
	<link rel="stylesheet" type="text/css" href="view/stylesheet/stylesheet.css" />
	<link type="text/css" href="view/stylesheet/admin_theme/base5builder_impulsepro/style-custom-page.css" rel="stylesheet" />
	<?php
}
?>

<?php /*  ?>
<link type="text/css" href='http://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' />
<?php */  ?>

<link type="text/css" href="view/javascript/admin_theme/base5builder_impulsepro/ui/themes/ui-lightness/jquery-ui-1.8.20.custom-min.css" rel="stylesheet" />
	  <!--[if IE 7]>
	  <link type="text/css" href="view/stylesheet/admin_theme/base5builder_impulsepro/style-ie7.css" rel="stylesheet">
	  <![endif]-->
	  <!--[if IE 8]>
	  <link type="text/css" href="view/stylesheet/admin_theme/base5builder_impulsepro/style-ie8.css" rel="stylesheet">
	  <![endif]-->
	  <script type="text/javascript" src="view/javascript/admin_theme/base5builder_impulsepro/jquery.js"></script>
	  <script type="text/javascript" src="view/javascript/admin_theme/base5builder_impulsepro/ui/jquery-ui-1.8.20.custom.min.js"></script>
	  <script type="text/javascript" src="view/javascript/admin_theme/base5builder_impulsepro/tabs.js"></script>
	  <script type="text/javascript" src="view/javascript/jquery/ui/external/jquery.cookie.js"></script>
	  <?php foreach ($styles as $style) { ?>
	  <link rel="<?php echo $style['rel']; ?>" type="text/css" href="<?php echo $style['href']; ?>" media="<?php echo $style['media']; ?>" />
	  <?php } ?>
	  <?php foreach ($scripts as $script) { ?>
	  <script type="text/javascript" src="<?php echo $script; ?>"></script>
	  <?php } ?>
	  <?php if($this->user->getUserName() && $is_homepage){ ?>
	  <script type="text/javascript" src="view/javascript/admin_theme/base5builder_impulsepro/flot/jquery.flot.min.js"></script>
	  <script type="text/javascript" src="view/javascript/admin_theme/base5builder_impulsepro/flot/jquery.flot.pie.min.js"></script>
	  <script type="text/javascript" src="view/javascript/admin_theme/base5builder_impulsepro/flot/curvedLines.min.js"></script>
	  <script type="text/javascript" src="view/javascript/admin_theme/base5builder_impulsepro/flot/jquery.flot.tooltip.min.js"></script>
	  <script type="text/javascript" src="view/javascript/admin_theme/base5builder_impulsepro/modernizr.js"></script>

		<!--[if lte IE 8]>
		<script type="text/javascript" src="view/javascript/admin_theme/base5builder_impulsepro/excanvas.min.js"></script>
		<![endif]-->
		<?php } ?>
		<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
		<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
		<script type="text/javascript">
		$(document).ready(function(){

		// Signin - Button

		$(".form-signin-body-right input").click(function(){
			$(".form-signin").submit();
		});

		// Signin - Enter Key

		$('.form-signin input').keydown(function(e) {
			if (e.keyCode == 13) {
				$('.form-signin').submit();
			}
		});

	    // Confirm Delete
	    $('#form').submit(function(){
	    	if ($(this).attr('action').indexOf('delete',1) != -1) {
	    		if (!confirm('<?php echo $text_confirm; ?>')) {
	    			return false;
	    		}
	    	}
	    });

		// Confirm Uninstall
		$('a').click(function(){
			if ($(this).attr('href') != null && $(this).attr('href').indexOf('uninstall', 1) != -1) {
				if (!confirm('<?php echo $text_confirm; ?>')) {
					return false;
				}
			}
		});
	});
		</script>

		<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
  <!--[if lt IE 9]>
  <script type="text/javascript" src="view/javascript/admin_theme/base5builder_impulsepro/html5shiv.js"></script>
  <![endif]-->

  <!-- Fav and touch icons -->
  <link rel="shortcut icon" href="view/image/admin_theme/base5builder_impulsepro/favicon.png" />
</head>

<body>

	<div class="container-fluid">

		<?php if ($logged) { ?>

		<div id="left-column">
			<div class="sidebar-logo">
				<a href="<?php echo $home; ?>">
					<b style="font-size:23px;font-size: 1.7vw;">VET Bill System</b>
					<br />
					<b style="font-size:15px;font-size: 1.0vw;">Administration</b>
					<?php /*  ?>
					<img src="view/image/admin_theme/base5builder_impulsepro/logo.png" />
					<?php */ ?>
				</a>
			</div>
			<div id="mainnav">
				<ul class="mainnav">
					<li id="menu-control">
						<div class="menu-control-outer">
							<div class="menu-control-inner">
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</div>
						</div>
					</li>
					<li id="dashboard"><a href="<?php echo $home; ?>" class="top"><?php echo $text_dashboard; ?></a></li>
					<li id="catalog"><a class="top"><?php echo $text_master; ?></a>
						<ul>
							<li><a href="<?php echo $horse; ?>"><?php echo $text_horse; ?></a></li>
							<li><a href="<?php echo $owner; ?>"><?php echo $text_owner; ?></a></li>
							<li><a href="<?php echo $trainer; ?>"><?php echo $text_trainer; ?></a></li>
							<li><a href="<?php echo $medicine; ?>"><?php echo $text_medicine; ?></a></li>
							<li><a href="<?php echo $treatments; ?>"><?php echo 'Treatments'; ?></a></li>
						</ul>
					</li>
					
					<li id="extension"><a class="top"><?php echo $text_transaction; ?></a>
						<ul>
							<li><a href="<?php echo $horse_wise_tr; ?>"><?php echo $text_horse_wise_tr; ?></a></li>
							<li><a href="<?php echo $medicine_wise_tr; ?>"><?php echo $text_medicine_wise_tr; ?></a></li>
							<li><a href="<?php echo $treated_horse; ?>"><?php echo $text_treated_horse; ?></a></li>
							<li><a href="<?php echo $debit; ?>"><?php echo 'Debit'; ?></a></li>
							<li><a href="<?php echo $credit; ?>"><?php echo 'Credit'; ?></a></li>
						</ul>
					</li>
					<li id="sale"><a class="top"><?php echo $text_bills; ?></a>
						<ul>
							<li><a href="<?php echo $print_inv; ?>"><?php echo $text_print_inv; ?></a></li>
							<?php  ?>
							<li><a href="<?php echo $bill_history; ?>"><?php echo $text_bill_history; ?></a></li>
							<?php  ?>
							<li><a href="<?php echo $bill_payment; ?>"><?php echo 'RWITC Bill Data'; ?></a></li>
							<li><a href="<?php echo $owner_statement_1; ?>"><?php echo 'Owner Statement'; ?></a></li>
						</ul>
					</li>
					<li id="reports"><a class="top"><?php echo $text_report; ?></a>
						<ul>
							<?php /*  ?>
							<li><a href="<?php echo $horse_wise_report; ?>"><?php echo $text_horse_wise_report; ?></a></li>
							<?php */  ?>

							<li><a href="<?php echo $horse_wise_daily_report; ?>"><?php echo $text_horse_wise_daily_report; ?></a></li>
							<li><a href="<?php echo $horse_wise_15_report; ?>"><?php echo $text_horse_wise_15_report; ?></a></li>
							
							<li><a href="<?php echo $trainer_wise_report; ?>"><?php echo $text_trainer_wise_report; ?></a></li>
							<li><a href="<?php echo $trainer_wise_statement; ?>"><?php echo $text_trainer_wise_statement; ?></a></li>
							<li><a href="<?php echo $trainer_wise_log_report; ?>"><?php echo $text_trainer_wise_log_report; ?></a></li>
							
							<li><a href="<?php echo $owner_wise_report; ?>"><?php echo $text_owner_wise_report; ?></a></li>
							<li><a href="<?php echo $owner_wise_statement; ?>"><?php echo $text_owner_wise_statement; ?></a></li>
							<li><a href="<?php echo $owner_statement_email; ?>"><?php echo 'Owner Wise Statement Email'; ?></a></li>
							<li><a href="<?php echo $owner_statement1; ?>"><?php echo 'Owner Statement'; ?></a></li>
							<li><a href="<?php echo $owner_statement_summ; ?>"><?php echo 'Owner Cumulative Statement'; ?></a></li>
							<li><a href="<?php echo $owner_email_status; ?>"><?php echo 'Owner Email Status'; ?></a></li>
							<li><a href="<?php echo $owner_outstanding_report; ?>"><?php echo 'Owner Outstanding Report'; ?></a></li>
							
							<li><a href="<?php echo $pending_wise_report; ?>"><?php echo $text_pending_wise_report; ?></a></li>
							<li><a href="<?php echo $paid_wise_report; ?>"><?php echo $text_paid_wise_report; ?></a></li>
							<li><a href="<?php echo $medicine_report; ?>"><?php echo $text_medicine_report; ?></a></li>
							<li><a href="<?php echo $category_medicine_report; ?>"><?php echo 'Category Wise Medicine Report'; ?></a></li>
							<li><a href="<?php echo $medicine_stock_report; ?>"><?php echo $text_medicine_stock_report; ?></a></li>
							<li><a href="<?php echo $horse_wise_shock; ?>"><?php echo 'Shock Wave'; ?></a></li>
							<li><a href="<?php echo $horse_wise_tread; ?>"><?php echo 'Treadmill'; ?></a></li>
							<li><a href="<?php echo $horse_wise_endos; ?>"><?php echo 'Endoscopy'; ?></a></li>
							<li><a href="<?php echo $horse_wise_sur; ?>"><?php echo 'Surgery'; ?></a></li>
							<li><a href="<?php echo $medicine_vol; ?>"><?php echo 'Medicine Volume Report'; ?></a></li>

						</ul>
					</li>
					<li id="report"><a class="top"><?php echo 'Report New'; ?></a>
						<ul>
							<li><a href="<?php echo $owner_bill; ?>"><?php echo 'Owner Bill Report'; ?></a></li>
						</ul>
					</li>
					<li id="help"><a class="top"><?php echo $text_utility; ?></a>
						<ul>
							<li><a href="<?php echo $payment_tracking; ?>"><?php echo $text_payment_tracking; ?></a></li>
							<?php /* ?>
							<li><a href="<?php echo $change_invoice_treatment; ?>"><?php echo $text_change_invoice_treatment; ?></a></li>
							<?php */ ?>
							<li><a href="<?php echo $cancel_bill; ?>"><?php echo $text_cancel_bill; ?></a></li>
							<li><a href="<?php echo $owner_change; ?>"><?php echo 'Bill Change'; ?></a></li>
							<?php /* ?>
							<li><a href="<?php echo $send_invoice_by_email; ?>"><?php echo $text_send_invoice_by_email; ?></a></li>
							<?php */ ?>
						</ul>
					</li>
				</ul>
			</div>

			<?php /* ?>
			<div class="sidebar copyright" style="display:none;">
				<div class="sidebar-base5builder">
					<p>ImpulsePro Admin Template By <a href="http://base5builder.com/" target="_blank">Base5Builder.com</a>. Built with <a href="http://getbootstrap.com/" target="_blank">Bootstap</a> v2.3.2. <br />Icons by: <a href="http://iconsweets2.com/" target="_blank">iconSweets2</a></p>
				</div>
				<div class="sidebar-opencart"><?php echo $text_footer; ?></div>
			</div>
			<?php */ ?>
		</div>
		<div class="right-header-content clearfix">
			<div class="secondary-menu">
				<ul>
					<li id="store" style="display:none;">
						<a class="top"><span><?php echo $text_front; ?></span></a>
						<ul>
							<li><a  href="<?php echo $store; ?>" target="_blank" class="top"><?php echo $this->config->get('config_name'); ?></a></li>
							<?php foreach ($stores as $stores) { ?>
							<li><a href="<?php echo $stores['href']; ?>" target="_blank"><?php echo $stores['name']; ?></a></li>
							<?php } ?>
						</ul>
					</li>
					<li id="logout"><a class="top" href="<?php echo $logout; ?>"><span><?php echo $text_logout; ?></span></a></li>
				</ul>
			</div>
			<div class="admin-info"><?php echo $logged; ?></div>
		</div>
		<?php } ?>
