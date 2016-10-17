<html>
<head>
	<title>Installation of System Affiliate Lite - Version <?=$pwjafflite_version?></title>
    <style type="text/css">
<!--
p	{
	margin:0px;
}
body {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	line-height: normal;
	margin:0px;
}
h1	{
	text-align:center;
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:18px;
	color:#CC0000;
}
.tableinstallation	{
	border:solid;
	border-color:#E9E9E9;
	border-width:1px;
	margin:auto;
}
.infoinstallationrows	{
	background-image:url(images/SA_yellowheadbg.png);
	height:32px;
	text-align:center;
	font-size:14px;
	font-weight:bold;
	font-family:Verdana, Arial, Helvetica, sans-serif;
	color:#CC0000;
}
.installationrows	{
	text-align:left;
	font-size:12px;
	font-family:Verdana, Arial, Helvetica, sans-serif;
	padding:5px;
	background-color:#E5E5E5;
}
-->
    </style>
</head>
<body>
<br />
<br />
<h1>Pemasangan Script Sistem Affiliate Lite Versi 2.6.0</h1><br />
<br />
<div align="center">
<form method="post" action="pwjafflite_install.php">
	<table width="600" cellspacing="1" class="tableinstallation">
    	<tr>
        	<td colspan="2" class="infoinstallationrows">Sila Pilih Proses Yang Terlibat</td>
        </tr>
        <tr>
        	<td class="installationrows"><input type="radio" name="installation_type" value="upgradescript" /></td>
        	<td class="installationrows"><p>&nbsp;</p>
        	  <p><strong>Upgrade Script Sistem Affiliate Lite Ke Versi 2.6.0</strong> (<font color="#FF0000">AMARAN</font>: <i>Pastikan anda telah BACKUP database script affiliate versi lama</i>)</p>
        	  <p>&nbsp;</p>
       	    <p><font color="#FF0000">Nota:</font> Pastikan anda telah menetapkan nama database, username database dan password database pada fail pwjafflite_database.php script affiliate versi baru.</p>
       	    <p>&nbsp;</p>
       	    </td>
        </tr>
        <tr>
        	<td class="installationrows"><input type="radio" name="installation_type" value="freshinstall" /></td>
        	<td class="installationrows"><p>&nbsp;</p>
        	  <p><strong>Install Database Baru Script Sistem Affiliate Lite Versi 2.6.0</strong> (<i>Hanya untuk pemasangan script baru</i>)</p>
        	  <p>&nbsp;</p>
       	    <p><font color="#FF0000">Nota:</font> Pastikan anda telah menetapkan nama database, username database dan password database pada fail pwjafflite_database.php script affiliate versi baru.</p>
       	    <p>&nbsp;</p></td>
        </tr>
        <tr>
        	<td colspan="2" class="installationrows"><div align="center"><input type="submit" value="Mulakan Proses Install!" /></div></td>
        </tr>
    </table>
</form>
<br />
<br />
<script src="http://jvcommerce.com/main/s3/php/banner/view.php?id=4"></script>
<br />
<br />
Copyright &copy; <a href="http://www.sistemaffiliate.com" target="_blank">Sistem Affiliate Lite</a>. All Rights Reserved Worldwide.
</div>    
</body>
</html>