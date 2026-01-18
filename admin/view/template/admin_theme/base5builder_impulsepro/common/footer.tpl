<?php

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
</div> <!-- /container -->
	<!-- Le javascript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<?php if($this->user->getUserName()){ ?>
	<?php
	if(!$is_custom_page){
		?>
		<script type="text/javascript" src="view/javascript/admin_theme/base5builder_impulsepro/scriptbreaker-multiple-accordion-1-min.js"></script>
		<script type="text/javascript" src="view/javascript/admin_theme/base5builder_impulsepro/script.js"></script>
		<?php
	}else{ 
		if($logged){
			?>
			<script type="text/javascript" src="view/javascript/admin_theme/base5builder_impulsepro/script-custom-page.js"></script>
			<?php
		}else{
			?>
			<script type="text/javascript" src="view/javascript/admin_theme/base5builder_impulsepro/script.js"></script>
			<?php
		}
	}
	?>
	<?php } ?>

</body>
</html>