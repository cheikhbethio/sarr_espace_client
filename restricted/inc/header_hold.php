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

    <title>espace Membre</title>

    <!-- Bootstrap core CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

    <nav class="navbar navbar-inverse">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">PDG</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <?php Session::getInstance(); ?>
                <?php if(isset($_SESSION['auth'])):?>
                    <li><a href="../logout.php">Déconnexion</a></li>
                <?php else :?>
                    <li class="active"><a href="index.php">Home</a></li>
                    <li><a href="register.php">Inscription</a></li>
                    <li><a href="login.php">Connexion</a></li>

                <?php endif;?>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
    </div>
</nav>

<div class="container">
    <?php if(Session::getInstance()->hasFlashes()) : ?>
        <?php foreach(Session::getInstance()->getFlashes() as $type => $message) : ?>
            <div class="alert alert-<?= $type;?>">
                <?= $message;?>
            </div>
        <?php endforeach;?>
    <?php endif;?>

