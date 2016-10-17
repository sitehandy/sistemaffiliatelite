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

if (($_REQUEST['delete'] == 'allsalesrecords') && ($_REQUEST['validation'] == $_SESSION['aff_valid_admin']))
{
    // Sahkan proses penghapusan data
    $errorMsg = '';

    if($_POST['commited'] == 'yes')
    {        

        // Check for a password and match against the confirmed password.
        if (eregi ("^[[:alnum:]]{4,20}$", stripslashes(trim($_POST['passwordadmin'])))) {
            if ($_POST['passwordadmin'] == $_POST['passwordadmin2'])
            {
                $p = ($_POST['passwordadmin']);

                // Check Kesahihan Password Admin
                $datapassadmin = mysql_query("SELECT pass FROM admin WHERE user = '$_SESSION[aff_valid_admin]'", $database_connection) or die ('Database Connect Error');
                if (mysql_num_rows($datapassadmin))
                {
                    while ($qrypassadmin = mysql_fetch_array($datapassadmin))
                    $passadmin = $qrypassadmin['pass'];
                }

                //Tetapkan masalah jika password yang dimasukkan tak sama dalam database
                if (sha1(sha1($p)) != $passadmin)
                {
                    $errorMsg .= '<br />'.AFF_SI_PWDNOTMATCHDATABASE.'<br />';
                }
                
            } else {
                $p = FALSE;
                $errorMsg .= '<br />'.AFF_SI_PWDNOTMATCH.'<br />';
            }
        } else {
            $p = FALSE;
            $errorMsg .= '<br />'.AFF_SI_PWDMISSING.'<br />';
        }        
        
        if($errorMsg == '')
        {
            mysql_query("DELETE FROM sales", $database_connection) or die("Database DELETE Error");
            aff_redirect('pwjafflite_admin_sales.php');
        }

        if($errorMsg != '')
        {
            echo "<br /><table cellspacing=\"1\" class=\"SA_error_box\"><tr><td>$errorMsg<br /></td></tr></table><br />";
        }
    
    //Close Post Committed
    }
    ?>
    
    <br />
        <form action="pwjafflite_sales_delete_all.php?delete=allsalesrecords&validation=<?=$_SESSION['aff_valid_admin']?>" method="post" ENCTYPE="multipart/form-data">
            <div align="center">
                <table cellspacing="1" class="SA_adminarea_statisticbox">
                    <tr>
                        <td colspan="3" class="SA_adminarea_statisticbox_header"><?=AFF_A_SALESRESET?></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="SA_adminarea_statisticbox_row1">
                            <br /><?=AFF_A_SALESRESETCONFIRM?><br /><br />
                            <center><font color="#FF0000">Please Enter Admin Password to CONFIRM Deletion!</font></center><br />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="SA_adminarea_statisticbox_row2">&nbsp;</td>
                    </tr>                    
                    <tr>
                        <td class="SA_adminarea_statisticbox_row1"><div align="right"><?=AFF_AA_ADMINPASSWORD?></div></td>
                        <td class="SA_adminarea_statisticbox_row1"><div align="center">:</div></td>
                        <td class="SA_adminarea_statisticbox_row1"><input type="password" name="passwordadmin" size="20" maxlength="20" value=""><font color="#FF0000">*</font></td>
                    </tr>
                    <tr>
                        <td class="SA_adminarea_statisticbox_row2"><div align="right"><?=AFF_R_PASSWORD2?></div></td>
                        <td class="SA_adminarea_statisticbox_row2"><div align="center">:</div></td>
                        <td class="SA_adminarea_statisticbox_row2"><input type="password" name="passwordadmin2" maxlength="20" size="20" value=""><font color="#FF0000">*</font></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="SA_adminarea_statisticbox_row1">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan=3 valign="middle" class="SA_adminarea_statisticbox_row2">
                            <div align="center">
                                <input type="hidden" name="commited" value="yes" />
                                <input type="submit" name="Submit" value="<?=AFF_DELETE_CONFIRM?>" />
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </form>
        <br />

    <?php
}

//Check jika deletion berdasarkan status
else if (( ($_REQUEST['delete'] == AFF_AS_STATUSPENDING) || ($_REQUEST['delete'] == AFF_AS_STATUSVERIFIED) || ($_REQUEST['delete'] == AFF_AS_STATUSPAID) ) && ($_REQUEST['validation'] == $_SESSION['aff_valid_admin']))
{
    // Sahkan proses penghapusan data
    $errorMsg = '';

    if($_POST['commited'] == 'yes')
    {

        // Check for a password and match against the confirmed password.
        if (eregi ("^[[:alnum:]]{4,20}$", stripslashes(trim($_POST['passwordadmin'])))) {
            if ($_POST['passwordadmin'] == $_POST['passwordadmin2'])
            {
                $p = ($_POST['passwordadmin']);

                // Check Kesahihan Password Admin
                $datapassadmin = mysql_query("SELECT pass FROM admin WHERE user = '$_SESSION[aff_valid_admin]'", $database_connection) or die ('Database Connect Error');
                if (mysql_num_rows($datapassadmin))
                {
                    while ($qrypassadmin = mysql_fetch_array($datapassadmin))
                    $passadmin = $qrypassadmin['pass'];
                }

                //Tetapkan masalah jika password yang dimasukkan tak sama dalam database
                if (sha1(sha1($p)) != $passadmin)
                {
                    $errorMsg .= '<br />'.AFF_SI_PWDNOTMATCHDATABASE.'<br />';
                }

            } else {
                $p = FALSE;
                $errorMsg .= '<br />'.AFF_SI_PWDNOTMATCH.'<br />';
            }
        } else {
            $p = FALSE;
            $errorMsg .= '<br />'.AFF_SI_PWDMISSING.'<br />';
        }

        if($errorMsg == '')
        {
            mysql_query("DELETE FROM sales WHERE statuspelanggan = '$_REQUEST[delete]'", $database_connection) or die("Database DELETE Error");
            aff_redirect('pwjafflite_admin_sales.php');
        }

        if($errorMsg != '')
        {
            echo "<br /><table cellspacing=\"1\" class=\"SA_error_box\"><tr><td>$errorMsg<br /></td></tr></table><br />";
        }

    //Close Post Committed
    }
    ?>

    <br />
        <form action="pwjafflite_sales_delete_all.php?delete=<?=$_REQUEST['delete']?>&validation=<?=$_SESSION['aff_valid_admin']?>" method="post" ENCTYPE="multipart/form-data">
            <div align="center">
                <table cellspacing="1" class="SA_adminarea_statisticbox">
                    <tr>
                        <td colspan="3" class="SA_adminarea_statisticbox_header"><?=AFF_A_SALESSTATUSRESET?> - <?=$_REQUEST['delete']?></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="SA_adminarea_statisticbox_row1">
                            <br /><?=AFF_A_SALESSTATUSRESETCONFIRM?><br /><br />
                            <center><font color="#FF0000">Please Enter Admin Password to CONFIRM Deletion!</font></center><br />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="SA_adminarea_statisticbox_row2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="SA_adminarea_statisticbox_row1"><div align="right"><?=AFF_AA_ADMINPASSWORD?></div></td>
                        <td class="SA_adminarea_statisticbox_row1"><div align="center">:</div></td>
                        <td class="SA_adminarea_statisticbox_row1"><input type="password" name="passwordadmin" size="20" maxlength="20" value=""><font color="#FF0000">*</font></td>
                    </tr>
                    <tr>
                        <td class="SA_adminarea_statisticbox_row2"><div align="right"><?=AFF_R_PASSWORD2?></div></td>
                        <td class="SA_adminarea_statisticbox_row2"><div align="center">:</div></td>
                        <td class="SA_adminarea_statisticbox_row2"><input type="password" name="passwordadmin2" maxlength="20" size="20" value=""><font color="#FF0000">*</font></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="SA_adminarea_statisticbox_row1">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan=3 valign="middle" class="SA_adminarea_statisticbox_row2">
                            <div align="center">
                                <input type="hidden" name="commited" value="yes" />
                                <input type="submit" name="Submit" value="<?=AFF_DELETE_CONFIRM?>" />
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </form>
        <br />

    <?php
}

else echo '<br /><table cellspacing="1" class="SA_norecord_box"><tr><td><br />'.AFF_AS_SALESNORECORD.'<br /><br /></td></tr></table><br />';

//Papar Footer
echo $footerdisplay; 

?>