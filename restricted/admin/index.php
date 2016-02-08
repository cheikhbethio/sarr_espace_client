<?php require_once 'bootstrapAdmin.php';
$auth = theApp::getAuth();
$auth->restrictAdmin();
include('../inc/header.php');?>

<div class="row">
	<ul>
		<li>
			<a class ="all_link" href="ajouter.php" >Ajouter un nouveau client</a>
		</li>
		<li>
			<a class ="all_link" href="upload.php">Envoyer des fichiers aux clients</a>
		</li>
		<li>
			<a class ="all_link" href="list_client.php">Liste des clients/fichiers</a>
		</li>
		<li>
			<a class ="all_link" href="supprimer.php">Supprimer / Modifier un client</a>
		</li>
		<li>
			<a class ="all_link" href="modifEpace.php">Modifier Votre compte personel</a>
		</li>
	</ul>
</div>
<?php include('../inc/footer.php');?>