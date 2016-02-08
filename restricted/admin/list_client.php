<?php
require 'bootstrapAdmin.php';
require 'lib/inc.prepend.php';
$auth = theApp::getAuth();
$auth->restrictAdmin();
$session = Session::getInstance();
$db = theApp::getDataBase();
$session = Session::getInstance();
$receviedFile=[];
$sendedFile=[];
$selectedUserName = '';
if(isset($_POST) && !empty($_POST['nomClient'])){
    $reqSelect = $db->query("select * from users where id = ?", [$_POST['nomClient']]);
    $selectedUser = $reqSelect->fetch();
    $selectedUserName = $selectedUser->username;
    $req = $db->query("SELECT * FROM upload WHERE id_client = ?", [$_POST['nomClient']]);
    $receviedFile=$req->fetchAll();
    $sended = $db->query("SELECT * FROM upload_for_users WHERE id_client = ?", [$_POST['nomClient']]);
    $sendedFile=$sended->fetchAll();
}

?>

<?php require '../inc/header.php'?>
<div class="row">
    <h2>Choisir un client pour voir la liste des fichiers qu'il a dans sa boite de réception</h2>
</div>
<form method="post">
    <div class="form-group">
        <label for="">Client : </label>
        <select name="nomClient" id="nomClient" class="form-control">
            <option value="" selected>Choisir ici un client</option>
            <?php $users = $db->query('SELECT * FROM users')?>
            <?php foreach($users as $user): ?>
                <option value="<?= $user->id?>"><?= $user->username?></option>
            <?php endforeach;?>
        </select>
        <br>
        <button class="btn btn-primary" id="voirFichier" name="voirFichier">Voir les fichiers</button>
    </div>
</form>

<div class="row">
    <div class="col-sm-5 pull-left">
        <h4> <?= 'Fichiers envoyés par : '.strtoupper($selectedUserName) ?></h4>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($receviedFile as $file) : ?>
                    <tr>
                        <td><?= $file->name?></td>
                        <td><a href="../client/download.php?id=<?=$file->id;?>">Télécharger</a>
                            <a style="color: red" href="../client/delete.php?id=<?=$file->id;?>">Suppimer</a>
                        </td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-sm-5">
        <h4><?=  'Fichiers reçus par : '.strtoupper($selectedUserName) ?></h4>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($sendedFile as $send) : ?>
                    <tr>
                        <td><?= $send->name?></td>
                        <td><a href="../client/download.php?id=<?=$send->id;?>&status=admin">Télécharger</a>
                            <a style="color: red" href="../client/delete.php?id=<?=$send->id;?>&status=admin">Suppimer</a>
                        </td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?php require '../inc/footer.php'?>
