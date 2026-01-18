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
			
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <div id="tabs" class="htabs"><a href="#tab-general"><?php echo $tab_general; ?></a></div>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <div id="tab-general">
          <table class="form">
            <tr>
              <td><span class="required">*</span> <?php echo 'Responsible Person Name'; ?></td>
              <td>
                <input type="text" name="responsible_person" value="<?php echo $responsible_person; ?>" size="100" />
                <input type="hidden" name="responsible_person_id" value="<?php echo $responsible_person_id; ?>" size="100" />
                <?php if ($error_responsible_person) { ?>
                <span class="error"><?php echo $error_responsible_person; ?></span>
                <?php } ?>
              </td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_name; ?></td>
              <td><input type="text" name="name" value="<?php echo $name; ?>" size="100" />
                <?php if ($error_name) { ?>
                <span class="error"><?php echo $error_name; ?></span>
                <?php } ?>
              </td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo 'Email'; ?></td>
              <td><input type="text" name="email" value="<?php echo $email; ?>" size="100" />
                <?php /*if ($error_name) { ?>
                <span class="error"><?php echo $error_name; ?></span>
                <?php } */ ?>
              </td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo 'Phone Number'; ?></td>
              <td><input type="text" name="phone" value="<?php echo $phone; ?>" size="100" />
                <?php /*if ($error_name) { ?>
                <span class="error"><?php echo $error_name; ?></span>
                <?php } */ ?>
              </td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo 'Outstanding Amount'; ?></td>
              <td><input type="text" name="balance" value="<?php echo $balance; ?>" size="100" />
                <?php /*if ($error_name) { ?>
                <span class="error"><?php echo $error_name; ?></span>
                <?php } */ ?>
              </td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo 'Outstanding Amount PTK'; ?></td>
              <td><input type="text" name="outstandingamount_ptk" value="<?php echo $outstandingamount_ptk; ?>" size="100" />
                <?php /*if ($error_name) { ?>
                <span class="error"><?php echo $error_name; ?></span>
                <?php } */ ?>
              </td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo 'Outstanding Amount LMF'; ?></td>
              <td><input type="text" name="outstandingamount_lmf" value="<?php echo $outstandingamount_lmf; ?>" size="100" />
                <?php /*if ($error_name) { ?>
                <span class="error"><?php echo $error_name; ?></span>
                <?php } */ ?>
              </td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo 'Total'; ?></td>
              <td><input type="text" name="total" value="<?php echo $total; ?>" size="100" />
                <?php /*if ($error_name) { ?>
                <span class="error"><?php echo $error_name; ?></span>
                <?php } */ ?>
              </td>
            </tr>
            <tr style="display: none;">
              <td><span class="required">*</span> <?php echo 'Opening Balance as of July 2017'; ?></td>
              <td><input type="text" name="opening_balance" value="<?php echo $opening_balance; ?>" size="100" />
              </td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_transaction_type; ?></td>
              <td>
                <select name="transaction_type" id="transaction_type" style="">
                  <?php foreach($transaction_types as $tkey => $tvalue) { ?>
                    <?php if ($transaction_type == $tkey) { ?>
                      <option value="<?php echo $tkey ?>" selected="selected"><?php echo $tvalue; ?></option>
                    <?php } else { ?>
                      <option value="<?php echo $tkey ?>"><?php echo $tvalue; ?></option>
                    <?php } ?>
                  <?php } ?>
                </select>
                <?php /* if($transaction_type == '1' || $transaction_type == '0') { ?>
                    <input type="radio" name="transaction_type" class="transaction_type" value="1"  checked="checked" />
                    <?php echo 'Phiroz Khambatta'; ?>
                    <input type="radio" name="transaction_type" class="transaction_type" value="2" />
                    <?php echo 'P.T Khambatta'; ?>
                <?php } else { ?>
                    <input type="radio" name="transaction_type" class="transaction_type" value="1" />
                    <?php echo 'Phiroz Khambatta'; ?>
                    <input type="radio" name="transaction_type" class="transaction_type" value="2" checked="checked" />
                    <?php echo 'P.T Khambatta'; ?>
                <?php } */ ?>
              </td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo 'Status'; ?></td>
              <td>
                <select name="status" id="status" style="">
                  <?php foreach($statuses as $tkey => $tvalue) { ?>
                    <?php if ($status == $tkey) { ?>
                      <option value="<?php echo $tkey ?>" selected="selected"><?php echo $tvalue; ?></option>
                    <?php } else { ?>
                      <option value="<?php echo $tkey ?>"><?php echo $tvalue; ?></option>
                    <?php } ?>
                  <?php } ?>
                </select>
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