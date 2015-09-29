<?php
//Page liste résultat des membres qui vous suivent (1 lien dans Accueil.php)

require("moduleFonction.php");  // accès à l'adresse de la module de fonctions
connexionChoixBase();						// declenche la fonction de Connection à la base de données
session_start();
$IDM = $_SESSION["IDM"];
$_SESSION["CountA"]=0;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
 <head>
  <title>ListeVousSuivez</title>
  <link href="style.css" rel="stylesheet" type="text/css">
 </head>
 <body><div class="style">
  <div class="entete"> <img src="LogoSIGE.JPG" align="left"></h3>
  <h4 align="right" color="#E3E3E3"><a href="Deconnexion.php" >Déconnexion</a></h4>
  <h4 align="right"><a href="Accueil.php">Retourner à page d'Accueil</a></h4>
  </div>
  <?php
  $suivre="SELECT *  FROM ABONNER WHERE IDM_ABONNER='$IDM'";
  $resultSuivre=mysql_query($suivre);
  $numSuivre=mysql_num_rows($resultSuivre);

  if ($numSuivre==0)
   {
   echo("vous suivez aucune personne");
   }
  
  echo("<h3> &nbsp&nbsp Voici les personnes que vous suivez:</h3>");
  echo("<div class='contenu'>");
  echo("<table  cellpadding=16 cellspacing= 9 align =\"center\" >");
  for($i=1;$i<=$numSuivre;$i++)
    {
    $nupletSuivre=mysql_fetch_array($resultSuivre);
    $idmSuivre=$nupletSuivre["IDM"];

    $requet="SELECT NOMM, PRENOM, PSEUDO FROM MEMBRES WHERE IDM= '$idmSuivre'";
    $cursuer=mysql_query($requet);
    $nuplet=mysql_fetch_array($cursuer);


    $requetCom="SELECT NOMC, NIVEAU FROM AVOIR A, COMPETENCES C WHERE A.IDC=C.IDC AND A.IDM= '$idmSuivre'";
    $cursuerCom=mysql_query($requetCom);
	$msg=mysql_error();
	echo("$msg");
	$nbcom=mysql_num_rows($cursuerCom);

	$requetrec="SELECT DISTINCT  C.NOMC FROM COMPETENCES C, RECOMMANDER R WHERE R.IDM='$idmSuivre' AND C.IDC = R.IDC";
	$cursuerrec=mysql_query($requetrec);
	$msg=mysql_error();
	echo("$msg");
	$nbrec=mysql_num_rows($cursuerrec);

	echo("<tr><td text-style:  bgcolor=\"F8E4CC\" ; align =\"center\"> &nbsp&nbsp <b>".$nuplet["PRENOM"]." &nbsp".$nuplet["NOMM"]."</b> &nbsp&nbsp <br>(alias ".$nuplet["PSEUDO"].")");
//ouvre ligne de la grande table qui représente un membre de la liste
	echo ("<p> &nbsp </p><form action = \"profil.php\" method = \"GET\">");
	echo ("<input type=\"hidden\" name=\"IDMP\" value=\"$idmSuivre\" />");
	echo ("<input type=\"submit\" value = \"Voir son profil\"/>");
	echo ("</form></td>");
	echo("<td text-style:  bgcolor=\"F8E4CC\">");

	echo("<table align='center'>"); // ouvre table comp&rec
	echo ("<tr><td><b>"."Ses compétences :"."</b></td></tr>");
	for ($j=1;$j<=$nbcom;$j++)
		{
		$nupletCom=mysql_fetch_array($cursuerCom);
		echo("<tr><td> - ".$nupletCom["NOMC"]."<i> (Niveau ".$nupletCom["NIVEAU"].")</i></td></tr>");
		}
	$checkrec= mysql_num_rows($cursuerrec);
	if ($checkrec !=0)
		{
		echo ("<tr><td><b>"."Recommandé pour :"."</b></td></tr>");
		for ($k=1;$k<=$nbrec;$k++)
			{
			$nupletrec=mysql_fetch_array($cursuerrec);
			echo("<tr><td> - ".$nupletrec["NOMC"]." </td></tr>");
			}
		}
	echo("</table></tr>"); // ferme table comp&rec et ligne membre

	}

echo("</table>");
?>
</body>
</html>
