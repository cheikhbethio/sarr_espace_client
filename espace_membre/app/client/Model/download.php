<?php
if(isset($_GET['id'])){
   require '../db.php';
    $id    = $_GET['id'];
    $prepared = "SELECT name, type, size, content " .
        "FROM upload WHERE id = ?";

    $req = $pdo->prepare($prepared);
    $req->execute([$id]);
    $result = $req->fetch();

    $name = $result->name;
    $type = $result->type;
    $size = $result->size;
    $content =  $result->content;

    header("Content-length: $size");
    header("Content-type: $type");
    header("Content-Disposition: attachment; filename=$name");
    echo $content;
    //header('Location: form.php');
    exit;
}
