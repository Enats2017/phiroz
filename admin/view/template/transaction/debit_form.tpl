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
      <h1><img src="view/image/shipping.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <div id="tabs" class="htabs"><a href="#tab-general"><?php echo $tab_general; ?></a></div>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <div id="tab-general">
            <table class="form">
                <tr>
                  <td><span class="required">*</span> <?php echo 'Owner Name'; ?></td>
                  <td>
                    <input type="text" name="responsible_person" value="<?php echo $responsible_person; ?>" size="100" />
                    <input type="hidden" name="owner_id" value="<?php echo $owner_id; ?>" size="100" />
                    <?php if ($error_responsible_person) { ?>
                    <span class="error"><?php echo $error_responsible_person; ?></span>
                    <?php } ?>
                  </td>
                </tr>
                <tr>
                  <td><span class="required">*</span> <?php echo 'Amount'; ?></td>
                  <td><input type="number" style="width: 73%; " name="amount" value="<?php echo $amount; ?>" size="100" />
                  </td>
                </tr>
                <tr>
                  <td><span class="required">*</span> <?php echo 'Comment'; ?></td>
                  <td><textarea type="text" style="width: 50%" rows="4" cols="15"name="comment" value="<?php echo $comment; ?>" ></textarea> 
                  </td>
                </tr>
            </table>
        </div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
$('#tabs a').tabs(); 

$('input[name=\'responsible_person\']').autocomplete({
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
    $('input[name=\'responsible_person\']').val(ui.item.label);
    $('input[name=\'responsible_person_id\']').val(ui.item.value);
            
    return false;
  },
  focus: function(event, ui) {
        return false;
    }
});

//--></script> 
<?php echo $footer; ?>
<style>
  input::-webkit-outer-spin-button,
  input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
</style>