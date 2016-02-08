<?php
require 'lib/inc.prepend.php';
?>
<?php
if(isset($_POST['nom_envoye'])){
//require 'lib/inc.prepend.php';
$client_envoye = $_POST['nom_envoye'];
$stmt = $PDO->prepare('SELECT name, type, updated_date FROM FILE WHERE client_envoye = ? ');
$stmt->execute([$client_envoye]);
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

echo $r;
}

//echo $r;

}


?>



<html>
<head>
    <title>Upload</title>
</head>
<body>
    <form method="post" action = "" enctype="multipart/form-data">
        
		<table border="0" align="center" cellspacing="2" cellpadding="2">
  
		<br> <br> <br>
		<br> <br> <br>
		<br> <br> <br>
		
        <fieldset>
        <legend>Choisir un client</legend>
		
		
			<p>
         
				<label for="nom_envoye">Client a envoyer</label>
				<select name="nom_envoye"><?php
				//require 'lib/inc.prepend.php';
				
				$req = $PDO->query('SELECT `nom_client` FROM `ecotoitnrn770`.`clients` ORDER BY nom_client ASC') or die(print_r($PDO->errorInfo()));
				while ($donnees = $req->fetch())
				{
					
					echo '<option value="'.$donnees['nom_client'].'">'.$donnees['nom_client'].'</option>';
				}
					
				?></select>
            </p>
			
			
			
            <p>
                <input type="submit" value="Rechercher" />
            </p>
			
        </fieldset>
		
		 </table>
    </form>
</body>
</html>