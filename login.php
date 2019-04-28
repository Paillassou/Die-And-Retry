<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login - Die And Retry</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.0/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link href="https://fonts.googleapis.com/css?family=Merriweather|Press+Start+2P|Roboto" rel="stylesheet">

    </head>
    <body>
      <header>
        <div class="banner">

        </div>
      </header>

<div class="bloclog">
  <h1 class="m-5">Connexion administrateur</h1>
  <div class="formlog">
    <form class="" action="login.php" method="post">
      <div class="champlog p-2">
        <p>Login</p>
        <input type="text" name="login" value="">
      </div>
        <div class="champpwd p-2">
        <p>Mot de passe</p>
      <input type="password" name="pwd" value=""><br>
      <button class="m-4 btn btn-primary" type="submit" name="valid">Connexion</button>
    </form>
  </div>
</div>
<?php
if (isset($_POST['login']) && isset($_POST['pwd'])){
  $login = $_POST['login'];
  $pwd = $_POST['pwd'];
  $b = new PDO('mysql:host=localhost;dbname=videogames', 'root', '');
  $req = $b->query('SELECT * FROM users');
  $r = $req->fetchAll();
  for ($p=0; $p < count($r); $p++) { 
    if ($login == $r[$p]['login'] && $pwd == $r[$p]['password']){
      header('Location: index.php');
    }
  }

}
?>
<?php
require 'footer.php';
  ?>
