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
<form method="post" action="pwjafflite_affiliate_statistic.php">
    <table width="400" cellspacing="1" class="SA_general_table">
        <tr>
            <td colspan="3" class="SA_general_table_header"><?=AFF_AA_INFOAGEN?></td>
        </tr>
        <tr>
            <td class="SA_general_table_row1"><?=AFF_AA_PAPARAGEN?></td>
            <td class="SA_general_table_row1"><div align="center">:</div></td>
            <td class="SA_general_table_row1">
                <div align="center">
                    <select name="change">
<?          
// Dapatkan Data Affiliate
$result = mysql_query("SELECT refid FROM affiliates ORDER BY refid", $database_connection) or die ('Database Error');
if (mysql_num_rows($result))
{
    while ($qry = mysql_fetch_array($result))
    echo '<option value="'.$qry['refid'].'">'.$qry['refid'].'</option>';
}

?>
                    </select>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="3" class="SA_general_table_row2">
                <div align="center">
                    <input type="submit" value="<?=AFF_AA_PAPARAGENBUTTON?>">
                </div>
            </td>
        </tr>
    </table>
</form>
<br />
<?

////////////// Setup Paging Sistem///////////

$membersPage = 30;
function buildLeadIndex($qty, $membersPage)
{
	if($qty > $membersPage)
	{
		echo 'Page: ';
		$index = 0;
		$start = 0;
		while($qty > 0)
		{
			echo '[<a href="pwjafflite_admin_affiliates.php?start='.$start.'">'.++$index.'</a>] ';
			$qty = $qty - $membersPage;
			$start = $start + $membersPage;
		}
	}
}

// get total members
$qryT = mysql_query("SELECT * FROM affiliates", $database_connection) or die ('Database Error');
$totalMember = mysql_num_rows($qryT);

// get members
if($_REQUEST[start]) { $start = $_REQUEST[start]; }
else { $start = 0; }

////Get Affiliate Data

$queryaffiliate = mysql_query("SELECT * FROM affiliates ORDER BY date DESC LIMIT $start, $membersPage", $database_connection) or die ('Database Error');

//////////////// Paparkan Paging/////////
if (mysql_num_rows($queryaffiliate) > 0)
{
	print '<br /><table cellspacing="1" class="SA_general_table">';
	print '<tr><td class="SA_general_table_header">'.AFF_AA_AFFILIATESPAGES.': <b><u>';
	print $totalMember.'</u></b></td></tr>';
	print '<tr><td class="SA_general_table_row1"><div id="text" align="center">';
	buildLeadIndex($totalMember, $membersPage);
	print '</div></td></tr>';
	print '</table><br />';

//Papar Data Agen

        print '<br /><table cellspacing="1" class="SA_details_table">';
        print '<tr><td class="SA_details_table_header">'.AFF_AA_IDAFFILIATE.'</td>';
        print '<td class="SA_details_table_header">'.AFF_AA_NAMAAFFILIATE.'</td>';
        print '<td class="SA_details_table_header">'.AFF_AA_EMAILAFFILIATE.'</td>';
        print '<td class="SA_details_table_header">'.AFF_AA_PHONEAFFILIATE.'</td>';
        print '<td class="SA_details_table_header">'.AFF_AA_NEGERIAFFILIATE.'</td>';
        print '<td class="SA_details_table_header">'.AFF_AA_TARIKHDAFTAR.'</td>';
        print '<td class="SA_details_table_header">'.AFF_AA_IPDAFTAR.'</td>';
        print '<td class="SA_details_table_header">'.AFF_G_SAHKOMISYEN.'</td></tr>';

        while ($qry = mysql_fetch_array($queryaffiliate))
        {
            print '<tr><td class="SA_details_table_row1"><div align="center">';
            print $qry['refid'];
            print '</div></td><td class="SA_details_table_row2"><div align="center">';
            print $qry['title'].' '.$qry['firstname'].' '.$qry['lastname'];
            print '</div></td><td class="SA_details_table_row1"><div align="center">';
            print '<a href="pwjafflite_affiliate_email.php?agen='.$qry['refid'].'" toptions="width = 550, height = 500, type = iframe, title = Sistem Affiliate Lite, layout = quicklook">';
            print $qry['email'];
            print '</div></a></td><td class="SA_details_table_row2"><div align="center">';
            print $qry['phone'];
            print '</div></td><td class="SA_details_table_row1"><div align="center">';
            print $qry['county'];
            print '</div></td><td class="SA_details_table_row2"><div align="center">';
            print $qry['date'];
            print '</div></td><td class="SA_details_table_row1"><div align="center">';
            print $qry['ipaddress'];
            print '</div></td><td class="SA_details_table_row2"><div align="center">';
            print '[<a href="pwjafflite_affiliate_profile.php?edit='.$qry['refid'].'">'.AFF_AA_DETAILSLINK.'</a>]<br />[<a href="pwjafflite_affiliate_delete.php?delete='.$qry['refid'].'&validation='.$_SESSION['aff_valid_admin'].' "onClick="return confirm(\''.AFF_P_DELETE.'\')">'.AFF_AA_DELETELINK.'</a>]</div></td></tr>';
        }
        
        print '</table><br />';
}

//Papar Informasi Jika Tiada Jualan Terhasi Lagi
else echo '<br /><table cellspacing="1" class="SA_norecord_box"><tr><td><br />'.AFF_AA_TIADAAGEN.'<br /><br /></td></tr></table><br />';

//Papar Footer
echo $footerdisplay;    

?>