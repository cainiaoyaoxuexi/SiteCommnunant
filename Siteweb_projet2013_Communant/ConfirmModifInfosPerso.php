<?php
//Page de confirmation après modification des infos personnelles dans ModifProfil.php

require("moduleFonction.php");
connexionChoixBase();

session_start();
$IDM = $_SESSION["IDM"];

$nom =$_POST["txt_nom"];
$prenom =$_POST["txt_prenom"];
$pseudo =$_POST["txt_pseudo"];
$email =$_POST["txt_email"];
$pass =$_POST["txt_password"];

$query = "UPDATE MEMBRES SET NOMM='$nom', PRENOM='$prenom', PSEUDO = '$pseudo', EMAIL = '$email', PASSWORD='$pass' WHERE IDM='$IDM'" ;
$result = mysql_query($query);
$msg=mysql_error();
echo("$msg");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Untitled</title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="style"> 
  <div class="entete"> <img src="LogoSIGE.JPG" align="left"></h3>
    <h4 align="right" color="#E3E3E3"><a href="Deconnexion.php" >Déconnexion</a></h4>
    <h4 align="right"><a href="Accueil.php">Retourner à page d'Accueil</a></h4>
  </div>
  <div class="contenu"> <br>
    <h3>Vos informations ont bien été mis à jour !</h3>
    <form action="Accueil.php" method="get">
      <input type="submit" value="Retourner sur votre page d'accueil" />
    </form>
  </div>
</div>
</body>
</html>
