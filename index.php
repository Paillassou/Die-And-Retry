<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Liste - Die And Retry</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.0/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link href="https://fonts.googleapis.com/css?family=Merriweather|Press+Start+2P|Roboto" rel="stylesheet">

    </head>
    <body>
      <header>
        <div class="banner">

        </div>
      </header>

<div class="bodytop text-center mb-3">
  <h1 class="m-5">Liste des jeux</h1>
  <form action="" method="get">
  <input class ="" type="text" name="searchlist" value="" placeholder="Rechercher un jeu par">
  <select class="" name="searchtype">
    <option value="name">Nom</option>
    <option value="edit">Editeur</option>
    <option value="dev">Développeur</option>
    <option value="plat">Plateforme</option>
  </select>
  <button class = "btn btn-primary" type="submit" name="searchvalid"> Rechercher</button>
  </form>
  <div class="buttons m-3">
  <form action="add.php" method="post">
  <button id ="add" class ="butt btn btn-primary" type="submit" name="act" value ="add">Ajouter un jeu</button>
  </form>
  <form action="index.php" method="post">
  <button id ="upd" class ="butt btn btn-primary" type="submit" name="act" value ="upd">Mettre à jour un jeu</button>
  </form>
  <form action="index.php" method="post">
  <button id ="del" class ="butt btn btn-primary" type="submit" name="act" value ="del">Supprimer un jeu</button>
  </form>
  
</div>
</div>



<section id="gamelist" class="container-fluid">
  <table class="list1 table-striped table tab">
    <thead class="thead-dark">
      <tr>
        <th></th>
        <th class = "mobhide">Référence</th>
        <th>Nom</th>
        <th>Plateforme</th>
        <th>Genre</th>
        <th class = "tabhide mobhide">Développeur</th>
        <th class = "mobhide">Editeur</th>
      </tr>
    </thead>
    <form action="" method="post">
  <?php
        // CONNEXION A MYSQL
      try
    {

        $bdd = new PDO('mysql:host=localhost;dbname=videogames', 'root', '');
    }
    catch(Exception $e)
    {

            die('Erreur : '.$e->getMessage());
    }
        // REQUETE SQL
    $requete = $bdd->query('SELECT videogames.id as idGames, videogames.ref2 as refGame, developers.name AS devNom, publishers.name AS pubNom, videogames.id AS idJeu, Title, platform.name AS plateforme, group_concat(genres.name separator ", ") AS genre, platform.platref AS platref FROM platform
  LEFT OUTER JOIN videogames ON videogames.idplatform=platform.id
  INNER JOIN gamesgenres ON gamesgenres.idVideoGame=videogames.id
  INNER JOIN genres ON genres.id=gamesgenres.idGenre
  INNER JOIN constructor ON constructor.id=platform.idConstructor
  INNER JOIN publishers ON publishers.id=videogames.idPublisher
  INNER JOIN developers ON developers.id=videogames.idDeveloper
  GROUP BY videogames.id ORDER BY videogames.Title');
  $donnees = $requete->fetchAll();
        // CONSTRUCTION DE LA REFERENCE DE CHAQUE JEU
  $idprim = 1; // On démarre à 1
  $idsec = "A"; // On démarre à A
  $i = 1; // On démarre à 1
  $idprim = sprintf('%03d',$idprim);  // On affiche les "00" 

// Code à éxécuter si le champ de recherche est vide  
var_dump($_POST);
if ($_GET == null ) {
  foreach ($donnees as $jeu => $details) {
  
    $idprem = $details['platref'] . $idprim . $idsec;   // On écrit la réference avec 3 lettres + les chiffres + la lettre
    $id = strtoupper($idprem); // On met en MAJ
    $j = $i - 1; // On crée une variable pour comparer une ligne à la précédente
    $idsec = "A";
  
  if ($donnees[$i]['Title'] == $donnees[$j]['Title'] && $donnees[$i]['plateforme'] == $donnees[$j]['plateforme'] ) {
    $idsec++; // Si le jeu est en doublon on passe à la lettre suivante
  } 
  
  elseif ($donnees[$i]['plateforme'] !== $donnees[$j]['plateforme']){
    $idprim = 1; // Si on change de console on redémarre à 1
  }else {
    $idprim++; // Sinon on continue l'incrémentation
  }
  
  $i++; 

  if($i==count($donnees)){
    break; // On arrête quand on arrive au bout de la table
  };
  
  $idprim = sprintf('%03d',$idprim);
  
  // On affiche toutes les infos des jeux
  echo '<tr>
  <td><input class = "radio" type="radio" id="' . $details['idJeu'] . '" name="choix" value="' . $details['idJeu'] . '"></td>
  <td class = "mobhide">' . $details['refGame'] . '</td> 
  <td>' . $details['Title'] . '</td> 
  <td>' . $details['plateforme'] . '</td>
  <td>' . $details['genre'] . '</td>
  <td class = "mobhide">' . $details['devNom'] . '</td>
  <td class = "tabhide mobhide">' . $details['pubNom'] . '</td>
  </tr>';
  

// Insertion de la référence unique dans la base de données...
  /*try {
  
  $sql = 'UPDATE videogames SET ref2="' . $id . '" WHERE videogames.id="' . $details['idGames'] . '"';  
  $stmt = $bdd->prepare($sql);  
  $stmt->execute();
  echo $stmt->rowCount() . " records UPDATED successfully ";
    }
  catch(PDOException $e)
    {
    echo $sql . " <br> " . $e->getMessage();
    }  
*/
}
// Code à éxécuter si le champ de recherche a été saisi
} else {
  if ($_GET['searchtype'] == 'name') {
    $search = $_GET['searchlist'];
    $s = '"% '.$search.'%" GROUP BY videogames.id ORDER BY videogames.Title';                
    $query = 'SELECT developers.name AS devNom, publishers.name AS pubNom, videogames.id AS idJeu, videogames.ref2 as refGame, Title, platform.name AS plateforme, group_concat(genres.name separator ", ") AS genre, platform.platref AS platref FROM videogames INNER JOIN platform ON platform.id=videogames.idplatform
    LEFT OUTER JOIN gamesgenres ON gamesgenres.idVideoGame=videogames.id
    LEFT OUTER JOIN genres ON genres.id=gamesgenres.idGenre
    LEFT OUTER JOIN constructor ON constructor.id=platform.idConstructor
    LEFT OUTER JOIN publishers ON publishers.id=videogames.idPublisher
    LEFT OUTER JOIN developers ON developers.id=videogames.idDeveloper WHERE videogames.Title LIKE '.$s.'';
    $requetesearch = $bdd->query($query);
    $donnees = $requetesearch->fetchAll();
  } 
  elseif ($_GET['searchtype'] == 'edit') {
    $search = $_GET['searchlist'];
    $s = '"%'.$search.'%" GROUP BY videogames.id ORDER BY videogames.Title';                
    $query = 'SELECT developers.name AS devNom, publishers.name AS pubNom, videogames.id AS idJeu, videogames.ref2 as refGame, Title, platform.name AS plateforme, group_concat(genres.name separator ", ") AS genre, platform.platref AS platref FROM videogames INNER JOIN platform ON platform.id=videogames.idplatform
    LEFT OUTER JOIN gamesgenres ON gamesgenres.idVideoGame=videogames.id
    LEFT OUTER JOIN genres ON genres.id=gamesgenres.idGenre
    LEFT OUTER JOIN constructor ON constructor.id=platform.idConstructor
    LEFT OUTER JOIN publishers ON publishers.id=videogames.idPublisher
    LEFT OUTER JOIN developers ON developers.id=videogames.idDeveloper WHERE publishers.name LIKE '.$s.'';
    $requetesearch = $bdd->query($query);
    $donnees = $requetesearch->fetchAll();
    
  } 
  elseif ($_GET['searchtype'] == 'dev') {
    $search = $_GET['searchlist'];
    $s = '"%'.$search.'%" GROUP BY videogames.id ORDER BY videogames.Title';                
    $query = 'SELECT developers.name AS devNom, publishers.name AS pubNom, videogames.id AS idJeu, videogames.ref2 as refGame, Title, platform.name AS plateforme, group_concat(genres.name separator ", ") AS genre, platform.platref AS platref FROM videogames INNER JOIN platform ON platform.id=videogames.idplatform
    LEFT OUTER JOIN gamesgenres ON gamesgenres.idVideoGame=videogames.id
    LEFT OUTER JOIN genres ON genres.id=gamesgenres.idGenre
    LEFT OUTER JOIN constructor ON constructor.id=platform.idConstructor
    LEFT OUTER JOIN publishers ON publishers.id=videogames.idPublisher
    LEFT OUTER JOIN developers ON developers.id=videogames.idDeveloper WHERE developers.name LIKE '.$s.'';
    $requetesearch = $bdd->query($query);
    $donnees = $requetesearch->fetchAll();
  } 
  elseif ($_GET['searchtype'] == 'plat') {
    $search = $_GET['searchlist'];
    $s = '"%'.$search.'%" GROUP BY videogames.id ORDER BY videogames.Title';                
    $query = 'SELECT developers.name AS devNom, publishers.name AS pubNom, videogames.id AS idJeu, videogames.ref2 as refGame, Title, platform.name AS plateforme, group_concat(genres.name separator ", ") AS genre, platform.platref AS platref FROM videogames INNER JOIN platform ON platform.id=videogames.idplatform
    LEFT OUTER JOIN gamesgenres ON gamesgenres.idVideoGame=videogames.id
    LEFT OUTER JOIN genres ON genres.id=gamesgenres.idGenre
    LEFT OUTER JOIN constructor ON constructor.id=platform.idConstructor
    LEFT OUTER JOIN publishers ON publishers.id=videogames.idPublisher
    LEFT OUTER JOIN developers ON developers.id=videogames.idDeveloper WHERE platform.name LIKE '.$s.'';
    $requetesearch = $bdd->query($query);
    $donnees = $requetesearch->fetchAll();
  } 
  
  foreach ($donnees as $jeu => $details) {

    
    echo '<tr>
    <td><input type="radio" id="' . $details['idJeu'] . '" name="choix"></td>
    <td class = "mobhide">' . $details['refGame'] . '</td> 
    <td>' . $details['Title'] . '</td> 
    <td>' . $details['plateforme'] . '</td>
    <td>' . $details['genre'] . '</td>
    <td>' . $details['devNom'] . '</td>
    <td>' . $details['pubNom'] . '</td>
    </tr>';}

      };
  

  
?>


    
  </tr>

  </table>
  </form>
</section>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.0/js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/script.js"></script>
</body>
</html>

