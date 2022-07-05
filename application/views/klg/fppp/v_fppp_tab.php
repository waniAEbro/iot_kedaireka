<?php
$uri_1 = $is_memo;


$t1 = 'load_silent("klg/' . $uri_1 . '/list/1/",".tab-content")';
$t2 = 'load_silent("klg/' . $uri_1 . '/list/2/",".tab-content")';
$t3 = 'load_silent("klg/' . $uri_1 . '/list/3/",".tab-content")';
$t4 = 'load_silent("klg/' . $uri_1 . '/list/4/",".tab-content")';
$t5 = 'load_silent("klg/' . $uri_1 . '/list/5/",".tab-content")';
$t6 = 'load_silent("klg/' . $uri_1 . '/list/6/",".tab-content")';
$t7 = 'load_silent("klg/' . $uri_1 . '/list/7/",".tab-content")';
$t8 = 'load_silent("klg/' . $uri_1 . '/list/8/",".tab-content")';
$t9 = 'load_silent("klg/' . $uri_1 . '/list/9/",".tab-content")';
$t10 = 'load_silent("klg/' . $uri_1 . '/list/10/",".tab-content")';
if ($param_tab == '1') {
    $this->fungsi->run_js($t1);
    $tab_1 = 'active';
    $tab_2 = '';
    $tab_3 = '';
    $tab_4 = '';
    $tab_5 = '';
    $tab_6 = '';
    $tab_7 = '';
    $tab_8 = '';
    $tab_9 = '';
    $tab_10 = '';
} else if ($param_tab == '2') {
    $this->fungsi->run_js($t2);
    $tab_1 = '';
    $tab_2 = 'active';
    $tab_3 = '';
    $tab_4 = '';
    $tab_5 = '';
    $tab_6 = '';
    $tab_7 = '';
    $tab_8 = '';
    $tab_9 = '';
    $tab_10 = '';
} else if ($param_tab == '3') {
    $this->fungsi->run_js($t3);
    $tab_1 = '';
    $tab_2 = '';
    $tab_3 = 'active';
    $tab_4 = '';
    $tab_5 = '';
    $tab_6 = '';
    $tab_7 = '';
    $tab_8 = '';
    $tab_9 = '';
    $tab_10 = '';
} else if ($param_tab == '4') {
    $this->fungsi->run_js($t4);
    $tab_1 = '';
    $tab_2 = '';
    $tab_3 = '';
    $tab_4 = 'active';
    $tab_5 = '';
    $tab_6 = '';
    $tab_7 = '';
    $tab_8 = '';
    $tab_9 = '';
    $tab_10 = '';
} else if ($param_tab == '5') {
    $this->fungsi->run_js($t5);
    $tab_1 = '';
    $tab_2 = '';
    $tab_3 = '';
    $tab_4 = '';
    $tab_5 = 'active';
    $tab_6 = '';
    $tab_7 = '';
    $tab_8 = '';
    $tab_9 = '';
    $tab_10 = '';
} else if ($param_tab == '6') {
    $this->fungsi->run_js($t6);
    $tab_1 = '';
    $tab_2 = '';
    $tab_3 = '';
    $tab_4 = '';
    $tab_5 = '';
    $tab_6 = 'active';
    $tab_7 = '';
    $tab_8 = '';
    $tab_9 = '';
    $tab_10 = '';
} else if ($param_tab == '7') {
    $this->fungsi->run_js($t7);
    $tab_1 = '';
    $tab_2 = '';
    $tab_3 = '';
    $tab_4 = '';
    $tab_5 = '';
    $tab_6 = '';
    $tab_7 = 'active';
    $tab_8 = '';
    $tab_9 = '';
    $tab_10 = '';
} else if ($param_tab == '8') {
    $this->fungsi->run_js($t8);
    $tab_1 = '';
    $tab_2 = '';
    $tab_3 = '';
    $tab_4 = '';
    $tab_5 = '';
    $tab_6 = '';
    $tab_7 = '';
    $tab_8 = 'active';
    $tab_9 = '';
    $tab_10 = '';
} else if ($param_tab == '9') {
    $this->fungsi->run_js($t9);
    $tab_1 = '';
    $tab_2 = '';
    $tab_3 = '';
    $tab_4 = '';
    $tab_5 = '';
    $tab_6 = '';
    $tab_7 = '';
    $tab_8 = '';
    $tab_9 = 'active';
    $tab_10 = '';
} else {
    $this->fungsi->run_js($t10);
    $tab_1 = '';
    $tab_2 = '';
    $tab_3 = '';
    $tab_4 = '';
    $tab_5 = '';
    $tab_6 = '';
    $tab_7 = '';
    $tab_8 = '';
    $tab_9 = '';
    $tab_10 = 'active';
}
?>
<div class="box box-default">

    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="<?= $tab_1 ?>"><a data-toggle="tab" onclick='<?php echo $t1; ?>' href="javascript:void(0)">RESIDENTIAL</a></li>
            <li class="<?= $tab_2 ?>"><a onclick='<?php echo $t2; ?>' data-toggle="tab" href="javascript:void(0)">ASTRAL RSD</a></li>
            <li class="<?= $tab_3 ?>"><a onclick='<?php echo $t3; ?>' data-toggle="tab" href="javascript:void(0)">ASTRAL BRAVO</a></li>
            <li class="<?= $tab_4 ?>"><a onclick='<?php echo $t4; ?>' data-toggle="tab" href="javascript:void(0)">ASTRAL BENDING EXTRUTION</a></li>
            <li class="<?= $tab_5 ?>"><a onclick='<?php echo $t5; ?>' data-toggle="tab" href="javascript:void(0)">VITTO</a></li>
            <li class="<?= $tab_6 ?>"><a onclick='<?php echo $t6; ?>' data-toggle="tab" href="javascript:void(0)">HRB</a></li>
            <li class="<?= $tab_7 ?>"><a onclick='<?php echo $t7; ?>' data-toggle="tab" href="javascript:void(0)">ALPHAMAX</a></li>
            <li class="<?= $tab_8 ?>"><a onclick='<?php echo $t8; ?>' data-toggle="tab" href="javascript:void(0)">EXPORT</a></li>
            <li class="<?= $tab_9 ?>"><a onclick='<?php echo $t9; ?>' data-toggle="tab" href="javascript:void(0)">ASTRAL KITCHEN</a></li>
            <li class="<?= $tab_10 ?>"><a onclick='<?php echo $t10; ?>' data-toggle="tab" href="javascript:void(0)">ASTRAL PARTISI & FURNITURE</a></li>
        </ul>
        <div class="tab-content">

        </div>
    </div>

</div>