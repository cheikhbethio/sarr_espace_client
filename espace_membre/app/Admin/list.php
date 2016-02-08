<?php


if(isset($_POST['nom_envoye'])){
	require 'lib/inc.prepend.php';
//$client_envoye = $_POST['nom_envoye'];
$stmt = $PDO->prepare('SELECT name, type, updated_date FROM FILE WHERE client_envoye = ? ');
$stmt->execute($_POST['nom_envoye']);
if ($stmt->rowCount()>0) {
    $r = <<<THEAD
<table width="100%" border="1">
    <tr>
        <th align="left">Nom du fichier</th>
        <th>Type de fichier</th>
        <th>Date de derniere modification</th>
        <td></td>
    </tr>
THEAD;
    while($File = $stmt->fetch(PDO::FETCH_OBJ)) {
        $r.= <<<ITEM
        <tr>
            <th align="left">{$File->name}</th>
            <td align="center">{$File->type}</td>
            <td align="center">{$File->updated_date}</td>
            <td align="center"><a href="download.php?filename={$File->name}">voir ce fichier</a></td>
        </tr>
ITEM;
    }
    $r.= <<<TFOOT
</table>
TFOOT;
}
}
?>
<html>
<head>
    <title>Mes fichiers</title>
</head>
<body>
<?php echo $r; ?>
</html>