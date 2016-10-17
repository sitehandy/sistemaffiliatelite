<?php

session_start();
include '../../pwjafflite_config.php';
include '../lang/'.$language;

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><? print $namaproduk; ?> - Client Contact Form</title>
<link href="../pwjafflite_temp/pwjafflite_styles.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="container">
    <div id="SA_content_area">

<?php

// Cek data yang dihantar
if ($_POST)
{
    // if the user submited the form
    $usertosend = (isset($_POST['user'])) ? $_POST['user'] : '';
    $passtosend = '';
    $nametosend = '';
    $useremail = (isset($_POST['email'])) ? $_POST['email'] : '';

    if ($usertosend != '' || $useremail != '')
    {
        $result = mysql_query("SELECT * FROM admin WHERE emailadmin = '{$_REQUEST['email']}' AND user = '{$_REQUEST['user']}' LIMIT 1", $database_connection)
	or die ("ERROR:" . mysql_error());

        while ($qry = mysql_fetch_array($result))
	{
            $usertosend = $qry['user'];
            $passtosend = $qry['pass'];
            $nametosend = $qry['namaadmin'];
	}
    }

// if it is then send the email with his data
if (($usertosend != '') && ($passtosend != '') && ($nametosend != ''))
{


// Hantar Email Pendaftaran Ke Email Agen
$dataemail = '

Dear Admin, you OR someone has requested a new password for your admin login
for your affiliate program hosted at:

=> http://'.$domain.'/'.$folderaffiliates.'/'.$folderadmin.'/

If you really want to reset the admin password, please click on the link below:
http://'.$domain.'/'.$folderaffiliates.'/'.$folderadmin.'/pwjafflite_admin_forgotpass_request.php?id='.$usertosend.'&email='.$_REQUEST['email'].'&resetpass='.$passtosend.'

The administrator password recovery has been requested from the following detail:

==============================================================
Network Detail
==============================================================

IP Address Recorded: '.$clientip.'
Time Recorded: '.$clienttime.'
Date Recorded: '.$clientdate.'
Browser Used: '.$clientbrowser.'


If you didn\'t attempt any password request for your administrator login, please change your administrator folder as soon as possible to avoid any damage!

Regards,
Automatic Affiliate System Lite Notification
'.$domain.'

';
	
    
// Proses Email Dan Hantar Kepada Agen Baru
mail($_REQUEST['email'], $nametosend.' Affiliate Lite Admin Password Recovery', $dataemail, 'From: '.$admininfo.'<'.$emailadminsupport.'>');

echo '<br /><table bgcolor="#FFFFFF" cellspacing="1" class="SA_login_box"><tr><td class="SA_login_box_header">Admin Password Recovery</td></tr><tr><td class="SA_login_box_row1"><div align="justify"><br />Administrator password recovery request has been sent to your administrator main email which you\'ve entered before. Please check the email to reset your password.<br /><br /></div></td></tr><tr><td class="SA_login_box_row2"><div align="center"></div></td></tr></table><br />';


}

else
{
    // if it isn�t then show an error message
    echo '<br /><table bgcolor="#FFFFFF" cellspacing="1" class="SA_login_box"><tr><td class="SA_login_box_header">Data Not Valid!</td></tr><tr><td class="SA_login_box_row1"><div align="justify"><br />The data(s) you entered are not valid! Please re-try. If you really have forgotten your access, you may need to edit your access through phpmyadmin which is can be found in your hosting control panel.<br /><br /></div></td></tr><tr><td class="SA_login_box_row2"><div align="center">[ <a href="pwjafflite_admin_forgotpass.php">Return to Previous Page</a> ]</div></td></tr></table><br />';
}

// Tutup Post Committed
} 

else 
{
    // and if he didn�t submitted the form, then show it :)
?>

<br />
<form method="post" action="pwjafflite_admin_forgotpass.php">
    <table bgcolor="#FFFFFF" cellspacing="1" class="SA_login_box">
        <tr>
            <td colspan="3" class="SA_login_box_header">Administrator Password Recovery</td>
        </tr>
        <tr>
            <td class="SA_login_box_row1"><div align="right">Admin Email</div></td>
            <td class="SA_login_box_row1"><div align="center">:</div></td>
            <td class="SA_login_box_row1"><input name="email" type="text" id="email" size="30"></td>
        </tr>
        <tr>
            <td class="SA_login_box_row2"><div align="right">Admin Username</div></td>
            <td class="SA_login_box_row2"><div align="center">:</div></td>
            <td class="SA_login_box_row2"><input name="user" type="text" id="mail" size="30"></td>
        </tr>
        <tr>
            <td colspan="3" class="SA_login_box_row1">
                <div align="center">
                    <input type="submit" name="Submit" value="Request New Password" />
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="3" class="SA_login_box_row2"><div align="center"></div></td>
        </tr>
    </table>
</form>
<br />
<? 
}

?>

    </div>
</div>
</body>
</html>