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
    <table class="form">
        <tr>
          <td style="width:13%;"><?php echo 'Date Start'; ?>
            <input type="text" name="filter_date_start" value="<?php echo $filter_date_start; ?>" id="date-start" size="12" /></td>
          <td style="width:13%;"><?php echo 'Date End'; ?>
            <input type="text" name="filter_date_end" value="<?php echo $filter_date_end; ?>" id="date-end" size="12" /></td>
          <td style="width:13%;"><?php echo 'Report Type'; ?>
            <select name="filter_type" id="filter_type">
              <option value="" selected="selected">All</option>
              <?php foreach($types as $key => $value) { ?>
                <?php if ($key == $filter_type) { ?>
                  <option value="<?php echo $key ?>" selected="selected"><?php echo $value; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $key ?>"><?php echo $value; ?></option>
                <?php } ?>
              <?php } ?>
            </select>
          </td>
          <td style="width:13%;"><?php echo 'Owner'; ?>
            <input type="text" name="filter_name" value="<?php echo $filter_name; ?>" id="filter_name" size="20" />
            <input type="hidden" name="filter_name_id" value="<?php echo $filter_name_id; ?>" id="filter_name_id" size="20" /></td>
          <td style="width:5%;"><?php echo 'Select doctor'; ?>
            <select name="filter_doctor" id="filter_doctor">
              <option value="" selected="selected">All</option>
              <?php foreach($doctors as $dkey => $dvalue) { ?>
                <?php if ($filter_doctor == $dvalue['doctor_id']) { ?>
                  <option value="<?php echo $dvalue['doctor_id'] ?>" selected="selected"><?php echo $dvalue['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $dvalue['doctor_id'] ?>"><?php echo $dvalue['name']; ?></option>
                <?php } ?>
              <?php } ?>
            </select>
          </td>
          <td>
            <a onclick="filter();" id="filter" class="btn btn-primary" style="margin-top: 15px;"><?php echo $button_filter; ?></a>
          </td>
        </tr>
    </table>
    <div class="content">
        <table class="list">        
          <thead>
            <tr>
              <td><?php if ($sort == 'name') { ?>
              <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>">Owner Name</a>
              <?php } else { ?>
              <a href="<?php echo $sort_name; ?>">Owner Name</a>
              <?php } ?></td>
              <td><?php if ($sort == 'email') { ?>
              <a href="<?php echo $sort_email; ?>" class="<?php echo strtolower($order); ?>">Email</a>
              <?php } else { ?>
              <a href="<?php echo $sort_email; ?>">Email</a>
              <?php } ?></td>
              <td><?php if ($sort == 'type') { ?>
              <a href="<?php echo $sort_type; ?>" class="<?php echo strtolower($order); ?>">Report Type</a>
              <?php } else { ?>
              <a href="<?php echo $sort_type; ?>">Report Type</a>
              <?php } ?></td>
              <td><?php if ($sort == 'status') { ?>
              <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>">Status</a>
              <?php } else { ?>
              <a href="<?php echo $sort_status; ?>">Status</a>
              <?php } ?></td>
              <td><?php if ($sort == 'date') { ?>
              <a href="<?php echo $sort_date; ?>" class="<?php echo strtolower($order); ?>">Date</a>
              <?php } else { ?>
              <a href="<?php echo $sort_date; ?>">Date</a>
              <?php } ?></td>
              <td><?php if ($sort == 'time') { ?>
              <a href="<?php echo $sort_time; ?>" class="<?php echo strtolower($order); ?>">Time</a>
              <?php } else { ?>
              <a href="<?php echo $sort_time; ?>">Time</a>
              <?php } ?></td>
            </tr>
          </thead>
          <tbody>
          <?php if ($results) { ?>
          <?php foreach($results as $result) { ?>
            <tr>
              <td><?php echo $result['owner_name']; ?></td>
              <td><?php echo $result['owner_email'] ?></td>
              <td><?php echo $result['report_name'] ?></td>
              <td><?php echo $result['send_status'] ?></td>
              <td><?php echo $result['date'] ?></td>
              <td><?php echo $result['time'] ?></td>
            </tr>
          <?php } ?>
          <?php } else { ?>
          <tr>
            <td class="center" colspan="6"><?php echo $text_no_results; ?></td>
          </tr>
          <?php } ?>
          </tbody>
        </table>
      <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
$(document).ready(function() {
  $('#date-start').datepicker({dateFormat: 'yy-mm-dd'});
  $('#date-end').datepicker({dateFormat: 'yy-mm-dd'});
});

function filter() {
  url = 'index.php?route=report/owner_email_status&token=<?php echo $token; ?>';
  
  var filter_date_start = $('input[name=\'filter_date_start\']').attr('value');
  
  if (filter_date_start) {
    url += '&filter_date_start=' + encodeURIComponent(filter_date_start);
  }

  var filter_date_end = $('input[name=\'filter_date_end\']').attr('value');
  
  if (filter_date_end) {
    url += '&filter_date_end=' + encodeURIComponent(filter_date_end);
  }

  var filter_type = $('select[name=\'filter_type\']').attr('value');
  
  if (filter_type) {
    url += '&filter_type=' + encodeURIComponent(filter_type);
  }

  var filter_name = $('input[name=\'filter_name\']').attr('value');
  
  if (filter_name) {
    url += '&filter_name=' + encodeURIComponent(filter_name);
    var filter_name_id = $('input[name=\'filter_name_id\']').attr('value');
    if (filter_name_id) {
      url += '&filter_name_id=' + encodeURIComponent(filter_name_id);
    }
  }

  var filter_doctor = $('select[name=\'filter_doctor\']').attr('value');
  if (filter_doctor) {
    url += '&filter_doctor=' + encodeURIComponent(filter_doctor);
  }

  location = url;
  return false;
}


$('input[name=\'filter_name\']').autocomplete({
  delay: 500,
  source: function(request, response) {
    $.ajax({
      url: 'index.php?route=catalog/owner/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
      dataType: 'json',
      success: function(json) {   
        response($.map(json, function(item) {
          return {
            label: item.name,
            value: item.owner_id
          }
        }));
      }
    });
  }, 
  select: function(event, ui) {
    $('input[name=\'filter_name\']').val(ui.item.label);
    $('input[name=\'filter_name_id\']').val(ui.item.value);
    return false;
  },
  focus: function(event, ui) {
    return false;
  }
});
//--></script>
<?php echo $footer; ?>