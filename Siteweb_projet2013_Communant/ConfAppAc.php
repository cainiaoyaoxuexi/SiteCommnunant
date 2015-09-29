<?php
//Page de confirmation après un LIKE d'un commentaire dans Accueil.php
require("moduleFonction.php");
connexionChoixBase();
session_start();
$IDM = $_SESSION["IDM"];
$IDcom =$_GET["idcom"];


$queryrecommend = "INSERT INTO APPROUVER values('$IDcom','$IDM')";
$resultrec = mysql_query($queryrecommend);
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
</div>
<div class="contenu"> <br>
  <h3>Vous approuvez ce commentaire !</h3>
  <form action="Accueil.php" method="get">
    <input type="submit" value="Retourner sur son profil" />
  </form>
</div></div>
</body>
</html>
