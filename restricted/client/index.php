<?php
require_once 'bootstrapClient.php';
$auth = theApp::getAuth();
$auth->restrict();
$session = Session::getInstance();
$id_client = $session->read('auth')->id;
$db = theApp::getDataBase();
if(isset($_POST['upload']) && $_FILES['userfile']['size'] > 0){
    $fileName = $_FILES['userfile']['name'];
    $tmpName  = $_FILES['userfile']['tmp_name'];
    $fileSize = $_FILES['userfile']['size'];
    $fileType = $_FILES['userfile']['type'];

    $fp      = fopen($tmpName, 'r');
    $content = fread($fp, filesize($tmpName));
    $content = addslashes($content);
    fclose($fp);

    if(!get_magic_quotes_gpc()){
        $fileName = addslashes($fileName);
    }
    $db->query("INSERT INTO upload (name, size, type, content, id_client ) ".
        "VALUES ('$fileName', '$fileSize', '$fileType', '$content', '$id_client')");

    $id_fichier = $db->lastInsertId();
    $queryFileUser = "INSERT INTO client_fichier set id_user = ? , id_fichier = ?";
    $req = $db->query($queryFileUser, [$id_client, $id_fichier]);
    mail("p.quetard@ecotoit.net","Notification","Bonjour, \nUn nouveau fichier est mis à votre disposition dans votre espace personnel ecotoit.net");
    echo  "<script>alert(\"File $fileName uploaded\")</script>";
}

$allMyFiles = [];
if(isset($_POST['seclectId']) && $id_client){
    $req = $db->query("SELECT * FROM upload WHERE id_client = ?", [$id_client]);
    $allMyFiles = $req->fetchAll();
}
?>

<?php require '../inc/header.php';?>
<h4 style="color: green">Bienvenue dans votre espace personnel <i><?= ucfirst($_SESSION['auth']->username);?></i></h4>

<div class="row" >
    <h4>Formulaire d'envoi de fichier</h4>
    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <input type="hidden" name="MAX_FILE_SIZE" value="2000000">
        </div>
        <div class="form-group">
            <input name="userfile" type="file" id="userfile">
        </div>
            <button class="btn btn-success" id="upload" name="upload" type="submit">Envoyer le fichier</button>
    </form>
    <br> <br>
</div>

<div class="row" style="border: solid green 1px; border-radius: 10px ">
    <h4>Mes Fichiers Personnels</h4>

    <form method="post" name="secondForm">
        <div class="form-group">
            <input class="btn btn-success" id="seclectId" name="seclectId" type="submit" value="Afficher mes fichirs">
        </div>
    </form>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($allMyFiles as $file) : ?>
                <tr>
                    <td><?= $file->id?></td>
                    <td><?= $file->name?></td>
                    <td><a href="download.php?id=<?=$file->id;?>">Télécharger</a>
                    </td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
    <div>
</div>
<?php require '../inc/footer.php'; ?>
