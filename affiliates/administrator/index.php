<?php

session_start();

include '../../pwjafflite_config.php';
include '../lang/'.$language;


if ($_POST['userid']!='' && $_POST['password']!='')
{
    // protection against script injection
    $userid = preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['userid']);
    $password = preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['password']);
  
    // Password encryption
    $password = sha1(sha1($_POST['password']));

    $result = mysql_query("SELECT * from admin WHERE user='$userid' and pass='$password'", $database_connection) or die ('Database Error');

    if (mysql_num_rows($result) >0 )
    {
        // if they are in the database register the user id
        $_SESSION['aff_valid_admin'] = $userid;

        // logout user if he was logged in before
        $_SESSION['aff_valid_user'] = '';

        unset($_SESSION['aff_valid_user']);
        echo '<meta HTTP-EQUIV="Refresh" content=0;URL="pwjafflite_admin_area.php">';
        exit();
    }
}

include 'header.php'; 

if(aff_admin_check_security())
{
    aff_redirect('pwjafflite_admin_area.php');
    exit();
}

else
{
    if (isset($_POST['userid']))
    {
        // Jika admin cuba login tetapi tidak berjaya, paparkan masalah dan email notifikasi.
        echo '<br /><table cellspacing="1" class="SA_error_box"><tr><td><br />'.AFF_AA_ADMINCANNOTLOG.'<br /><br /></td></tr></table><br />';

        // Hantar notifikasi ruangan admin gagal login
	$email_admin_gagal_login = '

Salam sejahtera, '.$admininfo.'

Anda mahupun seseorang cuba login ke ruang admin
sistem affiliate di http://'.$domain.'/
tetapi gagal.

Notifikasi ini dikirimkan adalah sebagai notis
makluman keselamatan login admin.


===========================================================
Rekod Komputer Semasa Kegagalan Login
===========================================================

=> No. IP: '.$clientip.'

=> Tarikh: '.$clientdate.'
=> Masa: '.$clienttime.'

=> Browser: 
'.$clientbrowser.'

===========================================================

Sekian, terima kasih.

Sistem Affiliate.
http://'.$domain.'/

';

mail($emailadmin, $admininfo.': '.AFF_AA_ADMINCANNOTLOGNOTIFICATION, $email_admin_gagal_login, 'From: '.$admininfo.'<'.$emailadminsupport.'>');
	  
    }
    else 
    {
        // they have not tried to log in yet or have logged out
        echo '<br /><table cellspacing="1" class="SA_error_box"><tr><td><br />'.AFF_AA_ADMINNOTLOGGED.'<br /><br /></td></tr></table><br />';
    }

    // Borang Login Untuk Admin
?>    

<br />
<form method=post action="index.php">
    <table cellspacing="1px" class="SA_login_box">
        <tr>
            <td colspan="3" class="SA_login_box_header"><?=AFF_AA_ADMINLOGINTITLE?></td>
        </tr>
        <tr>
            <td class="SA_login_box_row1"><div align="right"><?=AFF_AA_ADMINUSERNAME?></div></td>
            <td class="SA_login_box_row1"><div align="center">:</div></td>
            <td class="SA_login_box_row1"><div align="left"><input name="userid" type="text" size="25" class="SA_login_box_input" /></div></td>
        </tr>
        <tr>
            <td class="SA_login_box_row2"><div align="right"><?=AFF_AA_ADMINPASSWORD?></div></td>
            <td class="SA_login_box_row2"><div align="center">:</div></td>
            <td class="SA_login_box_row2"><div align="left"><input name="password" type="password" size="25" class="SA_login_box_input" /></div></td>
        </tr>
        <tr>
            <td colspan="3" class="SA_login_box_row1"><div align="center">[ <a href="pwjafflite_admin_forgotpass.php" toptions="width = 450, height = 300, type = iframe, title = Sistem Affiliate Lite, layout = quicklook">Recover Password?</a> ]</div></td>
        </tr>
        <tr>
            <td colspan="3" class="SA_login_box_row2"><div align="center"><input type="submit" value="<?=AFF_AA_ADMINLOGIN?>" class="SA_login_button" /></div></td>
        </tr>
    </table>
</form>
<br />
<br />
<br />    
<?    
}

//Papar Footer Dari Fail pwjafflite_config.php
echo $footerdisplay;

?>