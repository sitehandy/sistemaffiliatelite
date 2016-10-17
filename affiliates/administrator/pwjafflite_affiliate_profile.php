<?php

session_start();

// Intergrasi sistem borang dengan PHPMailer
include '../../includes/mail/class.phpmailer.php';

include '../../pwjafflite_config.php';
include '../lang/'.$language;
include '../countries.php';
include '../pwjafflite_title.php';
include '../pwjafflite_processor.php';

$titleErrorMsg = AFF_SI_TITLE;

if(!aff_admin_check_security())
{
    aff_redirect('index.php');
    exit();
}

// Papar Header Sistem Affiliate
include 'header.php';

$errorMsg = '';

if($_POST['commited'] == 'yes')
{
    // Check for a password and match against the confirmed password.
    if (eregi ("^[[:alnum:]]{4,20}$", stripslashes(trim($_POST['password'])))) {
        if ($_POST['password'] == $_POST['password2']) {
            $p = ($_POST['password']);
        } else {
            $p = FALSE;
            $errorMsg .= '<br />'.AFF_SI_PWDNOTMATCH.'<br />';
        }
    } else {
        $p = FALSE;
        $errorMsg .= '<br />'.AFF_SI_PWDMISSING.'<br />';
    }

    // check email valid
    $clientemail = $_POST['clientemail'];

    if ($_POST['clientemail'] == ''){
    $errorMsg .= '<br />'.AFF_SI_EMAILMISSING.'<br />';
    }

    if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $clientemail)){
    $errorMsg .= '<br />'.AFF_SI_EMAILNOTVALID.'<br />';
    }

    //encrypt password admin
    $passwordagen = sha1(sha1($_POST['password']));

    // Jika tiada masalah, update database admin

    if($errorMsg == '')
    {
	
$email_agen_tukar_password = "

Salam sejahtera,

Butiran login ke ruang agen sistem affiliate di 

http://$domain/$folderaffiliates

telah ditukar oleh admin bagi program affiliate

$namaproduk.

===========================================================
Maklumat Login Baru
===========================================================

Login Agen: ".$_REQUEST['edit']."
Password Agen: ".$_POST['password']."
Email Agen: ".$_POST['clientemail']."


===========================================================

Jika ada sebarang permasalahan dengan penukaran ini, sila
hubungi admin pada $emailadminsupport

Sekian, terima kasih.

$admininfo
http://$domain/

";



        /********************************
        * Versi lama proses kiriman emel
        *********************************/
        // Proses Email Pengesahan Komisyen.
        // mail($_POST['clientemail'], AFF_G_AFFILIATELOGINCHANGED,"$email_agen_tukar_password","From: $admininfo<$emailadminsupport>");

        /********************************
        * Versi baru proses kiriman emel (Updated July 2013)
        * Penggunaan PHPMailer: https://github.com/Synchro/PHPMailer
        *********************************/

        $mail = new PHPMailer;

        $mail->IsMail();									// Set mailer to use PHP Mail

        $mail->From = $emailadminsupport;
        $mail->FromName = $admininfo;
        $mail->AddAddress($_POST['clientemail']);		// Add a recipient
        $mail->AddReplyTo($emailadminsupport);

        $mail->IsHTML(false);								// Set email format to plain text

        $mail->Subject = AFF_G_AFFILIATELOGINCHANGED;

        $mail->Body    = $email_agen_tukar_password; 				// Email body

        // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        if(!$mail->Send()) {
           echo 'Message could not be sent.';
           echo 'Mailer Error: ' . $mail->ErrorInfo;
           exit();
        }
	
// Update Database Table Affiliate
mysql_query("UPDATE affiliates SET pass = '".$passwordagen."', email = '".$_POST['clientemail']."' WHERE refid = '".$_REQUEST['edit']."'", $database_connection) or die ("Database INSERT Error");
echo "<br /><table cellspacing=\"1\" class=\"SA_success_box\"><tr><td><br />".AFF_AD_PASSEMAILCHANGED."<br /><br /></td></tr></table><br />";
    }
}

if($errorMsg != '')
{
    echo "<br /><table cellspacing=\"1\" class=\"SA_error_box\"><tr><td>$errorMsg<br /></td></tr></table><br />";
}

// Dapatkan Data Affiliate
$result = mysql_query("SELECT * from affiliates where refid = '".$_REQUEST['edit']."'", $database_connection) or die ("Database INSERT Error");
if (mysql_num_rows($result))
{
    while ($qry = mysql_fetch_array($result)) 
    {
        ?>
        <br />
        <form action="pwjafflite_affiliate_profile.php?edit=<?=$_REQUEST['edit']?>" method="post" ENCTYPE="multipart/form-data">
            <div align="center">
                <table cellspacing="1" class="SA_adminarea_statisticbox">
                    <tr>
                        <td colspan="3" class="SA_adminarea_statisticbox_header"><?=AFF_G_AFFILIATELOGINPROFILE?></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="SA_adminarea_statisticbox_row1"><br /><?=$affiliate_profile_info?><br /><br /></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="SA_adminarea_statisticbox_row2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="SA_adminarea_statisticbox_row1"><div align="right"><?=AFF_AD_USERNAME?></div></td>
                        <td class="SA_adminarea_statisticbox_row1"><div align="center">:</div></td>
                        <td class="SA_adminarea_statisticbox_row1"><?=$_REQUEST['edit']?></td>
                    </tr>
                    <tr>
                        <td class="SA_adminarea_statisticbox_row2"><div align="right"><?=AFF_AD_PASSWORD?></div></td>
                        <td class="SA_adminarea_statisticbox_row2"><div align="center">:</div></td>
                        <td class="SA_adminarea_statisticbox_row2"><input type="password" name="password" size="20" maxlength="20" value=""><font color="#FF0000">*</font></td>
                    </tr>
                    <tr>
                        <td class="SA_adminarea_statisticbox_row1"><div align="right"><?=AFF_R_PASSWORD2?></div></td>
                        <td class="SA_adminarea_statisticbox_row1"><div align="center">:</div></td>
                        <td class="SA_adminarea_statisticbox_row1"><input type="password" name="password2" maxlength="20" size="20" value=""><font color="#FF0000">*</font></td>
                    </tr>
                    <tr>
                        <td class="SA_adminarea_statisticbox_row2"><div align="right"><a href="javascript:void(0)" onclick="window.open('pwjafflite_affiliate_email.php?agen=<?=$qry['refid']?>','Email Client','width=550,height=600')"><?=AFF_AD_EMAILAGEN?></a></div></td>
                        <td class="SA_adminarea_statisticbox_row2"><div align="center">:</div></td>
                        <td class="SA_adminarea_statisticbox_row2"><input type="text" name="clientemail" size="30" value="<?=$qry[email]?>"><font color="#FF0000">*</font></td>
                    </tr>
                    <tr>
                        <td class="SA_adminarea_statisticbox_row1"><div align="right"><?=AFF_AA_UPLINE?></div></td>
                        <td class="SA_adminarea_statisticbox_row1"><div align="center">:</div></td>
                        <td class="SA_adminarea_statisticbox_row1"><a href="pwjafflite_affiliate_profile.php?edit=<?=$qry[upline]?>" target="_blank"><?=$qry[upline]?></a></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="SA_adminarea_statisticbox_row2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan=3 valign="middle" class="SA_adminarea_statisticbox_row1">
                            <div align="center">
                                <input type="hidden" name="commited" value="yes" />
                                <input type="submit" name="Submit" value="<?=AFF_AD_UPDATEPASSEMAIL?>" />
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </form>
        <br />
        <?
    }
}


// Update Butiran Peribadi Agen
$errorMsg = '';

if($_POST['update'] == 'yes')
{
    // check firstname
    if($_POST['clientfirstname'] == ''){
    $errorMsg .= '<br />'.AFF_SI_FIRSTNAMEMISSING.'<br />';
    }

    // check lastname
    if($_POST['clientlastname'] == ''){
    $errorMsg .= '<br />'.AFF_SI_LASTNAMEMISSING.'<br />';
    }

    // check address
    if($_POST['clientstreet'] == ''){
    $errorMsg .= '<br />'.AFF_SI_ADDRESSMISSING.'<br />';
    }

    // check town
    if($_POST['clienttown'] == ''){
    $errorMsg .= '<br />'.AFF_SI_TOWNMISSING.'<br />';
    }
 
    // check state
    if($_POST['clientcounty'] == ''){
    $errorMsg .= '<br />'.AFF_SI_STATEMISSING.'<br />';
    }

    // check poskod
    if($_POST['clientpostcode'] == ''){
    $errorMsg .= '<br />'.AFF_SI_POSKODMISSING.'<br />';
    }

    // check phone
    if($_POST['clientphone'] == ''){
    $errorMsg .= '<br />'.AFF_SI_PHONEMISSING.'<br />';
    }

    // check pemprosesan
    if($_POST['clientprocessor'] == ''){
    $errorMsg .= '<br />'.AFF_SI_PEMPROSESANMISSING.'<br />';
    }

    // check no akaun
    if($_POST['clientaccount'] == ''){
    $errorMsg .= '<br />'.AFF_SI_ACCOUNTMISSING.'<br />';
    }

    if($errorMsg == '')
    {
        mysql_query("UPDATE affiliates SET title = '".$_POST['clienttitle']."', firstname = '".$_POST['clientfirstname']."', lastname = '".$_POST['clientlastname']."', website = '".$_POST['webpage']."', street = '".$_POST['clientstreet']."', town = '".$_POST['clienttown']."', county = '".$_POST['clientcounty']."', postcode = '".$_POST['clientpostcode']."', country = '".$_POST['clientcountry']."', phone = '".$_POST['clientphone']."', processor = '".$_POST['clientprocessor']."', account = '".$_POST['clientaccount']."', payto = '".$_POST['clientpayto']."' WHERE refid = '".$_REQUEST['edit']."'", $database_connection) or die ("Database INSERT Error");
        echo "<br /><table cellspacing=\"1\" class=\"SA_success_box\"><tr><td><br />".AFF_AD_AFFPROFILECHANGED."<br /><br /></td></tr></table><br />";
    }
}

if($errorMsg != '')
{
    echo "<br /><table cellspacing=\"1\" class=\"SA_error_box\"><tr><td>$errorMsg<br /></td></tr></table><br />";
}

//Dapatkan Data Affiliate
$result = mysql_query("SELECT * FROM affiliates where refid = '".$_REQUEST['edit']."'") or die ("Database Connect Error");
if (mysql_num_rows($result)) 
{
    while ($qry = mysql_fetch_array($result))
    {
        ?>
        <br  />
        <form action="pwjafflite_affiliate_profile.php?edit=<?=$_REQUEST['edit']?>" method="post" ENCTYPE="multipart/form-data">
            <div align="center">
                <table cellspacing="1" class="SA_adminarea_statisticbox">
                    <tr>
                        <td colspan="3" class="SA_adminarea_statisticbox_header"><?=AFF_R_DETAILS?></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="SA_adminarea_statisticbox_row1"><br /><?=$affiliate_profile_info2?><br /><br /></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="SA_adminarea_statisticbox_row2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="SA_adminarea_statisticbox_row1"><?=AFF_R_TITLE?></td>
                        <td class="SA_adminarea_statisticbox_row1"><div align="center">:</div></td>
                        <td class="SA_adminarea_statisticbox_row1">
                            <select name="clienttitle" class="dropdown">
<?
foreach($GLOBALS['title'] as $key => $title)
print '<option value="'.$key.'" '.($qry['title'] == $key ? 'selected' : '').'>'.$title.'</option>'."\n";
?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="SA_adminarea_statisticbox_row2"><?=AFF_R_FIRSTNAME?></td>
                        <td class="SA_adminarea_statisticbox_row2"><div align="center">:</div></td>
                        <td class="SA_adminarea_statisticbox_row2"><input type="text" name="clientfirstname" size="30" value="<?=$qry['firstname']?>"><font color="#FF0000">*</font></td>
                    </tr>
                    <tr>
                        <td class="SA_adminarea_statisticbox_row1"><?=AFF_R_LASTNAME?></td>
                        <td class="SA_adminarea_statisticbox_row1"><div align="center">:</div></td>
                        <td class="SA_adminarea_statisticbox_row1"><input type="text" name="clientlastname" size="30" value="<?=$qry['lastname']?>"><font color="#FF0000">*</font></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="SA_adminarea_statisticbox_row2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="SA_adminarea_statisticbox_row1"><?=AFF_R_STREET?></td>
                        <td class="SA_adminarea_statisticbox_row1"><div align="center">:</div></td>
                        <td class="SA_adminarea_statisticbox_row1"><input type="text" name="clientstreet" size="30" value="<?=$qry['street']?>"><font color="#FF0000">*</font></td>
                    </tr>
                    <tr>
                        <td class="SA_adminarea_statisticbox_row2"><?=AFF_R_CITY?></td>
                        <td class="SA_adminarea_statisticbox_row2"><div align="center">:</div></td>
                        <td class="SA_adminarea_statisticbox_row2"><input type="text" name="clienttown" size="30" value="<?=$qry['town']?>"><font color="#FF0000">*</font></td>
                    </tr>
                    <tr>
                        <td class="SA_adminarea_statisticbox_row1"><?=AFF_R_STATE?></td>
                        <td class="SA_adminarea_statisticbox_row1"><div align="center">:</div></td>
                        <td class="SA_adminarea_statisticbox_row1"><input type="text" name="clientcounty" size="30" value="<?=$qry['county']?>"><font color="#FF0000">*</font></td>
                    </tr>
                    <tr>
                        <td class="SA_adminarea_statisticbox_row2"><?=AFF_R_POSTCODE?></td>
                        <td class="SA_adminarea_statisticbox_row2"><div align="center">:</div></td>
                        <td class="SA_adminarea_statisticbox_row2"><input type="text" name="clientpostcode" size="10" value="<?=$qry['postcode']?>"><font color="#FF0000">*</font></td>
                    </tr>
                    <tr>
                        <td class="SA_adminarea_statisticbox_row1"><?=AFF_R_COUNTRY?></td>
                        <td class="SA_adminarea_statisticbox_row1"><div align="center">:</div></td>
                        <td class="SA_adminarea_statisticbox_row1">
                            <select name="clientcountry" class="dropdown">
<?
foreach($GLOBALS['countries'] as $key => $country)
print '<option value="'.$key.'" '.($qry['country'] == $key ? 'selected' : '').'>'.$country.'</option>'."\n";
?>
                            </select><font color="#FF0000">*</font>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="SA_adminarea_statisticbox_row2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="SA_adminarea_statisticbox_row1"><?=AFF_R_PHONE?></td>
                        <td class="SA_adminarea_statisticbox_row1"><div align="center">:</div></td>
                        <td class="SA_adminarea_statisticbox_row1"><input type="text" name="clientphone" size="30" value="<?=$qry['phone']?>"><font color="#FF0000">*</font></td>
                    </tr>
                    <tr>
                        <td class="SA_adminarea_statisticbox_row2"><?=AFF_R_WEBSITE?></td>
                        <td class="SA_adminarea_statisticbox_row2"><div align="center">:</div></td>
                        <td class="SA_adminarea_statisticbox_row2"><input type="text" name="webpage" size="30" value="<?=$qry['website']?>"></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="SA_adminarea_statisticbox_row1">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="SA_adminarea_statisticbox_header"><?=AFF_R_PAYMENTTYPEINFO?></td>
                    </tr>
                    <tr>
                        <td class="SA_adminarea_statisticbox_row1"><?=AFF_R_PAYMENTTYPE?></td>
                        <td class="SA_adminarea_statisticbox_row1"><div align="center">:</div></td>
                        <td class="SA_adminarea_statisticbox_row1">
                            <select name="clientprocessor" class="dropdown">
<?
foreach($GLOBALS['processor'] as $key => $processor)
print '<option value="'.$key.'" '.($qry['processor'] == $key ? 'selected' : '').'>'.$processor.'</option>'."\n";
?>
                            </select><font color="#FF0000">*</font>
                        </td>
                    </tr>
                    <tr>
                        <td class="SA_adminarea_statisticbox_row2"><?=AFF_R_ACCOUNTNO?></td>
                        <td class="SA_adminarea_statisticbox_row2"><div align="center">:</div></td>
                        <td class="SA_adminarea_statisticbox_row2"><input type="text" name="clientaccount" size="30" value="<?=$qry['account']?>"><font color="#FF0000">*</font></td>
                    </tr>
                    <tr>
                        <td class="SA_adminarea_statisticbox_row1"><?=AFF_R_PAYTO?></td>
                        <td class="SA_adminarea_statisticbox_row1"><div align="center">:</div></td>
                        <td class="SA_adminarea_statisticbox_row1"><input type="text" name="clientpayto" size="30" value="<?=$qry['payto']?>"></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="SA_adminarea_statisticbox_row2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan=3 valign="middle" class="SA_adminarea_statisticbox_row1">
                            <div align="center">
                                <input type="hidden" name="update" value="yes" />
                                <input type="submit" name="Submit" value="<?=AFF_AD_UPDATEAFFDETAILS?>" />
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </form>
        <br />
        <br />
        <table cellspacing="1" class="SA_adminarea_statisticbox">
            <tr>
                <td colspan="3" class="SA_adminarea_statisticbox_row1"><br /><? echo $instruction_affiliate_profile_admin; ?><br /><br /></td>
            </tr>
        </table>
        <br />
        <?
    }

// Close Post
}

//Papar Informasi Jika Tiada Jualan Terhasi Lagi
else echo "<br /><table cellspacing=\"1\" class=\"SA_norecord_box\"><tr><td><br />".AFF_AD_NOAFFILIATESELECTION."<br /><br /></td></tr></table><br />";

//Papar Footer
echo $footerdisplay; 

?>