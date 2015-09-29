<?php 
//Page de confirmation après "ajout d'une compétence" dans ModifProfil.php

session_start();

require("moduleFonction.php");
connexionChoixBase();

$IDM=$_SESSION["IDM"];
$nomC=$_GET["txt_com"];
$niv=$_GET["niveauAjouter"];

$requetAjouter="INSERT INTO COMPETENCES VALUES('','$nomC')";
$resultAjouter=mysql_query($requetAjouter);

$requetIDC="select IDC from COMPETENCES where NOMC='$nomC'";
$resultIDC=mysql_query($requetIDC);
$nupletIDC=mysql_fetch_array($resultIDC);
$IDC=$nupletIDC["IDC"];

$requeteInsererComp = "INSERT INTO AVOIR VALUES('$IDM','$IDC','$niv')";
$result=mysql_query($requeteInsererComp);

if ($result==0)
{
$msg=mysql_error();
echo("$msg");
}
$_SESSION["COUNT"]=1;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>ModifAjouterNouvCompetence</title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body><div class="style">
<div class="entete"> <img src="LogoSIGE.JPG" align="left"></h3> </div>
<div class="contenu"> <br>
  <h3>Vous avez bien ajouté une nouvelle compétence !</h3>
  <form action = "ModifProfil.php" >
    <br>
    <input type="submit"  value="Continuez à modifier votre profil">
  </form>
</div>
</body>
</html>
