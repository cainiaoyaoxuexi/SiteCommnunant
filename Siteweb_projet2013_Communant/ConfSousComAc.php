<?php
//Page de confirmation l'envoi d'un sous-commentaire dans Accueil.php
require("moduleFonction.php");
connexionChoixBase();
session_start();

$sousCommentaire=$_GET["souscommentaire"];
$IDM = $_SESSION["IDM"];
$IDCOMP=$_GET["IDCOMP"];

$requetesousCommentaire="insert into COMMENTAIRES values ('', \"$sousCommentaire\",now(), '$IDM','$IDCOMP')";
$curseursousCommentaire=mysql_query($requetesousCommentaire);
$msg=mysql_error();
echo("$msg");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>ConfirmationSousCom</title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="style"> 
  <div class="entete"> <img src="LogoSIGE.JPG" align="left"></h3>
    <h4 align="right" color="#E3E3E3"><a href="Deconnexion.php" >Déconnexion</a></h4>
    <h4 align="right"><a href="Accueil.php">Retourner à page d'Accueil</a></h4>
  </div>
  <div class="contenu"> <br>
    <h3>Votre réaction au commentaire a été posté !</h3>
    <form action="Accueil.php" method="get">
      <input type="submit" value="Retourner sur le profil de la personne" />
    </form>
  </div>
</div>
</body>
</html>
