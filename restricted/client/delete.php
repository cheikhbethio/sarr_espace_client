<?php
require_once 'bootstrapClient.php';
$auth = theApp::getAuth();
$auth->isPermit();
$db = theApp::getDataBase();

if(isset($_GET['id'])){
    $id    = $_GET['id'];
    $status =  $_GET['status'];
    if($status===admin){
        $table = "upload_for_users";
    }else{
        $table = "upload";
    }
    $prepared = "DELETE FROM $table WHERE id = ?";

    $req = $db->query($prepared, [$id]);
    //header('Location: index.php');
    header ("Location: $_SERVER[HTTP_REFERER]" );
    exit;
}
