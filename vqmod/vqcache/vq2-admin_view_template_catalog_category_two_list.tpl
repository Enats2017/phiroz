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
          <td><?php echo 'Employee Code/Name'; ?>
            <input type="text" name="filter_employee" value="<?php echo $filter_employee?>" id="filter_employee" size="12" style = "font-size: 14px;" />
            <input type="hidden" name="filter_employee_code" value="<?php echo $filter_employee_code?>" id="filter_employee_code" size="12" style = "font-size: 14px;" />&nbsp;&nbsp;&nbsp; <a onclick="filter();"  style="padding: 10px 28px 8px 28px;border: 1px solid #0088cc;text-decoration: none;background:#0088cc;font-size: 16px;color: #efecec;" ><?php echo 'Filter'; ?></a>
             &nbsp;&nbsp;&nbsp;
         <a  onclick="filter_export();" style="padding: 10px 28px 8px 28px;border: 1px solid #25cb66;text-decoration: none;background:#25cb66;font-size: 16px;color: #efecec;" ><?php echo "Export"; ?></a></td> 
           
           
        </tr>
      </table>
      <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="list">
          <thead>
            <tr>
              <td class="left"><?php echo 'Employee Code'; ?></td>
              <td class="left"><?php echo 'Employee Name'; ?></td>
              <td class="left"><?php echo 'Company'; ?></td>
              <td class="left"><?php echo 'LocationName'; ?></td>
              <td class="left"><?php echo 'DOJ'; ?></td>
              <td class="left"><?php echo 'Access Activated'; ?></td>
              <td class="left"><?php echo 'Device code'; ?></td>
              <td class="left"><?php echo 'DOR'; ?></td>
              <td class="left"><?php echo 'AccessDeactivated'; ?></td>
            </tr>
          </thead>
          <tbody>
            <?php if ($emp_array) { ?>
            <?php foreach ($emp_array as $category) { ?>
            <tr>
                <td class="left"><?php echo $category['EmployeeCode']; ?></td>
                <td class="left"><?php echo $category['employee_names']; ?></td>
                <td class="left"><?php echo $category['company_name']; ?></td>
                <td class="left"><?php echo $category['area_name']; ?></td>
                <td class="left"><?php echo $category['DOJ']; ?></td>
                <td class="left"><?php echo $category['ValidFromDate']; ?></td>
                <td class="left"><?php echo $category['device_names']; ?></td>
                <td class="left"><?php echo $category['DOR']; ?></td>
                <td class="left"><?php echo $category['ValidToDate']; ?></td>
            </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
              <td class="center" colspan="9"><?php echo $text_no_results; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?>
<script type="text/javascript">
  function filter() {
  url = 'index.php?route=catalog/category_two&token=<?php echo $token; ?>';
  var filter_employee = $('input[name=\'filter_employee\']').attr('value');
  
  if (filter_employee != '') {
    url += '&filter_employee=' + encodeURIComponent(filter_employee);
     var filter_employee_code = $('input[name=\'filter_employee_code\']').attr('value');
    if (filter_employee_code) {
    url += '&filter_employee_code=' + encodeURIComponent(filter_employee_code);
    }
  }
  location = url;
}
function filter_export() {
  url = 'index.php?route=catalog/category_two/export&token=<?php echo $token; ?>';
  var filter_employee = $('input[name=\'filter_employee\']').attr('value');
 if (filter_employee != '') {
   url += '&filter_employee=' + encodeURIComponent(filter_employee);
     var filter_employee_code = $('input[name=\'filter_employee_code\']').attr('value');
    if (filter_employee_code) {
    url += '&filter_employee_code=' + encodeURIComponent(filter_employee_code);
    }
  }
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