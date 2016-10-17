<?php

session_start();
include '../../pwjafflite_config.php';
include '../pwjafflite_temp/pwjafflite_magicquotes.inc.php';
include '../lang/'.$language;

if(!aff_admin_check_security())
{
    aff_redirect('index.php');
    exit();
}

// Tetapkan variable
$titleErrorMsg  = AFF_SI_TITLE;
$carian         = mysql_real_escape_string($_GET['carian']);
$katakunci      = mysql_real_escape_string($_GET['katakunci']);

// Papar Header Sistem Affiliate
include 'header.php';

?>    
<br />
<form action="pwjafflite_affiliate_search.php" method="GET" ENCTYPE="multipart/form-data">
    <div align="center">
        <table cellspacing="1" class="SA_adminarea_statisticbox">
            <tr>
                <td colspan="3" class="SA_adminarea_statisticbox_header"><?=AFF_AS_AFFILIATESEARCHTITLE?></td>
            </tr>
            <tr>
                <td colspan="3" class="SA_adminarea_statisticbox_row1"><?=$affiliate_search_info?></td>
            </tr>
            <tr>
                <td class="SA_adminarea_statisticbox_row2"><div align="right"><?=AFF_AS_AFFILIATESEARCHKEYWORD?></div></td>
                <td class="SA_adminarea_statisticbox_row2"><div align="center">:</div></td>
                <td class="SA_adminarea_statisticbox_row2"><div align="left"><input type="text" name="carian" maxlength="50" /></div></td>
            </tr>
            <tr>
                <td class="SA_adminarea_statisticbox_row1"><div align="right"><?=AFF_AS_AFFILIATESEARCHCATEGORY?></div></td>
                <td class="SA_adminarea_statisticbox_row1"><div align="center">:</div></td>
                <td class="SA_adminarea_statisticbox_row1">
                    <div align="left">
                        <input type="radio" name="katakunci" value="refid" checked="checked" /><?=AFF_AS_AFFILIATESEARCHID?><br />
                        <input type="radio" name="katakunci" value="firstname" /><?=AFF_AS_AFFILIATESEARCHNAME?><br />
                        <input type="radio" name="katakunci" value="email" /><?=AFF_AS_AFFILIATESEARCHEMAIL?><br />
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="3" class="SA_adminarea_statisticbox_row2">&nbsp;</td>
            </tr>
            <tr>
                <td colspan=3 valign="middle" class="SA_adminarea_statisticbox_row1">
                    <div align="center">
                        <input type="submit" value="<?=AFF_AS_AFFILIATESEARCHBUTTON?>">
                    </div>
                </td>
            </tr>
        </table>
    </div>
</form>
<br />

<?

////////////// Setup Paging Sistem///////////

$salesPage = 30;
function buildLeadIndex($qty, $salesPage)
{
	if($qty > $salesPage)
	{
		echo 'Page: ';
		$index = 0;
		$start = 0;
		while($qty > 0)
		{
			echo '[<a href="pwjafflite_affiliate_search.php?carian='.$_REQUEST['carian'].'&katakunci='.$_REQUEST['katakunci'].'&start='.$start.'">'.++$index.'</a>] ';
			$qty = $qty - $salesPage;
			$start = $start + $salesPage;
		}
	}

}

// Get Total Unit Sales for Paging
if (($_REQUEST['carian']) and ($_REQUEST['katakunci']))
{
    $qryT = mysql_query("SELECT * FROM affiliates WHERE $katakunci like '%$carian%'", $database_connection) or die ('Database Connect Error');
    $totalSales = mysql_num_rows($qryT);

    // Set Pages
    if($_REQUEST[start]) { $start = $_REQUEST[start]; }
    else { $start = 0; }

    // Wajibkan keyword diisi
    $titleErrorMsg = AFF_SI_TITLE;

    $errorMsg = '';
    if (($_REQUEST['carian']) == '')
    {
        $errorMsg = AFF_AS_SALESNOINPUT;
    }

    if ($errorMsg == '')
    {

        //Dapatkan rekod dari database
        $result = mysql_query("SELECT * from affiliates WHERE $katakunci like '%$carian%' ORDER BY refid LIMIT $start, $salesPage", $database_connection) or die ('<br /><table cellspacing="1" class="SA_norecord_box"><tr><td><br />'.AFF_AS_AFFILIATENOINPUT.'<br /><br /></td></tr></table><br />');

        if (mysql_num_rows($result) > 0)
        {
            print '<br /><table cellspacing="1" class="SA_general_table">';
            print '<tr><td colspan="3" class="SA_general_table_header"><b>Page(s)</b></td></tr>';
            print '<tr><td colspan="3" class="SA_general_table_row1"><div id="text" align="center">';
            buildLeadIndex($totalSales, $salesPage);
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

            while ($qry = mysql_fetch_array($result))
            {
                print '<tr><td class="SA_details_table_row1"><div align="center">';
                print $qry['refid'];
                print '</div></td><td class="SA_details_table_row2"><div align="center">';
                print $qry['title'].' '.$qry['firstname'].' '.$qry['lastname'];
                print '</div></td><td class="SA_details_table_row1"><div align="center">';
                print '<a href="pwjafflite_affiliate_email.php?agen='.$qry['refid'].'" toptions="width = 550, height = 500, type = iframe, title = Sistem Affiliate Lite, layout = quicklook">';
                print $qry['email'];
                print '</a></div></td><td class="SA_details_table_row2"><div align="center">';
                print $qry['phone'];
                print '</div></td><td class="SA_details_table_row1"><div align="center">';
                print $qry['county'];
                print '</div></td><td class="SA_details_table_row2"><div align="center">';
                print $qry['date'];
                print '</div></td><td class="SA_details_table_row1"><div align="center">';
                print $qry['ipaddress'];
                print '</div></td><td class="SA_details_table_row2"><div align="center">[<a href="pwjafflite_affiliate_profile.php?edit='.$qry['refid'].'">'.AFF_AA_DETAILSLINK.'</a>]<br>[<a href="pwjafflite_affiliate_delete.php?delete='.$qry['refid'].'&validation='.$_SESSION['aff_valid_admin'].'" onClick="return confirm(\''.AFF_P_DELETE.'\')">'.AFF_AA_DELETELINK.'</a>]</div></td>';
                print '</tr>';
            }
            print '</table><br />';
        }

        //Papar Informasi Jika Tiada keyword dijumpai
        else echo '<br /><table cellspacing="1" class="SA_norecord_box"><tr><td><br />'.AFF_AS_SALESNORECORD.'<br /><br /></td></tr></table><br />';
    }

    if($errorMsg != '')
    {
            echo '<br /><table cellspacing="1" class="SA_norecord_box"><tr><td><br />'.$errorMsg.'<br /><br /></td></tr></table><br />';
    }
			
}

//Papar Informasi Jika Tiada keyword dijumpai
else echo '<br /><table cellspacing="1" class="SA_norecord_box"><tr><td><br />'.AFF_AS_SALESNOINPUT.'<br /><br /></td></tr></table><br />';

//Papar Footer
echo $footerdisplay; 

?>