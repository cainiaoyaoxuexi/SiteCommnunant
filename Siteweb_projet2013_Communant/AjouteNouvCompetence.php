<?php 
//Page de confirmation apr�s ajout d'une comp�tence SAISIE dans Enregistrer3.php 

session_start();
$email =$_SESSION["email"];									//identifie le membre connect�

require("moduleFonction.php");
connexionChoixBase();												//fonction se connecte � la base								

$nuplet= infosMembreParEmail($email);				//fonction r�cup�re tous les infos du membre connect�
$IDM=$nuplet["IDM"];
$nomC=$_GET["txt_com"];											//r�cup�ration de la comp�tence et du niveau � ajouter
$niv=$_GET["niveauAjouter"];
																						//on ins�re la comp�tence dans la base
$requetAjouter="INSERT INTO COMPETENCES VALUES('','$nomC')";
$resultAjouter=mysql_query($requetAjouter);
																					 	//on r�cup�re l'identifiant de cette comp�tence
$requetIDC="select IDC from COMPETENCES where NOMC='$nomC'";
$resultIDC=mysql_query($requetIDC);
$nupletIDC=mysql_fetch_array($resultIDC);
$IDC=$nupletIDC["IDC"];
											 									 		//on ajoute cette comp�tence au membre connect�	
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
