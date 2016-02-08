<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="../../favicon.ico">
        <title>Gestion espace Membre</title>
        <!-- Bootstrap core CSS -->
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <h1 style="color: green">Bienvenu dans votre espace perso <i>Moussa</i></h1>
            <br><br><br>

            <div class="row" style="border: solid green 1px; padding: 0 100px; border-radius: 10px; margin-bottom: 10px ">
                <h2>Formulaire d'envoi de fichier</h2>
                <form action="../Model/envoi.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="hidden" name="MAX_FILE_SIZE" value="2000000">
                    </div>
                    <div class="form-group">
                        <input name="userfile" type="file" id="userfile">
                    </div>
                    <div class="form-group">
                        <label for="num_id_client">Entrez L'ID du client</label>
                        <input name="num_id_client" type="text" id="num_id_client" class="form-control">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-success" id="upload" name="upload" type="submit">Envoyer le fichier</button>
                    </div>
                </form>

                <br> <br>
            </div>

            <div class="row" style="border: solid green 1px; padding: 0 100px; border-radius: 10px ">
                <h2>Mes Fichiers Perso</h2>

                <form method="post" name="secondForm">
                    <div class="form-group">
                        <label for="id_utilisateur"> Entrez Id Utilisateur</label>
                        <input type="text" name="id_utilisateur" class="form-control" id="id_utilisateur">
                    </div>
                    <div class="form-group">
                        <input class="btn btn-success" id="seclectId" name="seclectId" type="submit" value="Choisir cet ID">
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($allMyFiles as $file) : ?>
                            <tr>
                                <td><?= $file->id?></td>
                                <td><?= $file->name?></td>
                                <td><a href="../Model/download.php?id=<?=$file->id;?>">Télécharger</a>
                                    <a style="color: red" href="../Model/delete.php?id=<?=$file->id;?>">Suppimer</a>
                                </td>
                            </tr>
                        <?php endforeach;?>
                        </tbody>
                    </table>
                <div

            </div>

        </div><!-- /.container -->
    </body>
</html>
