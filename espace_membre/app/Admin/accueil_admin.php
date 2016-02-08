
<?php include('templates/header.php');?>
<style>
	body{
		background-image : url("../../image_fond.jpg");
		-webkit-background-size: cover;
		background-size: cover;
		background-size: 80% auto;
	}
	.block_lien{
		background-color: green;
		color: yellow;
		border-radius: 8px;
		height: 100px;
		margin-bottom: 20px;
		margin-top: 20px;
		font-size: 30px;
	}
	.all_link{
		border-radius: 8px;
		border: solid 3px green;
		background-color: white;
		margin-top: 25%
	}
</style>
<div class=" row all_link">
	<a href="ajouter.php">
		<div class="block_lien col-sm-5 ">
			Ajouter un nouveau client
		</div>
	</a>
	<a href="upload.php">
		<div class="block_lien  col-sm-5  col-sm-offset-1">
			Envoyer des fichiers aux clients
		</div>
	</a>
	<a href="list_client.php">
		<div class="block_lien  col-sm-5 col-sm-offset-1">
			Liste fichiers
		</div>
	</a>

	<a href="supprimer.php">
		<div class="block_lien  col-sm-5 col-sm-offset-1">
			Supprimer un client
		</div>
	</a>
</div>
<?php include('templates/footer.php');?>