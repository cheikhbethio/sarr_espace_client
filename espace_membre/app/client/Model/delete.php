<?php
if(isset($_GET['id'])){
    require '../db.php';
    $id    = $_GET['id'];
    $prepared = "DELETE FROM upload WHERE id = ?";

    $req = $pdo->prepare($prepared);
    $req->execute([$id]);

    header('Location: leClient.php');
    exit;
}
