<?php

session_start();
include '../../pwjafflite_config.php';
include '../lang/'.$language;

if(!aff_admin_check_security())
{
    aff_redirect('index.php');
    exit();
}

// Papar Header Sistem Affiliate
include 'header.php';

echo '<br /><table width="600" cellspacing="1" class="SA_general_table"><tr><td class="SA_general_table_header">'.AFF_P_ADMINTRACKINGINFO.'</td></tr><tr><td class="SA_general_table_row1"><div align="justify"><br />'.$arahan_tracking.'<br /><br /></div></td></tr></table><br />';

?>   

<br />
<table width="600" cellspacing="1" class="SA_general_table">
    <tr>
        <td class="SA_general_table_header"><?=AFF_P_ADMINTRACKINGNEWTITLE?></td>
    </tr>
    <tr>
        <td class="SA_general_table_row1"><br /><?=$arahan_tracking_new?><br /><br /></td>
    </tr>
    <tr>
        <td class="SA_general_table_row1"><div align="center"><br /><input type="text" value="&lt;?php include &quot;pwjafflite_tracking_affiliate_new.php&quot;; ?&gt;" size="70" /></div><br /></td>
    </tr>
</table>
<br />
<br />
<table width="600" cellspacing="1" class="SA_general_table">
    <tr>
        <td class="SA_general_table_header"><?=AFF_P_ADMINTRACKINGOLDTITLE?></td>
    </tr>
    <tr>
        <td class="SA_general_table_row1"><br /><?=$arahan_tracking_old?><br /><br /></td>
    </tr>
    <tr>
        <td class="SA_general_table_row1"><div align="center"><br /><input type="text" value="&lt;?php include &quot;pwjafflite_tracking_affiliate_old.php&quot;; ?&gt;" size="70" /></div><br /></td>
    </tr>
</table>
<br />
<?  

//Papar Footer
echo $footerdisplay;

?>