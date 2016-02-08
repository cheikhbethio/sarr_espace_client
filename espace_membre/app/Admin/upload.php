<?php
require 'lib/inc.prepend.php';
$message = null;

if (isset($_FILES['myFile'])) {
    $File = new FileFromDB($_FILES['myFile']['name']);
    $File->upload($_FILES['myFile'],$_POST['nom_envoye']);
	
	$nom_envoye    = $_POST['nom_envoye'];
	$prepared = "SELECT mail " .
		         "FROM clients WHERE client_envoye = ?";

		$req = $PDO->prepare($prepared);
		$req->execute([$nom_envoye]);		
		$result = $req->fetch();

		$mail = $result['mail'];
		
		mail($mail,"ECOTOIT", "VOUS AVEZ RECU UN FICHIER SUR VOTRE ESPACE MEMBRE DE LA PART DE ECOTOIT");
	
    $message = 'Votre fichier a bien été ajouté';
}



?>
<html>
<head>
    <title>Upload</title>
</head>
<body>
    <form method="post" enctype="multipart/form-data">
        <?php echo $message; ?>
		<table border="0" align="center" cellspacing="2" cellpadding="2">
  
		<br> <br> <br>
		<br> <br> <br>
		<br> <br> <br>
		
        <fieldset>
        <legend>Charger un fichier</legend>
		
		
			<p>
         
				<label for="nom_envoye">Client à envoyer</label>
				<select name="nom_envoye"><?php
				$req = $PDO->query('SELECT `nom_client` FROM `ecotoitnrn770`.`clients` ORDER BY nom_client ASC') or die(print_r($PDO->errorInfo()));
				while ($donnees = $req->fetch())
				{
					
					echo '<option value="'.$donnees['nom_client'].'">'.$donnees['nom_client'].'</option>';
				}
					
				?></select>
            </p>
			
            <p>
                <label for="myFile">Fichier</label>
                <input type="file" id="myFile" name="myFile" />
            </p>
			
			
			
			
            <p>
                <input type="reset" value="Annuler" />
                <input type="submit" value="Envoyer" />
            </p>
			
        </fieldset>
		
		 </table>
    </form>
</body>
</html>