<?php

session_start();
include '../../pwjafflite_config.php';
include '../lang/'.$language;

if(!aff_admin_check_security())
{
    aff_redirect('index.php');
    exit();
}

if ( isset($_POST['checkbox']) )
{
    // Process selected item - delete action.
    if( isset($_POST['action']) and $_POST['action'] == 'delete' )
    {
        $action = $_POST['checkbox'];

        //Then do what you want with the selected items://
        foreach ($action as $id)
        {
            mysql_query("DELETE FROM sales WHERE idsales = '".$id."'", $database_connection) or die("Database DELETE Error");
        }
		header('Location: ' . $_SERVER['HTTP_REFERER']);
		exit();
    }
    
    // Process selected item - paid action.
    if( isset($_POST['action']) and $_POST['action'] == 'paid' )
    {
        $action = $_POST['checkbox'];

        //Then do what you want with the selected items://
        foreach ($action as $id)
        {
            // Update sales
            mysql_query("UPDATE sales SET statuspelanggan = '".AFF_AS_STATUSPAID."' WHERE idsales = '$id'", $database_connection) or die ('Database Error');            
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }
    }
    
    // Process selected item - pending action.
    if( isset($_POST['action']) and $_POST['action'] == 'pending' )
    {
        $action = $_POST['checkbox'];

        //Then do what you want with the selected items://
        foreach ($action as $id)
        {
            // Update sales
            mysql_query("UPDATE sales SET statuspelanggan = '".AFF_AS_STATUSPENDING."' WHERE idsales = '$id'", $database_connection) or die ('Database Error');            
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }
    }
    
    // Process selected item - verified action.
    if( isset($_POST['action']) and $_POST['action'] == 'verified' )
    {
        $action = $_POST['checkbox'];

        //Then do what you want with the selected items://
        foreach ($action as $id)
        {
            // Update sales
            mysql_query("UPDATE sales SET statuspelanggan = '".AFF_AS_STATUSVERIFIED."' WHERE idsales = '$id'", $database_connection) or die ('Database Error');            
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }
    }
    
    // Process selected item - cancel action.
    if( isset($_POST['action']) and $_POST['action'] == 'cancel' )
    {
        $action = $_POST['checkbox'];

        //Then do what you want with the selected items://
        foreach ($action as $id)
        {
            // Update sales
            mysql_query("UPDATE sales SET statuspelanggan = '".AFF_AS_STATUSCANCELLED."' WHERE idsales = '$id'", $database_connection) or die ('Database Error');            
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }
    }
}

else
{
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}
?>