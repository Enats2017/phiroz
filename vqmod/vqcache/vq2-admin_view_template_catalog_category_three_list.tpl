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
      <td style="width:13%">Month
        <select name="filter_month">
          <?php foreach($months as $key => $ud) { ?>
            <?php if($key == $filter_month) { ?>
              <option value='<?php echo $key; ?>' selected="selected"><?php echo $ud; ?></option> 
            <?php } else { ?>
              <option value='<?php echo $key; ?>'><?php echo $ud; ?></option>
            <?php } ?>
          <?php } ?>
        </select>
      </td>
      <td style="width:13%">Year
        <select name="filter_year">
          <?php foreach($years as $key => $dd) { ?>
            <?php if($key == $filter_year) { ?>
              <option value='<?php echo $key; ?>' selected="selected"><?php echo $dd; ?></option> 
            <?php } else { ?>
              <option value='<?php echo $key; ?>'><?php echo $dd; ?></option>
            <?php } ?>
          <?php } ?>
        </select>
      </td>
      <td style="text-align: right;">
        <a style="padding: 10px 28px 8px 28px;border: 1px solid #0088cc;text-decoration: none;background:#0088cc;font-size: 16px;color: #efecec;" onclick="filter();" id="filter" class="button"><?php echo 'Process'; ?></a>
      </td>
    </tr>
      </table>
      <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="list">
          <thead>
            <tr>
              <td class="left"><?php echo 'Employee Code'; ?></td>
              <td class="left"><?php echo 'Employee Name'; ?></td>
              <td class="left"><?php echo 'Company'; ?></td>
            </tr>
          </thead>
          <tbody>
            
          </tbody>
        </table>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?>
<script type="text/javascript">
  function filter() {
  url = 'index.php?route=catalog/category_three&token=<?php echo $token; ?>';
  var filter_month = $('select[name=\'filter_month\']').attr('value');
  if (filter_month) {
  url += '&filter_month=' + encodeURIComponent(filter_month);
  }
  var filter_year = $('select[name=\'filter_year\']').attr('value');
  if (filter_year) {
  url += '&filter_year=' + encodeURIComponent(filter_year);
  }
   var filter_location = $('select[name=\'filter_location\']').attr('value');
  if (filter_location) {
  url += '&filter_location=' + encodeURIComponent(filter_location);
  }
  url += '&once=1';
  location = url;
}
function filter_export() {
  url = 'index.php?route=catalog/category_three/export&token=<?php echo $token; ?>';
  var filter_month = $('select[name=\'filter_month\']').attr('value');
  if (filter_month) {
  url += '&filter_month=' + encodeURIComponent(filter_month);
  }
  var filter_year = $('select[name=\'filter_year\']').attr('value');
  if (filter_year) {
  url += '&filter_year=' + encodeURIComponent(filter_year);
  }
   var filter_location = $('select[name=\'filter_location\']').attr('value');
  if (filter_location) {
  url += '&filter_location=' + encodeURIComponent(filter_location);
  }
  url += '&once=1';
  location = url;
  return false;
}
  $('input[name=\'filter_employee\']').autocomplete({
  delay: 500,
  source: function(request, response) {
    $.ajax({
      url: 'index.php?route=catalog/category_two/employeeautocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
      dataType: 'json',
      success: function(json) { 
        response($.map(json, function(item) {
          return {
            label: item.employee_name,
            value: item.employee_code
          }
        }));
      }
    });
  }, 
  select: function(event, ui) {
    $('input[name=\'filter_employee\']').val(ui.item.label);
    $('input[name=\'filter_employee_code\']').val(ui.item.value);
    return false;
  },
  focus: function(event, ui) {
        return false;
    }
});
</script>