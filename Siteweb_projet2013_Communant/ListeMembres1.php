<?php
//Page résultat de recherche d'un membre par nom saisie dans Accueil.php

require("moduleFonction.php");
connexionChoixBase();

session_start();
$IDM = $_SESSION["IDM"];
$_SESSION["CountA"]=0
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>liste des memebers cherchés</title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="style"> 
  <div class="entete"> <img src="LogoSIGE.JPG" align="left"></h3>
    <h4 align="right" color="#E3E3E3"><a href="Deconnexion.php" >Déconnexion</a></h4>
    <h4 align="right"><a href="Accueil.php">Retourner à page d'Accueil</a></h4>
  </div>
  <?php

$nom=$_GET["nomMembre"];
$requet="SELECT IDM, NOMM, PRENOM, PSEUDO FROM MEMBRES WHERE (NOMM='$nom'OR PRENOM='$nom'OR PSEUDO='$nom') AND IDM NOT IN (SELECT IDM FROM MEMBRES WHERE IDM= '$IDM')";
$cursuer=mysql_query($requet);
$nbmebre=mysql_num_rows($cursuer);    //nombre de membres ayant soit nom, prénom ou pseudo identique au nom saisie
$nuplet=mysql_fetch_array($cursuer);  //récupère les infos du prochain membre à ajouter à la liste
$IDM_MemebreListe=$nuplet["IDM"];

$requetCom="SELECT NOMC, NIVEAU FROM AVOIR A, COMPETENCES C WHERE A.IDC=C.IDC AND A.IDM= '$IDM_MemebreListe'";
$cursuerCom=mysql_query($requetCom);
$msg=mysql_error();
echo("$msg");			 									  
$nbcom=mysql_num_rows($cursuerCom);	 	//récupère le nombre de compétences possèdé par un membre de la liste		 

$requetrec="SELECT DISTINCT  C.NOMC ,C.IDC FROM COMPETENCES C, RECOMMANDER R WHERE R.IDM_RECOMMAND='$IDM_MemebreListe' AND C.IDC = R.IDC";
$cursuerrec=mysql_query($requetrec);
$msg=mysql_error();
echo("$msg");
$nbrec=mysql_num_rows($cursuerrec);   //récupère le nombre de compétences recommandés pour un membre de la liste		 

if ($nbmebre!=0)
{
echo("<h3>  &nbsp&nbsp Voici les personnes qui s'appelle"." "."$nom".":</h3>");

echo("<div class='contenu'>");
// definition grande table, chaque ligne correspond à un membre de la liste :
echo("<table  cellpadding=16 cellspacing= 9 align =\"center\" >");   

for ($i=1;$i<=$nbmebre;$i++)
{
// on ouvre une ligne de la grande table et dans la première case on met identifiants + bouton "voir Profil" :
echo("<tr><td text-style:  bgcolor=\"F8E4CC\" ; align =\"center\"> &nbsp&nbsp <b><div class='pseudo'>".$nuplet["PRENOM"]);
echo ("</div><br> &nbsp(alias ".$nuplet["PSEUDO"].")");
echo ("<p> &nbsp </p><form action = \"profil.php\" method = \"GET\">");
echo ("<input type=\"hidden\" name=\"IDMP\" value=\"$IDM_MemebreListe\" />");
echo ("<input type=\"submit\" value = \"Voir son profil\"/>");
echo ("</form></td>");

//dans la deuxième case (compétences et recommandations):
echo("<td text-style:  bgcolor=\"F8E4CC\">");

echo("<table align='left'>"); 							 // ouvre une table comp&rec
echo ("<tr><td><b>"."Ses compétences :"."</b></td></tr>");

for ($j=1;$j<=$nbcom;$j++)
{
$nupletCom=mysql_fetch_array($cursuerCom);
echo("<tr><td> - ".$nupletCom["NOMC"]."<i> (Niveau ".$nupletCom["NIVEAU"].")</i></td></tr>");
}

$checkrec= mysql_num_rows($cursuerrec);
if ($checkrec !=0)										 		   // si le membre a eu des recommandations
{
echo ("<tr><td><br> <b>"."Recommandé pour :"."</b></td></tr>");
for ($j=1;$j<=$nbrec;$j++)
{
$nupletrec=mysql_fetch_array($cursuerrec);
$idc=$nupletrec["IDC"];
$recPar= quiRecommande($IDM_MemebreListe, $idc);
$nom=$recPar["PSEUDO"];
echo("<tr><td> - ".$nupletrec["NOMC"]." <i>(par $nom)"); 
}
}

echo("</table></tr>"); // ferme table comp&rec et ligne membre

}
echo("</table>");			 // ferme grande table
}
else
{
echo("<h3>  &nbsp&nbspIl n'y a personne qui s'appelle"." "."$nom"." (Vous n'apparaiterez jamais dans cette liste)</H3>");
}
?>
</div>
</body>
</html>
