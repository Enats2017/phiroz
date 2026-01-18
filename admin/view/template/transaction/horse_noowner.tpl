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
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/admin_theme/base5builder_impulsepro/icon-products-large.png" alt="" /> <?php echo $heading_title; ?></h1>
    </div>
    <div class="content sales-report">
      <table class="list">
        <thead>
          <tr>
            <td class="left"><?php echo 'Sr.No'; ?></td>
            <td class="left"><?php echo $column_horse_name; ?></td>
            <td class="left"><?php echo $column_action; ?></td>
          </tr>
        </thead>
        <tbody>
          <?php if ($treatedhorse) { ?>
          <?php $i = 1; ?>
          <?php foreach ($treatedhorse as $order) { ?>
          <tr>
            <td class="left"><?php echo $i; ?></td>
            <td class="left"><?php echo $order['horse_name']; ?></td>
            <td class="right"><?php foreach ($order['action'] as $action) { ?>
            [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
            <?php } ?></td>
          </tr>
          <?php $i++; ?>
          <?php } ?>
          <?php } else { ?>
          <tr>
            <td class="center" colspan="3"><?php echo $text_no_results; ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
      <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>
<?php echo $footer; ?>