 <?php

//Page résultat de recherche d'un membre par compétence sélectionnée dans Accueil.php
require("moduleFonction.php");
connexionChoixBase();
session_start();
$IDM = $_SESSION["IDM"];
$_SESSION["CountA"]=0
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>liste des membres cherchés par compétence</title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="style"> 
  <div class="entete"> <img src="LogoSIGE.JPG" align="left"></h3>
    <h4 align="right" color="#E3E3E3"><a href="Deconnexion.php" >Déconnexion</a></h4>
    <h4 align="right"><a href="Accueil.php">Retourner à page d'Accueil</a></h4>
  </div>
  <?php

$IDC=$_GET["competence"];
$requetmembre="SELECT DISTINCT MEMBRES.NOMM, MEMBRES.PRENOM, MEMBRES.IDM , MEMBRES.PSEUDO FROM MEMBRES, AVOIR, RECOMMANDER WHERE ((MEMBRES.IDM=AVOIR.IDM AND AVOIR.IDC='$IDC') or (MEMBRES.IDM=RECOMMANDER.IDM_RECOMMAND AND RECOMMANDER.IDC='$IDC')) AND MEMBRES.IDM NOT IN (SELECT IDM FROM MEMBRES WHERE IDM= '$IDM')";
$cursuer=mysql_query($requetmembre);
echo(mysql_error());
$nbmebre=mysql_num_rows($cursuer);   //nombre de membres qui ont ou qui sont recommandés pour la compétence $IDC


$queryCompNom = "SELECT NOMC FROM COMPETENCES WHERE IDC = $IDC";
$resCompNom = mysql_query($queryCompNom);
$msg=mysql_error();
echo("$msg");
$nupletnomComp=mysql_fetch_array($resCompNom);
$nomC = $nupletnomComp["NOMC"];			 				


if ($nbmebre!=0)
{

echo("<h3> &nbsp&nbsp Voici les personnes ayant la compétence "." "."$nomC"." : </h3>");

echo("<div class='contenu'>");
// on ouvre une ligne de la grande table et dans la première case on met identifiants + bouton "voir Profil" :
echo("<table  cellpadding=10 cellspacing= 9 align =\"center\" >");

for ($i=1;$i<=$nbmebre;$i++)
{
$nuplet=mysql_fetch_array($cursuer);
$IDM_MemebreListe=$nuplet["IDM"];

$requetCom="SELECT NOMC, NIVEAU FROM AVOIR A, COMPETENCES C WHERE A.IDC=C.IDC AND A.IDM= '$IDM_MemebreListe'";
$cursuerCom=mysql_query($requetCom);
$msg=mysql_error();
echo("$msg");
$nbcom=mysql_num_rows($cursuerCom);

$requetrec="SELECT DISTINCT  C.NOMC , C.IDC FROM COMPETENCES C, RECOMMANDER R WHERE R.IDM_RECOMMAND='$IDM_MemebreListe' AND C.IDC = R.IDC";
$cursuerrec=mysql_query($requetrec);
$msg=mysql_error();
echo("$msg");
$nbrec=mysql_num_rows($cursuerrec);

//ouvre ligne de la grande table qui représente un membre de la liste :
echo("<tr><td text-style:  bgcolor=\"F8E4CC\" ; align =\"center\"> &nbsp&nbsp <div class='pseudo'>".$nuplet["PRENOM"]);
echo("</div &nbsp".$nuplet["NOMM"]."</b> &nbsp&nbsp <br>(alias ".$nuplet["PSEUDO"].")");
echo ("<p> &nbsp </p><form action = \"profil.php\" method = \"GET\">");
echo ("<input type=\"hidden\" name=\"IDMP\" value=\"$IDM_MemebreListe\" />");
echo ("<input type=\"submit\" value = \"Voir son profil\"/>");
echo ("</form></td>");

//dans la deuxième case de la grande table(compétences et recommandations):
echo("<td text-style:  bgcolor=\"F8E4CC\">");
echo("<table align='left'>"); 							 // ouvre table comp&rec
echo ("<tr><td><b>"."Ses compétences :"."</b></td></tr>");
for ($j=1;$j<=$nbcom;$j++)
{
$nupletCom=mysql_fetch_array($cursuerCom);
echo("<tr><td> - ".$nupletCom["NOMC"]."<i> (Niveau ".$nupletCom["NIVEAU"].")</i></td></tr>");
}

$checkrec= mysql_num_rows($cursuerrec);
if ($checkrec !=0)										 		  // si le membre a eu des recommandations
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
echo("<h3>  &nbsp&nbspDésole,il n'y a personne ayant la compétence de "."$nomC".".</h3>");
}
?>
</div>
</body>
</html>
