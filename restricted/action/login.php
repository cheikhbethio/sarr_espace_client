<?php
require_once '../inc/bootstrap.php';
$auth = theApp::getAuth();
$db =  theApp::getDataBase();
$auth->reconnect_from_cookie($db);
/*if($auth->user()){
    theApp::redirect('index.php');
}*/

if(!empty($_POST) && !empty($_POST['username']) && !empty($_POST['password'])){
   $user = $auth->login($db, $_POST['username'], $_POST['password'], isset($_POST['remember']));
    $session = Session::getInstance();
    if($user){
        if($user->isAdmin){
            $session->setFlash('success',  "Vous êtes maintenant bien connecté. Vous êtes l'administrateur de ce site !" );
            theApp::redirect('../admin');
        }else{
            $session->setFlash('success',  "Vous êtes maintenant bien connecté !" );
            theApp::redirect('../client/');
        }
    }else{
        $session->setFlash('danger', "Mot de pass ou identifiant incorrect!");
    }
}
?>
<?php require '../inc/header.php';  ?>

<form action="" method="POST">

    <div class="form-group">
        <label for="">Pseudo ou Email</label>
        <input type="text" name="username" class="form-control">
    </div>
    <div class="form-group">
        <label for="">Mot de passe</label>
        <input type="password" name="password" class="form-control">
    </div>
    <div class="form-group">
        <label>
          <input type="checkbox" name="remember"> Se souvenir de moi
        </label>
    </div>
    <button type="submit" class="btn btn-primary">M'INSCRIRE</button>
    <a href="rememberPassword.php">Mot de passe oublié</a>

</form>
<?php require '../inc/footer.php'; ?>
