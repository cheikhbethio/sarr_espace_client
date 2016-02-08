<?php
require_once 'bootstrapClient.php';
$auth = theApp::getAuth();
$auth->isPermit();
$db = theApp::getDataBase();
$session = Session::getInstance();

if(isset($_GET['id'])){
    $id    = $_GET['id'];
   if(isset($_GET['status'])){
       $status =  $_GET['status'];
    }else{
       $status =  null;
   }
    if($status==='admin'){
        $table = "upload_for_users";
    }else{
        $table = "upload";
    }
    $prepared = "SELECT name, type, size, content " .
        "FROM $table WHERE id = ?";

    $req = $db->query($prepared, [$id]);
    $result = $req->fetch();
    if($result!=null && $table==='upload'){
        $Client = $session->read('auth')->username;
        mail('p.quetard@ecotoit.net', 'notification',
            "Bonjour, \nDes documents ont été télécharger depuis ecotoit.fr par $Client");
    }
    $name = $result->name;
    $type = $result->type;
    $size = $result->size;
    $content =  $result->content;

    header("Content-length: $size");
    header("Content-type: $type");
    header("Content-Disposition: attachment; filename=$name");
    echo $content;
    sleep(1000);
    exit;
}
