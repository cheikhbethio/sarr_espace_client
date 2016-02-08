<?php
require_once '../inc/bootstrap.php';

$user_id = $_GET['id'];
$token = $_GET['token'];
$db = theApp::getDataBase();
$auth = theApp::getAuth();
if($auth->confirm($db, $user_id, $token)){
    Session::getInstance()->setFlash('success', 'Votre compte a été bien crée!');
    theApp::redirect('../client');
}else{
    Session::getInstance()->setFlash('danger', 'Ce lien n\'est pas valide!!');
    theApp::redirect('../action/login.php');
}
