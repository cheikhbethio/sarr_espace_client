<?php
require 'bootstrapAdmin.php';
require 'lib/inc.prepend.php';
$auth = theApp::getAuth();
$auth->restrictAdmin();
$session = Session::getInstance();
$db = theApp::getDataBase();
$session = Session::getInstance();

$req = $db->query("SELECT * FROM users ");
$users=$req->fetchAll();
$displayForm = false;
$actu;
if(!empty($_POST['checkClient']) && !empty($_POST['client'])) {
    $del = $_POST['client'];
    $actu = $db->query("SELECT * FROM users WHERE id = ?", [$del])->fetch();
    if ($actu) {
        $displayForm = true;
    }
}
if(!empty($_POST['modifClient'])){
    $idClient = $_GET['id'];
    $validator = new Validator($_POST);

    $validator->isConfirmPWD('password', 'Vos deux mots de passe ne sont pas les mêmes');
    if($validator->isValid()){
        $auth->updater($db, $_POST['username'], $_POST['password'], $_POST['email'], $idClient);
        $session = Session::getInstance();
        $session->setFlash('success', 'un email de notifiaction a été envoyé au client!');
    }else{
        $errors = $validator->getErrors();
    }
}
if(!empty($_POST['deleteClient'])){
    $idClient = $_GET['id'];
    $req = $db->query("DELETE FROM users WHERE id=?", [$idClient]);
}

?>

<?php require '../inc/header.php'?>
<div class="row" xmlns="http://www.w3.org/1999/html">
    <h2>Choisir un client pour pour modification ou suppression</h2>
</div>

<div class="row">
    <div class="col-sm-5">
        <form method="post">
            <div class="form-group">
                <label for="">Choisir le client à supprimer :</label>
                <select name="client" id="client" class="form-control">
                    <option value="" selected>Choisir ici un client</option>
                    <?php foreach($users as $user): ?>
                        <option value="<?= $user->id?>"><?= $user->username?></option>
                    <?php endforeach;?>
                </select>
            </div>
            <input type="submit" class="btn btn-primary" id="checkClient" name="checkClient"
                   value="Modifier ou supprimer ce client">
        </form>
    </div>
    <div class="col-sm-5">
        <?php if($displayForm === true) : ?>
            <form method="post" action="supprimer.php?id=<?= $actu->id?>">
            <div class="form-group">
                <label for="">Pseudo</label>
                <input type="text" name="username" class="form-control" value="<?= $actu->username?>" required>
            </div>
            <div class="form-group">
                <label for="">Email</label>
                <input type="email" name="email" class="form-control" value="<?= $actu->email?>" required>
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
            <input type="submit" name="deleteClient" id="deleteClient" class="btn btn-danger" value="Supprimer">

        </form>
        <?php endif;?>
    </div>
</div>

<?php require '../inc/footer.php'?>
