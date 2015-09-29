<?php
//Page de confirmation après "modification de niveau pour une compétence" dans ModifProfil.php

require("moduleFonction.php");
connexionChoixBase();

session_start();
$IDM = $_SESSION["IDM"];
$comp= $_GET["IDCompàModifier"];
$niv = $_GET["niveau"];

$queryup = "UPDATE AVOIR SET NIVEAU= '$niv' WHERE IDM ='$IDM' AND IDC ='$comp'";
$resultup = mysql_query ($queryup);
$msg=mysql_error();
echo("$msg");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>ConfirmModifNiveau</title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="style"> 
  <div class="entete"> <img src="LogoSIGE.JPG" align="left"></h3>
    <h4 align="right" color="#E3E3E3"><a href="Deconnexion.php" >Déconnexion</a></h4>
    <h4 align="right"><a href="Accueil.php">Retourner à page d'Accueil</a></h4>
  </div>
  <div class="contenu"> <br>
    <h3>Vous avez bien modifié votre niveau pour cette compétence !</h3>
    <form action="ModifProfil.php" method="get">
      <input type="submit" value="Continuez à modifier votre profil" />
    </form>
  </div>
</div>
</body>
</html>
