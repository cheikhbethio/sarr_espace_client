<?php
$db_host = 'localhost';
$db_name = 'depannage_sarr';
$db_user = 'root';
$db_pass = '';

try {
    $PDO = new PDO('mysql:dbname='.$db_name.';host='.$db_host, $db_user, $db_pass);
} catch (PDOException $e) {
    echo 'Connexion échouée : ' . $e->getMessage();
}
