<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/report.png" alt="" /> <?php echo $heading_title; ?></h1>
    </div>
    <div class="content sales-report">
      <table class="form">
        <tr>
          <td style="width:11%;">
            <?php echo $entry_bill_id; ?>
            <input type="text" name="filter_bill_id" value="<?php echo $filter_bill_id; ?>" id="filter_bill_id" size="10" />
          </td>
          <td style="text-align: right;">
            <a onclick="filter();" class="button" style="padding: 13px 15px;"><?php echo $button_filter; ?></a>
          </td>
        </tr>
      </table>
      <table class="list" style="width:99%;">
        <thead>
          <tr>
            <td class="left" style="width:1%;"><?php echo $column_sr_no; ?></td>
            <td class="left" style="width:6%;"><?php echo $column_bill_no; ?></td>
            <td class="left" style="width:15%;"><?php echo $column_horse_name; ?></td>
            <td class="left"><?php echo $column_trainer_name; ?></td>
            <td class="right"><?php echo $column_total; ?></td>
            <td class="right"><?php echo $column_action; ?></td>
          </tr>
        </thead>
        <tbody>
          <?php if ($bill_checklist) { ?>
          <?php $i = 1; ?>
          <?php foreach ($bill_checklist as $order) { ?>
          <tr>
            <td class="left"><?php echo $i; ?></td>
            <td class="left"><?php echo $order['bill_id']; ?></td>
            <td class="left"><?php echo $order['horse_name']; ?></td>
            <td class="left"><?php echo $order['trainer_name']; ?></td>
            <td class="right"><?php echo $order['total']; ?></td>
            <td class="right"><?php foreach ($order['action'] as $action) { ?>
            [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
            <?php } ?></td>
          </tr>
          <?php $i++; ?>
          <?php } ?>
          <?php } else { ?>
          <tr>
            <td class="center" colspan="6"><?php echo $text_no_results; ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
      <?php /* ?>
      <div class="pagination"><?php echo $pagination; ?></div>
      <?php */ ?>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
function filter() {
  url = 'index.php?route=tool/cancel_bill&token=<?php echo $token; ?>';
  
  var filter_bill_id = $('input[name=\'filter_bill_id\']').attr('value');
  if (filter_bill_id) {
    url += '&filter_bill_id=' + encodeURIComponent(filter_bill_id);
  }

  url += '&first=0';
  
  location = url;
  return false;
}
//--></script>
<?php echo $footer; ?>