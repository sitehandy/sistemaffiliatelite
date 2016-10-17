<?php

session_start();

include '../pwjafflite_config.php';
include './lang/'.$language;
include './countries.php';
include './pwjafflite_title.php';
include './pwjafflite_processor.php';

if(!aff_check_security())
{
    aff_redirect('index.php');
    exit();
}

include 'header.php';

  
$getpassword    = $_POST['password'];
$userpassword   = preg_replace('/[^a-zA-Z0-9_]/', '',$getpassword);
 

// Semak update profile
$errorMsg = '';
 
if($_POST['commited'] == 'yes')
{
    // Check for a password and match against the confirmed password.
    if (strlen($userpassword) > 3) {
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

	if(!filter_var($clientemail, FILTER_VALIDATE_EMAIL)){ 
      $errorMsg .= '<br />'.AFF_SI_EMAILNOTVALID.'<br />';
	  } 
	  

//encrypt password agen
$passwordagen = sha1(sha1($_POST['password']));

// Jika tiada masalah, update database affiliate
if($errorMsg == '')
{

// Hantar notifikasi ruangan butiran login affiliate telah ditukar	  
$email_agen_tukar_password = "

Salam sejahtera,

Butiran login ke ruang agen sistem affiliate di 

http://$domain/$folderaffiliates

telah anda tukar. Maklumatnya adalah seperti berikut:

===========================================================
Maklumat Login Baru
===========================================================

Login Agen: ".$_SESSION['aff_valid_user']."
Password Agen: ".$_POST['password']."
Email Agen: ".$_POST['clientemail']."


Link Affiliate:
=> http://$domain/hop?ref=".$_SESSION['aff_valid_user']."

===========================================================

Jika ada sebarang permasalahan dengan penukaran ini, sila
hubungi admin pada $emailadminsupport

Sekian, terima kasih.

$admininfo
http://$domain/

";

mail($_POST['clientemail'], AFF_G_AFFILIATELOGINCHANGED,"$email_agen_tukar_password","From: $admininfo<$emailadminsupport>");
	
// Update Database Table Affiliate
mysql_query("UPDATE affiliates SET pass = '".$passwordagen."', email = '".$_POST['clientemail']."' WHERE refid = '".$_SESSION['aff_valid_user']."'", $database_connection) or die ("Database INSERT Error");


echo "<br /><table cellspacing=\"1\" class=\"SA_success_box\"><tr><td><br />".AFF_MA_PROFILECHANGED."<br /><br /></td></tr></table><br />";
}
//Close Post
}

// Jika ada masalah dengan update profile, paparkan masalahnya
if($errorMsg != '')
{
    echo "<br /><table cellspacing=\"1\" class=\"SA_error_box\"><tr><td>$errorMsg<br /></td></tr></table><br />";
}

// Dapatkan Data Affiliate
$result = mysql_query("select * from affiliates where refid = '".$_SESSION['aff_valid_user']."'", $database_connection) or die ("Database INSERT Error (line 19)");
if (mysql_num_rows($result)) 
{
    while ($qry = mysql_fetch_array($result))
    {
?>               
<br />
      <form action="pwjafflite_member_profile.php" method="post" ENCTYPE="multipart/form-data">
          <table cellspacing="1" class="SA_adminarea_statisticbox">
              <tr>
                  <td colspan="3" class="SA_adminarea_statisticbox_header"><?=AFF_G_AFFILIATELOGINPROFILE?></td>
              </tr>
              <tr>
    		  <td colspan="3" class="SA_adminarea_statisticbox_row1"><br /><?=$instruction_page_profile?><br /><br /></td>
              </tr>
              <tr>
                  <td colspan="3" class="SA_adminarea_statisticbox_row2">&nbsp;</td>
              </tr>
              <tr>
                  <td class="SA_adminarea_statisticbox_row1"><div align="right"><?=AFF_MA_AFFUSERNAME?></div></td>
                  <td class="SA_adminarea_statisticbox_row1"><div align="center">:</div></td>
                  <td class="SA_adminarea_statisticbox_row1"><?=$_SESSION['aff_valid_user']?></td>
              </tr>
              <tr>
                  <td class="SA_adminarea_statisticbox_row2"><div align="right"><?=AFF_MA_AFFPASSWORD?></div></td>
                  <td class="SA_adminarea_statisticbox_row2"><div align="center">:</div></td>
                  <td class="SA_adminarea_statisticbox_row2"><input type="password" name="password" size="20" maxlength="20" value=""><font color="#FF0000">*</font></td>
              </tr>
              <tr>
                  <td class="SA_adminarea_statisticbox_row1"><div align="right"><?=AFF_R_PASSWORD2?></div></td>
                  <td class="SA_adminarea_statisticbox_row1"><div align="center">:</div></td>
                  <td class="SA_adminarea_statisticbox_row1"><input type="password" name="password2" maxlength="20" size="20" value=""><font color="#FF0000">*</font></td>
              </tr>
              <tr>
                  <td class="SA_adminarea_statisticbox_row2"><div align="right"><?=AFF_AD_EMAILAGEN?></div></td>
                  <td class="SA_adminarea_statisticbox_row2"><div align="center">:</div></td>
                  <td class="SA_adminarea_statisticbox_row2"><input type="text" name="clientemail" size="30" value="<?=$qry['email']?>"><font color="#FF0000">*</font></td>
              </tr>
              <tr>
                  <td colspan="3" class="SA_adminarea_statisticbox_row1">&nbsp;</td>
              </tr>
              <tr>
                  <td colspan=3 valign="middle" class="SA_adminarea_statisticbox_row2">
                      <div align="center">
                          <input type="hidden" name="commited" value="yes">
                          <input type="submit" name="Submit" value="<?=AFF_AD_UPDATEPASSEMAIL?>">
                      </div>
                  </td>
              </tr>
          </table>
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
    mysql_query("UPDATE affiliates SET title = '".$_POST['clienttitle']."', firstname = '".$_POST['clientfirstname']."', lastname = '".$_POST['clientlastname']."', website = '".$_POST['webpage']."', street = '".$_POST['clientstreet']."', town = '".$_POST['clienttown']."', county = '".$_POST['clientcounty']."', postcode = '".$_POST['clientpostcode']."', country = '".$_POST['clientcountry']."', phone = '".$_POST['clientphone']."', processor = '".$_POST['clientprocessor']."', account = '".$_POST['clientaccount']."', payto = '".$_POST['clientpayto']."' WHERE refid = '".$_SESSION['aff_valid_user']."'", $database_connection) or die ("Database INSERT Error");
    echo "<br /><table cellspacing=\"1\" class=\"SA_success_box\"><tr><td><br />".AFF_AD_AFFPROFILECHANGED."<br /><br /></td></tr></table><br />";
}

//Close Update Post
}

//Dapatkan Data Affiliate
$result2 = mysql_query("select * from affiliates where refid = '".$_SESSION['aff_valid_user']."'", $database_connection) or die ("Database Query Error");
if (mysql_num_rows($result2))
{
    while ($qry2 = mysql_fetch_array($result2))
    {
?>               
<br  />
      <form action="pwjafflite_member_profile.php" method="post" ENCTYPE="multipart/form-data">
          <div align="center">
              <table cellspacing="1" class="SA_adminarea_statisticbox">
                  <tr>
                      <td colspan="3" class="SA_adminarea_statisticbox_header"><?=AFF_R_DETAILS?></td>
                  </tr>
                  <tr>
                      <td colspan="3" class="SA_adminarea_statisticbox_row1"><br /><?=$instruction_page_profile2?><br /><br /></td>
                  </tr>
                  <tr>
                      <td colspan="3" class="SA_adminarea_statisticbox_row2">&nbsp;</td>
                  </tr>
                  <tr>
                      <td class="SA_adminarea_statisticbox_row1"><div align="left"><?=AFF_R_TITLE?></div></td>
                      <td class="SA_adminarea_statisticbox_row1"><div align="center">:</div></td>
                      <td class="SA_adminarea_statisticbox_row1">
                          <div align="left">
                              <select name="clienttitle" class="dropdown">
                                <?
                                    foreach($GLOBALS['title'] as $key => $title)
                                    print '<option value="'.$key.'" '.($qry2['title'] == $key ? 'selected' : '').'>'.$title.'</option>'."\n";
                                ?>
                              </select>
                          </div>
                      </td>
                  </tr>
                  <tr>
                      <td class="SA_adminarea_statisticbox_row2"><div align="left"><?=AFF_R_FIRSTNAME?></div></td>
                      <td class="SA_adminarea_statisticbox_row2"><div align="center">:</div></td>
                      <td class="SA_adminarea_statisticbox_row2"><div align="left"><input type="text" name="clientfirstname" size="30" value="<?=$qry2['firstname']?>"><font color="#FF0000">*</font></div></td>
                  </tr>
                  <tr>
                      <td class="SA_adminarea_statisticbox_row1"><div align="left"><?=AFF_R_LASTNAME?></div></td>
                      <td class="SA_adminarea_statisticbox_row1"><div align="center">:</div></td>
                      <td class="SA_adminarea_statisticbox_row1"><div align="left"><input type="text" name="clientlastname" size="30" value="<?=$qry2['lastname']?>"><font color="#FF0000">*</font></div></td>
                  </tr>
                  <tr>
                      <td colspan="3" class="SA_adminarea_statisticbox_row2">&nbsp;</td>
                  </tr>
                  <tr>
                      <td class="SA_adminarea_statisticbox_row1"><div align="left"><?=AFF_R_STREET?></div></td>
                      <td class="SA_adminarea_statisticbox_row1"><div align="center">:</div></td>
                      <td class="SA_adminarea_statisticbox_row1"><div align="left"><input type="text" name="clientstreet" size="30" value="<?=$qry2['street']?>"><font color="#FF0000">*</font></div></td>
                  </tr>
                  <tr>
                      <td class="SA_adminarea_statisticbox_row2"><div align="left"><?=AFF_R_CITY?></div></td>
                      <td class="SA_adminarea_statisticbox_row2"><div align="center">:</div></td>
                      <td class="SA_adminarea_statisticbox_row2"><div align="left"><input type="text" name="clienttown" size="30" value="<?=$qry2['town']?>"><font color="#FF0000">*</font></div></td>
                  </tr>
                  <tr>
                      <td class="SA_adminarea_statisticbox_row1"><div align="left"><?=AFF_R_STATE?></div></td>
                      <td class="SA_adminarea_statisticbox_row1"><div align="center">:</div></td>
                      <td class="SA_adminarea_statisticbox_row1"><div align="left"><input type="text" name="clientcounty" size="30" value="<?=$qry2['county']?>"><font color="#FF0000">*</font></div></td>
                  </tr>
                  <tr>
                      <td class="SA_adminarea_statisticbox_row2"><div align="left"><?=AFF_R_POSTCODE?></div></td>
                      <td class="SA_adminarea_statisticbox_row2"><div align="center">:</div></td>
                      <td class="SA_adminarea_statisticbox_row2"><div align="left"><input type="text" name="clientpostcode" size="10" value="<?=$qry2['postcode']?>"><font color="#FF0000">*</font></div></td>
                  </tr>
                  <tr>
                      <td class="SA_adminarea_statisticbox_row1"><div align="left"><?=AFF_R_COUNTRY?></div></td>
                      <td class="SA_adminarea_statisticbox_row1"><div align="center">:</div></td>
                      <td class="SA_adminarea_statisticbox_row1">
                          <div align="left">
                              <select name="clientcountry" class="dropdown">
                                    <?
                                        foreach($GLOBALS['countries'] as $key => $country)
                                        print '<option value="'.$key.'" '.($qry2['country'] == $key ? 'selected' : '').'>'.$country.'</option>'."\n";
                                    ?>
                              </select><font color="#FF0000">*</font>
                          </div>
                      </td>
                  </tr>
                  <tr>
                      <td colspan="3" class="SA_adminarea_statisticbox_row2">&nbsp;</td>
                  </tr>
                  <tr>
                      <td class="SA_adminarea_statisticbox_row1"><div align="left"><?=AFF_R_PHONE?></div></td>
                      <td class="SA_adminarea_statisticbox_row1"><div align="center">:</div></td>
                      <td class="SA_adminarea_statisticbox_row1"><div align="left"><input type="text" name="clientphone" size="30" value="<?=$qry2['phone']?>"><font color="#FF0000">*</font></div></td>
                  </tr>
                  <tr>
                      <td class="SA_adminarea_statisticbox_row2"><div align="left"><?=AFF_R_WEBSITE?></div></td>
                      <td class="SA_adminarea_statisticbox_row2"><div align="center">:</div></td>
                      <td class="SA_adminarea_statisticbox_row2"><div align="left"><input type="text" name="webpage" size="30" value="<?=$qry2[website]?>"></div></td>
                  </tr>
                  <tr>
                      <td colspan="3" class="SA_adminarea_statisticbox_row1">&nbsp;</td>
                  </tr>
                  <tr>
                      <td colspan="3" class="SA_adminarea_statisticbox_header"><?=AFF_R_PAYMENTTYPEINFO?></td>
                  </tr>
                  <tr>
                      <td class="SA_adminarea_statisticbox_row1"><div align="left"><?=AFF_R_PAYMENTTYPE?></div></td>
                      <td class="SA_adminarea_statisticbox_row1"><div align="center">:</div></td>
                      <td class="SA_adminarea_statisticbox_row1">
                          <div align="left">
                              <select name="clientprocessor" class="dropdown">
                                        <?
                                            foreach($GLOBALS['processor'] as $key => $processor)
                                            print '<option value="'.$key.'" '.($qry2['processor'] == $key ? 'selected' : '').'>'.$processor.'</option>'."\n";
                                        ?>
                              </select><font color="#FF0000">*</font>
                          </div>
                      </td>
                  </tr>
                  <tr>
                      <td class="SA_adminarea_statisticbox_row2"><div align="left"><?=AFF_R_ACCOUNTNO?></div></td>
                      <td class="SA_adminarea_statisticbox_row2"><div align="center">:</div></td>
                      <td class="SA_adminarea_statisticbox_row2"><div align="left"><input type="text" name="clientaccount" size="30" value="<?=$qry2['account']?>"><font color="#FF0000">*</font></div></td>
                  </tr>
                  <tr>
                      <td class="SA_adminarea_statisticbox_row1"><div align="left"><?=AFF_R_PAYTO?></div></td>
                      <td class="SA_adminarea_statisticbox_row1"><div align="center">:</div></td>
                      <td class="SA_adminarea_statisticbox_row1"><div align="left"><input type="text" name="clientpayto" size="30" value="<?=$qry2['payto']?>"></div></td>
                  </tr>
                  <tr>
                      <td colspan="3" class="SA_adminarea_statisticbox_row2">&nbsp;</td>
                  </tr>
                  <tr>
                      <td colspan=3 valign="middle" class="SA_adminarea_statisticbox_row1">
                          <div align="center">
                              <input type="hidden" name="update" value="yes">
                              <input type="submit" name="Submit" value="<?=AFF_MA_AFFUPDATEBUTTON?>">
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

//Papar Informasi Jika Tiada Jualan Terhasil Lagi
else echo "<br /><table cellspacing=\"1\" class=\"SA_norecord_box\"><tr><td><br />".AFF_MA_AFFNODATA."<br /><br /></td></tr></table><br />"; 

//Papar Footer
echo $footerdisplay; 

?>