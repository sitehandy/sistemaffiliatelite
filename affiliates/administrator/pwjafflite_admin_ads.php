<?php

session_start();

include '../../pwjafflite_config.php';
include '../lang/'.$language;

if(!aff_admin_check_security())
{
    aff_redirect('index.php');
    exit();
}

?>

<!--MCE Editor Code Start-->
<script type="text/javascript" src="../pwjafflite_temp/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>

<script type="text/javascript">
// O2k7 skin
	tinyMCE.init({
		// General options
		mode : "exact",
		elements : "elm2",
		theme : "advanced",
		skin : "o2k7",
		plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups,autosave",

		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		content_css : "../pwjafflite_temp/tinymce/examples/css/content.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "../pwjafflite_temp/tinymce/examples/lists/template_list.js",
		external_link_list_url : "../pwjafflite_temp/tinymce/examples/lists/link_list.js",
		external_image_list_url : "../pwjafflite_temp/tinymce/examples/lists/image_list.js",
		media_external_list_url : "../pwjafflite_temp/tinymce/examples/lists/media_list.js",

		// Replace values for the template plugin
		template_replace_values : {
			username : "sistemaffiliate",
			staffid : "lite"
		}
	});

</script>
<!--MCE Editor Code End-->

<?
include 'header.php';
  
// Papar Box Info
echo "<br /><div align=\"center\"><table width=\"600\" cellspacing=\"1\" class=\"SA_general_table\"><tr><td class=\"SA_general_table_header\">".AFF_P_ADMINADSINFO."</td></tr><tr><td class=\"SA_general_table_row1\"><div align=\"justify\"><br />".$arahan_iklan."<br /><br /></div></td></tr></table></div><br />";

// Tetapkan konfigurasi Tarikh Iklan
$tarikhberita = date("d/m/Y");
$waktuberita = date("H:i:s");

// Tetapkan Fungsi Update Berita
$errorMsg = '';

if($_POST['commited'] == 'yes')
{
    // check firstname
    if($_POST['kandunganiklan'] == ''){
    $errorMsg .= '<br />'.AFF_P_ADMINADSMISSING.'<br />';
    }

    if($errorMsg == '')
    {
        mysql_query("UPDATE iklanadmin SET kandunganiklan = '".$_POST['kandunganiklan']."' ", $database_connection) or die("Database INSERT Error");
        echo "<br /><div align=\"center\"><table cellspacing=\"1\" class=\"SA_success_box\"><tr><td><br />".AFF_P_ADMINADSCONTENTCHANGED."<br /><br /></td></tr></table></div><br />";
    }

// Tutup Post Commited
}

// Dapatkan iklan yang sudah didaftarkan
$result = mysql_query("SELECT * from iklanadmin", $database_connection) or die ("Database Query Error");

if($errorMsg != '')
{
    echo "<br /><div align=\"center\"><table cellspacing=\"1\" class=\"SA_error_box\"><tr><td>$errorMsg<br /></td></tr></table></div><br />";
}

if (mysql_num_rows($result))
{
    while ($qry = mysql_fetch_array($result)) 
    {
?>   
<br  />	
<div align="center">
<form name="kandunganiklan" method="post" action="pwjafflite_admin_ads.php">
    <table cellspacing="1" class="SA_general_table">
        <tr>
            <td colspan="3" class="SA_general_table_header"><?=AFF_P_ADMINADSTITLE?></td>
        </tr>
        <tr>
            <td class="SA_general_table_row1"><div align="right"><?=AFF_P_ADMINADSCONTENT?></div></td>
            <td class="SA_general_table_row1"><div align="center">:</div></td>
            <td class="SA_general_table_row1">
                <textarea id="elm2" name="kandunganiklan" rows="15" cols="80" style="width: 80%"><?=$qry['kandunganiklan']?></textarea>
            </td>
        </tr>
        <tr>
            <td colspan="3" class="SA_general_table_row2">
                <div align="center">
                    <input type="hidden" name="commited" value="yes">
                    <input type="submit" name="Submit" value="<?=AFF_P_ADMINADSBUTTON?>">
                </div>
            </td>
        </tr>
    </table>
</form>
</div>
<br />
<br />
<div align="center">
<table width="600" cellspacing="1" class="SA_general_table">
    <tr>
        <td class="SA_general_table_header"><?=AFF_P_ADMINADSTITLE?></td>
    </tr>
    <tr>
        <td class="SA_general_table_row1"><br /><?=$qry[kandunganiklan]?><br /></td>
    </tr>
</table>
</div>
<br />
<?  
    }
}

//Papar Footer
echo $footerdisplay;

?>