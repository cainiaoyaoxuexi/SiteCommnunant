<?php
//Page de confirmation après "choix de suivre un membre" dans profil.php

require("moduleFonction.php");
connexionChoixBase();

session_start();
$IDM = $_SESSION["IDM"];
$IDMprofil=$_SESSION["IDMProfil"];

$requeteS = "INSERT INTO ABONNER VALUES('$IDM', '$IDMprofil')";
$resultatS = mysql_query($requeteS);
$msg=mysql_error();
echo("$msg");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Confirmation de Suivi</title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="style"> 
  <div class="entete"> <img src="LogoSIGE.JPG" align="left"></h3>
    <h4 align="right" color="#E3E3E3"><a href="Deconnexion.php" >Déconnexion</a></h4>
    <h4 align="right"><a href="Accueil.php">Retourner à page d'Accueil</a></h4>
  </div>
  <div class="contenu"> 
    <?php 
$nuplet = infosMembreParID($IDMprofil);
echo ("<h1> &nbsp </h1><h3>Vous suivez désormais ".$nuplet["PRENOM"]." ".$nuplet["NOMM"]." "." (alias"." ".$nuplet["PSEUDO"].") </h3>"); ?>
    <form action="profil.php" method="get">
      <input type="submit" value="Retourner sur son profil" />
    </form>
  </div>
</div>
</body>
</html>
