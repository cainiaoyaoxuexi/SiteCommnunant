<?php
//Page de confirmation après "recommandation d'un membre" dans profil.php

require("moduleFonction.php");
connexionChoixBase();

session_start();
$IDM = $_SESSION["IDM"];
$IDMProfil=$_SESSION["IDMProfil"];
$comp = $_GET["competence"];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>ConfirmationRecommandation.php</title>
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
$queryExist = "SELECT * FROM RECOMMANDER WHERE IDM = $IDM AND IDC = '$comp'AND IDM_RECOMMAND = $IDMProfil";
$resultExist = mysql_query($queryExist);
$nb = mysql_num_rows ($resultExist);

If ($nb ==0)
{
$queryrecommend = "INSERT INTO RECOMMANDER values('$IDM','$comp','$IDMProfil')";
$resultrec = mysql_query($queryrecommend);
$msg=mysql_error();
echo("$msg");

$nuplet = infosMembreParID($IDMProfil);

echo ("<br><h3>Vous avez recommandé ".$nuplet["PRENOM"]." ".$nuplet["NOMM"]." ("."alias"." ".$nuplet["PSEUDO"]); 
echo (")pour cette compétence</h3>");
}
else
{
echo ("<br><h3>Vous avez déjà recommandé ce membre pour cette compétence</h3>");
}
?>
    <form action="profil.php" method="get">
      <input type="submit" value="Retourner sur son profil" />
    </form>
  </div>
</div>
</body>
</html>
