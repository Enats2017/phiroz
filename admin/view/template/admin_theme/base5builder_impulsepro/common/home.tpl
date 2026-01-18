<?php echo $header; ?>
<div id="content">
	<div class="breadcrumb">
		<?php foreach ($breadcrumbs as $breadcrumb) { ?>
		<?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
		<?php } ?>
	</div>
	<?php if ($error_install) { ?>
	<div class="warning"><?php echo $error_install; ?></div>
	<?php } ?>
	<?php if ($error_image) { ?>
	<div class="warning"><?php echo $error_image; ?></div>
	<?php } ?>
	<?php if ($error_image_cache) { ?>
	<div class="warning"><?php echo $error_image_cache; ?></div>
	<?php } ?>
	<?php if ($error_cache) { ?>
	<div class="warning"><?php echo $error_cache; ?></div>
	<?php } ?>
	<?php if ($error_download) { ?>
	<div class="warning"><?php echo $error_download; ?></div>
	<?php } ?>
	<?php if ($error_logs) { ?>
	<div class="warning"><?php echo $error_logs; ?></div>
	<?php } ?>
	<div class="box">
		<div class="heading">
			<h1><img src="view/image/admin_theme/base5builder_impulsepro/icon-dashboard-large.png" alt="" /> <?php echo $heading_title; ?></h1>
		</div>
		<div class="content">
			<div class="dashboard-top">
				<div class="statistic">
					<div class="dashboard-heading"><?php echo 'Horse Search'; ?></div>
					<div class="dashboard-content" style="text-align:center;">
						<input type="text" name = "h_name" id = "h_name" value="" style="margin-top:100px;height:30px;" />
						<input type="hidden" name = "h_name_id" id = "h_name_id" value="" />
						<input type="button" onclick="filter();" style="margin-top:100px;margin-left:20px;background-color: #2382e4;color: #ffffff;font-weight: bold;padding:7px;" value="<?php echo $button_search; ?>" />
					</div>
				</div>
				<div class="overview">
					<div class="dashboard-heading"><?php echo $text_overview; ?></div>
					<div class="dashboard-content">
						<div class="dashboard-overview-top clearfix">
							<div class="sales-value-graph">
								<input id="total_sale_raw" type="hidden" value="<?php echo substr($total_treatment_raw, 0, -2); ?>" data-text_label="<?php echo 'Total Treatment Amount'; ?>" data-currency_value="<?php echo $total_treatment; ?>" />
								<input id="total_sale_year_raw" type="hidden" value="<?php echo substr($total_amount_recovered_raw, 0, -2); ?>" data-text_label="<?php echo 'Amount Recovered'; ?>" data-currency_value="<?php echo $total_amount_recovered; ?>" />
								<input id="total_sales_previous_years_raw" type="hidden" value="<?php echo $total_amount_balance_raw; ?>" data-text_label="<?php echo 'Amount Balance'; ?>" data-currency_value="<?php echo $total_amount_balance; ?>" />

								<div id="sales-value-graph"></div>
							</div>
							<div class="sales-value-legend">
								<div class="sales-this-year">
									<div class="number-stat-legend-color">
										<div class="legend-color-box"></div>
									</div>
									<div class="number-stat-number"><?php echo $total_treatment; ?></div>
									<div class="number-stat-text"><?php echo 'Total Treatment Amount'; ?></div>
								</div>
								<div class="sales-previous-years">
									<div class="number-stat-legend-color">
										<div class="legend-color-box"></div>
									</div>
									<div class="number-stat-number"><?php echo $total_amount_recovered; ?></div>
									<div class="number-stat-text"><?php echo 'Amount Recovered'; ?></div>
								</div>
								<div class="sales-total">
									<div class="number-stat-legend-color">
										<div class="legend-color-box"></div>
									</div>
									<div class="number-stat-number"><?php echo $total_amount_balance ?></div>
									<div class="number-stat-text"><?php echo 'Amount Balance'; ?></div>
								</div>
							</div>
						</div>
						<div class="dashboard-overview-bottom clearfix">
							<div class="number-stat-box stat-1" style="width:24.5%;">
								<div class="number-stat-number"><?php echo number_format($total_horses); ?></div>
								<div class="number-stat-text"><?php echo $text_total_horses; ?></div>
							</div>
							<div class="number-stat-box stat-2" style="width:24.5%;">
								<div class="number-stat-number"><?php echo number_format($total_trainer); ?></div>
								<div class="number-stat-text"><?php echo $text_total_trainer; ?></div>
							</div>
							<div class="number-stat-box stat-3" style="width:24.5%;">
								<div class="number-stat-number"><?php echo number_format($total_owner); ?></div>
								<div class="number-stat-text"><?php echo $text_total_owner; ?></div>
							</div>
							<div class="number-stat-box stat-3" style="width:24.5%;">
								<div class="number-stat-number"><?php echo number_format($total_medicine); ?></div>
								<div class="number-stat-text"><?php echo $text_total_medicine; ?></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="dashboard-bottom">
				<div class="latest" style="width:100%;">
					<div class="dashboard-heading"><?php echo $text_latest_10_orders; ?></div>
					<div class="dashboard-content">
						<table class="list">
							<thead>
								<tr>
									<td class="left"><?php echo $column_sr_no; ?></td>
									<td class="left"><?php echo $column_horse_name; ?></td>
									<td class="left"><?php echo $column_trainer; ?></td>
									<td class="left"><?php echo $column_date; ?></td>
									<td class="left"><?php echo $column_medicine; ?></td>
									<td class="right"><?php echo $column_total; ?></td>
								</tr>
							</thead>
							<tbody>
								<?php if ($orders) { ?>
								<?php foreach ($orders as $order) { ?>
								<tr>
									<td class="left"><?php echo $order['transaction_id']; ?></td>
									<td class="left"><?php echo $order['horse_name']; ?></td>
									<td class="left"><?php echo $order['trainer_name']; ?></td>
									<td class="left"><?php echo $order['dot']; ?></td>
									<td class="left"><?php echo $order['medicine_name']; ?></td>
									<td class="right"><?php echo $order['medicine_total']; ?></td>
									<?php /* ?>
									<td class="right"><?php foreach ($order['action'] as $action) { ?>
										[ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
										<?php } ?></td>
									<?php */ ?>
								</tr>
								<?php } ?>
								<?php } else { ?>
								<tr>
									<td class="center" colspan="5"><?php echo $text_no_results; ?></td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
				<div class="other-stats" style="display:none;">
					<div class="dashboard-heading"><?php echo $text_other_stats; ?></div>
					<div class="dashboard-content">
						<div class="other-stats-box stat-1">
							<div class="other-stat-number"><?php echo number_format($total_customer_approval); ?></div>
							<div class="other-stat-text"><?php echo $text_total_customer_approval; ?></div>
						</div>
						<div class="other-stats-box stat-2">
							<div class="other-stat-number"><?php echo number_format($total_review_approval); ?></div>
							<div class="other-stat-text"><?php echo $text_total_review_approval; ?></div>
						</div>
						<div class="other-stats-box stat-3">
							<div class="other-stat-number"><?php echo number_format($total_affiliate); ?></div>
							<div class="other-stat-text"><?php echo $text_total_affiliate; ?></div>
						</div>
						<div class="other-stats-box stat-4">
							<div class="other-stat-number"><?php echo number_format($total_affiliate_approval); ?></div>
							<div class="other-stat-text"><?php echo $text_total_affiliate_approval; ?></div>
						</div>
					</div>
				</div>
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>
<script type="text/javascript"><!--

$.widget('custom.catcomplete', $.ui.autocomplete, {
  _renderMenu: function(ul, items) {
    var self = this, currentCategory = '';
    $.each(items, function(index, item) {
      if (item.category != currentCategory) {
        //ul.append('<li class="ui-autocomplete-category">' + item.category + '</li>');
        currentCategory = item.category;
      }
      self._renderItem(ul, item);
    });
  }
});

$('input[name=\'h_name\']').autocomplete({
  delay: 500,
  source: function(request, response) {
    $.ajax({
      url: 'index.php?route=transaction/horse_wise/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
      dataType: 'json',
      success: function(json) {   
        response($.map(json, function(item) {
          return {
            label: item.name,
            value: item.horse_id
          }
        }));
      }
    });
  }, 
  select: function(event, ui) {
    $('input[name=\'h_name\']').val(ui.item.label);
    $('input[name=\'h_name_id\']').val(ui.item.value);
    return false;
  },
  focus: function(event, ui) {
    return false;
  }
});
//--></script>
<script type="text/javascript"><!--

$('#h_name').keydown(function(e) {
  if (e.keyCode == 13) {
    filter();
  }
});

function filter() {
	url = 'index.php?route=report/horse_data&token=<?php echo $token; ?>';
	
	var h_name = $('input[name=\'h_name\']').attr('value');
	
	if (h_name) {
    url += '&h_name=' + encodeURIComponent(h_name);
    var h_name_id = $('input[name=\'h_name_id\']').attr('value');
    if (h_name_id) {
      url += '&h_name_id=' + encodeURIComponent(h_name_id);
    }
  }

  location = url;
  return false;
}

//--></script>
<?php echo $footer; ?>
