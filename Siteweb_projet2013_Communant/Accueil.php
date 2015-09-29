<!-- Page d'acceuil : La première page après la connection d'un membre sur Login.php 
		 ou après son premier enregistrement -->
<?php
require("moduleFonction.php");  // accès à l'adresse de la module de fonctions
connexionChoixBase();						// declenche la fonction de Connection à la base de données
session_start();								// accès à la session	
If ($_SESSION["CountB"]==0)			// si l'arrivée sur cette page ce fait à partir de Login.php
{
$EMAIL = $_POST["txt_email"];		// récupération du texte remplit dans les champs "Email" 
$MDP = $_POST["txt_mdp"];				// et "Mot de Passe" du formulaire de Login.php 

		// execution d'une requete vérifiant l'existence d'un membre correspondant

$requete = "SELECT PSEUDO,IDM FROM MEMBRES WHERE PASSWORD = '$MDP' AND EMAIL = '$EMAIL'";
$result = mysql_query($requete);
$nuplet = mysql_fetch_array($result);
$numresult=mysql_num_rows($result);


If ($numresult !=0)							// si un nuplet existe 
{
$pseudo=$nuplet["PSEUDO"];			// on récupère les idenifiants de cet nuplet
$IDM=$nuplet["IDM"];
$_SESSION["IDM"] = $IDM;				// on conserve l'identifiant du membre pour la suite de sa navigation
}
else						 	 							// si il n'exite pas de membre correspondant à l'email et au mot de passe
{
header('Location: Login.php');  // redirection immédiate vers la page Login.php   
}
}	
$_SESSION["CountB"]=1;					// pour éviter l'étape précédente si l'uilisateur revient sur cette page d'autre part que Login.php
$IDM = $_SESSION["IDM"];				// récupération de l'identifiant d'un membre connecté si celui ci vient d'autre part que Login.php
$nupletP = infosMembreParID($IDM);  // foncion dans le module qui récupère toutes les infos d'un membre à partir de son identifiant
$pseudo=$nupletP["PSEUDO"];				

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head><div class="style" >
<title>Accueil</title>
<script language="JavaScript1.1" type="text/javascript" src="function.js">
</script>
<link href="style.css" rel="stylesheet" type="text/css"></head>
<body> 
<div class="entete"> <img src="LogoSIGE.JPG" align="left"></h3>
  <h4 align="right" color="#E3E3E3"> <a href="Deconnexion.php" >Déconnexion</a></h4>
</div>
<div class="contenu"> 
  <div class="menu"> 
    <h2>Bonjour </h2>
    <div class="pseudo"> <?php echo("$pseudo"."!"); ?> </div>
    <h5><a href="ModifProfil.php">(Modifier Votre Profil)</a></h5>
    <?php
// execution d'une requête qui compte le nombre de personnes que l'utilisateur suit
$suivre="SELECT IDM  FROM ABONNER WHERE IDM='$IDM'";
$resultSuivre=mysql_query($suivre);
$numSuivre=mysql_num_rows($resultSuivre);
echo("<a href='ListeVousSuivez.php'><h5>Vous suivez ".$numSuivre." personne(s)</h5></a>");

// execution d'une requête qui compte le nombre de personnes que suivent l'utilisateur 
$suive="SELECT IDM_ABONNER  FROM ABONNER WHERE IDM_ABONNER='$IDM'";
$resultSuive=mysql_query($suive);
$numSuive=mysql_num_rows($resultSuive);
echo("<a href='ListeSuivezVous.php'><h5>Vous êtes suivé par ".$numSuive." personne(s)</h5></a>");
?>
    <!--  formulaire pour poster un commentaire -->
    <br>
    <form action="ConfirmationCommentaire.php" method ="GET">
      <div class="pseudo">
        <h4>Faites un commentaire:</h4>
      </div>
      <textarea name="commentaire" cols="15" rows="5" onfocus="if (value=='140 caractères max.'){value=''}" onblur="if (value==''){value='140 caractères max.'}"/>140 
      caractères max.</textarea> <br>
      <input type="submit" value = "Poster" onClick="return saisie6(commentaire)"/>
    </form>
    <!--  2 formulaires pour chercher un membre -->
    <div class="pseudo">
      <h4>Cherchez un membre :</h4>
    </div>
    <form action="ListeMembres1.php" method ="GET">
      <h5> Soit par nom (prenom ou pseudo) : </h5>
      <input type ="text" name="nomMembre" />
      <input type="submit" value = "Voir les résultats" onClick="return saisie7(nomMembre)"/>
    </form></p>
    <form action="ListeMembres2.php" method ="GET">
      <h5>Soit par compétence : </h5>
      <select name="competence">
        <?php
// execution d'une requete qui vompte le nombres de competences existantes dans la base:
$requeteNomc="select IDC, NOMC FROM COMPETENCES";
$curseurNomc=mysql_query($requeteNomc);
$nbNomc=mysql_num_rows($curseurNomc);
for ($i=1;$i<=$nbNomc;$i++)  //Pour chaque compétence dans la base
{
$nupletNomc=mysql_fetch_array($curseurNomc);					//récupère IDC et NOMC
echo("<option value=\"");		 //Afficher une liste déroulante							
echo($nupletNomc["IDC"]);		 //Chaque valeur correspond à un identifiant compétence
echo("\">");
echo($nupletNomc["NOMC"]);	 //Le nom de la compétence correspondant est affiché dans la liste
echo("</option>");
}
?>
      </select>
      <input type="submit" value = "Voir les résultats"/></p>
    </form>
  </div>
  <div class="corps"> 
    <?php
//Création d'un grand tableau pour tous les commentaires:
//La premiere ligne correspond au titre et chaque ligne suivante correspond à un commentaire
echo("<table width= 70% align='center' valign='top' cellpadding=14 cellspacing= 13>");
echo("<tr><td colspan=\"3\" text-style: align= \"center\" ; bgcolor=\"FCD9BD\"><h3>Votre Messageboard</h3>");
echo("</td></tr>");

//requête pour infos de tous les commentaires "mères" (C.IDCOM_SURCOM IS NULL) du membre connecté et des membres qu'il suit:
$infosComment1="SELECT M.PSEUDO, C.IDCOM, C.CONTENU,C.DATE FROM COMMENTAIRES C, MEMBRES M WHERE C.IDM=M.IDM AND (M.IDM='$IDM' OR M.IDM in (SELECT IDM_ABONNER FROM ABONNER WHERE IDM='$IDM')) AND C.IDCOM_SURCOM IS NULL ORDER BY C.DATE DESC";
$result1=mysql_query($infosComment1);
echo(mysql_error());
$nbcom1=mysql_num_rows($result1);

		 							 												 				
for ($i=1;$i<=$nbcom1;$i++)		// Premier boucle (sur 3) correspond aux commentaires mères du membre connecté et des membres qu'il suit	
{

$nupletcom1=mysql_fetch_array($result1);	
$idcom1=$nupletcom1["IDCOM"];
$pseudo1=$nupletcom1["PSEUDO"];
$contenu1=$nupletcom1["CONTENU"];
$nbappouv1 = nbQuiAiment($idcom1); 				//fonction compte le nombre de personnes qui ont "liké" le commentaire
$YouLike1 = doYouLike($idcom1, $IDM);			//fonction regarde si vous avez déjà liké le commentaire ($YouLike1=1) ou pas ($YouLike1=0)

echo("<tr><td colspan=\"3\" text-style:  bgcolor=\"FCE6C9\"><div class=\"pseudo\">".$pseudo1."</div><div class=\"com\">".$contenu1."</div><div class='aimer'>");



If ($YouLike1==0)						//si vous n'avez pas encore "liké" le commentaire, affiche nombre de likes + bouton
{
echo ("<form action=\"ConfAppAc.php\" method = \"GET\" >");
echo ("<input type=\"hidden\" value=\"$idcom1\" name = \"idcom\"/>");
echo ($nbappouv1." LIKE &nbsp VOUS AIMEZ? &nbsp&nbsp <input type=\"image\" border=0 height=\"25\" width=\"25\" src=\"thumbsup.png\" type=\"image\" Value=\"submit\"></form>");
}
else 							 					//sinon affiche seulement le nombre de likes
{
echo("<br>".$nbappouv1." LIKE ");
}

//formulaire pour réagir au commentaire
echo("<form action=\"ConfSousComAc.php\" method=\"get\">");
echo ("REAGISSEZ ! &nbsp ");
echo("<textarea rows=\"1\" cols=\"20\" name=\"souscommentaire\">");
echo("</textarea>");
echo ("<input type=\"hidden\" name=\"IDM\" value=\"$IDM\" />");
echo ("<input type=\"hidden\" name=\"IDCOMP\" value=\"$idcom1\" />");
echo("<input type=\"submit\" value=\"ok\"/>");
echo("</form></div></td></tr>");

$nbcom2 = nbSousCom($idcom1);		//on compte le nombre de sous-commentaires directs pour chaque commentaire "mère"

$infosComment2 ="SELECT M.NOMM, M.PRENOM, M.PSEUDO, C.IDCOM, C.CONTENU,C.DATE FROM COMMENTAIRES C, MEMBRES M WHERE C.IDM=M.IDM AND C.IDCOM_SURCOM ='$idcom1'ORDER BY C.DATE ASC";
$result2=mysql_query($infosComment2);		

for ($j=1;$j<=$nbcom2;$j++) //Deuxième boucle correspond aux sous-commentaires directs aux commentaires mères

{
$nupletcom2 = mysql_fetch_array($result2);
$pseudo2=$nupletcom2["PSEUDO"];
$idcom2 = $nupletcom2["IDCOM"];
$contenu2 = $nupletcom2["CONTENU"];
$nbappouv2 = nbQuiAiment($idcom2); 
$YouLike2 = doYouLike($idcom2, $IDM);


echo("<tr><td width=10%></td><td colspan=\"2\" text-style:  bgcolor=\"FEEED8\" ><div class=\"pseudo\">".$pseudo2."</div><div class=\"com\">".$contenu2."</div><div class='aimer'>");


If ($YouLike2 ==0)	 						//si pas encore liké, nb likes + bouton image pour liker
{
echo ("<form action=\"ConfAppAc.php\" method = \"GET\" >");						
echo ("<input type=\"hidden\" value=\"$idcom2\" name = \"idcom\"/>");
echo ($nbappouv2." LIKE &nbsp - &nbsp VOUS AIMEZ? &nbsp&nbsp <input type=\"image\" border=0 height=\"25\" width=\"25\" src=\"thumbsup.png\" type=\"image\" Value=\"submit\"></form>");
}
else 							 						  //sinon juste le nb de likes
{
echo("<br>".$nbappouv2." LIKE ");
}

//formulaire pour réagir aux sous-commentaires
echo ("<form action=\"ConfSousComAc.php\" method=\"get\">");  //form pour réagir
echo ("REAGISSEZ ! &nbsp ");
echo ("<textarea rows=\"1\" cols=\"20\" name=\"souscommentaire\">");
echo ("</textarea>");
echo ("<input type=\"hidden\" name=\"IDM\" value=\"$IDM\" />");
echo ("<input type=\"hidden\" name=\"IDCOMP\" value=\"$idcom2\" />");
echo ("<input type=\"submit\" value=\"ok\"/>");
echo ("</form></div></td></tr>");

$nbcom3 = nbSousCom($idcom2);		 	//fonction calcule nombre de sous-sous-commentaires dans 3eme boucle

$infosComment3 ="SELECT M.NOMM, M.PRENOM, M.PSEUDO, C.IDCOM, C.CONTENU,C.DATE FROM COMMENTAIRES C, MEMBRES M WHERE C.IDM=M.IDM AND C.IDCOM_SURCOM ='$idcom2'ORDER BY C.DATE ASC";
$result3=mysql_query($infosComment3);

for ($k=1;$k<=$nbcom3;$k++) 			//3eme boucle correspond aux sous-commentaires de chaque sous-commentaire 
{

//exactement même principe que précedement sauf qu'il n'y a pas de formulaire de réaction dans la 3eme boucle
 
$nupletcom3 = mysql_fetch_array($result3);
$idcom3 = $nupletcom3["IDCOM"];
$pseudo3 =$nupletcom3["PSEUDO"];
$contenu3 = $nupletcom3["CONTENU"];
$nbappouv3 = nbQuiAiment($idcom3); 
$YouLike3 = doYouLike($idcom3, $IDM);

echo("<tr><td colspan=\"2\" ; width=20%></td><td text-style:  bgcolor=\"FFF3E2\" >");
echo ("<div class=\"pseudo\">".$pseudo3."</div><div class=\"com\">".$contenu3."</div><div class='aimer'>");

If ($YouLike3 ==0)
{
echo ("<form action=\"ConfAppAc.php\" method = \"GET\" > ");
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
?></table>
    <!--fermeture de la grande table de commentaires -->
  </div>
</div></body>
</html>
