<?php
//Page de profil d'un membre autre que le membre connecté 
require("moduleFonction.php");
connexionChoixBase();
session_start();
$IDM = $_SESSION["IDM"];

 If ($_SESSION["CountA"]==0)
   {
   $IDMProfil = $_GET["IDMP"];
   $_SESSION["IDMProfil"]=$IDMProfil;
   }
 else
 {
 $IDMProfil=$_SESSION["IDMProfil"];
 }
 $_SESSION["CountA"]=1;

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
 <head>
  <title>profil.php</title>
  <link href="style.css" rel="stylesheet" type="text/css">
 </head>
 <body bgcolor="E3E3E3">
  <div class="style"> 
  <?PHP

$nupletinfor=infosMembreParID($IDMProfil);

	echo("<div class='entete'>");
	echo("<img src='LogoSIGE.JPG' align='left'></h3><h4 align='right' color='#E3E3E3'><a href='Deconnexion.php' >Déconnexion</a></h4>");
	echo("<h4 align='right'><a href='Accueil.php'>Retourner à page d'Accueil</a></h4>");
	echo("</div><div class=\"lefthalf\">");
	echo ("<h2>Profil de ");
	echo($nupletinfor["NOMM"]." ");
	echo($nupletinfor["PRENOM"]." (");
	echo($nupletinfor["PSEUDO"].") &nbsp&nbsp </h2>");

	$querySuivi = "SELECT IDM FROM ABONNER WHERE IDM = '$IDM' AND IDM_ABONNER='$IDMProfil'";
	$resultqs = mysql_query($querySuivi);
	$nb = mysql_num_rows($resultqs);   // verification du suivi ou non du profil par l'utilisateur

	if ($nb==0)
		{
//pas encore suivi donc bouton "sUIVRE" avec demande insertion dans la table abonner
		echo ("<form action =\"ConfirmationSuivi.php\" method=\"GET\">");
		echo ("( Vous ne suivez pas cette personne )&nbsp&nbsp&nbsp");
		echo ("<input type=\"submit\" value=\"SUIVRE\" style=\"background-color: #78AB46 \"></form>");
		}
	else
		{
//déjà suivi donc bouton "Ne plus Suivre" avec demande delete dans la table abonner
		echo ("<form action =\"ConfirmationNePlusSuivi.php\" method=\"GET\">");
		echo ("( Vous suivez cette personne ) &nbsp&nbsp&nbsp");
		echo ("<input type=\"submit\" value=\"NE PLUS SUIVRE\" style=\"background-color: #C75D4D\"></form>");
		}

	$requetCom="SELECT NOMC, NIVEAU FROM AVOIR A, COMPETENCES C WHERE A.IDC=C.IDC AND A.IDM= '$IDMProfil'";
	$cursuerCom=mysql_query($requetCom);
	$msg=mysql_error();
	echo("$msg");
	$nbcom=mysql_num_rows($cursuerCom);

	$requetrec="SELECT DISTINCT  C.NOMC FROM COMPETENCES C, RECOMMANDER R WHERE R.IDM_RECOMMAND ='$IDMProfil' AND C.IDC = R.IDC";
	$cursuerrec=mysql_query($requetrec);
	$msg=mysql_error();
	echo("$msg");
	$nbrec=mysql_num_rows($cursuerrec);

	echo("<br><p></p><b>Ses compétences :"."</b><br>");
	for ($j=1;$j<=$nbcom;$j++)
		{
		$nupletCom=mysql_fetch_array($cursuerCom);
		}
	$checkrec= mysql_num_rows($cursuerrec);
	if ($checkrec !=0)
		{
		echo ("<p></p><b>"."Recommandé pour :"."</b><br>");
		for ($j=1;$j<=$nbrec;$j++)
			{
			$checkrec= mysql_num_rows($cursuerrec);
			$nupletrec=mysql_fetch_array($cursuerrec);
			echo(" - ".$nupletrec["NOMC"]."<br>");
			}
		}

?>
	<form action="ConfirmationRecommandation.php" method="get">
		<br>
		<h2> </h2>
		<b>Recommandez cette personne pour une compétence:&nbsp&nbsp </b><br><select name="competence"> 
		<?php 
		$requeteNomc="select IDC,NOMC FROM COMPETENCES";
		$curseurNomc=mysql_query($requeteNomc);
		$nbNomc=mysql_num_rows($curseurNomc);

		for ($i=1;$i<=$nbNomc;$i++)
			{
			$nupletNomc=mysql_fetch_array($curseurNomc);
			echo("<option value=\"");
			echo($nupletNomc["IDC"]);
			echo("\">");
			echo($nupletNomc["NOMC"]);
			echo("</option>");
			} 
		?><br><input type="submit" value="Recommander"/>
    
			</form>
			</div></div><div class="righthalf">
			<!-- partie droite de la page -->
			<div class="style2"> 
	<?php
  // verification du suivi ou non du profil par l'utilisateur

		if ($nb!=0)  // Si l'utilisateur suit le profil 
			{
// Il peut voir les commentaires du membre profilé ainsi que tous les sous-commentaires respectifs de ceux-ci

			$nbcom1= nbCommentaires($IDMProfil);

			echo("<table width= 90% align='left' valign='top' cellpadding=14 cellspacing= 13>");
			echo("<tr><td colspan=\"3\" text-style: align= \"center\" ; bgcolor=\"FCD9BD\"><h3>Ses commentaires</h3>");
			echo("<h5>(Cette personne a ecrit ".$nbcom1." commentaires)</h5></td></tr>");

			$infosComment1="SELECT M.PSEUDO, C.IDCOM, C.CONTENU,C.DATE FROM COMMENTAIRES C, MEMBRES M WHERE C.IDM=M.IDM AND M.IDM='$IDMProfil' AND C.IDCOM_SURCOM IS NULL ORDER BY C.DATE DESC";
			$result1=mysql_query($infosComment1);

// il y a 3 requêtes pour infos (pour avancer 3 curseurs simultanément pour 3 niveaux de commentaires)
//	Premier boucle correspond aux commentaires originales du membre profilé :				 							 												 				
			for ($i=1;$i<=$nbcom1;$i++)			

			$nupletcom1=mysql_fetch_array($result1);	
			$idcom1=$nupletcom1["IDCOM"];
			$pseudo1=$nupletcom1["PSEUDO"];
			$contenu1=$nupletcom1["CONTENU"];
			$nbappouv1 = nbQuiAiment($idcom1); 
			$YouLike1 = doYouLike($idcom1, $IDM);

			echo("<tr><td colspan=\"3\" text-style:  bgcolor=\"FCE6C9\"><div class=\"pseudo\">".$pseudo1."</div><div class=\"com\">".$contenu1."</div><div class='aimer'>");



			If ($YouLike1==0)
				{
				echo ("<form action=\"confirmApprouver.php\" method = \"GET\" >");
				echo ("<input type=\"hidden\" value=\"$idcom1\" name = \"idcom\"/>");
				echo ($nbappouv1." LIKE &nbsp VOUS AIMEZ? &nbsp&nbsp <input type=\"image\" border=0 height=\"25\" width=\"25\" src=\"thumbsup.png\" type=\"image\" Value=\"submit\"></form>");
				}
			else
				{
				echo("<br>".$nbappouv1." LIKE ");
				}
			
			echo("<form action=\"ConfirmationSousCom.php\" method=\"get\">");
			echo ("REAGISSEZ ! &nbsp ");
			echo("<textarea rows=\"1\" cols=\"20\" name=\"souscommentaire\">");
			echo("</textarea>");
			echo ("<input type=\"hidden\" name=\"IDM\" value=\"$IDM\" />");
			echo ("<input type=\"hidden\" name=\"IDCOMP\" value=\"$idcom1\" />");
			echo("<input type=\"submit\" value=\"ok\"/>");
			echo("</form></div></td></tr>");

			$nbcom2 = nbSousCom($idcom1);
			$infosComment2 ="SELECT M.NOMM, M.PRENOM, M.PSEUDO, C.IDCOM, C.CONTENU,C.DATE FROM COMMENTAIRES C, MEMBRES M WHERE C.IDM=M.IDM AND C.IDCOM_SURCOM ='$idcom1'ORDER BY C.DATE ASC";
			$result2=mysql_query($infosComment2);		

//	Deuxième boucle correspond aux sous-commentaires aux commentaires originales
			for ($j=1;$j<=$nbcom2;$j++) 
				{
				$nupletcom2 = mysql_fetch_array($result2);
				$pseudo2=$nupletcom2["PSEUDO"];
				$idcom2 = $nupletcom2["IDCOM"];
				$contenu2 = $nupletcom2["CONTENU"];
				$nbappouv2 = nbQuiAiment($idcom2); 
				$YouLike2 = doYouLike($idcom2, $IDM);

				echo("<tr><td width=10%></td><td colspan=\"2\" text-style:  bgcolor=\"FEEED8\" ><div class=\"pseudo\">".$pseudo2."</div><div class=\"com\">".$contenu2."</div><div class='aimer'>");

				If ($YouLike2 ==0)	  //si pas encore aimé, bouton image pour "LIKER"
					{
					echo ("<form action=\"confirmApprouver.php\" method = \"GET\" >");						
					echo ("<input type=\"hidden\" value=\"$idcom2\" name = \"idcom\"/>");
					echo ($nbappouv2." LIKE &nbsp - &nbsp VOUS AIMEZ? &nbsp&nbsp <input type=\"image\" border=0 height=\"25\" width=\"25\" src=\"thumbsup.png\" type=\"image\" Value=\"submit\"></form>");
					}
				else
					{
					echo("<br>".$nbappouv2." LIKE ");
					}

				echo ("<form action=\"ConfirmationSousCom.php\" method=\"get\">");  //form pour réagir
				echo ("REAGISSEZ ! &nbsp ");
				echo ("<textarea rows=\"1\" cols=\"20\" name=\"souscommentaire\">");
				echo ("</textarea>");
				echo ("<input type=\"hidden\" name=\"IDM\" value=\"$IDM\" />");
				echo ("<input type=\"hidden\" name=\"IDCOMP\" value=\"$idcom2\" />");
				echo ("<input type=\"submit\" value=\"ok\"/>");
				echo ("</form></div></td></tr>");


				$nbcom3 = nbSousCom($idcom2);	
				
	//fonction calcule nombre de sous-sous-commentaires dans 3eme boucle
				$infosComment3 ="SELECT M.NOMM, M.PRENOM, M.PSEUDO, C.IDCOM, C.CONTENU,C.DATE FROM COMMENTAIRES C, MEMBRES M WHERE C.IDM=M.IDM AND C.IDCOM_SURCOM ='$idcom2'ORDER BY C.DATE ASC";
				$result3=mysql_query($infosComment3);

				for ($k=1;$k<=$nbcom3;$k++) /
				//3eme boucle correspond aux sous-commentaires des sous-commentaires 
					{
 
					$nupletcom3 = mysql_fetch_array($result3);
					$idcom3 = $nupletcom3["IDCOM"];
					$pseudo3 =$nupletcom3["PSEUDO"];
					$contenu3 = $nupletcom3["CONTENU"];
					$nbappouv3 = nbQuiAiment($idcom3); 
					$YouLike3 = doYouLike($idcom3, $IDM);

					echo("<tr><td colspan=\"2\" ; width=20%></td><td text-style:  bgcolor=\"FFF3E2\" ><div class=\"pseudo\">".$pseudo3."</div><div class=\"com\">".$contenu3."</div><div class='aimer'>");

					If ($YouLike3 ==0)
						{
						echo ("<form action=\"confirmApprouver.php\" method = \"GET\" > ");
						echo ("<input type=\"hidden\" value=\"$idcom3\" name = \"idcom\"/>");
						echo ($nbappouv3." LIKE &nbsp - &nbsp VOUS AIMEZ? &nbsp&nbsp <input type=\"image\" border=0 height=\"25\" width=\"25\" src=\"thumbsup.png\" type=\"image\" Value=\"submit\"></form></td></div></tr>");
						}
					else
						{
						echo("<br>".$nbappouv3." LIKE ");
						}
					}
				}
			}
		else
			{
			echo ("<br><h5>Vous devez suivre cette personne pour voir ses commentaires</h5>");
			}
?></table>
  </div>
</body>
</html>
