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
	
include 'header.php';

?>
<script language="javascript">
function checkAll(sales_records, checktoggle)
{
  var checkboxes = new Array(); 
  checkboxes = document[sales_records].getElementsByTagName('input');
 
  for (var i=0; i<checkboxes.length; i++)  {
    if (checkboxes[i].type == 'checkbox')   {
      checkboxes[i].checked = checktoggle;
    }
  }
}
</script>
<br />
<form  method="GET" action="pwjafflite_sales_search.php" ENCTYPE="multipart/form-data">
    <div align="center">
        <table cellspacing="1" class="SA_adminarea_statisticbox">
            <tr>
                <td colspan="3" class="SA_adminarea_statisticbox_header"><?=AFF_AS_SALESSEARCHTITLE?></td>
            </tr>
            <tr>
                <td colspan="3" class="SA_adminarea_statisticbox_row1"><?=$sales_search_info?></td>
            </tr>
            <tr>
                <td class="SA_adminarea_statisticbox_row2"><div align="right"><?=AFF_AS_SALESSEARCHKEYWORD?></div></td>
                <td class="SA_adminarea_statisticbox_row2"><div align="center">:</div></td>
                <td class="SA_adminarea_statisticbox_row2"><div align="left"><input type="text" name="carian" maxlength="50" /></div></td>
            </tr>
            <tr>
                <td class="SA_adminarea_statisticbox_row1"><div align="right"><?=AFF_AS_SALESSEARCHCATEGORY?></div></td>
                <td class="SA_adminarea_statisticbox_row1"><div align="center">:</div></td>
                <td class="SA_adminarea_statisticbox_row1">
                    <div align="left">
                        <input type="radio" name="katakunci" value="refid" checked="checked" /><?=AFF_AS_SALESSEARCHID?><br />
                        <input type="radio" name="katakunci" value="namapelanggan" /><?=AFF_AS_SALESSEARCHNAME?><br />
                        <input type="radio" name="katakunci" value="emailpelanggan" /><?=AFF_AS_SALESSEARCHEMAIL?><br />
                        <input type="radio" name="katakunci" value="jumlahpembayaran" /><?=AFF_AS_SALESSEARCHPRODUCT?><br />
                        <input type="radio" name="katakunci" value="kaedahpembayaran" /><?=AFF_AS_SALESSEARCHPROCESSOR?><br />
                        <input type="radio" name="katakunci" value="date" /><?=AFF_AS_SALESSEARCHDATE?><br />
                        <input type="radio" name="katakunci" value="time" /><?=AFF_AS_SALESSEARCHTIME?><br />
                        <input type="radio" name="katakunci" value="ipaddress" /><?=AFF_AS_SALESSEARCHIP?><br />
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="3" class="SA_adminarea_statisticbox_row2">&nbsp;</td>
            </tr>
            <tr>
                <td colspan=3 valign="middle" class="SA_adminarea_statisticbox_row1">
                    <div align="center">
                        <input type="submit" value="<?=AFF_AS_SALESSEARCHBUTTON?>">
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
			echo '[<a href="pwjafflite_sales_search.php?carian='.$_REQUEST['carian'].'&katakunci='.$_REQUEST['katakunci'].'&start='.$start.'">'.++$index.'</a>] ';
			$qty = $qty - $salesPage;
			$start = $start + $salesPage;
		}
	}

}

// Get Total Unit Sales for Paging
if (($_REQUEST['carian']) and ($_REQUEST['katakunci']))
{
    $qryT = mysql_query("SELECT * FROM sales WHERE $katakunci like '%$carian%'", $database_connection) or die ('Database Connect Error');
    $totalSales = mysql_num_rows($qryT);

    // Set Pages
    if($_REQUEST[start]) { $start = $_REQUEST[start]; }
    else { $start = 0; }

    // Wajibkan keyword diisi
    $errorMsg = '';
    if (($_REQUEST['carian']) == '')
    {
        $errorMsg = AFF_AS_SALESNOINPUT;
    }

    if ($errorMsg == '')
    {

        //Dapatkan rekod dari database
        $result = mysql_query("SELECT * FROM sales WHERE $katakunci like '%$carian%' ORDER BY idsales DESC LIMIT $start, $salesPage", $database_connection)
        or die ('<br /><table cellspacing="1" class="SA_norecord_box"><tr><td><br />'.AFF_AS_SALESNOINPUT.'<br /><br /></td></tr></table><br />');

        if (mysql_num_rows($result) > 0)
        {
            print '<br /><table cellspacing="1" class="SA_general_table">';
            print '<tr><td colspan="3" class="SA_general_table_header"><b>Page(s)</b></td></tr>';
            print '<tr><td colspan="3" class="SA_general_table_row1"><div id="text" align="center">';
            buildLeadIndex($totalSales, $salesPage);
            print '</div></td></tr>';
            print '</table><br />';

            //Papar Data Sales
            print '<form id="sales_records" name="sales_records" method="post" action="pwjafflite_multiple_action.php">';
            print '<br /><table cellspacing="1" class="SA_details_table">';
            print '<tr><td class="SA_details_table_header"></td>';
            print '<td class="SA_details_table_header">'.AFF_C_REFERRER.'</td>';
            print '<td class="SA_details_table_header">'.AFF_G_PRODUKJUALAN.'</td>';
            print '<td class="SA_details_table_header">'.AFF_G_KAEDAHPEMBAYARAN.'</td>';
            print '<td class="SA_details_table_header">'.AFF_G_DATE.'</td>';
            print '<td class="SA_details_table_header">'.AFF_G_TIME.'</td>';
            print '<td class="SA_details_table_header">'.AFF_G_EARNINGS.'</td>';
            print '<td class="SA_details_table_header">'.AFF_G_IPPELANGGAN.'</td>';
            print '<td class="SA_details_table_header">'.AFF_G_BROWSER.'</td>';
            print '<td class="SA_details_table_header">'.AFF_G_PELANGGAN.'</td>';
            print '<td class="SA_details_table_header">'.AFF_G_EMAILPELANGGAN.'</td>';
            print '<td class="SA_details_table_header">'.AFF_G_STATUSPELANGGAN.'</td>';
            print '<td class="SA_details_table_header">'.AFF_G_SAHKOMISYEN.'</td></tr>';

            while ($qry = mysql_fetch_array($result))
            {
                 print '<tr>';
                print '<td class="SA_details_table_row2"><input name="checkbox[]" type="checkbox" id="checkbox[]" value="'.$qry['idsales'].'"></td>';
                print '<td class="SA_details_table_row1"><a href="pwjafflite_affiliate_profile.php?edit='.$qry['refid'].'">'.$qry['refid'].'</a></td>';
                print '<td class="SA_details_table_row2"><div align="center">';
                print $qry['jumlahpembayaran'];
                print '</div></td>';
                print '<td class="SA_details_table_row1"><div align="center">';
                print $qry['kaedahpembayaran'];
                print '</div></td>';
                print '<td class="SA_details_table_row2"><div align="center">';
                print $qry['date'];
                print '</div></td>';
                print '<td class="SA_details_table_row1"><div align="center">';
                print $qry['time'];
                print '</div></td>';
                print '<td class="SA_details_table_row2"><div align="center">';
                print $qry['payment'];
                print '</div></td>';
                print '<td class="SA_details_table_row1"><div align="center">';
                print $qry['ipaddress'];
                print '</div></td>';
                print '<td class="SA_details_table_row2"><div align="center">';
                print $qry['browser'];
                print '</div></td>';
                print '<td class="SA_details_table_row1"><div align="center">';
                print $qry['namapelanggan'];
                print '</div></td>';
                print '<td class="SA_details_table_row2"><div align="center">';
                print '<a href="pwjafflite_admin_client.php?idjualan='.$qry['idsales'].'" toptions="width = 550, height = 500, type = iframe, title = Sistem Affiliate Lite, layout = quicklook">';
                print $qry['emailpelanggan'];
                print '</a></div></td>';
                print '<td class="SA_details_table_row1"><div align="center"><a href="pwjafflite_admin_sahkomisyen.php?pembeli='.$qry['idsales'].'" onClick="return confirm(\''.AFF_AS_SAH.'\')">'.$qry['statuspelanggan'].'</a></div></td>';
                print '<td class="SA_details_table_row2"><center>[<a href="pwjafflite_sales_delete.php?delete='.$qry['idsales'].'&validation='.$_SESSION['aff_valid_admin'].'" onClick="return confirm(\''.AFF_P_DELETE.'\')">Delete</a>]';
                print '<br />[<a href="pwjafflite_sales_edit.php?salesid='.$qry['idsales'].'&validation='.$_SESSION['aff_valid_admin'].' "onClick="return confirm(\''.AFF_P_EDIT.'\')"">Edit</a>]</center></td>';
                print '</tr>';
            }
            print '<tr><td colspan="13" class="SA_details_table_header" style="text-align: left;">
                <a href="javascript:void();" onclick="javascript:checkAll(\'sales_records\', true);">Check All</a> | 
                <a href="javascript:void();" onclick="javascript:checkAll(\'sales_records\', false);">Un-Check All</a> 
                <select name="action">
                <option value="null">With selected...</option>
                <option value="paid">Mark as Paid</option>
                <option value="verified">Mark as Verified</option>
                <option value="pending">Mark as Pending</option>
                <option value="cancel">Mark as Cancel</option>
                <option value="delete">Delete Selected</option>        
                </select>&nbsp;<input type="submit" name="submit" value="Take Action" /></td></tr>';
            print '</table><br /></form>';
        }
		
        //Papar Informasi Jika Tiada keyword dijumpai
        else echo '<br /><table cellspacing="1" class="SA_norecord_box"><tr><td><br />'.AFF_AS_SALESNORECORD.'<br /><br /></td></tr></table><br />';
    // Close
    }

    if($errorMsg != '')
    {
        echo '<br /><table cellspacing="1" class="SA_norecord_box"><tr><td><br />'.$errorMsg.'<br /><br /></td></tr></table><br />';
    }
// Close Post
}

//Papar Informasi Jika Tiada keyword dijumpai
else echo '<br /><table cellspacing="1" class="SA_norecord_box"><tr><td><br />'.AFF_AS_SALESNOINPUT.'<br /><br /></td></tr></table><br />';

//Papar Footer
echo $footerdisplay;

?>