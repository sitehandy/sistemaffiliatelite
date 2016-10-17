<?php

session_start();
include '../../pwjafflite_config.php';
include '../lang/'.$language;

if(!aff_admin_check_security())
{
    aff_redirect('index.php');
    exit();
}

$tarikhberita = date('d/m/Y');
$waktuberita = date('H:i:s');

// Paparan Masalah
$errorMsg = '';

if($_POST['commited'] == 'yes')
{
	$kandungan_berita = mysql_real_escape_string($_POST['text'], $database_connection);
	
    // Semak Tarikh Berita
    if($_POST['tarikhberita'] == ''){
    $errorMsg .= AFF_P_ADMINNEWSDATEMISSING.'<br /><br />';
    }
	
    // Semak Tajuk Berita
    if($_POST['tajukberita'] == ''){
    $errorMsg .= AFF_P_ADMINNEWSTITLEMISSING.'<br /><br />';
    }

    // Semak Kandungan Berita
    if($_POST['text'] == ''){
    $errorMsg .= AFF_P_ADMINNEWSCONTENTMISSING.'<br /><br />';
    }

    // Proses data jika tiada masalah
    if($errorMsg == '')
    {
        // Sambung Ke Database
	if (!$database_connection)
	{
            die('Could not connect: ' . mysql_error());
	}
	
	mysql_query("INSERT INTO beritaagen VALUES ('', '".$_POST['tarikhberita']."', '".$_POST['tajukberita']."', '".$kandungan_berita."')", $database_connection) or die('Database INSERT Error');
        aff_redirect('pwjafflite_admin_news.php');
    }
// Close POST Committed
}
?>

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
<?

// Papar Header Sistem Affiliate
include 'header.php';

// Jika Wujud masalah paparkan
if($errorMsg != '')
echo '<br /><div align="center"><table cellspacing="1" class="SA_error_box"><tr><td><br />'.$errorMsg.'</td></tr></table></div><br />';

?>
<br />
<div align="center">
<form name="tambahartikel" method="post" action="pwjafflite_news_add.php">
    <table cellspacing="1" class="SA_general_table">
        <tr>
            <td colspan="3" class="SA_general_table_header"><?=AFF_P_ADMINNEWSADDTITLE?></td>
        </tr>
        <tr>
            <td class="SA_general_table_row1"><div align="right"><?=AFF_P_ADMINNEWSDATEADD?></div></td>
            <td class="SA_general_table_row1"><div align="center">:</div></td>
            <td class="SA_general_table_row1">
                <input type="text" name="tarikhberita" size="60" value="<? echo $tarikhberita.' ['.$waktuberita.']' ?>">
            </td>
        </tr>
        <tr>
            <td class="SA_general_table_row2"><div align="right"><?=AFF_P_ADMINNEWSTITLEADD?></div></td>
            <td class="SA_general_table_row2"><div align="center">:</div></td>
            <td colspan="2" class="SA_general_table_row2">
                <input type="text" name="tajukberita" size="60">
            </td>
        </tr>
        <tr>
            <td class="SA_general_table_row1"><div align="right"><?=AFF_P_ADMINNEWSCONTENTADD?></div></td>
            <td class="SA_general_table_row1"><div align="center">:</div></td>
            <td class="SA_general_table_row1">
                <textarea id="elm2" name="text" rows="15" cols="80" style="width: 80%"></textarea>
            </td>
        </tr>
        <tr>
            <td colspan="3" class="SA_general_table_row2">
                <div align="center">
                    <input type="hidden" name="commited" value="yes">
                    <input type="submit" name="Submit" value="<?=AFF_P_ADMINNEWSBUTTONADD?>">
                </div>
            </td>
        </tr>
    </table>
</form>
</div>
<br />

<? 
  
//Papar Footer
echo $footerdisplay;

?>