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
      <h1><img src="view/image/shipping.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a href="<?php echo $insert; ?>" class="button"><?php echo $button_insert; ?></a><a onclick="$('form').submit();" class="button"><!-- <?php echo $button_delete; ?> --></a></div>
    </div>
    <div class="content">
      <table class="list">
        <thead>
          <tr>
            <td width="1" style="text-align: center;">debit-no</td>
            <td class="left"><?php if ($sort == 'name') { ?>
              <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
              <?php } else { ?>
              <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
              <?php } ?></td>
              <td>Amount</td>
            
            <td class="right">Comment</td>
          </tr>
        </thead>
        <tbody>
          <tr class="filter">
            <td></td>
            <td><input type="text" id="filter_name" name="filter_name" value="<?php echo $filter_name; ?>" style="width:280px;" /><a onclick="filter();" class="btn" style="margin-left:10px; color:#0aad1d"><?php echo $button_filter; ?></a></td>
            <td align="right"></td>
            <td></td>
          </tr>
          <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
            <?php if ($owners) { ?>
            <?php foreach ($owners as $owner) { ?>
            <tr>
              <td style="text-align: center;"><?php echo $owner['owner_id']; ?></td>
              <td class="left"><?php echo $owner['responsible_person']; ?></td>
              <td><?php echo $owner['amount']; ?></td>   
              <td class="right"><?php echo $owner['comment']; ?></td>
            </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
              <td class="center" colspan="3"><?php echo $text_no_results; ?></td>
            </tr>
            <?php } ?>
          </form>
        </tbody>
      </table>
      <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
function filter() {
  url = 'index.php?route=transaction/debit&token=<?php echo $token; ?>';
  
  var filter_name = $('input[name=\'filter_name\']').attr('value');
  
  if (filter_name) {
    url += '&filter_name=' + encodeURIComponent(filter_name);
  }
  
  location = url;
  return false;
}
//</script>
<script type="text/javascript"><!--
$('#filter_name').keydown(function(e) {
  if (e.keyCode == 13) {
    filter();
  }
});
//--></script> 
<script type="text/javascript"><!--
$('input[name=\'filter_name\']').autocomplete({
  delay: 500,
  source: function(request, response) {
    $.ajax({
      url: 'index.php?route=transaction/debit/autocomplete&token=<?php echo $token; ?>&filter_name_1=' +  encodeURIComponent(request.term),
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
            
    return false;
  },
  focus: function(event, ui) {
        return false;
    }
});
//--></script>
<?php echo $footer; ?> -->