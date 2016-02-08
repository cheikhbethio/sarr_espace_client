<?php
require '../../db.php';
if(isset($_POST['upload']) && $_FILES['userfile']['size'] > 0){
    $fileName = $_FILES['userfile']['name'];
    $tmpName  = $_FILES['userfile']['tmp_name'];
    $fileSize = $_FILES['userfile']['size'];
    $fileType = $_FILES['userfile']['type'];
    $id_client = $_POST['num_id_client'];

    $fp      = fopen($tmpName, 'r');
    $content = fread($fp, filesize($tmpName));
    $content = addslashes($content);
    fclose($fp);

    if(!get_magic_quotes_gpc())
    {
        $fileName = addslashes($fileName);
    }


    $req = $pdo->prepare("SELECT * FROM upload WHERE name = ?");
    $req->execute([$fileName]);
    $fileIsHeres = $req->fetchAll();
    /* var_dump($fileIsHere);
     die();*/
    if($fileIsHeres){
        $presence = false;
        foreach($fileIsHeres as $fileIsHere){
            if($fileIsHere->name && $fileIsHere->type && $fileIsHere->size &&  $fileIsHere->content){
                echo  "<script>alert(\"File $fileName is yet in the database!\")</script>";
                $presence = true;
                break;
            }
        }
        if(!$presence){
            $pdo->query("INSERT INTO upload (name, size, type, content, id_client ) ".
                "VALUES ('$fileName', '$fileSize', '$fileType', '$content', '$id_client')");

            $id_fichier = $pdo->lastInsertId();
            $queryFileUser = "INSERT INTO client_fichier set id_user = ? , id_fichier = ?";
            $req = $pdo->prepare($queryFileUser);
            $res = $req->execute([$id_client, $id_fichier]);
            //mail()
            echo  "<script>alert(\"File $fileName uploaded\")</script>";

        }
        header('Location: sarr/espace_membre/app/Client/Views/leClient.php');
    }else{
        $pdo->query("INSERT INTO upload (name, size, type, content, id_client ) ".
            "VALUES ('$fileName', '$fileSize', '$fileType', '$content', '$id_client')");

        $id_fichier = $pdo->lastInsertId();
        $queryFileUser = "INSERT INTO client_fichier set id_user = ? , id_fichier = ?";
        $req = $pdo->prepare($queryFileUser);
        $res = $req->execute([$id_client, $id_fichier]);
        echo  "<script>alert(\"File $fileName uploaded\")</script>";
        header('Location: sarr/espace_membre/app/Client/Views/leClient.php');
    }
}

$allMyFiles = [];
if(isset($_POST['seclectId']) && !empty($_POST['id_utilisateur'])){
    $id2 = $_POST['id_utilisateur'];
    $req = $pdo->prepare("SELECT * FROM upload WHERE id_client = ?");
    $req->execute([$id2]);
    $allMyFiles = $req->fetchAll();
}