<?php
require 'bootstrapAdmin.php';
require 'lib/inc.prepend.php';
$auth = theApp::getAuth();
$auth->restrictAdmin();
$session = Session::getInstance();
$db = theApp::getDataBase();
$user = $db->query("SELECT * FROM users WHERE isAdmin = true")->fetch();

if(!empty($_POST['modifClient'])){
   $db->query("
   UPDATE users set username=?, password=?, email=? WHERE id=?",
   [$_POST['username'], $_POST['password'],$_POST['email'], $user->id]);
}

?>

<?php require '../inc/header.php'?>
<div class="row" xmlns="http://www.w3.org/1999/html">
    <h2>Modifier vos information</h2>
</div>

<div class="row">
    <div class="col-sm-5">
            <form method="post">
                <div class="form-group">
                    <label for="">Pseudo</label>
                    <input type="text" name="username" class="form-control" value="<?= $user->username?>" required>
                </div>
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="email" name="email" class="form-control" value="<?= $user->email?>" required>
                </div>
                <div class="form-group">
                    <label for="">Mot de passe</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="">Confirmation de mot de passe</label>
                    <input type="password" name="password_confirm" class="form-control" placeholder="confirmer mot de passe" required>
                </div>
                <input type="submit" name="modifClient" id="modifClient" class="btn btn-success" value="Mise à Jour">

            </form>
    </div>
</div>

<?php require '../inc/footer.php'?>
