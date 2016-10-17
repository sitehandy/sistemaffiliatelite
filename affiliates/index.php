<?php

session_start();

include '../pwjafflite_config.php';
include './lang/'.$language;

if ($_POST['userid']!='' && $_POST['password']!='')
{
  // protection against script injection
  $userid   = preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['userid']);
  $password = preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['password']);
  
  // Password encryption
  $password = sha1(sha1($_POST['password']));		
  
  // if the user has just tried to log in
  $result = mysql_query("SELECT * FROM affiliates WHERE refid='$userid' and pass='$password'", $database_connection) or die('Database Connect Error');
  if (mysql_num_rows($result) > 0 )
  {
    // if they are in the database register the user id
    $_SESSION['aff_valid_user'] = $userid;

    // logout admin if he was logged in before
    $_SESSION['aff_valid_admin'] = '';
    unset($_SESSION['aff_valid_admin']);
    
    echo '<META HTTP-EQUIV="Refresh" CONTENT=0;URL=pwjafflite_member_area.php>';
    exit();
  }
}
 
include 'header.php';

if(aff_check_security())
{
    aff_redirect('pwjafflite_member_area.php');
    exit();
}

else
{
    if (isset($_POST['userid']))
    {
    // Jika affiliate cuba login tetapi tidak berjaya, paparkan masalah.
    echo '<br /><table cellspacing="1" class="SA_error_box"><tr><td><br />'.AFF_I_CANNOTLOG.'<br /><br /></td></tr></table><br />';
    }

    else
    {
        // they have not tried to log in yet or have logged out
        echo '<br /><table cellspacing="1" class="SA_error_box"><tr><td><br />'.AFF_I_NOTLOGGED.'<br /><br /></td></tr></table><br />';
    }

 // provide form to log in
?>
<br  />   
    <form method="post" action="index.php">
      <table cellspacing="1" class="SA_login_box">
		<tr>
          <td colspan="3" class="SA_login_box_header"><?=AFF_I_INFOLOG?></td>
        </tr>       
        <tr>
          <td class="SA_login_box_row1"><div align="right"><?=AFF_G_AFFID?></div></td>
          <td class="SA_login_box_row1"><div align="center">:</div></td>
          <td class="SA_login_box_row1"><input name="userid" type="text" size="25" class="SA_login_box_input" /></td>
        </tr>
        <tr>
          <td class="SA_login_box_row2"><div align="right"><?=AFF_G_PASSWORD?></div></td>
          <td class="SA_login_box_row2"><div align="center">:</div></td>
          <td class="SA_login_box_row2"><input name="password" type="password" size="25" class="SA_login_box_input" /></td>
        </tr>
        <tr>
          <td colspan="3" class="SA_login_box_row1"><div align="center"><input class="SA_login_button" type="submit" value="<?=AFF_I_LOGBUTTON?>" /></div></td>
        </tr>
      </table>
    </form>
<br />

<?

// Paparkan halaman pendaftaran atau tidak

$registrationform = 'ON';
if ($registrationform == $onoffregistration) {

	print '<br /><form method="post" action="pwjafflite_register.php?registrationcode='.$kodpendaftaran.'">';
	print '<table cellspacing="1" class="SA_login_box">';
	print '<tr><td class="SA_login_box_header">'.AFF_I_NOTAFFILIATE.'</td></tr>';
	print '<tr><td class="SA_login_box_row1"><div align="center"><input class="SA_login_button" type="submit" value="'.AFF_I_SIGNUP.'"></div></td></tr>';
	print '</table></form><br />';
}

else if ($registrationform != $onoffregistration) {

	print '<br />';
	print '<table cellspacing="1" class="SA_login_box">';
	print '<tr><td class="SA_login_box_header">'.AFF_I_AFFILIATEREGISTRATIONOFF.'</td></tr>';	
	print '</table><br />';
}
?>    

<br />
<table cellspacing="1" class="SA_login_box">
    <tr>
        <td class="SA_login_box_header"><?=AFF_I_LUPAPASSWORDINFO?></td>
    </tr>
    <tr>
        <td class="SA_login_box_row1"><div align="center"><a href="pwjafflite_forgotpass.php" toptions="width = 450, height = 300, type = iframe, title = Sistem Affiliate Lite, layout = quicklook"><input class="SA_login_button" type="submit" value="<?=AFF_I_LUPAPASSWORDBUTTON?>" /></a></div></td>
    </tr>
</table>
<br />

<?    

}

//Papar Footer Dari Fail pwjafflite_config.php
echo $footerdisplay;

?>