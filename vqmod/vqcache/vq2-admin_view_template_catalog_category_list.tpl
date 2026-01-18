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
      
			<h1><img src="view/image/admin_theme/base5builder_impulsepro/icon-category-large.png" alt="" /> <?php echo $heading_title; ?></h1>
			
    </div>
    <div class="content">
      <table class="form">
        <tr>
          <td><?php echo 'Date Start'; ?>
            <input type="text" name="filter_date_start" value="<?php echo $filter_date_start; ?>" id="date-start" size="12" style = "font-size: 14px;" /></td>
          <td><?php echo 'Date End'; ?>
            <input type="text" name="filter_date_end" value="<?php echo $filter_date_end; ?>" id="date-end" size="12"  style = "font-size: 14px;" />&nbsp;&nbsp;&nbsp; <a onclick="filter();"  style="padding: 10px 28px 8px 28px;border: 1px solid #0088cc;text-decoration: none;background:#0088cc;font-size: 16px;color: #efecec;" ><?php echo 'Filter'; ?></a>
             &nbsp;&nbsp;&nbsp;
        </tr>
      </table>
      <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="list">
          <thead>
            <tr>
              <td class="left"><?php echo 'Changed Date'; ?></td>
              <td class="left"><?php echo 'Message'; ?></td>
              <td class="left"><?php echo 'Modified By'; ?></td>
               <td class="left"><?php echo 'IP Address'; ?></td>
            </tr>
          </thead>
          <tbody>
            <?php if ($emp_array) { ?>
            <?php foreach ($emp_array as $category) { ?>
            <tr>
                <td class="left"><?php echo $category['ChangeDate']; ?></td>
                <td class="left"><?php echo $category['Message']; ?></td>
                <td class="left"><?php echo $category['ModifiedBy']; ?></td>
                <td class="left"><?php echo $category['IPAddress']; ?></td>
            </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
              <td class="center" colspan="4"><?php echo $text_no_results; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </form>
      <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
function filter() {
  url = 'index.php?route=catalog/category&token=<?php echo $token; ?>';
  
  var filter_date_start = $('input[name=\'filter_date_start\']').attr('value');
  
  if (filter_date_start) {
    url += '&filter_date_start=' + encodeURIComponent(filter_date_start);
  }

  var filter_date_end = $('input[name=\'filter_date_end\']').attr('value');
  
  if (filter_date_end) {
    url += '&filter_date_end=' + encodeURIComponent(filter_date_end);
  }
  location = url;
}

//--></script> 
<script type="text/javascript"><!--
$(document).ready(function() {
  $('#date-start').datepicker({dateFormat: 'yy-mm-dd'});
  
  $('#date-end').datepicker({dateFormat: 'yy-mm-dd'});
});
//--></script> 
<?php echo $footer; ?>