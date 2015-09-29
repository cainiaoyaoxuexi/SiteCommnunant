<?php
//Page de confirmation après "ajout d'une nouvelle compétence" dans ModifProfil.php

require("moduleFonction.php");
connexionChoixBase();

session_start();
$IDM = $_SESSION["IDM"];

$comp= $_GET["competence"];
$niv=$_GET["niveau"];

$requetCheckCom="SELECT IDC FROM AVOIR WHERE IDC= '$comp' AND IDM='$IDM'";
$curseurCheckCom=mysql_query($requetCheckCom);
$nbCom=mysql_num_rows($curseurCheckCom);
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
  <div class="contenu"> 
    <?php
If ($nbCom ==0)
{
$queryinsertComp = "INSERT INTO AVOIR VALUES('$IDM','$comp', '$niv')";
$resultComp = mysql_query($queryinsertComp);
$msg=mysql_error();
echo("$msg");
echo ("Vous avez bien ajouté une compétence !");
}
else
{
echo ("<h3>Vous aviez déjà cette compétence</h3> !");
}
?>
    <form action="ModifProfil.php" method="get">
      <input type="submit" value="Continuez à modifier votre profil" />
    </form>
  </div>
</div>
</body>
</html>
