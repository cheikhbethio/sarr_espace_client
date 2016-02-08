<?php require_once 'bootstrap.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Espace Membre</title>
    <link href="../css/app.css" rel="stylesheet" type="text/css">
    <link href="../css/bootstrap.css" rel="stylesheet">
</head>
<body>
<div class="conteneur container-fluid">
    <header style="color:white;">
        <section class="logo">
            <img src="../images/logo.png">
        </section>
        <div class="entete">
            <h1>ECOTOIT</h1>
        </div>
    </header>
    <?php if(Session::getInstance()->hasFlashes()) : ?>
        <?php foreach(Session::getInstance()->getFlashes() as $type => $message) : ?>
            <div class="alert alert-<?= $type;?>">
                <?= $message;?>
            </div>
        <?php endforeach;?>
    <?php endif;?>
    <div class="baniere">
        <img class="baniereImg" src="../images/baniere.jpeg">
    </div>
    <div class="corps">
        <section class="gauche">
                    <?php Session::getInstance(); ?>
                    <?php if(isset($_SESSION['auth']) || isset($_SESSION['authAdmin'])):?>
                        <a style="color:red" class="pull-right" href="../action/logout.php">Voulez-vous vous déconnectez?</a>
                   <?php endif;?>

