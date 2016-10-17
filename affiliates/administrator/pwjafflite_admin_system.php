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

// Update System Setting

$titleErrorMsg = AFF_SI_TITLE;
$errorMsg = '';

if($_POST['update'] == 'yes')
{
    // check usernameadmin
    if($_POST['emailadminsupport'] == ''){
    $errorMsg .= '<br />'.AFF_AA_EMAILSUPPORTMISSING.'<br />';
    }

    // check password
    if($_POST['emailadminpayment'] == ''){
    $errorMsg .= '<br />'.AFF_AA_EMAILPAYMENTMISSING.'<br />';
    }

    // check admin name
    if($_POST['namaproduk'] == ''){
    $errorMsg .= '<br />'.AFF_AA_NAMAPRODUKMISSING.'<br />';
    }
		
    // check email admin
    if($_POST['domain'] == ''){
    $errorMsg .= '<br />'.AFF_AA_NAMADOMAINMISSING.'<br />';
    }

    // check email admin
    if($_POST['folderaffiliates'] == ''){
    $errorMsg .= '<br />'.AFF_AA_FOLDERAFFILIATESMISSING.'<br />';
    }
		
    // check email admin
    if($_POST['folderadmin'] == ''){
    $errorMsg .= '<br />'.AFF_AA_FOLDERAFFILIATESMISSING.'<br />';
    }

    // check email admin
    if($_POST['domainredirect'] == ''){
    $errorMsg .= '<br />'.AFF_AA_DOMAINREDIRECTMISSING.'<br />';
    }

    // check email admin
    if($_POST['landingpage'] == ''){
    $errorMsg .= '<br />'.AFF_AA_LANDINGPAGEMISSING.'<br />';
    }
		
    // check cookie expiration
    if($_POST['cookieExpiration'] == ''){
    $errorMsg .= '<br />'.AFF_AA_COOKIEEXPIRATIONMISSING.'<br />';
    }
				
    // check email admin
    if($_POST['cartatopaffiliate'] == ''){
    $errorMsg .= '<br />'.AFF_AA_CARTATOPAFFILIATEMISSING.'<br />';
    }
		
    // check email admin
    if($_POST['currency'] == ''){
    $errorMsg .= '<br />'.AFF_AA_CURRENCYMISSING.'<br />';
    }
		
    // check email admin
    if($_POST['language'] == ''){
    $errorMsg .= '<br />'.AFF_AA_LANGUAGEMISSING.'<br />';
    }
		
    // check email admin
    if($_POST['kodpendaftaran'] == ''){
    $errorMsg .= '<br />'.AFF_AA_KODPENDAFTARANMISSING.'<br />';
    }
		
    // check email admin
    if($_POST['kodcaptchaborang'] == ''){
    $errorMsg .= '<br />'.AFF_AA_KODCAPTCHAMISSING.'<br />';
    }
		
    // check email admin
    if($_POST['affiliatetracking'] == ''){
    $errorMsg .= '<br />Affiliate Tracking Type Is Missing!<br />';
    }

    // check email admin
    if($_POST['scriptcredit'] == ''){
    $errorMsg .= '<br />Please choose script powered by<br />';
    }

    // Jika tiada masalah, update database admin
    if($errorMsg == '')
    {
        mysql_query("UPDATE admin SET emailadminsupport = '".$_POST['emailadminsupport']."', emailadminpayment = '".$_POST['emailadminpayment']."', namaproduk = '".$_POST['namaproduk']."', domain = '".$_POST['domain']."', folderaffiliates = '".$_POST['folderaffiliates']."', folderadmin = '".$_POST['folderadmin']."', domainredirect = '".$_POST['domainredirect']."', landingpage = '".$_POST['landingpage']."', cookieExpiration = '".$_POST['cookieExpiration']."', cookieDomain = '".$_POST['cookieDomain']."', cartatopaffiliate = '".$_POST['cartatopaffiliate']."', currency = '".$_POST['currency']."', language = '".$_POST['language']."', idaffiliatePIS = '".$_POST['idaffiliatePIS']."', tahunoperasi = '".$_POST['tahunoperasi']."', onoffpendaftaran = '".$_POST['onoffpendaftaran']."', kodpendaftaran = '".$_POST['kodpendaftaran']."', kodcaptchaborang = '".$_POST['kodcaptchaborang']."', affiliatetracking = '".$_POST['affiliatetracking']."', scriptcredit = '".$_POST['scriptcredit']."' ", $database_connection) or die('Database INSERT Error');
	echo '<br /><table cellspacing="1" class="SA_success_box"><tr><td><br />'.AFF_AA_SETTINGCHANGED.'<br /><br /></td></tr></table><br />';

    }

//Close Post Committed
}

// Jika Wujud masalah, paparkan puncanya
if($errorMsg != '')
{
    echo '<br /><table cellspacing="1" class="SA_error_box"><tr><td>'.$errorMsg.'<br /></td></tr></table><br />';
}

// Papar Konfigurasi Dari Database
$result = mysql_query("SELECT * FROM admin", $database_connection) or die('Database INSERT Error');

if (mysql_num_rows($result))
{
    while ($qry = mysql_fetch_array($result))
    {
?>
	<br />
        <form action="pwjafflite_admin_system.php" method="post" ENCTYPE="multipart/form-data">
            <table cellspacing="1" class="SA_adminarea_statisticbox">
                <tr>
                    <td colspan="3" class="SA_adminarea_statisticbox_header"><?=AFF_AA_SETTINGSTITLE?></td>
                </tr>
                <tr>
                    <td colspan=3 class="SA_adminarea_statisticbox_row1"><div align="left"><?=$systemconfigurationinfo?></div></td>
                </tr>
                <tr>
                    <td class="SA_adminarea_statisticbox_row2"><div align="left"><?=AFF_AA_EMAILADMINSUPPORT?></div></td>
                    <td class="SA_adminarea_statisticbox_row2"><div align="center">:</div></td>
                    <td class="SA_adminarea_statisticbox_row2"><div align="left"><input type="text" name="emailadminsupport" size="30" value="<?=$qry['emailadminsupport']?>"><font color="#FF0000">*</font></div></td>
                </tr>
                <tr>
                    <td class="SA_adminarea_statisticbox_row1"><div align="left"><?=AFF_AA_EMAILADMINPAYMENT?></div></td>
                    <td class="SA_adminarea_statisticbox_row1"><div align="center">:</div></td>
                    <td class="SA_adminarea_statisticbox_row1"><div align="left"><input type="text" name="emailadminpayment" size="30" value="<?=$qry['emailadminpayment']?>"><font color="#FF0000">*</font></div></td>
                </tr>
                <tr>
                    <td class="SA_adminarea_statisticbox_row2"><div align="left"><?=AFF_AA_NAMAPRODUK?></div></td>
                    <td class="SA_adminarea_statisticbox_row2"><div align="center">:</div></td>
                    <td class="SA_adminarea_statisticbox_row2"><div align="left"><input type="text" name="namaproduk" size="30" value="<?=$qry['namaproduk']?>"><font color="#FF0000">*</font></div></td>
                </tr>
                <tr>
                    <td class="SA_adminarea_statisticbox_row1"><div align="left"><?=AFF_AA_NAMADOMAIN?></div></td>
                    <td class="SA_adminarea_statisticbox_row1"><div align="center">:</div></td>
                    <td class="SA_adminarea_statisticbox_row1"><div align="left"><input type="text" name="domain" size="30" value="<?=$qry['domain']?>"><font color="#FF0000">*</font></div></td>
                </tr>
                <tr>
                    <td class="SA_adminarea_statisticbox_row2"><div align="left"><?=AFF_AA_FOLDERAFFILIATES?></div></td>
                    <td class="SA_adminarea_statisticbox_row2"><div align="center">:</div></td>
                    <td class="SA_adminarea_statisticbox_row2"><div align="left"><input type="text" name="folderaffiliates" size="30" value="<?=$qry['folderaffiliates']?>"><font color="#FF0000">*</font></div></td>
                </tr>
                <tr>
                    <td class="SA_adminarea_statisticbox_row1"><div align="left"><?=AFF_AA_FOLDERADMIN?></div></td>
                    <td class="SA_adminarea_statisticbox_row1"><div align="center">:</div></td>
                    <td class="SA_adminarea_statisticbox_row1"><div align="left"><input type="text" name="folderadmin" size="30" value="<?=$qry['folderadmin']?>"><font color="#FF0000">*</font></div></td>
                </tr>
                <tr>
                    <td class="SA_adminarea_statisticbox_row2"><div align="left"><?=AFF_AA_DOMAINREDIRECT?></div></td>
                    <td class="SA_adminarea_statisticbox_row2"><div align="center">:</div></td>
                    <td class="SA_adminarea_statisticbox_row2"><div align="left"><input type="text" name="domainredirect" size="30" value="<?=$qry['domainredirect']?>"><font color="#FF0000">*</font></div></td>
                </tr>
                <tr>
                    <td class="SA_adminarea_statisticbox_row1"><div align="left"><?=AFF_AA_LANDINGPAGE?></div></td>
                    <td class="SA_adminarea_statisticbox_row1"><div align="center">:</div></td>
                    <td class="SA_adminarea_statisticbox_row1"><div align="left"><input type="text" name="landingpage" size="30" value="<?=$qry['landingpage']?>"><font color="#FF0000">*</font></div></td>
                </tr>
                <tr>
                    <td class="SA_adminarea_statisticbox_row2"><div align="left"><?=AFF_AA_COOKIEEXPIRATION?></div></td>
                    <td class="SA_adminarea_statisticbox_row2"><div align="center">:</div></td>
                    <td class="SA_adminarea_statisticbox_row2"><div align="left"><input type="text" name="cookieExpiration" size="30" value="<?=$qry['cookieExpiration']?>"><font color="#FF0000">*</font><br />(<font color="#FF0000">Put 0 for unlimited</font>)</div></td>
                </tr>
                <tr>
                    <td class="SA_adminarea_statisticbox_row1"><div align="left"><?=AFF_AA_COOKIEDOMAIN?></div></td>
                    <td class="SA_adminarea_statisticbox_row1"><div align="center">:</div></td>
                    <td class="SA_adminarea_statisticbox_row1"><div align="left"><input type="text" name="cookieDomain" size="30" value="<?=$qry['cookieDomain']?>"><br />(Ex: <font color="#FF0000">.domain.com</font>)</div></td>
                </tr>
                <tr>
                    <td class="SA_adminarea_statisticbox_row2"><div align="left"><?=AFF_AA_CARTATOPAFFILIATE?></div></td>
                    <td class="SA_adminarea_statisticbox_row2"><div align="center">:</div></td>
                    <td class="SA_adminarea_statisticbox_row2"><div align="left"><input type="text" name="cartatopaffiliate" size="30" value="<?=$qry['cartatopaffiliate']?>"><font color="#FF0000">*</font></div></td>
                </tr>
                <tr>
                    <td class="SA_adminarea_statisticbox_row1"><div align="left"><?=AFF_AA_CURRENCY?></div></td>
                    <td class="SA_adminarea_statisticbox_row1"><div align="center">:</div></td>
                    <td class="SA_adminarea_statisticbox_row1"><div align="left"><input type="text" name="currency" size="30" value="<?=$qry['currency']?>"><font color="#FF0000">*</font></div></td>
                </tr>
                <tr>
                    <td class="SA_adminarea_statisticbox_row2"><div align="left"><?=AFF_AA_LANGUAGE?></div></td>
                    <td class="SA_adminarea_statisticbox_row2"><div align="center">:</div></td>
                    <td class="SA_adminarea_statisticbox_row2"><div align="left"><input type="text" name="language" size="30" value="<?=$qry['language']?>"><font color="#FF0000">*</font></div></td>
                </tr>
                <tr>
                    <td class="SA_adminarea_statisticbox_row1"><div align="left"><?=AFF_AA_IDAFFILIATEPIS?> <a href="http://www.kelabniaga.com" target="_blank">KelabNiaga.com</a></div></td>
                    <td class="SA_adminarea_statisticbox_row1"><div align="center">:</div></td>
                    <td class="SA_adminarea_statisticbox_row1"><div align="left"><input type="text" name="idaffiliatePIS" size="30" value="<?=$qry['idaffiliatePIS']?>"></div></td>
                </tr>
                <tr>
                    <td class="SA_adminarea_statisticbox_row2"><div align="left"><?=AFF_AA_TAHUNOPERASI?></div></td>
                    <td class="SA_adminarea_statisticbox_row2"><div align="center">:</div></td>
                    <td class="SA_adminarea_statisticbox_row2"><div align="left"><input type="text" name="tahunoperasi" size="30" value="<?=$qry['tahunoperasi']?>"></div></td>
                </tr>
                <tr>
                    <td class="SA_adminarea_statisticbox_row1"><div align="left"><?=AFF_AA_ONOFFPENDAFTARAN?></div></td>
                    <td class="SA_adminarea_statisticbox_row1"><div align="center">:</div></td>
                    <td class="SA_adminarea_statisticbox_row1">
                        <div align="left">
                            <select name="onoffpendaftaran" id="onoffpendaftaran">
<?
$GLOBALS['REGISTRATION'] = Array("ON" => "ENABLE", "OFF" => "DISABLE");
foreach($GLOBALS['REGISTRATION'] as $key => $REGISTRATION)
print '<option value="'.$key.'" '.($qry['onoffpendaftaran'] == $key ? 'selected' : '').'>'.$REGISTRATION.'</option>';
?>       
                            </select><font color="#FF0000">*</font>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="SA_adminarea_statisticbox_row2"><div align="left"><?=AFF_AA_KODPENDAFTARAN?></td>
                    <td class="SA_adminarea_statisticbox_row2"><div align="center">:</div></td>
                    <td class="SA_adminarea_statisticbox_row2"><div align="left"><input type="text" name="kodpendaftaran" size="30" value="<?=$qry['kodpendaftaran']?>"><br />(<font color="#FF0000">Put 0 to disable registration</font>)</td>
                </tr>
                <tr>
                    <td class="SA_adminarea_statisticbox_row1"><div align="left"><?=AFF_AA_LINKPENDAFTARAN?></td>
                    <td class="SA_adminarea_statisticbox_row1"><div align="center">:</div></td>
                    <td class="SA_adminarea_statisticbox_row1"><div align="left"><input type="text" size="30" value="http://<?=$domain?>/<?=$folderaffiliates?>/pwjafflite_register.php?registrationcode=<?=$qry['kodpendaftaran']?>"><br />(<font color="#FF0000">Only can be used if registration code is not 0</font>)</td>
                </tr>
                <tr>
                    <td class="SA_adminarea_statisticbox_row2"><div align="left"><?=AFF_AA_KODCAPTCHABORANG?></div></td>
                    <td class="SA_adminarea_statisticbox_row2"><div align="center">:</div></td>
                    <td class="SA_adminarea_statisticbox_row2">
                        <div align="left">
                            <select name="kodcaptchaborang" id="kodcaptchaborang">
<?
$GLOBALS['KODCAPTCHABORANG'] = Array("ENABLE" => "ENABLE", "DISABLE" => "DISABLE");
foreach($GLOBALS['KODCAPTCHABORANG'] as $key => $KODCAPTCHABORANG)
print '<option value="'.$key.'" '.($qry['kodcaptchaborang'] == $key ? 'selected' : '').'>'.$KODCAPTCHABORANG.'</option>';
?>       
                            </select><font color="#FF0000">*</font>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="SA_adminarea_statisticbox_row1"><div align="left">Commission Concept</td>
                    <td class="SA_adminarea_statisticbox_row1"><div align="center">:</div></td>
                    <td class="SA_adminarea_statisticbox_row1">
                        <div align="left">
                            <select name="affiliatetracking" id="affiliatetracking">
    <?
    $GLOBALS['affiliatetracking'] = Array("F" => "First Affiliate", "L" => "Last Affiliate");
    foreach($GLOBALS['affiliatetracking'] as $key => $affiliatetracking)
    print '<option value="'.$key.'" '.($qry['affiliatetracking'] == $key ? 'selected' : '').'>'.$affiliatetracking.'</option>';
    ?>
                            </select><font color="#FF0000">*</font>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="SA_adminarea_statisticbox_row2"><div align="left">Show Powered By Link</td>
                    <td class="SA_adminarea_statisticbox_row2"><div align="center">:</div></td>
                    <td class="SA_adminarea_statisticbox_row2">
                        <div align="left">
                            <select name="scriptcredit" id="scriptcredit">
<?
$GLOBALS['scriptcredit'] = Array("0" => "ENABLE", "1" => "DISABLE");
foreach($GLOBALS['scriptcredit'] as $key => $scriptcredit)
print '<option value="'.$key.'" '.($qry['scriptcredit'] == $key ? 'selected' : '').'>'.$scriptcredit.'</option>';
?>       
                            </select><font color="#FF0000">*</font>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" class="SA_adminarea_statisticbox_row1">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan=3 valign="middle" class="SA_adminarea_statisticbox_row2">
                        <div align="center">
                            <input type="hidden" name="update" value="yes">
                            <input type="submit" name="Submit" value="<?=AFF_AA_SUBMITSETTINGS?>">
                        </div>
                    </td>
                </tr>
            </table>
        </form>
        <br />
<?      
    }

//Close Post Update
}

//Papar Footer
echo $footerdisplay;  

?>