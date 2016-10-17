<?php
include_once '../pwjafflite_config.php';
include_once './lang/'.$language;

include 'header.php';

?>        
<br />
<table width="600" cellspacing="1" class="SA_general_table">
    <tr>
        <td class="SA_general_table_header"><?=AFF_TY_TITLE?></td>
    </tr>
    <tr>
        <td class="SA_general_table_row1"><br />
            <? echo $instruction_page_thankyou; ?>
            <br />
        </td>
    </tr>
</table>
<br />
<?

//Papar Footer Dari Fail pwjafflite_config.php
echo $footerdisplay;

?>