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
  
echo "<br /><div align=\"center\"><table width=\"600\" cellspacing=\"1\" class=\"SA_general_table\"><tr><td class=\"SA_general_table_header\">".AFF_P_ADMINNOTICEINFO."</td></tr><tr><td class=\"SA_general_table_row1\"><div align=\"justify\"><br />".$arahan_notis."<br /><br /></div></td></tr></table></div><br />";

$tarikhberita = date("d/m/Y");
$waktuberita = date("H:i:s");

$errorMsg = '';

if($_POST['commited'] == 'yes')
{
    // check firstname
    if($_POST['datetime'] == ''){
    $errorMsg .= '<br />'.AFF_P_ADMINNOTICEDATETIMEMISSING.'<br />';
    }

    if($_POST['text'] == ''){
    $errorMsg .= '<br />'.AFF_P_ADMINNOTICECONTENTMISSING.'<br />';
    }

    if($errorMsg == '')
    {
        mysql_query("UPDATE notisagen SET datetime = '".$_POST['datetime']."', kandungannotis = '".$_POST['text']."' ", $database_connection) or die("Database Update Error");
        echo "<br /><table cellspacing=\"1\" class=\"SA_success_box\"><tr><td><br />".AFF_P_ADMINNOTICECONTENTCHANGED."<br /><br /></td></tr></table><br />";
    }
}

//Dapatkan Data daripada Notis
$result = mysql_query("SELECT * FROM notisagen", $database_connection) or die ("Database Connect Error");

if($errorMsg != '')
{
    echo "<br /><div align=\"center\"><table cellspacing=\"1\" class=\"SA_error_box\"><tr><td><br />$errorMsg<br /></td></tr></table></div><br />";
}

if (mysql_num_rows($result))
{
    while ($qry = mysql_fetch_array($result)) 
    {
?>   
<br  />
<div align="center">
<form name="kandungannotis" method="post" action="pwjafflite_admin_notice.php">
    <table cellspacing="1" class="SA_general_table">
        <tr>
            <td colspan="3" class="SA_general_table_header"><?=AFF_P_ADMINNOTICETITLE?></td>
        </tr>
        <tr>
            <td class="SA_general_table_row1"><div align="right"><?=AFF_P_ADMINNOTICEDATETIME?></div></td>
            <td class="SA_general_table_row1"><div align="center">:</div></td>
            <td class="SA_general_table_row1"><input type="text" name="datetime" size="60" value="<? echo $tarikhberita.' ['.$waktuberita.']' ?>"></td>
        </tr>
        <tr>
            <td class="SA_general_table_row1"><div align="right"><?=AFF_P_ADMINNOTICECONTENT?></div></td>
            <td class="SA_general_table_row1"><div align="center">:</div></td>
            <td class="SA_general_table_row1"><textarea id="elm2" name="text" rows="15" cols="80" style="width: 80%"><?=$qry['kandungannotis']?></textarea>	  </td>
        </tr>
        <tr>
            <td colspan="3" class="SA_general_table_row2">
                <div align="center">
                    <input type="hidden" name="commited" value="yes">
                    <input type="submit" name="Submit" value="<?=AFF_P_ADMINNOTICEBUTTON?>">
                </div>
            </td>
        </tr>
    </table>
</form>
</div>
<br />
<br />
<div align="center">
<table width="800" cellspacing="1" class="SA_general_table">
    <tr>
        <td class="SA_general_table_header"><?=AFF_P_ADMINNOTICETITLE?></td>
    </tr>
    <tr>
        <td class="SA_general_table_row1"><div align="left"><i>Last Updated</i>: <?=$qry['datetime']?></div></td>
    </tr>    
    <tr>      
      <td class="SA_general_table_row1"><br /><?=$qry['kandungannotis']?><br /><br /></td>
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