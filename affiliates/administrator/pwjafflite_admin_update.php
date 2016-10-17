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


?>   
<br />
<table width="600" cellspacing="1" class="SA_general_table">
    <tr>
        <td class="SA_general_table_header"><?=AFF_AA_ADMINUPDATETITLE?> - <?=$pwjafflite_version?></td>
    </tr>
    <tr>
        <td class="SA_general_table_row1">
            <br />
            <script src="http://www.sistemaffiliate.com/v2/changelog/update.js"></script>
            <br /><br />
        </td>
    </tr>
</table>
<br />
<?      

//Papar Footer
echo $footerdisplay;  

?>