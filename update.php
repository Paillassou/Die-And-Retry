<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>MAJ de jeu - Die And Retry</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.0/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link href="https://fonts.googleapis.com/css?family=Merriweather|Press+Start+2P|Roboto" rel="stylesheet">

    </head>
    <body>
      <header>
        <div class="banner">

        </div>
      </header>

      <div class="addform col-10 offset-1">
  <h1 class="addform m-5 text-center">Modifier un jeu</h1>
  <?php
  try
  {

      $bdd = new PDO('mysql:host=localhost;dbname=videogames', 'root', '');
  }
  catch(Exception $e)
  {

          die('Erreur : '.$e->getMessage());
  }
  $requete = $bdd->query('SELECT DISTINCT id, name AS genrename FROM genres
  GROUP BY genrename');
  $donnees = $requete->fetchAll();


?>

<form action="" method="post">
  <span>Nom </span>
  <input class="ml-2" type="text" name="gamename" value="" placeholder="Entrez le nom du jeu">
  <div class="genre mt-5">
    <p class="mt-3 mb-3">Genre</p>
    <div class="boxes">
    
      <?php 
      
        foreach ($donnees as $donnee => $info) {
      
      echo '<div class="box"><label for="">' . $info['genrename'] . '</label>
      <input type="checkbox" id="genre' . $info['id'] . '" name="genre" method="post"></div>';
        }
      ?>
    
    </div>
  </div>  
  <div class ="row">
  <div class="fplat mt-5 col-12 col-md-6">
  
  <p>Plateforme</p>
    <select class="plat" name="plat" method="post">
      <?php
      $requete2 = $bdd->query('SELECT DISTINCT name AS platname FROM platform GROUP BY platname');
      $donnees2 = $requete2->fetchAll();
      foreach ($donnees2 as $donnee => $info) {
      echo' <option value="' . $info['platname'] . '">' . $info['platname'] .'</option>';
      }
      
      ?>
    </select><br>
    
  
  </div>
  <div class="fdate mt-5 col-12 col-md-6">
    <p>Date de sortie</p>
    <span>Jour</span>
    <select class="jour" name="jour" method="post">
      <option value=""></option>
      <?php
      for ($i   =1; $i < 32; $i++) {
        echo '<option value=" '   . $i .'"> ' . $i .'</option>';
      }
      ?>
    </select>
    <span>Mois</span>
    <select class="mois" name="mois" method="post">
      <option value=""></option>
      <?php
      for ( $i =1; $i < 13; $i++) {
        echo '<option value="  '  . $i .'"  > '   .$i .'</option>';
      }
      ?>
    </select>
    <span>Année</span>
    <select class="annee" name="annee" method="post">
      <option value=""></option>
      <?php
      for ($i =2019  ; $i  >1960; $i--) {
        echo '<option value="   ' .$i   .'" >  ' .$i .'</option>';
      }
      ?>
    </select>
  </div>
  </div>
  <div class="fedit mt-5">
    <p>Editeur</p>
    <select class="edit" name="edit"  method="post">
    <?php
      $requete3 = $bdd->query('SELECT DISTINCT name AS pubname FROM publishers GROUP BY pubname');
      $donnees3 = $requete3->fetchAll();
      foreach ($donnees3 as $donnee => $info) {
      echo' <option value="' . $info['pubname'] . '">' . $info['pubname'] .'</option>';
      }      
      ?>
      </select><br>
    <input class="mt-2 mb-2" type="text" name="adddev" value="" placeholder="Nouveau" style="width:360px">
    <button class ="btn btn-primary" type="button" name="button">Ajouter</button>
  </div>
  <div class="fdev mt-5">
    <p>Développeur</p>
    <select class="dev" name="dev" method="post">
    <?php
      $requete4 = $bdd->query('SELECT DISTINCT name AS devname FROM developers GROUP BY devname');
      $donnees4 = $requete4->fetchAll();
      foreach ($donnees4 as $donnee => $info) {
      echo' <option value="' . $info['devname'] . '">' . $info['devname'] .'</option>';
      }      
      ?>
    </select><br>
    <input class="mt-2 mb-2" type="text" name="adddev" value="" placeholder="Nouveau" style="width:360px">
    <button class ="btn btn-primary" type="button" name="button">Ajouter</button>
  </div>
  

  <button class="addgamebut btn btn-primary" type="submit" name="button">Enregistrer le jeu</button>
  </form>

</div>

<?php

  require 'footer.php';
?>
