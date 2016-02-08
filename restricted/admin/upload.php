<?php
require 'bootstrapAdmin.php';
require 'lib/inc.prepend.php';
$auth = theApp::getAuth();
$auth->restrictAdmin();
$session = Session::getInstance();
$db = theApp::getDataBase();
$users = theApp::getDataBase()->query('SELECT * FROM users');
if(isset($_POST['upload']) && !empty($_POST['nom_client']) && $_FILES['userfile']['size'] > 0){
    $fileName = $_FILES['userfile']['name'];
    $tmpName  = $_FILES['userfile']['tmp_name'];
    $fileSize = $_FILES['userfile']['size'];
    $fileType = $_FILES['userfile']['type'];
    $id_client=$_POST['nom_client'];

    $fp      = fopen($tmpName, 'r');
    $content = fread($fp, filesize($tmpName));
    $content = addslashes($content);
    fclose($fp);

    if(!get_magic_quotes_gpc()){
        $fileName = addslashes($fileName);
    }
    $db->query("INSERT INTO upload_for_users (name, size, type, content, id_client ) ".
        "VALUES ('$fileName', '$fileSize', '$fileType', '$content', '$id_client')");
    foreach($users as $userEmail){
        if($userEmail->id === $id_client){
            mail($userEmail->email, "Notification par ecotoit.fr", "Bonjour, \nLe client $userEmail->username a mis à votre disposition des documents
        dans le site ecotoit.fr");
        }
    }

    echo  "<script>alert(\"File $fileName uploaded\")</script>";
}
?>

<?php require '../inc/header.php'?>

    <form method="post"  enctype="multipart/form-data">
        <h1>Choisir un client et le fichier à lui envoyer</h1> <br>
        <div class="form-group">
            <label for="">Nom et prenom du client : </label>
            <select name="nom_client" id="nom_client" class="form-control">
                <option value="" selected>Choisir ici un client</option>
                <??>
                <?php foreach($users as $user): ?>
                <option value="<?= $user->id?>"><?= $user->username?></option>
                <?php endforeach;?>
            </select>
        </div>
        <div class="form-group">
            <label for="">Fichier à envoyer : </label>
            <div class="form-group">
                <input type="hidden" name="MAX_FILE_SIZE" value="2000000">
            </div>
            <div class="form-group">
                <input name="userfile" type="file" id="userfile">
            </div>
            <div class="form-group">
                <button class="btn btn-success" id="upload" name="upload" type="submit">Envoyer le fichier</button>
            </div>
            <!--input type="reset" value="Reset"  class="btn btn-danger"/>
            <input type="submit" value="Envoyer"  class="btn btn-primary"/-->
        </div>
    </form>

    </form>

<?php require '../inc/footer.php'?>