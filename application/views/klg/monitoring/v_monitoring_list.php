<?php
   
  $common='load_silent("klg/monitoring/common/",".tab-content")';
  $custom='load_silent("klg/monitoring/custom/",".tab-content")';
  if ($param_tab == '1') {
    $this->fungsi->run_js($common);
    $tab_1 = 'active';
    $tab_2 = '';
  } else {
    $this->fungsi->run_js($custom);
    $tab_1 = '';
    $tab_2 = 'active';
  }
?>
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">Monitoring</h3>
  </div>

  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="<?=$tab_1?>"><a data-toggle="tab" onclick='<?php echo $common; ?>' href="javascript:void(0)">Common</a></li>
      <li class="<?=$tab_2?>"><a onclick='<?php echo $custom; ?>' data-toggle="tab" href="javascript:void(0)">Custom</a></li>
    </ul>
    <div class="tab-content">
      
    </div>
  </div>
    
</div>