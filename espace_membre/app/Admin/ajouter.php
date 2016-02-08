<?php
require 'lib/inc.prepend.php';
require 'generer_password.php';
$message = null;

//$nom = $_POST['nom'];
//$mail = $_POST['mail'];
$password= genererMDP ($longueur = 8);
$id = time();

if(!empty($_POST['nom']) && !empty($_POST['mail'])){
	
	//$resultat =$req;
	$req = $PDO->prepare('INSERT INTO `ecotoitnrn770`.`clients` (`id`, `nom_client`, `mail`, `pasword`) VALUES (:id, :nom_client, :mail, :password)');
$req->execute(array('id' => $id,
 'nom_client' => $_POST['nom'] ,
 'mail' => $_POST['mail'],
 'password' => $password
 ));
//var_dump($req);	
	$message = 'Votre client a bien été ajouté';


}

?>
<?php include('templates/header.php');?>
<style>
    body{ background-image : url("../../image_fond.jpg");
        -webkit-background-size: cover;
        background-size: cover;
        background-size: 50% auto;

    }
</style>


<div class="col-sm-8 col-sm-offset-2" style="height: 100%; border-radius: 8px;  border: solid 3px green; background-color: white; margin-top: 25%">
    <h1 style="color: green; text-align: center">Ajouter des clients</h1>
    <form method="post" enctype="multipart/form-data">
        <?php echo $message; ?>

    <div class="form-group">
        <label for="nom">Nom client</label>
      <input type="text" name="nom" class="form-control" placeholder="Entrez le nom du client">
    </div>
    <div class="form-group">
        <label for="mail">E-mail contact</label>
     <input type="text" name="mail" class="form-control" placeholder="Entrez son email">
    </div>

    <div class="form-group">
        <input class="btn btn-success lg" type="submit" value="Ajouter">
    </div>
</form>
</div>
<?php include('templates/footer.php');?>
