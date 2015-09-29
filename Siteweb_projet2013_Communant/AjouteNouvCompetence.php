<?php 
//Page de confirmation après ajout d'une compétence SAISIE dans Enregistrer3.php 

session_start();
$email =$_SESSION["email"];									//identifie le membre connecté

require("moduleFonction.php");
connexionChoixBase();												//fonction se connecte à la base								

$nuplet= infosMembreParEmail($email);				//fonction récupère tous les infos du membre connecté
$IDM=$nuplet["IDM"];
$nomC=$_GET["txt_com"];											//récupération de la compétence et du niveau à ajouter
$niv=$_GET["niveauAjouter"];
																						//on insère la compétence dans la base
$requetAjouter="INSERT INTO COMPETENCES VALUES('','$nomC')";
$resultAjouter=mysql_query($requetAjouter);
																					 	//on récupère l'identifiant de cette compétence
$requetIDC="select IDC from COMPETENCES where NOMC='$nomC'";
$resultIDC=mysql_query($requetIDC);
$nupletIDC=mysql_fetch_array($resultIDC);
$IDC=$nupletIDC["IDC"];
											 									 		//on ajoute cette compétence au membre connecté	
$requeteInsererComp = "INSERT INTO AVOIR VALUES('$IDM','$IDC','$niv')";
$result=mysql_query($requeteInsererComp);

if ($result==0)
{
$msg=mysql_error();
echo("$msg");
}
$_SESSION["COUNT"]=0;
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
<title>AjouteNouvCompetence</title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="style">
<div class="entete">
<img src="LogoSIGE.JPG" align="left"></h3>
</div>
<div class="contenu">
<form action = "Enregistrer3.php" >
<br><input type="submit"  value="Continuer">

</form>
</div>
</body>
</html>
